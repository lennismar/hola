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


    if (isset($_POST['dop_booking_calendar'])){

		require_once 'config.php';	
		
		$rid = $_GET['rid'];
		
		// Backup de la cadena entera, en la tabla room_prices_backup
		$data = $_POST['dop_booking_calendar'];
		
		//mysql_query("INSERT INTO rooms_prices_backup (rid, date, data) VALUES ($rid, now(),'$data')");
		//mysqli_query('UPDATE rooms_prices_backup SET date=now(), data="'.$_POST['dop_booking_calendar'].'" WHERE rid='.$rid);
		$db->where('rid',$rid);
		$data=Array('date'=>now(),'data'=>$_POST['dop_booking_calendar']);
		$db->update('rooms_prices',$data);
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
			//$insert="INSERT INTO rooms_prices (rid,date,price,availability) VALUES ($rid,'$date',$price,$availability)";			
			//mysqli_query($insert) OR die(mysqli_error());
			$data=Array('rid'=>$rid,'date'=>$date,'price'=>$price,'availability'=>$availability);
			$resultado=$db->insert('rooms_prices',$data);
			if(!$resultado){
				die(mysqli_error());
			}
		}
	}
?>