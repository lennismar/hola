<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php'; 
if ($_SESSION['type_user']=='propietario') header('location: images_edit.php?id='.$_SESSION['eid']);
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Galeria d'Imatges</h2>
				<!--<p>Administrar l'establiment</p>-->
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<th>Establiment</th> 
                            <th>Imatges</th>
						</tr> 
					</thead> 
					<tbody> 
                    
<?php
	/*$rs_query = mysqli_query("SELECT eid, title FROM establiments ORDER BY title ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title','ASC');
	$rs_query=$db->get('establiments',null,'eid, title');
	foreach($rs_query as $rs){
?>                      
						<tr> 
							<td><a href="images_edit.php?id=<?php echo $rs['eid'];?>"><?php echo $rs['title']; ?></a></td> 
                            <td class="center"><?php echo GetNumImagesEstabliment($rs['eid']); ?></td>
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