<h3 class="h3-header push--top"><?php echo MEJORES_ZONAS_CATALUNA;
?></h3>
			<div class="row">
<?php 
	$cont_establiment = 1;
	$query ="SELECT eid, title, subtitle_".$lng.", persons, persons_min, description_small_".$lng.", lid, pvid, tid, comid, published, dateadded, recommended FROM establiments WHERE published = 1 AND home = 1 AND eid <> ".$recommended[0]." AND eid <> ".$recommended[1]." AND eid <> ".$recommended[2]." ORDER BY RAND() LIMIT 4";
	$rs_query=$db->rawQuery($query);
//while(($rs = mysql_fetch_array($query)) && ($cont_establiment <= 3)){
	
	/*$db->orderBy('rand()');
	$db->where('published',1);
	$db->where('home',1);
	$db->where('eid',$recommended[0],'<>');
	$db->where('eid',$recommended[1],'<>');
	$db->where('eid',$recommended[2],'<>');
	$rs_query=$db->get('establiments',4,"eid, title, subtitle_".$lng.", persons, persons_min, description_small_".$lng.", lid, pvid, tid, comid, published, dateadded, recommended");
	*/
	
		foreach($rs_query as $rs):
			if($cont_establiment<=3): ?>
			    <div class="list-col-three">
			        <?php include("card-bestzones.php");?>	
			    </div>
		<?php endif; ?>
		<?php 
			$cont_establiment++;
			endforeach;
		?>					    
		</div>