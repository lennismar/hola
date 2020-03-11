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


    if (isset($_POST['dop_booking_calendar'])){

		require_once 'opendb.php';	
		
		$rid = $_GET['rid'];
		
		$eid = Query('rooms', 'eid', 'rid', $rid);
		
		// Backup de la cadena entera, en la tabla room_prices_backup
		$data = $_POST['dop_booking_calendar'];
		
		//mysql_query("INSERT INTO rooms_prices_backup (rid, date, data) VALUES ($rid, now(),'$data')");
		
		//mysqli_query('UPDATE rooms_prices_backup SET date=now(), data="'.$_POST['dop_booking_calendar'].'" WHERE rid='.$rid);
		$db->where('rid',$rid);
		$data=Array('date'=>now(),'data'=>$_POST['dop_booking_calendar']);
		$db->update('room_prices_backup',$data);
		// Insertamos en un array cada una de las fechas, que estan separadas por comas
		$calendar_array=split(",",$_POST['dop_booking_calendar']);
		
		// Borramos todos los registros de la BD de la habitación (room) para después insertar los nuevos
		//mysqli_query("DELETE FROM rooms_prices WHERE rid = " . $rid);
		$db->where('rid',$rid);
		$db->delete('rooms_prices');
		
		foreach($calendar_array as $calendar)
		{
			$registro=split(";;",$calendar);
			$date = $registro[0];
			$availability = $registro[1];
			$price = $registro[2];
			//$insert="INSERT INTO rooms_prices (rid,eid,date,price,availability) VALUES ($rid,$eid,'$date',$price,$availability)";
			$data=Array('rid'=>$rid,'eid'=>$eid,'date'=>$date,'price'=>$price,'availability'=>$availability);
			$insert=$db->insert('rooms_prices',$data);
			//mysqli_query($insert) OR die(mysqli_error());
			if(!insert) echo $db->getLastError();
		}
	}
?>