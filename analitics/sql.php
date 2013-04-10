 <script type="text/javascript" src="../testcenter/datepicker/jquery.js"></script>
<?php
include "menu.php";
include "navigate.php";
require_once "class/class_firebird.php";
$contingent = new class_ibase();
$sql = $_GET['sort']." ".$_GET['s']." ".$_GET['type'];
echo "<table><tr><td width=50%><form action='sql.php' method='GET' enctype='multipart/form-data'>";
echo "<TEXTAREA NAME=sort id='text' ROWS=10 COLS=100>".$sql."</TEXTAREA>";
echo "<br><input type='submit' name='put' value='Обробити'>";
echo "</form></td><td valign=top>";
echo "
<input type='submit' id='select' value='SELECT'><br><br>
<input type='submit' id='clear' value='Очистити'>
</td></tr><tr><td colspan=2>";
if($_GET['put'] || $_GET['sort']){
if ($_SESSION['name_sesion_a']=="admin"){
$zag_mas = $contingent->select_sql($sql);}else{header("Location: index.php");}
echo "<table bgcolor='white' border=1>";
  for ($i=0;$i<count($zag_mas);$i++)
  {
  echo "<tr>";
		for($j=0;$j<count($zag_mas[0]);$j++)
		{	
			if (($i==0) && ($_GET['type']=='DESC')){echo "<td><center><a href='sql.php?sort=".$_GET['sort']."&s=order by ".$zag_mas[$i][$j]." &type=ASC'>".$zag_mas[$i][$j]."</a></td>";}
			else
			if (($i==0) && ($_GET['type']=='ASC')){echo "<td><center><a href='sql.php?sort=".$_GET['sort']."&s=order by ".$zag_mas[$i][$j]." &type=DESC'>".$zag_mas[$i][$j]."</a></td>";}
			else
			if (($i==0)) {echo "<td><center><a href='sql.php?sort=".$_GET['sort']." &s=order by ".$zag_mas[$i][$j]."&type=DESC'>".$zag_mas[$i][$j]."</a></td>";}else{
			echo "<td><center>".$zag_mas[$i][$j]."</td>";}
		}
  echo "</tr>";
  }
}
?> 
<script type="text/javascript">
$('#clear').click(function(event){$("#text").val("");});
$('#select').click(function(event){$("#text").val("SELECT * FROM ");});
</script>