<?php

/*
 * Función para actualizar estado de una reserva (y envío de email si corresponde)
 *
 *
 * devuelve true/false
 */


function updateReservation($restid, $resid, $email = 'yes', $response ='') {
    $debug = false;
    global $log, $allow_email_bcc, $email_bcc_address, $config_DB_datetime_format, $email_subject_prefix;
    $db = MysqliDb::getInstance();
    $db->where('resid',$resid);
    $reserva_original=$db->getOne('reservations','resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, response, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid');

    if($debug) $log->loginfo('Entro en función de actualización de reserva ('.$restid.', '.$resid.', '.$email.', '.$response.')');

    if (($restid == 2) && ($email!='no')) { // -----------------------------------------------------------   Disponible - Pago anticipado Pendiente

        /*$query_response = "UPDATE reservations SET response = '$response' WHERE resid='$resid'";
        mysqli_query($query_response);*/
        $db->where('resid',$resid);
        $data=Array('response'=>$response);
        $db->update('reservations',$data);

        /*$rs_query = mysqli_query("SELECT resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid FROM reservations WHERE resid = " . $resid);
        $rs = mysqli_fetch_array($rs_query);*/
        $db->where('resid',$resid);
        $rs=$db->getOne('reservations','resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid');

//if(empty($_GET['rescode'])) { header('Location: '.URL_BASE); exit();}
//var_dump($_POST);
        $rescode_encoded = SomruralsEncode($rs['rescode']);
        $payment_script = '';
        switch($rs['olanguage']) {
            case 'ca':
                $payment_script = 'reserva-pagament';
                break;
            case 'en':
                $payment_script = 'book-payment';
                break;
            case 'fr':
                $payment_script = 'reservations-paiement';
                break;
            default:
                $payment_script = 'reserva-pago';
                break;
        }
        $payment_url = 	URL_BASE.$rs['olanguage'].'/'.$payment_script.'/'.$rescode_encoded;

        switch ($rs['olanguage']) {
            case 'ca':
                $subject_text= "Somrurals | La teva casa rural està disponible";
                $txt_hello= "Hola";
                $txt_casa_disponible= "La teva casa rural està disponible!";
                $txt_confirmar_reserva= '<strong>Per confirmar la teva reserva has de realitzar el</strong> <strong style="color:#E37F4B;">pagament anticipat abans de 24 hores</strong> indicat l\'import de la reserva, mitjançant transferència bancària al següent número de compte:';
                $txt_confirmar_reserva_1= '<strong>Per confirmar la teva reserva has de </strong> <strong style="color:#E37F4B;">pagar amb targeta</strong> en el següent link a la nostra web:';
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
                $txt_pagar_con_tarjeta = "PAGAR AMB TARGETA DE CRÈDIT";
                break;
            case 'fr':
                $subject_text= "Somrurals | Votre maison est disponible";
                $txt_hello= "Salut";
                $txt_casa_disponible= "Votre maison est disponible!";
                $txt_confirmar_reserva= '<strong>Une fois la maison confirme sa disponibilité, </strong> <strong style="color:#E37F4B;">les dates resteront fermée pendant 24 heures,</strong> vous devrez alors faire le paiement anticipé par virement bancaire au numéro de compte indiqué:';
                $txt_confirmar_reserva_1= '<strong>Pour confirmer votre réservation, </strong> <strong style="color:#E37F4B;">vous devez payer par carte de crédit</strong> sur le lien suivant sur notre site:';
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
                $txt_pagar_con_tarjeta = "PAY PAR CARTE DE CRÉDIT";
                break;
            case 'en':
                $subject_text= "Somrurals | Your house is available";
                $txt_hello= "Hi";
                $txt_casa_disponible= "Your house is available!";
                $txt_confirmar_reserva= '<strong>To confirm your reservation, </strong> <strong style="color:#E37F4B;">you have to make the advance payment within 24 hours,</strong> indicated the amount of the reserve, by bank transfer to the following account:';
                $txt_confirmar_reserva_1= '<strong>To confirm your reservation </strong> <strong style="color:#E37F4B;">you must pay by credit card</strong> on the following link to our website:';
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
                $txt_pagar_con_tarjeta = "PAY WITH A CREDIT CARD";
                break;
            default:
                $subject_text= "Somrurals | Tu casa rural está disponible";
                $txt_hello= "Hola";
                $txt_casa_disponible= "¡Tu casa rural está disponible!";
                $txt_confirmar_reserva= '<strong>También puedes (aunque es más lento) confirmar tu reserva realizando un</strong> <strong style="color:#E37F4B;">pago anticipado antes de 24 horas</strong> indicado del importe de la reserva, mediante transferencia bancaria al siguiente número de cuenta:';
                $txt_confirmar_reserva_1= '<strong>Para confirmar tu reserva </strong> <strong style="color:#E37F4B;">debes pagar con tarjeta</strong> en el siguiente link a nuestra web:';
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
                $txt_pagar_con_tarjeta = "PAGAR CON TARJETA DE CRÉDITO";
                break;
        }


        $body = '
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="initial-scale=1.0" />
                <meta name="format-detection" content="telephone=no" />

                <title>Somrurals</title>
                <link href=\'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,,700italic,700\' rel=\'stylesheet\' type=\'text/css\' />
                <style type="text/css">
            /*<![CDATA[*/
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
                /*]]>*/
                </style>
                <meta id="_checkinTime10" itemprop="checkinTime" content="'.date("Y-m-d",strtotime($rs['checkin'])).'" />
                <meta id="_checkoutTime11" itemprop="checkoutTime" content="'.date("Y-m-d",strtotime($rs['checkout'])).'" />
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
                    <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

                        <span style="font-size:18px;line-height:30px"><strong>'.$txt_hello.' '.$rs['ofirstname'].',</strong></span><br/>
                        <span style="font-size:30px; line-height:30px"><strong>'.$txt_casa_disponible.'</strong></span><br/><br/>
                        <span style="font-size:16px;">'.$txt_confirmar_reserva_1.'</span><br/><br/>
                        <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100%" height="20">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                            <table cellspacing="0" cellpadding="0" align="center" width="90%">
                                <tr>
                                    <td align="center" bgcolor="#81C824" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #487D02 solid;  padding:10px">
                                        <a href="'.$payment_url.'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: \'Open sans\', sans-serif; text-decoration: none; width:100%; display:inline-block">'.$txt_pagar_con_tarjeta.'</a>
                                    </td>
                                </tr>
                                </table>
                            </td>
                          </tr>
                          <tr>
                            <td height="20">&nbsp;</td>
                          </tr>
                        </table>

                        <span>'.$txt_confirmar_reserva.'</span><br/><br/>
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

            ';

        if ($response !="") {
            $body .='
                        <br>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0 "style="border:1px #E7E7E5 solid; padding:10px;" >
                          <tr>
                            <td style="font-size:18px; display:block; padding:0px 0px 10px 0px;color:#4BA6DB""><strong>'.$txt_respuesta.'</strong></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; line-height:22px;">'.$response.'</td>
                          </tr>
                        </table>
            ';
        }

        $body .='
                        <br>
                        <strong style="font-size:24px; display:block; padding:25px 0px 10px 0px;">'.$txt_tu_reserva.'</strong>

                       <table width="100%" cellspacing="0" cellpadding="0">

                        <tbody><tr>
                            <td style="border:1px #E7E7E5 solid;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tbody>
                                          <tr>
                                            <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                            <strong style="font-size:14px; color:#232323">'.$txt_entrada.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkin'])).'</td>
                                            <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                            <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                            <strong style="font-size:14px; color:#232323">'.$txt_salida.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkout'])).'</td>
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
                                      <strong itemprop="lodgingUnitDescription" style="color:#232323">'.((!empty($tipo))?GetTitleTipus($tipo):'').'</strong>
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
                        <a itemprop="url" href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                        Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                        Tlfn: 93 293 55 27</td>
                  </tr>
                  <tr>
                    <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                    <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tbody><tr>
                            <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                            </tr>
                          <tr>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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

        //echo $body;
        $subject = $email_subject_prefix.$subject_text;
        $para = $rs['oemail'];
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
        $bcc = array();
        if ($allow_email_bcc == true && !empty($email_bcc_address)) {
            $cabeceras .= 'Bcc:  '.implode(', ', $email_bcc_address).''."\r\n";
            $bcc = array_merge ($bcc, $email_bcc_address);
        }

        $envio = transactional_mail($para, $subject, $body, $cabeceras, $bcc);
        if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }

        $msg = "emailOK";
        $log->loginfo("enviado email a ".$rs['oemail']." con el asunto '". $subject."'");

        //exit();
    }


    if ($restid == 3) {
        $db->where('eid', $reserva_original['eid']);
        $est = $db->getOne('establiments', '*');

        $db->where('resid',$resid);
        $rs=$db->getOne('reservations','resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid');
        $est_reserva_inmediata = $est['reserva_inmediata'];
        $texto_reserva_inmediata = false;
        if($est_reserva_inmediata == '1' && $rs['restid'] == '6') { $texto_reserva_inmediata = true; } // Si el establecimiento acepta reseervas inmediatas y estoy cancelando una reserva que estaba como 'pago retenido pendiente de disponibilidad' asumo que es que no había disponibilidad tras confirmar el pago.
        $email = 'yes';
    }

    if (($restid == 3) && ($email!='no')) { // -----------------------------------------------------------   NO Disponible

        /*$rs_query = mysqli_query("SELECT resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid FROM reservations WHERE resid = " . $resid);
        $rs = mysqli_fetch_array($rs_query);*/


        $txt_advertencia = '';
        switch ($rs['olanguage']) {
            case 'ca':
                $subject_text= "Somrurals | La teva casa rural no està disponible, tenim altres opcions";
                $txt_hello= "Hola";
                $txt_casa_nodisponible= "Ho sentim, no hi ha disponibilitat per a la casa que has seleccionat";
                $txt_opciones= "No obstant això, tenim altres opcions que et poden agradar. I molt.";
                $txt_casas_similares_en ="Casas similars a";
                $txt_desde ="Desde";
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_casa_nodisponible = "Tu reserva no ha sido aceptada";
                    $txt_opciones = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.<br/>No obstant això, tenim altres opcions que et poden agradar. I molt.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_casa_nodisponible = "Tu reserva no ha sido aceptada";
                    $txt_opciones = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.<br/>Nous avons d'autres options que vous pourriez aimer.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_casa_nodisponible = "Tu reserva no ha sido aceptada";
                    $txt_opciones = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.<br/>However, we have other options that you might like.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_casa_nodisponible = "Tu reserva no ha sido aceptada";
                    $txt_opciones = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.<br/>Sin embargo, tenemos otras opciones que te pueden gustar. Y mucho.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta name="viewport" content="initial-scale=1.0" />
                <meta name="format-detection" content="telephone=no" />

                <title>Somrurals</title>
                <link href=\'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,,700italic,700\' rel=\'stylesheet\' type=\'text/css\' />
                <style type="text/css">
            /*<![CDATA[*/
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
                /*]]>*/
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
                    <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
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

                                      <a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentpvid['eid'])).'-'.$establimentpvid['eid'].'" style="font-size:18px;text-decoration:none; color:#E37F4B"><strong>'.Query('establiments', 'title', 'eid', $establimentpvid['eid']).'</strong></a><br/>
                                        '.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $establimentpvid['eid'])).' ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $establimentpvid['eid'])).')<br/>
                                        <strong style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                                  </td>
                                    <td width="30%" style="padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#232323;">
                                    '.$txt_desde.'<br>
                                    <strong style="font-size:24px;color:#E37F4B"">'.$establimentpvid['bestprice'].'&euro;</strong><br>
                                  '.$txt_persona_noche.'</td>
                               </tr>
                                  <tr>
                                    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentpvid['eid'])).'-'.$establimentpvid['eid'].'"><img src="'.CDN_BASE.'images/uploads/establiments/'.ImagePrincipalEstabliment($establimentpvid['eid']).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
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
                                        <a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casas_rurales.'/'.Query('provincies', 'title_url', 'pvid', $pvid).'/all/pers:'.$rs['persons'].'/price:all/checkin:'.date("d-m-Y",strtotime($rs['checkin'])).'/checkout:'.date("d-m-Y",strtotime($rs['checkout'])).'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: \'Open sans\', sans-serif; text-decoration: none; width:100%; display:inline-block">'.$txt_mas_casas_en.' '.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $rs['eid'])).'</a>
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
                                        <a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentalt['eid'])).'-'.$establimentalt['eid'].'" style="font-size:18px;text-decoration:none; color:#E37F4B"><strong>'.Query('establiments', 'title', 'eid', $establimentalt['eid']).'</strong></a><br/>
                                          '.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $establimentalt['eid'])).' ('.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $establimentalt['eid'])).')<br/>
                                        <strong style="color:#232323">'.GetTitleTipus ($tipo).'</strong>
                                  </td>
                                    <td width="30%" style="padding:5px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#232323;">
                                    '.$txt_desde.'<br>
                                    <strong style="font-size:24px;color:#E37F4B"">'.$establimentalt['bestprice'].'&euro;</strong><br>
                                  '.$txt_persona_noche.'</td>
                               </tr>
                                  <tr>
                                    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;"><a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casa_rural.'/'.urls_amigables(Query('establiments', 'title', 'eid', $establimentalt['eid'])).'-'.$establimentalt['eid'].'"><img src="'.CDN_BASE.'images/uploads/establiments/'.ImagePrincipalEstabliment($establimentalt['eid']).'" width="550" height="298" alt="Casarural" style="display:block; width:100%; height:auto;"/></a></td>
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
                                        <a href="https://www.somrurals.com/'.$rs['olanguage'].'/'.$url_casas_rurales.'/all/all/pers:'.$rs['persons'].'/price:all/checkin:'.date("d-m-Y",strtotime($rs['checkin'])).'/checkout:'.date("d-m-Y",strtotime($rs['checkout'])).'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: \'Open sans\', sans-serif; text-decoration: none; width:100%; display:inline-block">'.$txt_mas_casas_para.' '.$rs['persons'].' '.$txt_personas.'</a>
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
                                '.$txt_advertencia.'.<br/>

                        </td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min">
                        <a href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                        Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                        Tlfn: 93 293 55 27</td>
                  </tr>
                  <tr>
                    <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                    <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tbody><tr>
                            <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                            </tr>
                          <tr>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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

        $subject = $email_subject_prefix.$subject_text;
        $para = $rs['oemail'];
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
        $bcc = array();
        if ($allow_email_bcc == true && !empty($email_bcc_address)) {
            $cabeceras .= 'Bcc:  '.implode(', ', $email_bcc_address).''."\r\n";
            $bcc = array_merge ($bcc, $email_bcc_address);
        }

        $envio = transactional_mail($para, $subject, $body, $cabeceras, $bcc);
        if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }

        $msg = "emailOK";
        $log->loginfo("enviado email a ".$rs['oemail']." con el asunto '". $subject."' y cabceras ".$cabeceras);

    }

    if (($restid == 4) && ($email!='no' || $reserva_original['restid'] == '6'))  { // -----------------------------------------------------------   Pagament Realitzat

        /*$rs_query = mysqli_query("SELECT resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, response, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid FROM reservations WHERE resid = " . $resid);
        $rs = mysqli_fetch_array($rs_query);*/
        $db->where('resid',$resid);
        $rs=$db->getOne('reservations','resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, response, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid');
        if(empty($rs)) { $log->loginfo('Reserva '.$resid.' no encontrada'); return false; }

        /*$rs_est = mysqli_query("SELECT * FROM establiments WHERE eid = " . $rs['eid']);
        $est = mysqli_fetch_array($rs_est);*/
        $db->where('eid',$rs['eid']);
        $est=$db->getOne('establiments','*');
        if(empty($est)) { $log->loginfo('Establecimiento '.$rs['eid'].' no encontrado'); return false; }

        $rescode_encoded = SomruralsEncode($rs['rescode']);
        $payment_script = '';
        switch($rs['olanguage']) {
            case 'ca':
                $payment_script = 'reserva-imprimir';
                break;
            case 'en':
                $payment_script = 'book-print';
                break;
            case 'fr':
                $payment_script = 'reservations-imprimer';
                break;
            default:
                $payment_script = 'reserva-imprimir';
                break;
        }
        $printing_url = 	URL_BASE.$rs['olanguage'].'/'.$payment_script.'/'.$rescode_encoded;

        switch ($rs['olanguage']) {
            case 'ca':
                $subject_text= "Somrurals | La teva reserva està confirmada";
                $txt_hello= "Hola";
                $txt_reserva_confirmada = "La teva reserva està confirmada";
                $txt_pago_recibido = "Hem rebut correctament el pagament anticipat de la reserva";
                $txt_codigo_reserva ="CODI DE RESERVA";
                //$txt_documento_adjunto ="En el <strong>document adjunt</strong> trobareu la confirmació de la reserva, així com totes les dades d'aquesta.";
                $txt_documento_adjunto ="Aquest <strong>correu electrònic</strong> es la teva confirmació de la reserva. La teva casa rural està reservada.";
                $txt_recuerda_informar ="Recorda <strong>informar a la casa rural</strong> de l'hora aproximada de la teva entrada, per al lliurament de claus.<br><br>El <strongpagament pendent</strong> s'ha de fer en efectiu a la casa rural.<br>";
                $txt_respuesta_comentario = "En resposta al seu comentari";
                $txt_tu_reserva = "La teva reserva";
                $txt_entrada = "Entrada";
                $txt_fianza = "Fianza";
                $txt_salida = "Sortida";
                $txt_salida_semana = "Hora de sortida en reserves d'una setmana: ";
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
                $txt_indicaciones="Indicacions";
                $txt_impresion="versió per imprimir";
                $txt_pagar_en_la_entrada = "PAGAMENT A L'ENTRADA. ";

                break;
            case 'fr':
                $subject_text= "Somrurals | Votre réservation est confirmée";
                $txt_hello= "Salut";
                $txt_reserva_confirmada = "Votre réservation est confirmée";
                $txt_pago_recibido = "Nous avons reçu votre paiement correctement.";
                $txt_codigo_reserva ="CODE DE RÉSERVATION";
                $txt_documento_adjunto ="Cet e-mail est votre confirmation de réservation.";
                $txt_recuerda_informar ="Ne oubliez pas <strong>d'informer la maison</strong> de leur heure d'arrivée estimée.<br><br>Le <strong>reste du montant total</strong> sera payé à arrivée au gîte rural.<br>";
                $txt_respuesta_comentario = "En réponse à votre commentaire";
                $txt_tu_reserva = "Vos coordonnées";
                $txt_fianza = "Lien";
                $txt_entrada = "Arrivée";
                $txt_salida = "Anticipé";
                $txt_salida_semana = "Heure de départ pour les réservations d'une semaine ";
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
                $txt_indicaciones="Indications";
                $txt_impresion="Version imprimable";
                $txt_pagar_en_la_entrada = "PAIEMENT POUR ARRIVER À LA MAISON. ";

                break;
            case 'en':
                $subject_text= "Somrurals | Your reservation is confirmed";
                $txt_hello= "Hi";
                $txt_reserva_confirmada = "Your reservation is confirmed";
                $txt_pago_recibido = "Your reservation is confirmed. we have received correctly your prepayment.";
                $txt_codigo_reserva ="BOOKING CODE";
                $txt_documento_adjunto ="This email is your booking confirmation.";
                $txt_recuerda_informar ="Remember <strong>to inform the house</strong> about your approximate check in hour.<br><br>The <strong>outstanding amount</strong> should be paid directly in the house, by cash.<br>";
                $txt_respuesta_comentario = "In response to your comment";
                $txt_tu_reserva = "Your booking details";
                $txt_fianza = "Deposit";
                $txt_entrada = "Check-in";
                $txt_salida = "Check-out";
                $txt_salida_semana = "Check-out Hour in one week bookings ";
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
                $txt_indicaciones="Indications";
                $txt_impresion="Printable version";
                $txt_pagar_en_la_entrada = "PAYMENT WHEN MAKING CHECK IN. ";

                break;
            default:
                $subject_text= "Somrurals | Tu reserva está confirmada";
                $txt_hello= "Hola";
                $txt_reserva_confirmada = "Tu reserva está confirmada";
                $txt_pago_recibido = "Hemos recibido correctamente el pago anticipado de tu reserva.";
                $txt_codigo_reserva ="CÓDIGO DE RESERVA";
                $txt_documento_adjunto ="Este <strong>correo electrónico</strong> es tu confirmación de reserva. La casa rural está reservada.";
                $txt_recuerda_informar ="Recuerda <strong>informar a la casa rural</strong> de la hora aproximada de tu entrada, para la entrega de llaves.<br><br>El <strong>pago pendiente</strong> se debe hacer en efectivo en la casa rural.<br>";
                $txt_respuesta_comentario = "En respuesta a su comentario";
                $txt_tu_reserva = "Tu reserva";
                $txt_fianza = "Fianza";
                $txt_entrada = "Entrada";
                $txt_salida = "Salida";
                $txt_salida_semana = "Hora salida en reservas de semanas ";
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
                $txt_indicaciones="Indicaciones";
                $txt_impresion="Versión para imprimir";
                $txt_pagar_en_la_entrada = "PAGO EN LA ENTRADA. ";

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
                    <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">
                        <strong style="font-size:18px;line-height:30px">'.$txt_hello.' '.$rs['ofirstname'].',</strong>
                        <img src="https://www.somrurals.com/images/email/ico-yes.png" width="89" height="89" alt="Confirmada" style="display:block; margin:0 auto;padding-bottom:15px">
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
                        <br />
                        <a href="'.$printing_url.'" style="color:#E37F4B; display:block; text-align:center"><strong>'.$txt_impresion.'</strong></a><br />
                        <br />
            ';

        if ($rs['response'] !="") {
            $body .='
                        <br>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0 "style="border:1px #E7E7E5 solid; padding:10px;" >
                          <tr>
                            <td style="font-size:18px; display:block; padding:0px 0px 10px 0px;color:#4BA6DB""><strong>'.$txt_respuesta_comentario.'</strong></td>
                          </tr>
                          <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; line-height:22px;">'.$rs['response'].'</td>
                          </tr>
                        </table>
            ';
        }

        $body .='
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
                                            <strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query('establiments', 'title', 'eid', $rs['eid']).'</a></strong><br/>
                                                <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" itemref="Ladress">
                                                    <span itemprop="addressLocality">'.GetTitleLocalitat (Query('establiments', 'lid', 'eid', $rs['eid'])).'</span> (<span itemprop="addressRegion">'.GetTitleProvincia (Query('establiments', 'pvid', 'eid', $rs['eid'])).'</span>)</span>
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
                                    <td colspan="2" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;">'.(($rs['eid'] == '500')?$txt_pagar_en_la_entrada:'').$txt_tasa_turistica.'</td>
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
                            <td width="64%" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['title_real'].'</strong></td>
                          </tr>
                          <tr>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_localidad.'</td>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.GetTitleLocalitat($est['lid']).'. '.GetTitleComarca ($est['comid']).' ('.GetTitleProvincia ($est['pvid']).')</strong></td>
                          </tr>
                          <tr bgcolor="#F1F1EF">
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_direccion.'</td>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="streetAddress" id="Ladress">'.$est['address'].'</strong></td>
                          </tr>';
        if($est["indications_".$rs['olanguage']]!=""){
            $body.='<tr bgcolor="#F1F1EF">
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_indicaciones.'</td>
                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="streetAddress" id="Ladress">'.$est["indications_".$rs['olanguage']].'</strong></td>
                            </tr>';
        }
        $body.='<tr>
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
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$txt_hasta_las.' '.$est['checkouttimeto'].'</strong></td>
                          </tr> 
                           <tr bgcolor="#F1F1EF">
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_salida_semana.'</td>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$txt_hasta_las.' '.$est['checkouttime_weeks'].'</strong></td>
                          </tr>';
                if(!empty($est['fianza'])) {
                    $body.='<tr bgcolor="#F1F1EF">
                                    <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_fianza.'</td>
                                    <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$est['fianza'].'€</strong></td>
                                  </tr>';
                }
                $body.='</tbody>
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
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['olanguage'].'</strong></td>
                          </tr>
                           <tr>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;">'.$txt_comentarios.'</td>
                            <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.$rs['ocomments'].'</strong></td>
                          </tr>
                        </tbody>
                        </table><br />
                        <a href="'.$printing_url.'" style="display:block; color:#E37F4B; text-align:center"><strong>'.$txt_impresion.'</strong></a><br />
                        <br/>
                        '.$txt_recuerda_checkin.'<br>
                        <br>
                        '.$txt_consulta.'
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
                        <a itemprop="url" href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                        Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                        Tlfn: 93 293 55 27</td>
                  </tr>
                  <tr>
                    <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                    <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tbody><tr>
                            <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                            </tr>
                          <tr>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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

        $subject = $email_subject_prefix.$subject_text;
        $para = $rs['oemail'];
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
        $cabeceras .= 'Bcc: '.$est['email']. "\r\n";
        $bcc = array($est['email']);
        if ($allow_email_bcc == true && !empty($email_bcc_address)) {
            $cabeceras .= 'Bcc: '.$est['email'].', '.implode(', ', $email_bcc_address).''."\r\n";
            $bcc = array_merge ($bcc, $email_bcc_address);
        }

        $envio = transactional_mail($para, $subject, $body, $cabeceras, $bcc);
        if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }

        $msg = "emailOK";
        $log->loginfo("enviado email de confirmación de pago a ".$rs['oemail']." con el asunto '". $subject."'");

    }

