<?php 
include 'includes/config.php';

if (isset($_POST['reserva-eid'])){ 
	$id = $_POST['reserva-eid']; 
	$_SESSION['reserva-eid'] = $_POST['reserva-eid']; 
} elseif (isset($_SESSION['reserva-eid'])) $id = $_SESSION['reserva-eid'];

if (isset($_POST['reserva-datein'])) { 
	$datein = strtotime($_POST['reserva-datein']); 
	$_SESSION['reserva-datein'] = $_POST['reserva-datein']; 
	$_SESSION['datein'] = $_POST['reserva-datein']; 
} elseif (isset($_SESSION['reserva-datein'])) $datein = strtotime($_SESSION['reserva-datein']);

if (isset($_POST['reserva-dateout'])) { 
	$dateout = strtotime($_POST['reserva-dateout']); 
	$_SESSION['reserva-dateout'] = $_POST['reserva-dateout'];
	$_SESSION['dateout'] = $_POST['reserva-dateout'];
} elseif (isset($_SESSION['reserva-dateout'])) $dateout = strtotime($_SESSION['reserva-dateout']);

if (isset($_POST['reserva-persons'])) { 
	$persons = $_POST['reserva-persons']; 
	$_SESSION['persons'] = $_POST['reserva-persons'];
} elseif (isset($_SESSION['reserva-adultos'])) $persons = $_SESSION['reserva-persons'];

if (isset($_POST['reserva-ninos'])) { 
	$ninos = $_POST['reserva-ninos']; 
	//$_SESSION['reserva-ninos'] = $_POST['reserva-ninos'];
	$persons=$persons+$ninos;

} else { $ninos = 0; unset($_SESSION['reserva-ninos']);}
//elseif (isset($_SESSION['reserva-ninos'])) $ninos = $_SESSION['reserva-ninos'];

if (isset($_POST['reserva-bebes'])) { 
	$bebes = $_POST['reserva-bebes']; 
	$_SESSION['reserva-bebes'] = $_POST['reserva-bebes'];
} else { $bebes = 0; unset($_SESSION['reserva-bebes']);}
//elseif (isset($_SESSION['reserva-bebes'])) $bebes = $_SESSION['reserva-bebes'];


if (isset($_POST['reserva-tipo'])) { 
	$tipo = $_POST['reserva-tipo']; 
	$_SESSION['reserva-tipo'] = $_POST['reserva-tipo'];
} elseif (isset($_SESSION['reserva-tipo'])) $tipo = $_SESSION['reserva-tipo'];

if (isset($_POST['rooms'])) { 
	$rooms = $_POST['rooms']; 
	$_SESSION['rooms'] = $_POST['rooms'];
} elseif (isset($_SESSION['rooms'])) $rooms = $_SESSION['rooms'];

if (isset($_POST['reserva-total'])) { 
	$total = $_POST['reserva-total']; 
	$_SESSION['reserva-total'] = $_POST['reserva-total'];
} elseif (isset($_SESSION['reserva-total'])) $total = $_SESSION['reserva-total'];

if (isset($_POST['reserva-anticipado'])) { 
	$anticipado = $_POST['reserva-anticipado']; 
	$_SESSION['reserva-anticipado'] = $_POST['reserva-anticipado'];
} elseif (isset($_SESSION['reserva-anticipado'])) $anticipado = $_SESSION['reserva-anticipado'];

if (isset($_POST['reserva-restante'])) { 
	$restante = $_POST['reserva-restante']; 
	$_SESSION['reserva-restante'] = $_POST['reserva-restante'];
} elseif (isset($_SESSION['reserva-restante'])) $restante = $_SESSION['reserva-restante'];

$numnights = DateDiff($_SESSION['datein'], $_SESSION['dateout']);
$numdaysant = DateDiff(date("d-m-Y"), date("d-m-y", $datein));
$sel_rooms = $_SESSION['rooms'];

