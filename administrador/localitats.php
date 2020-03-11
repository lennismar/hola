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
				<h2>Localitats</h2>
				<p>Administrar les localitats catalanes</p>
                <p><button class="button_colour orange round_all" onClick="location.href='localitats_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Localitat</th> 
							<th>Provincia</th>
                            <th>Comarca</th>
						</tr> 
					</thead> 
					<tbody>              
<?php
	//$rs_query = mysqli_query("SELECT lid, pvid, comid, title FROM localitats ORDER BY title ASC");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy("title","asc");
	$rs_result=$db->get("localitats",null,"lid, pvid, comid, title");
	foreach($rs_result as $rs){ 
?>                                
						<tr> 
                        	<td style="text-indent:inherit"><a href="javascript: if(confirm('Estas segur de que la vols eliminar?')){window.location='localitats_act.php?action=del&id=<?php echo $rs['lid']; ?>'}" title="">X</a></td>
							<td><a href="localitats_edit.php?id=<?php echo $rs['lid']; ?>"><?php echo $rs['title'];?></a></td> 
							<td class="center"><?php echo GetTitleProvincia($rs['pvid']);?></td>
                            <td class="center"><?php echo GetTitleComarca($rs['comid']);?></td>
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