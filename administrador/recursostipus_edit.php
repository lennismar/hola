<?php
$superadmin = 1; 
$id=$_GET["id"];
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php'?>
                                 
				<div class="flat_area grid_16">
                
<?php
if(isset($id)){
	/*$rs_query = mysqli_query("SELECT idtipusrecurso, title_es, title_ca, title_en, title_fr FROM recursos_tipus WHERE idtipusrecurso = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
	$db->where('idtipusrecurso',$id);
	$rs=$db->getOne('recursos_tipus','idtipusrecurso, title_es, title_ca, title_en, title_fr');		

	$title_es = htmlspecialchars($rs['title_es']);	
	$title_ca = htmlspecialchars($rs['title_ca']);	
	$title_en = htmlspecialchars($rs['title_en']);	
	$title_fr = htmlspecialchars($rs['title_fr']);	

	?>
    <h2>Tipus de recursos turístics</h2>
    <p>Administrar tipus de recursos turístics</p>
	<?php		

}else{
	$title_es = "";	
	$title_ca = "";	
	$title_en = "";
	$title_fr = "";

	?>
    <h2>Tipus de recursos turístics</h2>
    <p>Administrar tipus de recursos turístics</p>
	<?php

}
?>                
				</div>
			
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <form id="tipus_form" action="recursostipus_act.php" method="post">
                                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                						<input type="hidden" name="action" value="process">
                                    
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Nom</label> 
                                        <input title="Nom del tipus en català" type="text" name="title_ca" id="title_ca" class="small" autofocus value="<?php echo $title_ca;?>"> 
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Nom</label> 
                                        <input title="Nom del tipus en espanyol" type="text" name="title_es" id="title_es" class="small" value="<?php echo $title_es;?>"> 
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Nom</label> 
                                        <input title="Nom del tipus en anglès" type="text" name="title_en" id="title_en" class="small" value="<?php echo $title_en;?>">                                         

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Nom</label> 
                                        <input title="Nom del tipus en francés" type="text" name="title_fr" id="title_fr" class="small" value="<?php echo $title_fr;?>">                                         

                                    </form>
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
				<div class="flat_area grid_16">
                    <p style="display:inline">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'recursostipus.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.tipus_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
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
		
	// Live Validation		
		/*
	    var title_es = new LiveValidation('title_es');
		title_es.add( Validate.Presence );
		
		var title_ca = new LiveValidation('title_ca');
		title_ca.add( Validate.Presence );
	
        var title_en = new LiveValidation('title_en');
		title_en.add( Validate.Presence );
		*/
		
		var realemail = new LiveValidation('realemail');
		realemail.add( Validate.Email );

		var atleast = new LiveValidation('atleast');
		atleast.add( Validate.Length, { minimum: 30 } );

</script>
        
<?php include 'includes/closing_items.php'?>