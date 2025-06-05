<?php 

include '../../config.php';

$admin = new Admin();

?>

<?php
//update------------------------------------------------------------------
if(isset($_POST['update'])){ //update is submit button name

    $id = $_POST['admin_id']; //hidden id passed in update form

	$username = $_POST['username']; 

    $password = $_POST['password']; 

    }

$query=$admin->cud("UPDATE `admin` SET `username`='$username', `password`='$password' WHERE admin.admin_id='$id' ","updated successfully"); 

echo "<script>alert('updated');window.location.href='../index.php';</script>";
?>
