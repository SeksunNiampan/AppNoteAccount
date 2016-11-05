<?php
session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$sql = "DELETE FROM `noteAccount` WHERE `listID` =  '".$_POST['listID']."' AND `user` =  '".$_COOKIE['user']."'";
$result = $conn->query($sql);
$conn->close();
?>