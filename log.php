<?php
	$f = fopen ('log.txt', 'a');

	$string = ($_GET['type']).','.($_GET['networkName']).','.($_GET['ip']).','.($_GET['timestamp']).','.($_GET['country']).','.($_GET['city']).',';
	$string .= ($_GET['os']).','.($_GET['brand']).','.($_GET['model']).','.($_GET['appname'])."\n";

	fwrite ($f, $string);

	fclose ($f);
?>
