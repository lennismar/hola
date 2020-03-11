
<?php
session_start();
// FUNCION QUE DEVUELVE EL REGISTRO QUE SE DESEE DE CUALQUIER TABLA DE LA BBDD
// PARÁMETRO 1: Nombre de la tabla
// PARÁMETRO 2: Nombre del registro a consultar
// PARÁMETRO 3: Nombre del id que usa la tabla
// PARÁMETRO 4: id a filtrar

function Query($table, $reg, $nameid, $id) {
	/*$query = mysql_query("SELECT $reg FROM $table WHERE $nameid = $id");
	if($rs = mysql_fetch_array($query))	return $rs[$reg];
	else return false;*/
	$db = MysqliDb::getInstance();
	$db->where($nameid,$id);
	$rs=$db->getOne($table,null,$reg);

	if($db->count > 0){
		return $rs[$reg];
	}
	else{
		return false;
	}
}


// TRANSFORMACIÓN DE UNA CADENA DE CARÁCTERES EN URL AMIGABLE
function urls_amigables($url) {
	// Tranformamos todo a minusculas
	$url = mb_strtolower($url);
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'à', 'é', 'è', 'í', 'ó', 'ò', 'ú', 'ñ', 'â', 'ê', 'î', 'ô', 'û');
	$repl = array('a', 'a', 'e', 'e', 'i', 'o', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u');
	$url = str_replace ($find, $repl, $url);

	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);

	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}


function array_envia($array) {
    $tmp = serialize($array);
    $tmp = urlencode($tmp);
    return $tmp;
}

function array_recibe($url_array) {
    $tmp = stripslashes($url_array);
    $tmp = urldecode($tmp);
    $tmp = unserialize($tmp);

   return $tmp;
}


// PREPARA PARA EL FORMATO XML UNA CADENA DE CARÁCTERES
function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}

// IMPRIME UN DESPLEGABLE CON TODOS LOS PAISES
function paises(){
    $array_paises = array("España","Afganistan","Africa del Sur","Albania","Alemania","Andorra","Angola","Antigua y Barbuda","Antillas Holandesas","Arabia Saudita","Argelia","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarusia","Belgica","Belice","Benin","Bermudas","Bolivia","Bosnia","Botswana","Brasil","Brunei Darussulam","Bulgaria","Burkina Faso","Burundi","Butan","Camboya","Camerun","Canada","Cape Verde","Chad","Chile","China","Chipre","Colombia","Comoros","Congo","Corea del Norte","Corea del Sur","Costa de Marfíl","Costa Rica","Croasia","Cuba","Dinamarca","Djibouti","Dominica","Ecuador","Egipto","El Salvador","Emiratos Arabes Unidos","Eritrea","Eslovenia","Estados Unidos","Estonia","Etiopia","Fiji","Filipinas","Finlandia","Francia","Gabon","Gambia","Georgia","Ghana","Granada","Grecia","Groenlandia","Guadalupe","Guam","Guatemala","Guayana Francesa","Guerney","Guinea","Guinea-Bissau","Guinea Equatorial","Guyana","Haiti","Holanda","Honduras","Hong Kong","Hungria","India","Indonesia","Irak","Iran","Irlanda","Islandia","Islas Caiman","Islas Faroe","Islas Malvinas","Islas Marshall","Islas Solomon","Islas Virgenes Britanicas","Islas Virgenes (U.S.)","Israel","Italia","Jamaica","Japon","Jersey","Jordania","Kazakhstan","Kenia","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lesotho","Libano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macao","Macedonia","Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Martinica","Mauricio","Mauritania","Mexico","Micronesia","Moldova","Monaco","Mongolia","Mozambique","Myanmar (Burma)","Namibia","Nepal","Nicaragua","Niger","Nigeria","Noruega","Nueva Caledonia","Nueva Zealandia","Oman","Pakistan","Palestina","Panama","Papua Nueva Guinea","Paraguay","Peru","Polinesia Francesa","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido","Republica Centroafricana","Republica Checa","Republica Democratica del Congo","Republica Dominicana","Republica Eslovaca","Reunion","Ruanda","Rumania","Rusia","Sahara","Samoa","San Cristobal-Nevis (St. Kitts)","San Marino","San Vincente y las Granadinas","Santa Helena","Santa Lucia","Santa Sede (Vaticano)","Sao Tome & Principe","Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Sri Lanka (Ceilan)","Sudan","Suecia","Suiza","Sur Africa","Surinam","Swaziland","Tailandia","Taiwan","Tajikistan","Tanzania","Timor Oriental","Togo","Tokelau","Tonga","Trinidad & Tobago","Tunisia","Turkmenistan","Turquia","Ucrania","Uganda","Union Europea","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Yugoslavia","Zambia","Zimbabwe");
    $cantidad_paises = count($array_paises);
    //echo '<select name="'.$nombre_del_select.'" id="'.$nombre_del_select.'" >';
    for($i = 0; $i<$cantidad_paises; $i++){
        $array_paises_i = $array_paises[$i];
        echo '<option value="'.$array_paises_i.'"';
            if("$array_paises_i"=="España"){
                    echo "selected";
            }
        echo '>'.$array_paises_i.'</option>';
    }
    //echo '</select>';
}

// FUNCION QUE DEVUELVE COMO HA VIAJADO EL CLIENTE
function CommentsHow($idcomo) {
	switch ($idcomo) {
		case 1:
			$como = VALORACIONES_COMO_EMPRESA;
			break;
		case 2:
			$como = VALORACIONES_COMO_PAREJA;
			break;
		case 3:
			$como = VALORACIONES_COMO_SOLO;
			break;
		case 4:
			$como = VALORACIONES_COMO_AMIGOS;
			break;
		case 5:
			$como = VALORACIONES_COMO_FAMILIA;
			break;
	}

	return $como;
}

