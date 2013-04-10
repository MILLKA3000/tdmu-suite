<?
 class class_mysql_base

{

  var $sql_login="root";
  var $sql_passwd="admin5";
  var $sql_database="testcenter";
  var $sql_host="127.0.0.1";
  var $conn_id;
  var $sql_query;
  var $sql_err;
  var $sql_result;
  var $mas_doctor = array(array());

function sql_connect()
 {
  $this->conn_id = mysql_connect($this->sql_host,$this->sql_login,$this->sql_passwd);
  mysql_select_db($this->sql_database);
  mysql_query('SET NAMES cp1251', $this->conn_id);
  //mysql_query('SET NAMES UTF-8', $this->conn_id);
 }

function sql_execute()
 {
  $this->sql_result=mysql_query($this->sql_query,$this->conn_id);
  $this->sql_err=mysql_error();
 }

function sql_close()
 {
  mysql_close($this->conn_id);
 }
//Функції обробки даних
//Получення даних з звязуючої таблиці для формування списків лікарів
function select_type_session($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT * FROM type_sesion WHERE ".$parameter.";";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];   
       $type[$i]['type'] = $Mas['type']; 
       $i++;
    }
  $this->sql_close();
  return $type;
 }
 function select_table_ocinka($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query=$parameter;

  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['potochna'] = $Mas['potochna']; 
	   $type[$i]['examen'] = $Mas['examen']; 
	   $type[$i]['ostatochna'] = $Mas['ostatochna']; 
	   $type[$i]['student_id'] = $Mas['student_id']; 
	   $type[$i]['group'] = $Mas['group'];
	   $type[$i]['discipline_id'] = $Mas['discipline_id']; 
	   $type[$i]['module_id'] = $Mas['module_id']; 
	   $type[$i]['excel_id'] = $Mas['excel_id']; 
	   $type[$i]['sort'] = $Mas['sort'];
       $i++;
    }
  $this->sql_close();
  return $type;
 }
function select_excel_faculty()
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT DISTINCT faculty_id FROM excel WHERE 1;";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['faculty_id'] = $Mas['faculty_id'];  
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
function select_excel_speciality($fac)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT DISTINCT speciality_id FROM excel WHERE faculty_id=".$fac.";";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['speciality_id'] = $Mas['speciality_id'];  
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
function select_excel_lang($fac,$spec)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT DISTINCT lang FROM excel WHERE faculty_id=".$fac." AND speciality_id=".$spec.";";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['lang'] = $Mas['lang'];  
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
 
