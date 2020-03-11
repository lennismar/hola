<!-- Newsletter-->
	
	<section class="wrapper">
	
		<div class="page-container-fixed-pad">
		
			<h2 class="h2-header"><?php echo NEWSLETTER_TITLE; ?></h2>
			
			<p class="text-sub-header"><?php echo NEWSLETTER_SUBTITLE; ?></p>
			
			<div class="newsletter">
			
			<!-- Begin MailChimp Signup Form -->
				
				<div id="mc_embed_signup">
					
				<form action="//somrurals.us5.list-manage.com/subscribe/post?u=e74e70caf4ae83f621f868d39&amp;id=d834c642a7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					
				    <div id="mc_embed_signup_scroll">
					
						<div class="mc-field-group">
						
							<div class="newsletter-input">
								<input type="text" value="" name="FNAME" class="" placeholder="<?php echo NOMBRE; ?>" id="mce-NAME">
							</div>
							
							<div class="newsletter-input">
								<input type="email" value="" name="EMAIL" class="required email icon-input-email" placeholder="<?php echo EMAIL; ?>" id="mce-EMAIL">
							</div>
							
							<div class="newsletter-input">
								<input type="submit" value="<?php echo SUSCRIBETE; ?>" name="subscribe" id="mc-embedded-subscribe" class="btn btn--secondary">
							</div>
							
						</div>
						
						<div id="mce-responses" class="clear" style="margin-top:10px;">
								
							<div class="response alert alert--danger" id="mce-error-response" style="display:none"></div>
								
							<div class="response alert alert--succes" id="mce-success-response" style="display:none"></div>
								
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							
						<div style="position: absolute; left: -5000px;display:inline-block;float:left">
							    
							<input type="text" name="b_e74e70caf4ae83f621f868d39_d834c642a7" tabindex="-1" value="">
							
						</div>
						    <!--<div style="display:inline-block;float:left"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>-->
				    </div>
				
				</form>
				</div>
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';/*}(jQuery));var $mcj = jQuery.noConflict(true);*/
					$.extend($.validator.messages, {
					  required: "Este campo es obligatorio.",
					  remote: "Por favor, rellena este campo.",
					  email: "Por favor, escribe una dirección de correo válida",
					  url: "Por favor, escribe una URL válida.",
					  date: "Por favor, escribe una fecha válida.",
					  dateISO: "Por favor, escribe una fecha (ISO) válida.",
					  number: "Por favor, escribe un número entero válido.",
					  digits: "Por favor, escribe sólo dígitos.",
					  creditcard: "Por favor, escribe un número de tarjeta válido.",
					  equalTo: "Por favor, escribe el mismo valor de nuevo.",
					  accept: "Por favor, escribe un valor con una extensión aceptada.",
					  maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
					  minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
					  rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
					  range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
					  max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
					  min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
					});}(jQuery));var $mcj = jQuery.noConflict(true);
			
				</script>
			<!--End mc_embed_signup-->
			
			</div>
					
		</div>
	
	</section>
