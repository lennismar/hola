<?php
// ------------------------------------------------------------------
// --------------------- INICIO: VARIABLES --------------------------
// ------------------------------------------------------------------
//print_r($url2);
// GET SANITIZE
if (isset($_GET['lng'])) 		$lng = filter_input(INPUT_GET, 'lng', FILTER_SANITIZE_STRING);					//Language
if (isset($_GET['provincia'])) 	$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);					//URL Frindly
if (isset($_GET['id'])) 		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);				//Id de la Landing

/*
if (isset($_GET['lng'])) echo '<br>lng-'.$lng;
if (isset($_GET['provincia'])) echo '<br>url-'.$url;
if (isset($_GET['id'])) echo '<br>id-'.$id;
*/
//$rs_query = mysql_query("SELECT * FROM landings WHERE id = " . $id);
if(isset($url2)){
	$id=$query_2['id'];
}
elseif(isset($url3)){
	$id=$query2['id'];
}
//exit('<br>id-'.$id);
$db->where('id',$id);
$landing=$db->getOne('landings','*');
//$landing = mysql_fetch_array($rs_query);

//print_r($landing);
$datein = "";
$dateout = "";
$persons = 0;
$price = $landing['prices'];
$tipo = "all";
$tipocasa = $landing['tipus'];
$where = $landing['location'];
$provincia= "all";
$comarca = "all";
$serid = false;
$perid = false;

if ($landing['serveis']!="") $serid = explode('+', $landing['serveis']);	
if ($landing['perfils']!="") $perid = explode('+', $landing['perfils']);

if ($tipocasa!='all') $tipo = Query('tipus', 'tipo', 'tid', (int)$tipocasa);

// SESSION
$_SESSION['tipocasa'] = $tipocasa;
$_SESSION['price'] = $price;
$_SESSION['datein'] = "";
$_SESSION['dateout'] = "";
$_SESSION['where'] = $where;


// WHERE
$where = explode("-", $where);
if ($where[0]=='p') { 
	$provincia = urls_amigables(GetTitleProvincia($where[1]));
} elseif($where[0]=='c') {
	$comarca = urls_amigables(GetTitleComarca ($where[1]));
	$provincia = urls_amigables(GetTitleProvincia(Query('comarques', 'pvid', 'comid', $where[1])));
}



// Almacenamos la url de búsqueda para poder volver en cualquier momento desde una ficha
$_SESSION['current_url'] = $current_url;

// ------------------------------------------------------------------
// ----------------- INICIO: FILTROS --------------------------------
// ------------------------------------------------------------------

// Cálculo de número de noches y número de dias con antelación
$numnights = DateDiff($datein, $dateout); 
$numdaysant = DateDiff(date("d-m-Y"), $datein);

$where = explode("-", $_SESSION['where']);
$where_consulta = $_SESSION['where'];
$_SESSION['where'] = $where_consulta;

$filter_where = "";
$title_where = "";


// $where[0] -> p (provincia), c (comarca)
// $where[1] -> id de la comarca o provincia
if ($where[0]=='p') {
    if(empty($where[1])){
        header('Location:../index.php'); exit();
    }

    $filter_where = "AND pvid = " . $where[1] . " "; // Filtro de la consulta
	$title_where = GetTitleProvincia ($where[1]); // Título de la provincia
	$description_where = Query('provincies', 'description_'.$lng, 'pvid', $where[1]); // Descripción de la provincia
} elseif($where[0]=='c') {
    if(empty($where[1])){
        header('Location:../index.php'); exit();
    }

    $filter_where = "AND comid = " . $where[1] . " "; // Filtro de la consulta
	$title_where = GetTitleComarca ($where[1]); // Titulo de la comarca
	$description_where = Query('comarques', 'description_'.$lng, 'comid', $where[1]); // Descripción de la comarca
	$pvid = Query('comarques', 'pvid', 'comid', $where[1]);
} else {
	$title_where = CATALUNYA;
}


// --------------- FILTRO DEL TIPO DE CASA  ---------------------------
$filter_tipocasa="";

