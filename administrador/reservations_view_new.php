<?php 
$id=$_GET["id"];


include 'includes/checkuser.php';
include 'includes/document_head.php';
if(in_array($_SESSION['type_user'], $usuarios_excluidos)){ header("location: establiments.php");exit();}
?>

	<div id="wrapper">		
		<?php include 'includes/topbar.php' ?>
		<?php include 'includes/sidebar.php' ?>

<?php
if(isset($id)){
	/*$rs_query = mysqli_query("SELECT resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid FROM reservations WHERE resid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
    $db->where('resid',$id);
    $rs=$db->getOne('reservations','resid, eid, resdate, checkin, checkout, numdays, totalprice, restid, ofirstname, olastname, ocity, ophone, oemail, iva, ocomments, ocountry, olanguage, ipaddress, persons, adults, children, babies, pet, rescode, paid, feeamount, pid, iid FROM reservations');

	$eid = htmlspecialchars($rs['eid']);
	$resdate = htmlspecialchars($rs['resdate']);
	$checkin = htmlspecialchars($rs['checkin']);
	$checkout = htmlspecialchars($rs['checkout']);
	$numdays = htmlspecialchars($rs['numdays']);
	$totalprice = htmlspecialchars($rs['totalprice']);	
	$restid = htmlspecialchars($rs['restid']);
	$ofirstname = htmlspecialchars($rs['ofirstname']);
	$olastname = htmlspecialchars($rs['olastname']);
	$ocity = htmlspecialchars($rs['ocity']);
	$ophone = htmlspecialchars($rs['ophone']);
	$oemail = htmlspecialchars($rs['oemail']);
	$iva = htmlspecialchars($rs['iva']);
	$ocomments = htmlspecialchars($rs['ocomments']);
	$ocountry = htmlspecialchars($rs['ocountry']);	
	$olanguage = htmlspecialchars($rs['olanguage']);	
	$ipaddress = htmlspecialchars($rs['ipaddress']);				
	$persons = htmlspecialchars($rs['persons']);
	$adults = $rs['adults'];
	$children = $rs['children'];
	$babies = $rs['babies'];
	$pet = htmlspecialchars($rs['pet']);	
	$rescode = htmlspecialchars($rs['rescode']);
	$paid = htmlspecialchars($rs['paid']);
	$feeamount = htmlspecialchars($rs['feeamount']);	
	$pid = htmlspecialchars($rs['pid']);	
	$iid = htmlspecialchars($rs['iid']);
	
	if ($olanguage=='ca') { $olng = 'Català'; }		
	if ($olanguage=='es') { $olng = 'Español'; }		
	if ($olanguage=='en') { $olng = 'English'; }		
	if ($olanguage=='fr') { $olng = 'Francés'; }		
}
?>

		<script type="text/javascript">
            function updateState() {
				var restid = document.getElementById('restid').value;
				//var restid = estate;
				var msg ="";
				var comments = "<?php echo $ocomments; ?>";
				//restid = 3;
            
				if (window.XMLHttpRequest) {
				  xmlhttp = new XMLHttpRequest();
				}
				
				xmlhttp.onreadystatechange = function () {
				  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					 document.getElementById("txtuser").innerHTML = xmlhttp.responseText;
				  }
				}
			   
				/*
				if(restid==4){ // Si l'estat es "valoració" recorda que s'enviará un email per la valoració
					if (confirm('S\'enviarà un email al client demanant la valoració de la casa?')){
						xmlhttp.open("GET", "update_reservation_state.php?restid=" + restid + "&resid=<?php echo $id; ?>", true);
						xmlhttp.send();
					} else {
						document.getElementById('restid').value = <?php echo $restid; ?>;
					}
					
				}else if(restid==2){ // Si l'estat es "Pagament anticipat pendent" recorda que s'enviará un email al client
					if (confirm('')){
						xmlhttp.open("GET", "update_reservation_state_new.php?restid=" + restid + "&resid=<?php echo $id; ?>", true);
						xmlhttp.send();
					} else {
						document.getElementById('restid').value = <?php echo $restid; ?>;
					}
				
				} else {
					xmlhttp.open("GET", "update_reservation_state_new.php?restid=" + restid + "&resid=<?php echo $id; ?>", true);
					xmlhttp.send();
				}
				*/
				
				/*
				if(restid==2) {
					msg = "S'enviarà un email al client indicant que hi ha disponibilitat i que pot realitzar el pagament."; 
					if (comments!="") { var retVal = prompt("El client pregunta: " + comments, "La seva resposta aqui");}
					if (confirm(msg)){ 
						xmlhttp.open("GET", "update_reservation_state_new.php?restid=" + restid + "&resid=<?php echo $id; ?>", true);
						xmlhttp.send();
					}
				} else {
				*/
				
				xmlhttp.open("GET", "update_reservation_state_new.php?restid=" + restid + "&resid=<?php echo $id; ?>&email=no", true);
				xmlhttp.send();
				//}
				
				location.reload(true);
            }
        </script>
        
		<div id="main_container" class="main_container container_16 clearfix">
			<div class="flat_area grid_16">
				<h2>Reserva <?php echo $rescode?></h2>
				<p><button class="button_colour orange round_all" onClick="location.href='reservations.php'"><span>Tornar</span></button></p>
            </div>
            
			<div class="grid_16">
                <table class="static">
					<thead> 
                        <tr>
                            <th colspan="4" align="left" class="first">Detalls de la reserva</th>
                        </tr>
                    </thead>
                    
                	<tbody>
                        <tr>
                            <td width="200"><strong>Codi de la Reserva</strong></td>
                            <td><?php echo $rescode;?></td>
                            <td><strong>Total</strong></td>
                            <td><?php echo $totalprice;?> €</td>
                        </tr>
                        <tr>
                            <td><strong>Data de reserva</strong></td>
                            <td><?php echo date("d-m-Y G:i:s",strtotime($resdate));?></td>
                            <td><strong>Senyal de la reserva</strong></td>
                            <td><?php echo $feeamount;?> € <!--(<span style="color: rgb(255, 0, 0);"><?php if ($paid==0) echo "No";?> Pagat</span>)--></td>
                        </tr>
                        <tr>
                            <td><strong>Data d'arribada</strong></td>
                            <td><?php echo date("d-m-Y",strtotime($checkin));?></td>
                            <td><strong>Métode de pagament</strong></td>
                            <td><?php echo Query('paymodules', 'title_ca', 'pid', $pid); ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Data de sortida</strong></td>
                            <td><?php echo date("d-m-Y",strtotime($checkout));?></td>
                            <td><strong>IVA aplicat</strong></td>
                            <td><?php echo $iva;?> %</td>
                        </tr>
                        <tr>
                            <td><strong>Estancia</strong></td>
                            <td><?php echo $numdays;?> nits</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Persones</strong></td>
                            <td><?php echo $persons;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Adults</strong></td>
                            <td><?php echo $adults;?></td>
                            <td></td>
                            <td></td>
                        </tr>  
                        <tr>
                            <td><strong>Nens</strong></td>
                            <td><?php echo $children;?></td>
                            <td></td>
                            <td></td>
                        </tr>                        			
                        <tr>
                            <td><strong>Bebes</strong></td>
                            <td><?php echo $babies;?></td>
                            <td></td>
                            <td></td>
                        </tr>                        			
                                              			
					</tbody>
                </table>
                
                <br /><br />
                <table class="static">
					<thead> 
                        <tr>
                            <th colspan="4" align="left" class="first">Estat de la reserva</th>
                        </tr>
                    </thead>
                    
                	<tbody>
                        <tr>
                            <td style="font-size:14px; padding-top:10px;">
