<?
function navigate($title,$mas,$name)
{
echo "<br>".$title." <select style='width:800px;' class='".$name."' name='".$name."'>";
echo "<option value='0' selected='selected'>".$title."</option>";
    for ($i=0;$i<count($mas);$i++)
    {
	
	if ($_GET[$name]==$mas[$i][0]||$_POST[$name]==$mas[$i][0])
		{
		echo "<option value='".$mas[$i][0]."' selected='selected'>".substr(strip_tags($mas[$i][1]),0,120)."</option>";
		}
		else
		{
		echo "<option value='".$mas[$i][0]."'>".substr(strip_tags($mas[$i][1]),0,120)."</option>";
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
?>