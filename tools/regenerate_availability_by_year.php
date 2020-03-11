<?php 
include 'includes/config.php';

set_time_limit(600);
//transactional_mail("juanjo.nieto@gmail.com", "asunto", "esto es una prueba de mensaje");
/*$home_query = mysql_query("SELECT * FROM page_home");
$home = mysql_fetch_array($home_query, MYSQL_ASSOC);*/



//$db->where ("eid > 505");
$properties = $db->get ("establiments", null, array('eid', 'title'));
echo '<br>'.$db->getLastQuery();
if ($db->count > 0)
    foreach ($properties as $property) {

        echo '<hr><br><strong>Procesando propiedad '.$property['title'].' ('.$property['eid'].')</strong>';


        $price_referencia_ = $db->rawQuery('select eid, price, count(*) from establiments_prices  where date like \'2018-%\' and eid = \''.$property['eid'].'\'group by eid, price order by count(*) desc limit 1');
        //var_dump($price_referencia_);

        $price_referencia = $price_referencia_[0]['price'];
        if(empty($price_referencia)) continue;
        echo '<br>Precio de referencia: '.$price_referencia;
        //exit();


        //continue;



        $last_price = 0;
        $last_availability = 1;
        //establiments_prices
        $start = strtotime('2019-01-01');
        $end = strtotime('2019-12-31');
        $contador = 0;
        do {
            echo '<br>'.date('Y-m-d',$start);
            $db->where ("date", date('Y-m-d',$start));
            $db->where ("eid", $property['eid']);
            $price = $db->getOne ("establiments_prices");
            echo '<br>'.$db->getLastQuery();
            if ($db->count > 0) {
                echo '<br>Existe registro para el eid '.$property['eid'].' para la fecha '.date('Y-m-d',$start);
            } else {
                echo '<br><strong>No</strong> existe registro para el eid '.$property['eid'].' para la fecha '.date('Y-m-d',$start).'<br/>Vamos a crearlo.';
                echo '<br>Encontrado registro del año anterior';
                $data = array('eid' => $property['eid'], 'date' => date('Y-m-d',$start), 'price' => $price_referencia, 'availability' => 1, 'managed_online' => 0);
                $db->insert ('establiments_prices', $data);
                echo '<br>'.$db->getLastQuery();
            }


            $start = strtotime("+ 1 day",$start);
            $contador++;
        } while ( $start <= $end);
        //exit();
    }


