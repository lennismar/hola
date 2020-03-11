<div class="search-filters">	
					
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
					<input name="instantBooking" type="checkbox" value="instantBooking" <?php if(isset($instantBooking) && $instantBooking) echo 'checked="checked" checked'; ?>/><strong><?php echo FILTRO_INMEDIATA; ?></strong><br>
					<span class="small">
						<?php echo FILTRO_INMEDIATA_SUB; ?>
					</span>
				</label>

			</li>
		</ul>
		<?php } ?>

		<div class="filter-header-block btn-expand-extra-content">TIPO</div>
						
		<ul class="filter-content filters-tipo">
            <li><label><input type="radio" name="tipocasa" value="all" onClick="javascript:forms.FilterSearch.submit();" <?php if (!isset($tipocasa) || $tipocasa==0) echo "checked"; ?>/><?php echo TODO_TIPO_CASAS; ?></label></li>
            <li><label><input type="radio" name="tipocasa" value="10" onClick="javascript:forms.FilterSearch.submit();" <?php if ($tipocasa==10) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 10); ?></label></li>
            <li><label><input type="radio" name="tipocasa" value="3" onClick="javascript:forms.FilterSearch.submit();" <?php if ($tipocasa==3) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 3); ?></label></li>            
            <li><label><input type="radio" name="tipocasa" value="8" onClick="javascript:forms.FilterSearch.submit();" <?php if ($tipocasa==8) echo " checked"; ?>/><?php echo Query('tipus', 'title_'.$lng, 'tid', 8); ?></label></li>  
        </ul>
		
		
		<div class="filter-header-block btn-expand-extra-content">PRECIO PERSONA/NOCHE</div>
						
		<ul class="filter-content filters-precio">
        	<li><label><input name="price" type="radio" value="all" <?php if ($price=='all') echo " checked"; ?>/>Cualquier Precio</label></li>
			<li><label><input name="price" type="radio" value="0-29" <?php if ($price=='0-29') echo " checked"; ?>/>0 - 29 €</label></li>
			<li><label><input name="price" type="radio" value="30-59" <?php if ($price=='30-59') echo " checked"; ?>/>30 - 59 €</label></li>
			<li><label><input name="price" type="radio" value="60-1000" <?php if ($price=='60-1000') echo " checked"; ?>/>+60€</label></li>
		</ul>
		
		<div class="filter-header-block btn-expand-extra-content"><?php echo SERVICIOS; ?></div>
		
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
	if ($count==10) echo '<span class="filters-extra-content" id="filters-extra-servicios">';
?>   
			<li><label><input name="serid[]" id="serid[]" type="checkbox" value="<?php echo $rs['serid']; ?>" <?php if (is_array($serid)) {foreach ($serid as $servicio) { if($servicio==$rs['serid']) echo "checked"; }} ?>/><?php echo $rs['title_'.$lng];?></label></li>        
<?php
	$count++;
}
?>
			</span>
			
			<a href="#"  onclick="toggle2('filters-extra-servicios',this);return false;" class="btn-filter-plus btn-expand-extra-content">+ <?php echo SERVICIOS; ?></a>
		</ul>
		
		<div class="filter-header-block btn-expand-extra-content"><?php echo PERFILES; ?></div>

		<ul class="filter-content filters-servicios">
<?php
$count = 0;
//$rs_query = mysqli_query("SELECT perid, title_".$lng." FROM perfils ORDER BY title_".$lng." ASC");
$db->orderBy("orden",'DESC');
$db->orderBy("title_".$lng,'ASC');
$db->where('active',1);
$rs_query=$db->get('perfils',null,"perid, title_".$lng."");
//while($rs = mysqli_fetch_array($rs_query)){
foreach($rs_query as $rs){
	if ($count==5) echo '<span class="filters-extra-content" id="filters-extra-tipo">';
?>   
    			<li><label><input name="perid[]" id="perid[]" type="checkbox" value="<?php echo $rs['perid']; ?>" <?php if (is_array($perid)) {foreach ($perid as $perfil) { if($perfil==$rs['perid']) echo "checked"; }} ?>/><?php echo $rs['title_'.$lng];?><label></li>
<?php
	$count++;
}
?>
			</span>
			
			<a href="#" onclick="toggle2('filters-extra-tipo',this);return false;" class="btn-filter-plus btn-expand-extra-content">+ <?php echo PERFILES; ?></a>
		</ul>
		
		<input type="submit" value="<?php echo FILTRAR; ?>" name="filtrar" class="btn btn--secondary push-half--top" />

	</form>
						
</div>


<script>
/*
	
	javascript:hideshow(document.getElementById('filters-extra-tipo'))
	
	
$(function () {
    $('.search-filters').find('.btn-expand-filter').click(function(){

      //Expand or collapse this panel
      $(this).next().slideToggle('fast');

      //Hide the other panels
      //$(".filter-content").not($(this).next()).slideUp('fast');

    });
  });*/

 </script>