function landingHeadImages ($where,$id) {
	$db = MysqliDb::getInstance();
	if ($where=='p') { $where="provincies"; $idquery = "pvid"; $dir="provincias";}
	if ($where=='c') { $where="comarques"; $idquery = "comid"; $dir="comarcas";}

	if ($where=='provincies' || $where =='comarques') {
		$txt = "";
		//$rs_query = mysql_query("SELECT headimage1, headimage2, headimage3 FROM ".$where." WHERE ".$idquery."=".$id);
		$db->where($idquery,$id);
		$rs_query=$db->get($where,null,'headimage1, headimage2, headimage3');
		//while($rs = mysql_fetch_array($rs_query)){
		foreach($rs_query as $rs){
			if ($rs['headimage1'] != "") $txt="'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/images/uploads/".$dir."/".$rs['headimage1']."',"; else $txt = CDN_BASE."'assets/img/bg-landing-1.jpg',";
			if ($rs['headimage2'] != "") $txt.="'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/images/uploads/".$dir."/".$rs['headimage2']."',"; else $txt.= CDN_BASE."'assets/img/bg-landing-2.jpg',";
			if ($rs['headimage3'] != "") $txt.="'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/images/uploads/".$dir."/".$rs['headimage3']."'"; else $txt.= CDN_BASE."'assets/img/bg-landing-3.jpg'";
		}
	} else {
		$txt = "'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/assets/img/bg-landing-1.jpg',
				'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/assets/img/bg-landing-2.jpg',
				'image.php?width=1400&height=391&cropratio=1400:391&quality=60&image=/assets/img/bg-landing-3.jpg'";
	}

	return $txt;
}

// FUNCION QUE DEVUELVE COMO HA VIAJADO EL CLIENTE
function ValoracionMediaCasa($eid) {
	$media_total = 0;
	$db = MysqliDb::getInstance();
	//$rs_query = mysql_query("SELECT cid, comcode, eid, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, date, ipaddress, resid, published, state  FROM comments WHERE state=1 AND published=1 AND eid=".$eid." ORDER BY date DESC");
	$db->orderBy('date','DESC');
	$db->where('state',1);
	$db->where('published',1);
	$db->where('eid',$eid);
	$rs_query=$db->get('comments',null,'cid, comcode, eid, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, date, ipaddress, resid, published, state');

	//$num_valoraciones = mysql_num_rows($rs_query);
	$num_valoraciones=$db->count;
	//while($rs = mysql_fetch_array($rs_query)){
	foreach($rs_query as $rs){
		$media_total = $media_total + ($rs['netega'] + $rs['tracte'] + $rs['entorn'] + $rs['equipaments'] + $rs['relacio'] + $rs['somni'] + $rs['natura'] + $rs['sensacio']) / 8;
	}


	if ($media_total != 0){
		$media_total = $media_total/$num_valoraciones;
	}

	return $media_total;
}

// FUNCION QUE DEVUELVE COMO HA VIAJADO EL CLIENTE
function NumValoracionesCasa($eid) {
	$db = MysqliDb::getInstance();
	$media_total = 0;
	//$rs_query = mysql_query("SELECT * FROM comments WHERE state=1 AND published=1 AND eid=".$eid);
	$db->where('state',1);
	$db->where('published',1);
	$db->where('eid',$eid);
	$rs=$db->get('comments',null,'*');
	//return $num_valoraciones = mysql_num_rows($rs_query);
	return $db->count;
}

function linkHreflang($lng){
		echo '<link href="http://'.$_SERVER['HTTP_HOST'].'/es'.substr($_SERVER['REQUEST_URI'],3).'" hreflang="es" rel="alternate"/>'."\n";
		echo '<link href="http://'.$_SERVER['HTTP_HOST'].'/ca'.substr($_SERVER['REQUEST_URI'],3).'" hreflang="ca" rel="alternate"/>'."\n";
		echo '<link href="http://'.$_SERVER['HTTP_HOST'].'/en'.substr($_SERVER['REQUEST_URI'],3).'" hreflang="en" rel="alternate"/>'."\n";
		echo '<link href="http://'.$_SERVER['HTTP_HOST'].'/fr'.substr($_SERVER['REQUEST_URI'],3).'" hreflang="fr" rel="alternate"/>'."\n";
}






// FUNCION QUE IMPRIME TODOS LOS OPTION DE LAS COMARCAS
function PrintOptionComarca($where){
	$db = MysqliDb::getInstance();
	$printoptioncomarca = "";
	//$query = mysql_query("SELECT comid, pvid, title FROM comarques ORDER BY title ASC");
	$db->orderBy('title','ASC');
	$query=$db->get('comarques',null,'comid, pvid, title');
	//while($rs = mysql_fetch_array($query)){
	foreach($query as $rs){
		$filter="";
		if ($where == 'c-'.$rs['comid']) { $filter = "selected=\"selected\""; }
		$printoptioncomarca = $printoptioncomarca . '<option value="c-'.$rs['comid'].'" '.$filter.'>'.$rs['title'].'</option>';
	}

	return $printoptioncomarca;
}

// FUNCION QUE IMPRIME TODOS LOS OPTION DE LAS PROVINCIAS
function PrintOptionProvincia($where){
	$printoptionprovincia = "";
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
	$db->orderBy('title','ASC');
	$query=$db->get('provincies',null,'pvid,title');

	//while($rs = mysql_fetch_array($query)){
	foreach($query as $rs){
		$filter="";
		if ($where == 'p-'.$rs['pvid']) { $filter = "selected=\"selected\""; }
		$printoptionprovincia = $printoptionprovincia . '<option value="p-'.$rs['pvid'].'" '.$filter.'>'.$rs['title'].'</option>';
	}

	return $printoptionprovincia;
}

// FUNCION QUE DEVUELVE EL MEJOR PRECIO DE UN ESTABLECIMIENTO POR NOCHE
function GetBestPriceEstablimentPerNight($id,$data){ // Filtramos a partir de una fecha
	/*$query = mysql_query("SELECT eid, price FROM rooms_prices WHERE eid=".$id." AND availability > 0 AND date >= '".$data."' ORDER BY price ASC");
	if($rs = mysql_fetch_array($query)){
		return $rs['price'];
	}*/
	$db = MysqliDb::getInstance();
	$db->orderBy('price','ASC');
	$db->where('eid',$id);
	$db->where('availability',0,'>');
	$db->where('date',$data,'>=');
	$rs=$db->getOne('rooms_prices','eid, price');
	if($db->count > 0){
		return $rs['price'];
	}
}

