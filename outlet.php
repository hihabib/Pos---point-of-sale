<?php
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'outlet') {
    header('Location: index.php');
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

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
