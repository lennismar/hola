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
$db->where ("published", '1');
$db->where ("external_ical", NULL, ' IS NOT ');
$db->where ("external_ical <> ''");
$db->orderBy("eid","asc");
$establecimientos = $db->get ("establiments", 400, 'eid, title, external_ical');
if($debug) echo "Last executed query was ". $db->getLastQuery()."\r\n";
if($debug) echo '<br>Total: '.$db->count.'<br><pre>'."\r\n";
$log->loginfo("Establecimientos a los que se actualizará el calendario: ".$db->count);


if ($db->count > 0) {
    foreach ($establecimientos as $establecimiento) {
		if($establecimiento['eid'] == 126) $debug = true;
		else $debug = false;
        echo "Actualización la casa ".$establecimiento['title']." (id ".$establecimiento['eid'].")"."\r\n";
		$log->loginfo("Actualización la casa ".$establecimiento['title']." (id ".$establecimiento['eid'].")");

        if($debug) print_r($establecimiento);

        /*$ical_url = $establecimiento['external_ical'];
        $ctx = stream_context_create(array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko')
            )
        );
        $ical = file_get_contents($ical_url,false,$ctx);
        echo '<pre>'.$ical.'</pre>';*/

        $ical = new ICal();
        $ical->initURL($establecimiento['external_ical']);
        $events = $ical->events();
        if(count($events) > 0) {
            $sql_update = "UPDATE establiments_prices set availability = '1', managed_online = 0 where eid = '".$establecimiento['eid']."' and managed_online = 1";
            if($debug) echo '<br>'.$sql_update."\r\n";
            $db->rawQuery($sql_update);


            $fechas_a_bloquear = array();
            foreach($events as $event) {
                $fechas_a_bloquear_tmp = array();
                $strDateFrom = $event->dtstart;
                $strDateTo = $event->dtend;

                $iDateFrom=mktime(1,0,0,substr($strDateFrom,4,2),     substr($strDateFrom,6,2),substr($strDateFrom,0,4));
                $iDateTo=mktime(1,0,0,substr($strDateTo,4,2),     substr($strDateTo,6,2),substr($strDateTo,0,4));

                if ($iDateTo>=$iDateFrom)
                {
                    array_push($fechas_a_bloquear_tmp,date($config_DB_date_format,$iDateFrom)); // first entry
                    while ($iDateFrom<$iDateTo)
                    {
                        $iDateFrom+=86400; // add 24 hours
                        array_push($fechas_a_bloquear_tmp,date($config_DB_date_format,$iDateFrom));
                    }

                    // Con esta línea quitamos la última fecha del array, si consideramos que la ultima fecha es la de salida y no debe estar ocupada
                    //array_pop($fechas_a_bloquear_tmp);
                    if(count($fechas_a_bloquear_tmp) > 1) array_pop($fechas_a_bloquear_tmp);
                }

                $fechas_a_bloquear = array_merge($fechas_a_bloquear, $fechas_a_bloquear_tmp);
                if($debug) echo '<br>Fechas entre '.$strDateFrom.' y '.$strDateTo.'<br>'."\r\n";
                if($debug) print_r($fechas_a_bloquear_tmp);

            }

            //print_r($fechas_a_bloquear);

            $sql_update = "UPDATE establiments_prices set availability = '0', managed_online = 1 where eid = '".$establecimiento['eid']."' and availability = '1' and date IN ('".join("', '", $fechas_a_bloquear)."')";
            if($debug) echo '<br>'.$sql_update."\r\n";
            $db->rawQuery($sql_update);
        } else echo "La casa ".$establecimiento['title']." (id ".$establecimiento['eid'].") o no tiene datos o ha fallado la carga del fichero."."\r\n";


        //echo '<pre>'; print_r($events);
        unset($ical); unset($events);
        //cancelReservation($reserva['resid'], 'yes', true);
        //createComment($reserva['resid']);
        //sendEmailComment($reserva['resid']);
        //if($debug) echo '<br>Enviada encuesta para reserva '.$reserva['rescode'];
        //exit();
    }
}

$log->loginfo("Finalizada la actualización de calendarios ");


?>
