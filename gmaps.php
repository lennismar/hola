<?php
require("includes/config.php");

header("Content-type: text/xml");

echo '<markers>'; // Inicio del XML, echo parent node

switch ($_GET['g']) {
	
    case "establiments": // ESTABLIMENTS
		
		//$establiments = $_GET['ids'];
		
		$establiments = $_SESSION['ids'];
		$establiments = array_recibe($establiments);
		$total_establiments = count($establiments);		
		
		foreach ($establiments as $establiment){
		  // ADD TO XML DOCUMENT NODE
		  echo '<marker ';
		  echo 'title="' . parseToXML($establiment['subtitle']) . '" ';
		  echo 'localitat="' . parseToXML(GetTitleLocalitat($establiment['lid'])) . '" ';
		  echo 'eid="' . $establiment['eid'] . '" ';
		  echo 'imagen="' . str_replace('/', '/thumb_', $establiment['imagen']) . '" ';
		  echo 'tipus="' . GetTitleTipusEstabliment($establiment['eid'],$lng) . '" ';
		  echo 'lat="' . $establiment['gmap_lat'] . '" ';
		  echo 'lng="' . $establiment['gmap_lng'] . '" ';
		  echo 'price="' . $establiment['bestprice'] . '" ';
		  echo 'bedrooms="' . $establiment['bedrooms'] . '" ';
		  echo 'bathrooms="' . $establiment['bathrooms'] . '" ';
		  echo 'persons="' . $establiment['persons_min'] . ' - '.$establiment['persons'].'" ';
		  echo 'url="'.$lng.'/'.URL_CASA_RURAL.'/'.urls_amigables($establiment['title']).'-'.$establiment['eid'].'" ';
		  echo '/>';			
		}
		
		break;

    case "recursos": // RECURSOS
	
		//$recursos = $_GET['ids'];
		
		$recursos = $_SESSION['ids'];
		
		$recursos = array_recibe($recursos);
		$total_recursos = count($recursos);
		$filter = "WHERE ";
		$i = 1;
		
		foreach ($recursos as $recurs){
			$filter.= " idrecurso = ".$recurs;
			if ($total_recursos!=$i) $filter.= " OR ";  
			$i++;
		}
		
		$query = "SELECT * FROM recursos ".$filter;
		//$result = mysqli_query($query);
		$result=$db->rawQuery($query);

		if (!$result) {
		  die('Invalid query: ' . $db->getLastError());
		}
		
		// Iterate through the rows, printing XML nodes for each
		//while ($row = @mysqli_fetch_assoc($result)){
		foreach($result as $row){
		  // ADD TO XML DOCUMENT NODE
		  echo '<marker ';
		  echo 'title="' . parseToXML($row['title_'.$lng]) . '" ';
		  echo 'smalldescription="' . parseToXML($row['smalldescription_'.$lng]) . '" ';
		  echo 'idrecurso="' . $row['idrecurso'] . '" ';
		  echo 'imagen="' . $row['image'] . '" ';
		  echo 'lat="' . $row['gmap_lat'] . '" ';
		  echo 'lng="' . $row['gmap_lng'] . '" ';
		  echo 'url="'.$lng."/".URL_RECURSOS_TURISTICOS."/".urls_amigables(GetTitleProvincia($row['pvid']))."/".urls_amigables(GetTitleComarca($row['comid']))."/".urls_amigables($row['title_'.$lng])."-".$row['idrecurso'].'" ';
		  echo '/>';
		}
		break;
}

		
echo '</markers>'; // Final del archivo XML
?>
