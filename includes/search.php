<?php
// ------------------------------------------------------------------
// --------------------- INICIO: VARIABLES --------------------------
// ------------------------------------------------------------------

//$datein = DMA;
//$dateout = DMA;
$datein = "";
$dateout = "";
$persons = 0;
$price = "all";
$tipo = "all";
$tipocasa = "all";
$where = "all";
$provincia= "all";
$comarca = "all";
$serid = false;
$perid = false;
$instantBooking = false;
//echo '<pre>'; print_r($_POST); print_r($_GET);
// Almacenamos la url de búsqueda para poder volver en cualquier momento desde una ficha
$_SESSION['current_url'] = $current_url;

if ((strpos($_GET['comarca'],'p-')!== false) || (strpos($_GET['comarca'],'c-') !== false)) {
	// COMARCA y PROVINCIA
	$url="";
	$where = explode("-", $_GET['comarca']);

	if ($where[0]=='p') {
		$provincia = urls_amigables(GetTitleProvincia($where[1]));
	} elseif($where[0]=='c') {
		$comarca = urls_amigables(GetURLComarca ($where[1]));
		$provincia = urls_amigables(GetTitleProvincia(Query('comarques', 'pvid', 'comid', $where[1])));
	}

	if ($comarca!="all")  {
		$url= "/".$lng."/".URL_SEARCH."/".$provincia."/".$comarca;
	}else {
		$url= "/".$lng."/".URL_SEARCH."/".$provincia;
	}
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$url);
	die;
}

