<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';

?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Landings</h2>
				<!--<p>Administrar l'establiment</p>-->
                <p><button class="button_colour orange round_all" onClick="location.href='landings_edit.php'"><span>+ Nova Landing</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<th>Titol</th> 
							<th>URL CA</th>
							<th>URL ES</th>
                            
                            <th>Publicat</th>
						</tr> 
					</thead> 
					<tbody> 
                    
<?php
	/*$rs_query = mysqli_query("SELECT id, title_ca, title_es, url_ca, url_es, status FROM landings ORDER BY id ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('id','ASC');
	$rs_query=$db->get('landings',null,'id, title_ca, title_es, url_ca, url_es, status');
	foreach($rs_query as $rs){
?>                      
						<tr> 
							<td><a href="landings_edit.php?id=<?php echo $rs['id'];?>"><?php echo $rs['title_ca']; ?></a></td> 
                            <td><a href="http://www.somrurals.com/ca/landing/<?php echo $rs['url_ca']. "-".$rs['id'];?>" target="_blank">www.somrurals.com/ca/landing/<?php echo $rs['url_ca']. "-".$rs['id'];?></a></td> 
                            <td><a href="http://www.somrurals.com/es/landing/<?php echo $rs['url_es']. "-".$rs['id'];?>" target="_blank">www.somrurals.com/es/landing/<?php echo $rs['url_es']. "-".$rs['id'];?></a></td> 
                            <td class="center"><?php echo GetYesNo($rs['status']); ?></td>
						</tr> 
<?php
	}
?>
                	</tbody> 
				</table>
			</div>
		</div>
		
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>

<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
		
<?php include 'includes/closing_items.php'?>