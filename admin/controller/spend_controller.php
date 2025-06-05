<?php
include '../../config.php'; // adjust your path if needed

$admin = new Admin();
date_default_timezone_set('Asia/Kolkata');
// Insert
if (isset($_POST['insert'])) {
    $neg_inr = $_POST['neg_inr'];
    $neg_cny = $_POST['neg_cny'];
    $neg_note = $_POST['neg_note'];
    $acc_id = $_POST['acc_id']; 
    $neg_date = date('Y-m-d H:i:s'); // 🛠 Set the current date and time

    $admin->cud("INSERT INTO `spend` (neg_inr, neg_cny, neg_note, neg_status, neg_date, acc_id) VALUES ('$neg_inr', '$neg_cny', '$neg_note', 'active', '$neg_date', '$acc_id')", "saved");

    echo "<script>alert('Inserted Successfully'); window.location.href='../index.php';</script>";
}

// Update
if (isset($_POST['update'])) {
    $id = $_POST['neg_id'];
    $neg_inr = $_POST['neg_inr'];
    $neg_cny = $_POST['neg_cny'];
    $neg_note = $_POST['neg_note'];
    $neg_status = $_POST['neg_status'];
    $acc_id = $_POST['acc_id'];

    $admin->cud("UPDATE spend SET neg_inr='$neg_inr', neg_cny='$neg_cny', neg_note='$neg_note', neg_status='$neg_status', acc_id='$acc_id' WHERE neg_id='$id'", "updated");

    echo "<script>alert('Updated Successfully'); window.location.href='../index.php';</script>";
}

// Delete
if (isset($_GET['delete_spend'])) {
    $id = $_GET['delete_spend'];

    $admin->cud("DELETE FROM spend WHERE neg_id='$id'", "deleted");

    echo "<script>alert('Deleted Successfully'); window.location.href='../spend.php';</script>";
}
?>