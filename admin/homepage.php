<?php
include '../config.php';

$admin = new Admin();

if (!isset($_SESSION['admin_id'])) {
  header("location:login_front.php");
  exit();
}

$admin_id = $_SESSION['admin_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Homepage | Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet" />

  <!-- ✅ Bootstrap 5.3.5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 30px 10px;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 700px;
      text-align: center;
      animation: fadeIn 0.7s;
      transition: transform 0.3s ease;
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      animation: slideDown 0.7s ease-out;
    }

    .menu-button {
      display: block;
      background: white;
      color: #2575fc;
      border: none;
      padding: 30px 25px;
      margin: 20px auto;
      width: 80%;
      font-size: 1.5rem;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .menu-button:hover {
      transform: scale(1.05);
      background: #e6ecff;
    }
    .btn-success{
     display: block;
      background: white;
      color: #2575fc;
      border: none;
      padding: 30px 25px;
      margin: 20px auto;
      width: 80%;
      font-size: 1.5rem;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2); 
    }
    .btn-success:hover {
      background: #e6ecff;
      transform: scale(1.05);
    }
    .footer {
      margin-top: 30px;
      font-size: 0.9rem;
      color: #eee;
    }

    
    @keyframes fadeIn {
      0% { opacity: 0; transform: scale(0.6); }
      100% { opacity: 1; transform: scale(1); }
    }

    @keyframes slideDown {
      0% { opacity: 0; transform: translateY(-50px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome Admin</h1>

    <button class="menu-button" onclick="location.href='index.php'">
      Exchange
    </button>

                <!-- Modal Trigger -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAccountModal">
          <i class="bi bi-plus-circle"></i>Pricing
        </button>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header">
        <h5 class="modal-title" id="addAccountModalLabel">Pricing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

        <div class="modal-body">
          <div class="mb-3">
          <button type="submit" name="insert" class="btn btn-primary">Submit</button>  <br>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </div>
  </div>
</div>
</div>  
    <button class="menu-button" onclick="location.href='purchase_list.php'">
      Purchase List 
    </button>



    <div class="footer">
      &copy; <?= date("Y") ?> Mish Dashboard
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
