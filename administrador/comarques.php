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
				<h2>Comarques</h2>
				<p>Administrar les comarques catalanes</p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<th>Comarca</th>
						</tr> 
					</thead> 
					<tbody>              
<?php
	//$rs_query = mysqli_query("SELECT comid, title FROM comarques ORDER BY title ASC");
	//while($rs = mysqli_fetch_array($rs_query)) {
	$cols=Array("comid","title");
	$db->orderBy("title","asc");
	$rs_result=$db->get("comarques",null,$cols);	
	foreach($rs_result as $rs){
?>                                
						<tr> 
							<td><a href="comarques_edit.php?id=<?php echo $rs['comid']; ?>"><?php echo $rs['title'];?></a></td> 
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