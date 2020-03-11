<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];
$description_es = ($_POST['description_es']);
$description_ca = ($_POST['description_ca']);
$description_en = ($_POST['description_en']);
$description_fr = ($_POST['description_fr']);



if(isset($action) || $_GET['action']!=""){

	if($action == "process"){
		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$rs_query = mysqli_query("SELECT headimage1, headimage2, headimage3 FROM provincies WHERE pvid = " . $id);
			$rs = mysqli_fetch_array($rs_query);*/
			$db->where('pvid',$id);
			$rs=$db->getOne('provincies','headimage1, headimage2, headimage3');
			
			
			if($rs['headimage1'] != ""){
				$headimage1 = upload_file('headimage1', $rs['headimage1'], FILE_DIR . "provincias/");
			}
			else{
				$headimage1 = upload_file('headimage1', '', FILE_DIR . "provincias/");
			}

			if($rs['headimage2'] != ""){
				$headimage2 = upload_file('headimage2', $rs['headimage2'], FILE_DIR . "provincias/");
			}
			else{
				$headimage2 = upload_file('headimage2', '', FILE_DIR . "provincias/");
			}


			if($rs['headimage3'] != ""){
				$headimage3 = upload_file('headimage3', $rs['headimage3'], FILE_DIR . "provincias/");
			}
			else{
				$headimage3 = upload_file('headimage3', '', FILE_DIR . "provincias/");
			}


			/*$SQL = "UPDATE provincies SET "; 
			$SQL .= "description_es = '" . $description_es . "', ";
			$SQL .= "description_ca = '" . $description_ca . "', ";
			$SQL .= "description_en = '" . $description_en . "', ";									
			$SQL .= "description_fr = '" . $description_fr . "', ";									
			$SQL .= "headimage1 = '" . $headimage1 . "', ";
			$SQL .= "headimage2 = '" . $headimage2 . "', ";
			$SQL .= "headimage3 = '" . $headimage3 . "' ";

			$SQL .= "WHERE pvid = " . $id;

			mysqli_query($SQL);*/
			$db->where('pvid',$id);
			$data=Array(
				"description_es" => $description_es,
				"description_ca" => $description_ca,
				"description_en" => $description_en,									
				"description_fr" => $description_fr,									
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3
			);
			$db->update('provincies',$data);
		}
	}
}

header("location: provincies.php");
?>