<?php
include 'includes/checkuser.php';
include('includes/config.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];

$title_ca = ($_POST['title_ca']);
$title_es = ($_POST['title_es']);
$title_en = ($_POST['title_en']);
$title_fr = ($_POST['title_fr']);
$description_es = ($_POST['description_es']);
$description_ca = ($_POST['description_ca']);
$description_en = ($_POST['description_en']);
$description_fr = ($_POST['description_fr']);
$eid = $_POST['eid'];
$persons = $_POST['persons'];
$published = $_POST['published'];
$availability = $_POST['availability'];
$daysmin = $_POST['daysmin'];
$daysant = $_POST['daysant'];

// Verifiquem que aquesta página ha estat trucada desde el formulari
if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- BORRAR HABITACIÓ -----------------------
	/*
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		mysql_query("DELETE FROM tipus WHERE tid = " . $id);
	}
	*/
	// ------------------------------------------------------------------


	if($action == "process"){
		
	// ----------------------- EDITAR HABITACIÓ	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE rooms SET "; 
			$SQL .= "title_ca = '" . $title_ca . "', ";
			$SQL .= "title_es = '" . $title_es . "', ";
			$SQL .= "title_en = '" . $title_en . "', ";						
			$SQL .= "title_fr = '" . $title_fr . "', ";						
			$SQL .= "description_es = '" . $description_es . "', ";
			$SQL .= "description_ca = '" . $description_ca . "', ";
			$SQL .= "description_en = '" . $description_en . "', ";
			$SQL .= "description_fr = '" . $description_fr . "', ";
			$SQL .= "eid = " . $eid . ", ";
			$SQL .= "persons = " . $persons . ", ";	
			$SQL .= "availability = " . $availability . ", ";						
			$SQL .= "published = " . $published . ", ";
			$SQL .= "daysmin = " . $daysmin . ", ";
			$SQL .= "daysant = " . $daysant . " ";		
			$SQL .= "WHERE rid = " . $id;

			//echo $SQL;
			mysqli_query($SQL);*/
			$data = Array(
				"title_ca"=>$title_ca,
				"title_es"=>$title_es,
				"title_en"=>$title_en,
				"title_fr"=>$title_fr,
				"description_ca"=>$description_ca,
				"description_es"=>$description_es,
				"description_en"=>$description_en,
				"description_fr"=>$description_fr,
				"eid"=>$eid,
				"persons"=>$persons,
				"published"=>$published,
				"availability"=>$availability,
				"published"=>$published,
				"daysmin"=>$daysmin,
				"daysant"=>$daysant
			);
			$db->where("rid",$id);
			$db->update("rooms",$data);
					
		}
	// ---------------------------------------------------------------



	// ----------------------- NOVA HABITACIÓ	----------------------
		else{
			/*$SQL = "INSERT INTO rooms (title_ca, title_es, title_en, title_fr, description_ca, description_es, description_en, description_fr, eid, persons, published, availability, daysmin, daysant) VALUES(";
			$SQL .= "'" . $title_ca . "', ";
			$SQL .= "'" . $title_es . "', ";
			$SQL .= "'" . $title_en . "', ";						
			$SQL .= "'" . $title_fr . "', ";						

			$SQL .= "'" . $description_es . "', ";
			$SQL .= "'" . $description_ca . "', ";
			$SQL .= "'" . $description_en . "', ";
			$SQL .= "'" . $description_fr . "', ";

			$SQL .= $eid . ", ";
			$SQL .= $persons . ", ";
			$SQL .= $published . ", ";
			$SQL .= $availability . ", ";			
			$SQL .= $daysmin . ", ";
			$SQL .= $daysant . ")";	*/						
			
			$data = Array(
				"title_ca"=>$title_ca,
				"title_es"=>$title_es,
				"title_en"=>$title_en,
				"title_fr"=>$title_fr,
				"description_ca"=>$description_ca,
				"description_es"=>$description_es,
				"description_en"=>$description_en,
				"description_fr"=>$description_fr,
				"eid"=>$eid,
				"persons"=>$persons,
				"published"=>$published,
				"availability"=>$availability,
				"daysmin"=>$daysmin,
				"daysant"=>$daysant
			);
			//echo $SQL;
			//mysqli_query($SQL);		
			$new_id=$db->insert('rooms',$data);
			//$new_id = mysqli_insert_id();
			
			//$SQL = "INSERT INTO rooms_prices_backup (rid) VALUES(".$new_id.")";	
			//mysqli_query($SQL);
			$data2=array('rid'=>$id);
			$db->insert("rooms_prices_backup",$data2);
		}
	// ---------------------------------------------------------------	
	}
}

header("location: rooms.php");
?>