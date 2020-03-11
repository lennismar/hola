<div class="card card-h house-type-1" itemscope itemtype="http://schema.org/Product">
			
		<a itemprop="url" href="<?php echo $lng."/".URL_CASA_RURAL."/".urls_amigables($establiment['title'])."-".$establiment['eid']; ?>" class="card-header" target="_blank">
					
			<div class="house-class"><?php echo GetTitleTipusEstabliment($establiment['tid'],$lng); ?></div>
					
			<div class="house-TypeDot"></div>
					
			<div class="card-title" itemprop="name"><?php echo $establiment['subtitle']; ?></div>
					
		</a>
			
	<div class="card-img">
				
		<div class="card-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		
            <?php

            if(empty($establiment['descripcion_precio'])) $establiment['descripcion_precio'] = PERSONA_NOCHE;

                if(isset($establiment['nitsmin_price']) && $establiment['nitsmin_price'] != '') {
            ?>
                    <?php echo DESDE; ?> <span class="card-price-hightlight"><span itemprop="price"><?php echo $establiment['nitsmin_price']; ?></span><span itemprop="priceCurrency" content="EUR">€</span> </span><?php echo $establiment['descripcion_precio']; ?>
            <?php
                } else {
            ?>
                <?php echo DESDE; ?> <span class="card-price-hightlight"><span itemprop="price"><?php echo $establiment['bestprice']; ?></span><span itemprop="priceCurrency" content="EUR">€</span> </span><?php echo $establiment['descripcion_precio']; ?>
            <?php
                }
            ?>


		</div>
		
		<?php 
		
		if($reserva_inmediata==true){
			$db->where('eid',$establiment['eid']);
			$rs=$db->getOne('establiments','reserva_inmediata');
			
			//Si la casa esta marcada como reserva inmediata
			if($rs['reserva_inmediata']==1){
				//Marca de reserva inmediata 
				include("includes/instant-booking.php"); 
			}
		
		}?>

        <img itemprop="image" src="<?php echo CDN_BASE."images/uploads/establiments/".str_replace('/', '/thumb_', ImagePrincipalEstabliment($establiment['eid'])); ?>" alt="Som Rurals - <?php echo $establiment['title']; ?>" width="739" height="397">


        <!-- EN EL CSS PONER AL FINAL del TODO, en la hoja, o en la página-->
        <style>

            @media (min-width:600px) {

                .card-img {
                    overflow: hidden;
                }

                .card-img img {
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: cover;
                }
            }
        </style>

    </div>
	
	<a href="<?php echo $lng."/".URL_CASA_RURAL."/".urls_amigables($establiment['title'])."-".$establiment['eid']; ?>" class="card-link">
	
		<div class="card-content">
				
			<div class="card-location"><span class="icon icon--place"><?php echo GetTitleLocalitat($establiment['lid']); ?> (<?php echo GetTitleComarca($establiment['comid']); ?>, <?php echo GetTitleProvincia($establiment['pvid']); ?>)</span> 
<?php
$dm = $establiment['daysmin'];
if ($establiment['daysmin'] < $nitsmin_global) $dm = $nitsmin_global;
?>
            <span class="alert-small-pill alert-small-pill--warning"><?php echo MINIMO . " ".$dm . " " .NOCHES; ?></span></div>

			<?php $persons_extra = GetNumPersonsExtraEstabliment($establiment['eid']); 
				if($persons_extra>0){
					$total=$establiment['persons'] + $persons_extra;
				}else{
					$total=$establiment['persons'];
				}

			?>
			<!-- Rating -->
			<?php


			$media_total = ValoracionMediaCasa($establiment['eid']);
			$numvaloraciones = NumValoracionesCasa($establiment['eid']);

			// echo "<p>" . $establiment['eid'] ."</p>";
			// echo "<p>$media_total</p>";
			// echo "<p>$numvaloraciones</p>";
			?>
			<div class="clearfix card-rating">
					<?php if ($media_total>0): ?>
						<div class="rating">
							<?php echo ValoracionMediaCasaStars($establiment['eid'] ); ?>
						</div>	
						<div class="comments-number">(<span id="_countReview"><?php echo $numvaloraciones; ?></span> <?php echo COMENTARIOS; ?>)
						</div> 
					<?php endif; ?>
			</div>
			<div class="card-items-core">
				<span class="card-person"><?php echo PERSONAS; ?> <strong><?php echo $establiment['persons_min']; ?> - <?php echo $total; ?></strong></span>
				<span class="card-rooms"><?php echo HABITACIONES; ?> <strong><?php if ($establiment['bedrooms']==0) echo "-"; else echo $establiment['bedrooms']; ?></strong></span>
				<span class="card-baths"><?php echo BANOS; ?> <strong><?php if ($establiment['bathrooms']==0) echo "-"; else echo $establiment['bathrooms']; ?></strong></span>
			</div>
				
			<div class="card-items-services-core">
<?php
$cont=1;
//$serveis_query = mysqli_query("SELECT serid, title_".$lng.", css FROM serveis WHERE css='pool' OR css='barbacue' OR css='wifi' OR css='pets' OR css='garden' OR css='terrace' OR css='air' OR css='fireplace' ORDER BY orden ASC");
$serveis_query ="SELECT serid, title_".$lng.", css FROM serveis WHERE css='pool' OR css='barbacue' OR css='wifi' OR css='pets' OR css='garden' OR css='terrace' OR css='air' OR css='fireplace' ORDER BY orden ASC";
$rs_serveis=$db->rawQuery($serveis_query);
//while($serveis = mysqli_fetch_array($serveis_query)){
foreach($rs_serveis as $serveis){
	if (GetServeis($establiment['eid'], $serveis['serid'])=='yes' && $cont<=3) {
?>           
				<span class="icon icon--<?php echo $serveis['css']; ?>"><?php echo $serveis['title_'.$lng]; ?></span>
<?php 
		$cont++;
	}
} 
?>
			</div>
				
			<div class="card-description">
            	<?php echo $establiment['description_small']; ?> 
                
            	<?php if (HaveServeisExt($establiment['eid'])) { ?> <span class="alert-small-pill alert-small-pill--succes"><?php echo SERVICIOS_EXTERIORES_COMPARTIDOS; ?></span> <?php } ?>
            </div>
				
			<div class="card-items-tags">
<?php		
			//$query_perfil = mysqli_query("SELECT eid, perid FROM establiments_perfils WHERE eid = ".$establiment['eid']." ORDER BY RAND() LIMIT 3");
			$db->orderBy('rand()');
			$db->where('eid',$establiment['eid']);
			$query_perfil=$db->get('establiments_perfils',3,'eid, perid');
			//while($rs_perfil = mysqli_fetch_array($query_perfil)){
			foreach($query_perfil as $rs_perfil){
?>
                <span class="tag"><?php echo GetTitlePerfil($rs_perfil['perid'],$lng); ?></span>
<?php 
			}
?>
            </div>
				
		</div>
	</a>
</div>

