<?php
include '../config.php';

$admin = new Admin();

if (!isset($_SESSION['admin_id'])) {
    header("location:login_front.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$convert_data = $admin->ret("
    SELECT c.*, a.acc_name 
    FROM `convert` c 
    LEFT JOIN `account` a ON c.acc_id = a.acc_id 
    ORDER BY c.m_date DESC
");

$spend_data = $admin->ret("
    SELECT s.*, a.acc_name 
    FROM `spend` s 
    LEFT JOIN `account` a ON s.acc_id = a.acc_id 
    ORDER BY s.neg_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #f1f4f9, #dff3ff);
            font-family: 'Poppins', sans-serif;
        }

        h2 {
            font-weight: 600;
            color: #004085;
            margin-bottom: 30px;
        }

        .card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            background: linear-gradient(90deg, #0062ff, #60efff);
            color: white;
            cursor: pointer;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table-hover tbody tr {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .table-hover tbody tr:hover {
            transform: scale(1.01);
            background-color: #e3f2fd !important;
        }

        .accordion-button:not(.collapsed) {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
        }

        .dataTables_filter input {
            border-radius: 6px;
            padding: 4px 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.3em 0.8em;
            border-radius: 8px;
            margin: 2px;
        }

        @media screen and (max-width: 768px) {
            .table th, .table td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container my-5 pt-5">
    <h2 class="text-center" data-aos="zoom-in">📊 Transaction History</h2>

    <!-- Converted Transactions -->
    <div class="card mb-4" data-aos="fade-up">
        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#convertedTable" aria-expanded="true">
            🔄 Converted Transactions
        </div>
        <div id="convertedTable" class="collapse show">
            <div class="card-body table-responsive">
                <table id="converted" class="table table-hover table-bordered mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Account</th>
                            <th>CNY</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = $convert_data->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>{$i}</td>
                                <td>{$row['acc_name']}</td>
                                <td>₹{$row['cny']}</td>
                                <td>{$row['m_date']}</td>
                                <td>{$row['note']}</td>
                            </tr>";
                            $i++;
                        }
                        if ($i === 1) echo "<tr><td colspan='5'>No converted transactions available.</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Spend Transactions -->
    <div class="card">
        <div class="card-header" data-bs-toggle="collapse" data-bs-target="#spendTable" aria-expanded="true">
            💸 Spend Transactions
        </div>
        <div id="spendTable" class="collapse show">
            <div class="card-body table-responsive">
                <table id="spend" class="table table-hover table-bordered mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th>#</th>
                            <th>Account</th>
                            <th>CNY</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j = 1;
                        while ($row = $spend_data->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                                <td>{$j}</td>
                                <td>{$row['acc_name']}</td>
                                <td>₹{$row['neg_cny']}</td>
                                <td>{$row['neg_date']}</td>
                                <td>{$row['neg_note']}</td>
                            </tr>";
                            $j++;
                        }
                        if ($j === 1) echo "<tr><td colspan='5'>No spend transactions available.</td></tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- AOS Animation -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });

    $(document).ready(function () {
        $('#converted').DataTable({
            paging: true,
            lengthChange: false,
            pageLength: 5,
            searching: true,
            ordering: true,
            info: false
        });

        $('#spend').DataTable({
            paging: true,
            lengthChange: false,
            pageLength: 5,
            searching: true,
            ordering: true,
            info: false
        });
    });
</script>

</body>
</html>
