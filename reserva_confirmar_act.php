<?php
include 'includes/config.php';

// Guardamos los datos del formulario POST en variables
$persons = $_POST['persons'];
$adultos = $_POST['adultos'];
$ninos = $_POST['ninos'];
$bebes = $_POST['bebes'];
$datein = ($_POST['datein']);
$dateout = ($_POST['dateout']);
$tipo = $_POST['tipo'];
$eid = $_POST['eid'];
$total = $_POST['total'];
$anticipado = $_POST['anticipado'];
$restante = $_POST['restante'];
$nombre = htmlspecialchars($_POST['nombre']);
$apellidos = htmlspecialchars($_POST['apellidos']);
$telefono = $_POST['telefono'];
$poblacion = $_POST['poblacion'];
$email = $_POST['email'];
$pais = htmlspecialchars($_POST['pais']);
$language = $_POST['language'];
$comentarios = htmlspecialchars($_POST['comentarios']);
$pago = $_POST['pago'];
$numdays = DateDiff(date("d-m-Y",$datein), date("d-m-Y",$dateout));
$newsletter=0;
/* Control de reserva inmediata */

// Parámetro que proviene del formulario de confirmación de reserva cuando es una finca con reserva inmediata
$reserva_inmediata_post = $_POST['reserva_inmediata'];
$db->where('eid',$eid);
$rs=$db->getOne('establiments',"reserva_inmediata");
// Variable que indica que la reserva inmediata está habilitada para ese establecimiento
$reserva_inmediata_enabled = false;

$reserva= $rs['reserva_inmediata'];
if($reserva_inmediata && $reserva_inmediata_post == '1' && $reserva == '1') { $reserva_inmediata_enabled = true;  }
if ($_POST['newsletter']=='on') $newsletter=1;


