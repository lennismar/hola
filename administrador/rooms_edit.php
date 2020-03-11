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
	/*$rs_query = mysqli_query("SELECT rid, eid, title_ca, title_es, title_en, title_fr, description_ca, description_es, description_en,  description_fr, persons, published, availability, daysmin, daysant FROM rooms WHERE rid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/	
	$db->where('rid',$id);
	$rs=$db->getOne('rooms',null,'rid, eid, title_ca, title_es, title_en, title_fr, description_ca, description_es, description_en,  description_fr, persons, published, availability, daysmin, daysant');
	
	
	$title_ca = htmlspecialchars($rs['title_ca']);
	$title_es = htmlspecialchars($rs['title_es']);
	$title_en = htmlspecialchars($rs['title_en']);
	$title_fr = htmlspecialchars($rs['title_fr']);

	$description_es = htmlspecialchars($rs['description_es']);
	$description_ca = htmlspecialchars($rs['description_ca']);
	$description_en = htmlspecialchars($rs['description_en']);
	$description_fr = htmlspecialchars($rs['description_fr']);

	$eid = $rs['eid'];
	$persons = $rs['persons'];
	$published = $rs['published'];
	$availability = $rs['availability'];
	$daysmin = $rs['daysmin'];
	$daysant = $rs['daysant'];

	?><h2>Editar Habitació - <?php echo $title_ca;?> - <?php echo Query('establiments', 'title', 'eid', $eid); ?></h2><?php				

}else{
	$title_ca = "";
	$title_es = "";
	$title_en = "";
	$title_fr = "";

	$description_es = "";
	$description_ca = "";
	$description_en = "";
	$description_fr = "";

	$eid = "";
	$persons = "";
	$published = "";
	$availability = "";
	$daysmin = "";
	$daysant = "";	

	?>
    <h2>Nova Habitació</h2>
	<p>Administrar Habitacions</p>
	<?php
}
?>   

<script type="text/JavaScript" src="js/BookingCalendar/js/jquery.dop.BookingCalendar.js"></script>

<script type="text/JavaScript">
	$(document).ready(function(){
		$('#backend').DOPBookingCalendar({
			'Type':'BackEnd',
			'Availability':<?php echo $availability; ?>,
			'DataURL': 'js/BookingCalendar/php/load.php?rid=<?php echo $id; ?>',
			'SaveURL': 'js/BookingCalendar/php/save.php?rid=<?php echo $id; ?>'
		});
		
		$('#frontend').DOPBookingCalendar({'Type':'FrontEnd'});

		$('#refresh1').click(function(){
			$('#backend').html('');
			$('#backend').DOPBookingCalendar({'Type':'BackEnd'});
		});

		$('#refresh2').click(function(){
			$('#frontend').html('');
			$('#frontend').DOPBookingCalendar({'Type':'FrontEnd'});
		});
	});
</script>
                         
				</div>
                
                <form id="rooms_form" action="rooms_act.php" method="post"> 			
				<div class="box grid_16 tabs">
					<ul class="tab_header grad_colour clearfix">
						<li><a href="#tabs-1">Detalls</a></li>
                        <li><a href="#tabs-2">Descripció</a></li>
                        <?php if(isset($id)){ ?>
                        	<li><a href="#tabs-3">Preus y Disponibilitat</a></li>
                        <?php } ?>
					</ul>

					<div class="toggle_container">
                    	<!-- Detalls -->
						<div id="tabs-1" class="block no_padding">
                            <div class="block">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <input type="hidden" name="action" value="process">
                                
                                <label><img src="images/language/ca.gif" width="23" height="13"> Titol</label> 
                                <input name="title_ca" id="title_ca" type="text" class="small required" value="<?php echo $title_ca;?>">
                                
                                <label><img src="images/language/es.gif" width="23" height="13"> Titol</label> 
                                <input name="title_es" id="title_es" type="text" class="small required" value="<?php echo $title_es;?>">
                                
                                <label><img src="images/language/en.gif" width="23" height="13"> Titol</label> 
                                <input name="title_en" id="title_en" type="text" class="small required" value="<?php echo $title_en;?>">                                                                                

                                <label><img src="images/language/fr.gif" width="23" height="13"> Titol</label> 
                                <input name="title_fr" id="title_fr" type="text" class="small required" value="<?php echo $title_fr;?>">                                                                                

								<?php
								if ($_SESSION['type_user']=='superadmin') {
                                ?>
								<label>Establiment</label>
                                <div class="input_group">
                                    <select name="eid" id="eid">

<?php
	/*$rs_query = mysqli_query("SELECT eid, title FROM establiments ORDER BY title ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title','ASC');
	$rs=$db->get('establiments',null,'eid, title');
	print_r($rs);
?>    
                                	<option value="<?php echo $rs['eid']?>" <?php if($eid==$rs['eid']) echo "selected='selected'";?>> <?php echo $rs['title']?></option>
<?php
//}
?>
                                    </select>
                                </div> 
                                <?php
								} else {?>
									<input type="hidden" name="eid" value="<?php echo $_SESSION['eid']; ?>">
								<?php	
								}
								?>   
                                <label>Disponibilitat</label> 
                                <div class="input_group">
                                    <select name="availability" id="availability">
                                        <option value="1" <?php if ($availability==1) echo 'selected="selected"'; ?>>1</option>
                                        <option value="2" <?php if ($availability==2) echo 'selected="selected"'; ?>>2</option>
                                        <option value="3" <?php if ($availability==3) echo 'selected="selected"'; ?>>3</option>
                                        <option value="4" <?php if ($availability==4) echo 'selected="selected"'; ?>>4</option>
                                        <option value="5" <?php if ($availability==5) echo 'selected="selected"'; ?>>5</option>
                                        <option value="6" <?php if ($availability==6) echo 'selected="selected"'; ?>>6</option>
                                        <option value="7" <?php if ($availability==7) echo 'selected="selected"'; ?>>7</option>
                                        <option value="8" <?php if ($availability==8) echo 'selected="selected"'; ?>>8</option>
                                        <option value="9" <?php if ($availability==9) echo 'selected="selected"'; ?>>9</option>
                                        <option value="10" <?php if ($availability==10) echo 'selected="selected"'; ?>>10</option>
                                        <option value="11" <?php if ($availability==11) echo 'selected="selected"'; ?>>11</option>
                                        <option value="12" <?php if ($availability==12) echo 'selected="selected"'; ?>>12</option>
                                        <option value="13" <?php if ($availability==13) echo 'selected="selected"'; ?>>13</option>
                                        <option value="14" <?php if ($availability==14) echo 'selected="selected"'; ?>>14</option>    
                                        <option value="15" <?php if ($availability==15) echo 'selected="selected"'; ?>>15</option>
                                        <option value="16" <?php if ($availability==16) echo 'selected="selected"'; ?>>16</option>
                                        <option value="17" <?php if ($availability==17) echo 'selected="selected"'; ?>>17</option>
                                        <option value="18" <?php if ($availability==18) echo 'selected="selected"'; ?>>18</option>
                                        <option value="19" <?php if ($availability==19) echo 'selected="selected"'; ?>>19</option>
                                        <option value="20" <?php if ($availability==20) echo 'selected="selected"'; ?>>20</option>                                                                                         
                                    </select>
                                </div> 
                                    
                                <label>Persones (Adults)</label>
                                <div class="input_group">
                                    <select name="persons" id="persons">
                                        <option value="1" <?php if ($persons==1) echo 'selected="selected"'; ?>>1</option>
                                        <option value="2" <?php if ($persons==2) echo 'selected="selected"'; ?>>2</option>
                                        <option value="3" <?php if ($persons==3) echo 'selected="selected"'; ?>>3</option>
                                        <option value="4" <?php if ($persons==4) echo 'selected="selected"'; ?>>4</option>
                                        <option value="5" <?php if ($persons==5) echo 'selected="selected"'; ?>>5</option>
                                        <option value="6" <?php if ($persons==6) echo 'selected="selected"'; ?>>6</option>
                                        <option value="7" <?php if ($persons==7) echo 'selected="selected"'; ?>>7</option>
                                        <option value="8" <?php if ($persons==8) echo 'selected="selected"'; ?>>8</option>
                                        <option value="9" <?php if ($persons==9) echo 'selected="selected"'; ?>>9</option>
                                        <option value="10" <?php if ($persons==10) echo 'selected="selected"'; ?>>10</option>
                                        <option value="11" <?php if ($persons==11) echo 'selected="selected"'; ?>>11</option>
                                        <option value="12" <?php if ($persons==12) echo 'selected="selected"'; ?>>12</option>
                                        <option value="13" <?php if ($persons==13) echo 'selected="selected"'; ?>>13</option>
                                        <option value="14" <?php if ($persons==14) echo 'selected="selected"'; ?>>14</option>    
                                        <option value="15" <?php if ($persons==15) echo 'selected="selected"'; ?>>15</option>
                                        <option value="16" <?php if ($persons==16) echo 'selected="selected"'; ?>>16</option>
                                        <option value="17" <?php if ($persons==17) echo 'selected="selected"'; ?>>17</option>
                                        <option value="18" <?php if ($persons==18) echo 'selected="selected"'; ?>>18</option>
                                        <option value="19" <?php if ($persons==19) echo 'selected="selected"'; ?>>19</option>
                                        <option value="20" <?php if ($persons==20) echo 'selected="selected"'; ?>>20</option>                                                                                         
                                    </select>
                                </div> 
                                
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Mínim de nits</label> 
                                    <select name="daysmin" id="daysmin">
                                        <option value="1" <?php echo OptionIsSelected ($daysmin,1); ?>>1</option>
                                        <option value="2" <?php echo OptionIsSelected ($daysmin,2); ?>>2</option>
                                        <option value="3" <?php echo OptionIsSelected ($daysmin,3); ?>>3</option>
                                        <option value="4" <?php echo OptionIsSelected ($daysmin,4); ?>>4</option>
                                        <option value="5" <?php echo OptionIsSelected ($daysmin,5); ?>>5</option>
                                        <option value="6" <?php echo OptionIsSelected ($daysmin,6); ?>>6</option>
                                        <option value="7" <?php echo OptionIsSelected ($daysmin,7); ?>>7</option>
                                        <option value="8" <?php echo OptionIsSelected ($daysmin,8); ?>>8</option>
                                        <option value="9" <?php echo OptionIsSelected ($daysmin,9); ?>>9</option>
                                        <option value="10" <?php echo OptionIsSelected ($daysmin,10); ?>>10</option>
                                        <option value="11" <?php echo OptionIsSelected ($daysmin,11); ?>>11</option>
                                        <option value="12" <?php echo OptionIsSelected ($daysmin,12); ?>>12</option>
                                        <option value="13" <?php echo OptionIsSelected ($daysmin,13); ?>>13</option>
                                        <option value="14" <?php echo OptionIsSelected ($daysmin,14); ?>>14</option>
                                    </select>
                                    </div>
                                </div>
                            
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Dies per anticipat</label>
                                    <select name="daysant" id="daysant">
                                        <option value="1" <?php echo OptionIsSelected ($daysant,1); ?>>1</option>
                                        <option value="2" <?php echo OptionIsSelected ($daysant,2); ?>>2</option>
                                        <option value="3" <?php echo OptionIsSelected ($daysant,3); ?>>3</option>
                                        <option value="4" <?php echo OptionIsSelected ($daysant,4); ?>>4</option>
                                        <option value="5" <?php echo OptionIsSelected ($daysant,5); ?>>5</option>
                                        <option value="6" <?php echo OptionIsSelected ($daysant,6); ?>>6</option>
                                        <option value="7" <?php echo OptionIsSelected ($daysant,7); ?>>7</option>
                                        <option value="8" <?php echo OptionIsSelected ($daysant,8); ?>>8</option>
                                        <option value="9" <?php echo OptionIsSelected ($daysant,9); ?>>9</option>
                                        <option value="10" <?php echo OptionIsSelected ($daysant,10); ?>>10</option>
                                        <option value="11" <?php echo OptionIsSelected ($daysant,11); ?>>11</option>
                                        <option value="12" <?php echo OptionIsSelected ($daysant,12); ?>>12</option>
                                        <option value="13" <?php echo OptionIsSelected ($daysant,13); ?>>13</option>
                                        <option value="14" <?php echo OptionIsSelected ($daysant,14); ?>>14</option>
                                    </select>
                                    </div>
                                </div>                                
                                    
                                <label>Publicat</label>
                                <div class="input_group">
                                    <input name="published" id="published" type="radio" value="1" <?php if ($published==1) echo "checked" ?>>Si
                                    <input name="published" id="published" type="radio" value="0"  <?php if ($published==0) echo "checked" ?>>No
                                </div>                                                              
                            </div>
						</div>
                        
                        <!-- Descripció -->
                        <div id="tabs-2" class="block">
                        	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="description_es" name="description_es" style="width:100%"><?php echo $description_es;?></textarea>
                                	</div>
                                </div>
                            </div>
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="description_ca" name="description_ca" style="width:100%"><?php echo $description_ca;?></textarea>
                                </div>
                            </div>
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="description_en" name="description_en" style="width:100%"><?php echo $description_en;?></textarea>
                                </div>
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="description_fr" name="description_fr" style="width:100%"><?php echo $description_fr;?></textarea>
                                </div>
                            </div>		

						</div>
                        
                        <?php if(isset($id)){ ?>
                        <!-- Preus -->   
						<div id="tabs-3" class="block no_padding">
                            <div class="block">
                                <div id="backend-container">
                                    <div id="backend"></div>
                                </div>                                
                            </div>
						</div>      
                        <?php } ?>                                             
                    </div>
				</div>
                </form>
                                
				<div class="flat_area grid_16">
                <p>
                    <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'rooms.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
					<button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.rooms_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
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
        var notempty = new LiveValidation('notempty');
		notempty.add( Validate.Presence );

		var realemail = new LiveValidation('realemail');
		realemail.add( Validate.Email );

		var atleast = new LiveValidation('atleast');
		atleast.add( Validate.Length, { minimum: 30 } );

</script>


<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "description_es, description_ca, description_en, description_fr",
		plugins: "media",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,cleanup,code,removeformat,link,unlink,|,pastetext,pasteword",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",				
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : true,
		convert_urls : false,
		forced_root_block : false,
		force_p_newlines : false,
		remove_linebreaks : false,
		force_br_newlines : true,
		remove_trailing_nbsp : false,
		verify_html : false
	});
</script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>

<script type="text/javascript">	
	
	//FancyBox Config (more info can be found at http://www.fancybox.net/)

		$(".gallery ul li a").fancybox({
	        'overlayColor':'#000' 		
		});
		
		$("a img.fancy").fancybox();
		
</script>


        
<?php include 'includes/closing_items.php'?>