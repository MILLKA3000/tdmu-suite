<?
include ("auth.php");
include ("header.php");
?>



<table width="100%"><tr><td ><h3><center></td><td></td><td><h3><center></td></tr><tr><td width="15%" valign='top'>

<div id="firstcol">
	<div id="menu">
		<ul>
			<li><a href="index.php">�������</a></li>
			<?if ($_SESSION['name_sesion_a']=="admin")
			{?>
			<li><a href="sql.php">Sql �������</a></li>
			<li><a href="ser.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>������ �������� � ��� ����������</div></a></li>
			<li><a href="moodle2cont.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>�������� �������� ����� � ����������� � ���������</div></a></li>
			<li><a href="http://intranet.tdmu.edu.ua/data/kafedra/internal/scan.php" style='font-size:10pt;'><div style='padding-top:-8px;margin-top:-8px;'>ʳ������ �������� � ��������</div></a></li>
			<?}?>
			
			
			<li><a href="auth.php?action=logout" title="�����">�����</a></li>	
		</ul>
  </div> </div>
    </td><td valign='top'>
	
	<?
	
	?>
    
    