<?php
include 'includes/config.php';
$id = $_GET['id'];

//$query = mysql_query("SELECT idrecurso, title_".$lng.", smalldescription_".$lng.", description_".$lng.", quever_".$lng.", infopract_".$lng.", seowords_".$lng.", info_quan, info_on, info_more, gmap_lat, gmap_lng, image, headimage1, headimage2, headimage3, pvid, comid, idtipusrecurso FROM recursos WHERE idrecurso=".$id);
$db->where('idrecurso',$id);
$query=$db->get('recursos',null,"idrecurso, title_".$lng.", smalldescription_".$lng.", description_".$lng.", quever_".$lng.", infopract_".$lng.", seowords_".$lng.", info_quan, info_on, info_more, gmap_lat, gmap_lng, image, headimage1, headimage2, headimage3, pvid, comid, idtipusrecurso");
//while ($rs = mysql_fetch_array($query)) {
foreach($query as $rs){
	$idrecurso = $rs['idrecurso'];
	$title = htmlspecialchars($rs['title_'.$lng]);
	$smalldescription = htmlspecialchars($rs['smalldescription_'.$lng]);
	$description = $rs['description_'.$lng];
	$quever = $rs['quever_'.$lng];
	$infopract = $rs['infopract_'.$lng];
	$seowords = htmlspecialchars($rs['seowords_'.$lng]);
	$info_quan = htmlspecialchars($rs['info_quan']);
	$info_on = htmlspecialchars($rs['info_on']);
	$info_more = htmlspecialchars($rs['info_more']);
	$gmap_lat = htmlspecialchars($rs['gmap_lat']);
	$gmap_lng = htmlspecialchars($rs['gmap_lng']);
	$image = htmlspecialchars($rs['image']);
	$headimage1 = htmlspecialchars($rs['headimage1']);
	$headimage2 = htmlspecialchars($rs['headimage2']);
	$headimage3 = htmlspecialchars($rs['headimage3']);
	$pvid = $rs['pvid'];
	$comid = $rs['comid'];
	$idtipusrecurso	 = $rs['idtipusrecurso'];
}

$breadcrumb_pvid=$pvid;
$breadcrumb_comid=$comid;
$breadcrumb_lid="";

$meta_title=$title." | Somrurals.com";
$meta_description=html_entity_decode(strip_tags($smalldescription), ENT_QUOTES, 'utf-8');;
$meta_keywords=$seowords;
$meta_index="";
$meta_follow="";

$og_site_name="somrurals.com";
$og_title=$title;
$og_url=URL_BASE . $lng."/".URL_RECURSOS_TURISTICOS."/".urls_amigables(GetTitleProvincia($pvid))."/".urls_amigables(GetTitleComarca($comid))."/".urls_amigables($title)."-".$idrecurso;;
$og_image=URL_BASE . "images/uploads/recursos/".$image;
/*
    <meta property="og:site_name" content="somrurals.com"/> 
    <meta property="og:title" content="<?php echo $title; ?>"/>
    <meta property="og:description" content="<?php echo html_entity_decode(strip_tags($smalldescription), ENT_QUOTES, 'utf-8'); ?>" />
    <meta property="og:image" content="<?php echo URL_BASE . "images/uploads/recursos/".$image; ?>" />
    <meta property="og:url" content="<?php echo URL_BASE . $lng."/".URL_RECURSOS_TURISTICOS."/".urls_amigables(GetTitleProvincia($pvid))."/".urls_amigables(GetTitleComarca($comid))."/".urls_amigables($title)."-".$idrecurso;?>"/>
    <meta property="og:type" content="article" />
    <meta property="og:country-name" content="España"/>
    <meta property="og:locale" content="<?php echo $lng."_".CODIGO_GEO; ?>"/>
    <meta property="og:latitude" content="<?php echo $gmap_lat; ?>"/> 
    <meta property="og:longitude" content="<?php echo $gmap_lng; ?>"/>     
    <meta property="og:street-address" content="<?php echo $info_on; ?>"/>     
    <meta property="og:region" content="<?php echo GetTitleProvincia ($pvid); ?>"/>   
*/

include("includes/head.php");

?>

<body>

<?php include("includes/tag-manager.php"); ?>

