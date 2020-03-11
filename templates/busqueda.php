<?php include("includes/head.php"); ?>

<body>

<?php include("includes/mobile-bar-filters.php"); ?>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper wrapper--darkcream result-search-bar">
	
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
		
			<aside class="col-pad col-pad--fourth only-desktop" id="filters-mobile">
				
				<?php include("includes/filters.php"); ?>
			
			</aside>
			
			<main class="col-pad col-pad--three-fourth">
			
				<div class="search-info clearfix">
				
					<div class="search-results-number">
						Hay <strong class="text-color--orange">36</strong> <h1><strong class="text-color--orange">casas rurales</strong> esperándote en <span class="text-color--orange">La Garrotxa</span><h1>
					</div>
					
					<div class="search-order">
						
						<span class="text">Ordenar por:</span>
						
				    	<input type="radio" value="" name="order" id="orderprice">
				    	<label for="orderprice">Precio</label>
				    	
				    	<input type="radio" value="" name="order" id="orderratio"> 
				    	<label for="orderratio">Valoración</label>
				    	
				    	<input type="radio" value="" name="order" id="orderpopular">
				    	<label for="orderpopular">Populares</label>
				    	
				    	<input type="radio" value="" name="order" id="ordercomments">
				    	<label for="ordercomments">Comentarios</label>
				    	
					</div>
					
					<div class="search-results-map"><a href="busqueda-mapa.php" class="icon icon--map">Mapa</a></div>
				
				</div>
			
				<div class="search-results">
			
					<?php include("includes/card-h.php"); ?>
			
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
					
					<?php include("includes/card-h.php"); ?>
				
				</div>
				
				
				<?php include("includes/pagination.php"); ?>
							
			</main>
			
		</div>

	</div>
</div>

<?php include("includes/footer.php"); ?>