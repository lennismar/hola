<?php

/*
* Title                   : Ajax Booking Calendar Pro
* Version                 : 1.1
* File                    : load.php
* File Version            : 1.0
* Created / Last Modified : 24 May 2011
* Author                  : Marius-Cristian Donea
* Copyright               : © 2011 Marius-Cristian Donea
* Website                 : http://www.mariuscristiandonea.com
* Description             : Booking Calendar save data script file.
*/

/* SCRIPT ORIGINAL
    if (isset($_POST['dop_booking_calendar'])){
        require_once 'opendb.php';
        mysql_query('UPDATE schedule SET data="'.$_POST['dop_booking_calendar'].'" WHERE id=1');
    }
*/
require_once 'opendb.php';	

function Query($table, $reg, $nameid, $id) {
	//$query = mysqli_query("SELECT $reg FROM $table WHERE $nameid = $id");
	$db->where($nameid,$id);
	$rs=$db->getOne($table,$reg);
	//if($rs = mysqli_fetch_array($query))	return $rs[$reg];
	if($db->count > 0) return $rs[$reg];
	else return false;
}

if (isset($_POST['dop_booking_calendar'])){

	
	
	$eid = $_GET['eid'];
	
	// Guardamos los datos anteriores en un array
	//$query_ep = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE eid=".$eid);
	$db->where('eid',$eid);
	$query_ep=$db->get('establiments_prices',null,'eid, date, price, availability');
	// Backup de la cadena entera, en la tabla room_prices_backup
	$data = $_POST['dop_booking_calendar'];
	
	//mysql_query("INSERT INTO rooms_prices_backup (rid, date, data) VALUES ($rid, now(),'$data')");
	//mysql_query('UPDATE rooms_prices_backup SET date=now(), data="'.$_POST['dop_booking_calendar'].'" WHERE rid='.$rid);
	
	// Insertamos en un array cada una de las fechas, que estan separadas por comas
	$calendar_array=split(",",$_POST['dop_booking_calendar']);
	
	// Borramos todos los registros de la BD de la habitación (room) para después insertar los nuevos
	//mysqli_query("DELETE FROM establiments_prices WHERE eid = " . $eid);
	$db->where('eid',$eid);
	$db->delete('establiments_prices');

	foreach($calendar_array as $calendar)
	{
		$registro=split(";;",$calendar);
		$date = $registro[0];
		$availability = $registro[1];
		$price = $registro[2];
		
		// Si la disponibilidad es 1 (Disponible)
		// Todas las habitaciones del establecimiento quedarán con la disponibilidad al máximo
		if ($availability == 1) {
			//$query = mysqli_query('SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid='.$eid);
			$db->where('eid',$eid);
			$query=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
			//while($rs = mysqli_fetch_array($query)){
			foreach($query as $rs){
				$availability_room = Query('rooms', 'availability', 'rid', $rs['rid']);
				//mysqli_query("UPDATE rooms_prices SET availability=".$availability_room." WHERE rid=".$rs['rid']." AND date='".$date."'");
				$data=Array('availability'=>$availability_room);
				$db->where('rid',$rs['rid']);
				$db->where('date',$date);
				$db->update('rooms_prices',$data);
			}
		}
		
		// Si la disponibilidad es 0 (No Disponible)
		// Se modificará la disponibilidad de las habitaciones a 0 (No disponibles)
		// Antes hay que verificar si esta fecha se acaba de modificar (comparándolo con el estado availability anterior)
		if ($availability == 0) {
			$mod = 0;
			
			//$query = mysqli_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$eid." AND date='".$date."'");
			$db->where('eid',$eid);
			$db->where('date',$date);
			$query=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
			//while($rs = mysqli_fetch_array($query)){
			foreach($query as $rs)
				$availability_room = Query('rooms', 'availability', 'rid', $rs['rid']);
				if ($availability_room != $rs['availability']) $mod = 1;
			}	
			
			if ($mod == 0) {
				//mysqli_query("UPDATE rooms_prices SET availability=0 WHERE eid=".$eid." AND date='".$date."'");
				$data=Array('availability'=>0);
				$db->where('eid',$eid);
				$db->where('date',$date);
				$db->update('rooms_prices',$data);
			}
		}
		
		
		
		//$insert="INSERT INTO establiments_prices (eid,date,price,availability) VALUES ($eid,'$date',$price,$availability)";
		$data=Array('eid'=>$eid,'date'=>$date,'price'=>$price,'availability'=>$availability);
		$insert=$db->insert('establiments_prices',$data);
		//mysqli_query($insert) OR die(mysqli_error());
		if(!insert) echo $db->getLastError();
	}
}
?>