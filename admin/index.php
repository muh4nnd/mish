<?php
include '../config.php';

$admin = new Admin();

if (!isset($_SESSION['admin_id'])) {
  header("location:login_front.php");
  exit();
}

$admin_id = $_SESSION['admin_id'];

$query = $admin->ret("SELECT * FROM `account` ");
$c = 0;
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $c++;
    $current_acc_id = $row['acc_id'];

    $convertINR = $admin->ret("SELECT SUM(inr) AS total_inr FROM `convert` ");
    $convertCNY = $admin->ret("SELECT SUM(cny) AS total_cny FROM `convert` ");
    $totalINR = $convertINR->fetch(PDO::FETCH_ASSOC)['total_inr'] ?? 0;
    $totalCNY = $convertCNY->fetch(PDO::FETCH_ASSOC)['total_cny'] ?? 0;

    $spendINR = $admin->ret("SELECT SUM(neg_inr) AS spent_inr FROM `spend` ");
    $spendCNY = $admin->ret("SELECT SUM(neg_cny) AS spent_cny FROM `spend` ");
    $spentINR = $spendINR->fetch(PDO::FETCH_ASSOC)['spent_inr'] ?? 0;
    $spentCNY = $spendCNY->fetch(PDO::FETCH_ASSOC)['spent_cny'] ?? 0;

    $netINR = $totalINR - $spentINR;
    $netCNY = $totalCNY - $spentCNY;

    $query = $admin->ret("SELECT AVG(result) AS average FROM `convert`");
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $avg_rate = number_format($row['average'] ?? 0, 4);
}

$query = $admin->ret("
    SELECT manager_id, 'convert' AS type, inr, cny, m_date
    FROM `convert`
    UNION ALL
    SELECT neg_id, 'spend' AS type, neg_inr, neg_cny, neg_date
    FROM `spend`
    ORDER BY m_date DESC
    LIMIT 4
");

$transactions = [];
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $transactions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mish Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;;
      background: linear-gradient(to right, #e0f7fa, #e1bee7);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .card-box {
      animation: fadeInUp 1s ease;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      padding: 40px;
      transition: transform 0.3s ease;
    }
    .card-box:hover {
      transform: translateY(-5px);
      transform: scale(1.01);
    }
    .btn-custom {
      border-radius: 30px;
      padding: 12px 30px;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    .btn-spend {
      background-color: #ff4d4d;
      border: none;
      color: white;
    }
    .btn-spend:hover {
      background-color: #cc0000;
      box-shadow: 0 0 10px #ff4d4d;
    }
    .btn-convert {
      background-color: #007bff;
      border: none;
      color: white;
    }
    .btn-convert:hover {
      background-color: #0056b3;
      box-shadow: 0 0 10px #007bff;
    }
    .total-box {
      text-align: center;
      background: linear-gradient(to right, #2575fc, #6a11cb);
      color: white;
      border-radius: 20px;
      padding: clamp(20px, 5vw, 35px) clamp(10px, 4vw, 20px);
      margin: 15px 0;
      transition: 0.4s;
      box-shadow: 0 10px 20px rgba(106, 17, 203, 0.3);
    }
    .total-box:hover {
      transform: translateY(-5px);
    }
    .total-box h5 {
  font-size: clamp(0.5rem, 2.5vw, 1.25rem);
}

.rate-display {
  font-size: clamp(1.2rem, 5vw, 2.4rem); /* adjusts between 1.2rem and 2.4rem based on screen width */
  font-weight: 800;
  color: #ff6f61;
  text-shadow: 2px 2px #ffd9d2;
}

    .transactions-box {
      border: 2px dashed #ff7f50;
      background: #fff6f2;
      padding: 25px;
      text-align: left;
      border-radius: 15px;
      color: #333;
      font-size: 15px;
    }
    .transactions-box li strong {
      color: #ff6f61;
    }
    .transactions-box li:hover {
      background: #ffece6;
      border-radius: 8px;
      padding: 5px;
    }
    footer {
      text-align: center;
      padding-top: 20px;
      color: #555;
      font-weight: 500;
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
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container my-5 pt-5">
  <div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4 gap-"> 
      <button class="btn btn-spend btn-custom" onclick="window.location.href='spend.php'">Spend</button>
      <h2 class="mb-0 rate-display" id="rate" data-value="<?php echo htmlspecialchars($avg_rate); ?>">0.0000</h2>
      <button class="btn btn-convert btn-custom" onclick="window.location.href='convert.php'">Convert</button>
    </div>
    
<div class="row text-center">
  <div class="col-6">
    <div class="total-box">
      <h5>Total CNY</h5>
      <h3 id="total-cny" data-value="<?php echo htmlspecialchars($netCNY); ?>">0</h3>
    </div>
  </div>
  <div class="col-6">
    <div class="total-box">
      <h5>Total INR</h5>
      <h3 id="total-inr" data-value="<?php echo htmlspecialchars($netINR); ?>">0</h3>
    </div>
  </div>
</div>

    <div class="transactions-box mt-4">
      <?php if (!empty($transactions)): ?>
        <ul class="list-unstyled mb-0">
          <?php foreach ($transactions as $tx): ?>
            <li class="mb-2">
              <strong><?= ucfirst($tx['type']) ?></strong> - 
              CNY: <?= $tx['cny'] ?>, INR: <?= $tx['inr'] ?> 
              <small class="text-muted">(<?= date("d M Y, h:i A", strtotime($tx['m_date'])) ?>)</small>
          </li> 
          <?php endforeach; ?>
        </ul>
        <div class="text-end mt-2">
          <a href="history.php" class="btn btn-sm btn-link">Show More</a>
        </div>
      <?php else: ?>
        <p id="recent-transactions">No recent transactions</p>
      <?php endif; ?>
    </div>
    <div class="d-flex justify-content-between mt-4">
      <button class="btn btn-outline-primary btn-custom" onclick="window.location.href='account.php'">Account</button>
      <button class="btn btn-outline-primary btn-custom" onclick="window.location.href='history.php'">History</button>
    </div>
  </div>
  <footer class="mt-5">
    <p>&copy; <?php echo date("Y"); ?> Mish Dashboard</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function animateValue(id, start, end, duration, isDecimal = false) {
    const obj = document.getElementById(id);
    let startTime = null;
    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = timestamp - startTime;
      const percentage = Math.min(progress / duration, 1);
      const value = start + (end - start) * percentage;
      obj.innerText = isDecimal ? value.toFixed(4) : Math.floor(value);
      if (percentage < 1) {
        window.requestAnimationFrame(step);
      }
    }
    window.requestAnimationFrame(step);
  }
  window.onload = function () {
    const cny = parseFloat(document.getElementById("total-cny").dataset.value);
    const inr = parseFloat(document.getElementById("total-inr").dataset.value);
    const rate = parseFloat(document.getElementById("rate").dataset.value);
    animateValue("total-cny", 0, cny, 1200);
    animateValue("total-inr", 0, inr, 1200);
    animateValue("rate", 0, rate, 1200, true);
  };
</script>
</body>
</html>



