<?php 
ob_start();
include 'includes/config.php';
if(isset($_GET['tipo']) && $_GET['tipo'] == "index.php") {
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".URL_BASE); 
	exit();
}
//echo 'a';
include("includes/search.php");
//echo 'b';
$meta_title= SEO_SEARCH_TITLE . " " .$title_where." - ".SEO_ESTABLIMENT_SUFIX." | Somrurals.com";
$meta_description=str_replace('<where>', $title_where, SEO_SEARCH_DESCRIPCION);
$meta_keywords=str_replace('<where>', $title_where, SEO_SEARCH_KEYWORDS);
$meta_index="";
$meta_follow="";

# Fichero que personaliza el  meta-title en los casos estipulados
include("includes/manage-search-meta.php");

# Ajustes de rel=canonical
$rel_canonical = '<link rel="canonical" href="'.URL_BASE.'" />';

$array_slugs_casas_rurales = array('casas-rurales', 'cases-rurals', 'holiday-cottages', 'maisons-rurales');
if(isset($_GET['tipo']) && in_array($_GET['tipo'], $array_slugs_casas_rurales)) $rel_canonical = '<link rel="canonical" href="'.URL_BASE.''.$_SESSION['lng'].'/'.$_GET['tipo'].'" />';
if(!empty($_GET['provincia']) && $_GET['provincia'] != 'all' && (empty($_GET['comarca']) || $_GET['comarca'] == 'all'))  $rel_canonical = '<link rel="canonical" href="'.URL_BASE.''.$_SESSION['lng'].'/'.URL_SEARCH.'/'.$_GET['provincia'].'" />';
if(!empty($_GET['provincia']) && $_GET['provincia'] != 'all' && !empty($_GET['comarca']) && $_GET['comarca'] != 'all')  $rel_canonical = '<link rel="canonical" href="'.URL_BASE.''.$_SESSION['lng'].'/'.URL_SEARCH.'/'.$_GET['provincia'].'/'.$_GET['comarca'].'" />';
//exit($rel_canonical);
$pre_title = CASAS_RURALES;
if(!empty($_GET['provincia']) && empty($_GET['comarca'])) $pre_title = SEO_SEARCH_TITLE;

$og_site_name="";
$og_title="";
$og_url="";

$imagenes_ =  landingHeadImages ($where[0],$where[1]);
$imagenes = explode(',', $imagenes_);
$imagen = str_replace("'", '', $imagenes[0]);
$og_image=URL_BASE.$imagen;


$enable_gmaps = TRUE;

if(empty($url2)) include("includes/head.php");
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

<!-- Google Maps API v3-->
    <style>
        .map-search-canvas {overflow: hidden}
    </style>

