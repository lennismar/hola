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
				<h2>Provincies</h2>
				<p>Administrar les provincies catalanes</p>
			</div>
			<div class="box grid_16 round_all">
				<table class="display datatable"> 
					<thead> 
						<tr> 
							<th>Provincia</th>
						</tr> 
					</thead> 
					<tbody>              
                    <?php
                        $db->orderBy("title ","asc");
                        $provincias = $db->get('provincies', null, "pvid, title");
                        if ($db->count > 0) {
                            foreach ($provincias as $rs) {
                    ?>
						<tr> 
							<td><a href="provincies_edit.php?id=<?php echo $rs['pvid']; ?>"><?php echo $rs['title'];?></a></td> 
						</tr> 
                    <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td>No se encontraron provincias que mostrar</td>
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