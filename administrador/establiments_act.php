<?php
include 'includes/checkuser.php';
include('includes/config.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//echo '<pre>'; var_dump($_POST); echo '</pre>'; exit();

// Recollim les dades del formulari en variables
$action = $_POST['action'];
$id = $_POST['id'];
$title = ($_POST['title']);
$title_real=($_POST['title_real']);
$subtitle_es = ($_POST['subtitle_es']);
$subtitle_ca = ($_POST['subtitle_ca']);
$subtitle_en = ($_POST['subtitle_en']);
$subtitle_fr = ($_POST['subtitle_fr']);
$description_es = ($_POST['description_es']);
$description_ca = ($_POST['description_ca']);
$description_en = ($_POST['description_en']);
$description_fr = ($_POST['description_fr']);
$description_small_es = ($_POST['description_small_es']);
$description_small_ca = ($_POST['description_small_ca']);
$description_small_en = ($_POST['description_small_en']);
$description_small_fr = ($_POST['description_small_fr']);
$indications_es = ($_POST['indications_es']);
$indications_ca = ($_POST['indications_ca']);
$indications_en = ($_POST['indications_en']);
$indications_fr = ($_POST['indications_fr']);
$destacat_es = ($_POST['destacat_es']);
$destacat_ca = ($_POST['destacat_ca']);
$destacat_en = ($_POST['destacat_en']);
$destacat_fr = ($_POST['destacat_fr']);
$fianza = ($_POST['fianza']);
$videos = $_POST['videos'];
$bedrooms = $_POST['bedrooms'];
$bathrooms = $_POST['bathrooms'];
$lid = $_POST['lid'];
$published = $_POST['published'];
$daysmin = $_POST['daysmin'];
$daysant = $_POST['daysant'];
$establimentcomplert = $_POST['establimentcomplert'];
$persons = $_POST['persons'];
$persons_min = $_POST['persons_min'];

$personesAdicionals = (!empty($_POST['personesAdicionals'])) ? $_POST['personesAdicionals'] : 0;
$maxPersonesAdicionals = (!empty($_POST['MaxPersonesAdicionals'])) ? $_POST['MaxPersonesAdicionals'] : 0;
$preuPersonesAdicionals = (!empty($_POST['preuPersonAdicional'])) ? $_POST['preuPersonAdicional'] : 0;

$user = $_POST['user'];
$username = ($_POST['username']);
$userlocked = $_POST['userlocked'];
$ownername = ($_POST['ownername']);
//$ownername = ($_POST['ownername']);
$email = $_POST['email'];
$address = ($_POST['address']);
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$gmap_lat = $_POST['gmap_lat'];
$gmap_lng = $_POST['gmap_lng'];
$home = $_POST['home'];
$recommended = $_POST['recommended'];
$checkintime = $_POST['checkintime'];
$checkintimeto = $_POST['checkintimeto'];
$checkouttime = $_POST['checkouttime'];
$checkouttimeto = $_POST['checkouttimeto'];
$checkouttime_weeks = $_POST['checkouttime_weeks'];
$seotitle = ($_POST['seotitle']);
$seowords = ($_POST['seowords']);
$seodescription = ($_POST['seodescription']);
$tid = $_POST['tid'];
$terms_es = ($_POST['terms_es']);
$terms_ca = ($_POST['terms_ca']);
$terms_en = ($_POST['terms_en']);
$terms_fr = ($_POST['terms_fr']);

$reserva_inmediata=$_POST['reserva_inmediata'];
$senyal = $_POST['senyal'];
$userpsw = "";

$invoice_rao = ($_POST['invoice_rao']);
$invoice_NIF = $_POST['invoice_NIF'];
$invoice_address = ($_POST['invoice_address']);
$invoice_cp = ($_POST['invoice_cp']);
$invoice_poblacio = ($_POST['invoice_poblacio']);
$invoice_provincia = $_POST['invoice_provincia'];
$invoice_email = ($_POST['invoice_email']);
$invoice_send_address = ($_POST['invoice_send_address']);
$invoice_send_cp = ($_POST['invoice_send_cp']);
$invoice_send_poblacio = ($_POST['invoice_send_poblacio']);
$invoice_send_provincia = $_POST['invoice_send_provincia'];
$invoice_send_email = ($_POST['invoice_send_email']);

$registro_turismo = ($_POST['registro_turismo']);
$external_ical = ($_POST['external_ical']);

$comid = Query('localitats', 'comid', 'lid', $lid);
$pvid = Query('localitats', 'pvid', 'lid', $lid);

if (isset($_POST['cond_towels'])) $cond_towels = 1; else $cond_towels = 0;
if (isset($_POST['cond_kitchen'])) $cond_kitchen = 1; else $cond_kitchen = 0;
if (isset($_POST['cond_firewood'])) $cond_firewood = 1; else $cond_firewood = 0;


// Si el password s'ha modificat es codifica amb MD5
if ($_POST['userpsw']!='') $userpsw = md5($_POST['userpsw']);


// Verifiquem que aquesta página ha estat trucada desde el formulari
if(isset($action) || $_GET['action']!=""){
	
	// -------------------------------------------------------------------
	// ----------------------- BORRAR ESTABLIMENT ------------------------
	// -------------------------------------------------------------------
	
	/*
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		mysql_query("DELETE FROM tipus WHERE tid = " . $id);
	}
	*/
	
	// -------------------------------------------------------------------
	

	if($action == "process"){
	// -------------------------------------------------------------------
	// ----------------------- EDITAR ESTABLIMENT	----------------------
	// -------------------------------------------------------------------
	if($id!="")
		{

			if($personesAdicionals==0){ $maxPersonesAdicionals=0; $preuPersonesAdicionals=0;}
			$data=Array(
				'title'=>$title,
				'title_real'=>$title_real,
				'subtitle_ca'=>$subtitle_ca,
				'subtitle_es'=>$subtitle_es,
				'subtitle_en'=>$subtitle_en,
				'subtitle_fr'=>$subtitle_fr,
				'description_ca'=>$description_ca,
				'description_es'=>$description_es,
				'description_en'=>$description_en,
				'description_fr'=>$description_fr,
				'description_small_ca'=>$description_small_ca,
				'description_small_es'=>$description_small_es,
				'description_small_en'=>$description_small_en,
				'description_small_fr'=>$description_small_fr,
				'indications_ca'=>$indications_ca,
				'indications_es'=>$indications_es,
				'indications_en'=>$indications_en,
				'indications_fr'=>$indications_fr,
				'destacat_ca'=>$destacat_ca,
				'destacat_es'=>$destacat_es,
				'destacat_en'=>$destacat_en,
				'destacat_fr'=>$destacat_fr,
				'cond_towels'=>$cond_towels,
				'cond_kitchen'=>$cond_kitchen,
				'cond_firewood'=>$cond_firewood,
				'fianza'=>$fianza,
				'videos'=>$videos,
				'bedrooms'=>$bedrooms,
				'bathrooms'=>$bathrooms,
				'lid'=>$lid,
				'comid'=>$comid,
				'pvid'=>$pvid,
				'published'=>$published,
				'daysmin'=>$daysmin,
				'daysant'=>$daysant,
				'establimentcomplert'=>$establimentcomplert,
				'persons'=>$persons,
				'persons_min'=>$persons_min,
				'allow_extra_persons'=>$personesAdicionals,
				'extra_quantity'=>$maxPersonesAdicionals,
				'extra_price'=>$preuPersonesAdicionals,
				'user'=>$user,
				'username'=>$username,
				'userlocked'=>$userlocked,
				'ownername'=>$ownername,
				'email'=>$email,
				'address'=>$address,
				'phone'=>$phone,
				'fax'=>$fax,
				'gmap_lat'=>$gmap_lat,
				'gmap_lng'=>$gmap_lng,
				'home'=>$home,
				'recommended'=>$recommended,
				'checkintime'=>$checkintime,
				'checkintimeto'=>$checkintimeto,
				'checkouttime'=>$checkouttime,
				'checkouttimeto'=>$checkouttimeto,
                'checkouttime_weeks'=>$checkouttime_weeks,
				'seotitle'=>$seotitle,
				'seowords'=>$seowords,
				'seodescription'=>$seodescription,
				'tid'=>$tid,
				'terms_ca'=>$terms_ca,
				'terms_es'=>$terms_es,
				'terms_en'=>$terms_en,
				'terms_fr'=>$terms_fr,
				'reserva_inmediata'=>$reserva_inmediata,
				'senyal'=>$senyal,
				'invoice_rao'=>$invoice_rao,
				'invoice_NIF'=>$invoice_NIF,
				'invoice_address'=>$invoice_address,
				'invoice_cp'=>$invoice_cp,
				'invoice_poblacio'=>$invoice_poblacio,
				'invoice_provincia'=>$invoice_provincia,
				'invoice_email'=>$invoice_email,
				'invoice_send_address'=>$invoice_send_address,
				'invoice_send_cp'=>$invoice_send_cp,
				'invoice_send_poblacio'=>$invoice_send_poblacio,
				'invoice_send_provincia'=>$invoice_send_provincia,
				'invoice_send_email'=>$invoice_send_email,
				'registro_turismo'=>$registro_turismo,
				'external_ical'=>$external_ical
			);
				if ($userpsw != ''){
					
					$data['userpsw']=$userpsw;
				}

			/*
			$SQL .= "WHERE eid = " . $id;*/
			$db->where('eid',$id);
			//echo $SQL;
			//mysqli_query($SQL);
			$db->update('establiments',$data);
			
			// Guardar Serveis
			$db->where('eid',$id);
			//mysqli_query("delete from establiments_serveis where eid = " . $id);	
			$db->delete('establiments_serveis');
			//print_r($_POST['serid']);
            if(!empty($_POST['serid'])) {
                foreach ($_POST['serid'] as $serveis) {
                    if ($serveis != 0) {
                        //mysqli_query("insert into establiments_serveis (eid,serid) values (".$id.",".$serveis.")");
                        $data = Array('eid' => $id, 'serid' => $serveis);
                        $db->insert('establiments_serveis', $data);
                    }
                }
            }

			// Guardar Serveis Exteriors
			//mysqli_query("delete from establiments_serveis_ext where eid = " . $id);	
			$db->where('eid',$id);
			$db->delete('establiments_serveis_ext');

			if(!empty($_POST['serextid'])) {
                foreach ($_POST['serextid'] as $serveis) {
                    if ($serveis != 0) {
                        //mysqli_query("insert into establiments_serveis_ext (eid,serid) values (".$id.",".$serveis.")");
                        $data = Array('eid' => $id, 'serid' => $serveis);
                        $db->insert('establiments_serveis_ext', $data);
                    }
                }
            }


			// Guardar Perfils
			//mysqli_query("delete from establiments_perfils where eid = " . $id);
			$db->where('eid',$id);
			$db->delete('establiments_perfils');

            if(!empty($_POST['perid'])) {
                foreach ($_POST['perid'] as $perfils) {
                    if ($perfils != 0) {
                        //mysqli_query("insert into establiments_perfils (eid,perid) values (".$id.",".$perfils.")");
                        $data = Array('eid' => $id, 'perid' => $perfils);
                        $db->insert('establiments_perfils', $data);
                    }
                }
            }
		}
	// -------------------------------------------------------------------


	// -------------------------------------------------------------------
	// ----------------------- NOU ESTABLIMENT	--------------------------
	// -------------------------------------------------------------------	
		else{
			
			$data=Array(
				'title'=>$title,
				'title_real'=>$title_real,
				'subtitle_ca'=>$subtitle_ca,
				'subtitle_es'=>$subtitle_es,
				'subtitle_en'=>$subtitle_en,
				'subtitle_fr'=>$subtitle_fr,
				'description_ca'=>$description_ca,
				'description_es'=>$description_es,
				'description_en'=>$description_en,
				'description_fr'=>$description_fr,
				'description_small_ca'=>$description_small_ca,
				'description_small_es'=>$description_small_es,
				'description_small_en'=>$description_small_en,
				'description_small_fr'=>$description_small_fr,
				'indications_ca'=>$indications_ca,
				'indications_es'=>$indications_es,
				'indications_en'=>$indications_en,
				'indications_fr'=>$indications_fr,
				'destacat_ca'=>$destacat_ca,
				'destacat_es'=>$destacat_es,
				'destacat_en'=>$destacat_en,
				'destacat_fr'=>$destacat_fr,
				'cond_towels'=>$cond_towels,
				'cond_kitchen'=>$cond_kitchen,
				'cond_firewood'=>$cond_firewood,
				'fianza'=>$fianza,
				'videos'=>$videos,
				'bedrooms'=>$bedrooms,
				'bathrooms'=>$bathrooms,
				'lid'=>$lid,
				'comid'=>$comid,
				'pvid'=>$pvid,
				'published'=>$published,
				'daysmin'=>$daysmin,
				'daysant'=>$daysant,
				'establimentcomplert'=>$establimentcomplert,
				'persons'=>$persons,
				'persons_min'=>$persons_min,
				'allow_extra_persons'=>$personesAdicionals,
				'extra_quantity'=>$maxPersonesAdicionals,
				'extra_price'=>$preuPersonesAdicionals,
				'user'=>$user,
				'userpsw'=>$userpsw,
				'username'=>$username,
				'userlocked'=>$userlocked,
				'ownername'=>$ownername,
				'email'=>$email,
				'address'=>$address,
				'phone'=>$phone,
				'fax'=>$fax,
				'gmap_lat'=>$gmap_lat,
				'gmap_lng'=>$gmap_lng,
				'home'=>$home,
				'recommended'=>$recommended,
				'checkintime'=>$checkintime,
				'checkintimeto'=>$checkintimeto,
				'checkouttime'=>$checkouttime,
				'checkouttimeto'=>$checkouttimeto,
                'checkouttime_weeks'=>$checkouttime_weeks,
				'seotitle'=>$seotitle,
				'seowords'=>$seowords,
				'seodescription'=>$seodescription,
				'tid'=>$tid,
				'terms_ca'=>$terms_ca,
				'terms_es'=>$terms_es,
				'terms_en'=>$terms_en,
				'terms_fr'=>$terms_fr,
				'reserva_inmediata'=>$reserva_inmediata,
				'senyal'=>$senyal,
				'invoice_rao'=>$invoice_rao,
				'invoice_NIF'=>$invoice_NIF,
				'invoice_address'=>$invoice_address,
				'invoice_cp'=>$invoice_cp,
				'invoice_poblacio'=>$invoice_poblacio,
				'invoice_provincia'=>$invoice_provincia,
				'invoice_email'=>$invoice_email,
				'invoice_send_address'=>$invoice_send_address,
				'invoice_send_cp'=>$invoice_send_cp,
				'invoice_send_poblacio'=>$invoice_send_poblacio,
				'invoice_send_provincia'=>$invoice_send_provincia,
				'invoice_send_email'=>$invoice_send_email,
				'registro_turismo'=>$registro_turismo,
				'dateadded'=>date('Y-m-d H:i:s')
			);


			$new_id = $db->insert('establiments',$data);
			if(!$new_id) echo 'Fallo en la creación de casa: ' . $db->getLastError();
			//echo '-----'.$db->getLastQuery();

			// Guardar Serveis
            if(!empty($_POST['serid'])) {
                foreach ($_POST['serid'] as $serveis) {
                    if ($serveis != 0) {
                        //mysqli_query("insert into establiments_serveis (eid,serid) values (".$new_id.",".$serveis.")");
                        $data = Array('eid' => $new_id, 'serid' => $serveis);
                        $db->insert('establiments_serveis', $data);
                    }
                }
            }

			// Guardar Serveis Exteriors
            if(!empty($_POST['serextid'])) {
                foreach ($_POST['serextid'] as $serveis) {
                    if ($serveis != 0) {
                        //mysqli_query("insert into establiments_serveis_ext (eid,serid) values (".$new_id.",".$serveis.")");
                        $data = Array('eid' => $new_id, 'serid' => $serveis);
                        $db->insert('establiments_serveis_ext', $data);
                    }
                }
            }

			
			// Guardar Perfils			
            if(!empty($_POST['perid'])) {
                foreach ($_POST['perid'] as $perfils) {
                    if ($perfils != 0) {
                        //mysqli_query("insert into establiments_perfils (eid,perid) values (".$new_id.",".$perfils.")");
                        $data = Array('eid' => $new_id, 'perid' => $perfils);
                        $db->insert('establiments_perfils', $data);
                    }
                }
            }

            $_POST['id'] = $new_id;
		}
	// ---------------------------------------------------------------	
	}
}

header("location: establiments_edit.php?id=".$_POST['id']);
?>