<?php
include 'includes/config.php';
$debug = false;
//somrurals\assets\img\bg-footer.png
echo '<h2>Trasladando fotos de establecimientos al CDN</h2>';

/*
Documentación de SDK
https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html
*/

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

//$credentials = new Aws\Credentials\Credentials('D5HAE4BPUS7MH4BCHJAB', 'J40ptJFdW089FomBpKK5pXv6Q5E/15ugb92bklm4V8w');

$s3 = new Aws\S3\S3Client([
    'profile' => 'default',
    'version' => 'latest',
    'region' => 'ams3',
    'endpoint' => 'https://ams3.digitaloceanspaces.com',
]);

$bucket = 'cdn-rural';


//$result = $s3->listBuckets();
//$result = $s3->listObjects(array('Bucket' => $bucket));

$tempFilePath = "somrurals/assets/img/bg-footer.png";
$result = $s3->putObject(array(
    'ACL' => 'public-read',
    'Bucket'=>$bucket,
    'Key' =>  'somrurals/images/bg-footer.png',
    'SourceFile' => $tempFilePath,
    'StorageClass' => 'STANDARD'
));
echo '<pre>'; print_r($result);

