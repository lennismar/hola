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
                
<?php
if(isset($id)){
	/*$rs_query = mysqli_query("SELECT * FROM recursos WHERE idrecurso = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
    $db->where('idrecurso',$id);
    $rs=$db->getOne('recursos','*');		

	$title_es = htmlspecialchars($rs['title_es']);	
	$title_ca = htmlspecialchars($rs['title_ca']);	
	$title_en = htmlspecialchars($rs['title_en']);
	$title_fr = htmlspecialchars($rs['title_fr']);
	$smalldescription_es = htmlspecialchars($rs['smalldescription_es']);
	$smalldescription_ca = htmlspecialchars($rs['smalldescription_ca']);
	$smalldescription_en = htmlspecialchars($rs['smalldescription_en']);
	$smalldescription_fr = htmlspecialchars($rs['smalldescription_fr']);
	$description_es = htmlspecialchars($rs['description_es']);
	$description_ca = htmlspecialchars($rs['description_ca']);
	$description_en = htmlspecialchars($rs['description_en']);
	$description_fr = htmlspecialchars($rs['description_fr']);
	
	$quever_es = htmlspecialchars($rs['quever_es']);
	$quever_ca = htmlspecialchars($rs['quever_ca']);
	$quever_en = htmlspecialchars($rs['quever_en']);
	$quever_fr = htmlspecialchars($rs['quever_fr']);

	$infopract_es = htmlspecialchars($rs['infopract_es']);
	$infopract_ca = htmlspecialchars($rs['infopract_ca']);
	$infopract_en = htmlspecialchars($rs['infopract_en']);
	$infopract_fr = htmlspecialchars($rs['infopract_fr']);
	
	$seotitle = htmlspecialchars($rs['seotitle']);	
	$seowords_ca = htmlspecialchars($rs['seowords_ca']);
	$seowords_es = htmlspecialchars($rs['seowords_es']);	
	$seowords_en = htmlspecialchars($rs['seowords_en']);
	$seowords_fr = htmlspecialchars($rs['seowords_fr']);
	$info_quan = htmlspecialchars($rs['info_quan']);
	$info_on = htmlspecialchars($rs['info_on']);
	$info_more = htmlspecialchars($rs['info_more']);
	$gmap_lat = htmlspecialchars($rs['gmap_lat']);
	$gmap_lng = htmlspecialchars($rs['gmap_lng']);
	$image = htmlspecialchars($rs['image']);
	
	$headimage1 = htmlspecialchars($rs['headimage1']);
	$headimage2 = htmlspecialchars($rs['headimage2']);
	$headimage3 = htmlspecialchars($rs['headimage3']);
	
	$pvid = htmlspecialchars($rs['pvid']);
	$comid = htmlspecialchars($rs['comid']);
	$idtipusrecurso = htmlspecialchars($rs['idtipusrecurso']);
	$published = htmlspecialchars($rs['published']);
	$external_url = htmlspecialchars($rs['external_url']);

	?><h2>Editar Recursos turístics</h2><?php				

}else{
	$title_es = "";	
	$title_ca = "";	
	$title_en = "";	
	$title_fr = "";	
	$smalldescription_es = "";
	$smalldescription_ca = "";
	$smalldescription_en = "";
	$smalldescription_fr = "";
	$description_es = "";	
	$description_ca = "";	
	$description_en = "";
	$description_fr = "";
	$quever_es = "";
	$quever_ca = "";
	$quever_en = "";
	$quever_fr = "";

	$infopract_es = "";
	$infopract_ca = "";
	$infopract_en = "";
	$infopract_fr = "";
	
	$seowords_ca = "";
	$seowords_es = "";
	$seowords_en = "";		
	$seowords_fr = "";		
	$info_quan = "";
	$info_on = "";
	$info_more = "";
	$gmap_lat = "";
	$gmap_lng = "";
	$image = "";
	$pvid = "";
	$comid = "";
	$idtipusrecurso = "";
	$published = "";
    $external_url = "";

	?>
    <h2>Nou Recursos turístics</h2>
	<p>Gestionar dels diferents recursos turístics</p>
<?php
}
?>
                
                <form id="tipus_form" action="recursos_act.php" method="post" enctype="multipart/form-data">        
				<div class="box grid_16 tabs">
					<ul class="tab_header grad_colour clearfix">
						<li><a href="#tabs-1">Detalls</a></li>
                        <li><a href="#tabs-2">Descripció</a></li>
                        <li><a href="#tabs-3">Que Veure</a></li>
                        <li><a href="#tabs-4">Informació Pràctica</a></li>
                        <li><a href="#tabs-5">SEO</a></li>
                        <li><a href="#tabs-6">Imatges</a></li>
					</ul>
                    
					<div class="toggle_container">
                    	<!-- DETALLS -->
						<div id="tabs-1" class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <input type="hidden" name="action" value="process">
                                
                                    <label><img src="images/language/ca.gif" width="23" height="13"> Nom</label> 
                                    <input type="text" name="title_ca" id="title_ca" class="small" autofocus value="<?php echo $title_ca;?>"> 
                                    
                                    <label><img src="images/language/es.gif" width="23" height="13"> Nom</label> 
                                    <input type="text" name="title_es" id="title_es" class="small" value="<?php echo $title_es;?>"> 
                                    
                                    <label><img src="images/language/en.gif" width="23" height="13"> Nom</label> 
                                    <input type="text" name="title_en" id="title_en" class="small" value="<?php echo $title_en;?>">                                         

                                    <label><img src="images/language/fr.gif" width="23" height="13"> Nom</label> 
                                    <input type="text" name="title_fr" id="title_fr" class="small" value="<?php echo $title_fr;?>">                                         
                            
                            		<label><img src="images/language/ca.gif" width="23" height="13"> Descripció Curta (<span id="maxlenght_smalldescription_ca">160</span> caràcters)</label> 
									<textarea id="smalldescription_ca" name="smalldescription_ca" cols="47" rows="40"><?php echo $smalldescription_ca;?></textarea>

                            		<label><img src="images/language/es.gif" width="23" height="13"> Descripció Curta (<span id="maxlenght_smalldescription_es">160</span> caràcters)</label> 
									<textarea id="smalldescription_es" name="smalldescription_es" cols="47" rows="40"><?php echo $smalldescription_es;?></textarea>
                                                                        
                            		<label><img src="images/language/en.gif" width="23" height="13"> Descripció Curta (<span id="maxlenght_smalldescription_en">160</span> caràcters)</label> 
									<textarea id="smalldescription_en" name="smalldescription_en" cols="47" rows="40"><?php echo $smalldescription_en;?></textarea>

                            		<label><img src="images/language/fr.gif" width="23" height="13"> Descripció Curta (<span id="maxlenght_smalldescription_fr">160</span> caràcters)</label> 
									<textarea id="smalldescription_fr" name="smalldescription_fr" cols="47" rows="40"><?php echo $smalldescription_fr;?></textarea>

                                    <label>Quan? </label> 
                                    <input type="text" name="info_quan" id="info_quan" class="small" value="<?php echo $info_quan;?>"> 

                                    <label>On? </label> 
                                    <input type="text" name="info_on" id="info_on" class="small" value="<?php echo $info_on;?>"> 

                                    <label>Més Informació </label> 
                                    <input type="text" name="info_more" id="info_more" class="small" value="<?php echo $info_more;?>">
									
                                    <label>Google Maps Latitud</label> 
                                    <input type="text" name="gmap_lat" id="gmap_lat" class="small" value="<?php echo $gmap_lat;?>">

                                    <label>Google Maps Longitud</label>
                                    <input type="text" name="gmap_lng" id="gmap_lng" class="small" value="<?php echo $gmap_lng;?>">

                                    <label>Provincia</label>
                                    <div class="input_group">
                                        <select name="pvid" id="pvid" dir="ltr">
                                            <option value="0">- Seleccioni Provincia -</option>
<?php
/*$rs_query = mysqli_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
while($rs = mysqli_fetch_array($rs_query)){*/
    $db->orderBy('title','ASC');
    $rs_query=$db->get('provincies',null,'pvid, title');
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
    /*$rs_query = mysqli_query("SELECT comid, pvid, title FROM comarques WHERE comid = ". $comid." ORDER BY title ASC");
    while($rs = mysqli_fetch_array($rs_query)){*/
    $db->orderBy('title','ASC');
    $db->where('comid',$comid);
    $rs_query=$db->get('comarques',null,'comid, pvid, title');
    foreach($rs_query as $rs){
?>
    <option value="<?php echo $rs['comid']?>" <?php if($comid==$rs['comid']) echo "selected='selected'";?>><?php echo $rs['title']?></option>		
<?php
    }
}
?>
                                        </select>
                                  	</div>
             
                                    <label>Tipus Recurs Turístic</label>
                                    <div class="input_group">
                                        <select name="idtipusrecurso" id="idtipusrecurso" dir="ltr">
