<?php
include 'includes/checkuser.php';
include('includes/config.php');

$action = $_POST['action'];
$id = $_POST['id'];

$date_start = dateToMySQL($_POST['date_start']);
$date_end = dateToMySQL($_POST['date_end']);
print_r($date_start);

$texto_buscador_ca = ($_POST['texto_buscador_ca']);
$texto_buscador_es = ($_POST['texto_buscador_es']);
$texto_buscador_en = ($_POST['texto_buscador_en']);
$texto_buscador_fr = ($_POST['texto_buscador_fr']);

if(isset($action) || $_GET['action']!=""){
	
	// ----------------------- Borrar registre -----------------------
	if($_GET['action'] == "del"){
		$id = $_GET['id'];
		//mysqli_query("DELETE FROM texto_buscador WHERE id = " . $id);
		$db->where('id',$id);
		$db->delete('texto_buscador');
	}

	if($action == "process"){

		
	// ----------------------- Editar registre	-----------------------	
	if($id!="")
		{
			/*$SQL = "UPDATE texto_buscador SET ";
			$SQL .= "date_start = '" . $date_start . "', ";
			$SQL .= "date_end = '" . $date_end . "', ";		 
			$SQL .= "texto_buscador_ca = '" . $texto_buscador_ca . "', ";
			$SQL .= "texto_buscador_es = '" . $texto_buscador_es . "', ";
			$SQL .= "texto_buscador_en = '" . $texto_buscador_en . "', ";
			$SQL .= "texto_buscador_fr = '" . $texto_buscador_fr . "' ";
			$SQL .= "WHERE id = ".$id;

			mysqli_query($SQL);*/
			$data=Array(
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'texto_buscador_ca'=>$texto_buscador_ca,
				'texto_buscador_es'=>$texto_buscador_es,
				'texto_buscador_en'=>$texto_buscador_en,
				'texto_buscador_fr'=>$texto_buscador_fr
			);
			$db->where('id',$id);
			$db->update('texto_buscador',$data);
		}

	// ----------------------- Nou registre	-----------------------	
		else{
			
			/*$SQL = "INSERT INTO texto_buscador (date_start, date_end, texto_buscador_ca, texto_buscador_es, texto_buscador_en, texto_buscador_fr) VALUES(";
			$SQL .= "'".$date_start."',";
			$SQL .= "'".$date_end."',";
			$SQL .= "'".$texto_buscador_ca."',";
			$SQL .= "'".$texto_buscador_es."',";
			$SQL .= "'".$texto_buscador_en."',";
			$SQL .= "'".$texto_buscador_fr."')";
			
			mysqli_query($SQL);	*/
			$data=Array(
				'date_start'=>$date_start,
				'date_end'=>$date_end,
				'texto_buscador_ca'=>$texto_buscador_ca,
				'texto_buscador_es'=>$texto_buscador_es,
				'texto_buscador_en'=>$texto_buscador_en,
				'texto_buscador_fr'=>$texto_buscador_fr
			);
			$db->insert('texto_buscador',$data);
		}
	}
}

header("location: texto_buscador.php");
?>