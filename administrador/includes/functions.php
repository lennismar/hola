<?php


// FUNCION QUE DEVUELVE EL REGISTRO QUE SE DESEE DE CUALQUIER TABLA DE LA BBDD
// PARÁMETRO 1: Nombre de la tabla
// PARÁMETRO 2: Nombre del registro a consultar
// PARÁMETRO 3: Nombre del id que usa la tabla
// PARÁMETRO 4: id a filtrar

function Query($table, $reg, $nameid, $id) {
	//$query = mysqli_query("SELECT $reg FROM $table WHERE $nameid = $id");
	//if($rs = mysqli_fetch_array($query))	return $rs[$reg];
	//else return false;
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

// FUNCION QUE DEVUELVE EL NOMBRE DE LA COMARCA
function GetTitleComarca ($id) {
	/*$query = mysqli_query("SELECT comid, title FROM comarques WHERE comid=".$id);
	if($rs = mysqli_fetch_array($query)){
			return $rs['title'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
	$db->where('comid',$id);
	$rs=$db->get('comarques',null,'comid, title');
	
	if($db->count > 0){
		return $rs['title'];
	}
	else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA LOCALIDAD
function GetTitleLocalitat ($id) {
	/*$query = mysqli_query("SELECT lid, title FROM localitats WHERE lid=".$id);
	if($rs = mysqli_fetch_array($query)){
			return $rs['title'];
	}else{
			return false;
	}*/
	
	$db = MysqliDb::getInstance();
	$db->where('lid',$id);
	$rs=$db->getOne('localitats',null,'lid, title');
	
	
	if($db->count > 0){
		return $rs['title'];
	}
	else{
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


// FUNCION QUE IMPRIME TODOS LOS OPTION DE LAS COMARCAS
function PrintOptionComarca($where){
	$printoptioncomarca = "";
	$db = MysqliDb::getInstance();
	/*$query = mysqli_query("SELECT comid, pvid, title FROM comarques ORDER BY title ASC");
	while($rs = mysqli_fetch_array($query)){*/
	$db->orderBy('title','ASC');
	$rs_query=$db->get('comarques',null,'comid, pvid, title');
	foreach($rs_query as $rs){
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
	/*$query = mysqli_query("SELECT pvid, title FROM provincies ORDER BY title ASC");
	while($rs = mysqli_fetch_array($query)){*/
	$db->orderBy('title','ASC');
	$rs_query=$db->get('provincies',null,'pvid, title');
	foreach($rs_query as $rs){
		$filter="";
		if ($where == 'p-'.$rs['pvid']) { $filter = "selected=\"selected\""; }
		$printoptionprovincia = $printoptionprovincia . '<option value="p-'.$rs['pvid'].'" '.$filter.'>'.$rs['title'].'</option>';			
	}
	
	return $printoptionprovincia;
}


// FUNCION QUE DEVUELVE EL NOMBRE DEL TIPUS DE ESTABLECIMIENTO
function GetTitleTipusEstabliment ($id) {
    $db = MysqliDb::getInstance();
    $db->where ("tid", $id);
    $rs = $db->getOne('tipus', null, "tid, title_ca");
    if ($db->count > 0) {
        return $rs['title_ca'];
	}else{
		return false;
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

// CASA ALTERNATIVA DISPONIBLE EN LA PROVINCIA
function AltEstablimentProvincia($eid,$checkin,$checkout,$persons) {
	$pvid = Query('establiments', 'pvid', 'eid', $eid);
	$tipo = Query('establiments', 'tid', 'eid', $eid);
	
	
}


// FUNCION QUE CONVIERTE YES/NO EN 1 ó 0
function YesNoTo1or0($yesno) {
	if($yesno == 'yes'){
			return 1;
	}else{
			return 0;
	}
}

// FUNCION QUE DEVUELVE EL NUMERO DE ALOJAMIENTOS DE UN TIPO
// $tipus -> si diferente de 'false' entonces filtrará por tipo 
function GetNumEstabliments($tipus) {
	$db = MysqliDb::getInstance();
	if ($tipus != "") 	
	{
		//$filter_tipus = " WHERE tid = " . $tipus;
		$db->where("tid",$tipus);
	}
	/*$num = mysqli_query("SELECT eid FROM establiments ".$filter_tipus);
	return mysqli_num_rows($num);*/
	
	$rs=$db->withTotalCount()->get('establiments',null,'eid');
	return $db->totalCount;	
}

// FUNCION QUE DEVUELVE EL NUMERO DE IMAGENES DE UN ESTABLECIMIENTO
function GetNumReservations($eid) {
	/*$num = mysqli_query("SELECT eid FROM reservations WHERE eid=".$eid);
	return mysqli_num_rows($num);*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$rs=$db->withTotalCount()->get('reservations',null,'eid');
	return $db->totalCount;
}

// FUNCION QUE DEVUELVE EL NUMERO DE RESERVES DE UN ESTABLECIMIENTO
function GetNumImagesEstabliment($eid) {
	/*$num = mysqli_query("SELECT eid FROM establiments_images WHERE eid=".$eid);
	return mysqli_num_rows($num);*/	
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$rs=$db->withTotalCount()->get('establiments_images',null,'eid');
	return $db->totalCount;
}


// FUNCION QUE DEVUELVE EL NUMERO DE HABITACIONES DE UN ESTABLECIMIENTO
function GetNumRoomsEstabliment($eid) {
	/*$num = mysqli_query("SELECT eid FROM rooms WHERE eid=".$eid);
	return mysqli_num_rows($num);*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$rs=$db->withTotalCount()->get('rooms',null,'eid');
	return $db->totalCount;
}

// FUNCION QUE DEVUELVE OPTION "SELECTED"
function GetSelectedCheckBoxServeis ($eid, $serid) {
	/*$query = mysqli_query("SELECT eid FROM establiments_serveis WHERE eid=".$eid." AND serid=".$serid);
	if($rs = mysqli_fetch_array($query)) return ' checked ';*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('serid',$serid);
	$rs=$db->get('establiments_serveis',null,'eid');
	if($db->count > 0) return ' checked ';
}

// FUNCION QUE DEVUELVE OPTION "SELECTED"
function GetSelectedCheckBoxServeisExt ($eid, $serid) {
	/*$query = mysqli_query("SELECT eid FROM establiments_serveis_ext WHERE eid=".$eid." AND serid=".$serid);
	if($rs = mysqli_fetch_array($query)) return ' checked ';*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('serid',$serid);
	$rs=$db->get('establiments_serveis_ext',null,'eid');
	if($db->count > 0) return ' checked ';
}

// FUNCION QUE DEVUELVE OPTION "SELECTED"
function GetSelectedCheckBoxPerfils ($eid, $perid) {
	/*$query = mysqli_query("SELECT eid FROM establiments_perfils WHERE eid=".$eid." AND perid=".$perid);
	if($rs = mysqli_fetch_array($query)) return ' checked ';*/
	$db = MysqliDb::getInstance();
	$db->where('eid',$eid);
	$db->where('perid',$perid);
	$rs=$db->get('establiments_perfils',null,'eid');
	if($db->count > 0) return ' checked ';
}

// FUNCION QUE DEVUELVE EL NOMBRE DEL TIPUS RECURSO TURISTICO
function GetTitleTipusRecurso($id) {
	/*$query = mysqli_query("SELECT idtipusrecurso, title_ca FROM recursos_tipus WHERE idtipusrecurso=".$id);
	if($rs = mysqli_fetch_array($query)){
			return $rs['title_ca'];
	}else{
			return false;
	}*/
	$db = MysqliDb::getInstance();
    $db->where ("idtipusrecurso", $id);
    $rs = $db->getOne('recursos_tipus', null, "idtipusrecurso, title_ca");
    
    if ($db->count > 0) {
        return $rs['title_ca'];
	}else{
		return false;
	}
}

// FUNCION QUE DEVUELVE EL NOMBRE DE LA IMAGEN PRINCIPAL DEL ESTABLECIMIENTO
function ImagePrincipalEstabliment($eid) {
	/*$query = mysqli_query("SELECT eid, filename FROM establiments_images WHERE eid=".$eid." AND principal=1");
	if($rs = mysqli_fetch_array($query)){
			return $rs['filename'];
	}*/
	$db = MysqliDb::getInstance();
    $db->where ("eid", $eid);
	$db->where ("principal", 1);
    $rs = $db->getOne('establiments_images', null, "eid, filename");
    if ($db->count > 0) {
        return $rs['filename'];
	}else{
		return false;
	}
}

function dateToMySQL ($datetoconvert) {
	$phpdate = strtotime($datetoconvert);
	return date( 'Y-m-d H:i:s', $phpdate );
}

// FUNCION QUE DEVUELVE COMO HA VIAJADO EL CLIENTE
function CommentsHow($idcomo) {
	switch ($idcomo) {
		case 1:
			$como = "En viatge d'empresa";
			break;
		case 2:
			$como = "En parella";
			break;
		case 3:
			$como = "Jo sol";
			break;
		case 4:
			$como = "Amb amics";
			break;
		case 5:
			$como = "En família";
			break;						
	}		
	
	return $como;
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

// FUNCION QUE DEVUELVE EL NUMERO DE PERSONAS QUE CABEN EN UN ESTABLECIMIENTO POR CASA ENTERA
function GetNumPersonsEstabliment($id) {
	/*$query = mysqli_query("SELECT eid, persons FROM establiments WHERE eid = ".$id);
	if($rs = mysqli_fetch_array($query)){
		return $rs['persons'];
	} else {
		return 0;	
	}*/
	$db = MysqliDb::getInstance();
    $db->where ("eid", $id);
    $rs = $db->getOne('establiments', null, "eid, persons");
    if ($db->count > 0) {
        return $rs['persons'];
	}else{
		return 0;
	}
}
// FUNCION QUE DEVUELVE EL NUMERO DE PERSONAS EXTRA QUE CABEN EN UN ESTABLECIMIENTO POR CASA ENTERA
function GetNumExtraPersonsEstabliment($id) {

	$db = MysqliDb::getInstance();
    $db->where ("eid", $id);
    $db->where ("allow_extra_persons", 1);
    $rs = $db->getOne('establiments', null, "eid, extra_quantity");
    if ($db->count > 0) {
        return $rs['extra_quantity'];
	}else{
		return 0;
	}
}
// FUNCION QUE DEVUELVE EL NUMERO DE PERSONAS QUE CABEN EN UN ESTABLECIMIENTO POR HABITACIONES
function GetNumPersonsRooms($id) {
	/*$query = mysqli_query("SELECT eid, SUM(persons*availability) FROM rooms WHERE published = 1 AND eid = ".$id);
	if($rs = mysqli_fetch_array($query)){
		return $rs['SUM(persons*availability)'];
	} else {
		return 0;	
	}*/
	$db = MysqliDb::getInstance();
    $db->where ("eid", $id);
	$db->where ("published", 1);
    $rs = $db->getOne('rooms', null, "eid, SUM(persons*availability)");
    if ($db->count > 0) {
        return $rs['SUM(persons*availability)'];
	}else{
		return 0;
	}
}

// FUNCION QUE DEVUELVE EL MEJOR PRECIO DE UN ESTABLECIMIENTO POR NOCHE POR PERSONA
function GetBestPriceEstablimentPerNightPerPerson($id,$datein,$dateout,$tipo,$persons){ // Filtramos a partir de una fecha
	$db = MysqliDb::getInstance();
	if ($tipo==1) { // HABITACION
		$SQL  = "SELECT rp.rid as rid, rp.price as price, r.persons as persons "; 
		$SQL .= "FROM rooms_prices rp, rooms r ";
		$SQL .= "WHERE rp.eid = ".$id." AND r.eid = ".$id." AND rp.rid = r.rid ";
		
		if ($datein!="") $SQL .= " AND rp.date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND rp.date < '".$dateout."'";
		
		/*$query = mysqli_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);
		$cont = 1;
				
		//while($rs = mysqli_fetch_array($query)){
		foreach($rs_query as $rs){
			if ($persons=='') {
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
		
		if ($datein!="") $SQL .= " AND date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND date < '".$dateout."'";
		
		//$query = mysqli_query($SQL);
		/* $rs_query=$db->get('establiments_prices',null,'eid, date, price, availability');*/
		$rs_query=$db->rawQuery($SQL);

		$cont = 0;
		
		if ($persons=="") $persons = Query('establiments', 'persons', 'eid', $id);
				
		if ($datein!="" && $dateout!="") { // Si existe fecha de entrada y salida, calculamos la media
			$total=0;
			//while($rs = mysqli_fetch_array($query)){
			foreach($rs_query as $rs){
				$total = $total + $rs['price'];
				$cont++;
			}
			$lessprice = ($total/$cont)/$persons;
		} else { // Si no hay fecha de entrada o salida, calculamos el mejor precio
			//while($rs = mysqli_fetch_array($query)){
			foreach($rs_query as $rs){
				if ($rs['price']!=0) {
					if ($cont==0) $lessprice = $rs['price']/$persons;
					$media = $rs['price']/$persons;
					if ($media < $lessprice) $lessprice = $media;
					$cont++;
				}
			}
		}
		
		//$lessprice = 12.25;

	} else if ($tipo=='all') { // HABITACION Y CASA COMPLETA
				
		// Cálculo del mejor precio por habitación
		$SQL  = "SELECT rp.rid as rid, rp.price as price, r.persons as persons "; 
		$SQL .= "FROM rooms_prices rp, rooms r ";
		$SQL .= "WHERE rp.eid = ".$id." AND r.eid = ".$id." AND rp.rid = r.rid ";
		
		if ($datein!="") $SQL .= " AND rp.date >= '".$datein."'";
		if ($dateout!="") $SQL .= " AND rp.date < '".$dateout."'";
		
		/*$query = mysqli_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);
		$cont = 0;
		
		//while($rs = mysqli_fetch_array($query)){
		foreach($rs_query as $rs){
			if ($persons=='') {
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
		
		/*$query = mysqli_query($SQL);*/
		$rs_query=$db->rawQuery($SQL);
		$cont = 0;
		
		if ($persons=="") $persons = Query('establiments', 'persons', 'eid', $id);
		
		//while($rs = mysqli_fetch_array($query)){
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


// Pujar arxiu
function upload_file($new_file, $old_file, $c_folder){
  
     if (isset($_FILES[$new_file])) {
      $uploaded_file = array('name' => $_FILES[$new_file]['name'],
                             'type' => $_FILES[$new_file]['type'],
                             'size' => $_FILES[$new_file]['size'],
                             'tmp_name' => $_FILES[$new_file]['tmp_name']);
    } elseif (isset($GLOBALS['HTTP_POST_FILES'][$new_file])) {
      global $HTTP_POST_FILES;

      $uploaded_file = array('name' => $HTTP_POST_FILES[$new_file]['name'],
                             'type' => $HTTP_POST_FILES[$new_file]['type'],
                             'size' => $HTTP_POST_FILES[$new_file]['size'],
                             'tmp_name' => $HTTP_POST_FILES[$new_file]['tmp_name']);
    } else {
      $uploaded_file = array('name' => $GLOBALS[$new_file . '_name'],
                             'type' => $GLOBALS[$new_file . '_type'],
                             'size' => $GLOBALS[$new_file . '_size'],
                             'tmp_name' => $GLOBALS[$new_file]);
    }

	if($uploaded_file['tmp_name']){

		$name = mb_strtolower(str_replace(" ","",$uploaded_file['name']));
		$name = str_replace(' ', '-', $name); // Replaces all spaces with hyphens.

		$name = preg_replace('/[^A-Za-z0-9.\-]/', '', $name);

			if(!move_uploaded_file($uploaded_file['tmp_name'], HOME_DIR . $c_folder . $name)){
				$name= $old_file;
			}else{
				chmod (HOME_DIR . $c_folder . $name,0777); 
				if($old_file && $old_file != $name){
					delete_file($c_folder . $old_file);
				}
			}
	}else{
		$name= $old_file;
	}
	return $name;
}


// Eliminar Arxiu
function delete_file($file_path){
  	$url = URL_BASE . $file_path;
	$page = @file_get_contents($url);
	if ($page != NULL){
		unlink(HOME_DIR . $file_path);
	}
}

// Redimensionar Imatge
function resize($src_im, $dpath, $maxd, $square=false) {
    $src_width = imagesx($src_im);
    $src_height = imagesy($src_im);
    $src_w=$src_width;
    $src_h=$src_height;
    $src_x=0;
    $src_y=0;
    if($square){
        $dst_w = $maxd;
        $dst_h = $maxd;
        if($src_width>$src_height){
            $src_x = ceil(($src_width-$src_height)/2);
            $src_w=$src_height;
            $src_h=$src_height;
        }else{
            $src_y = ceil(($src_height-$src_width)/2);
            $src_w=$src_width;
            $src_h=$src_width;
        }
    }else{
        if($src_width>$src_height){
            $dst_w=$maxd;
            $dst_h=floor($src_height*($dst_w/$src_width));
        }else{
            $dst_h=$maxd;
            $dst_w=floor($src_width*($dst_h/$src_height));
        }
    }
	
    $dst_im=imagecreatetruecolor($dst_w,$dst_h);
    imagecopyresampled($dst_im, $src_im, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    imagejpeg($dst_im,$dpath);
    return $dst_im;
}

// FUNCION QUE DEVUELVE UNA CASA OPCIONAL CON DISPONIBILIDAD
function GetOptionalEstablimentsDisponibles ($eid,$datein,$dateout,$persons,$pvid) {
	$db = MysqliDb::getInstance();

	$datein = strtotime($datein);
	$dateout = strtotime($dateout);
    $establiments = null;
	//$pvid = Query('establiments', 'pvid', 'eid', $eid);
	$tid = Query('establiments', 'tid', 'eid', $eid);
	$tipo = Query('tipus', 'tipo', 'tid', $tid);
	
	if ($pvid!='') {
		$filter = " AND ";
		$filter .= " pvid = ".$pvid;
		//$db->where('pvid',$pvid);
	}
	
	// --------------------------------------------------------------------------------- CONSULTA POR HABITACIONES (tipo=1) -----------------------------------------------------------
	if ($tipo == 1) { 
		$num_establiment_disponibles = 0; //indicará el número de casas disponibles
		$query = "SELECT DISTINCT eid, title, lid, tid, comid, published FROM establiments WHERE published = 1 ".$filter." ORDER BY RAND()";
		$rs_query=$db->rawQuery($query);
		/*$db->where('published',1);
		$db->orderBy('rand()');
		$rs_query=$db->get('establiments',null,'DISTINCT eid, title, lid, tid, comid, published');*/

		//while($rs = mysqli_fetch_array($query)){ // Recorrido de cada establecimiento
		foreach($rs_query as $rs){
			if ($persons <= GetNumPersonsEstabliment($rs['eid'])) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
				$disponibilitat = 1; // flag que indicará si hay disponibilidad o no
				$date = $datein;
	
				while ($date < $dateout) { // Recorrido del intervalo de fechas	
					$SQL  = "SELECT rp.eid, rp.date, SUM(r.persons*rp.availability) AS total "; 
					$SQL .= "FROM rooms_prices rp, rooms r ";
					$SQL .= "WHERE rp.eid = ".$rs['eid']." AND r.eid = ".$rs['eid']." AND rp.rid = r.rid AND rp.date = '".date("Y-m-d", $date)."'";
							
					//$query2 = mysqli_query($SQL);
					$query2 = $db->rawQuery($SQL);
					/*$db->join('rooms r','rp.rid = r.rid','left');
					$db->where('rp.eid',$rs['eid']);
					$db->where('r.eid',$rs['eid']);
					$db->where('rp.date',date("Y-m-d", $date));
					$rs_query2=$db->get('rooms_prices',null,'rp.eid, rp.date, SUM(r.persons*rp.availability) AS total');*/

					//while($rs2 = mysqli_fetch_array($query2)){
					foreach($query2 as $rs2){
						if ($rs2['total']<$persons) $disponibilitat = 0;
					}

					$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
			    }
				
				// Si hay disponibilidad de las habitaciones de la casa, la guardamos en el array
				if ($disponibilitat==1) {
					$num_establiment_disponibles++;
					//$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
	
					$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,''),2);
					//$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
					$establiments['eid'] = $rs['eid'];
					$establiments['bestprice'] = $bestprice;
					break;
				}
			}	
		}
	}
		
	// --------------------------------------------------------------------------------- CONSULTA POR CASA ENTERA (tipo=2) ------------------------------------------------------------
	if ($tipo == 2) { 
		$num_establiment_disponibles = 0; //indicará el número de casas disponibles
		$query = "SELECT DISTINCT eid, title, lid, tid, comid, published FROM establiments WHERE published = 1 AND establimentcomplert = 1 AND persons >= ".$persons." ".$filter." ORDER BY RAND()";
		$rs_query=$db->rawQuery($query);

		//while($rs = mysqli_fetch_array($query)){ // Recorrido de cada establecimiento
		foreach($rs_query as $rs){
			$disponibilitat = 1; //flag que indicará si hay disponibilidad o no
			$date = $datein;		
			
			if (GetNumRoomsEstabliment($rs['eid'])==0) { // Sólo Establecimiento Entero (Comprobamos si tiene habitaciones)
				while ($date < $dateout) {
					//$query2 = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
					$db->where('availability',1);
					$db->where('eid',$rs['eid']);
					$db->where('date',date("Y-m-d", $date));
					$rs_query2=$db->get('establiments_prices',null,'eid, date, price, availability');

					//if(!(mysqli_fetch_array($query2))) $disponibilitat = 0;
					if(!$rs_query2) $disponibilitat = 0;
					$date = strtotime("+1 day", $date);
				}
			} else { // Establecimiento entero y habitaciones
				while ($date < $dateout) { // Recorrido del intervalo de fechas
					//$query2 = mysqli_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
					$db->where('availability',1);
					$db->where('eid',$rs['eid']);
					$db->where('date',date("Y-m-d", $date));
					$rs_query2=$db->get('establiments_prices',null,'eid, date, price, availability');


					//if($rs2 = mysqli_fetch_array($query2)) { // Verificamos que haya disponibilidad y precio marcado en la fecha concreta del establecimiento entero
					if($rs_query2){					
						//$query3 = mysqli_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
						$db->where('eid',$rs['eid']);
						$db->where('date',date("Y-m-d", $date));
						$rs_query3=$db->get('rooms_prices',null,'rid, eid, date, price, availability');
						//while($rs3 = mysqli_fetch_array($query3)){ // Verificamos que cada una de las habitaciones esten disponibles también, sino no se podrá dar disponibilidad
						foreach($rs_query3 as $rs3){
							$availability_room = Query('rooms', 'availability', 'rid', $rs3['rid']);
							if ($availability_room != $rs3['availability']) $availability = 0;
						}
						
					} else {
						$disponibilitat = 0;
					}
					$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
				}
			}
			
			// Si hay disponibilidad de la casa entera, la guardamos en el array
			if ($disponibilitat==1) {
				$num_establiment_disponibles++;	
				//$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
	
				$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,''),2);
				//$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
				$establiments['eid'] = $rs['eid'];
				$establiments['bestprice'] = $bestprice;
				break;
			}
		}
	}
	
	return $establiments;
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


?>