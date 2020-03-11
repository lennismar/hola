<?php
include 'includes/config.php';

$id = $_POST['eid'];
$datein = strtotime($_POST['datein']);
$dateout = strtotime($_POST['dateout']);
$tipo = $_POST['tipo'];
$numnights = DateDiff($_POST['datein'], $_POST['dateout']); // Número de noches
$numdaysant = DateDiff(date("d-m-Y"), $_POST['datein']); // Número de dias con antelación

$rooms = explode(',', $_POST['rooms']);
$senyal = 0;

if ($tipo == 1) {
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
                    $rs=$db->getOne('rooms_prices','rid,price');
					
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
            <div class="split total-price">
                <div class="split-title">
                    <strong><?php echo PRECIO_TOTAL; ?></strong>
                    <span class="explanatory-text">IVA incluido</span>
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
                    <span class="explanatory-text">(A pagar en la casa)</span>
                </div>
                <div class="split-content"><?php echo round($restant,2); ?>€</div>
            </div>

            <input type="hidden" name="reserva-total" value="<?php echo $total; ?>">
            <input type="hidden" name="reserva-anticipado" value="<?php echo $anticipat; ?>">
            <input type="hidden" name="reserva-restante" value="<?php echo $restant; ?>">
<?			
	}
	
} else if($tipo == 2){
    $date = $datein;
    $total = 0;

    /**
     * Comprobación sobre si hay precio por noches minimas
     */
    $db->where('eid',$id);
    $rs_query=$db->get('establiments_nitsmin',null,'*');
    if ($db->count > 0){
        foreach($rs_query as $rs){
            $date_start = date('Y-m-d', strtotime($rs['date_start']));
            $date_end = date('Y-m-d', strtotime($rs['date_end']));
            $nitsmin= $rs['nitsmin'];

            $between=0;

            if (($datein >= $date_start) && ($datein < $date_end)) $between=1;
            if (($dateout >= $date_start) && ($dateout <= $date_end)) $between=1;

            if($between == 1){
                $nitsmin_price = $rs['precio_bloque_dias'];
                $nitsmin_price_extra = $rs['precio_extra_bloque_dias'];
            }
        }
    }



    /**
     * Si hay un precio por 'semanas' o por noches mínimas, ese prevalece al que pueda venir de la tabla de disponibilidad
     */
    if(isset($nitsmin_price) && $nitsmin_price != '') $total = $nitsmin_price * $numnights / $nitsmin;
    else {
        /**
         * Comprobación tradicional en base a la tabla de disponibilidad
         */

        //$query = mysqli_query("SELECT SUM(price) as total FROM establiments_prices WHERE availability=1 AND eid=".$id." AND date >= '".date("Y-m-d", $datein)."' AND date < '".date("Y-m-d", $dateout)."'");
        $db->where('availability', 1);
        $db->where('eid', $id);
        $db->where('date', date("Y-m-d", $datein), '>=');
        $db->where('date', date("Y-m-d", $dateout), '<');
        $rs = $db->getOne('establiments_prices', 'SUM(price) as total');
        //if($rs = mysqli_fetch_array($query)) $total = round($rs['total'],2);
        if ($db->count > 0) {
            $total = round($rs['total'], 2);
        }
    }

    $senyal = Query('establiments', 'senyal', 'eid', $id);
    $anticipat = $total*($senyal/100);
    $restant = $total - $anticipat;
?>
        <div class="split total-price">
            <div class="split-title">
                <strong><?php echo PRECIO_TOTAL; ?></strong>
                <span class="explanatory-text">IVA incluido</span>
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
                <span class="explanatory-text">(A pagar en la casa)</span>
            </div>
            <div class="split-content"><?php echo round($restant,2); ?>€</div>
        </div>

        <input type="hidden" name="reserva-total" value="<?php echo $total; ?>">
        <input type="hidden" name="reserva-anticipado" value="<?php echo $anticipat; ?>">
        <input type="hidden" name="reserva-restante" value="<?php echo $restant; ?>">
<?php
}
?>
