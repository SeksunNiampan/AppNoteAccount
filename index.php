<?php
session_start();

if(isset($_COOKIE['user'])==true){
    $_SESSION['user'] = $_COOKIE['user'];
    $_SESSION['name'] = $_COOKIE['name'];
    setcookie("user",$_COOKIE['user'],time()+2*24*60*60);
    setcookie("name",$_COOKIE['name'],time()+2*24*60*60);
}
if($_GET['word']){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=http://angsila.cs.buu.ac.th/~57160608/NoteAccount/\">";
}


if(isset($_SESSION['user'])==true || isset($_COOKIE['user'])==true ){
    echo "
    <!DOCTYPE html>
<html>
<head>
    <title>บัญชีรายรับ-รายจ่าย</title>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js\"></script>
    <script src=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\"></script>
    <link href=\"https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/united/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-0UBL8wxZ28kqJ8w8N8RUV0odBG5w8D/Y+rb+o7hr2F3dS9twlAE8S7VUtVSRe5cc\" crossorigin=\"anonymous\">
</head>

<style>
    html, body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    #full-screen-background-image {
        z-index: -999;
        min-height: 100%;
        min-width: 1024px;
        width: 100%;
        height: auto;
        position: fixed;
        top: 0;
        left: 0;
    }

    #wrapper {
        position: relative;
        width: 800px;
        min-height: 400px;
        margin: 100px auto;
        color: #333;
    }
</style>

<body>
<img alt=\"full screen background image\" src=\"paper-bg.jpg\" id=\"full-screen-background-image\" />

<!--menu-->
<nav class=\"navbar navbar-default navbar-fixed-top\">
    <div class=\"container-fluid\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"index.php\"><span class=\"glyphicon glyphicon-list-alt\"></span> บัญชีของ ".$_COOKIE['name']." </a>
        </div>

        <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
            <form class=\"navbar-form navbar-left\" id=\"re\">
                <div class=\"form-group\">
                    <input type=\"text\" class=\"form-control\" id=\"word\" name=\"word\" placeholder=\"ค้นหารายการ\">
                </div>
                <button type=\"button\" class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#myModalSearch\"  onclick=\"setTimeout(search,100)\"><span class=\"glyphicon glyphicon-search\"></span></button>
            </form>
            <ul class=\"nav navbar-nav navbar-right\">
                <li><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalADD\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่มรายการ</a></li>
                <li><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalSourceCode\"><span class=\"glyphicon glyphicon-download-alt\"></span> Source code</a></li>
                <li><a href=\"#\" data-toggle=\"modal\" data-target=\"#myModalLogout\"><span class=\"glyphicon glyphicon-log-out\"></span> ออกจากระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>
<!--end menu-->
<br><br><br><br>

<!--show-->
<div id=\"show\"></div>
<!--end show-->

<!-- ModalLogout -->
<div id=\"myModalLogout\" class=\"modal fade\" role=\"dialog\">
    <div class=\"modal-dialog\">
        <!-- Modal content-->
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h4 class=\"modal-title\">ยืนยันการออกจากระบบ</h4>
            </div>
            <div class=\"modal-body\">
                <p>คุณแน่ใจว่าต้องการออกระบบ</p>
            </div>
            <div class=\"modal-footer\">
                <form method='post' action='logout.php'>
                    <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">
                        <span class=\"glyphicon glyphicon-remove\"></span> ยกเลิก
                    </button>

                    <input type='hidden' name='yes' value='y'>
                    <button type=\"submit\" class=\"btn btn-danger\">
                        <span class=\"glyphicon glyphicon-ok\"></span> ออกจากระบบ
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- ModalInsert -->
<div id=\"myModalADD\" class=\"modal fade\" role=\"dialog\">
    <div class=\"modal-dialog\">
        <!-- Modal content-->
        <div class=\"modal-content\">
            <div class=\"modal-body\">
                <form id=\"re\">
                    <button type=\"reset\" class=\"close\" data-dismiss=\"modal\" onclick=\"setTimeout(resetForm,500)\">&times;</button>
                    <table class=\"table table-striped table-hover \">
                        <thead>
                        <tr>
                            <th>รายการ</th>
                            <th><center>รายรับ</center></th>
                            <th><center>รายจ่าย</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type=\"text\" class=\"form-control\" id=\"list\" name=\"list\" onkeypress=\"return chspace()\"></td>
                            <td><center><input type=\"text\" class=\"form-control\" id=\"mi\" name=\"mi\" size=\"1\" onkeypress=\"return CheckNum()\"></center></td>
                            <td><center><input type=\"text\" class=\"form-control\" id=\"mo\" name=\"mo\" size=\"1\" onkeypress=\"return CheckNum()\"></center></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class=\"modal-footer\">
                <input type=\"button\" value=\"เพิ่ม\" class=\"btn btn-success\" data-dismiss=\"modal\" onclick=\"setTimeout(addNote,500)\">
            </div>
        </div>

    </div>
