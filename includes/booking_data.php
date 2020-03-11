<?php
/**
 * Created by PhpStorm.
 * User: Juanjo
 * Date: 11/01/2016
 * Time: 21:05
 */
$error_carga_datos = true;
if(isset($rescode)) {
    $error_carga_datos = false;
    /*$rs_query = mysql_query("SELECT eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal FROM establiments WHERE eid = " . $id);
    $rs = mysql_fetch_array($rs_query);*/
    /*
     *
     $db->where('eid', $rescode);
    $rs = $db->getOne(
        'establiments',
        "eid, title, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, persons,persons_min,allow_extra_persons,extra_quantity,extra_price,user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal"
    );
    */

    $db->where ("rescode", $rescode);
    $reserva = $db->getOne ("reservations");
    if ($db->count <= 0) {
        //echo '<br>'.$db->getLastQuery();
        $error_carga_datos = true;
        //exit('reserva no existente');
    }
    //var_dump($reserva);

    $db->where('eid', $reserva['eid']);
    $establecimiento = $db->getOne(
        'establiments',
        "eid, title, title_real, description_".$lng.", lid, pvid, comid, published, daysmin, daysant, establimentcomplert, persons,persons_min,allow_extra_persons,extra_quantity,extra_price,user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime, checkouttime, checkouttime_weeks, fianza, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, terms_".$lng.", senyal"
    );
    if ($db->count <= 0) {
        $error_carga_datos = true;
        //echo '<br>'.$db->getLastQuery();
        //exit('establecimiento asociado a la reserva no existente');
    }
    //var_dump($establecimiento);
}

/*
 * * CARGA DE DATOS EN VARIABLES
 */

$id = $establecimiento['eid'];
$title = htmlspecialchars($establecimiento['title']);
$title_real = htmlspecialchars($establecimiento['title_real']);
$description = $establecimiento['description_'.$lng];
$lid = htmlspecialchars($establecimiento['lid']);
$pvid = htmlspecialchars($establecimiento['pvid']);
$comid = htmlspecialchars($establecimiento['comid']);
$published = htmlspecialchars($establecimiento['published']);
$daysmin = htmlspecialchars($establecimiento['daysmin']);
$daysant = htmlspecialchars($establecimiento['daysant']);
$establimentcomplert = htmlspecialchars($establecimiento['establimentcomplert']);
$user = htmlspecialchars($establecimiento['user']);
$userpsw = htmlspecialchars($establecimiento['userpsw']);
$username = htmlspecialchars($establecimiento['username']);
$userlocked = htmlspecialchars($establecimiento['userlocked']);
$ownername = htmlspecialchars($establecimiento['ownername']);
$email = htmlspecialchars($establecimiento['email']);
$address = htmlspecialchars($establecimiento['address']);
$phone = htmlspecialchars($establecimiento['phone']);
$fax = htmlspecialchars($establecimiento['fax']);
$gmap_lat = htmlspecialchars($establecimiento['gmap_lat']);
$gmap_lng = htmlspecialchars($establecimiento['gmap_lng']);
$home = htmlspecialchars($establecimiento['home']);
$recommended = htmlspecialchars($establecimiento['recommended']);
$checkintime = htmlspecialchars($establecimiento['checkintime']);
$checkouttime = htmlspecialchars($establecimiento['checkouttime']);
$checkouttime_weeks = htmlspecialchars($establecimiento['checkouttime_weeks']);
$seotitle = htmlspecialchars($establecimiento['seotitle']);
$seowords = htmlspecialchars($establecimiento['seowords']);
$seodescription = htmlspecialchars($establecimiento['seodescription']);
$hits = htmlspecialchars($establecimiento['hits']);
$dateadded = htmlspecialchars($establecimiento['dateadded']);
$datelastvisit = htmlspecialchars($establecimiento['datelastvisit']);
$tid = htmlspecialchars($establecimiento['tid']);
$terms = $establecimiento['terms_'.$lng];
$senyal = htmlspecialchars($establecimiento['senyal']);
$terms_es = $establecimiento['terms_es'];
$fianza = $establecimiento['fianza'];

$max_person= htmlspecialchars($establecimiento['persons']);
$min_person= htmlspecialchars($establecimiento['persons_min']);
$permiteExtra= htmlspecialchars($establecimiento['allow_extra_persons']);
$numPersonExtra= htmlspecialchars($establecimiento['extra_quantity']);
$precioPersonExtra= htmlspecialchars($establecimiento['extra_price']);
$totalCasa=(int)$max_person+(int)$numPersonExtra;
$tipusestabliment = GetTitleTipusEstabliment($tid,$lng);

// RESERVA
$datein = strtotime($reserva['checkin']);
$dateout = strtotime($reserva['checkout']);
$persons = $reserva['persons'];
$numdays = $reserva['numdays'];
$totalprice = $reserva['totalprice'];
$adults = $reserva['adults'];
$children = $reserva['children'];
$babies = $reserva['babies'];
$ofirstname = htmlspecialchars($reserva['ofirstname']);
$olastname = htmlspecialchars($reserva['olastname']);
$ocity = htmlspecialchars($reserva['ocity']);
$ophone = htmlspecialchars($reserva['ophone']);
$oemail = htmlspecialchars($reserva['oemail']);
$ocountry = htmlspecialchars($reserva['ocountry']);
$olanguage = htmlspecialchars($reserva['olanguage']);
$ocomments = htmlspecialchars($reserva['ocomments']);
$oresponse = htmlspecialchars($reserva['response']);
$restid = htmlspecialchars($reserva['restid']);
$pid = htmlspecialchars($reserva['pid']);
$anticipat = $totalprice*($senyal/100);