<?
	function rus2translit($string)
{
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		 'і' => 'i',   'І' => 'I',  ' ' => '_',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
	
	function for_sql($sem_v) 
	{
		for ($i=0;$i<count($sem_v);$i++)
			{
				$sem_sql=$sem_sql.$sem_v[$i];
				if($sem_v[$i+1])$sem_sql=$sem_sql.", ";
			}
	return $sem_sql;
	}
	
	function js_str($s) {
	return '"'.addcslashes($s, "\0..\37\"\\").'"';
	}
	function js_array($array) {
	$temp=array();
	foreach ($array as $value)
		$temp[] = js_str($value);
	return '['.implode(',', $temp).']';
	}
	
	function course($sem){
	$course=0;
	switch ($sem)   {
    case 1:	case 2: $course=1; break;
    case 3: case 4: $course=2; break;
	case 5: case 6: $course=3; break;
	case 7: case 8: $course=4; break;
	case 9: case 10: $course=5; break;
	case 11: case 12: $course=6; break;
					}
	return $course;
	}
	
	function potochna($kont)
	{
	$pot=0;
	switch ($kont)   {
	case 66: $pot=4;break;
	case 69: $pot=4.5;break;
	case 72: $pot=5;break;
	case 75: $pot=5.5;break;
	case 78: $pot=6;break;
	case 81: $pot=6.5;break;
	case 84: $pot=7;break;
	case 87: $pot=7.5;break;
	case 90: $pot=8;break;
	case 93: $pot=8.5;break;
	case 96: $pot=9;break;
	case 99: $pot=9.5;break;
	case 102: $pot=10;break;
	case 105: $pot=10.5;break;
	case 108: $pot=11;break;
	case 111: $pot=11.5;break;
	case ($kont>112): $pot=12;
	case ($kont==''):$pot='';break;
					}
				
	return $pot;
	}
?>