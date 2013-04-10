<? 
$y=$_SESSION['mas'];
$ii=1;
for ($i=0;$i<count($y);$i++)
  {
  
  if ($_POST['id'.$i]==$i){
  $jj=0;
		for($j=0;$j<count($y[0]);$j++)
		{
		$x[$ii][$jj][0]=$y[$i][$j][0];	
		$jj++;
		}
	$ii++;}
  }
require_once "Spreadsheet/Excel/Writer.php";
$xls = new Spreadsheet_Excel_Writer();
$xls->_codepage = 0x04E3;
		$cart =& $xls->addWorksheet("Оцінки");
		$cart =& $xls->addWorksheet("Розкодування");
		$cart =& $xls->addWorksheet("Предмети");
		$myArr=array("№","Предмет","Модуль","№ модуля","№ предмета","Тест ліст");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,3);
			$cart->setColumn(0,1,40);
			$cart->setColumn(0,2,60);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,10);
			$cart->setColumn(0,5,10); 
	for ($i=1;$i<count($x)+1;$i++)
    {
			$myArr[$i]=array($i,iconv("utf-8", "windows-1251", $x[$i][0][0]),iconv("utf-8", "windows-1251", $x[$i][1][0]),$x[$i][2][0],$x[$i][3][0],$x[$i][6][0]);
		$cart->writeRow($i,0,$myArr[$i]);
    }		
		$cart =& $xls->addWorksheet("Поточна");
		$cart =& $xls->addWorksheet("Точність");
		$xls->send("Таблиця ".date('dS M Y').".xls");
		$xls->close();
?>