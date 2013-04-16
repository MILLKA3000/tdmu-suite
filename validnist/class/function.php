<? 
	function js_str($s) {
	//return '"'.addcslashes($s, "\0..\37\"\\").'"';
		return $s;
	}
	function js_array($array) {
	$temp=array();
	foreach ($array as $value)
		$temp[] = js_str($value);
	return '['.implode(',', $temp).']';
	}
	function cleanDir($dir) {
    $files = glob($dir."/*");
    $c = count($files);
    if (count($files) > 0) {
        foreach ($files as $file) {      
            if (@fopen($file, "w")) {
            unlink($file);
            }   
        }
    }
	}
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
function table($title,$mas,$name,$name_title_table)
{	echo "<table bgcolor='white' width=80%><tr><td><center>";	
	for ($i=0;$i<count($mas);$i++)
	{
	echo "<img class='t' name='".$name[$i]."' act='Y' src='images/down.gif'><font color=green><b>&nbsp;&nbsp;".$title[$i]." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>";
	}
	echo "</table><br>";
	for ($j1=0;$j1<count($mas);$j1++)
	{
	echo "<div id='".$name[$j1]."' tabl=d style='display:none;'>";
	echo "<table bgcolor=white width=90%><tr bgcolor='grey'>";
		for($t1=0;$t1<count($name_title_table[$j1]);$t1++)
		{
			echo "<td><center>".$name_title_table[$j1][$t1]."</td>";
		}
		echo "</tr>";
	for ($i=0;$i<count($mas[$j1]);$i++)
		{
		echo "<tr>";
		for($j=0;$j<count($mas[$j1][0]);$j++)
		{
			echo "<td><a href='?variant=".$mas[$j1][$i][0]."&type=".$mas[$j1][$i][6]."' style='color:black;font-size:9pt;'><b><center>".$mas[$j1][$i][$j]."</a></td>";
		}
		echo "</tr>";
		}
	echo "</table></div>";
	}
}
?>