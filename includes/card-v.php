<a href="<?php echo $lng."/".URL_CASA_RURAL."/".urls_amigables($rs['title'])."-".$rs['eid']; ?>" id="_urlProduct" itemprop="url" class="card-link" target="_blank">
		
	<div class="card house-type-1" itemscope itemtype="http://schema.org/Product" itemref="_urlProduct">
				
		<div class="card-header">
					
			<div class="house-class"><?php echo GetTitleTipusEstabliment($rs['tid'],$lng); ?></div>
					
			<div class="house-TypeDot"></div>
					
			<div class="card-title" itemprop="name"><?php echo $rs['subtitle_'.$lng]; ?></div>
					
		</div>
				
		<div class="card-img">
				
			<div class="card-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<?php echo DESDE; ?> <span class="card-price-hightlight"><span itemprop="price"><?php echo $bestprice; ?></span><span itemprop="priceCurrency" content="EUR">€</span> </span><?php echo PERSONA_NOCHE; ?>
			</div>

			<?php if($reserva_inmediata==true){
				$db->where('eid',$rs['eid']);
				$rs2=$db->getOne('establiments','reserva_inmediata');
			   
				//Si la casa esta marcada como reserva inmediata
				if($rs2['reserva_inmediata']==1){
					//Marca de reserva inmediata 
					include("includes/instant-booking.php"); 
				}
				
			}?>	
			<img itemprop="image" src="<?php echo CDN_BASE."images/uploads/establiments/".str_replace('/', '/thumb_', ImagePrincipalEstabliment($rs['eid'])); ?>" alt="Som Rurals - <?php echo $rs['title']; ?>" width="739" height="397" />
					
		</div>
			
		<div class="card-content">
			
			<div class="card-location"><span class="icon icon--place"><?php echo GetTitleLocalitat($rs['lid']); ?> (<?php echo GetTitleComarca($rs['comid']); ?>, <?php echo GetTitleProvincia($rs['pvid']); ?>)</span></div>
			
			<div class="card-items-core">
				
				<span class="card-person"><?php echo PERSONAS; ?> <strong><?php echo $rs['persons_min']?> - <?php echo $rs['persons']?></strong></span>
				<span class="card-rooms"><?php echo HABITACIONES; ?> <strong><?php if ($rs['bedrooms']==0) echo "-"; else echo $rs['bedrooms']; ?></strong></span>
				<span class="card-baths"><?php echo BANOS; ?> <strong><?php if ($rs['bathrooms']==0) echo "-"; else echo $rs['bathrooms']; ?></strong></span>
				
			</div>
			
			<div class="card-items-services-core">
 <?php
$cont=1;
//$serveis_query = mysqli_query("SELECT serid, title_".$lng.", css FROM serveis WHERE css='pool' OR css='barbacue' OR css='wifi' OR css='pets' OR css='garden' OR css='terrace' OR css='air' OR css='fireplace' ORDER BY orden ASC");
$db->orderBy('orden','ASC');
$db->where('css','pool');
$db->orWhere('css','barbacue');
$db->orWhere('css','wifi');
$db->orWhere('css','pets');
$db->orWhere('css','garden');
$db->orWhere('css','terrace');
$db->orWhere('css','air');
$db->orWhere('css','fireplace');
$serveis_query=$db->get('serveis',null,"serid, title_".$lng.", css");

//while($serveis = mysqli_fetch_array($serveis_query)){
foreach($serveis_query as $serveis){
	if (GetServeis($rs['eid'], $serveis['serid'])=='yes' && $cont<=3) {
?>           
				<span class="icon icon--<?php echo $serveis['css']; ?>"><?php echo $serveis['title_'.$lng]; ?></span>
<?php 
		$cont++;
	}
} 
?>
			</div>
			
			<div class="card-description"><?php echo $rs['description_small_'.$lng]; ?></div>
			
			<div class="card-items-tags">
<?php		
			//$query_perfil = mysqli_query("SELECT eid, perid FROM establiments_perfils WHERE eid = ".$rs['eid']." ORDER BY RAND() LIMIT 3");
			$db->orderBy('rand()');
			$db->where('eid',$rs['eid']);
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
		
		<div class="card-btn"><?php echo VER_CASA; ?></div>
			
	</div>

</a>