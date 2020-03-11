<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
		<div id="wrapper">
			<?php include 'includes/topbar.php'?>		
			<?php include 'includes/sidebar.php'?>
			<div id="main_container" class="main_container container_16 clearfix">               
                <div class="flat_area grid_16">
                
<?php
	/*$rs_query = mysqli_query("SELECT * FROM texto_home");
	$rs = mysqli_fetch_array($rs_query);*/
	$rs=$db->getOne('texto_home','*');

	$texto_home_ca = htmlspecialchars($rs['texto_home_ca']);	
	$texto_home_es = htmlspecialchars($rs['texto_home_es']);	
	$texto_home_en = htmlspecialchars($rs['texto_home_en']);
	$texto_home_fr = htmlspecialchars($rs['texto_home_fr']);
?>
                
                <h2>Editar Text Home</h2>
                </div>
                      
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                	<form id="texto_form" action="texto_home_act.php" method="post">  
                                        <input type="hidden" name="action" value="process">
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_home_ca" name="texto_home_ca" style="width:500px"><?php echo $texto_home_ca;?></textarea>
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_home_es" name="texto_home_es" style="width:500px"><?php echo $texto_home_es;?></textarea>
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_home_en" name="texto_home_en" style="width:500px"><?php echo $texto_home_en;?></textarea>                                       

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_home_fr" name="texto_home_fr" style="width:500px"><?php echo $texto_home_fr;?></textarea>                                       
									</form>
                                </div>
                            </ul>
						</div>
                	</div>
				</div>
                
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.texto_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
					</p>
				</div>  
             
			</div>
		</div>
       
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
       
<?php include 'includes/closing_items.php'?>