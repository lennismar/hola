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
	$rid = $_GET['rid'];
	
	//$query = mysqli_query('SELECT rid, date, price, availability FROM rooms_prices WHERE rid='.$rid);
	$db->where('rid',$rid);
	$rs_query=$db->get('rooms_prices',null,'rid, date, price, availability');
	$i=0;
	
	//while($rs = mysqli_fetch_array($query)){
	foreach($rs_query as $rs){
		if ($i!=0) $cadena .= ",";
		$cadena .= $rs['date'] . ";;" . $rs['availability'] . ";;" . $rs['price'];
		$i++;
	}
	
	echo $cadena;
	
?>