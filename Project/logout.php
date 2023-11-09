<?php ob_start() ?>
<?php
session_start();
$_SESSION['email']=null;
header("location:index.php");
?>
