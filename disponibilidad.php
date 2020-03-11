<?php
include 'includes/config.php';

$id = $_POST['eid'];
$persons = $_POST['persons'];
$tipo = $_POST['tipo'];
$pvid = $_POST['pvid'];

$datein = strtotime($_POST['datein']);
$dateout = strtotime($_POST['dateout']);

$numnights = DateDiff($_POST['datein'], $_POST['dateout']); 										// Número de noches
$numdaysant = DateDiff(date("d-m-Y"), $_POST['datein']); 											// Número de dias con antelación
$_SESSION['tipo'] = $tipo;
$_SESSION['persons'] = $persons;
//$_SESSION['datein'] = $_POST['datein'];
//$_SESSION['dateout'] = $_POST['dateout'];

$rooms = explode(',', $_POST['rooms']);
$sel_rooms = $rooms;
$senyal = 0;
$dia_entrada=0;

if ($datein!="" && $dateout!="") { 																	// Verificamos que haya introducido fecha de entrada y de salida
	if($tipo == 1) { 																				// tipo=1 => habitaciones  
		if ($persons <= GetNumPersonsRooms($id)) { 													// Miramos que la casa pueda albergar el número de personas
			$disponibilidad = 1; 																	// flag que indicará si hay disponibilidad o no
			$date = $datein;
			while ($date < $dateout) { 																// Recorrido del intervalo de fechas	
				$SQL  = "SELECT SUM(r.persons*rp.availability) AS disponibilitat_total_dia "; 
				$SQL .= "FROM rooms_prices rp, rooms r ";
				$SQL .= "WHERE rp.eid = ".$id." ";
				$SQL .= "AND r.eid = ".$id. " ";
				$SQL .= "AND rp.rid = r.rid ";
				$SQL .= "AND rp.date = '".date("Y-m-d", $date)."'";
				
				//$query = mysqli_query($SQL);
				$rs_query=$db->rawQuery($SQL);

				//if($rs = mysqli_fetch_array($query)){
				foreach($rs_query as $rs){
					if ($rs['disponibilitat_total_dia'] < $persons) { 								// NO hay capacidad para el numero de personas solicitadas
						$disponibilidad = 0;
						$e_persons = 1;
					} else if ($date == $datein){  													// SI hay disponibilidad, miramos si el primer dia los dias mínimos y dias con antelación funcionen
						$SQL  = "SELECT  r.rid, r.eid, r.persons, r.published, rp.availability, r.daysmin, r.daysant, rp.price ";
						$SQL .= "FROM rooms_prices rp, rooms r ";
						$SQL .= "WHERE r.published = 1 ";
						$SQL .= "AND rp.eid = ".$id." ";
						$SQL .= "AND r.eid = ".$id. " ";
						$SQL .= "AND rp.rid = r.rid ";
						$SQL .= "AND rp.date = '".date("Y-m-d", $datein)."'";
	
						//$query2 = mysqli_query($SQL);
						$query2=$db->rawQuery($SQL);

						//while($rs2 = mysqli_fetch_array($query2)){
						
						foreach($query2 as $rs2){
							if ($numdaysant < $rs2['daysant']) {
								$disponibilidad = 0; 
								$e_numdaysant = $rs2['daysant'];
							}
							
							if ($numnights < $rs2['daysmin']) {
								$disponibilidad = 0;
								$e_numnights = $rs2['daysmin'];
							}
						}
					
					} else { 																			// NO hay disponibilidad para ese dia
						$disponibilidad = 0;
					}
				
				$date = strtotime("+1 day", $date);
				} 												// Guardamos la fecha siguiente
			}
		} else { 																					// NO hay suficiente espacio para las personas
			$e_persons = 1;
			$disponibilidad = 0;	
		}
		

	} else if($tipo == 2) { 																		// tipo=2 => casa entera
		//$numPersonasExtra=GetNumExtraPersonsEstabliment($id);
		if ($persons <= (GetNumPersonsEstabliment($id) + GetNumPersonsExtraEstabliment($id) )) { 											// Miramos que la casa pueda albergar el número de personas
			$disponibilidad = 1; 																	// flag que indicará si hay disponibilidad o no
			$date = $datein;
				
			if (GetNumRoomsEstabliment($id) == 0) { 												// Sólo Establecimiento Entero
				while ($date < $dateout) {
					//$query = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$id." AND date = '".date("Y-m-d", $date)."'");
					$db->where('availability',1);
					$db->where('eid',$id);
					$db->where('date',date("Y-m-d", $date));
					$query=$db->get('establiments_prices',null,'eid, date, price, availability');
					//if(!(mysqli_fetch_array($query))) $disponibilidad = 0;
					if($db->count <=0) $disponibilidad = 0;
					$date = strtotime("+1 day", $date);
				}
			} else { 																				// Establecimiento entero y habitaciones
				while ($date < $dateout) { 															// Recorrido del intervalo de fechas
					//$query = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$id." AND date = '".date("Y-m-d", $date)."'");
					$db->where('availability',1);
					$db->where('eid',$id);
					$db->where('date',date("Y-m-d", $date));
					$query=$db->get('establiments_prices',null,'eid, date, price, availability');
					
					//if($rs = mysqli_fetch_array($query)) { 											// Verificamos que haya disponibilidad y precio marcado en la fecha concreta del establecimiento entero
					if($db->count >0){
						//$query2 = mysqli_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$id." AND date = '".date("Y-m-d", $date)."'");
						$db->where('eid',$id);
						$db->where('date',date("Y-m-d", $date));
						$query2=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
						//while($rs2 = mysqli_fetch_array($query2)){ 									// Verificamos que cada una de las habitaciones esten disponibles también, sino no se podrá dar disponibilidad
						foreach($query2 as $rs2){
							$availability_room = Query('rooms', 'availability', 'rid', $rs2['rid']);
							if ($availability_room != $rs2['availability']) $disponibilidad = 0;
						}
					} else {
						$disponibilidad = 0;
					}
					$date = strtotime("+1 day", $date); 											// Guardamos la fecha siguiente
				}
			}
			
			$establiment_numdaysant = Query('establiments', 'daysant', 'eid', $id);
			$establiment_numnights = Query('establiments', 'daysmin', 'eid', $id);
			
			if ($numdaysant < $establiment_numdaysant) { 											// Comprobamos que los dias con antelación concuerden con los pedidos por el establecimiento
				$disponibilidad = 0; 
				$e_numdaysant = $establiment_numdaysant;
			}
			
			if ($numnights < $establiment_numnights) { 												// Comprobamos que el número mínimo de noches concuerden con los pedidos por el establecimiento
				$disponibilidad = 0;
				$e_numnights = $establiment_numnights;
			}			
		} else { 																					// NO hay suficiente espacio para las personas
			$e_persons = 1;
			$disponibilidad = 0;	
		}
	}	
	
	if ($numnights == 0) { 																			// Si se ha seleccionado el mismo dia de entrada que de salida
		$e_numnights = 1;
		$disponibilidad = 0;
	}
	
	// Mínimo de noches
	$date_entrada = date('Y-m-d', strtotime($_POST['datein']));
	$date_salida = date('Y-m-d', strtotime($_POST['dateout']));

	
	$rs_query=$db->get('nitsmin',null,' date_start, date_end, nitsmin');
	foreach($rs_query as $rs){
		$date_start = date('Y-m-d', strtotime($rs['date_start']));
		$date_end = date('Y-m-d', strtotime($rs['date_end']));
		$nitsmin= $rs['nitsmin'];
		
		$between=0;
		
		if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
		if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;

		if (($between==1) && ($numnights<$nitsmin)) {
			$e_nitsmin=1;
			$disponibilidad = 0;
			break;
		}
		
	}
	
	$nitsmin_price = null;
	if ($e_nitsmin!=1) {
		$db->where('eid',$id);
		$rs_query=$db->get('establiments_nitsmin',null,'*');
		foreach($rs_query as $rs){
			$date_start = date('Y-m-d', strtotime($rs['date_start']));
			$date_end = date('Y-m-d', strtotime($rs['date_end']));
			$nitsmin= $rs['nitsmin'];
			
			$between=0;
			
			if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
			if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;
			
			if (($between==1) && ($numnights<$nitsmin)) {
				$e_nitsmin=1;
				$disponibilidad = 0;
				break;
			}
			if($between == 1){
			
				if($rs['reserva_multiplo']==1 && $rs['dia_entrada']!=0){
					if($numnights%$rs['nitsmin']!=0){
						$disponibilidad = 0;
						$e_reserva_multiplo=1;
					}
				}
				if($rs['dia_entrada']!=0){

					$partido=explode('-',$date_entrada);
					$dia_entrada=date('w',mktime(6,0,0,$partido[1],$partido[2],$partido[0]));
					if($dia_entrada==0)$dia_entrada=7;

					if($rs['dia_entrada']!=$dia_entrada){
						$disponibilidad = 0;
						$e_dia_entrada=1;

					}
				
				}

                $nitsmin_price = $rs['precio_bloque_dias'];
                $nitsmin_price_extra = $rs['precio_extra_bloque_dias'];
			}
		}
	}
	
	if ($disponibilidad == 1) { // ------------------------------------------ HAY DISPONIBILIDAD ----------------------------------------------------------------
		if ($tipo==1) {
            /**
             * Reservas por Habitaciones
             */
			$SQL  = "SELECT  r.rid, r.title_".$lng." as title, r.eid, r.persons, r.published, rp.availability, r.daysmin, r.daysant, rp.price, r.title_ca, r.description_".$lng." as description "; 
			$SQL .= "FROM rooms_prices rp, rooms r ";
			$SQL .= "WHERE r.published = 1 ";
			$SQL .= "AND rp.eid = ".$id." ";
			$SQL .= "AND r.eid = ".$id. " ";
			$SQL .= "AND rp.rid = r.rid ";
			$SQL .= "AND rp.date = '".date("Y-m-d", $date)."'";
			
			//$query2 = mysqli_query($SQL);
			$query2=$db->rawQuery($SQL);
			
			$num_habitacion = 0;
			//while($rs2 = mysqli_fetch_array($query2)){
			foreach($query2 as $rs2){
				$cont_availability = 1;
				while ($cont_availability<=$rs2['availability']) {
					// Guardamos en un array las habitaciones
					$habitaciones[date("Y-m-d", $date)][$num_habitacion]['title'] = $rs2['title'];
					$habitaciones[date("Y-m-d", $date)][$num_habitacion]['rid'] = $rs2['rid'];
					$habitaciones[date("Y-m-d", $date)][$num_habitacion]['persons'] = $rs2['persons'];
					$habitaciones[date("Y-m-d", $date)][$num_habitacion]['price'] = $rs2['price'];
					$habitaciones[date("Y-m-d", $date)][$num_habitacion]['description'] = $rs2['description'];					 					
					
					$cont_availability++;
					$num_habitacion++;
				}
			}
				
			$habitaciones_disponibles = min($habitaciones);
			?>
				<div class="label-group">
					<?php echo ESCOGE_HABITACIONES_PARA_TOTAL; ?>
			<?php	
			$count_sel = 0;	
			foreach ($habitaciones_disponibles as $room) {
				$checked = "";
			
				if (is_array($sel_rooms)) {
					foreach ($sel_rooms as $sel) {		
						if ($sel == $room['rid']) {
							$checked = "checked";
							unset($sel_rooms[$count_sel]);
							$count_sel++;
							break;
						}
						$count_sel++;
					}
				}
			?>
					<hr class="hr-line-2">
					<div class="label-group">
						<label>
							<input name="rooms[]" id="rooms[]" type="checkbox" <?php echo $checked; ?> value="<?php echo $room['rid']; ?>" onChange="ConsultarDisponibilidad(); return false;"/>
							<div class="checkbox-text">
								<strong><?php echo $room['title']; ?></strong><br>
								<?php echo PERSONAS; ?>: <strong><?php echo $room['persons']; ?></strong><br>
								<?php echo PRECIO; ?>: <strong><?php echo $room['price']; ?>€ / <?php echo NOCHE; ?></strong>
							</div>
						</label>
					</div>
			<?php
			}
			?>	
				</div>
			<?php		
			if ($_POST['rooms']!="") {
		
					$date = $datein;
					$total = 0;
					
					while ($date < $dateout) { // Recorrido del intervalo de fechas	
						foreach ($rooms as $room) {		
							/*$SQL  = "SELECT rid, price "; 
							$SQL .= "FROM rooms_prices ";
							$SQL .= "WHERE rid = ".$room." ";
							$SQL .= "AND date = '".date("Y-m-d", $date)."'";
							
							$query = mysqli_query($SQL);*/
							$db->where('rid',$room);
							$db->where('date',date("Y-m-d", $date));
							$rs=$db->getOne('rooms_prices',null,'rid, price');
							
							//if($rs = mysqli_fetch_array($query)){
							if($db->count >0){
								$total = $total + $rs['price'];
							}
							
						}
								
						$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
					}
			
					
					$senyal = Query('establiments', 'senyal', 'eid', $id);		
					$anticipat = $total*($senyal/100);
					$restant = $total - $anticipat;		
				?>

            		<div class="split label-group"><?php echo round($total/$numnights,2); ?>€ x <?php echo $numnights. " ".NOCHES; ?></div>

					<div class="split total-price">
						<div class="split-title">
							<strong><?php echo PRECIO_TOTAL; ?></strong>
							<span class="explanatory-text"><?php echo IVA_INCLUIDO; ?></span>
						</div>
						<div class="split-content"><strong><?php echo round($total,2); ?>€</strong></div>
					</div>
					
					<div class="split">
						<div class="split-title">
							<?php echo ANTICIPADO; ?>
							<span class="explanatory-text"><?php echo AL_CONFIRMAR_RESERVA; ?></span>
						</div>
						<div class="split-content"><?php echo round($anticipat,2); ?>€</div>
					</div>
					
					<div class="split">
						<div class="split-title">
							<?php echo CANTIDAD_RESTANTE; ?>
							<span class="explanatory-text">(<?php echo A_PAGAR_EN_LA_CASA; ?>)</span>
						</div>
						<div class="split-content"><?php echo round($restant,2); ?>€</div>
					</div>
		
					<input type="hidden" name="reserva-total" value="<?php echo $total; ?>">
					<input type="hidden" name="reserva-anticipado" value="<?php echo $anticipat; ?>">
					<input type="hidden" name="reserva-restante" value="<?php echo $restant; ?>">
                    
                    <div class="label-group">
                        <input type="submit" value="<?php echo RESERVAR; ?>" name="reservar" class="btn btn--primary"/>	
                    </div>
				<?php			
			}
		} else if ($tipo==2) {
            /**
             * PAra casa entera
             */
		?>
			<div class="label-group">
				<?php echo RESERVA_CASA_ENTERA; ?>
			</div>
			<?php           
            
             //funcion en includes/functions.php
			//realiza todo el calculo del precio por noche y por rango que este establecido en la tabla establiments_nitsmin, de acuerdo al rango de fecha seleccionado
                $array_totales=CalcularPrecio(array('id'=>$id,'personas'=>$persons,'fecha_entrada'=>$datein,'fecha_salida'=>$dateout));
              //echo "array_totales"; print_r($array_totales);
	              $total=$array_totales['total'];
	              $senyal=$array_totales['senyal'];
	              $anticipat=$array_totales['anticipat'];
	              $restant=$array_totales['restant'];
	              $descripcion_tipo_precio=$array_totales['descripcion_tipo_precio'];
           
            ?>
             <?php echo $descripcion_tipo_precio; ?>
            
            <div class="split label-group "><?php echo round($total/$numnights,2); ?>€ x <span class="total-noches"><?php echo $numnights. " </span>".NOCHES; ?></div>

            <div class="split total-price">
                <div class="split-title">
                    <strong><?php echo PRECIO_TOTAL; ?></strong>
                    <span class="explanatory-text"><?php echo IVA_INCLUIDO; ?></span>
                </div>
                <div class="split-content total"><strong><?php echo round($total,2); ?>€</strong></div>
            </div>
            
            <div class="split">
                <div class="split-title">
                    <?php echo ANTICIPADO; ?>
                    <span class="explanatory-text"><?php echo AL_CONFIRMAR_RESERVA; ?></span>
                </div>
                <div class="split-content"><?php echo round($anticipat,2); ?>€</div>
            </div>
            
            <div class="split">
                <div class="split-title">
                    <?php echo CANTIDAD_RESTANTE; ?>
                    <span class="explanatory-text">(<?php echo A_PAGAR_EN_LA_CASA; ?>)</span>
                </div>
                <div class="split-content"><?php echo round($restant,2); ?>€</div>
            </div>
    
            <input type="hidden" name="reserva-total" value="<?php echo $total; ?>">
            <input type="hidden" name="reserva-anticipado" value="<?php echo $anticipat; ?>">
            <input type="hidden" name="reserva-restante" value="<?php echo $restant; ?>">

            <div class="label-group">
                <input type="submit" value="<?php echo RESERVAR; ?>" name="reservar" class="btn btn--primary"/>	
            </div>
            
    	<?php
		}
		
		/*
		echo "
			<p><strong>".PRECIO_PERS_NOCHE." (".PARA." ".$persons." ".PERSONAS.")</strong></p>
			<span class=\"subtotal\">".round(GetBestPriceEstablimentPerNightPerPerson($id,date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,$persons),2)."€</span><br>
			<button name=\"boton-reservar\" id=\"boton-reservar\" onclick=\"javascript:forms.form_consulta.submit();\">".RESERVAR."</button>
		";
		*/
			
	} else { 					// ----------------------------------------- NO HAY DISPONIBILIDAD ---------------------------------------------------------------
				
		if ($e_numdaysant!="") {
			echo "<p style=\"color:#de4f40\"><strong>".str_replace('<e_numdaysant>', $e_numdaysant, ERROR_NOCHES_ANTELACION)."</strong></p>";
		}else if($e_dia_entrada==1){
			echo "<p style=\"color:#de4f40\"><strong>".ENTRADA_NO_VALIDA."</strong></p>";
		}else if ($e_reserva_multiplo!=""){
			$parte1=str_replace('<dia_entrada>',$dia_semana[$rs['dia_entrada']],DIAS_NO_VALIDOS);
			$dia_entrada=$rs['dia_entrada'];
			$posiciones=$rs['nitsmin']+$dia_entrada;
			if($posiciones>7){
				$total=$posiciones-7;
			}
			$dia=$dia_semana[$total];
			$parte2=str_replace('<dia_salida>', $dia, $parte1);
			echo "<p style=\"color:#de4f40\"><strong>".$parte2."</strong></p>";
		} else if ($e_nitsmin!="") {
			echo "<p style=\"color:#de4f40\"><strong>";
			$nitsmin_msg = NITS_MIN;
			$nitsmin_msg = str_replace('<date_start>', date('d-m-Y', strtotime($date_start)) , $nitsmin_msg);
			$nitsmin_msg = str_replace('<date_end>', date('d-m-Y', strtotime($date_end)) , $nitsmin_msg);
			$nitsmin_msg = str_replace('<nitsmin>', $nitsmin , $nitsmin_msg);
			echo $nitsmin_msg."</strong></p>";	
		} else if ($e_numnights!="") {
			echo "<p style=\"color:#de4f40\"><strong> ".str_replace('<e_numnights>', $e_numnights, ERROR_ESTANCIA_MINIMA)."</strong></p>";			
		} else if ($e_persons!="") {
			echo "<p style=\"color:#de4f40\"><strong>".ERROR_CAPACIDAD."</strong></p>";
		

		} else {
			echo "<p style=\"color:#de4f40\"><strong>".ERROR_NO_DISPONIBILIDAD."</strong></p>";
		}
		
		//$url= $lng."/".URL_SEARCH."/".$provincia."/".$comarca."/pers:".$persons."/price:".$price;
		//if ($datein!=DMA && $dateout!=DMA)  $url .="/checkin:".$datein."/checkout:".$dateout;
		
		$mascasas = $lng."/".URL_SEARCH.'/'.GetURLProvincia ($pvid).'/all/pers:'.$persons.'/price:all/checkin:'.date("d-m-Y", $datein).'/checkout:'.date("d-m-Y", $dateout);
		?>
		
		<div class="label-group">
        	<input type="button" value="<?php echo MAS_CASAS; ?>" name="reservar" class="btn btn--primary" onclick="location.href = '<?php echo $mascasas; ?>'"/>	
        </div>
		<?php
				
		//echo "<input type=\"button\" name=\"boton-reservar\" id=\"boton-reservar\" onclick=\"location.href = '".$lng."/".URL_SEARCH."'\" value='".MAS_CASAS."' ".$stylebutton.">";			
	}
			
} else { // Si no se ha escogido fechas de entrada y salida
	echo "<p><strong>".ESCOGE_FECHAS_PARA_DISPONIBILIDAD."</strong></p><br>";
}

?>