if ($tipocasa!="all") {
	$filter_tipocasa=" AND tid=".$tipocasa. " ";
}



// --------------- FILTRO DE PERFILES ---------------------------
$filter_perfil="";
$count_perfil=1;

if (!empty($perid)) {
	foreach ($perid as $perfil) {
		if ($count_perfil==1) {
			$filter_perfil .= " AND eid IN (
				SELECT eid
				FROM (
				SELECT eid, COUNT( eid ) AS c
				FROM establiments_perfils
				WHERE ("; 
		} else { 
			$filter_perfil .= " OR ";
		}
		
		$filter_perfil .= "perid = ".$perfil;
		
		if (count($perid) == $count_perfil) 
			$filter_perfil .= ")
			GROUP BY eid
			HAVING c = ".count($perid)."
			) AS taula2
			)";
			
		$count_perfil++;
	}
}
// --------------- FILTRO DE SERVICIOS --------------------------
$filter_servicios="";
$count_servicios=1;

if (!empty($serid)) {
	foreach ($serid as $servicio){
	
		if ($count_servicios==1) {
			$filter_servicios .= " AND eid IN (
				SELECT eid
				FROM (
				SELECT eid, COUNT( eid ) AS c
				FROM establiments_serveis
				WHERE ("; 
		} else { 
			$filter_servicios .= " OR ";
		}
		
		$filter_servicios .= "serid = ".$servicio;
		
		if (count($serid) == $count_servicios) 
			$filter_servicios .= ")
			GROUP BY eid
			HAVING c = ".count($serid)."
			) AS taula3
			)";
			
		$count_servicios++;
	}
}


// --------------- Guardamos toda la cadena de filtros -----------
if ($filter_buscador == ""){
	$filter = $filter_where . $filter_tipocasa . $filter_perfil . $filter_servicios . $filter_buscador; 
}
elseif ($filter_buscador != ''){
	$filter_where = "";
	$title_where = CATALUNYA;
	$description_where = "";
	$filter = $filter_buscador; 
}

