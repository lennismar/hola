<div class="book-form">
	
	<!-- Marca de reserva inmediata -->
	<?php include("includes/instant-booking.php"); ?>
	
	<div class="book-form-price clearfix" id="_offerPrice" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	
		<div class="main-price"><span itemprop="price">156,50</span><span itemprop="priceCurrency" content="EUR">€</span></div>
		<div class="text-price">Precio persona / noche<span class="explanatory-text">(Mínimo 2 noches)</span></div>
		
	</div>
	
	<div class="push-half--ends"><strong>Casa rural independiente</strong></div>
	
	<div class="alert alert--warning alert-small text--center">
		Del 01-08-2016 al 31-08-2016<br>
		Estancia mínima <strong>6 noches</strong><br>
		Día de entrada: <strong>Lunes</strong>
	</div>
	
	<form action="checkout-1.php" method="post" id="BookForm" name="BookForm">
	
		<div class="label-group input-daterange main-search-date" id="datepicker">
													    
			<input type="text" id="from" placeholder="Entrada" class="icon-input-calendar" name="from" onfocus="blur();">
						
			<input type="text" id="to" placeholder="Salida" class="icon-input-calendar" name="to" onfocus="blur();">
						    					
		</div>
	
		<div class="label-group">
						 
			<select class="">
				<option value="p-1" >1 persona</option>	
				<option value="p-2" selected>2 personas</option>
				<option value="p-2" >3 personas</option>
				<option value="p-2" >4 personas</option>
				<option value="p-2" >4 personas</option>
				<option value="p-2" >6 personas</option>
				<option value="p-2" >7 personas</option>
				<option value="p-2" >8 personas</option>
				<option value="p-2" >9 personas</option>
				<option value="p-2" >10 personas</option>
				<option value="p-2" >+10 personas</option>
			</select>
						
		</div>
		
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
		<!-- /Campos para hoteles -->
		
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
		
		<div class="label-group">
		
			<input type="submit" value="Solicitar reserva" name="subscribe" class="btn btn--primary" />
		
		</div>
	
	</form>
	
	<a class="how-to-book venobox-how-to-book" href="includes/como-reservar.php" data-type="ajax">¿No sabes como reservar?</a>
	
</div>

<div class="instant-booking-advice clearfix">
	<div class="instant-booking-advice-icon">
		<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
			<path id="ico-flash" sketch:type="MSShapeGroup" fill="#d0021b" d="M8.803,20.999c-0.193-0.127,3.154-7.16,3.038-7.468c-0.115-0.308-3.664-1.437-3.838-1.98c-0.173-0.543,7.007-8.706,7.196-8.548c0.189,0.158-3.129,7.238-3.038,7.468c0.09,0.23,3.728,1.406,3.838,1.98C16.108,13.024,8.996,21.124,8.803,20.999"/>
		</svg>
	</div>
	<div class="instant-booking-advice-text">
		Las  reservas inmediatas son revisadas por Somrurals para comprobar y evitar datos incorrectos o incompletos.
	</div>
</div>

<div class="advice">
	<p class="icon icon--place">Al realizar la reserva te proporcionaremos los datos completos de localización y de contacto con el propietario de la casa.</p>
</div>