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
			<li><a href="sql.php">Sql запроси</a></li>
			<li><a href="ser.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Середнє значення у БД "Контингент"</div></a></li>
			<li><a href="moodle2cont.php" style='font-size:9pt;'><div style='padding-top:-8px;margin-top:-8px;'>Прив"язка дисциплін мудла і Контингента з кафедрами</div></a></li>
			<li><a href="intranet_count.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Кількість матеріалів в "Інтранет"-і</div></a></li>
            <li><a href="ratinginfo.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>Дані рейтингу викладачів</div></a></li>
			<?}?>
			
			
			<li><a href="auth.php?action=logout" title="Вихід">Вихід</a></li>	
		</ul>
  </div> </div>
    </td><td valign='top'>
	
	<?
	
	?>
    
    