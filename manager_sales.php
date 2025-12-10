<?php
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header('Location: index.php');
    exit;
}

$from = $_GET['from'] ?? date('Y-m-d');
$to = $_GET['to'] ?? date('Y-m-d');

$fromSafe = preg_replace('/[^0-9\-]/', '', $from);
$toSafe = preg_replace('/[^0-9\-]/', '', $to);
$fromDt = $fromSafe . ' 00:00:00';
$toDt = $toSafe . ' 23:59:59';

$sql = "SELECT s.id, s.total_amount, s.sale_date, COALESCE(SUM(si.quantity),0) AS total_items
                         FROM sales s
                         LEFT JOIN sale_items si ON si.sale_id = s.id
                         WHERE s.sale_date BETWEEN '$fromDt' AND '$toDt'
                         GROUP BY s.id
                         ORDER BY s.id DESC";
    $sales = mysqli_query($conn, $sql);

$viewSaleId = isset($_GET['view_sale_id']) ? intval($_GET['view_sale_id']) : 0;
$items = null;
if ($viewSaleId) {
    $items = mysqli_query($conn, 'SELECT si.*, p.name FROM sale_items si JOIN products p ON p.id = si.product_id WHERE si.sale_id = ' . $viewSaleId);
}

include __DIR__ . '/includes/header.php';
?>
<h5 class="mb-3">Sales</h5>
<form class="row g-2 mb-3" method="get" action="manager_sales.php">
  <div class="col-md-5">
    <label class="form-label">From</label>
    <input type="date" class="form-control" name="from" value="<?php echo htmlspecialchars($from); ?>">
  </div>
  <div class="col-md-5">
    <label class="form-label">To</label>
    <input type="date" class="form-control" name="to" value="<?php echo htmlspecialchars($to); ?>">
  </div>
  <div class="col-md-2 align-self-end">
    <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
  </div>
</form>

<div class="card mb-3">
  <div class="card-body" id="summary">
    <div class="row text-center">
      <div class="col-md-4"><strong id="sumSales">0</strong><div class="text-muted">Total Sales</div></div>
      <div class="col-md-4"><strong id="sumQty">0</strong><div class="text-muted">Total Items Sold</div></div>
      <div class="col-md-4"><strong id="sumRevenue">0.00</strong><div class="text-muted">Total Revenue</div></div>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-sm" id="salesTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Total Amount</th>
        <th>Items</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $sales ? $sales->fetch_assoc() : null): ?>
        <tr data-total="<?php echo number_format((float)$row['total_amount'], 2, '.', ''); ?>" data-items="<?php echo intval($row['total_items']); ?>">
          <td><?php echo intval($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
          <td><?php echo number_format((float)$row['total_amount'], 2); ?></td>
          <td><?php echo intval($row['total_items']); ?></td>
          <td><a class="btn btn-sm btn-secondary" href="manager_sales.php?from=<?php echo htmlspecialchars($from); ?>&to=<?php echo htmlspecialchars($to); ?>&view_sale_id=<?php echo intval($row['id']); ?>">View Details</a></td>
        </tr>
      <?php endwhile; ?>
      <?php if (!$sales || $sales->num_rows === 0): ?>
        <tr><td colspan="5" class="text-center text-muted">No sales found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php if ($viewSaleId && $items): ?>
  <div class="card mt-3">
    <div class="card-body">
      <h6 class="mb-3">Sale #<?php echo $viewSaleId; ?> Items</h6>
      <div class="table-responsive">
        <table class="table table-sm">
          <thead><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr></thead>
          <tbody>
            <?php while ($it = $items->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($it['name']); ?></td>
                <td><?php echo intval($it['quantity']); ?></td>
                <td><?php echo number_format((float)$it['unit_price'], 2); ?></td>
                <td><?php echo number_format((float)$it['subtotal'], 2); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
function calcSummary() {
  const rows = document.querySelectorAll('#salesTable tbody tr');
  let count = 0, qty = 0, revenue = 0;
  rows.forEach(r => {
    const t = parseFloat(r.getAttribute('data-total') || '0');
    const q = parseInt(r.getAttribute('data-items') || '0', 10);
    if (!isNaN(t)) revenue += t;
    if (!isNaN(q)) qty += q;
    count += 1;
  });
  document.getElementById('sumSales').textContent = count;
  document.getElementById('sumQty').textContent = qty;
  document.getElementById('sumRevenue').textContent = revenue.toFixed(2);
}
calcSummary();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
