<?php

include '../../config.php';

$admin = new Admin();


if(isset($_POST['login'])){

	$username = $_POST['username'];

	$password = $_POST['password'];

	$query=$admin->ret("SELECT * FROM `admin` WHERE `username`='$username' AND `password`='$password' ");


//couting row
	$num=$query->rowCount();

	if($num>0){
		$row=$query->fetch(PDO::FETCH_ASSOC);

		$id =$row['admin_id'];
		$_SESSION['admin_id']=$id; //used to uniquely identify user session. use this in user pages

		echo "<script> window.location.href='../homepage.php';</script>";

	}

	else
	{
		echo "<script>alert('wrong username or password..!'); window.location.href='../login_front.php';</script>";
	}
	
}

?>
