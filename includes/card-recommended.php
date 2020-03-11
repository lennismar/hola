<?php		
			//$query_perfil = mysqli_query("SELECT eid, perid FROM establiments_perfils WHERE eid = ".$rs['eid']." ORDER BY RAND() LIMIT 1");
			$db->orderBy('rand()');
			$db->where('eid',$rs['eid']);
			$query_perfil=$db->get('establiments_perfils',1,'eid,perid');
			//while($rs_perfil = mysqli_fetch_array($query_perfil)){
			foreach($query_perfil as $rs_perfil){
?>
<a href="<?php echo $lng."/".URL_SEARCH."/all/all/pers:none/price:all/theme:".$rs_perfil['perid'];?>" class="card-link">
		
	<div class="card-others">
				
		<div class="card-others-img">
			<img src="<?php echo CDN_BASE."images/uploads/establiments/".str_replace('/', '/thumb_', ImagePrincipalEstabliment($rs['eid'])); ?>" alt="Som Rurals - <?php echo $establiment['title']; ?>" width="450" height="269" />
		</div>
			
		<div class="card-others-title">

                <?php 
				echo GetDescPerfil($rs_perfil['perid'],$lng); 
				?>     
<?php 
			}
?>
		</div>
		
		<div class="card-others-link">
			<?php 
			if ($rs['subtitle_'.$lng]!="") echo $rs['subtitle_'.$lng]; else echo $rs['title'];
			
			?>
		</div>
			
	</div>

</a>