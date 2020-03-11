<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];
$title_ca = ($_POST['title_ca']);
$title_es = ($_POST['title_es']);
$title_en = ($_POST['title_en']);
$title_fr = ($_POST['title_fr']);

$description_ca = ($_POST['description_ca']);
$description_es = ($_POST['description_es']);
$description_en = ($_POST['description_en']);
$description_fr = ($_POST['description_fr']);

$smalldescription_ca = ($_POST['smalldescription_ca']);
$smalldescription_es = ($_POST['smalldescription_es']);
$smalldescription_en = ($_POST['smalldescription_en']);
$smalldescription_fr = ($_POST['smalldescription_fr']);

$quever_es = htmlspecialchars($_POST['quever_es']);
$quever_ca = htmlspecialchars($_POST['quever_ca']);
$quever_en = htmlspecialchars($_POST['quever_en']);
$quever_fr = htmlspecialchars($_POST['quever_fr']);

$infopract_es = htmlspecialchars($_POST['infopract_es']);
$infopract_ca = htmlspecialchars($_POST['infopract_ca']);
$infopract_en = htmlspecialchars($_POST['infopract_en']);
$infopract_fr = htmlspecialchars($_POST['infopract_fr']);


$seowords_ca = ($_POST['seowords_ca']);
$seowords_es = ($_POST['seowords_es']);
$seowords_en = ($_POST['seowords_en']);
$seowords_fr = ($_POST['seowords_fr']);

$info_quan = ($_POST['info_quan']);
$info_on = ($_POST['info_on']);
$info_more = ($_POST['info_more']);
$gmap_lat = ($_POST['gmap_lat']);
$gmap_lng = ($_POST['gmap_lng']);

$pvid = $_POST['pvid'];
$comid = $_POST['comid'];
$idtipusrecurso = $_POST['idtipusrecurso'];
$published = $_POST['published'];
$external_url = $_POST['external_url'];

// Verifiquem que aquesta página ha estat cridada des del formulari
if(isset($action) || $_GET['action']!=""){

	
	// ----------------------- ELIMINAR RECURS -----------------------------
	
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		
		// Eliminem les foto
		$rs_old = Query('recursos', 'image', 'idrecurso', $id);
		delete_file(FILE_DIR . "recursos/" . $rs_old);
		
		//mysqli_query("DELETE FROM recursos WHERE idrecurso = " . $id);
		$db->where('idrecurso',$id);
		$db->delete('recursos');
	}
	// ---------------------------------------------------------------------
	
	if($action == "process"){
		// ----------------------- EDITAR RECURS ---------------------------	
		if($id!="")
			{
				/*$rs_query = mysqli_query("SELECT image, headimage1, headimage2, headimage3 FROM recursos WHERE idrecurso = " . $id);
				$rs = mysqli_fetch_array($rs_query);*/
				$db->where('idrecurso',$id);
				$rs=$db->getOne('recursos',' image, headimage1, headimage2, headimage3');
				//$rs_old = $rs['image'];
				
				if($rs['image'] != ""){
					$image = upload_file('arxiu_image', $rs['image'], FILE_DIR . "recursos/");
				}
				else{
					$image = upload_file('arxiu_image', '', FILE_DIR . "recursos/");
				}

				if($rs['headimage1'] != ""){
					$headimage1 = upload_file('headimage1', $rs['headimage1'], FILE_DIR . "recursos/");
				}
				else{
					$headimage1 = upload_file('headimage1', '', FILE_DIR . "recursos/");
				}

				if($rs['headimage2'] != ""){
					$headimage2 = upload_file('headimage2', $rs['headimage2'], FILE_DIR . "recursos/");
				}
				else{
					$headimage2 = upload_file('headimage2', '', FILE_DIR . "recursos/");
				}


				if($rs['headimage3'] != ""){
					$headimage3 = upload_file('headimage3', $rs['headimage3'], FILE_DIR . "recursos/");
				}
				else{
					$headimage3 = upload_file('headimage3', '', FILE_DIR . "recursos/");
				}

				$data=Array(
				"title_ca" => $title_ca,
				"title_es" => $title_es,
				"title_en" => $title_en,
				"title_fr" => $title_fr,
				"description_ca" => $description_ca,
				"description_es" => $description_es,
				"description_en" => $description_en,
				"description_fr" => $description_fr,
				"quever_ca" => $quever_ca,
				"quever_es" => $quever_es,
				"quever_en" => $quever_en,
				"quever_fr" => $quever_fr,
				"infopract_ca" => $infopract_ca,
				"infopract_es" => $infopract_es,
				"infopract_en" => $infopract_en,
				"infopract_fr" => $infopract_fr,
				"smalldescription_ca" => $smalldescription_ca,
				"smalldescription_es" => $smalldescription_es,
				"smalldescription_en" => $smalldescription_en,
				"smalldescription_fr" => $smalldescription_fr,
				"seowords_ca" => $seowords_ca,
				"seowords_es" => $seowords_es,
				"seowords_en" => $seowords_en,
				"seowords_fr" => $seowords_fr,
				"info_quan" => $info_quan,
				"info_on" => $info_on,
				"info_more" => $info_more,
				"gmap_lat" => $gmap_lat,
				"gmap_lng" => $gmap_lng,																		
				"image" => $image,
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3,
				"pvid" => $pvid,
				"comid" => $comid,
				"idtipusrecurso" => $idtipusrecurso,
				"published" => $published,
				"external_url" => $external_url
				);
				$db->where('idrecurso',$id);
				$db->update('recursos',$data);
	
			}
		// ---------------------------------------------------------------
	
		// ----------------------- NOU RECURS ----------------------------	
			else{
				$image = upload_file('arxiu_image', '', FILE_DIR . "recursos/");
				$headimage1 = upload_file('headimage1', '', FILE_DIR . "recursos/");
				$headimage2 = upload_file('headimage2', '', FILE_DIR . "recursos/");
				$headimage3 = upload_file('headimage3', '', FILE_DIR . "recursos/");



			$data=Array(
				"title_ca" => $title_ca,
				"title_es" => $title_es,
				"title_en" => $title_en,
				"title_fr" => $title_fr,
				"description_ca" => $description_ca,
				"description_es" => $description_es,
				"description_en" => $description_en,
				"description_fr" => $description_fr,
				"quever_ca" => $quever_ca,
				"quever_es" => $quever_es,
				"quever_en" => $quever_en,
				"quever_fr" => $quever_fr,
				"infopract_ca" => $infopract_ca,
				"infopract_es" => $infopract_es,
				"infopract_en" => $infopract_en,
				"infopract_fr" => $infopract_fr,
				"smalldescription_ca" => $smalldescription_ca,
				"smalldescription_es" => $smalldescription_es,
				"smalldescription_en" => $smalldescription_en,
				"smalldescription_fr" => $smalldescription_fr,
				"seowords_ca" => $seowords_ca,
				"seowords_es" => $seowords_es,
				"seowords_en" => $seowords_en,
				"seowords_fr" => $seowords_fr,
				"info_quan" => $info_quan,
				"info_on" => $info_on,
				"info_more" => $info_more,
				"gmap_lat" => $gmap_lat,
				"gmap_lng" => $gmap_lng,																		
				"image" => $image,
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3,
				"pvid" => $pvid,
				"comid" => $comid,
				"idtipusrecurso" => $idtipusrecurso,
				"published" => $published,
                "external_url" => $external_url
				);
				$db->insert('recursos',$data);

			}
		// ---------------------------------------------------------------	
		}
}

header("location: recursos.php");
?>