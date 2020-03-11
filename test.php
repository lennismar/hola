<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$subject = 'Prueba';
        $para = 'juanjo.nieto@gmail.com';
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";

        mail($para, $subject, 'Esto es un mensaje de prueba', $cabeceras);
		
		
		exit();
include 'includes/config.php';

$from = new DateTime('2017-01-01');
$to = new DateTime('2017-12-31');
$fechas = array();
for($date=clone $from; $date<$to; $date->modify('+1 day')){
			//echo $date->format('Y-m-d') . PHP_EOL . '<br>';
	array_push($fechas, $date->format('Y-m-d'));
}

$insert_sql = "";
$db->where ("date", '2016-11-11');
$casas = $db->get ("establiments_prices", null, array('eid', 'price'));
echo 'Numero de casas:'.$db->count.'<br/>';
if ($db->count > 0) {
	foreach ($casas as $casa) {
		$insert_sql .= '--- Insercion de fechas para el establecimiento '.$casa['eid']. PHP_EOL;
		$insert_sql .= ' INSERT INTO establiments_prices (eid, date, price, availability) VALUES '. PHP_EOL;
		$i = 0;
		$fechas_definidas_ = $db->rawQuery('SELECT distinct date from establiments_prices where eid = ? and date like ? order by date', Array ($casa['eid'], '2017-%'));
		$fechas_definidas = array();
		foreach ($fechas_definidas_ as $fecha_definida) {
			array_push($fechas_definidas, $fecha_definida['date']);
		}
		//print_r($fechas_definidas);
		$fechas_a_meter = array_diff ($fechas, $fechas_definidas);
		foreach($fechas_a_meter as $fecha) {
			if ($i != 0) {
				$insert_sql .= ', ';
			}

			$insert_sql .= "(".$casa['eid'].", '".$fecha."', ".$casa['price'].", 1)". PHP_EOL;
			$i++;
		}
		$insert_sql .= ';'. PHP_EOL;
	}
}

echo '<pre>'.$insert_sql;
?>