function select_course($fac,$spec,$lang)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT DISTINCT semester FROM excel WHERE faculty_id=".$fac." AND speciality_id=".$spec." AND lang='".$lang."';";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['course'] = $Mas['semester'];  
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
function select_excel($fac,$parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query="SELECT * FROM excel WHERE faculty_id='".$fac."'".$parameter.";";
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['semester'] = $Mas['semester'];
	   $type[$i]['faculty_id'] = $Mas['faculty_id'];
	   $type[$i]['speciality_id'] = $Mas['speciality_id'];
	   $type[$i]['type_sesion'] = $Mas['type_sesion'];
	   $type[$i]['potik'] = $Mas['potik'];
	   $type[$i]['chastuna'] = $Mas['chastuna'];
	   $type[$i]['lang'] = $Mas['lang'];
	   $type[$i]['date'] = $Mas['date'];
	   $type[$i]['type_atemp'] = $Mas['type_atemp'];
       $type[$i]['course'] = $Mas['course'];
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
 function select_year($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['date'] = $Mas['date'];
	   $type[$i]['name'] = $Mas['name'];
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
 function select_excel2($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['semester'] = $Mas['semester'];
	   $type[$i]['faculty_id'] = $Mas['faculty_id'];
	   $type[$i]['speciality_id'] = $Mas['speciality_id'];
	   $type[$i]['type_sesion'] = $Mas['type_sesion'];
	   $type[$i]['potik'] = $Mas['potik'];
	   $type[$i]['chastuna'] = $Mas['chastuna'];
	   $type[$i]['lang'] = $Mas['lang'];
	   $type[$i]['date'] = $Mas['date'];
	   $type[$i]['type_atemp'] = $Mas['type_atemp'];
       $type[$i]['course'] = $Mas['course'];
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
 
 function select_module($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['id_excel'] = $Mas['id_excel'];
	   $type[$i]['id_discipline'] = $Mas['id_discipline'];
	   $type[$i]['id_module'] = $Mas['id_module'];
	   $type[$i]['name_discipline'] = $Mas['name_discipline'];
	   $type[$i]['name_module'] = $Mas['name_module'];
	   $type[$i]['sort'] = $Mas['sort'];
       $i++; 
    }
  $this->sql_close();
  return $type;
 }
 function delete_log_excel($parameter)
 {
    $this->sql_connect();
    $this->sql_query="DELETE FROM excel  WHERE  id='".(int)$parameter."';";
    $this->sql_execute();
    $this->sql_query="DELETE FROM log_excel  WHERE  id_export_table='".(int)$parameter."';";
    $this->sql_execute();
    $this->sql_query="DELETE FROM module  WHERE id_excel='".(int)$parameter."';";
    $this->sql_execute(); 
    $this->sql_query="DELETE FROM table_ocinka  WHERE  excel_id='".(int)$parameter."';";
    $this->sql_execute();
    $this->sql_close();
 }
 
  function select_log($parameter)
 {  $type = array(array());
    $i=0;
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute();
  while($Mas = mysql_fetch_array($this->sql_result))
	{
	   $type[$i]['id'] = $Mas['id'];  
	   $type[$i]['name'] = $Mas['name'];
	   $type[$i]['date'] = $Mas['date'];
	   $type[$i]['file_path'] = $Mas['file_path'];
	   $type[$i]['id_load_user'] = $Mas['id_load_user'];
	   $type[$i]['id_export_table'] = $Mas['id_export_table'];
	   
       $i++; 
    }
  $this->sql_close();
  return $type;
 }

function insert_excel($semester,$faculty_id,$speciality_id,$type_sesion,$potik,$chastuna,$date,$lang,$course,$year)
 {  
  $this->sql_connect();
  $this->sql_query="INSERT INTO `testcenter`.`excel` (`semester` ,`faculty_id` ,`speciality_id` ,`type_sesion` ,`potik` ,`chastuna` ,`date` , 
`course`,`lang`,`type_atemp`)VALUES ('".$semester."', '".$faculty_id."', '".$speciality_id."', '".$type_sesion."', '".$potik."', '".$chastuna."', '".$date."', '".$course."', '".$lang."', '".$year."') ";
  $this->sql_execute();
  $last_id=mysql_insert_id();
  $this->sql_close();
  return $last_id;
 }
function insert_module($id_excel,$id_discipline,$id_module,$name_discipline,$name_module,$sort)
 {  
  $this->sql_connect();
  $this->sql_query="INSERT INTO `testcenter`.`module` (`id_excel` ,`id_discipline` ,`id_module` ,`name_discipline` ,`name_module`,`sort`)
  VALUES ('".$id_excel."', '".$id_discipline."', '".$id_module."', '".mysql_real_escape_string($name_discipline)."', '".mysql_real_escape_string($name_module)."', '".$sort."') ";
  $this->sql_execute();
  $this->sql_close();
 }
 
function insert_ocinka($potochna,$examen,$ostatochna,$student_id,$discipline_id,$module_id,$excel_id,$sort,$form,$group)
 {  
    if ($examen=='0(n)'){$examen=0;}
    if ($ostatochna=='0(n)'){$ostatochna=0;}
  $this->sql_connect();
  $this->sql_query="INSERT INTO `testcenter`.`table_ocinka` (`potochna` ,`examen` ,`ostatochna` ,`student_id` ,`discipline_id` ,`module_id` ,`excel_id` ,`sort`,`form`,`group`
)VALUES ('".$potochna."', '".$examen."', '".$ostatochna."', '".$student_id."', '".$discipline_id."', '".$module_id."', '".$excel_id."', '".$sort."', '".$form."', '".$group."') ";

  $this->sql_execute();
  $this->sql_close();
 } 
function insert_log_excel($name,$date,$file_path,$id_load_user,$id_export_table)
 {  
    if ($examen=='0(n)'){$examen=0;}
    if ($ostatochna=='0(n)'){$ostatochna=0;}
  $this->sql_connect();
  $this->sql_query="INSERT INTO `testcenter`.`log_excel` (`name` ,`date` ,`file_path` ,`id_load_user` ,`id_export_table`
)VALUES ('".$name."', '".$date."', '".$file_path."', '".$id_load_user."', '".$id_export_table."') ";
  $this->sql_execute();
  $this->sql_close();
 } 
function update_excel($parameter) 
 {
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute(); 
  $this->sql_close();
 } 
}
?>