// ------------------------------------------------------------------
// ----------------- FIN: FILTROS -----------------------------------
// ------------------------------------------------------------------



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------- INICIO: CONSULTA DE CASAS --------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------- CONSULTA SIN CONOCER FECHA DE SALIDA o ENTRADA -------------------------------------------------------
if(($datein == "") || ($dateout == "")) { 
	$num_establiment_disponibles = 0; //indicará el número de casas disponibles

	$query = "SELECT DISTINCT rand() as rand, eid, title, subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter."  ORDER BY reserva_inmediata DESC, persons ASC, rand";
	$rs_query=$db->rawQuery($query);

	foreach($rs_query as $rs){
		if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
			$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", strtotime("next saturday")),'',$tipo,''),2);
			
			if ($price!="all") {
				list($pricemin, $pricemax) = explode('-', $price);
				if (($pricemin <= (int)$bestprice) && ((int)$bestprice <= $pricemax)) $fPrice = true; else $fPrice = false;
			} else {
				$fPrice = true;
			}

			if (($bestprice!=0) && $fPrice) { // Si el precio es diferente de 0, guardamos el establecimiento (id y precio) en el un Array
				$num_establiment_disponibles++;
				$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
				$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
				$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
				$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];				
				$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
				$establiments[$num_establiment_disponibles]['daysmin'] = $rs['daysmin'];
				$establiments[$num_establiment_disponibles]['lid'] = $rs['lid'];
				$establiments[$num_establiment_disponibles]['tid'] = $rs['tid'];
				$establiments[$num_establiment_disponibles]['comid'] = $rs['comid'];
				$establiments[$num_establiment_disponibles]['pvid'] = $rs['pvid'];
				$establiments[$num_establiment_disponibles]['persons'] = $rs['persons'];
				$establiments[$num_establiment_disponibles]['persons_min'] = $rs['persons_min'];
				$establiments[$num_establiment_disponibles]['bedrooms'] = $rs['bedrooms'];
				$establiments[$num_establiment_disponibles]['bathrooms'] = $rs['bathrooms'];
				$establiments[$num_establiment_disponibles]['gmap_lat'] = $rs['gmap_lat'];
				$establiments[$num_establiment_disponibles]['gmap_lng'] = $rs['gmap_lng'];
				$establiments[$num_establiment_disponibles]['imagen'] = ImagePrincipalEstabliment($rs['eid']);
			}
		}
	}
} else {
// --------------------------------------------------------------------------------- CONSULTA POR HABITACIONES (tipo=1) -----------------------------------------------------------
	if ($tipo == 1) { 
		$num_establiment_disponibles = 0; //indicará el número de casas disponibles

		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter."  ORDER BY reserva_inmediata DESC, persons ASC, rand";
		$rs_query=$db->rawQuery($query);

		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
				$disponibilitat = 1; // flag que indicará si hay disponibilidad o no
				$date = $datein;

				while ($date < $dateout) { // Recorrido del intervalo de fechas	
					$SQL  = "SELECT rp.eid, rp.date, SUM(r.persons*rp.availability) AS total "; 
					$SQL .= "FROM rooms_prices rp, rooms r ";
					$SQL .= "WHERE rp.eid = ".$rs['eid']." AND r.eid = ".$rs['eid']." AND rp.rid = r.rid AND rp.date = '".date("Y-m-d", $date)."'";
							
					//$query2 = mysql_query($SQL);
					$query2=$db->rawQuery($SQL);
					//while($rs2 = mysql_fetch_array($query2)){
					foreach($query2 as $rs2){
						if ($rs2['total']<$persons) $disponibilitat = 0;
					}
					$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
				}
				
				// Si hay disponibilidad de las habitaciones de la casa, la guardamos en el array
				if ($disponibilitat==1) {
					$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,''),2);
					
					if ($price!="all") {
						list($pricemin, $pricemax) = explode('-', $price);
						if (($pricemin <= (int)$bestprice) && ((int)$bestprice <= $pricemax)) $fPrice = true; else $fPrice = false;
					} else {
						$fPrice = true;
					}
			
					if ($fPrice) {
						// Comprobamos si hay un número mínimo de noches para unas fechas determinadas
						$nitsmin= $rs['daysmin'];
						
						//$nitsmin_query = mysql_query("SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']);
						$nitsmin_query = "SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']."";
						$rs_nitsmin=$db->rawQuery($nitsmin_query);
						//while($nm = mysql_fetch_array($nitsmin_query)) {
						foreach($rs_nitsmin as $nm){
							$date_start = date('Y-m-d', strtotime($nm['date_start']));
							$date_end = date('Y-m-d', strtotime($nm['date_end']));
							$between=0;
							if (($datein >= $date_start) && ($datein < $date_end)) $between=1;
							if (($dateout >= $date_start) && ($dateout <= $date_end)) $between=1;
							if ($between==1) $nitsmin= $nm['nitsmin'];
						}

						
						$num_establiment_disponibles++;
						$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
						$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
						$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
						$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];
						$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
						$establiments[$num_establiment_disponibles]['daysmin'] = $nitsmin;
						$establiments[$num_establiment_disponibles]['lid'] = $rs['lid'];
						$establiments[$num_establiment_disponibles]['tid'] = $rs['tid'];
						$establiments[$num_establiment_disponibles]['comid'] = $rs['comid'];
						$establiments[$num_establiment_disponibles]['pvid'] = $rs['pvid'];
						$establiments[$num_establiment_disponibles]['persons'] = $rs['persons'];
						$establiments[$num_establiment_disponibles]['persons_min'] = $rs['persons_min'];
						$establiments[$num_establiment_disponibles]['bedrooms'] = $rs['bedrooms'];
						$establiments[$num_establiment_disponibles]['bathrooms'] = $rs['bathrooms'];
						$establiments[$num_establiment_disponibles]['gmap_lat'] = $rs['gmap_lat'];
						$establiments[$num_establiment_disponibles]['gmap_lng'] = $rs['gmap_lng'];
						$establiments[$num_establiment_disponibles]['imagen'] = ImagePrincipalEstabliment($rs['eid']);
					}
				}
			}	
		}
	}
	
