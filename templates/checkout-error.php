<?php include("includes/head.php"); ?>

<body>

<div class="container-main" id="container">

	<?php include("includes/header-clean.php"); ?>
			
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<article  class="col-pad col-pad--two-third" id="main">
								
				<div class="clearfix checkout-form-process">
				
					<form action="checkout-3.php" method="post" id="CheckOutForm" name="CheckOutForm">
						<h1>Ha habido un error en el pago </h1>
				
						<p>Parece que el pago no se ha podido completar. Por favor, inténtalo de nuevo.</p>

						<div class="alert alert--info">
							
							A continuación serás redirigido a la pasarela de pago segura del banco. Por favor no salgas de la página ni cierres el navegador durante este proceso.
						
						</div>
						
						<div class="label-group checkout-button">
		
							<input type="submit" value="Pagar" name="continuar" class="btn btn--primary" />
		
						</div>

					</form>
					
				</div>
				
				<div class="label-group check-out-advice push--top">
					Si el error persiste puedes llamarnos al <a href="tel: 932935527">93 293 55 27</a> o escribirnos a través de nuestro formulario de <a href="contacto.php">contacto</a>. 
				
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