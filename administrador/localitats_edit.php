<?php 
$id=$_GET["id"];
$superadmin = 1;
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
	/*$rs_query = mysqli_query("SELECT lid, pvid, comid, title FROM localitats WHERE lid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
	$db->where('lid',$id);
	$rs=$db->getOne('localitats','lid, pvid, comid, title');

	$title = htmlspecialchars($rs['title']);
	$pvid = htmlspecialchars($rs['pvid']);	
	$comid = htmlspecialchars($rs['comid']);	

	?><h2>Editar Localitat</h2><?php				

}else{
	$title = "";

	?>
    <h2>Nova Localitat</h2>
	<p>Administrar localitats</p>
<?php
}
?>                
				</div>
			
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <form id="localitats_form" action="localitats_act.php" method="post">
                                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                						<input type="hidden" name="action" value="process">

                                        <label>Localitat</label> 
                                        <input title="Nom de la localitat" type="text" name="title" id="title" class="small" value="<?php echo $title;?>"> 
                                    
                                        <label>Provincia</label>
                                        <div class="input_group">
                                            <select name="pvid" id="pvid" dir="ltr">
                                                <option value="0">- Seleccioni Provincia -</option>
<?php
	//$rs_query = mysqli_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
	$query = "SELECT pvid, title FROM provincies ORDER BY title ASC";
	$rs_query=$db->rawQuery($query);
	//while($rs = mysqli_fetch_array($rs_query)){
	foreach($rs_query as $rs){
?>    
												<option value="<?php echo $rs['pvid']?>" <?php if($pvid==$rs['pvid']) echo "selected='selected'";?>> <?php echo $rs['title']?> </option>
<?php
	}
?>												
                                            </select>
                                        </div>  


                                        <label>Comarca</label>
                                        <div class="input_group">
                                            <select name="comid" id="comid" dir="ltr">
<?php
	if ($id!="") { 
		//$rs_query = mysqli_query("SELECT comid, pvid, title FROM comarques WHERE comid = ". $comid." ORDER BY title ASC");
		$db->orderBy('title','ASC');
		$db->where('comid',$comid);
		$rs_query=$db->geet('comarques',null,'comid,pvid,title');
		//while($rs = mysqli_fetch_array($rs_query)){
		foreach($rs_query as $rs){
?>
		<option value="<?php echo $rs['comid']?>" <?php if($comid==$rs['comid']) echo "selected='selected'";?>><?php echo $rs['title']?></option>		
<?php
		}
	}
?>
                                            </select>
                                        </div>  
                                
                                    </form>
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
				<div class="flat_area grid_16">
                    <p style="display:inline">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'localitats.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.localitats_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
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