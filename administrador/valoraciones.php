<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';


?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Valoracions</h2>
                <!--<p><button class="button_colour orange round_all" onClick="location.href='accomodation_add.php'"><span>+ Nou</span></button></p>-->
			</div>
			<div class="box grid_16 round_all">
            	<div class="block no_padding">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                            <th>Codi de Valoració</th>
                            <th>Reserva</th>
                            <th>Establiment</th>
                            <th>Title</th>
                            <th>Netega</th>
                            <th>Tracte</th>
                            <th>Entorn</th>
                            <th>Equipaments</th>
                            <th>Relació Qualitat/Preu</th>
                            <th>Qualitat del Somni</th>
                            <th>Relación con la naturaleza</th>
                            <th>Sensación de paz y tranquilidad</th>
                            <th>Com ha viatjat</th>                            
                            <th>Data</th>
                            <th>Publicat</th>
						</tr> 
					</thead> 
					<tbody> 
<?php
	/*$rs_query = mysqli_query("SELECT cid, comcode, eid, title_ca, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, como, date, ipaddress, resid, published, state  FROM comments WHERE state=1 ORDER BY date DESC");
	while($rs = mysqli_fetch_array($rs_query)){*/
    $db->where('state',1);
    $db->orderBy('date','DESC');
    $rs_query=$db->get('comments',null,'cid,comcode, eid, title_ca, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, como, date, ipaddress, resid, published, state');
    foreach($rs_query as $rs){
?>    
						<tr> 
							<td><a href="valoraciones_edit.php?cid=<?php echo $rs['cid']; ?>"><?php echo $rs['comcode'];?></a></td>
                            <td><a href="reservations_view.php?id=<?php echo $rs['resid']; ?>"><?php echo Query('reservations', 'rescode', 'resid', $rs['resid']); ?></a></td>
                            <td class="center"><?php echo Query('establiments', 'title', 'eid', $rs['eid']); ?></td>
                            <td><?php echo $rs['title_ca'];?></td>
                            <td><?php echo $rs['netega'];?></td>
                            <td><?php echo $rs['tracte'];?></td>
                            <td><?php echo $rs['entorn'];?></td>
                            <td><?php echo $rs['equipaments'];?></td>
                            <td><?php echo $rs['relacio'];?></td>
                            <td><?php echo $rs['somni'];?></td>
                            <td><?php echo $rs['natura'];?></td>
                            <td><?php echo $rs['sensacio'];?></td> 
                            <td><?php echo CommentsHow($rs['como']);?></td>                            
                            <td><?php echo $rs['date'];?></td>
                            <td><?php echo GetYesNo($rs['published']);?></td>
						</tr> 
<?php
	}
?>
                	</tbody> 
				</table>
                </div>
			</div>
		</div>
		
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>

<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
		
<?php include 'includes/closing_items.php'?>