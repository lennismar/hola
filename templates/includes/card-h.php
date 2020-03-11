<div class="card card-h" itemscope itemtype="http://schema.org/Product">
	
	<div class="card-img">
		
		<div class="card-photo">
			<img itemprop="image" src="assets/img/foto-casa.jpg" alt="foto casa" width="739" height="397" />
		</div>
		
		<!-- carrusel de fotos -->
		<!--
		<div class="photos-carousel owl-photo-theme">
			
			<img itemprop="image" src="assets/img/foto-casa.jpg" alt="foto casa" width="739" height="397" />
			
			<img itemprop="image" src="assets/img/foto-casa2.jpg" alt="foto casa" width="739" height="397" />
			
			<img itemprop="image" src="assets/img/foto-casa3.jpg" alt="foto casa" width="739" height="397" />
			
			<img itemprop="image" src="assets/img/foto-casa4.jpg" alt="foto casa" width="739" height="397" />
			
		</div>
		-->
		<!--
		<div class="fotorama" data-width="100%" data-height="100%" data-maxheight="300" data-fit="cover" data-loop="true">
			<img itemprop="image" src="assets/img/foto-casa.jpg">
			<img src="assets/img/foto-casa2.jpg">
			<img src="assets/img/foto-casa3.jpg">
			<img src="assets/img/foto-casa4.jpg">
		</div>
		-->
					
	</div>
	
	<div class="card-main">
		
		<div class="card-top">
			
			<div class="card-top-left">
		
				<a itemprop="url" href="ficha.php" class="card-header link-external">
							
					<div class="house-class">Casa rural independiente</div>
							
					<div class="house-TypeDot"></div>
							
					<h2 class="card-title" itemprop="name">
						Masía rural para grupos, ideal para relajarse y desconectar. Piscina, granja, parque infantil y barbacoa.
					</h2>
							
				</a>
			
				<div class="card-location">
						
					<div class="icon icon--place">
						
						<a href="#" class="btn-more-card text-orange" onclick='return false;'>Más</a>
							
						<span class="location-card" style="display: none;">Buda</span>, 
							
						Baix Ampurdá, Girona
							
					</div>
											
				</div>
				
			</div>
			
			<div class="card-top-right">
				
				<!-- precio -->
				<div class="card-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		
					Desde <span class="card-price-hightlight"><span itemprop="price">40,5</span><span itemprop="priceCurrency" content="EUR">€</span> </span>Pers. / Noche
		
				</div>
				
				
				<!-- Rating -->
				<div class="card-rating">
								
					<!-- Include rating stars -->
					<?php include("includes/rating.php"); ?>
					
					<div class="comments-number">
						<strong id="_countReview">4</strong> Comentarios
					</div>

				</div>
				
				<!-- Marca de reserva inmediata -->
				<?php include("includes/instant-booking.php"); ?>		
				
			</div>
		</div>
		<!-- End cart top -->
		
		<div class="card-content">
		
			<div class="card-items-core">
	
				<strong>8</strong> Personas,  <strong>4</strong> Habitaciones, <strong>3</strong> Baños 
				
				<span class="alert-small-pill alert-small-pill--succes">Servicios exteriores compartidos</span>

			</div>
					
			<div class="card-items-services-core">
				<span class="icon icon--pool">Piscina</span>
				<span class="icon icon--wifi">WiFi Gratis</span>
				<span class="icon icon--fireplace">Chimenea</span>
			</div>
			
			<a href="ficha.php" class="card-link link-external">	
				<div class="card-description">
					Amplia casa rural con estilo rústico, en plena naturaleza. Descanso muy cerca de Barcelona. Destaca el futbolín.
									
					<span class="alert-small-pill alert-small-pill--warning">Mínimo 3 noches</span>

				</div>
			</a>
			
			<div class="card-items-tags">
				Para: 
				<span class="tag">Grupos,</span> 
				<span class="tag">Montaña,</span> 
				<span class="tag">Familiar</span>
			</div>
			
		</div>
		
	</div>
	
</div>