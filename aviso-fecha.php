<?php
	include 'includes/config.php';

	$datein = date('Y-m-d', strtotime($_POST['datein']));
	$dateout = date('Y-m-d', strtotime($_POST['dateout']));
	$id=$_POST['eid'];
	$mensaje="";
		$query='SELECT * from establiments_nitsmin where eid='.$id.' and ("'.$datein.'">= date_start and "'.$datein.'"< date_end or "'.$dateout.'">= date_start and "'.$dateout.'"<= date_end )';
		$rs=$db->rawQueryOne($query);
		$resultado = $db->count;
		$query2='SELECT * from establiments where eid='.$id;
		$rs2=$db->rawQueryOne($query2);

		if($resultado > 0):
			echo  date('d-m-Y',strtotime($rs['date_start'])).'/'.date('d-m-Y',strtotime($rs['date_end'])).'/'.$rs['nitsmin'].'/'.$dia_semana[$rs['dia_entrada']].'/'.(($rs2['checkouttime'] != $rs2['checkouttime_weeks'])?$rs2['checkouttime_weeks']:'');
		endif;