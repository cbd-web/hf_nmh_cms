<?php 
error_reporting(E_ALL); 
ini_set('memory_limit','512M');
set_time_limit(1000);

define('BASE_URL', '/home/cmsmy/public_html/');
//primary
// /home/mynamplt/public_html
// secondary
// /var/www/my.na/public_html/
//http://mynamibia.s3-website-us-east-1.amazonaws.com/

require 'aws-autoloader.php';
use Aws\S3\S3Client;
$out = '';
try {
	 //encryption password for server 2 lzfwxzzzphhd
	$client = S3Client::factory(array(
		'key'    => 'AKIAJDJ43LVB5PMFA2FA',
		'secret' => '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'
	));
	
	//$client->uploadDirectory(BASE_URL.'assets/documents/', 'mynamibia');
	
	$dir = BASE_URL.'backup/';
	$bucket = 'mynamibia-eu/cms/';
	$keyPrefix = 'backup/';
	$options = array(
		'params'      => array('ACL' => 'public-read'),
		'concurrency' => 20,
		'debug'       => true
	);
	 
	$out = $client->uploadDirectory($dir, $bucket, $keyPrefix, $options);

}catch(Exception $e) {
    $out = $e->getMessage();
	echo $out;
}


$to = "roland@my.na";
$subject = "CMS DB Backup Sync Amazon S3";
$message = "We have succesfully synced the CMS DB \n\n".$out;
$from = "no-reply@my.na";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";


?>