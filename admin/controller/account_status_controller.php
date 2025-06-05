<?php
include '../../config.php';

$admin = new Admin();

if (isset($_POST['acc_id']) && isset($_POST['acc_status'])) {
    $id = $_POST['acc_id'];
    $status = $_POST['acc_status'];

    $query = $admin->cud("UPDATE `account` SET `acc_status`='$status' WHERE `acc_id`='$id'", "Status Updated");

    echo "<script>alert('Inserted successfully'); window.location.href='../account.php';</script>";
    exit();
}
?>