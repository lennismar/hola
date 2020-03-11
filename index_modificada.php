<?php 
include 'includes/config.php';

/*$home_query = mysql_query("SELECT * FROM page_home");
$home = mysql_fetch_array($home_query, MYSQL_ASSOC);*/
$home=$db->getOne('page_home','*');

$meta_title= $home['meta_title_'.$lng];
$meta_description=$home['meta_description_'.$lng];
$meta_keywords=$home['meta_keywords_'.$lng];
$meta_index="";
$meta_follow="";

$og_site_name="Som Rurals";
$og_title=$home['meta_title_'.$lng];
$og_url="";
$og_image="";

include("includes/head.php");
?>

<body>
	
<?php include("includes/tag-manager.php"); ?>
    
<?php include("includes/nav-responsive.php"); ?>

<div class="container-main" id="container">
			
	<div class="wrapper">
	
		<div class="hero" id="hero-home">
		
			<?php include("includes/header-transparent.php"); ?>
		
			<div class="hero-container">
				
				<div class="hero-inner">
				
					<h1><?php echo HOME_TITLE; ?></h1>
					
					<p class="only-tablet-to-desktop"><?php echo HOME_SUBTITLE; ?></p>
				
					<div class="main-search-form main-search-form--home">
					
						<?php include("includes/main-search.php"); ?>
												
					</div>
			
				</div>
			
			</div>
		
		</div>

	</div>
	
	<script>
		$(document).ready(function() {
			$("#hero-home").backgroundCycle({
				imageUrls: [
				<?php
				if ($home['headimage1'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/home/".$home['headimage1']."',"; else echo "'assets/img/bg-home-1.jpg',";
				if ($home['headimage2'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/home/".$home['headimage2']."',"; else echo "'assets/img/bg-home-2.jpg',";
				if ($home['headimage3'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/home/".$home['headimage3']."'"; else echo "'assets/img/bg-home-3.jpg'";
				?>
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
		});
	</script>
			
	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<?php include("includes/quiklinks.php"); ?>
				
		</div>
	
	</section>
	<!-- Propuestas de valor -->

	<section class="wrapper ">

		<div class="page-container-fixed-pad">
			
			<h2 class="h2-header push--bottom"><?PHP ECHO RESERVA_TU_CASA; ?></h2>

			<div class="row">

			    <div class="list-col-three">
				    
				    <div class="value-proposal">
					    <div class="value-proposal-img value-proposal-img-1"></div>
				        <?php echo RESPUESTA_24_HORAS; ?>
				    </div>
			    </div>
			
				<div class="list-col-three">
					<div class="value-proposal">
						<div class="value-proposal-img value-proposal-img-2"></div>
			        	<?php echo PAGO_CON_TARJETA; ?>
					</div>
			    </div>
			    			
				<div class="list-col-three">
					<div class="value-proposal">
						<div class="value-proposal-img value-proposal-img-3"></div>
			        	<?php echo CONSULTA_PRECIOS; ?>
					</div>
			    </div>
			
			</div>
				
		</div>
	
	</section>
	<!-- Casas que te van a gustar (Segmentacicon) -->
	
	<div class="wrapper wrapper--darkcream">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header push--bottom"><?php echo CASAS_QUE_TE_VAN_GUSTAR; ?></h2>	
		   
			<?php include_once("includes/secciones-index/casas-te-van-a-gustar.php"); ?>
				
		</div>
	
	</div>
	
	<!-- Casas que nos gustan (slect)-->
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header"><?php echo CASAS_RURALES_DESTACADAS; ?></h2>
						
			<!--  TABS -->
			<div class="tabs">
  
			 	<nav role='navigation' class="transformer-tabs">
					<ul class="tab-links">
						<li><a href="#tab-1" class="active"><?php echo LAS_MAS_DESTACADAS; ?></a></li>
						<li><a href="#tab-2"><?php echo ANADIDAS_RECIENTEMENTE;?></a></li>
						<li><a href="#tab-3"><?php echo LAS_MAS_BARATAS; ?></a></li>
					</ul>
				</nav>
			  <div class="tab-content">
			  
				<div id="tab-1" class="tab active">
			    
				    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
<?php
	// LAS MÁS DESTACADAS. RECOMMENDED = 1
	$cont_establiment = 1;
	/*$query = mysql_query("SELECT * FROM establiments WHERE published = 1 AND recommended = 1 ORDER BY RAND()");
	while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){*/
	$db->orderBy('rand()');
	$db->where('published',1);
	$db->where('recommended',1);
	$rs_query=$db->get('establiments',null,'*');
	foreach($rs_query as $rs){
		if($cont_establiment<=3):
			if ($datein!="") {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $_SESSION['datein']),date("Y-m-d"),'all',$_SESSION['persons']),2);
			} else {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d"),'','all',$_SESSION['persons']),2);
			}
			
			if ($bestprice != 0 ) {		
	?>				
							<div class="item"><?php include("includes/card-v.php"); ?></div>
	<?php
				$cont_establiment++;
			}
		endif;
	}
?>
					</div>
				    
				</div>
				<!-- / tab-1 -->
				<div id="tab-2" class="tab">
			    
				    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
				
<?php
	// AÑADIDAS RECIENTEMENTE. ORDENADAS POR FECHA datedadded
	$cont_establiment = 1;
	//$query = mysql_query("SELECT * FROM establiments WHERE published = 1 ORDER BY dateadded DESC, RAND()");
	$db->orderBy('dateadded','DESC');
	$db->orderBy('rand()');
	$db->where('published',1);
	$rs_query=$db->get('establiments',null,'*');

	//while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){
	foreach($rs_query as $rs){
		if($cont_establiment <= 3):
			if ($datein!="") {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $_SESSION['datein']),date("Y-m-d"),'all',$_SESSION['persons']),2);
			} else {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d"),'','all',$_SESSION['persons']),2);
			}
			
			if ($bestprice != 0 ) {		
?>				
							<div class="item"><?php include("includes/card-v.php"); ?></div>
<?php
				$cont_establiment++;
			}
		endif;
	}
?>
				  
					</div>
				    
				</div>
				<!-- / tab-2 -->
				<div id="tab-3" class="tab">
			    
				    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
<?php
	// MAS BARATAS. BESTPRICE < 20 Euros
	$cont_establiment = 1;
	//$query = mysql_query("SELECT * FROM establiments WHERE published = 1 ORDER BY RAND()");
	$db->orderBy('rand()');
	$db->where('published',1);
	$rs_query=$db->get('establiments',null,'*');
	//while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){
	foreach($rs_query as $rs){
		if($cont_establiment <= 3):
			if ($datein!="") {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $_SESSION['datein']),date("Y-m-d"),'all',$_SESSION['persons']),2);
			} else {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d"),'','all',$_SESSION['persons']),2);
			}
			
			if ($bestprice != 0 && $bestprice<20) {		
?>				
							<div class="item"><?php include("includes/card-v.php"); ?></div>
<?php
				$cont_establiment++;
			}
		endif;
	}
