<div id="sidebar">
	<div class="cog">+</div>
	
	<!--<a href="index.php" class="logo"><span>Adminica Pro II</span></a>-->
    <span style="font-family:Verdana, Geneva, sans-serif; font-size:31px; color:#CCC; font-weight:bold">somrurals</span>
	<br />

    <?php 
	if ($_SESSION['type_user']=='superadmin') {  // ---------------------------------- SUPERADMIN ---------------------------------------------
	?>
    
    <div class="user_box round_all clearfix">
		<!--<img src="images/profile.jpg" width="55" alt="Profile Pic" />-->
		<h2>Administrador</h2>
		<!--<h3><a class="text_shadow" href="#">Oliver</a></h3>-->
        <!--<h3 class="text_shadow">Administrador</h3>-->
		<ul>
			<li><a href="#">configuració</a><span class="divider">|</span></li>
			<li><a href="logoff.php">sortir</a></li>
		</ul>
	</div><!-- #user_box -->

	<ul id="accordion" class="round_all">
		<li><a href="#" class="top_level"><img src="images/icons/small/grey/laptop.png"/>Dashboard</a></li>
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/cog_2.png"/>Configuracions</a>
            <ul class="drawer">
                <li><a href="configuration.php">Configuració</a></li>
                <li><a href="page_home_edit.php">Pàgina Home</a></li>
                <li><a href="texto_buscador.php">Text Cercador</a></li>  
                <!--              
                <li><a href="banners_header.php">Banners Capçalera</a></li>      
                <li><a href="banners_columna.php">Banners Columna</a></li> 
                -->         
                <li><a href="nitsmin.php">Mínim Nits Global</a></li>
                <li><a href="localitats.php">Localitats</a></li>
                <li><a href="comarques.php">Comarques</a></li>
                <li><a href="provincies.php">Provincies</a></li>
            </ul>
        </li>  
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/home.png"/>Establiments</a>
            <ul class="drawer">
                <li><a href="establiments.php">Establiments</a></li>
                <li><a href="tipus.php">Tipus d'Allotjament</a></li>
                <li><a href="images.php">Galeria d'Imatges</a></li>
                <li><a href="establimentsnitsmin.php">Mínim Nits</a></li>
                <li><a href="valoraciones.php">Valoracions</a></li>
            </ul>
        </li>     
 
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/day_calendar.png"/>Gestió Disponibilitats</a>
            <ul class="drawer">
                <li><a href="establimentspreus.php">Establiment Sencer</a></li>
                <li><a href="rooms.php">Establiment Hab.</a></li>
                <li><a href="reservations.php">Reserves</a></li>
            </ul>
        </li>    
 
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/camera.png"/>Recursos turístics</a>
            <ul class="drawer">
                <li><a href="recursos.php">Recursos turístics</a></li>
                <li><a href="recursostipus.php">Tipus de recursos</a></li>
            </ul>
        </li> 
        
        <li><a href="landings.php"><img src="images/icons/small/grey/airplane.png"/>Landings</a></li>
  
        
        <!--           
   		<li><a href="#" onClick="parent.location='recursos.php'" class="top_level"><img src="images/icons/small/grey/camera.png"/>Recursos turístics</a></li>
        <li><a href="#" onClick="parent.location='comments.php'" class="top_level"><img src="images/icons/small/grey/microphone.png"/>Comentaris</a></li>        
        <li><a href="#" onClick="parent.location='localitats.php'" class="top_level"><img src="images/icons/small/grey/sign_post.png"/>Localitats</a></li>
        <li><a href="#" onClick="parent.location='configuration.php'" class="top_level"><img src="images/icons/small/grey/cog_2.png"/>Configuració</a></li>
        <li><a href="#" onClick="parent.location='establiments.php'" class="top_level"><img src="images/icons/small/grey/home.png"/>Establiments</a></li>
        <li><a href="#" onClick="parent.location='tipus.php'" class="top_level"><img src="images/icons/small/grey/home_2.png"/>Tipus d'Allotjament</a></li>        
        <li><a href="#" onClick="parent.location='establimentspreus.php'" class="top_level"><img src="images/icons/small/grey/home.png"/>Preus Establiment</a></li>    
        <li><a href="#" onClick="parent.location='images.php'" class="top_level"><img src="images/icons/small/grey/home.png"/>Galeria d'Imatges</a></li>        
        <li><a href="#" onClick="parent.location='rooms.php'" class="top_level"><img src="images/icons/small/grey/key.png"/>Habitacions</a></li>
		<li><a href="#" onClick="parent.location='reservations.php'" class="top_level"><img src="images/icons/small/grey/day_calendar.png"/>Reserves</a></li>
   		<li><a href="#" onClick="parent.location='recursostipus.php'" class="top_level"><img src="images/icons/small/grey/camera.png"/>Tipus de recursos</a></li>        
        -->
	</ul>
	<?php 
	} 
	elseif ($_SESSION['type_user']=='propietario') { 	// ---------------------------------- PROPIETARIO ---------------------------------------------
	?>
    <div class="user_box round_all clearfix">
		<!--<img src="images/profile.jpg" width="55" alt="Profile Pic" />-->
        <h2>Benvingut Propietari</h2>
		<h2><?php echo Query('establiments', 'title', 'eid', $_SESSION['eid'])?> </h2>
		<!--<h3><a class="text_shadow" href="#">Oliver</a></h3>-->
        <!--<h3 class="text_shadow">Administrador</h3>-->
		<ul>
			<!--<li><a href="#">configuració</a><span class="divider">|</span></li>-->
			<li><a href="logoff.php">sortir</a></li>
		</ul>
	</div><!-- #user_box -->

	<ul id="accordion" class="round_all">
		<!--<li><a href="#" class="top_level"><img src="images/icons/small/grey/laptop.png"/>Dashboard</a></li>-->
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/home.png"/>Establiment</a>
            <ul class="drawer">
                <li><a href="establiments_edit.php?id=<?php echo $_SESSION['eid'];?>">Establiment</a></li>
                <!--<li><a href="tipus.php">Tipus d'Allotjament</a></li>-->
                <li><a href="images_edit.php?id=<?php echo $_SESSION['eid'];?>">Galeria d'Imatges</a></li>
				 <li><a href="establimentsnitsmin.php">Mínim Nits</a></li>
            </ul>
        </li>     
 
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/day_calendar.png"/>Gestió Disponibilitats</a>
            <ul class="drawer">
                <li><a href="establimentspreus_edit.php?id=<?php echo $_SESSION['eid'];?>">Establiment Sencer</a></li>
                <li><a href="rooms.php">Establiment Hab.</a></li>
                <li><a href="reservations.php">Reserves</a></li>
            </ul>
        </li>
	</ul>
            	
    <?php }     
	elseif(in_array($_SESSION['type_user'], $usuarios_excluidos)) {  // ---------------------------------- USUARIOS EXCLUIDOS ---------------------------------------------
	?>
    <div class="user_box round_all clearfix">
		<!--<img src="images/profile.jpg" width="55" alt="Profile Pic" />-->
		<h2><?php echo ucfirst($_SESSION['type_user']); ?></h2>
		<!--<h3><a class="text_shadow" href="#">Oliver</a></h3>-->
        <!--<h3 class="text_shadow">Administrador</h3>-->
		<ul>
			<li><a href="#">configuració</a><span class="divider">|</span></li>
			<li><a href="logoff.php">sortir</a></li>
		</ul>
	</div><!-- #user_box -->

	<ul id="accordion" class="round_all">
		<li><a href="#" class="top_level"><img src="images/icons/small/grey/laptop.png"/>Dashboard</a></li>
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/cog_2.png"/>Configuracions</a>
            <ul class="drawer">
                <li><a href="configuration.php">Configuració</a></li>
                <li><a href="page_home_edit.php">Pàgina Home</a></li>
                <li><a href="texto_buscador.php">Text Cercador</a></li>  
                <!--              
                <li><a href="banners_header.php">Banners Capçalera</a></li>      
                <li><a href="banners_columna.php">Banners Columna</a></li> 
                -->         
                <li><a href="nitsmin.php">Mínim Nits Global</a></li>
                <li><a href="localitats.php">Localitats</a></li>
                <li><a href="comarques.php">Comarques</a></li>
                <li><a href="provincies.php">Provincies</a></li>
            </ul>
        </li>  
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/home.png"/>Establiments</a>
            <ul class="drawer">
                <li><a href="establiments.php">Establiments</a></li>
                <li><a href="tipus.php">Tipus d'Allotjament</a></li>
                <li><a href="images.php">Galeria d'Imatges</a></li>
                <li><a href="establimentsnitsmin.php">Mínim Nits</a></li>
                <li><a href="valoraciones.php">Valoracions</a></li>
            </ul>
        </li>     
 
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/day_calendar.png"/>Gestió Disponibilitats</a>
            <ul class="drawer">
                <li><a href="establimentspreus.php">Establiment Sencer</a></li>
                <li><a href="rooms.php">Establiment Hab.</a></li>
            </ul>
        </li>    
 
        <li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/camera.png"/>Recursos turístics</a>
            <ul class="drawer">
                <li><a href="recursos.php">Recursos turístics</a></li>
                <li><a href="recursostipus.php">Tipus de recursos</a></li>
            </ul>
        </li> 
        
        <li><a href="landings.php"><img src="images/icons/small/grey/airplane.png"/>Landings</a></li>
	</ul>
	<?php 
	} ?>
</div><!-- #sidebar -->
