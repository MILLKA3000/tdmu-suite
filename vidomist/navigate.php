<?
function navigate($title,$mas,$name)
{
echo "<br>".$title." <select class='".$name."' name='".$name."'>";
echo "<option value='0' selected='selected'>".$title."</option>";
    for ($i=0;$i<count($mas);$i++)
    {
	
	if ($_GET[$name]==$mas[$i][0]||$_POST[$name]==$mas[$i][0])
		{
		echo "<option value='".$mas[$i][0]."' selected='selected'>".substr(strip_tags($mas[$i][1]),0,80)."</option>";
		}
		else
		{
		echo "<option value='".$mas[$i][0]."'>".substr(strip_tags($mas[$i][1]),0,80)."</option>";
		}
 	}
echo "</select>";
}

function check($title,$mas,$name)
{	
	echo "<font color='red'><center>".$title."</center></font>";
	for ($i=0;$i<count($mas);$i++)
	{	
		if ($_POST[$name.$i]=="on"){
		echo"<input type='checkbox' class='".$name.$i."' name='".$name.$i."' CHECKED> ".$mas[$i][0]."<br>";}
		else{
		echo"<input type='checkbox' class='".$name.$i."' name='".$name.$i."'> ".$mas[$i][0]."<br>";}
	}
}

function table($title,$mas,$name)
{	echo "<table bgcolor='white' width=80%><tr><td><center>";	
	for ($i=0;$i<count($mas);$i++)
	{
	echo "<img class='t' name='".$name[$i]."' act='Y' src='images/down.gif'><font color=green><b>&nbsp;&nbsp;".$title[$i]." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>";
	}
	echo "</table><br>";
	for ($j1=0;$j1<count($mas);$j1++)
	{
	echo "<div id='".$name[$j1]."' tabl=d style='display:none;'>";
	echo "<table bgcolor=white width=90%>";
	for ($i=0;$i<count($mas[$j1]);$i++)
		{
		echo "<tr>";
		for($j=0;$j<count($mas[$j1][0]);$j++)
		{
			echo "<td><center>".$mas[$j1][$i][$j]."</td>";
		}
		echo "</tr>";
		}
	echo "</table></div>";
	}
}
?>