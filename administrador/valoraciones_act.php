<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];
$published = $_POST['published'];

$title_ca = ($_POST['title_ca']);
$title_es = ($_POST['title_es']);
$title_en = ($_POST['title_en']);
$title_fr = ($_POST['title_fr']);
$comments_ca = ($_POST['comments_ca']);
$comments_es = ($_POST['comments_es']);
$comments_en = ($_POST['comments_en']);
$comments_fr = ($_POST['comments_fr']);


// Verifiquem que aquesta página ha estat cridada des del formulari
if(isset($action) || $_GET['action']!=""){

	if($action == "process"){
		// ----------------------- EDITAR VALORACION ---------------------------	
		if($id!=""){
			/*$SQL = "UPDATE comments SET "; 
			$SQL .= "title_ca = '" . $title_ca . "', ";		
			$SQL .= "title_es = '" . $title_es . "', ";		
			$SQL .= "title_en = '" . $title_en . "', ";		
			$SQL .= "title_fr = '" . $title_fr . "', ";		
			$SQL .= "comments_ca = '" . $comments_ca . "', ";		
			$SQL .= "comments_es = '" . $comments_es . "', ";
			$SQL .= "comments_en = '" . $comments_en . "', ";																
			$SQL .= "comments_fr = '" . $comments_fr . "', ";																
			$SQL .= "published = " . $published . " ";			
			$SQL .= "WHERE cid = " . $id;

			mysqli_query($SQL);*/
			$data=Array(
				'title_ca'=>$title_ca,
				'title_es'=>$title_es,
				'title_en'=>$title_en,
				'title_fr'=>$title_fr,
				'comments_ca'=>$comments_ca,
				'comments_es'=>$comments_es,
				'comments_en'=>$comments_en,
				'comments_fr'=>$comments_fr,
				'published'=>$published
			);
			$db->where('cid',$id);
			$db->update('comments',$data);
		}
		// ---------------------------------------------------------------
	}	
}

header("location: valoraciones.php");
?>