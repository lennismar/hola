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
	$_SESSION['reserva-ninos'] = $_POST['reserva-ninos'];
} elseif (isset($_SESSION['reserva-ninos'])) $ninos = $_SESSION['reserva-ninos'];

if (isset($_POST['reserva-bebes'])) { 
	$bebes = $_POST['reserva-bebes']; 
	$_SESSION['reserva-bebes'] = $_POST['reserva-bebes'];
} elseif (isset($_SESSION['reserva-bebes'])) $bebes = $_SESSION['reserva-bebes'];


if (isset($_POST['reserva-tipo'])) { 
	$tipo = $_POST['reserva-tipo']; 
	$_SESSION['reserva-tipo'] = $_POST['reserva-tipo'];
} elseif (isset($_SESSION['reserva-tipo'])) $tipo = $_SESSION['reserva-tipo'];

if (isset($_POST['rooms'])) { 
	$rooms = $_POST['rooms']; 
	$_SESSION['rooms'] = $_POST['rooms'];
} elseif (isset($_SESSION['rooms'])) $rooms = $_SESSION['rooms'];

/*
 *
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
*/

/* Priorizo lo que llega por sesión, que viene actualizado con el último valor de reserva-form.php */
if (isset($_SESSION['reserva-total'])) $total = $_SESSION['reserva-total'];
elseif (isset($_POST['reserva-total'])) {
	$total = $_POST['reserva-total'];
	$_SESSION['reserva-total'] = $_POST['reserva-total'];
}

if (isset($_SESSION['reserva-anticipado'])) $anticipado = $_SESSION['reserva-anticipado'];
elseif (isset($_POST['reserva-anticipado'])) {
	$anticipado = $_POST['reserva-anticipado'];
	$_SESSION['reserva-anticipado'] = $_POST['reserva-anticipado'];
}

if (isset($_SESSION['reserva-restante'])) $restante = $_SESSION['reserva-restante'];
elseif (isset($_POST['reserva-restante'])) {
	$restante = $_POST['reserva-restante'];
	$_SESSION['reserva-restante'] = $_POST['reserva-restante'];
}

//exit($total);
if (isset($_POST['reserva-newsletter'])) $_SESSION['reserva-newsletter'] =  $_POST['reserva-newsletter'];
if (isset($_POST['reserva-nombre'])) $_SESSION['reserva-nombre'] =  $_POST['reserva-nombre'];
if (isset($_POST['reserva-apellidos'])) $_SESSION['reserva-apellidos'] =  $_POST['reserva-apellidos'];
if (isset($_POST['reserva-email'])) $_SESSION['reserva-email'] =  $_POST['reserva-email'];
if (isset($_POST['reserva-telefono'])) $_SESSION['reserva-telefono'] =  $_POST['reserva-telefono'];
if (isset($_POST['reserva-poblacion'])) $_SESSION['reserva-poblacion'] =  $_POST['reserva-poblacion'];
if (isset($_POST['reserva-pais'])) $_SESSION['reserva-pais'] =  $_POST['reserva-pais'];
if (isset($_POST['reserva-language'])) $_SESSION['reserva-language'] =  $_POST['reserva-language'];
if (isset($_POST['reserva-persons'])) $_SESSION['reserva-persons'] =  $_POST['reserva-persons'];
if (isset($_POST['reserva-ninos'])) $_SESSION['reserva-ninos'] =  $_POST['reserva-ninos'];
if (isset($_POST['reserva-bebes'])) $_SESSION['reserva-bebes'] =  $_POST['reserva-bebes'];
if (isset($_POST['reserva-pago'])) $_SESSION['reserva-pago'] =  $_POST['reserva-pago'];
if (isset($_POST['reserva-comentarios'])) $_SESSION['reserva-comentarios'] =  $_POST['reserva-comentarios'];


$numnights = DateDiff($_SESSION['datein'], $_SESSION['dateout']);
$numdaysant = DateDiff(date("d-m-Y"), date("d-m-y", $datein));
$sel_rooms = $_SESSION['rooms'];


