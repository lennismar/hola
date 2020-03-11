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
				<h2>Mínim Nits Global</h2>
                <p><button class="button_colour orange round_all" onClick="location.href='nitsmin_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Concepte</th> 
							<th>Data Començament</th>
                            <th>Data Finalització</th>
                            <th>Minim de nits</th>
						</tr> 
					</thead> 
					<tbody>              
<?php
	//$rs_query = mysqli_query("SELECT nm, nom, date_start, date_end, nitsmin FROM nitsmin ORDER BY date_start DESC");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy("date_start","desc");
	$rs_result=$db->get("nitsmin",null,"nm, nom, date_start, date_end, nitsmin");
	foreach($rs_result as $rs){ 
?>                                
						<tr> 
                        	<td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='nitsmin_act.php?action=del&id=<?php echo $rs['nm']; ?>'}" title="">X</a></td>
							<td><a href="nitsmin_edit.php?id=<?php echo $rs['nm']; ?>"><?php echo $rs['nom']; ?></a></td> 
							<td class="center"><?php echo $rs['date_start']; ?></td>
                            <td class="center"><?php echo $rs['date_end']; ?></td>
                            <td class="center"><?php echo $rs['nitsmin']; ?></td>
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