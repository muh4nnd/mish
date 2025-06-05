<?php
session_start();
session_destroy();
header('Location:login_front.php');
//note: for logout only one page is enough
?>