if(isset($_POST['searchsubmit']) || isset($_POST['refinesearchsubmit'])) {
	// POST SANITIZE
	if (isset($_POST['lng'])) 		$lng = filter_input(INPUT_POST, 'lng', FILTER_SANITIZE_STRING);					//Language
	if (isset($_POST['where'])) 	$where = filter_input(INPUT_POST, 'where', FILTER_SANITIZE_STRING);				//Where
	if (isset($_POST['persons'])) 	$persons = filter_input(INPUT_POST, 'persons', FILTER_SANITIZE_STRING);			//Persons
	if (isset($_POST['price'])) 	$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);			//Price
	if (isset($_POST['datein'])) 	$datein = filter_input(INPUT_POST, 'datein', FILTER_SANITIZE_STRING);			//Datein
	if (isset($_POST['dateout'])) 	$dateout = filter_input(INPUT_POST, 'dateout', FILTER_SANITIZE_STRING);			//Dateout
	if (isset($_POST['tipocasa'])) 	$tipocasa = filter_input(INPUT_POST, 'tipocasa', FILTER_SANITIZE_STRING);		//TipoCasa
	if (isset($_POST['serid'])) 	$serid = $_POST['serid']; 														//servicios
	if (isset($_POST['perid'])) 	$perid = $_POST['perid']; 														//perfil
	if (isset($_POST['instantBooking'])) 	$instantBooking = $_POST['instantBooking']; 														//reserva inmediata

	// TIPO DE CASA
	if ($tipocasa!="all") {
		$tipo_url = urls_amigables(Query('tipus', 'title_'.$lng, 'tid', $tipocasa));
	} else {
		$tipo_url = URL_SEARCH;
	}

	// COMARCA y PROVINCIA
	$where = explode("-", $where);
	if ($where[0]=='p') {
		$provincia = urls_amigables(GetTitleProvincia($where[1]));
	} elseif($where[0]=='c') {
		$comarca = urls_amigables(GetURLComarca ($where[1]));
		$provincia = urls_amigables(GetTitleProvincia(Query('comarques', 'pvid', 'comid', $where[1])));
	}

	$_SESSION['where'] = $where;
	$_SESSION['tipocasa'] = $tipocasa;

} else {

	// GET SANITIZE
	if (isset($_GET['lng'])) 		$lng = filter_input(INPUT_GET, 'lng', FILTER_SANITIZE_STRING);					//Language
	//if (isset($_GET['tipo'])) 	$tipocasa = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);			//Tipo
	if (isset($_GET['provincia'])) 	$provincia = filter_input(INPUT_GET, 'provincia', FILTER_SANITIZE_STRING);		//provincia
	if (isset($_GET['comarca'])) 	$comarca = filter_input(INPUT_GET, 'comarca', FILTER_SANITIZE_STRING);			//comarca

	if ($comarca!="all") {

		$where = "c-".GetIDComarca($comarca);
	} else {
		if ($provincia!="all") {
			$where = "p-".GetIDProvincia($provincia);
		}
	}

	$_SESSION['where'] = $where;

	if (isset($_GET['persons'])) {
		if($_GET['persons']!=none){
			$persons = filter_input(INPUT_GET, 'persons', FILTER_SANITIZE_STRING);										//Persons
			$_SESSION['persons'] = $persons;
		}
	}

	if (isset($_GET['price'])) 	{
		$price = filter_input(INPUT_GET, 'price', FILTER_SANITIZE_STRING);										//Persons
		$_SESSION['price'] = $price;
	} else {
		//$_SESSION['datein'] = DMA;
		$_SESSION['price'] = "";
	}


	if (isset($_GET['datein'])) {
		$datein = filter_input(INPUT_GET, 'datein', FILTER_SANITIZE_STRING);										//Datein
		$_SESSION['datein'] = $datein;
		$datein = strtotime($datein);
	} else {
		//$_SESSION['datein'] = DMA;
		$_SESSION['datein'] = "";
	}

	if (isset($_GET['dateout'])) 	{
		$dateout = filter_input(INPUT_GET, 'dateout', FILTER_SANITIZE_STRING);										//Dateout
		$_SESSION['dateout'] = $dateout;
		$dateout = strtotime($dateout);
	} else {
		//$_SESSION['dateout'] = DMA;
		$_SESSION['dateout'] = "";
	}

	if (isset($_GET['tipo'])) 	{
		$tipocasa = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);										//TipoCasa
		if ($tipocasa!=URL_SEARCH) {
			$tipocasa = GetIDTipusEstabliment ($tipocasa, $lng);
			$tipo = Query('tipus', 'tipo', 'tid', (int)$tipocasa);
		} else {
			$tipocasa = "all";
		}
		$_SESSION['tipocasa'] = $tipocasa;
	}

	if (isset($_GET['serid']))  $serid = explode(' ', $_GET['serid']);												//servicios

	if (isset($_GET['perid'])) 	$perid = explode(' ', $_GET['perid']);												//perfiles

	if (isset($_GET['instant']))  $instantBooking = true;												//instantBooking

	//Redirect para eliminar los /all indexados
	/*
	if (!isset($_GET['persons']) && $comarca=="all") {
		$tipo_url = urls_amigables(Query('tipus', 'title_'.$lng, 'tid', $tipocasa));
		$url= "/".$lng."/".$tipo_url."/".$provincia;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$url);
		die;
	}
	*/
}

// ------------------------------------------------------------------
// ----------------------- FIN: VARIABLES ---------------------------
// ------------------------------------------------------------------



// ------------------------------------------------------------------
// --------------------- INICIO: REDIRECTS --------------------------
// ------------------------------------------------------------------

if(isset($_POST['searchsubmit'])) {
	$url= $lng."/".$tipo_url."/".$provincia."/".$comarca."/pers:".$persons."/price:".$price;
	//if ($datein!=DMA && $dateout!=DMA)  $url .="/checkin:".$datein."/checkout:".$dateout; ---- FUERA DMA
	if ($datein!="" && $dateout!="")  $url .="/checkin:".$datein."/checkout:".$dateout;
	header("Location: ".$url);
	die;
}

