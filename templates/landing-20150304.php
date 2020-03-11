<?php include("includes/head.php"); ?>

<body>

<?php include("includes/mobile-bar-filters.php"); ?>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper">
	
		<div class="hero" id="hero-landing">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1>Casas rurales en Girona</h1>
					<p class="hero-subtitle">Descubre el paraíso natural de Cataluña</p>
					
					<div class="hero-inner-buttons">
					
						<a href="#encuentra" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--find-white">Encuentra tu casa rural</span></a>
						
						<a href="#favoritas" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--love-white">Nuestras casas favoritas</span></a>
						
						<a href="#quever" class="btn-ghost btn-ghost--white btn-smooth-scroll"><span class="icon icon--quever-white">Qué ver</span></a>
					
					</div>
					
				</div>
			
			</div>
		
		</div>
		
	</div>
	<script>
	
	</script>
		
	
	<script>
		
		// Ciclo de imágnes en backgroun en la cabecera
	
		$(document).ready(function() {
			$("#hero-landing").backgroundCycle({
				imageUrls: [
					'assets/img/bg-landing-1.jpg',
					'assets/img/bg-landing-2.jpg',
					'assets/img/bg-landing-3.jpg'
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
		});

	</script>
	
	<div class="wrapper wrapper--darkcream result-search-bar" id="encuentra">
	
		<div class="page-container-fixed-small">
	
		<!-- Busqueda -->
			
			<div class="btn-show-search btn-expand-extra-content">Buscar</div>
				
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
				
				<div class="search-results-number">Hay <strong class="text-color--orange">36</strong> <h1><strong class="text-color--orange">casas rurales</strong> esperándote en <span class="text-color--orange">La Garrotxa</span><h1></div>					
					<div class="search-results-map"><a href="#" class="icon icon--map" data-type="iframe">Mapa</a></div>
				
				</div>
			
				<div class="search-results">
			
					<?php include("includes/card-h.php"); ?>
			
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
				
				</div>
				
				<?php include("includes/pagination.php"); ?>
							
			</article>
			
		</div>

	</div>
	
<!-- Casas que te van a gustar (Segmentacicon) -->
	
	<div class="wrapper wrapper--darkcream" id="favoritas">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Casas que te van a gustar en Girona</h2>
			
			<p class="text-sub-header">Para que las disfrutes con con los que más quieres</p>			
		
			<div class="row">

			    <div class="col-pad col-pad--third">
			        <?php include("includes/card-others.php"); ?>	
			    </div>
			
				<div class="col-pad col-pad--third">
			        <?php include("includes/card-others.php"); ?>	
			    </div>
			    			
				<div class="col-pad col-pad--third">
			        <?php include("includes/card-others.php"); ?>	
			    </div>
			
			</div>
				
		</div>
	
	</div>

<!-- Lugares para descubrir (slect)-->
	
	<section class="wrapper wrapper--white" id="quever">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header">Qué ver en Girona</h2>
			
			<p class="text-sub-header">Haz de tu estancia el momento de descubrir los mejores rincones de Cataluña</p>
				
			<div id="owl-places" class="owl-carousel owl-theme clearfix owl-places">
			
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			  <div class="item"><?php include("includes/card-places.php"); ?></div>
			  
			</div>
			
			<a class="btn--more push--top" href="#">Descubre más</a>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>