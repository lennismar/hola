<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
	<div id="wrapper">		
		<?php include 'includes/topbar.php'?>
		<?php include 'includes/sidebar.php'?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Tipus d'allotjament</h2>
				<p>Administrar tipus d'allotjaments</p>
                <p><button class="button_colour orange round_all" onClick="location.href='tipus_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Titol</th> 
							<th>Número d'allotjaments</th>
						</tr> 
					</thead> 
					<tbody>              
<?php
	/*$rs_query = mysqli_query("SELECT tid, title_ca FROM tipus ORDER BY title_ca ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title_ca','ASC');
	$rs_query=$db->get('tipus',null,'tid, title_ca');
	foreach($rs_query as $rs){
?>                                
						<tr> 
                        	<td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='tipus_act.php?action=del&id=<?php echo $rs['tid']; ?>'}" title="">X</a></td>
							<td><a href="tipus_edit.php?id=<?php echo $rs['tid']; ?>"><?php echo $rs['title_ca'];?></a></td> 
							<td class="center"><?php echo GetNumEstabliments($rs['tid']) ?></td>
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