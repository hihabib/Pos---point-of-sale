

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



<?php include __DIR__ . '/includes/footer.php'; ?>