//$query = "UPDATE reservations SET restid ='$restid' WHERE resid='$resid'";
    $data = array('restid' => $restid, 'payment_request' => date($config_DB_datetime_format));
    $db->where('resid',$resid);
    $db->update('reservations',$data);
    if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());
    /*$SQL = "INSERT INTO reservations_history (resid, restid, user, date) VALUES(";
    $SQL .= $resid.",";
    $SQL .= $restid.",";
    $SQL .= "'".$_SESSION['type_user']."',";
    $SQL .= "'".date("Y-m-d H:i:s")."')";
    mysqli_query($SQL);*/
    $data=Array(
        'restid'=>$restid,
        'resid'=>$resid,
        'user'=>(empty($_SESSION['type_user']))?'customer':$_SESSION['type_user'],
        'date'=>date($config_DB_datetime_format)
    );
    $db->insert('reservations_history',$data);
    if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());

    return true;
}




/*
 * Función para cancelar una reserva (y envío de email si corresponde)
 *
 *
 * devuelve true/false
 */


function cancelReservation($resid, $email = 'yes', $restore_availability = false, $restid = 5)
{
    $debug = false;
    global $log, $allow_email_bcc, $email_bcc_address, $config_DB_datetime_format, $config_DB_date_format, $email_subject_prefix;
    $db = MysqliDb::getInstance();
    //$restid = 5; // Estado cancelada

    if ($debug) echo '<br/>restid: '.$restid;
    if ($debug) {
        $log->loginfo('Entro en función de cancelación de reserva ( '.$resid.', '.$email.')');
    }
    $db->where('resid', $resid);
    $rs = $db->getOne(
        'reservations',
        'resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, response, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid'
    );

    $db->where('eid', $rs['eid']);
    $est = $db->getOne('establiments', '*');
    $est_reserva_inmediata = $est['reserva_inmediata'];
    $texto_reserva_inmediata = false;
    if($est_reserva_inmediata == '1' && $rs['restid'] == '6') $texto_reserva_inmediata = true;  // Si el establecimiento acepta reseervas inmediatas y estoy cancelando una reserva que estaba como 'pago retenido pendiente de disponibilidad' asumo que es que no había disponibilidad tras confirmar el pago.

    if($texto_reserva_inmediata && $debug) echo 'true!'; else echo 'false!';
    if($texto_reserva_inmediata) $email = 'yes';    // Si estoy cancelando una reserva como 'no disponible' pero no es de reserva inmediata NO envío email

    if ($debug) echo '<br/>est: '.$est_reserva_inmediata;
    if ($debug) echo '<br/>restid: '.$rs['restid'];
    if ($debug) echo '<br/>email: '.$email;


    if($email == 'yes') {
        switch ($rs['olanguage']) {
            case 'ca':
                $subject_text = "Somrurals | La teva reserva ha expirat";
                $txt_hello = "Hola";
                $txt_reserva_cancelada = "El teu termini de reserva ha expirat";
                $txt_pago_no_recibido = "El pagament anticipat necessari per a la reserva de la casa no ha estat rebut";
                $txt_advertencia = "Si hi ha hagut algun error en el pagament o no ha estat rebut, si us plau posa't en contacte amb nosaltres el més aviat possible";
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_reserva_cancelada = "Tu reserva no ha sido aceptada";
                    $txt_pago_no_recibido = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                break;
            case 'fr':
                $subject_text = "Somrurals | Votre période de réservation a expiré";
                $txt_hello = "Salut";
                $txt_reserva_cancelada = "Votre période de réservation a expiré";
                $txt_pago_no_recibido = "L'acompte requis pour réserver la maison n'a pas été reçu";
                $txt_advertencia = "Si il ya eu une erreur dans le paiement ou n'a pas été reçu, s'il vous plaît nous contacter dès que possible";
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_reserva_cancelada = "Tu reserva no ha sido aceptada";
                    $txt_pago_no_recibido = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                break;
            case 'en':
                $subject_text = "Somrurals | Your reservation has expired";
                $txt_hello = "Hi";
                $txt_reserva_cancelada = "Your booking period has expired";
                $txt_pago_no_recibido = "The advance payment required to reserve the house has not been received";
                $txt_advertencia = "If there has been an error in the payment or has not been received, please contact us as soon as possible";
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_reserva_cancelada = "Tu reserva no ha sido aceptada";
                    $txt_pago_no_recibido = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                break;
            default:
                $subject_text = "Somrurals | Tu plazo de reserva ha expirado";
                $txt_hello = "Hola";
                $txt_reserva_cancelada = "Tu plazo de reserva ha expirado";
                $txt_pago_no_recibido = "El pago anticipado necesario para la reserva de la casa no ha sido recibido";
                $txt_advertencia = "Si ha habido algún error en el pago o no ha sido recibido, por favor ponte en contacto con nosotros lo antes posible";
                if($texto_reserva_inmediata) {
                    $subject_text = "Somrurals | Tu reserva no ha sido aceptada";
                    $txt_hello = "Hola";
                    $txt_reserva_cancelada = "Tu reserva no ha sido aceptada";
                    $txt_pago_no_recibido = "Tras recibir tu pago anticipado y confirmar con la casa la disponibilidad de las fechas nos hemos encontrado con un problema inesperado de disponibilidad que nos impide confirmar tu reserva, por lo que no tenemos más remedio que cancelarla.<br/>Lamentamos mucho las molestias provocadas por este inconveniente.";
                    $txt_advertencia = "Hemos procedido a reembolsarte el importe que habías adelantado directamente a la misma forma de pago que utilizaste para abonarlo (según cada entidad bancaria esta devolución puede hacerse efectiva entre 24 y 72 horas).";
                }
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
                        <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff" class="container">

                            <tbody>
                            <tr>
                            <td height="20" class="clear-mobile" bgcolor="#f1f1Ef" align="center"></td>
                          </tr>
                          <tr>
                            <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
                          </tr>
                          <tr>
                            <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

                                <span style="font-size:18px;line-height:30px"><strong>'.$txt_hello.' '.$rs['ofirstname'].',</strong></span><br/>
                                <strong style="font-size:24px; line-height:30px">'.$txt_reserva_cancelada.'</strong><br/><br/>
                                '.$txt_pago_no_recibido.'.<br>
                                <br>
                                <table width="100%" cellspacing="0" cellpadding="0">

                                <tbody><tr>
                                    <td style="border:1px #E7E7E5 solid;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
                                                  <tr>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                                    <meta id="_checkinTime10" itemprop="checkinTime" content="'.date(
                "Y-m-d",
                strtotime($rs['checkin'])
            ).'"><strong style="font-size:14px; color:#232323">'.$txt_entrada.':</strong><br/>'.date(
                "d/m/Y",
                strtotime($rs['checkin'])
            ).'</td>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                                    <meta id="_checkoutTime11" itemprop="checkoutTime" content="'.date(
                "Y-m-d",
                strtotime($rs['checkout'])
            ).'"><strong style="font-size:14px; color:#232323">'.$txt_salida.':</strong><br/>'.date(
                "d/m/Y",
                strtotime($rs['checkout'])
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
                                                        <strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.Query(
                'establiments',
                'title',
                'eid',
                $rs['eid']
            ).'</a></strong><br/>
                                                            <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                                                <span itemprop="addressLocality">'.GetTitleLocalitat(
                Query('establiments', 'lid', 'eid', $rs['eid'])
            ).'</span> ('.GetTitleProvincia(Query('establiments', 'pvid', 'eid', $rs['eid'])).')</span>
                                                  </span><br/>
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
                                                <td style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; text-align:right"><strong>'.round(
                $rs['totalprice'] - $rs['feeamount'],
                2
            ).' &euro;</strong></td>
                                              </tr>
                                              <tr>
                                                <td colspan="2" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#232323;">'.$txt_tasa_turistica.'</td>
                                                </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                <br>
                                '.$txt_advertencia.'.<br/><br>
                           </td>
                           </tr>
                      <tr>
                        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
                            <a itemprop="url" href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                            Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                            Tlfn: 93 293 55 27</td>
                      </tr>
                      <tr>
                        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tbody><tr>
                                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                                </tr>
                              <tr>
                                <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                                <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                                <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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
        //exit('-------'.$body);

        $subject = $email_subject_prefix.$subject_text;
        $para = $rs['oemail'];
        //$para = 'juanjo.nieto@gmail.com';
        $cabeceras = 'MIME-Version: 1.0'."\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8'."\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>'."\r\n";
        $cabeceras .= 'Bcc: '.$est['email']."\r\n";
        $bcc = array($est['email']);
        if ($allow_email_bcc == true && !empty($email_bcc_address)) {
            $cabeceras .= 'Bcc: '.$est['email'].', '.implode(', ', $email_bcc_address).''."\r\n";
            $bcc = array_merge ($bcc, $email_bcc_address);
        }

        $envio = transactional_mail($para, $subject, $body, $cabeceras, $bcc);
        if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }

        $log->loginfo("enviado email a ".$rs['oemail']." con el asunto '".$subject."'");



        // EMAIL PARA EL ESTABLECIMIENTO
        $subject_text = $email_subject_prefix."Somrurals | El client no ha confirmat la reserva";
        $txt_hello = "Hola";
        $txt_reserva_cancelada = "El client no ha confirmat la reserva, pots tornar a ficar la teva disponibilitat activa";
        $txt_entrada = "Entrada";
        $txt_salida = "Sortida";
        $txt_adultos = "Adults";
        $txt_ninos = "Nens";
        $txt_bebes = "Nadons";
        $txt_referencia = "Referència";
        $establiment_title = Query('establiments','title_real','eid',$rs['eid']);
        if(empty($establiment_title)) $establiment_title = Query('establiments','title','eid',$rs['eid']);
        $body_establiment = '
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
                            <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
                          </tr>
                          <tr>
                            <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

                                <span style="font-size:18px;line-height:30px"><strong>'.$txt_hello.' '.Query('establiments','username','eid',$rs['eid']).',</strong></span><br/>
                                <strong style="font-size:24px; line-height:30px">'.$txt_reserva_cancelada.'</strong><br/><br/>
                                <table width="100%" cellspacing="0" cellpadding="0">

                                <tbody><tr>
                                    <td style="border:1px #E7E7E5 solid;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
                                                  <tr>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                                    <meta id="_checkinTime10" itemprop="checkinTime" content="'.date("Y-m-d",strtotime($rs['checkin'])).'"><strong style="font-size:14px; color:#232323">'.$txt_entrada.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkin'])).'</td>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;"><hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;"></td>
                                                    <td width="33%" style="padding:10px 0px 10px 10px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#777;" align="center">
                                                    <meta id="_checkoutTime11" itemprop="checkoutTime" content="'.date("Y-m-d", strtotime($rs['checkout'])).'"><strong style="font-size:14px; color:#232323">'.$txt_salida.':</strong><br/>'.date("d/m/Y",strtotime($rs['checkout'])).'</td>
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
                                                        <strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url">'.$establiment_title.'</a></strong><br/>
                                                            <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                                                <span itemprop="addressLocality">'.GetTitleLocalitat(Query('establiments', 'lid', 'eid', $rs['eid'])).'</span> ('.GetTitleProvincia(Query('establiments', 'pvid', 'eid', $rs['eid'])).')</span>
                                                  </span><br/>
                                                  </td>
                                                <td bordercolor="#CCCCCC" style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#777; text-align:right;">'.$txt_referencia.': SR-'.$rs['eid'].'</td>
                                              </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                                <br>
                           </td>
                           </tr>
                      <tr>
                        <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">
                            <a itemprop="url" href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                            Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                            Tlfn: 93 293 55 27</td>
                      </tr>
                      <tr>
                        <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                        <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tbody><tr>
                                <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                                </tr>
                              <tr>
                                <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                                <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                                <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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

        $subject = $email_subject_prefix.$subject_text;
        $para = $est['email'];
        //$para = 'juanjo.nieto@gmail.com';
        $cabeceras = 'MIME-Version: 1.0'."\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8'."\r\n";
        $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>'."\r\n";
        $cabeceras .= 'Bcc: '.$est['email']."\r\n";
        $bcc = array($est['email']);
        if ($allow_email_bcc == true && !empty($email_bcc_address)) {
            $cabeceras .= 'Bcc: '.$est['email'].', '.implode(', ', $email_bcc_address).''."\r\n";
            $bcc = array_merge ($bcc, $email_bcc_address);
        }

        // envio email al establecimiento solo si es una cancelación normal (y NO es una cancelación de reserva inmediata.. que esas están motivadas por los establecimientos y no hace falta comunicarselo)
        if(!$texto_reserva_inmediata) {
            $envio = transactional_mail($para, $subject, $body_establiment, $cabeceras, $bcc);
            if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }
            $log->loginfo("enviado email a ".$rs['oemail']." con el asunto '".$subject."'");
        }
        $msg = "emailOK";

        //echo $body;
    }   // Fin del IF de envío de email


    // Actualización del estado de la reserva
    $data = array('restid' => $restid);
    $db->where('resid',$resid);
    $db->update('reservations',$data);
    if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());


    // Liberación de la disponibilidad
    if($restore_availability) {
        $date = $rs['checkin'];
        $date_ = explode('-', $date);
        $real_date = mktime(0, 0, 1, $date_[1], $date_[2], $date_[0]);
        $dateout = $rs['checkout'];
        $dateout_ = explode('-', $dateout);
        $real_dateout = mktime(0, 0, 1, $dateout_[1], $dateout_[2], $dateout_[0]);
        if ($debug) $log->loginfo("Volviendo a poner disponible la casa ".$rs['eid']." entre las fechas ".$date." y ".$dateout);
        $cont = 0;
        while ($real_date < $real_dateout && $cont<50) { // Recorrido del intervalo de fechas
            $data = array('availability' => 1);
            $db->where('eid', $rs['eid']);
            $db->where('date', date("Y-m-d", $real_date));
            $db->update('establiments_prices', $data);
            if ($debug) $log->loginfo("Last executed query was ".$db->getLastQuery());
            $date = date($config_DB_date_format ,strtotime(" +1 day", $real_date)); // Guardamos la fecha siguiente
            $real_date = strtotime('+1 day', $real_date); // Guardamos la fecha siguiente
            if ($debug) $log->loginfo("Voy a comprobar el día siguiente: ".$date);
            $cont++;
           // echo "<br>Last executed query was ".$db->getLastQuery();
        }
    }

    //return true;
    // Actualización del histórico de la reserva
    $data = array(
        'restid'=>$restid,
        'resid'=>$resid,
        'user'=>(empty($_SESSION['type_user']))?'customer':$_SESSION['type_user'],
        'date'=>date($config_DB_datetime_format)
    );
    $db->insert('reservations_history',$data);
    if($debug) $log->loginfo("Last executed query was ". $db->getLastQuery());

    return true;
}




