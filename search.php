<?php
session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$sql = "SELECT * FROM (SELECT * FROM  `noteAccount` WHERE  `user` =  '".$_COOKIE['user']."' AND `list` LIKE  '%".$_GET['word']."%' ORDER BY  `listID` DESC LIMIT 0 , 20)t ORDER BY  `listID`";
$query = $conn->query($sql);
$result = array();
while($row = $query->fetch_assoc()){
    $result[] = $row;
}

$conn->close();

echo json_encode($result);
?>