<?php
$isEdit = false;
$product = null;
$error = '';
?>
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
