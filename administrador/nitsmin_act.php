<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];
$nom = ($_POST['nom']);
$date_start = dateToMySQL($_POST['date_start']);
$date_end = dateToMySQL($_POST['date_end']);
$nitsmin = $_POST['nitsmin'];

if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- Borrar registre -----------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		//mysqli_query("DELETE FROM nitsmin WHERE nm = " . $id);
		$db->where('nm',$id);
		$db->delete('nitsmin');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE nitsmin SET "; 
			$SQL .= "nom = '" . $nom . "', ";
			$SQL .= "date_start = '" . $date_start . "', ";
			$SQL .= "date_end = '" . $date_end . "', ";
			$SQL .= "nitsmin = " . $nitsmin . " ";			
			$SQL .= "WHERE nm = " . $id;
			mysqli_query($SQL);*/
			$data=Array(
				'nom'=>$nom,
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'nitsmin'=>$nitsmin
			);
			$db->where('nm',$id);
			$db->update('nitsmin',$data);
				
		}

	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO nitsmin (nom, date_start, date_end, nitsmin) VALUES(";
			$SQL .= "'".$nom."',";
			$SQL .= "'".$date_start."',";
			$SQL .= "'".$date_end."',";
			$SQL .= $nitsmin.")";
			mysqli_query($SQL);*/
			$data=Array(
				'nom'=>$nom,
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'nitsmin'=>$nitsmin
			);
			$db->insert('nitsmin',$data);
		}
	}
}

header("location: nitsmin.php");
?>