// Calculamos el código de reserva
$codeok = 0;
$rescode = RandomChars(4)."-".RandomNums(4)."-".RandomNums(4); // Ej: FTJH-8347-2345
while ($codeok == 0) { // Verificamos que el código sea único
	//$query = mysqli_query("SELECT rescode FROM reservations WHERE rescode = '".$rescode."'");
	$db->where('rescode',$rescode);
	$query=$db->get('reservations',null,'rescode');
	//if($rs = mysqli_fetch_array($query)){
	if($db->count >0){
		$rescode = RandomChars(4)."-".RandomNums(4)."-".RandomNums(4);
	}
    else {
		$codeok = 1;
	}
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------- ALTA RESERVA -> Insertamos los datos en la tabla de la reserva (reservations) -------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


$data=Array(
	'eid'=>$eid,
	'resdate'=>date("Y-m-d H:i:s"),
	'checkin'=>date("Y-m-d",$datein),
	'checkout'=>date("Y-m-d",$dateout),
	'numdays'=>$numdays,
	'persons'=>$persons,
	'adults'=>$adultos,
	'children'=>$ninos,
	'babies'=>$bebes,
	'totalprice'=>$total,
	'feeamount'=>$anticipado,
	'restid'=>1,
	'ofirstname'=>$nombre,
	'olastname'=>$apellidos,
	'ocity'=>$poblacion,
	'ophone'=>$telefono,
	'oemail'=>$email,
	'iva'=>$IVA,
	'ocomments'=>$comentarios,
	'ocountry'=>$pais,
	'olanguage'=>$language,
	'ipaddress'=>$_SERVER['REMOTE_ADDR'],
	'rescode'=>$rescode,
	'paid'=>0,
	'pid'=>$pago,
	'newsletter'=>$newsletter,
	'iid'=>$tipo
);
if($reserva_inmediata_enabled) $data['restid'] = 7;
$resid=$db->insert('reservations',$data);
if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------- ALTA ITEMS -> Insertamos los "items" (room o casa) en la tabla "reserveditems" ------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if ($tipo==1) { // -------------------------------------- Si la reserva es de HABITACIONES -------------------------------------------
	$rooms = $_POST['rooms'];
	$rooms = array_count_values($rooms);

	// Damos de alta las reservas de la diferentes habitaciones en la tabla "reserveditems"
	foreach ($rooms as $room => $quantity) {

		// Calculo del precio total de la habitacion durante el intervalo de fechas
		$date = $datein;
		$price = 0;
		while ($date < $dateout) { // Recorrido del intervalo de fechas
			/*$SQL  = "SELECT rid, price ";
			$SQL .= "FROM rooms_prices ";
			$SQL .= "WHERE rid = ".$room." ";
			$SQL .= "AND date = '".date("Y-m-d", $date)."'";
			$query = mysql_query($SQL);*/
			$db->where('rid',$room);
			$db->where('date',date("Y-m-d", $date));
			$rs=$db->getOne('rooms_prices',null,'rid, price');

			//if($rs = mysql_fetch_array($query)){
			if($db->count > 0){
				$price = $price + $rs['price'];
			}

			$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
		}

		/*$SQL = "INSERT INTO reserveditems (resid, iid, rid, sdate, edate, quantity, price) VALUES(";
		$SQL .= $resid . ", ";
		$SQL .= "1, "; // 1 = id "item" room
		$SQL .= $room . ", ";
		$SQL .= "'" . date("Y-m-d",$datein) . "', ";
		$SQL .= "'" . date("Y-m-d",$dateout) . "', ";
		$SQL .= $quantity . ", ";
		$SQL .= $price . ")";

		mysql_query($SQL);*/
		$data=Array(
			'resid'=>$resid,
			'iid'=>1,
			'rid'=>$room,
			'sdate'=>date("Y-m-d",$datein),
			'edate'=>date("Y-m-d",$dateout),
			'quantity'=>$quantity,
			'price'=>$price
		);
		$db->insert('reserveditems',$data);
		if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
	}

}
else if ($tipo==2){ // Si la reserva es de la casa entera

	/*$SQL = "INSERT INTO reserveditems (resid, iid, rid, sdate, edate, quantity, price) VALUES(";
	$SQL .= $resid . ", ";
	$SQL .= "2, "; // 2 = id "item" casa
	$SQL .= "0, "; // 0 = no es una habitacion
	$SQL .= "'" . date("Y-m-d",$datein) . "', ";
	$SQL .= "'" . date("Y-m-d",$dateout) . "', ";
	$SQL .= "1, ";
	$SQL .= $total . ")";

	mysql_query($SQL);*/
	$data=Array(
		'resid'=>$resid,
		'iid'=>2,
		'rid'=>0,
		'sdate'=>date("Y-m-d",$datein),
		'edate'=>date("Y-m-d",$dateout),
		'quantity'=>1,
		'price'=>$total
	);
	$db->insert('reserveditems',$data);
	if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------- ACTUALIZACION DE LA DISPONIBILIDAD----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if ($tipo==1) { // -------------------------------------- Si la reserva es de HABITACIONES -------------------------------------------
	$rooms = $_POST['rooms'];
	$rooms = array_count_values($rooms);

	// Actualizamos la disponibilidad de la diferentes habitaciones seleccionadas
	foreach ($rooms as $room => $quantity) {
		$date = $datein;
		while ($date < $dateout) { // Recorrido del intervalo de fechas
			/*$SQL =  "UPDATE rooms_prices SET ";
			$SQL .= "availability = availability - " . $quantity . " ";
			$SQL .= "WHERE rid = " . $room . " ";
			$SQL .= "AND eid = ".$eid." ";
			$SQL .= "AND date = '".date("Y-m-d", $date)."'";
			mysql_query($SQL);*/
			$data=Array('availability'=>"availability - " . $quantity . "");
			$db->where('rid',$room);
			$db->where('eid',$eid);
			$db->where('date',date("Y-m-d", $date));
			$db->update('rooms_prices',$data);
			if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
			$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
		}
	}

}
else if ($tipo==2){ // --------------------------------- Si la reserva es de la CASA ENTERA -------------------------------------------

	// Quitamos la disponibilidad de todas las habitaciones
	$date = $datein;
	while ($date < $dateout) { // Recorrido del intervalo de fechas
		/*$SQL =  "UPDATE rooms_prices SET ";
		$SQL .= "availability = 0 ";
		$SQL .= "WHERE eid = ".$eid." ";
		$SQL .= "AND date = '".date("Y-m-d", $date)."'";
		mysql_query($SQL);*/
		$data=Array('availability'=>0);
		$db->where('eid',$eid);
		$db->where('date',date("Y-m-d", $date));
		$db->update('rooms_prices',$data);
		if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
		$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
	}

	// Quitamos la disponibilidad de la casa entera
	$date = $datein;
	while ($date < $dateout) { // Recorrido del intervalo de fechas
		/*$SQL =  "UPDATE establiments_prices SET ";
		$SQL .= "availability = 0 ";
		$SQL .= "WHERE eid = ".$eid." ";
		$SQL .= "AND date = '".date("Y-m-d", $date)."'";
		mysql_query($SQL);*/
		$data=Array('availability'=>0);
		$db->where('eid',$eid);
		$db->where('date',date("Y-m-d", $date));
		$db->update('establiments_prices',$data);
		if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
		$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
	}

}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------ ENVIO DEL EMAIL AL ESTABLECIMIENTO ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if($reserva_inmediata_enabled) {
	$body = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="initial-scale=1.0"/>
<meta name="format-detection" content="telephone=no"/>
<title>Somrurals</title>
<style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff;}
.ExternalClass {width: 100%; background-color: #ffffff;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
html{width: 100%; }
body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
body {margin:0; padding:0;}
table {border-spacing:0;}
img{display:block !important;}
table td {border-collapse:collapse;}
.yshortcuts a {border-bottom: none !important;}

@media only screen and (max-width: 600px){
  body{width:auto!important;}
  table[class="container"]{ width: 100%!important;padding-left: 0px!important; padding-right: 0px!important;}

}
@media only screen and (max-width: 479px){
   table[class="container2"]{ width:100%!important; float:none !important;}
   .pad-min {padding:10px 10px !important;}
   .clear-mobile {display:none;!important}
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td align="center" valign="top" bgcolor="#f1f1Ef">
  	<!-- Contenido -->
    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container" itemscope itemtype="http://schema.org/LodgingReservation" itemref="_underName6 _numAdults13">

    	<tbody>
        <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
      <tr>
        <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="http://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">
            <strong style="font-size:24px; line-height:30px">Solicitud de la reserva</strong>

            <br/><br/>

            Un client ha realitzat una reserva immediata al seu establiment. En breu ens posarem en contacte amb vostè per confirmar la disponibilitat.<br/><br/>

           <table width="100%" cellspacing="0" cellpadding="0">

           	<tbody>
            <tr>
                <td style="border:1px #E7E7E5 solid;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                              <tr>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">Entrada:</strong><br/>'.date("d-m-Y",$datein).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">Salida:</strong><br/>'.date("d-m-Y",$dateout).'</td>
                              </tr>
                       </tbody>
                       </table>
                	</td>
                </tr>
                <tr>
                	<td height="15"></td>
                </tr>
                 <tr>
                	<td style="border:1px #E7E7E5 solid;">

                   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Adultos:</strong> <span itemprop="numAdults">'.$adultos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Niños:</strong> <span itemprop="numChildren">'.$ninos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Bebes: </strong> '.$bebes.'</td>
                              </tr>
                       </tbody>
                       </table>

                    </td>
                </tr>
                 <tr>
                	<td height="15"></td>
                </tr>
            	<tr>
            	<td>
                 <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
               		<span>
					<tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777;">

							<span itemprop="reservationFor" itemscope itemtype="http://schema.org/LodgingBusiness" itemref="_image3">
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query('establiments', 'title', 'eid', $eid).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $eid)).'</span> ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $eid)).')</span>
                   		  </span><br/>
                   		  <strong itemprop="lodgingUnitDescription" style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                        <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">Referencia: SR-'.$eid.'</td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Total</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="price">'.$total.' &euro;</strong></td>
                      </tr></span>
                      <tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Anticipado</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$anticipado.' &euro;</strong></td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Restante</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$restante.' &euro;</strong></td>
                      </tr>
                </table>
            	</td>
            </tr>
            </tbody>
            </table><br/><br>


			<br><br>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FEF5E3">
                  <tbody><tr>
                    <td style="border: 1px #F9B636 solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #232323; display: block; padding:7px 10px;font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#232323; text-align:center">También puede informar de la disponibilidad<br><strong>respondiendo a este email</strong><br>o en el teléfono 93 293 55 27</td>
                  </tr>
            </tbody></table>

            <br/>
            Les dades complertes del client seran facilitades en el moment que aquest realitzi el pagament anticipat, confirmant la reserva.<br>
			<br>
			El import restant de la reserva es pagarà directament a l\'establiment, de la manera especificada en la web.<br><br>
            Les factures y transferències corresponents al pagament anticipat (si aquest es superior al 15%), es farà efectiva a primers de cada mes desprès de la data de sortida del client.<br><br>
            Moltes gràcies,</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: 93 293 55 27</td>
      </tr>
      <tr>
        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
              <tbody><tr>
                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="http://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                </tr>
              <tr>
                <td><a href="https://www.facebook.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://www.facebook.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://plus.google.com/117022694086662550685"><img src="http://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
              </tr>
            </tbody></table>
       </td>
      </tr>
      <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
    </tbody>
    </table>
     <!-- / Contenido  -->
    </td>
  </tr>
 </tbody>
</table>

</body></html>
';
	//$email_establiment = Query('establiments', 'email', 'eid', $eid); // para producción
	$email_establiment = implode(', ', $email_bcc_address);	// Para demo
	//$subject = "Som Rurals - Confirmació de disponibilitat";
	$subject = $email_subject_prefix."Som Rurals - Reserva inmediata";
	$para = $email_establiment;

	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
    $bcc = array();
    if ($allow_email_bcc == true && !empty($email_bcc_address)) {
        $cabeceras .= 'Bcc: '.implode(', ', $email_bcc_address).''."\r\n";
        $bcc = array_merge ($bcc, $email_bcc_address);
    }

    transactional_mail($para, $subject, $body, $cabeceras, $bcc);

}
else {
$body = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="initial-scale=1.0"/>
<meta name="format-detection" content="telephone=no"/>
<title>Somrurals</title>
<style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff;}
.ExternalClass {width: 100%; background-color: #ffffff;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
html{width: 100%; }
body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
body {margin:0; padding:0;}
table {border-spacing:0;}
img{display:block !important;}
table td {border-collapse:collapse;}
.yshortcuts a {border-bottom: none !important;}

@media only screen and (max-width: 600px){
  body{width:auto!important;}
  table[class="container"]{ width: 100%!important;padding-left: 0px!important; padding-right: 0px!important;}

}
@media only screen and (max-width: 479px){
   table[class="container2"]{ width:100%!important; float:none !important;}
   .pad-min {padding:10px 10px !important;}
   .clear-mobile {display:none;!important}
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td align="center" valign="top" bgcolor="#f1f1Ef">
  	<!-- Contenido -->
    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container" itemscope itemtype="http://schema.org/LodgingReservation" itemref="_underName6 _numAdults13">

    	<tbody>
        <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
      <tr>
        <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="http://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">
            <strong style="font-size:24px; line-height:30px">Solicitud de la reserva</strong>

            <br/><br/>

            Un client ha demanat confirmació de disponibilitat per la teva casa.<br/><br/>

           <table width="100%" cellspacing="0" cellpadding="0">

           	<tbody>
            <tr>
                <td style="border:1px #E7E7E5 solid;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                              <tr>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">Entrada:</strong><br/>'.date("d-m-Y",$datein).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">Salida:</strong><br/>'.date("d-m-Y",$dateout).'</td>
                              </tr>
                       </tbody>
                       </table>
                	</td>
                </tr>
                <tr>
                	<td height="15"></td>
                </tr>
                 <tr>
                	<td style="border:1px #E7E7E5 solid;">

                   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Adultos:</strong> <span itemprop="numAdults">'.$adultos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Niños:</strong> <span itemprop="numChildren">'.$ninos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Bebes: </strong> '.$bebes.'</td>
                              </tr>
                       </tbody>
                       </table>

                    </td>
                </tr>
                 <tr>
                	<td height="15"></td>
                </tr>
            	<tr>
            	<td>
                 <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
               		<span>
					<tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777;">

							<span itemprop="reservationFor" itemscope itemtype="http://schema.org/LodgingBusiness" itemref="_image3">
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.GetTitleCasa ($eid).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $eid)).'</span> ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $eid)).')</span>
                   		  </span><br/>
                   		  <strong itemprop="lodgingUnitDescription" style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                        <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">Referencia: SR-'.$eid.'</td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Total</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="price">'.$total.' &euro;</strong></td>
                      </tr></span>
                      <tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Anticipado</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$anticipado.' &euro;</strong></td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">Restante</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$restante.' &euro;</strong></td>
                      </tr>
                </table>
            	</td>
            </tr>
            </tbody>
            </table><br/><br>
            Si la casa <strong>está disponible</strong>, puede confirmarlo clicando en este enlace que le redirigirá a la gestión de reservas de su establecimiento. Debe haber introducido usuario y contraseña previamente para poder acceder.
            <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100%" height="20">&nbsp;</td>
              </tr>
              <tr>
                <td>
                <table cellspacing="0" cellpadding="0" align="center" width="90%">
                        <tr>
                            <td align="center" bgcolor="#81C824" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #487D02 solid;  padding:10px">
            					<a href="http://www.somrurals.com/administrador/reservations_view.php?id='.$resid.'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: Arial, sans-serif; text-decoration: none; width:100%; padding:0px 20px display:inline-block">CONFIRMACIÓN DE DISPONIBILIDAD</a>
                            </td>
                        </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td height="20">&nbsp;</td>
              </tr>
            </table>
            De <strong>no estar disponible</strong>, por favor clique en este enlace que le redirigirá a la gestión de reservas de su establecimiento. Debe haber introducido usuario y contraseña previamente para poder acceder.
            <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100%" height="20">&nbsp;</td>
              </tr>
              <tr>
                <td>
                <table cellspacing="0" cellpadding="0" align="center" width="90%">
					<tr>
						<td align="center" bgcolor="#F94B36" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #AC2717 solid;  padding:10px">
							<a href="http://www.somrurals.com/administrador/reservations_view.php?id='.$resid.'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: Arial, sans-serif; text-decoration: none; width:100%; padding:0px 20px display:inline-block">La casa no está disponible</a>
						</td>
					</tr>
                </table>
                </td>
              </tr>
              <tr>
                <td height="20">&nbsp;</td>
              </tr>
            </table>

			<br><br>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FEF5E3">
                  <tbody><tr>
                    <td style="border: 1px #F9B636 solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #232323; display: block; padding:7px 10px;font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#232323; text-align:center">También puede informar de la disponibilidad<br><strong>respondiendo a este email</strong><br>o en el teléfono 93 293 55 27</td>
                  </tr>
            </tbody></table>

            <br/>
            Les dades complertes del client seran facilitades en el moment que aquest realitzi el pagament anticipat, confirmant la reserva.<br>
			<br>
			El import restant de la reserva es pagarà directament a l\'establiment, de la manera especificada en la web.<br><br>
            Les factures y transferències corresponents al pagament anticipat (si aquest es superior al 15%), es farà efectiva a primers de cada mes desprès de la data de sortida del client.<br><br>
            Moltes gràcies,</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: 93 293 55 27</td>
      </tr>
      <tr>
        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
              <tbody><tr>
                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="http://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                </tr>
              <tr>
                <td><a href="https://www.facebook.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://www.facebook.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://plus.google.com/117022694086662550685"><img src="http://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
              </tr>
            </tbody></table>
       </td>
      </tr>
      <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
    </tbody>
    </table>
     <!-- / Contenido  -->
    </td>
  </tr>
 </tbody>
