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
$url_ca = $_POST['url_ca'];
$url_es = $_POST['url_es'];
$url_en = $_POST['url_en'];
$url_fr = $_POST['url_fr'];

// Verificamos que esta página ha sido llamada desde el formulario
if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- ELIMINAR BANNER -----------------------------
	
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		
		// Eliminamos las imagenes de los 3 idiomas
		$image_es_old = Query('banners_columna', 'image_es', 'bcid', $id);
		$image_ca_old = Query('banners_columna', 'image_ca', 'bcid', $id);
		$image_en_old = Query('banners_columna', 'image_en', 'bcid', $id);
		$image_fr_old = Query('banners_columna', 'image_fr', 'bcid', $id);

		
		delete_file(FILE_DIR . "banners/" . $rs_old);
		delete_file(FILE_DIR . "banners/" . $rs_old);
		delete_file(FILE_DIR . "banners/" . $rs_old);
		
		// Eliminamos el registro en la BD
		//mysqli_query("DELETE FROM banners_columna WHERE bcid = " . $id);
		$db->where('bcid',$id);
		$db->delete('banners_columna');
	}
	// ---------------------------------------------------------------------
	
	if($action == "process"){
		
		// ----------------------- EDITAR BANNER ---------------------------	
		if($id!="")
			{
				$image_es_old = Query('banners_columna', 'image_es', 'bcid', $id);
				if($image_es_old != ""){
					$image_es = upload_file('image_es', $image_es_old, FILE_DIR . "banners/");
				}else{
					$image_es = upload_file('image_es', '', FILE_DIR . "banners/");
				}
				
				$image_ca_old = Query('banners_columna', 'image_ca', 'bcid', $id);
				if($image_ca_old != ""){
					$image_ca = upload_file('image_ca', $image_ca_old, FILE_DIR . "banners/");
				}else{
					$image_ca = upload_file('image_ca', '', FILE_DIR . "banners/");
				}				
				
				$image_en_old = Query('banners_columna', 'image_en', 'bcid', $id);
				if($image_en_old != ""){
					$image_en = upload_file('image_en', $image_en_old, FILE_DIR . "banners/");
				}else{
					$image_en = upload_file('image_en', '', FILE_DIR . "banners/");
				}	

				$image_fr_old = Query('banners_columna', 'image_fr', 'bcid', $id);
				if($image_fr_old != ""){
					$image_fr = upload_file('image_fr', $image_fr_old, FILE_DIR . "banners/");
				}else{
					$image_fr = upload_file('image_fr', '', FILE_DIR . "banners/");
				}	
				/*$SQL = "UPDATE banners_columna SET "; 
				$SQL .= "title_ca = '" . $title_ca . "', ";
				$SQL .= "title_es = '" . $title_es . "', ";
				$SQL .= "title_en = '" . $title_en . "', ";
				$SQL .= "title_fr = '" . $title_fr . "', ";
				$SQL .= "image_es = '" . $image_es . "', ";
				$SQL .= "image_ca = '" . $image_ca . "', ";
				$SQL .= "image_en = '" . $image_en . "', ";
				$SQL .= "image_fr = '" . $image_fr . "', ";
				$SQL .= "url_ca = '" . $url_ca . "', ";
				$SQL .= "url_es = '" . $url_es . "', ";
				$SQL .= "url_en = '" . $url_en . "', ";			
				$SQL .= "url_fr = '" . $url_fr . "', ";
				$SQL .= "orden = " . $orden . ", ";
				$SQL .= "published = " . $published . " ";			
				$SQL .= "WHERE bcid = " . $id;

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
					"url_ca" => $url_ca,
					"url_es" => $url_es,
					"url_en" => $url_en,		
					"url_fr" => $url_fr,
					"orden" => $orden,
					"published" => $published
				);
				$db->where('bcid',$id);
				$db->update('banners_columna',$data);
			}
		// ---------------------------------------------------------------
	
		// ----------------------- NOU BANNER ----------------------------	
			else{
				$image_es = upload_file('image_es', '', FILE_DIR . "banners/");
				$image_ca = upload_file('image_ca', '', FILE_DIR . "banners/");
				$image_en = upload_file('image_en', '', FILE_DIR . "banners/");
				$image_fr = upload_file('image_fr', '', FILE_DIR . "banners/");

				
				/*$SQL = "INSERT INTO banners_columna (title_es, title_ca, title_en, title_fr, image_es, image_ca, image_en, image_fr, url_ca, url_es, url_en, url_fr, orden, published) VALUES(";
				$SQL .= "'" . $title_es . "', ";
				$SQL .= "'" . $title_ca . "', ";
				$SQL .= "'" . $title_en . "', ";
				$SQL .= "'" . $title_fr . "', ";
				$SQL .= "'" . $image_es . "', ";
				$SQL .= "'" . $image_ca . "', ";
				$SQL .= "'" . $image_en . "', ";
				$SQL .= "'" . $image_fr . "', ";
				$SQL .= "'" . $url_ca . "', ";	
				$SQL .= "'" . $url_es . "', ";	
				$SQL .= "'" . $url_en . "', ";				
				$SQL .= "'" . $url_fr . "', ";				
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
					"url_ca" => $url_ca,
					"url_es" => $url_es,
					"url_en" => $url_en,		
					"url_fr" => $url_fr,
					"orden" => $orden,
					"published" => $published
				);
				$db->insert('banners_columna',$data);
			}
		// ---------------------------------------------------------------	
		}
}

header("location: banners_columna.php");
?>