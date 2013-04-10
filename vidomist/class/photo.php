<?
require_once "class_firebird.php";
$base = new class_ibase();
$base->sql_connect();

	$sql="SELECT PHOTO FROM STUDENTS WHERE STUDENTID='".$_GET['id_photo']."'";
	$base->sql_query=$sql;
	$base->sql_execute();
	if ($row = ibase_fetch_row($base->sql_result)) 
	{
    header("Content-Type: image/jpeg");
    ibase_blob_echo($row[0]);
	} 

?>