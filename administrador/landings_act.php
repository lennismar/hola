<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];

if(!empty($_POST['perid'])) foreach ($_POST['perid'] as $p) $perfils .= $p."+";
if(!empty($_POST['serid'])) foreach ($_POST['serid'] as $s) $serveis .= $s."+";

$perfils=substr($perfils, 0, -1);
$serveis=substr($serveis, 0, -1);
if(empty($serveis)) $serveis = '';	// Me aseguro que si no llega nada, se grabe cero
if(empty($perfils)) $perfils = '';	// Me aseguro que si no llega nada, se grabe cero
//echo '<pre>'; var_dump($_POST); var_dump($serveis); echo '</pre>';//exit();
// Verificamos que esta página ha sido llamada desde el formulario
if(isset($action) || $_GET['action']!=""){
	
	// ----------------------------- DELETE --------------------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
				
		// Eliminamos el registro en la BD
		//mysqli_query("DELETE FROM landings WHERE id = " . $id);
		$db->where('id',$id);
		$db->delete('landings');
	}
	// ---------------------------------------------------------------------
	
	if($action == "process"){
		
		// ------------------------------ EDIT ---------------------------	
		if(isset($id)) {
		
			/*$rs_query = mysqli_query("SELECT headimage1, headimage2, headimage3 FROM landings");
			$rs = mysqli_fetch_array($rs_query);*/
			$db->where('id',$id);
			$rs=$db->getOne('landings','headimage1, headimage2, headimage3');
			
			if($rs['headimage1'] != ""){
				$headimage1 = upload_file('headimage1', $rs['headimage1'], FILE_DIR . "landings/");
			}
			else{
				$headimage1 = upload_file('headimage1', '', FILE_DIR . "landings/");
			}
	
			if($rs['headimage2'] != ""){
				$headimage2 = upload_file('headimage2', $rs['headimage2'], FILE_DIR . "landings/");
			}
			else{
				$headimage2 = upload_file('headimage2', '', FILE_DIR . "landings/");
			}
	
	
			if($rs['headimage3'] != ""){
				$headimage3 = upload_file('headimage3', $rs['headimage3'], FILE_DIR . "landings/");
			}
			else{
				$headimage3 = upload_file('headimage3', '', FILE_DIR . "landings/");
			}
			
			
			/*$SQL = "UPDATE landings SET "; 
			$SQL .= "url_ca = '" . addslashes($_POST['url_ca']) . "', ";
			$SQL .= "url_es = '" . addslashes($_POST['url_es']) . "', ";
			$SQL .= "url_en = '" . addslashes($_POST['url_en']) . "', ";
			$SQL .= "url_fr = '" . addslashes($_POST['url_fr']) . "', ";
			
			$SQL .= "content_ca = '" . addslashes($_POST['content_ca']) . "', ";
			$SQL .= "content_es = '" . addslashes($_POST['content_es']) . "', ";
			$SQL .= "content_en = '" . addslashes($_POST['content_en']) . "', ";
			$SQL .= "content_fr = '" . addslashes($_POST['content_fr']) . "', ";

			$SQL .= "title_ca = '" . addslashes($_POST['title_ca']) . "', ";
			$SQL .= "title_es = '" . addslashes($_POST['title_es']) . "', ";
			$SQL .= "title_en = '" . addslashes($_POST['title_en']) . "', ";
			$SQL .= "title_fr = '" . addslashes($_POST['title_fr']) . "', ";

			$SQL .= "subtitle_ca = '" . addslashes($_POST['subtitle_ca']) . "', ";
			$SQL .= "subtitle_es = '" . addslashes($_POST['subtitle_es']) . "', ";
			$SQL .= "subtitle_en = '" . addslashes($_POST['subtitle_en']) . "', ";
			$SQL .= "subtitle_fr = '" . addslashes($_POST['subtitle_fr']) . "', ";

			$SQL .= "meta_title_ca = '" . addslashes($_POST['meta_title_ca']) . "', ";
			$SQL .= "meta_title_es = '" . addslashes($_POST['meta_title_es']) . "', ";
			$SQL .= "meta_title_en = '" . addslashes($_POST['meta_title_en']) . "', ";
			$SQL .= "meta_title_fr = '" . addslashes($_POST['meta_title_fr']) . "', ";
	
			$SQL .= "meta_description_ca = '" . addslashes($_POST['meta_description_ca']) . "', ";
			$SQL .= "meta_description_es = '" . addslashes($_POST['meta_description_es']) . "', ";
			$SQL .= "meta_description_en = '" . addslashes($_POST['meta_description_en']) . "', ";
			$SQL .= "meta_description_fr = '" . addslashes($_POST['meta_description_fr']) . "', ";
	
			$SQL .= "meta_keywords_ca = '" . addslashes($_POST['meta_keywords_ca']) . "', ";
			$SQL .= "meta_keywords_es = '" . addslashes($_POST['meta_keywords_es']) . "', ";
			$SQL .= "meta_keywords_en = '" . addslashes($_POST['meta_keywords_en']) . "', ";
			$SQL .= "meta_keywords_fr = '" . addslashes($_POST['meta_keywords_fr']) . "', ";

			//$SQL .= "eidlist = '" . addslashes($_POST['eidlist']) . "', ";


			$SQL .= "tipus = '" . $_POST['tipus'] . "', ";
			$SQL .= "location = '" . $_POST['location'] . "', ";
			$SQL .= "prices = '" . $_POST['prices'] . "', ";
			$SQL .= "perfils = '" . $perfils . "', ";
			$SQL .= "serveis = '" . $serveis . "', ";
			$SQL .= "status = '" . $_POST['status'] . "', ";
			
			$SQL .= "headimage1 = '" . $headimage1 . "', ";
			$SQL .= "headimage2 = '" . $headimage2 . "', ";
			$SQL .= "headimage3 = '" . $headimage3 . "' ";
			$SQL .= "WHERE id = " . $id;
	
			mysqli_query($SQL);*/
			$data=Array(
				"url_ca" => ($_POST['url_ca']),
				"url_es" => ($_POST['url_es']),
				"url_en" => ($_POST['url_en']),
				"url_fr" => ($_POST['url_fr']),
				"content_ca" => ($_POST['content_ca']),
				"content_es" => ($_POST['content_es']),
				"content_en" => ($_POST['content_en']),
				"content_fr" => ($_POST['content_fr']),
				"title_ca" => ($_POST['title_ca']),
				"title_es" => ($_POST['title_es']),
				"title_en" => ($_POST['title_en']),
				"title_fr" => ($_POST['title_fr']),
				"subtitle_ca" => ($_POST['subtitle_ca']),
				"subtitle_es" => ($_POST['subtitle_es']),
				"subtitle_en" => ($_POST['subtitle_en']),
				"subtitle_fr" => ($_POST['subtitle_fr']),
				"meta_title_ca" => ($_POST['meta_title_ca']),
				"meta_title_es" => ($_POST['meta_title_es']),
				"meta_title_en" => ($_POST['meta_title_en']),
				"meta_title_fr" => ($_POST['meta_title_fr']),
				"meta_description_ca" => ($_POST['meta_description_ca']),
				"meta_description_es" => ($_POST['meta_description_es']),
				"meta_description_en" => ($_POST['meta_description_en']),
				"meta_description_fr" => ($_POST['meta_description_fr']),
				"meta_keywords_ca" => ($_POST['meta_keywords_ca']),
				"meta_keywords_es" => ($_POST['meta_keywords_es']),
				"meta_keywords_en" => ($_POST['meta_keywords_en']),
				"meta_keywords_fr" => ($_POST['meta_keywords_fr']),
				"tipus" => $_POST['tipus'],
				"location" => $_POST['location'],
				"prices" => $_POST['prices'],
				"perfils" => $perfils,
				"serveis" => $serveis,
				"status" => $_POST['status'],
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3,
				"linked_pid" => $_POST['linked_perfiles'],
				"linked_cid" => $_POST['linked_comarcas']
			);
			$db->where('id',$id);
			$db->update('landings',$data);
			//echo "Last executed query was ". $db->getLastQuery();exit();
		}
	// ---------------------------------------------------------------

	// ----------------------------- NEW ----------------------------	
		else {
			$headimage1 = upload_file('headimage1', '', FILE_DIR . "landings/");
			$headimage2 = upload_file('headimage2', '', FILE_DIR . "landings/");
			$headimage3 = upload_file('headimage3', '', FILE_DIR . "landings/");
			
							
			/*$SQL = "INSERT INTO landings (url_ca,url_es,url_en,url_fr,content_ca,content_es,content_en,content_fr,title_ca,title_es,title_en,title_fr,
			subtitle_ca,subtitle_es,subtitle_en,subtitle_fr,meta_title_ca,meta_title_es,meta_title_en,meta_title_fr,meta_description_ca,meta_description_es,
			meta_description_en,meta_description_fr,meta_keywords_ca,meta_keywords_es,meta_keywords_en,meta_keywords_fr,tipus,location,prices,perfils,serveis,status,headimage1,headimage2,headimage3) VALUES(";
			$SQL .= "'" . $_POST['url_ca'] . "', ";
			$SQL .= "'" . $_POST['url_es'] . "', ";
			$SQL .= "'" . $_POST['url_en'] . "', ";
			$SQL .= "'" . $_POST['url_fr'] . "', ";
			
			$SQL .= "'" . addslashes($_POST['content_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['content_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['content_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['content_fr']) . "', ";

			$SQL .= "'" . addslashes($_POST['title_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['title_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['title_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['title_fr']) . "', ";

			$SQL .= "'" . addslashes($_POST['subtitle_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['subtitle_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['subtitle_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['subtitle_fr']) . "', ";
			
			$SQL .= "'" . addslashes($_POST['meta_title_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_title_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_title_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_title_fr']) . "', ";

			$SQL .= "'" . addslashes($_POST['meta_description_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_description_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_description_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_description_fr']) . "', ";

			$SQL .= "'" . addslashes($_POST['meta_keywords_ca']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_keywords_es']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_keywords_en']) . "', ";
			$SQL .= "'" . addslashes($_POST['meta_keywords_fr']) . "', ";
			
			//$SQL .= "'" . addslashes($_POST['eidlist']) . "', ";

			$SQL .= "'" . $_POST['tipus'] . "', ";
			$SQL .= "'" . $_POST['location'] . "', ";
			$SQL .= "'" . $_POST['prices'] . "', ";
			$SQL .= "'" . $perfils . "', ";
			$SQL .= "'" . $serveis . "', ";
			$SQL .= $_POST['status'] . ", ";

			$SQL .= "'" . $headimage1 . "', ";										
			$SQL .= "'" . $headimage2 . "', ";				
			$SQL .= "'" . $headimage3 . "')";
			
			mysqli_query($SQL);*/
			$data=Array(
				"url_ca" => ($_POST['url_ca']),
				"url_es" => ($_POST['url_es']),
				"url_en" => ($_POST['url_en']),
				"url_fr" => ($_POST['url_fr']),
				"content_ca" => ($_POST['content_ca']),
				"content_es" => ($_POST['content_es']),
				"content_en" => ($_POST['content_en']),
				"content_fr" => ($_POST['content_fr']),
				"title_ca" => ($_POST['title_ca']),
				"title_es" => ($_POST['title_es']),
				"title_en" => ($_POST['title_en']),
				"title_fr" => ($_POST['title_fr']),
				"subtitle_ca" => ($_POST['subtitle_ca']),
				"subtitle_es" => ($_POST['subtitle_es']),
				"subtitle_en" => ($_POST['subtitle_en']),
				"subtitle_fr" => ($_POST['subtitle_fr']),
				"meta_title_ca" => ($_POST['meta_title_ca']),
				"meta_title_es" => ($_POST['meta_title_es']),
				"meta_title_en" => ($_POST['meta_title_en']),
				"meta_title_fr" => ($_POST['meta_title_fr']),
				"meta_description_ca" => ($_POST['meta_description_ca']),
				"meta_description_es" => ($_POST['meta_description_es']),
				"meta_description_en" => ($_POST['meta_description_en']),
				"meta_description_fr" => ($_POST['meta_description_fr']),
				"meta_keywords_ca" => ($_POST['meta_keywords_ca']),
				"meta_keywords_es" => ($_POST['meta_keywords_es']),
				"meta_keywords_en" => ($_POST['meta_keywords_en']),
				"meta_keywords_fr" => ($_POST['meta_keywords_fr']),
				"tipus" => $_POST['tipus'],
				"location" => $_POST['location'],
				"prices" => $_POST['prices'],
				"perfils" => $perfils,
				"serveis" => $serveis,
				"status" => $_POST['status'],
				"headimage1" => $headimage1,
				"headimage2" => $headimage2,
				"headimage3" => $headimage3,
				"linked_pid" => $_POST['linked_perfiles'],
				"linked_cid" => $_POST['linked_comarcas']
			);
			$db->insert('landings',$data);
			//echo "////////////". $db->getLastQuery();exit();
		}
	// ---------------------------------------------------------------	
	}
}

header("location: landings.php");
?>