<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';

?>

<script>
/*
function nuevoAjax(){

	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

// Funcion que combierte en un array una seleccion de check
function get_array_for_checkboxes_with_name(name) {
    var new_arr = [];
    var nodes = document.getElementsByName(name);
 
    for (var i = 0, n; n = nodes[i]; i++) {
        if (n.checked == true) {
            new_arr.push(n.value);
        }
    }
 
    return new_arr;
}


// Función que carga a través de AJAX el archivo calculoreserva.php, para que calcule el total de la reserva.
function CalculoReserva(){
	var datein, dateout, tipo, eid, resultado;
	trig_bind();

	resultado = document.getElementById('reserva_calculo');
	datein = document.getElementById('reserva-datein').value;
	dateout = document.getElementById('reserva-dateout').value;
	rooms = get_array_for_checkboxes_with_name('rooms[]');
	tipo = document.getElementById('reserva-tipo').value;
	eid = document.getElementById('reserva-eid').value;

  
	ajax=nuevoAjax();
	ajax.open("POST", "calculoreserva.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			resultado.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("datein="+datein+"&dateout="+dateout+"&rooms="+rooms+"&tipo="+tipo+"&eid="+eid);
}      

$(document).ready(function() { CalculoReserva(); return false; });
*/

</script>
		<div id="wrapper">
			<?php include 'includes/topbar.php'?>		
			<?php include 'includes/sidebar.php'?>
			<div id="main_container" class="main_container container_16 clearfix">               
                <div class="flat_area grid_16">
                                
                <h2>
                Nova Reserva
                </h2>
                </div>
                      
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                <?php
								if (!isset($_GET['eid'])) {
								?>
                                	<form id="reservationnew" action="reservation_new.php" method="get">  
										
                                        <label>Selecciona una casa</label>
                                        <select name="eid" id="eid">
                                            <?php
                                                /*$query  = mysqli_query("SELECT eid, title FROM establiments"); 
                                                while($rs = mysqli_fetch_array($query)){*/
												$rs_query=$db->get('establiments',null,'eid,title');
												foreach($rs_query as $rs){
                                            ?>                            	
													<option selected="selected" value="<?php echo $rs['eid']; ?>"><?php echo $rs['title']; ?></option>
                                            <?php } ?>		
                                        </select>
										<br /><br /><br />
                                        <label>Tipus de reserva</label>
                                        <select name="tipo" id="tipo">
                                                <option selected="selected" value="2">Casa Complerta</option>
                                                <option value="1">Habitacions</option>
                                        </select>

                                <?php 
								
								} else {
									$eid = $_GET['eid'];
									$tipo = $_GET['tipo'];

									/*$query  = mysqli_query("SELECT eid, title FROM establiments WHERE eid=".$eid); 
									$est = mysqli_fetch_array($query);*/
									$db->where('eid',$eid);
									$est=$db->getOne('establiments','eid,title');

								?>
                                	<form id="reservationnew" action="reservation_new_act.php" method="post">  
                                        <input type="hidden" name="action" value="process">
                                        <input type="hidden" name="eid" id="eid" value="<?php echo $eid; ?>">
                                        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">
										
                                        
                                        <h3><?php echo $est['title']. " ("; if ($tipo==1) echo "Habitacions)"; else echo "Casa Complerta)";?></h3>
                                        <br /><br />
                                        <?php
										?>								
                                        
                                        <label>Data d'entrada</label>
                                        <input id="checkin" name="checkin" type="text" class="datepicker" value="">

                                        <label>Data de Sortida</label>
                                        <input id="checkout" name="checkout" type="text" class="datepicker" value="">
                                        
                                        <label>Número d'Adultos (+18 anys)</label>
                                        <select name="adults" id="adults">
                                            <?php
                                                $cont = 1;
                                                while($cont<=30) {
                                                    echo "<option value=\"".$cont."\">".$cont."</option>";
                                                    $cont++;	
                                                }
                                            ?>                                      
                                        </select>
										<br /><br />
                                        <label>Número de Nens (3-17 anys)</label>
                                        <select name="children" id="children">
                                            <?php
                                                $cont = 1;
                                                while($cont<=30) {
                                                    echo "<option value=\"".$cont."\">".$cont."</option>";
                                                    $cont++;	
                                                }
                                            ?>                                      
		                                </select>
										<br /><br />
                                        <label>Número de Bebes (0-2 años)</label>
                                        <select name="babies" id="babies">
                                            <?php
                                                $cont = 1;
                                                while($cont<=30) {
                                                    echo "<option value=\"".$cont."\">".$cont."</option>";
                                                    $cont++;	
                                                }
                                            ?>                                      
                                        </select>
										<br /><br /><br />
                                        <label>Nom</label> 
                                        <input type="text" name="ofirstname" id="ofirstname" class="small" placeholder="" value="">

                                        <label>Cognoms</label> 
                                        <input type="text" name="olastname" id="olastname" class="small" placeholder="" value="">

                                        <label>Localitat</label> 
                                        <input type="text" name="ocity" id="ocity" class="small" placeholder="" value="">

                                        <label>Telèfon</label> 
                                        <input type="text" name="ophone" id="ophone" class="small" placeholder="" value="">

                                        <label>Email</label> 
                                        <input type="text" name="oemail" id="oemail" class="small" placeholder="" value="">

                                        <label>Pais</label> 
                                        <input type="text" name="ocountry" id="ocountry" class="small" placeholder="" value="">

                                        <label>Idioma de Contacte</label> 
                                        <select name="olanguage" id="olanguage">
                                            <option value="ca">Català</option>
                                            <option value="es">Castellano</option>
                                            <option value="en">English</option>
                                            <option value="fr">Français</option>
                                        </select>
										<br /><br /><br />
                                        
                                        <label>Comentaris</label> 
                                        <textarea id="ocomments" name="ocomments" style="width:500px"></textarea>                                       

                                        <select name="pid" id="pid">
                                            <?php
                                                /*$query  = mysqli_query("SELECT pid, title_ca FROM paymodules"); 
                                                if($rs = mysqli_fetch_array($query)){*/
												$rs_query=$db->get('paymodules',null,'pid, title_ca');
												foreach($rs_query as $rs){
                                            ?>                            	
                                                <option selected="selected" value="<?php echo $rs['pid']; ?>"><?php echo $rs['title_ca']; ?></option>
                                            <?php } ?>		
                                        </select>
										<br /><br /><br />
                                    <?php
									}
									?>
                                        
									</form>
                                </div>
                            </ul>
						</div>
                	</div>
				</div>
                
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.reservationnew.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png">
                        <span>Nova Reserva</span>
                        </button>
					</p>
				</div>  
             
			</div>
		</div>
       
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
       
<?php include 'includes/closing_items.php'?>