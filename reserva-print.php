<?php 
include 'includes/config.php';
// Reserva de prueba: ADLH-1478-6916
// Reserva codificada: QURMSC0xNDc4LTY5MTY,
if(empty($_GET['rescode'])) { header('Location: '.URL_BASE); exit();}
//var_dump($_POST);
$rescode = SomruralsDecode($_GET['rescode']);

if(isset($rescode)) {

	include('includes/booking_data.php');
	if(empty($reserva['eid'])) { header('Location: '.URL_BASE); exit();}
} else { header('Location: '.URL_BASE); exit();}

?>


	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <base href="/">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1.0" />
		<meta name="format-detection" content="telephone=no" />

		<title>Somrurals</title>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,,700italic,700' rel='stylesheet' type='text/css' />
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
			/*]]>*/
		</style>
	</head>

	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table width="960" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" valign="top">
				<!-- Contenido -->

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="padding:10px; color:#E37F4B;font-family:'Open sans', sans-serif; font-size:30px;"><strong>Somrurals</strong></td>

						<td style="font-family:'Open sans', sans-serif; font-size:20px; text-align: right; color:#ccc; padding:10px;"><strong>Confirmación de reserva</strong></td>
					</tr>
				</table>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="14%"><img src="<?php echo CDN_BASE; ?>assets/img/ico-yes.png" width="89" height="89" alt="Confirmada" style="display:block; margin:0 auto;padding-bottom:15px" /></td>

						<td width="86%" style="font-family:'Open sans', sans-serif; font-size:14px; color:#222; padding:10px;"><strong style="font-size:18px;line-height:30px">Hola <?php echo $ofirstname; ?>,</strong> <strong style="font-size:24px; line-height:30px; display:block; padding-bottom:15px">Tu reserva está confirmada</strong> Hemos recibido correctamente el pago anticipado de tu&nbsp;reserva.<br />
							<br />
							CÓDIGO DE RESERVA: <strong itemprop="reservationId"><?php echo $rescode; ?></strong><br />
							<br />
							Recuerda informar a la casa rural de la hora aproximada de tu entrada, para la entrega de llaves.<br />
							<br />
							El pago pendiente se debe hacer en efectivo en la casa rural.</td>
					</tr>
				</table>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="48%">
							<strong style="font-size:24px;font-family:'Open sans', sans-serif; display:block; padding:25px 0px 10px 0px;">Tu reserva</strong>

							<table width="100%" cellspacing="0" cellpadding="0">
								<tbody>
								<tr>
									<td style="border:1px #E7E7E5 solid;">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tbody>
											<tr>
												<td width="33%" style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;" align="center"><strong style="font-size:14px; color:#232323">Entrada:</strong><br />
                                                    <?php echo date('d/m/Y', $datein); ?></td>

												<td width="33%" style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;">
													<hr style="width:100%; height:1px; border:0; margin:0; padding:0; background:#ccc;" />
												</td>

												<td width="33%" style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;" align="center"><strong style="font-size:14px; color:#232323">Salida:</strong><br />
                                                    <?php echo date('d/m/Y', $dateout); ?></td>
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
											<tbody>
											<tr>
												<td style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Adultos:</strong> <span itemprop="numAdults"><?php echo $adults;?></span></td>

												<td style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Niños:</strong> <span itemprop="numChildren"> <?php echo $children;?></span></td>

												<td style="padding:10px 0px 10px 10px; font-family:'Open sans', sans-serif; font-size:18px; color:#777;"><strong style="font-size:14px; color:#232323">Bebes:</strong> <?php echo $babies;?></td>
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
												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#777;"><span itemprop="reservationFor" itemscope="" itemtype="http://schema.org/LodgingBusiness"><strong itemprop="name" style="font-size:18px;"><a href="#" style=" color:#E37F4B; text-decoration:none" itemprop="url"><?php echo $title; ?></a></strong><br />
                                                    <span itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress" itemref="Ladress"><span itemprop="addressLocality"><?php echo GetTitleLocalitat($lid); ?> (<?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?>)</span></span><br />
													<strong itemprop="lodgingUnitDescription" style="color:#232323">Casa rural completa</strong></td>

												<td bordercolor="#CCCCCC" style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#777; text-align:right;"><?php echo REFERENCIA; ?> SR-<?php echo $id; ?></td>
											</tr>

											<tr bgcolor="#F1F1EF">
												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Total</td>

												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="totalPrice"><?php echo number_format( $totalprice, 2)?>€</strong></td>
											</tr>

											<tr>
												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Anticipado</td>

												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo number_format( $anticipat, 2)?>€</strong></td>
											</tr>

											<tr bgcolor="#F1F1EF">
												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Restante</td>

												<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo number_format( ($totalprice - $anticipat), 2)?>€</strong></td>
											</tr>

											<tr>
												<td colspan="2" style="padding:10px; font-family:'Open sans', sans-serif; font-size:12px; color:#232323;">No incluye la tasa turística de 0´50 € por persona y día.</td>
											</tr>
										</table>
									</td>
								</tr>
								</tbody>
							</table>
						</td>

						<td width="4%"></td>

						<td width="48%">
							<strong style="font-family:'Open sans', sans-serif;font-size:24px; padding-bottom:15px; display:block; padding:25px 0px 10px 0px;">Datos de la casa rural</strong>

							<table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
								<tbody>
								<tr bgcolor="#F1F1EF">
									<td width="36%" style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Nombre</td>

									<td width="64%" style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $title_real; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Localidad</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo GetTitleLocalitat($lid); ?> (<?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?>)</strong></td>
								</tr>

								<tr bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Dirección</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="streetAddress" id="Ladress"><?php echo $address; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Coordenadas GPS</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong>(<?php echo $gmap_lat; ?>) (<?php echo $gmap_lng; ?>)</strong></td>
								</tr>

								<tr bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Teléfono</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $phone; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">eMail</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $email; ?></strong></td>
								</tr>

								<tr bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Contacto</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $ownername; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Hora de entrada</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong>A partir de las <?php echo $checkintime; ?></strong></td>
								</tr>

								<tr bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Hora de salida</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong>Hasta las <?php echo $checkouttime; ?></strong></td>
								</tr>
								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Hora salida en reservas de semanas</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong>Hasta las <?php echo $checkouttime_weeks; ?></strong></td>
								</tr>

                                <?php if(!empty($fianza)) { ?>
								<tr bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Fianza</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $fianza; ?></strong></td>
								</tr>
                                <?php } ?>
                                </tbody>
							</table>
						</td>
					</tr>
				</table><br />
				<br />

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="48%">
							<strong style="font-family:'Open sans', sans-serif;font-size:24px; padding-bottom:15px; display:block; padding:25px 0px 10px 0px;">Tus datos</strong>

							<table width="100%" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid;">
								<tbody id="_underName6" itemprop="underName" itemscope="" itemtype="http://schema.org/Person">
								<tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
									<td width="36%" style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Nombre</td>

									<td width="64%" style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="name"><?php echo $ofirstname; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Apellidos</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $olastname; ?></strong></td>
								</tr>

								<tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Telefono</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $ophone; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Población</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $ocity; ?></strong></td>
								</tr>

								<tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Email</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong itemprop="email"><?php echo $oemail; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">País</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $ocountry; ?></strong></td>
								</tr>

								<tr style="border-top: 1px #E7E7E5 solid;" bgcolor="#F1F1EF">
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Idioma de contacto</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $idiomas_descripcion[$olanguage]; ?></strong></td>
								</tr>

								<tr>
									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323;">Comentarios</td>

									<td style="padding:10px; font-family:'Open sans', sans-serif; font-size:14px; color:#232323; text-align:right"><strong><?php echo $ocomments; ?></strong></td>
								</tr>
								</tbody>
							</table>
						</td>

						<td width="4%">&nbsp;</td>

						<td width="48%" valign="top" style="font-family:'Open sans', sans-serif; font-size:14px; color:#222;">
							<?php if(!empty($oresponse)) { ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px #E7E7E5 solid; padding:10px; margin-bottom:20px">
								<tr>
									<td style="font-size:18px; display:block; padding:0px 0px 10px 0px;font-family:'Open sans', sans-serif;color:#4BA6DB"><strong>En respuesta a su comentario</strong></td>
								</tr>

								<tr>
									<td style="font-family:'Open sans', sans-serif; font-size:14px; color:#777; line-height:22px;"><?php echo $oresponse; ?></td>
								</tr>
							</table>
                            <?php } // Fin del IF que comprueba si hay respuesta a comentario ?>
                            Recuerda que al realizar el checking de entrada debes proporcionar a la casa rural tu nombre y DNI para el registro.<br />
							<br />
							Ante cualquier consulta no dudes en contactar con nosotros.<br />
							<br />
							<a itemprop="url" href="http://www.somrurals.com" style="text-decoration:none; color:#232323;font-family:'Open sans', sans-serif; font-size:14px;"><strong itemprop="name">Somrurals</strong></a><br />
							Email: <a href="mailto:<?php echo ADMIN_BCC ?>" style="text-decoration:none; color:#E37F4B"><?php echo ADMIN_BCC ?></a><br />
							Tlfn: <?php echo $telefono_somrurals['humano']; ?>
						</td>
					</tr>
				</table><!-- / Contenido  -->
			</td>
		</tr>
	</table>
	</body>
    <script type="text/javascript">
        <!--
        window.onload = function() { window.print(); }
        //-->
    </script>
	</html>
