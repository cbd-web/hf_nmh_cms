<?php
 
class S3_model extends CI_Model {
 	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }

	function S3_model($rep_id = '')
	{
		parent::__construct();

	}

	

	//+++++++++++++++++++++++++++
	//GET UPLOAD URL S3
	//++++++++++++++++++++++++++

	public function upload_gc_bucket($file, $path)
	{

		$out = system('gsutil cp '.$file.' gs://my-na-bucket-eu'.$path);
		return $out;

	}
	
	//+++++++++++++++++++++++++++
	//GET UPLOAD URL S3
	//++++++++++++++++++++++++++
	function getS3Details($s3Bucket, $region, $acl = 'private') {
	
		// Options and Settings
		//$awsKey = (!empty(getenv('AWS_ACCESS_KEY')) ? getenv('AWS_ACCESS_KEY') : AWS_ACCESS_KEY);
		//$awsSecret = (!empty(getenv('AWS_SECRET')) ? getenv('AWS_SECRET') : AWS_SECRET);
	
		$this->config->load('s3');
		$awsKey = $this->config->item('access_key');
		$awsSecret = $this->config->item('secret_key');
	
		$algorithm = "AWS4-HMAC-SHA256";
		$service = "s3";
		$date = gmdate("Ymd\THis\Z");
		$shortDate = gmdate("Ymd");
		$requestType = "aws4_request";
		$expires = "86400"; // 24 Hours
		$successStatus = "201";
		$url = "//{$s3Bucket}.{$service}.amazonaws.com";
	
		// Step 1: Generate the Scope
		$scope = [
			$awsKey,
			$shortDate,
			$region,
			$service,
			$requestType
		];
		$credentials = implode('/', $scope);
	
		// Step 2: Making a Base64 Policy
		$policy = [
			'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+6 hours')),
			'conditions' => [
				['bucket' => $s3Bucket],
				['acl' => $acl],
				['starts-with', '$key', ''],
				['starts-with', '$Content-Type', ''],
				['success_action_status' => $successStatus],
				['x-amz-credential' => $credentials],
				['x-amz-algorithm' => $algorithm],
				['x-amz-date' => $date],
				['x-amz-expires' => $expires],
			]
		];
		$base64Policy = base64_encode(json_encode($policy));
	
		// Step 3: Signing your Request (Making a Signature)
		$dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
		$dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
		$dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
		$signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);
	
		$signature = hash_hmac('sha256', $base64Policy, $signingKey);
	
		// Step 4: Build form inputs
		// This is the data that will get sent with the form to S3
		$inputs = [
			'Content-Type' => '',
			'acl' => $acl,
			'success_action_status' => $successStatus,
			'policy' => $base64Policy,
			'X-amz-credential' => $credentials,
			'X-amz-algorithm' => $algorithm,
			'X-amz-date' => $date,
			'X-amz-expires' => $expires,
			'X-amz-signature' => $signature
		];
	
		return compact('url', 'inputs');
	}




	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function upload_s3($path)
	{
		  //error_reporting(E_ALL); 
		  $filename = $path;
		  $base = BASE_URL.$path;
	      // Load Library
		  $this->load->library('s3');
		/**
		 * Put an object
		 *
		 * @param mixed $input Input data
		 * @param string $bucket Bucket name
		 * @param string $uri Object URI
		 * @param constant $acl ACL constant
		 * @param array $metaHeaders Array of x-amz-meta-* headers
		 * @param array $requestHeaders Array of request headers or content type as a string
		 * @param constant $storageClass Storage class constant
		 * @param constant $serverSideEncryption Server-side encryption
		 * @return boolean
		 */
		  //$input = $this->s3->inputResource(fopen($base, "rb"), filesize($base));
		  $input = $this->s3->inputFile($filename);
		  return $this->s3->putObject($input, 'mynamibia-eu', 'cms/'.$filename, 'public-read');
		  
		  
		  //var_dump($this->s3->putBucket('my.na', $this->s3->ACL_PUBLIC_READ));
		  
		  // List Buckets
		  //var_dump($this->s3->listBuckets());
	}

	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function exists_upload_s3($path)
	{
		  //error_reporting(E_ALL); 
		  $filename = $path;
		  $base = BASE_URL.$path;
	      // Load Library
		  $this->load->library('s3');
		/**
		 * Put an object
		 *
		 * @param mixed $input Input data
		 * @param string $bucket Bucket name
		 * @param string $uri Object URI
		 * @param constant $acl ACL constant
		 * @param array $metaHeaders Array of x-amz-meta-* headers
		 * @param array $requestHeaders Array of request headers or content type as a string
		 * @param constant $storageClass Storage class constant
		 * @param constant $serverSideEncryption Server-side encryption
		 * @return boolean
		 */
		  //$input = $this->s3->inputResource(fopen($base, "rb"), filesize($base));
		  //$input = $this->s3->inputFile($filename);
		  //return $this->s3->putObject($input, 'mynamibia-eu', $filename, 'public-read');
		  return $this->s3->getObjectInfo('mynamibia-eu', $filename, true);

	}

	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function delete_s3($path)
	{
		  //error_reporting(E_ALL); 
		  $filename = $path;
		  $base = BASE_URL.$path;
	      // Load Library
		  $this->load->library('s3');
		/**
		 * Put an object
		 *
		 * @param mixed $input Input data
		 * @param string $bucket Bucket name
		 * @param string $uri Object URI
		 * @param constant $acl ACL constant
		 * @param array $metaHeaders Array of x-amz-meta-* headers
		 * @param array $requestHeaders Array of request headers or content type as a string
		 * @param constant $storageClass Storage class constant
		 * @param constant $serverSideEncryption Server-side encryption
		 * @return boolean
		 */
		  //$input = $this->s3->inputResource(fopen($base, "rb"), filesize($base));
		  //$input = $this->s3->inputFile($filename);
		  //return $this->s3->putObject($input, 'mynamibia-eu', $filename, 'public-read');
		  return $this->s3->deleteObject('mynamibia-eu', $filename);

	}

 


}
