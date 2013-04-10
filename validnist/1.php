<?php
$questions = array(array());
require_once "class/mysql-class.php";
$base = new class_mysql_base();
$base->sql_connect();
$rs = $base->sql_query="call `selectgroup`(16485,1)";
//$rs = $base->sql_query="select * from variant where 1; ";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
	   $questions[$i]['id'] = $Mas['id'];   
       $questions[$i]['numvariant'] = $Mas['numvariant']; 
	   $questions[$i]['numquestion'] = $Mas['numquestion']; 
	   $questions[$i]['gr1'] = $Mas['gr1']; 
	   $questions[$i]['gr2'] = $Mas['gr2']; 
	   $questions[$i]['gr3'] = $Mas['gr3']; 
	   $questions[$i]['gr4'] = $Mas['gr4']; 
	   $questions[$i]['gr5'] = $Mas['gr5']; 
	   $questions[$i]['validn'] = $Mas['validn']; 
       $i++;
    }
print_r($questions);
?> 
