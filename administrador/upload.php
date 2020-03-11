<?php
/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */
include 'includes/checkuser.php';
 
include 'includes/config.php';
echo 'aaaaaaaaaaaaa';
/*
 * CDN
 */

use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
echo 'b';
$profile = 'default';
$path = '/home/.aws/credentials';
echo 'c';
$provider = CredentialProvider::ini($profile, $path);
echo 'd';
$provider = CredentialProvider::memoize($provider);
echo 'e';
$s3 = new S3Client([
    //'profile' => 'default',
    'version' => 'latest',
    'region' => 'ams3',
    'endpoint' => 'https://ams3.digitaloceanspaces.com',
    'credentials' => $provider

]);
$bucket = 'cdn-rural';
echo 'f';

// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = '../images/uploads/establiments/';

//$cleanupTargetDir = false; // Remove old files
//$maxFileAge = 60 * 60; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
$eid = $_REQUEST['eid'];

// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

// Make sure the fileName is unique but only if chunking is disabled
if($fileName!=$_SESSION['unique_name']){
	$data= array('eid' => $eid, 'filename' => $eid.'/'.$fileName);
	$db->insert('establiments_images',$data);
    $_SESSION['unique_name']=$fileName;
}

$targetDir = $targetDir.'/'.$eid;

if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;
	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
		$count++;

	$fileName = $fileName_a . '_' . $count . $fileName_b;
}




// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir);


// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
		// Open temp file
		$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);


            $tempFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
            $result = $s3->putObject(array(
                'ACL' => 'public-read',
                'Bucket'=>$bucket,
                'Key' =>  'somrurals/images/uploads/establiments/' . $eid . '/' . $fileName,
                'SourceFile' => $tempFilePath,
                'StorageClass' => 'STANDARD'
            ));

			/*
			 *
			# Thumbnail creation
			 */
            define('MEMORY_TO_ALLOCATE',	'100M');
            define('DEFAULT_QUALITY',		90);
            define('CURRENT_DIR',			dirname(__FILE__));
            define('CACHE_DIR_NAME',		'/imagecache/');
            define('CACHE_DIR',				CURRENT_DIR . CACHE_DIR_NAME);
            define('DOCUMENT_ROOT',			$_SERVER['DOCUMENT_ROOT']);
            $actualizacion = false;
            $image = $photo['filename'];

            // Get the size and MIME type of the requested image
            $size = GetImageSize($targetDir . DIRECTORY_SEPARATOR . $fileName);
            $mime = $size['mime'];

            // Make sure that the requested file is actually an image
            if (substr($mime, 0, 6) != 'image/') {
                header('HTTP/1.1 400 Bad Request');
                echo 'Error: requested file is not an accepted type: '.$targetDir . DIRECTORY_SEPARATOR . $fileName;
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

            $resizedImageSource .= '-'.$image;

            $resizedImage = md5($resizedImageSource);

            $resized = dirname(realpath($targetDir . DIRECTORY_SEPARATOR . $fileName)).'/thumb_'.$fileName;

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
            $src	= $creationFunction($targetDir . DIRECTORY_SEPARATOR . $fileName);

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


            $tempFilePath = $targetDir . DIRECTORY_SEPARATOR . 'thumb_' . $fileName;
            $result = $s3->putObject(array(
                'ACL' => 'public-read',
                'Bucket'=>$bucket,
                'Key' =>  'somrurals/images/uploads/establiments/' . $eid . '/thumb_' . $fileName,
                'SourceFile' => $tempFilePath,
                'StorageClass' => 'STANDARD'
            ));





			
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');



?>
