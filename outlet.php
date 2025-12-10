<?php
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'outlet') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create_sale') {
    $cartJson = $_POST['cart'] ?? '[]';
    $items = json_decode($cartJson, true);
    if (!is_array($items) || count($items) === 0) {
        header('Location: outlet.php');
        exit;
    }
    $total = 0.0;
    foreach ($items as $it) {
        $qty = intval($it['quantity']);
        $price = floatval($it['unit_price']);
        $total += ($qty * $price);
    }
    $now = date('Y-m-d H:i:s');
    mysqli_query($conn, "INSERT INTO sales (total_amount, sale_date) VALUES ($total, '$now')");
    $saleId = mysqli_insert_id($conn);

    foreach ($items as $it) {
        $pid = intval($it['product_id']);
        $qty = intval($it['quantity']);
        $price = floatval($it['unit_price']);
        $subtotal = $qty * $price;
        mysqli_query($conn, "INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, subtotal) VALUES ($saleId, $pid, $qty, $price, $subtotal)");
        mysqli_query($conn, "UPDATE products SET stock_quantity = stock_quantity - $qty WHERE id = $pid");
    }
    header('Location: outlet.php');
    exit;
}

include __DIR__ . '/includes/header.php';
$productsRes = mysqli_query($conn, 'SELECT * FROM products ORDER BY name ASC');
?>
<div class="row">
  <div class="col-lg-6">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">Products</h5>
      <input type="text" id="search" class="form-control w-50" placeholder="Search products">
    </div>
    <div class="table-responsive">
      <table class="table table-sm align-middle" id="productList">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Unit</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php while ($p = $productsRes ? $productsRes->fetch_assoc() : null): ?>
            <tr data-name="<?php echo strtolower(htmlspecialchars($p['name'])); ?>">
              <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
              <td><?php echo number_format($p['price'], 2); ?></td>
              <td>
                <?php if (intval($p['stock_quantity']) <= 0): ?>
                  <span class="badge bg-warning text-dark">Out of stock</span>
                <?php else: ?>
                  <span class="badge bg-success"><?php echo intval($p['stock_quantity']); ?></span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($p['unit']); ?></td>
              <td>
                <button class="btn btn-sm btn-primary" onclick="addToCart(<?php echo intval($p['id']); ?>, '<?php echo htmlspecialchars(addslashes($p['name'])); ?>', <?php echo floatval($p['price']); ?>)">Add</button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-6">
    <h5>Cart</h5>
    <form method="post" action="outlet.php" onsubmit="return prepareSale()">
      <input type="hidden" name="action" value="create_sale">
      <input type="hidden" name="cart" id="cartInput">
      <div class="table-responsive">
        <table class="table table-sm" id="cartTable">
          <thead>
            <tr>
              <th>Product</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Total</th>
              <th id="totalCell">0.00</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
      <button type="submit" class="btn btn-success">Submit Sale</button>
    </form>
  </div>
</div>
<script>
let cart = [];

function addToCart(id, name, price) {
  const idx = cart.findIndex(i => i.product_id === id);
  if (idx >= 0) {
    cart[idx].quantity += 1;
  } else {
    cart.push({ product_id: id, name, unit_price: price, quantity: 1 });
  }
  renderCart();
}

function removeFromCart(id) {
  cart = cart.filter(i => i.product_id !== id);
  renderCart();
}

function changeQty(id, val) {
  const item = cart.find(i => i.product_id === id);
  if (!item) return;
  const q = parseInt(val || '0', 10);
  item.quantity = Math.max(1, q);
  renderCart();
}

function renderCart() {
  const tbody = document.querySelector('#cartTable tbody');
  tbody.innerHTML = '';
  let total = 0;
  cart.forEach((item) => {
    const subtotal = item.quantity * item.unit_price;
    total += subtotal;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${item.name}</td>
      <td style="width:120px"><input type="number" min="1" class="form-control form-control-sm" value="${item.quantity}" onchange="changeQty(${item.product_id}, this.value)"></td>
      <td>${item.unit_price.toFixed(2)}</td>
      <td>${subtotal.toFixed(2)}</td>
      <td><button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.product_id})">Remove</button></td>
    `;
    tbody.appendChild(tr);
  });
  document.getElementById('totalCell').textContent = total.toFixed(2);
}

function prepareSale() {
  if (cart.length === 0) return false;
  document.getElementById('cartInput').value = JSON.stringify(cart);
  return true;
}

document.getElementById('search').addEventListener('input', function() {
  const q = this.value.trim().toLowerCase();
  document.querySelectorAll('#productList tbody tr').forEach(tr => {
    const name = tr.getAttribute('data-name');
    tr.style.display = name.includes(q) ? '' : 'none';
  });
});
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
