<?php

include 'includes/config.php';

$rpta = '';


/*$rs_query2 = mysqli_query("SELECT comid, pvid, title FROM comarques WHERE pvid = ". $_POST["elegido"]." ORDER BY title ASC");
while($rs2 = mysqli_fetch_array($rs_query2)){
	$rpta = $rpta . '<option value="'.$rs2['comid'].'">'.$rs2['title'].'</option>';			
}*/
$db = MysqliDb::getInstance();

$db->orderBy('title','ASC');
$db->where('pvid',$_POST["elegido"]);
$rs_query=$db->get('comarques',null,'comid, pvid, title');
foreach($rs_query as $rs2){
	$rpta = $rpta . '<option value="'.$rs2['comid'].'">'.$rs2['title'].'</option>';
}


echo $rpta;
?>