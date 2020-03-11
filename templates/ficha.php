<?php include("includes/head.php"); ?>

<body>

<?php include("includes/mobile-bar-book.php"); ?>

<div class="container container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<section class="wrapper">
	
		<div class="page-container-fixed push-half--ends">
		
			<a class="btn--back" href="busqueda.php">Volver a los resultados</a>
			
			<?php include("includes/breadcrumb.php"); ?>
		
		</div>
		
	</section>

	<section class="wrapper">
		
		<article class="page-container-fixed house-layout push--bottom" itemscope itemtype="http://schema.org/Product" itemref="_offerPrice">
				
			<div class="house-main">
				
				<div id="ficha" class="house-section">
					
					<header class="house-section-header">
					
						<div class="house-class">
							Casa rural independiente
						</div>
												
						<div class="house-title">
							<h1 itemprop="name">
								Masía rural para grupos, ideal para relajarse y desconectar. Piscina, granja, parque infantil y barbacoa.
							</h1>
						</div>
							
						<div class="dhouse-reviews">
							
							<!-- Include rating stars -->
							
							<?php include("includes/rating.php"); ?>
															
							<div class="comments-number">
								<span id="_countReview"><strong>4</strong></span> Comentarios
							</div>
								
						</div>
						
					</header>
						
					<!-- Menu navegación ficha -->
					<div class="house-nav" id="top-menu">
						
						<div class="">
							<a href="#description">Descripción</a>
						</div>
						
						<div>
							<a href="#services">Servicios</a>
						</div>
						
						<div>
							<a href="#comments">Comentarios</a>
						</div>
						
						<div>
							<a href="#location">Ubicación</a>
						</div>
						
						<div>
							<a href="#availability">Disponibilidad</a>
						</div>
						
						<div>
							<a href="#surroundings">Alrededores</a>
						</div>
						
					</div>
						
					<!-- Carrusel de fotos -->
						
					<div class="fotorama" data-width="100%" data-nav="thumbs" data-loop="true" data-allowfullscreen="yes">
					
						<img itemprop="image" src="assets/img/foto-casa.jpg">
							
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
					
					
					<!-- Stats casa -->
											
					<div class="content-block--small-pad">
							
						<div class="house-stats">
							
							<dl class="stat">
								<dt class="stat--title">Personas</dt>
								<dd class="stat--value">10</dd>
							</dl>
							
							<dl class="stat">
								<dt class="stat--title">Habitaciones</dt>
								<dd class="stat--value">5</dd>
							</dl>
							
							<dl class="stat">
								<dt class="stat--title">Baños</dt>
								<dd class="stat--value">3</dd>
							</dl>
							
							<dl class="stat">
								<dt class="stat--title">Referencia</dt>
								<dd class="stat--value">SR-323</dd>
							</dl>
						</div>

					</div>

					<div class="content-block--small-pad">

						<div class="house-stats">

							<dl class="stat">
								<dd class="stat--value">
									<div class="icon-big icon-big--fireplace"></div>
								</dd>
								<dt class="stat--title">Chimenea</dt>
							</dl>
							
							<dl class="stat">
								<dd class="stat--value">
									<div class="icon-big icon-big--barbacue"></div>
								</dd>
								<dt class="stat--title">Barbacoa</dt>
							</dl>
							
							<dl class="stat">
								<dd class="stat--value">
									<div class="icon-big icon-big--pool"></div>
								</dd>
								<dt class="stat--title">Piscina</dt>
							</dl>
							
							<dl class="stat">
								<dd class="stat--value">
									<div class="icon-big icon-big--wifi"></div>
								</dd>
								<dt class="stat--title">WiFi Gratis</dt>
							</dl>
						</div>
						
					</div>
					
					<!-- Descripción -->
						
					<div class="content-block" id="description">
						
						<h2>Descripción</h2>
							
						<p>Masia que está ubicada en el tranquilo paisaje del municipio de Tàrrega, en la comarca de Urgell dentro de la provincia de Lleida. Completamente rehabilitada y autosuficiente, se abastece en un 90% de energías renovables. Se alquila la casa completa.</p>
							
						<p>El interior consta de una superficie total de 530 m2, con una gran sala de estar con equipo de música y TV, un comedor totalmente equipado con mesa para 15 personas y una cocina con todo el equipamiento necesario para su labor. Además de sala de juegos con billar y futbolín y un patio interior con piscina climatizada.</p>
							
						<p>Tiene un total de 6 habitaciones decoradas con estilo, 3 triples y 3 dobles. Cada habitación dispone de baño particular, calefacción, TV, ventilador de techo y unas excepcionales vistas al paisaje.El exterior de la masía está rodeada de campo, en total 10 hectáreas de olivos, viñedos y cereal. Es un lugar estupendo donde poder perderse en el silencio del ámbito rural. Dispone de un horno de leña para elaborar pan y una barbacoa. </p>
						
						<p>La masía ofrece diferentes actividades tales como rutas a pie y bici por los senderos de la zona, turismo ornitológico en el que los amantes de las aves puedan disfrutar de la biodiversidad o rutas turismo vegetal. Para más información preguntar en la casa.</p>
						
						<!-- Video -->
						
						<div class="video_container">
							<div class="video_wrapper">
								<iframe src="//www.youtube.com/embed/SoEdz5yR6nE" width="640" height="480" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
							</div>
						</div>
						
						<div class="push-top-sm">
							Para <span class="tag">grupos</span> <span class="tag">Montaña</span> <span class="tag">Familiar</span>
						</div>
						
					</div>
					
					<!-- Servicios -->
						
					<div class="content-block" id="services">
						
						<h2>Servicios de la casa</h2>
							
						<ul class="service-list three-col">
							<li><span class="icon icon--yes">Aire acondicionado</span></li>
							<li><span class="icon icon--yes">Baño en la habitación</span></li>
							<li><span class="icon icon--yes">Barbacoa</span></li>
							<li><span class="icon icon--yes">Calefacción</span></li>
							<li><span class="icon icon--yes">Chimenea</span></li>
							<li><span class="icon icon--yes">Cocina</span></li>
							<li><span class="icon icon--yes">Comedor</span></li>
							<li><span class="icon icon--no">Jacuzzi</span></li>
							<li><span class="icon icon--yes">Jardín</span></li>
							<li><span class="icon icon--yes">Lavadora</span></li>
							<li><span class="icon icon--no">Lavavajillas</span></li>
							<li><span class="icon icon--yes">Permite animales</span></li>
							<li><span class="icon icon--yes">Piscina</span></li>
							<li><span class="icon icon--no">Piscina climatizada</span></li>
							<li><span class="icon icon--no">Sala de convenciones</span></li>
							<li><span class="icon icon--yes">Sala de estar</span></li>
							<li><span class="icon icon--no">Spa</span></li>
							<li><span class="icon icon--yes">Televisión</span></li>
							<li><span class="icon icon--no">Televisión en la habitación</span></li>
							<li><span class="icon icon--yes">Terraza</span></li>
							<li><span class="icon icon--yes">WiFi Gratis</span></li>
						</ul>
						
						<h3 class="push-top-sm">Servicios exteriores compartidos</h3>
							
						<p>Los servicios exteriores se comparten con las <strong>5 casas</strong> pertenecientes al complejo.</p>
							
						<ul class="service-list three-col">
								
							<li><span class="icon icon--yes">Jardín</span></li>
							<li><span class="icon icon--yes">Piscina</span></li>
							<li><span class="icon icon--no">Piscina climatizada</span></li>
							<li><span class="icon icon--no">Sala de convenciones</span></li>
							<li><span class="icon icon--no">Spa</span></li>
							<li><span class="icon icon--yes">WiFi Gratis</span></li>
						</ul>
												
					</div>
						
					<!-- Propietario -->
					
					<div class="content-block" id="owner">
						
						<h2>El Propietario</h2>
							
						<p>Somos personas enamoradas del paisaje, de la naturaleza y del patrimonio rural de la Segarra y del Urgell. Queremos compartir este tesoro desconocido, con las personas que deseen conocerlo y amarlo.</p>
						
					</div>
					
					<!-- Condiciones -->
						
					<div class="content-block" id="conditions">
						
						<h2>Condiciones de la casa</h2>
							
						<p><strong>Horario de entrada:</strong> A partir de las 12:00 horas</p>
							
						<p><strong>Horario de salida:</strong> Flexible (sujeto a disponibilidad del día).</p>
							
						<p><strong>Fianza</strong> Si. 100€. La Fianza se devolverá íntegra salvo si hubiere desperfectos o por mal uso las instalaciones. </p>
							
						<div class="house-conditions clearfix">
							
							<div class="col-pad col-pad--third"><div class="icon-conditios--towels"></div>Juegos de cama y toallas incluidas</div>
								
							<div class="col-pad col-pad--third"><div class="icon-conditios--kitchen"></div>Utensilios de cocina incluidos</div>
								
							<div class="col-pad col-pad--third"><div class="icon-conditios--firewood"></div>Equipada con leña</div>
							
						</div>
						
						<div  class="push-top-sm">
							Registro Turismo: PG-00377
						</div>
						
					</div>
					
					<!-- Comentarios -->
						
					<div class="content-block" id="comments"> 
						
						<h2>Comentarios</h2>
						
						<div class="rating-box">
							
							<h3>10 Valoraciones </h3>
							
							<div class="rating-house" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" itemref="_countReview">
								
								<!-- Include rating stars -->
								<?php include("includes/rating.php"); ?>
								
								<div class="rating-punctuation-title">
									<span class="punctuation" itemprop="ratingValue"><h4>4.4</h4> </span> / 5
								</div>
								
							</div>
							
							<ol class="two-col list-punctuation clearfix">
							
								<li>Limpieza
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Trato personal
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Servicios de la casa
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Relación calidad/precio
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								
								<li>Calidad del sueño
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Entorno
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Relajación
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
								<li>Sensación de paz y tranquilidad
									<!-- Include rating stars -->
									<?php include("includes/rating.php"); ?>
								</li>
							
							</ol>
						</div>
							
						<div class="reviews">
							
							<?php include("includes/review.php"); ?>
								
							<?php include("includes/review.php"); ?>
								
							<?php include("includes/review.php"); ?>
								
							<?php include("includes/review.php"); ?>
							
							<div class="push-top-sm text-center">				
								<a href="#" class="btn-ghost btn-g"><strong>Cargar más comentarios</strong></a>
							</div>
							
						</div>
							
					</div>
					
					<!-- Ubicacion -->
					
					<div class="content-block" id="location">
							
						<h2>Ubicacion</h2>
							
						<p class="house-location">
							<span class="icon icon--place">
								<span class="location" style="display: none;">(Buda).</span> Baix Ampurdá, Girona.
								<span class="btn-more text-sm text-orange">Más</span>
							</span>
						</p>
							
						<!-- GOOGLE MAPS
						<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> -->
							
						<div class="map-canvas" id="map-canvas"></div>
						
						
						<!-- Script google maps -->
						<script>
							
							function initialize() {
							var myLatlng = new google.maps.LatLng(41.072451,0.751338);
							var mapOptions = {
								zoom: 10,
								center: myLatlng,
								scrollwheel: false,
								styles:[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
							};
						
							var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

							var icono = {
								url: "assets/img/point-area.svg",
								anchor: new google.maps.Point(80,80),
								scaledSize: new google.maps.Size(160,160)
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
						
						google.maps.event.addDomListener(window, 'load', initialize);	
								
						</script>
											
					</div>
						
					<!-- Disponibilidad -->
					
					<div class="content-block" id="availability">
						
						<h2>Calendario de disponibilidad</h2>
							
						<script type="text/JavaScript">
								
								$('#disponibilidad-casa').DOPBookingCalendar({
						            'Type':'FrontEnd',
						            'Availability':1,
									'DayNames':['do', 'lu', 'ma', 'mi', 'ju', 'vi', 'sá'],
						            //'DataURL': 'js/BookingCalendar/php/load_establimentpreus.php?eid=12'
						        });	
								
						</script>
							
						<div id="disponibilidad-casa"></div>
							
					</div>
					
					<!-- qué ver -->
					
					<div class="content-block" id="surroundings">
						
						<h2>Qué ver</h2>
							
						<div class="owl-carousel clearfix owl-related-places">
				
							<div class="item"><?php include("includes/card-places.php"); ?></div>
							  
							<div class="item"><?php include("includes/card-places.php"); ?></div>
							  
							<div class="item"><?php include("includes/card-places.php"); ?></div>
							  						  
						</div>
							
					</div>				
					
					<!-- botones compartir -->
					
					<div class="content-block">
						
						<?php include("includes/share-buttons.php"); ?>
							
					</div>
						
				</div>
				
				<!-- btn-back -->
				<a class="btn--back push--top" href="busqueda.php">Volver a los resultados</a>
				
			</div>
			
			<!-- Form lateral -->
			<div class="house-sidebar" id="book-form">
				<?php include("includes/book-form.php"); ?>
			</div>
				
		</article>
		
		
		
	</section>
	
	<section class="wrapper wrapper--darkcream">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h3-header">También te pueden interesar</h2>
			    
			<div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
				
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
			</div>
			
		</div>
	
	</section>
	
	<script>
	
	/** fija la barra de submenu de la ficha */
		
	(function() {
	  $(function() {
	    $("body").on("click", ".example_controls button", (function(_this) {
	      return function(e) {
	        return $(e.currentTarget).closest(".example").find("iframe")[0].contentWindow.scroll_it();
	      };
	    })(this));
	    return $("#top-menu").stick_in_parent().on("sticky_kit:stick", (function(_this) {
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

<?php include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>