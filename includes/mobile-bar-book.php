<div class="mobile-bar mobile-bar--bottom" id="mobile-nav-book">
	
	<div class="mobile-book-info">
		<div class="mobile-book-text"><?php echo PRECIO . " " . PERSONA_NOCHE . " " .DESDE; ?></div>
		<div class="mobile-book-price"><span itemprop="price"><?php echo $bestprice; ?></span><span itemprop="priceCurrency" content="EUR">€</span></div>
	</div>
	
	<a class="btn btn--tertiary btn-mobile-book  btn-smooth-scroll" id="btn-scroll" href="<?php echo $current_url; ?>#book-form"><?php echo RESERVAR; ?></a>
	
</div>