<?php
    /*$rs_query = mysqli_query("SELECT idtipusrecurso, title_ca FROM recursos_tipus ORDER BY title_ca ASC");
    while($rs = mysqli_fetch_array($rs_query)){*/
    $db->orderBy('title_ca','ASC');
    $rs_query=$db->get('recursos_tipus',null,'idtipusrecurso, title_ca');
    foreach($rs_query as $rs){
?>
    <option value="<?php echo $rs['idtipusrecurso']?>" <?php if($idtipusrecurso==$rs['idtipusrecurso']) echo "selected='selected'";?>><?php echo $rs['title_ca']?></option>		
<?php
    }
?>
                                        </select>
                                    </div>

                                    <label>URL externa</label>
                                    <input type="text" name="external_url" id="external_url" class="small" maxlength="255" value="<?php echo $external_url;?>">

                                    <label>Publicat</label>
                                    <div class="input_group">
                                        <input name="published" id="published" type="radio" value="1" <?php if ($published==1) echo "checked" ?>>Si
                                        <input name="published" id="published" type="radio" value="0"  <?php if ($published==0) echo "checked" ?>>No
                                    </div> 
								</div>
                            </ul>
						</div>
                        
                        <!-- DESCRIPCIÓ -->
                        <div id="tabs-2" class="block">
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="description_ca" name="description_ca" style="width:100%; height:300px" cols="50"><?php echo $description_ca;?></textarea>
                                </div>	
                            </div>		
                                                    
                        	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="description_es" name="description_es" style="width:100%; height:300px"><?php echo $description_es;?></textarea>
                                	</div>
                                </div>	
                            </div>	
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="description_en" name="description_en" style="width:100%; height:300px"><?php echo $description_en;?></textarea>
                                </div>	
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="description_fr" name="description_fr" style="width:100%; height:300px"><?php echo $description_fr;?></textarea>
                                </div>	
                            </div>		
						</div>

                        <!-- QUE VER -->
                        <div id="tabs-3" class="block">
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="quever_ca" name="quever_ca" style="width:100%; height:300px" cols="50"><?php echo $quever_ca;?></textarea>
                                </div>	
                            </div>		
                                                    
                        	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="quever_es" name="quever_es" style="width:100%; height:300px"><?php echo $quever_es;?></textarea>
                                	</div>
                                </div>	
                            </div>	
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="quever_en" name="quever_en" style="width:100%; height:300px"><?php echo $quever_en;?></textarea>
                                </div>	
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="quever_fr" name="quever_fr" style="width:100%; height:300px"><?php echo $quever_fr;?></textarea>
                                </div>	
                            </div>		
						</div>


                        <!-- INFORMACION PRACTICA -->
                        <div id="tabs-4" class="block">
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="infopract_ca" name="infopract_ca" style="width:100%; height:300px" cols="50"><?php echo $infopract_ca;?></textarea>
                                </div>	
                            </div>		
                                                    
                        	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="infopract_es" name="infopract_es" style="width:100%; height:300px"><?php echo $infopract_es;?></textarea>
                                	</div>
                                </div>	
                            </div>	
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="infopract_en" name="infopract_en" style="width:100%; height:300px"><?php echo $infopract_en;?></textarea>
                                </div>	
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="infopract_fr" name="infopract_fr" style="width:100%; height:300px"><?php echo $infopract_fr;?></textarea>
                                </div>	
                            </div>		
						</div>

                        
                        <!-- SEO -->
						<div id="tabs-5" class="block no_padding">
							<ul class="full_width">
                            	<div class="block">   
                                	<!--                                                               
                                    <label>Titol (Ex. la-patum-de-berga)</label> 
                                    <input type="text" name="seotitle" id="seotitle" class="small" value="<?php echo $seotitle;?>">
                                    -->
                                     
                            		<label><img src="images/language/ca.gif" width="23" height="13"> Paraules Clau (separades per comes)</label> 
									<textarea id="seowords_ca" name="seowords_ca" cols="47" rows="40"><?php echo $seowords_ca;?></textarea>       
                                    
                            		<label><img src="images/language/es.gif" width="23" height="13"> Paraules Clau (separades per comes)</label> 
									<textarea id="seowords_es" name="seowords_es" cols="47" rows="40"><?php echo $seowords_es;?></textarea>         
                                   
                            		<label><img src="images/language/en.gif" width="23" height="13"> Paraules Clau (separades per comes)</label> 
									<textarea id="seowords_en" name="seowords_en" cols="47" rows="40"><?php echo $seowords_en;?></textarea>                                                                                                              

                            		<label><img src="images/language/fr.gif" width="23" height="13"> Paraules Clau (separades per comes)</label> 
									<textarea id="seowords_fr" name="seowords_fr" cols="47" rows="40"><?php echo $seowords_fr;?></textarea>                                                                                                              

								</div>
                            </ul>
						</div>                        

                        <!-- IMATGES -->
						<div id="tabs-6" class="block no_padding">
							<ul class="full_width">
                            	<div class="block">   
                                    <label>Imatge Petita</label>
                                    <em>Mida 500 x 298px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                    <input type="file" name="arxiu_image" id="arxiu_image" size="30" class="button">
                                    
                                    <?php if($image!=""){ ?>
                                    <br />
                                    <img src="<?php echo URL_BASE . FILE_DIR . "recursos/" . $image;?>" width="250" vspace="5" hspace="5" align="absmiddle"><br />
                                    <?php echo $image; ?>	
                                    <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                    <?php } ?>

                                    <br><br><br /><br />

                                    <label>Imatge Capçalera 1</label>
                                    <em>Mida 1200 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                    <input type="file" name="headimage1" id="headimage1" size="30" class="button">
                                    
                                    <?php if($headimage1!=""){ ?>
                                    <br />
                                    <img src="<?php echo URL_BASE . FILE_DIR . "recursos/" . $headimage1;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                    <?php echo $headimage1; ?>	
                                    <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                    <?php } ?>

                                    <br><br><br /><br />

                                    <label>Imatge Capçalera 2</label>
                                    <em>Mida 1200 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                    <input type="file" name="headimage2" id="headimage2" size="30" class="button">
                                    
                                    <?php if($headimage2!=""){ ?>
                                    <br />
                                    <img src="<?php echo URL_BASE . FILE_DIR . "recursos/" . $headimage2;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                    <?php echo $headimage2; ?>	
                                    <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                    <?php } ?>

                                    <br><br><br /><br />

                                    <label>Imatge Capçalera 3</label>
                                    <em>Mida 1200 x 391px i en JPG<br>Nom de l'arxiu sense accents ni caràcters extranys</em><br><br>
                                    <input type="file" name="headimage3" id="headimage3" size="30" class="button">
                                    
                                    <?php if($headimage3!=""){ ?>
                                    <br />
                                    <img src="<?php echo URL_BASE . FILE_DIR . "recursos/" . $headimage3;?>" width="350" vspace="5" hspace="5" align="absmiddle"><br />
                                    <?php echo $headimage3; ?>	
                                    <!--<input type="checkbox" name="image_del" value="1">&nbsp;Esborrar-->
                                    <?php } ?>

								</div>
                            </ul>
						</div>                        

                    </div>
				</div>
                </form>
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'recursos.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
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
		elements : "description_es, description_ca, description_en, description_fr, quever_ca, quever_es, quever_en, quever_fr, infopract_ca,infopract_es,infopract_en,infopract_fr",
		plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect",
		theme_advanced_buttons2 : "pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,charmap,emotions,iespell,media,advhr,|,print,|,fullscreen",
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

