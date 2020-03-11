<?php 
$superadmin = 1;
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
	/*$rs_query = mysqli_query("SELECT * FROM banners_header WHERE bhid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
    $db->where('bhid',$id);
    $rs=$db->getOne('banners_header','*');		

	$title_es = htmlspecialchars($rs['title_es']);	
	$title_ca = htmlspecialchars($rs['title_ca']);	
	$title_en = htmlspecialchars($rs['title_en']);
	$title_fr = htmlspecialchars($rs['title_fr']);

	$image_es = htmlspecialchars($rs['image_es']);
	$image_ca = htmlspecialchars($rs['image_ca']);
	$image_en = htmlspecialchars($rs['image_en']);
	$image_fr = htmlspecialchars($rs['image_fr']);

	$orden = htmlspecialchars($rs['orden']);
	$published = htmlspecialchars($rs['published']);

	?><h2>Editar Banners Capçalera</h2><?php				

}else{
	$title_es = "";	
	$title_ca = "";	
	$title_en = "";	
	$title_fr = "";	
	$image_es = "";
	$image_ca = "";
	$image_en = "";		
	$image_fr = "";		
	$orden = 0;
	$published = 1;

	?>
    <h2>Nou Banner Capçalera</h2>
<?php
}
?>
    				<p>
                    	<strong>Les imatges:</strong><br />
                    	<em>Obligatoriament de la mida 720 x 298 px en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em>
                    </p> 
                
                </div>
                      
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                	<form id="banners_form" action="banners_header_act.php" method="post" enctype="multipart/form-data">  
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="action" value="process">
                                    	
                                        <label>Publicat</label>
                                        <div class="input_group">
                                            <input name="published" id="published" type="radio" value="1" <?php if ($published==1) echo "checked" ?>>Si
                                            <input name="published" id="published" type="radio" value="0"  <?php if ($published==0) echo "checked" ?>>No
                                        </div>
                                        
                                        <label>Ordre</label> 
                                        <input type="text" name="orden" id="orden" class="small" autofocus value="<?php echo $orden;?>">                                         
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_ca" id="title_ca" class="small" value="<?php echo $title_ca;?>"> 
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_es" id="title_es" class="small" value="<?php echo $title_es;?>"> 
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_en" id="title_en" class="small" value="<?php echo $title_en;?>">                                         

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_fr" id="title_fr" class="small" value="<?php echo $title_fr;?>">                                         
                                                                   
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Imatge </label>
                                        <input type="file" name="image_ca" id="image_ca" size="30" class="button">
                                        
                                        <?php if($image_ca!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "banners/" . $image_ca;?>" width="250" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $image_ca; ?>
                                        <br />
                                        <?php } ?>
										<br /><br />
                                        
                                        
                                        <label><img src="images/language/es.gif" width="23" height="13"> Imatge </label>
                                        <input type="file" name="image_es" id="image_es" size="30" class="button">
                                        
                                        <?php if($image_es!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "banners/" . $image_es;?>" width="250" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $image_es; ?>
                                        <br />
                                        <?php } ?>
                                        <br /><br />
                                        
                                        
                                        <label><img src="images/language/en.gif" width="23" height="13"> Imatge </label>
                                        <input type="file" name="image_en" id="image_en" size="30" class="button">
                                        
                                        <?php if($image_en!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "banners/" . $image_en;?>" width="250" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $image_en; ?>
                                        <br />
                                        <?php } ?>
                                        <br /><br />

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Imatge </label>
                                        <input type="file" name="image_fr" id="image_fr" size="30" class="button">
                                        
                                        <?php if($image_fr!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "banners/" . $image_fr;?>" width="250" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $image_fr; ?>
                                        <?php } ?>     
                                        <br />                                                                               
										<br /><br />

                                    </form> 
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'banners_header.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.banners_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
					</p>
				</div>  
             
			</div>
		</div>
       
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
       
<?php include 'includes/closing_items.php'?>