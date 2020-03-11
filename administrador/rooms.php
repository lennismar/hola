<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';

// Creamos un filtro con la id del establecimiento por si el usuario es un propietario
$filter = "";
if ($_SESSION['type_user']=='propietario') $filter = " WHERE eid = ".$_SESSION['eid']." ";
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php'?>
		<?php include 'includes/sidebar.php'?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Habitacions</h2>
				<!--<p>Gestionar habitacions</p>-->
                <p><button class="button_colour orange round_all" onClick="location.href='rooms_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<?php if ($_SESSION['type_user']=='superadmin') echo "<th>Establiment</th>"; ?>
                            <th>Nom Habitació</th>
                            <th>Publicat</th>
                            <th>Vacants</th>
                            <th>Persones</th>
						</tr> 
					</thead> 
					<tbody> 
<?php
	//$rs_query = mysqli_query("SELECT rid, eid, title_ca, title_es, title_en, title_fr, description_ca, description_es, description_en, description_fr, persons, published, availability FROM rooms ".$filter." ORDER BY eid");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy('eid','asc');
	$rs_query=$db->get('rooms',null,'rid, eid, title_ca, title_es, title_en, title_fr, description_ca, description_es, description_en, description_fr, persons, published, availability');
	if($db->count > 0){
		foreach($rs_query as $rs){ 
?>                       
						<tr> 
                        	<?php if ($_SESSION['type_user']=='superadmin') { ?>
                            	<td><a href="establiments_edit.php?id=<?php echo $rs['eid'];?>"><?php echo Query('establiments', 'title', 'eid', $rs['eid']); ?></a></td>
							<?php } ?>
                            <td><a href="rooms_edit.php?id=<?php echo $rs['rid'];?>"><?php echo $rs['title_ca']; ?></a></td>
                            <td class="center"><?php echo GetYesNo($rs['published']);?></td>
                            <td class="center"><?php echo $rs['availability']; ?></td>
                            <td class="center"><?php echo $rs['persons']; ?></td>
						</tr> 
<?php
	}}
?>                	</tbody> 
				</table>
			</div>
		</div>
		
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>

<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
		
<?php include 'includes/closing_items.php'?>