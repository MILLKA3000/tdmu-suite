<?
 class class_mysql_base_moodle

{
  var $sql_login="moodle2cont";
  var $sql_passwd="kolobok";
  var $sql_database="moodle";
  var $sql_host="192.168.1.233";
  
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
//������� ������� �����
function select($parameter)
 {  $Row=array(array());
    $j=0;
  $this->sql_connect();
  $this->sql_query=$parameter;
  $this->sql_execute();
  while($Mas = mysql_fetch_row($this->sql_result))
	{
		for ($i=0;$i<count($Mas);$i++){
	   $Row[$j][$i] = $Mas[$i];   
	   }
     $j++;   
       
    }
	$this->sql_close();
  return $Row;
 }

}
?>