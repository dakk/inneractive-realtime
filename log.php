<?php
	$f = fopen ('log.txt', 'a');

	//http://sagregna.it/advlog/log.php?type=click&ip=$ip$&timestamp=$timestamp$&networkName=$networkName$&country=$country$&city=$city$&os=$os$&appname=$appname$&age=$age$&model=$model$&brand=$brand$


	$string = ($_GET['type']).','.($_GET['networkName']).','.($_GET['ip']).','.($_GET['timestamp']).','.($_GET['country']).','.($_GET['city']).',';
	$string .= ($_GET['os']).','.($_GET['brand']).','.($_GET['model']).','.($_GET['appname'])."\n";

	fwrite ($f, $string);

	fclose ($f);
?>
