<?php
	if ($price=="") $price="all";
	if ($tipocasa=="") $tipocasa="all";
	if ($_SESSION['persons']=="") $_SESSION['persons']=2;
?>
<form action="search.php" method="post" id="FormSearch" name="FormSearch">
    <!--<input type="hidden" name="searchsubmit" value="1"/>-->
    <input type="hidden" name="refinesearchsubmit" value="1"/>
    <input type="hidden" name="lng" value="<?php echo $lng; ?>"/>
    <input type="hidden" name="price" value="<?php echo $price; ?>"/>
    <input type="hidden" name="tipocasa" value="<?php echo $tipocasa; ?>"/>

<?php
if (!empty($perid)) {
	foreach ($perid as $perfil) {
	?>
		<input type="hidden" name="perid[]" value="<?php echo $perfil; ?>"/>
	<?php
	}
}

if (!empty($serid)) {
	foreach ($serid as $servicio){
	?>
		<input type="hidden" name="serid[]" value="<?php echo $servicio; ?>"/>
	<?php	
	}
}
?>    
						
	<div class="form-search-fields">
																				
		<div class="label-group main-search-place">
							
			<select name="where" id="e2" class="populate" dplaceholder="¿Dónde quieres ir?">
					<option value="all"><?php echo TODA_CATALUNYA; ?></option>							 	
					<optgroup label="Provincias" style="font-style:normal">
						<?php echo PrintOptionProvincia($_SESSION['where']); ?>
					</optgroup>
									
					<optgroup label="Comarcas">
	                   <?php echo PrintOptionComarca($_SESSION['where']);   ?>
					</optgroup>

			</select>
								
		</div>
						
		<div class="label-group input-daterange main-search-date" id="datepicker">
														    
			<input type="text" id="from" placeholder="<?php echo ENTRADA; ?>" class="icon-input-calendar" name="datein" style="ewidth:150px" value="<?php if (isset($_SESSION['datein'])) echo $_SESSION['datein'];?>" onfocus="blur();" autocomplete="off">
							
			<input type="text" id="to" placeholder="<?php echo SALIDA; ?>" class="icon-input-calendar" name="dateout" style="ewidth:150px" value="<?php if (isset($_SESSION['dateout'])) echo $_SESSION['dateout'];?>" onfocus="blur();" autocomplete="off">
							    					
		</div>
							
		<div class="label-group main-search-people">
							 
			<select class="selectpicker" name="persons" id="txt-persones">
				<?php
                    $cont = 1;
                    while($cont<=30) { // Número máximo de 30 personas
                        echo "<option value=\"".$cont."\"";
                        if ($_SESSION['persons']==$cont){ echo " selected=\"selected\"";}
                        echo ">".$cont." ".PERSONAS."</option>";
                        $cont++;	
                    }
                ?>                                      
			</select>
							
		</div>
	    			              
	
						
	<div class="label-group form-search-button">
						
		<input type="submit" value="<?php echo BUSCAR;?>" name="subscribe" class="btn btn--primary" />
							
	</div>
	</div>					
</form>