if(isset($_POST['refinesearchsubmit'])) {
	$url= $lng."/".$tipo_url."/".$provincia."/".$comarca."/pers:".$persons."/price:".$price;

	//if ($datein!=DMA && $dateout!=DMA)  $url .="/checkin:".$datein."/checkout:".$dateout; ---- FUERA DMA

	if ($datein!="" && $dateout!="")  $url .="/checkin:".$datein."/checkout:".$dateout;

	if(isset($_POST['serid'])) {
		$url .="/services:";

		foreach ($_POST['serid'] as $serid) {
			$url .= $serid ."+";
		}

		$url = substr($url, 0, -1);
	}

	if(isset($_POST['perid'])) {
		$url .="/theme:";

		/*if($_GET['persons'] == none){
			$db->where('linked_pid',$_POST['perid']);
			$query=$db->getOne('landings','*');
			echo $db->getLastQuery();
			if($db->count > 0){
				$url=URL_BASE.$lng.'/landing/'.urls_amigables($query['url_'.$lng]).'-'.$query['id'];
				//header("Location: ".$url); die();

			}
		}else{*/
			foreach ($_POST['perid'] as $perid) {
				$url .= $perid ."+";
			}

			$url = substr($url, 0, -1);
		//}

	}

	if(isset($_POST['instantBooking'])) {
		$url .= "/instant:1";
	}


	header("Location: ".$url);
	die;
}


// ------------------------------------------------------------------
// ----------------- INICIO: FILTROS --------------------------------
// ------------------------------------------------------------------

// Cálculo de número de noches y número de dias con antelación
$numnights = DateDiff($datein, $dateout);
$numdaysant = DateDiff(date("d-m-Y"), $datein);

$where = explode("-", $_SESSION['where']);
$where_consulta = $_SESSION['where'];
$_SESSION['where'] = $where_consulta;
//echo $_SESSION['where'];
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

