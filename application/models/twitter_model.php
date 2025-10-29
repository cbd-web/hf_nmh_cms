<?php
 
class Twitter_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter(){
		error_reporting(E_ALL);
		if(!$bus_id = $this->input->get('bus_id')){

			$bus_id = 0;

			//die('Please supply a parameter');
		}
		if(!$screen_name = $this->input->get('screen_name')){

			$screen_name = '';

			//die('Please supply a parameter');
		}
		if(!$hashtag = $this->input->get('hashtag')){

			$hashtag = '';
		}
		if(!$mention = $this->input->get('mention')){

			$mention = '';
		}

		//LOAD CONFIGS
		$this->load->config('twitter');

		$settings = array(
			'oauth_access_token' =>  $this->config->item('oauth_access_token'),
			'oauth_access_token_secret' => $this->config->item('oauth_access_token_secret'),
			'consumer_key' => $this->config->item('consumer_key'),
			'consumer_secret' => $this->config->item('consumer_secret')

		);

		$lib = $this->load->library('TwitterAPIExchange', $settings);

		//GET MOST RECENT TWEET ENTRY
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->order_by('tweet_id', 'DESC');
		$q = $this->db->limit(1);
		$q = $this->db->get('twitter_feed');
		$latest_tweet = '';
		if($q->result()){

			$qrow = $q->row();

			$latest_tweet = date('Y-m-d H:i:s', strtotime($qrow->created_at));

			$url = 'https://api.twitter.com/1.1/search/tweets.json';
			$getfield = '?q=@'.$screen_name.'&since_id='.$qrow->tweet_id;
			$requestMethod = 'GET';

			$twitter = new TwitterAPIExchange($settings);
			$x = $twitter->setGetfield($getfield)
				->buildOauth($url, $requestMethod)
				->performRequest();

		}else{

			$url = 'https://api.twitter.com/1.1/search/tweets.json';
			$getfield = '?q=@'.$screen_name;
			$requestMethod = 'GET';

			$twitter = new TwitterAPIExchange($settings);
			$x = $twitter->setGetfield($getfield)
				->buildOauth($url, $requestMethod)
				->performRequest();


		}

		var_dump($x);
		//$x = json_decode(file_get_contents('http://music.my.na/twitter/index.php?q=%23NAMA2015'));

