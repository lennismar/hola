<?php include("includes/head.php"); ?>

<body>
	
<?php include("includes/nav-responsive.php"); ?>

<div class="container-main" id="container">
			
	<div class="wrapper">
	
		<div class="hero" id="hero-home">
		
			<?php include("includes/header-transparent.php"); ?>
		
			<div class="hero-container">
				
				<div class="hero-inner">
				
					<h1 class="margin-h1-home">Encuentra tu casa rural en Cataluña</h1>
					
					<p class="only-tablet-to-desktop">Nº 1 en casas rurales en Cataluña. Seguro que aquí encuentras lo que buscas</p>
				
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
					'assets/img/bg-home-1.jpg',
					'assets/img/bg-home-2.jpg',
					'assets/img/bg-home-3.jpg'
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
		});
	</script>
	
	<!-- Quicklinks -->
		
	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<?php include("includes/quiklinks.php"); ?>
				
		</div>
	
	</section>


	<!-- Propuestas de valor -->

	<section class="wrapper ">

		<div class="page-container-fixed-pad">
			
			<h2 class="h2-header push--bottom">Reserva tu casa rural fácil y rápidamente</h2>

			<div class="row">

			    <div class="list-col-three">
				    
				    <div class="value-proposal">
					    <div class="value-proposal-img value-proposal-img-1"></div>
				        <strong>Respuesta en menos de 24 horas</strong>
				        <p>Además, las casas marcadas como <span class="highlited">Reserva Inmediata</span> pueden ser alquiladas en el mismo momento.<br>Sin esperas.</p>
				    </div>
			    </div>
			
				<div class="list-col-three">
					<div class="value-proposal">
						<div class="value-proposal-img value-proposal-img-2"></div>
			        	<strong>Pago con tarjeta</strong>
						<p>Reserva fácilmente tu casa rural pagando con tarjeta de crédito, en sólo 3 pasos. También puedes pagar con PayPal o por transferencia bancaria.</p>
					</div>
			    </div>
			    			
				<div class="list-col-three">
					<div class="value-proposal">
						<div class="value-proposal-img value-proposal-img-3"></div>
			        	<strong>Consulta los precios directamente</strong>
						<p>Precios directamente calculados en la web. Sin sorpresas de última hora.</p>
					</div>
			    </div>
			
			</div>
				
		</div>
	
	</section>

	<!-- Casas que te van a gustar (Segmentacion) -->
	
	<section class="wrapper wrapper--darkcream">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header push--bottom">Planes que te van a gustar</h2>			
		
			<div class="row push--bottom">

			    <div class="col-pad col-pad--half">

				    <a href="landing.php">
					    
					    <div class="block-destiny">
		
							<div class="block-destiny-img">
								<img src="assets/img/foto-plan-01.jpg" alt="Casas con reserva inmediata" width="550" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57">
  <path fill="#D0021B" fill-rule="evenodd" d="M316.999613,222.103364 C316.746451,221.042838 305.615654,215.894092 305.271189,214.047531 C304.926723,212.200969 331.72447,188.42025 332.276445,189.010817 C332.828419,189.605543 319.091306,211.427409 319.294665,212.217605 C319.493874,213.0078 330.898583,218.347857 331.023089,220.269279 C331.147594,222.19486 304.598859,245.796745 304.017833,245.305993 C303.436807,244.811081 317.248624,223.15973 316.999613,222.103364 Z" transform="translate(-304 -189)"/>
</svg>

							    <h3>Casas con reserva inmediata</h3>
						    </div>							    
					    </div>
				    </a>
				    
			    </div>
			    
			    <div class="col-pad col-pad--half">
			         <a href="landing.php">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="assets/img/foto-plan-02.jpg" alt="Alt Empordà" width="550" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3>Alt Empordà</h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			</div>
			
			<div class="row">

			    <div class="col-pad col-pad--third">
			        <a href="landing.php">
					    
					    <div class="block-destiny">
		
							<div class="block-destiny-img">
								<img src="assets/img/foto-plan-03.jpg" alt="La Garrotxa" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3>La Garrotxa</h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>

			    <div class="col-pad col-pad--third">
			        <a href="landing.php">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="assets/img/foto-plan-04.jpg" alt="Pirineo Catalán" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3>Pirineo Catalán</h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			    
			    <div class="col-pad col-pad--third">
			         <a href="landing.php">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="assets/img/foto-plan-05.jpg" alt="Casas con piscina" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3>Casas con piscina</h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			    
			</div>
			
		</div>

	</section>

	<!-- Casas que nos gustan (select)-->
	
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Casas destacadas</h2>
						
			<!--  TABS -->
			
			<div class="tabs">
			
				<ul class="tab-links">
					<li class="active"><a href="#tab-1">Las + Vistas</a></li>
					<li><a href="#tab-2">Últimas</a></li>
					<li><a href="#tab-3">Más baratas</a></li>
				</ul>
				
				<div class="tab-content">
			  
					<div id="tab-1" class="tab active">
				    
					    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
					
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
						</div>
					    
					</div>
					
					<div id="tab-2" class="tab">
				    
					    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
					
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
						</div>
					    
					</div>
					
					<div id="tab-3" class="tab">
				    
					    <div id="owl-related" class="owl-carousel owl-theme clearfix owl-related">
					
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
							<div class="item"><?php include("includes/card-v.php"); ?></div>
					  
						</div>
					    
					</div>
			    
				</div>
			</div>
								
			<!-- /TABS -->

		</div>

	</section>

	<!-- Lugares para descubrir (slect)-->

	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Lugares para descubrir</h2>
			
			<p class="text-sub-header">Haz de tu estancia el momento de descubrir los mejores rincones de Cataluña</p>
				
			<div id="owl-places" class="owl-carousel owl-theme clearfix owl-places">
			
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			</div>
			
			<a class="btn--more push--top" href="distribuidora-rrtt.php">Descubre más</a>

		</div>

	</section>

	<!-- Newsletter-->

	<?php include("includes/newsletter.php"); ?>
	
	<!-- SEO text-->
	
	<section class="wrapper wrapper--darkcream">
	
		<div class="page-container-fixed-pad">
		
			<h3 class="h4-header text-orange">En Somrurals, trabajamos a diario para ayudarte con el alquiler de casas rurales Cataluña.
