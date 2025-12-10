<?php
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header('Location: index.php');
    exit;
}

$isEdit = false;
$product = null;
if (!empty($_GET['id'])) {
    $isEdit = true;
    $id = intval($_GET['id']);
    $res = mysqli_query($conn, 'SELECT * FROM products WHERE id=' . $id . ' LIMIT 1');
    if ($res && mysqli_num_rows($res) === 1) {
        $product = mysqli_fetch_assoc($res);
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $stock = trim($_POST['stock_quantity'] ?? '');
    $serial = trim($_POST['serial'] ?? '');
    $unit = trim($_POST['unit'] ?? '');

    if ($name === '' || $price === '' || $stock === '') {
        $error = 'Please fill required fields';
    } elseif (!is_numeric($price) || !is_numeric($stock)) {
        $error = 'Price and Stock must be numeric';
    } else {
        $p = floatval($price);
        $s = intval($stock);
        $name = preg_replace('/[^a-zA-Z0-9 _-]/', '', $name);
        $serial = preg_replace('/[^a-zA-Z0-9 _-]/', '', $serial);
        $unit = preg_replace('/[^a-zA-Z0-9 _-]/', '', $unit);
        if ($isEdit) {
            $id = intval($_POST['id'] ?? 0);
            $sql = "UPDATE products SET name='$name', price=$p, stock_quantity=$s, serial='$serial', unit='$unit' WHERE id=$id";
            mysqli_query($conn, $sql);
            header('Location: manager_products.php?msg=' . urlencode('Product updated'));
            exit;
        } else {
            $sql = "INSERT INTO products (name, price, stock_quantity, serial, unit) VALUES ('$name', $p, $s, '$serial', '$unit')";
            mysqli_query($conn, $sql);
            header('Location: manager_products.php?msg=' . urlencode('Product created'));
            exit;
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<h5 class="mb-3"><?php echo $isEdit ? 'Edit Product' : 'Add Product'; ?></h5>
<?php if ($error): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<form class="row g-3" method="post" action="manager_product_form.php<?php echo $isEdit ? ('?id=' . intval($product['id'])) : ''; ?>">
  <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?php echo intval($product['id']); ?>">
  <?php endif; ?>
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Price</label>
    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Stock</label>
    <input type="number" class="form-control" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity'] ?? ''); ?>" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Serial</label>
    <input type="text" class="form-control" name="serial" value="<?php echo htmlspecialchars($product['serial'] ?? ''); ?>">
  </div>
  <div class="col-md-4">
    <label class="form-label">Unit</label>
    <input type="text" class="form-control" name="unit" value="<?php echo htmlspecialchars($product['unit'] ?? ''); ?>">
  </div>
  <div class="col-md-4 align-self-end">
    <button type="submit" class="btn btn-success w-100"><?php echo $isEdit ? 'Update' : 'Create'; ?></button>
  </div>
</form>
<div class="mt-3">
  <a href="manager_products.php" class="btn btn-outline-secondary">Back to Products</a>
  <a href="manager_sales.php" class="btn btn-outline-primary">View Sales</a>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
