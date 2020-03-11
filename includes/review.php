<div class="review" itemprop="review" itemscope itemtype="http://schema.org/Review">
							
	<div class="review-header">
		<span class="review-author" itemprop="author"><?php echo Query('reservations', 'ofirstname', 'resid', $rs['resid']); ?></span>
		<span class="review-author-location">(<?php echo ucwords(Query('reservations', 'ocity', 'resid', $rs['resid'])); ?>)</span>
		<span class="review-date"><?php echo date("d-m-Y",strtotime($rs['date']));?></span>
								
	</div>
								
	<div class="review-content">
								
		<p><strong><?php echo VALORACIONES_COMO; ?></strong> <?php echo CommentsHow($rs['como']);?></p>
		<span itemprop="description">
			<p><?php echo $rs['comments_'.$lng]; ?></p>
		</span>
	</div>
							
</div>
