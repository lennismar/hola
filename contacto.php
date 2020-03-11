<?php 
include 'includes/config.php';

if (isset($_POST['enviar']) && $_POST['enviar'] == 1) {
	$referencia="";
	if ($_POST['referencia']!="") $referencia= " (". $_POST['referencia'].")";
	switch ($_POST['motivo'])  {
		case 'm1': $motivo ="Consulta sobre una casa rural"; break;
		case 'm2': $motivo ="Consulta sobre pagos"; break;
		case 'm3': $motivo ="Consulta sobre alta de casa rural"; break;
		default: $motivo ="Otros"; break;
	}
	
	$body = '
		<body style="background-color:#ffffff; margin:0; padding:0;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff;">		 
				<tr>
					<td style="font-size:20px; color:#000; font-family:Helvetica, Arial, Helvetica, sans-serif;">
						<h1>Som Rurals</h1>
					</td>
				</tr>
				
				<tr>
					<td style="font-size:12px; color:#000; font-family:Helvetica, Arial, Helvetica, sans-serif;"> 
						<strong>Tens una consulta de la web Som Rurals:</strong><br><br>
							• Motivo Consulta: '.$motivo.$referencia.'<br>
							• Email: '.$_POST['email'].'<br>
							• Telèfon: '.$_POST['telefono'].'<br>
							• Consulta: '.$_POST['comentario'].' <br><br>
					</td>
				 </tr>
			</table>
		</body>
	';
	
	/*
	$from = array('yorlenischetik@gmail.com' => 'Som Rurals');
	$subject = "Som Rurals - Consulta";
	
	set_time_limit(0); 
	require_once 'includes/Swift/lib/swift_required.php';
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
	  ->setUsername('yorlenischetik@gmail.com')
	  ->setPassword('06INFrur12')
	  ->setTimeout(15)
	  ;

	$mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');
	
	$message = Swift_Message::newInstance($subject)
		->setFrom($_POST['email'])
		->setCharset("UTF-8")
		->setTo('yorlenischetik@gmail.com')
		->setBody($body, 'text/html') or die('error here.');
		
	$mailer->send($message);
	*/
	
	$subject = $email_subject_prefix."Som Rurals - Consulta";
	$para = ADMIN_BCC;
	//$para = "hello@raysopinion.net";
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";	
	$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
	//$cabeceras .= 'Cc: cristianruiz82@gmail.com' . "\r\n";
	
	// Enviarlo
    transactional_mail($para, $subject, $body, $cabeceras);
}

$meta_title=CONTACTO." | SomRurals.com";
$meta_description=CONTACTO_SEO_DESCRIPCION;
$meta_keywords=SEO_HOME_KEYWORDS;
$meta_index="";
$meta_follow="";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

include("includes/head.php");

?>

<body>

<?php include("includes/tag-manager.php"); ?>

<script>
	
$().ready(function() {
	
	$("#ContactForm").validate({
		
		rules: {
				
			motivo:"required",		

			email: {
				required: true,
				email: true
			},
			
			repetir_email: {
				required: true,
				equalTo: "#email"
			},
				
			telefono: {
					required: true,
					digits: true
			},
				
			comentario: "required",
				
			check_condiciones: "required",
		},
			
		messages: {
			motivo: "Seleccione el motivo de tu consulta",
			email: "Por favor, introduce una dirección de email válida",
			repetir_email: {
				required: "Por favor, introduce tu email",
				equalTo: "El email debe coincidir"
			},
			telefono: {
				required: "<?php echo LIVE_VALIDATION_TELEFONO; ?>",
				digits: "El teléfono solo puede contener números"
			},
			comentario: "Por favor, explica el motivo de tu consulta",
			check_condiciones: "Por favor, acepta nuestra Política de Privacidad"
		}
	});
});

