<?php 
include 'includes/config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);	

if(!isset($id) || (empty($id))){
    // Si NO hay variable GET $id
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    die();
}


	$db->where('eid',$id);
	$rs=$db->getOne('establiments',"eid, title, subtitle_".$lng.", persons, persons_min, description_".$lng.", destacat_".$lng.", description_small_".$lng.", cond_towels, cond_kitchen, cond_firewood, fianza, bedrooms, bathrooms, videos, lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime,checkintimeto, checkouttime,checkouttimeto, checkouttime_weeks, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, extra_quantity, registro_turismo, terms_".$lng);

	// Guardamos los registros en variables
	$title = htmlspecialchars($rs['title']);
	$subtitle = htmlspecialchars($rs['subtitle_'.$lng]);
	$description = $rs['description_'.$lng];
	$description_small = $rs['description_small_'.$lng];
	$persons_max = $rs['persons'];
	$persons_min = $rs['persons_min'];
	$persons_extra= $rs['extra_quantity'];

	$destacat = $rs['destacat_'.$lng];
	$embed_videos = $rs['videos'];
	$lid = htmlspecialchars($rs['lid']);
	$pvid = htmlspecialchars($rs['pvid']);
	$comid = htmlspecialchars($rs['comid']);
	$published = htmlspecialchars($rs['published']);
	$daysmin = htmlspecialchars($rs['daysmin']);
	$daysant = htmlspecialchars($rs['daysant']);
	$cond_towels = $rs['cond_towels'];
	$cond_kitchen = $rs['cond_kitchen'];
	$cond_firewood = $rs['cond_firewood'];
	$fianza = htmlspecialchars($rs['fianza']);
	$bedrooms = $rs['bedrooms'];
	$bathrooms = $rs['bathrooms'];
	$establimentcomplert = htmlspecialchars($rs['establimentcomplert']);
	$user = htmlspecialchars($rs['user']);
	$userpsw = htmlspecialchars($rs['userpsw']);
	$username = htmlspecialchars($rs['username']);
	$userlocked = htmlspecialchars($rs['userlocked']);
	$ownername = htmlspecialchars($rs['ownername']);
	$email = htmlspecialchars($rs['email']);
	$address = htmlspecialchars($rs['address']);
	$phone = htmlspecialchars($rs['phone']);
	$fax = htmlspecialchars($rs['fax']);
	$gmap_lat = htmlspecialchars($rs['gmap_lat']);
	$gmap_lng = htmlspecialchars($rs['gmap_lng']);
	/*$aleatorio=rand(-30,30)/1000;
	$gmap_lng=$gmap_lng+$aleatorio;
	$gmap_lat=$gmap_lat+$aleatorio;*/
	$home = htmlspecialchars($rs['home']);
	$recommended = htmlspecialchars($rs['recommended']);	
	$checkintime = htmlspecialchars($rs['checkintime']);
	$checkintimeto = htmlspecialchars($rs['checkintimeto']);
	$checkouttime = htmlspecialchars($rs['checkouttime']);
	$checkouttimeto = htmlspecialchars($rs['checkouttimeto']);
    $checkouttime_weeks = htmlspecialchars($rs['checkouttime_weeks']);
	$seotitle = htmlspecialchars($rs['seotitle']);
	$seowords = htmlspecialchars($rs['seowords']);
	$seodescription = htmlspecialchars($rs['seodescription']);
	$hits = htmlspecialchars($rs['hits']);
	$dateadded = htmlspecialchars($rs['dateadded']);
	$datelastvisit = htmlspecialchars($rs['datelastvisit']);
	$tid = htmlspecialchars($rs['tid']);
	$terms = htmlspecialchars($rs['terms_'.$lng]);
	$senyal = htmlspecialchars($rs['senyal']);
	$registro_turismo = htmlspecialchars($rs['registro_turismo']);



//if($_SESSION['persons']=='') $_SESSION['persons']=$persons_min;

$persons = $_SESSION['persons'];
$datein = strtotime($_SESSION['datein']);
$dateout = strtotime($_SESSION['dateout']);
$numnights = DateDiff($_SESSION['datein'], $_SESSION['dateout']);
$numdaysant = DateDiff(date("d-m-Y"), $_SESSION['datein']);