<?php 
	if ($restid==1) $colorstate='red';
	if ($restid==2) $colorstate='green';
	if ($restid==3) $colorstate='orange';
	if ($restid==4) $colorstate='blue';
?>
                            	<strong>Estat: <span style="color:<?php echo $colorstate; ?>"><?php echo Query('reservations_states', 'title_ca', 'restid', $restid); ?></span></strong>
                                <?php 
									if ($restid==1) {
								?>
                                	
                                    <br /><br />
                                    <?php if($ocomments!="") { ?>
                                    <form name="dispon" id="dispon" action="update_reservation_state_new.php" method="get">
                                        <p><strong>El client pregunta:</strong> <?php echo $ocomments; ?></p>
                                        <p><strong>Contesta aquí:</strong><br /><textarea name="response" id="response" style="height:50px; width:350px;"></textarea></p>
                                        <input type="hidden" id="restid" name="restid" value="2"/>
                                        <input type="hidden" id="resid" name="resid" value="<?php echo $id;?>"/>
                                    </form>
                                    <p>
                                    <button class="button_colour green round_all" style="clear:none" onClick="javascript:if (confirm('S\'enviarà un email al client demanant que faci el pagament?')){document.getElementById('dispon').submit();}"><span>Disponible</span></button>
                                    <button class="button_colour orange round_all" style="clear:none" onClick="javascript:if (confirm('S\'enviarà un email al client indicant que no hi ha disponibilitat?')){window.location = 'update_reservation_state_new.php?restid=3&resid=<?php echo $id;?>'};"><span>Sense Disponibilitat</span></button>
                                	</p>
                                    <?php } else { ?>
                                	<p>
                                    <button class="button_colour green round_all" style="clear:none" onClick="javascript:if (confirm('S\'enviarà un email al client demanant que faci el pagament?')){window.location = 'update_reservation_state_new.php?restid=2&resid=<?php echo $id;?>'};"><span>Disponible</span></button>
                                    <button class="button_colour orange round_all" style="clear:none" onClick="javascript:if (confirm('S\'enviarà un email al client indicant que no hi ha disponibilitat?')){window.location = 'update_reservation_state_new.php?restid=3&resid=<?php echo $id;?>'};"><span>Sense Disponibilitat</span></button>
                                	</p>
								<?php
									}
									} ?>
                                
                                 <?php 
									if ($restid==2) {
								?>
                                    <br /><br />
                                	<p>                                
                                    <button class="button_colour blue round_all" style="clear:none" onClick="javascript:if (confirm('S\'enviarà un email al client confirmant el pagament i la reserva?')){window.location = 'update_reservation_state_new.php?restid=4&resid=<?php echo $id;?>'};"><span>Pagament fet</span></button>
                                	</p>
                                <?php } ?>
                                
                                <p>
                                <?php 
									/*
									$establimentalt = Array();
									$pvid = Query('establiments', 'pvid', 'eid', $eid);
									$establimentalt = GetOptionalEstablimentsDisponibles ($eid,$checkin,$checkout,$persons,$pvid);
									echo "la id es: ".$establimentalt['bestprice'];
									*/
								?>
                                </p>
                        	</td>
                        </tr>
                        <?php 
						if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
						?>
                        
                        <tr>
                            <td style="font-size:14px; padding:10px;">
                            		<p><strong>Historial de canvis d'Estats</strong></p>
