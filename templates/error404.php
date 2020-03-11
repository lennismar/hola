<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad error-page">
		
			<h1 class="h1-header">No hemos encontrado lo que buscas</h1>
			
			<p>Puede que la casa ya no esté disponible, la dirección del navegador sea incorrecta...</p>
			
			<hr class="hr-line-1">
		
			Puedes realizar una búsqueda de tu casa
			
			<form class="search-error" method="post" action="">
		            	
				<input id="search-box" class="icon-input-search--right" type="text" placeholder="Busca casa, nº de referencia...">
					    
			</form>
			
			<a href="index.php">Ir a inicio</a>
			
		</div>

	</section>
	
	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<div class="push--bottom text--center">O echar un vistazo a las casas que tenemos</div>
		
			<?php include("includes/quiklinks.php"); ?>
				
		</div>
	
	</section>

	<?php include("includes/footer.php"); ?>