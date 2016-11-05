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

$sql = "SELECT * FROM (SELECT * FROM  `noteAccount` WHERE  `user` =  '".$_SESSION['user']."' ORDER BY  `listID`)t ORDER BY  `listID`";
$result = $conn->query($sql);
$sumMoney = 0;
while($note = $result->fetch_object()){
        $mi = $note->moneyIN;
        $mo = $note->moneyOUT;
        
        $sumMoney = $sumMoney+$mi;  
        $sumMoney = $sumMoney-$mo;
        
}

$sql = "SELECT * FROM (SELECT * FROM  `noteAccount` WHERE  `user` =  '".$_SESSION['user']."' ORDER BY  `listID` DESC LIMIT 0 , 20)t ORDER BY  `listID`";
$result = $conn->query($sql);
$sum = $result->num_rows;

echo "<div class=\"container\">
        <div class=\"jumbotron\">
            <table class=\"table table-striped table-hover \">
            <thead>
            <tr>
                <th>วัน</th>
                <th>รายการ</th>
                <th><center>รายรับ</center></th>
                <th><center>รายจ่าย</center></th>
                <th><center>ตัวดำเนินการ</center></th>
            </tr>
            </thead><tbody>";
if($sum == 0){
    echo "<tr>
             <td colspan=\"5\" align=\"center\">ยังไม่มีข้อมูลในระบบ</td>
          </tr>
          </tbody></table>";

}else{
    while($note = $result->fetch_object()){
        echo "  <tr>
                <td>$note->date</td>
                <td>$note->list</td>";
        $mi = $note->moneyIN;
        $mo = $note->moneyOUT;

        if($mi == 0){
            echo "<td><center>-</center></td>";
        }else{
            echo "<td><center>$mi</center></td>";
        }

        if($mo == 0){
            echo "<td><center>-</center></td>";
        }else{
            echo "<td><center>$mo</center></td>";
        }
        echo "
                <td><center><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#delete_".$note->listID."\">
                                    <span class='glyphicon glyphicon-trash'></span>
                                  </button>&nbsp;&nbsp;<button type='button' class='btn btn-success btn-sm' data-toggle=\"modal\" data-target=\"#edit_".$note->listID."\">
                                    <span class='glyphicon glyphicon-pencil'></span></center></td>
            </tr>";

        echo "<!-- Modal deleteBlog -->
                    <div id=\"delete_".$note->listID."\" class=\"modal fade\" role=\"dialog\">
                          <div class=\"modal-dialog\">
                                <!-- Modal content-->
                                <div class=\"modal-content\">
                                      <div class=\"modal-header\">
                                           <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                           <h4 class=\"modal-title\">ยืนยันการลบข้อมูล</h4>
                                      </div>
                                      <div class=\"modal-body\">
                                            <p>ต้องการลบข้อมูลของคุณหรือไม่</p>
                                      </div>
                                      <div class=\"modal-footer\">
                                            <form>
                                                <input type='hidden' name='id' value='$note->listID'>
                                                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">
                                                      <span class=\"glyphicon glyphicon-remove\"></span> ไม่ลบ
                                                </button>
                                                <button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\" onclick=\"setTimeout(deleteNote,500,$note->listID)\">
                                                      <span class=\"glyphicon glyphicon-ok\"></span> ลบ
                                                </button>
                                            </form>
                                      </div>
                                </div>
                          </div>
                    </div>

              <!-- Modal edit-->
              <div id=\"edit_".$note->listID."\" class=\"modal fade\" role=\"dialog\">
                   <div class=\"modal-dialog\">
                       <!-- Modal content-->
                       <div class=\"modal-content\">
                             <div class=\"modal-body\">
                             <form>
                                   <button type=\"reset\" class=\"close\" data-dismiss=\"modal\">&times;</button>

                                        <input type='hidden' id='id_$note->listID' name='id' value='$note->listID'>
                                        <label>รายการ</label>
                                        <input type=\"text\" class=\"form-control\" id=\"name_$note->listID\" name=\"name_$note->listID\" value=\"$note->list\" onkeypress=\"return chspace()\">
                                        <label>รายรับ</label>
                                        <input type=\"text\" class=\"form-control\" id=\"ip_$note->listID\" name=\"ip_$note->listID\" value=\"$mi\" size=\"1\" onkeypress=\"return CheckNum()\">
                                        <label>รายจ่าย</label>
                                        <input type=\"text\" class=\"form-control\" id=\"op_$note->listID\" name=_$note->listID\"op\" value=\"$mo\" size=\"1\" onkeypress=\"return CheckNum()\">

                             </div>
                             <div class=\"modal-footer\">
                                   <input type=\"button\" value=\"ตกลง\" class=\"btn btn-success\" data-dismiss=\"modal\" onclick=\"setTimeout(editNote,500,$note->listID)\">
                             </div>
                             </form>
                       </div>
                   </div>
              </div>";

    }

    echo "  <tr class=\"warning\">
                <td colspan=\"3\" align=\"right\">เงินคงเหลือ</td>
                <td><center>$sumMoney</center></td>
            </tr>
            </tbody>
        </table>
        </div></div>";
}
$conn->close();
?>