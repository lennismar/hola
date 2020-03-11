<?php
include 'includes/checkuser.php';
include('includes/config.php');

$eid=$_GET["eid"];
$filename=$_GET["filename"];
?>

<!DOCTYPE html>
<html>

	<head>
		<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">

		<!-- iPhone, iPad and Android specific settings -->	
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1;">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        
		<title>Editar Imatge</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<!-- Create an icon and splash screen for iPhone and iPad -->
		<link rel="apple-touch-icon" href="images/iOS_icon.png">
		<link rel="apple-touch-startup-image" href="images/iOS_startup.png"> 

		<link rel="stylesheet" type="text/css" href="css/all.css" media="screen">

		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
        
        <!-- Load JQuery -->		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>


		<script type="text/javascript" src="js/Jcrop/js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="js/Jcrop/css/jquery.Jcrop.css" type="text/css" />
        
		<script language="Javascript">
		/*
		jQuery(function(){
		
			jQuery('#cropbox').Jcrop({
				onSelect: updateCoords,
				boxWidth:700
			});
		
		});
		*/

		$(window).load(function(){
			var jcrop_api;
			var i, ac;
		
			initJcrop();
			
			function initJcrop()//{{{
			{		
				jcrop_api = $.Jcrop('#cropbox',{					
					boxWidth:800,
					aspectRatio: 500/298,
					onSelect: updateCoords
				});
			};
			//}}}


			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

		
			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		
		});
		</script>                 
</head>

<body>
<div id="content" style="width:850px; margin:20px;">

    <img src="<?php echo URL_BASE . FILE_DIR . "establiments/" . $filename;?>" id="cropbox">
	
    <form name="formulari" action="images_crop_act.php" method="post" onsubmit="return checkCoords();">   
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />

        <input type="hidden" id="filename" name="filename" value="<?php echo $filename;?>" />
        <input type="hidden" id="eid" name="eid" value="<?php echo $eid;?>" />
        
        <input type="hidden" id="pathimage" name="pathimage" value="<?php echo "establiments/" . $filename;?>"/>
		
        <br>
        <button class="button_colour orange round_all" style="clear:none" onClick="javascript:forms.formulari.submit();"><img width="24" height="24" alt="Guardar" src="images/icons/small/white/box_incoming.png"><span>Editar</span></button>            
        <button class="button_colour orange round_all" style="clear:none" onClick="window.close();"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
    </form>
</div>
</body>
</html>
