<a href="<?php if(!empty($place['external_url'])) { echo $place['external_url']; } else {echo $lng."/".URL_RECURSOS_TURISTICOS."/".urls_amigables(GetTitleProvincia($place['pvid']))."/".urls_amigables(GetTitleComarca($place['comid']))."/".urls_amigables($place['title_'.$lng])."-".$place['idrecurso'];}?>" class="card-link" target="_blank">
	<div class="card-places">
		<div class="card-places-img">		
			<img src="<?php echo "image.php?width=450&height=269&cropratio=450:269&quality:80&image=/images/uploads/recursos/".$place['image']; ?>" alt="<?php echo $place['title_'.$lng]; ?>" width="450" height="269" />
		</div>
			
		<div class="card-places-title">
			<?php echo $place['title_'.$lng]; ?>
		</div>
		
		<div class="card-places-content">
			<?php echo $place['smalldescription_'.$lng]; ?>
		</div>
		
		<div class="card-places-link">
			<?php echo SEGUIR_LEYENDO; ?>
		</div>
	</div>
</a>