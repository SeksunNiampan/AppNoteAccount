<?php
session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$sql = "UPDATE `noteAccount` SET `listID`='".$_POST['listID']."',`user`='".$_SESSION['user']."',`list`='".$_POST['list']."',`moneyIN`='".$_POST['mi']."',`moneyOUT`='".$_POST['mo']."' WHERE `listID`='".$_POST['listID']."' AND `user`='".$_SESSION['user']."'";
$result = $conn->query($sql);
$conn->close();
?>