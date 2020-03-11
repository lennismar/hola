<?php   
include("includes/config.php");

$restid=$_GET['restid'];
$resid=$_GET['resid'];
$email=$_GET['email'];
$response=($_GET['response']);

$query = "UPDATE reservations SET restid ='$restid' WHERE resid='$resid'";

$SQL = "INSERT INTO reservations_history (resid, restid, user, date) VALUES(";
$SQL .= $resid.",";
$SQL .= $restid.",";
$SQL .= "'".$_SESSION['type_user']."',";
$SQL .= "'".date("Y-m-d H:i:s")."')";
$history = $db->rawQuery($SQL);
$log->logdbg('reservations_history created: '.$SQL);

if (($restid == 2) && ($email!='no')) { // -----------------------------------------------------------   Disponible - Pago anticipado Pendiente

    $query_response = "UPDATE reservations SET response = '$response' WHERE resid='$resid'";
    $response = $db->rawQuery($query_response);
    $log->logdbg('Response de reserva actualizada: '.$query_response);

    $db->where ("resid", $resid);
    $rs = $db->getOne("reservations");

    switch ($rs['olanguage']) {
        case 'ca':
            $subject_text= "Somrurals | La teva casa rural està disponible";
            $txt_hello= "Hola";
            $txt_casa_disponible= "La teva casa rural està disponible!";
            $txt_confirmar_reserva= '<strong>Per confirmar la teva reserva has de realitzar el</strong> <strong style="color:#E37F4B;">pagament anticipat abans de 48 hores</strong> indicat l\'import de la reserva, mitjançant transferència bancària al següent número de compte:';
            $txt_datos_bancarios= "
                    <strong>Titular compte:</strong> Somrurals eCommerce Solutions<br>
                    <strong>Entitat bancària:</strong> La Caixa<br>
                    <strong>Compte Bancari:</strong> 2100 3313 31 22 00153093<br>
                    <strong>IBAN:</strong> ES48 2100 3313 3122 0015 3093<br>
                    <strong>BIC/SWIFT: </strong>CAIX00 3313 31 22 00153093<br>
                    <strong>Import anticipat:</strong> ".$rs['feeamount']." &euro;<br>
                    <strong>Concepte: </strong>".$rs['ofirstname']." ".$rs['olastname']."<br>
            ";
            $txt_momento_efectivo = "En el moment que es fa efectiu el pagament <strong>la teva reserva quedarà confirmada.</strong>";
            $txt_momento_efectivo_email = "Rebràs un mail amb totes les dades de la teva reserva i de la casa rural";
            $txt_info_transferencia = "
            Si la transferència es <strong>realitza des d'una entitat diferent a la Caixa</strong>, triguen una mitjana de 24 hores a fer-se efectives.<br/><br>
            Si vols, una vegada realitzada la transferència pots enviar  via email el justificant de pagament per a la teva tranquil·litat.<br>
            ";
            $txt_respuesta = "En resposta al teu comentari";
            $txt_tu_reserva = "La teva reserva";
            $txt_entrada = "Entrada";
            $txt_salida = "Sortida";
            $txt_adultos = "Adults";
            $txt_ninos = "Nens";
            $txt_bebes = "Nadons";
            $txt_referencia = "Referència";
            $txt_total = "Total";
            $txt_anticipado = "Anticipat";
            $txt_restante = "Restant";
            $txt_tasa_turistica = "No inclou la taxa turística de 0,99 € per persona i dia.";
            $txt_pago_pendiente = "El pagament pendent ho hauràs de realitzar en efectiu directament a la casa rural, o bé per transferència abans d'entrar a la casa rural.";
            $txt_contacte_nosotros = "Davant de qualsevol consulta pots contactar amb nosaltres.";
            break;
        case 'fr':
            $subject_text= "Somrurals | Votre maison est disponible";
            $txt_hello= "Salut";
            $txt_casa_disponible= "Votre maison est disponible!";
            $txt_confirmar_reserva= '<strong>Une fois la maison confirme sa disponibilité, </strong> <strong style="color:#E37F4B;">les dates resteront fermée pendant 48 heures,</strong> vous devrez alors faire le paiement anticipé par virement bancaire au numéro de compte indiqué:';
            $txt_datos_bancarios= "
                    <strong>Titulaire du compte:</strong> Somrurals eCommerce Solutions<br>
                    <strong>Banque Entité:</strong> La Caixa<br>
                    <strong>Compte bancaire:</strong> 2100 3313 31 22 00153093<br>
                    <strong>IBAN:</strong> ES48 2100 3313 3122 0015 3093<br>
                    <strong>BIC/SWIFT: </strong>CAIX00 3313 31 22 00153093<br>
                    <strong>Anticipé:</strong> ".$rs['feeamount']." &euro;<br>
                    <strong>Concept: </strong>".$rs['ofirstname']." ".$rs['olastname']."<br>
            ";
            $txt_momento_efectivo = "Lorsque nous recevront le paiement anticipé, <strong>nous vous enverrons une confirmation et toute l'information nécessaire.</strong>";
            $txt_momento_efectivo_email = "Rebràs un mail amb totes les dades de la teva reserva i de la casa rural";
            $txt_info_transferencia = "
            Si la transferència es <strong>realitza des d'una entitat diferent a la Caixa</strong>, triguen una mitjana de 24 hores a fer-se efectives.<br/><br>
            Si vols, una vegada realitzada la transferència pots enviar  via email el justificant de pagament per a la teva tranquil·litat.<br>
            ";
            $txt_respuesta = "En réponse à votre commentaire";
            $txt_tu_reserva = "Vos coordonnées";
            $txt_entrada = "Arrivée";
            $txt_salida = "Anticipé";
            $txt_adultos = "Adults";
            $txt_ninos = "Childrens";
            $txt_bebes = "Babies";
            $txt_referencia = "Référence";
            $txt_total = "Prix total";
            $txt_anticipado = "Anticipé";
            $txt_restante = "Montant qui reste à payer";
            $txt_tasa_turistica = "Non compris dans le tarif: 0.99 EUR de taxe de séjour par personne par nuit.";
            $txt_pago_pendiente = "Le reste du montant total sera payé à arrivée au gîte rural.";
            $txt_contacte_nosotros = "Pour toute question, contactez-nous.";
            break;
        case 'en':
            $subject_text= "Somrurals | Your house is available";
            $txt_hello= "Hi";
            $txt_casa_disponible= "Your house is available!";
            $txt_confirmar_reserva= '<strong>To confirm your reservation, </strong> <strong style="color:#E37F4B;">you have to make the advance payment within 48 hours,</strong> indicated the amount of the reserve, by bank transfer to the following account:';
            $txt_datos_bancarios= "
                    <strong>Account holder:</strong> Somrurals eCommerce Solutions<br>
                    <strong>Bank Entity:</strong> La Caixa<br>
                    <strong>Bank Account:</strong> 2100 3313 31 22 00153093<br>
                    <strong>IBAN:</strong> ES48 2100 3313 3122 0015 3093<br>
                    <strong>BIC/SWIFT: </strong>CAIX00 3313 31 22 00153093<br>
                    <strong>Prepayment:</strong> ".$rs['feeamount']." &euro;<br>
                    <strong>Concept: </strong>".$rs['ofirstname']." ".$rs['olastname']."<br>
            ";
            $txt_momento_efectivo = "When payment is made your reservation will be confirmed.</strong>";
            $txt_momento_efectivo_email = "You will receive your booking confirmation with all the details";
            $txt_info_transferencia = "The bank transfer take an average of 24 hours to be effective<br>";
            $txt_respuesta = "In response to your comment";
            $txt_tu_reserva = "Your reservation";
            $txt_entrada = "Check in";
            $txt_salida = "Check out";
            $txt_adultos = "Adults";
            $txt_ninos = "Childrens";
            $txt_bebes = "Babies";
            $txt_referencia = "Complete rental Reference";
            $txt_total = "Total Price";
            $txt_anticipado = "Prepayment";
            $txt_restante = "Outstanding amount";
            $txt_tasa_turistica = "Not included city tax: 0,99€ per person per night.";
            $txt_pago_pendiente = "The outstanding amount should be paid directly in the house, by cash.";
            $txt_contacte_nosotros = "For any questions, contact us.";
            break;
        default:
            $subject_text= "Somrurals | Tu casa rural está disponible";
            $txt_hello= "Hola";
            $txt_casa_disponible= "¡Tu casa rural está disponible!";
            $txt_confirmar_reserva= '<strong>Para confirmar tu reserva debes realizar el</strong> <strong style="color:#E37F4B;">pago anticipado antes de 48 horas</strong> indicado del importe de la reserva, mediante transferencia bancaria al siguiente número de cuenta:';
            $txt_datos_bancarios= "
                    <strong>Titular cuenta:</strong> Somrurals eCommerce Solutions<br>
                    <strong>Entidad bancaria:</strong> La Caixa<br>
                    <strong>Cuenta Bancaria:</strong> 2100 3313 31 22 00153093<br>
                    <strong>IBAN:</strong> ES48 2100 3313 3122 0015 3093<br>
                    <strong>BIC/SWIFT: </strong>CAIX00 3313 31 22 00153093<br>
                    <strong>Importe anticipada:</strong> ".$rs['feeamount']." &euro;<br>
                    <strong>Concepto: </strong>".$rs['ofirstname']." ".$rs['olastname']."<br>
            ";
            $txt_momento_efectivo = "En el momento que se hace efectivo el pago <strong>tu reserva quedará confirmada</strong>";
            $txt_momento_efectivo_email = "En el momento en que tu pago se haga efectivo, recibirás un mail con todos los datos de tu reserva y de la casa rural";
            $txt_info_transferencia = "
            Si la transferencia se <strong>realiza desde una entidad diferente a La Caixa</strong>, tardan una media de 24h en hacerse efectivas.<br/><br>
            Si lo deseas, una vez realizada la transferencia puede enviarnos a via email el justificante de pago para su tranquilidad.<br>
            ";
            $txt_respuesta = "En respuesta a su comentario";
            $txt_tu_reserva = "Tu reserva";
            $txt_entrada = "Entrada";
            $txt_salida = "Salida";
            $txt_adultos = "Adultos";
            $txt_ninos = "Niños";
            $txt_bebes = "Bebes";
            $txt_referencia = "Referencia";
            $txt_total = "Total";
            $txt_anticipado = "Anticipado";
            $txt_restante = "Restante";
            $txt_tasa_turistica = "No incluye la tasa turística de 0´99 &euro; por persona y día.";
            $txt_pago_pendiente = "El pago pendiente deberás realizar en efectivo directamente a la casa rural, o bien por transferencia antes de entrar en la casa rural.";
            $txt_contacte_nosotros = "Ante cualquier consulta no dudes en contactar con nosotros.";
            break;
    }


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
        
        	<span style="font-size:18px;line-height:30px"><strong>'.$txt_hello.' '.$rs['ofirstname'].',</strong></span><br/>
            <span style="font-size:30px; line-height:30px"><strong>'.$txt_casa_disponible.'</strong></span><br/><br/>
            <span style="font-size:16px;">'.$txt_confirmar_reserva.'</span><br/><br/>
            
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EAF4DE">
                  <tr>
                    <td style="border: 1px #81C824 solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #ffffff; display: block; padding:10px;font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px; color:#232323;">
					'.$txt_datos_bancarios.'
					</td>
                  </tr>
            </table>
            
            <br/>'.$txt_momento_efectivo.'<br><br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E7E7E5">
                  <tr>
                    <td style="border-left: 5px #E37F4B solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #ffffff; display: block; padding:10px;font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:24px; color:#232323;">
                    '.$txt_momento_efectivo_email.'
					</td>
                  </tr>
            </table>
            <br>
			'.$txt_info_transferencia.'
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0 "style="border:1px #E7E7E5 solid; padding:10px;" >
              <tr>
                <td style="font-size:18px; display:block; padding:0px 0px 10px 0px;color:#4BA6DB""><strong>'.$txt_respuesta.'</strong></td>
              </tr>
              <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; line-height:22px;">'.$response.'</td>
              </tr>
            </table>
            <br>
			<strong style="font-size:24px; display:block; padding:25px 0px 10px 0px;">'.$txt_tu_reserva.'</strong>
           
           <table width="100%" cellspacing="0" cellpadding="0">
           
           	<tbody><tr>
                <td style="border:1px #E7E7E5 solid;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                              <tr>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
								<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">'.$txt_entrada.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkin'])).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">'.$txt_salida.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkout'])).'</td>
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
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_adultos.':</strong> <span itemprop="numAdults">'.$rs['adults'].'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_ninos.':</strong> <span itemprop="numChildren">'.$rs['children'].'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_bebes.'</strong> '.$rs['babies'].'</td>
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
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query('establiments', 'title', 'eid', $rs['eid']).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $rs['eid'])).'</span> ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $rs['eid'])).')</span>
                   		  </span><br/>
                   		  <strong itemprop="lodgingUnitDescription" style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                        <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">'.$txt_referencia.': SR-'.$rs['eid'].'</td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_total.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="price">'.$rs['totalprice'].' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_anticipado.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['feeamount'].' &euro;</strong></td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_restante.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.round($rs['totalprice'] - $rs['feeamount'],2).' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;">'.$txt_tasa_turistica.'</td>
                        </tr>
                </table>
                
            	</td>
            </tr>
            </tbody>
            </table>
              
            <br/>
            '.$txt_pago_pendiente.'.<br>
            <br>
            '.$txt_contacte_nosotros.'
		</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: 93.308.24.88</td>
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

