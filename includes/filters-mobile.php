<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'config.php';
//require 'config-mobile.php';
$lng = $_GET['lng'];
$where_consulta = $_GET['where_consulta'];
$tipocasa = $_GET['tipocasa'];
$persons = $_GET['persons'];
$price = $_GET['price'];
$serid = explode(' ', $_GET['serid']);
$perid = explode(' ', $_GET['perid']);

?>


<div class="search-filters">
	
	<strong> FILTRAR POR <?php echo $_GET['hello'];?></strong>
    <?php 
	//var_dump ($perid);
	?>
					
	<form action="search.php" method="post" id="FormSearch" name="FilterSearch">
        <input type="hidden" name="refinesearchsubmit" value="1"/>
        <input type="hidden" name="where" value="<?php echo $where_consulta; ?>"/>
        <input type="hidden" name="datein" value="<?php echo $_SESSION['datein']; ?>" />
        <input type="hidden" name="dateout" value="<?php echo $_SESSION['dateout']; ?>"/>
		<input type="hidden" name="persons" value="<?php echo $persons; ?>"/>

		<?php if(!empty($reserva_inmediata)) { ?>
			<ul class="filter-content filters-instant-booking">

				<li>
					<label>
						<input name="" type="checkbox" value="instantBooking"  <?php if(isset($instantBooking) && $instantBooking) echo 'checked="checked" checked'; ?>/><strong><?php echo FILTRO_INMEDIATA; ?></strong><br>
					<span class="small">
						<?php echo FILTRO_INMEDIATA_SUB; ?>
					</span>
					</label>

				</li>
			</ul>
		<?php } ?>

		<div class="filter-header-block btn-expand-extra-content">TIPO</div>
						
		<ul class="filter-content filters-tipo">
			<li><label><input type="radio" name="tipocasa1" value="all" <?php if (!isset($tipocasa) || $tipocasa==0) echo "checked"; ?>/><?php echo TODO_TIPO_CASAS; ?></label></li>
			<li><label><input type="radio" name="tipocasa2" value="10" <?php if ($tipocasa==10) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 10); ?></label></li>
			<li><label><input type="radio" name="tipocasa3" value="3" <?php if ($tipocasa==3) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 3); ?></label></li>
			<li><label><input type="radio" name="tipocasa4" value="8" <?php if ($tipocasa==8) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 8); ?></label></li>
		</ul>
		<script type='text/javascript'>

			$(document).ready(function() {
				$('input[name*=tipocasa]').click(function(){
					//alert($(this).val());
					$(this).attr("checked", "checked");
					$('input[name=tipocasa]').val($(this).val());
					//$(this).click();
					$('#FormSearch').submit();
				});
			});

		</script>
		<div class="filter-header-block btn-expand-extra-content">PRECIO PERSONA/NOCHE</div>
						
		<ul class="filter-content filters-precio">
        	<li><label><input name="price" type="radio" value="all" <?php if ($price=='all') echo " checked"; ?>/>Cualquier Precio</label></li>
			<li><label><input name="price" type="radio" value="0-29" <?php if ($price=='0-29') echo " checked"; ?>/>0 - 29 €</label></li>
			<li><label><input name="price" type="radio" value="30-59" <?php if ($price=='30-59') echo " checked"; ?>/>30 - 59 €</label></li>
			<li><label><input name="price" type="radio" value="60-1000" <?php if ($price=='60-1000') echo " checked"; ?>/>+60€</label></li>
		</ul>
		
		<div class="filter-header-block btn-expand-extra-content" id="btn-expand-extra-content"><?php echo SERVICIOS; ?></div>
		
		<ul class="filter-content filters-servicios">
<?php
$count = 0;
//$rs_query = mysqli_query("SELECT serid, title_".$lng." FROM serveis ORDER BY title_".$lng." ASC");
$db->orderBy("orden",'DESC');
$db->orderBy("title_".$lng,'ASC');
$db->where('active',1);
$rs_query=$db->get('serveis',null,"serid, title_".$lng."");
//while($rs = mysqli_fetch_array($rs_query)){
foreach($rs_query as $rs){
	//if ($count==10) echo '<span class="filters-extra-content" id="filters-extra-servicios">';
?>   
			<li><label><input name="serid[]" id="serid[]" type="checkbox" value="<?php echo $rs['serid']; ?>" <?php if (is_array($serid)) {foreach ($serid as $servicio) { if($servicio==$rs['serid']) echo "checked"; }} ?>/><?php echo $rs['title_'.$lng];?></label></li>        
<?php
	$count++;
}
?>
		</ul>
		
		<div class="filter-header-block btn-expand-extra-content"><?php echo PERFILES; ?></div>

		<ul class="filter-content filters-servicios push--bottom">
<?php
$count = 0;
//$rs_query = mysqli_query("SELECT perid, title_".$lng." FROM perfils ORDER BY title_".$lng." ASC");
$db->orderBy("orden",'DESC');
$db->orderBy("title_".$lng,'ASC');
$db->where('active',1);
$rs_query=$db->get('perfils',null,"perid, title_".$lng."");
//while($rs = mysqli_fetch_array($rs_query)){
foreach($rs_query as $rs){
	//if ($count==5) echo '<span class="filters-extra-content" id="filters-extra-tipo">';
?>   
    			<li><label><input name="perid[]" id="perid[]" type="checkbox" value="<?php echo $rs['perid']; ?>" <?php if (is_array($perid)) {foreach ($perid as $perfil) { if($perfil==$rs['perid']) echo "checked"; }} ?>/><?php echo $rs['title_'.$lng];?><label></li>
<?php
	$count++;
}
?>
		</ul>
		
		
		<div class="filter-mobile-button">
		
			<input type="submit" value="<?php echo FILTRAR; ?>" name="filtrar" class="btn btn--secondary push--top" />
		
		</div>

	</form>
						
</div>

<script>
	
	$(function () {
		
	    $(document).find('.btn-expand-extra-content').click(function(){
	
	      //Expand or collapse this panel
	      $(this).next().slideToggle('fast');
	
	      //Hide the other panels
	      //$(".filter-content").not($(this).next()).slideUp('fast');
	
	    });
	});
 </script>