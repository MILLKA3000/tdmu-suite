<?php

require_once("XLSReader.class.php");

class XLSToDB {
	
	private  $data;
	
	private  $variant=1;	
	public  $predmet=1;		
	private  $filename;			
	
	private  $group03=0;	
	private  $group46=0;	
	private  $group79=0;	
	private  $group1012=0;				
	
	private  $stud;
	private  $mark;
	
	private  $marks;
	
	private  $uploaddir = "file/";	
	private  $valueArray;
	
    //зміна властивостей класу
    //$key - назва властивості, $value - значення
    function setOption($key, $value = null)
    {
        switch ($key) {
            case 'variant':
                $this->variant = $value;
                break;
            case 'predmet':
                $this->predmet = $value;
                break;
            case 'mark':
                $this->marks = $value;
                break;
            case 'filename':
                $this->filename = $value;                
        }
    }
    
	//конструктор, створює дескриптор на відповідний файл
	//$fileName - імя цього файла
	function XLSToDB($fileName, $encoding){
		$this->data = new Spreadsheet_Excel_Reader();
		$this->data->setOutputEncoding($encoding);
		
	}
	

	function summGparh($value){
		
		if($value<4){
			$this->group03++;
		}
		
		if($value>=4 and $value<7){
			$this->group46++;
		}
		
		if($value>=7 and $value<10){
			$this->group79++;
		}

		if($value>10){
			$this->group1012++;
		}
	}
	

	
	function AddFile($newsPicTmpName){

		$newName=time().".xls";
		
		if (move_uploaded_file($newsPicTmpName, $this->uploaddir.$newName)) {
  			return $newName;

		} else {
			return 'error';
		}
	}
	
	
	
	function fileToMasAll($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 8;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 28)
					{
						$poleStart = $poleStart + 25;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];

						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						$num++;
					}

				}
			}
		}
		return $myArray;
	}	


	function fileToMasAll288($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 3;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 76)
					{
						$poleStart = $poleStart + 73;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];

						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						$num++;
					}

				}
			}
		}
		return $myArray;
	}	

	function fileToMasAll24($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 8;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 28)
					{
						$poleStart = $poleStart + 25;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];
						

						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						//echo $stuid . "=" . $predmet  . "=" . $num . "=" . $myArray[$stuid][$predmet]['question'][$num] . "<br />";
						$num++;
						$this->setOption('predmet', $predmet);
					}

				}
			}
		}
		return $myArray;
	}

	function fileToMasAll48($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 8;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 52)
					{
						$poleStart = $poleStart + 49;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];
						

						$predmet++;
						
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						//echo $stuid . "=" . $predmet  . "=" . $num . "=" . $myArray[$stuid][$predmet]['question'][$num] . "<br />";
						$num++;
						$this->setOption('predmet', $predmet);
						
					}

				}
			}
		}
		return $myArray;
	}

	function fileToMasAll72($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 3;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 76)
					{
						$poleStart = $poleStart + 73;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];
						

						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						//echo $stuid . "=" . $predmet  . "=" . $num . "=" . $myArray[$stuid][$predmet]['question'][$num] . "<br />";
						$num++;
						$this->setOption('predmet', $predmet);
					}

				}
			}
		}
		return $myArray;
	}

	function fileToMasAll144($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 2;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 148)
					{
						$poleStart = $poleStart + 145;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];
						

						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						//echo $stuid . "=" . $predmet  . "=" . $num . "=" . $myArray[$stuid][$predmet]['question'][$num] . "<br />";
						$num++;
					}

				}
			}
		}
		return $myArray;
	}

	function getVariants($xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) 
		{
			$myArray[$this->data->sheets[0]['cells'][$i][2]] = $this->data->sheets[0]['cells'][$i][3];
		}

		return $myArray;
	}	
	function fileToMasAll96($variant, $xlsfile){
		$dir = "file/" . $xlsfile;
		$this->data->read($dir);
		
		$myArray = array();

		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
			if($this->data->sheets[0]['cells'][$i][2]==$variant){

				$poleStart = 0;
				$poleFinish = 178;

				$storinka = $this->data->sheets[0]['cells'][$i][1];

				if($storinka == 2)
				{
					$predmet = 2;
				}
				if($storinka == 3)
				{
					$predmet = 3;
				}
				else
				{
					$predmet = 1;
				}

				$stuid = $this->data->sheets[0]['cells'][$i][3];

				$num = 1;

				for ($j = 4; $j <= $poleFinish; $j++) {

					if(($j - $poleStart) == 100)
					{
						$poleStart = $poleStart + 97;

						$myArray[$stuid][$predmet]['mark'] = $this->data->sheets[0]['cells'][$i][$j];


						$predmet++;
						$num=1;
					}
					else
					{
						$myArray[$stuid][$predmet]['question'][$num] = $this->data->sheets[0]['cells'][$i][$j];
						$num++;
					}

				}
			}
		}
		return $myArray;
	}
}


?>