/*
$persons = $_POST['reserva-persons'];
$datein = strtotime($_POST['reserva-datein']);
$dateout = strtotime($_POST['reserva-dateout']);
$numnights = DateDiff($_POST['reserva-datein'], $_POST['reserva-dateout']);
$numdaysant = DateDiff(date("d-m-Y"), $_POST['reserva-datein']);
$tipo = $_POST['reserva-tipo'];
$id = $_POST['reserva-eid'];

$rooms = $_POST['rooms'];
$total = $_POST['reserva-total'];
$anticipado = $_POST['reserva-anticipado'];
$restante = $_POST['reserva-restante'];

// ---------------- VARIABLES DE SESION -----------------------
if (isset($_POST['reserva-eid'])) $_SESSION['reserva-eid'] =  $_POST['reserva-eid'];
if (isset($_POST['reserva-newsletter'])) $_SESSION['reserva-newsletter'] =  $_POST['reserva-newsletter'];
if (isset($_POST['rooms'])) $_SESSION['rooms'] =  $_POST['rooms'];
if (isset($_POST['reserva-total'])) $_SESSION['reserva-total'] =  $_POST['reserva-total'];
if (isset($_POST['reserva-anticipado'])) $_SESSION['reserva-anticipado'] =  $_POST['reserva-anticipado'];
if (isset($_POST['reserva-restante'])) $_SESSION['reserva-restante'] =  $_POST['reserva-restante'];
if (isset($_POST['reserva-nombre'])) $_SESSION['reserva-nombre'] =  $_POST['reserva-nombre'];
if (isset($_POST['reserva-apellidos'])) $_SESSION['reserva-apellidos'] =  $_POST['reserva-apellidos'];
if (isset($_POST['reserva-email'])) $_SESSION['reserva-email'] =  $_POST['reserva-email'];
if (isset($_POST['reserva-telefono'])) $_SESSION['reserva-telefono'] =  $_POST['reserva-telefono'];
if (isset($_POST['reserva-poblacion'])) $_SESSION['reserva-poblacion'] =  $_POST['reserva-poblacion'];
if (isset($_POST['reserva-pais'])) $_SESSION['reserva-pais'] =  $_POST['reserva-pais'];
if (isset($_POST['reserva-language'])) $_SESSION['reserva-language'] =  $_POST['reserva-language'];
if (isset($_POST['reserva-persons'])) $_SESSION['reserva-persons'] =  $_POST['reserva-persons'];
if (isset($_POST['reserva-ninos'])) $_SESSION['reserva-ninos'] =  $_POST['reserva-ninos'];
if (isset($_POST['reserva-bebes'])) $_SESSION['reserva-bebes'] =  $_POST['reserva-bebes'];
if (isset($_POST['reserva-comentarios'])) $_SESSION['reserva-comentarios'] =  $_POST['reserva-comentarios'];
*/

