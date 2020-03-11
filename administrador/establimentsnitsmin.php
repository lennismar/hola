<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Mínim Nits</h2>
                <p><button class="button_colour orange round_all" onClick="location.href='establimentsnitsmin_edit.php'"><span>+ Nou</span></button><div style="float: right;"><i>Només es mostren els períodes que ara estan vigents</i></div></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Establiment</th> 
							<th>Data Començament</th>
                            <th>Data Finalització</th>
                            <th>Minim de nits</th>
                            <th>Preu del bloc</th>
						</tr>
					</thead> 
					<tbody>              
<?php
	if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
	$db->orderBy('date_start','desc');
	$db->where('date_end',date('Y-m-d'), '>=');
	$rs_query=$db->get('establiments_nitsmin',null,'enm, eid, date_start, date_end, nitsmin, precio_bloque_dias');
	foreach($rs_query as $rs){
?>                                
						<tr> 
                        	<td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='establimentsnitsmin_act.php?action=del&id=<?php echo $rs['enm']; ?>'}" title="">X</a></td>
							<td><a href="establimentsnitsmin_edit.php?id=<?php echo $rs['enm']; ?>"><?php echo Query('establiments', 'title', 'eid', $rs['eid']); ?></a></td> 
							<td class="center"><?php echo $rs['date_start']; ?></td>
                            <td class="center"><?php echo $rs['date_end']; ?></td>
                            <td class="center"><?php echo $rs['nitsmin']; ?></td>
                            <td class="center"><?php echo $rs['precio_bloque_dias']; ?></td>
						</tr>
<?php
	}
?>
                	</tbody> 
				</table>
			</div>
		</div>
<?php
	}
	else{
		$db->orderBy('date_start','desc');
		$db->where('eid',$_SESSION['eid']);
		$rs_query=$db->get('establiments_nitsmin',null,'enm, eid, date_start, date_end, nitsmin, precio_bloque_dias');
		foreach($rs_query as $rs){
?>                                
						<tr> 
                        	<td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='establimentsnitsmin_act.php?action=del&id=<?php echo $rs['enm']; ?>'}" title="">X</a></td>
							<td><a href="establimentsnitsmin_edit.php?id=<?php echo $rs['enm']; ?>"><?php echo Query('establiments', 'title', 'eid', $rs['eid']); ?></a></td> 
							<td class="center"><?php echo $rs['date_start']; ?></td>
                            <td class="center"><?php echo $rs['date_end']; ?></td>
                            <td class="center"><?php echo $rs['nitsmin']; ?></td>
                            <td class="center"><?php echo $rs['precio_bloque_dias']; ?></td>
						</tr>
<?php
		}
	}
?>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
		
<?php include 'includes/closing_items.php'?>