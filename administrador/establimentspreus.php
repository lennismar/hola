<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php'; 
if ($_SESSION['type_user']=='propietario') header('location: establimentspreus_edit.php?id='.$_SESSION['eid']);
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Preus Establiment Sencer</h2>
				<p>Administrar preus de l'establiment sencer</p>
                <p><button class="button_colour orange round_all" onClick="location.href='establiments_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<th>Titol</th> 
							<th>Localitat</th>
                            <th>Tipus</th>
                            <th>Publicat</th>
                            <th>Capacitat</th>
                            <th>Minim nits</th>
                            <th>Dies Antelació</th>
                            <th>Reserves</th>
						</tr> 
					</thead> 
					<tbody> 
                    
<?php
	/*$rs_query = mysqli_query("SELECT eid, title, lid, tid, published, ownername, hits, daysmin, persons, daysant FROM establiments WHERE establimentcomplert=1 ORDER BY title ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title','ASC');
	$db->where('establimentcomplert',1);
	$rs_query=$db->get('establiments',null,'eid, title, lid, tid, published, ownername, hits, daysmin, persons, daysant');
	foreach($rs_query as $rs){
?>                      
						<tr> 
							<td><a href="establimentspreus_edit.php?id=<?php echo $rs['eid'];?>"><?php echo $rs['title']; ?></a></td> 
							<td class="center"><?php echo GetTitleLocalitat($rs['lid']); ?></td>
							<td class="center"><?php echo GetTitleTipusEstabliment($rs['tid']); ?></td>
                            <td class="center"><?php echo GetYesNo($rs['published']); ?></td>
                            <td class="center"><?php echo Query('establiments', 'persons', 'eid', $rs['eid']); ?></td>
                            <td class="center"><?php echo Query('establiments', 'daysmin', 'eid', $rs['eid']); ?></td>
                            <td class="center"><?php echo Query('establiments', 'daysant', 'eid', $rs['eid']); ?></td>
                            <td class="center">2</td>
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