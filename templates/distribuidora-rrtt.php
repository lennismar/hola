<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper">
	
		<div class="hero" id="hero-distribuidora">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1>Lo mejor de Cataluña</h1>
					
					<p class="hero-subtitle">Qué hacer, qué ver, que sentir</p>
					
				</div>
			
			</div>
		
		</div>
		
	</div>
	
	<script>
		
		$(document).ready(function() {
			$("#hero-distribuidora").backgroundCycle({
				imageUrls: [
					'assets/img/bg-distribuidora-1.jpg',
					'assets/img/bg-distribuidora-2.jpg',
					'assets/img/bg-distribuidora-3.jpg'
					],
				fadeSpeed: 500,
				duration: 5000,
				backgroundSize: SCALING_MODE_COVER,
			});
		});


	</script>

<!-- Listado lugares  para descubrir -->
	
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<div class="clearfix push--bottom">
			
				<select id="select-distribuidora" style="width:300px;">
					<option value="c-0" >Todas las comarcas</option>
					<option value="c-32" >Alt Camp</option>
					<option value="c-12" >Alt Empordà</option>
					<option value="c-1" >Alt Penedès</option>
					<option value="c-20" >Alt Urgell</option>
					<option value="c-21" >Alta Ribagorça</option>
					<option value="c-2" >Anoia</option><option value="c-3" >Bages</option><option value="c-33" >Baix Camp</option><option value="c-34" >Baix Ebre</option><option value="c-13" >Baix Empordà</option><option value="c-4" >Baix Llobregat</option><option value="c-35" >Baix Penedès</option><option value="c-5" >Barcelonès</option><option value="c-6" >Berguedà</option><option value="c-14" >Cerdanya</option><option value="c-36" >Conca de Barberà</option><option value="c-7" >Garraf</option><option value="c-22" >Garrigues</option><option value="c-15" >Garrotxa</option><option value="c-16" >Gironès</option><option value="c-8" >Maresme</option><option value="c-37" >Montsià</option><option value="c-23" >Noguera</option><option value="c-9" >Osona</option><option value="c-24" >Pallars Jussà</option><option value="c-25" >Pallars Sobirà</option><option value="c-26" >Pla d'Urgell</option><option value="c-17" >Pla de l'Estany</option><option value="c-38" >Priorat</option><option value="c-39" >Ribera d'Ebre</option><option value="c-18" >Ripollès</option><option value="c-27" >Segarra</option><option value="c-28" >Segrià</option><option value="c-19" >Selva</option><option value="c-29" >Solsonès</option><option value="c-40" >Tarragonès</option><option value="c-41" >Terra Alta</option><option value="c-30" >Urgell</option><option value="c-31" >Val d'Aran</option><option value="c-10" >Vallès Occidental</option><option value="c-11" >Vallès Oriental</option> 
						               
				</select>

			</div>
		
			<div class="row-flex row-flex-gutter-sm">

			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
			    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>

			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>

			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>

			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>
	    
			    <div class="col-sm-3"><?php include("includes/card-places.php"); ?></div>

			</div>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>