// FUNCION QUE DEVUELVE EL MEJOR PRECIO DE UN ESTABLECIMIENTO POR NOCHE POR PERSONA
function GetBestPriceEstablimentPerNightPerPerson($id, $datein, $dateout, $tipo, $persons){ // Filtramos a partir de una fecha
	$db = MysqliDb::getInstance();

	if ($tipo==1) { // HABITACION
		$SQL  = "SELECT rp.rid as rid, rp.price as price, r.persons as persons ";
		$SQL .= "FROM rooms_prices rp, rooms r ";
		$SQL .= "WHERE rp.eid = ".$id." AND r.eid = ".$id." AND rp.rid = r.rid ";

		if ($datein!="") $SQL .= " AND rp.date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND rp.date < '".$dateout."'";

		/*$query = mysql_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);
		$cont = 1;

		//while($rs = mysql_fetch_array($query)){
		foreach($rs_query as $rs){
			if ($persons==0) {
				$pers = $rs['persons'];
			} else {
				$pers = $persons;
			}
			if ($cont==1) $lessprice = $rs['price']/$pers;
			$media = $rs['price']/$pers;
			if ($media < $lessprice) $lessprice = $media;
			$cont++;
		}

	} else if ($tipo==2) {	// CASA COMPLETA
		$SQL  = "SELECT eid, date, price, availability ";
		$SQL .= "FROM establiments_prices ";
		$SQL .= "WHERE eid=".$id." ";
		$numnights=0;
        $total = 0;

		if ($datein!="") $SQL .= " AND date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND date < '".$dateout."'";
		if($datein!="" && $dateout!="") $numnights=DateDiff($datein,$dateout);
		/*$query = mysql_query($SQL);*/
		//echo '<br>'.$SQL;
		$rs_query=$db->rawQuery($SQL);
		$cont = 0;

		if (empty($persons)) if(!empty($_SESSION['persons'])) $persons=$_SESSION['persons']; else $persons = Query('establiments', 'persons', 'eid', $id);
				//echo '<br>personas: '.$persons;


        $total_extra = 0;
        //Si tiene personas extra, calculo del precio correspondiente
        $db->where('eid',$id);
        $datosEstabliment=$db->getOne('establiments',null,'persons,allow_extra_persons,extra_quantity,extra_price');
        //Comprobamos que admite personas extra
        if($datosEstabliment['allow_extra_persons'] == 1){
            if($datosEstabliment['persons']<$persons){
                //Si el número de personas del establecimiento es menor que las elegidas, es que tiene personas extra
                $personas_extra=$persons - $datosEstabliment['persons'];
                //precio por persona
                $precio_extra=$personas_extra * $datosEstabliment['extra_price'];
                $total_extra=$precio_extra * $numnights;


                //Comprobamos el siguiente rango de fechas
                $db->where('eid',$id);
                $rs_query2=$db->get('establiments_nitsmin',null,'*');
                if($db->count > 0) {
                    $datein = date('Y-m-d', strtotime($datein));
                    $dateon = date('Y-m-d', strtotime($dateout));

                    foreach ($rs_query2 as $rs) {
                        $date_start = date('Y-m-d', strtotime($rs['date_start']));
                        $date_end = date('Y-m-d', strtotime($rs['date_end']));
                        $nitsmin = $rs['nitsmin'];
						$nitsmin_price_extra = $rs['precio_extra_bloque_dias'];
                        $between = 0;

                        if (($datein >= $date_start) && ($datein < $date_end)) {
                            $between = 1;
                        }
                        if (($dateon >= $date_start) && ($dateon <= $date_end)) {
                            $between = 1;
                        }

                        if ($between == 1) {
                            if ($rs['precio_extra'] != 1) {
                                //Si está marcado como que queremos que se cobre el precio extra en esa fecha
                                $cobrar = false;
                                break;
                            } else {
								// Si está marcado como que SI se cobrará, compruebo si hay un precio marcado específico.. y en ese caso, modifico el total_extra
								if(!empty($nitsmin_price_extra)) {
									$precio_extra = $personas_extra * $nitsmin_price_extra;
									$total_extra = $precio_extra * $numnights;
								}
							}
                        }
                    }
                }


                if($cobrar){
                    $total=$total+$total_extra;
                }

                //echo '<br>total: '.$total_extra;
            }
        }








		if ($datein!="" && $dateout!="") { // Si existe fecha de entrada y salida, calculamos la media
			$total=0;
			//while($rs = mysql_fetch_array($query)){
			foreach($rs_query as $rs){
				$total = $total + $rs['price'];
				$cont++;
			}
            if ($cont==0) $lessprice = $rs['price']/$persons;
			else $lessprice = (($total + $total_extra)/$cont)/$persons;
            /*echo '<br>total: '.$total;
            echo '<br>total_extra: '.$total_extra;
            echo '<br>cont: '.$cont;
            echo '<br>persons: '.$persons;
            echo '<br>lessprice: '.$lessprice;*/
		} else { // Si no hay fecha de entrada o salida, calculamos el mejor precio
			//while($rs = mysql_fetch_array($query)){
			foreach($rs_query as $rs){
				if ($rs['price']!=0) {
					if ($cont==0) $lessprice = $rs['price']/$persons;
					if($numnights!=0) $lessprice = $lessprice/$numnights;
					$media = $rs['price']/$persons;
					if ($media < $lessprice) $lessprice = $media;
					$cont++;
				}
			}
            $lessprice = $lessprice + ($total_extra / ((empty($numnights))?1:$numnights));
		}

		//$lessprice = 12.25;

	} else if ($tipo=='all') { // HABITACION Y CASA COMPLETA

		// Cálculo del mejor precio por habitación
		$SQL  = "SELECT rp.rid as rid, rp.price as price, r.persons as persons ";
		$SQL .= "FROM rooms_prices rp, rooms r ";
		$SQL .= "WHERE rp.eid = ".$id." AND r.eid = ".$id." AND rp.rid = r.rid ";

		if ($datein!="") $SQL .= " AND rp.date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND rp.date < '".$dateout."'";
		elseif($datein!="") $SQL .= " AND rp.date < '".$datein."'";

		/*$query = mysql_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);
		$cont = 0;

		//while($rs = mysql_fetch_array($query)){
		foreach($rs_query as $rs){
			if ($persons==0) {
				$pers = $rs['persons'];
			} else {
				$pers = $persons;
			}

			if ($cont==0) $lessprice = $rs['price']/$pers;
			$media = $rs['price']/$pers;
			if ($media < $lessprice) $lessprice = $media;
			$cont++;
		}

		// Cálculo del mejor precio por establecimiento entero
		$SQL  = "SELECT eid, date, price, availability ";
		$SQL .= "FROM establiments_prices ";
		$SQL .= "WHERE eid=".$id." ";

		if ($datein!="") $SQL .= " AND date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND date <= '".$dateout."'";
		elseif($datein!="") $SQL .= " AND date <= '".$datein."'";

		/*$query = mysql_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);

		$cont = 0;

		if ($persons==0) $persons = Query('establiments', 'persons', 'eid', $id);

		//while($rs = mysql_fetch_array($query)){
		foreach($rs_query as $rs){
			if ($rs['price']!=0) {
				if ($cont==0) $lessprice = $rs['price']/$persons;
				$media = $rs['price']/$persons;
				if ($media < $lessprice) $lessprice = $media;
				$cont++;
			}
		}

	}
	return $lessprice;
}


// FUNCION QUE DEVUELVE EL NOMBRE DE LA PROVINCIA
function GetTitleProvincia ($id) {
	/*$query = mysqli_query("SELECT pvid, title FROM provincies WHERE pvid=".$id);
	if($rs = mysqli_fetch_array($query)){
			return $rs['title'];
	}else{
			return false;
	}*/

	$db = MysqliDb::getInstance();
	$db->where('pvid',$id);
	$rs=$db->getOne('provincies',null,'pvid, title');

	if($db->count > 0){
		return $rs['title'];
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE LA URL FRIENDLY DE LA PROVINCIA
function GetURLProvincia ($id) {
	/*$query = mysql_query("SELECT pvid, title_url FROM provincies WHERE pvid=".$id);
	if($rs = mysql_fetch_array($query)){
			return $rs['title_url'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where('pvid',$id);
	$rs=$db->getOne('provincies','pvid, title_url');
	if($db->count > 0){
		return $rs['title_url'];
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA PROVINCIA
function GetIDProvincia ($title_url) {
	/*$query = mysql_query("SELECT pvid, title FROM provincies WHERE title_url='".$title_url."'");
	if($rs = mysql_fetch_array($query)){
			return $rs['pvid'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where('title_url',$title_url);
	$rs=$db->getOne('provincies','pvid, title');
	if($db->count > 0){
		return $rs['pvid'];
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA COMARCA
function GetTitleComarca ($id) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT comid, title FROM comarques WHERE comid=".$id);
	$db->where('comid',$id);
	$rs=$db->getOne('comarques','comid, title');
	//if($query === FALSE) {
	//	die(mysql_error()); // TODO: better error handling
	//}

	if($db->count > 0){
			return $rs['title'];
	}else{
			return false;
	}
}

// FUNCION QUE DEVUELVE LA URL FRIENDLY DE LA COMARCA
function GetURLComarca ($id) {
	/*$query = mysql_query("SELECT comid, title_url FROM comarques WHERE comid=".$id);
	if($rs = mysql_fetch_array($query)){
			return $rs['title_url'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where('comid',$id);
	$rs=$db->getOne('comarques','comid, title_url');
	if($db->count > 0){
		return $rs['title_url'];
	}
	else{
		return false;
	}
}


// FUNCION QUE DEVUELVE EL NOMBRE DE LA COMARCA
function GetIDComarca ($title_url) {
	/*$query = mysql_query("SELECT comid, title FROM comarques WHERE title_url='".$title_url."'");
	if($rs = mysql_fetch_array($query)){
			return $rs['comid'];
	}else{
			return false;
	}*/

	$db = MysqliDb::getInstance();
	$db->where('title_url',$title_url);
	$rs=$db->getOne('comarques','comid, title');	if($db->count > 0){
		return $rs['comid'];
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA LOCALIDAD
function GetTitleLocalitat ($id) {
	//$query = mysql_query("SELECT lid, title FROM localitats WHERE lid=".$id);
	$db = MysqliDb::getInstance();
	$db->where('lid',$id);
	$rs=$db->getOne('localitats',null,'lid, title');
	//if($query === FALSE) {
	//	die(mysql_error()); // TODO: better error handling
	//}

	//if($rs = mysql_fetch_array($query)){
	if($db->count > 0){
			return $rs['title'];
	}else{
			return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DEL TIPUS DE ESTABLECIMIENTO
function GetTitleTipusEstabliment ($id,$lng) {
	if ($lng=="") $lng='ca';
	//$query = mysql_query("SELECT tid, title_sing_".$lng." FROM tipus WHERE tid=".$id);
	$db = MysqliDb::getInstance();
    $db->where ("tid", $id);
    $rs = $db->getOne('tipus', null, "tid, title_sing_".$lng."");
	//if($query === FALSE) {
	//	die(mysql_error()); // TODO: better error handling
	//}

	//if($rs = mysql_fetch_array($query)){
    if ($db->count > 0) {
			return $rs['title_sing_'.$lng];
	}else{
			return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DEL TIPUS
function GetTitleTipus ($id) {
	if($id == 1){
			return "Habitaciones";
	}else{
			return "Toda la Casa";
	}
}

// FUNCION QUE DEVUELVE LA ID DEL TIPUS DE ESTABLECIMIENTO
function GetIDTipusEstabliment ($title_url, $lng) {
	/*$query = mysql_query("SELECT tid FROM tipus WHERE url_".$lng."='".$title_url."'");
	if($rs = mysql_fetch_array($query)){
			return $rs['tid'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where("url_".$lng,$title_url);
	$rs=$db->getOne('tipus','tid');
	if($db->count > 0){
		return $rs['tid'];
	}
	else{
		return false;
	}
}

// FUNCION QUE INDICA SI EL ESTABLIMENT ALQUILA LA CASA COMPLETA
function IsEstablimentComplert ($id) {
	/*$query = mysql_query("SELECT eid, persons FROM establiments WHERE establimentcomplert=1 AND eid = ".$id);
	if($rs = mysql_fetch_array($query)){
			return true;
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where("establimentcomplert",1);
	$db->where("eid",$id);
	$rs=$db->get('establiments',null,'eid,persons');
	if($db->count > 0){
		return true;
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DEL SERVEI
function GetTitleServei ($id, $lang) {
	/*$query = mysql_query("SELECT serid, title_".$lang." FROM serveis WHERE serid=".$id);
	if($rs = mysql_fetch_array($query)){
			return $rs['title_'.$lang];
	}*/
	$db = MysqliDb::getInstance();
	$db->where("serid",$id);
	$rs=$db->getOne('serveis',"serid, title_".$lang);
	if($db->count > 0){
		return $rs['title_'.$lang];
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DEL PERFIL
function GetTitlePerfil ($id, $lang) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT perid, title_".$lang." FROM perfils WHERE perid=".$id);
	$db->where('perid',$id);
	$rs=$db->getOne('perfils',"perid, title_".$lang."");
	//if($rs = mysql_fetch_array($query)){
	if($db->count > 0){
			return $rs['title_'.$lang];
	}
}


// FUNCION QUE DEVUELVE LA DESCRIPCION DEL PERFIL
function GetDescPerfil ($id, $lang) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT perid, desc_".$lang." FROM perfils WHERE perid=".$id);
	$db->where('perid',$id);
	$rs=$db->getOne('perfils',null,"perid, desc_".$lang."");
	//if($rs = mysql_fetch_array($query)){
	if($db->count > 0){
		return $rs['desc_'.$lang];
	}
}

// FUNCION QUE DEVUELVE "SI" o "NO"
function GetYesNo($yesno) {
	if($yesno == 1){
			return "SI";
	}else{
			return "NO";
	}
}


// FUNCION QUE CONVIERTE YES/NO EN 1 ó 0
function YesNoTo1or0($yesno) {
	if($yesno == 'yes'){
			return 1;
	}else{
			return 0;
	}
}


// FUNCION QUE DEVUELVE EL LINK A LOS RESULTADOS CON ALOJAMIENTOS, A PARTIR DE UNA COMARCA O PROVINCIA
function GetListEstablimentsCom($comid,$pvid,$lng) {
	$db = MysqliDb::getInstance();
	//$num = mysql_query("SELECT eid FROM establiments WHERE published=1 AND comid=".$comid);
	$db->where('published',1);
	$db->where('comid',$comid);
	$num=$db->get('establiments',null,'eid');
	//if (mysql_num_rows($num)!=0) {
	if($db->count > 0){
		return $lng."/".URL_SEARCH."/". urls_amigables(GetTitleProvincia ($pvid))."/".urls_amigables(GetTitleComarca($comid));
	}
	else {
		//$num = mysql_query("SELECT eid FROM establiments WHERE published=1 AND pvid=".$pvid);
		$db->where('published',1);
		$db->where('pvid',$pvid);
		$num=$db->get('establiments',null,'eid');
		if($db->count > 0):
			return $lng."/".URL_SEARCH."/". urls_amigables(GetTitleProvincia ($pvid));
		endif;
	}
}

// FUNCION QUE DEVUELVE EL NUMERO DE ALOJAMIENTOS DE A PARTIR DE UNA COMARCA O PROVINCIA
function GetNumEstablimentsCom($comid,$pvid) {
	/*$num = mysql_query("SELECT eid FROM establiments WHERE published=1 AND comid=".$comid);
	if (mysql_num_rows($num)!=0) {
		return mysql_num_rows($num);
	} else {
		$num = mysql_query("SELECT eid FROM establiments WHERE published=1 AND pvid=".$pvid);
		return mysql_num_rows($num);
	}*/
	$db = MysqliDb::getInstance();
	$db->where('published',1);
	$db->where('comid',$comid);
	$num=$db->get('establiments',null,'eid');
	if($db->count > 0){
		return $db->count;
	}
	else{
		$db->where('published',1);
		$db->where('pvid',$pvid);
		$num=$db->get('establiments',null,'eid');
		return $db->count;
	}
}


// FUNCION QUE DEVUELVE EL NUMERO DE ALOJAMIENTOS DE UN TIPO
// $tipus -> si diferente de 'false' entonces filtrará por tipo
function GetNumEstabliments($tipus) {
	$db = MysqliDb::getInstance();
	$filter_tipus = "";
	//if ($tipus != "") $filter_tipus = " WHERE tid = " . $tipus;
	if ($tipus != ""){ $db->where('tid',$tipus);}
	//$num = mysql_query("SELECT eid FROM establiments ".$filter_tipus);
	$num=$db->get('establiments',null,'eid');
	//return mysql_num_rows($num);
	return $db->count;
}

// FUNCION QUE DEVUELVE EL NUMERO DE PERSONAS QUE CABEN EN UN ESTABLECIMIENTO POR CASA ENTERA
function GetNumPersonsEstabliment($id) {
	/*$query = mysql_query("SELECT eid, persons FROM establiments WHERE eid = ".$id);
	if($rs = mysql_fetch_array($query)){
		return $rs['persons'];
	} else {
		return 0;
	}*/
	$db = MysqliDb::getInstance();
	$db->where("eid",$id);
	$rs=$db->getOne('establiments',"eid,persons");
	if($db->count > 0){
		return $rs['persons'];
	}
	else{
		return 0;
	}
}

// FUNCION QUE DEVUELVE EL NUMERO DE PERSONAS QUE CABEN EN UN ESTABLECIMIENTO POR HABITACIONES
function GetNumPersonsRooms($id) {
	/*$query = mysql_query("SELECT eid, SUM(persons*availability) FROM rooms WHERE published = 1 AND eid = ".$id);
	if($rs = mysql_fetch_array($query)){
		return $rs['SUM(persons*availability)'];
	} else {
		return 0;
	}*/
	$db = MysqliDb::getInstance();
	$db->where("eid",$id);
	$db->where("published",1);
	$rs=$db->getOne('rooms',"eid, (persons*availability) as total");

	if($db->count > 0){
		return $rs['total'];
	}
	else{
		return 0;
	}
}

// FUNCION QUE DEVUELVE EL NUMERO DE IMAGENES DE UN ESTABLIMENT
function GetNumImagesEstabliment($eid) {
	/*$num = mysql_query("SELECT eid FROM establiments_images WHERE eid=".$eid);
	return mysql_num_rows($num);*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$num=$db->get('establiments_images',null,'eid');
	return $db->count;
}

// FUNCION QUE DEVUELVE EL NUMERO DE HABITACIONES DE UN ESTABLIMENT
function GetNumRoomsEstabliment($eid) {
	/*$num = mysql_query("SELECT eid FROM rooms WHERE eid=".$eid);
	return mysql_num_rows($num);*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$num=$db->get('rooms',null,'eid');
	return $db->count;
}

// FUNCION QUE DEVUELVE OPTION "SELECTED"
function GetSelectedCheckBoxServeis ($eid, $serid) {
	/*$query = mysql_query("SELECT eid FROM establiments_serveis WHERE eid=".$eid." AND serid=".$serid);
	if($rs = mysql_fetch_array($query)) return ' checked ';*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('serid',$serid);
	$query=$db->get('establiments_serveis',null,'eid');
	if($db->count>0) return 'checked';
}

// FUNCION QUE DEVUELVE OPTION "SELECTED" EN LA FICHA DE LA CASA RURAL
function GetServeis ($eid, $serid) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT eid FROM establiments_serveis WHERE eid=".$eid." AND serid=".$serid);
	$db->where('eid',$eid);
	$db->where('serid',$serid);
	$rs=$db->get('establiments_serveis',null,'eid');
	//if($rs = mysql_fetch_array($query)) return "yes"; else return "no";
	if($db->count > 0) return "yes"; else return "no";
}

// FUNCION QUE DEVUELVE OPTION "SELECTED" EN LA FICHA DE LA CASA RURAL
function GetServeisExt ($eid, $serid) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT eid FROM establiments_serveis_ext WHERE eid=".$eid." AND serid=".$serid);
	$db->where('eid',$eid);
	$db->where('serid',$serid);
	$rs=$db->get('establiments_serveis_ext',null,'eid');
	//if($rs = mysql_fetch_array($query)) return "yes"; else return "no";
	if($db->count > 0) return "yes"; else return "no";
}

// FUNCION QUE DEVUELVE OPTION "SELECTED" EN LA FICHA DE LA CASA RURAL
function HaveServeisExt ($eid) {
	$db = MysqliDb::getInstance();
	//$query = mysql_query("SELECT eid FROM establiments_serveis_ext WHERE eid=".$eid);
	$db->where('eid',$eid);
	$rs=$db->get('establiments_serveis_ext',null,'eid');
	//if($rs = mysql_fetch_array($query)) return true; else return false;
	if($db->count > 0) return true; else return false;
}


// FUNCION QUE DEVUELVE OPTION "SELECTED"
function GetSelectedCheckBoxPerfils ($eid, $perid) {
	/*$query = mysql_query("SELECT eid FROM establiments_perfils WHERE eid=".$eid." AND perid=".$perid);
	if($rs = mysql_fetch_array($query)) return ' checked ';*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('perid',$perid);
	$query=$db->get('establiments_perfils',null,'eid');
	if($db->count>0) return 'checked';
}


// FUNCION QUE DEVUELVE EL NOMBRE DEL TIPUS RECURSO TURISTICO
function GetTitleTipusRecurso($id) {
	$db = MysqliDb::getInstance();
	/*$query = mysql_query("SELECT idtipusrecurso, title_ca FROM recursos_tipus WHERE idtipusrecurso=".$id);
	if($rs = mysql_fetch_array($query)){
			return $rs['title_ca'];
	}else{
			return false;
	}*/
	$db->where('idtipusrecurso',$id);
	$rs=$db->getOne('recursos_tipus','idtipusrecurso, title_ca');
	if($db->count > 0){
		return $rs['title_ca'];
	}else{
			return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA IMAGEN PRINCIPAL DEL ESTABLECIMIENTO
function ImagePrincipalEstabliment($eid) {
	/*$query = mysql_query("SELECT eid, filename FROM establiments_images WHERE eid=".$eid." AND principal=1");
	if($rs = mysql_fetch_array($query)){
			return $rs['filename'];
	}*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('principal',1);
	$rs=$db->getOne('establiments_images','eid, filename');
	if($db->count > 0){
		return $rs['filename'];
	}
}
function GetNumPersonsExtraEstabliment($eid){
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$rs=$db->getOne('establiments','eid, extra_quantity');
	if($db->count > 0){
		return $rs['extra_quantity'];
	}
}

// FUNCION QUE DEVUELVE LA MEDIA DE UNA VALORACION DE UN CAMPO
function ValoracionesCampo($eid, $campo) {
	//$query = mysql_query("SELECT ".$campo." FROM comments WHERE state=1 AND published=1 AND eid=".$eid);
	$db = MysqliDb::getInstance();
	$db->where('state',1);
	$db->where('published',1);
	$db->where('eid',$eid);
	$query=$db->get('comments',null,"$campo");

	$num_valoraciones = /*mysql_num_rows($query)*/ $db->count;
	$media = 0;
	//while($rs = mysql_fetch_array($query)){
	foreach($query as $rs){
		$media = $media + $rs[$campo];
	}


	$valoracion = "";

	for ($i = 1; $i <= 5; $i++) {
    	if ($media < $i) {
    	    //Pintar estrella con contenido parcial o vacío
			if ($media >= ($i-0.5)) {
                $valoracion .="<span class=\"show-rating starred-half\">
                                    <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                        <polyline fill=\"#E7E6E4\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 9.999,0 \"/>
                                        <path fill=\"#F7B535\" d=\"M9.999,15.279L3.819,20l2.124-7.875L0,7.639h7.286L9.999,0L9.999,15.279L9.999,15.279z\"/>
                                    </svg>
                                </span>";
			} else {
                $valoracion .="<span class=\"show-rating starred-none\">
                                <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                    <polyline fill=\"#e7e6e4\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 3.82,20 5.944,12.125 0,7.639 7.286,7.639 9.999,0 \"/>
                                </svg>
                            </span>";
			}
		} else {
			$valoracion .="	<span class=\"show-rating starred-one\">
                            <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                <polyline fill=\"#F7B535\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 3.82,20 5.944,12.125 0,7.639 7.286,7.639 9.999,0 \"/>
                            </svg>
                        </span>
                    ";
		}

	}
    $valoracion .=  "";

	//$media = floor($media/$num_valoraciones);
	return $valoracion;
}

// FUNCION QUE DEVUELVE LAS ESTRELLAS DE LA VALORACION MEDIA
function ValoracionMediaCasaStars($eid) {
	$db = MysqliDb::getInstance();
	$media_total = 0;
	//$rs_query = mysql_query("SELECT cid, comcode, eid, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, date, ipaddress, resid, published, state  FROM comments WHERE state=1 AND published=1 AND eid=".$eid." ORDER BY date DESC");
	$db->orderBy('date','DESC');
	$db->where('state',1);
	$db->where('published',1);
	$db->where('eid',$eid);
	$rs_query=$db->get('comments',null,'cid, comcode, eid, netega, tracte, entorn, equipaments, relacio, somni, natura, sensacio, date, ipaddress, resid, published, state');

	$num_valoraciones = $db->count/*mysql_num_rows($rs_query)*/;
	//while($rs = mysql_fetch_array($rs_query)){
	foreach($rs_query as $rs){
		$media_total = $media_total + ($rs['netega'] + $rs['tracte'] + $rs['entorn'] + $rs['equipaments'] + $rs['relacio'] + $rs['somni'] + $rs['natura'] + $rs['sensacio']) / 8;
	}


	if ($media_total != 0){
		$media_total = $media_total/$num_valoraciones;
	}

	$media = $media_total;
	$valoracion = "";

	for ($i = 1; $i <= 5; $i++) {
    	if ($media < $i) {
    	    //Pintar estrella con contenido parcial o vacío
			if ($media >= ($i-0.5)) {
                $valoracion .="<span class=\"show-rating starred-half\">
                                    <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                        <polyline fill=\"#E7E6E4\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 9.999,0 \"/>
                                        <path fill=\"#F7B535\" d=\"M9.999,15.279L3.819,20l2.124-7.875L0,7.639h7.286L9.999,0L9.999,15.279L9.999,15.279z\"/>
                                    </svg>
                                </span>";
			} else {
                $valoracion .="<span class=\"show-rating starred-none\">
                                <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                    <polyline fill=\"#e7e6e4\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 3.82,20 5.944,12.125 0,7.639 7.286,7.639 9.999,0 \"/>
                                </svg>
                            </span>";
			}
		} else {
			$valoracion .="	<span class=\"show-rating starred-one\">
                            <svg version=\"1.1\" id=\"star-full\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"20px\" height=\"20px\" viewBox=\"0 0 20 20\" enable-background=\"new 0 0 20 20\" xml:space=\"preserve\">
                                <polyline fill=\"#F7B535\" points=\"9.999,0 12.713,7.639 20,7.639 14.055,12.125 16.18,20 9.999,15.279 3.82,20 5.944,12.125 0,7.639 7.286,7.639 9.999,0 \"/>
                            </svg>
                        </span>
                    ";
		}

	}
    $valoracion .=  "";
	//$media = floor($media/$num_valoraciones);
	return $valoracion;
}



// FUNCION QUE DEVUELVE SI EL OPTION ES SELECTED
function OptionIsSelected($var,$value) {
	if ($var==$value) return 'selected="selected"';
}


// FUNCION QUE DEVUELVE EL NUMERO DE DIAS ENTRE DOS FECHAS
function DateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}

// FUNCION QUE DEVUELVE EL ARRAY EN FORMATO LEGIBLE PARA DEBUGS
function printArray($array, $devolver = false){
	$string = '<pre>' . print_r($array, true) . '</pre>';
	if($devolver) return $string;
	else echo $string;
}


// FUNCION QUE DEVUELVE UN ARRAY CON TODAS LAS COMBINACIONES DE LOS ELEMENTOS ENVIADOS
function ArrayCombinations($array) {
    // initialize by adding the empty set
    $results = array(array( ));

    foreach ($array as $element)
        foreach ($results as $combination)
            array_push($results, array_merge(array($element), $combination));

    return $results;
}

// FUNCION QUE DEVUELVE CARÁCTERES ALEATORIOS DEL TAMAÑO DE $lenght
function RandomChars($length)
{
  $random= "";
  srand((double)microtime()*1000000);
  $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  // Add the special characters to $char_list if needed

  for($i = 0; $i < $length; $i++)
  {
     $random .= substr($char_list,(rand()%(strlen($char_list))), 1);
  }
  return $random;
}


// FUNCION QUE DEVUELVE NÚMEROS ALEATORIOS DEL TAMAÑO DE $lenght
function RandomNums($length)
{
  $random= "";
  srand((double)microtime()*1000000);
  $char_list .= "1234567890";

  for($i = 0; $i < $length; $i++)
  {
     $random .= substr($char_list,(rand()%(strlen($char_list))), 1);
  }
  return $random;
}


// FUNCION QUE CODIFICA UN VALOR PARA ADEMAS PASARLO POR URL
function SomruralsEncode($value) {
	//$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
	$encoded = strtr(base64_encode($value), '+/=', '-_,');
	return $encoded;
}

// FUNCION QUE DECODIFICA UN VALOR PARA ADEMAS PASARLO POR URL
function SomruralsDecode($value) {
	//$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	$decoded = base64_decode(strtr($value, '-_,', '+/='));
	return $decoded;
}


// FUNCION QUE GENERA EL FORMULARIO PARA LA TPV
//function form_creator_redsys($data)
function form_creator_redsys($data, $version, $params, $signature)
{

	$output = '';

	$attributes = array('class' => 'frmPay', 'id' => 'frmPay2', 'method' => 'post', 'target' => 'tpv');
	$output .= '<form class="frmPay" id="frmPay2" method="post" target="_self" action="'.$data['tpv_payment_url'].'">'."\r\n";
	//$output .= form_open($data['tpv_payment_url'], $attributes);
	$output .= '<input type="hidden" name="Ds_SignatureVersion" value="'.$version.'"/></br>'."\r\n";
	$output .= '<input type="hidden" name="Ds_MerchantParameters" value="'.$params.'"/></br>'."\r\n";
	$output .= '<input type="hidden" name="Ds_Signature" value="'.$signature.'"/></br>'."\r\n";
	$output .= '</form>';

	return $output;
}


if (!function_exists('getUserIP')) {
	function getUserIP()
	{
		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote = $_SERVER['REMOTE_ADDR'];

		if (filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}

		return $ip;
	}
}


// FUNCION para enviar emails a través de Sendinblue
function transactional_mail($para, $subject, $body, $cabeceras = null, $bcc = null)
{

    $mailin = new Sendinblue\Mailin("https://api.sendinblue.com/v2.0","VCyqO1Agt8dTSHj7");
    $data = array( "to" => array($para=>$para),
        "from" => array(ADMIN_BCC, "Som Rurals"),
        "subject" => $subject,
        "html" => $body,
        "headers" => array("Content-Type"=>"text/html; charset=iso-8859-1", "MIME-Version" => "1.0", "From" => "Som Rurals <ADMIN_BCC>")
        //"attachment" => array("https://domain.com/path-to-file/filename1.pdf", "https://domain.com/path-to-file/filename2.jpg")
    );
    if(!empty($bcc) && is_array($bcc)) {
        foreach($bcc as $destinatario) {
            $data['bcc'][$destinatario] = $destinatario;
        }
    }

    return $mailin->send_email($data);

}

function CalcularPrecio($array) {
	$db = MysqliDb::getInstance();

	$id=$array['id'];
	$datein=$array['fecha_entrada'];
	$dateout=$array['fecha_salida'];
	$persons=$array['personas'];
	$date = $datein;
	$nitsmin_price =  0;
	$total = 0; //$numnights
	$numnights = DateDiff(date('Y-m-d',$datein), date('Y-m-d',$dateout));

	 /**
	 * Comprobación sobre si hay precio por noches minimas
	 */
	$db->where('eid',$id);
	$rs_query=$db->get('establiments_nitsmin',null,'*');
	foreach($rs_query as $rs){
		$date_start = date('Y-m-d', strtotime($rs['date_start']));
		$date_end = date('Y-m-d', strtotime($rs['date_end']));
		$nitsmin= $rs['nitsmin'];

		$between=0;

		if ((date('Y-m-d',$datein) >= $date_start) && (date('Y-m-d',$datein) < $date_end)) $between=1;
		if ((date('Y-m-d',$dateout) >= $date_start) && (date('Y-m-d',$dateout) <= $date_end)) $between=1;

		if($between == 1){
			$nitsmin_price = $rs['precio_bloque_dias'];
			$nitsmin_price_extra = $rs['precio_extra_bloque_dias'];
		}
	}



 	if(isset($nitsmin_price) && $nitsmin_price != '' && $nitsmin_price != 0) {
		//if($id == 332) exit('a');
               
               $total = $nitsmin_price * $numnights / $nitsmin;

               $bestprice=$total;
 
                /* Calculo para personas extra */
               // $cobrar=true;
                //Si tiene personas extra, calculo del precio correspondiente
                $db->where('eid',$id);
                $datosEstabliment=$db->getOne('establiments',null,'persons,allow_extra_persons,extra_quantity,extra_price');
                //Comprobamos que admite personas extra
                if($datosEstabliment['allow_extra_persons'] == 1){
                    if($datosEstabliment['persons']<$persons){
                        //Si el número de personas del establecimiento es menor que las elegidas, es que tiene personas extra
                        $personas_extra=$persons - $datosEstabliment['persons'];
                        //precio por persona
                        if(!empty($nitsmin_price_extra)) {
                            $precio_extra = $personas_extra * $nitsmin_price_extra;
                            $total_extra = $precio_extra;
                            $total=$total+$total_extra;
                        } 
                        $bestprice=$total;
                    }
                }





               
         

               $descripcion_tipo_precio = $nitsmin.' '.NOCHES;
                
		} else {

		   $descripcion_tipo_precio = PERSONA_NOCHE;

			/**
			 * Cálculo del precio por noche normal
			 */
			$db->where('availability',1);
			$db->where('eid',$id);
			$db->where('date',date("Y-m-d", $datein),'>=');
			$db->where('date',date("Y-m-d", $dateout),'<');
			$query=$db->get('establiments_prices',null,'DISTINCT date, price');

			foreach($query as $rs){
				$total = $total + round($rs['price'],2);
			}


			$cobrar=true;
			//Si tiene personas extra, calculo del precio correspondiente
			$db->where('eid',$id);
			$datosEstabliment=$db->getOne('establiments',null,'persons,allow_extra_persons,extra_quantity,extra_price');
			//Comprobamos que admite personas extra
			if($datosEstabliment['allow_extra_persons'] == 1){
				if($datosEstabliment['persons']<$persons){

					//Si el número de personas del establecimiento es menor que las elegidas, es que tiene personas extra
					$personas_extra=$persons - $datosEstabliment['persons'];
					//precio por persona
					$precio_extra=$personas_extra * $datosEstabliment['extra_price'];
					$total_extra=$precio_extra * $numnights;


					//Comprobamos el siguiente rango de fechas
					$db->where('eid',$id);
					$rs_query=$db->get('establiments_nitsmin',null,'*');
					if($db->count > 0) {

						foreach ($rs_query as $rs) {
							$date_start = date('Y-m-d', strtotime($rs['date_start']));
							$date_end = date('Y-m-d', strtotime($rs['date_end']));
							$nitsmin = $rs['nitsmin'];
							$nitsmin_price_extra = $rs['nitsmin_price_extra'];

							$between = 0;

							if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) {
								$between = 1;
							}
							if (($date_salida >= $date_start) && ($date_salida <= $date_end)) {
								$between = 1;
							}

							if ($between == 1) {
								if ($rs['precio_extra'] != 1) {
									//Si está marcado como que queremos que se cobre el precio extra en esa fecha
									$cobrar = false;
									break;
								} else {
									// Si está marcado como que SI se cobrará, compruebo si hay un precio marcado específico.. y en ese caso, modifico el total_extra
									if(!empty($nitsmin_price_extra)) {
										$precio_extra = $personas_extra * $nitsmin_price_extra;
										$total_extra = $precio_extra * $numnights;
									}
								}
							}
						}
					}


					if($cobrar){
						$total=$total+$total_extra;
					}

				}
			}

			$totalNoches=(double)$total;
		if (empty($persons) || ($persons==0)){
			$TotalMaximoHuespedes=1;
			$db->where('eid',$id);
			$query=$db->get("establiments","persons");
			foreach($query as $rs){
				$TotalMaximoHuespedes=$rs["persons"];
			}
		} else {
			$TotalMaximoHuespedes=$persons;
		}
		if (empty($numnights) || ($numnights==0)) $numnights = 1;
		if (empty($persons) || ($persons==0)) $persons = 1;
		$bestprice=round(($totalNoches/$persons)/$numnights,2);

		}
               

            $senyal = Query('establiments', 'senyal', 'eid', $id);		
            $anticipat = $total*($senyal/100);
            $restant = $total - $anticipat;

	//if($id == 332) exit('a');



	return array('total'=>round($total, 2), 'senyal'=>round($senyal, 2), 'anticipat'=>round($anticipat, 2), 'restant'=>round($restant, 2),'descripcion_tipo_precio'=>'<input type="hidden" id="descripcion_tipo_precio" value="'.$descripcion_tipo_precio.'" />', 'descripcion_precio' => $descripcion_tipo_precio, 'bestprice'=>round($bestprice, 2), 'nitsmin_price' => $nitsmin_price);


           

	//return array('total'=>$total,'senyal'=>$senyal,'anticipat'=>$anticipat,'restant'=>$restant,'between'=>$between);
	
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA CASA
function GetTitleCasa ($id) {

	$db = MysqliDb::getInstance();
	$db->where("eid",$id);
	$rs=$db->getOne('establiments',"eid,title_real");
	if($db->count > 0){
		return $rs['title_real'];
	}
	else{
		return 0;
	}
}

?>
