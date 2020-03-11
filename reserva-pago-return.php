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
//if(empty($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST') { header('Location: '.URL_BASE); exit();}
$rescode = SomruralsDecode($_GET['rescode']);
$status = SomruralsDecode($_GET['status']);
//echo '<br/>reserva:'.$rescode;
//echo '<br/>estado:'.$status;
if(isset($rescode)) {
	include('includes/booking_data.php');
}

include("includes/head.php");

?>
<body>
<?php if($status == 'OK') { ?>
	<!-- Tracking code para registrar la conversión de una compra -->
	<script>
	gtag('event', 'page_view', {
	  'send_to': 'AW-873759961',
	  'hrental_pagetype': 'conversion'
	});

	</script>
<?php } ?>
<div class="container-main" id="container">

<?php include("includes/header-clean.php"); ?>

	<section class="wrapper">

		<div class="page-container-fixed-pad">

			<article  class="col-pad col-pad--two-third" id="main">

				<div class="step-nav clearfix push-half--bottom">

					<a href="" class="step-nav-two disable"><span><?php echo CONFIRMACION_DATOS_PAGOS; ?></span></a>

					<a href="#" class="step-nav-two current "><span><?php echo TERMINADO; ?></span></a>

				</div>

				<div class="clearfix checkout-form-process">

					<form action="" method="post" id="CheckOutForm" name="CheckOutForm">

						<h1><?php if($status == 'OK') echo ENHORABUENA; else echo ERROR_PAGO; ?></h1>

						<h2><?php if($status == 'OK') echo PAGO_ANTICIPADO_REALIZADO; else echo PAGO_ANTICIPADO_FALLADO; ?></h2>

						<ul class="label-group block-list-circle-orange">

							<?php if($status == 'OK') echo PAGO_ANTICIPADO_REALIZADO_DESCRIPCION; else echo PAGO_ANTICIPADO_FALLADO_DESCRIPCION; ?>

						</ul>

						<p><?php if($status == 'OK') echo DISFRUTA_ESTANCIA; ?></p>

						<div class="label-group check-out-advice">

							<?php echo RESERVA_ENVIADA_CONTENT2; ?>

						</div>

						<div class="label-group"><?php echo RESERVA_ENVIADA_CONTENT3; ?></div>

					</form>

				</div>

			</article>

			<aside class="col-special-one-third" id="fixed-book-form">

				<?php include("includes/checkout-info.php"); ?>

			</aside>

		</div>

		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
			<input type="hidden" name="action" value="pay">
			<input type="submit" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary" />

		</div>

	</section>

<?php include("includes/footer.php"); ?>