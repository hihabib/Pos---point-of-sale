<?php
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header('Location: index.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_product') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        mysqli_query($conn, 'DELETE FROM products WHERE id=' . $id);
        $msg = 'Product deleted successfully';
    } else {
        $msg = 'Invalid product';
    }
}

$q = trim($_GET['q'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$where = '';
if ($q !== '') {
    $safeQ = preg_replace('/[^a-zA-Z0-9 _-]/', '', $q);
    $likeEsc = '%' . $safeQ . '%';
    $where = "WHERE name LIKE '$likeEsc' OR serial LIKE '$likeEsc' OR unit LIKE '$likeEsc'";
}

$countSql = 'SELECT COUNT(*) AS c FROM products ' . $where;
$countRes = mysqli_query($conn, $countSql);
$totalRows = ($countRes && ($row = mysqli_fetch_assoc($countRes))) ? intval($row['c']) : 0;
$totalPages = max(1, (int)ceil($totalRows / $limit));

$listSql = 'SELECT * FROM products ' . $where . ' ORDER BY id DESC LIMIT ' . intval($limit) . ' OFFSET ' . intval($offset);
$products = mysqli_query($conn, $listSql);

include __DIR__ . '/includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Product List</h5>
  <a href="manager_product_form.php" class="btn btn-success">Add Product</a>
  </div>
<?php if ($msg): ?>
  <div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<form class="row g-2 mb-3" method="get" action="manager_products.php">
  <div class="col-md-8">
    <input type="text" class="form-control" name="q" placeholder="Search by name, serial, unit" value="<?php echo htmlspecialchars($q); ?>">
  </div>
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">Search</button>
  </div>
  <div class="col-md-2">
    <a href="manager_products.php" class="btn btn-outline-secondary w-100">Reset</a>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-sm align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Unit</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $products ? $products->fetch_assoc() : null): ?>
        <tr>
          <td><?php echo intval($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo number_format((float)$row['price'], 2); ?></td>
          <td><?php echo intval($row['stock_quantity']); ?></td>
          <td><?php echo htmlspecialchars($row['unit']); ?></td>
          <td>
            <a class="btn btn-sm btn-primary" href="manager_product_form.php?id=<?php echo intval($row['id']); ?>">Edit</a>
            <form method="post" action="manager_products.php<?php echo $q ? ('?q=' . urlencode($q) . '&page=' . $page) : ''; ?>" class="d-inline" onsubmit="return confirm('Delete product?');">
              <input type="hidden" name="action" value="delete_product">
              <input type="hidden" name="id" value="<?php echo intval($row['id']); ?>">
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if (!$products || $products->num_rows === 0): ?>
        <tr><td colspan="6" class="text-center text-muted">No products found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<nav aria-label="Page navigation">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
        <a class="page-link" href="manager_products.php?page=<?php echo $i; ?><?php echo $q ? ('&q=' . urlencode($q)) : ''; ?>"><?php echo $i; ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>

<?php include __DIR__ . '/includes/footer.php'; ?>
