<?php 
include 'includes/config.php';

$meta_title=AÑADE_CASA . "| SomRurals.com";
$meta_description=CASA_NUEVA_SEO_DESCRIPCION;
$meta_keywords=AÑADE_CASA. ", somrurals, som rurals";
$meta_index="";
$meta_follow="";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

include("includes/head.php"); 

if (isset($_POST['enviar']) && $_POST['enviar'] == 1) {
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
						<strong>Un client s\'ha possat en contacte per afegir la seva casa:</strong><br><br>
							• Nom i Cognoms: '.$_POST['nombre']. ' ' . $_POST['apellidos'].'<br>
							• Email: '.$_POST['email'].'<br>
							• Telèfon: '.$_POST['telefono'].'<br>
							• Comentaris: '.$_POST['comentarios'].' <br><br>
					</td>
				 </tr>
			</table>
		</body>
	';
	
	/*
	$from = array('yorlenischetik@gmail.com' => 'Som Rurals');
	$subject = "Som Rurals - Afegir Casa";
	
	set_time_limit(0); 
	require_once 'includes/Swift/lib/swift_required.php'; //require lib
	
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
	  ->setUsername('yorlenischetik@gmail.com')
	  ->setPassword('06INFrur12')
	  ;
	
	$mailer = Swift_Mailer::newInstance($transport) or die('Error creating mailer.');
	
	$message = Swift_Message::newInstance($subject)
		->setFrom($_POST['email'])
		->setCharset("UTF-8")
		->setTo('yorlenischetik@gmail.com')
		->setBody($body, 'text/html') or die('error here.');
		
	$mailer->send($message);
	*/
	
	$subject = $email_subject_prefix."Som Rurals - Afegir Casa";
	$para = ADMIN_BCC;
	//$para = "hello@raysopinion.net";
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";	
	//$cabeceras .= 'To: Som Rurals <yorlenischetik@gmail.com>' . "\r\n";
	$cabeceras .= 'From: Som Rurals <'.ADMIN_BCC.'>' . "\r\n";
	//$cabeceras .= 'Cc: cristianruiz82@gmail.com' . "\r\n";
    $bcc = array();
    if ($allow_email_bcc == true && !empty($email_bcc_address)) {
        $cabeceras .= 'Bcc:  '.implode(', ', $email_bcc_address).''."\r\n";
        $bcc = array_merge ($bcc, $email_bcc_address);
    }
	
	// Enviarlo
    transactional_mail($para, $subject, $body, $cabeceras, $bcc);
	
}
?>

<body>

<?php include("includes/tag-manager.php"); ?>

<script>
	
$().ready(function() {
	
	$("#ContactForm").validate({
		
		rules: {

			nombre:"required",
			
			apellidos:"required",
				
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
				
			comentarios: "required"
				
		},
			
		messages: {
			nombre: "<?php echo LIVE_VALIDATION_NOMBRE; ?>",		
			apellidos: "<?php echo LIVE_VALIDATION_APELLIDOS; ?>",
			motivo: "Seleccione el motivo de tu consulta",
			email: "<?php echo LIVE_VALIDATION_EMAIL_CORRECTO; ?>",
			repetir_email: {
				required: "<?php echo LIVE_VALIDATION_EMAIL; ?>",
				equalTo: "<?php echo LIVE_VALIDATION_EMAIL_MATCH; ?>"
			},
			telefono: {
				required: "<?php echo LIVE_VALIDATION_TELEFONO; ?>",
				digits: "El teléfono solo puede contener números"
			},
			comentarios: "Por favor, explica el motivo de tu consulta"
		}
	});
});

</script>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	
	<div class="hero--small hero-contact">
		
		<div class="hero-container">
		
			<div class="hero-inner--small">
			
				<h1 class="h1-header"><?php echo AÑADE_CASA; ?></h1>
									
			</div>
			
		</div>
		
	</div>
	
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<div  class="col-pad col-pad--half content-custom-template" id="main">
				<?php echo CASA_NUEVA_CONTENT; ?>
            </div>
			
			<div class="col-pad col-pad--half contact-form content-custom-template">
				<?php 
                if (isset($_POST['enviar']) && $_POST['enviar'] == 1) { echo "<div class=\"alert alert--succes\">".CASA_NUEVA_ENVIO_OK."</div>"; }
                ?>
                
                <h2><?php echo CASA_NUEVA_RELLENA_FORMULARIO; ?></h2>
                <form action="<?php echo $lng."/".URL_CASA_NUEVA;?>" method="post" id="ContactForm" name="ContactForm">
                    <input type="hidden" name="enviar" value="1">					

                    <div class="label-group">

                        <label><?php echo NOMBRE; ?></label>

                        <input type="text" placeholder="" id="nombre" class="" name="nombre" required>

                    </div>

                    <div class="label-group">

                        <label><?php echo APELLIDOS; ?></label>

                        <input type="text" placeholder="" id="apellidos" class="" name="apellidos" required>

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
                            
                        <label><?php echo COMENTARIOS; ?></label>
                            
                        <textarea class="form-control" rows="3" id="comentarios" name="comentarios" required></textarea>
                        
                    </div>
                        
                    <!--    
                    <div class="label-group"><input type="checkbox" class="" id="check_condiciones" name="check_condiciones" required><?php echo ACEPTO_CONDICIONES; ?></div>
                    -->
                    
                    <div class="label-group checkout-button">
    
                        <input type="submit" value="<?php echo ENVIAR; ?>" name="enviando" class="btn btn--primary" />
    
                    </div>
                </form>            	
				
			</div>
		</div>
	</section>

<?php include("includes/footer.php"); ?>