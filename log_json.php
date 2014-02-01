<?php
	header('Content-type: text/json');

	class LogEntry 
	{
		public $Ip;
		public $Brand;
		public $Model;
		public $Os;
		public $Type;
		public $App;
		public $Network;
		public $Timestamp;
		public $Country;
		public $City;

		public static function fromString ($str)
		{
			$le = new LogEntry ();

			$w = explode (',', $str);
		
			$le->Type = $w[0];
			$le->Network = $w[1];
			$le->Ip = $w[2];
			$le->Timestamp = ((int) $w[3])/1000;
			$le->Country = $w[4];
			$le->City = $w[5];
			$le->Os = $w[6];
			$le->Brand = $w[7];
			$le->Model = $w[8];
			$le->App = str_replace (' ', '', str_replace ("\n", '', str_replace ("\r", '', $w[9])));

			return $le;
		}

		public function toString ()
		{
			//return ' { type: ''..'', type: ''..'', type: ''..'', type: ''..'', type: ''..'', type: ''..'', type: ''..'',
		}
	}

	$f = fopen ('log.txt', 'r');
	
	$log = array ();
	$apps = array ();
	$i = 0;
	$ti = 0;
	$au = 0;
	
	while (($line = fgets($f)) !== false) 
	{	
		$le = LogEntry::fromString ($line);

		if (strlen ($le->App) < 2) continue;

		$log[$i] = $le; 


		if (!array_key_exists ($le->App, $apps))
			$apps[$le->App] = array ('today' => array ('click' => 0, 'imp' => 0), 'click' => 0, 'imp' => 0,
						 'countries' => array (), 'active' => array ());

		$apps[$le->App][$le->Type]++;
		

		if (!array_key_exists ($le->Country, $apps[$le->App]['countries']))
			$apps[$le->App]['countries'][$le->Country] = 0;

		$apps[$le->App]['countries'][$le->Country]++;

		if (strtotime ('today') < ($le->Timestamp))
		{
			$apps[$le->App]['today'][$le->Type]++;
			$ti++;
		}


		$date_past = strtotime (date('o-m-d H:i:s',time() - 10 * 60));
		if (($le->Timestamp) >= $date_past)
		{
			if (!array_key_exists ($le->Ip, $apps[$le->App]['active']))
			{
				$apps[$le->App]['active'][$le->Ip] = 0;
				$au++;
			}

			$apps[$le->App]['active'][$le->Ip]++;
		}

		$i++;
    }


	echo '{ ';
	echo '"entries": "'.$i.'", ';
	echo '"entriesToday": "'.$ti.'", ';
	echo '"activeUsers": "'.$au.'", ';
	echo '"apps": [ ';
	$first = true;
	
	foreach ($apps as $k => $v)
	{
		if ($first)
			$first = false;
		else 
			echo ', ';

		echo '{ "name": "'.$k.'", "imp": "'.$v['imp'].'", "click": "'.$v['click'].'", "todayImp": "'.$v['today']['imp'].'", ';
		echo '"todayClick": "'.$v['today']['click'].'",  "activeUsers": "'.count ($v['active']).'" }';
	}

	echo ' ] ';
	echo '}';

/*
					foreach ($apps as $k => $v)
					{
						echo '<tr><td>'.$k.'</td><td>';
					
						foreach ($v['countries'] as $c => $cn)
							echo $c.' ('.$cn.'); ';
						echo '</td></tr>';
					}*/
?>

