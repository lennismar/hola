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
	/*$rs_query = mysqli_query("SELECT pvid, title, description_es, description_ca, description_en, description_fr, headimage1, headimage2, headimage3 FROM provincies WHERE pvid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
	$db->where('pvid',$id);
	$rs=$db->getOne('provincies','pvid, title, description_es, description_ca, description_en, description_fr, headimage1, headimage2, headimage3');

	$title = htmlspecialchars($rs['title']);
	$description_es = htmlspecialchars($rs['description_es']);
	$description_ca = htmlspecialchars($rs['description_ca']);
	$description_en = htmlspecialchars($rs['description_en']);		
	$description_fr = htmlspecialchars($rs['description_fr']);		
	$headimage1 = htmlspecialchars($rs['headimage1']);
	$headimage2 = htmlspecialchars($rs['headimage2']);
	$headimage3 = htmlspecialchars($rs['headimage3']);


	?><h2>Editar Provincia - <?php echo $title; ?></h2><?php				
}
?>                
				</div>
			
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <form id="provincies_form" action="provincies_act.php" method="post" enctype="multipart/form-data">
                                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                						<input type="hidden" name="action" value="process">

                                        <label>Imatge Capçalera 1</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage1" id="headimage1" size="30" class="button">
                                        
                                        <?php if($headimage1!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "provincias/" . $headimage1;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage1; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 2</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage2" id="headimage2" size="30" class="button">
                                        
                                        <?php if($headimage2!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "provincias/" . $headimage2;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage2; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 3</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage3" id="headimage3" size="30" class="button">
                                        
                                        <?php if($headimage3!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "provincias/" . $headimage3;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage3; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
                                        
                                        <br><br><br /><br />


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

                                    </form>
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
				<div class="flat_area grid_16">
                    <p style="display:inline">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'provincies.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.provincies_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
                    </p>
				</div>                
			</div>
		</div>
        
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
        
<?php include 'includes/closing_items.php'?>