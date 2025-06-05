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


        <!-------------🟦MAIN CONTENT STARTS------------>
        <?php

$query=$admin->ret("SELECT * FROM `admin` " );
$row=$query->fetch(PDO::FETCH_ASSOC);
?>

<!--table starts-->
<div class="container my-5 pt-5">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card animated-card p-5" style="width: 750px; background: white;">
      <h3 class="text-center mb-4"><i class="bi bi-person-lines-fill"></i> Update Account</h3>
 <div class="d-flex justify-content-center align-items-center">
<div class="col-md-10 grid-margin stretch-card ">
              <div class="card ">
                <div class="card-body ">

                  <form class="forms-sample" method="POST" action="controller/account_settings_controller.php" enctype="multipart/form-data">
                    
                <!--passing location id as hidden-->
                <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']?>">

                  <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">User Name</label>
                      <div class="col-sm-9">
                        <input type="text" value="<?php echo $row['username']?>" name="username" class="form-control" id="exampleInputUsername2" placeholder="username">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">password</label>
                      <div class="col-sm-9">
                        <input type="password" value="<?php echo $row['password']?>" name="password" class="form-control" id="exampleInputUsername2" placeholder="password">
                      </div>
                    </div>


 
                    <button type="submit" name="update" class="btn btn-primary mr-2">Submit</button>
                    <a class="btn btn-light" href="index.php">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
<!--table ends-->

          <!-----------🟦MAIN CONTENT ENDS------------------>
          
        </div><!--content wrapper ends-->
 

      </div> <!--main panel ends-->
    </div> <!--body wrapper ends-->
  </div> <!--container scroller ends-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
