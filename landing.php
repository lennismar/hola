<?php 
ob_start();
if(!isset($url2) && !isset($url3)){
	include 'includes/config.php';
}



include("includes/landing.php");

$meta_title = $landing['meta_title_'.$lng]. " - ".SEO_ESTABLIMENT_SUFIX." | Somrurals.com";
$meta_description=$landing['meta_description_'.$lng];
$meta_keywords=$landing['meta_keywords_'.$lng];
$meta_index="";
$meta_follow="";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

	include("includes/head.php");

?>

<!-- CSS -->
<link href="assets/js/jsPages/jpages.css" rel="stylesheet">

<!-- JsPages -->    
<script src="assets/js/jsPages/jPages.min.js"></script>

<script>
  /* when document is ready */
  $(function() {
    /* initiate plugin */
    $("div.holder").jPages({
        containerID: "itemContainer",
        minHeight: false,
        perPage      : 15,
        previous: "Anterior",
        next: "Siguiente",
        startPage    : 1,
        startRange   : 0,
        midRange     : 4,
        endRange     : 1			  
    });
	
	/* destroy pagination */
    $("a.destroypagination").click(function(){
        /* destroy jpages */
      $("div.holder").jPages("destroy");
      /* remove button */
      $(this).remove();
    });		
  });
</script>  

<?php //if(!isset($url2) && !isset($url3)) { ?>
<!-- Google Maps API v2-->
    <style>
        .map-search-canvas {overflow: hidden}
    </style>

<!-- Google Maps-->
<script type="text/javascript">

	//<![CDATA[
	function load() {
		if (GBrowserIsCompatible()) {
            var mapOptions = {
                zoom: 10,
                scrollwheel: false,
            };
			var map = new GMap2(document.getElementById("map-search-canvas"), mapOptions);
			map.addControl(new GSmallMapControl());
			
			<?php 
			session_start();
			$_SESSION['ids'] = array_envia($establiments);		
			?>
			
			GDownloadUrl("gmaps.php?g=establiments", function(data) {
				
				var xml = GXml.parse(data);
				var markers = xml.documentElement.getElementsByTagName("marker");
				var bounds = new GLatLngBounds();
				
				// De la consulta a gmaps.php devuelve el XML con todos los campos necesarios
				for (var i = 0; i < markers.length; i++) {
					var title = markers[i].getAttribute("title");
					var localitat = markers[i].getAttribute("localitat");
					var address = markers[i].getAttribute("address");
					var eid = markers[i].getAttribute("eid");
					var imagen = markers[i].getAttribute("imagen");
					var tipus = markers[i].getAttribute("tipus");
					var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
																	parseFloat(markers[i].getAttribute("lng")));
					var price = markers[i].getAttribute("price");
					var bedrooms = markers[i].getAttribute("bedrooms");
					var bathrooms = markers[i].getAttribute("bathrooms");
					var persons = markers[i].getAttribute("persons");
					var url = markers[i].getAttribute("url");
					bounds.extend(point);																	
					var marker = createMarker(point, title, address, eid, localitat, imagen, tipus, price, bedrooms, bathrooms, persons, url);
					map.addOverlay(marker);
				}
				
				// Centramos el mapa sobre los resultados obtenidos y le damos el zoom necesario
				<?php if ($num_establiment_disponibles!=0) { ?>
					var zoom = map.getBoundsZoomLevel(bounds);
					if (zoom > 10 ) zoom = 10;
					map.setCenter(bounds.getCenter(), zoom);
				<?php } ?>
			});
			
			
			<?php  // Si no hay establecimientos se encuadra el mapa a toda Catalunya
			
			if ($num_establiment_disponibles==0) { ?> map.setCenter(new GLatLng(41.590797,1.521606), 7); <?php } ?>
			
		}
	}


	// Función que monta el HTML del globo en el Google Maps
	function createMarker(point, title, address, eid, localitat, imagen, tipus, price, bedrooms, bathrooms, persons,url) {
		//var marker = new GMarker(point, {icon:iconRed, title:name});
		var marker = new GMarker(point);
		var contentString = '<div id="content-map-pin">'+
					'<div id="siteNotice">'+
					'</div>'+
					'<div class="card-header">'+
					'<div class="house-class">'+tipus+'</div>'+
					'<div class="house-TypeDot"></div>'+
					'<div class="card-title">'+ title +'</div>'+
					'</div>'+
					'<div class="card-img">'+
					'<div class="card-price"><?php echo DESDE; ?><span class="card-price-hightlight">'+price+'€ </span><?php echo PERSONA_NOCHE; ?></div>'+
					'<img src="<?php echo CDN_BASE; ?>images/uploads/establiments/'+imagen+'" alt="foto-casa" width="300"/>'+
					'</div>'+
					'<div class="card-items-core">'+
					'<span class="card-person"><?php echo PERSONAS; ?> <strong>'+persons+'</strong></span>'+
					'<span class="card-rooms"><?php echo HABITACIONES; ?> <strong>'+bedrooms+'</strong></span>'+
					'<span class="card-baths"><?php echo BANOS; ?> <strong>'+bathrooms+'</strong></span>'+
					'</div>'+
					'<a href="'+url+'" class="card-btn"><?php echo VER_CASA; ?></a>'+
					'</div>';

		contentString = contentString.toString().replace("&lt;br /&gt;", "<br />");
		GEvent.addListener(marker, 'click', function() {
			marker.openInfoWindowHtml(contentString);
		});
		return marker;
	}
	//]]>
	
	$(document).ready(function(){
		$('#map-search-canvas').hide();
		$('.btn-list').hide();
		
		$(".icon--map").on( "click", function() {
			$('#map-search-canvas').show("linear");
			$('#itemContainer').hide("linear");
			$('.btn-list').show("linear");
			$('.btn-map').hide("linear");

			load();
		 });
		 
		$(".icon--list").on( "click", function() {
			$('#map-search-canvas').hide("linear");
			$('#itemContainer').show("linear");
			$('.btn-map').show("linear");
			$('.btn-list').hide("linear");

		});
		
		$(".holder").click(function(){
			var aTag = $("#itemContainer");
			$('html,body').animate({scrollTop: aTag.offset().top},'slow');
		});	
			
		
	});
	