$from = array(ADMIN_BCC => 'Som Rurals');
$subject = $subject_text;
$email_client =  $rs['oemail'];

set_time_limit(0); 
require_once '../includes/Swift/lib/swift_required.php'; //require lib

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
  ->setUsername(ADMIN_BCC)
  ->setPassword('06INFrur12')
  ;

$mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');

$message = Swift_Message::newInstance($subject)
	->setFrom($from)
	->setCharset("UTF-8")
	->setTo($email_client)
	->setBody($body, 'text/html') or die('error here.');
	
$mailer->send($message);
$msg = "emailOK";
}


if (($restid == 3) && ($email!='no')) { // -----------------------------------------------------------   NO Disponible

    $db->where ("resid", $resid);
    $rs = $db->getOne("reservations");

    switch ($rs['olanguage']) {
        case 'ca':
            $subject_text= "Somrurals | La teva casa rural no està disponible, tenim altres opcions";
            $txt_hello= "Hola";
            $txt_casa_nodisponible= "Ho sentim, no hi ha disponibilitat per a la casa que has seleccionat";
            $txt_opciones= "No obstant això, tenim altres opcions que et poden agradar. I molt.";
            $txt_casas_similares_en ="Casas similars a";
            $txt_desde ="Desde";
            $txt_persona_noche ="Persona / Nit";
            $txt_mas_casas_en ="Més cases a";
            $txt_casas_similares_para ="Casas similars per a";
            $txt_personas ="persones";
            $txt_mas_casas_para ="Més cases per a";
            $url_casa_rural = "casa-rural";
            $url_casas_rurales = "cases-rurals";
            break;
        case 'fr':
            $subject_text= "Somrurals | Il n'y a pas de disponibilité pour la maison que vous avez sélectionné";
            $txt_hello= "Salut";
            $txt_casa_nodisponible= "Il n'y a pas de disponibilité pour la maison que vous avez sélectionné";
            $txt_opciones= "Nous avons d'autres options que vous pourriez aimer.";
            $txt_casas_similares_en ="Similar houses in";
            $txt_desde ="A partir de";
            $txt_persona_noche ="Pers. / Nuit";
            $txt_mas_casas_en ="Plus de gites à";
            $txt_casas_similares_para ="Similar houses for";
            $txt_personas ="personnes";
            $txt_mas_casas_para ="Plus de maisons pour";
            $url_casa_rural = "gite-rural";
            $url_casas_rurales = "maisons-rurales";
            break;
        case 'en':
            $subject_text= "Somrurals | Sorry, there is no availability for the house you have selected";
            $txt_hello= "Hi";
            $txt_casa_nodisponible= "Sorry, there is no availability for the house you have selected";
            $txt_opciones= "However, we have other options that you might like.";
            $txt_casas_similares_en ="Similar houses in";
            $txt_desde ="Complete rental From";
            $txt_persona_noche ="Person / Night";
            $txt_mas_casas_en ="More houses in";
            $txt_casas_similares_para ="Similar houses for";
            $txt_personas ="persons";
            $txt_mas_casas_para ="More houses for";
            $url_casa_rural = "holiday-cottage";
            $url_casas_rurales = "holiday-cottages";
            break;
        default:
            $subject_text= "Somrurals | Tu casa rural no está disponible, tenemos otras opciones";
            $txt_hello= "Hola";
            $txt_casa_nodisponible= "Lo sentimos, no ha disponibilidad para la casa que has seleccionado";
            $txt_opciones= "Sin embargo, tenemos otras opciones que te pueden gustar. Y mucho.";
            $txt_casas_similares_en ="Casas similares en";
            $txt_desde ="Desde";
            $txt_persona_noche ="Persona / Noche";
            $txt_mas_casas_en ="Más casas en";
            $txt_casas_similares_para ="Casas similares para";
            $txt_personas ="personas";
            $txt_mas_casas_para ="Más casas para";
            $url_casa_rural = "casa-rural";
            $url_casas_rurales = "casas-rurales";
            break;
    }

    $establimentpvid = Array();
    $pvid = Query('establiments', 'pvid', 'eid', $rs['eid']);
    $establimentpvid = GetOptionalEstablimentsDisponibles ($rs['eid'],date("d-m-Y",strtotime($rs['checkin'])),date("d-m-Y",strtotime($rs['checkout'])),$rs['persons'],$pvid);

    $establimentalt = Array();
    $establimentalt = GetOptionalEstablimentsDisponibles ($rs['eid'],date("d-m-Y",strtotime($rs['checkin'])),date("d-m-Y",strtotime($rs['checkout'])),$rs['persons'],'');

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
        <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container">

            <tbody>
            <tr>
            <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
          </tr>
          <tr>
            <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="http://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
          </tr>
          <tr>
            <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

                <span style="font-size:18px;line-height:30px"><strong>'.$txt_hello.' '.$rs['ofirstname'].',</strong></span><br/>
                <strong style="font-size:24px; line-height:30px">'.$txt_casa_nodisponible.'</strong><br/><br/>
                '.$txt_opciones.'<br/><br>
                <strong style="font-size:24px; padding-bottom:15px; display:block; color:#4BA6DB">'.$txt_casas_similares_en.' '.GetTitleProvincia ($pvid).'</strong>

                     <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                        <tr>
                            <td width="70%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777;">

                              <a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentpvid['eid'])).'-'.$establimentpvid['eid'].'" style="font-size:18px;text-decoration:none; color:#E37F4B"><strong>'.Query('establiments', 'title', 'eid', $establimentpvid['eid']).'</strong></a><br/>
                                '.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $establimentpvid['eid'])).' ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $establimentpvid['eid'])).')<br/>
                                <strong style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                            <td width="30%" style="padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#232323;">
                            '.$txt_desde.'<br>
                            <strong style="font-size:24px;color:#E37F4B"">'.$establimentpvid['bestprice'].'&euro;</strong><br>
                          '.$txt_persona_noche.'</td>
                       </tr>
                          <tr>
                            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentpvid['eid'])).'-'.$establimentpvid['eid'].'"><img src="'.CDN_BASE.'images/uploads/establiments/'.ImagePrincipalEstabliment($establimentpvid['eid']).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
                       </tr>
                    </table>
                    <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100%" height="10"></td>
                  </tr>
                  <tr>
                    <td>
                    <table cellspacing="0" cellpadding="0" align="center" width="90%">
                            <tr>
                                <td align="center" bgcolor="#F94B36" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #AC2717 solid;  padding:10px">
                                <a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casas_rurales.'/'.Query('provincies', 'title_url', 'pvid', $pvid).'/all/pers:'.$rs['persons'].'/checkin:'.date("d-m-Y",strtotime($rs['checkin'])).'/checkout:'.date("d-m-Y",strtotime($rs['checkout'])).'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: Arial, sans-serif; text-decoration: none; width:100%; padding:0px 20px display:inline-block">'.$txt_mas_casas_en.' '.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $rs['eid'])).'</a>
                              </td>
                            </tr>
                          </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="20"></td>
                  </tr>
                </table>

                <br>
                <strong style="font-size:24px; padding-bottom:15px; display:block; color:#4BA6DB">'.$txt_casas_similares_para.' '.$rs['persons'].' '.$txt_personas.'</strong>

                     <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;" bgcolor="#F1F1EF">

                        <tr>
                            <td width="70%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777;">
                                <a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentalt['eid'])).'-'.$establimentalt['eid'].'" style="font-size:18px;text-decoration:none; color:#E37F4B"><strong>'.Query('establiments', 'title', 'eid', $establimentalt['eid']).'</strong></a><br/>
                                  '.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $establimentalt['eid'])).' ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $establimentalt['eid'])).')<br/>
                                <strong style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                            <td width="30%" style="padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#232323;">
                            '.$txt_desde.'<br>
                            <strong style="font-size:24px;color:#E37F4B"">'.$establimentalt['bestprice'].'&euro;</strong><br>
                          '.$txt_persona_noche.'</td>
                       </tr>
                          <tr>
                            <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentalt['eid'])).'-'.$establimentalt['eid'].'"><img src="'.CDN_BASE.'images/uploads/establiments/'.ImagePrincipalEstabliment($establimentalt['eid']).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
                       </tr>
                    </table>
                    <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100%" height="10"></td>
                  </tr>
                  <tr>
                    <td>
                    <table cellspacing="0" cellpadding="0" align="center" width="90%">
                            <tr>
                                <td align="center" bgcolor="#F94B36" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #AC2717 solid;  padding:10px">
                                <a href="http://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casas_rurales.'/all/all/pers:'.$rs['persons'].'/checkin:'.date("d-m-Y",strtotime($rs['checkin'])).'/checkout:'.date("d-m-Y",strtotime($rs['checkout'])).'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: Arial, sans-serif; text-decoration: none; width:100%; padding:0px 20px display:inline-block">'.$txt_mas_casas_para.' '.$rs['persons'].' '.$txt_personas.'</a>
                              </td>
                            </tr>
                          </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="20"></td>
                  </tr>
                </table>
                </td>
          </tr>
          <tr>
            <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min">
                <a href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                Tlfn: 93.308.24.88</td>
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

    $from = array(ADMIN_BCC => 'Som Rurals');
    $subject = $subject_text;
    $email_client =  $rs['oemail'];

    set_time_limit(0);
    require_once '../includes/Swift/lib/swift_required.php'; //require lib

    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
      ->setUsername(ADMIN_BCC)
      ->setPassword('06INFrur12')
      ;

    $mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');

    $message = Swift_Message::newInstance($subject)
        ->setFrom($from)
        ->setCharset("UTF-8")
        ->setTo($email_client)
        ->setBody($body, 'text/html') or die('error here.');

    $mailer->send($message);
    $msg = "emailOK";
}

