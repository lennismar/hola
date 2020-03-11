<?php include("includes/head.php"); ?>

<body>

<script>
	
$().ready(function() {
	
	$("#CheckOutForm").validate({
		
		rules: {
				
			nombre:"required",
			
			apellidos:"required",

			email: {
				required: true,
				email: true
			},
			
			repetir_email: {
				required: true,
				equalTo: "#email"
			},
				
			/*telefono: {
					required: true,
					digits: true
			},
				
			comentario: "required",*/
				
			check_condiciones: "required",
		},
			
		messages: {
			nombre: "Debes poner tu nombre",
			
			apellidos: "Debes completar tus apellidos",
			
			email: "Por favor, introduce una dirección de email válida",
			
			repetir_email: {
				required: "Por favor, introduce tu email",
				equalTo: "El email debe coincidir"
			},
			check_condiciones: "Por favor, acepta nuestra Política de Privacidad"
		}
	});
});

</script>

<div class="container-main" id="container">

	<?php include("includes/header-clean.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a href="#" class="step-nav-three current"><span>Tus datos y forma de pago</span></a>
					
					<a href="#" class="step-nav-three disable"><span>Confirmación de datos</span></a>
					
					<a href="#" class="step-nav-three disable"><span>¡Terminado!</span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-instant-booking-2.php" method="post" id="CheckOutForm" name="CheckOutForm">
					
						<h2>Datos para la reserva</h2>
						
						<div class="label-group clearfix">
						
							<div class="label-group-three">
								<label>Número de Adultos</label>
							
								<select>
									<option value="a1">1</option>
									<option value="a2" selected>2</option>
									<option value="a3">3</option>
									<option value="a4">4</option>
									<option value="a5">5</option>
									<option value="a6">6</option>
									<option value="a7">7</option>
									<option value="a8">8</option>
								</select>
							</div>
							
							<div class="label-group-three">
								<label>Número de niños</label>
							
								<select>
									<option value="n0" selected>0</option>
									<option value="n1">1</option>
									<option value="n2">2</option>
									<option value="n3">3</option>
									<option value="n4">4</option>
									<option value="n5">5</option>
									<option value="n6">6</option>
									<option value="n7">7</option>
									<option value="n8">8</option>
								</select>
							</div>
							
							<div class="label-group-three">
								<label>Número de bebés</label>
							
								<select>
									<option value="b0" selected>0</option>
									<option value="b1">1</option>
									<option value="b2">2</option>
									<option value="b3">3</option>
									<option value="b4">4</option>
									<option value="b5">5</option>
									<option value="b6">6</option>
									<option value="b7">7</option>
									<option value="b8">8</option>
								</select>
							</div>
											
						</div>
	
						<h2>Tus datos</h2>
						
						<div class="label-group clearfix">
						
							<div class="label-group-two">
							
								<label>Tu nombre</label>
								
								<input type="text"placeholder="" class="" id="nombre" name="nombre" required>
							
							</div>
							
							<div class="label-group-two">
							
								<label>Apellidos</label>
								
								<input type="text"placeholder="" class="" id="apellidos" name="apellidos" required>
							
							</div>
							
							<div class="label-group-two">
							
								<label>Tu email</label>
								
								<input type="text" placeholder="" class="icon-input-email" id="email" name="email" required>
							
							</div>
							
							<div class="label-group-two">
							
								<label>Repetir email</label>
								
								<input type="text" placeholder="" class="icon-input-email" id="repetir_email" name="repetir_email" required>
							
							</div>
							
							<div class="label-group-two">
							
								<label>Pais</label>
								
								<select>
									<option value="c0" selected>España</option>
									<option value="c1">France</option>
									<option value="c2">UK</option>
									<option value="c3">Deutchsland</option>
								</select>
							
							</div>
							
							<div class="label-group-two">
							
								<label>Idioma de contacto</label>
								
								<select>
									<option value="c0" selected>Castellano</option>
									<option value="c1">Català</option>
									<option value="c2">English</option>
									<option value="c3">French</option>
								</select>
							
							</div>
							
							
							<div class="label-group">
								
								<label>Comentario</label>
								
								<textarea class="form-control" rows="3"></textarea>
							
							</div>
							
						</div>

						<h2>Forma de pago</h2>
						
						<script>
							$(function() {
						        $('#forma-de-pago').change(function(){
						            $('.forma-de-pago').hide();
						            $('#' + $(this).val()).show();
						        });
						    });
							
						</script>
						
						<div class="label-group pay-way">
						 
							<select id="forma-de-pago">
								<option value="forma-de-pago2" selected>Tarjeta de Crédito</option>
								<option value="forma-de-pago3" >PayPal</option>
							</select>
											
						</div>
												
						<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago2">
						
							<div class="push-half--bottom"><strong>TARJETA DE CRÉDITO</strong></div>
						
							<ol>
				
								<li>Tu reserva quedará <strong>confirmada en el momento del pago</strong>.</li>
								
								<li>Recibirás un mail de confirmación del pago con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>
							
							</ol>
							
							<img src="assets/img/payment-tarjeta.png" class="push-half--top" alt="Tarjetas aceptadas" width="241" height="36" />
						
						</div>
						
						<div class="label-group check-out-advice forma-de-pago" id="forma-de-pago3" style="display:none">
						
							<div class="push-half--bottom"><strong>PAYPAL</strong></div>
						
							<ol>
				
								<li>En máximo <strong>24 horas confirmaremos la disponibilidad</strong> de este alojamiento</li>
								
								<li>Una vez confirmada, te enviaremos un <strong>email</strong> con un link a nuestra web para que realices el <strong>pago del importe anticipado</strong> mediante <strong>PayPal</strong>.</li>

								<li>Al momento de recibirás un mail de confirmación con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>
							
							</ol>
							
							<img src="assets/img/logo-paypal.svg" class="push-half--top" alt="Pago con PayPal" />
						
						</div>
						
						<div class="label-group">No incluye la tasa turística de 0´99 € por persona y día.</div>
						
						<div class="label-group"><input type="checkbox" class="" name="check-newsletter">Quiero darme de alta en la newsletter de Somrurals para conocer las novedades y promociones.</div>
						
						<div class="label-group"><input type="checkbox" class="" id="check_condiciones" name="check_condiciones" required>Lo he leído y acepto las <a href="#">condiciones y términos generales</a>.</div>
						
						
						<div class="label-group checkout-button">
		
							<input type="submit" value="Continuar" name="continuar" class="btn btn--primary" />
		
						</div>

					
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>
		
		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
		
			<input type="submit" value="Continuar" name="continuar" class="btn btn--primary" />
		
		</div>

	</section>

<?php include("includes/footer.php"); ?>