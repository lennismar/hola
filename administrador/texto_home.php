<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
	<div id="wrapper">		
		<?php include 'includes/topbar.php'?>
		<?php include 'includes/sidebar.php'?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Texto Home</h2>
                <p><button class="button_colour orange round_all" onClick="location.href='texto_home_edit.php'"><span>Editar</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Text</th> 
						</tr> 
					</thead> 
					<tbody>              
<?php
	/*$rs_query = mysqli_query("SELECT texto_home_ca FROM texto_home");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$rs_query=$db->get('texto_home',null,'texto_home_ca');
	foreach($rs_query as $rs){
?>                                
						<tr> 
							<td><?php echo $rs['texto_home_ca'];?></td> 
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