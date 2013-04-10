<?php

include("php_file_tree.php");

?>

		<link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
		<script src="script/php_file_tree_jquery.js" type="text/javascript"></script>
	
		<?php
		echo php_file_tree("report", "[link]");
		//echo php_file_tree($_SERVER['DOCUMENT_ROOT'], "javascript:alert('You clicked on [link]');");
		?>
		
	