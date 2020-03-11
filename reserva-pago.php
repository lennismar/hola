<?php 
include 'includes/config.php';

$meta_title="Som Rurals. ". HEADER_TITLE;
$meta_description=SEO_HOME_DESCRIPCION;
$meta_keywords=SEO_HOME_KEYWORDS;
$meta_index="no";
$meta_follow="no";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

// Reserva de prueba: ADLH-1478-6916
// Reserva codificada: QURMSC0xNDc4LTY5MTY,
if(empty($_GET['rescode'])) { header('Location: '.URL_BASE); exit();}
//var_dump($_POST);
$rescode = SomruralsDecode($_GET['rescode']);

if(isset($rescode)) {
	include('includes/booking_data.php');
}
if(empty($rescode) || !empty($error_carga_datos)) { header('Location: '.URL_BASE); exit();}

$action_url = URL_BASE;
switch($lng) {
	case 'es':
		$action_url .= 'es/reserva-pago2/'.$_GET['rescode'];
		break;
	case 'ca':
		$action_url .= 'ca/reserva-pagament2/'.$_GET['rescode'];
		break;
	case 'fr':
		$action_url .= 'en/book-payment2/'.$_GET['rescode'];
		break;
	case 'en':
		$action_url .= 'fr/reservations-paiement2/'.$_GET['rescode'];
		break;
}

/* Control para redirección en caso de estar ya pagada la reserva */
$jump_url = URL_BASE;
$estado_OK = SomruralsEncode('OK');
$estado_KO = SomruralsEncode('KO');
if($restid == 5 || $restid == 3) $estado_final = SomruralsEncode('KO');
elseif ($restid == 4) $estado_final = SomruralsEncode('OK');
switch($lng) {
	case 'es':
		$jump_url .= 'es/reserva-pago-confirm/'.$_GET['rescode'].'/'.$estado_final;
		break;
	case 'ca':
		$jump_url .= 'ca/reserva-pagament-confirm/'.$_GET['rescode'].'/'.$estado_final;
		break;
	case 'fr':
		$jump_url .= 'en/book-payment-confirm/'.$_GET['rescode'].'/'.$estado_final;
		break;
	case 'en':
		$jump_url .= 'fr/reservations-paiement-confirm/'.$_GET['rescode'].'/'.$estado_final;
		break;
}
if($restid == 5 || $restid == 3 || $restid == 4)  { header('Location: '.$jump_url); exit();}

/* Fin de control de redirección para reservas ya pagadas */

include("includes/head.php");

?>
<body>

<div class="container-main" id="container">

<?php include("includes/header-clean.php"); ?>

	<section class="wrapper">

		<div class="page-container-fixed-pad">

			<article  class="col-pad col-pad--two-third" id="main">

				<div class="step-nav clearfix push-half--bottom">

					<a href="#" class="step-nav-two current"><span><?php echo CONFIRMACION_DATOS_PAGOS; ?></span></a>

					<a href="#" class="step-nav-two disable"><span><?php echo TERMINADO; ?></span></a>

				</div>

				<div class="clearfix checkout-form-process">

					<form action="<?php echo $action_url; ?>" method="post" id="CheckOutForm" name="CheckOutForm">

						<p><?php echo REALIZA_PAGO_CON_TARJETA; ?></p>

						<div class="alert alert--info">

							<?php echo SERAS_REDIRIGIDO_TPV; ?>

						</div>

						<div class="label-group checkout-button">
							<input type="hidden" name="action" value="pay">
							<input type="hidden" name="rescode" value="<?php echo $_GET['rescode']; ?>">
							<input type="submit" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary" />

						</div>

						<h1><?php echo TU_RESERVA; ?></h1>

						<h2><?php echo DATOS_RESERVA; ?></h2>

						<ul class="label-group checkout-confirm-list">
							<?php
							$huespedes = array();
							if(!empty($adults)) array_push($huespedes, $adults.' '.ADULTOS);
							if(!empty($children)) array_push($huespedes, $children.' '.NINOS);
							if(!empty($babies)) array_push($huespedes, $babies.' '.BEBES);
							?>
							<li><?php echo HUESPEDES; ?>: <strong><?php echo implode(', ', $huespedes); ?></strong></li>
						</ul>

						<h2><?php echo TUS_DATOS; ?></h2>

						<ul class="label-group checkout-confirm-list">

							<li><?php echo NOMBRE; ?>: <strong><?php echo $ofirstname; ?></strong></li>

							<li><?php echo APELLIDOS; ?>: <strong><?php echo $olastname; ?></strong></li>

							<li><?php echo EMAIL; ?>: <strong><?php echo $oemail; ?></strong></li>

							<li><?php echo TELEFONO; ?>: <strong><?php echo $ophone; ?></strong></li>

							<!--<li><?php echo POBLACION; ?>: <strong><?php echo $ofirstname; ?></strong></li>-->

							<li><?php echo PAIS; ?> <strong><?php echo $ocountry; ?></strong></li>

							<li><?php echo IDIOMA_CONTACTO; ?>: <strong><?php echo $idiomas_descripcion[$olanguage]; ?></strong></li>

							<li><?php echo COMENTARIOS; ?>:<br><strong><?php echo $ocomments; ?></strong></li>

						</ul>

						<h2><?php echo METODO_PAGO; ?></h2>

						<ul class="checkout-confirm-list">

							<li><?php echo TARJETA_CREDITO; ?></li>

						</ul>

						<div class="label-group check-out-advice">

							<div class="push-half--bottom"><strong><?php echo (TARJETA_CREDITO); ?></strong></div>

							<ol>

								<?php echo PAGO_CON_TARJETA_DESCRIPCION; ?>

							</ol>

							<img src="<?php echo CDN_BASE; ?>assets/img/payment-tarjeta.png" class="push-half--top" alt="<?php echo TARJETAS_ACEPTADAS;?>" width="241" height="36" />

						</div>

						<div class="alert alert--info">

							<?php echo SERAS_REDIRIGIDO_TPV; ?>

						</div>

						<div class="label-group checkout-button">
							<input type="hidden" name="action" value="pay">
							<input type="hidden" name="rescode" value="<?php echo $_GET['rescode']; ?>">
							<input type="submit" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary" />

						</div>

					</form>

				</div>

			</article>

			<aside class="col-special-one-third" id="fixed-book-form">

				<?php include("includes/checkout-info.php"); ?>

			</aside>

		</div>

		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
			<input type="hidden" name="action" value="pay">
			<input type="button" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary"  onclick="return sendForm();" />
			<script type="text/javascript">
				function sendForm() {
					//alert("Submit button clicked!");
					document.getElementById("CheckOutForm").submit();
					return true;
				}
			</script>

		</div>

	</section>

<?php include("includes/footer.php"); ?>