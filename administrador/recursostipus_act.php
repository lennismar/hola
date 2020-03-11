<?php
$superadmin = 1;
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
		//mysqli_query("DELETE FROM recursos_tipus WHERE idtipusrecurso = " . $id);
		$db->where('idtipusrecurso',$id);
		$db->delete('recursos_tipus');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE recursos_tipus SET "; 
			$SQL .= "title_es = '" . $title_es . "', ";
			$SQL .= "title_ca = '" . $title_ca . "', ";
			$SQL .= "title_en = '" . $title_en . "', ";
			$SQL .= "title_fr = '" . $title_fr . "' ";
			$SQL .= "WHERE idtipusrecurso = " . $id;

			mysqli_query($SQL);*/
			$data=Array(
				"title_ca"=>$title_ca,
				"title_es"=>$title_es,
				"title_fr"=>$title_fr,
				"title_en"=>$title_en
			);
			$db->where('idtipusrecurso',$id);
			$db->update('recursos_tipus',$data);
		}


	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO recursos_tipus (title_es, title_ca, title_en, title_fr) VALUES(";
			$SQL .= "'".$title_es."',";
			$SQL .= "'".$title_ca."',";
			$SQL .= "'".$title_en."',";
			$SQL .= "'".$title_fr."')";			
			mysqli_query($SQL);	*/
			$data=Array(
				"title_ca"=>$title_ca,
				"title_es"=>$title_es,
				"title_fr"=>$title_fr,
				"title_en"=>$title_en
			);
			$db->insert('recursos_tipus',$data);
		}
	}
}

header("location: recursostipus.php");
?>