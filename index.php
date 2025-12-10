<?php
require_once __DIR__ . '/includes/db.php';

// redirect based on user role
if (!empty($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    if ($role === 'manager') {
        header('Location: manager.php');
        exit;
    }
    if ($role === 'outlet') {
        header('Location: outlet.php');
        exit;
    }
}

// other wise show login page
include __DIR__ . '/includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-3">Sign In</h5>
        <form method="post" action="login.php">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12 mt-3">
    <p class="text-muted">Use manager: manager123 or outlet: outlet123</p>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

