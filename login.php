<html>
<head>
    <title>บัญชีรายรับ-รายจ่าย</title>
    <meta charset="utf-8">
</head>
</html>

<?php session_start();

$host="localhost";
$username="it57160608";
$password="1102700532951";
$database="it57160608";
$conn=new mysqli($host,$username,$password,$database);
$conn->query("SET NAMES UTF8");

$username = md5($_GET['email']);
$password = md5($_GET['pw']);


$sql_check = "select * from registNote where user='$username' or password='$password'";
$check = $conn->query($sql_check);
$check = $check->fetch_object();

$checkUsername = $check->user;
$checkPassword = $check->password;
$name = $check->name;

if($_GET['email'] == "" || $_GET['pw'] == ""){
    if($_GET['email'] == "" && $_GET['pw'] == ""){
        echo "กรุณากรอกข้อมูล...!";
    }else if($_GET['email'] != "" && $_GET['pw'] == "" && $_GET['err'] != ""){
        echo "กรุณากรอกข้อมูลให้ครบ...!<br>กรุณากรอกอีเมลล์ให้ถูกต้อง...!";
    }else{
        echo "กรุณากรอกข้อมูลให้ครบ...!";
    }
}else if($_GET['email'] != "" && $_GET['pw'] != "" && $_GET['err'] != ""){
    echo "กรุณากรอกอีเมลล์ให้ถูกต้อง...!";
}

if($_GET['err'] == "" && $_GET['pw'] != ""){
    if($username != $checkUsername && $password != $checkPassword){
        echo "คุณยังไม่มีบัญชีในระบบ<br>กรุณาสมัครสมาชิกก่อนเข้าสู่ระบบ";
    }else if($username != $checkUsername || $password != $checkPassword){
        echo "มีความผิดพลาด กรุณาตรวจสอบความถูกต้องของ อีเมลล์และรหัสผ่าน ของผู้ใช้";
    }else{
        $_SESSION['user'] = $checkUsername;
        $_SESSION['name'] = $name;
        setcookie("user",$checkUsername,time()+2*24*60*60);
        setcookie("name",$name,time()+2*24*60*60);
        echo "<meta http-equiv=\"refresh\" content=\"0; url=http://angsila.cs.buu.ac.th/~57160608/NoteAccount/\">";
    }
}
$conn->close();
?>