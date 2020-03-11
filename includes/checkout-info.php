<div class="checkout-form-resume house-type-1">

	<div class="card-header">

		<div class="house-class"><?php echo $tipusestabliment; ?></div>

		<div class="house-TypeDot"></div>

		<div class="card-title"><?php echo $title; ?></div>

	</div>

	<div class="card-img">

		<!-- Marca de reserva inmediata -->
		<?php if($reserva_inmediata==true) include("includes/instant-booking.php"); ?>

		<img src="<?php echo CDN_BASE."images/uploads/establiments/".ImagePrincipalEstabliment($id); ?>" alt="foto-casa" width="739" height="397" />

	</div>

	<div class="card-content">

		<div class="card-location"><span class="icon icon--place"><?php echo GetTitleLocalitat($lid); ?> (<?php echo GetTitleComarca($comid); ?>, <?php echo GetTitleProvincia($pvid); ?>)</span></div>

		<div class="card-description"><?php echo REFERENCIA; ?> <strong>SR-<?php echo $id; ?></strong></div>

		<div class="card-description">

			<p><strong><?php echo $tipusestabliment; ?></strong> para <strong><?php echo $persons . " ". PERSONAS; ?></strong></p>

			<p><?php echo ENTRADA; ?>: <strong><?php echo date("d/m/y", $datein); ?></strong></p>

			<p><?php echo SALIDA; ?>: <strong><?php echo date("d/m/y", $dateout); ?></strong></p>

		</div>

		<div class="card-description">

			<div class="soft-half--bottom">
				<?php echo number_format( ($totalprice / $numdays), 2)?>€ x <?php echo $numdays; ?> <?php echo NOCHES; ?>
			</div>

			<div class="split split--border-grey">
				<div class="split-title">
					<?php echo PRECIO_TOTAL; ?>
					<span class="explanatory-text"><?php echo IVA_INCLUIDO; ?></span>
				</div>
				<div class="split-content"><?php echo number_format( $totalprice, 2)?>€</div>
			</div>

			<div class="split split--border-grey">
				<div class="split-title">
					<strong><?php if(empty($status)) echo PAGAS_ANTICIPADO; else echo PAGADO_ANTICIPADO; ?></strong>
					<span class="explanatory-text"><?php echo PARA_CONFIRMAR_RESERVA;?></span>
				</div>
				<div class="split-content precio-anticipado"><strong><?php echo number_format( $anticipat, 2)?>€</strong></div>
			</div>

			<div class="split split--border-grey">
				<div class="split-title">
					<?php echo CANTIDAD_RESTANTE; ?>
					<span class="explanatory-text">(<?php echo A_PAGAR_EN_LA_CASA; ?>)</span>
				</div>
				<div class="split-content"><?php echo number_format( ($totalprice - $anticipat), 2)?>€</div>

			</div>

		</div>

	</div>

</div>

<?php if($reserva_inmediata==true) { ?>
<!-- Información que se muestra dependiendo de si la reserva es inmediata o no -->

<div class="instant-booking-advice clearfix">
	<div class="instant-booking-advice-icon">
		<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
			<path id="ico-flash" sketch:type="MSShapeGroup" fill="#d0021b" d="M8.803,20.999c-0.193-0.127,3.154-7.16,3.038-7.468c-0.115-0.308-3.664-1.437-3.838-1.98c-0.173-0.543,7.007-8.706,7.196-8.548c0.189,0.158-3.129,7.238-3.038,7.468c0.09,0.23,3.728,1.406,3.838,1.98C16.108,13.024,8.996,21.124,8.803,20.999"/>
		</svg>
	</div>

	<div class="instant-booking-advice-text">
		<?php echo  RESERVAS_INMEDIATAS_SON_REVISADAS;?>
	</div>
</div>

<!-- /Info reserva inmediata -->
<?php } // Fin del IF que comprueba si hay reserva inmediata activa ?>

<div class="checkout-advice">
	<h6><?php echo TIENES_DUDAS; ?></h6>
	<?php echo LLAMANOS_AL;?> <a href="tel: <?php echo $telefono_somrurals['condensado']; ?>"><?php echo $telefono_somrurals['humano']; ?></a>
</div>