<script>
	$(document).ready(function() {
	
		var smalldescription_ca = 160;
		var smalldescription_es = 160;
		var smalldescription_en = 160;
		var smalldescription_fr = 160;

	
		$('#smalldescription_ca').keyup(function() {
			var longitud = $(this).val().length;
			var resto = smalldescription_ca - longitud;
			$('#maxlenght_smalldescription_ca').html(resto);
			if(resto <= 0){
				$('#smalldescription_ca').attr("maxlength", 160);
			}
		});

		$('#smalldescription_es').keyup(function() {
			var longitud = $(this).val().length;
			var resto = smalldescription_es - longitud;
			$('#maxlenght_smalldescription_es').html(resto);
			if(resto <= 0){
				$('#smalldescription_es').attr("maxlength", 160);
			}
		});
		
		$('#smalldescription_en').keyup(function() {
			var longitud = $(this).val().length;
			var resto = smalldescription_en - longitud;
			$('#maxlenght_smalldescription_en').html(resto);
			if(resto <= 1){
				$('#smalldescription_en').attr("maxlength", 160);
			}
		});		

		$('#smalldescription_fr').keyup(function() {
			var longitud = $(this).val().length;
			var resto = smalldescription_fr - longitud;
			$('#maxlenght_smalldescription_fr').html(resto);
			if(resto <= 1){
				$('#smalldescription_fr').attr("maxlength", 160);
			}
		});		

	
	});
</script>
        
<?php include 'includes/closing_items.php'?>