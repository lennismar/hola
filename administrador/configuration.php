<?php 
$superadmin = 1;
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php'?>
				<div class="flat_area grid_16">
					<h2>Configuració</h2>
					<!--<p>Aquí serà on es podrà editar la configuración general</strong>.</p>-->
				</div>
			
				<div class="box grid_16 tabs">
                <form id="configuration_form" action="configuration_act.php" method="post">
					<ul class="tab_header grad_colour clearfix">
						<li><a href="#tabs-1">Configuració General</a></li>
						<!--<li><a href="#tabs-2">Reserves</a></li>-->
					</ul>
<?php
    $vars = $db->rawQuery('SELECT confid, var, value FROM configuration');
    foreach ($vars as $variable) {
		$$variable['var'] = $variable['value'];
	}
?>
					<div class="toggle_container">
						<div id="tabs-1" class="block">
							<div class="content">
                            	<input type="hidden" name="action" value="process">
                            
                                <label style="clear:none;">IVA</label> 
                                <div class="input_group" style="clear:none;">
                                    <select name="IVA" id="IVA">
                                        <option value="0" <?php if ($IVA=='0') echo 'selected="selected"'; ?>>0%</option>
                                        <option value="1" <?php if ($IVA=='1') echo 'selected="selected"'; ?>>1%</option>
                                        <option value="2" <?php if ($IVA=='2') echo 'selected="selected"'; ?>>2%</option>
                                        <option value="3" <?php if ($IVA=='3') echo 'selected="selected"'; ?>>3%</option>
                                        <option value="4" <?php if ($IVA=='4') echo 'selected="selected"'; ?>>4%</option>
                                        <option value="5" <?php if ($IVA=='5') echo 'selected="selected"'; ?>>5%</option>
                                        <option value="6" <?php if ($IVA=='6') echo 'selected="selected"'; ?>>6%</option>
                                        <option value="7" <?php if ($IVA=='7') echo 'selected="selected"'; ?>>7%</option>
                                        <option value="8" <?php if ($IVA=='8') echo 'selected="selected"'; ?>>8%</option>
                                        <option value="9" <?php if ($IVA=='9') echo 'selected="selected"'; ?>>9%</option>
                                        <option value="10" <?php if ($IVA=='10') echo 'selected="selected"'; ?>>10%</option>
                                        <option value="11" <?php if ($IVA=='11') echo 'selected="selected"'; ?>>11%</option>
                                        <option value="12" <?php if ($IVA=='12') echo 'selected="selected"'; ?>>12%</option>
                                        <option value="13" <?php if ($IVA=='13') echo 'selected="selected"'; ?>>13%</option>
                                        <option value="14" <?php if ($IVA=='14') echo 'selected="selected"'; ?>>14%</option>
                                        <option value="15" <?php if ($IVA=='15') echo 'selected="selected"'; ?>>15%</option>
                                        <option value="16" <?php if ($IVA=='16') echo 'selected="selected"'; ?>>16%</option>
                                        <option value="17" <?php if ($IVA=='17') echo 'selected="selected"'; ?>>17%</option>
                                        <option value="18" <?php if ($IVA=='18') echo 'selected="selected"'; ?>>18%</option>
                                        <option value="19" <?php if ($IVA=='19') echo 'selected="selected"'; ?>>19%</option>
                                        <option value="20" <?php if ($IVA=='20') echo 'selected="selected"'; ?>>20%</option>
                                    </select>
                                </div>
                                

                                <label>Som Rurals Actiu</label>
                                <div class="input_group">
                                    <input name="SITE_STATE" id="SITE_STATE" type="radio" value="1" <?php if ($SITE_STATE==1) echo "checked" ?>>Si
                                    <input name="SITE_STATE" id="SITE_STATE" type="radio"  value="0"  <?php if ($SITE_STATE==0) echo "checked" ?>>No
                                </div>   
                                
                                
                                <label style="clear:none;">Nombre màxim d'establiments a la Home</label> 
                                <div class="input_group" style="clear:none;">
                                    <select name="HOME_NUM_ESTABLIMENTS" id="HOME_NUM_ESTABLIMENTS">
                                        <option value="6" <?php if ($HOME_NUM_ESTABLIMENTS=='6') echo 'selected="selected"'; ?>>6</option>
                                        <option value="7" <?php if ($HOME_NUM_ESTABLIMENTS=='7') echo 'selected="selected"'; ?>>7</option>
                                        <option value="8" <?php if ($HOME_NUM_ESTABLIMENTS=='8') echo 'selected="selected"'; ?>>8</option>
                                        <option value="9" <?php if ($HOME_NUM_ESTABLIMENTS=='9') echo 'selected="selected"'; ?>>9</option>
                                        <option value="10" <?php if ($HOME_NUM_ESTABLIMENTS=='10') echo 'selected="selected"'; ?>>10</option>
                                        <option value="11" <?php if ($HOME_NUM_ESTABLIMENTS=='11') echo 'selected="selected"'; ?>>11</option>
                                        <option value="12" <?php if ($HOME_NUM_ESTABLIMENTS=='12') echo 'selected="selected"'; ?>>12</option>
                                        <option value="13" <?php if ($HOME_NUM_ESTABLIMENTS=='13') echo 'selected="selected"'; ?>>13</option>
                                        <option value="14" <?php if ($HOME_NUM_ESTABLIMENTS=='14') echo 'selected="selected"'; ?>>14</option>
                                        <option value="15" <?php if ($HOME_NUM_ESTABLIMENTS=='15') echo 'selected="selected"'; ?>>15</option>
                                        <option value="16" <?php if ($HOME_NUM_ESTABLIMENTS=='16') echo 'selected="selected"'; ?>>16</option>
                                        <option value="17" <?php if ($HOME_NUM_ESTABLIMENTS=='17') echo 'selected="selected"'; ?>>17</option>
                                        <option value="18" <?php if ($HOME_NUM_ESTABLIMENTS=='18') echo 'selected="selected"'; ?>>18</option>
                                        <option value="19" <?php if ($HOME_NUM_ESTABLIMENTS=='19') echo 'selected="selected"'; ?>>19</option>
                                        <option value="20" <?php if ($HOME_NUM_ESTABLIMENTS=='20') echo 'selected="selected"'; ?>>20</option>
                                        <option value="21" <?php if ($HOME_NUM_ESTABLIMENTS=='20') echo 'selected="selected"'; ?>>21</option>                                        
                                    </select>
                                </div>                                                                                           
                            </div>
						</div>
                        <!--
						<div id="tabs-2" class="block">
							<div class="content">
								<p>En construcció</p>                            
							</div>
						</div>
                        -->
                    </div>
                </div>
                
				<div class="flat_area grid_16">
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.configuration_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
				</div>                
                
				</form>
			</div>
		</div>
<?php include 'includes/closing_items.php'?>