<?php
	/*$rs_query = mysqli_query("SELECT * FROM reservations_history WHERE resid = ".$id." ORDER BY date DESC");
	while($rs = mysqli_fetch_array($rs_query)){ */
    $db->orderBy('date','DESC');
    $db->where('resid',$id);
    $rs_query=$db->get('reservations_history',null,'*');
    foreach($rs_query as $rs){	
?>                                
									<p style="margin-bottom:0px; font-size:12px;"><?php echo date( 'd-m-Y H:i:s', strtotime($rs['date']));?> - <?php echo Query('reservations_states', 'title_ca', 'restid', $rs['restid']); ?> (<?php echo $rs['user']; ?>)</p>
                             
<?
	}
						}
?>
								
                            </td>
                    	</tr>    
                        <?php 
						if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
						?>

                        <tr>
                            <td style="font-size:14px; padding-top:10px;">
                                
                          		<p>
                                Cambi d'estat sense enviament d'email: 
                            	<select id="restid" name="restid" onchange="updateState()">
<?php
	/*$rs_query = mysqli_query("SELECT restid, title_ca FROM reservations_states");
	while($rs = mysqli_fetch_array($rs_query)){ */	
    $rs_query=$db->get('reservations_states',null,'restid, title_ca');
    foreach($rs_query as $rs){
?>                                
                                	<option value="<?php echo $rs['restid'];?>" <?php if($restid==$rs['restid']) echo "selected=\"selected\""; ?>><?php echo $rs['title_ca'];?></option>
<?
	}