</table>

</body></html>
';

/*
$from = array('yorlenischetik@gmail.com' => 'Som Rurals');
$subject = "Som Rurals - Confirmació de disponibilitat";
$email_establiment = Query('establiments', 'email', 'eid', $eid);

set_time_limit(0);
require_once 'includes/Swift/lib/swift_required.php'; //require lib

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
  ->setUsername('yorlenischetik@gmail.com')
  ->setPassword('06INFrur12')
  ;

$mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');

$message = Swift_Message::newInstance($subject)
	->setFrom($from)
	->setCharset("UTF-8")
	->setTo($email_establiment)
	->setBcc('yorlenischetik@gmail.com')
	->setBody($body, 'text/html') or die('error here.');

$mailer->send($message);
*/

$email_establiment = Query('establiments', 'email', 'eid', $eid);

$subject = $email_subject_prefix."Som Rurals - Confirmació de disponibilitat";
$para = $email_establiment;
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
    $bcc = array();
    if ($allow_email_bcc == true && !empty($email_bcc_address)) {
        $cabeceras .= 'Bcc:  '.implode(', ', $email_bcc_address).''."\r\n";
        $bcc = array_merge ($bcc, $email_bcc_address);
    }

    transactional_mail($para, $subject, $body, $cabeceras, $bcc);


}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------ ENVIO DEL EMAIL AL CLIENTE  -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
if($reserva_inmediata_enabled) {
	$body = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="initial-scale=1.0"/>
<meta name="format-detection" content="telephone=no"/>
<title>Somrurals</title>
<style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff;}
.ExternalClass {width: 100%; background-color: #ffffff;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
html{width: 100%; }
body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
body {margin:0; padding:0;}
table {border-spacing:0;}
img{display:block !important;}
table td {border-collapse:collapse;}
.yshortcuts a {border-bottom: none !important;}

@media only screen and (max-width: 600px){
  body{width:auto!important;}
  /*start width 100%*/
  table[class="container"]{ width: 100%!important;padding-left: 0px!important; padding-right: 0px!important;}

}
@media only screen and (max-width: 479px){
  /*start width 100% */
   table[class="container2"]{ width:100%!important; float:none !important;}
   .pad-min {padding:10px 10px !important;}
   .clear-mobile {display:none;!important}
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td align="center" valign="top" bgcolor="#f1f1Ef">
  	<!-- Contenido -->
    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container" itemscope itemtype="http://schema.org/LodgingReservation">

    	<tbody>
        <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
      <tr>
        <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="img/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

        	<span style="font-size:18px;line-height:30px"><strong>Hola '.$_SESSION['reserva-nombre'].',</strong></span><br/>
            <span style="font-size:30px; line-height:30px"><strong>'.MAIL_AVISO_INMEDIATA_1.'</strong></span><br/><br/>
            <span style="font-size:16px;">'.MAIL_AVISO_INMEDIATA_2.'</span><br/><br/>

		</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">


			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: '.$telefono_somrurals['humano'].'</td>
      </tr>
      <tr>
        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
              <tbody><tr>
                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="http://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                </tr>
              <tr>
                <td><a href="https://www.facebook.com/somrurals"><img src="img/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://www.facebook.com/somrurals"><img src="img/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://plus.google.com/117022694086662550685"><img src="img/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
              </tr>
            </tbody></table>
       </td>
      </tr>
      <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
    </tbody>
    </table>
     <!-- / Contenido  -->
    </td>
  </tr>
 </tbody>
</table>

</body></html>';
	$subject = $email_subject_prefix."Som Rurals - ".EMAIL_CLIENT_SUBJECT;
	//$para = $email;	// para produccion
	implode(', ', $email_bcc_address);	// Para demo
	$cabeceras = 'MIME-Version: 1.0'."\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8'."\r\n";
	$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>'."\r\n";
//$cabeceras .= 'Bcc: info@movetothebit.com' . "\r\n";
	$cabeceras .= 'Bcc: '.ADMIN_BCC.''."\r\n";

	//mail($para, $subject, $body, $cabeceras);
}
else {
	$body = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="initial-scale=1.0"/>
<meta name="format-detection" content="telephone=no"/>
<title>Somrurals</title>
<style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff;}
.ExternalClass {width: 100%; background-color: #ffffff;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
html{width: 100%; }
body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
body {margin:0; padding:0;}
table {border-spacing:0;}
img{display:block !important;}
table td {border-collapse:collapse;}
.yshortcuts a {border-bottom: none !important;}

@media only screen and (max-width: 600px){
  body{width:auto!important;}
  /*start width 100%*/
  table[class="container"]{ width: 100%!important;padding-left: 0px!important; padding-right: 0px!important;}

}
@media only screen and (max-width: 479px){
  /*start width 100% */
   table[class="container2"]{ width:100%!important; float:none !important;}
   .pad-min {padding:10px 10px !important;}
   .clear-mobile {display:none;!important}
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td align="center" valign="top" bgcolor="#f1f1Ef">
  	<!-- Contenido -->
    <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container" itemscope itemtype="http://schema.org/LodgingReservation">

    	<tbody>
        <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
      <tr>
        <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="http://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">
        	<span style="font-size:18px;line-height:30px"><strong>'.MAIL_CLIENTE_HOLA.' '.$nombre.',</strong></span><br/>
            <span style="font-size:24px; line-height:30px"><strong>'.MAIL_CLIENTE_TITLE.'</strong></span><br/><br/>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E4F2FB">
                  <tbody><tr>
                    <td style="border: 1px #4BA6DB solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #ffffff; display: block; padding:7px 10px;font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#232323; text-align:center">
					'.MAIL_CLIENTE_PLAZO_MAXIMO.'
					</td>
                  </tr>
            </tbody></table>
            <br/>
            '.MAIL_CLIENTE_CONFIRMADA_DISPONIBILIDAD.'<br/><br/>
           <table width="100%" cellspacing="0" cellpadding="0">
           	<tbody><tr>
                <td style="border:1px #E7E7E5 solid;">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                              <tr>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">'.ENTRADA.':</strong><br/>'.date(
			"d-m-Y",
			$datein
		).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">'.SALIDA.':</strong><br/>'.date(
			"d-m-Y",
			$dateout
		).'</td>
                              </tr>
                       </tbody>
                       </table>
                	</td>
                </tr>
                <tr>
                	<td height="15"></td>
                </tr>
                 <tr>
                	<td style="border:1px #E7E7E5 solid;">

                   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.ADULTOS.':</strong> <span itemprop="numAdults">'.$adultos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.NINOS.':</strong> <span itemprop="numChildren">'.$ninos.'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.BEBES.':</strong> '.$bebes.'</td>
                              </tr>
                       </tbody>
                       </table>

                    </td>
                </tr>
                 <tr>
                	<td height="15"></td>
                </tr>
				<tr>
            	<td>
                 <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">

					<tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777;">
                            <span itemprop="reservationFor" itemscope itemtype="http://schema.org/LodgingBusiness" itemref="_image3">
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query(
			'establiments',
			'title',
			'eid',
			$eid
		).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat(
			Query('establiments', 'lid', 'eid', $eid)
		).'</span> ('.GetTitleProvincia(Query('establiments', 'pvid', 'eid', $eid)).')</span>
                   		  </span><br/>
                   		  <strong itemprop="lodgingUnitDescription" style="color:#232323">'.GetTitleTipus($tipo).'</strong>
                          </td>
                        <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">'.MAIL_CLIENTE_REFERENCIA.': SR-'.$eid.'</td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.PRECIO_TOTAL.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="price">'.$total.' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.ANTICIPADO.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$anticipado.' &euro;</strong></td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.CANTIDAD_RESTANTE.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$restante.' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;">
						'.Query('establiments', 'terms_'.$lng, 'eid', $eid).'
						</td>
                        </tr>
						<tr>
                        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="#"><img id="_image3" itemprop="image" src="'.CDN_BASE.'images/uploads/establiments/'.ImagePrincipalEstabliment(
			$eid
		).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
                        </tr>
                </table>
            	</td>
            </tr>
            </tbody>
            </table>

            <br/><br/>
			<strong style="font-size:24px; padding-bottom:15px;">'.MAIL_CLIENTE_TUS_DATOS.'</strong>
            <br/>
            <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
              <tbody id="_underName6" itemprop="underName" itemscope itemtype="http://schema.org/Person"><tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td width="36%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.NOMBRE.'</td>
                <td width="64%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="name">'.$nombre.'</strong></td>
              </tr>
              <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.APELLIDOS.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$apellidos.'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.TELEFONO.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$telefono.'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.POBLACION.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$poblacion.'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.EMAIL.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="email">'.$email.'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.PAIS.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$pais.'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.IDIOMA_CONTACTO.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$language.'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.COMENTARIOS.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$comentarios.'</strong></td>
              </tr>
            </tbody></table>
            <br/>
			'.MAIL_CLIENTE_FOOTER.'
		</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: 93 293 55 27</td>
      </tr>
      <tr>
        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
              <tbody><tr>
                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="http://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                </tr>
              <tr>
                <td><a href="https://www.facebook.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://www.twitter.com/somrurals"><img src="http://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                <td><a href="https://plus.google.com/117022694086662550685"><img src="http://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
              </tr>
            </tbody></table>
       </td>
      </tr>
      <tr>
        <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
      </tr>
    </tbody>
    </table>
     <!-- / Contenido  -->
    </td>
  </tr>
 </tbody>
