 <?php
	include 'includes/config.php';
	// Número de noches
    $id=$_POST['id'];
	$numnights = DateDiff($_POST['datein'], $_POST['dateout']); 
    $persons=$_SESSION['persons'];
    $datein=strtotime($_POST['datein']);
    $dateout=strtotime($_POST['dateout']);

	if($_POST['total'] == '0'){

		$db->where('availability',1);
    		$db->where('eid',$_POST['id']);
    		$db->where('date',date("Y-m-d", $_POST['datein']),'>=');
    		$db->where('date',date("Y-m-d", $_POST['dateout']),'<');
    		$query=$db->get('establiments_prices',null,'DISTINCT date, price');
    		foreach($query as $rs){
				$total = $total + round($rs['price'],2);
    		}
    	echo round($total,2);
	}
	else{

     
         $array_totales=CalcularPrecio(array('id'=>$id,'personas'=>$persons,'fecha_entrada'=>$datein,'fecha_salida'=>$dateout));
             // echo "array_totales"; print_r($array_totales);
              echo $array_totales['bestprice'];

            
        }
	

?>