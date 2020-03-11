<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Recursos turístics</h2>
				<p>Gestionar dels diferents recursos turístics</p>
                <p><button class="button_colour orange round_all" onClick="location.href='recursos_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
	                        <th width="15"></th>
                            <th>Títol</th>
                            <th>Provincia</th>
                            <th>Tipus de recurs</th>
                            <th width="15">Publicat</th>
						</tr> 
					</thead> 
					<tbody> 
<?php
	/*$rs_query = mysqli_query("SELECT idrecurso, title_ca, description_ca, pvid, idtipusrecurso, published  FROM recursos ORDER BY title_ca ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('title_ca','ASC');
	$rs_query=$db->get('recursos',null,'idrecurso, title_ca, description_ca, pvid, idtipusrecurso, published');
	foreach($rs_query as $rs){
?>      
						<tr> 
	                        <td><a href="javascript: if(confirm('Estas segur de que ho vols eliminar?')){window.location='recursos_act.php?action=del&id=<?php echo $rs['idrecurso'];?>'}" title="">X</a></td>
							<td><a href="recursos_edit.php?id=<?php echo $rs['idrecurso'];?>"><?php echo $rs['title_ca']; ?></a></td>
                            <td class="center"><?php echo GetTitleProvincia($rs['pvid']);?></td>
                            <td class="center"><?php echo GetTitleTipusRecurso($rs['idtipusrecurso']); ?></td>
                            <td class="center"><?php echo GetYesNo($rs['published']); ?></td>
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