<?php
/*
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Guardamos los datos del formulario POST en variables
$persons = $_POST['persons'];
$adultos = $_POST['adultos'];
$ninos = $_POST['ninos'];
$bebes = $_POST['bebes'];
$datein = $_POST['datein'];
$dateout = $_POST['dateout'];
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
if ($_POST['newsletter']=='on') $newsletter=1;


// Calculamos el código de reserva
$codeok = 0;
$rescode = RandomChars(4)."-".RandomNums(4)."-".RandomNums(4); // Ej: FTJH-8347-2345
while ($codeok == 0) { // Verificamos que el código sea único
	$query = mysql_query("SELECT rescode FROM reservations WHERE rescode = '".$rescode."'"); 
	if($rs = mysql_fetch_array($query)){
		$rescode = RandomChars(4)."-".RandomNums(4)."-".RandomNums(4);
	} else {
		$codeok = 1;	
	}
}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------- ALTA RESERVA -> Insertamos los datos en la tabla de la reserva (reservations) -------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$SQL = "INSERT INTO reservations (eid, resdate, checkin, checkout, numdays, persons, adults, children, babies, totalprice, feeamount, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, rescode, paid,  pid, newsletter, iid) VALUES(";
$SQL .= $eid . ", ";
//$SQL .= "now(), ";
$SQL .= "'".date("Y-m-d H:i:s")."', ";
$SQL .= "'" . date("Y-m-d",$datein) . "', ";
$SQL .= "'" . date("Y-m-d",$dateout) . "', ";
$SQL .= $numdays . ", ";
$SQL .= $persons . ", ";
$SQL .= $adultos . ", ";
$SQL .= $ninos . ", ";
$SQL .= $bebes . ", ";
$SQL .= $total . ", ";
$SQL .= $anticipado . ", ";
$SQL .= "1, ";
$SQL .= "'" . $nombre . "', ";
$SQL .= "'" . $apellidos . "', ";
$SQL .= "'" . $poblacion . "', ";
$SQL .= "'" . $telefono . "', ";
$SQL .= "'" . $email . "', ";
$SQL .= $IVA . ", ";
$SQL .= "'" . $comentarios . "', ";
$SQL .= "'" . $pais . "', ";
$SQL .= "'" . $language . "', ";
$SQL .= "'" . $_SERVER['REMOTE_ADDR']. "', ";
$SQL .= "'" . $rescode . "', ";	
$SQL .= "0, ";
$SQL .= $pago .", ";
$SQL .= $newsletter .", ";
$SQL .= $tipo . ")";																																						

mysql_query($SQL);	
$resid = mysql_insert_id();

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
			$SQL  = "SELECT rid, price "; 
			$SQL .= "FROM rooms_prices ";
			$SQL .= "WHERE rid = ".$room." ";
			$SQL .= "AND date = '".date("Y-m-d", $date)."'";
			
			$query = mysql_query($SQL);
			
			if($rs = mysql_fetch_array($query)){
				$price = $price + $rs['price'];
			}
				
			$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
		}	
		
		
		$SQL = "INSERT INTO reserveditems (resid, iid, rid, sdate, edate, quantity, price) VALUES(";
		$SQL .= $resid . ", ";
		$SQL .= "1, "; // 1 = id "item" room
		$SQL .= $room . ", ";	
		$SQL .= "'" . date("Y-m-d",$datein) . "', ";
		$SQL .= "'" . date("Y-m-d",$dateout) . "', ";	
		$SQL .= $quantity . ", ";
		$SQL .= $price . ")";
		
		mysql_query($SQL);
	}
	
} else if ($tipo==2){ // Si la reserva es de la casa entera
	
	$SQL = "INSERT INTO reserveditems (resid, iid, rid, sdate, edate, quantity, price) VALUES(";
	$SQL .= $resid . ", ";
	$SQL .= "2, "; // 2 = id "item" casa
	$SQL .= "0, "; // 0 = no es una habitacion
	$SQL .= "'" . date("Y-m-d",$datein) . "', ";
	$SQL .= "'" . date("Y-m-d",$dateout) . "', ";	
	$SQL .= "1, ";
	$SQL .= $total . ")";
	
	mysql_query($SQL);
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
			$SQL =  "UPDATE rooms_prices SET "; 
			$SQL .= "availability = availability - " . $quantity . " ";																																		
			$SQL .= "WHERE rid = " . $room . " ";
			$SQL .= "AND eid = ".$eid." ";
			$SQL .= "AND date = '".date("Y-m-d", $date)."'";			
			mysql_query($SQL);			
			$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
		}	
	}
	
} else if ($tipo==2){ // --------------------------------- Si la reserva es de la CASA ENTERA -------------------------------------------
	
	// Quitamos la disponibilidad de todas las habitaciones
	$date = $datein;
	while ($date < $dateout) { // Recorrido del intervalo de fechas			
		$SQL =  "UPDATE rooms_prices SET "; 
		$SQL .= "availability = 0 ";																																		
		$SQL .= "WHERE eid = ".$eid." ";
		$SQL .= "AND date = '".date("Y-m-d", $date)."'";
		mysql_query($SQL);			
		$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
	}
	
	// Quitamos la disponibilidad de la casa entera
	$date = $datein;
	while ($date < $dateout) { // Recorrido del intervalo de fechas			
		$SQL =  "UPDATE establiments_prices SET "; 
		$SQL .= "availability = 0 ";																																		
		$SQL .= "WHERE eid = ".$eid." ";
		$SQL .= "AND date = '".date("Y-m-d", $date)."'";
		mysql_query($SQL);			
		$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
	}	

}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------ ENVIO DEL EMAIL AL ESTABLECIMIENTO ----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
        	Email: <a href="mailto:info@somrurals.com" style="text-decoration:none; color:#E37F4B">info@somrurals.com</a><br/>
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


$email_establiment = Query('establiments', 'email', 'eid', $eid);

$subject = "Som Rurals - Confirmació de disponibilitat";
$para = $email_establiment;
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";	
$cabeceras .= 'From: Som Rurals <info@somrurals.com>' . "\r\n";

mail($para, $subject, $body, $cabeceras);


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------ ENVIO DEL EMAIL AL CLIENTE  -----------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">'.ENTRADA.':</strong><br/>'.date("d-m-Y",$datein).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">'.SALIDA.':</strong><br/>'.date("d-m-Y",$dateout).'</td>
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
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query('establiments', 'title', 'eid', $eid).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $eid)).'</span> ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $eid)).')</span>
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
                        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="#"><img id="_image3" itemprop="image" src="http://www.somrurals.com/images/uploads/establiments/'.ImagePrincipalEstabliment($eid).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
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
        	Email: <a href="mailto:info@somrurals.com" style="text-decoration:none; color:#E37F4B">info@somrurals.com</a><br/>
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

$subject = "Som Rurals - ".EMAIL_CLIENT_SUBJECT;
$para = $email;
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";	
$cabeceras .= 'From: Som Rurals <info@somrurals.com>' . "\r\n";
$cabeceras .= 'Bcc: info@somrurals.com' . "\r\n";

mail($para, $subject, $body, $cabeceras);


header("location: page_home_edit.php");
*/
?>