/*
 * Función para crear el registro de una nueva valoración para una reserva
 *
 *
 * devuelve true/false
 */

function createComment ($resid) {
    $debug = false;
    global $log;
    $db = MysqliDb::getInstance();

    if($debug) $log->loginfo('Entro en función de creación de valoración para reserva ('.$resid.')');
    $db->where ("resid", $resid);
    $reservation = $db->getOne ("reservations");

    $db->where ('comcode', $reservation['rescode']);
    $users = $db->get ("comments");
    if ($db->count > 0) return false;

    $data = array (
        "comcode" => $reservation['rescode'],
        "eid" => $reservation['eid'],
        "resid" => $reservation['resid']
    );
    $id = $db->insert ('comments', $data);
    echo "Last executed query was ". $db->getLastQuery();

    if($id) return true;
    else {
        if($debug) $log->loginfo('Creación de valoración ha fallado: '.$db->getLastError());
        return false;
    }

}



/*
 * Función para enviar email de solicitud de encuesta al usuario
 *
 *
 * devuelve true/false
 */

function sendEmailComment ($resid) {
    $debug = false;
    global $log, $allow_email_bcc, $email_bcc_address,$email_subject_prefix;
    $db = MysqliDb::getInstance();

    if($debug) $log->loginfo('Entro en función de solicitud de valoración para reserva ('.$resid.')');
    $db->where ("resid", $resid);
    $reservation = $db->getOne ("reservations");

    $db->where ("eid", $reservation['eid']);
    $establecimiento = $db->getOne ("establiments");
    //if($debug) print_r($establecimiento);
    // Si ya hay una encuesta rellena para este código, no se envía email
    $db->where ('comcode', $reservation['rescode']);
    $db->where ('state', 1);
    $users = $db->get ("comments");
    if ($db->count > 0) return false;

    // Composición de la URL de destino del link que llevará a la encuesta
    switch($reservation['olanguage']) {
        case 'ca':
            $url_sufix = 'valoracions';
            break;
        case 'en':
            $url_sufix = 'rate';
            break;
        case 'fr':
            $url_sufix = 'evaluation';
            break;
        default:
            $url_sufix = 'valoraciones';
            break;
    }
    $enlace_encuesta = URL_BASE.$reservation['olanguage'].'/'.$url_sufix.'/'.$reservation['rescode'];


    // Traducciones para el email en función del idioma de la reserva original
    switch($reservation['olanguage']) {
        case 'ca':
            define('VALORACIONES_EMAIL_CLIENTE_HOLA','Hola');
            define('VALORACIONES_EMAIL_SUBJECT','Somrurals | Valoració de la teva visita');
            define('VALORACIONES_EMAIL_TITLE','Vas disfrutar de la teva estància?');
            define('VALORACIONES_EMAIL_FILL_SURVEY','EMPLENAR ENQUESTA');
            define('VALORACIONES_EMAIL_FIRST','Ens hem donat compte que fa uns dies vas visitar');
            define('VALORACIONES_EMAIL_SATISFACTION','Las satisfacció dels nostres clientes es el més important per nosaltres, ens agradaria que emplenis aquesta breu enquesta respecte la teva estància. Estem segur que la teva opinió ens servirà per millorar de cara al futur.');
            define('VALORACIONES_EMAIL_END','Merci per la teva opinió que ens ajudar a millorar.<br/><br/>Si tens cap mena de dubte, contacta amb nosaltres.');
            break;
        case 'en':
            define('VALORACIONES_EMAIL_CLIENTE_HOLA','Hello');
            define('VALORACIONES_EMAIL_SUBJECT','Somrurals | Rating your visit');
            define('VALORACIONES_EMAIL_TITLE','You enjoy your stay?');
            define('VALORACIONES_EMAIL_FILL_SURVEY','FILL SURVEY');
            define('VALORACIONES_EMAIL_FIRST','We noticed a few days ago you visited');
            define('VALORACIONES_EMAIL_SATISFACTION','The satisfaction of our customers is important to us, we would like to fill out this short survey about your stay. Your opinion matters!');
            define('VALORACIONES_EMAIL_END','Thank you for your opinion.');
            break;
        case 'fr':
            define('VALORACIONES_EMAIL_CLIENTE_HOLA','Salut');
            define('VALORACIONES_EMAIL_SUBJECT','Somrurals | Notation de votre visite');
            define('VALORACIONES_EMAIL_TITLE','Vous apprécierez votre séjour?');
            define('VALORACIONES_EMAIL_FILL_SURVEY','ENQUÊTE');
            define('VALORACIONES_EMAIL_FIRST','Nous avons remarqué il ya quelques jours, vous visité');
            define('VALORACIONES_EMAIL_SATISFACTION','La satisfaction de nos clients est importante pour nous, nous tenons à remplir ce court sondage sur votre séjour.');
            define('VALORACIONES_EMAIL_END','Nous vous remercions de votre opinion va nous aider à améliorer.');
            break;
        default:
            define('VALORACIONES_EMAIL_CLIENTE_HOLA','Hola');
            define('VALORACIONES_EMAIL_SUBJECT','Somrurals | Valoración de tu visita');
            define('VALORACIONES_EMAIL_TITLE','¿Disfrutaste de tu estancia?');
            define('VALORACIONES_EMAIL_FILL_SURVEY','RELLENAR ENCUESTA');
            define('VALORACIONES_EMAIL_FIRST','Nos hemos dado cuenta que ya hace unos días que estuviste en');
            define('VALORACIONES_EMAIL_SATISFACTION','La satisfacción de nuestros clientes es lo más importante para nosotros, por lo que nos encantaría que rellenaras una brevísima encuesta respecto a tu estancia. Estamos seguros que tu opinión nos servirá para mejorar de cara al futuro.');
            define('VALORACIONES_EMAIL_END','Muchas gracias de antemano por tu colaboración que nos ayuda a mejorar.<br><br>Ante cualquier consulta no dudes en contactar con nosotros.');
            break;
    }

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
                    <td bgcolor="#E37F4B" style="padding:10px; text-align:center" align="center"><img src="https://www.somrurals.com/images/email/logo-somrurals.png" width="149" height="44" alt="Somrurals" style="display:block; margin:0 auto"/></td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323; line-height:22px;" class="pad-min">

                        <span style="font-size:18px;line-height:30px"><strong>'.VALORACIONES_EMAIL_CLIENTE_HOLA.' '.$reservation['ofirstname'].',</strong></span><br/>
                        <span style="font-size:30px; line-height:30px"><strong>'.VALORACIONES_EMAIL_TITLE.'</strong></span><br/><br/>
                        <span style="font-size:16px;">'.VALORACIONES_EMAIL_FIRST.' <strong style="color:#E37F4B;">'.((empty($establecimiento['title_real']))?$establecimiento['title']:$establecimiento['title_real']).'</strong>.</span><br/><br/>
                        '.VALORACIONES_EMAIL_SATISFACTION.'
                        <table width="100%" style="text-align:center;" align="center"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="100%" height="20">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                            <table cellspacing="0" cellpadding="0" align="center" width="90%">
                                    <tr>
                                        <td align="center" bgcolor="#81C824" style="-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; color: #fff; display: block; border-bottom:3px #487D02 solid;  padding:10px">
                        <a href="'.$enlace_encuesta.'" style="color:#ffffff; font-size:16px; font-weight: bold; font-family: Arial, sans-serif; text-decoration: none; width:100%; padding:0px 20px display:inline-block">'.VALORACIONES_EMAIL_FILL_SURVEY.'</a>
                                            </td>
                                    </tr>
                                    </table>
                            </td>
                          </tr>
                          <tr>
                            <td height="20">&nbsp;</td>
                          </tr>
                        </table>

                        '.VALORACIONES_EMAIL_END.'
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:15px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#232323;" class="pad-min" id="_bookingAgent14" itemprop="bookingAgent" itemscope itemtype="http://schema.org/Person">


                        <a itemprop="url" href="https://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:Arial, Helvetica, sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br>
                        Email: <a href="mailto:'.ADMIN_BCC.'" style="text-decoration:none; color:#E37F4B">'.ADMIN_BCC.'</a><br/>
                        Tlfn: 93.308.24.88</td>
                  </tr>
                  <tr>
                    <td style="padding:20px; border-top: 1px #f1f1Ef solid; text-align:center">

                    <table width="150" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tbody><tr>
                            <td colspan="3" style="padding-bottom:10px; text-align:center"><a href="https://www.somrurals.com" style="text-decoration:none; color:#777;font-family:Arial, Helvetica, sans-serif; font-size:14px;">www.somrurals.com</a></td>
                            </tr>
                          <tr>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-facebook.png" width="32" height="32" alt="facebook" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://www.facebook.com/somrurals"><img src="https://www.somrurals.com/images/email/ico-twitter.png" width="32" height="32" alt="Twitter" style="display:block; margin:0 auto"/></a></td>
                            <td><a href="https://plus.google.com/117022694086662550685"><img src="https://www.somrurals.com/images/email/ico-gplus.png" width="32" height="32" alt="gplus" style="display:block; margin:0 auto"/></a></td>
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

    $subject = $email_subject_prefix.VALORACIONES_EMAIL_SUBJECT;
    $para = $reservation['oemail'];
    //$para = 'juanjo.nieto@gmail.com';
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
    $log->loginfo("enviado email a ".$reservation['oemail']." con el asunto '". $subject."'");
    $bcc = array();
    if ($allow_email_bcc == true && !empty($email_bcc_address)) {
        $cabeceras .= 'Bcc: '.implode(', ', $email_bcc_address).''."\r\n";
        $bcc = array_merge ($bcc, $email_bcc_address);
    }

    $envio = transactional_mail($para, $subject, $body, $cabeceras, $bcc);
    if(!$envio || ($envio && !empty($envio['code']) && $envio['code'] != 'success')) { $log->loginfo('Fallo al enviar ');  $log->loginfo(var_export($envio, true)); return false; }
    $log->loginfo("enviado email a ".$reservation['oemail']." con el asunto '".$subject."'");

    $msg = "emailOK";
    //echo $subject;
   // echo $body;

    return true;


}