?>
                            	</select>
                                </p>                        
                            </td>
                        </tr>
                        <?php 
						}
						?>
                                            
					</tbody>
                </table>
                <br><br>
                <?php 
				if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
				?>
				<table class="static">
					<thead> 
                        <tr>
                            <th colspan="2" align="left">Dades del Client</th>
                            <th colspan="2" align="left">Establiment</th>
                        </tr>
                    </thead>
                    
                	<tbody>
                        <tr>
                            <td width="200"><strong>Nom</strong></td>
                            <td width="300"><?php echo $ofirstname;?></td>
                            <td width="200"><strong>Títol</strong></td>
                            <td><a href="establiments_edit.php?id=<?php echo $eid;?>"><?php echo Query('establiments', 'title', 'eid', $eid); ?></a></td>
                        </tr>

                        <tr>
                            <td><strong>Cognoms</strong></td>
                            <td><?php echo $olastname;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                                                
                        <tr>
                            <td><strong>Localitat</strong></td>
                            <td><?php echo $ocity;?></td>
                            <td><strong>Localitat</strong></td>
                            <td><?php echo GetTitleLocalitat(Query('establiments', 'lid', 'eid', $eid)); ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Telèfon</strong></td>
                            <td><?php echo $ophone;?></td>
                            <td><strong>Direcció</strong></td>
                            <td><?php echo Query('establiments', 'address', 'eid', $eid); ?></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Email</strong></td>
                            <td><?php echo $oemail;?></td>
                            <td><strong>Telèfon</strong></td>
                            <td><?php echo Query('establiments', 'phone', 'eid', $eid); ?></td>
                        </tr>
                                               
                        <tr>
                            <td><strong>País</strong></td>
                            <td><?php echo $ocountry;?></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><strong>Idioma de contacte</strong></td>
                            <td><?php echo $olng;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <td><strong>Comentaris</strong></td>
                            <td><?php echo $ocomments;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                
                        <tr>
                            <td><strong>IP</strong></td>
                            <td><?php echo $ipaddress;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                	</tbody>
                </table>
				<?php
                } elseif ($_SESSION['type_user']=='propietario') { 	// ---------------------------------- PROPIETARIO ---------------------------------------------
                ?>
                
				<table class="static">
					<thead> 
                        <tr>
                            <th colspan="4" align="left">Dades del Client</th>
                        </tr>
                    </thead>
                    
                	<tbody>                                                
                        <tr>
                            <td width="300"><strong>Localitat</strong></td>
                            <td width="300"><?php echo $ocity;?></td>
                            <td></td>
                            <td></td>                            
                        </tr>
                                                                       
                        <tr>
                            <td><strong>País</strong></td>
                            <td><?php echo $ocountry;?></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><strong>Idioma de contacte</strong></td>
                            <td><?php echo $olanguage;?></td>
                            <td></td>
                            <td></td>
                        </tr>
                	</tbody>
                </table>                
                
                <?php
				}
				?>
				<br><br>
                <table class="static">
                	<thead>
                        <tr>
                            <th colspan="5" align="left">Reserva</th>
                        </tr>
                        
                        <tr>
                            <th>Concepte</th>
                            <th>Quantitat x Nits</th>
                            <th colspan="2" style="text-align:right;">Preu</th>
                        </tr>
                    </thead>
                    
                    <tbody>
<?php                    

		/*$rs_query = mysqli_query("SELECT riid, resid, rid, sdate, edate, quantity, price FROM reserveditems WHERE resid = ".$id." ORDER BY riid ASC");
		while($rs = mysqli_fetch_array($rs_query)){ */
        $db->orderBy('riid','ASC');
        $db->where('resid',$id);
        $rs_query=$db->get('reserveditems',null,'riid, resid, rid, sdate, edate, quantity, price');
        foreach($rs_query as $rs){                   
?>
                        <tr>
                        	<td>
<?php 
								if ($iid==1) echo Query('rooms', 'title_ca', 'rid', $rs['rid']);
								if ($iid==2) echo "Casa Sencera";
?>                        
							</td>
                            
                            <td><?php echo $rs['quantity']; ?> x <?php echo $numdays;?> nits</td>
                            <td align="right" colspan="2"><?php echo round($rs['price'] * $rs['quantity'],2); ?> €</td>
                        </tr>
<?php 	} ?>                

                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td valign="top"><strong>Total</strong></td>
                            <td align="right"><strong><?php echo $totalprice; ?> €</strong></td>
                        </tr>   
                                               
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td valign="top">Senyal per la reserva</td>
                            <td align="right"><?php echo $feeamount; ?> €</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td valign="top">Resta per pagar</td>
                            <td align="right"><?php echo round($totalprice - $feeamount,2); ?> €</td>
                        </tr>
                        
                     
                    </tbody>
                </table>
                <br><br>
			</div>
		</div>
		
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>

<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
		
<?php include 'includes/closing_items.php' ?>