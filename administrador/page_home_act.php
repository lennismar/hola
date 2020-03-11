<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];

// Verificamos que esta página ha sido llamada desde el formulario
if(isset($action)){
	if($action == "process"){
		//$rs_query = mysql_query("SELECT headimage1, headimage2, headimage3 FROM page_home");
		$rs = $db->getOne ("page_home", "headimage1, headimage2, headimage3");
		
		if($rs['headimage1'] != ""){
			$headimage1 = upload_file('headimage1', $rs['headimage1'], FILE_DIR . "home/");
		}
		else{
			$headimage1 = upload_file('headimage1', '', FILE_DIR . "home/");
		}

		if($rs['headimage2'] != ""){
			$headimage2 = upload_file('headimage2', $rs['headimage2'], FILE_DIR . "home/");
		}
		else{
			$headimage2 = upload_file('headimage2', '', FILE_DIR . "home/");
		}


		if($rs['headimage3'] != ""){
			$headimage3 = upload_file('headimage3', $rs['headimage3'], FILE_DIR . "home/");
		}
		else{
			$headimage3 = upload_file('headimage3', '', FILE_DIR . "home/");
		}
		
		
		
		$SQL = "UPDATE page_home SET "; 

		$SQL .= "meta_title_ca = '" . $db->escape($_POST['meta_title_ca']) . "', ";
		$SQL .= "meta_title_es = '" . $db->escape($_POST['meta_title_es']) . "', ";
		$SQL .= "meta_title_en = '" . $db->escape($_POST['meta_title_en']) . "', ";
		$SQL .= "meta_title_fr = '" . $db->escape($_POST['meta_title_fr']) . "', ";

		$SQL .= "meta_description_ca = '" . $db->escape($_POST['meta_description_ca']) . "', ";
		$SQL .= "meta_description_es = '" . $db->escape($_POST['meta_description_es']) . "', ";
		$SQL .= "meta_description_en = '" . $db->escape($_POST['meta_description_en']) . "', ";
		$SQL .= "meta_description_fr = '" . $db->escape($_POST['meta_description_fr']) . "', ";

		$SQL .= "meta_keywords_ca = '" . $db->escape($_POST['meta_keywords_ca']) . "', ";
		$SQL .= "meta_keywords_es = '" . $db->escape($_POST['meta_keywords_es']) . "', ";
		$SQL .= "meta_keywords_en = '" . $db->escape($_POST['meta_keywords_en']) . "', ";
		$SQL .= "meta_keywords_fr = '" . $db->escape($_POST['meta_keywords_fr']) . "', ";

		
		$SQL .= "texto_ca = '" . $db->escape($_POST['texto_ca']) . "', ";
		$SQL .= "texto_es = '" . $db->escape($_POST['texto_es']) . "', ";
		$SQL .= "texto_en = '" . $db->escape($_POST['texto_en']) . "', ";
		$SQL .= "texto_fr = '" . $db->escape($_POST['texto_fr']) . "', ";
		$SQL .= "headimage1 = '" . $headimage1 . "', ";
		$SQL .= "headimage2 = '" . $headimage2 . "', ";
		$SQL .= "headimage3 = '" . $headimage3 . "' ";
		echo '<br>'.$SQL.'<br>';
        $home = $db->rawQuery($SQL);
        $log->logdbg('Home page updated: '.$SQL);
	}
}

header("location: page_home_edit.php");
?>