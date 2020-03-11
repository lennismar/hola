<?php
// Clase de acceso a BD
require_once ('../administrador/includes/MysqliDb.php');
require_once ('../includes/db_config.php');
$db = new MysqliDb ($db_config);

if (!isset($_GET['eid'])) {
	echo 'ERROR: missing eid';
	return;
}

$eid = $_GET['eid'];


#query todos las fechas para la casa
#select resid, eid, checkin, checkout from reservations where eid = ?
$db->where('eid',$eid);
$query=$db->get('reservations',null,'resid, eid, checkin, checkout');

$result = array();
foreach($query as $rs){
	$reservation  = array('eid' => $rs['eid'] );
	$reservation['resid']=$rs['resid'];
	$reservation['checkin']=$rs['checkin'];
	$reservation['checkout']=$rs['checkout'];
	array_push($result,$reservation);
}

// echo json_encode(array('reservations'=>$result));
echo json_encode($result);