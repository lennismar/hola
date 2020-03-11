<?php
$superadmin = 1;
include 'includes/checkuser.php';
include('includes/config.php');

// Recollim les dades del formulari en variables
$action = $_POST['action'];

$HOME_NUM_ESTABLIMENTS = ($_POST['HOME_NUM_ESTABLIMENTS']);
$SITE_STATE = ($_POST['SITE_STATE']);
$IVA = ($_POST['IVA']);

// Verifiquem que aquesta página ha estat trucada desde el formulari
if(isset($action)){
	/*$SQL = "UPDATE configuration SET value = '" . $IVA . "' WHERE var = 'IVA'";
	mysqli_query($SQL);*/
	$db->where('var','IVA');
	$data=Array('value'=>$IVA);
	$db->update('configuration',$data);

	/*$SQL = "UPDATE configuration SET value = '" . $SITE_STATE . "' WHERE var = 'SITE_STATE'";
	mysqli_query($SQL);*/
	$db->where('var','SITE_STATE');
	$data=Array('value'=>$SITE_STATE);
	$db->update('configuration',$data);

	/*$SQL = "UPDATE configuration SET value = '" . $HOME_NUM_ESTABLIMENTS . "' WHERE var = 'HOME_NUM_ESTABLIMENTS'";
	mysqli_query($SQL);*/
	$db->where('var','HOME_NUM_ESTABLIMENTS');
	$data=Array('value'=>$HOME_NUM_ESTABLIMENTS);
	$db->update('configuration',$data);
}

header("location: configuration.php");
?>