/*
echo "POST: ". $_POST['reserva-total']."<br>";
echo "SESSION: ". $_SESSION['reserva-total']."<br>";
echo "VAR: ". $total."<br>";
*/
//var_dump($_SESSION);
if(isset($id)){
	/*$rs_query = mysql_query("SELECT eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal FROM establiments WHERE eid = " . $id);
	$rs = mysql_fetch_array($rs_query);*/
	$db->where('eid',$id);
	$rs=$db->getOne('establiments',"eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, persons,persons_min,allow_extra_persons,extra_quantity,extra_price,user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal, reserva_inmediata");

	$title = htmlspecialchars($rs['title']);
	$description = $rs['description_'.$lng];
	$lid = htmlspecialchars($rs['lid']);
	$pvid = htmlspecialchars($rs['pvid']);
	$comid = htmlspecialchars($rs['comid']);
	$published = htmlspecialchars($rs['published']);
	$daysmin = htmlspecialchars($rs['daysmin']);
	$daysant = htmlspecialchars($rs['daysant']);
	$establimentcomplert = htmlspecialchars($rs['establimentcomplert']);
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
	$seotitle = htmlspecialchars($rs['seotitle']);	
	$seowords = htmlspecialchars($rs['seowords']);
	$seodescription = htmlspecialchars($rs['seodescription']);
	$hits = htmlspecialchars($rs['hits']);
	$dateadded = htmlspecialchars($rs['dateadded']);
	$datelastvisit = htmlspecialchars($rs['datelastvisit']);
	$tid = htmlspecialchars($rs['tid']);
	$terms = $rs['terms_'.$lng];
	$senyal = htmlspecialchars($rs['senyal']);

	$max_person= htmlspecialchars($rs['persons']);
	$min_person= htmlspecialchars($rs['persons_min']);
	$permiteExtra= htmlspecialchars($rs['allow_extra_persons']);
	$numPersonExtra= htmlspecialchars($rs['extra_quantity']);
	$precioPersonExtra= htmlspecialchars($rs['extra_price']);
	$totalCasa=(int)$max_person+(int)$numPersonExtra;

	$reserva_inmediata_enabled = $rs['reserva_inmediata'];
	
}

$tipusestabliment = GetTitleTipusEstabliment($tid,$lng);

$meta_title="Som Rurals. ". HEADER_TITLE;
$meta_description=SEO_HOME_DESCRIPCION;
$meta_keywords=SEO_HOME_KEYWORDS;
$meta_index="no";
$meta_follow="no";

$og_site_name="";
$og_title="";
$og_url="";
$og_image="";

include("includes/head.php");

?>

<body onLoad="actualizarInformacionReserva(<?php echo $tid; ?>); return false;">
<form method="post" action="" id="fOculto">
	<input type="hidden" name="totalCasa" value="<?php echo $totalCasa; ?>">
	<input type="hidden" name="minCasa" value="<?php echo $min_person; ?>">
</form>
<?php include("includes/tag-manager.php"); ?>

