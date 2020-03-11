<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';

$prices="all";
$where="location";
$tipus="all";
$serid = array();
$perid = array();

if(isset($_GET["id"])){
	$id = $_GET["id"];
	/*$rs_query = mysqli_query("SELECT * FROM landings WHERE id = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
    $db->where('id',$id);
    $rs=$db->getOne('landings','*');

	$headimage1 = htmlspecialchars($rs['headimage1']);
	$headimage2 = htmlspecialchars($rs['headimage2']);
	$headimage3 = htmlspecialchars($rs['headimage3']);
	$prices = htmlspecialchars($rs['prices']);
	$location = htmlspecialchars($rs['location']);
	$tipus = $rs['tipus'];
    $linked_comarcas= $rs['linked_cid'];
    $linked_perfiles= $rs['linked_pid'];
}

$serid = explode('+', $rs['serveis']);
$perid = explode('+', $rs['perfils']);


?>
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">               
                <div class="box grid_16">
                    <div class="block">
                        <?php if (isset($id)) { ?>
                        <h1 class="section">Edit Landing Page</h1>
                        <?php } else {?>
                        <h1 class="section">New Landing Page</h1>
                        <?php }; ?>
                    </div>
                </div>
                      
					<form id="theform" class="validate_form" action="landings_act.php" method="post" enctype="multipart/form-data">
                    <div class="box grid_16 tabs">
                        <ul class="tab_header grad_colour clearfix">
                            <li><a href="#url">URL / Status</a></li>
                            <li><a href="#images">Imatges</a></li>
                            <li><a href="#title">Titol / Subtitol</a></li>
                            <li><a href="#content">Descripció</a></li>
                            <li><a href="#seo">SEO</a></li>
                            <li><a href="#properties">Filtre de Cases</a></li>
                        </ul>
                        
                        <div class="toggle_container">
                            <input type="hidden" name="action" value="process">
                            <?php if (isset($id)) { ?>
								<input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php } ?>
 
                            <!-- url -->
                            <div id="url" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block">

                                        <label><img src="images/language/ca.gif" width="23" height="13"> Identificador URL</label> 
                                        <input type="text" name="url_ca" id="url_ca" class="large" placeholder="cases-rurals-amb-piscina" value="<?php echo htmlspecialchars($rs['url_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> Identificador URL</label> 
                                        <input type="text" name="url_es" id="url_es" class="large" placeholder="cases-rurals-amb-piscina" value="<?php echo htmlspecialchars($rs['url_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> Identificador URL</label> 
                                        <input type="text" name="url_en" id="url_en" class="large" placeholder="cases-rurals-amb-piscina" value="<?php echo htmlspecialchars($rs['url_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Identificador URL</label> 
                                        <input type="text" name="url_fr" id="url_fr" class="large" placeholder="cases-rurals-amb-piscina" value="<?php echo htmlspecialchars($rs['url_fr']);?>">
										
                                        <br /><br />

                                        <label>Status</label>
                                        <div class="input_group">
                                            <input name="status" id="status" type="radio" value="1" <?php if ($rs['status']==1) echo "checked" ?>>Actiu
                                            <input name="status" id="status" type="radio"  value="0"  <?php if ($rs['status']==0) echo "checked" ?>>Inactiu
                                        </div>

                                        <br /><br />
                                        <label>Comarcas</label>
                                        <select name="linked_comarcas" id="comarcas">
                                            <option value="0" id="inicioC"></option>
                                            <?php $cols=Array("comid","title");
                                            $db->orderBy("title","asc");
                                            $rs_result=$db->get("comarques",null,$cols);    
                                            foreach($rs_result as $rs1){ ?>
                                                <option <?php if($linked_comarcas == $rs1['comid']){ echo'selected="selected"';} ?> value="<?php echo $rs1['comid']; ?>"><?php echo $rs1['title'];?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Perfiles</label>
                                        <select name="linked_perfiles" id="perfiles">
                                            <option value="0" id="inicioP"></option>
                                            <?php
                                             
                                                $db->orderBy("title_ca",'ASC');
                                                $rs_query=$db->get('perfils',null,"perid, title_ca");
                                                foreach($rs_query as $rs2){
                                            ?>
                                                    <option <?php if($linked_perfiles == $rs2['perid']){ echo'selected="selected"';} ?> value="<?php echo $rs2['perid']; ?>">  <?php echo $rs2['title_ca'];?></option> 
                                                <?php ; } ?>
                                        </select>
                                    </div>
                                </ul>
                            </div>

                            <!-- images -->
                            <div id="images" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block">

                                        <label>Imatge Capçalera 1</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage1" id="headimage1" size="30" class="button">
                                        
                                        <?php if($headimage1!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "landings/" . $headimage1;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage1; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 2</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage2" id="headimage2" size="30" class="button">
                                        
                                        <?php if($headimage2!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "landings/" . $headimage2;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage2; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
    
                                        <br><br><br /><br />
    
                                        <label>Imatge Capçalera 3</label>
                                        <em>Mida 1400 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                        <input type="file" name="headimage3" id="headimage3" size="30" class="button">
                                        
                                        <?php if($headimage3!=""){ ?>
                                        <br />
                                        <img src="<?php echo URL_BASE . FILE_DIR . "landings/" . $headimage3;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                        <?php echo $headimage3; ?>	
                                        <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                        <?php } ?>
                                        
                                        
                                    </div>
                                </ul>
                            </div>


                            <!-- title -->
                            <div id="title" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block">

                                        <label><img src="images/language/ca.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_ca" id="title_ca" class="large" placeholder="Cases rurals a catalunya amb piscina" value="<?php echo htmlspecialchars($rs['title_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_es" id="title_es" class="large" placeholder="Cases rurals a catalunya amb piscina" value="<?php echo htmlspecialchars($rs['title_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_en" id="title_en" class="large" placeholder="Cases rurals a catalunya amb piscina" value="<?php echo htmlspecialchars($rs['title_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> Titol</label> 
                                        <input type="text" name="title_fr" id="title_fr" class="large" placeholder="Cases rurals a catalunya amb piscina" value="<?php echo htmlspecialchars($rs['title_fr']);?>">
            							<br /><br />
                                        
                                        <label><img src="images/language/ca.gif" width="23" height="13"> SubTitol</label> 
                                        <input type="text" name="subtitle_ca" id="subtitle_ca" class="large" placeholder="Aquí trobarás les millors Cases rurals amb piscina de tota Catalunya. No ho dubtis i refresca't." value="<?php echo htmlspecialchars($rs['subtitle_ca']);?>">

                                        <label><img src="images/language/es.gif" width="23" height="13"> SubTitol</label> 
                                        <input type="text" name="subtitle_es" id="subtitle_es" class="large" placeholder="Aquí trobarás les millors Cases rurals amb piscina de tota Catalunya. No ho dubtis i refresca't." value="<?php echo htmlspecialchars($rs['subtitle_es']);?>">

                                        <label><img src="images/language/en.gif" width="23" height="13"> SubTitol</label> 
                                        <input type="text" name="subtitle_en" id="subtitle_en" class="large" placeholder="Aquí trobarás les millors Cases rurals amb piscina de tota Catalunya. No ho dubtis i refresca't." value="<?php echo htmlspecialchars($rs['subtitle_en']);?>">

                                        <label><img src="images/language/fr.gif" width="23" height="13"> SubTitol</label> 
                                        <input type="text" name="subtitle_fr" id="subtitle_fr" class="large" placeholder="Aquí trobarás les millors Cases rurals amb piscina de tota Catalunya. No ho dubtis i refresca't." value="<?php echo htmlspecialchars($rs['subtitle_fr']);?>">
                                        
                                        
                                    </div>
                                </ul>
                            </div>
                            
                            <!-- content -->
                            <div id="content" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block">
                                        <label><img src="images/language/ca.gif" width="23" height="13"> Descripció</label> 
                                        <textarea id="content_ca" name="content_ca" style="width:700px"><?php echo htmlspecialchars($rs['content_ca']);?></textarea>
                                        <br />
                                        <label><img src="images/language/es.gif" width="23" height="13"> Descripció</label> 
                                        <textarea id="content_es" name="content_es" style="width:700px"><?php echo htmlspecialchars($rs['content_es']);?></textarea>
                                        <br />
                                        <label><img src="images/language/en.gif" width="23" height="13"> Descripció</label> 
                                        <textarea id="content_en" name="content_en" style="width:700px"><?php echo htmlspecialchars($rs['content_en']);?></textarea>                                       
										<br />
                                        <label><img src="images/language/fr.gif" width="23" height="13"> Descripció</label> 
                                        <textarea id="content_fr" name="content_fr" style="width:700px"><?php echo htmlspecialchars($rs['content_fr']);?></textarea>                                       
                                    </div>
                                </ul>
                            </div>

                            <!-- seo -->
                            <div id="seo" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block">
                                    	<h2>Meta Title</h2>
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
                                    </div>
                                </ul>
                            </div>

                            <!-- properties -->
                            <div id="properties" class="block no_padding">
                                <ul class="full_width">
                                    <div class="block"> 
                                    <!--
                                    <h2>Selecció de Establiments per ID's</h2> 
                                    <label>Númmeros Id de la casa separades per commes. S'hi s'omple desactivará els filtres y surtiran solament les cases seleccionades. Sinó, es deixa buit.</label> 
                                    <input type="text" name="eidlist" id="eidlist" class="large" placeholder="234,123,423,564,1,2,34,4,56,45,23" value="<?php echo htmlspecialchars($rs['eidlist']);?>">
                                    
                                    <br /><br />  
                                    -->
                                    <label></label>
                                    <h2>Escull Localització</h2>   
                                    <div class="input_group">
                                    <select name="location" id="location">
                                            <option value="all" <?php if($location=="all") echo "selected='selected'";?>>Tota Catalunya</option>							 	
                                            <optgroup label="Provincias" style="font-style:normal">
                                                <?php echo PrintOptionProvincia($location); ?>
                                            </optgroup>
                                                            
                                            <optgroup label="Comarcas">
                                               <?php echo PrintOptionComarca($location);   ?>
                                            </optgroup>
                        
                                    </select>
                                    </div>
                                    <br />
                                    
                                    <label></label>
                                    <h2>Tipus d'establiments</h2> 
                                    <div class="input_group">
                                        <select name="tipus" id="tipus" dir="ltr">
                                            <option value="all" <?php if($tipus=="all") echo "selected='selected'";?>>Tot tipus</option>
<?php
/*$rs_query = mysqli_query("SELECT tid, title_ca FROM tipus ORDER BY title_ca ASC");
while($rs2 = mysqli_fetch_array($rs_query)){*/
    $db->orderBy('title_ca');
    $rs_query=$db->get('tipus',null,'tid, title_ca');
    foreach($rs_query as $rs2){
?>    
                                            <option value="<?php echo $rs2['tid']?>" <?php if($tipus==$rs2['tid']) echo "selected='selected'";?>> <?php echo $rs2['title_ca']?></option>
<?php
}
?>
                                        </select>
                                    </div> 
                                    <br />
                                    
                                    <label></label> 
                                    <h2>Preu per persona/nit</h2>
                                    <div class="input_group">
                                        <input name="prices" id="prices" type="radio" value="all" <?php if ($prices=="all") echo "checked" ?>>Qualsevol preu&nbsp;&nbsp;
                                        <input name="prices" id="prices" type="radio" value="0-29"  <?php if ($prices=="0-29") echo "checked" ?>>0-29€&nbsp;&nbsp;
                                        <input name="prices" id="prices" type="radio" value="30-59"  <?php if ($prices=="30-59") echo "checked" ?>>30-59€&nbsp;&nbsp;
                                        <input name="prices" id="prices" type="radio" value="60-1000"  <?php if ($prices=="60-1000") echo "checked" ?>>+60€
                                    </div> 
                                    <br /> 

                                    <h2>Perfils</h2>
                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">
                                    <?php
                                    //$rs_query = mysqli_query("SELECT perid, title_ca FROM perfils ORDER BY title_ca ASC");
                                    $db->orderBy('title_ca','ASC');
                                    $rs_query=$db->get('perfils',null,'perid, title_ca');
                                    $fila = 1;
                                    //while($rs2 = mysqli_fetch_array($rs_query)){
                                    foreach($rs_query as $rs2){
                                        if ($fila == 6) {
                                            $fila = 0;

                                    ?>
                                        </div>  
                                    </div>	
                                        
                                    
                                    <div class="grid_2" style="margin:0">
                                                <div class="input_group">			
                                        <?php
                                            }
                                        ?>
                                            <input name="perid[]" id="perid[]"  type="checkbox" value="<?php echo $rs2['perid'];?>"
                                        <?php
                                         if (in_array($rs2['perid'], $perid)) {
                                             echo ' checked="checked" ';
                                 }
                                ?>
                                    ><?php echo $rs2['title_ca'];?><br>

                                <?php
                                    $fila++;
                                }
                                ?>
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <label></label>
                                                                <h2>Serveis</h2>
                                                                <div class="grid_2" style="margin:0">
                                                                    <div class="input_group">
                                <?php
                                    //$rs_query = mysqli_query("SELECT serid, title_ca FROM serveis ORDER BY title_ca ASC");
                                    $db->orderBy('title_ca','ASC');
                                    $rs_query=$db->get('serveis',null,'serid, title_ca');
                                    $fila = 1;
                                    //while($rs2 = mysqli_fetch_array($rs_query)){
                                    foreach($rs_query as $rs2){
                                        if ($fila == 11) {
                                            $fila = 0;
                                ?>
                                        </div>  
                                    </div>	
                                    
                                    
                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">			
    <?php			
            }
    ?>   
            <input name="serid[]" id="serid[]" type="checkbox" value="<?php echo $rs2['serid'];?>"
			<?php 
             if (in_array($rs2['serid'], $serid)) {
                 echo ' checked="checked" ';
             }
            ?>    
            ><?php echo $rs2['title_ca'];?><br>
            
    <?php
            $fila++;
        }
    ?>
                                        </div>  
                                    </div>

                                                                      
                                    </div>
                                </ul>
                            </div>
						</div>
                    </div>
                </form>                
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'landings.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>                        
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.theform.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
                    </p>
                </div>    
             
			</div>
		</div>
       
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		entity_encoding : "raw",
		mode : "exact",
		elements : "content_ca,content_es,content_en,content_fr",
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
    $(document).ready(function(){
        $('#comarcas').change(function(){
            if($('#perfiles').val() >0 && $('#comarcas').val() >0){
                 $("#perfiles option").removeAttr('selected');
                 $('#perfiles').change();
            }
        });
        $('#perfiles').change(function(){
            if($('#perfiles').val() >0 && $('#comarcas').val() >0){                 
                 $("#comarcas option").removeAttr('selected');
                 $('#comarcas').change();
            }
        });
    })
</script>

       
<?php include 'includes/closing_items.php'?>