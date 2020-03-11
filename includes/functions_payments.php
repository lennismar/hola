<?php

/*
 * Función para crear un pago nuevo
 * paymentway: valor por defecto 'tarjeta' (2).
 *
 * devuelve el ID del pago si es que se ha creado el pago
 */

function createPayment($rescode, $paymentway = 2, $quantity = null, $description = null, $status = 0) {
    $debug = false;
    global $log;
    $db = MysqliDb::getInstance();

    if($debug) $log->loginfo('Entro en función de pago');

    $db->where ("rescode", $rescode);
    $reserva = $db->getOne ("reservations");
    $resid = $reserva['resid'];

    if(empty($quantity)) $quantity = $reserva['feeamount'];
    if(empty($description)) $description = 'Pago de anticipo de reserva '.$rescode;
    $customer_desc = trim($reserva['ofirstname'].' '.$reserva['olastname']);

    // Cancelo posibles pagos anteriores que estén pendientes para esta reserva
    $data3 = Array (
        'status' => 8
    );
    $db->where ('resid', $resid);
    $db->where('status', Array(8 , 9), 'NOT IN');
    $db->update ('payments', $data3);
    if($debug) echo "<br>Last executed query was ". $db->getLastQuery();

    // Inserto el registro con su información básica
    $data = Array (
        'id_type' => 1,
        'resid' => $resid,
        'id_transaction' => $rescode,
        'id_paymentway' => $paymentway,
        'status' => $status,
        'quantity' => $quantity,
        'description' => $description,
        'amount' => $quantity,
        'datetime' => date('Y-m-d H:i:s'),
        'create_time' => date('Y-m-d H:i:s'),
        'create_ip' => getUserIP()
    );
    if($debug) var_dump($data);
    $id = $db->insert ('payments', $data);

    if($debug) echo "<br>Last executed query was ". $db->getLastQuery();

    // Una vez creado el registro lo actualizo con el ID autonumérico para crear el id_transaction que se usará como número de pedido
    if ($id) {
        $id_transaction = date('Y').'-'.str_pad($id, 7, '0', STR_PAD_LEFT);
        $data2 = Array (
            'id_transaction' => $id_transaction
        );
        $db->where ('id', $id);
        $db->update ('payments', $data2);
        if($debug) echo "<br>Last executed query was ". $db->getLastQuery();
        $datos = array(
            'id' => $id,
            'order' => $id_transaction,
            'amount' => $quantity,
            'description' => $description,
            'customer_desc' => $customer_desc
        );
        return $datos;
    }
    else  return null;
}


/*
 * Función para procesar la información recibida del TPV para un pago existente
 * $tpvData: el json que llega codificado del banco en la llamada en background
 *
 * devuelve true o false en función de si se procesó bien o mal
 */


function updatePaymentTPV($tpvData)
{
    $debug = false;
    global $log;
    $db = MysqliDb::getInstance();

    $tpvData = json_decode($tpvData, true);

    if(empty($tpvData) || !is_array($tpvData)) return false;
    if(empty($tpvData['Ds_Order'])) return false;

    $db->where ("id_transaction", $tpvData['Ds_Order']);
    //$db->where('status', Array(8 , 9), 'NOT IN');
    $pago = $db->getOne ("payments");
    if($debug) $log->loginfo("<br>Last executed query was ". $db->getLastQuery());
    if ($db->count <= 0) return false;

    // Asumiendo que los datos recibidos están bien, vamos a componer e larray de update
    $status = 9; $error_code = '';
    $response = $tpvData['Ds_Response'];
    $securePayment = $tpvData['Ds_SecurePayment'];
    $commerce_id = $tpvData['Ds_MerchantCode'];
    $terminal = $tpvData['Ds_Terminal'];
    $authorisationCode = trim($tpvData['Ds_AuthorisationCode']);
    $fecha = explode('-', str_replace('/', '-', $tpvData['Ds_Date']));
    //if($debug) $log->loginfo('Fecha '.$tpvData['Ds_Date'].' explotada: '.var_export($fecha, true));
    $fecha_completa = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' '.$tpvData['Ds_Hour'];
    if($debug) $log->loginfo("<br>fecha de respuesta ". $fecha_completa);
    $response_datetime = $fecha_completa;

    /* Especifico status 5 para pagos en diferido aceptados, a la espera de hacerlos efectivos */
    if($tpvData['Ds_TransactionType']=='O') { $status = 5; }

    if($tpvData['Ds_Response']!='0000' || (!empty($tpvData['Ds_ErrorCode']) && $tpvData['Ds_ErrorCode'] != '')) { $status = 8; $error_code = $tpvData['Ds_ErrorCode'];}

    $data = Array (
        'status' => $status,
        'error_code' => $error_code,
        'response' => $response,
        'secure_payment' => $securePayment,
        'commerce_id' => $commerce_id,
        'terminal' => $terminal,
        'authorisation_code' => $authorisationCode,
        'response_datetime' => $response_datetime
    );
    if($debug) $log->loginfo('Datos para el update: '.var_export($data, true));

    $db->where ("id", $pago['id']);
    $db->update ('payments', $data);
    if($debug) $log->loginfo("<br>Last executed query was ". $db->getLastQuery());


    if($status == 9 || $status == 5) return true;
    else return false;



}
