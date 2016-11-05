<html>
<head>
    <title>บัญชีรายรับ-รายจ่าย</title>
    <meta charset="utf-8">
</head>
</html>

<?php
session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$username = md5($_GET['email']);
$password = md5($_GET['pw1']);
$password1 = md5($_GET['pw2']);
$name = $_GET['name'];

$sql_check = "select user from registNote where user='$username'";
$check = $conn->query($sql_check);
$check = $check->fetch_object();
$check_username = $check->username;

$sql_check = "select password from registNote where password='$password'";
$check = $conn->query($sql_check);
$check = $check->fetch_object();
$check_password = $check->password;

if($_GET['email'] == "" || $_GET['pw1'] == "" || $_GET['pw2'] == "" || $_GET['name'] == ""){
    if($_GET['email'] == "" && $_GET['pw1'] == "" && $_GET['pw2'] == "" && $_GET['name'] == ""){
        echo "กรุณากรอกข้อมูล...!";
    }else if($_GET['email'] != "" && $_GET['pw1'] == "" && $_GET['err'] != "" && $_GET['pw2'] == "" && $_GET['name'] == ""){
        echo "กรุณากรอกข้อมูลให้ครบ...!<br>กรุณากรอกอีเมลล์ให้ถูกต้อง...!";
    }else{
        echo "กรุณากรอกข้อมูลให้ครบ...!";
    }
}else if($_GET['email'] != "" && $_GET['pw1'] != "" && $_GET['err'] != ""){
    echo "กรุณากรอกอีเมลล์ให้ถูกต้อง...!";
}else{
    if($password != $password1){
        echo "กรุณายืนยันรหัสผ่านให้ถูกต้อง...";
    }else if($username == $check_username && $password == $check_password ){
        echo "มีผู้ใช้ อีเมลล์ กับ รหัสผ่าน นี้แล้ว";
    }else if($username == $check_username || $password == $check_password ){
        if($username == $check_username){
            echo "มีผู้ใช้ อีเมลล์ นี้แล้ว<br>";
        }
        if($password == $check_password){
            echo "มีผู้ใช้ รหัสผ่าน นี้แล้ว";
        }
    }else{
        $sql = "INSERT INTO registNote(user,password,name)
                VALUES('".$username."','".$password."','".$name."')";
        if($conn->query($sql)){
            echo "<meta http-equiv=\"refresh\" content=\"1; url=index.php\">";
        }
    }
}


?>