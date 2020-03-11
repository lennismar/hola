<?php 
$superadmin = 1;
$id=$_GET["cid"];
echo $id;
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php' ?>
                
                <div class="flat_area grid_16">
                
<?php
if(isset($id)){
	/*$rs_query = mysqli_query("SELECT cid, comcode, eid, title_ca, title_es, title_en,title_fr, comments_ca, comments_es, comments_en, comments_fr, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, como, date, ipaddress, resid, published, state FROM comments WHERE cid = " . $id);
	$rs = mysqli_fetch_array($rs_query);*/
    $db->where('cid',$id);
    $rs=$db->getOne('comments','cid, comcode, eid, title_ca, title_es, title_en,title_fr, comments_ca, comments_es, comments_en, comments_fr, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, como, date, ipaddress, resid, published, state');

	$comcode = $rs['comcode'];	
	$eid = $rs['eid'];
	$title_ca = htmlspecialchars($rs['title_ca']);
	$title_es = htmlspecialchars($rs['title_es']);
	$title_en = htmlspecialchars($rs['title_en']);		
	$title_fr = htmlspecialchars($rs['title_fr']);		

	$comments_ca = htmlspecialchars($rs['comments_ca']);
	$comments_es = htmlspecialchars($rs['comments_es']);
	$comments_en = htmlspecialchars($rs['comments_en']);		
	$comments_fr = htmlspecialchars($rs['comments_fr']);		

	$netega = $rs['netega'];
	$tracte = $rs['tracte'];
	$entorn = $rs['entorn'];
	$equipaments = $rs['equipaments'];
	$relacio = $rs['relacio'];
	$somni = $rs['somni'];	
	$natura = $rs['natura'];
	$sensacio = $rs['sensacio'];
	$como = $rs['como'];					
	$date = $rs['date'];
	$ipaddress = $rs['ipaddress'];
	$resid = $rs['resid'];
	$published = $rs['published'];			
	$state = $rs['state'];
}
?>
    				<h2>Valoració de <?php echo Query('establiments', 'title', 'eid', $eid); ?></h2>
                </div>
                      
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                	<form id="valoraciones_form" action="valoraciones_act.php" method="post" enctype="multipart/form-data">  
                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <input type="hidden" name="action" value="process">
                                        <label>Publicat</label>
                                        <div class="input_group">
                                            <input name="published" id="published" type="radio" value="1" <?php if ($published==1) echo "checked" ?>>Si
                                            &nbsp;&nbsp;
                                            <input name="published" id="published" type="radio" value="0"  <?php if ($published==0) echo "checked" ?>>No
                                        </div> 
                                        
                                        <label>Codi de Valoració</label><p><?php echo $comcode; ?></p>
                                        <label>Titol <img src="images/language/ca.gif" width="23" height="13"></label><input type="text" name="title_ca" value="<?php echo $title_ca; ?>" style="width:500px"/>
                                        <label>Titol <img src="images/language/es.gif" width="23" height="13"></label><input type="text" name="title_es" value="<?php echo $title_es; ?>" style="width:500px"/>
                                        <label>Titol <img src="images/language/en.gif" width="23" height="13"></label><input type="text" name="title_en" value="<?php echo $title_en; ?>" style="width:500px"/>
                                        <label>Titol <img src="images/language/fr.gif" width="23" height="13"></label><input type="text" name="title_fr" value="<?php echo $title_fr; ?>" style="width:500px"/>
                                        
                                        <label>Comentaris <img src="images/language/ca.gif" width="23" height="13"></label> 
                                        <textarea id="comments_ca" name="comments_ca" style="width:500px"><?php echo $comments_ca;?></textarea>
                                        
                                        <label>Comentaris <img src="images/language/es.gif" width="23" height="13"></label> 
                                        <textarea id="comments_es" name="comments_es" style="width:500px"><?php echo $comments_es;?></textarea>
                                        
                                        <label>Comentaris <img src="images/language/en.gif" width="23" height="13"></label>
                                        <textarea id="comments_en" name="comments_en" style="width:500px"><?php echo $comments_en;?></textarea>                                        

                                        <label>Comentaris <img src="images/language/fr.gif" width="23" height="13"></label>
                                        <textarea id="comments_fr" name="comments_fr" style="width:500px"><?php echo $comments_fr;?></textarea>                                        


                                        <label>Netega</label> <p><?php echo $netega; ?></p>   
                                        <label>Tracte</label> <p><?php echo $tracte; ?></p>   
                                        <label>Entorn</label> <p><?php echo $entorn; ?></p>   
                                        <label>Equipaments</label> <p><?php echo $equipaments; ?></p>   
                                        <label>Relació Qualitat/Preu</label> <p><?php echo $relacio; ?></p>   
                                        <label>Qualitat del Somni</label> <p><?php echo $somni; ?></p>  
                                        <label>Relación amb la naturalesa</label> <p><?php echo $natura; ?></p>   
                                        <label>Sensació de pau i tranquilitat</label> <p><?php echo $sensacio; ?></p>  
                                        <label>Com has viatjat a la casa rural?</label> <p><?php echo CommentsHow($como); ?></p> 
                                        <label>Data de la Valoració</label> <p><?php echo $date; ?></p>
                                        <label>IP</label> <p><?php echo $ipaddress; ?></p>
                                        <br />
                                        <label>Reserva</label><p><a href="reservations_view.php?id=<?php echo $resid; ?>"><?php echo Query('reservations', 'rescode', 'resid', $resid); ?></a></p>
										<br /><br />
                                    </form> 
								</div>
                            </ul>
						</div>
                	</div>
				</div>
                
                                
				<div class="flat_area grid_16">
                    <p>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'valoraciones.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.valoraciones_form.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Guardar</span></button>
					</p>
				</div>  
             
			</div>
		</div>
       
<script type="text/javascript" src="js/tipsy/jquery.tipsy.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>
       
<?php include 'includes/closing_items.php'?>