</table>

</body></html>
';

	/*
    $subject = "Som Rurals - ".EMAIL_CLIENT_SUBJECT;
    $message = Swift_Message::newInstance($subject)
        ->setFrom($from)
        ->setCharset("UTF-8")
        ->setTo($email)
        //->setBcc(array('yorlenischetik@gmail.com','manteniment@atipus.com'))
        ->setBody($body, 'text/html') or die('error here.');

    $mailer->send($message);
    */

	$subject = $email_subject_prefix."Som Rurals - ".EMAIL_CLIENT_SUBJECT;
	$para = $email;
	$cabeceras = 'MIME-Version: 1.0'."\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8'."\r\n";
	$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>'."\r\n";
//$cabeceras .= 'Bcc: info@movetothebit.com' . "\r\n";
	$cabeceras .= 'Bcc: '.ADMIN_BCC.''."\r\n";
    $bcc = array(ADMIN_BCC);
    if ($allow_email_bcc == true && !empty($email_bcc_address)) {
        $cabeceras .= 'Bcc: '.ADMIN_BCC.', '.implode(', ', $email_bcc_address).''."\r\n";
        $bcc = array_merge ($bcc, $email_bcc_address);
    }

    transactional_mail($para, $subject, $body, $cabeceras, $bcc);

}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------- Borramos las variables de session  --------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

