<?php 
$id=$_GET["id"];
include 'includes/checkuser.php';
include 'includes/document_head.php';

if ($_SESSION['type_user']=='propietario') {
	if ($_SESSION['eid'] != $id) header('location: index.php');
}

?>
               
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<div class="flat_area grid_16">

<?php

// ---------- Consulta del establecimiento -----------------
if(isset($id)){
	/*$rs_query = mysqli_query("SELECT * FROM establiments WHERE eid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
	$db->where('eid',$id);
	$rs=$db->getOne('establiments','*');

	$title = htmlspecialchars($rs['title']);
	$title_real= htmlspecialchars($rs['title_real']);

	$subtitle_es = htmlspecialchars($rs['subtitle_es']);
	$subtitle_ca = htmlspecialchars($rs['subtitle_ca']);
	$subtitle_en = htmlspecialchars($rs['subtitle_en']);
	$subtitle_fr = htmlspecialchars($rs['subtitle_fr']);
	$description_es = htmlspecialchars($rs['description_es']);
	$description_ca = htmlspecialchars($rs['description_ca']);
	$description_en = htmlspecialchars($rs['description_en']);
	$description_fr = htmlspecialchars($rs['description_fr']);

	$description_small_es = htmlspecialchars($rs['description_small_es']);
	$description_small_ca = htmlspecialchars($rs['description_small_ca']);
	$description_small_en = htmlspecialchars($rs['description_small_en']);	
	$description_small_fr = htmlspecialchars($rs['description_small_fr']);

	$indications_es = htmlspecialchars($rs['indications_es']);
	$indications_ca = htmlspecialchars($rs['indications_ca']);
	$indications_en = htmlspecialchars($rs['indications_en']);	
	$indications_fr = htmlspecialchars($rs['indications_fr']);

	$destacat_es = htmlspecialchars($rs['destacat_es']);
	$destacat_ca = htmlspecialchars($rs['destacat_ca']);
	$destacat_en = htmlspecialchars($rs['destacat_en']);	
	$destacat_fr = htmlspecialchars($rs['destacat_fr']);	
	
	$cond_towels = $rs['cond_towels'];
	$cond_kitchen = $rs['cond_kitchen'];
	$cond_firewood = $rs['cond_firewood'];
	
	$fianza = $rs['fianza'];
	$bedrooms = $rs['bedrooms'];
	$bathrooms = $rs['bathrooms'];

	$videos = $rs['videos'];
	$lid = htmlspecialchars($rs['lid']);
	$published = htmlspecialchars($rs['published']);
	$daysmin = htmlspecialchars($rs['daysmin']);
	$daysant = htmlspecialchars($rs['daysant']);

	$personesAdicionals=htmlspecialchars($rs['allow_extra_persons']);
	$maxPersonesAdicionals=htmlspecialchars($rs['extra_quantity']);
	$preuPersonesAdicionals=htmlspecialchars($rs['extra_price']);

	$establimentcomplert = htmlspecialchars($rs['establimentcomplert']);
	$persons = htmlspecialchars($rs['persons']);	
	$persons_min = htmlspecialchars($rs['persons_min']);	
	$user = htmlspecialchars($rs['user']);
	$userpsw = htmlspecialchars($rs['userpsw']);
	$username = htmlspecialchars($rs['username']);
	$userlocked = htmlspecialchars($rs['userlocked']);
	$ownername = htmlspecialchars($rs['ownername']);
	$email = htmlspecialchars($rs['email']);
	$address = htmlspecialchars($rs['address']);
	$phone = htmlspecialchars($rs['phone']);
	$fax = htmlspecialchars($rs['fax']);
	$gmap_lat = htmlspecialchars($rs['gmap_lat']);
	$gmap_lng = htmlspecialchars($rs['gmap_lng']);
	$home = htmlspecialchars($rs['home']);
	$recommended = htmlspecialchars($rs['recommended']);	
	$checkintime = htmlspecialchars($rs['checkintime']);
	$checkouttime = htmlspecialchars($rs['checkouttime']);
	$checkintimeto = htmlspecialchars($rs['checkintimeto']);
	$checkouttimeto = htmlspecialchars($rs['checkouttimeto']);
    $checkouttime_weeks = htmlspecialchars($rs['checkouttime_weeks']);

	$seotitle = htmlspecialchars($rs['seotitle']);	
	$seowords = htmlspecialchars($rs['seowords']);
	$seodescription = htmlspecialchars($rs['seodescription']);
	$hits = htmlspecialchars($rs['hits']);
	$dateadded = htmlspecialchars($rs['dateadded']);
	$datelastvisit = htmlspecialchars($rs['datelastvisit']);
	$tid = htmlspecialchars($rs['tid']);
	$terms_es = htmlspecialchars($rs['terms_es']);
	$terms_ca = htmlspecialchars($rs['terms_ca']);
	$terms_en = htmlspecialchars($rs['terms_en']);
	$terms_fr = htmlspecialchars($rs['terms_fr']);

	$reserva_inmediata = htmlspecialchars($rs['reserva_inmediata']);
	$senyal = htmlspecialchars($rs['senyal']);
	$invoice_rao = htmlspecialchars($rs['invoice_rao']);
	$invoice_NIF = htmlspecialchars($rs['invoice_NIF']);
	$invoice_address = htmlspecialchars($rs['invoice_address']);
	$invoice_cp = htmlspecialchars($rs['invoice_cp']);
	$invoice_poblacio = htmlspecialchars($rs['invoice_poblacio']);
	$invoice_provincia = htmlspecialchars($rs['invoice_provincia']);
	$invoice_email = htmlspecialchars($rs['invoice_email']);
	$invoice_send_address = htmlspecialchars($rs['invoice_send_address']);
	$invoice_send_cp = htmlspecialchars($rs['invoice_send_cp']);
	$invoice_send_poblacio = htmlspecialchars($rs['invoice_send_poblacio']);
	$invoice_send_provincia = htmlspecialchars($rs['invoice_send_provincia']);
	$invoice_send_email = htmlspecialchars($rs['invoice_send_email']);

	$registro_turismo = htmlspecialchars($rs['registro_turismo']);
	$external_ical = htmlspecialchars($rs['external_ical']);

	?><h2>Editar Establiment - <?php echo $title;?></h2><?php

}else{
	$title = "";
	$subtitle_es = "";
	$subtitle_ca = "";
	$subtitle_en = "";
	$subtitle_fr = "";
	
	$description_es = "";
	$description_ca = "";
	$description_en = "";
	$description_fr = "";

	$description_small_es = "";
	$description_small_ca = "";
	$description_small_en = "";		
	$description_small_fr = "";	

	$indications_es = "";
	$indications_ca = "";
	$indications_en = "";		
	$indications_fr = "";	

	$destacat_es = "";
	$destacat_ca = "";
	$destacat_en = "";	
	$destacat_fr = "";	

	$cond_towels = 1;
	$cond_kitchen = 1;
	$cond_firewood = 1;

	$fianza = "";
	$bedrooms = "";
	$bathrooms = "";
	
	$videos = "";		
	$lid = "";
	$published = 1;
	$daysmin = 1;
	$daysant = 1;
	$establimentcomplert = 0;
	$persons = 0;	
	$user = "";
	$userpsw = "";
	$username = "";
	$userlocked = 0;
	$ownername = "";
	$email = "";
	$address = "";
	$phone = "";
	$fax = "";
	$gmap_lat = "";
	$gmap_lng = "";
	$home = 0;
	$recommended = 0;
	$checkintime = "flexible";
	$checkouttime = "flexible";
	$checkintimeto = "flexible";
	$checkouttimeto = "flexible";
    $checkouttime_weeks	 = "flexible";
	$seotitle = "";
	$seowords = "";
	$seodescription = "";
	$hits = "";
	$dateadded = "";
	$datelastvisit = "";
	$tid = "";
	$terms_es = "";
	$terms_ca = "";
	$terms_en = "";
	$terms_fr = "";
	
	$invoice_rao = "";
	$invoice_NIF = "";
	$invoice_address = "";
	$invoice_cp = "";
	$invoice_poblacio = "";
	$invoice_provincia = "";
	$invoice_email = "";
	$invoice_send_address = "";
	$invoice_send_cp = "";
	$invoice_send_poblacio = "";
	$invoice_send_provincia = "";
	$invoice_send_email = "";

	$registro_turismo = "";
	$external_ical = "";

	?>
    <h2>Nou Establiment</h2>
	<p>Administrar Establiments</p>
	<?php
}
?>    
				</div>
                
                <div id="dialog" title="ERROR" style="display:none"><p>Has de revisar els camps marcats en vermell.</p></div>

				<form id="establiments_form" action="establiments_act.php" method="post">               
                <div class="box grid_16 tabs">
					<ul class="tab_header grad_colour clearfix">
						<li><a href="#tabs-1">Usuari</a></li>
						<li><a href="#tabs-2">Establiment</a></li>
                        <li><a href="#tabs-3">Descripció</a></li>
                        <li><a href="#tabs-4">El propietari destaca</a></li>
                        <li><a href="#tabs-5">Termes i condicions</a></li>
                        <li><a href="#tabs-6">Videos</a></li>
                        <li <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>><a href="#tabs-7">Perfils i Serveis</a></li>
                        <li><a href="#tabs-8">Pagament</a></li>
                        <li><a href="#tabs-9">Dades de Facturació</a></li>
                        <li <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>><a href="#tabs-10">SEO</a></li>
                        <li><a href="#tabs-11">Establiment Complert</a></li>                        
					</ul>
                    
					<div class="toggle_container">
                    	<input type="hidden" name="id" value="<?php echo $id;?>">
                		<input type="hidden" name="action" value="process">
                        
                        <!-- USUARI -->
						<div id="tabs-1" class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <label <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>Usuari</label> 
                                    <input name="user" id="user" type="text" class="small required" autofocus value="<?php echo $user; ?>" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>> 
                                                       
                                    <label <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>Clau d'Accés</label> 
                                    <input name="userpsw" id="userpsw" type="text" class="small required" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
                                    
                                    <label <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>Repetir Clau d'Accés</label> 
                                    <input name="userpsw2" id="userpsw2" type="text" class="small required" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
                                                                        
                                    <label>Nom y Cognom de l'usuari</label> 
                                    <input name="username" id="username" type="text" class="small required" value="<?php echo $username; ?>"> 
                    
                                    <label <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>Bloquejar Usuari</label>
                                    <div class="input_group" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
                                        <input name="userlocked" id="userlocked" type="radio" value="1" <?php if ($userlocked==1) echo "checked"; ?>>Si
                                        <input name="userlocked" id="userlocked" type="radio"  value="0"  <?php if ($userlocked==0) echo "checked"; ?>>No
                                    </div>
                                    
                                    <?php if(isset($id)){ ?>
                                        <label>Data de Registre</label> 
                                        <p><?php echo $dateadded; ?></p>                                        
        
                                        <label>Data de l'ùltima visita</label>
                                        <p><p><?php echo $datelastvisit; ?></p> 
                                    <?php } ?>
								</div>
                            </ul>
						</div>
                        
                        <!--ESTABLIMENT-->
						<div id="tabs-2" class="block no_padding">
							<div class="content">
                            	<div class="block">
                            		
                                    <label>Nom de l'establiment</label> 
                                    <input name="title" id="title" title="Nom de l'establiment" type="text" class="small required" autofocus value="<?php echo $title; ?>">
                                
                                    <label>Nom real</label> 
                                    <input name="title_real" id="title_real" title="Nom de l'establiment real" type="text" class="small required" autofocus value="<?php echo $title_real; ?>">
	                                          

                                    <label>Titol de l'establiment (Sortirà a la web publica)</label> 
                                    <img src="images/language/es.gif" width="23" height="13"> <input name="subtitle_es" id="subtitle_es" title="Titol de l'establiment que sortirà als llistats y la fitxa" type="text" class="small required" style="display:inline" autofocus value="<?php echo $subtitle_es;?>"><br />                
                                    <img src="images/language/ca.gif" width="23" height="13"> <input name="subtitle_ca" id="subtitle_ca" title="Titol de l'establiment que sortirà als llistats y la fitxa" type="text" class="small required" style="display:inline" autofocus value="<?php echo $subtitle_ca; ?>"><br />                      
                                    <img src="images/language/en.gif" width="23" height="13"> <input name="subtitle_en" id="subtitle_en" title="Titol de l'establiment que sortirà als llistats y la fitxa" type="text" class="small required" style="display:inline" autofocus value="<?php echo $subtitle_en; ?>"><br />                     
                                    <img src="images/language/fr.gif" width="23" height="13"> <input name="subtitle_fr" id="subtitle_fr" title="Titol de l'establiment que sortirà als llistats y la fitxa" type="text" class="small required" style="display:inline" autofocus value="<?php echo $subtitle_fr;?>"><br />                     

                    
                                    <label>Localitat</label>
                                    <div class="input_group">
                                        <select name="lid" id="lid" dir="ltr">
                                            <option value="0">- Seleccioni Localitat -</option>
<?php
//$rs_query = mysqli_query("SELECT lid, title FROM localitats ORDER BY title ASC");
//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy('title','ASC');
	$rs_result=$db->get('localitats',null,'lid, title');
	foreach($rs_result as $rs){
?>    
                                            <option value="<?php echo $rs['lid']?>" <?php if($lid==$rs['lid']) echo "selected='selected'";?>> <?php echo $rs['title']?></option>
<?php
}
?>
                                        </select>
                                    </div>  
                                                                          
                                    <label>Tipus d'establiment</label> 
                                    <div class="input_group">
                                        <select name="tid" id="tid" dir="ltr">
                                            <option value="0">- Seleccioni Tipus -</option>
<?php
/*$rs_query = mysqli_query("SELECT tid, title_ca FROM tipus ORDER BY title_ca ASC");
while($rs = mysqli_fetch_array($rs_query)){*/
$db->orderBy('title_ca','ASC');
$rs_query=$db->get('tipus',null,'tid, title_ca');
foreach($rs_query as $rs){
?>    
                                            <option value="<?php echo $rs['tid']?>" <?php if($tid==$rs['tid']) echo "selected='selected'";?>> <?php echo $rs['title_ca']?></option>
<?php
}
?>
                                        </select>
                                    </div> 

                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">
                                        <label>Total Habitacions</label> 
                                        <select name="bedrooms" id="bedrooms">
                                        <?php
										for($i = 0; $i <= 20; $i++):
                                            echo "<option value='".$i."' ".OptionIsSelected ($bedrooms,$i).">".$i."</option>";
										endfor;
										?>    
                                        </select>
                                        
                                        </div>
                                    </div>
                                
                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">
                                        <label>Banys</label>
                                        <select name="bathrooms" id="bathrooms">
                                        <?php
										for($i = 0; $i <= 20; $i++):
                                            echo "<option value='".$i."' ".OptionIsSelected ($bathrooms,$i).">".$i."</option>";
										endfor;
										?>    
                                        </select>
                                        </div>
                                    </div>

									<div style="clear:both"></div>

                                    <label>Email</label> 
                                    <input name="email" id="email" title="Email" type="text" class="small required" value="<?php echo $email; ?>"> 
                                                                                                                
                                    <label>Propietari</label> 
                                    <input name="ownername" id="ownername" title="Nom i Cognoms del Propietari" type="text" class="small required" value="<?php echo $ownername;?>"> 

                                    <label>Direcció</label> 
                                    <input name="address" id="address" title="Direcció" type="text" class="small required" value="<?php echo $address; ?>"> 

                                    <label>Telèfon</label> 
                                    <input name="phone" id="phone" title="Telèfon" type="text" class="small required" value="<?php echo $phone; ?>"> 

                                    <label>Fax</label> 
                                    <input name="fax" id="fax" title="Fax" type="text" class="small required" value="<?php echo $fax; ?>"> 
                                    
                                    <label>Google Maps - Latitud</label> 
                                    <input name="gmap_lat" id="gmap_lat" title="Coordenades de Google Maps - Latitud" type="text" class="small required" value="<?php echo $gmap_lat; ?>"> 
                                    
                                    <label>Google Maps - Longitud</label> 
                                    <input name="gmap_lng" id="gmap_lng" title="Coordenades de Google Maps - Longitud" type="text" class="small required" value="<?php echo $gmap_lng; ?>">                                     
								                    
                                    <label <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>Publicat</label>
                                    <div class="input_group" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
                                        <input name="published" id="published" type="radio" value="1" <?php if ($published==1) echo "checked" ?>>Si
                                        &nbsp;&nbsp;
                                        <input name="published" id="published" type="radio" value="0"  <?php if ($published==0) echo "checked" ?>>No
                                    </div> 

                                    <div class="grid_2" style='margin:0; <?php if ($_SESSION['type_user']=='propietario') { echo "display:none"; } ?>'>
                                        <div class="input_group">
                                        	<label>Publicat a la Home</label> 
                                            <div class="input_group">
                                                <input name="home" id="home" type="radio" value="1" <?php if ($home==1) echo "checked" ?>>Si
                                                &nbsp;&nbsp;
                                                <input name="home" id="home" type="radio" value="0"  <?php if ($home==0) echo "checked" ?>>No
                                            </div>   
                                        </div>
                                    </div>
                                

                                    <div class="grid_2" style='margin:0; <?php if ($_SESSION['type_user']=='propietario') { echo "display:none"; } ?>'>
                                        <div class="input_group">
                                        	<label>Recomanat</label> 
                                            <div class="input_group">
                                                <input name="recommended" id="recommended" type="radio" value="1" <?php if ($recommended==1) echo "checked" ?>>Si
                                                &nbsp;&nbsp;
                                                <input name="recommended" id="recommended" type="radio" value="0"  <?php if ($recommended==0) echo "checked" ?>>No
                                            </div>   
                                        </div>
                                    </div>

									<label>Registre Turisme</label>
									<input name="registro_turismo" id="registro_turismo" title="Registre Turisme" type="text" class="small required" value="<?php echo $registro_turismo; ?>">


								</div>
                            </div>
						</div>
                        
                        <!-- DESCRIPCIÓ -->
                        <div id="tabs-3" class="block">
                        	<div <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
                                <p>Petita descripció de l'establiment</p>
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                                    <div class="toggle_container">
                                        <div class="block no_padding">
                                        <textarea id="description_small_es" name="description_small_es" style="width:100%"><?php echo $description_small_es;?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                                    <div class="toggle_container">
                                        <textarea id="description_small_ca" name="description_small_ca" style="width:100%"><?php echo $description_small_ca;?></textarea>
                                    </div>
                                </div>
                                
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                                    <div class="toggle_container">
                                        <textarea id="description_small_en" name="description_small_en" style="width:100%"><?php echo $description_small_en;?></textarea>
                                    </div>
                                </div>	                        

                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                                    <div class="toggle_container">
                                        <textarea id="description_small_fr" name="description_small_fr" style="width:100%"><?php echo $description_small_fr;?></textarea>
                                    </div>
                                </div>	                        

                                <br />
                            </div>
                    	<p>Aquesta informació sortirà a la fitxa a sota de la referència de l'establiment</p>
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
                            <p>Indicacions per arribar a la casa</p>
                    	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="indications_es" name="indications_es" style="width:100%"><?php echo $indications_es;?></textarea>
                                	</div>
                                </div>
                            </div>
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="indications_ca" name="indications_ca" style="width:100%"><?php echo $indications_ca;?></textarea>
                                </div>
                            </div>
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="indications_en" name="indications_en" style="width:100%"><?php echo $indications_en;?></textarea>
                                </div>
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="indications_fr" name="indications_fr" style="width:100%"><?php echo $indications_fr;?></textarea>
                                </div>
                            </div>		

						</div>
					

                        <!-- EL PROPIETARI DESTACA -->
                        <div id="tabs-4" class="block">
                        	<div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                            	<div class="toggle_container">
                                	<div class="block no_padding">
									<textarea id="destacat_es" name="destacat_es" style="width:100%"><?php echo $destacat_es;?></textarea>
                                	</div>
                                </div>	
                            </div>	
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                            	<div class="toggle_container">
									<textarea id="destacat_ca" name="destacat_ca" style="width:100%"><?php echo $destacat_ca;?></textarea>
                                </div>
                            </div>		
                            
                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                            	<div class="toggle_container">
									<textarea id="destacat_en" name="destacat_en" style="width:100%"><?php echo $destacat_en;?></textarea>
                                </div>
                            </div>		

                            <div class="box round_all">
                            	<h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                            	<div class="toggle_container">
									<textarea id="destacat_fr" name="destacat_fr" style="width:100%"><?php echo $destacat_fr;?></textarea>
                                </div>
                            </div>		

						</div>
                        
                        <!-- TERMES I CONDICIONS -->
						<div id="tabs-5" class="block">
							<div class="content">
                                <h2>Equipacions incloses</h2>
                                <input name="cond_towels" id="cond_towels" type="checkbox" value="<?php echo $cond_towels;?>" <?php if ($cond_towels==1) echo "checked";?>>Juegos de cama y toallas incluidas<br>
                                <input name="cond_kitchen" id="cond_kitchen" type="checkbox" value="<?php echo $cond_kitchen;?>" <?php if ($cond_kitchen==1) echo "checked";?>>Utensilios de cocina incluidos<br>
                                <input name="cond_firewood" id="cond_firewood" type="checkbox" value="<?php echo $cond_firewood;?>" <?php if ($cond_firewood==1) echo "checked";?>>Equipada con leña<br>
								<br /><br />

                                <h2>Horaris</h2>
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Hora d'entrada (desde)</label> 
                                    <select name="checkintime" id="checkintime">
                                    	<option value="flexible" <?php if ($checkintime=='flexible') echo 'selected="selected"'; ?>>Flexible</option>
                                        <?php 
                                        for($i = 0; $i <= 23; $i++):
                                            if ($i<=9) $num=0; else $num="";
                                            $hour = $num.$i.":00";
                                        ?>
                                        <option value="<?php echo $hour; ?>" <?php if ($checkintime==$hour) echo 'selected="selected"'; ?>><?php echo $hour; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>
                            
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Hora d'entrada (fins)</label> 
                                    <select name="checkintimeto" id="checkintimeto">
                                    	<option value="flexible" <?php if ($checkintimeto=='flexible') echo 'selected="selected"'; ?>>Flexible</option>
                                        <?php 
                                        for($i = 0; $i <= 23; $i++):
                                            if ($i<=9) $num=0; else $num="";
                                            $hour = $num.$i.":00";
                                        ?>
                                        <option value="<?php echo $hour; ?>" <?php if ($checkintimeto==$hour) echo 'selected="selected"'; ?>><?php echo $hour; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Hora de Sortida (desde)</label> 
                                    <select name="checkouttime" id="checkouttime">
                                    	<option value="flexible" <?php if ($checkouttime=='flexible') echo 'selected="selected"'; ?>>Flexible</option>
                                        <?php 
                                        for($i = 0; $i <= 23; $i++):
                                            if ($i<=9) $num=0; else $num="";
                                            $hour = $num.$i.":00";
                                        ?>
                                        <option value="<?php echo $hour; ?>" <?php if ($checkouttime==$hour) echo 'selected="selected"'; ?>><?php echo $hour; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>
                            
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Hora de Sortida (fins)</label> 
                                    <select name="checkouttimeto" id="checkouttimeto">
                                    	<option value="flexible" <?php if ($checkouttimeto=='flexible') echo 'selected="selected"'; ?>>Flexible</option>
                                        <?php 
                                        for($i = 0; $i <= 23; $i++):
                                            if ($i<=9) $num=0; else $num="";
                                            $hour = $num.$i.":00";
                                        ?>
                                        <option value="<?php echo $hour; ?>" <?php if ($checkouttimeto==$hour) echo 'selected="selected"'; ?>><?php echo $hour; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
                                    <label>Sortida (setmanes)</label>
                                    <select name="checkouttime_weeks" id="checkouttime_weeks">
                                    	<option value="flexible" <?php if ($checkouttime_weeks=='flexible') echo 'selected="selected"'; ?>>Flexible</option>
                                        <?php
                                        for($i = 0; $i <= 23; $i++):
                                            if ($i<=9) $num=0; else $num="";
                                            $hour = $num.$i.":00";
                                        ?>
                                        <option value="<?php echo $hour; ?>" <?php if ($checkouttime_weeks==$hour) echo 'selected="selected"'; ?>><?php echo $hour; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>


								<div style="clear:both"></div>
                                <br />
                                <h2>Fiança</h2>
                                <p>Si no n'hi ha, deixeu en blanc</p>
                                <input name="fianza" id="fianza"  type="text" class="small" placeholder="100" value="<?php echo $fianza; ?>"> 
                                <br /><br />

                                <h2>Altres condicions</h2>
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/es.gif" width="23" height="13"> Castellà</h2>
                                    <div class="toggle_container">
                                        <textarea id="terms_es" name="terms_es" style="width:100%"><?php echo $terms_es;?></textarea>
                                    </div>	
                                </div>	
                                
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/ca.gif" width="23" height="13"> Català</h2>
                                    <div class="toggle_container">
                                        <textarea id="terms_ca" name="terms_ca" style="width:100%"><?php echo $terms_ca;?></textarea>
                                    </div>	
                                </div>		
                                
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/en.gif" width="23" height="13"> Anglès</h2>
                                    <div class="toggle_container">
                                        <textarea id="terms_en" name="terms_en" style="width:100%"><?php echo $terms_en;?></textarea>
                                    </div>	
                                </div>
                                
                                <div class="box round_all">
                                    <h2 class="box_head grad_colour"><img src="images/language/fr.gif" width="23" height="13"> Francés</h2>
                                    <div class="toggle_container">
                                        <textarea id="terms_fr" name="terms_fr" style="width:100%"><?php echo $terms_fr;?></textarea>
                                    </div>	
                                </div>
                            </div>
						</div>
                        
                        <!-- VIDEOS -->
                        <div id="tabs-6" class="block">
                        	<p>
                            	Aqui pots introduir els videos de serveis com Youtube o Vimeo. Funciona introduïnt els <strong>codis "embed" o "iframe"</strong> que proporcionen els serveis.<br><br>
                                Has de tenir en compte lo següent: <br>
                                - Has de personalitzar els videos amb un <strong>ample de 452px</strong> (width)<br>
                                - <strong>Entre video i video</strong> has de ficar el següent codi: <code> &lt;br&gt;&lt;br&gt; </code>
                                <br><br>
                                <strong>Per exemple:</strong><br>
                                <code>
                                    &lt;iframe width="452" height="336" src="http://www.youtube.com/embed/QV7Fl_4jv1M?rel=0" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;<br>
                                    &lt;br&gt;&lt;br&gt;<br>
                                    &lt;iframe width="452" height="259" src="http://www.youtube.com/embed/vD-7Zs3N7C4?rel=0" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;<br>
                                    &lt;br&gt;&lt;br&gt;<br>
                                    &lt;iframe src="http://player.vimeo.com/video/3412273?title=0&amp;byline=0&amp;portrait=0" width="452" height="301" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen&gt;&lt;/iframe&gt;
                            	</code>
                            </p>
							<ul class="full_width">
								<textarea id="videos" name="videos" rows="200" style="width:100%"><?php echo $videos;?></textarea>                                   
                            </ul>
                            
                            <?php if ($videos!="") { ?>
							
                            <h2>Videos</h2>
                            <?php echo $videos;?>
                            
                            <?php } ?>
						</div>                        
                        
                        <!-- PERFILS I SERVEIS -->
                        <div id="tabs-7" class="block" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
							<div class="content">
                                <h2>Perfils</h2>
                                <div class="grid_2" style="margin:0">
                                    <div class="input_group">
<?php
//$rs_query = mysqli_query("SELECT perid, title_ca FROM perfils ORDER BY title_ca ASC");
$db->orderBy('title_ca','ASC');
$rs_result=$db->get('perfils',null,'perid, title_ca');
$fila = 1;
//while($rs = mysqli_fetch_array($rs_query)){
	foreach($rs_result as $rs){ 
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
    <input name="perid[]" id="perid[]" type="checkbox" value="<?php echo $rs['perid'];?>"  <?php if(isset($id)) echo GetSelectedCheckBoxPerfils($id, $rs['perid']);?>><?php echo $rs['title_ca'];?><br>
    
<?php
    $fila++;
}
?>
                                    </div>  
                                </div> 
                                <label></label>
                            	<h2>Serveis</h2>
                                <div class="grid_2" style="margin:0">
                                	<div class="input_group">
<?php
	//$rs_query = mysqli_query("SELECT serid, title_ca FROM serveis ORDER BY title_ca ASC");
	$db->orderBy('title_ca','ASC');
	$rs_result=$db->get('serveis',null,'serid, title_ca');
	$fila = 1;
	//while($rs = mysqli_fetch_array($rs_query)){
	foreach($rs_result as $rs){
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
		<input name="serid[]" id="serid[]" type="checkbox" value="<?php echo $rs['serid'];?>" <?php if(isset($id)) echo GetSelectedCheckBoxServeis($id, $rs['serid']);?>><?php echo $rs['title_ca'];?><br>
        
<?php
		$fila++;
	}
?>
                                    </div>  
                            	</div>

                                <label></label>
                            	<h2>Serveis exteriors compartits</h2>
                                <div class="grid_2" style="margin:0">
                                	<div class="input_group">
<?php
	//$rs_query = mysqli_query("SELECT serid, title_ca FROM serveis WHERE ext=1 ORDER BY title_ca ASC");
	$db->orderBy('title_ca','ASC');
	$db->where('ext','1');
	$rs_query=$db->get('serveis',null,'serid, title_ca');
	$fila = 1;
	//while($rs = mysqli_fetch_array($rs_query)){
	foreach($rs_query as $rs){
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
		<input name="serextid[]" id="serextid[]" type="checkbox" value="<?php echo $rs['serid'];?>" <?php if(isset($id)) echo GetSelectedCheckBoxServeisExt($id, $rs['serid']);?>><?php echo $rs['title_ca'];?><br>
        
<?php
		$fila++;
	}
?>
                                    </div>  
                            	</div>

                            </div>
						</div>                                                    
                        
                        <!-- PAGAMENT -->
						<div id="tabs-8" class="block no_padding">
							<ul class="full_width">
								
                            	<div class="block">
                            		<div class="grid_3" style="margin:0">
	                                        <div class="input_group">
		                                        <label>Reserva inmediata</label>
		                                        <div class="input_group">
		                                        	<input name="reserva_inmediata" id="reserva_inmediata" type="radio" value="1" <?php if ($reserva_inmediata==1) echo "checked"; ?>>Si
		                                       		&nbsp;&nbsp;
		                                        	<input name="reserva_inmediata" id="reserva_inmediata" type="radio" value="0"  <?php if ($reserva_inmediata==0) echo "checked"; ?>>No
		                                    	</div> 
	                                        </div>
	                                    </div>
                                	<!--<p>Para asegurar la serietat de las reserves, en aquest establiment se puede solicitar a los clientes pagar previamente a través de una de las pasarelas de pago soportadas la totalidad o una parte del importe de la reserva como señal. El importe de dicho pago puede ser un valor absoluto o un porcentaje.</p>-->
                                    <label>Cost de la senyal</label> 
                                    

                                    <div class="input_group">
                                        <select name="senyal" id="senyal">
                                            <option value="15" <?php if ($senyal=='15') echo 'selected="selected"'; ?>>15%</option>
                                            <option value="20" <?php if ($senyal=='20') echo 'selected="selected"'; ?>>20%</option>
                                            <option value="25" <?php if ($senyal=='25') echo 'selected="selected"'; ?>>25%</option>
                                            <option value="30" <?php if ($senyal=='30') echo 'selected="selected"'; ?>>30%</option>
                                            <option value="35" <?php if ($senyal=='35') echo 'selected="selected"'; ?>>35%</option>
                                            <option value="40" <?php if ($senyal=='40') echo 'selected="selected"'; ?>>40%</option>
                                            <option value="45" <?php if ($senyal=='45') echo 'selected="selected"'; ?>>45%</option>
                                            <option value="50" <?php if ($senyal=='50') echo 'selected="selected"'; ?>>50%</option>
                                        </select>
                                    </div>  
								</div>
								
                            </ul>
						</div>  

                        <!--DADES DE FACTURACIO-->
						<div id="tabs-9" class="block no_padding">
							<div class="content">
                            	<div class="block">
                                	<h2>Adreça Fiscal</h2>
                                    
                                    <label>Raó social</label> 
                                    <input name="invoice_rao" id="invoice_rao" type="text" class="small required" autofocus value="<?php echo $invoice_rao; ?>"> 

                                    <label>NIF</label> 
                                    <input name="invoice_NIF" id="invoice_NIF" type="text" class="small required" autofocus value="<?php echo $invoice_NIF;?>">                     
                    
                                    <label>Adreça</label> 
                                    <input name="invoice_address" id="invoice_address" type="text" class="small required" value="<?php echo $invoice_address; ?>"> 
                                                                                                                
                                    <label>Codi Postal</label> 
                                    <input name="invoice_cp" id="invoice_cp" type="text" class="small required" value="<?php echo $invoice_cp; ?>"> 
                                   
                                    <label>Provincia</label>
                                    <div class="input_group">
                                        <select name="invoice_provincia" id="invoice_provincia" dir="ltr">
                                            <option value="0">- Seleccioni Provincia -</option>
<?php
	//$rs_query = mysqli_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy('title','ASC');
	$rs_query=$db->get('provincies',null,'pvid, title ');
	foreach($rs_query as $rs){
?>    
											<option value="<?php echo $rs['pvid']?>" <?php if($invoice_provincia==$rs['pvid']) echo "selected='selected'";?>> <?php echo $rs['title']?> </option>
<?php
	}
?>												
                                        </select>
                                    </div> 

                                    <label>Població</label> 
                                    <input name="invoice_poblacio" id="invoice_poblacio" type="text" class="small required" value="<?php echo $invoice_poblacio; ?>"> 
                                                                       
                                    <label>Email</label> 
                                    <input name="invoice_email" id="invoice_email" type="text" class="small required" value="<?php  echo $invoice_email; ?>">                                                                                                             
									<br>
                                    <h2>Adreça enviament factures</h2>
                                   
                                    <label>Adreça</label> 
                                    <input name="invoice_send_address" id="invoice_send_address" type="" class="small required" value="<?php echo $invoice_send_address; ?>"> 

                                    <label>Codi Postal</label> 
                                    <input name="invoice_send_cp" id="invoice_send_cp" type="" class="small required" value="<?php echo $invoice_send_cp; ?>"> 
                                    
                                    <label>Provincia</label>
                                    <div class="input_group">
                                        <select name="invoice_send_provincia" id="invoice_send_provincia" dir="ltr">
                                            <option value="0">- Seleccioni Provincia -</option>
<?php
	//$rs_query = mysqli_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy('title','ASC');
	$rs_query=$db->get('provincies',null,'pvid, title ');
	foreach($rs_query as $rs){
?>    
											<option value="<?php echo $rs['pvid']?>" <?php if($invoice_send_provincia==$rs['pvid']) echo "selected='selected'";?>> <?php echo $rs['title']?> </option>
<?php
	}
?>												
                                        </select>
                                    </div> 

                                    <label>Població</label>
                                    <input name="invoice_send_poblacio" id="invoice_send_poblacio" type="text" class="small required" value="<?php echo $invoice_send_poblacio; ?>">                                                                          
                                    
                                    <label>Email</label>
                                    <input name="invoice_send_email" id="invoice_send_email" type="text" class="small required" value="<?php echo $invoice_send_email; ?>">                                            
								</div>
                            </div>
						</div>
                        
                        <!-- SEO -->
						<div id="tabs-10" class="block no_padding" <?php if ($_SESSION['type_user']=='propietario') { echo "style='display:none;'"; } ?>>
							<ul class="full_width">
                            	<div class="block">                                                                  
                                    <label>Titol (Ex. casa-la-selva)</label> 
                                    <input type="text" name="seotitle" id="seotitle" class="small" value="<?php echo $seotitle;?>">
                                     
                            		<label>Descripció</label> 
									<textarea id="seodescription" name="seodescription" cols="47" rows="40"><?php echo $seodescription;?></textarea>           
                                                                         
                            		<label>Paraules Clau (separades per comes)</label> 
									<textarea id="seowords" name="seowords" cols="47" rows="40"><?php echo $seowords;?></textarea>                                    
								</div>
                            </ul>
						</div> 
                        
                        <!--ESTABLIMENT COMPLERT-->
						<div id="tabs-11" class="block no_padding">
							<div class="content">
                            	<div class="block">
                                    <label>Establiment Complert</label>
                                    <div class="input_group">
                                        <input name="establimentcomplert" id="establimentcomplert" type="radio" value="1" <?php if ($establimentcomplert==1) echo "checked" ?>>Si
                                        &nbsp;&nbsp;
                                        <input name="establimentcomplert" id="establimentcomplert" type="radio" value="0"  <?php if ($establimentcomplert==0) echo "checked" ?>>No
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
                                    <?php if ($establimentcomplert==1): ?>
	                                    <div class="grid_2" style="margin:0">
	                                        <div class="input_group">
		                                        <label>Persones Addicionals</label>
		                                        <div class="input_group">
		                                        	<input name="personesAdicionals" id="personesAdicionals" type="radio" value="1" <?php if ($personesAdicionals==1) echo "checked"; ?>>Si
		                                       		&nbsp;&nbsp;
		                                        	<input name="personesAdicionals" id="personesAdicionals" type="radio" value="0"  <?php if ($personesAdicionals==0) echo "checked"; ?>>No
		                                    	</div> 
	                                        </div>
	                                    </div>
	                                <?php endif; ?>

                                    <div style="clear:both;"></div>
									
                                                                        
                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">
                                        	<label>Mínim Persones (Adults)</label>
                                            <select name="persons_min" id="persons_min">
                                           <?php
                                                $cont = 1;
                                                while($cont<=30) { // Número máximo de 30 personas
                                                    echo "<option value=\"".$cont."\"";
                                                    if ($persons_min==$cont) echo "selected=\"selected\""; 
                                                    echo ">".$cont."</option>";
                                                    $cont++;	
                                                }
                                            ?>                                      
                                            </select>
                                        </div> 
                                    </div>
                                    
                                    <div class="grid_2" style="margin:0">
                                        <div class="input_group">
                                        	<label>Màxim Persones (Adults)</label>
                                            <select name="persons" id="persons">
                                           <?php
                                                $cont = 1;
                                                while($cont<=30) { // Número máximo de 30 personas
                                                    echo "<option value=\"".$cont."\"";
                                                    if ($persons==$cont) echo "selected=\"selected\""; 
                                                    echo ">".$cont."</option>";
                                                    $cont++;	
                                                }
                                            ?>                                      
                                            </select>
                                        </div> 
                                    </div>
                                    
                                    <?php if ($establimentcomplert==1): ?>
                                    	<div class="grid_2" style="margin:0">
		                                    <div class="input_group">
		                                        <label>Màxim Persones Addicionals</label>
		                                        <select name="MaxPersonesAdicionals" id="MaxPersonesAdicionals">
		                                            <option value="0" <?php echo OptionIsSelected ($maxPersonesAdicionals,1); ?>>0</option>
		                                            <option value="1" <?php echo OptionIsSelected ($maxPersonesAdicionals,1); ?>>1</option>
		                                            <option value="2" <?php echo OptionIsSelected ($maxPersonesAdicionals,2); ?>>2</option>
		                                            <option value="3" <?php echo OptionIsSelected ($maxPersonesAdicionals,3); ?>>3</option>
		                                            <option value="4" <?php echo OptionIsSelected ($maxPersonesAdicionals,4); ?>>4</option>
		                                            <option value="5" <?php echo OptionIsSelected ($maxPersonesAdicionals,5); ?>>5</option>
		                                            <option value="6" <?php echo OptionIsSelected ($maxPersonesAdicionals,6); ?>>6</option>
		                                            <option value="7" <?php echo OptionIsSelected ($maxPersonesAdicionals,7); ?>>7</option>
		                                            <option value="8" <?php echo OptionIsSelected ($maxPersonesAdicionals,8); ?>>8</option>
		                                            <option value="9" <?php echo OptionIsSelected ($maxPersonesAdicionals,9); ?>>9</option>
		                                            <option value="10" <?php echo OptionIsSelected ($maxPersonesAdicionals,10); ?>>10</option>
		                                            <option value="11" <?php echo OptionIsSelected ($maxPersonesAdicionals,11); ?>>11</option>
		                                            <option value="12" <?php echo OptionIsSelected ($maxPersonesAdicionals,12); ?>>12</option>
		                                            <option value="13" <?php echo OptionIsSelected ($maxPersonesAdicionals,13); ?>>13</option>
		                                            <option value="14" <?php echo OptionIsSelected ($maxPersonesAdicionals,14); ?>>14</option>
		                                        </select>
	                                        </div>
                                        </div>

                                        <div class="grid_2" style="margin:0">
		                                    <div class="input_group">
		                                        <label>Preu persona addicional</label>
		                                        <input type="text"  name="preuPersonAdicional" id="preuPersonAdicional" value="<?php echo $preuPersonesAdicionals; ?>">
	                                        </div>
                                        </div>
	                                <?php endif; ?>
	                                
                                    <div style="clear:both;"></div>

									<label>iCal URL</label>
									<div class="input_group">
										<input class="small required" name="external_ical" id="external_ical" type="text" size="255" maxlength="512" value="<?php if (!empty($external_ical)) echo $external_ical ?>" >
									</div>
								</div>
                            </div>
						</div>                        
                        
                    </div>
				</div>
                </form>
                
				<div class="flat_area grid_16">
                    <p>
                    	<?php
						if ($_SESSION['type_user']=='superadmin') { ?>
                        	<button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'establiments.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>                        
                        <?php
						}
						?>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.establiments_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
                    </p>
                </div>    
            </div>
		</div>

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "description_es, description_ca, description_en, description_fr, destacat_es, destacat_ca, destacat_en, destacat_fr, terms_es, terms_ca, terms_en, terms_fr",
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
		/*
		theme : "advanced",
		mode : "exact",
		elements : "description_es, description_ca, description_en, destacat_es, destacat_ca, destacat_en, terms_es, terms_ca, terms_en",
		theme_advanced_layout_manager : "SimpleLayout",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough"
		*/
	});
