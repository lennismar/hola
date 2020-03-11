<?php include("includes/head.php"); ?>

<body>

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
			
					<h1>El Pedraforca</h1>
					
					<p class="hero-subtitle">El Massis del Pedraforca, es un paraje natural de interés nacional. Su singularidad le convierte en una de las cimas más reconocidas del territorio.</p>
					
				</div>
			
			</div>
		
		</div>
		
	</div>
	
	<script>
		
		$(document).ready(function() {
			$("#hero-ficha-recurso").backgroundCycle({
				imageUrls: [
					'assets/img/bg-ficha-recurso-1.jpg',
					'assets/img/bg-ficha-recurso-2.jpg',
					'assets/img/bg-ficha-recurso-3.jpg'
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
			
				<a href="#descripcion" class="btn-smooth-scroll">Descripción</a>
				<a href="#quever" class="btn-smooth-scroll">Qué ver</a>
				<a href="#donde" class="btn-smooth-scroll">Dónde</a>
				<a href="#informacion" class="btn-smooth-scroll">Información</a>
				<a href="#casas" class="btn-smooth-scroll">Casas que nos gustan</a>
			
			</div>
			
			<a href="busqueda.php" class="big-button-related">
			
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
			
				<div class="big-button-related--number">30</div>
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
			    
			    
			    <div class="push-half--top clearfix">
			    
			    	<span class="icon icon--place-green">Berguedá, Girona</span>
			    	
			    	<span class="icon icon--date-green">Todo el año</span>
			    
					<div class="ficha-share"><?php include("includes/share-buttons.php"); ?></div>
			    
			    </div>
			    
			    <article class="dd" style="background:#fff;">
			    
					<div class="content-block" id="descripcion">
					
						<h2>DESCRIPCIÓN</h2>
						
						<p>En el parque encontramos rastros bien conservados de dos periodos históricos principales.</p>
						
						<ul class="block-list-circle-orange">
							<li>Románico: son numerosas las iglesias del periodo que podemos encontrar por todo el territorio, tanto en pequeñas poblaciones como en lugares aislados.</li>
							<li>Medieval: el pasado medieval del parque tiene que ver con las presencia de los condes de Cerdenya, que utilizaban los castillos de Saldes y Gósol (las dos localidades más próximas) para defender su territorio. Alrededor de los dos castillos nacieron las localidades que encontramos hoy.</li>
						</ul>
					
					</div>
					
					<div class="content-block" id="quever">
					
						<h2>Qué ver</h2>
						
						<p><strong>Geología</strong></p>
						
						<p>La geología del parque del Massis del Pedraforca, se divide entre el manto superior y el manto inferior. La estructura geología del Massis del Pedraforca, es el punto que probablemente suscita un mayor interés en el parque, debido principalmente a su peculiar estructura geológica, forjada durante millones de años. De manera que a la hora de diferenciar los dos puntos principales del parque hablaremos del manto superior y del manto inferior (termino que se refiere a capa de la tierra ubicada a 33km de profundidad). Fruto de las colisiones de las placas tectónicas hace entre 75 y 69 millones de años, acabo por emerger del interior de la Tierra el territorio que configura actualmente el Massis de Pedraforca.</p>
						<p>Manto superior: son los elementos geológicos concentrados en este punto los que confieren el aspecto rocoso que se puede contemplar actualmente en el punto más alto del parque. Los elementos rocosos del parque se remontan 230 millones de años atrás.</p>
						<p>Manto inferior: es de los dos el que tiene un origen más antiguo. Formado por un tipo de roca sedentaria de color blanquecino compuesta por arcillas y calcita. Su color hace que resalte especialmente sobre el relieve.</p>
						<p><strong>Habitats</strong></p>
						<p>En lo que se refiere a árboles, los ejemplares más habituales que podemos encontrar son el pino rojo, pino negro, la haya común, el abeto y el roble pubescente. La mayor concentración de estos elementos la podemos encontrar en la denominada Baga de Gresolet, se trata del bosque del parque de mayor tamaño e importancia.Las principales especies de arbustos que podemos encontrar son: el boj común, enebro rastrero y la gayuba. Distribuidos de forma desigual por todo el parque.Destaca la singularidad de las especies vegetales que se han adaptado a los terrenos más difíciles y rocosos, especialmente en los puntos más elevados del parque.</p>
						<p><strong>Vegetación</strong></p>
						<p>La vegetación del Massís del Pedraforca, está condicionada principalmente por la altitud del parque en la que nos encontremos. El principal punto que marca esta diferencia lo encontramos entre los 1.500 y 1.700 metros de altura.</p>
						<p>Debajo de los 1.500 y 1.700 metros encontramos, un clima de montaña lluvioso. El grupo de vegetación de este punto recibe el nombre de Piso montano, aquí encontraremos principalmente el roble pubescente, entre otras especies como el avellano o el espino. En las zona más sombrías destaca la haya. Por encima de los 1.500 y 1.700 metros de altitud encontramos un clima de montaña subalpina. Con dos pisos de vegetación principales:</p>
						<p>Piso subalpino: (entre 1.700 y 2.300 metros) conforman la parte del parque más verdosa, formada por bosques de coníferas, dónde abundan árboles altos y longevos como abetos o pinos negros.</p>
						<p>Piso alpino: (a partir de los 2.300 metros) predominan los elementos rocosos del parque, y no hay presencia de arbóles. Tan sólo podemos encontrar la presencia de algunas formaciones vegetales que se han adaptado al medio como la oreja del oso o la corona del rey.</p>
						<p><strong>Animales</strong></p>
						<p>En el parque del Massis del Pedraforca encontramos una amplia variedad de especies animales como mamíferos, aves, anfibios y algunos invertebrados. Todas son especies adaptadas a un medio montañoso.
Entre los mamíferos del parque destaca el rebeco pirenaico, animal especialmente sociable y con un color de piel que cambia ligeramente en función de la estación del año en que nos encontremos, siendo en verano la piel rojiza y en invierno mucho más oscura.</p>
						<p>Las aves se pueden encontrar principalmente en los bosques caducifolios, destacan el urogallo (hábitats solitarios) y el pito negro.</p>
						<p>Entre los reptiles y anfibios del parque, encontramos entre otros la rana y el sapo común además de la salamandra. Forman parte de este grupo algunas de las especies más peligrosas del parque como las culebras o la víbora europea.</p>
					
					</div>
					
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
					
					<div class="content-block" id="informacion">
					
						<h2>Información práctica</h2>
						
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
						
					</div>	
					
					<div class="content-block" id="donde">
					
						<h2>Dónde</h2>
						
						<a href="#" class="icon icon--map push-half--bottom">Cómo llegar</a>
						<!-- GOOGLE MAPS
						<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script> -->
						<script>
						// This example displays a marker at the center of Australia.
						// When the user clicks the marker, an info window opens.
						
							function initialize() {
							  var myLatlng = new google.maps.LatLng(42.121965,2.741803);
							  var mapOptions = {
							    zoom: 10,
							    center: myLatlng,
							    scrollwheel: false,
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
							      content: contentString
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
			
				<span class="sidebar-header">Más por la zona</span>
			
				<?php include("includes/card-places.php"); ?>
			
				<?php include("includes/card-places.php"); ?>
			
				<?php include("includes/card-places.php"); ?>
			
			</aside>
			
		</div>
	
	</section>
	
	<!-- Casas relacionadas -->
	
	<section class="wrapper wrapper--darkcream" id="casas">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Casas rurales que nos gustan cerca de Pedraforca</h2>
			    
			<div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
				
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
				<div class="item"><?php include("includes/card-v.php"); ?></div>
				  
			</div>
			
			<a class="btn--more push--top" href="busqueda.php">Ver todas</a>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>