<script type="text/javascript" src="../testcenter/datepicker/jquery.js"></script>
 
<?php  
include "class/function.php";
include "auth.php";
if ($_SESSION['name_sesion_a']=="admin"){
include "menu.php";
include "navigate.php";
echo "<table bgcolor='white' border=1 width=100% class='ser2'><tr><td>";
echo '<center><h2>������-��������� ������� ���������� �������� �� ������ "��������":</h2></center></td></tr><tr><td>';
echo "<p></p>";
echo "<h3><center><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/scan.php' target='_new'>������ ����� ��� ������� ��������� �����</a></center></h3>";
echo "<h3><center><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/scan3short.php' target='_new'>� ��������� ��������� ����� (������� - �� ��������������)</a></center></h3>";
echo "<h3><center><a href='http://intranet.tdmu.edu.ua/data/kafedra/internal/scan3full.php' target='_new'>� ��������� ��������� ����� (�������� - �� ���������)</a></center></h3>";
echo "<p></p>";

echo "</td></tr></table>";
}else {header("Location: index.php");}
?> 