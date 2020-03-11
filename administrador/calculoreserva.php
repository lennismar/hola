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
					$db->where('rid',$room);
					$db->where('date',date("Y-m-d", $date));
					$rs_query=$db->get('rooms_prices',null,'rid, price');
					foreach($rs_query as $rs) {
						$total = $total + $rs['price'];
					}
				}
						
				$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
			}
	
			
			$senyal = Query('establiments', 'senyal', 'eid', $id);		
			$anticipat = $total*($senyal/100);
			$restant = $total - $anticipat;
			
			echo "
						<div id=\"total\">
							<p class=\"texto\">".PRECIO_TOTAL."</p>
							<p class=\"numero\" style=\"\">".round($total,2)."<span>€</span></p>
						</div>
				
						<div id=\"anticipat\">
							<ul>
								<li>
									<p class=\"texto\">".ANTICIPADO."</p>
									<p class=\"numero\">".round($anticipat,2)."<span>€</span></p>
								</li>
								<li class=\"last\">
									<p class=\"texto\">".CANTIDAD_RESTANTE."</p>
									<p class=\"numero\">".round($restant,2)."<span>€</span></p>
								</li>
								<br clear=\"left\" />
							</ul>
						</div>
						
						<input type=\"hidden\" name=\"reserva-total\" value=\"".$total."\">
						<input type=\"hidden\" name=\"reserva-anticipado\" value=\"".$anticipat."\">
						<input type=\"hidden\" name=\"reserva-restante\" value=\"".$restant."\">
						
			";
	
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
        $db->where('availability', 1);
        $db->where('eid', $id);
        $db->where('date', date("Y-m-d", $datein), '>=');
        $db->where('date', date("Y-m-d", $dateout), '<');
        $rs_query = $db->get('establiments_prices', null, 'SUM(price) as total');

        //if($rs = mysqli_fetch_array($query)) $total = round($rs['total'],2);
        foreach ($rs_query as $rs) {
            $total = round($rs['total'], 2);
        }
    }


    $senyal = Query('establiments', 'senyal', 'eid', $id);
    $anticipat = $total*($senyal/100);
    $restant = $total - $anticipat;

    // Comprobación de si hay decimales, para reducir el tamaño de la fuente ----------- FALTA HACER!!
    $fontsize = "";
		
		echo "
			<div id=\"total\">
				<p class=\"texto\">".PRECIO_TOTAL."</p>
				<p class=\"numero\" ".$fontsize.">".round($total,2)."<span>€</span></p>
			</div>
	
			<div id=\"anticipat\">
				<ul>
					<li>
						<p class=\"texto\">".ANTICIPADO."</p>
						<p class=\"numero\" ".$fontsize.">".round($anticipat,2)."<span>€</span></p>
					</li>
					<li class=\"last\">
						<p class=\"texto\">".CANTIDAD_RESTANTE."</p>
						<p class=\"numero\" ".$fontsize.">".round($restant,2)."<span>€</span></p>
					</li>
					<br clear=\"left\" />
				</ul>
			</div>
			
			<input type=\"hidden\" name=\"reserva-total\" value=\"".$total."\">
			<input type=\"hidden\" name=\"reserva-anticipado\" value=\"".$anticipat."\">
			<input type=\"hidden\" name=\"reserva-restante\" value=\"".$restant."\">
		";
}
?>
