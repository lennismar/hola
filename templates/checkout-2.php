<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header-clean.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a href="checkout-1.php" class="step-nav-three complete"><span>Tus datos y forma de pago</span></a>
					
					<a href="#" class="step-nav-three current"><span>Confirmación de datos</span></a>
					
					<a href="#" class="step-nav-three disable"><span>¡Terminado!</span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-3.php" method="post" id="CheckOutForm" name="CheckOutForm">
					
						<h1>Por favor, revisa tus datos</h1>
					
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
						
							<li>Transferencia bancaria</li>						
						
						</ul>
						
						<div class="label-group">
						
							<a href="checkout-1.php">Modificar Datos</a>			
						
						</div>
						
						<div class="label-group check-out-advice">
						
							<ol>
								<li>En máximo <strong>48 horas confirmaremos la disponibilidad</strong> de este alojamiento</li>
								
								<li>Una vez confirmada, te enviaremos un <strong>email</strong> con el <strong>nº de cuenta y concepto</strong> al que realizar la la <strong>tranferencia</strong> indicada por el importe de 365€ en concepto de <strong>reserva y pago anticipado</strong>. El plazo para realizar este pago es de <strong>48 horas</strong>.</li>
								
								<li>Recibirás un mail de confirmación con todos los datos de contacto de la casa rural. Así mismo, el <strong>importe restante</strong> se abonará en la casa al propietario.</li>
							
							</ol>
						
						</div>
						
						<div class="label-group checkout-button">
		
							<input type="submit" value="Confirmar reserva" name="continuar" class="btn btn--primary" />
		
						</div>

					
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>
		
		<div class="label-group checkout-button only-mobile-and-tablet push--bottom ">
		
			<input type="submit" value="Confirmar reserva" name="continuar" class="btn btn--primary" />
		
		</div>

	</section>

<?php include("includes/footer.php"); ?>