?>
				  
					</div>
				    
				</div>
				<!-- / tab-3 -->
			    
			</div>
			  			 						
			<!-- /TABS -->
			
			
		</div>
	
	</section>
	
	<!-- Lugares para descubrir (slect)-->
	
	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header"><?php echo LUGARES_PARA_DESCUBRIR; ?></h2>
			
			<p class="text-sub-header"><?php echo HAZ_DE_TU_ESTANCIA; ?></p>
				
			<div id="owl-places" class="owl-carousel owl-theme clearfix owl-places">
<?php
//$query = mysql_query("SELECT idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid FROM recursos WHERE image<>'' ORDER BY RAND() LIMIT 4");
	$db->orderBy('rand()');
	$db->where('image','','<>');
	$rs_query=$db->get('recursos',4,"idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid");
	//while($place = mysql_fetch_array($query)){
	foreach($rs_query as $place){         
?>			
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
<?php } ?>						  						  			  			  
			</div>
			
			<a class="btn--more push--top" href="<?php echo $lng."/".URL_RECURSOS_TURISTICOS;?>"><?php echo DESCUBRE_MAS; ?></a>
			
		</div>
	
	</section>
	
	<!-- Newsletter-->
		
	<?php //include("includes/newsletter.php"); ?>
	<?php include_once("includes/secciones-index/desc-reservas-inmediatas.php"); ?>
	
	<!-- SEO -->
	
	<section class="wrapper wrapper--white only-desktop">
	
		<div class="page-container-fixed-pad seo-block">
<?php    
	//$prov_query = mysql_query("SELECT pvid, title, title_url FROM provincies ORDER BY title ASC");
	$db->orderBy('title','ASC');
	$rs_query=$db->get('provincies',null,'pvid, title, title_url');
	//while($prov = mysql_fetch_array($prov_query)){
	foreach($rs_query as $prov){
?>           		
		<p><a href="<?php echo $lng."/".URL_SEARCH."/".$prov['title_url'] ;?>" class="seo-block-title"><?php echo strtoupper($prov['title']); ?></a>&nbsp; 
<?php
		//$com_query = mysql_query("SELECT comid, pvid, title, title_url FROM comarques WHERE pvid = '".$prov['pvid']."' ORDER BY title ASC");
		$db->orderBy('title','ASC');
		$db->where('pvid',$prov['pvid']);
		$resultado=$db->get('comarques',null,'comid, pvid, title, title_url');
		//while($com = mysql_fetch_array($com_query)){
		foreach($resultado as $com){
			//str_replace("-", "", $com['title_url']);
			echo '<a href="'.$lng.'/'.URL_SEARCH.'/'.urls_amigables($prov['title_url']) .'/'.$prov['pvid'] .'/'.$com['title_url'].'/'.$com['comid'].'">'.$com['title'].'</a>,&nbsp;';
		}
		
	} 
?>
			</p>
		</div>
		
	</section>
	
<?php include("includes/footer.php"); ?>