if (!isset($_SESSION['tipo'])) {
	if (GetNumRoomsEstabliment($id)>0) {
		$_SESSION['tipo']=1;
	} else if (IsEstablimentComplert($id)){
		$_SESSION['tipo']=2;
	}
}

/* Precarga de precio genérico para cuando se carga la ficha de la casa sin fechas y disponibilidad.php no calcula precio */
if ($datein=="") {
	$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($id,date("Y-m-d", strtotime("next saturday")),'','all',$persons),2);
}

//Tipo de establecimiento
//$query_tipus = mysqli_query("SELECT * FROM tipus WHERE tid=".$tid);
$db->where('tid',$tid);
$rs_query=$db->get('tipus',null,'*');
//if($rs_tipus = mysqli_fetch_array($query_tipus)){
foreach($rs_query as $rs_tipus){
	$tipusestabliment = $rs_tipus['title_sing_'.$lng];
	$tipus_title = $rs_tipus['title_'.$lng];
	$tipus_description = $rs_tipus['description_'.$lng];
}

$media_total = ValoracionMediaCasa($id);
$numvaloraciones = NumValoracionesCasa($id);
//$tipusestabliment = GetTitleTipusEstabliment($tid,$lng);

$breadcrumb_pvid=$pvid;
$breadcrumb_comid=$comid;
$breadcrumb_lid=$lid;

$meta_title = "SR-".$id. " | ".GetTitleComarca($comid)." - ".GetTitleProvincia($pvid)." - ".SEO_ESTABLIMENT_SUFIX." - SomRurals.com";
$meta_description = substr(strip_tags($description), 0, 250);
$meta_keywords = "somrurals, som rurals, catalunya, cataluña, catalonia";
$meta_index = "";
$meta_follow = "";

$og_site_name="somrurals.com";
$og_title= "SomRurals.com - ". $subtitle . " ". $title ;
$og_title= $meta_title;
$og_url= URL_BASE . $lng."/".URL_CASA_RURAL."/".urls_amigables($title)."-".$id;
$og_image= CDN_BASE . "images/uploads/establiments/" . ImagePrincipalEstabliment($id);

$rel_canonical = '<link rel="canonical" href="'.URL_BASE.'/'.$_SESSION['lng'].'/'.URL_CASA_RURAL.'/'.urls_amigables($title).'-'.$id.'" />';

$enable_calendar = TRUE;
$enable_gmaps = TRUE;

include("includes/head.php");
?>
<script>
$(document).ready(function(){
	$("#tooltip-House-Type").tooltipster({animation:"grow",content:$("<div><strong><?php echo $tipus_title;?></strong><br><?php echo $tipus_description;?></div>")})
});	

</script>

<body onLoad="ConsultarDisponibilidad(); return false;">
	<!-- Tracking code para registrar la oferta de una compra -->
	<script>
	gtag('event', 'page_view', {
	  'send_to': 'AW-873759961',
	  'hrental_pagetype': 'offerdetail',
	  'hrental_id': 'SR-<?php echo $id; ?>'
	});

	</script>

<?php include("includes/tag-manager.php"); ?>

<script>
	/*
	$(document).ready(function() {
		$("#book-form").stick_in_parent({
			//parent:'.page-container-fixed',
			offset_top:10,
			inner_scrolling:true,
		});
	});
	*/
	$(document).ready(function() {
		function mysticky() {
			if ($(window).width() > 901) {
				$("#book-form").stick_in_parent({
					offset_top:125,
					inner_scrolling:true,
				});
			} 
			else if ($(window).width() < 900) {
				$("#book-form").trigger("sticky_kit:detach")
			};
		};
	
		mysticky();
	});

</script>


<?php include("includes/mobile-bar-book.php"); ?>

