<?php
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];
$eid = $_POST['eid'];
$date_start = dateToMySQL($_POST['date_start']);
$date_end = dateToMySQL($_POST['date_end']);
$nitsmin = $_POST['nitsmin'];
$dia_entrada=$_POST['dia_entrada'];
$precio_extra=$_POST['precio_extra'];
$precio_extra_bloque_dias=$_POST['precio_extra_bloque_dias'];
$reserva_multiplo=$_POST['reserva_multiplo'];
$precio_bloque_dias=$_POST['precio_bloque_dias'];

if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- Borrar registre -----------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		//mysqli_query("DELETE FROM establiments_nitsmin WHERE enm = " . $id);
		$db->where('enm',$id);
		$db->delete('establiments_nitsmin');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE establiments_nitsmin SET "; 
			$SQL .= "eid = " . $eid . ", ";
			$SQL .= "date_start = '" . $date_start . "', ";
			$SQL .= "date_end = '" . $date_end . "', ";
			$SQL .= "nitsmin = " . $nitsmin . " ";			
			$SQL .= "WHERE enm = " . $id;

			mysqli_query($SQL);*/
			$data =array(
				'eid'=>$eid,
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'nitsmin'=>$nitsmin,
				'dia_entrada'=>$dia_entrada,
				'precio_bloque_dias'=>$precio_bloque_dias,
				//'precio_extra'=>$precio_extra,
				'reserva_multiplo'=>$reserva_multiplo
			);
			if($precio_extra!=null){
				$data['precio_extra']=$precio_extra;
                $data['precio_extra_bloque_dias'] = $precio_extra_bloque_dias;
			}
			$db->where('enm',$id);
			$db->update('establiments_nitsmin',$data);
		}

	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO establiments_nitsmin (eid, date_start, date_end, nitsmin) VALUES(";
			$SQL .= $eid.",";
			$SQL .= "'".$date_start."',";
			$SQL .= "'".$date_end."',";
			$SQL .= $nitsmin.")";
			
			mysqli_query($SQL);*/
			$data=Array(
				'eid'=>$eid,
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'nitsmin'=>$nitsmin,
				'dia_entrada'=>$dia_entrada,
                'precio_bloque_dias'=>$precio_bloque_dias,
				'reserva_multiplo'=>$reserva_multiplo
			);
			if($precio_extra!=null){
				$data['precio_extra'] = $precio_extra;
                $data['precio_extra_bloque_dias'] = $precio_extra_bloque_dias;
			}
			$db->insert('establiments_nitsmin',$data);

		}
	}
}

header("location: establimentsnitsmin.php");
?>