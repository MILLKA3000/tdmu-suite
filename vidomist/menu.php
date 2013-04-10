<?
include ("auth.php");
include ("header.php");
?>



<table width="100%"><tr><td ><h3><center></td><td></td><td><h3><center></td></tr><tr><td width="15%" valign='top'>

<div id="firstcol">
	<div id="menu">
		<ul>
			<li><a href="index.php">Головна</a></li>
			<?if ($_SESSION['name_sesion_a']=="admin")
			{?>
			<li><a href="vidomist.php"  style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Створення відомості для одного студента</div></a></li>
			<li><a href="vidomist_old.php"  style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Створення відомостей</div></a></li>
			<li><a href="XML_dis.php"  style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Робота з XML</div></a></li>
			
			<?}?>
			
			
			<li><a href="auth.php?action=logout" title="Вихід">Вихід</a></li>	
		</ul>
  </div> </div>
    </td><td valign='top'>
	
	<?
	
	?>
    
    