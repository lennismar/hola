<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
	<div id="wrapper">		
		<?php include 'includes/topbar.php'?>
		<?php include 'includes/sidebar.php'?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Advertències Buscador</h2>
                <p><button class="button_colour orange round_all" onClick="location.href='texto_buscador_edit.php'"><span>+ Nova Advertència</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Text</th> 
							<th>Data Començament</th>
                            <th>Data Finalització</th>						
                        </tr> 
					</thead> 
					<tbody>              
<?php
	//$rs_query = mysqli_query("SELECT id, date_start, date_end, texto_buscador_ca FROM texto_buscador ORDER BY date_start DESC");
	//while($rs = mysqli_fetch_array($rs_query)){
	$db->orderBy("date_start","desc");
	$rs_result=$db->get("texto_buscador",null,"id,date_start,date_end,texto_buscador_ca");
	foreach($rs_result as $rs){ 
?>                                
						<tr> 
                        	<td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='texto_buscador_act.php?action=del&id=<?php echo $rs['id'];?>'}" title="">X</a></td>
							<td><a href="texto_buscador_edit.php?id=<?php echo $rs['id']?>"><?php echo $rs['texto_buscador_ca']; ?></a></td> 
							<td class="center"><?php echo $rs['date_start']; ?></td>
                            <td class="center"><?php echo $rs['date_end']; ?></td>
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