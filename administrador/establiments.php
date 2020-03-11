<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';

if ($_SESSION['type_user']=='propietario') header('location: establiments_edit.php?id='.$_SESSION['eid']);
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Establiments</h2>
				<!--<p>Administrar l'establiment</p>-->
                <p><button class="button_colour orange round_all" onClick="location.href='establiments_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th>Referencia</th>
							<th>Titol</th> 
							<th>Localitat</th>
                            <th>Tipus</th>
                            <th>Publicat</th>
                            <th>Publicat a la Home</th>
                            <th>Recomenat</th>
                            <th>Habitacions</th>
                            <th>Usuari</th>
                            <th>Visites</th>
                            <th>Reserves</th>
                            <th>Imatges</th>
						</tr> 
					</thead> 
					<tbody> 
                    
<?php
	/*$rs_query = mysqli_query("SELECT eid, title, lid, tid, published, ownername, hits, home, recommended FROM establiments ORDER BY title ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title','ASC');
	$rs_query=$db->get('establiments',null,'eid, title, lid, tid, published, ownername, hits, home, recommended');
	foreach($rs_query as $rs){ 
?>                      
						<tr> 
                        	<td>SR-<?php echo $rs['eid']; ?></td> 
							<td><a href="establiments_edit.php?id=<?php echo $rs['eid'];?>"><?php echo $rs['title']; ?></a></td> 
							<td class="center"><?php echo GetTitleLocalitat($rs['lid']); ?></td>
							<td class="center"><?php echo GetTitleTipusEstabliment($rs['tid']); ?></td>
                            <td class="center"><?php echo GetYesNo($rs['published']); ?></td>
                            <td class="center"><?php echo GetYesNo($rs['home']); ?></td>
                            <td class="center"><?php echo GetYesNo($rs['recommended']); ?></td>
                            <td class="center"><?php echo GetNumRoomsEstabliment($rs['eid']); ?></td>
                            <td class="center"><?php echo $rs['ownername']; ?></td>
                            <td class="center"><?php echo $rs['hits']; ?></td>
                            <td class="center"><a href="reservations.php"><?php echo GetNumReservations($rs['eid']); ?></a></td>
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