// --------------------------------------------------------------------------------- CONSULTA POR CASA ENTERA (tipo=2) ------------------------------------------------------------
	if ($tipo == 2) { 
		$num_establiment_disponibles = 0; //indicará el número de casas disponibles

		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 AND establimentcomplert = 1 ".$filter."  ORDER BY reserva_inmediata DESC, persons ASC, rand";
		$rs_query=$db->rawQuery($query);

		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
		
				$disponibilitat = 1; //flag que indicará si hay disponibilidad o no
				$date = $datein;		
				
				if (GetNumRoomsEstabliment($rs['eid'])==0) { // Sólo Establecimiento Entero (Comprobamos si tiene habitaciones)
					while ($date < $dateout) {
						//$query2 = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
						$query2 = "SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
						$rs_query2=$db->rawQuery($query2);
						//if(!(mysql_fetch_array($query2))) $disponibilitat = 0;
						if($db->count<1) $disponibilitat = 0;
						$date = strtotime("+1 day", $date);
					}
				} else { // Establecimiento entero y habitaciones
					while ($date < $dateout) { // Recorrido del intervalo de fechas
						//$query2 = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
						$query2 = "SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
						$rs_query2=$db->rawQuery($query2);
						//if($rs2 = mysql_fetch_array($query2)) { // Verificamos que haya disponibilidad y precio marcado en la fecha concreta del establecimiento entero
						if($db->count >0){					
							//$query3 = mysql_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
							$query3 = "SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
							$rs_query3=$db->rawQuery($query3);
							//while($rs3 = mysql_fetch_array($query3)){ // Verificamos que cada una de las habitaciones esten disponibles también, sino no se podrá dar disponibilidad
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
					//$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,''),2);
					
					if ($price!="all") {
						list($pricemin, $pricemax) = explode('-', $price);
						if (($pricemin <= (int)$bestprice) && ((int)$bestprice <= $pricemax)) $fPrice = true; else $fPrice = false;
					} else {
						$fPrice = true;
					}
			
					if ($fPrice) {
						// Comprobamos si hay un número mínimo de noches para unas fechas determinadas
						$nitsmin= $rs['daysmin'];
						
						//$nitsmin_query = mysql_query("SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']);
						$nitsmin_query = "SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']."";
						$rs_nitsmin=$db->rawQuery($nitsmin_query);

						//while($nm = mysql_fetch_array($nitsmin_query)) {
						foreach($rs_nitsmin as $nm){
							$date_start = date('Y-m-d', strtotime($nm['date_start']));
							$date_end = date('Y-m-d', strtotime($nm['date_end']));
							$between=0;
							if (($datein >= $date_start) && ($datein < $date_end)) $between=1;
							if (($dateout >= $date_start) && ($dateout <= $date_end)) $between=1;
							if ($between==1) $nitsmin= $nm['nitsmin'];
						}
	
	
						$num_establiment_disponibles++;	
						$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
						$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
						$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
						$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];
						$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
						$establiments[$num_establiment_disponibles]['daysmin'] = $nitsmin;
						$establiments[$num_establiment_disponibles]['lid'] = $rs['lid'];
						$establiments[$num_establiment_disponibles]['tid'] = $rs['tid'];
						$establiments[$num_establiment_disponibles]['comid'] = $rs['comid'];
						$establiments[$num_establiment_disponibles]['pvid'] = $rs['pvid'];
						$establiments[$num_establiment_disponibles]['persons'] = $rs['persons'];
						$establiments[$num_establiment_disponibles]['persons_min'] = $rs['persons_min'];
						$establiments[$num_establiment_disponibles]['bedrooms'] = $rs['bedrooms'];
						$establiments[$num_establiment_disponibles]['bathrooms'] = $rs['bathrooms'];
						$establiments[$num_establiment_disponibles]['gmap_lat'] = $rs['gmap_lat'];
						$establiments[$num_establiment_disponibles]['gmap_lng'] = $rs['gmap_lng'];
						$establiments[$num_establiment_disponibles]['imagen'] = ImagePrincipalEstabliment($rs['eid']);
					}
				}
			}
		}
	}
	
