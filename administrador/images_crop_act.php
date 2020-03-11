<?php
include 'includes/checkuser.php';
include('includes/config.php');

$eid=$_POST['id'];

$targ_w = 500;
$targ_h = 298;	

$filename = $_POST['filename'];

$jpeg_quality = 100;

$src = URL_BASE . FILE_DIR . $_POST['pathimage'];
$img_r = imagecreatefromjpeg($src);
$dst_r = imagecreatetruecolor($targ_w, $targ_h);

$x = $_POST['x'];
$y = $_POST['y'];
$w = $_POST['w'];
$h = $_POST['h'];

imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);

delete_file(FILE_DIR . "establiments/" . $filename);

imagejpeg($dst_r, "../images/uploads/establiments/". $filename, $jpeg_quality);

//header("location: images_edit.php?eid=".$eid);
?>

<script>
	window.close();
</script>