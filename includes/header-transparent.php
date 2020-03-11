<!-- Fixed navbar -->

<header class="wrapper-nav nav-transparent">

	<div class="page-container-fixed">
	
		<a class="logo" href="<?php echo $lng."/";?>" title="Somrurals. La teva casa rural a Catalunya">Som Rurals</a>
		
		<nav class="nav-desktop" id="menu">
		
			<ul class="nav">
	          
	            <li><a href="<?php echo $lng."/".URL_NOSOTROS;?>"><?php echo QUIENES_SOMOS; ?></a></li>
	            <li><a href="<?php echo $lng."/".URL_COMO_RESERVAR;?>"><?php echo COMO_RESERVAR; ?></a></li>
	            <li>
	            
	            	<form class="search_header" method="post" action="search.php">
					    <input id="search-box" type="text" name="buscador" placeholder="<?php echo NOMBRE_REFERENCIA; ?>">
					</form>
	            
	            </li>
	            <li><a href="<?php echo $lng."/".URL_CONTACTO;?>"><?php echo CONTACTO; ?></a></li>
	            
	            <li>
	            	
					<div id="dd" class="wrapper-dropdown-3" tabindex="1">
						<?php 
						switch ($lng) {
							case 'es':
								echo "<span>Castellano</span>";
								break;
							case 'ca':
								echo "<span>Català</span>";
								break;
							case 'en':
								echo "<span>English</span>";
								break;
							case 'fr':
								echo "<span>Français</span>";
								break;

						}
						?>
                        <ul class="dropdown">
							<li onclick="location.href = '<?php echo URL_BASE; ?>es/';"><a href="/es/" target="_self"><span class="icon icon--flag-es">Castellano</span></a></li>
							<li onclick="location.href = '<?php echo URL_BASE; ?>ca/';"><a href="/ca/" target="_self"><span class="icon icon--flag-cat">Català</span></a></li>
							<li onclick="location.href = '<?php echo URL_BASE; ?>en/';"><a href="/en/" target="_self"><span class="icon icon--flag-en">English</span></a></li>
							<li onclick="location.href = '<?php echo URL_BASE; ?>fr/';"><a href="/fr/" target="_self"><span class="icon icon--flag-fr">Français</span></a></li>
						</ul>
					</div>
	            </li>
			</ul>
					
		</nav>
		
		<a href="javascript:hideshow(document.getElementById('menu'))" class="menu-trigger" id="btn-show-menu">
						
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="45px" height="45px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
				<rect x="10" y="12" fill="#fff" width="25" height="3"/>
				<rect x="10" y="20" fill="#fff" width="25" height="3"/>
				<rect x="10" y="28" fill="#fff" width="25" height="3"/>
			</svg>
			
		</a>
		
	</div>

</header>