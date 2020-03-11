<?php
include 'includes/config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$establecimiento = new \stdClass;

if(isset($id) && !(empty($id))) {

    $db->where('eid', $id);
    $rs = $db->getOne(
        'establiments',
        "eid, title, subtitle_".$lng.", persons, persons_min, description_".$lng.", destacat_".$lng.", description_small_".$lng.", cond_towels, cond_kitchen, cond_firewood, fianza, bedrooms, bathrooms, videos, lid, pvid, comid, published, daysmin, daysant, establimentcomplert, user, userpsw, username, userlocked, ownername, email, address, phone, fax, gmap_lat, gmap_lng, home, recommended, checkintime,checkintimeto, checkouttime,checkouttimeto, checkouttime_weeks, seotitle, seowords, seodescription, hits, dateadded, datelastvisit, tid, extra_quantity, registro_turismo, reserva_inmediata, terms_".$lng
    );

    if(!empty($rs)) {

        $establecimiento->id = $rs['eid'];
        $establecimiento->url = URL_BASE . '/'.$lng."/".URL_CASA_RURAL."/".urls_amigables($rs['title'])."-".$rs['eid'];
        $establecimiento->image = CDN_BASE . 'images/uploads/establiments/'.ImagePrincipalEstabliment($rs['eid']);
        $establecimiento->price_per_nigh = round(GetBestPriceEstablimentPerNightPerPerson($rs['eid'],date("Y-m-d", strtotime("next saturday")),'','all',''),2);
        $establecimiento->instant_booking = $rs['reserva_inmediata'];
        $establecimiento->name = $rs['subtitle_es'];
        $establecimiento->description = substr(strip_tags($rs['description_es']), 0, 250);
        $establecimiento->location = GetTitleLocalitat($rs['lid']).' ('.GetTitleComarca($rs['comid']).' ,'.GetTitleProvincia($rs['pvid']).')';
        $establecimiento->minimum_stay = $rs['daysmin'];
        $establecimiento->capacity = $rs['persons'];
        $establecimiento->rooms = $rs['bedrooms'];
        $establecimiento->bathrooms = $rs['bathrooms'];

        $serveis_query = "SELECT serid, title_".$lng.", css FROM serveis WHERE css='pool' OR css='barbacue' OR css='wifi' OR css='pets' OR css='garden' OR css='terrace' OR css='air' OR css='fireplace' ORDER BY orden ASC";
        $rs_serveis = $db->rawQuery($serveis_query);
        $servicios = array();
        foreach($rs_serveis as $serveis){
            if (GetServeis($rs['eid'], $serveis['serid'])=='yes' && $cont<=3) {
                array_push($servicios, array($serveis['css'], $serveis['title_'.$lng]));
                $cont++;
            }
        }
        $establecimiento->services = $servicios;

    }

}

header('Content-Type: application/json');

echo json_encode($establecimiento, JSON_UNESCAPED_SLASHES);
exit();


// Datos de demo

echo '{
  "id": 206,
  "url": "http://www.somrurals.com/ca/casa-rural/sr-206-garrotxa-206",
  "image": "http://www.eresrural.com/images/establiments/thumbs/400_230_1513600699Habitacio%CC%81n%20-%20Apto.%20La%20Candaliega%201%20.jpg",
  "price_per_nigh": 40.5,
  "instant_booking": true,
  "name": "Apartamentos rurales con barbacoa en Garrotxa",
  "description": "Preciosa casa rural ubicada en ",
  "location": "Buda (Baix Ampurdá, Girona)",
  "minimum_stay": "Mínimo 3 noches",
  "capacity": 8,
  "rooms": 4,
  "bathrooms": 3,
  "services": [
    [
      "Piscina",
      "Piscina"
    ],
    [
      "Wifi",
      "Wifi Gratis\n"
    ]
  ]
}';