<div class="container container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<section class="wrapper">
	
		<div class="page-container-fixed push-half--ends">
			<!--
			<a class="btn--back" href="<?php 
			if(isset($_SERVER['HTTP_REFERER'])) {
				echo $_SERVER['HTTP_REFERER'];
			} else {
				echo $lng.'/'.URL_SEARCH.'/'.GetURLProvincia($pvid).'/'.GetURLComarca($comid);
			}
			?>"><?php echo VOLVER_BUSQUEDA; ?></a>
            -->
            
            <?php
			if (isset($_SESSION['current_url'])) echo '<a class="btn--back" href="'.$_SESSION['current_url'].'">'.VOLVER_BUSQUEDA.'</a>';
			?>
            
            
			<?php include("includes/breadcrumb.php"); ?>
		
		</div>
		
	</section>
		
	<section class="wrapper">
	
		<div class="page-container-fixed push--bottom">
		
			<article  class="col-pad col-pad--two-third" id="main">
				
				<div id="ficha" class="house-section house-type-1" itemscope itemtype="http://schema.org/Product" itemref="_offerPrice">
				
					<header class="house-section-header">
				
						<div class="house-class"><?php echo $tipusestabliment; ?></div>
						
						<div class="house-TypeDot"></div>
								
						<div class="house-title"><h1 itemprop="name"><?php echo $subtitle; ?></h1></div>
					
					</header>
								
					<div class="fotorama" data-width="100%" data-nav="thumbs" data-loop="true" data-allowfullscreen="yes">
                    <?php
                        //$rs_query = mysqli_query("SELECT eid, filename FROM establiments_images WHERE eid=".$id." ORDER BY principal DESC");
                        $db->orderBy('principal','DESC');
                        $db->where('eid',$id);
                        $rs_query=$db->get('establiments_images',null,'eid, filename');
                        //while($rs = mysqli_fetch_array($rs_query)) {
                        foreach($rs_query as $rs){
                            echo "<img src='".CDN_BASE."images/uploads/establiments/".$rs['filename']."' alt='Som Rurals - ".$title."'>";
                        }
                    ?>
					</div>
					
					<div class="content-block--small-pad">
					
						<div class="house-location col-pad col-pad-half"><span class="icon icon--place"><?php echo GetTitleLocalitat($lid); ?> (<?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?>)</span></div>
                        <?php
                            if ($media_total != 0 ) {
                        ?>
						<div class="house-reviews col-pad col-pad-half">
						
							<div class="rating">
								<?php echo ValoracionMediaCasaStars($id); ?>
							</div>
							(<span id="_countReview"><?php echo $numvaloraciones; ?></span> <?php echo COMENTARIOS; ?>)
						</div>
                        <?php
                            }
                        ?>
						
					</div>
						
					<div class="content-block--small-pad">
						
						<p class="icon icon--tooltip text-color--black" id="tooltip-House-Type-1"><strong><?php echo $tipusestabliment; ?></strong></p>
												
					</div>
										
					<div class="content-block--small-pad">
						<div class="house-stats">

							<dl class="stat ">
					            <dt class="stat--title"><?php echo PERSONAS; ?></dt>
					            <?php $totalperson=(int)$persons_max+(int)$persons_extra;?>
					            <dd class="stat--value"><?php echo $persons_min. " - ".$totalperson; ?></dd>
					        </dl>
					
					        <dl class="stat ">
					            <dt class="stat--title"><?php echo HABITACIONES; ?></dt>
					            <dd class="stat--value"><?php if ($bedrooms==0) echo "-"; else echo $bedrooms; ?></dd>
					        </dl>
							
					        <dl class="stat ">
					            <dt class="stat--title"><?php echo BANOS; ?></dt>
					            <dd class="stat--value"><?php if ($bathrooms==0) echo "-"; else echo $bathrooms; ?></dd>
					        </dl>
					        
					        <dl class="stat ">
					            <dt class="stat--title"><?php echo REFERENCIA; ?></dt>
					            <dd class="stat--value">SR-<?php echo $id; ?></dd>
					        </dl>
					    </div>
					</div>
					
					<div class="content-block--small-pad">
						<div class="house-stats">
                        <?php
                        $cont=1;
                        //$serveis_query = mysqli_query("SELECT serid, title_".$lng.", css FROM serveis WHERE css='pool' OR css='barbacue' OR css='wifi' OR css='pets' OR css='garden' OR css='terrace' OR css='air' OR css='fireplace' ORDER BY orden ASC");
                        $db->orderBy('orden','ASC');
                        $db->where('css','pool');
                        $db->orWhere('css','barbacue');
                        $db->orWhere('css','wifi');
                        $db->orWhere('css','pets');
                        $db->orWhere('css','garden');
                        $db->orWhere('css','terrace');
                        $db->orWhere('css','air');
                        $db->orWhere('css','fireplace');
                        $rs_query=$db->get('serveis',null,"serid, title_".$lng.", css");
                        //while($serveis = mysqli_fetch_array($serveis_query)){
                        foreach($rs_query as $serveis){
                            if (GetServeis($id, $serveis['serid'])=='yes' && $cont<=4) {
                        ?>
							<dl class="stat ">
								<dd class="stat--value"><div class="icon-big icon-big--<?php echo $serveis['css']; ?>"</div></dd>
					            <dt class="stat--title"><?php echo $serveis['title_'.$lng]; ?></dt>
					        </dl>
                        <?php
                                $cont++;
                            }
                        }
                        ?>
						</div>
					</div>
					
					<div class="content-block">
					
						<h2><?php echo DESCRIPCION; ?></h2>
						
						<?php if ($description != "") echo "<p>".$description."</p>"; ?>
					
					</div>
					
					
					<div class="content-block">
					
						<h2><?php echo SERVICIOS_CASA; ?></h2>
						
						<ul class="service-list three-col">
    
