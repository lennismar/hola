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
			/*$rs_query = mysqli_query("SELECT headimage1, headimage2, headimage3 FROM comarques WHERE comid = " . $id);
			$rs = mysqli_fetch_array($rs_query);*/
			$db->where('comid',$id);
			$rs=$db->getOne('comarques','headimage1, headimage2, headimage3');
			
			if($rs['headimage1'] != ""){
				$headimage1 = upload_file('headimage1', $rs['headimage1'], FILE_DIR . "comarcas/");
			}
			else{
				$headimage1 = upload_file('headimage1', '', FILE_DIR . "comarcas/");
			}

			if($rs['headimage2'] != ""){
				$headimage2 = upload_file('headimage2', $rs['headimage2'], FILE_DIR . "comarcas/");
			}
			else{
				$headimage2 = upload_file('headimage2', '', FILE_DIR . "comarcas/");
			}


			if($rs['headimage3'] != ""){
				$headimage3 = upload_file('headimage3', $rs['headimage3'], FILE_DIR . "comarcas/");
			}
			else{
				$headimage3 = upload_file('headimage3', '', FILE_DIR . "comarcas/");
			}

			
			/*$SQL = "UPDATE comarques SET "; 
			$SQL .= "description_es = '" . $description_es . "', ";
			$SQL .= "description_ca = '" . $description_ca . "', ";
			$SQL .= "description_en = '" . $description_en . "', ";									
			$SQL .= "description_fr = '" . $description_fr . "', ";									
			$SQL .= "headimage1 = '" . $headimage1 . "', ";
			$SQL .= "headimage2 = '" . $headimage2 . "', ";
			$SQL .= "headimage3 = '" . $headimage3 . "' ";

			$SQL .= "WHERE comid = " . $id;

			mysqli_query($SQL);*/
			$data=Array(
				"description_es" => $description_es,
				"description_ca" => $description_ca,
				"description_en" => $description_en,									
				"description_fr" => $description_fr,									
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3
			);
			$db->where('comid',$id);
			$db->update('comarques',$data);
		}
	}
}

header("location: comarques.php");
?>