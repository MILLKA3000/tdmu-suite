<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="../testcenter/css/vrStyle.css" rel="stylesheet" type="text/css" />
<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
 <script type="text/javascript">
            $().ready(
            function() {
                $('form').show(1000);
                
            }
            );
        
</script>
<?
include ("auth.php");
if (($_POST['login']=="admin")&&($_POST['pass']=="admin")) 
		{
		session_start();
		$_SESSION['name_sesion_a'] = "admin";
		}else{
if (($_POST['login']=="test")&&($_POST['pass']=="test")) 
		{
		session_start();
		$_SESSION['name_sesion_a'] = "test";
		}		}
if (!$_SESSION['name_sesion_a'])
	{
	include ("header.php");
		echo "
		<center> <FONT size=8>¬х≥д</FONT><br><br>
<b> јвторизуйтесь  
 <div id='vrWrapper'>
        <form action='index.php' method='post' id='form' style='display:none;'> <b>
<div class='loginBlock'>¬вед≥ть лог≥н<center><input name='login' maxlength='50' size='41' type='text' >
<center>¬вед≥ть пароль<center><input name='pass' maxlength='50' size='41' type='password' ><br>
<div class='buttonDiv'><input type='submit' value='¬х≥д'></div></div></td></tr></form></table>
</div>";
	}else
	{
	

include ("menu.php");
}

?>