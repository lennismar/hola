<?php
	include 'includes/config.php';

	$tid = $_POST['tid'];
	$datein = $_SESSION['datein'];
	$dateout = $_SESSION['dateout'];
	$tipusestabliment = GetTitleTipusEstabliment($tid,$lng);
	$persons = $_SESSION['persons'];
	if(!empty($_POST['totalPersonas'])) $persons = $_POST['totalPersonas'];
	$adultos=$_POST['adultos']; 
	$_SESSION['reserva-adultos']=$adultos;
	$ninos=$_POST['ninos'];
	$_SESSION['reserva-ninos']=$ninos;
	$tipo = $_SESSION['reserva-tipo'];
	$numnights = DateDiff($_SESSION['datein'], $_SESSION['dateout']);
	$result=$_POST['resultado'];
	$title  = Query('establiments','title','eid',$_SESSION['reserva-eid']);

?>
<div class="card-description">
		
			<p><strong><?php echo $tipusestabliment; ?></strong> para <strong><span class='personas'><?php echo $persons . "</span> ". PERSONAS; ?></strong></p>
			
			<p><?php echo ENTRADA; ?>: <strong><?php echo date("d/m/y",strtotime($datein)); ?></strong></p>
			
			<p><?php echo SALIDA; ?>: <strong><?php echo date("d/m/y",strtotime($dateout)); ?></strong></p>

		</div>
				
		<div class="card-description">

