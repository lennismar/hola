<?php
include 'includes/config.php';

// Comprobación de la existencia de la Valoración que se quiere rellenar. Si no, al index.php
if (isset($_GET['comcode'])) {
    $comcode = $_GET['comcode'];
    //$query = mysql_query("SELECT * FROM comments WHERE comcode = '$comcode' AND state = 0");
    $db->where('comcode',$comcode);
    $db->where('state',0);
    $query=$db->get('comments',null,'*');
    //if(!(mysql_fetch_array($query))) header("location: index.php");
    if($db->count <1) { header("location: ".URL_BASE.$_GET['lng'].'/'); exit(); }
}


$home=$db->getOne('page_home','*');

$meta_title= $home['meta_title_'.$lng];
$meta_description=$home['meta_description_'.$lng];
$meta_keywords=$home['meta_keywords_'.$lng];
$meta_index="";
$meta_follow="";

$og_site_name="Som Rurals";
$og_title=$home['meta_title_'.$lng];
$og_url="";
$og_image="";

include 'includes/head.php';


if (isset($_POST['enviar']) && $_POST['enviar'] == 1) {
	
	/*$SQL = "UPDATE comments SET "; 
	$SQL .= "netega = " . $_POST['netega'] . ", ";
	$SQL .= "tracte = " . $_POST['tracte'] . ", ";
	$SQL .= "entorn = " . $_POST['entorn'] . ", ";	
	$SQL .= "equipaments = " . $_POST['equipaments'] . ", ";	
	$SQL .= "relacio = " . $_POST['relacio'] . ", ";
	$SQL .= "somni = " . $_POST['somni'] . ", ";
	$SQL .= "natura = " . $_POST['natura'] . ", ";
	$SQL .= "sensacio = " . $_POST['sensacio'] . ", ";	
	$SQL .= "como = " . $_POST['como'] . ", ";
	$SQL .= "title_".$lng." = '" . addslashes($_POST['title']) . "', ";
	$SQL .= "comments_".$lng." = '" . addslashes($_POST['comments']) . "', ";
	$SQL .= "ipaddress = '" . $_SERVER['REMOTE_ADDR'] . "', ";
	$SQL .= "date = now(), ";
	$SQL .= "state=1 ";			
	$SQL .= "WHERE comcode = '" . $_GET['comcode'] . "'";
	$result = mysql_query($SQL);*/
    $data=Array(
        "netega"=> $_POST['netega'] ,
        "tracte"=> $_POST['tracte'] ,
        "entorn"=> $_POST['entorn'] ,  
        "equipaments"=> $_POST['equipaments'],    
        "relacio"=> $_POST['relacio'],
        "somni"=> $_POST['somni'],
        "natura"=> $_POST['natura'],
        "sensacio"=> $_POST['sensacio'], 
        "como" =>$_POST['como'],
        "title_".$lng."" => ($_POST['title']),
        "comments_".$lng."" => ($_POST['comments']),
        "ipaddress" => $_SERVER['REMOTE_ADDR'] ,
        "date" => date('Y-m-d'),
        "state"=>1
    );
    $db->where('comcode',$_GET['comcode']);
    $result = $db->update('comments',$data);
	$com_result = 1;

	if (!$result) $com_result = 0;
}

?>
	<meta name="robots" content="nofollow">   
</head>

<body>

<?php include("includes/tag-manager.php"); ?>

<div class="container-main" id="container">
    
		<?php include 'includes/header.php' ?>


<?php
	// Consultamos la id del establecimiento para imprimir el nombre
	//$query = mysql_query("SELECT eid FROM comments WHERE comcode = '$comcode'");
    $db->where('comcode',$comcode);
    $rs=$db->getOne('comments','eid');
	//if($rs = mysql_fetch_array($query)) $eid = $rs['eid'];
    if($db->count >0) $eid = $rs['eid'];
    $db->where ("eid", $eid);
    $establecimiento = $db->getOne ("establiments");
    $db->where ("lid", $establecimiento['lid']);
    $localidad = $db->getOne ("localitats");

