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
* Description             : Booking Calendar database config script file.
*/
	/*define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_NAME', 'somrurals'); 
	
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die ('Error connecting to mysql!');
    mysqli_select_db(DB_NAME);*/
    // Clase de log
	/*require_once('../../../../administrador/includes/Logger.php');
	$log = new aalog('logs/'.date('Ymd').'_logfile.log');
	$log->setCookie(1);*/
	//$log->loginfo('here\'s some info on the DB connection: ');


	// ------------------- CONFIGURACIO BBDD ONLINE --------------------------------------

	// Clase de acceso a BD
	require_once ('../../../../administrador/includes/MysqliDb.php');
	require_once ('../../../../includes/db_config.php');
	$db = new MysqliDb ($db_config);

	define('URL_BASE','https://www.somrurals.com/');

	//define('HOME_DIR','C:\\Apache24\\htdocs\\somrurals/');
    define('HOME_DIR','/var/www/somrurals_v2/');

	define('FILE_DIR','images/uploads/');
	include '../../../../includes/functions.php';

	/*if ($_SESSION['type_user']=='propietario') {
		if ($superadmin==1) header('location: index.php');
	}*/
?>