</script>
        
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
	var user = new LiveValidation('user' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	user.add( Validate.Presence );
	
	var username = new LiveValidation('username' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	username.add( Validate.Presence );
	
	var title = new LiveValidation('title' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	title.add( Validate.Presence );

	var email = new LiveValidation('email' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	email.add( Validate.Presence );
	email.add( Validate.Email, { failureMessage: "Email incorrecte!" } );
	
	var ownername = new LiveValidation('ownername' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	ownername.add( Validate.Presence );	

	var address = new LiveValidation('address' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	address.add( Validate.Presence );			

	var phone = new LiveValidation('phone' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	phone.add( Validate.Presence );	

	var gmap_lat = new LiveValidation('gmap_lat' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	gmap_lat.add( Validate.Presence );	
	
	var gmap_lng = new LiveValidation('gmap_lng' , { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	gmap_lng.add( Validate.Presence );		

	var userpsw2 = new LiveValidation('userpsw2', { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $("#dialog").dialog("open"); } });
	userpsw2.add( Validate.Confirmation, { match: 'userpsw', failureMessage: "Les contrasenyes no coincideixen!" });
	
	<?php
	if(!isset($id)){ 
		echo "
			var userpsw = new LiveValidation('userpsw', { onlyOnSubmit: true, onInvalid : function(){ this.insertMessage(this.createMessageSpan()); this.addFieldClass(); $('#dialog').dialog('open'); }});
			userpsw.add( Validate.Presence );	
		";
	}
	?>
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