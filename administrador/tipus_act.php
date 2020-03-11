<?php
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];
$title_es = ($_POST['title_es']);
$title_ca = ($_POST['title_ca']);
$title_en = ($_POST['title_en']);
$title_fr = ($_POST['title_fr']);

if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- Borrar registre -----------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		//mysqli_query("DELETE FROM tipus WHERE tid = " . $id);
		$db->where('tid',$id);
		$db->delete('tipus');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE tipus SET "; 
			$SQL .= "title_es = '" . $title_es . "', ";
			$SQL .= "title_ca = '" . $title_ca . "', ";
			$SQL .= "title_en = '" . $title_en . "', ";
			$SQL .= "title_fr = '" . $title_fr . "'";			
			$SQL .= "WHERE tid = " . $id;

			mysqli_query($SQL);*/
			$data=Array(
				'title_es'=>$title_es,
				'title_ca'=>$title_ca,
				'title_en'=>$title_en,
				'title_fr'=>$title_fr
			);
			$db->where('tid',$id);
			$db->update('tipus',$data);
				
		}


	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO tipus (title_es, title_ca, title_en, title_fr) VALUES(";
			$SQL .= "'".$title_es."',";
			$SQL .= "'".$title_ca."',";
			$SQL .= "'".$title_en."',";
			$SQL .= "'".$title_fr."')";*
			
			mysqli_query($SQL);*/
			$data=Array(
				'title_es'=>$title_es,
				'title_ca'=>$title_ca,
				'title_en'=>$title_en,
				'title_fr'=>$title_fr
			);
			$db->insert('tipus',$data);
		}
	}
}

header("location: tipus.php");
?>