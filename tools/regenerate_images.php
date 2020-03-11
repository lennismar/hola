<?php
include 'includes/config.php';
$debug = false;
define('MEMORY_TO_ALLOCATE',	'100M');
define('DEFAULT_QUALITY',		90);
define('CURRENT_DIR',			dirname(__FILE__));
define('CACHE_DIR_NAME',		'/imagecache/');
define('CACHE_DIR',				CURRENT_DIR . CACHE_DIR_NAME);
define('DOCUMENT_ROOT',			$_SERVER['DOCUMENT_ROOT']);
$docRoot = FILE_DIR.'establiments/'; //.$photo['filename']
set_time_limit(90);

echo '<h2>Creación de miniaturas</h2>';

//$db -> where("filename not like '%/%'");
$db -> orderBy("eid", "ASC");
$photos = $db -> get("establiments_images", 10);

if ($db->count > 0) {
    echo 'Moviendo un total de '.$db->count.' imagenes<br/>';

    foreach ($photos as $photo) {
        echo '<br>'.$photo['filename'].' de '.$photo['eid'];
        $ok = true;
        $actualizacion = false;
        $image = $photo['filename'];

        // Get the size and MIME type of the requested image
        $size = GetImageSize($docRoot.$image);
        $mime = $size['mime'];

        // Make sure that the requested file is actually an image
        if (substr($mime, 0, 6) != 'image/') {
            header('HTTP/1.1 400 Bad Request');
            echo 'Error: requested file is not an accepted type: '.$docRoot.$image;
            exit();
        }

        $width = $size[0];
        $height = $size[1];

        $maxWidth = 450;
        $maxHeight = 268;

        $color = false;

        // Ratio cropping
        $offsetX = 0;
        $offsetY = 0;


        // Setting up the ratios needed for resizing. We will compare these below to determine how to
        // resize the image (based on height or based on width)
        $xRatio = $maxWidth / $width;
        $yRatio = $maxHeight / $height;

        if ($xRatio * $height < $maxHeight) { // Resize the image based on width
            $tnHeight = ceil($xRatio * $height);
            $tnWidth = $maxWidth;
        } else // Resize the image based on height
        {
            $tnWidth = ceil($yRatio * $width);
            $tnHeight = $maxHeight;
        }

        // Determine the quality of the output image
        $quality = DEFAULT_QUALITY;

        // We store our cached image filenames as a hash of the dimensions and the original filename
        $resizedImageSource = $tnWidth.'x'.$tnHeight.'x'.$quality;
        if ($color) {
            $resizedImageSource .= 'x'.$color;
        }
        if (isset($_GET['cropratio'])) {
            $resizedImageSource .= 'x'.(string)$_GET['cropratio'];
        }
        $resizedImageSource .= '-'.$image;

        $resizedImage = md5($resizedImageSource);

        $resized = dirname(realpath($docRoot.$image)).'/thumb_'.basename($image);

        // We don't want to run out of memory
        ini_set('memory_limit', MEMORY_TO_ALLOCATE);

        // Set up a blank canvas for our resized image (destination)
        $dst	= imagecreatetruecolor($tnWidth, $tnHeight);

        // Set up the appropriate image handling functions based on the original image's mime type
        switch ($size['mime'])
        {
            case 'image/gif':
                // We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
                // This is maybe not the ideal solution, but IE6 can suck it
                $creationFunction	= 'ImageCreateFromGif';
                $outputFunction		= 'ImagePng';
                $mime				= 'image/png'; // We need to convert GIFs to PNGs
                $doSharpen			= FALSE;
                $quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
                break;

            case 'image/x-png':
            case 'image/png':
                $creationFunction	= 'ImageCreateFromPng';
                $outputFunction		= 'ImagePng';
                $doSharpen			= FALSE;
                $quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
                break;

            default:
                $creationFunction	= 'ImageCreateFromJpeg';
                $outputFunction	 	= 'ImageJpeg';
                $doSharpen			= TRUE;
                break;
        }

        // Read in the original image
        $src	= $creationFunction($docRoot . $image);

        if (in_array($size['mime'], array('image/gif', 'image/png')))
        {
            if (!$color)
            {
                // If this is a GIF or a PNG, we need to set up transparency
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }
        }

        // Resample the original image into the resized canvas we set up earlier
        ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);


        // Write the resized image to the cache
        $outputFunction($dst, $resized, $quality);


    }

}


