<?php

function Query($table, $reg, $nameid, $id) {
	/*$query = mysqli_query("SELECT $reg FROM $table WHERE $nameid = $id");
	if($rs = mysqli_fetch_array($query))	return $rs[$reg];
		else return false;*/
	$db->where($nameid,$id);
	$rs=$db->getOne($table,null,$reg);
	
	if($db->count > 0){
		return $rs[$reg];
	}
	else{
		return false;
	}
}

require_once 'opendb.php';	

$eid = $_GET['eid'];

// Guardamos los datos anteriores sin disponibilidad en un array
// $query_ep = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE eid=".$eid." AND availability");
//$ep = mysql_fetch_array($query);

$date = '2011-12-05';
$availability = 0;
$price = '340.00';


//$mod = 0; //Flag que incdicará si se ha modificado		
/*while ($row = mysql_fetch_array($query_ep)) {
	printf("eid:%d | date:%s | price:%d | availability:%d <br>", $row["eid"], $row["date"], $row["price"], $row["availability"]);	
	if (($row["date"] == $date) && ($row["availability"] == $availability)) {
		
	}
}
*/

//$query2 = mysqli_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$eid." AND date='".$date."'");
$db->where('eid',$eid);
$db->where('date',$date);
$rs_query=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
//while($rs2 = mysqli_fetch_array($query2)){
foreach($rs_query as $rs2){
	$availability_room = Query('rooms', 'availability', 'rid', $rs2['rid']);
	if ($availability_room != $rs2['availability']) $availability = 0;
}		

//$ep["eid"] $ep["date"] $ep["price"] $ep["availability"]
//print_r($ep);
//mysql_free_result($ep);
?>