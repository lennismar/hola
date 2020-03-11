<?php 
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
	/*$rs_query = mysqli_query("SELECT enm, eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE enm = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
	$db->where('enm',$id);
	$rs_query=$db->get('establiments_nitsmin',null,'*');
	foreach($rs_query as $rs){
?>
		<h2>Editar Mínim Nits per a <?php echo Query('establiments', 'title', 'eid', $rs['eid']);?></h2>
<?php				
		$date_start = date('Y-m-d',strtotime($rs['date_start']));
		$date_end = date('Y-m-d',strtotime($rs['date_end']));
	}
}else{
	?>
    <h2>Mínim Nits</h2>
	<?php
	$date_start = "";
	$date_end = "";
	
}
?>                
				</div>
			
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <form id="nitsmin_form" action="establimentsnitsmin_act.php" method="post">
                                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                						<input type="hidden" name="action" value="process">

										<label>Establiment</label>
                                		<div class="input_group">
                                    		<select name="eid" id="eid">

<?php
	if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
	/*$rs_query = mysqli_query("SELECT eid, title FROM establiments ORDER BY title ASC");
	while($establiments = mysqli_fetch_array($rs_query)){*/
		$db->orderBy('title','ASC');
		$rs_query=$db->get('establiments',null,'eid, title');
		
		foreach($rs_query as $establiments){
	?>    
												<option value="<?php echo $establiments['eid']?>" <?php if($rs['eid']==$establiments['eid']) echo "selected='selected'";?>> <?php echo $establiments['title']?></option>
	<?php
		}
	}
	else{
		$db->orderBy('title','ASC');
		$db->where('eid',$_SESSION['eid']);
		$rs_query=$db->get('establiments',null,'eid, title');
		
		
		foreach($rs_query as $establiments){
	?>    
												<option value="<?php echo $establiments['eid']?>" <?php if($rs['eid']==$establiments['eid']) echo "selected='selected'";?>> <?php echo $establiments['title']?></option>
	<?php
		}
	}	
?>
                                    		</select>
                                		</div> 

                                    
                                        <label>Data Començament</label> 
                                        <input id="date_start" name="date_start" type="text" class="datepicker" value="<?php echo $date_start; ?>">

                                        <label>Data Finalització</label> 
                                        <input id="date_end" name="date_end" type="text" class="datepicker" value="<?php echo $date_end;  ?>">

                                        <label>Nits minims</label> 
                                        <div class="input_group">
                                            <select name="nitsmin" id="nitsmin">
                                                <option value="1" <?php if ($rs['nitsmin']==1) echo 'selected="selected"'; ?>>1</option>
                                                <option value="2" <?php if ($rs['nitsmin']==2) echo 'selected="selected"'; ?>>2</option>
                                                <option value="3" <?php if ($rs['nitsmin']==3) echo 'selected="selected"'; ?>>3</option>
                                                <option value="4" <?php if ($rs['nitsmin']==4) echo 'selected="selected"'; ?>>4</option>
                                                <option value="5" <?php if ($rs['nitsmin']==5) echo 'selected="selected"'; ?>>5</option>
                                                <option value="6" <?php if ($rs['nitsmin']==6) echo 'selected="selected"'; ?>>6</option>
                                                <option value="7" <?php if ($rs['nitsmin']==7) echo 'selected="selected"'; ?>>7</option>
                                                <option value="8" <?php if ($rs['nitsmin']==8) echo 'selected="selected"'; ?>>8</option>
                                                <option value="9" <?php if ($rs['nitsmin']==9) echo 'selected="selected"'; ?>>9</option>
                                                <option value="10" <?php if ($rs['nitsmin']==10) echo 'selected="selected"'; ?>>10</option>
                                            </select>
                                        </div> 

                                        <label>Dia d'entrada</label> 
                                        <div class="input_group">
                                            <select name="dia_entrada" id="dia_entrada">
                                            	<?php 
                                            	$semana = array('','dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte', 'diumenge');
												$contador=0;
                                            	for($i=0;$i<count($semana);$i++){ ?>
                                            		<option value="<?php echo $contador; ?>" <?php if ($rs['dia_entrada']==$contador) echo 'selected="selected"'; ?>><?php echo $semana[$i]; ?></option>
                                                <?php 
                                                	$contador++;
                                                } ?>
                                            </select>
                                        </div>
                                         <label>Reserva en múltiples dies</label>
	                                    		<div class="input_group">
	                                        	<input name="reserva_multiplo" id="reserva_multiplo" type="radio" value="1" <?php if ($rs['reserva_multiplo']==1) echo "checked"; ?>>Si
	                                        <input name="reserva_multiplo" id="reserva_multiplo" type="radio"  value="0"  <?php if ($rs['reserva_multiplo']==0) echo "checked"; ?>>No
	                                   			 </div>
                                        <label>Preu del bloc de múltiples dies</label>
                                        <input id="precio_bloque_dias" name="precio_bloque_dias" type="text" class="" value="<?php echo $rs['precio_bloque_dias'];  ?>">
                                        <?php
                                        $db->where('eid',$rs['eid']);
                                        $admite_personas=$db->getOne('establiments','allow_extra_persons as admite');
                                        //var_dump($admite_personas); exit();
                                        if($admite_personas['admite']==1): ?>
                                        
	                                        <label>Preu extra per persona</label>
	                                    		<div class="input_group">
	                                        	<input name="precio_extra" id="precio_extra" type="radio" value="1" <?php if ($rs['precio_extra']==1) echo "checked"; ?>>Si
	                                        <input name="precio_extra" id="precio_extra" type="radio"  value="0"  <?php if ($rs['precio_extra']==0) echo "checked"; ?>>No
	                                   			 </div>
                                   		<?php endif; ?>
                                        <label>Preu extra per persona per bloc de múltiples dies</label>
                                        <input id="precio_extra_bloque_dias" name="precio_extra_bloque_dias" type="text" class="" value="<?php echo $rs['precio_extra_bloque_dias'];  ?>">
                                    </form>
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
				<div class="flat_area grid_16">
                    <p style="display:inline">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'establimentsnitsmin.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.nitsmin_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
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