<?php
//$serveis_query = mysqli_query("SELECT serid, title_".$lng." FROM serveis ORDER BY title_".$lng." ASC");
$db->orderBy("title_".$lng,"ASC");
$db->orWhere('active',1);
$serveis_query=$db->get('serveis',null,"serid, title_".$lng);
//while($serveis = mysqli_fetch_array($serveis_query)){
foreach($serveis_query as $serveis){
?>   
							<li><span class="icon icon--<?php echo GetServeis($id, $serveis['serid']); ?>"><?php echo $serveis['title_'.$lng];?></span></li>
<?php 
} 
?>
						</ul>
											
					</div>

<?php if (HaveServeisExt($id)) { ?>					
					<div class="content-block">
						<h2><?php echo SERVICIOS_EXTERIORES_COMPARTIDOS; ?></h2>
						
						<!--<p>Los servicios exteriores se comparten con las <strong>5 casas</strong> pertenecientes al complejo.</p>-->
						
                        <p><?php echo SERVICIOS_EXTERIORES_COMPARTEN; ?></p>
                        
						<ul class="service-list three-col">
<?php
//$serveis_query = mysqli_query("SELECT serid, title_".$lng." FROM serveis WHERE ext=1 ORDER BY title_".$lng." ASC");
$db->orderBy("title_".$lng,'ASC');
$db->where('ext',1);
$serveis_query=$db->get('serveis',null,"serid, title_".$lng);

//while($serveis = mysqli_fetch_array($serveis_query)){
foreach($serveis_query as $serveis){
?>   
							<li><span class="icon icon--<?php echo GetServeisExt($id, $serveis['serid']); ?>"><?php echo $serveis['title_'.$lng];?></span></li>
<?php 
} 
?>
						</ul>
					</div>
<?php 
}
?>					
                    <?php if ($destacat!="") { ?>
					<div class="content-block">
						<h2><?php echo PROPIETARIO_DESTACA;?></h2>
						<?php echo $destacat; ?>				
					</div>
                    <?php } ?>
					
                    <?php if($embed_videos!="") { ?>
					<div class="content-block">
						<h2><?php echo VIDEOS;?></h2>
						<?php echo $embed_videos; ?>
					</div>
					<?php } ?>
					
					<div class="content-block">
					
						<h2><?php echo CONDICIONES_CASA; ?></h2>
						
						<p><strong><?php echo HORARIO_ENTRADA; ?>:</strong>
                        <?php 
						if ($checkintime!='flexible' && $checkintimeto!='flexible') {
                        	echo A_PARTIR_DE_LAS." ".$checkintime." ".HORAS;
							if ($checkintime!=$checkintimeto) echo " ".HASTA_LAS." ".$checkintimeto;
						}
						if ($checkintime=='flexible' && $checkintimeto=='flexible') echo HORARIO_FLEXIBLE;
						if ($checkintime!='flexible' && $checkintimeto=='flexible') echo A_PARTIR_DE_LAS." ".$checkintime." ".HORAS;
						?>
                        </p>
						<p><strong><?php echo HORARIO_SALIDA; ?>:</strong>
                        <?php 
						if ($checkouttime!='flexible' && $checkouttimeto!='flexible') {
                        	echo A_PARTIR_DE_LAS." ".$checkouttime." ".HORAS;
							if ($checkouttime!=$checkouttimeto) echo " ".HASTA_LAS." ".$checkouttimeto;
						}
						if ($checkouttime=='flexible' && $checkouttimeto=='flexible') echo HORARIO_FLEXIBLE;
						if ($checkouttime!='flexible' && $checkouttimeto=='flexible') echo A_PARTIR_DE_LAS." ".$checkouttime." ".HORAS;
						?>.
                            <?php //echo HORARIO_SALIDA_SEMANA;
                                if(!empty($checkouttime_weeks) && $checkouttime_weeks != $checkouttime) echo '<br/><i><strong>'.HORA_SALIDA.' '.$checkouttime_weeks.'</strong></i>';
                            ?>
                        </p>
						
						<p><strong><?php echo FIANZA; ?></strong> 
                        <?php if ($fianza!="") { ?>
                        	Si. <?php echo $fianza; ?>&euro;. <?php echo FIANZA_TEXT; ?></p>
						<?php } else { ?>
                        	No
                        <?php } ?>
                        
						<div class="house-conditions clearfix">
                        	<?php if($cond_towels==1) { ?>
							<div class="col-pad col-pad--third"><div class="icon-conditios--towels"></div><?php echo JUEGOS_CAMA_TOALLAS; ?></div>
							<?php } ?>
                            
                            <?php if($cond_kitchen==1) { ?>
							<div class="col-pad col-pad--third"><div class="icon-conditios--kitchen"></div><?php echo UTENSILIOS_COCINA; ?></div>
							<?php } ?>

                            <?php if($cond_firewood==1) { ?>                            
							<div class="col-pad col-pad--third"><div class="icon-conditios--firewood"></div><?php echo EQUIPADA_LENA; ?></div>
							<?php } ?>
						</div>
					
					</div>


				<div class="content-block">
					<?php echo ucwords(REGISTRO_TURISMO).': '.((empty($registro_turismo))?'-':$registro_turismo); ?>
				</div>
				<div class="content-block">
						<?php echo ucwords(PARA); ?>
						<?php
						//$query_perfil = mysqli_query("SELECT eid, perid FROM establiments_perfils WHERE eid = ".$id." ORDER BY RAND()");
						$db->orderBy('rand()');
						$db->where('eid',$id);
						//$db->where('active',1);
						$query_perfil=$db->get('establiments_perfils',null,'eid,perid');
						//while($rs_perfil = mysqli_fetch_array($query_perfil)){
						foreach($query_perfil as $rs_perfil){
						?>
							 <span class="tag"><?php echo GetTitlePerfil($rs_perfil['perid'],$lng); ?></span>
						<?php
							}
						?>
									
					</div>
					
					<script>
						function initialize() {
							var myLatlng = new google.maps.LatLng(<?php echo $gmap_lat; ?>,<?php echo $gmap_lng; ?>);
							var cdn_base = '<?php echo CDN_BASE; ?>';
							var mapOptions = {
								zoom: 10,
								center: myLatlng
							};
						
							var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
						  /*
						  var infowindow = new google.maps.InfoWindow({
						      content: contentString,
						       maxWidth: 300
						  });
						  */

							var icono = {
								url: cdn_base+"assets/img/point-area.svg",
								anchor: new google.maps.Point(35,35),
								scaledSize: new google.maps.Size(110,110)
							}

						  	var marker = new google.maps.Marker({
						      position: myLatlng,
						      map: map,
						      title: 'Apartamentos rurales con barbacoa en Garrotxa',
						      icon: icono
						  	});
						  	google.maps.event.addListener(marker, 'click', function() {
						    	infowindow.open(map,marker);
						  	});
							var minZoomLevel = 13;
							google.maps.event.addListener(map, 'zoom_changed', function() {
								if (map.getZoom() > minZoomLevel) map.setZoom(minZoomLevel);
								//alert (map.getZoom());
							});
						}
						
						//google.maps.event.addDomListener(window, 'load', initialize);
                        //$(document).ready(function() { initialize(); });

						
					</script>
						    
					<!--
					<div class="map-canvas" id="map-canvas">
										
					</div>
					-->
					
					<div class="map-canvas-static" id="map-canvas-static" style="text-align: center;">
						<img src="https://maps.googleapis.com/maps/api/staticmap?size=800x400&zoom=10&markers=color:orange%7C<?php echo $gmap_lat; ?>,<?php echo $gmap_lng; ?>&key=<?php echo GOOGLE_MAPS_API_KEY; ?>">
					</div>


					<div class="content-block">
						<h2><?php echo DISPONIBILIDAD;?></h2>
                        <!--<div id="casa-rural-ficha-disponibilitat"></div>
						
                        <img src="assets/img/point-disponible.gif" width="64" height="35" align="absmiddle" style="vertical-align: middle;height:35px !important;">&nbsp;&nbsp;<p class="nodisponible">NO DISPONIBLE</p>-->
						
						<div id="casa-rural-ficha-disponibilitat2"></div>
					</div>
					
