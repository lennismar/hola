<?php
include 'includes/config.php';
include 'includes/functions_bookings.php';
$debug = false;

$db->join("comments c", "r.rescode=c.comcode", "LEFT");
$db->where("c.cid", NULL, ' IS');   // Con esto consigo que salgan las reservas que NO tienen una reserva ya hecha
//$db->where("r.oemail", 'juanjo.nieto@gmail.com');   // Con esto consigo que salgan las reservas que se han pagado y disfrutado
$db->where("r.restid", 4);   // Con esto consigo que salgan las reservas que se han pagado y disfrutado
$db->where ('r.checkout < DATE_SUB(NOW(),INTERVAL 3 DAY)'); // Reservas que hace más de 3 días que salieron de la casa
$db->where ('r.checkout > DATE_SUB(NOW(),INTERVAL 5 MONTH)'); // Reservas que hace, como mucho, 5 meses que se produjeron
$db->orderBy("resid","asc");
$reservas = $db->get ("reservations r", 5, 'r.*');
if($debug) echo "Last executed query was ". $db->getLastQuery();
if($debug) echo '<br>Total: '.$db->count.'<br><pre>';

$_SESSION['type_user'] = 'automated';   // Para guardar los datos en el histórico de reservas asignados a este nombre

if ($db->count > 0) {
    foreach ($reservas as $reserva) {
        //if($debug) print_r($reserva);
        createComment($reserva['resid']);
        sendEmailComment($reserva['resid']); 
		if($debug) echo '<br>Enviada encuesta para reserva '.$reserva['rescode'];
		//exit();
    }
}

$log->loginfo("Generación de notificaciones para valoraciones de reservas. Enviadas: ".$db->count);

//if($debug) echo "Last executed query was ". $db->getLastQuery().' with '.$db->count.' results';