</script>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	
	<div class="hero--small hero-contact">
		
		<div class="hero-container">
		
			<div class="hero-inner--small">
			
				<h1 class="h1-header"><?php echo CONTACTO; ?></h1>
									
			</div>
			
		</div>
		
	</div>
	
	<script>
		$(function() {
	        $('#motivo').change(function(){
	            $('.motivo').hide();
	            $('#' + $(this).val()).show();
	        });
	    });
		
	</script>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<div  class="col-pad col-pad--half contact-form" id="main">
				<?php
                if (isset($_POST['enviar']) && $_POST['enviar'] == 1)  { 
				?>
                
				<div class="contact-gracias-tittle"><?php echo GRACIAS_POR_CONTACTAR; ?></div>
				<p><?php echo CONTACTO_ENVIO_OK; ?></p>

                <?php } else { ?>
					<form action="<?php echo $lng."/".URL_CONTACTO;?>" method="post" id="ContactForm" name="ContactForm">
						<input type="hidden" name="enviar" value="1">					
						<div class="label-group clearfix">

							<div class="label-group">

								<label><?php echo MOTIVO_DE_CONTACTO; ?></label>

								<select id="motivo" name="motivo" required>
									<option value="" disabled selected style="display:none; color:#777" ><?php echo SELECCIONA_UNA_OPCION; ?></option>
									<option value="m1"><?php echo CONSULTA_CASA_RURAL; ?></option>
									<option value="m2"><?php echo CONSULTA_PAGOS; ?></option>
									<option value="m3"><?php echo CONSULTA_ALTA_CASA; ?></option>
									<option value="m4"><?php echo OTROS; ?></option>
								</select>
							</div>

						</div>

						<div class="label-group motivo" id="m1" style="display:none">
							
							<label><?php echo REFERENCIA_CASA_RURAL; ?></label>

							<input type="text" placeholder="" class="" name="referencia" id="referencia" required>

							<div class="explanatory-text"><?php echo LA_ENCONTRARAS_FICHA; ?></div>

						</div>

						<div class="label-group">

							<label><?php echo EMAIL; ?></label>

							<input type="text" placeholder="" id="email" class="icon-input-email" name="email" required>

						</div>

						<div class="label-group">

							<label><?php echo REPETIR_EMAIL; ?></label>

							<input type="text" placeholder=""  id="repetir_email" class="icon-input-email" name="repetir_email" required>
							
						</div>
							
						<div class="label-group">
							
							<label><?php echo TELEFONO; ?></label>
								
							<input type="tel" placeholder=""  title="Solo números" pattern="[0-9]*" id="telefono" class="" name="telefono" required>
							
						</div>

						<div class="label-group">
								
							<label><?php echo CONSULTA; ?></label>
								
							<textarea class="form-control" rows="3" id="comentario" name="comentario" required></textarea>
							
						</div>
							
						<div class="label-group"><input type="checkbox" class="" id="check_condiciones" name="check_condiciones" required><?php echo ACEPTO_CONDICIONES; ?></div>
						
						
						<div class="label-group checkout-button">
		
							<input type="submit" value="<?php echo ENVIAR; ?>" name="enviando" class="btn btn--primary" />
		
						</div>
					</form>
                    <?php } ?>
			</div>
			
			<div class="col-pad col-pad--half contact-content">
			
				<p><?php echo CONTACTO_CONTENT; ?></p>
				
				<div class="contact-email"><a href="mailto:<?php echo ADMIN_BCC; ?>" class="icon icon--email-orange"><?php echo ADMIN_BCC; ?></a></div>
				
				<p><?php echo CONTACTO_CONTENT2; ?></p>
				
				<hr class="hr-line-1">
				
				<p><strong>Oficina Barcelona</strong><br />
					Espacio Mob-Barcelona.<br />
					Calle Bailen 11, Bajos, Barcelona 08010, Spain.<br />
					<?php echo ADMIN_BCC; ?><br />
					<?php echo $telefono_somrurals['humano']; ?></p>
				
				<hr class="hr-line-1">
				
				<p class="h6-header"><?php echo EN_REDES_SOCIALES; ?></p>
				
				<a class="footer-btn-ico" href="https://twitter.com/somrurals" target="_blank">
												
						<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47px" height="46px" viewBox="0 0 47 46" enable-background="new 0 0 47 46" xml:space="preserve">
						<g id="_x38_.-Contacto" sketch:type="MSPage">
							<g id="_x38_.1.Contacto-Desktop" transform="translate(-656.000000, -644.000000)" sketch:type="MSArtboardGroup">
								<g id="Group" transform="translate(649.000000, 592.500000)" sketch:type="MSLayerGroup">
									<g id="footer-ico-twitter" transform="translate(8.000000, 52.000000)" sketch:type="MSShapeGroup">
										<path class="footer-ico-fill" d="M29.591,16.475c-0.013-0.005-0.026-0.022-0.041-0.035
											c-0.823-0.716-1.788-1.059-2.901-1.017l-0.032-0.075c0.007-0.006,0.014-0.006,0.021-0.006c1.008-0.215,1.604-0.437,1.781-0.678
											c0.062-0.194-0.012-0.301-0.232-0.328c-0.506,0.06-0.973,0.161-1.392,0.315c0.528-0.315,0.733-0.536,0.618-0.651
											c-0.521,0.013-1.084,0.263-1.674,0.751c0.219-0.348,0.302-0.536,0.246-0.57c-0.279,0.182-0.528,0.376-0.74,0.583
											c-0.445,0.462-0.801,0.892-1.077,1.282l-0.013,0.034c-0.705,1.065-1.198,2.138-1.494,3.232l-0.109,0.081l-0.02,0.02
											c-0.427-0.497-0.933-0.912-1.544-1.249c-0.719-0.435-1.562-0.852-2.535-1.254c-1.063-0.509-2.14-0.933-3.23-1.26
											c-0.006,1.134,0.59,2.038,1.775,2.697v0.02c-0.418-0.008-0.822,0.053-1.213,0.167c0.076,1.054,0.878,1.777,2.4,2.18
											l-0.008,0.019c-0.597-0.032-1.09,0.162-1.473,0.565c0.5,0.912,1.384,1.347,2.666,1.314c-0.252,0.121-0.452,0.254-0.582,0.404
											c-0.234,0.228-0.309,0.498-0.234,0.803c0.276,0.464,0.769,0.678,1.496,0.646l0.039,0.046c-0.006,0.008-0.012,0.014-0.019,0.02
											c-1.255,1.209-2.769,1.75-4.547,1.639l-0.026,0.014c-1.082-0.008-2.242-0.49-3.496-1.457c1.262,1.689,2.934,2.911,5.005,3.676
											c2.371,0.731,4.744,0.785,7.109,0.16h0.04c2.298-0.617,4.244-1.884,5.847-3.803c0.742-1.005,1.208-1.963,1.392-2.884
											c1.2,0.041,2.064-0.282,2.6-0.964l-0.014-0.022c-0.397,0.134-1.179,0.095-2.338-0.126V20.64c0-0.005,0-0.005,0.008,0
											c1.268-0.133,2.016-0.516,2.256-1.148c-0.885,0.323-1.758,0.329-2.62,0.028C31.126,18.407,30.564,17.393,29.591,16.475"/>
										<circle class="footer-ico-stroke" fill="none" cx="22.5" cy="22.5" r="22.5"/>
									</g>
								</g>
							</g>
						</g>
						</svg>

					</a>
					
					<a class="footer-btn-ico" href="https://www.facebook.com/somrurals" target="_blank">
						
						<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47px" height="46px" viewBox="0 0 47 46" enable-background="new 0 0 47 46" xml:space="preserve">
						<g id="_x38_.-Contacto" sketch:type="MSPage">
							<g id="_x38_.1.Contacto-Desktop" transform="translate(-721.000000, -643.000000)" sketch:type="MSArtboardGroup">
								<g id="footer-ico-facebook" transform="translate(649.000000, 592.500000)" sketch:type="MSLayerGroup">
									<g id="facebook-2-_x2B_-Oval-2" transform="translate(73.000000, 51.000000)" sketch:type="MSShapeGroup">
										<path class="footer-ico-fill" d="M28.005,19.476H24.6V17.4c0-0.779,0.555-0.961,0.946-0.961h2.403v-3.427L24.639,13
											c-3.677,0-4.512,2.556-4.512,4.192v2.284H18v3.531h2.127v9.992H24.6v-9.992h3.016L28.005,19.476"/>
										<circle class="footer-ico-stroke" fill="none"  cx="22.5" cy="22.5" r="22.5"/>
									</g>
								</g>
							</g>
						</g>
						</svg>
					</a>
					
					<a class="footer-btn-ico" href="https://plus.google.com/117022694086662550685" target="_blank">
						
						<svg version="1.1" id="Layer_1" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47px" height="46px" viewBox="0 0 47 46" enable-background="new 0 0 47 46" xml:space="preserve">
							<g id="_x38_.-Contacto" sketch:type="MSPage">
								<g id="_x38_.1.Contacto-Desktop" transform="translate(-782.000000, -641.000000)" sketch:type="MSArtboardGroup">
									<g id="Group" transform="translate(649.000000, 592.500000)" sketch:type="MSLayerGroup">
										<g id="footer-ico-gplus" transform="translate(134.000000, 49.000000)" sketch:type="MSShapeGroup">
											<g id="google-plus-2" transform="translate(14.000000, 12.000000)">
												<path class="footer-ico-fill" d="M20.938,9.28h-2.771V6.533h-1.416V9.28h-2.771v1.343h2.771v2.747h1.416v-2.747h2.771V9.28"
													/>
												<path class="footer-ico-fill" d="M12.168,1.1h-1.659c0.644,0.52,1.919,1.523,1.919,3.602c0,2.022-1.176,2.98-2.352,3.881
													C9.713,8.938,9.293,9.322,9.293,9.923c0,0.601,0.42,0.929,0.727,1.176l1.01,0.764c1.23,1.012,2.35,1.941,2.35,3.828
													c0,2.57-2.627,5.187-7.441,5.187C1.878,20.878,0,18.973,0,16.949c0-0.985,0.502-2.379,2.156-3.336
													c1.734-1.039,4.086-1.176,5.346-1.258c-0.393-0.492-0.84-1.012-0.84-1.858c0-0.465,0.141-0.739,0.281-1.066
													C6.633,9.458,6.326,9.485,6.046,9.485c-2.967,0-4.647-2.161-4.647-4.292c0-1.257,0.395-2.743,1.597-3.754
													C4.592,0.154,6.632,0,8.145,0l5.836,0.001L12.168,1.1L12.168,1.1z M4.866,13.56c-0.616,0.218-2.407,0.874-2.407,2.815
													s1.932,3.336,4.927,3.336c2.686,0,4.116-1.26,4.116-2.952c0-1.396-0.924-2.133-3.053-3.61
													c-0.223-0.027-0.363-0.027-0.642-0.027C7.554,13.121,6.042,13.176,4.866,13.56L4.866,13.56z M6.438,0.997
													c-0.729,0-1.512,0.287-1.961,0.833c-0.476,0.575-0.615,1.38-0.615,2.092c0,1.831,1.092,4.866,3.5,4.866
													c0.699,0,1.454-0.396,1.903-0.834c0.643-0.63,0.699-1.435,0.699-1.927C9.965,4.059,8.761,0.997,6.438,0.997L6.438,0.997z"/>
											</g>
											<circle class="footer-ico-stroke"  fill="none" cx="22.5" cy="22.5" r="22.5"/>
										</g>
									</g>
								</g>
							</g>
						</svg>
					</a>
			</div>
		</div>
	</section>

<?php include("includes/footer.php"); ?>