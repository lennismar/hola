<?php 
include 'includes/config.php';
include ABS_BASE.'includes/functions_payments.php';
include ABS_BASE.'includes/functions_bookings.php';

$debug = true;
$log->setCookie(1);
$pago_exitoso = false;

// Datos de prueba
//$_POST = array();
//$_POST['Ds_SignatureVersion'] = 'HMAC_SHA256_V1';
//$_POST['Ds_MerchantParameters'] = 'eyJEc19EYXRlIjoiMDElMkYwMiUyRjIwMTkiLCJEc19Ib3VyIjoiMTQlM0ExOSIsIkRzX1NlY3VyZVBheW1lbnQiOiIxIiwiRHNfQ2FyZF9UeXBlIjoiRCIsIkRzX0NhcmRfQ291bnRyeSI6IjcyNCIsIkRzX0Ftb3VudCI6IjQ2MjUiLCJEc19DdXJyZW5jeSI6Ijk3OCIsIkRzX09yZGVyIjoiMjAxOS0wMDA2Mjc5IiwiRHNfTWVyY2hhbnRDb2RlIjoiMDYxOTU5NDA5IiwiRHNfVGVybWluYWwiOiIwMDEiLCJEc19SZXNwb25zZSI6IjAwMDAiLCJEc19NZXJjaGFudERhdGEiOiIiLCJEc19UcmFuc2FjdGlvblR5cGUiOiIwIiwiRHNfQ29uc3VtZXJMYW5ndWFnZSI6IjEiLCJEc19BdXRob3Jpc2F0aW9uQ29kZSI6IjA3MzI4MiIsIkRzX0NhcmRfQnJhbmQiOiIxIn0=';
//$_POST['Ds_Signature'] = 'iMVJpb4yOuHPWpi42dLWwLwBMcUNJQAbRH9gir7LoBU=';
// Fin de datos de prueba

if (!empty( $_POST ) ) {//URL DE RESP. ONLINE
    if($debug) $log->loginfo('Información del POST: '.var_export($_POST, true));
    include 'includes/apiRedsys.php';
    $miObj = new RedsysAPI;
    $version = $_POST["Ds_SignatureVersion"];
    $datos = $_POST["Ds_MerchantParameters"];
    $signatureRecibida = $_POST["Ds_Signature"];

    if($debug) $log->loginfo('Procesando parámetros encriptados');

    $decodec = $miObj->decodeMerchantParameters($datos);
    $kc = $config['tpv_palabra_secreta']; //Clave recuperada de CANALES
    $firma = $miObj->createMerchantSignatureNotif($kc,$datos);

    if ($firma === $signatureRecibida){
        //echo "FIRMA OK";
        if($debug) $log->loginfo('Firma correcta. Información del POST: '.var_export($decodec, true));
        $cobro = json_decode($decodec, true);

        if(updatePaymentTPV($decodec)) {$pago_exitoso = true; $log->loginfo('Pago actualizado correctamente para el cobro '.$cobro['Ds_Order']); }
        else $log->loginfo('Problema en la actualización del pago del cobro '.$cobro['Ds_Order']);
    } else {
        //echo "FIRMA KO";
        if($debug) $log->loginfo('Firma errónea. Ignorar llamada.');
    }
} else {
    //echo "FIRMA KO";
    if($debug) $log->loginfo('Sin datos por POST. Ignorar llamada.');
}

if($pago_exitoso) {
    $log->loginfo("Se procede a actualizar estado de reserva y envío de notificaciones");

    $resid=$_GET['resid'];

    $restid=4;
    if($cobro['Ds_TransactionType']=='O') { $restid = 6; } // Estado 'pago retenido' para reserva inmediata cuando se preautoriza el pago a espera de disponibilidad

    $email='yes';
    $response='';
    $db->where ("id_transaction", $cobro['Ds_Order']);
    //$db->where('id', $id_pago_realizado);
    $pago = $db->getOne ("payments");
    if($debug) $log->loginfo("<br>Last executed query was ". $db->getLastQuery());
    if ($db->count <= 0) {$log->loginfo("Reserva con id_transaction ".$cobro['Ds_Order']." no encontrada para actualizarla. "); exit();}
    $resid=$pago['resid'];

    // Recupero información de la reserva y de la casa
    $db->where ("resid", $resid);
    $reservation = $db->getOne ("reservations");
    $db->where ("resid", $resid);
    $db->orderBy("date","desc");
    $reservation_hist = $db->getOne ("reservations_history");
    if(!empty($reservation['eid'])) {
        $db->where ("eid", $reservation['eid']);
        $establiment = $db->getOne ("establiments");
        # Si la casa es de reserva inmediata, cambio el estado resultante del pago de 'confirmada' a 'pago retenido'
        # (también compruebo que el ultimo estado de la reserva no provenga de modificación hecha desde el admin, puesto que en ese caso, al pagar, ya va confiramda)
        if(!empty($establiment) && $establiment['reserva_inmediata'] == '1' && (empty($reservation_hist) || $reservation_hist['user'] == 'customer')) {
            $restid = 6;
            $log->loginfo("La reserva es de la casa ".$reservation['eid']." que tiene reserva inmediata, por lo que actualizamos el estado a ".$restid);
        }
    }


    if(updateReservation($restid, $resid, $email, $response)) $log->loginfo("Reserva ".$resid." actualizada correctamente al estado ".$restid);
    else $log->loginfo("Fallo al actualizar el estado (y notificar) la reserva ".$resid." ");


}