</h3>			
			<p class="text-center">Ya tenemos opción de <strong class="text-orange">Reserva Inmediata</strong>.</p>
			<div class="row push--bottom">

			    <div class="col-pad col-pad--half">
				    <p>Tratamos de <strong>agilizar al máximo</strong> la gestión de las <strong>reservas del turismo rural en Cataluña</strong>, un sector tradicionalmente caracterizado por la gestión lenta y poco organizada de las reservas.</p>
				    <p>Consulta casa rural Catalunya con su respectivo precio, filtrando por los criterios que consideres interesantes para la búsqueda. También podrás consultar la disponibilidad de la casas, no es siempre al 100%, la singularidad del sector y gestión de algunos propietarios no lo permite, pero nos acercamos bastante.</p>
			    </div>
			    
			    <div class="col-pad col-pad--half">
				    <p>Nos comprometemos a ofrecer una <strong>respuesta en un periodo inferior a 24h</strong>. Recibirás un mail para formalizar la reserva, con <strong>opción de pago por tarjeta o transferencia bancaria</strong>. De no encontrarse disponible la casa rural, trabajamos para ofrecerte la alternativa parecida a la consultada. No dejamos un mail sin respuesta.</p>
				    <p>Nos queremos diferenciar de grandes portales de reservas, especialmente grandes webs internacionales, aquí entrarás un trato personalizado y ágil.</p>
			    </div>
			    
			</div>
			
			<h5 class="text-center">¿Necesitas más motivos? Encuentra tu casa rural Cataluña.</h5>
			
		</div>
		
		
	</section>

	<!-- SEO -->

	<section class="wrapper wrapper--white only-desktop">

		<div class="page-container-fixed-pad seo-block">

			<p><a href="#" class="seo-block-title">BARCELONA</a> <a href="#">Anoia</a>, <a href="#">Bages</a>, <a href="#">Baix</a>, <a href="#">Llobregat</a>, <a href="#">Barcelonès</a>, <a href="#">Berguedà</a>, <a href="#">Garraf</a>, <a href="#">Maresme</a>, <a href="#">Osona</a>, <a href="#">Vallès Occidental</a>, <a href="#">Vallès Oriental</a></p>
			
			<p><a href="#" class="seo-block-title">GIRONA</a> <a href="#">Alt Empordà</a>, <a href="#">Baix Empordà</a>, <a href="#">Garrotxa</a>, <a href="#">Gironès</a>, <a href="#">Pla de l'Estany</a>, <a href="#">Selva</a>, <a href="#">Selva</a>, <a href="#">Ripollès</a></p>
			
			<p><a href="#" class="seo-block-title">LLEIDA</a> <a href="#">Alta Ribagorça</a>, <a href="#">Alt Urgell</a>, <a href="#">Cerdanya</a>, <a href="#">Garrigues</a>, <a href="#">Noguera</a>, <a href="#">Pallars Jussà</a>, <a href="#">Pallars Sobirà</a>, <a href="#">Pla d'Urgell</a>, <a href="#">Segarra</a>, <a href="#">Segrià</a>, <a href="#">Solsonès</a>, <a href="#">Urgell</a>, <a href="#">Vall d'Aran</a></p>
			
			<p><a href="#" class="seo-block-title">TARRAGONA</a> <a href="#">Alt Camp</a>, <a href="#">Baix Camp</a>, <a href="#">Baix Ebre</a>, <a href="#">Baix Penedès</a>, <a href="#">Conca de Barberà</a>, <a href="#">Ribera d'Ebre</a>, <a href="#">Montsià</a>, <a href="#">Priorat</a>, <a href="#">Tarragonès</a>, <a href="#">Terra Alta</a></p>		
		
		</div>
		
	</section>
	
	
<!-- Tabs Home  -->
<script>
var Tabs={init:function(){this.bindUIfunctions();this.pageLoadCorrectTab();},bindUIfunctions:function(){$(document).on("click",".transformer-tabs a[href^='#']:not('.active')",function(event){Tabs.changeTab(this.hash);event.preventDefault();}).on("click",".transformer-tabs a.active",function(event){Tabs.toggleMobileMenu(event,this);event.preventDefault();});},changeTab:function(hash){var anchor=$("[href="+hash+"]");var div=$(hash);anchor.addClass("active").parent().siblings().find("a").removeClass("active");div.addClass("active").siblings().removeClass("active");anchor.closest("ul").removeClass("open");},pageLoadCorrectTab:function(){this.changeTab(document.location.hash);},toggleMobileMenu:function(event,el){$(el).closest("ul").toggleClass("open");}}
Tabs.init();
</script>
	
<?php include("includes/footer.php"); ?>