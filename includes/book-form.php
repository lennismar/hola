<div class="book-form">
	<?php if($reserva_inmediata==true){
		$db->where('eid',$id);
		$rs=$db->getOne('establiments','reserva_inmediata');

		//Si la casa esta marcada como reserva inmediata
		if($rs['reserva_inmediata']==1){
			//Marca de reserva inmediata 
			include("includes/instant-booking.php"); 
		}
		
	}?>
	

	<div class="book-form-price clearfix" id="_offerPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	
		<div class="main-price"><span itemprop="price" id="precio"><?php echo $bestprice; ?></span><span itemprop="priceCurrency" content="EUR">€</span></div>
		<div class="text-price"><?php echo PRECIO . " ". PERSONA_NOCHE; ?><span class="explanatory-text">(<?php echo MINIMO . " ".$daysmin." ".NOCHES; ?>)</span></div>
	</div>
	<div class="push-half--ends"><strong><?php echo $tipusestabliment; ?></strong></div>
	
	<div class="aviso-mensaje" style="display:none;">
		<div class='alert alert--warning alert-small text--center'>
			<?php echo DEL; ?> <span class="de"> </span> <?php echo AL; ?> <span class="a"></span><br/>
			<?php echo ESTANCIA_MINIMA; ?> <strong><span class="noches"> </span> <?php echo NOCHES; ?></strong><br/>
			<div class="no-entrada">
				<?php echo DIA_ENTRADA; ?> <strong><span class="entrada"> </span></strong>
			</div>
		</div>
	</div>

	<form action="<?php echo $lng."/".URL_RESERVA;?>" method="post" id="BookForm" name="BookForm">
    	<input type="hidden" name="reserva-eid" id="reserva-eid" value="<?php echo $id; ?>"/>
        <input type="hidden" name="reserva-pvid" id="reserva-pvid" value="<?php echo $pvid; ?>"/>
	
		<div class="label-group input-daterange main-search-date" id="datepicker">
													    
			<input type="text" id="from" placeholder="<?php echo ENTRADA; ?>" class="icon-input-calendar" name="reserva-datein" value="<?php if (isset($_SESSION['datein'])) echo $_SESSION['datein'];?>" onChange="ConsultarDisponibilidad();" onfocus="blur();" autocomplete="off">
						
			<input type="text" id="to" placeholder="<?php echo SALIDA; ?>" class="icon-input-calendar" name="reserva-dateout" value="<?php if (isset($_SESSION['dateout'])) echo $_SESSION['dateout'];?>" onChange="ConsultarDisponibilidad();" onfocus="blur();" autocomplete="off">
						    					
		</div>
	
		<div class="label-group">
			<select name="reserva-persons" id="reserva-persons" class="float-left" onChange="ConsultarDisponibilidad(); return false;">
				<?php
                    $cont = $persons_min;
                    $num_persons = GetNumPersonsRooms($id);
                    $num_persons_extra = GetNumPersonsExtraEstabliment($id);
                    if($num_persons < GetNumPersonsEstabliment($id)) $num_persons = GetNumPersonsEstabliment($id);
                    
					
                    // Imprime tantos options como personas caben en la casa o en las habitaciones
                    while($cont<=$num_persons+$num_persons_extra) {
                        echo "<option class='opcionp' value=\"".$cont."\"";
                        if ($_SESSION['persons']==$cont) echo " selected=\"selected\"";
                        if($cont == 1){
                        	echo ">".$cont." persona</option>";
                        }else{
                        	 echo ">".$cont." ". PERSONAS."</option>";
                        }
                        $cont++;
                    }
                    /*if($num_persons_extra>0){
                    	for($i=1;$i<=$num_persons_extra;$i++){
                    		echo "<option class='opcionp' value='".$cont."'";
                    		if ($_SESSION['persons']==$cont) echo " selected=\"selected\"";
                    		if($i==1):
                    			echo">".$num_persons." +".$i." adicional</option>";
                    		else:
                    			echo ">".$num_persons." +".$i." adicionales</option>";
                    		endif;
                    		$cont++;
                    	}
                    }*/
                ?> 
			</select>
		</div>
		
       <?php
			if(IsEstablimentComplert($id)) echo '<input type="hidden" name="reserva-tipo" id="reserva-tipo" value="2"/>';
			else {
		?>
        <div class="label-group">
            <select name="reserva-tipo" id="reserva-tipo" class="float-left" onChange="ConsultarDisponibilidad(); return false;">
                <option value="1" <?php if ($_SESSION['tipo']==1) echo "selected=\"selected\""; ?>><?php echo HABITACIONES; ?></option>
                <option value="2" <?php if ($_SESSION['tipo']==2) echo "selected=\"selected\""; ?>><?php echo TODA_CASA; ?></option>                   
            </select>
		</div>
		<?php } ?>
		<!-- Campos para hoteles -->
		
        <!--
		<div class="label-group">
		
			SELECCIONA OPCIÓN
			
			<hr class="hr-line-2">
			
			<div class="label-group">
			
				<label>
					<input name="" type="checkbox" value="" />
					<div class="checkbox-text">
						<strong>Habitación Doble Desayuno</strong><br>
						Personas: <strong>2</strong><br>
						Precio: <strong>82,5€ / Noche</strong>
					</div>
				</label>
			
			</div>
			
			<hr class="hr-line-2">
			
			<div class="label-group">
			
				<label>
					<input name="" type="checkbox" value="" />
					<div class="checkbox-text">
						<strong>Habitación Doble Desayuno</strong><br>
						Personas: <strong>2</strong><br>
						Precio: <strong>82,5€ / Noche</strong>
					</div>
				</label>
			
			</div>
			
			<hr class="hr-line-2">
			
		</div>
        -->
        
        <div id="resultado"></div>
		
		<!-- /Campos para hoteles -->
		
        <!--
		<div class="label-group">156,50€ x 8 noches</div>
		
		<div class="split total-price">
			<div class="split-title">
				<strong>Total</strong>
				<span class="explanatory-text">IVA incluido</span>
			</div>
			<div class="split-content"><strong>1.365,67€</strong></div>
		</div>
		
		<div class="split">
			<div class="split-title">
				Anticipado
				<span class="explanatory-text">Al confirmar la reserva</span>
			</div>
			<div class="split-content">365€</div>
		</div>
		
		<div class="split">
			<div class="split-title">
				Restante
				<span class="explanatory-text">(A pagar en la casa)</span>
			</div>
			<div class="split-content">1.333,50€</div>
		
		</div>
		-->
        
        <!--<div id="reserva_calculo"></div>-->
        
        <!--
		<div class="label-group">
		
			<input type="submit" value="Solicitar reserva" name="subscribe" class="btn btn--primary" />
		
		</div>
		-->
        
	</form>
	
	<a class="how-to-book venobox-how-to-book" href="includes/como-reservar.php?lng=<?php echo $lng; ?>" data-type="ajax"><?php echo NO_SABES_COMO_RESERVAR; ?></a>	
</div>
<?php if($reserva_inmediata==true){
		$db->where('eid',$id);
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
<div class="advice">
	<p class="icon icon--place"><?php echo AL_REALIZAR_LA_RESERVA; ?></p>
</div>