?>
    <section class="wrapper">

        <div class="page-container-fixed-pad">

            <article class="col-pad content-custom-template">
                <div class="formulario">
                    <p id="migas-de-pan" style="height:20px"><a href="<?php echo $lng."/";?>" class="activo"><?php echo INICIO;?></a> > <span class="last"><?php echo VALORACIONES;?></span></p>
                    <br clear="left"/>
                    <h2><?php echo VALORA_ESTANCIA_EN ." ". ((empty($establecimiento['title_real']))?$establecimiento['title']:$establecimiento['title_real']).((empty($localidad) && empty($localidad['title']))?'':' ('.$localidad['title'].')'); ?></h2>
                    <?php

                    if (isset($_POST['enviar']) && $_POST['enviar'] == 1) {
                        echo "<div class='message'>";
                        if ($com_result == 1) {
                            echo VALORACIONES_RESULTADO_OK;
                        } else {
                            echo VALORACIONES_RESULTADO_KO;
                        }
                        echo "</div>";
                    } else {

                    ?>

                    <br />
                    <form id="" name="" action="<?php echo $lng."/".URL_VALORACIONES."/".$comcode;?>" method="post">
                        <input type="hidden" name="enviar" value="1" />
                        <h3><?php echo VALORACIONES_LIMPIEZA; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="netega" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="netega" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="netega" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="netega" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="netega" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_TRATO; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="tracte" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="tracte" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="tracte" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="tracte" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="tracte" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>

                        <br />
                        <h3><?php echo VALORACIONES_SERVICIOS; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="equipaments" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="equipaments" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="equipaments" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="equipaments" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="equipaments" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_ENTORNO; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="entorn" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="entorn" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="entorn" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="entorn" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="entorn" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_RELACION; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="relacio" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="relacio" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="relacio" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="relacio" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="relacio" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_SUEÑO; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="somni" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="somni" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="somni" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="somni" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="somni" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_NATURA; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="natura" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="natura" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="natura" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="natura" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="natura" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br />
                        <h3><?php echo VALORACIONES_SENSACION; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="sensacio" type="radio" value="5" /> <?php echo VALORACIONES_EXCELENTE; ?> &nbsp;&nbsp;
                        <input name="sensacio" type="radio" value="4" /> <?php echo VALORACIONES_BUENA; ?> &nbsp;&nbsp;
                        <input name="sensacio" type="radio" value="3" checked="checked"/> <?php echo VALORACIONES_NORMAL; ?> &nbsp;&nbsp;
                        <input name="sensacio" type="radio" value="2" /> <?php echo VALORACIONES_MALA; ?> &nbsp;&nbsp;
                        <input name="sensacio" type="radio" value="1" /> <?php echo VALORACIONES_MUYMALA; ?> &nbsp;&nbsp;
                        </p>
                        <br /><br />
                        <h3><?php echo VALORACIONES_COMO; ?></h3>
                        <p style="font-size:13px; font-weight:bold; line-height:18px;">
                        <input name="como" type="radio" value="5" checked="checked"/> <?php echo VALORACIONES_COMO_FAMILIA; ?> &nbsp;&nbsp;
                        <input name="como" type="radio" value="4" /> <?php echo VALORACIONES_COMO_AMIGOS; ?> &nbsp;&nbsp;
                        <input name="como" type="radio" value="3" /> <?php echo VALORACIONES_COMO_SOLO; ?> &nbsp;&nbsp;
                        <input name="como" type="radio" value="2" /> <?php echo VALORACIONES_COMO_PAREJA; ?> &nbsp;&nbsp;
                        <input name="como" type="radio" value="1" /> <?php echo VALORACIONES_COMO_EMPRESA; ?> &nbsp;&nbsp;
                        </p>

                        <br /><br />
                        <h3><?php echo TITULAR_COMENTARIO; ?></h3>
                        <input type="text" name="title" size="70" maxlength="70"/>
                        <br /><br />

                        <h3><?php echo COMENTARIOS; ?></h3>
                        <textarea name="comments" value="" cols="80" rows="10"></textarea>
                        <br /><br />
                        <input type="submit" class="btn btn--primary" value="<?php echo ENVIAR; ?>" />
                    </form>
                <?php } ?>                  
                </div>
            </article>
        </div>
    </section>
</div>
    
    <?php include 'includes/footer.php' ?>
</body>
</html>