<!-- Google Maps-->
<script type="text/javascript">
    // Calcula el numero de objetos dentro de un objeto
    function ObjectLength( object ) {
        var length = 0;
        for( var key in object ) {
            if( object.hasOwnProperty(key) ) {
                ++length;
            }
        }
        return length;
    };

	//<![CDATA[
	function load() {
	    var mycenter = new google.maps.LatLng(41.590797,1.521606);
        var mapOptions = {
            zoom: 8,
            scrollwheel: false,
            center : mycenter
        };

        var map = new google.maps.Map(document.getElementById("map-search-canvas"), mapOptions);
        //map.addControl(new GSmallMapControl());

        <?php
        session_start();
        $_SESSION['ids'] = array_envia($establiments);

        $establiments_formateados = $establiments;
        for($i=0; $i<count($establiments); $i++) {
            $establiments_formateados[$i]['localitat'] = GetTitleLocalitat($establiments[$i]['lid']);
            $establiments_formateados[$i]['imagen'] = str_replace('/', '/thumb_', $establiments[$i]['imagen']);
            $establiments_formateados[$i]['tipus'] = GetTitleTipusEstabliment($establiments[$i]['eid'],'');
            $establiments_formateados[$i]['url'] = $lng.'/'.URL_CASA_RURAL.'/'.urls_amigables($establiments[$i]['title']).'-'.$establiments[$i]['eid'];
        }

        ?>

        var markers = <?php echo json_encode($establiments_formateados); ?>;
        var bounds = new google.maps.LatLngBounds();

        for( var key in markers ) {

            console.log(markers[key]);
            var title = markers[key].title;
            var localitat = markers[key].localitat;
            var address = markers[key].address;
            var eid = markers[key].eid;
            var imagen = markers[key].imagen;
            var tipus = markers[key].tipus;
            var point = new google.maps.LatLng(parseFloat(markers[key].gmap_lat), parseFloat(markers[key].gmap_lng));
            var price = markers[key].bestprice;
            var bedrooms = markers[key].bedrooms;
            var bathrooms = markers[key].bathrooms;
            var persons = markers[key].persons_min + ' - ' + markers[key].persons;
            var url = markers[key].url;

            //extend the bounds to include each marker's position
            bounds.extend(point);

            var marker = createMarker(map, point, title, address, eid, localitat, imagen, tipus, price, bedrooms, bathrooms, persons, url);

            //map.addOverlay(marker);
            //marker.setMap(map);

        }

        //now fit the map to the newly inclusive bounds
        google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
            this.setZoom(map.getZoom()-1);

            if (this.getZoom() > 15) {
                this.setZoom(15);
            }
        });

        map.fitBounds(bounds);


	}


	// Función que monta el HTML del globo en el Google Maps
	function createMarker(map, point, title, address, eid, localitat, imagen, tipus, price, bedrooms, bathrooms, persons, url) {
		//var marker = new GMarker(point, {icon:iconRed, title:name});
		var marker = new google.maps.Marker({
            position: point,
            map: map
        });
		var contentString = '<div id="content-map-pin">'+
					'<div id="siteNotice">'+
					'</div>'+
					'<div class="card-header">'+
					//'<div class="house-class">'+tipus+'</div>'+
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
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
		marker.addListener( 'click', function() {
            infowindow.open(map, marker);
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
	
    <?php if ($landing) { ?>
	<div class="wrapper">
	
		<div class="hero" id="hero-landing">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1 id="tituloptativo"><?php echo $pre_title . " ". EN . " " .$title_where; ?></h1>
					<p class="hero-subtitle"><?php echo str_replace('<location>', $title_where, LANDING_SUBTITLE); ?></p>
					
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
					echo landingHeadImages ($where[0],$where[1]);
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
    
	<?php } ?>
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
					//echo '<pre>';print_r($establiments);echo '</pre>';
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
    <?php
    /**
     * TEXTOS EN LANDINGS DE PROVINCIAS
     */
    if(isset($_GET['tipo'])  && !empty($_GET['provincia']) && empty($_GET['comarca'])) {
        echo '<div class="wrapper wrapper--darkcream" id="favoritas">'."\r\n";
        echo '<div class="page-container-fixed-pad">'."\r\n";
        echo '<h2 class="h2-header">'.strtoupper($_GET['provincia']).'</h2>'."\r\n";
        echo '<p class="text-sub-header">'.constant('LANDING_'.strtoupper($_GET['provincia']).'_FOOTER').'</p>'."\r\n";
        echo '</div>'."\r\n";
        echo '</div>'."\r\n";
    }
    ?>


<?php if ($landing) { ?>	
<!-- Casas que te van a gustar (Segmentacicon) -->
	
	<div class="wrapper wrapper--darkcream" id="favoritas">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header"><?php echo CASAS_QUE_TE_VAN_GUSTAR . " " .EN. " " .$title_where; ?></h2>
			
			<p class="text-sub-header"><?php echo PARA_QUE_LAS_DISFRUTES; ?></p>			
		
			<div class="row">
<?php 
	$cont_establiment = 1;
	$filter = "";	
	if ($where[0]=='p' && !(empty($where[1]))) { /*$filter = "pvid = ".$where[1]." AND ";*/ $db->where('pvid',$where[1]);} 
	if (($where[0]=='c') && !(empty($where[1])) ) { /*$filter = "comid = ".$where[1]." AND ";*/ $db->where('comid',$where[1]);}
	//$query = mysql_query("SELECT eid, title,  subtitle_".$lng.", persons, persons_min, description_small_".$lng.", lid, pvid, tid, comid, published, dateadded, recommended FROM establiments WHERE ".$filter." published = 1 AND recommended = 1 ORDER BY RAND() LIMIT 4");
	$db->where('published',1);
	$db->where('recommended',1);
	$db->orderBy('rand()');
	$query=$db->get('establiments',4,"eid, title,  subtitle_".$lng.", persons, persons_min, description_small_".$lng.", lid, pvid, tid, comid, published, dateadded, recommended");
	//while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){
	foreach($query as $rs){
		if($cont_establiment <= 3){
?>
			    <div class="col-pad col-pad--third">
			        <?php include("includes/card-recommended.php"); ?>	
			    </div>			
<?php
			$cont_establiment++;
		}
	}
?>
			</div>
				
		</div>
	
	</div>

<!-- Lugares para descubrir (slect)-->
	
	<section class="wrapper wrapper--white" id="quever">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Qué ver en <?php echo $title_where; ?></h2>
			
			<p class="text-sub-header"><?php echo HAZ_DE_TU_ESTANCIA; ?></p>
				
			<div id="owl-places" class="owl-carousel owl-theme clearfix owl-places">
<?php
//$query = mysql_query("SELECT idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid FROM recursos WHERE pvid=2 ORDER BY RAND() LIMIT 4");
$db->orderBy('rand()');
$db->where('pvid',2);
$query=$db->get('recursos',4,"idrecurso, image, idtipusrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid, external_url");
//while($place = mysql_fetch_array($query)){
foreach($query as $place){       
?>			
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
<?php } ?>						  						  			  
			</div>
			
			<a class="btn--more push--top" href="<?php echo $lng."/".URL_RECURSOS_TURISTICOS;?>"><?php echo DESCUBRE_MAS; ?></a>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php //include("includes/newsletter.php"); ?>

<?php } //if landing ?>



<?php 
include("includes/footer.php"); 
ob_end_flush();
?>