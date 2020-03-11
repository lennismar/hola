<form action="busqueda.php" method="post" id="FormSearch" name="FormSearch">
						
	<div class="form-search-fields">
																				
		<div class="label-group main-search-place">
							
			<select id="e2" class="populate" dplaceholder="¿Dónde quieres ir?">
								 
					<option value="p-0" >Buscar en toda Cataluña</option>
								 	
					<optgroup label="Provincias" style="font-style:normal">
						<option value="p-1" >Barcelona</option>
						<option value="p-2" >Girona</option>
						<option value="p-3" >Lleida</option>
						<option value="p-4" >Tarragona</option>
					</optgroup>
									
					<optgroup label="Comarcas">
	                   <option value="c-32" >Alt Camp</option>
					   <option value="c-12" >Alt Empordà</option>
					   <option value="c-1" >Alt Penedès</option>
					   <option value="c-20" >Alt Urgell</option>
					   <option value="c-21" >Alta Ribagorça</option>
					   <option value="c-2" >Anoia</option><option value="c-3" >Bages</option><option value="c-33" >Baix Camp</option><option value="c-34" >Baix Ebre</option><option value="c-13" >Baix Empordà</option><option value="c-4" >Baix Llobregat</option><option value="c-35" >Baix Penedès</option><option value="c-5" >Barcelonès</option><option value="c-6" >Berguedà</option><option value="c-14" >Cerdanya</option><option value="c-36" >Conca de Barberà</option><option value="c-7" >Garraf</option><option value="c-22" >Garrigues</option><option value="c-15" >Garrotxa</option><option value="c-16" >Gironès</option><option value="c-8" >Maresme</option><option value="c-37" >Montsià</option><option value="c-23" >Noguera</option><option value="c-9" >Osona</option><option value="c-24" >Pallars Jussà</option><option value="c-25" >Pallars Sobirà</option><option value="c-26" >Pla d'Urgell</option><option value="c-17" >Pla de l'Estany</option><option value="c-38" >Priorat</option><option value="c-39" >Ribera d'Ebre</option><option value="c-18" >Ripollès</option><option value="c-27" >Segarra</option><option value="c-28" >Segrià</option><option value="c-19" >Selva</option><option value="c-29" >Solsonès</option><option value="c-40" >Tarragonès</option><option value="c-41" >Terra Alta</option><option value="c-30" >Urgell</option><option value="c-31" >Val d'Aran</option><option value="c-10" >Vallès Occidental</option><option value="c-11" >Vallès Oriental</option>
					</optgroup>

			</select>
								
		</div>
						
		<div class="label-group input-daterange main-search-date" id="datepicker">
														    
			<input type="text" id="from" placeholder="Entrada" class="icon-input-calendar" name="from" onfocus="blur();">
							
			<input type="text" id="to" placeholder="Salida" class="icon-input-calendar" name="to" onfocus="blur();">
							    					
		</div>
							
		<div class="label-group main-search-people">
							 
			<select class="selectpicker">
				<option value="p-1" >1 persona</option>	
				<option value="p-2" selected>2 personas</option>
				<option value="p-2" >3 personas</option>
				<option value="p-2" >4 personas</option>
				<option value="p-2" >4 personas</option>
				<option value="p-2" >6 personas</option>
				<option value="p-2" >7 personas</option>
				<option value="p-2" >8 personas</option>
				<option value="p-2" >9 personas</option>
				<option value="p-2" >10 personas</option>
				<option value="p-2" >+10 personas</option>
			</select>
			
		</div>
		
		<div class="label-group form-search-button">
						
			<input type="submit" value="Buscar" name="subscribe" class="btn btn--primary" />
							
		</div>
	              
	</div>				
							
</form>
