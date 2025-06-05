<?php
include '../../config.php'; // adjust your path if needed

$admin = new Admin();
date_default_timezone_set('Asia/Kolkata');


// Insert
if (isset($_POST['insert'])) {
    $inr = $_POST['inr'];
    $cny = $_POST['cny'];
    $result = $_POST['result'];
    $acc_id = $_POST['acc_id']; 
    $date = date('Y-m-d H:i:s'); // 🛠 Set the current date and time

    $admin->cud("INSERT INTO `convert` (inr, cny, result, m_status, m_date, acc_id) VALUES ('$inr', '$cny', '$result', 'active', '$date', '$acc_id')", "saved");

    echo "<script>alert('Inserted Successfully'); window.location.href='../index.php';</script>";
}

// Update
if (isset($_POST['update'])) {
    $id = $_POST['manager_id'];
    $inr = $_POST['inr'];
    $cny = $_POST['cny'];
    $result = $_POST['result'];
    $status = $_POST['status'];
    $acc_id = $_POST['acc_id'];

    $admin->cud("UPDATE convert SET inr='$inr', cny='$cny', result='$result', m_status='$status', acc_id='$acc_id' WHERE manager_id='$id'", "updated");

    echo "<script>alert('Updated Successfully'); window.location.href='../index.php';</script>";
}

// Delete
if (isset($_GET['delete_convert'])) {
    $id = $_GET['delete_convert'];

    $admin->cud("DELETE FROM convert WHERE manager_id='$id'", "deleted");

    echo "<script>alert('Deleted Successfully'); window.location.href='../manager_manage.php';</script>";
}
?>