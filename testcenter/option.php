<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
 <script type="text/javascript" src="datepicker/jquery.tcollapse.js"></script>
<?PHP 
require("auth.php");
if (($_SESSION['login_name'])&&($_SESSION['role'] =="admin"))
{
    require("header.php");
    require("menu.php");
    require("class/class_firebird.php");
    require("class/mysql-class.php");
    
    $fac = new class_ibase();
    $test = new class_mysql_base();

    echo "<br><CENTER><h3>����� ������������</h3></CENTER>
    <form action='option.php' method='post' enctype='multipart/form-data' style='border: 1px solid blue;margin-top:20px;background-color:white;'>
     <div style='padding-left:50px;'>
     <b><h4>������ ����� ���������� ����</b></h4>
  
	г� ����� 
    <input size='5' name='date' value='".DATE("Y")."' />
	��� 
	<select name='name'>
    <option value='������'>������</option>
    <option value='˳���'>˳���</option>
	</select>
    
    <input type='submit' name='ok' value='��������'>
    </div><br>
    ";
     if($_POST['ok'])
    {
    $test->update_excel("INSERT INTO `testcenter`.`yearplan` (`name` ,`date`)VALUES ('".$_POST['name']."', '".$_POST['date']."');");
    echo "<FONT color='green'><b><center>������ ����������� ���������� ���� </b></center></FONT>";
    }   
    
    echo"<br></form>
       <form action='option.php' method='post' enctype='multipart/form-data' style='border: 1px solid blue;margin-top:20px;background-color:white;'>
     <div style='padding-left:50px;'>
     <b><h4>�������� �������</b></h4>
    ������� ��� ���� ������������ � ������ '�������' , �� ���� ���� ������ ���� ������������ ������,<br>
    ��� ���� ����������. ����� ���� ���� ������� � ��� ��������.<br><br>
	    
    ������� ���� <input type='file' name='filename'  value='�����'>
    <input type='submit' name='general' value='��������'>
    </div><br>
    ";
     if (isset($_FILES["filename"]["tmp_name"])) {
    if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
     move_uploaded_file($_FILES["filename"]["tmp_name"], "graf/index.html");
     $links = "graf/index.html";
     $test->update_excel("UPDATE testcenter.option SET `value` = '".$links."' WHERE `id`='2';");
     echo "<FONT color='green'><b><center>������ ��������� ������� ������� </b></center></FONT>";
   
    }
    echo"<br></form>";
}

include('footer.php');           
