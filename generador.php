<?php 
include 'includes/config.php';
$debug = false;
require_once 'includes/iCal/ICal.php';
require_once 'includes/iCal/EventObject.php';

use ICal\ICal;
ob_end_flush();

echo '<html><head>
<meta charset="UTF-8">
</head><body><pre>';
echo "Actualización online de disponibilidad de casas... (".date($config_DB_datetime_format).")"."\r\n";
$db->orderBy("eid","asc");
$establecimientos = $db->get ("establiments", 2000);
if($debug) echo "Last executed query was ". $db->getLastQuery()."\r\n";
if($debug) echo '<br>Total: '.$db->count.'<br><pre>'."\r\n";
$log->loginfo("Establecimientos a los que se actualizará el calendario: ".$db->count);

echo '<table>';
if ($db->count > 0) {
    foreach ($establecimientos as $establecimiento) {
		echo '<tr>';
		if($establecimiento['eid'] == 126) $debug = true;
		
		echo '</tr>';
    }
}
echo '</table>';



?>