<?php
	if ($media_total != 0 ) {
?>                    
					<div class="content-block"> 
						
						<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" itemref="_countReview">
						
							<h2><?php echo PUNTUACION_MEDIA; ?> <span class="rating-punctuation-title" itemprop="ratingValue"><?php echo round($media_total,1); ?></span>/5</h2>
							
						</span>
						
						<ol class="two-col list-punctuation clearfix">
						
							<li><?php echo VALORACIONES_LIMPIEZA; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'netega'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_TRATO; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'tracte'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_SERVICIOS; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'equipaments'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_RELACION; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'relacio'); ?>
								</div>
							</li>
							
							<li><?php echo VALORACIONES_SUEÑO; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'somni'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_ENTORNO; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'entorn'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_NATURA; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'natura'); ?>
								</div>
							</li>
							<li><?php echo VALORACIONES_SENSACION; ?>
								<div class="rating float--right">
									<?php echo ValoracionesCampo($id, 'sensacio'); ?>
								</div>
							</li>
						
						</ol>
						
						<div class="reviews">
                    <?php
                            //$rs_query = mysqli_query("SELECT cid, comcode, eid, title_".$lng.", comments_".$lng.", netega, tracte, entorn, equipaments, relacio, natura, sensacio, somni, como, date, ipaddress, resid, published, state FROM comments WHERE state=1 AND published=1 AND eid=".$id." ORDER BY date DESC");
                            $db->orderBy('date','DESC');
                            $db->where('state',1);
                            $db->where('published',1);
                            $db->where('eid',$id);
                            $rs_query=$db->get('comments',null,"cid, comcode, eid, title_".$lng.", comments_".$lng.", netega, tracte, entorn, equipaments, relacio, natura, sensacio, somni, como, date, ipaddress, resid, published, state");
                            //while($rs = mysqli_fetch_array($rs_query)){
                            foreach($rs_query as $rs){
                    ?>
							<?php include("includes/review.php"); ?>
                    <?php } ?>
							<?php //include("includes/pagination.php"); ?>
						
						</div>
						
					</div>