// --------------------------------------------------------------------------------- CONSULTA POR TODO TIPO DE CASAS (tipo=all) ------------------------------------------------------------	
	if ($tipo == 'all') { 
		
		$num_establiment_disponibles = 0; //indicará el número de casas disponibles

		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter."  ORDER BY reserva_inmediata DESC, persons ASC, rand";
		$rs_query=$db->rawQuery($query);

		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
		
				$disponibilitat = 1; //flag que indicará si hay disponibilidad o no
				$date = $datein;		
				
				$tipoestabliment = Query('tipus', 'tipo', 'tid', $rs['tid']);
				
				if ($tipoestabliment == 1){
					$disponibilitat = 1; // flag que indicará si hay disponibilidad o no
					$date = $datein;
		
					while ($date < $dateout) { // Recorrido del intervalo de fechas	
						$SQL  = "SELECT rp.eid, rp.date, SUM(r.persons*rp.availability) AS total "; 
						$SQL .= "FROM rooms_prices rp, rooms r ";
						$SQL .= "WHERE rp.eid = ".$rs['eid']." AND r.eid = ".$rs['eid']." AND rp.rid = r.rid AND rp.date = '".date("Y-m-d", $date)."'";
								
						//$query2 = mysql_query($SQL);
						$query2=$db->rawQuery($SQL);
						//while($rs2 = mysql_fetch_array($query2)){
						foreach($query2 as $rs2){
							if ($rs2['total']<$persons) $disponibilitat = 0;
						}
						
						$date = strtotime("+1 day", $date); // Guardamos la fecha siguiente
					}				
				
				} elseif ($tipoestabliment == 2){
					if (GetNumRoomsEstabliment($rs['eid'])==0) { // Sólo Establecimiento Entero (Comprobamos si tiene habitaciones)
						while ($date < $dateout) {
							//$query2 = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
							$query2 = "SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
							$rs_query2=$db->rawQuery($query2);
							//if(!(mysql_fetch_array($query2))) $disponibilitat = 0;
							if($db->count < 1) $disponibilitat = 0;
							$date = strtotime("+1 day", $date);
						}
					} else { // Establecimiento entero y habitaciones
						while ($date < $dateout) { // Recorrido del intervalo de fechas
							//$query2 = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
							$query2 = "SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
							$rs_query2=$db->rawQuery($query2);

							//if($rs2 = mysql_fetch_array($query2)) { // Verificamos que haya disponibilidad y precio marcado en la fecha concreta del establecimiento entero
							if($db->count > 0){				
								//$query3 = mysql_query("SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
								$query3 = "SELECT rid, eid, date, price, availability FROM rooms_prices WHERE eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
								$rs_query3=$db->rawQuery($query3);
								//while($rs3 = mysql_fetch_array($query3)){ // Verificamos que cada una de las habitaciones esten disponibles también, sino no se podrá dar disponibilidad
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
				}
	
				if ($disponibilitat==1) {
					$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipoestabliment,''),2);
	
					if ($price!="all") {
						list($pricemin, $pricemax) = explode('-', $price);
						if (($pricemin <= (int)$bestprice) && ((int)$bestprice <= $pricemax)) $fPrice = true; else $fPrice = false;
					} else {
						$fPrice = true;
					}
	
					if (($bestprice!= 0) && $fPrice) { // Si el precio es diferente de 0, guardamos el establecimiento (id y precio) en el un Array
						// Comprobamos si hay un número mínimo de noches para unas fechas determinadas
						$nitsmin= $rs['daysmin'];
						
						//$nitsmin_query = mysql_query("SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']);
						$nitsmin_query = "SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']."";
						$rs_nitsmin=$db->rawQuery($nitsmin_query);

						//while($nm = mysql_fetch_array($nitsmin_query)) {
						foreach($rs_nitsmin as $nm){
							$date_start = date('Y-m-d', strtotime($nm['date_start']));
							$date_end = date('Y-m-d', strtotime($nm['date_end']));
							$between=0;
							if ((date("Y-m-d", $datein) >= $date_start) && (date("Y-m-d", $datein) < $date_end)) $between=1;
							if ((date("Y-m-d", $dateout) >= $date_start) && (date("Y-m-d", $dateout) <= $date_end)) $between=1;
							if ($between==1) $nitsmin= $nm['nitsmin'];
						}
	
						$num_establiment_disponibles++;	
						$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
						$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
						$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
						$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];
						$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
						$establiments[$num_establiment_disponibles]['daysmin'] = $nitsmin;
						$establiments[$num_establiment_disponibles]['lid'] = $rs['lid'];
						$establiments[$num_establiment_disponibles]['tid'] = $rs['tid'];
						$establiments[$num_establiment_disponibles]['comid'] = $rs['comid'];
						$establiments[$num_establiment_disponibles]['pvid'] = $rs['pvid'];
						$establiments[$num_establiment_disponibles]['persons'] = $rs['persons'];
						$establiments[$num_establiment_disponibles]['persons_min'] = $rs['persons_min'];
						$establiments[$num_establiment_disponibles]['bedrooms'] = $rs['bedrooms'];
						$establiments[$num_establiment_disponibles]['bathrooms'] = $rs['bathrooms'];					
						$establiments[$num_establiment_disponibles]['gmap_lat'] = $rs['gmap_lat'];
						$establiments[$num_establiment_disponibles]['gmap_lng'] = $rs['gmap_lng'];
						$establiments[$num_establiment_disponibles]['imagen'] = ImagePrincipalEstabliment($rs['eid']);
					}
				}
			}		
		}
	}
}

