<?php 
include 'includes/config.php';

$meta_title="Som Rurals. ". HEADER_TITLE;
$meta_description=SEO_HOME_DESCRIPCION;
$meta_keywords=SEO_HOME_KEYWORDS;
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

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad error-page">
		
			<h1 class="h1-header">No hemos encontrado lo que buscas</h1>
			
			<p>Puede que la casa ya no esté disponible, la dirección del navegador sea incorrecta...</p>
			
			<hr class="hr-line-1">
		
			Puedes realizar una búsqueda de tu casa
			
			<form class="search-error" method="post" action="search.php">
		            	
				<input id="search-box" class="icon-input-search--right" type="text" name="buscador" placeholder="<?php echo NOMBRE_REFERENCIA; ?>">
					    
			</form>
			
			<a href="<?php echo $lng."/";?>">Ir a inicio</a>
			
		</div>

	</section>
	
	<section class="wrapper wrapper--white">
	
		<div class="page-container-fixed-pad">
		
			<div class="push--bottom text--center">O echar un vistazo a las casas que tenemos</div>
		
			<?php include("includes/quiklinks.php"); ?>
				
		</div>
	
	</section>

	<?php include("includes/footer.php"); ?>