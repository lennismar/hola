<?php 
include 'includes/config.php';

$persons = $_POST['persons'];
$datein = strtotime($_POST['datein']);
$dateout = strtotime($_POST['dateout']);
$numnights = DateDiff($_POST['datein'], $_POST['dateout']);
$numdaysant = DateDiff(date("d-m-Y"), $_POST['datein']);
$tipo = $_POST['tipo'];
$id = $_POST['eid'];

$rooms = $_POST['rooms'];
$total = $_POST['total'];
$anticipado = $_POST['anticipado'];
$restante = $_POST['restante'];

if(isset($id)){
	/*$rs_query = mysql_query("SELECT * FROM establiments WHERE eid = " . $id);
	$rs = mysql_fetch_array($rs_query);*/	
	$db->where('eid',$id);
	$rs=$db->getOne('establiments','*');

	$title = htmlspecialchars($rs['title']);
	$lid = htmlspecialchars($rs['lid']);
	$pvid = htmlspecialchars($rs['pvid']);
	$comid = htmlspecialchars($rs['comid']);
	$tid = htmlspecialchars($rs['tid']);
}

$tipusestabliment = GetTitleTipusEstabliment($tid,$lng);

$result = 1;

$meta_title="Som Rurals. ". HEADER_TITLE;
$meta_description=SEO_HOME_DESCRIPCION;
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

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a class="step-nav-three complete"><span><?php echo TUS_DATOS_FORMA; ?></span></a>
					
					<a class="step-nav-three complete"><span><?php echo CONFIRMACION_DATOS; ?></span></a>
					
					<a class="step-nav-three current"><span><?php echo TERMINADO; ?></span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-3.php" method="post" id="CheckOutForm" name="CheckOutForm">
					
						<h1><?php echo ENHORABUENA; ?></h1>
					
						<h2><?php echo SOLICITUD_RESERVA; ?></h2>
						
						<ul class="label-group block-list-circle-orange">
                        	<?php echo str_replace('<anticipado>', $anticipado, RESERVA_ENVIADA_CONTENT1); ?>						
						</ul>
						
						<div class="label-group check-out-advice">
							<?php echo RESERVA_ENVIADA_CONTENT2; ?>
						
						</div>
						
						<div class="label-group">
							<?php echo RESERVA_ENVIADA_CONTENT3; ?>                        
						</div>
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>

	</section>

<?php include("includes/footer.php"); ?>