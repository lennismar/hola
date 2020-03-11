<?php
include 'includes/checkuser.php';
include('includes/config.php');


// Verifiquem que aquesta página ha estat trucada desde el formulari
if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- BORRAR IMATGE ----------------------------
	
	if($_GET['action'] == "del"){
		$eid = $_GET['eid'];
		$filename = $_GET['filename'];
		# Borrado de la imagen en local
		delete_file(FILE_DIR . "establiments/" . $filename);
		#Borrado del thumbnail en local
		delete_file(FILE_DIR . "establiments/" . 'thumb_'.$filename);
		//mysqli_query("DELETE FROM establiments_images WHERE eid = " . $eid . " AND filename = '".$filename."'");
		$db->where('eid',$eid);
		$db->where('filename',$filename);
		$db->delete('establiments_images');
	}
	
	// ------------------------------------------------------------------
	
	// ----------------------- IMAGEN COMO PRINCIPAL --------------------
	
	if($_GET['action'] == "principal"){
		$eid = $_GET['eid'];
		$filename = $_GET['filename'];
		//mysqli_query("UPDATE establiments_images SET principal = 0 WHERE eid = " . $eid);
		$db->where('eid',$eid);
		$data=Array('principal'=>0);
		$db->update('establiments_images',$data);
		//mysqli_query("UPDATE establiments_images SET principal = 1 WHERE filename = '".$filename."'");
		$db->where('filename',$filename);
		$data=Array('principal'=>1);
		$db->update('establiments_images',$data);
	}
	
	// ------------------------------------------------------------------	
}


header("location: images_edit.php?id=".$eid);
?>