unset($_SESSION['reserva-persons']);
unset($_SESSION['reserva-ninos']);
unset($_SESSION['reserva-bebes']);
unset($_SESSION['reserva-datein']);
unset($_SESSION['reserva-dateout']);
unset($_SESSION['reserva-tipo']);
unset($_SESSION['reserva-eid']);
unset($_SESSION['reserva-total']);
unset($_SESSION['reserva-anticipado']);
unset($_SESSION['reserva-restante']);
unset($_SESSION['reserva-nombre']);
unset($_SESSION['reserva-apellidos']);
unset($_SESSION['reserva-email']);
unset($_SESSION['reserva-telefono']);
unset($_SESSION['reserva-poblacion']);
unset($_SESSION['reserva-pais']);
unset($_SESSION['reserva-language']);
unset($_SESSION['reserva-comentarios']);
unset($_SESSION['rooms']);
unset($_SESSION['datein']);
unset($_SESSION['dateout']);
unset($_SESSION['persons']);
unset($_SESSION['tipo']);
unset($_SESSION['search']);

// Borramos toda la sesion
session_destroy() or die("Error");
?>

<?php
	if($reserva_inmediata_enabled) {
        $rescode_encoded = SomruralsEncode($rescode);
        $payment_script = '';
        switch($lng) {
            case 'es':
                $payment_script .= 'reserva-prepago2/';
                break;
            case 'ca':
                $payment_script .= 'reserva-prepagament2/';
                break;
			case 'fr':
				$payment_script .= 'reservations-prepaiement2/';
				break;
			case 'en':
				$payment_script .= 'book-prepayment2/';
				break;
        }
        $payment_url = 	URL_BASE.$lng.'/'.$payment_script.'/'.$rescode_encoded;

        ?>
        <!-- Redirigimos la página que mostrará el resultado de la pre-reserva -->
        <form action="<?php echo $payment_url; ?>" method="post" name="reserva_result">
            <input type="submit" value="continuar" class="input" style="visibility:hidden">
            <input type="hidden" name="persons" value="<?php echo $persons; ?>">
            <input type="hidden" name="datein" value="<?php echo date("d-m-Y", $datein); ?>">
            <input type="hidden" name="dateout" value="<?php echo date("d-m-Y", $dateout) ?>">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <input type="hidden" name="eid" value="<?php echo $eid; ?>">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type="hidden" name="anticipado" value="<?php echo $anticipado; ?>">
            <input type="hidden" name="restante" value="<?php echo $restante; ?>">


            <?php
            if (is_array($rooms)) {
                foreach ($rooms as $room) { ?>
                    <input type="hidden" name="rooms[]" value="<?php echo $room; ?>">
                <?php }
            } ?>


        </form>
        <?php

    } else {
		?>
		<!-- Redirigimos la página que mostrará el resultado de la pre-reserva -->
		<form action="<?php echo $lng."/".URL_RESERVA_RESULT; ?>" method="post" name="reserva_result">
			<input type="submit" value="continuar" class="input" style="visibility:hidden">
			<input type="hidden" name="persons" value="<?php echo $persons; ?>">
			<input type="hidden" name="datein" value="<?php echo date("d-m-Y", $datein); ?>">
			<input type="hidden" name="dateout" value="<?php echo date("d-m-Y", $dateout) ?>">
			<input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
			<input type="hidden" name="eid" value="<?php echo $eid; ?>">
			<input type="hidden" name="total" value="<?php echo $total; ?>">
			<input type="hidden" name="anticipado" value="<?php echo $anticipado; ?>">
			<input type="hidden" name="restante" value="<?php echo $restante; ?>">


			<?php
			if (is_array($rooms)) {
				foreach ($rooms as $room) { ?>
					<input type="hidden" name="rooms[]" value="<?php echo $room; ?>">
				<?php }
			} ?>


		</form>
		<?php
	}
	?>
<script language="javascript">
    document.reserva_result.submit();
</script>
