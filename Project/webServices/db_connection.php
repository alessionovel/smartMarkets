<?php
ob_start();

session_start();

$host = "31.11.39.26";
$user = "Sql1506670";
$password = "0831qrr4f2";
$db = "Sql1506670_3";
$conn = mysqli_connect($host, $user, $password, $db);

if ($conn->connect_errno) {
  printf("Connect failed: %s\n", $conn->connect_error);
}
