<?php include("includes/head.php"); ?>

<body>

<?php include("includes/mobile-bar-filters.php"); ?>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper wrapper--darkcream result-search-bar">
	
		<div class="page-container-fixed-small">
	
		<!-- Busqueda -->
		
			<div class="btn-show-search btn-expand-extra-content">Buscar</div>
				
			<div class="main-search-form main-search-form--inside extra-content only-desktop">
				
				<?php include("includes/main-search.php"); ?>
									
			</div>
			
		<!-- Fin búsqueda -->

		</div>
	</div>
		
	<div class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<aside class="col-pad col-pad--fourth only-desktop" id="filters-mobile">
				
				<?php include("includes/filters.php"); ?>
			
			</aside>
			
			<article class="col-pad col-pad--three-fourth">
			
				<div class="search-info clearfix">
				
					<div class="search-results-number">Hay <strong class="text-color--orange">36</strong> <h1><strong class="text-color--orange">casas rurales</strong> esperándote en <span class="text-color--orange">La Garrotxa</span><h1></div>
					
					<div class="search-results-map"><a href="busqueda.php" class="icon icon--list">Lista</a></div>
					
					<!--<div class="search-results-map"><a href="includes/search-map.php" data-type="ajax" class="venobox-search-map icon icon--list">Lista</a></div>-->
				
				</div>
				
				<!-- GOOGLE MAPS
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> -->
				
				<script>
					function initialize() {
						var myLatlng = new google.maps.LatLng(42.121965,2.741803);
						var mapOptions = {
						zoom: 10,
						center: myLatlng,
						scrollwheel: false,
						};
										
						var map = new google.maps.Map(document.getElementById('map-search-canvas'), mapOptions);
						var contentString = '<div id="content-map-pin">'+
											'<div id="siteNotice">'+
											'</div>'+
											'<div class="card-header">'+
											'<div class="house-class">Casa rural independiente</div>'+
											'<div class="house-TypeDot"></div>'+
											'<div class="card-title">Apartamentos rurales con barbacoa en Garrotxa</div>'+
											'</div>'+
											'<div class="card-img">'+
											'<div class="card-price">Desde<span class="card-price-hightlight">40,5€ </span>Persona / Noche</div>'+
											'<img src="assets/img/foto-casa.jpg" alt="foto-casa" width="739" height="397" />'+
											'</div>'+
											'<div class="card-items-core">'+
											'<span class="card-person">Personas <strong>1 - 8</strong></span>'+
											'<span class="card-rooms">Habitaciones <strong>4</strong></span>'+
											'<span class="card-baths">Baños <strong>3</strong></span>'+
											'</div>'+
											'<a href="#" class="card-btn link-external">Ver Casa </a>'+
											'</div>';
										
						var infowindow = new google.maps.InfoWindow({
							content: contentString,
							maxWidth: 300
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
				
				<div class="map-search-canvas" id="map-search-canvas"></div>
							
			</article>
			
		</div>

	</div>
</div>

<?php include("includes/footer.php"); ?>