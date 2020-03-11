<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';

// Creamos un filtro con la id del establecimiento por si el usuario es un propietario
$filter = "";
if(in_array($_SESSION['type_user'], $usuarios_excluidos)){ header("location: establiments.php");exit();}
if ($_SESSION['type_user']=='propietario') $filter = " WHERE eid = ".$_SESSION['eid']." ";
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Reserves</h2>
			</div>
			<div class="box grid_16 round_all">
            	<div class="block no_padding">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<!--<th></th>--> 
							<!--<th></th>-->
                            <th>Codi</th>
                            <th>Nom</th>
                            <th>Establiment</th>
                            <th>Dia de la Reserva</th>
                            <th>Arribada</th>
                            <th>Sortida</th>
                            <th>Persones</th>
                            <th>Total</th>
                            <th>Senyal</th>
                            <th>Resta</th>
                            <th>Estat de la Reserva</th>
						</tr> 
					</thead> 
					<tbody> 
<?php
	/*$rs_query = mysqli_query("SELECT resid, eid, resdate, checkin, checkout, numdays, totalprice, persons, restid, ofirstname, olastname, oemail, rescode, paid, feeamount FROM reservations ".$filter." ORDER BY resdate DESC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('resdate','DESC');
	if($filter!=""){
		$db->where('eid',$_SESSION['eid']);
	}
	$rs_query=$db->get('reservations', null,'resid, eid, resdate, checkin, checkout, numdays, totalprice, persons, restid, ofirstname, olastname, oemail, rescode, paid, feeamount');
	foreach ($rs_query as $rs) {
		$stylegeneral = '';
		if ($rs['restid']==1) $colorstate='red';
		if ($rs['restid']==2 || $rs['restid']==7) $colorstate='green';
		if ($rs['restid']==3 || $rs['restid']==6) $colorstate='orange';
		if ($rs['restid']==4) $colorstate='blue';
		if ($rs['restid']==5) { $colorstate='grey'; $stylegeneral = ' style="color:grey"'; }

?>    
						<tr> 
							<!--<td><a href="#"><img src="images/icons/small/color/print.png" width="16" height="16"></a></td>-->
							<!--<td><a href="reservations_edit.php"><img src="images/icons/small/color/edit16.png" width="16" height="16"></a></td>-->
							<td><a <?php echo $stylegeneral;?> href="reservations_view.php?id=<?php echo $rs['resid']; ?>"><?php echo $rs['rescode'];?></a></td>
                            <td <?php echo $stylegeneral;?>><?php echo $rs['ofirstname'] . " " . $rs['olastname'];?></td>
                            <td class="center"><a <?php echo $stylegeneral;?> href="establiments_edit.php?id=<?php echo $rs['eid'];?>"><?php echo Query('establiments', 'title', 'eid', $rs['eid']); ?></a></td>
                            <td <?php echo $stylegeneral;?>><?php echo date("Y-m-d G:i:s", strtotime($rs['resdate']));?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo date("Y-m-d",strtotime($rs['checkin']));?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo date("Y-m-d",strtotime($rs['checkout']));?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo $rs['persons'];?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo $rs['totalprice'] . " €";?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo $rs['feeamount'] . " €";?></td>
                            <td <?php echo $stylegeneral;?> class="center"><?php echo $rs['totalprice'] - $rs['feeamount']  . " €";?></td>
                            <td class="center"><?php if($rs['restid']==7 || $rs['restid']==6) echo '<span style="color:red;">I</span> ';?><a href="reservations_view.php?id=<?php echo $rs['resid']; ?>" style="color:<?php echo $colorstate; ?>"><?php echo Query('reservations_states', 'title_ca', 'restid', $rs['restid']); ?></a></td>
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