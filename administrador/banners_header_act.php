<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];

$title_es = ($_POST['title_es']);
$title_ca = ($_POST['title_ca']);
$title_en = ($_POST['title_en']);
$title_fr = ($_POST['title_fr']);

$orden = $_POST['orden'];
$published = $_POST['published'];

// Verificamos que esta página ha sido llamada desde el formulario
if(isset($action) || $_GET['action']!=""){

	
	// ----------------------- ELIMINAR BANNER -----------------------------
	
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		
		// Eliminamos las imagenes de los 3 idiomas
		$image_es_old = Query('banners_header', 'image_es', 'bhid', $id);
		$image_ca_old = Query('banners_header', 'image_ca', 'bhid', $id);
		$image_en_old = Query('banners_header', 'image_en', 'bhid', $id);
		$image_fr_old = Query('banners_header', 'image_fr', 'bhid', $id);

		delete_file(FILE_DIR . "banners/" . $image_es_old);
		delete_file(FILE_DIR . "banners/" . $image_ca_old);
		delete_file(FILE_DIR . "banners/" . $image_en_old);
		delete_file(FILE_DIR . "banners/" . $image_fr_old);
		
		// Eliminamos el registro en la BD
		//mysqli_query("DELETE FROM banners_header WHERE bhid = " . $id);
		$db->where('bhid',$id);
		$db->delete('banners_header');
	}
	// ---------------------------------------------------------------------
	
	if($action == "process"){
		
		// ----------------------- EDITAR BANNER ---------------------------	
		if($id!="")
			{
				$image_es_old = Query('banners_header', 'image_es', 'bhid', $id);
				if($image_es_old != ""){
					$image_es = upload_file('image_es', $image_es_old, FILE_DIR . "banners/");
				}else{
					$image_es = upload_file('image_es', '', FILE_DIR . "banners/");
				}
				
				$image_ca_old = Query('banners_header', 'image_ca', 'bhid', $id);
				if($image_ca_old != ""){
					$image_ca = upload_file('image_ca', $image_ca_old, FILE_DIR . "banners/");
				}else{
					$image_ca = upload_file('image_ca', '', FILE_DIR . "banners/");
				}				
				
				$image_en_old = Query('banners_header', 'image_en', 'bhid', $id);
				if($image_en_old != ""){
					$image_en = upload_file('image_en', $image_en_old, FILE_DIR . "banners/");
				}else{
					$image_en = upload_file('image_en', '', FILE_DIR . "banners/");
				}	

				$image_fr_old = Query('banners_header', 'image_fr', 'bhid', $id);
				if($image_fr_old != ""){
					$image_fr = upload_file('image_fr', $image_fr_old, FILE_DIR . "banners/");
				}else{
					$image_fr = upload_file('image_fr', '', FILE_DIR . "banners/");
				}	


				/*$SQL = "UPDATE banners_header SET "; 
				$SQL .= "title_ca = '" . $title_ca . "', ";
				$SQL .= "title_es = '" . $title_es . "', ";
				$SQL .= "title_en = '" . $title_en . "', ";
				$SQL .= "title_fr = '" . $title_fr . "', ";
				$SQL .= "image_es = '" . $image_es . "', ";
				$SQL .= "image_ca = '" . $image_ca . "', ";
				$SQL .= "image_en = '" . $image_en . "', ";		
				$SQL .= "image_fr = '" . $image_fr . "', ";		
				$SQL .= "orden = " . $orden . ", ";
				$SQL .= "published = " . $published . " ";			
				$SQL .= "WHERE bhid = " . $id;

				mysqli_query($SQL);*/
				$data=Array(
					"title_ca" => $title_ca,
					"title_es" => $title_es,
					"title_en" => $title_en,
					"title_fr" => $title_fr,
					"image_es" => $image_es,
					"image_ca" => $image_ca,
					"image_en" => $image_en, 	
					"image_fr" => $image_fr,		
					"orden" => $orden, 
					"published" => $published
				);
				$db->where('bhid',$id);
				$db->update('banners_header',$data);
			}
		// ---------------------------------------------------------------
	
		// ----------------------- NOU BANNER ----------------------------	
			else{
				$image_es = upload_file('image_es', '', FILE_DIR . "banners/");
				$image_ca = upload_file('image_ca', '', FILE_DIR . "banners/");
				$image_en = upload_file('image_en', '', FILE_DIR . "banners/");
				$image_fr = upload_file('image_fr', '', FILE_DIR . "banners/");

				
				/*$SQL = "INSERT INTO banners_header (title_es, title_ca, title_en, title_fr, image_es, image_ca, image_en, image_fr, orden, published) VALUES(";
				$SQL .= "'" . $title_es . "', ";
				$SQL .= "'" . $title_ca . "', ";
				$SQL .= "'" . $title_en . "', ";
				$SQL .= "'" . $title_fr . "', ";
				$SQL .= "'" . $image_es . "', ";
				$SQL .= "'" . $image_ca . "', ";
				$SQL .= "'" . $image_en . "', ";				
				$SQL .= "'" . $image_fr . "', ";				
				$SQL .= $orden . ", ";
				$SQL .= $published . ")";
				
				mysqli_query($SQL);*/
				$data=Array(
					"title_ca" => $title_ca,
					"title_es" => $title_es,
					"title_en" => $title_en,
					"title_fr" => $title_fr,
					"image_es" => $image_es,
					"image_ca" => $image_ca,
					"image_en" => $image_en, 	
					"image_fr" => $image_fr,		
					"orden" => $orden, 
					"published" => $published
				);
				$db->insert('banners_header',$data);
			}
		// ---------------------------------------------------------------	
		}
}

header("location: banners_header.php");
?>