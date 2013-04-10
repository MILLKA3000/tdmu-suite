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
			<li><a href="all24.php">Валідність 24</a></li>
			<li><a href="all48.php">Валідність 48</a></li>
			<li><a href="all72.php">Валідність 72</a></li>
			<?}?>
			<li><a href="variant.php">Перегляд питань</a></li>
			
            <li><a href="arh.php">Управління архівом</a></li>
			
			<li><a href="auth.php?action=logout" title="Вихід">Вихід</a></li>	
		</ul>
  </div> </div>
    </td><td valign='top'>
	
	<?
	
	?>
    
    