		if(count(json_decode($x)) > 0){

			var_dump(json_decode($x));
			//echo 'YES<br /><br />';
			foreach(json_decode($x) as $row => $val){

				foreach($val as $row2 => $val2){

					if(isset($val2->user)){
						var_dump($val2);

						/*echo '<br /><br />';
						echo $val2->text.'<br />';
						echo date('Y-m-d h:i:s', strtotime($val2->created_at)). '  =  '.$latest_tweet.'<br />';

						echo $val2->id_str.'<br />';
						echo $val2->user->location.'<br />';
						echo $val2->user->description.'<br />';

						echo $val2->entities->hashtags[0]->text.'<br />';*/

						//IF LATER THAN latestTweet
						if($latest_tweet < date('Y-m-d H:i:s', strtotime($val2->created_at))){

							//SKIP IF RETWEET
							if( substr($val2->text, 0,2) == 'RT'){


							}else{
								$hash = '';
								if($val2->entities->hashtags[0]->text != null){

									$hash = $val2->entities->hashtags[0]->text;
								}

								//INSERT DATABASE
								$data = array(

									'user_id' => $val2->user->id_str,
									'bus_id' => $bus_id,
									'name'    => $val2->user->name,
									'screen_name' => $val2->user->screen_name,
									'location'  => $val2->user->location,
									'description' => $val2->user->description,
									'profile_image_url' => $val2->user->profile_image_url,
									'hashtags'  => $hash,
									'created_at' =>  date('Y-m-d H:i:s', strtotime($val2->created_at)),
									'text'   => $val2->text,
									'tweet_id' => $val2->id_str,
									'o_created_at' => date('Y-m-d H:i:s')

								);

								$this->db->insert('twitter_feed', $data);

							}


							echo 'INSERTED'.'<br /><br />';
						}


					}



				}
				//var_dump($val->metadata);
				echo '<br /><br />';
				//echo $row . ' ' . $val;

			}


		}


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter_timeline(){
		error_reporting(E_ALL);
		if(!$bus_id = $this->input->get('bus_id')){

			$bus_id = 0;

			//die('Please supply a parameter');
		}
		if(!$screen_name = $this->input->get('screen_name')){

			$screen_name = '';

			//die('Please supply a parameter');
		}

		//LOAD CONFIGS
		$this->load->config('twitter');

		$settings = array(
			'oauth_access_token' =>  $this->config->item('oauth_access_token'),
			'oauth_access_token_secret' => $this->config->item('oauth_access_token_secret'),
			'consumer_key' => $this->config->item('consumer_key'),
			'consumer_secret' => $this->config->item('consumer_secret')

		);

		$lib = $this->load->library('TwitterAPIExchange', $settings);

		//GET MOST RECENT TWEET ENTRY
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->order_by('tweet_id', 'DESC');
		$q = $this->db->limit(1);
		$q = $this->db->get('twitter_feed');
		$latest_tweet = '';
		if($q->result()){

			$qrow = $q->row();

			$latest_tweet = date('Y-m-d H:i:s', strtotime($qrow->created_at));

			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name='.$screen_name.'&since_id='.$qrow->tweet_id;
			$requestMethod = 'GET';

			$twitter = new TwitterAPIExchange($settings);
			$x = $twitter->setGetfield($getfield)
				->buildOauth($url, $requestMethod)
				->performRequest();

		}else{

			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name='.$screen_name;
			$requestMethod = 'GET';

			$twitter = new TwitterAPIExchange($settings);
			$x = $twitter->setGetfield($getfield)
				->buildOauth($url, $requestMethod)
				->performRequest();


		}

		//print_r(json_decode($x));
		//$x = json_decode(file_get_contents('http://music.my.na/twitter/index.php?q=%23NAMA2015'));

		if(count(json_decode($x)) > 0){

			echo 'Count: '.count(json_decode($x)).' -- ';
			//var_dump(json_decode($x));
			//echo 'YES<br /><br />';
			foreach(json_decode($x) as $row => $val){
				//var_dump($row);

				echo $val->text.' ---  <br />';

				var_dump($val);

				$hash = '';
				if($val->entities->hashtags){

					$hash = $val->entities->hashtags[0]->text;
				}

				//INSERT DATABASE
				$data = array(


					'bus_id' => $bus_id,
					'name'    => $val->user->screen_name,
					'screen_name' => $val->user->screen_name,
					'location'  => $val->user->location,
					'description' => $val->user->description,
					'profile_image_url' => $val->user->profile_image_url,
					'hashtags'  => $hash,
					'entities'  => json_encode($val->entities),
					'created_at' =>  date('Y-m-d H:i:s', strtotime($val->created_at)),
					'text'   => $val->text,
					'tweet_id' => $val->id_str,
					'o_created_at' => date('Y-m-d H:i:s')

				);

				$this->db->insert('twitter_feed', $data);


			}


		}


	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter_v2(){

		//GET MOST RECENT TWEET ENTRY

		//$q = $this->db->order_by('bus_id', );
		$q = $this->db->order_by('created_at', 'DESC');
		$q = $this->db->limit(1);
		$q = $this->db->get('twitter_feed');
		$latest_tweet = '';

		//INITAIATE API
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
			'oauth_access_token' => "3096753159-7gFNOshDuooIJJho3wsdYNcqVyblUBYOnaoQ5qV",
			'oauth_access_token_secret' => "6foaiZ77nujfxFWA3DgvJZSKci00LCOFaL4JRrfOiSlDc",
			'consumer_key' => "nsFKAatV3WFnERMpi5gpLVFJI",
			'consumer_secret' => "FGnJ2ybl1fzuGYBO195okPP394UfV8hpWsSGMl2SwNGFgdTUNy"
		);

		$this->load->library('TwitterAPIExchange', $settings);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q=%23NAMA2015&result_type=recent&count=15';
		$requestMethod = 'GET';


		echo $this->twitterapiexchange->setGetfield($getfield)
			->buildOauth($url, $requestMethod)
			->performRequest();

		//echo $x;
		if($q->result()){

			$qrow = $q->row();
			$latest_tweet = date('Y-m-d h:i:s', strtotime($qrow->created_at));
//			/$x = json_decode(file_get_contents('http://music.my.na/twitter/index.php?q=#NAMA2015&since_id='.$qrow->tweet_id));
			//$x = file_get_contents('http://music.my.na/twitter/index.php?q=%23NAMA2015');
		}else{

			//$x = file_get_contents('http://music.my.na/twitter/index.php?q=%23NAMA2015');


		}

		var_dump($x);

		//$x = json_decode(file_get_contents('http://music.my.na/twitter/index.php?q=%23NAMA2015'));

		if(count(json_decode($x)) > 0){
			//echo 'YES<br /><br />';
			foreach(json_decode($x) as $row => $val){

				foreach($val as $row2 => $val2){

					if(isset($val2->user)){
						//var_dump($val2);

						/*echo '<br /><br />';
						echo $val2->text.'<br />';
						echo date('Y-m-d h:i:s', strtotime($val2->created_at)). '  =  '.$latest_tweet.'<br />';

						echo $val2->id_str.'<br />';
						echo $val2->user->location.'<br />';
						echo $val2->user->description.'<br />';

						echo $val2->entities->hashtags[0]->text.'<br />';*/

						//IF LATER THAN latestTweet
						if($latest_tweet < date('Y-m-d h:i:s', strtotime($val2->created_at))){

							//INSERT DATABASE
							$data = array(

								'user_id' => $val2->user->id_str,
								'name'    => $val2->user->name,
								'screen_name' => $val2->user->screen_name,
								'location'  => $val2->user->location,
								'description' => $val2->user->description,
								'profile_image_url' => $val2->user->profile_image_url,
								'hashtags'  => $val2->entities->hashtags[0]->text,
								'created_at' =>  date('Y-m-d h:i:s', strtotime($val2->created_at)),
								'text'   => $val2->text,
								'tweet_id' => $val2->id_str,
								'o_created_at' => date('Y-m-d h:i:s')

							);

							$this->db->insert('twitter_feed', $data);

							//echo 'INSERTED'.'<br /><br />';
						}


					}



				}
				//var_dump($val->metadata);
				//echo '<br /><br />';
				//echo $row . ' ' . $val;

			}


		}


	}

}