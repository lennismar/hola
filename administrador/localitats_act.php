<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];
$title = ($_POST['title']);
$pvid = ($_POST['pvid']);
$comid = ($_POST['comid']);



if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- Borrar registre -----------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		//mysqli_query("DELETE FROM localitats WHERE lid = " . $id);
		$db->where('lid',$id);
		$db->delete('localitats');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE localitats SET "; 
			$SQL .= "title = '" . $title . "', ";
			$SQL .= "pvid = " . $pvid . ", ";
			$SQL .= "comid = " . $comid . " ";
			$SQL .= "WHERE lid = " . $id;

			mysqli_query($SQL);*/
			$data=Array(
				'title'=>$title,
				'pvid'=>$pvid,
				'comid'=>$comid
			);
			$db->where('lid',$id);
			$db->update('localitats',$data);
		}


	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO localitats (title, pvid, comid) VALUES(";
			$SQL .= "'".$title."',";
			$SQL .= $pvid.",";
			$SQL .= $comid.")";
			
			mysqli_query($SQL);*/
			$data=Array(
				'title'=>$title,
				'pvid'=>$pvid,
				'comid'=>$comid
			);
			$db->insert('localitats',$data);
		}
	}
}

header("location: localitats.php");
?>