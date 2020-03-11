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

    require_once 'opendb.php';

    //$query = mysqli_query('SELECT * FROM schedule WHERE id=1');
    $db->where('id',1);
    $query=$db->get('schedule',null,'*');
    //while ($result=mysqli_fetch_array($query)){
    foreach($query as $result){
        echo $result['data'];
    }
    
?>