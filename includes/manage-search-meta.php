<?php

$palabrafija = "Cataluña";
if(isset($_GET['provincia']) && $_GET['provincia'] != '' && $_GET['provincia'] != 'all') $palabrafija = ucfirst($_GET['provincia']);
if(isset($_GET['comarca']) && $_GET['comarca'] != '' && $_GET['comarca'] != 'all') {
    $id_comarca = GetIDComarca($_GET['comarca']);
    $palabrafija = ucfirst(GetTitleComarca($id_comarca));
}

//Permite visualizar los filtros que realmente llegan
//var_dump($_GET);

/* Flag que indica que tenemos más de un filtro que modifica el meta */
$flag_meta = false;
$cont = 0;
if(isset($_GET['instant']) && $_GET['instant'] == '1') $cont++;
if(isset($_GET['perid']) && $_GET['perid']!='') $cont++;
if(isset($_GET['serid']) && $_GET['serid']!='') $cont++;
if($cont > 1) $flag_meta = true; // Si hay más de uno, desactivo la gestión personalizada de los meta




/* Gestion del filtro de Reserva Inmediata, que es 'instant' en la URL friendly y es 'instant' en los parametros de GET */
if(!$flag_meta && isset($_GET['instant']) && $_GET['instant'] == '1') {
    $stringgg = "Reserva inmediata";
    $con=" con ";
    $flag_meta = true;
}

/* Gestion del filtro de Perfiles, que es 'theme' en la URL friendly y es 'perid' en los parametros de GET */
if(!$flag_meta && isset($_GET['perid']) && $_GET['perid']!='') {
    switch ($_GET['perid']){
        case 1:
            $stringgg = "Mar o en la costa";
            $con="con";
            break;
        case 2:
            $stringgg = "Montaña";
            $con="con";
            break;
        case 3:
            $stringgg = "Aisladas";
            $con="";
            break;
        case 4:
            $stringgg = "Rústica";
            $con="";
            break;
        case 5:
            $stringgg = "Romántica";
            $con="";
            break;
        case 6:
            $stringgg = "Familiar";
            $con="";
            break;
        case 7:
            $stringgg = "Económica";
            $con="";
            break;
        case 8:
            $stringgg = "para Grupos";
            $con="";
            break;
        case 9:
            $stringgg = "para Stage Empresas";
            $con="";
            break;
        case 10:
            $stringgg = "Encanto";
            $con="con";
            break;
        case 11:
            $stringgg = "Pistas de Esquí";
            $con="con";
            break;
        case 12:
            $stringgg = "Cercanas a Ríos";
            $con="";
            break;
        case 13:
            $stringgg = "Cercanas a Parque Natural";
            $con="con";
            break;
            /* Continuar con el resto de valores según aparecen en la tabla de BD 'perfils' */
    }
    $flag_meta = true;
}

/* Gestion del filtro de Servicios, que es 'services' en la URL friendly y es 'serid' en los parametros de GET */
if(!$flag_meta && isset($_GET['serid']) && $_GET['serid']!='') {
    switch ($_GET['serid']){
        case 1:
            $stringgg = "Jardín";
            $con="con";
            break;
        case 2:
            $stringgg = "Piscina";
            $con="con";
            break;
        case 3:
            $stringgg = "Terraza";
            $con="con";
            break;
        case 4:
            $stringgg = "Cocina";
            $con="con";
            break;
        case 5:
            $stringgg = "Comedor";
            $con="con";
            break;
        case 6:
            $stringgg = "Sala de estar";
            $con="con";
            break;
        case 7:
            $stringgg = "Spa";
            $con="con";
            break;
        case 8:
            $stringgg = "Chimenea";
            $con="con";
            break;
        case 9:
            $stringgg = "Barbacoa";
            $con="con";
            break;
        case 11:
            $stringgg = "Permite Animales";
            $con="";
            break;
        case 12:
            $stringgg = "Aire Acondicionado";
            $con="con";
            break;
        case 12:
            $stringgg = "Baño en la habitación";
            $con="con";
            break;
        case 14:
            $stringgg = "Jacuzzi";
            $con="con";
            break;
        case 15:
            $stringgg = "Televisión";
            $con="con";
            break;
        case 16:
            $stringgg = "Televisión";
            $con="con";
            break;
        case 17:
            $stringgg = "Lavadora";
            $con="con";
            break;
        case 18:
            $stringgg = "Lavavajillas";
            $con="con";
            break;
        case 20:
            $stringgg = "Piscina Climatizada";
            $con="con";
            break;
        case 21:
            $stringgg = "Wifi";
            $con="con";
            break;
        case 22:
            $stringgg = "Calefacción";
            $con="con";
            break;
        case 23:
            $stringgg = "Acceso a discapacitados";
            $con="con";
            break;
        case 24:
            $stringgg = "Bañera";
            $con="con";
            break;
        case 26:
            $stringgg = "Granja";
            $con="con";
            break;
        /* Continuar con el resto de valores según aparecen en la tabla de BD 'serveis' */
    }
    $flag_meta = true;
}

if($flag_meta) $meta_title = SEO_SEARCH_TITLE_CUSTOM . $palabrafija. ' ' . ((trim($con)!='')?CON:'') . ' ' . $stringgg." | Somrurals.com";
//echo $meta_title; // Descomentar para ver la traza de cómo se está componiendo el meta
?>
 