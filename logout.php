<?php
session_start();
session_destroy();
setcookie("user",false);
setcookie("name",false);
header("location:http://angsila.cs.buu.ac.th/~57160608/NoteAccount/");
?>