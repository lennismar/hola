<?php
include 'includes/config.php';
$debug = false;
if (empty($_GET['eid']) || !(is_numeric($_GET['eid']))) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
	die();
}
$db -> where('eid =' . $_GET['eid']);
$db -> where("availability=0");
$db -> where("date >= CURDATE()");
$db -> orderBy("date", "ASC");
$cols = Array("availability", "date", "eid");
$query = $db -> get("establiments_prices", null, $cols);
if (!count($query) > 0) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
	die();
}
for ($r = 0; $r < count($query); $r++) {
	$dates[] = new DateTime($query[$r]['date']);
}
$ultimafecha = null;
$rangosArray = Array();
$rangoActual = Array();

foreach ($dates as $date) {
	if (null === $ultimafecha) {
		$rangoActual[] = $date;
	} else {
		$interval = $date -> diff($ultimafecha);
		if ($interval -> days === 1) {
			$rangoActual[] = $date;
		} else {
			$rangosArray[] = $rangoActual;
			$rangoActual = Array($date);
		}
	}
	$ultimafecha = $date;
}
$rangosArray[] = $rangoActual;
foreach ($rangosArray as $rango) {
	$fechaDeInicio = array_shift($rango);
	$fechaFinal = array_pop($rango);
	$miArreglo[] = Array("BEGIN" => $fechaDeInicio -> format('Y-m-d'), "END" => $fechaFinal -> format('Y-m-d'));
}

date_default_timezone_set('Europe/Madrid');
$url_completa = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
$vCalendar = new \Eluceo\iCal\Component\Calendar($url_completa);
for ($t = 0; $t < count($miArreglo); $t++) {
	$vEvent = new \Eluceo\iCal\Component\Event();
	$vEvent -> setDtStart(new \DateTime($miArreglo[$t]['BEGIN']));
	$vEvent -> setDtEnd(new \DateTime($miArreglo[$t]['END']));
	$vEvent -> setNoTime(true);
	$vEvent -> setUseTimezone(true);
	$vCalendar -> addComponent($vEvent);
}
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="somrurals-' . $_GET['eid'] . '-' . $miArreglo[0]['BEGIN'] . '.ics"');
echo $vCalendar -> render();
?>