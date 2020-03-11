<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header-clean.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a href="checkout-1.php" class="step-nav-two current"><span>Confirmación de datos y pago</span></a>
										
					<a href="#" class="step-nav-two disable"><span>¡Terminado!</span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-tarjeta-2.php" method="post" id="CheckOutForm" name="CheckOutForm">
						
						<p>Realiza el <strong>pago</strong> con tarjeta de crédito para <strong>confirmar tu reserva</strong>.</p>
					
						<h1>Tu reserva</h1>
					
						<h2>Datos de la reserva</h2>
						
						<ul class="label-group checkout-confirm-list">
						
							<li>Huéspedes: <strong>2 adultos, 2 niños, 1 bebé</strong></li>						
						
						</ul>
							
						<h2>Tus datos</h2>
						
						<ul class="label-group checkout-confirm-list">
						
							<li>Tu nombre: <strong>Alberto</strong></li>
							
							<li>Apellidos: <strong>del Río</strong></li>	
							
							<li>Tu email: <strong> alberto@delirios.es</strong></li>	
							
							<li>Telefono: <strong>666 666 666</strong></li>	
							
							<li>Localidad <strong>Madrid</strong></li>	
							
							<li>País <strong>España</strong></li>	
							
							<li>Idioma de contacto <strong>Castellano</strong></li>	
							
							<li>Comentario<br><strong>Dispone de servicio de desayunos, una cocina equipada para los huéspedes "bajo petición y disponibilidad", salón común con TV y terraza con vistas a las montañas del Pallars Sobirà. El apartamento de la casa cuenta con un apartamento de 4 plazas con 2 habitaciones: una de matrimonio y una con dos camas individuales, ambas con baño privado.</strong></li>						
						
						</ul>
						
						<h2>Forma de pago</h2>
						
						<ul class="checkout-confirm-list">
						
							<li>Tarjeta de crédito</li>						
						
						</ul>
						
						
						
						<div class="label-group check-out-advice">
							
							<div class="push-half--bottom"><strong>TARJETA DE CRÉDITO</strong></div>
						
							<ol>
				
								<li>Tu reserva quedará <strong>confirmada en el momento del pago</strong>.</li>
								
								<li>Recibirás un mail de confirmación del pago con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>
							
							</ol>
							
							<img src="assets/img/payment-tarjeta.png" class="push-half--top" alt="Tarjetas aceptadas" width="241" height="36" />
						
						</div>
						
						<div class="label-group push-half--top clearfix">
						
							<div class="label-group-two">
							
								<label><strong>POR FAVOR, INTRODUCE TU DNI</strong></label>
								
								<input type="text" placeholder="123456789X" class="" id="dni" name="dni" required>
								
								<p class="explanatory-text push-half--top">El número de DNI/Pasaporte será validado en la casa rural para comprobar que eres beneficiario de la reserva.</p>
							
							</div>
							
						</div>
						
						<div class="alert alert--info">
							
							A continuación serás redirigido a la pasarela de pago segura del banco. Por favor no salgas de la página ni cierres el navegador durante este proceso.
						
						</div>
						
						<div class="label-group checkout-button">
		
							<input type="submit" value="Pagar" name="continuar" class="btn btn--primary" />
		
						</div>
					
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>
		
		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
		
			<input type="submit" value="Pagar" name="continuar" class="btn btn--primary" />
		
		</div>

	</section>

<?php include("includes/footer.php"); ?>