<?php
include '../config.php';
$admin = new Admin();

if (!isset($_SESSION['admin_id'])) {
    header("location:login_front.php");
}

$s_variable = $_SESSION['admin_id'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currency Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body {
        font-family: 'Roboto', sans-serif;
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
      }
      .card {
        max-width: 600px;
        width: 100%;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        animation: fadeIn 1s ease;
      }
      .card-title {
        text-align: center;
        font-weight: bold;
        color: #6a1b9a;
        animation: slideInDown 0.8s ease;
      }
      .form-control, .btn {
        border-radius: 10px;
      }
      .btn-primary {
        background-color: #6a1b9a;
        border-color: #6a1b9a;
        transition: 0.3s;
      }
      .btn-primary:hover {
        background-color: #4a0072;
        border-color: #4a0072;
      }
      .alert-info, .alert-success, .alert-danger {
        border-radius: 10px;
      }
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
      }
    </style>
  </head>
  <body>
  <?php include 'header.php'; ?>
  <div class="container my-5 pt-5">
  <div class="d-flex justify-content-center align-items-center">
    <div class="card p-4">
      <div class="card-body">
        <h2 class="card-title mb-4">Currency Converter (INR to Yuan)</h2>

        <form method="POST" action="controller/convert_controller.php" id="currencyForm">

          <div class="mb-3">
            <label for="inr" class="form-label">Indian Rupees (INR):</label>
            <input type="number" step="any" name="inr" id="inr" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="cny" class="form-label">Chinese Yuan (CNY):</label>
            <input type="number" step="any" name="cny" id="cny" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Exchange Rate:</label>
            <div id="result" class="alert alert-info">Please enter values above</div>
          </div>

          <div class="mb-3">
            <label for="acc_id" class="form-label">Account</label>
            <select name="acc_id" id="acc_id" required class="form-select">
              <option value="" selected disabled>Select Account</option>
              <?php 
              $query = $admin->ret("SELECT * FROM `account` WHERE acc_status = 'active'");
              while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                  echo "<option value='{$row['acc_id']}'>{$row['acc_name']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Current CNY Balance:</label>
            <div id="balanceDisplay" class="alert alert-success">Select an account to view balance</div>
          </div>

          <div class="mb-3">
            <label for="note" class="form-label">Note:</label>
            <input type="varchar" step="any" name="note" id="note" class="form-control" required>
          </div>

          <input type="hidden" name="result" id="resultInput">

          <div class="d-flex justify-content-between">
            <button type="submit" name="insert" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>

    <script>
      const inrInput = document.getElementById("inr");
      const cnyInput = document.getElementById("cny");
      const resultDiv = document.getElementById("result");
      const resultInput = document.getElementById("resultInput");
      const accountSelect = document.getElementById("acc_id");
      const balanceDisplay = document.getElementById("balanceDisplay");

      let currentBalance = 0;

      function animateRate(rate) {
        let current = 0;
        const duration = 600;
        const stepTime = 10;
        const steps = duration / stepTime;
        const increment = rate / steps;

        const interval = setInterval(() => {
          current += increment;
          if (current >= rate) {
            current = rate;
            clearInterval(interval);
          }
          resultDiv.textContent = `Exchange Rate: ${current.toFixed(4)}`;
        }, stepTime);
      }

      function updateResult() {
        const inr = parseFloat(inrInput.value);
        const cny = parseFloat(cnyInput.value);

        if (!isNaN(inr) && !isNaN(cny) && cny !== 0) {
          const rate = inr / cny;
          animateRate(rate);
          resultInput.value = rate.toFixed(4);
        } else {
          resultDiv.textContent = "Please enter valid values.";
          resultInput.value = "";
        }
      }

      inrInput.addEventListener("input", updateResult);
      cnyInput.addEventListener("input", updateResult);

      accountSelect.addEventListener("change", function () {
        const accId = this.value;

        if (accId) {
          fetch(`fetch_balance.php?acc_id=${accId}`)
            .then(res => res.json())
            .then(data => {
              currentBalance = parseFloat(data.balance);
              balanceDisplay.textContent = `CNY Balance: ¥${currentBalance.toFixed(2)}`;
              balanceDisplay.classList.remove("alert-danger");
              balanceDisplay.classList.add("alert-success");
            })
            .catch(() => {
              balanceDisplay.textContent = "Failed to fetch balance.";
              balanceDisplay.classList.remove("alert-success");
              balanceDisplay.classList.add("alert-danger");
              currentBalance = 0;
            });
        } else {
          balanceDisplay.textContent = "Select an account to view balance";
          currentBalance = 0;
        }
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
