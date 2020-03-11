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

						<h2>Tu reserva está hecha</h2>
						
						<ul class="label-group block-list-circle-orange">
						
							<li>El pago mediante tarjeta ha sido efectuado. A continuación te remitiremos un correo de confirmación.</li>
						
							<li>En el mismo mail están incluidos los datos de la casa, así como y cualquier información adicional que pudieras necesitar</li>
					
						</ul>

						<p>¡Disfruta de tu estancia!</p>
						
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