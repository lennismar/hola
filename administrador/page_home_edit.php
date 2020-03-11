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

    $rs = $db->getOne ("page_home");

	$headimage1 = htmlspecialchars($rs['headimage1']);
	$headimage2 = htmlspecialchars($rs['headimage2']);
	$headimage3 = htmlspecialchars($rs['headimage3']);

?>
                
                <h2>Editar Text Home</h2>
                </div>
                      
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                	<form id="texto_form" action="page_home_act.php" method="post" enctype="multipart/form-data">  
                                        <input type="hidden" name="action" value="process">
                                        
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Meta Title</label> 
                                        <input type="text" name="meta_title_ca" id="meta_title_ca" class="large" value="<?php echo htmlspecialchars($rs['meta_title_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> Meta Title</label> 
                                        <input type="text" name="meta_title_es" id="meta_title_es" class="large" value="<?php echo htmlspecialchars($rs['meta_title_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> Meta Title</label> 
                                        <input type="text" name="meta_title_en" id="meta_title_en" class="large" value="<?php echo htmlspecialchars($rs['meta_title_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Meta Title</label> 
                                        <input type="text" name="meta_title_fr" id="meta_title_fr" class="large" value="<?php echo htmlspecialchars($rs['meta_title_fr']);?>">
										<br /><br />

                                        <label><img src="images/language/ca.gif" width="23" height="13"> Meta Description</label> 
                                        <input type="text" name="meta_description_ca" id="meta_description_ca" class="large" value="<?php echo htmlspecialchars($rs['meta_description_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> Meta Description</label> 
                                        <input type="text" name="meta_description_es" id="meta_description_es" class="large" value="<?php echo htmlspecialchars($rs['meta_description_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> Meta Description</label> 
                                        <input type="text" name="meta_description_en" id="meta_description_en" class="large" value="<?php echo htmlspecialchars($rs['meta_description_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Meta Description</label> 
                                        <input type="text" name="meta_description_fr" id="meta_description_fr" class="large" value="<?php echo htmlspecialchars($rs['meta_description_fr']);?>">
										<br /><br />

                                        <label><img src="images/language/ca.gif" width="23" height="13"> Meta Keywords</label> 
                                        <input type="text" name="meta_keywords_ca" id="meta_keywords_ca" class="large" value="<?php echo htmlspecialchars($rs['meta_keywords_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> Meta Keywords</label> 
                                        <input type="text" name="meta_keywords_es" id="meta_keywords_es" class="large" value="<?php echo htmlspecialchars($rs['meta_keywords_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> Meta Keywords</label> 
                                        <input type="text" name="meta_keywords_en" id="meta_keywords_en" class="large" value="<?php echo htmlspecialchars($rs['meta_keywords_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Meta Keywords</label> 
                                        <input type="text" name="meta_keywords_fr" id="meta_keywords_fr" class="large" value="<?php echo htmlspecialchars($rs['meta_keywords_fr']);?>">
                                        <br /><br /> 
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_ca" name="texto_ca" style="width:700px"><?php echo htmlspecialchars($rs['texto_ca']);?></textarea>
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_es" name="texto_es" style="width:700px"><?php echo htmlspecialchars($rs['texto_es']);?></textarea>
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_en" name="texto_en" style="width:700px"><?php echo htmlspecialchars($rs['texto_en']);?></textarea>                                       

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Text Home</label> 
                                        <textarea id="texto_fr" name="texto_fr" style="width:700px"><?php echo htmlspecialchars($rs['texto_fr']);?></textarea>                                       
										<br><br>
                                        <label>Imatge Capçalera 1</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage1" id="headimage1" size="30" class="button">
                                        
                                        <?php if($headimage1!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "home/" . $headimage1;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage1; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 2</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage2" id="headimage2" size="30" class="button">
                                        
                                        <?php if($headimage2!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "home/" . $headimage2;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage2; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 3</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage3" id="headimage3" size="30" class="button">
                                        
                                        <?php if($headimage3!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "home/" . $headimage3;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage3; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
                                        
                                        <br><br><br /><br />
		
                                    
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