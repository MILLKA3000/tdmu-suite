<?
 class class_ibase

{
  var $sql_login="milenium";
  var $sql_passwd="1qaz2wsxcde3";
  var $sql_host="192.168.1.40:/var/data/CONTINGENT5.FDB";

  var $conn_id;
  var $sql_query;
  var $dbh;
  var $sql_result;


function sql_connect()
 {
  $this->dbh = ibase_connect ($this->sql_host, $this->sql_login, $this->sql_passwd);
 }

function sql_execute()
 {
    $param1 = 1;
    $this->sql_result=ibase_query ($this->sql_query, $this->dbh)or die("Помилка: " . mysql_error());
 }

function sql_close()
 {
  ibase_close ($this->$dbh);
 }
 function select_idstyd_tocontingent($student_id_contingent)
 {
    $this->sql_connect();
    $this->sql_query="SELECT * FROM STUDENTS WHERE STUDENTID=".$student_id_contingent.";";
    $this->sql_execute();
    $Row = ibase_fetch_assoc ($this->sql_result);
    //$this->sql_close();
    return $Row;
 }
     function butjetorkontrakt($ocinku_stud)
    {
            $kontr_butjet = array();
            $k=0;
            $b=0;
            for ($y=0;$y<count($ocinku_stud);$y++)
            {   
             $cont = $this->select_idstyd_tocontingent($ocinku_stud[$y]['student_id']); 
             if ($cont['EDUBASISID']=='К'){$k++;}
             if ($cont['EDUBASISID']=='Б'){$b++;}
            }
    $kontr_butjet[0]=$k;
    $kontr_butjet[1]=$b;
    return $kontr_butjet;
    }
 function select_faculty($id_faculty)
 {
    $this->sql_connect();
    $this->sql_query="SELECT * FROM GUIDE_DEPARTMENT WHERE DEPARTMENTID=".$id_faculty.";";
    $this->sql_execute();
    $Row = ibase_fetch_assoc ($this->sql_result);
    //$this->sql_close();
    return $Row;
 } 
 function select_speciality($id_speciality)
 {
    $this->sql_connect();
    $this->sql_query="SELECT * FROM GUIDE_SPECIALITY WHERE SPECIALITYID=".$id_speciality.";";
    $this->sql_execute();
    $Row = ibase_fetch_assoc ($this->sql_result);
    //$this->sql_close();
    return $Row;
 }  
 
  function select_module_discipline($id_discipline,$id_module,$faculty)
 {
    $modyle=array();    
    $this->sql_connect();
    $this->sql_query="SELECT * FROM GUIDE_DISCIPLINE WHERE DISCIPLINEID='".$id_discipline."';";
    $this->sql_execute();
    $Row = ibase_fetch_assoc ($this->sql_result);
    $modyle[0]=$Row['DISCIPLINE']; 
   
    $this->sql_connect();
    $this->sql_query="SELECT VARIANTID FROM B_VARIANT_ITEMS WHERE B_VARIANT_ITEMS.DISCIPLINEID='".$id_discipline."' AND B_VARIANT_ITEMS.SPECIALITYID='".$faculty."';";
    $this->sql_execute();
    $var = ibase_fetch_assoc ($this->sql_result);
    
    $this->sql_connect();
    $this->sql_query="SELECT MODULETHEME FROM B_VARIANT_ITEMS,B_VARIANT_MODULE WHERE  B_VARIANT_ITEMS.DISCIPLINEID='".$id_discipline."' AND B_VARIANT_ITEMS.PARENTVARIANTID='".$var['VARIANTID']."'    AND B_VARIANT_ITEMS.VARIANTID=B_VARIANT_MODULE.VARIANTID AND B_VARIANT_MODULE.MODULENUM='".$id_module."';";
    $this->sql_execute();
    $Row = ibase_fetch_assoc ($this->sql_result);
    $modyle[1]=$Row['MODULETHEME'];
    return $modyle;
 }  
 
 }
 
 /*$Row = ibase_fetch_assoc ($Q);
    ibase_free_result ($Q);*/
?>