</script>
<?php //} ?>
<body>
	<!-- Tracking code para registrar la busqueda -->
	<script>
	gtag('event', 'page_view', {
	  'send_to': 'AW-873759961',
	  'hrental_pagetype': 'searchresults '
	});

	</script>

<?php include("includes/tag-manager.php"); ?>

<?php include("includes/mobile-bar-filters.php"); ?>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper">
	
		<div class="hero" id="hero-landing">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1><?php echo $landing['title_'.$lng]; ?></h1>
					<p class="hero-subtitle"><?php echo $landing['subtitle_'.$lng]; ?></p>
					
					<div class="hero-inner-buttons">
						<a href="<?php echo $current_url; ?>#encuentra" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--find-white">Encuentra tu casa rural</span></a>
						<a href="<?php echo $current_url; ?>#favoritas" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--love-white">Nuestras casas favoritas</span></a>
						<a href="<?php echo $current_url; ?>#quever" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--quever-white">Qué ver</span></a>
					</div>
					
				</div>
			
			</div>
		
		</div>
		
	</div>
	
	<script>
		// Ciclo de imágnes en background en la cabecera
		$(document).ready(function() {
			$("#hero-landing").backgroundCycle({
				imageUrls: [
				<?php
				if ($landing['headimage1'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/landings/".$landing['headimage1']."',"; else echo CDN_BASE."'assets/img/bg-home-1.jpg',";
				if ($landing['headimage2'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/landings/".$landing['headimage2']."',"; else echo CDN_BASE."'assets/img/bg-home-2.jpg',";
				if ($landing['headimage3'] != "") echo "'image.php?width=1400&height=391&cropratio=1400:391&quality=70&image=/images/uploads/landings/".$landing['headimage3']."'"; else echo CDN_BASE."'assets/img/bg-home-3.jpg'";
				?>
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
			
			$(".bottom-nav").click(function(){
				var aTag = $("#encuentra");
				$('html,body').animate({scrollTop: aTag.offset().top},'slow');
			});	
			
		});

	</script>
    
	<div class="wrapper wrapper--darkcream result-search-bar" id="encuentra">
	
		<div class="page-container-fixed-small">
	
		<!-- Busqueda -->
			
			<div class="btn-show-search btn-expand-extra-content"><?php echo BUSCAR; ?></div>
				
			<div class="main-search-form main-search-form--inside extra-content">
				
				<?php include("includes/main-search.php"); ?>
								
			</div>
			
		<!-- Fin búsqueda -->

		</div>
		
	</div>
		
	<div class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<aside class="col-pad col-pad--fourth only-desktop">
				
				<?php include("includes/filters.php"); ?>
			
			</aside>
			
			<article class="col-pad col-pad--three-fourth">
			
				<div class="search-info clearfix">
				
					<div class="search-results-number"><?php echo HAY; ?> <strong class="text-color--orange"><?php echo $num_establiment_disponibles . " " .CASAS_RURALES; ?></strong> <?php echo ESPERANDOTE_EN; ?> <span class="text-color--orange"><?php echo $title_where; ?></span></div>
					
					<div class="search-results-map btn-map"><a class="icon icon--map" data-type="iframe" style="cursor:pointer">Mapa</a></div>

					<div class="search-results-map btn-list"><a class="icon icon--list" style="cursor:pointer">Lista</a></div>
				
				</div>
                
                <?php echo $txt_adv; ?>
				
				<div class="search-results" id="itemContainer">
				<?php 
                $cont_establiment = 0;
                if (is_array($establiments)) {
                    foreach ($establiments as $establiment) {
                    	include("includes/card-h.php");			
                    }
                }
                ?>
                </div>

                <div class="map-search-canvas" id="map-search-canvas"></div>

                <div class="holder pagination-wrapper push--top clearfix" id="paginator" align="center"></div>
                <div><a class="destroypagination" style="float:right; position:relative; margin-top:-15px; text-decoration:underline; cursor:pointer">Ver todas</a></div>
                
			</article>
			
		</div>

	</div>


	<div class="wrapper wrapper--darkcream" id="favoritas">
	
		<div class="page-container-fixed-pad">
		
			<p class="text-sub-header"><?php echo $landing['content_'.$lng]; ?></p>			
				
		</div>
	
	</div>

	<?php //include("includes/newsletter.php"); ?>



<?php 

include("includes/footer.php"); 

ob_end_flush();
?>