if(isset($id)){
	/*$rs_query = mysql_query("SELECT eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal FROM establiments WHERE eid = " . $id);
	$rs = mysql_fetch_array($rs_query);	*/	
	$db->where('eid',$id);
	$rs=$db->getOne('establiments',"eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal, reserva_inmediata");

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
	$reserva_inmediata_enabled = $rs['reserva_inmediata'];

	$max_person= htmlspecialchars($rs['persons']);
	$min_person= htmlspecialchars($rs['persons_min']);
	$permiteExtra= htmlspecialchars($rs['allow_extra_persons']);
	$numPersonExtra= htmlspecialchars($rs['extra_quantity']);
	$precioPersonExtra= htmlspecialchars($rs['extra_price']);
	$totalCasa=(int)$max_person+(int)$numPersonExtra;


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

<body onLoad="actualizarInformacionReserva(<?php echo $tid; ?>, 1); return false;">


	<form method="post" action="" id="fOculto">
		<input type="hidden" name="totalCasa" value="<?php echo $totalCasa; ?>">
		<input type="hidden" name="minCasa" value="<?php echo $min_person; ?>">
		<input type="hidden" id="adultos" name="adultos" value="<?php echo $persons; ?>">
		<input type="hidden" id="ninos" name="ninos" value="<?php echo $ninos; ?>">
	</form>

<?php include("includes/tag-manager.php"); ?>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a href="<?php echo $lng."/".URL_RESERVA;?>" class="step-nav-three complete"><span><?php echo TUS_DATOS_FORMA; ?></span></a>
					
					<a class="step-nav-three current"><span><?php echo CONFIRMACION_DATOS; ?></span></a>
					
					<a class="step-nav-three disable"><span><?php echo TERMINADO; ?></span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="reserva_confirmar_act.php" method="post" id="CheckOutForm" name="CheckOutForm">

                        <?php
                        if(!empty($reserva_inmediata) && $reserva_inmediata==true && !empty($reserva_inmediata_enabled) && $reserva_inmediata_enabled == '1') {
                            ?>
                            <input type="hidden" name="reserva_inmediata" value="1">
                            <div class="label-group checkout-button">
                                <input type="submit" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary"/>
                            </div>
                            <div class="alert alert--info">
                                <?php echo SERAS_REDIRIGIDO_TPV; ?>
                            </div>
                            <?php
                        }
                        else {
                            ?>
                            <div class="label-group checkout-button">
                                <input type="submit" value="<?php echo CONFIRMAR_RESERVA; ?>" name="continuar" class="btn btn--primary"/>
                            </div>
                            <?php
                        }
                        ?>
						<h1><?php echo CONFIRMACION_DATOS;?></h1>
					
						<h2><?php echo DATOS_RESERVA; ?></h2>
						
						<ul class="label-group checkout-confirm-list">
						
							<li><?php echo HUESPEDES;?>: <strong><?php echo $_POST['reserva-persons'] ." ".ADULTOS.", ".$_POST['reserva-ninos']." ".NINOS.", ".$_POST['reserva-bebes']." ".BEBES; ?></strong></li>
						
						</ul>
							
						<h2><?php echo DATOS_CLIENTE; ?></h2>
						
						<ul class="label-group checkout-confirm-list">
						
							<li><?php echo NOMBRE; ?>: <strong><?php echo $_SESSION['reserva-nombre']; ?></strong></li>
							
							<li><?php echo APELLIDOS; ?>: <strong><?php echo $_SESSION['reserva-apellidos']; ?></strong></li>	
							
							<li><?php echo EMAIL; ?>: <strong><?php echo $_SESSION['reserva-email']; ?></strong></li>	
							
							<li><?php echo TELEFONO; ?>: <strong><?php echo $_SESSION['reserva-telefono']; ?></strong></li>	
							
							<li><?php echo POBLACION; ?>: <strong><?php echo $_SESSION['reserva-poblacion']; ?></strong></li>	
							
							<li><?php echo PAIS; ?>: <strong><?php echo htmlspecialchars($_SESSION['reserva-pais']); ?></strong></li>	
							
							<li><?php echo IDIOMA_CONTACTO; ?>: <strong><?php echo $_SESSION['reserva-language']; ?></strong></li>	
							
							<li><?php echo COMENTARIOS; ?>:<br><strong><?php echo $_SESSION['reserva-comentarios']; ?></strong></li>		
						
						</ul>
						
						<h2><?php echo METODO_PAGO; ?></h2>
						
						<ul class="checkout-confirm-list">
						
							<li><?php echo Query('paymodules', 'title_'.$lng, 'pid', $_POST['reserva-pago']);?></li>						
						
						</ul>
						
						<div class="label-group">
						
							<a href="<?php echo $lng."/".URL_RESERVA;?>"><?php echo MODIFICACION_DATOS; ?></a>
						
						</div>
						
						<div class="label-group check-out-advice">
						
							<ol>
								<?php
									if($_POST['reserva-pago']=='1') echo TRANSFERENCIA_BANCARIA_TEXTO_RESERVA;
									else{

										if(!empty($reserva_inmediata) && $reserva_inmediata==true && !empty($reserva_inmediata_enabled) && $reserva_inmediata_enabled == '1') echo TARJETA_CREDITO_TEXTO_RESERVA_INMEDIATA;
										else  echo TARJETA_CREDITO_TEXTO_RESERVA;


									}
								?>
							
							</ol>
						
						</div>

                        <!-- Datos ocultos del formulario -->
                        <input type="hidden" name="persons" value="<?php echo $_SESSION['reserva-persons']; ?>">
                        <input type="hidden" name="datein" value="<?php echo $datein; ?>">
                        <input type="hidden" name="dateout" value="<?php echo $dateout; ?>">
                        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                        <input type="hidden" name="eid" value="<?php echo $id; ?>">

                        <?php
                        if (is_array($rooms))
                        {
                            foreach ($rooms as $room) { ?>
                                <input type="hidden" name="rooms[]" value="<?php echo $room; ?>">
                            <?php }
                        }?>
                        <input type="hidden" name="total" value="<?php echo $total; ?>">
                        <input type="hidden" name="anticipado" value="<?php echo $anticipado; ?>">
                        <input type="hidden" name="restante" value="<?php echo $restante; ?>">
                        <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($_SESSION['reserva-nombre']); ?>">
                        <input type="hidden" name="apellidos" value="<?php echo htmlspecialchars($_SESSION['reserva-apellidos']); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['reserva-email']); ?>">
                        <input type="hidden" name="telefono" value="<?php echo htmlspecialchars($_SESSION['reserva-telefono']); ?>">
                        <input type="hidden" name="poblacion" value="<?php echo htmlspecialchars($_SESSION['reserva-poblacion']); ?>">
                        <input type="hidden" name="pais" value="<?php echo htmlspecialchars($_SESSION['reserva-pais']); ?>">
                        <input type="hidden" name="language" value="<?php echo $_SESSION['reserva-language']; ?>">
                        <input type="hidden" name="adultos" value="<?php echo $_SESSION['reserva-persons']; ?>">
                        <input type="hidden" name="ninos" value="<?php echo $_SESSION['reserva-ninos']; ?>">
                        <input type="hidden" name="bebes" value="<?php echo $_SESSION['reserva-bebes']; ?>">
                        <input type="hidden" name="comentarios" value="<?php echo htmlspecialchars($_SESSION['reserva-comentarios']); ?>">
                        <input type="hidden" name="pago" value="<?php echo $_SESSION['reserva-pago']; ?>">
                        <input type="hidden" name="newsletter" value="<?php echo $_SESSION['reserva-newsletter']; ?>">
                        <!-- Fin de datos ocultos del formulario -->


                            <?php
                            if(!empty($reserva_inmediata) && $reserva_inmediata==true && !empty($reserva_inmediata_enabled) && $reserva_inmediata_enabled == '1') {
                                ?>
                                <div class="alert alert--info">
                                    <?php echo SERAS_REDIRIGIDO_TPV; ?>
                                </div>
                                <input type="hidden" name="reserva_inmediata" value="1">
                                <div class="label-group checkout-button">
                                    <input type="submit" value="<?php echo PAGAR; ?>" name="continuar" class="btn btn--primary"/>
                                </div>
                                <?php
                            }
                            else {
                                ?>
                                <div class="label-group checkout-button">
                                    <input type="submit" value="<?php echo CONFIRMAR_RESERVA; ?>" name="continuar" class="btn btn--primary"/>
                                </div>
                            <?php
                                    }
                            ?>
		


					
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php $result = 1; include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>
		
		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
		
			<input type="submit" value="<?php echo CONFIRMAR_RESERVA; ?>" name="continuar" class="btn btn--primary" />
		
		</div>

	</section>

<?php include("includes/footer.php"); ?>