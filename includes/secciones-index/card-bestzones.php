<a href="<?php echo $lng."/".URL_CASA_RURAL."/".urls_amigables($rs['title'])."-".$rs['eid']; ?>" class="card-link">
		
	<div class="card-others">
				
		<div class="card-others-img">
			<img src="<?php echo CDN_BASE."images/uploads/establiments/".str_replace('/', '/thumb_', ImagePrincipalEstabliment($rs['eid'])); ?>" alt="Som Rurals - <?php echo $establiment['title']; ?>" width="450" height="269" />
		</div>
			
		<div class="card-others-title">
			<?php echo CASA_RURAL . " " . EN . " ". GetTitleComarca($rs['comid']); ?>
		</div>
		
		<div class="card-others-link">
			<?php if ($rs['subtitle_'.$lng]!="") echo $rs['subtitle_'.$lng]; else echo $rs['title']; ?>
		</div>
			
	</div>

</a>