<?php } ?>					
					<div class="content-block">
					
						<h2><?php echo QUEVEREN . " " . GetTitleComarca($comid); ?></h2>
						
						<div class="owl-carousel clearfix owl-related-places">
                        <?php
                        //$query = mysqli_query("SELECT idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid FROM recursos WHERE comid=".$comid." LIMIT 3");
                        $db->where('comid',$comid);
                        $query=$db->get('recursos',3,"idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid, external_url");
                        //while($place = mysqli_fetch_array($query)){
                        foreach($query as $place){
                        ?>
							<div class="item"><?php include("includes/card-places.php"); ?></div>
                        <?php } ?>
						</div>
						
					</div>
					
					<div class="content-block">
					
						<?php include("includes/share-buttons.php"); ?>
						
					</div>
					
				</div>
				
				
				<a class="btn--back push--top" href="
                <?php
				if(isset($_SERVER['HTTP_REFERER'])) {
					echo $_SERVER['HTTP_REFERER'];
				} else {
					echo $lng.'/'.URL_SEARCH.'/'.GetURLProvincia($pvid).'/'.GetURLComarca($comid);
				}
                
                ?>"><?php echo VOLVER_BUSQUEDA; ?></a>
               
			
			</article>
			
			<div class="col-special-one-third" id="book-form">
			
				<?php include("includes/book-form.php"); ?>
			 					
			</div>
			
		</div>

	</section>
	
	<section class="wrapper wrapper--darkcream">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h3-header"><?php echo TAMBIEN_INTERESA; ?></h2>
			    
			<div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">

