<HEAD><TITLE>Валідність тестових завдань</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=windows-1251">
 <script type="text/javascript" src="script/jquery.js"></script> 
 <script src="http://code.jquery.com/jquery-latest.js"></script>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 
 <link rel="stylesheet" href="css/style.css" type="text/css">

 <?php
 include "class/function.php";
 include "class/mysql-class.php";
 $base = new class_mysql_base();
 include "menu.php";
 if ($_GET['variant']){$_POST['variant']=$_GET['variant'];$_POST['predmet']=1;}
echo "<center><form action='variant.php' method='POST' enctype='multipart/form-data'>
 <table width=90% style='border: 1px solid blue;margin-top:20px;background-color:white;'><tr><td>
 </td><td><center><h2><p><b>Введіть варіант та предмет </b></p></h2></center>
<b>Варіант <input type='text' name='variant' value='".$_POST['variant']."'> <b>Предмет </b><input type='text' name='predmet'  value='".$_POST['predmet']."'>
 <input type='submit' value='Вибір'><br></table></form>"; 

if (($_POST['variant']!='') && ($_POST['predmet'])!=''){ 

 $question=$base->select_question($_POST['variant'],$_POST['predmet']);
 }
//print_r($question);
 
$suma = array();
if ($question!=NULL){
echo "<table bgcolor=white border=1><tr><td>№ Питання</td><td>Питання по групам</td><td>Графік</td><td>Складність <br> питання</td><td>Дискримінативність <br> питання</td><td>Показник</td>";
}else{echo"<table bgcolor=white border=1>";}
for ($j=0;$j<count($question);$j++){


	$suma[0]=$question[$j]['gr1'];
	$suma[1]=$question[$j]['gr2'];
	$suma[2]=$question[$j]['gr3'];
	$suma[3]=$question[$j]['gr4'];
	$suma[4]=$question[$j]['gr5'];
echo "<tr><td>Питання ".($j+1)."</td><td> [".$suma[0]."%] [".$suma[1]."%] [".$suma[2]."%] [".$suma[3]."%] [".$suma[4]."%] </td><td>";	
	
	echo "
	<style>
	#chart_div".$j."{
    width:100px;
    height:70px;
    	}
	</style>
	
	<script type='text/javascript'>
	
	google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart".$j.");
      function drawChart".$j."() {
		
        var data".$j." = new google.visualization.DataTable();
        data".$j.".addColumn('string', 'Валідність');
        data".$j.".addColumn('number', 'Невалідні питання');
		for (var i=0;i<mas".$j.".length;i++){
		data".$j.".addRows([[String(i+1), parseFloat(mas".$j."[i])]]);
		}	
         var options = {legend: 'none',title: 'Загальний вигляд %',vAxis:{maxValue:100,minValue:0}, hAxis: { title: 'Групи', titleTextStyle: {color: 'green'} }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div".$j."'));
        chart.draw(data".$j.", options);
      }
	  var pos=1;</script>
	 ";
	 echo "<div id='chart_div".$j."'></div></td><td>".round((($question[$j]['check'])/($question[$j]['sumstyd'])),2)."</td><td>".$question[$j]['discrit']."</td>";
	 
	 if($question[$j]['validn']!=""){echo"<td bgcolor=yellow>".$question[$j]['validn'];}else{echo"<td> ";}echo"</td>";
	 echo "<script type='text/javascript'>
	 
	$('#chart_div".$j."').on('mousedown', function(e){
	
	   if ( pos == 1) 
			{			
		$(this).css({
	    width:'400px',
        height:'300px' 
		});
		drawChart".$j."();	
pos=2;		
			}		
			else 			
			{				
		$(this).css({
	    width:'100px',
        height:'70px' 
		});
		drawChart".$j."();	
pos=1;		
			}

		})
		
	  var mas".$j." = ".js_array($suma).";
	  </script>";
	  

 }
 
 ?>
 </table></td><td width=200px valign='top'>
<?
include ("wood_script.php");
?>