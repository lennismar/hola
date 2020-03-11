<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
			
				<div class="step-nav clearfix push-half--bottom">
				
					<a href="#" class="step-nav-three complete"><span>Tus datos y forma de pago</span></a>
					
					<a href="#" class="step-nav-three complete"><span>Confirmación de datos</span></a>
					
					<a href="#" class="step-nav-three current"><span>¡Terminado!</span></a>
				
				</div>
				
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-3.php" method="post" id="CheckOutForm" name="CheckOutForm">
					
						<h1>¡ENHORABUENA!</h1>
					
						<h2>Tu solicitud de pre-reserva está hecha</h2>
						
						<ul class="label-group block-list-circle-orange">
						
							<li>En un plazo máximo de 48 horas confirmaremos la disponibilidad de este alojamiento</li>
							
							<li>Una vez confirmada, te enviaremos un email con el nº de cuenta y concepto al que realizar la la tranferencia por el importe de 365€ en concepto de reserva y pago anticipado. El plazo para realizar esta transferencia es de 48 horas.</li>
							
							<li>Una vez confirmada tu transferencia, te haremos llegar el mail de confirmación de reserva con todos los datos de la casa, así como y cualquier información adicional que pudieras necesitar</li>					
						
						</ul>
						
						<div class="label-group check-out-advice">
						
							Si tienes cualquier duda puedes llamarnos al <a href="tel: 932935527">93 293 55 27</a> o escribirnos a través de nuestro formulario de <a href="contacto.php">contacto</a>. 
						
						</div>
						
						<div class="label-group">Mientras tanto, puedes seguirnos a través de nuestra cuenta de <a href="https://twitter.com/somrurals">Twitter</a>, <a href="https://www.facebook.com/somrurals">Google+</a> o hacerte fan en <a href="https://plus.google.com/117022694086662550685/posts">Facebook</a>.</div>
					
					</form>
				
				</div>
				
			</article>
			
			<aside class="col-special-one-third" id="fixed-book-form">
			
				<?php include("includes/checkout-form.php"); ?>
			 					
			</aside>
			
		</div>

	</section>

<?php include("includes/footer.php"); ?>