<?php 
include 'includes/config.php';

// --------------- FILTRO DEL LUGAR --------------------------
$where = explode("-", $_GET['w']); 
$filter_where = "";
$lloc = "";

// $where[0] -> p (provincia), c (comarca)
// $where[1] -> id de la comarca o provincia

if ($where[0]=='p') { //[0] -> p (provincia) o c (comarca) , [1] -> id de la comarca o provincia
	$filter_where = "AND pvid = " . $where[1]; // Filtro de la consulta
	$lloc_title = GetTitleProvincia ($where[1]); // Título de la provincia
	$description_where = Query('provincies', 'description_'.$lng, 'pvid', $where[1]); // Descripción de la provincia
} elseif($where[0]=='c') {
	$filter_where = "AND comid = " . $where[1]; // Filtro de la consulta 
	$lloc_title = GetTitleComarca ($where[1]); // Titulo de la comarca	
	$description_where = Query('comarques', 'description_'.$lng, 'comid', $where[1]); // Descripción de la comarca
}

// --------------- FILTRO DEL TIPO --------------------------
$filter_tipo="";
$count_tipo=1;
if (is_array($_POST['tipo'])) {
	foreach ($_POST['tipo'] as $tipo){
		if ($count_tipo==1) $filter_tipo .= " AND ("; else $filter_tipo .= " OR ";
		$filter_tipo .= " idtipusrecurso = ".$tipo;
		if (count($_POST['tipo']) == $count_tipo) $filter_tipo .= ")";
		$count_tipo++;
	}
}
// ---------------------- ORDEN -----------------------------
if ($_GET['order']=='data') {
	$order = "info_quan";	
} elseif ($_GET['order']=='tipo') {
	$order = 'idtipusrecurso';
} else {
	$order = "RAND()";
}


$filter = $filter_where . $filter_tipo; //Guardamos los diferentes filtros

$SQL="SELECT idrecurso FROM recursos WHERE published = 1 ".$filter." ORDER BY ".$order."";
//echo $SQL.'<br/>';
$query=$db->rawQuery($SQL);

//$num_recursos = mysql_num_rows($query); // número de recursos
$num_recursos=$db->count;

//while ($rs = mysql_fetch_array($query)) 
foreach($query as $rs){
	$recursos[] = $rs['idrecurso'];
}
/*echo '<pre>';
var_dump($recursos);
echo '</pre>';*/
$meta_title="Som Rurals. ".HEADER_TITLE.". ".RECURSOS_TURISTICOS;
$meta_description=html_entity_decode(strip_tags($description_where), ENT_QUOTES, 'utf-8');
$meta_keywords="somrurals, som rurals, catalunya, cataluña, catalonia, ".CASAS_RURALES.", ". $lloc_title;
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
	
	<div class="wrapper">
	
		<div class="hero" id="hero-distribuidora">
		
			<div class="hero-container hero-container--semiblack">
		
				<div class="hero-inner">
			
					<h1><?php echo LO_MEJOR_DE; ?> Cataluña</h1>
					
					<p class="hero-subtitle"><?php echo QUE_HACER; ?></p>
					
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
			$('iframe').prepend('<div class="video_container"><div class="video_wrapper">');
			$('iframe').append('</div></div>');
		});


	</script>

<!-- Listado lugares  para descubrir -->
	
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<div class="clearfix push--bottom">
            <!--
			<form name="filtrar" action="recursos.php?w=<?php echo $_GET['w'];?>" method="post">
				<select id="select-distribuidora" style="width:300px;" onChange="javascript:this.form.submit();">
					<option value="all"><?php echo TODA_CATALUNYA; ?></option>							 	
					<optgroup label="Provincias" style="font-style:normal">
						<?php echo PrintOptionProvincia($_SESSION['where']); ?>
					</optgroup>
									
					<optgroup label="Comarcas">
	                   <?php echo PrintOptionComarca($_SESSION['where']);   ?>
					</optgroup>
				</select>
			</form>
            -->
            <!--
			<form name="filtrar" action="recursos.php?w=<?php echo $_GET['w'];?>" method="post">
				<select id="select-distribuidora" name="tipo" id="tipo" style="width:300px;" onChange="javascript:this.form.submit();">
				<?php
				// Comentado dado que está comentado el código HTML que lo contiene
				//$SQL="SELECT idtipusrecurso, title_".$lng." FROM recursos_tipus ORDER BY title_".$lng." ASC";
				//$query=$db->rawQuery($SQL);

				//foreach($query as $rs){

				?>
    				<option value="<?php echo $rs['idtipusrecurso']; ?>" <?php if (is_array($_POST['tipo'])) {foreach ($_POST['tipo'] as $tipo) { if($tipo==$rs['idtipusrecurso']) echo "selected"; }} ?>><?php echo $rs['title_'.$lng];?>
    
				<?php
				//}
				?>
				</select>
			</form>
			-->
            
			</div>
		
			<div class="row">
<?php
if (!empty($recursos) && is_array($recursos)) {
	foreach ($recursos as $recurs) {
		//$query = mysql_query("SELECT idrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid, image FROM recursos WHERE idrecurso = ".$recurs);
		$db->where('idrecurso',$recurs);
		$places = $db->get('recursos',null,"idrecurso, title_".$lng.", smalldescription_".$lng.", pvid, comid, image, external_url");
		//echo "Last executed query was ". $db->getLastQuery();
		//if($place = mysql_fetch_array($query)){
		if($db->count >0){
			foreach ($places as $place) {
				?>
				<div class="list-col-four"><?php include("includes/card-places.php"); ?></div>
				<?php
			}
		}
	}
}
?>			    			    
			</div>
			
		</div>
	
	</section>

	<!-- Newsletter-->
		
	<?php //include("includes/newsletter.php"); ?>

<?php include("includes/footer.php"); ?>