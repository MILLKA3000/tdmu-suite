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
		$_SESSION['role'] = "MILKA";
		}else{
if (($_POST['login']=="test")&&($_POST['pass']=="test")) 
		{
		session_start();
		$_SESSION['name_sesion_a'] = "admin";
		$_SESSION['role'] = "RUSLAN";
		}		}
if (!$_SESSION['name_sesion_a'])
	{
	include ("header.php");
		echo "
		<center> <FONT size=8>Вхід</FONT><br><br>
<b> Авторизуйтесь  
 <div id='vrWrapper'>
        <form action='index.php' method='post' id='form' style='display:none;'> <b>
<div class='loginBlock'>Введіть логін<center><input name='login' maxlength='50' size='41' type='text' >
<center>Введіть пароль<center><input name='pass' maxlength='50' size='41' type='password' ><br>
<div class='buttonDiv'><input type='submit' value='Вхід'></div></div></td></tr></form></table>
</div>";
	}else
	{
	

include ("menu.php");
}

?>