</div>

<!-- ModalSearch -->
<div id=\"myModalSearch\" class=\"modal fade\" role=\"dialog\">
    <div class=\"modal-dialog\">
        <!-- Modal content-->
        <div class=\"modal-content\">
            <div class=\"modal-body\">
                <div id=\"showSearch\"></div>
            </div>
        </div>

    </div>
</div>

<!-- ModalSourceCode -->
<div id=\"myModalSourceCode\" class=\"modal fade\" role=\"dialog\">
    <div class=\"modal-dialog\">
        <!-- Modal content-->
        <div class=\"modal-content\">
            <div class=\"modal-body\">
                <p>คุณแน่ใจว่าต้องการดาวห์โหลด Source code</p>
            </div>
            <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">
                        <span class=\"glyphicon glyphicon-remove\"></span> ยกเลิก
                    </button>
                    <button type=\"submit\" class=\"btn btn-success\" onclick='load()'>
                        <span class=\"glyphicon glyphicon-ok\"></span> ดาวห์โหลด
                    </button>
            </div>
        </div>

    </div>
</div>

<script src=\"js/script.js\"></script>

</body>
</html> ";
}else{
    session_destroy();
    echo "

<!DOCTYPE html>
<html >
<head>
    <meta charset=\"UTF-8\">
    <title>บัญชีรายรับ-รายจ่าย</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel=\"stylesheet\" href=\"css/normalize.css\">
    <link rel=\"stylesheet\" href=\"css/style.css\">

</head>

<style>
    html, body {
        height: 100%;
        width: 100%;
        padding: 0;
        margin: 0;
    }

    #full-screen-background-image {
        z-index: -999;
        min-height: 100%;
        min-width: 1024px;
        width: 100%;
        height: auto;
        position: fixed;
        top: 0;
        left: 0;
    }

    #wrapper {
        position: relative;
        width: 800px;
        min-height: 400px;
        margin: 100px auto;
        color: #333;
    }
</style>

<body>
<img alt=\"full screen background image\" src=\"paper-bg.jpg\" id=\"full-screen-background-image\" />

<br><br><br><br>

<div class=\"form\">

    <ul class=\"tab-group\">
        <li class=\"tab  active\"><a href=\"#login\">เข้าสู่ระบบ</a></li>
        <li class=\"tab\"><a href=\"#signup\">สมัครสมาชิก</a></li>
    </ul>

    <div class=\"tab-content\">
        <div id=\"login\">

            <h2><span id=\"dispLogin\"></span></h2>

            <form>

                <div class=\"field-wrap\">
                    <label>
                        อีเมลล์<span class=\"req\"></span>
                    </label>
                    <input type=\"text\" id=\"email\" name=\"email\" autocomplete=\"off\" onkeypress=\"return chspace()\">
                </div>

                <div class=\"field-wrap\">
                    <label>
                        รหัสผ่าน<span class=\"req\"></span>
                    </label>
                    <input type=\"password\" id=\"pw\" name=\"pw\" autocomplete=\"off\" onkeypress=\"return chspace()\">
                </div>

                <input type=\"button\" value=\"เข้าสู่ระบบ\" class=\"button button-block\" onclick=\"login()\">

            </form>

        </div>

        <div id=\"signup\">
            <h2><span id=\"dispRegist\"></span></h2>

            <form>

                <div class=\"field-wrap\">
                    <label>
                        ชื่อผู้ใช้<span class=\"req\"></span>
                    </label>
                    <input type=\"text\" id=\"name\" name=\"name\" autocomplete=\"off\">
                </div>

                <div class=\"field-wrap\">
                    <label>
                        อีเมลล์<span class=\"req\"></span>
                    </label>
                    <input type=\"text\" id=\"em\" name=\"em\" autocomplete=\"off\" onkeypress=\"return chspace()\">
                </div>

                <div class=\"field-wrap\">
                    <label>
                        รหัสผ่าน<span class=\"req\"></span>
                    </label>
                    <input type=\"password\" id=\"pw1\" name=\"pw1\" autocomplete=\"off\" onkeypress=\"return chspace()\">
                </div>

                <div class=\"field-wrap\">
                    <label>
                        ยืนยันรหัสผ่าน<span class=\"req\"></span>
                    </label>
                    <input type=\"password\" id=\"pw2\" name=\"pw2\" autocomplete=\"off\" onkeypress=\"return chspace()\">
                </div>

                <input type=\"button\" value=\"ยืนยัน\" class=\"button button-block\" onclick=\"regist()\">

            </form>

        </div>

    </div><!-- tab-content -->

</div> <!-- /form -->

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src=\"js/script.js\"></script>

</body>
</html>

";
}
?>