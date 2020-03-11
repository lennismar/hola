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
				<h2>Banners Capçalera</h2>
                <p><button class="button_colour orange round_all" onClick="location.href='banners_header_edit.php'"><span>+ Nou</span></button></p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
                        	<th width="15"></th>
							<th>Títol Banner</th> 
                            <!--<th>Imatge</th>-->
                            <th>Orden</th> 
                            <th>Activo</th> 
						</tr> 
					</thead> 
					<tbody>              
<?php
	/*$rs_query = mysqli_query("SELECT bhid, title_ca, image_ca, orden, published FROM banners_header ORDER BY orden ASC");
	while($rs = mysqli_fetch_array($rs_query)){*/
	$db->orderBy('orden','ASC');
	$rs_query=$db->get('banners_header',null,'bhid, title_ca, image_ca, orden, published');
	foreach($rs_query as $rs){
?>                                
						<tr> 
                        	<td style="text-indent:inherit"><a href="javascript: if(confirm('Estas segur de que el vols eliminar?')){window.location='banners_header_act.php?action=del&id=<?php echo $rs['lid']; ?>'}" title="">X</a></td>
							<td><a href="banners_header_edit.php?id=<?php echo $rs['bhid']; ?>"><?php echo $rs['title_ca'];?></a></td> 
							<!--<td class="center"><img src="<?php echo URL_BASE . FILE_DIR . "banners/" . $rs['image_ca'];?>" width="300" align="" border="0"/></td>-->
                            <td class="center"><?php echo $rs['orden'];?></td>
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