<div class="mobile-bar mobile-bar--bottom" id="mobile-nav-book">
	
	<div class="mobile-book-info">
		<div class="mobile-book-text">Persona/Noche desde</div>
		<div class="mobile-book-price">123,50€</div>
	</div>
	
	<a class="btn btn--tertiary btn-mobile-book  btn-smooth-scroll" id="btn-scroll" href="#book-form" onclick="ga('send', 'event', 'Ficha', 'Click', 'Btn Mobile -Reserva Ya-');">Reservar</a>
	
</div>

<script>
	
	var altura = $('.house-main').height();
	
	$(window).scroll(function() {
			
	    if ($(this).scrollTop() > $('.house-main').height() ) {
	        $('#mobile-nav-book').css({
	            'opacity': '0'
	        });
	    }
	    
	    else {
		    $('#mobile-nav-book').css({
	            'opacity': '1'
	        });
	    }
	});
</script>