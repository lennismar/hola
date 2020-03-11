<div class="checkout-form-resume house-type-1">
	
	<div class="card-header">
					
		<div class="house-class"><?php echo $tipusestabliment; ?></div>
					
		<div class="house-TypeDot"></div>
					
		<div class="card-title"><?php echo $title; ?></div>
					
	</div>
				
	<div class="card-img">

        <!-- Marca de reserva inmediata -->
        <?php
        if($reserva_inmediata==true) {
            $db->where('eid', $id);
            $rs = $db->getOne('establiments', 'reserva_inmediata');

            //Si la casa esta marcada como reserva inmediata
            if ($rs['reserva_inmediata'] == 1) {
                include("includes/instant-booking.php");
            }
        }
        ?>
        <img src="<?php echo CDN_BASE."images/uploads/establiments/".ImagePrincipalEstabliment($id); ?>" alt="foto-casa" width="739" height="397" />
					
	</div>
	
	<div class="card-content">

		<div class="card-location"><span class="icon icon--place"><?php echo GetTitleLocalitat($lid); ?> (<?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?>)</span></div>
		
		<div class="card-description"><?php echo REFERENCIA; ?> <strong>SR-<?php echo $id; ?></strong></div>

        <!-- Aquí cargo el checkout-form con ajax -->
		<div id="resultado_reserva">
		</div>
