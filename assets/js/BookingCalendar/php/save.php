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

    if (isset($_POST['dop_booking_calendar'])){
        require_once 'opendb.php';
        //mysqli_query('UPDATE schedule SET data="'.$_POST['dop_booking_calendar'].'" WHERE id=1');
        $db->where('id',1);
        $data=Array('data'=>$_POST['dop_booking_calendar']);
        $db->update('schedule',$data);
    }

?>