<script>
$().ready(function() {
	$("#CheckOutForm").validate({
		
		rules: {
				
			"reserva-nombre":"required",
			
			"reserva-apellidos":"required",

			"reserva-email": {
				required: true,
				email: true
			},
			
			"reserva-email2": {
				required: true,
				equalTo: "#email"
			},
			
			"reserva-poblacion":"required",
			
			"reserva-telefono":"required",
				
			"reserva-condiciones": "required",
		},
			
		messages: {
			"reserva-nombre": "<?php echo LIVE_VALIDATION_NOMBRE; ?>",
			
			"reserva-apellidos": "<?php echo LIVE_VALIDATION_APELLIDOS; ?>",
			
			"reserva-email": {
				required: "<?php echo LIVE_VALIDATION_EMAIL; ?>",
				email: "<?php echo LIVE_VALIDATION_EMAIL_CORRECTO; ?>"
			},
			
			"reserva-email2": {
				required: "<?php echo LIVE_VALIDATION_EMAIL; ?>",
				equalTo: "<?php echo LIVE_VALIDATION_EMAIL_MATCH; ?>"
			},

			"reserva-poblacion":"<?php echo LIVE_VALIDATION_POBLACION; ?>",
			
			"reserva-telefono":"<?php echo LIVE_VALIDATION_TELEFONO; ?>",			
			
			"reserva-condiciones": "<?php echo LIVE_VALIDATION_CONDICIONES; ?>"
		}
	});
});
</script>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>	
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a class="step-nav-three current"><span><?php echo TUS_DATOS_FORMA; ?></span></a>
					
					<a class="step-nav-three disable"><span><?php echo CONFIRMACION_DATOS; ?></span></a>
					
					<a class="step-nav-three disable"><span><?php echo TERMINADO; ?></span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="<?php echo $lng."/".URL_RESERVA_CONFIRMAR;?>" method="post" id="CheckOutForm" name="CheckOutForm">

                        <input type="hidden" id="reserva-eid" name="reserva-eid" value="<?php echo $id; ?>">
                        <input type="hidden" id="reserva-tipo" name="reserva-tipo" value="<?php echo $tipo; ?>">
                        <input type="hidden" id="reserva-datein" name="reserva-datein" value="<?php echo $_SESSION['reserva-datein']; ?>">
                        <input type="hidden" id="reserva-dateout" name="reserva-dateout" value="<?php echo $_SESSION['reserva-dateout']; ?>">   
						<input type="hidden" id="reserva-total" name="reserva-total" value="<?php echo $total; ?>">
						<input type="hidden" id="reserva-anticipado" name="reserva-anticipado" value="<?php echo $anticipado; ?>">
						<input type="hidden" id="reserva-restante" name="reserva-restante" value="<?php echo $restante; ?>">
						<?php
						if (is_array($rooms)) {
							foreach ($rooms as $room) { ?>
								<input type="hidden" name="rooms[]" value="<?php echo $room; ?>">
						<?php
							}
						}?>
						<h2 class=""><?php echo DATOS_PARA_RESERVA; ?></h2>
						<?php 
                        	echo '<div class="mensaje-reserva alert alert--warning alert-small text--center mensaje-error" style="display:none;" >'.str_replace('<max_personas>',$totalCasa, ERROR_CAPACIDAD_MAXIMA).'</div>';
                        	echo '<div class=" alert alert--warning alert-small text--center mensaje-minpersons" style="display:none;" >'.str_replace('<min_personas>',$min_person, ERROR_CAPACIDAD_MINIMA).'</div>';
                     	?>
						<div class="label-group clearfix">
							
							<div class="label-group-three">
								<label><?php echo NUMERO_DE . " " .ADULTOS; ?> (+18 años)</label>
							
                                <select name="reserva-persons" id="adultos" onChange="actualizarInformacionReserva(<?php echo $tid; ?>);return false;">
									<?php
                                        /*$cont = 1;
                                        while($cont<=30) { // Número máximo de 30 personas
                                            echo "<option value=\"".$cont."\"";
                                            if ($persons==$cont) echo "selected=\"selected\""; 
                                            echo ">".$cont."</option>";
                                            $cont++;	
                                        }*/
                                        $cont = 1;//$min_person;
					                    $num_persons = $max_person;
					                    $num_persons_extra = $numPersonExtra;
					                    
					                    if(isset($_SESSION['reserva-persons'])){
					                    	$adultos=(int)$_SESSION['reserva-persons'];
					                    }
					                    else{
					                    	$adultos=(int)$_SESSION['persons'];
					                    }
					                    // Imprime tantos options como personas caben en la casa o en las habitaciones
					                    while($cont<=$num_persons+$num_persons_extra) {
					                        echo "<option class='adultos' value=\"".$cont."\"";
					                        if ($adultos==$cont) echo " selected=\"selected\"";
					                        if($cont == 1){
					                        	echo ">".$cont." persona</option>";
					                        }else{
					                        	 echo ">".$cont." ". PERSONAS."</option>";
					                        }
					                        $cont++;
					                    }
					                    

                                    ?>                                      
                                </select>
							</div>
							
							<div class="label-group-three">
								<label><?php echo NUMERO_DE . " " .NINOS; ?> (3-17 años)</label>
							
                                <select name="reserva-ninos" id="ninos"onChange="actualizarInformacionReserva(<?php echo $tid; ?>); return false;">
									<?php
										$num_persons = $max_person;
                                        $cont = 0;
                                        while($cont<=$max_person) { // Número máximo de 30 personas
                                            echo "<option value=\"".$cont."\"";
                                            if ($ninos==$cont) echo " selected=\"selected\"";
                                            echo ">".$cont."</option>";
                                            $cont++;	
                                        }
                                        /*$cont = $min_person;
					                    
					                    $num_persons_extra = $numPersonExtra;
					                    if($cont==1){$cont=0;}
					                    // Imprime tantos options como personas caben en la casa o en las habitaciones
					                    while($cont<=$num_persons+$num_persons_extra) {
					                        echo "<option class='ninos' value=\"".$cont."\"";
					                        
					                        if($cont == 1){
					                        	echo ">".$cont." persona</option>";
					                        }else{
					                        	 echo ">".$cont." ". PERSONAS."</option>";
					                        }
					                        $cont++;
					                    }*/
					                    
                                    ?>                                      
                                </select>
							</div>
							
							<div class="label-group-three">
								<label><?php echo NUMERO_DE . " " .BEBES; ?> (0-2 años)</label>
							
                                <select name="reserva-bebes" id="bebes">
									<?php
                                        $cont = 0;
                                        while($cont<=10) { // Número máximo de 30 personas
                                            echo "<option value=\"".$cont."\"";
                                            if ($bebes==$cont) echo "selected=\"selected\""; 
                                            echo ">".$cont."</option>";
                                            $cont++;	
                                        }
                                    ?>                                      
                                </select>
							</div>
											
						</div>
	
						<h2><?php echo TUS_DATOS; ?></h2>
						
						<div class="label-group clearfix">
						
							<div class="label-group-two">
								<label><?php echo NOMBRE; ?></label>
								<!--<input type="text" placeholder="" class="" id="nombre" name="nombre" required>-->
                            	<input type="text" placeholder="" name="reserva-nombre" id="nombre" value="<?php echo $_SESSION['reserva-nombre']; ?>" required>						
							</div>
							
							<div class="label-group-two">
								<label><?php echo APELLIDOS; ?></label>							
                            	<input type="text" name="reserva-apellidos" id="apellidos" value="<?php echo $_SESSION['reserva-apellidos']; ?>" required>
							</div>
							
							<div class="label-group-two">
								<label><?php echo EMAIL; ?></label>
                                <input type="text" name="reserva-email" id="email" class="icon-input-email" value="<?php echo $_SESSION['reserva-email']; ?>" required>							
							</div>
							
							<div class="label-group-two">
								<label><?php echo REPETIR_EMAIL; ?></label>							
                            	<input type="text" name="reserva-email2" id="repetir_email" class="icon-input-email" value="<?php echo $_SESSION['reserva-email']; ?>" required>						
							</div>

							<div class="label-group-two">
								<label><?php echo POBLACION; ?></label>
                                <input type="text" name="reserva-poblacion" id="reserva-poblacion"  value="<?php echo $_SESSION['reserva-poblacion']; ?>" required>							
							</div>

							<div class="label-group-two">
								<label><?php echo TELEFONO; ?></label>
                                <input type="text" name="reserva-telefono" id="reserva-telefono"  value="<?php echo $_SESSION['reserva-telefono']; ?>" required>							
							</div>

							
							<div class="label-group-two">
								<label><?php echo PAIS; ?></label>
								
                                <select name="reserva-pais" id="pais">
                                    <?php paises() ?>
                                </select>
							</div>
							
							<div class="label-group-two">
							
								<label><?php echo IDIOMA_CONTACTO; ?></label>
								
                                <select name="reserva-language" id="language">
                                    <option <?php if ($lng=='ca') echo "selected=\"selected\""; ?> value="ca">Català</option>
                                    <option <?php if ($lng=='es') echo "selected=\"selected\""; ?> value="es">Castellano</option>
                                    <option <?php if ($lng=='en') echo "selected=\"selected\""; ?> value="en">English</option>
                                    <option <?php if ($lng=='fr') echo "selected=\"selected\""; ?> value="fr">Français</option>
                                </select>
							
							</div>
							
							
							<div class="label-group">
								<label><?php echo COMENTARIOS; ?></label>
                                <textarea name="reserva-comentarios" id="comentarios" class="form-control"><?php echo $_SESSION['reserva-comentarios']; ?></textarea>				
							</div>
							
						</div>
						
						
						<h2><?php echo METODO_PAGO; ?></h2>
						
                        <!--
						<script>
							$(function() {
						        $('#forma-de-pago').change(function(){
						            $('.forma-de-pago').hide();
						            $('#' + $(this).val()).show();
						        });
						    });
							
						</script>
						-->
                        
						<div class="label-group pay-way">
						 
                         	<select name="reserva-pago" id="forma-de-pago">
								<!--<option value="forma-de-pago1" selected>Transferencia Bancaria</option>-->
								<?php
                                    //$query  = mysql_query("SELECT pid, title_".$lng." FROM paymodules");
									if(!empty($reserva_inmediata) && $reserva_inmediata==true && !empty($reserva_inmediata_enabled) && $reserva_inmediata_enabled == '1') $db->where ('reserva_inmediata', 1);
									$rs_query=$db->get('paymodules',null,"pid, title_".$lng."");
                                    //if($rs = mysql_fetch_array($query)){
									if($db->count > 0){
										$i = 0;
										foreach($rs_query as $rs){
								  ?>                            	
                                    	<option <?php if($i!=0) echo 'selected="selected"'; ?> value="<?php echo $rs['pid']; ?>"><?php echo $rs['title_'.$lng]; ?></option>
                                <?php
											$i++;
										}
									}?>
         

                                <!--
								<option value="forma-de-pago2" >Tarjeta de Crédito</option>
								<option value="forma-de-pago3" >PayPal</option>
								-->
                            </select>
											
						</div>
						
						<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago1" style="display:none">
							
							<div class="push-half--bottom"><strong>TRANSFERENCIA BANCARIA</strong></div>
							
							<ol>
								<?php echo TRANSFERENCIA_BANCARIA_TEXTO_RESERVA; ?>
							
							</ol>
							<!--<img src="assets/img/payment-tarjeta.png" class="push-half--top" alt="Tarjetas aceptadas" width="241" height="36" />-->
						</div>
						
						<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago2">
						
							<div class="push-half--bottom"><strong>TARJETA DE CRÉDITO</strong></div>
						
							<ol>
				
								<?php
									if(!empty($reserva_inmediata) && $reserva_inmediata==true && !empty($reserva_inmediata_enabled) && $reserva_inmediata_enabled == '1') echo TARJETA_CREDITO_TEXTO_RESERVA_INMEDIATA;
									else  echo TARJETA_CREDITO_TEXTO_RESERVA;
								?>
							
							</ol>
							
							<img src="<?php echo CDN_BASE; ?>assets/img/payment-tarjeta.png" class="push-half--top" alt="Tarjetas aceptadas" width="241" height="36" />

							<script>
								// Funcionalidad para mostrar un texto explicativo u otro en función de qué opción de pago se haya elegido
								$( "#forma-de-pago" ).change(function() {
									//alert( "Handler for .change() called." );
									$( ".forma-de-pago" ).hide();
									$( "#forma-de-pago"+$( "#forma-de-pago" ).val()).show();
								});
							</script>
						</div>
                        <!--

						<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago3" style="display:none">
						
							<div class="push-half--bottom"><strong>PAYPAL</strong></div>
						
							<ol>
				
								<li>En máximo <strong>48 horas confirmaremos la disponibilidad</strong> de este alojamiento</li>
								
								<li>Una vez confirmada, te enviaremos un <strong>email</strong> con un link a nuestra web para que realices el <strong>pago del importe anticipado</strong> mediante <strong>PayPal</strong>.</li>

								<li>Al momento de recibirás un mail de confirmación con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>
							
							</ol>
							
							<img src="assets/img/logo-paypal.svg" class="push-half--top" alt="Pago con PayPal" />
						
						</div>
                        -->
                        
						<div class="label-group"><?php echo NO_INCLUYE_TASA_TURISTICA; ?></div>
						
						<div class="label-group"><input type="checkbox" class="" name="reserva-newsletter">Quiero darme de alta en la newsletter de Somrurals para conocer las novedades y promociones.</div>
						
						<div class="label-group"><input type="checkbox" class="" id="check_condiciones" name="reserva-condiciones" required><?php echo ACEPTO_CONDICIONES; ?></div>
						
						
						<div class="label-group checkout-button">
                            
							<input type="submit" value="<?php echo SEGUIR; ?>" name="continuar" class="btn btn--primary seguir"/>
		
						</div>

					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">

				<?php include("includes/checkout-form.php"); ?>

			</aside>
			
		</div>
		
		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
			<input type="submit" value="<?php echo SEGUIR; ?>" name="continuar" class="btn btn--primary" />
		</div>

	</section>

<?php include("includes/footer.php"); ?>