<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
* Title                   : Ajax Booking Calendar Pro
* Version                 : 1.1
* File                    : load.php
* File Version            : 1.0
* Created / Last Modified : 24 May 2011
* Author                  : Marius-Cristian Donea
* Copyright               : © 2011 Marius-Cristian Donea
* Website                 : http://www.mariuscristiandonea.com
* Description             : Booking Calendar load data script file.
*/


	/* SCRIPT ORIGINAL
	require_once 'opendb.php';
    $query = mysql_query('SELECT * FROM schedule WHERE id=1');
    
    while ($result=mysql_fetch_array($query)){
        echo $result['data'];
    }
    */
	require_once 'opendb.php';
	
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
	
	
	$eid = $_GET['eid'];
	
	//$query = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE eid=".$eid);
	$db->where('eid',$eid);
	$rs_query=$db->get('establiments_prices',null,'eid, date, price, availability');
	$i=0;
	$cadena="";
	
	//while($rs = mysqli_fetch_array($query)){
	foreach($rs_query as $rs){
		$date = $rs['date'];
		$availability = $rs['availability'];
		$price = $rs['price'];
		
		//$query2 = mysqli_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$eid." AND date='".$date."'");
		$db->where('eid',$eid);
		$db->where('date',$date);
		$rs_query2=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
		//while($rs2 = mysqli_fetch_array($query2)){
		foreach($rs_query2 as $rs2){
			$availability_room = Query('rooms', 'availability', 'rid', $rs2['rid']);
			if ($availability_room != $rs2['availability']) $availability = 0;
		}

		if ($i!=0) $cadena .= ",";
		$cadena .= $date . ";;" . $availability . ";;" . $price;
		$i++;
	}
	
	echo $cadena;

?>