<?php
	$cont_establiment = 1;

	$db->orderBy('rand()');
	$db->where('published',1);
	$db->where('eid',$id,"<>");
	$db->where('persons_min',$persons,"<");
	$db->where('persons',$persons,">=");

	$query=$db->get('establiments',null,"eid, title, description_small_".$lng.", subtitle_".$lng.", persons, persons_min, lid, pvid, tid, comid, published, recommended");

	foreach($query as $rs){
		if($cont_establiment <= 3){
			if ($tipo=="") $tipo = 'all';
			
			if ($datein != "" && $dateout != "") {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,''),2);
			} else {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", strtotime("next saturday")),'',$tipo,''),2);
			}
			
			if ($bestprice != 0 ) {
	?>                
					
					<div class="item"><?php include("includes/card-v.php"); ?></div>
	<?php		
				$cont_establiment++;
			}
		}
	}
?>				  
				  
			</div>
			
		</div>
	
	</section>
	

<?php //include("includes/newsletter.php"); ?>

<!-- Calendario Booking -->
<script type="text/JavaScript" src="assets/js/BookingCalendar/js/jquery.dop.BookingCalendar_<?php echo $lng; ?>.js"></script>
    <script src="assets/js/jquery.dop.Select.js"></script>
    <script src="assets/js/dop-prototypes.js"></script>
    <script src="assets/js/jquery.dop.BackendBookingCalendarPRO.js"></script>
    <script src="assets/js/jquery.dop.FrontendBookingCalendarPRO.js"></script>

<script type="text/JavaScript">

    $('#casa-rural-ficha-disponibilitat2').DOPFrontendBookingCalendarPRO(
	{
      'loadURL': 'assets/js/BookingCalendar/php/load_establimentpreus2.php?eid=<?php echo $id; ?>',
      'days': {"data": {"available": [true, true, true, true, true, true, true],
                      "first": 1,
                      "morningCheckOut": false,
                      "multipleSelect": true},
               'text': {'names': <?php echo json_encode($dias_semana); ?>,
               			"shortNames": <?php echo json_encode($abrev_dias_semana); ?>}
           				
           	   },
       "months": {"data": {"no": 1},
                  "text": {'names': <?php echo json_encode($meses); ?>,
               			   "shortNames": <?php echo json_encode($abrev_meses); ?>}
               		
               	}
    });
</script>
<?php 
	$diasValidos=array();
	$fechasTotal=array();
	$db->where('eid',$id);
	$db->where('availability',1);
	$query=$db->get('establiments_prices',null,' date');
	
	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    
	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}

	$aniomas=date('Y')+1;
	$fechasTotal=createDateRangeArray(date('Y-m-d'),$aniomas.date('-m-d'));
	foreach($query as $rs){
		$clave= array_search($rs['date'], $fechasTotal);
		if($clave!=null){ unset($fechasTotal[$clave]);}
	}
	foreach($fechasTotal as $fecha){
		array_push($diasValidos, $fecha);
	}
	//print_r($fechasTotal);
?>
<script type="text/JavaScript">
	var array_dias_a_desactivar=<?php echo json_encode($diasValidos);?>;
</script>




<script type="text/JavaScript">
	var detalle_de_disponiblidad = [];
	var detalle_de_reservaciones = [];
	
	$(document).ready(function() {
		var url = 'assets/js/BookingCalendar/php/load_establimentpreus2.php?eid=<?php echo $id; ?>';
		console.log("cargando dias disponibles para la habitacion...");
		$.post(url , function (data){
			detalle_de_disponiblidad = JSON.parse(data);
		});

		var urlGetReservations = 'api/getReservations.php?eid=<?php echo $id; ?>';
		
		$.post(urlGetReservations , function (data){
			detalle_de_reservaciones = JSON.parse(data);

		
		});
	});
</script>



<?php include("includes/footer.php"); ?>