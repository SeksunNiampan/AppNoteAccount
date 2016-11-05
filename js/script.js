function chspace() {
    if(event.keyCode == 32)
        return false;

    return true;
}
function CheckNum(){
    if (event.keyCode < 48 || event.keyCode > 57){
        event.returnValue = false;
    }
    return true;
}
function resetForm(){
    resetSearch();
    document.getElementById("re").reset();
}

$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

function login(){
    var email = document.getElementById('email').value;
    var pw = document.getElementById('pw').value;
    var err = "";
    if(validateEmail(email) == false){
        err = "กรุณากรอกอีเมลล์ให้ถูกต้อง";
    }

    var ajaxRequest;
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            if(ajaxRequest.status == 200){
                var dispResult = document.getElementById('dispLogin');
                dispResult.innerHTML = ajaxRequest.responseText;
            }
        }
    }

    var queryString = "?email="+email+"&pw="+pw+"&err="+err;
    ajaxRequest.open("GET","login.php"+queryString,true);
    ajaxRequest.send(null);
}

function regist(){
    var ajaxRequest;
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            if(ajaxRequest.status == 200){
                var dispResult = document.getElementById('dispRegist');
                dispResult.innerHTML = ajaxRequest.responseText;
            }
        }
    }

    var email = document.getElementById('em').value;
    var pw1 = document.getElementById('pw1').value;
    var pw2 = document.getElementById('pw2').value;
    var name = document.getElementById('name').value;

    var err = "";
    if(validateEmail(email) == false){
        err = "กรุณากรอกอีเมลล์ให้ถูกต้อง";
    }

    var queryString = "?email="+email+"&pw1="+pw1+"&pw2="+pw2+"&name="+name+"&err="+err;
    ajaxRequest.open("GET","regist.php"+queryString,true);
    ajaxRequest.send(null);
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function addNote(){
    var list = document.getElementById('list').value;
    if(list == ""){
        alert("ไม่สามารถเพิ่มรายการได้กรุณากรอกข้อมูล");
        resetForm();
        return false;
    }
    var mi = document.getElementById('mi').value;
    if(mi == ""){
        mi = 0;
    }
    var mo = document.getElementById('mo').value;
    if(mo == ""){
        mo = 0;
    }

    var queryString = "&list="+list+"&mi="+mi+"&mo="+mo;
    $.post("add.php",{
            list: list,
            mi: mi,
            mo: mo
    });
    resetForm();
    $("#show").load("show.php");
}

function deleteNote(id){
    $.post("delete.php",{
        listID: id
    });
    $("#show").load("show.php");
}

function editNote(id){
    var listID = document.getElementById('id_'+id).value;
    var list = document.getElementById('name_'+id).value;
    if(list == ""){
        alert("ไม่สามารถเพิ่มรายการได้กรุณากรอกข้อมูล");
        return false;
    }

    var mi = document.getElementById('ip_'+id).value;
    if(mi == ""){
        mi = 0;
    }
    var mo = document.getElementById('op_'+id).value;
    if(mo == ""){
        mo = 0;
    }

    var queryString = "listID="+listID+"&list="+list+"&mi="+mi+"&mo="+mo;

    $.ajax({
        type: "POST",
        url: "edit.php",
        cache: false,
        data: queryString,
        success: function(msg){
            $("#edit").append(msg);
        }
    });
    $("#show").load("show.php");
}
function search(){
    var word = document.getElementById('word').value;
    if(word == ""){
        document.getElementById("showSearch").innerHTML = "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" onclick=\"setTimeout(resetSearch,500)\">&times;</button><br><center><h4>กรุณากรอกข้อมูล</h4></center>";
        return false;
    }
    var url = "search.php?word="+word;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            myFunction(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET",url , true);
    xmlhttp.send();

    function myFunction(parsejson) {
        var arr = JSON.parse(parsejson);
        var i;
        if(arr.length == 0){
            document.getElementById("showSearch").innerHTML = "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" onclick=\"setTimeout(resetForm,500)\">&times;</button><br><center><h4>ไม่พบข้อมูลที่ค้นหา</h4></center>";
        return false;
        }
        var out = "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\" style='float: right' onclick=\"setTimeout(resetSearch,500)\"> <span class=\"glyphicon glyphicon-remove\"></span></button><table class=\"table table-striped table-hover\"><thead><tr><th>วัน</th><th>รายการ</th><th><center>รายรับ</center></th><th><center>รายจ่าย</center></th></tr></thead><tbody>";
        for(i = 0; i < arr.length; i++) {
            out += "<tr><td>" + arr[i].date + "</td><td>" + arr[i].list + "</td><td><center>" + arr[i].moneyIN + "</center></td><td><center>" + arr[i].moneyOUT + "</center></td></tr>";
        }
        out += "</tbody></table>";
        resetForm();
        document.getElementById("showSearch").innerHTML = out;
    }
}

function show(){
    resetForm();
    $("#show").load("show.php");
}
function resetSearch(){
    document.getElementById("showSearch").innerHTML = "";
}

function load(){
    alert("5555");
    window.location.assign("");
}

$(document).ready(function(){
    $("#show").load("show.php");
    /*function loadShow(){
     $.get('show.php' , function(data){
     $("#show").html(data);
     });
     }
     //setInterval(loadShow, 5000);
    * */
});