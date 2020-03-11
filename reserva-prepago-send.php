<?php 
include 'includes/config.php';
include ABS_BASE.'includes/functions_payments.php';
$debug = false;

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
if(empty($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST') { header('Location: '.URL_BASE); exit();}
//var_dump($_POST);
$rescode = SomruralsDecode($_GET['rescode']);

$return_url = URL_BASE;
switch($lng) {
    case 'es':
        $return_url .= 'es/reserva-pago-confirm/'.$_GET['rescode'];
        break;
    case 'ca':
        $return_url .= 'ca/reserva-pagament-confirm/'.$_GET['rescode'];
        break;
    case 'fr':
        $return_url .= 'en/book-payment-confirm/'.$_GET['rescode'];
        break;
    case 'en':
        $return_url .= 'fr/reservations-paiement-confirm/'.$_GET['rescode'];
        break;
}


$payment = createPayment($rescode);
if($debug) echo '<br>---------'.$payment['id'];
if($debug) var_dump($payment);
include("includes/head.php");

?>
<body>
	<!-- Tracking code para registrar el checkout de una compra -->
	<script>
	gtag('event', 'page_view', {
	  'send_to': 'AW-873759961',
	  'hrental_pagetype': 'conversionintent',
	  'hrental_totalvalue': <?php echo $payment['amount']; ?>
	});

	</script>

<div class="container-main" id="container">

<?php include("includes/header-clean.php"); ?>
<p style="text-align: center; padding-top: 150px; padding-bottom: 150px; ">En breves segundos serás redirigido a la pasarela segura de pago bancario. <br />Si esto no ocurriera, haz clic aquí: <button id="abrirTPV">Proceder al pago</button></p>
<?php
//echo $return_url; exit();

/* El resto de parámetros vienen del config.php */
$config['tpv_url_ok']	= $return_url.'/'.SomruralsEncode('OK');
$config['tpv_url_ko']	= $return_url.'/'.SomruralsEncode('KO');
$config['tpv_url_return']	= URL_BASE.'reserva-pago-bgresponse.php';
$paymentDescription = substr($payment['description'], 0, 125);
$user_desc = $payment['customer_desc'];
$order = $payment['order'];
$amount = $payment['amount']*100;

include 'includes/apiRedsys.php';
// Se crea Objeto
$miObj = new RedsysAPI;

// Se Rellenan los campos
$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
//$miObj->setParameter("DS_MERCHANT_AMOUNT",100); // 1€ para las pruebas
$miObj->setParameter("DS_MERCHANT_TITULAR",$user_desc);
$miObj->setParameter("DS_MERCHANT_PRODUCTODESCRIPTION",$paymentDescription);
$miObj->setParameter("DS_MERCHANT_ORDER",strval($order));
$miObj->setParameter("DS_MERCHANT_PAYMETHODS",'C');
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$config['tpv_codigo_comercio']);
$miObj->setParameter("DS_MERCHANT_CURRENCY",$config['tpv_moneda']);
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$config['tpv_prepago_transaction_type']);
$miObj->setParameter("DS_MERCHANT_TERMINAL",$config['tpv_terminal']);
$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$config['tpv_url_return']);
$miObj->setParameter("DS_MERCHANT_URLOK",$config['tpv_url_ok']);
$miObj->setParameter("DS_MERCHANT_URLKO",$config['tpv_url_ko']);

//Datos de configuración
$version=$config['tpv_version'];
$kc = $config['tpv_palabra_secreta'];//Clave recuperada de CANALES
// Se generan los parámetros de la petición
$request = "";
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($kc);

$data = array();
$data['tpv_payment_url'] = $config['tpv_payment_url'];
echo form_creator_redsys($data, $version, $params, $signature);
//exit();
?>
<script>
	$( "#abrirTPV" ).click(function() {
		$( "#frmPay2" ).submit();
	});

		//$('#frmPay2').delay(3000).submit();
    $( document ).ready(function() {
        setTimeout( $('#frmPay2').submit(), 3000);
    });

</script>
<?php
 include("includes/footer.php");

exit();
