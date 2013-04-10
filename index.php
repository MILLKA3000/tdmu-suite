<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="testcenter/css/style.css" rel="stylesheet" type="text/css">
<link href="testcenter/css/vrStyle.css" rel="stylesheet" type="text/css" />
<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
<style>
        a {
            font-family: arial, verdana, serif;
			display:block;
			width:100px;
            font-size: 12pt;
            padding: 10px;
            color: #000000;
            font-weight: bold;
            background: #C1FFC1;
            vertical-align: middle;
            border-top: 1px solid #AEAF8A;
            border-left: 1px solid #AEAF8A;
            border-bottom: 1px solid #777777;
            border-right: 1px solid #777777;
        }
       
        a:hover {
            font-family: arial, verdana, serif;
			display:block;
			width:100px;
            font-size: 12pt;
            padding: 10px;
            color: #000000;
            font-weight: bold;
            background: #85A3C1;
            vertical-align: middle;
            border-top: 1px solid #AEAF8A;
            border-left: 1px solid #AEAF8A;
            border-bottom: 1px solid #777777;
            border-right: 1px solid #777777;
        }


</style>
<?php
echo "<center> <FONT size=6>Внутрішня система збору аналітики та статистики</FONT><br><br>
<b>   
 <div id='vrWrapper'>
        <form action='auth.php' method='post' id='form' style='display:none;'> <b>
<div class='loginBlock'><center><a href='testcenter/'>Статистика</a><br><a href='validnist/'>Валідність</a><br><a href='analitics/'>Аналітика</a><br><a href='vidomist/'>Відомості</a>
</div></div></td></tr></form></table>
</div>";

?>
 <script type="text/javascript">
            $().ready(
            function() {
                $('form').show(1000);
                
            }
            );
        
</script>
