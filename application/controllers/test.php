<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function __construct() {
        parent::__construct();

    }




    function index() {
      
	  	echo 'Going Nowhere Slowly!';
	  
    }

	function oauth2callback() {

		echo 'Going Nowhere Slowly!';

	}
//+++++++++++++++++++++++++++
	//GA STATS FOR SERVICE APPS
	//++++++++++++++++++++++++++
	public function service2($start = '', $end = '')
	{
		$this->load->model('google_model');
		$this->load->view('admin/inc/header');
		$ga = $this->set_GA();
		// Set the default params. For example the start/end dates and max-results
		$defaults = array(
			'start-date' => date('Y-m-d', strtotime('-30 days')),
			'end-date'   => date('Y-m-d'),
		);
		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics' => 'ga:organicSearches',
			'dimensions' => 'ga:date,ga:keyword',
		);

		$data = $ga->query($params);


		foreach($data['rows'] as $row => $val){

			//echo $row.' '.$val;

			if(is_array($row)){

				foreach($row as $row4 => $val4){

					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 4 '.$row4 . ' => ' . $val4 . '<br />';
				}

			}
			if(is_array($val)){

				foreach($val as $row5 => $val5){

					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 5 '.$row5 . ' => ' . $val5 . '<br />';
				}

			}
			if(!is_array($val) && !is_array($row)){

				echo '&nbsp;&nbsp;&nbsp;&nbsp;Row 3 '.$row3 . ' => ' . $val3 . '<br />';
			}

		}

		var_dump($data['rows']);

	}
		//+++++++++++++++++++++++++++
	//GA STATS FOR SERVICE APPS
	//++++++++++++++++++++++++++
	public function service($start = '', $end = '')
	{
		$this->load->model('google_model');
		$this->load->view('admin/inc/header');
		$ga = $this->set_GA();
		// Set the default params. For example the start/end dates and max-results
		$defaults = array(
			'start-date' => date('Y-m-d', strtotime('-1 day')),
			'end-date' => date('Y-m-d'),
		);
		$ga->setDefaultQueryParams($defaults);

		$params = array(
			'metrics' => 'ga:sessions,ga:bounceRate,ga:bounces, ga:percentNewSessions,ga:newUsers, ga:sessionDuration, ga:avgPageLoadTime, ga:sessionsPerUser',
			'dimensions' => 'ga:date, ga:sessionDurationBucket,ga:sessionCount,ga:daysSinceLastSession',
		);

		$data = $ga->query($params);

		echo $data['totalsForAllResults']['ga:sessions'] .'<br />';

		var_dump($data);
		$x = 0;
		foreach($data as $row => $key){

			if($x == 0){

				echo '<br />////////////////////////////////////////<br />'.$key.'<br />';
				var_dump($row);
				echo '<br />////////////////////////////////////////<br />';
			}


			if(is_array($row))
			{

				foreach ($row as $row2 => $val2)
				{

					if (is_array($row2))
					{

						echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$row2 . ' => ' . $val2 . '<br />';
					}
					else
					{

						echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$row2 . ' => ' . $val2 . '<br />';
					}

					//$data['summary']->metrics->visitors = $val2;
				}

			}elseif(is_array($key)){

				foreach($key as $row3 => $val3){

					if(is_array($row3)){

						foreach($row3 as $row4 => $val4){

							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 4 '.$row4 . ' => ' . $val4 . '<br />';
						}

					}
					if(is_array($val3)){

						foreach($val3 as $row5 => $val5){

							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 5 '.$row5 . ' => ' . $val5 . '<br />';
						}

					}
					if(!is_array($val3) && !is_array($row3)){

						echo '&nbsp;&nbsp;&nbsp;&nbsp;Row 3 '.$row3 . ' => ' . $val3 . '<br />';
					}

				}


			}else{

				echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$row.' %> ' .$key.'<br />';
			}
			$x ++;

		}



		//LOAD CIRCLE STATS
		echo '
				<div class="circleStats">

					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem red">
							<i class="fa-icon-group"></i>

                        	<input type="text" value="'.$data['summary']->metrics->visitors.'" class="orangeCircle" />
                    	</div>
						<div class="box-small-title">Visitors this month</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem blue">
                        	<i class="fa-icon-user"></i>
                        	<input type="text" value="'.$data['summary']->metrics->newVisits.'" class="blueCircle" />
                    	</div>
						<div class="box-small-title">New Visitors</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem yellow">
                        	<i class="fa-icon-thumbs-down"></i>

							<span class="percent">%</span>
                        	<input type="text" value="'.round($data['summary']->metrics->entranceBounceRate,2).'" class="yellowCircle" />
                    	</div>
						<div class="box-small-title">Bounce Rate</div>
					</div>
					<div class="noMargin span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem pink">
                        	<i class="fa-icon-user-md"></i>
							<span class="percent">%</span>
                        	<input type="text" value="'.round($data['summary']->metrics->percentNewVisits,2).'" class="pinkCircle" />
                    	</div>
						<div class="box-small-title">% New Visits</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem green">
                        	<i class="fa-icon-dashboard"></i>

							<span class="percent">s</span>
                        	<input type="text" value="'.round($data['summary']->metrics->avgPageLoadTime,2).'" class="greenCircle" />
                    	</div>
						<div class="box-small-title">Average Page Load Time</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem lightorange">
                        	<i class="fa-icon-bar-chart"></i>


                        	<input type="text" value="'.round($data['summary']->metrics->pageviewsPerVisit,2).'" class="lightOrangeCircle" />
                    	</div>
						<div class="box-small-title">Pageviews/Visit</div>
					</div>

                </div>';

		$max_visitors = round( $data['summary']->metrics->visitors * 1.5);
		$max_visits = round( $data['summary']->metrics->newVisits * 1.5);

		$txt_visitors = $this->google_model->get_text_size($data['summary']->metrics->visitors);
		$txt_visits = $this->google_model->get_text_size($data['summary']->metrics->newVisits);

		echo '<script type="text/javascript">
			$(document).ready(function(){

					var divElement = $("div"); //log all div elements

					$(".greenCircle").knob({
						"min":0,
						"max":15,
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#b9e672",
						"dynamicDraw": true,
						"thickness": 0.2,
						"tickColorizeValues": true,
						"skin":"tron"
					})

					$(".orangeCircle").knob({
						"min":0,
						"max":'.$max_visitors.',
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#FA5833",
						"dynamicDraw": true,
						"thickness": 0.1,
						"tickColorizeValues": true,
						"skin":"tron"
					})

					$(".lightOrangeCircle").knob({
						"min":0,
						"max":10,
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#f4a70c",
						"dynamicDraw": true,
						"thickness": 0.2,
						"tickColorizeValues": true,
						"skin":"tron"
					})

					$(".blueCircle").knob({
						"min":0,
						"max":'.$max_visits.',
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#2FABE9",
						"dynamicDraw": true,
						"thickness": 0.1,
						"tickColorizeValues": true,
						"skin":"tron"
					})

					$(".yellowCircle").knob({
						"min":0,
						"max":100,
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#e7e572",
						"dynamicDraw": true,
						"thickness": 0.2,
						"tickColorizeValues": true,
						"skin":"tron"
					})

					$(".pinkCircle").knob({
						"min":0,
						"max":100,
						"readOnly": true,
						"width": 120,
						"height": 120,
						"fgColor": "#e42b75",
						"dynamicDraw": true,
						"thickness": 0.2,
						"tickColorizeValues": true,
						"skin":"tron"
					})


				});
				$(".orangeCircle").css("font-size", "'.$txt_visitors.'");
				$(".blueCircle").css("font-size", "'.$txt_visits.'");
			</script>';
		//Home Stats
		echo '<hr>

			<div class="row-fluid">

			<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Monthly Traffic Overview</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<div class="sparkLineStats">
	                        <ul class="unstyled thumbnails">
	                            <li>
									Visits:
									<span class="number">'.$data['summary']->metrics->visitors.'</span>
								</li>
	                            <li>

	                                New Visitors:
	                                <span class="number">'.$data['summary']->metrics->newVisits.'</span>
	                            </li>
	                            <li>
	                                Pageviews:
	                                <span class="number">'.$data['summary']->metrics->uniquePageviews.'</span>
	                            </li>
	                            <li>
	                                Pages / Visit:
	                                <span class="number">'.round($data['summary']->metrics->pageviewsPerVisit,2).'</span>
	                            </li>
	                            <li>
	                                Avg. Visit Duration:
	                                <span class="number">'.round($data['summary']->metrics->avgTimeOnSite,2).' s</span>
	                            </li>
	                            <li>
	                                Bounce Rate: <span class="number">'.round($data['summary']->metrics->entranceBounceRate,2).' %</span>
	                            </li>
	                            <li>
	                                % New Visits:
	                                <span class="number">'.round($data['summary']->metrics->percentNewVisits,2).' %</span>
	                            </li>
	                            <li>
	                                Average page load time (s):
	                                <span class="number">'.round($data['summary']->metrics->avgPageLoadTime,2).' s</span>
	                            </li>

	                        </ul>

	                    </div><!-- End .sparkStats -->
						</div>
				</div><!--/span-->
				</div>';



		$this->load->view('admin/inc/footer');
		/*// Example2: Get visits by country
		$params = array(
			'metrics' => 'ga:visits',
			'dimensions' => 'ga:country',
			'sort' => '-ga:visits',
			'max-results' => 30,
			'start-date' => '2015-01-01' //Overwrite this from the defaultQueryParams
		);
		$visitsByCountry = $ga->query($params);

		var_dump($visitsByCountry);*/

	}


	function set_GA(){

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


	//+++++++++++++++++++++++++++
	//GA STATS
	//++++++++++++++++++++++++++
	public function stats($start = '', $end = '')
	{
		/*		"private_key_id": "3e1ba3da844e06e653eec187a407d2fd65e46684",
		  "private_key": "-----BEGIN PRIVATE KEY-----\nMIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMz+nKYlFpIHtAdE\nog+OQsTUx4OpqwQZE89FJ+hpFMph48xRv7dILSeEAGNGpO1xrj74Q6v/RgtPiBTL\nV9ebavV7vyrs8n6UdsI6axB/eLl7ITV9ngSIwquVg4cjblm1BHjFxXTV7x/oJ9It\nCUfxvIgBM7kfcz6bs0RYaqdhIN+NAgMBAAECgYEAi3FW1Z288LDUwWzqYHKA8Ktc\n3C756du1IfUE5I82WUSlVEL3ipFKResA6IcRgYMm6CawwbrvxpnfE2YO5tcNtZ5X\nfx+V7bWbZhExHhBR2PNQCFgAlwUz8OOy9QS2josldMiabuSVTR/xKafPeqNu57Uz\nElGFtec/SbVuRCkOnXECQQD3XG42l9/KXawTRUwINYxyA3YDi3jZKz2zMG34938q\nor9dxPCZAXDi5Bjlwk3ZXMdsNCu6GxC7pEK+KLzsVSWXAkEA1CdluvzlPa0nFBBu\nwbtBZz3LAe8tc/HNzwH8wQL/X+MpB0HSr53C7alJo5Bf8z7pAi5vzqN0erVZXdjA\nFKCwewJAEfdMqfpt7qzPCrdFxnLdOIq3z5oZtOxHFvS1iBexzM71R0I+l15bbJ9U\nj5uFO/xZH6rKYkIE/Rv5HQaociHdEQJAANxwE0Q3gfqT8AbpDCxAZbTggA+CdbgD\nh9WQOxBSDQeVAQyJWGEhi2lmfR125jvZIkMh/Qq4zE60ICdjEDJexQJBALOiQs6m\nKtB7Ntky7YslbnsDJuYElk380jJQfkP/pYiYPZUmtLvMhOIduJnYcAxmL+pcIHHR\naaT68v8NDmGNfNs\u003d\n-----END PRIVATE KEY-----\n",
		  "client_email": "731395995035-noi1phl2laqp3ae4qpv9iudpeco9i21a@developer.gserviceaccount.com",
		  "client_id": "731395995035-noi1phl2laqp3ae4qpv9iudpeco9i21a.apps.googleusercontent.com",
		  "type": "service_account"*/
		// From the APIs console
		$client_id = '314831996097-kaked6h9n6c3tgtfu2fgb8kol0nat24m.apps.googleusercontent.com';

		// From the APIs console
		$client_secret = 'HiMxjb8DX1zBFGRVfB8VMLJU';

		// Url to your this page, must match the one in the APIs console
		$redirect_uri = 'https://cms.my.na/test/stats/';

		// Analytics account id like, 'ga:xxxxxxx'
		$account_id = 'ga:45120939';

		session_start();
		include(BASE_URL.'application/libraries/GoogleAnalyticsAPI.class.php');

		$ga = new GoogleAnalyticsAPI();
		$ga->auth->setClientId($client_id);
		$ga->auth->setClientSecret($client_secret);
		$ga->auth->setRedirectUri($redirect_uri);

		if (isset($_GET['force_oauth'])) {
			$_SESSION['oauth_access_token'] = null;
		}


		/*
		 *  Step 1: Check if we have an oAuth access token in our session
		 *          If we've got $_GET['code'], move to the next step
		 */
		if (!isset($_SESSION['oauth_access_token']) && !isset($_GET['code'])) {
			// Go get the url of the authentication page, redirect the client and go get that token!
			$url = $ga->auth->buildAuthUrl();
			header("Location: ".$url);
		}

		/*
		 *  Step 2: Returning from the Google oAuth page, the access token should be in $_GET['code']
		 */
		if (!isset($_SESSION['oauth_access_token']) && isset($_GET['code'])) {
			$auth = $ga->auth->getAccessToken($_GET['code']);
			if ($auth['http_code'] == 200) {
				$accessToken    = $auth['access_token'];
				$refreshToken   = $auth['refresh_token'];
				$tokenExpires   = $auth['expires_in'];
				$tokenCreated   = time();

				// For simplicity of the example we only store the accessToken
				// If it expires use the refreshToken to get a fresh one
				$_SESSION['oauth_access_token'] = $accessToken;
			} else {
				die("Sorry, something wend wrong retrieving the oAuth tokens");
			}
		}

		/*
		 *  Step 3: Do real stuff!
		 *          If we're here, we sure we've got an access token
		 */
		$ga->setAccessToken($_SESSION['oauth_access_token']);
		$ga->setAccountId($account_id);


		// Set the default params. For example the start/end dates and max-results
		$defaults = array(
			'start-date' => date('Y-m-d', strtotime('-1 month')),
			'end-date'   => date('Y-m-d'),
		);
		$ga->setDefaultQueryParams($defaults);

		$params = array(
			'metrics'    => 'ga:visits',
			'dimensions' => 'ga:date',
		);
		$visits = $ga->query($params);

		print "<pre>";
		var_dump($visits);
		print "</pre>";

	}


	public function stats2($start, $end)
	{
		include('google-api-php-client/src/Google/autoload.php'); // or wherever autoload.php is located

		$client = new Google_Client();
		$client->setApplicationName("My Namibia CMS");
		$client->setDeveloperKey("YOUR_APP_KEY");

		$service = new Google_Service_Books($client);
		$optParams = array('filter' => 'free-ebooks');
		$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

		foreach ($results as $item) {
			echo $item['volumeInfo']['title'], "<br /> \n";
		}
	}

	
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */