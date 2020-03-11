<?php
include 'includes/config.php';

if(isset($_POST['usuari']) && isset($_POST['clau']))
{
	$clau_post = md5($_POST['clau']); //codifica lo escrito en md5
	$usuari_post = $_POST['usuari'];
	$encontrado=false;
	//echo $clau_post;exit();
	// Clave del SUPERADMIN
	$usuario = 'superadmin';
	$clau = '61d84288e21c002a76aa98e9e71bb009';
    //$clau = '743579237c0970c95aeddc354b18117f';   // Original.. el 'atipus'
    for($i=0;$i<count($usuarios);$i++){
    	if(in_array($usuari_post, $usuarios[$i])){
    		$encontrado=true;
    		$posicion=$i;
    		break;
    	}
    }
	/*if ($usuario == $usuari_post) { // ------------------------------------- SUPERADMIN -------------------------------------------------
		if($clau == $clau_post){
			session_start();

			$_SESSION['type_user'] = 'superadmin';
			header("location: reservations.php");exit();
		} else {
		?>
		<script type="text/javascript">
		<!--
			alert('Contrasenya Incorrecta');
		//-->
		</script>
		<?php
		}
	}elseif($encontrado == true){*/
	if($encontrado == true){// ------------------- USUARIOS --------------------------------------------------
		if($usuarios[$posicion]['clau'] == $clau_post ){
			session_start();
			if($usuari_post == 'superadmin'){ $_SESSION['type_user'] = 'superadmin'; header("location: reservations.php");exit();}
			else {$_SESSION['type_user'] = 'operador';header("location: establiments.php");exit();}
			
		/*$clau_post=md5($_POST['clau']);
		$clau= '6a8efb01b806ba7189de0205a976477f';
		if($clau == $clau_post){
			session_start();
			$_SESSION['type_user'] = 'operador';
			header("location: establiments.php");exit();*/
		} else {
		?>
			<script type="text/javascript">
				alert('Contrasenya Incorrecta');
			</script>
		<?php
		}
	} else { // ------------------------------------------------------------ PROPIETARI -------------------------------------------------
		
		//$query = mysqli_query("SELECT * FROM establiments WHERE userlocked=0 AND user = '" . $usuari_post . "' AND userpsw = '" . $clau_post . "'");
        $user = $db->rawQueryOne ('SELECT * FROM establiments WHERE userlocked=0 AND user = ? AND userpsw = ?', array($usuari_post, $clau_post));
		//echo $db->getLastQuery();exit();
		if($db->count > 0) {
		//if($rs = mysqli_fetch_array($query)){
			session_start();
			$_SESSION['type_user'] = 'propietario';
			$_SESSION['eid'] = $user['eid'];
			header("location: establiments_edit.php?id=".$user['eid']); exit();
			//header("location: includes/checkuser.php");
		} else {
		?>
			<script type="text/javascript">
			<!--
				alert('Usuari o Contrasenya Incorrecta');
			//-->
			</script>
		<?php
		}
	}
}

?>

<?php include 'includes/document_head_login.php' ?>
 
		<div id="login_box" class="round_all clearfix">
		<form method="post" action="">
			<label class="fields"><strong>Usuari</strong><input type="text" id="usuari" name="usuari" class="indent round_all"></label>
			<label class="fields"><strong>Clau</strong><input type="password" id="clau" name="clau" class="indent round_all"></label>
			<button class="button_colour round_all" onClick="submit();"><img width="24" height="24" alt="Locked 2" src="images/icons/small/white/locked_2.png"><span>Login</span></button>
			<!--
            <div id="bar" class="round_bottom">
				<label><input type="checkbox">Auto-login en el futur.</label>
				<a href="#">Has perdut la teva clau?</a>
			</div>
            -->		
			<!--<a href="#" id="login_logo"><span>Adminica</span></a>-->
		</form>
		</div>
		
	</body>
</html>

