<?php
include 'includes/config.php';
include 'includes/functions_bookings.php';
$debug = true;

//$db->where("r.oemail", 'juanjo.nieto@gmail.com');   // Con esto consigo que salgan las reservas que se han pagado y disfrutado
$db->where("restid", 7);   // Con esto consigo que salgan las reservas inmediatas pendientes de pagarse
$db->where ('resdate  < DATE_SUB(NOW(),INTERVAL 10 MINUTE)'); // Reservas que hace más de 10 Minutos que se lanzaron a pagar y son de reserva inmediata
$db->orderBy("resid","asc");
$reservas = $db->get ("reservations", 5, '*');
if($debug) echo "Last executed query was ". $db->getLastQuery();
if($debug) echo '<br>Total: '.$db->count.'<br><pre>';
$log->loginfo("Reservas inmediatas canceladas por impago: ".$db->count);

$_SESSION['type_user'] = 'automated';   // Para guardar los datos en el histórico de reservas asignados a este nombre

if ($db->count > 0) {
    foreach ($reservas as $reserva) {
        if($debug) print_r($reserva);
        cancelReservation($reserva['resid'], 'yes', true);
        //createComment($reserva['resid']);
        //sendEmailComment($reserva['resid']);
		//if($debug) echo '<br>Enviada encuesta para reserva '.$reserva['rescode'];
		//exit();
    }
}

//$log->loginfo("Generación de notificaciones para valoraciones de reservas. Enviadas: ".$db->count);

//if($debug) echo "Last executed query was ". $db->getLastQuery().' with '.$db->count.' results';