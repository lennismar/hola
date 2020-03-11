<div class="mobile-bar mobile-bar--bottom" id="mmobile-nav-filter">
	<?php 
	$varsget= "lng=".$lng."&where_consulta=".$where_consulta."&tipocasa=".$tipocasa."&persons=".$persons."&price=".$price."&serid=".$serid."&perid=".$perid;
	if (is_array($serid)) {
		$varsget.="&serid=";
		foreach ($serid as $servicio) $varsget.= $servicio."+";
		$varsget = rtrim($varsget, '+');
	}
	
	if (is_array($perid)) {
		$varsget.="&perid=";
		foreach ($perid as $perfil) $varsget.= $perfil."+";
		$varsget = rtrim($varsget, '+');
	}
	?>
	<a class="btn btn--secondary btn-mobile-filters venobox-filters-mobile  btn-smooth-scroll" 
    href="includes/filters-mobile.php?<?php echo $varsget; ?>" 
    data-type="ajax" data-overlay="#e7e7e5">Mostrar filtros</a>
	
</div>