<?php

/* Name        : gap_api.php
*  Description : Codeigniter Library Class for Google Analytics API
*  Creation	   : 01/05/2011
*  Version	   : 0,2
*  Author	   : Nithin Meppurathu
*/

class Ga_php_api {



	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('ga_api');

		$client_id = $this->ci->config->item('client_id');

		// From the APIs console
		$client_email =  $this->ci->config->item('client_email');

		$key =  $this->ci->config->item('key_file');

		$key_pass = $this->ci->config->item('notasecret');


		// Analytics account id like, 'ga:xxxxxxx'
		$account_id = 'ga:78189620';

		include(BASE_URL.'application/libraries/GoogleAnalyticsAPI.class.php');
		$ga = new GoogleAnalyticsAPI('service');
		$ga->auth->setClientId($client_id); // From the APIs console
		$ga->auth->setEmail($client_email); // From the APIs console
		$ga->auth->setPrivateKey($key);

		$auth = $ga->auth->getAccessToken();

		// Try to get the AccessToken
		if ($auth['http_code'] == 200) {
			$accessToken = $auth['access_token'];
			$tokenExpires = $auth['expires_in'];
			$tokenCreated = time();
			var_dump($auth);
		} else {
			// error...
			echo 'No';
		}


		// Set the accessToken and Account-Id
		$ga->setAccessToken($accessToken);
		$ga->setAccountId($account_id);
		return $ga;

	}
	

}