// Hemos eliminado el RAND() del MySQL para evitar más tiempo de consulta y usamos shuffle() para ordenar las casas de manera aleatoria
if ($num_establiment_disponibles>2) shuffle($establiments);


//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------- FIN: CONSULTA DE CASAS -----------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$nitsmin_global = 0;

if(($datein != "") && ($dateout != "")) { 
	$date_entrada = date('Y-m-d', $datein);
	$date_salida = date('Y-m-d', $dateout);
	
	// TEXTO ADVERTENCIA
	//$txt_buscador_query = mysql_query("SELECT date_start,date_end,texto_buscador_".$lng." FROM texto_buscador");
	$txt_buscador_query = "SELECT date_start,date_end,texto_buscador_".$lng." FROM texto_buscador";
	$rs_txt=$db->rawQuery($txt_buscador_query);

	//while($txt_buscador = mysql_fetch_array($txt_buscador_query)) {
	foreach($rs_txt as $txt_buscador){
		$date_start = date('Y-m-d', strtotime($txt_buscador['date_start']));
		$date_end = date('Y-m-d', strtotime($txt_buscador['date_end']));
		$txt_adv = "";
		$between=0;
		
		if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
		if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;
		
		if ($between==1) {
			$txt_adv = "<div class='alert alert--info'>".$txt_buscador['texto_buscador_'.$lng]."</div>";
			break;
		}
	}
	
	// NITS GLOBAL
	//$nitsmin_global_query = mysql_query("SELECT date_start, date_end, nitsmin FROM nitsmin");
	$nitsmin_global_query = "SELECT date_start, date_end, nitsmin FROM nitsmin";
	$rs_nitsmin=$db->rawQuery($nitsmin_global_query);

	//while($nmg = mysql_fetch_array($nitsmin_global_query)) {
	foreach($rs_nitsmin as $nmg){
		$date_start = date('Y-m-d', strtotime($nmg['date_start']));
		$date_end = date('Y-m-d', strtotime($nmg['date_end']));
		$between=0;
		
		if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
		if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;
		
		if ($between==1) $nitsmin_global = $nmg['nitsmin'];
	}
}
?>

