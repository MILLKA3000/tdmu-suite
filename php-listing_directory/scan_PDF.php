<?php
$file = "http://intranet.tdmu.edu.ua/data/kafedra/internal/informatika/classes_stud/en/med/lik/ptn/Medical%20informatics/2/01-Safety measures.Medical informatics basics. Data transfering.pdf";
$file = "http://intranet.tdmu.edu.ua/data/kafedra/internal/informatika/classes_stud/en/med/lik/ptn/Medical%20informatics/2/01-Safety%20measures.Medical%20informatics%20basics.%20Data%20transfering.pdf";
function getNumPagesPdf($filepath){
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
    $max=0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);
    if($max==0){
        $im = new imagick($filepath);
        $max=$im->getNumberImages();
    }

    return $max;
}
echo "<font color=red>".$file."</font><br>";
echo getNumPagesPdf($file);
?>