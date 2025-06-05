<?php
include '../../config.php';

$admin = new Admin();

// --- Create / Insert ---
if (isset($_POST['insert'])) {

    $name = $_POST['name'];
    $status = $_POST['status']; // Fetching status from the form

    $query = $admin->cud("INSERT INTO `account`(`acc_name`, `acc_status`) VALUES('$name', '$status')", "saved");

    echo "<script>alert('Inserted successfully'); window.location.href='../account.php';</script>";
}
?>

<?php
// --- Update ---
if (isset($_POST['update'])) {

    $id = $_POST['acc_id']; // hidden id passed in update form
    $name = $_POST['name'];
    $status = $_POST['status']; // Fetching status from the form

    $query = $admin->cud("UPDATE `account` SET `acc_name`='$name', `acc_status`='$status' WHERE acc_id='$id'", "updated successfully");

    echo "<script>alert('Updated'); window.location.href='../account.php';</script>";
}
?>

<?php
// --- Delete ---
if (isset($_GET['delete_account'])) {  // delete_category id is href variable from delete button

    $id = $_GET['delete_account'];

    $query = $admin->cud("DELETE FROM `account` WHERE `acc_id`=" . $id, "Deleted successfully");

    echo "<script>alert('Deleted'); window.location.href='../account.php';</script>";
}
?>