<?php 
include 'includes/config.php';
// Reserva de prueba: ADLH-1478-6916
// Reserva codificada: QURMSC0xNDc4LTY5MTY,
if(empty($_GET['rescode'])) { header('Location: '.URL_BASE); exit();}
var_dump($_POST);
$rescode = SomruralsDecode($_GET['rescode']);

if(isset($rescode)) {

	include('includes/booking_data.php');

}




/*
 * * FIN CARGA DE DATOS EN VARIABLES
 */


$meta_title="Som Rurals. ". HEADER_TITLE;
$meta_description=SEO_HOME_DESCRIPCION;
$meta_keywords=SEO_HOME_KEYWORDS;
$meta_index="no";
$meta_follow="no";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

include("includes/head.php");

?>

<body>

<div class="container-main" id="container">

<?php include("includes/header-clean.php"); ?>

	<section class="wrapper">

		<div class="page-container-fixed-pad">

			<article  class="col-pad col-pad--two-third" id="main">

				<div class="step-nav clearfix push-half--bottom">

					<a href="checkout-1.php" class="step-nav-three complete"><span>Tus datos y forma de pago</span></a>

					<a href="#" class="step-nav-three current"><span>Confirmación de datos</span></a>

					<a href="#" class="step-nav-three disable"><span>¡Terminado!</span></a>

				</div>

				<div class="clearfix checkout-form-process">

					<form action="" method="post" id="CheckOutForm" name="CheckOutForm">

						<h1>Por favor, revisa tus datos</h1>

						<h2>Datos de la reserva <i><?php echo $rescode; ?></i></h2>

						<ul class="label-group checkout-confirm-list">
							<?php
								$huespedes = array();
								if(!empty($adults)) array_push($huespedes, $adults.' adultos');
								if(!empty($children)) array_push($huespedes, $children.' niños');
								if(!empty($babies)) array_push($huespedes, $babies.' bebé');
							?>
							<li>Huéspedes: <strong><?php echo implode(', ', $huespedes); ?></strong></li>

						</ul>

						<h2>Tus datos</h2>

						<ul class="label-group checkout-confirm-list">

							<li>Tu nombre: <strong><?php echo $ofirstname; ?></strong></li>

							<li>Apellidos: <strong><?php echo $olastname; ?></strong></li>

							<li>Tu email: <strong><?php echo $oemail; ?></strong></li>

							<li>Telefono: <strong><?php echo $ophone; ?></strong></li>

							<li>Localidad <strong><?php echo $ocity; ?></strong></li>

							<li>País <strong><?php echo $ocountry; ?></strong></li>

							<li>Idioma de contacto <strong><?php echo $idiomas_descripcion[$olanguage]; ?></strong></li>

							<li>Comentario<br><strong><?php echo $terms_es; ?></strong></li>

						</ul>

						<?php
							if($restid == 4) { ?>
								<h2>Reserva pagada</h2>
						<?php } elseif($restid == 3) { ?>
								<h2>Reserva no disponible</h2>
						<?php }  elseif($restid == 2) { ?>
							<h2>Forma de pago</h2>

							<script>
								$(function() {
									$('#forma-de-pago').change(function(){
										$('.forma-de-pago').hide();
										$('#forma-de-pago' + $(this).val()).show();
									});
								});

							</script>

							<div class="label-group pay-way">

								<select id="forma-de-pago">
									<?php
									/*$query  = mysqli_query("SELECT pid, title_ca FROM paymodules");
                                    if($rs = mysqli_fetch_array($query)){*/
									$rs_query=$db->get('paymodules',null,'pid, title_'.$olanguage);
									foreach($rs_query as $rs){
										?>
										<option <?php ($rs['pid'] == $pid) ? 'selected="selected"' : ''; ?> value="<?php echo $rs['pid']; ?>"><?php echo $rs['title_ca']; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago2" style="display:none">

								<div class="push-half--bottom"><strong>TARJETA DE CRÉDITO</strong></div>

								<ol>

									<li>Tu reserva quedará <strong>confirmada en el momento del pago</strong>.</li>

									<li>Recibirás un mail de confirmación del pago con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>

								</ol>

								<img src="<?php echo CDN_BASE; ?>assets/img/payment-tarjeta.png" class="push-half--top" alt="Tarjetas aceptadas" width="241" height="36" />

							</div>

							<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago3" style="display:none">

								<div class="push-half--bottom"><strong>PAYPAL</strong></div>

								<ol>

									<li>En máximo <strong>24 horas confirmaremos la disponibilidad</strong> de este alojamiento</li>

									<li>Una vez confirmada, te enviaremos un <strong>email</strong> con un link a nuestra web para que realices el <strong>pago del importe anticipado</strong> mediante <strong>PayPal</strong>.</li>

									<li>Al momento de recibirás un mail de confirmación con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>

								</ol>

								<img src="<?php echo CDN_BASE; ?>assets/img/logo-paypal.svg" class="push-half--top" alt="Pago con PayPal" />

							</div>

							<div class="label-group checkout-button">
								<input type="hidden" name="action" value="pay">
								<input type="submit" value="Pagar" name="continuar" class="btn btn--primary" />

							</div>
						<?php } ?>

					</form>

				</div>

			</article>

			<aside class="col-special-one-third" id="fixed-book-form">

				<?php include("includes/checkout-info.php"); ?>

			</aside>

		</div>

		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">

			<input type="submit" value="Pagar" name="continuar" class="btn btn--primary" />

		</div>

	</section>

<?php include("includes/footer.php"); ?>