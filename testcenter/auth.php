<link href="css/vrStyle.css" rel="stylesheet" type="text/css" />
<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
<?php

if (isset($_GET['action']) AND $_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: index.php");
  exit;
}

if (isset($_POST['login'])) {
 if (($_POST['login']=='admin') && ($_POST['pass']=='admin'))
   {
    session_start();
    $_SESSION['role'] = "admin";
    $_SESSION['login_name'] = $_POST['login'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];    
	header("Location: index.php");
	exit;
   }   
 $sql_login="milenium";
 $sql_passwd="milenium";
 $sql_database="tdmu";
 $sql_host="192.168.1.19";
 $conn_id = mysql_connect($sql_host,$sql_login,$sql_passwd);
  mysql_select_db($sql_database);
  mysql_query('SET NAMES cp1251', $conn_id);  
$sql_query="SELECT DISTINCT tbl_login.login,tbl_stud_inf.studentid FROM tbl_login,tbl_stud_inf WHERE tbl_login.user_id=tbl_stud_inf.studentid AND tbl_login.login='".$_POST['login']."' AND tbl_login.pass='".crypt(md5($_POST['pass']), md5($_POST['login']))."';";
$sql_result=mysql_query($sql_query,$conn_id);
while($Mas = mysql_fetch_array($sql_result))
	{
	   $mas['login'] = $Mas['login']; 
       $mas['studentid'] = $Mas['studentid'];   
    }

 if ($mas['login']){
    session_start();
    $_SESSION['studentid'] = $mas['studentid'];
    $_SESSION['login_name'] = $_POST['login'];
    $_SESSION['role'] = "student";
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}
   

  header("Location: index.php");
  exit;
}
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['name']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
if (!$_SESSION['login_name'])
{
require("header.php");


echo "<center> <FONT size=8>¬х≥д</FONT><br><br>
<b> јвторизуйтесь  
 <div id='vrWrapper'>
        <form action='auth.php' method='post' id='form' style='display:none;'> <b>
<div class='loginBlock'>¬вед≥ть лог≥н<center><input name='login' maxlength='50' size='41' type='text' >
<center>¬вед≥ть пароль<center><input name='pass' maxlength='50' size='41' type='password' ><br>
<div class='buttonDiv'><input type='submit' value='¬х≥д'></div></div></td></tr></form></table>
</div>";
}
?>
 <script type="text/javascript">
            $().ready(
            function() {
                $('form').show(1000);
                
            }
            );
        
        </script>