if (!empty($tipocasa) && $tipocasa!="all" ) {
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

// --------------- FILTRO DEL BUSQUEDA NOMBRE/REF ----------------
$filter_buscador="";

if (isset($_POST['buscador'])) {
	$palabra = strtolower($_POST['buscador']);
	$ref = strpos($palabra, 'sr-');

	if ($ref !== false) {
		$id_ref = explode("-", $palabra);
		if (Query('establiments', 'eid', 'eid', $id_ref[1])!=false) {

			header("location:".$lng."/".URL_CASA_RURAL."/".urls_amigables(Query('establiments', 'title', 'eid', $id_ref[1]))."-".$id_ref[1]);
			die;
		} else {
			$error = "No existe esta referencia";
		}
	} else {
		$filter_buscador = " AND title LIKE '%$palabra%' ";
	}
}


// --------------- FILTRO DE RESERVA INMEDIATA ----------------
$filter_instantBooking = "";

if (isset($instantBooking) && $instantBooking) {
	$filter_instantBooking = " AND RESERVA_INMEDIATA = 1 ";
}

// --------------- Guardamos toda la cadena de filtros -----------
if ($filter_buscador == ""){
	$filter = $filter_where . $filter_tipocasa . $filter_perfil . $filter_servicios . $filter_buscador . $filter_instantBooking;
	//echo 'filter:'. $filter;
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
//if(($datein == DMA) || ($dateout == DMA)) { // Ya no usamos el formato DMA cuando no hay fechas indicadas
if(($datein == "") || ($dateout == "")) {

	$num_establiment_disponibles = 0; //indicará el número de casas disponibles
	//$query = mysql_query("SELECT DISTINCT eid, title, subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter);
	$query = "SELECT DISTINCT rand() as rand, eid, title, subtitle_".$lng.", persons, persons_min,extra_quantity, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng,reserva_inmediata FROM establiments WHERE published = 1 ".$filter." ORDER BY reserva_inmediata DESC, persons ASC, rand";
	$rs_query=$db->rawQuery($query);
	//echo $db->getLastQuery();

	//while($rs = mysql_fetch_array($query)){ // Recorrido de cada establecimiento
	foreach($rs_query as $rs){
		if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= ($rs['persons']+$rs['extra_quantity'])))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
			$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", strtotime("next saturday")),'',$tipo,$persons),2);
			//Si no hay fecha introducida, comprobamos que hay dentro él número de personas
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
		//$query = mysql_query("SELECT DISTINCT eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter);
		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter."  ORDEr BY reserva_inmediata DESC,  persons ASC, rand";
		$rs_query=$db->rawQuery($query);
        //echo $query;
		//while($rs = mysql_fetch_array($query)){ // Recorrido de cada establecimiento
		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta
				$disponibilitat = 1; // flag que indicará si hay disponibilidad o no
				$date = $datein;

				while ($date < $dateout) { // Recorrido del intervalo de fechas
					$SQL  = "SELECT rp.eid, rp.date, SUM(r.persons*rp.availability) AS total ";
					$SQL .= "FROM rooms_prices rp, rooms r ";
					$SQL .= "WHERE rp.eid = ".$rs['eid']." AND r.eid = ".$rs['eid']." AND rp.rid = r.rid AND rp.date = '".date("Y-m-d", $date)."'";

					$query2 =$db->rawQuery($SQL); /*mysql_query($SQL)*/;
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
						$db->where('eid',$rs['eid']);
						$nitsmin_query=$db->get('establiments_nitsmin',null,'eid, date_start, date_end, nitsmin');
						//while($nm = mysql_fetch_array($nitsmin_query)) {
						foreach($nitsmin_query as $nm){
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
		//$query = mysql_query("SELECT DISTINCT eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 AND establimentcomplert = 1 ".$filter);
		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min,extra_quantity, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 AND establimentcomplert = 1 ".$filter."  ORDER BY reserva_inmediata DESC, persons ASC, rand";
		$rs_query=$db->rawQuery($query);
        //echo $query;
		//while($rs = mysql_fetch_array($query)){ // Recorrido de cada establecimiento
		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']+$rs['extra_quantity']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta

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

				// Si hay disponibilidad de la casa entera, la guardamos en el array
				if ($disponibilitat==1) {
					$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipo,$persons),2);

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
						$nitsmin_query = "SELECT eid, date_start, date_end, nitsmin, precio_bloque_dias, precio_extra_bloque_dias FROM establiments_nitsmin WHERE eid = " . $rs['eid'];
						$rs_nitsmin=$db->rawQuery($nitsmin_query);

						//while($nm = mysql_fetch_array($nitsmin_query)) {
						foreach($rs_nitsmin as $nm){
							$date_start = date('Y-m-d', strtotime($nm['date_start']));
							$date_end = date('Y-m-d', strtotime($nm['date_end']));
							$between=0;
							if (($datein >= $date_start) && ($datein < $date_end)) $between=1;
							if (($dateout >= $date_start) && ($dateout <= $date_end)) $between=1;
							if ($between==1) {
							    $nitsmin= $nm['nitsmin'];
                                $nitsmin_price = $nm['precio_bloque_dias'];
                                $nitsmin_price_extra = $nm['precio_extra_bloque_dias'];
                            }
						}


						$num_establiment_disponibles++;
						$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
						$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
						$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
						$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];
						$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
						$establiments[$num_establiment_disponibles]['daysmin'] = $nitsmin;
						$establiments[$num_establiment_disponibles]['nitsmin_price'] = $nitsmin_price;
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
		//$query = mysql_query("SELECT DISTINCT eid, title,subtitle_".$lng.", persons, persons_min, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng FROM establiments WHERE published = 1 ".$filter);
		$query = "SELECT DISTINCT rand() as rand, eid, title,subtitle_".$lng.", persons, persons_min, extra_quantity, bedrooms, bathrooms, description_small_".$lng.", daysmin, lid, tid, comid, pvid, gmap_lat, gmap_lng,reserva_inmediata FROM establiments WHERE published = 1 ".$filter."  ORDEr BY reserva_inmediata DESC, persons ASC, rand";
		$rs_query=$db->rawQuery($query);
        //echo $query;
		//while($rs = mysql_fetch_array($query)){ // Recorrido de cada establecimiento
		foreach($rs_query as $rs){
			if (($persons==0) || (($persons >= $rs['persons_min']) && ($persons <= $rs['persons']+$rs['extra_quantity']))) { // Se comprueba si en el establecimiento caben el número de personas que pide la consulta

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
							if($db->count<1) $disponibilitat=0;
							$date = strtotime("+1 day", $date);
						}
					} else { // Establecimiento entero y habitaciones
						while ($date < $dateout) { // Recorrido del intervalo de fechas
							//$query2 = mysql_query("SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'");
							$query2 ="SELECT eid, date, price, availability FROM establiments_prices WHERE availability=1 AND eid=".$rs['eid']." AND date = '".date("Y-m-d", $date)."'";
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

				   //funcion en includes/functions.php
			//realiza todo el calculo del precio por noche y por rango que este establecido en la tabla establiments_nitsmin, de acuerdo al rango de fecha seleccionado

				$bestprice=0;
				$nitsmin_price = 0;
				$numnights = DateDiff(date("Y-m-d",$datein), date("Y-m-d",$dateout)); 

                if ($numnights!= 0) {
                    $array_totales=CalcularPrecio(array('id'=>$rs['eid'],'personas'=>$persons,'fecha_entrada'=>$datein,'fecha_salida'=>$dateout));
                    //echo "array_totales"; print_r($array_totales);
                    $bestprice = $array_totales['bestprice'];
                    $nitsmin_price = $array_totales['nitsmin_price'];
                    $descripcion_precio = $array_totales['descripcion_precio'];
                }


					/*$bestprice = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", $datein),date("Y-m-d", $dateout),$tipoestabliment,$persons),2);
	                //echo '<br>Precio para '.$rs['eid'].': '.$bestprice;
					if ($price!="all") {
						list($pricemin, $pricemax) = explode('-', $price);
						if (($pricemin <= (int)$bestprice) && ((int)$bestprice <= $pricemax)) $fPrice = true; else $fPrice = false;
					} else {
						$fPrice = true;
					}*/

					 //echo '<br>Precio para '.$rs['eid'].': '.$bestprice; exit();

					if ($bestprice!= 0) { // Si el precio es diferente de 0, guardamos el establecimiento (id y precio) en el un Array
						// Comprobamos si hay un número mínimo de noches para unas fechas determinadas
						$nitsmin= $rs['daysmin'];

						//$nitsmin_query = mysql_query("SELECT eid, date_start, date_end, nitsmin FROM establiments_nitsmin WHERE eid = " . $rs['eid']);
						//$nitsmin_query = "SELECT eid, date_start, date_end, nitsmin, precio_bloque_dias, precio_extra_bloque_dias FROM establiments_nitsmin WHERE eid = " . $rs['eid'];
						//$rs_nitsmin=$db->rawQuery($nitsmin_query);

						//while($nm = mysql_fetch_array($nitsmin_query)) {
						/*foreach($rs_nitsmin as $nm){
							$date_start = date('Y-m-d', strtotime($nm['date_start']));
							$date_end = date('Y-m-d', strtotime($nm['date_end'])); 
							$between=0;
							if ((date('Y-m-d', strtotime($datein)) >= $date_start) && (date('Y-m-d', strtotime($datein)) < $date_end)) $between=1;
							if ((date('Y-m-d', strtotime($dateout)) >= $date_start) && (date('Y-m-d', strtotime($dateout)) <= $date_end)) $between=1;
							if ($between==1) {
							    $nitsmin= $nm['nitsmin'];
                                $nitsmin_price = $nm['precio_bloque_dias'];
                                $nitsmin_price_extra = $nm['precio_extra_bloque_dias'];
                            }
						}*/

						$num_establiment_disponibles++;
						$establiments[$num_establiment_disponibles]['eid'] = $rs['eid'];
						$establiments[$num_establiment_disponibles]['bestprice'] = $bestprice;
						$establiments[$num_establiment_disponibles]['title'] = $rs['title'];
						$establiments[$num_establiment_disponibles]['subtitle'] = $rs['subtitle_'.$lng];
						$establiments[$num_establiment_disponibles]['description_small'] = $rs['description_small_'.$lng];
						$establiments[$num_establiment_disponibles]['daysmin'] = $nitsmin;
						$establiments[$num_establiment_disponibles]['nitsmin_price'] = $nitsmin_price;
						$establiments[$num_establiment_disponibles]['descripcion_precio'] = $descripcion_precio;
						$establiments[$num_establiment_disponibles]['lid'] = $rs['lid'];
						$establiments[$num_establiment_disponibles]['tid'] = $rs['tid'];
						$establiments[$num_establiment_disponibles]['comid'] = $rs['comid'];
						$establiments[$num_establiment_disponibles]['pvid'] = $rs['pvid'];
						$establiments[$num_establiment_disponibles]['persons'] = $rs['persons']+$rs['allow_extra_persons'];
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


//echo '<pre>'; print_r($establiments);
// Hemos eliminado el RAND() del MySQL para evitar más tiempo de consulta y usamos shuffle() para ordenar las casas de manera aleatoria
//if ($num_establiment_disponibles>2) shuffle($establiments);


//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------- FIN: CONSULTA DE CASAS -----------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$nitsmin_global = 0;

if(($datein != "") && ($dateout != "")) {
	$date_entrada = date('Y-m-d', $datein);
	$date_salida = date('Y-m-d', $dateout);

	// TEXTO ADVERTENCIA
	//$txt_buscador_query = mysql_query("SELECT date_start,date_end,texto_buscador_".$lng." FROM texto_buscador");
	$texto_buscador_query=$db->get('texto_buscador',null,"date_start,date_end,texto_buscador_".$lng."");

	//while($txt_buscador = mysql_fetch_array($txt_buscador_query)) {
	foreach($texto_buscador_query as $txt_buscador){
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
	$nitsmin_global_query=$db->get('nitsmin',null,'date_start, date_end, nitsmin');
	//while($nmg = mysql_fetch_array($nitsmin_global_query)) {
	foreach($nitsmin_global_query as $nmg){
		$date_start = date('Y-m-d', strtotime($nmg['date_start']));
		$date_end = date('Y-m-d', strtotime($nmg['date_end']));
		$between=0;

		if (($date_entrada >= $date_start) && ($date_entrada < $date_end)) $between=1;
		if (($date_salida >= $date_start) && ($date_salida <= $date_end)) $between=1;

		if ($between==1) $nitsmin_global = $nmg['nitsmin'];
	}
}

// PAGINA DE LANGING O DE BÚSQUEDA
$landing = true;
if (isset($_GET['datein']) || isset($_GET['dateout'])) $landing = false;
if ($_GET['provincia']=='all' || $_GET['comarca']=='all') $landing = false;

// Saber si la página es una landing (necesario para saberlo provincia,comarca e idioma)
if(!empty($_GET['provincia']) && !empty($_GET['comarca']) && !isset($_GET['datein']) && !isset($_GET['dateout']) && !isset($_GET['price']) && !isset($_GET['persons']) && !isset($_GET['tipocasa']) && !isset($_GET['serid']) && !isset($_GET['perid'])&&  !isset($_GET['where'])){
	// Falta quitar la comprobación del tipo, ya que si es una landing no lo necesitamos

	$idComarca=GetIDComarca($_GET['comarca']);
	$db->where('linked_cid',$idComarca);
	$db->where('status',1);
	$query_2=$db->getOne('landings','*');
	if($db->count > 0){
		$url2=URL_BASE.$lng.'/landing/'.urls_amigables($query_2['url_'.$lng]).'-'.$query_2['id'];
		$_GET['id'] = urls_amigables($query_2['url_'.$lng]).'-'.$query_2['id'];
		//header("Location: ".$url); exit();
		include('landing.php');
		//include("includes/footer.php");
		exit();
	}

}
if(isset($_GET['persons']) && $_GET['persons'] == none && isset($_GET['perid'])){
	$db->where('linked_pid',$_GET['perid']);
	$query_2=$db->getOne('landings','*');
	if($db->count > 0){
		$url3=URL_BASE.$lng.'/landing/'.urls_amigables($query_2['url_'.$lng]).'-'.$query_2['id'];
		//header("Location: ".$url);
		include('landing.php');
		//include("includes/footer.php");
		exit();
	}
}