<?php
if ($tipo==1) { // Reserva de habitaciones
?>
            	<p><strong><?php echo HABITACIONES; ?></strong></p>
<?php
	foreach ($rooms as $room) {
		$SQL  = "SELECT  r.rid, r.title_".$lng." as title, r.eid, r.persons, r.published, rp.availability, r.daysmin, r.daysant, rp.price, r.title_".$lng." "; 
		$SQL .= "FROM rooms r, rooms_prices rp ";
		$SQL .= "WHERE rp.rid = ".$room." ";
		$SQL .= "AND r.rid = ".$room. " ";
		
		//$query = mysqli_query($SQL);
		$query=$db->rawQuery($SQL);
		//if($rs = mysqli_fetch_array($query)){
		foreach($query as $rs){
				echo "<p>&bull; ".$rs['title'];?>: <?php echo $rs['price'];?>€ x <?php echo $numnights. " ".NOCHES."</p>";
		}
	}
} else if ($tipo==2){ // Reserva de la casa entera

		$total = 0;
     	$date_entrada=date('Y-m-d',strtotime($datein));
     	$date_salida=date('Y-m-d',strtotime($dateout));

        $db->where('availability',1);
        $db->where('eid',$_SESSION['reserva-eid']);
        $db->where('date',$date_entrada,'>=');
        $db->where('date',$date_salida,'<');
        $query=$db->get('establiments_prices',null,'DISTINCT date, price');

        //while ($rs = mysqli_fetch_array($query)) {
        foreach($query as $rs){
            $total = $total + round($rs['price'],2);
        }

		$cobrar=true;

        /**
         * Comprobación sobre si hay precio por noches minimas
         */
        $db->where('eid',$_SESSION['reserva-eid']);
        $rs_query=$db->get('establiments_nitsmin',null,'*');
        if ($db->count > 0){
            foreach($rs_query as $rs){
                $date_start = date('Y-m-d', strtotime($rs['date_start']));
                $date_end = date('Y-m-d', strtotime($rs['date_end']));
                $nitsmin= $rs['nitsmin'];

                $between=0;

                if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
                if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;

                if($between == 1){
                    $nitsmin_price = $rs['precio_bloque_dias'];
                    $nitsmin_price_extra = $rs['precio_extra_bloque_dias'];
                }
            }
        }

    /**
     * Si hay un precio por 'semanas' o por noches mínimas, ese prevalece al que pueda venir de la tabla de disponibilidad
     */
        if(isset($nitsmin_price) && $nitsmin_price != '') {
            $total = $nitsmin_price * $numnights / $nitsmin;

            $db->where('eid',$_SESSION['reserva-eid']);

            $datosEstabliment=$db->getOne('establiments',null,'persons,allow_extra_persons,extra_quantity,extra_price');
            //Comprobamos que admite personas extra
            if($datosEstabliment['allow_extra_persons'] == 1) {
                if ($datosEstabliment['persons'] < $persons) {
                    //Si el número de personas del establecimiento es menor que las elegidas, es que tiene personas extra
                    $personas_extra = $persons - $datosEstabliment['persons'];

                    if(!empty($nitsmin_price_extra)) {
                        $precio_extra = $personas_extra * $nitsmin_price_extra;
                        $total_extra = $precio_extra;
                        $total=$total+$total_extra;
                    }
                }
            }
        }
        else {
            /**
             * Comprobación tradicional en base a la tabla de disponibilidad
             */
            $db->where('eid',$_SESSION['reserva-eid']);

            $datosEstabliment=$db->getOne('establiments',null,'persons,allow_extra_persons,extra_quantity,extra_price');
            //Comprobamos que admite personas extra
            if($datosEstabliment['allow_extra_persons'] == 1){
                if($datosEstabliment['persons']<$persons) {
                    //Si el número de personas del establecimiento es menor que las elegidas, es que tiene personas extra
                    $personas_extra = $persons - $datosEstabliment['persons'];
                    //precio por persona
                    $precio_extra = $personas_extra * $datosEstabliment['extra_price'];
                    $total_extra = $precio_extra * $numnights;


                    //Comprobamos el siguiente rango de fechas$db->where('eid',$id);
                    $db->where('eid', $_SESSION['reserva-eid']);
                    $rs_query = $db->get('establiments_nitsmin', null, '*');
                    if ($db->count > 0){
                        foreach ($rs_query as $rs) {
                            $date_start = date('Y-m-d', strtotime($rs['date_start']));
                            $date_end = date('Y-m-d', strtotime($rs['date_end']));
                            $nitsmin = $rs['nitsmin'];
                            $nitsmin_price_extra = $rs['precio_extra_bloque_dias'];

                            $between = 0;

                            if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) {
                                $between = 1;
                            }
                            if (($date_salida >= $date_start) && ($date_salida <= $date_end)) {
                                $between = 1;
                            }

                            if ($between == 1) {
                                if ($rs['precio_extra'] != 1) {
                                    //Si NO está marcado como que queremos que se cobre el precio extra en esa fecha
                                    $cobrar = false;
                                    break;
                                } else {
                                    // Si está marcado como que SI se cobrará, compruebo si hay un precio marcado específico.. y en ese caso, modifico el total_extra
                                    if(!empty($nitsmin_price_extra)) {
                                        $precio_extra = $personas_extra * $nitsmin_price_extra;
                                        $total_extra = $precio_extra * $numnights;
                                    }
                                }
                            }
                        }
                    }

                    if($cobrar){
                        $total=$total+$total_extra;
                    }
                }
            }
        }

		$senyal = Query('establiments', 'senyal', 'eid', $_SESSION['reserva-eid']);		
        $anticipat = $total*($senyal/100);
        $restant = $total - $anticipat;

        echo "<p><strong>".RESERVA_CASA_ENTERA."</strong></p>";
        echo "<p>".round($total/$numnights,2); ?>€ x <?php echo $numnights. " ".NOCHES."</p>";

}
?>
			
            	
			<div class="split split--border-grey">
				<div class="split-title">
					<?php echo PRECIO_TOTAL; ?>
					<span class="explanatory-text"><?php IVA_INCLUIDO; ?></span>
				</div>
				<div class="split-content"><?php echo round($total,2); ?>€</div>
				<?php $_SESSION['reserva-total']=round($total,2); ?>
			</div>
		
			<div class="split split--border-grey">
				<div class="split-title">
					<strong><?php echo PAGAS_AHORA; ?> (<?php echo ANTICIPADO; ?>)</strong>
					<span class="explanatory-text"><?php echo PARA_CONFIRMAR_RESERVA; ?></span>
					</div>
				<div class="split-content precio-anticipado"><strong><?php echo round($anticipat,2); ?>€</strong></div>
				<?php $_SESSION['reserva-anticipado']=round($anticipat,2); ?>
			</div>
		
			<div class="split split--border-grey">
				<div class="split-title">
					<?php echo CANTIDAD_RESTANTE; ?>
					<span class="explanatory-text">(<?php echo A_PAGAR_EN_LA_CASA; ?>)</span>
				</div>
				<div class="split-content"><?php echo round($restant,2); ?>€</div>
				<?php $_SESSION['reserva-restante']=round($restant,2); ?>
			</div>
			
		</div>
        
        <?php if ($result!=1) { ?>
        <div class="label-group">
        <form name="" method="post" action="<?php echo $lng."/".URL_CASA_RURAL."/".urls_amigables($title)."-".$_SESSION['reserva-eid']; ?>">
            <input type="submit" value="Modificar Reserva" name="continuar" class="btn btn--grey"/>
        </form>
        </div>
		<?php } ?>	
	</div>
	
</div>
<?php if($reserva_inmediata==true){
		$db->where('eid',$_SESSION['reserva-eid']);
		$rs=$db->getOne('establiments','reserva_inmediata');

		//Si la casa esta marcada como reserva inmediata
		if($rs['reserva_inmediata']==1){?>
			<div class="instant-booking-advice clearfix">
				<div class="instant-booking-advice-icon">
					<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
					<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
						<path id="ico-flash" sketch:type="MSShapeGroup" fill="#d0021b" d="M8.803,20.999c-0.193-0.127,3.154-7.16,3.038-7.468c-0.115-0.308-3.664-1.437-3.838-1.98c-0.173-0.543,7.007-8.706,7.196-8.548c0.189,0.158-3.129,7.238-3.038,7.468c0.09,0.23,3.728,1.406,3.838,1.98C16.108,13.024,8.996,21.124,8.803,20.999"/>
					</svg>
				</div>
			<div class="instant-booking-advice-text">
				<?php echo RESERVAS_INMEDIATAS; ?>
			</div>
		</div>
		<?php }
		
	}?>

<div class="checkout-advice">
	<h6><?php echo TIENES_DUDAS;?></h6>
	 <?php echo LLAMANOS_AL; ?> <a href="tel: <?php echo $telefono_somrurals['condensado']; ?>"><?php echo $telefono_somrurals['humano']; ?></a>
</div>
