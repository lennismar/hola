<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];

$texto_home_ca = ($_POST['texto_home_ca']);
$texto_home_es = ($_POST['texto_home_es']);
$texto_home_en = ($_POST['texto_home_en']);
$texto_home_fr = ($_POST['texto_home_fr']);


// Verificamos que esta página ha sido llamada desde el formulario
if(isset($action)){
	if($action == "process"){
		/*$SQL = "UPDATE texto_home SET "; 
		$SQL .= "texto_home_ca = '" . $texto_home_ca . "', ";
		$SQL .= "texto_home_es = '" . $texto_home_es . "', ";
		$SQL .= "texto_home_en = '" . $texto_home_en . "', ";
		$SQL .= "texto_home_fr = '" . $texto_home_fr . "' ";
		mysqli_query($SQL);*/
		$data=Array(
			'texto_home_ca'=>$texto_home_ca,
			'texto_home_es'=>$texto_home_es,
			'texto_home_en'=>$texto_home_en,
			'texto_home_fr'=>$texto_home_fr
		);
		$db->update('texto_home',$data);
	}
}

header("location: texto_home_edit.php");
?>