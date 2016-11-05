<?php
session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$sql = "INSERT INTO `noteAccount`(`user`, `list`, `moneyIN`, `moneyOUT`, `date`) VALUES ('".$_COOKIE['user']."','".$_POST['list']."','".$_POST['mi']."','".$_POST['mo']."','".date("Y-m-d")."')";
$result = $conn->query($sql);
$conn->close();
?>