if (($restid == 4) && ($email!='no'))  { // -----------------------------------------------------------   Pagament Realitzat

    $db->where ("resid", $resid);
    $rs = $db->getOne("reservations");


    $db->where ("eid", $rs['eid']);
    $est = $db->getOne("establiments");

	switch ($rs['olanguage']) {
		case 'ca':
			$subject_text= "Somrurals | La teva reserva està confirmada";
			$txt_hello= "Hola";
			$txt_reserva_confirmada = "La teva reserva està confirmada";
			$txt_pago_recibido = "Hem rebut correctament el pagament anticipat de la reserva";
			$txt_codigo_reserva ="CODI DE RESERVA";
			$txt_documento_adjunto ="En el <strong>document adjunt</strong> trobareu la confirmació de la reserva, així com totes les dades d'aquesta.";
			$txt_recuerda_informar ="Recorda <strong>informar a la casa rural</strong> de l'hora aproximada de la teva entrada, per al lliurament de claus.<br><br>El <strongpagament pendent</strong> s'ha de fer en efectiu a la casa rural.<br>";
			$txt_respuesta_comentario = "En resposta al seu comentari";
			$txt_tu_reserva = "La teva reserva";
			$txt_entrada = "Entrada";
			$txt_salida = "Sortida";
			$txt_adultos = "Adults";
			$txt_ninos = "Nens";
			$txt_bebes = "Nadons";
			$txt_referencia = "Referència";
			$txt_total = "Total";
			$txt_anticipado = "Anticipat";
			$txt_restante = "Restant";
			$txt_tasa_turistica = "No inclou la taxa turística de 0,99 € per persona i dia.";
			$txt_datos_casa_rural = "Dades de la casa rural";
			$txt_tus_datos = "Les teves dades";
			$txt_nombre ="Nom";
			$txt_localidad ="Localitat";
			$txt_direccion ="Direcció";
			$txt_gps ="Coordenades GPS";
			$txt_telefono ="Telèfon";
			$txt_email ="Email";
			$txt_contacto ="Contacte";
			$txt_hora_entrada ="Hora d'entrada";
			$txt_hora_salida ="Hora de sortida";
			$txt_a_partir_de ="A partir de les";
			$txt_hasta_las ="Fins a les";
			$txt_apellidos ="Apellidos";
			$txt_pais ="País";
			$txt_idioma_contacto ="Idioma de contacte";
			$txt_comentarios ="Comentaris";
			$txt_recuerda_checkin = "Recorda que en realitzar el checking d'entrada has de proporcionar a la casa rural el teu nom i DNI per al registre.";
			$txt_consulta = "Davant de qualsevol consulta no dubtis en contactar amb nosaltres.";
			break;
		case 'fr':
			$subject_text= "Somrurals | Votre réservation est confirmée";
			$txt_hello= "Salut";
			$txt_reserva_confirmada = "Votre réservation est confirmée";
			$txt_pago_recibido = "Nous avons reçu votre paiement correctement.";
			$txt_codigo_reserva ="CODE DE RÉSERVATION";
			$txt_documento_adjunto ="";
			$txt_recuerda_informar ="Ne oubliez pas <strong>d'informer la maison</strong> de leur heure d'arrivée estimée.<br><br>Le <strong>reste du montant total</strong> sera payé à arrivée au gîte rural.<br>";
			$txt_respuesta_comentario = "En réponse à votre commentaire";
			$txt_tu_reserva = "Vos coordonnées";
			$txt_entrada = "Arrivée";
			$txt_salida = "Anticipé";
			$txt_adultos = "Adults";
			$txt_ninos = "Childrens";
			$txt_bebes = "Babies";
			$txt_referencia = "Référence";
			$txt_total = "Prix total";
			$txt_anticipado = "Anticipé";
			$txt_restante = "Montant qui reste à payer";
			$txt_tasa_turistica = "Non compris dans le tarif: 0.99 EUR de taxe de séjour par personne par nuit.";
			$txt_datos_casa_rural = "Gite/ Villa Details";
			$txt_tus_datos = "Vos coordonnées";
			$txt_nombre ="Nom";
			$txt_localidad ="Localité";
			$txt_direccion ="Adresse";
			$txt_gps ="GPS";
			$txt_telefono ="Téléphone";
			$txt_email ="Mail";
			$txt_contacto ="Personne à contacter";
			$txt_hora_entrada ="Arrivée";
			$txt_hora_salida ="Départ";
			$txt_a_partir_de ="A partir de las";
			$txt_hasta_las ="Hasta las";
			$txt_apellidos ="Prénom";
			$txt_pais ="Pays";
			$txt_idioma_contacto ="Langue pour contacter";
			$txt_comentarios ="Commentaires";
			$txt_recuerda_checkin = "Ne oubliez pas que lors de l'enregistrement, vous pouvez être invité à indiquer votre ID.";
			$txt_consulta = "Pour toute question, contactez-nous.";
			break;
		case 'en': 
			$subject_text= "Somrurals | Your reservation is confirmed";
			$txt_hello= "Hi";
			$txt_reserva_confirmada = "Your reservation is confirmed";
			$txt_pago_recibido = "Your reservation is confirmed. we have received correctly your prepayment.";
			$txt_codigo_reserva ="BOOKING CODE";
			$txt_documento_adjunto ="In the <strong>attachment</strong> you will find the booking confirmation.";
			$txt_recuerda_informar ="Remember <strong>to inform the house</strong> about your approximate check in hour.<br><br>The <strong>outstanding amount</strong> should be paid directly in the house, by cash.<br>";
			$txt_respuesta_comentario = "In response to your comment";
			$txt_tu_reserva = "Your booking details";
			$txt_entrada = "Check-in";
			$txt_salida = "Check-out";
			$txt_adultos = "Adults";
			$txt_ninos = "Childrens";
			$txt_bebes = "Babies";
			$txt_referencia = "Complete rental Reference";
			$txt_total = "Total Price";
			$txt_anticipado = "Prepayment";
			$txt_restante = "Outstanding amount";
			$txt_tasa_turistica = "Not included city tax: 0,99€ per person per night";
			$txt_datos_casa_rural = "House/ Villa Details";
			$txt_tus_datos = "Your Details";
			$txt_nombre ="Name";
			$txt_localidad ="Town";
			$txt_direccion ="Adress";
			$txt_gps ="GPS";
			$txt_telefono ="Phone";
			$txt_email ="Mail";
			$txt_contacto ="Contact";
			$txt_hora_entrada ="Check-in Hour";
			$txt_hora_salida ="Check-out Hour";
			$txt_a_partir_de ="A partir de las";
			$txt_hasta_las ="Hasta las";
			$txt_apellidos ="Surname";
			$txt_pais ="Country";
			$txt_idioma_contacto ="Contact Language";
			$txt_comentarios ="Comments";
			$txt_recuerda_checkin = "Remember that at check-in, you may be asked to provide your ID.";
			$txt_consulta = "For any questions, contact us.";
			break;		
		default: 
			$subject_text= "Somrurals | Tu reserva está confirmada";
			$txt_hello= "Hola";
			$txt_reserva_confirmada = "Tu reserva está confirmada";
			$txt_pago_recibido = "Hemos recibido correctamente el pago anticipado de tu reserva.";
			$txt_codigo_reserva ="CÓDIGO DE RESERVA";
			$txt_documento_adjunto ="En el <strong>documento adjunto</strong> encontrarás la confirmación de tu reserva, así como todos datos de esta.";
			$txt_recuerda_informar ="Recuerda <strong>informar a la casa rural</strong> de la hora aproximada de tu entrada, para la entrega de llaves.<br><br>El <strong>pago pendiente</strong> se debe hacer en efectivo en la casa rural.<br>";
			$txt_respuesta_comentario = "En respuesta a su comentario";
			$txt_tu_reserva = "Tu reserva";
			$txt_entrada = "Entrada";
			$txt_salida = "Salida";
			$txt_adultos = "Adultos";
			$txt_ninos = "Niños";
			$txt_bebes = "Bebes";
			$txt_referencia = "Referencia";
			$txt_total = "Total";
			$txt_anticipado = "Anticipado";
			$txt_restante = "Restante";
			$txt_tasa_turistica = "No incluye la tasa turística de 0´99 &euro; por persona y día.";
			$txt_datos_casa_rural = "Datos de la casa rural";
			$txt_tus_datos = "Tus datos";
			$txt_nombre ="Nombre";
			$txt_localidad ="Localidad";
			$txt_direccion ="Dirección";
			$txt_gps ="Coordenadas GPS";
			$txt_telefono ="Teléfono";
			$txt_email ="Email";
			$txt_contacto ="Contacto";
			$txt_hora_entrada ="Hora de entrada";
			$txt_hora_salida ="Hora de salida";
			$txt_a_partir_de ="A partir de las";
			$txt_hasta_las ="Hasta las";
			$txt_apellidos ="Apellidos";
			$txt_pais ="País";
			$txt_idioma_contacto ="Idioma de contacto";
			$txt_comentarios ="Comentarios";
			$txt_recuerda_checkin = "Recuerda que al realizar el checkin de entrada debes proporcionar a la casa rural tu nombre y DNI para el registro.";
			$txt_consulta = "Ante cualquier consulta no dudes en contactar con nosotros.";
			break;
	}

$body = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
        	<strong style="font-size:18px;line-height:30px">'.$txt_hello.' '.$rs['ofirstname'].',</strong>
            <img src="http://www.somrurals.com/images/email/ico-yes.png" width="89" height="89" alt="Confirmada" style="display:block; margin:0 auto;padding-bottom:15px">
            <strong style="font-size:24px; line-height:30px; display:block; text-align:center; padding-bottom:15px">'.$txt_reserva_confirmada.'</strong>
            '.$txt_pago_recibido.'<br><br>
            '.$txt_codigo_reserva.': <strong itemprop="reservationNumber">'.$rs['rescode'].'</strong>
            <br>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#E4F2FB">
                  <tbody><tr>
                    <td style="border: 1px #4BA6DB solid;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #ffffff; display: block; padding:7px 10px;font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#232323; text-align:center">
					'.$txt_documento_adjunto.'</td>
                  </tr>
            </tbody></table>
            <br/>
            '.$txt_recuerda_informar.'<br>
            <br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0 "style="border:1px #E7E7E5 solid; padding:10px;" >
              <tr>
                <td style="font-size:18px; display:block; padding:0px 0px 10px 0px;color:#4BA6DB""><strong>'.$txt_respuesta_comentario.'</strong></td>
              </tr>
              <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; line-height:22px;">La casa dispone de cunas para bebés de menos de un año, así como piscina y 100 metros cuadrados de jardín vallado para que no haya peligro de escape para mascotas y niños.</td>
              </tr>
            </table>
            <br/>
            
            <strong style="font-size:24px; display:block; padding:25px 0px 10px 0px;">'.$txt_tu_reserva.'</strong>
           
           <table width="100%" cellspacing="0" cellpadding="0">
           
           	<tbody><tr>
                <td style="border:1px #E7E7E5 solid;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                              <tr>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
								<meta id="_checkinTime10" itemprop="checkinTime" content="2014-10-30"><strong style="font-size:14px; color:#232323">'.$txt_entrada.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkin'])).'</td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                <meta id="_checkoutTime11" itemprop="checkoutTime" content="2014-11-03"><strong style="font-size:14px; color:#232323">'.$txt_salida.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkout'])).'</td>
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
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_adultos.':</strong> <span itemprop="numAdults">'.$rs['adults'].'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_ninos.':</strong> <span itemprop="numChildren">'.$rs['children'].'</span></td>
                                <td style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">'.$txt_bebes.'</strong> '.$rs['babies'].'</td>
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
                            <span itemprop="reservationFor" itemscope itemtype="http://schema.org/LodgingBusiness">
                            	<strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query('establiments', 'title_real', 'eid', $rs['eid']).'</a></strong><br/>
									<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" itemref="Ladress">
                          				<span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $rs['eid'])).'</span> (<span itemprop="addressRegion">'.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $rs['eid'])).'</span>)</span>
                   		  </span><br/>
                   		  <strong itemprop="lodgingUnitDescription" style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                          </td>
                        <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">'.$txt_referencia.': SR-112</td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_total.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="price">'.$rs['totalprice'].' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_anticipado.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['feeamount'].' &euro;</strong></td>
                      </tr>
                      <tr bgcolor="#F1F1EF">
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_restante.'</td>
                        <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.round($rs['totalprice'] - $rs['feeamount'],2).' &euro;</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;">'.$txt_tasa_turistica.'</td>
                        </tr>
                </table>
                
            	</td>
            </tr>
            </tbody>
            </table>
            
            <strong style="font-size:24px; padding-bottom:15px; display:block; padding:25px 0px 10px 0px;">'.$txt_datos_casa_rural.'</strong>
           
            <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
              <tbody>
              <tr bgcolor="#F1F1EF">
                <td width="36%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_nombre.'</td>
                <td width="64%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['title'].'</strong></td>
              </tr>
              <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_localidad.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.GetTitleLocalitat($est['lid']).'. '.GetTitleComarca ($est['comid']).' ('.GetTitleProvincia ($est['pvid']).')</strong></td>
              </tr>
              <tr bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_direccion.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="streetAddress" id="Ladress">'.$est['address'].'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_gps.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><a href="https://www.google.es/maps/@'.$est['gmap_lat'].','.$est['gmap_lng'].',15z"><strong>'.$est['gmap_lat'].','.$est['gmap_lng'].'</strong></a></td>
              </tr>
              <tr bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_telefono.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['phone'].' - ('.$est['fax'].' Fax)</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_email.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['email'].'</strong></td>
              </tr>
               <tr bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_contacto.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['ownername'].'</strong></td>
              </tr>
              <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_hora_entrada.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$txt_a_partir_de.' '.$est['checkintime'].'</strong></td>
              </tr>
               <tr bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_hora_salida.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$txt_hasta_las.' '.$est['checkouttime'].'</strong></td>
              </tr>
            </tbody>
            </table>
              
			<strong style="font-size:24px; padding-bottom:15px; display:block; padding:25px 0px 10px 0px;">'.$txt_tus_datos.'</strong>
           
            <table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
              <tbody id="_underName6" itemprop="underName" itemscope itemtype="http://schema.org/Person"><tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td width="36%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_nombre.'</td>
                <td width="64%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="name">'.$rs['ofirstname'].'</strong></td>
              </tr>
              <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_apellidos.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['olastname'].'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_telefono.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['ophone'].'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_email.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="email">'.$rs['oemail'].'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_pais.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['ocountry'].'</strong></td>
              </tr>
              <tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_idioma_contacto.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['language'].'</strong></td>
              </tr>
               <tr>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_comentarios.'</td>
                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['ocomments'].'</strong></td>
              </tr>
            </tbody>
            </table>
            <br/>
            '.$txt_recuerda_checkin.'<br>
            <br>
            '.$txt_consulta.'
		</td>
      </tr>
      <tr>
        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
			<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
        	Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
        	Tlfn: 93.308.24.88</td>
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
    </td>
  </tr>
 </tbody>
</table>

</body></html>
';

$from = array(ADMIN_BCC => 'Som Rurals');
$subject = $subject_text;
$email_client =  $rs['oemail'];

set_time_limit(0); 
require_once '../includes/Swift/lib/swift_required.php'; //require lib

$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
  ->setUsername(ADMIN_BCC)
  ->setPassword('06INFrur12')
  ;

$mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');

$message = Swift_Message::newInstance($subject)
	->setFrom($from)
	->setCharset("UTF-8")
	->setTo($email_client)
	->setBody($body, 'text/html') or die('error here.');
	
$mailer->send($message);
$msg = "emailOK";

}

$home = $db->rawQuery($query);
$log->logdbg('Consulta de actualización de eid: '.$query);

header("location: reservations_view_new.php?id=".$resid."&email=".$msg);
?>
