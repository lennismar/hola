<?php 
$id=$_GET["id"];
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
		<div id="wrapper">
			<?php include 'includes/topbar.php'?>		
			<?php include 'includes/sidebar.php'?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php'?>
                                 
				<div class="flat_area grid_16">
                
<?php
if(isset($id)){
	//$rs_query = mysqli_query("SELECT * FROM texto_buscador WHERE id = " . $id);
	//$rs = mysqli_fetch_array($rs_query);
	$db->where("id",$id);
	$rs=$db->getOne("texto_buscador",null,"*");
?>
	<h2>Editar Advertència Buscador</h2><?php				
	$date_start = date('Y-m-d',strtotime($rs['date_start']));
	$date_end = date('Y-m-d',strtotime($rs['date_end']));

	$texto_buscador_ca = htmlspecialchars($rs['texto_buscador_ca']);	
	$texto_buscador_es = htmlspecialchars($rs['texto_buscador_es']);
	$texto_buscador_en = htmlspecialchars($rs['texto_buscador_en']);
	$texto_buscador_fr = htmlspecialchars($rs['texto_buscador_fr']);
}else{
	?>
    <h2>Nova Advertència Buscador</h2>
	<?php
	$date_start = "";
	$date_end = "";

	$texto_buscador_ca = "";	
	$texto_buscador_es = "";	
	$texto_buscador_en = "";
	$texto_buscador_fr = "";
}
?>                
				</div>
			
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <form id="texto_buscador_form" action="texto_buscador_act.php" method="post">
                                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                						<input type="hidden" name="action" value="process">

                                        <label>Data Començament</label> 
                                        <input id="date_start" name="date_start" type="text" class="datepicker" value="<?php echo $date_start; ?>">

                                        <label>Data Finalització</label> 
                                        <input id="date_end" name="date_end" type="text" class="datepicker" value="<?php echo $date_end;  ?>">
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Text Buscador</label> 
                                        <textarea id="texto_buscador_ca" name="texto_buscador_ca" style="width:500px"><?php echo $texto_buscador_ca;?></textarea>
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Text Buscador</label> 
                                        <textarea id="texto_buscador_es" name="texto_buscador_es" style="width:500px"><?php echo $texto_buscador_es;?></textarea>
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Text Buscador</label> 
                                        <textarea id="texto_buscador_en" name="texto_buscador_en" style="width:500px"><?php echo $texto_buscador_en;?></textarea>                                       

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Text Buscador</label> 
                                        <textarea id="texto_buscador_fr" name="texto_buscador_fr" style="width:500px"><?php echo $texto_buscador_fr;?></textarea>                                       
                                    </form>
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
				<div class="flat_area grid_16">
                    <p style="display:inline">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'texto_buscador.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.texto_buscador_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
                    </p>
				</div>                
			</div>
		</div>
        
<script type="text/javascript" src="js/livevalidation/livevalidation_standalone.js"></script>
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>
		
<script type="text/javascript">
    // Tipsy Top Config (more info found at http://onehackoranother.com/projects/jquery/tipsy/)
		$('[title]').not("div").tipsy({
			fade: true,     // fade tooltips in/out?
			fallback: '',    // fallback text to use when no tooltip text
			gravity: 's',    // gravity
			opacity: 1,    // opacity of tooltip
			title: 'title',  // attribute/callback containing tooltip text
			trigger: 'hover' // how tooltip is triggered - hover | focus | manual    	
		});  
		
	// Tipsy Side Config
		$('input[title]').tipsy({
			trigger: 'focus',  
			offset:'5',
			gravity: 'w'
		});

</script>
        
<?php include 'includes/closing_items.php'?>