<script>
	(function() {
	  $(function() {
	    $("body").on("click", ".example_controls button", (function(_this) {
	      return function(e) {
	        return $(e.currentTarget).closest(".example").find("iframe")[0].contentWindow.scroll_it();
	      };
	    })(this));
	    return $("#menu-fixed-top").stick_in_parent().on("sticky_kit:stick", (function(_this) {
	      return function(e) {
	        return setTimeout(function() {
	          return $(e.target).addClass("show_hidden");
	        }, 0);
	      };
	    })(this)).on("sticky_kit:unstick", (function(_this) {
	      return function(e) {
	        return setTimeout(function() {
	          return $(e.target).removeClass("show_hidden");
	        }, 0);
	      };
	    })(this));
	  });

	}).call(this);

</script>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper">
	
		<div class="hero" id="hero-ficha-recurso">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1><?php echo $title; ?></h1>
					
					<p class="hero-subtitle"><?php echo $smalldescription; ?></p>
					
				</div>
			
			</div>
		
		</div>
		
	</div>
	
	<script>
		
		$(document).ready(function() {
			$("#hero-ficha-recurso").backgroundCycle({
                var cdn_base = '<?php echo CDN_BASE; ?>';
				imageUrls: [
					cdn_base+'assets/img/bg-ficha-recurso-1.jpg',
                    cdn_base+'assets/img/bg-ficha-recurso-2.jpg',
                    cdn_base+'assets/img/bg-ficha-recurso-3.jpg'
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
			
		});

	</script>

	<!-- submenu -->

	<div class="wrapper wrapper--darkcream" id="menu-fixed-top">
	
		<div class="page-container-fixed">
		
			<div class="second-level--menu only-desktop">
			
				<a href="<?php echo $current_url; ?>#descripcion" class="btn-smooth-scroll"><?php echo DESCRIPCION;?></a>
				<a href="<?php echo $current_url; ?>#quever" class="btn-smooth-scroll">Qué ver</a>
				<a href="<?php echo $current_url; ?>#donde" class="btn-smooth-scroll"><?php echo DONDE; ?></a>
				<a href="<?php echo $current_url; ?>#informacion" class="btn-smooth-scroll"><?php echo INFORMACION; ?></a>
				<a href="<?php echo $current_url; ?>#casas" class="btn-smooth-scroll"><?php echo CASAS_QUE_TE_VAN_GUSTAR; ?></a>
			
			</div>
			
			<a href="<?php echo GetListEstablimentsCom($comid,$pvid,$lng); ?>" class="big-button-related">
				<div class="big-button-related--ico">
					<svg width="21px" height="21px" viewBox="0 0 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
   					    <g id="7.-Detalle-RRTT" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="7.1.Detalle-RRTT-Desktop" sketch:type="MSArtboardGroup" transform="translate(-908.000000, -540.000000)" fill="#777777">
					            <g id="submenu" sketch:type="MSLayerGroup" transform="translate(0.000000, 521.000000)">
					                <path d="M919.370218,20.3490543 C918.892005,19.8204335 918.108341,19.8204335 917.629237,20.3490543 L908.268906,30.3264753 C907.789802,30.8541479 907.968353,31.2874747 908.665636,31.2874747 L910.616335,31.2874747 L910.616335,38.9493944 C910.616335,39.5036166 910.638599,39.9525887 911.578995,39.9525887 L916.12202,39.9525887 L916.12202,32.2683862 L920.877435,32.2683862 L920.877435,39.9525887 L925.647544,39.9525887 C926.363973,39.9525887 926.383119,39.5036166 926.383119,38.9493944 L926.383119,31.2874747 L928.334709,31.2874747 C929.031102,31.2874747 929.210543,30.8541479 928.730994,30.3264753 L919.370218,20.3490543 Z" id="Imported-Layers" sketch:type="MSShapeGroup"></path>
					            </g>
					        </g>
					    </g>
					</svg>
				</div>
			
				<!--<div class="big-button-related--number"><?php echo  GetNumEstablimentsCom($comid,$pvid); ?></div>-->
				<div class="big-button-related--text">Casas rurales cerca</div>
				<div class="big-button-related--go">Ver
					<svg width="10px" height="12px" viewBox="0 0 10 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
						<g id="7.-Detalle-RRTT" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="7.1.Detalle-RRTT-Desktop" sketch:type="MSArtboardGroup" transform="translate(-1133.000000, -545.000000)" fill="#E47F4B">
					            <g id="submenu" sketch:type="MSLayerGroup" transform="translate(0.000000, 521.000000)">
					                <path d="M1133.00098,24 L1133,35.7449362 L1142.7561,29.8715745 L1133.00098,24" id="Imported-Layers-2" sketch:type="MSShapeGroup"></path>
					            </g>
					        </g>
					    </g>
					</svg>
				</div>
			</a>
		
		</div>
	</div>
	<script>
		
		$(document).scroll(function () {
			var scroll = $(this).scrollTop();
			var topDist = $("#menu-fixed-top").position();
			if (scroll > topDist.top) {
				$('#menu-fixed-top').css({"position":"fixed","top":"0"});
			} else {
				$('#menu-fixed-top').css({"position":"static","top":"auto"});
			}
		});
		
		
	</script>
	
	<!-- Contenido -->
	
	<section class="wrapper">
	
		<div class="page-container-fixed">
		
			<main class="col-pad col-pad--three-fourth push-half--ends">

			    <?php include("includes/breadcrumb.php"); ?>
			    
			    <div class="row push-half--top">
			    
			    	<span class="icon icon--place-green"><?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?></span>
			    	
			    	<span class="icon icon--date-green"><?php echo $info_quan; ?></span>
			    
					<div class="float--right ficha-share"><?php include("includes/share-buttons.php"); ?></div>
			    
			    </div>
			    
			    <article class="dd" style="background:#fff;">
			    
					<div class="content-block" id="descripcion">
					
						<h2><?php echo DESCRIPCION;?></h2>
						<?php echo $description; ?>
                        <!--
						<p>En el parque encontramos rastros bien conservados de dos periodos históricos principales.</p>
						
						<ul class="block-list-circle-orange">
							<li>Románico: son numerosas las iglesias del periodo que podemos encontrar por todo el territorio, tanto en pequeñas poblaciones como en lugares aislados.</li>
							<li>Medieval: el pasado medieval del parque tiene que ver con las presencia de los condes de Cerdenya, que utilizaban los castillos de Saldes y Gósol (las dos localidades más próximas) para defender su territorio. Alrededor de los dos castillos nacieron las localidades que encontramos hoy.</li>
						</ul>
						-->
					</div>
					
					<div class="content-block" id="quever">
						<h2>Qué ver</h2>
						<?php echo $quever; ?>						
					</div>
                    <!--
					<div class="content-block" id="fotos">
					
						<h2>Fotos</h2>
						
						<div class="fotorama" data-width="100%" data-nav="thumbs" data-loop="true">
				
							<img src="assets/img/foto-casa.jpg">
							
							<img src="assets/img/foto-casa2.jpg">
							
							<img src="assets/img/foto-casa3.jpg">
							
							<img src="assets/img/foto-casa4.jpg">
							
							<img src="assets/img/foto-casa.jpg">
							
							<img src="assets/img/foto-casa2.jpg">
							
							<img src="assets/img/foto-casa3.jpg">
							
							<img src="assets/img/foto-casa4.jpg">
							
							<img src="assets/img/foto-casa.jpg">
							
							<img src="assets/img/foto-casa2.jpg">
							
							<img src="assets/img/foto-casa3.jpg">
							
							<img src="assets/img/foto-casa4.jpg">
					
						</div>
						
					</div>
					-->
                    
					<div class="content-block" id="informacion">
					
						<h2>Información práctica</h2>
						<?php echo $infopract; ?>
                        <!--
						<p>Si buscáis información adicional sobre el parque os podéis dirigir al centro de Información e Interpretación del Massís del Pedraforca.</p>
						<p>Dirección: Pl. Pedraforca, s/n - 08699 Saldes</p>
						<p>Contacto: saldes@diba.es</p>
						<p>Tlfn: 93 825 80 46</p>
						<p><strong>Enlaces de interés</strong></p>
						<p><a href="#" target="_blank">Rutas Masssis Pedraforca (Wikiloc)</a></p>
						<p><a href="#" target="_blank">Rutas Massis Pedraforca (Oficial)</a></p>
						<p><a href="#" target="_blank">Rutas Massis Pedraforca (Itineraris Geològics)</a></p>
						<p><a href="#" target="_blank">Actividades del Parque</a></p>
						<p><a href="#" target="_blank">Actividades del Parque</a></p>
						<p><a href="#" target="_blank">Agenda de Actividades</a></p>
						<p><a href="#" target="_blank">Mapa (PDF)</a></p>
						-->
                        
					</div>	
					
					<div class="content-block" id="donde">
					
						<h2><?php echo DONDE; ?></h2>
						
						<!--<a href="#" class="icon icon--map push-half--bottom">Cómo llegar</a>-->
						
						<script>
						// This example displays a marker at the center of Australia.
						// When the user clicks the marker, an info window opens.
						
							function initialize() {
							  var myLatlng = new google.maps.LatLng(<?php echo $gmap_lat; ?>,<?php echo $gmap_lng; ?>);
							  var mapOptions = {
							    zoom: 10,
							    center: myLatlng
							  };
							
							  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
							  
							  var contentString = '<div id="content">'+
							      '<div id="siteNotice">'+
							      '</div>'+
							      '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
							      '<div id="bodyContent">'+
							      '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
							      'sandstone rock formation in the southern part of the '+
							      'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
							      'south west of the nearest large town, Alice Springs; 450&#160;km '+
							      '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
							      'features of the Uluru - Kata Tjuta National Park. Uluru is '+
							      'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
							      'Aboriginal people of the area. It has many springs, waterholes, '+
							      'rock caves and ancient paintings. Uluru is listed as a World '+
							      'Heritage Site.</p>'+
							      '<p>Attribution: Uluru, <a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
							      'http://en.wikipedia.org/w/index.php?title=Uluru</a> '+
							      '(last visited June 22, 2009).</p>'+
							      '</div>'+
							      '</div>';
							
							  var infowindow = new google.maps.InfoWindow({
							      //content: contentString
							  });
							
							  var marker = new google.maps.Marker({
							      position: myLatlng,
							      map: map,
							      title: 'Apartamentos rurales con barbacoa en Garrotxa',
							      icon: 'assets/img/icon-point-map.svg'
							  });
							  google.maps.event.addListener(marker, 'click', function() {
							    infowindow.open(map,marker);
							  });
							}
							
							google.maps.event.addDomListener(window, 'load', initialize);
						
						</script>
						
						<div class="map-canvas" id="map-canvas">
						
					</div>			    
				
				</article>
			    			    
			</main>
			
			<aside class="col-pad col-pad--fourth only-desktop push--top sidebar-related">
			
				<span class="sidebar-header"><?php echo MAS_POR_LA_ZONA; ?></span>
<?php
	//$query = mysql_query("SELECT idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid FROM recursos WHERE published = 1 ORDER BY RAND() LIMIT 4");
	$db->where('published',1);
	$query=$db->get('recursos',null," idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid");
	//while($place = mysql_fetch_array($query)){
	foreach($query as $place){
?>
			
				<?php include("includes/card-places.php"); ?>
<?php				
	}
?>                               
			
			</aside>
			
		</div>
	
	</section>
	
	<!-- Casas relacionadas -->
	
	<section class="wrapper wrapper--darkcream" id="casas">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Casas rurales que nos gustan cerca de <?php echo $title; ?></h2>
			    
			<div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
<?php
	// LAS MÁS DESTACADAS. HOME = 1
	$cont_establiment = 1;
	//$query = mysql_query("SELECT * FROM establiments WHERE published = 1 AND pvid = ".$pvid." ORDER BY RAND()");
	$db->orderBy('rand()');
	$db->where('published',1);
	$db->where('pvid',$pvid);
	$query=$db->get('establiments',null,'*');
	//while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){
	foreach($query as $rs){
		if($cont_establiment <= 3){
			if ($datein!="") {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $_SESSION['datein']),date("Y-m-d"), $dateout,1,''),2);
			} else {
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", strtotime("next saturday")),'','all',''),2);
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
			
			<a class="btn--more push--top" href="busqueda.php">Ver todas</a>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php //include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>