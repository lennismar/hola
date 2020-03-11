<?php 
include 'includes/config.php';

$meta_title=COMO_RESERVAR." | Som Rurals";
$meta_description=COMO_RESERVAR_SEO_DESCRIPCION;
$meta_keywords=COMO_RESERVAR.", somrurals, som rurals";
$meta_index="";
$meta_follow="";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

include("includes/head.php"); 
?>

<body>

<?php include("includes/tag-manager.php"); ?>

<script>
	
	$(document).ready(function() {
		$("#fixed-menu").stick_in_parent({
			offset_top:20,
		});
	});

</script>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
	
	<div class="wrapper">
	
		<div class="hero--small hero-how-to-book ">
		
			<div class="hero-container">
		
				<div class="hero-inner--small">
			
					<h1 class="h1-header"><?php echo COMO_RESERVAR; ?></h1>
					
					<p class="hero-subtitle"><?php echo COMO_RESERVAR_SUBTITLE; ?></p>
				
				</div>
			
			</div>
		
		</div>
	
	</div>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<?php echo COMO_RESERVAR_ASIDE; ?>
			
			<?php echo COMO_RESERVAR_CONTENT; ?>	
            		
		</div>

	</section>

<?php include("includes/footer.php"); ?>