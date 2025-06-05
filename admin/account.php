<?php
include '../config.php';
$admin = new Admin();

if (!isset($_SESSION['admin_id'])) {
    header("location:login_front.php");
    exit();
}

$s_variable = $_SESSION['admin_id'];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #dfe9f3, #ffffff);
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }

    .animated-card {
      animation: fadeInUp 1s ease;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease;
    }

    .animated-card:hover {
      transform: translateY(-5px);
    }

    h3 {
      font-weight: 700;
      color: #333;
      animation: slideIn 1s ease;
    }

    .table {
      animation: fadeIn 1.2s ease;
    }

    .btn-success {
      border-radius: 50px;
      padding: 10px 24px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      background-color: #28a745;
      transform: scale(1.05);
    }

    select.form-select {
      padding: 4px 8px;
      font-size: 0.9rem;
      border-radius: 10px;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideIn {
      from {
        transform: translateX(-100px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container my-5 pt-5">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card animated-card p-5" style="width: 750px; background: white;">
      <h3 class="text-center mb-4"><i class="bi bi-person-lines-fill"></i> Account Details</h3>

      <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>INR</th>
              <th>CNY</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
<?php
  $query = $admin->ret("SELECT * FROM `account` ");
  $c = 0;
  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $c++;
      $current_acc_id = $row['acc_id'];

      // Total converted INR and CNY
      $convertINR = $admin->ret("SELECT SUM(inr) AS total_inr FROM `convert` WHERE acc_id = '$current_acc_id'");
      $convertCNY = $admin->ret("SELECT SUM(cny) AS total_cny FROM `convert` WHERE acc_id = '$current_acc_id'");
      $totalINR = $convertINR->fetch(PDO::FETCH_ASSOC)['total_inr'] ?? 0;
      $totalCNY = $convertCNY->fetch(PDO::FETCH_ASSOC)['total_cny'] ?? 0;

      // Total spent INR and CNY
      $spendINR = $admin->ret("SELECT SUM(neg_inr) AS spent_inr FROM `spend` WHERE acc_id = '$current_acc_id'");
      $spendCNY = $admin->ret("SELECT SUM(neg_cny) AS spent_cny FROM `spend` WHERE acc_id = '$current_acc_id'");
      $spentINR = $spendINR->fetch(PDO::FETCH_ASSOC)['spent_inr'] ?? 0;
      $spentCNY = $spendCNY->fetch(PDO::FETCH_ASSOC)['spent_cny'] ?? 0;

      // Final net values
      $netINR = $totalINR - $spentINR;
      $netCNY = $totalCNY - $spentCNY;
?>
<tr>
  <td><?= $c ?></td>
  <td><?= htmlspecialchars($row['acc_name']) ?></td>
  <td><?= number_format($netINR, 2) ?></td>
  <td><?= number_format($netCNY, 2) ?></td>
  <td>
    <form action="controller/account_status_controller.php" method="post">
      <input type="hidden" name="acc_id" value="<?= $row['acc_id']; ?>">
      <select name="acc_status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="active" <?= ($row['acc_status'] == 'active') ? "selected" : "" ?>>Active</option>
        <option value="inactive" <?= ($row['acc_status'] == 'inactive') ? "selected" : "" ?>>Inactive</option>
      </select>
    </form>
  </td>
</tr>
<?php } ?>
</tbody>
        </table>
      </div>

      <div class="text-center mt-4">
        <!-- Modal Trigger -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAccountModal">
          <i class="bi bi-plus-circle"></i> Add new Account
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header">
        <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="controller/account_controller.php" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="accountName" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="accountName"
              placeholder="Account name" pattern="[a-zA-Z'-'\s]*"
              title="No numbers or special characters are allowed" required>
          </div>
        </div>
        <input type="hidden" name="status" value="active">

        <div class="modal-footer">
          <button type="submit" name="insert" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

