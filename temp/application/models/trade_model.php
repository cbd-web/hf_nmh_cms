<?php

class Trade_model extends CI_Model
{

	function trade_model()
	{
		//parent::CI_model();

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_business_deals()
	{


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT RIBBON
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_product_ribbon($product_id, $extras, $featured, $listing_type, $start_price, $sale_price, $start_date, $end_date, $listing_date, $status, $size = '')
	{

		//IF SOLD
		if ($status == 'sold')
		{


			$str = '<div class="product_ribbon' . $size . '"><small>Not Available</small>ITEM HAS SOLD<span></span></div>';

			return $str;;

		}


		//IF AUCTION
		if ($listing_type == 'A')
		{


			//ENDING DATE
			$now = new DateTime("");
			$listE = new DateTime(date('Y-m-d H:i:s', strtotime($end_date)));
			$intervalE = $now->diff($listE);

			//HOURS
			$hours = $intervalE->h;
			$hours = $hours + ($intervalE->days * 24);
			//MINUTES
			$minutes = $intervalE->days * 24 * 60;
			$minutes += $intervalE->h * 60;
			$minutes += $intervalE->i;

			if (time() < strtotime($end_date))
			{

				if ($intervalE->days > 0)
				{

					$str = '<div class="product_ribbon' . $size . '"><small>Ends in ' . $intervalE->days . ' days</small> START BIDDING NOW<span></span></div>';

					return $str;

				}
				elseif ($minutes > 60)
				{
					$str = '<div class="product_ribbon' . $size . '"><small>Only ' . $intervalE->h . ' hours left</small>AUCTION ENDING SOON<span></span></div>';

					return $str;


				}
				else
				{
					$str = '<div class="product_ribbon' . $size . '"><small>Only ' . $minutes . ' minutes</small> HURRY ENDING SOON<span></span></div>';

					return $str;
				}
			}
			else
			{

				$str = '<div class="product_ribbon' . $size . '"><small>Closed</small> AUCTION HAS ENDED<span></span></div>';

				return $str;

			}
			//echo $intervalE->format("%r%a").'  '. $intervalE->days . " Days,  " . $minutes; 

		}
		else
		{


			//ARRAY FEATURES
			//SOLE MANDATE
			$arr = json_decode($extras);
			if (count($arr) > 0)
			{

				//SOLE MANDATE AND FEATURED
				if (array_key_exists("sole_mandate", $arr) && $featured == 'Y')
				{

					$str = '<div class="product_ribbon' . $size . '"><small class="clearfix">&nbsp;</small> FEATURED SOLE MANDATE<span></span></div>';

					return $str;

					//SOLE MANDATE	
				}
				elseif (array_key_exists("sole_mandate", $arr))
				{

					$str = '<div class="product_ribbon' . $size . '"><small class="clearfix">&nbsp;</small> SOLE MANDATE<span></span></div>';

					return $str;

				}

			}
			else
			{

				if ($featured == 'Y')
				{

					$str = '<div class="product_ribbon' . $size . '"><small  class="clearfix">&nbsp;</small> FEATURED<span></span></div>';

					return $str;

				}

			}

			//LISTING DATE
			$now = new DateTime("");
			$listD = new DateTime(date('Y-m-d h:i:s', strtotime($listing_date)));
			$intervalL = $now->diff($listD);

			//HOURS
			$hours = $intervalL->h;
			$hours = $hours + ($intervalL->days * 24);
			//MINUTES
			$minutes = $intervalL->days * 24 * 60;
			$minutes += $intervalL->h * 60;
			$minutes += $intervalL->i;


			//JUST LISTED
			if ($intervalL->days < 2)
			{

				$str = '<div class="product_ribbon' . $size . '"><small>' . $this->time_passed(strtotime($listing_date)) . '</small> LISTED TODAY<span></span></div>';

				return $str;
				//RECENTLY LISTED
			}
			elseif ($intervalL->days < 14)
			{

				$str = '<div class="product_ribbon' . $size . '"><small>' . $this->time_passed(strtotime($listing_date)) . '</small> RECENTLY LISTED<span></span></div>';

				return $str;

			}


		}


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TIME PAST
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function time_passed($timestamp)
	{
		//type cast, current time, difference in timestamps
		$timestamp = (int) $timestamp;
		$current_time = time();
		$diff = $current_time - $timestamp;

		//intervals in seconds
		$intervals = array(
			'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
		);

		//now we just find the difference
		if ($diff == 0)
		{
			return 'just now';
		}

		if ($diff < 60)
		{
			return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
		}

		if ($diff >= 60 && $diff < $intervals['hour'])
		{
			$diff = floor($diff / $intervals['minute']);

			return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
		}

		if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
		{
			$diff = floor($diff / $intervals['hour']);

			return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
		}

		if ($diff >= $intervals['day'] && $diff < $intervals['week'])
		{
			$diff = floor($diff / $intervals['day']);

			return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
		}

		if ($diff >= $intervals['week'] && $diff < $intervals['month'])
		{
			$diff = floor($diff / $intervals['week']);

			return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
		}

		if ($diff >= $intervals['month'] && $diff < $intervals['year'])
		{
			$diff = floor($diff / $intervals['month']);

			return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
		}

		if ($diff >= $intervals['year'])
		{
			$diff = floor($diff / $intervals['year']);

			return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
		}
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT MAP
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_product_map($product_id, $extras)
	{

		$arr = (array) json_decode($extras);

		$lat = '';
		$long = '';
		if (array_key_exists("toggle_map", $arr))
		{

			//GET LAT AND LONG
			foreach ($arr as $key => $value)
			{

				if ($key == 'prop_lat')
				{

					$lat = $value;

				}
				if ($key == 'prop_lon')
				{

					$long = $value;

				}
			}

			//
			foreach ($arr as $key1 => $value1)
			{
				//TOGGLE MAP SET TO Y
				if ($key1 == 'toggle_map' && $value1 == 'Y')
				{

					$result = '
						<div class="white_box padding10">
							<div id="map-canvas" class="clearfix" style="height:300px"></div>
							<script data-cfasync="false" type="text/javascript">
									var geocoder;
									var map;
									function initialize() {
					
										  geocoder = new google.maps.Geocoder();
										  var myLatlng = new google.maps.LatLng( ' . $lat . ' , ' . $long . ' );
										 
										  var myOptions = {
											zoom:14,
											center: myLatlng,
											mapTypeControl: true,
											mapTypeId: google.maps.MapTypeId.ROADMAP,
											scrollwheel: false,
											zoomControl: true,
											zoomControlOptions: {
												style: google.maps.ZoomControlStyle.LARGE,
												position: google.maps.ControlPosition.LEFT_CENTER
											},
											streetViewControl:true,
											scaleControl:false
										  }
										  var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
											
										  var marker = new google.maps.Marker({
												position: myLatlng,
												map: map,
												animation: google.maps.Animation.DROP
												
								
										  });
											  
								
									}
											
									
							  </script>
							  <script src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&callback=initialize" type="text/javascript"></script>
						 </div>	  
							  ';

					return $result;

				}


			}


		}

	}


	//+++++++++++++++++
	//LOAD SUB NAV
	//+++++++++++++++++

	public function load_group_filter($id)
	{

		if ($id == '3408')
		{

			$this->load->view('trade/inc/filter/filter_property');

		}
		else
		{
			$this->load->view('trade/inc/filter/filter_all');

		}


	}

	//+++++++++++++++++++++++++++
	//POPULATE CITIES FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_city($city_current)
	{

		$city_current = $this->decode_url($city_current);
		$this->db->order_by('MAP_LOCATION', 'ASC');
		$query = $this->db->get('a_map_location');

		if ($query->num_rows() > 0)
		{


			echo '<select name="location" id="location_slct" class="span12">
							<option value="national">National</option>';

			foreach ($query->result() as $row)
			{

				$city = $row->MAP_LOCATION;//ucwords(filter_var(utf8_encode($row->MAP_LOCATION), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));

				$city_id = $row->ID;

				if (ucwords($city_current) == $city)
				{
					$str = 'selected="selected"';
				}
				else
				{
					$str = '';
				}

				echo '<option value="' . $row->MAP_LOCATION . '" ' . $str . ' >' . $city . '</option>';


			}
			echo '</select> 
					';
		}
		else
		{

			return;
		}

	}


	//+++++++++++++++++++++++++++
	//GET LOCATIO N FRO ID
	//++++++++++++++++++++++++++
	public function get_location_value($id)
	{

		$this->db->where('ID', $id);
		$query = $this->db->get('a_map_location');

		if ($query->num_rows() > 0)
		{

			$row = $query->row();

			return $row->MAP_LOCATION;

		}
		else
		{

			return 'n';
		}

	}

	//+++++++++++++++++++++++++++
	//POPULATE FILTERS PER CATEGORY
	//++++++++++++++++++++++++++
	public function get_categories_select($type, $id, $current_id)
	{

		if ($type == 'cat_id')
		{

			$test = $this->db->where('main_cat_id', '0');

		}
		if ($type == 'main_cat_id')
		{

			$test = $this->db->where($type, $id);
			$test = $this->db->where('sub_cat_id', '0');

		}
		if ($type == 'sub_cat_id')
		{

			$test = $this->db->where($type, $id);
			$test = $this->db->where('sub_sub_cat_id', '0');

		}
		if ($type == 'sub_sub_cat_id')
		{

			$test = $this->db->where($type, $id);
			$test = $this->db->where('sub_sub_sub_cat_id', '0');


		}

		$test = $this->db->get('product_categories');

		if ($test->num_rows() > 0)
		{
			echo '
					<option value="0">Please Select</option> 
			';
			foreach ($test->result() as $row)
			{

				$cat_id = $row->cat_id;

				if ($cat_id == $current_id)
				{

					echo '<option value="' . $cat_id . '" selected="selected">' . htmlentities($row->category_name) . '</option>';

				}
				else
				{

					echo '<option value="' . $cat_id . '">' . htmlentities($row->category_name) . '</option>';

				}


			}

			echo '

			';

		}
		else
		{


			echo '<option value="0">No options</option>';

		}

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+ASK SELLER QUESTION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function ask_question()
	{

		if ($this->session->userdata('id'))
		{

			$this->load->library('user_agent');
			//TEST IF ROBOT
			if ($this->agent->is_robot())
			{
				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Sorry, only humans can submit an enquiry!</div>';

				//IS HUMAN
			}
			else
			{

				$msg = $this->input->post('msg', true);
				$captcha = $this->input->post('captcha', true);
				$x = $this->input->post('x', true);
				$y = $this->input->post('y', true);
				$product_id = $this->input->post('product_id', true);
				$product_title = $this->input->post('product_title', true);
				$client_id = $this->input->post('client_id', true);
				$bus_id = $this->input->post('bus_id', true);
				$sender_client_id = $this->session->userdata('id');
				$name = $this->session->userdata('u_name');


				//VALIDATE INPUT
				if (($x + $y) != $captcha)
				{
					$val = false;
					$error = 'Your security answer did not match. What is ' . $x . ' + ' . $y;

				}
				else
				{
					$val = true;
				}

				//IF VALIDATED
				if ($val == true)
				{

					//GET SENDER EMAIL
					$this->db->where('ID', $sender_client_id);
					$this->db->from('u_client');
					$sender_query = $this->db->get();
					$sender_row = $sender_query->row_array();
					$sender_email = $sender_row['CLIENT_EMAIL'];
					$sender_name = $sender_row['CLIENT_NAME'] . ' ' . $sender_row['CLIENT_SURNAME'];
					//VALIDATE IF PRODUCT BELONGS TO BUSINESS
					if ($bus_id != 0)
					{


						$this->db->where('ID', $bus_id);
						$this->db->from('u_business');
						$queryB = $this->db->get();
						$rowB = $queryB->row_array();

						$query = $this->db->query("SELECT u_client.*, products.*, product_images.img_file, product_extras.extras
													,group_concat(client.CLIENT_EMAIL) as emails
													FROM u_client
						  							JOIN products ON u_client.ID = products.client_id
													LEFT JOIN u_business ON u_business.ID = products.bus_id
						  							LEFT JOIN i_client_business ON i_client_business.BUSINESS_ID = u_business.ID
													LEFT JOIN u_client as client ON client.ID = i_client_business.CLIENT_ID
						  							LEFT JOIN product_extras ON products.product_id = product_extras.product_id
													LEFT JOIN product_images ON products.product_id = product_images.product_id
													WHERE products.product_id = '" . $product_id . "'");
						$row = $query->row_array();

						$mails = array();
						$bemail = array('email' => $rowB['BUSINESS_EMAIL']);
						array_push($mails, $bemail);
						//INDONGO TOYOTA SEND EMAIL TO ALL AGENTS
						if ($bus_id == 5959)
						{


							$mA = explode(',', $row['emails']);
							if (is_array($mA))
							{


								foreach ($mA as $mar)
								{

									$temp = array('email' => $mar);
									array_push($mails, $temp);

								}

							}
							else
							{
								$mailsT = array('email' => $row['CLIENT_EMAIL']);
								array_push($mails, $mailsT);

							}

						}
						else
						{

							$mailsT = array('email' => $row['CLIENT_EMAIL']);
							array_push($mails, $mailsT);

						}

						//var_dump($mails);
						$emailTO = $mails;

						$reference = '';
						$extras = json_decode($row['extras']);

						if (count($extras) > 0)
						{


							if ($extras->agency != '')
							{

								$reference = $extras->agency;

							}


						}
						$subject = 'New Question regarding ' . $product_title . ' ' . $reference;
					}
					else
					{

						$query = $this->db->query("SELECT u_client.*, products.*, product_images.img_file, product_extras.extras FROM u_client
						  							JOIN products ON u_client.ID = products.client_id
						  							LEFT JOIN product_extras ON products.product_id = product_extras.product_id
													LEFT JOIN product_images ON products.product_id = product_images.product_id
													WHERE products.product_id = '" . $product_id . "'");
						$row = $query->row_array();
						$emailTO = array(array('email' => $row['CLIENT_EMAIL']));

						$reference = '';
						$extras = json_decode($row['extras']);

						if (count($extras) > 0)
						{


							if ($extras->agency != '')
							{

								$reference = $extras->agency;

							}


						}
						$subject = 'New Question regarding ' . $product_title . ' ' . $reference;

					}
					$img_str = '';
					if ($row['img_file'] != '')
					{

						$img_str .= '<img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row['img_file'] . '&w=190&h=130" />';


					}
					//BUILD BODY
					$body = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
									You have received a new question regarding your product ' . $product_title . ' <strong>(Ref: ' . $reference . ')</strong> listed on My Namibia&trade; trade.<br /><br />
								    <table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px">
											 <tr>
												<td style="width:30%">' . $img_str . '</td>
												<td style="width:25%;vertical-align: top;" valign="top"><strong>Question:</strong></td>
												<td style="width:45%;vertical-align: top;" valign="top"><p><em>' . $msg . '</em></p>
																	 
												</td>					  
											</tr>

								    </table>
									<br /><br />
									<a style="text-decoration:none" href="' . site_url('/') . 'product/' . $product_id . '/">View ' . $product_title . '</a><br />
									Please answer the question by viewing it in your Buy and Sell section in the dashboard.<br /><br />
									Have a !tna day!<br />
									My Namibia';

					$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news', $data_view, true);

					$fromEMAIL = 'no-reply@my.na';
					$fromEMAIL = $sender_email;
					$fromNAME = 'My Namibia Trade';
					$fromNAME = $sender_name;
					$TAG = array('tags' => 'trade_question');


					//SEND EMAIL LINK
					$this->load->model('email_model');
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
					//send_mail($HTML, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG)

					//IF CLIENT MOBILE VERIFIED
					if ($row['VERIFIED'] == 'Y')
					{

						//SEND SMS
						$msgSMS = 'A question has been asked about listing ' . $this->shorten_string($product_title, 3) . '. Please answer it from your product dashboard. http://my.na/u/p/' . $product_id;

						//LOAD LIBRARIES FOR API AND SEND SMS
						$this->load->library('curl');
						$this->load->library('rest', array(
							'server'    => 'http://sms.my.na/api/sms/',
							'http_user' => 'myna_ma$ster',
							'http_pass' => '#$5_jh56_hdgd',
							'http_auth' => 'basic' // or 'digest'
						));

						$user = $this->rest->get('send', array('number' => $row['CLIENT_CELLPHONE'], 'msg' => $msgSMS), 'json');
					}


					//INSERT INTO QUESTIONS
					$data1 = array(
						'product_id'       => $product_id,
						'bus_id'           => $bus_id,
						'client_id'        => $client_id,
						'asking_client_id' => $sender_client_id,
						'question'         => $msg,
						'status'           => 'draft'
					);
					$this->db->insert('product_questions', $data1);


					//INSERT INTO MESSAGES TABLE AS UNREAD
					if ($bus_id != 0)
					{
						$data2 = array(
							'bus_id'         => $bus_id,
							'client_id'      => $sender_client_id,
							'client_id_logo' => $client_id,
							'nameFROM'       => $name,
							'nameTO'         => $row['CLIENT_NAME'],
							'email'          => $sender_row['CLIENT_EMAIL'],
							'emailTO'        => $row['CLIENT_NAME'],
							'body'           => $body,
							'status'         => 'unread',
							'status_client'  => 'unread',
							'subject'        => $subject
						);

						$this->db->insert('u_business_messages', $data2);
					}
					//INSERT INTO MESSAGES TABLE AS SENT
					$data3 = array(
						'bus_id'         => '0',
						'client_id'      => $client_id,
						'client_id_logo' => $sender_client_id,
						'nameFROM'       => $name,
						'nameTO'         => $row['CLIENT_NAME'],
						'email'          => $sender_row['CLIENT_EMAIL'],
						'emailTO'        => $row['CLIENT_NAME'],
						'body'           => $msg,
						'status'         => 'unread',
						'status_client'  => 'sent',
						'subject'        => $subject
					);

					$this->db->insert('u_business_messages', $data3);


					$data['basicmsg'] = 'Thanks, ' . $name . '! We have succesfully sent your question.';

					$data['fb_conversion'] = '
												<script  data-cfasync="false">(function() {
												  var _fbq = window._fbq || (window._fbq = []);
												  if (!_fbq.loaded) {
												    var fbds = document.createElement("script");
												    fbds.async = true;
												    fbds.src = "//connect.facebook.net/en_US/fbds.js";
												    var s = document.getElementsByTagName("script")[0];
												    s.parentNode.insertBefore(fbds, s);
												    _fbq.loaded = true;
												  }
												})();
												window._fbq = window._fbq || [];
												window._fbq.push(["track", "6020352901773", {"value":"10.00","currency":"ZAR"}]);
												</script>
												<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6020352901773&amp;cd[value]=0.00&amp;cd[currency]=ZAR&amp;noscript=1" /></noscript>';


					echo '<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">×</button>
									' . $data['basicmsg'] . '</div>
									<script data-cfasync="false" type="text/javascript">
										$("#msg").html("");
										$("#contactbut").html("<i class=' . "'icon-envelope'" . '></i> Ask Question");
									</script>
									' . $data['fb_conversion'];

					//IF NOT VALIDATED	
				}
				else
				{

					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					echo '<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">×</button>
									' . $data['error'] . '</div>';

				}
			}

		}
		else
		{

			echo '<div class="alert alert-error">Please log in or register to ask a question</div>';

		}
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = '', $offset = 0, $title = '', $amt = '', $advert = true, $pages = '')
	{

		if ($query == '')
		{
			//$query = $this->db->query("SELECT * FROM products WHERE is_active = 'Y' ORDER BY listing_date DESC" ,FALSE);
			$query = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,products_buy_now.amount,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN products_buy_now ON products_buy_now.product_id = products.product_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        WHERE products.is_active = 'Y' AND products.status = 'live'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 30", false);

			//$query = $this->db->query("SELECT AVG(RATING)as TOTAL FROM u_business_vote WHERE PRODUCT_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review' ORDER BY TOTAL ");

		}
		else
		{
			$query = $query;
		}

		$span = $amt - 1;
		if ($amt == '')
		{
			$span = '3';
			$amt = 3;
		}
		if ($query->result())
		{

			$sorting = '';

			$current = $query->num_rows();
			$count = '<strong>' . $offset . ' - ' . ($offset + $query->num_rows()) . '</strong> Results shown of <strong>' . (int) $count . '</strong>';

			if ($advert)
			{
				$priceD = '';
				if (strstr(current_url('/'), '/priceD'))
				{
					$priceD = ' active';
				}
				$priceA = '';
				if (strstr(current_url('/'), '/priceA'))
				{
					$priceA = ' active';
				}
				$sorting = '<div class="row-fluid">
								<div class="span8">	
									<h2 class="upper na_script">' . $title . '</h2>
								</div>
								 
								<div class="span4 text-right">
								 <div class="btn-group text-left">
									<button class="btn btn-inverse"><i class="icon-resize-vertical icon-white"></i> Sort By</button>
									<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul class="dropdown-menu pull-right">
									  <li><a href="' . site_url('/') . 'trade/sortby/price/priceD/?url=' . $this->uri->uri_string() . '/?' . urlencode(json_encode($this->input->get())) . '" class=" ' . $priceD . '"><i class="icon-arrow-up"></i> Highest Price First</a></li>
									  <li><a href="' . site_url('/') . 'trade/sortby/price/priceA/?url=' . $this->uri->uri_string() . '/?' . urlencode(json_encode($this->input->get())) . '" class="' . $priceA . '"><i class="icon-arrow-down"></i> Lowest Price First</a></li>
									  <li class="divider"></li>
									  
									</ul>
								  </div>
								
								
								<p>' . $count . '</p>
								</div>
							</div>';

				$advert = $this->my_na_model->show_trade_advert($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, 10);

			}
			else
			{

				$advert = '';

			}
			echo $sorting . '
				<div class="row-fluid">	  
			 		<div class="thumbnails">
			';
			$x2 = 0;

			// var_dump($advert);
			foreach ($query->result() as $row)
			{
				//var_dump($row);
				//get images

				//$images = $this->db->query("SELECT * FROM product_images WHERE product_id = '".$row->product_id."' ORDER BY sequence ASC LIMIT 5");
				$xx = 0;
				$img = array();
				$img_Cycle = '';
				if ($row->images != null)
				{

					$imgA = explode(',', $row->images);
					$imgAa = array();
					foreach ($imgA as $imgR)
					{
						$lazy = '';
						if ($xx == 0)
						{
							$lazy = 'lazy active';
							$img_str = CDN_URL . 'assets/products/images/' . $imgR;
							$img[$xx] = '<li><img class="' . $lazy . ' vignette" src="' . NA_SITE_URL . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-original="' .
								NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $imgR . '&w=360&h=230"/></li>';
						}
						else
						{

							$at = '<img class="vignette" alt="' . strip_tags($row->title) . '" src="' .
								NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL. 'assets/products/images/' . $imgR . '&w=360&h=230"/>';
							array_push($imgAa, $at);

						}
						/*$img[$xx] = '<li><img class="'.$lazy.' vignette" src="'.NA_SITE_URL.'img/deal_place_load.gif" alt="'.strip_tags($row->title).'" data-original="'.
										NA_SITE_URL.'img/timbthumb.php?src='. NA_SITE_URL.'assets/products/images/'.$imgR.'&w=340&h=200"/></li>';*/


						$xx++;
					}

					$img_Cycle = '<script id="images_' . $row->product_id . '" type="text/cycle">
								' . json_encode($imgAa) . '
						 </script>';

				}
				else
				{

					$img[0] = '<li><img class="lazy vignette active" src="' . NA_SITE_URL . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-original="' .
						NA_SITE_URL . 'img/timbthumb.php?src=' .CDN_URL. 'img/product_blank.jpg&w=360&h=230" /></li>';
					$img_str = NA_SITE_URL . 'img/product_blank.jpg';
				}

				//CHECK IF AGENCY PROPERTY LISTING
				$b_logo = '';
				if ($row->IS_ESTATE_AGENT == 'Y')
				{

					if (trim($row->BUSINESS_LOGO_IMAGE_NAME) != '')
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . CDN_URL . 'assets/business/photos/' . $row->BUSINESS_LOGO_IMAGE_NAME . '" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}
					else
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . CDN_URL . 'img/bus_blank.jpg" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}

				}
				$btn_txt = 'Buy Now';
				if ($row->main_cat_id == 3408)
				{

					$btn_txt = 'Enquire Now';

				}
				//Check Price
				//Fixed price
				if ($row->listing_type == 'S')
				{

					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">' . $btn_txt . '</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';

					if ($row->sub_cat_id == 3410)
					{
						$price = '<span style=" font-size:18px">N$</span> ' . $this->smooth_price($row->sale_price) . ' pm';
					}
					else
					{
						$price = '<span style=" font-size:18px">N$</span> ' . $this->smooth_price($row->sale_price);
					}
					if ($row->por == 'Y')
					{

						$price = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}
					//Auction	
				}
				elseif ($row->listing_type == 'A')
				{

					//$price = '<span style=" font-size:18px">N$</span> '.$this->smooth_price($row->sale_price);
					$price = $this->get_current_bid($row->current_bid);

					if ($price['str'] != 'No Bids')
					{
						$price = '<span style=" font-size:10px">BID</span> ' . $price['str'];

					}
					else
					{
						$price = $price['str'];
					}

					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">Place Bid</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';


					//SERVICE
				}
				elseif ($row->listing_type == 'C')
				{

					$btn = '';
					$reserve = '';
					$count = '';


					if ($row->sub_cat_id == 3410)
					{
						$price = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span> pm';
					}
					else
					{
						$price = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span>';
					}
					if ($row->por == 'Y')
					{

						$price = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}

					$btn_txt = 'Order Now';


					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">' . $btn_txt . '</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';
				}

				$private = '';
				if ($row->bus_id == 0)
				{

					$private = '<span class="private" rel="tooltip" title="This item is listed Privately"><i class="icon-star"></i></span>';

				}

				$fb = "postToFeed(" . $row->product_id . ", '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . "','" . trim($img_str) . "', '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->description, " ", " ")), 50)))) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . trim($this->clean_url_str($row->title)) . "')";

				//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";

				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';


				//LOCATION
				$location = '';
				if ($row->location != '')
				{

					$location = '<span  itemprop="address" class="badge">' . $row->location . '</span>';

					if ($row->suburb != 0 && $row->suburb != '')
					{
						$location = '<span  itemprop="address" class="badge">' . $row->location . ' / ' . $row->suburb . '</span>';
					}

				}
				//get REVIEWS
				$rating = 0;
				$total_reviews = 0;
				if ($row->TOTAL != null)
				{

					$rating = $row->TOTAL;
					if (isset($row->TOTAL_REVIEWS))
					{
						$total_reviews = $row->TOTAL_REVIEWS;
					}
					else
					{
						$total_reviews = 0;
					}

				}
				$a_count = 0;
				if (isset($advert['count']))
				{
					$a_count = $advert['count'];
				}

				$randA = rand(0, ($a_count - 1));
				if ($x2 % $amt == 0)
				{
					$ad = '';
					if ($advert)
					{
						if ($x2 != 0)
						{
							$ad = '<div class="span3">' . $advert[$randA] . '</div>';
						}
					}
					echo $ad . '
				   </div>
				   <div class="row-fluid">
				   ';
				}
				$ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
				echo ' <div class="span' . $span . ' white_box">
							' . $ribbon . '
							<div class="slideshow-block">
								<a href="#" class="link"></a>
								<ul class="cycle-slideshow cycle-paused" data-cycle-speed="500" data-cycle-timeout="500" data-cycle-loader=true data-cycle-progressive="#images_' . $row->product_id . '" data-cycle-slides="> li">
									' . implode($img) . '
								</ul>
								' . $img_Cycle . '
							</div>

							<div class="padding10">
								
								<div class="price_label">' . $price . '</div>
								<span class="pull-right" style="margin-top:-55px">
									<a onClick="' . $fb . '" class="facebook"></a>
									' . anchor_popup('https://twitter.com/share?url=' . trim($tweet_url), ' ', $tweet) . '
								</span>
								<h4 class="upper na_script">' . ucwords(strtolower($this->shorten_string($row->title, 6))) . '</h4>
								' . $location . '
								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;width:100%;min-height:90px;max-height:143px; overflow:hidden;">' . $this->shorten_string(strip_tags($row->description), 10) .

					$this->show_extras_short($row->extras) .
					'</div>
								' . $this->get_review_stars_show($rating, $row->product_id, 0, $total_reviews) . $b_logo . '
								<div class="clearfix"></div>
								<p>' . $type_btn . '</p>
								<div class="clearfix"></div>
							</div>
										' . $private . '
					  </div>
					  ';

				$x2++;


			}


			echo '</div>
				</div>';

			echo $pages . '<div class="clearfix" style="height:30px;"></div>';

			if ($this->input->is_ajax_request())
			{


				echo '
				 <script data-cfasync="false" type="text/javascript">

					$(document).ready(function(){
							$("img.lazy").lazyload({
								  effect : "fadeIn"
							  });
							window.setTimeout(initiate_pagination, 100);
							$(".cycle-slideshow").cycle();
							var c = $(".cycle-slideshow").cycle("pause");
							c.hover(function () {
								//mouse enter - Resume the slideshow
								$(this).cycle("resume");
							},
							function () {
								//mouse leave - Pause the slideshow
								$(this).cycle("pause");
							});
					});
				 </script>';


			}
			else
			{


				echo '
				 <script type="text/javascript">

					$(document).ready(function(){
							$("img.lazy").lazyload({
								  effect : "fadeIn"
							  });

							//PAGINATION
							window.setTimeout(initiate_slides, 200);
							window.setTimeout(initiate_pagination, 400);
					});
				 </script>';

			}

		}
		else
		{


			//$ad = $this->my_na_model->show_trade_advert($main_cat_id , $sub_cat_id, $sub_sub_cat_id , $sub_sub_sub_cat_id);
			echo '<div class="row-fluid">
					<div class="span12">
						<div class="alert">
						 <h2>No matches found!</h2> We could not find any matching items for the current search criteria.
						 <p>Please refine your search by changing the search criteria above.</p>
						 <h3>but here are some similar items...</h3>
						</div>
					</div>
				 
				 </div>

				 ';
			$query = "SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE main_cat_id = '" . $main_cat_id . "' ORDER BY listing_date DESC LIMIT 9";
			$this->get_products($query = '', $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $amt = '');

		}


	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SINGLE PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_product($product_id)
	{

		//Get Main
		$query = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        AVG(u_business_vote.RATING) as TOTAL,MAX(product_auction_bids.amount) as current_bid,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        WHERE products.product_id = '" . $product_id . "'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 1", false);

		if ($query->result())
		{

			$row = $query->row();


			echo '<div id="product_msg_"></div>';

			$fb = "postToFeed(" . $row->product_id . ", '" . $row->title . "', '" . $row->title . "', '" . $row->title . " - My Namibia','" . $this->shorten_string(strip_tags($row->description), 50) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . "')";
			$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
			);

			$btn = '<a onclick="claim_deal_un(' . $row->product_id . ');" href="javascript:void(0)" id="claim_btn' . $row->product_id . '"  class="btn btn-large pull-right btn-inverse">
				<i class="icon-star-empty icon-white"></i> Grab Product
				</a>';
			//IF LOGGED IN
			if ($this->session->userdata('id'))
			{


				$btn = '<a onclick="claim_deal_un(' . $row->product_id . ');" href="javascript:void(0)" id="claim_btn' . $row->product_id . '"  class="btn btn-large pull-right btn-inverse">
								<i class="icon-star-empty icon-white"></i> Grab Product
								</a>';
			}


			$tweet_url = $this->clean_url_str($row->title) . '&text=' . substr(strip_tags($row->title . ' ' . $row->description), 0, 60) . ' ' . site_url('/') . 'product/' . $row->product_id . '&via=MyNamibia';
			$c = '';

			//STOCK TICKER
			if ($row->total_quantity > 1)
			{

				$t_stock = $row->total_quantity;
				$s_perc = ($row->quantity / $t_stock) * 100;
				$stock_ticker = '<div class="well well-mini" style="padding:2px 10px 0px 10px"><small>' . $row->quantity . ' Currently In Stock </small>
				    <div class="progress  progress-warning" title="' . $row->quantity . ' of ' . $row->total_quantity . ' products are available" rel="tooltip">
					  <div class="bar" style="width:' . $s_perc . '%"></div>
					</div><small class="pull-right"><em>Stock Counter</em></small></div>';

			}
			else
			{

				$stock_ticker = '';
			}

			//IF BUY NOW
			if ($row->listing_type == 'S')
			{

				$count = '';
				$reserve = '';

				if ($row->status == 'sold')
				{
					$price['str'] = '<span itemprop="price" class="hide">' . $this->smooth_price($row->sale_price) . '</span> Sold';
				}
				else
				{
					if ($row->sub_cat_id == 3410)
					{
						$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span> pm';
					}
					else
					{
						$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span>';
					}
					if ($row->por == 'Y')
					{

						$price['str'] = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}

				}
				$btn_txt = 'Buy Now';

				if ($row->main_cat_id == 3408 || $row->sub_cat_id == 352 || $row->quantity == 0)
				{

					$btn_txt = 'Enquire Now';

				}
				//SEE IF OWN PRODUCT
				if ($row->client_id == $this->session->userdata('id'))
				{


					$btn = '<div class="pull-right" style="margin-top:10px;" rel="tooltip" title="Sorry, this is your item!">
							  <form id="buy_now_frm" method="post" style="margin-bottom:0">
								   <input type="hidden" name="product_id" value="' . $product_id . '" />
								  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
								  <input type="hidden" name="amount" value="' . $row->sale_price . '" />
								  <button class="btn btn-inverse btn-large" type="submit" disabled="disabled">' . $btn_txt . '</button>
							  </form>
							</div>';
				}
				else
				{
					if ($row->main_cat_id == 3408 || $row->sub_cat_id == 352 || $row->quantity == 0)
					{

						$btn = '<div class="pull-right" style="margin-top:10px;">
									  <a href="#contact_anchor" rel="tooltip" title="Please enquire about the product" class="btn btn-inverse btn-large" >' . $btn_txt . '</a>
								</div>';

					}
					else
					{
						$btn = '<div class="pull-right" style="margin-top:10px;">
								  <form action="' . site_url('/') . 'trade/buy_now/" id="buy_now_frm" method="post"  style="margin-bottom:0">
									   <input type="hidden" name="product_id" value="' . $product_id . '" />
									  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
									  <input type="hidden" name="title" value="' . $row->title . '" />
									  <input type="hidden" name="seller_id" value="' . $row->client_id . '" />
									  <input type="hidden" name="amount" value="' . $row->sale_price . '" />
									  <button class="btn btn-inverse btn-large" id="buy_now_btn" type="submit">' . $btn_txt . '</button>
								  </form>
								</div>';
					}

				}
				//AUCTION	
			}
			elseif ($row->listing_type == 'A')
			{

				if ($this->input->is_ajax_request())
				{

				}
				else
				{

					echo '<script type="text/javascript" src="' . NA_SITE_URL . 'js/jquery.countdown.min.js"></script>';

				}


				$count = '<div id="ctdwn_' . $product_id . '" class="CT-tmer"></div>';
				$reserve = '<div class="well well-mini text-center"><span style=" font-size:12px">Reserve</span> <span style=" font-size:12px">N$</span> <br /><span style="font-size:20px;color:#FF9F01; font-weight:bold;">' . $row->reserve . '</span></div>';
				$price = $this->get_current_bid($row->current_bid);

				//TEST RESERVE
				$resT = '<p>&nbsp;</p><p>&nbsp;</p><div class="alert clearfix"><h4>Reserve has not been met</h4>The reserve price has to be reached for the item to qualify as sold. If the reserve is not met by the auction end the item will not be sold.</div>';
				if ($price['current'] > $row->reserve)
				{

					$resT = '';

				}


				//SEE IF OWN PRODUCT
				if ($row->client_id == $this->session->userdata('id'))
				{

					$btn = '' . $resT . '<div class="input-append">
							  <form action="' . current_url() . '" id="auction_frm" method="post"  rel="tooltip" title="Sorry, this is your item!">
								  <input class="span4" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold" name="bid_amount" value="Not Allowed"  disabled>
								  <input type="hidden" name="product_id" value="' . $product_id . '" />
								  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
								  <input type="hidden" name="reserve" value="' . $row->reserve . '" />
								  <input type="hidden" name="current_bid" value="' . $price['current'] . '" />
								  <button class="btn btn-inverse btn-large disabled" id="auction_btn1" type="submit">N$ Bid Now</button>
							  </form>
							</div>';
				}
				else
				{

					//IF EXPIRED
					$now = date('Y-m-d H:i:s');
					$end = date('Y-m-d H:i:s', strtotime($row->end_date));

					if ($end < $now)
					{

						$btn = '<div class="row-fluid">
									<div class="span12"><div class="alert"><h3>Auction has Ended</h3>The auction has ended and all bidding has been suspended. Better luck next time</div></div>
								</div>';
					}
					else
					{


						$btn = '<div style="min-height:100px; ">
								' . $resT . '
								<div class="row-fluid">
									<div class="span8">
										<div class="input-append" id="bid_box">
										  <form action="' . site_url('/') . 'trade/place_bid/" id="auction_frm" method="post">
											  <input class="span3" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold; width:30%" name="bid_amount" value="' . $price['price'] . '">
											  <input type="hidden" name="product_id" value="' . $product_id . '" />
											  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
											  <input type="hidden" name="reserve" value="' . $row->reserve . '" />
											  <input type="hidden" name="title" value="' . $row->title . '" />
											  <input type="hidden" name="auto_bid" value="0" />
											  <input type="hidden" name="seller_id" value="' . $row->client_id . '" />
											  <input type="hidden" name="current_bid" value="' . $price['current'] . '" />
											  <button class="btn btn-inverse btn-large" id="auction_btn" type="submit">N$ Bid Now</button>
										  </form>
										</div>

										<div class="input-append hide" id="auto_bid_box">
										  <form action="' . site_url('/') . 'trade/place_bid/" id="auction_frm_auto" method="post">
											  <input class="span3" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold;width:30%" name="bid_amount" value="' . $price['price'] . '">
											  <input type="hidden" name="product_id" value="' . $product_id . '" />
											  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
											  <input type="hidden" name="reserve" value="' . $row->reserve . '" />
											  <input type="hidden" name="title" value="' . $row->title . '" />
											  <input type="hidden" name="auto_bid" value="1" />
											  <input type="hidden" name="seller_id" value="' . $row->client_id . '" />
											  <input type="hidden" name="current_bid" value="' . $price['current'] . '" />
											  <button class="btn btn-inverse btn-large" id="auction_btn_auto" type="submit">N$ Auto Bid</button>
										</div>
									</div>
									<div class="span4">
										<a href="javascript:void(0)" onClick="switch_auto_bid()" class="btn btn-inverse pull-right">Auto Bid</a>
									</div>
								</div>
								<div class="alert alert-block clearfix hide" id="auto_help_txt"><strong>Please Note:</strong> Auto bid will automatically place your bid until your auto bid value is met.</div>
						   </div>
							';

					}
					$btn .= $this->get_bid_history($row->product_id);
				}


				//SERVICE
			}
			elseif ($row->listing_type == 'C')
			{

				$btn = '';
				$reserve = '';
				$count = '';

				//SEE IF OWN PRODUCT
				if ($row->client_id == $this->session->userdata('id'))
				{
					$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span>';
					$btn_txt = 'Your Own Service';
				}
				else
				{

					if ($row->sub_cat_id == 3410)
					{
						$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span> pm';
					}
					else
					{
						$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</span>';
					}
					if ($row->por == 'Y')
					{

						$price['str'] = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}

					$btn_txt = 'Order Now';

				}

				$btn = '<div class="pull-right" style="margin-top:10px;">
								  <form action="' . site_url('/') . 'trade/order_service/" id="order_now_frm" method="post"  style="margin-bottom:0">
									   <input type="hidden" name="product_id" value="' . $product_id . '" />
									  <input type="hidden" name="bus_id" value="' . $row->bus_id . '" />
									  <input type="hidden" name="title" value="' . $row->title . '" />
									  <input type="hidden" name="seller_id" value="' . $row->client_id . '" />
									  <input type="hidden" name="amount" value="' . $row->sale_price . '" />
									  <button class="btn btn-inverse btn-large" id="order_now_btn" type="submit">' . $btn_txt . '</button>
								  </form>
								</div>';

			}
			$agent_ref = '<span class="label" rel="tooltip"  title="Product Reference"  itemprop="sku">MYNA' . $row->product_id . '</span>';
			//PROPERTY REFERENCE
			if (count(json_decode($row->extras)) > 0)
			{

				foreach (json_decode($row->extras) as $exr => $exv)
				{

					if ($exr == 'agency' && $exv != '')
					{

						$agent_ref = '<span  class="label" rel="tooltip"  title="Product Reference">Ref: <strong itemprop="sku">' . $exv . '</strong></span>';
					}

				}

			}
			//get REVIEWS
			//get REVIEWS
			$rating = 0;
			$total_reviews = 0;
			if ($row->TOTAL != null)
			{

				$rating = $row->TOTAL;
				$total_reviews = $row->TOTAL_REVIEWS;
			}
			//LOCATION
			$location = '';
			if ($row->location != '')
			{

				$location = '<span class="label">' . $row->location . '</span>';

				if ($row->suburb != 0 && $row->suburb != '')
				{
					$location = '<span class="label">' . $row->location . ' / ' . $row->suburb . '</span>';
				}

			}

			$order_now_btn = "<a href='javascript:void(0)' id='order_now_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Order Now</a>";
			$buy_now_btn = "<a href='javascript:void(0)' id='buy_now_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Buy Now</a>";
			$bid_btn = "<a href='javascript:void(0)' id='bid_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Place My Bid</a>";
			echo '<div itemscope itemtype="http://schema.org/Product">
						<div class="pull-right">' . $reserve . '</div>
						<h3 class="upper na_script" itemprop="name">' . $row->title . '</h3>

						' . $agent_ref . '

						' . $location . '
						<span itemprop="description">
							<p>' . $row->description . '</p><p>' . $this->show_extras($row->extras) . '</p>
						</span>	
						' . $count . '

						<div class="row-fluid">
							<div class="span6">
							 ' . $this->get_review_stars_show($rating, $row->product_id, 0, $total_reviews) . '
							</div>
							<div class="span6">
							' . $stock_ticker . '
							</div>
						</div>
						<div id="product_msg" class="clearfix"></div>
						<span class="pull-left" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
							<h1 style="font-size:50px;height:40px;color:#FF9F01;">' . $price['str'] . '</h1>
							<meta itemprop="priceCurrency" content="NAD" />
						</span>

						<div class="clearfix">' . $btn . '</div>
						
						<!--<div class="price_label">' . $price['str'] . '</div>-->


					</div>';

			//ENDING DATE
			$listE = new DateTime(date('Y-m-d H:i:s', strtotime($row->end_date)));

			if ($this->input->is_ajax_request())
			{

				echo '<script data-cfasync="false" type="text/javascript">
								$(document).ready(function(){
									$.getScript("' . NA_SITE_URL . 'js/jquery.rating.pack.js", function(){

										$("input .star").rating();

									});
									';

			}
			else
			{

				echo '<script type="text/javascript">
								$(document).ready(function(){
							';

			}

			echo '	


						';


			if ($row->listing_type == 'A')
			{

				echo '	$(function () {
									
										ctdwn_' . $product_id . ' = new Date(' . ($listE->format('Y')) . ', ' . ($listE->format('m') - 1) . ', ' . ($listE->format('d')) . ', ' . ($listE->format('H')) . ', ' . ($listE->format('i')) . ');
										$(".CT-tmer").countdown({until: ctdwn_' . $product_id . '});
										
									});';
			}

			echo '

								$("#auction_btn").bind("click", function(e){

										e.preventDefault();
										var x = $(this);
										x.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />' . $bid_btn . '"});
										x.popover("show");
										$("html, body").animate({
											 scrollTop: (x.offset().top - 300)
										 }, 300);
										 $("#bid_btn_do").attr("href", "javascript:place_bid()");
								});



								$("#auction_btn_auto").bind("click", function(e){

										e.preventDefault();
										var x = $(this);
										x.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />' . $bid_btn . '"});
										x.popover("show");
										$("html, body").animate({
											 scrollTop: (x.offset().top - 300)
										 }, 300);
										 $("#bid_btn_do").attr("href", "javascript:place_bid_auto()");
								});

								$("#buy_now_btn").bind("click", function(e){

										e.preventDefault();
										var x = $(this);
										x.popover({  delay: { show: 100, hide: 3000 },
										 placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />' . $buy_now_btn . '"});
										x.popover("show");
										$("html, body").animate({
											 scrollTop: (x.offset().top - 300)
										 }, 300);
										 $("#buy_now_btn_do").attr("href", "javascript:buy_now()");
								});

								$("#order_now_btn").bind("click", function(e){

										e.preventDefault();
										var x = $(this);
										x.popover({  delay: { show: 100, hide: 3000 },
										 placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />' . $order_now_btn . '"});
										x.popover("show");
										$("html, body").animate({
											 scrollTop: (x.offset().top - 300)
										 }, 300);
										 $("#order_now_btn_do").attr("href", "javascript:order_now()");
								});
						});

						function place_bid(){


								var frm = $("#auction_frm"), btn = $("#auction_btn"), bbtn = $("#bid_btn_do");
								btn.html("Adding Bid...");
								bbtn.html("<img src=' . "'" . NA_SITE_URL . 'img/load_black.gif' . "'" . '> Please Wait...");
								$.ajax({
									type: "post",
									cache: false,
									url: "' . site_url("/") . 'trade/place_bid_ajax/" ,
									data: frm.serialize(),
									success: function (data) {
										btn.html("Bid Now");
										$("#product_msg").html(data);
                                        $("#auction_btn").popover("destroy");
									}
								});

						}
						function buy_now(){


								var frm = $("#buy_now_frm"), btn = $("#buy_now_btn");
								btn.html("Purchasing...");
								$.ajax({
									type: "post",
									cache: false,
									url: "' . site_url("/") . 'trade/buy_now/" ,
									data: frm.serialize(),
									success: function (data) {
										btn.html("Buy Now");
										$("#product_msg").html(data);
 										btn.popover("destroy");
									}
								});

						}
						function place_bid_auto(){


								var frm = $("#auction_frm_auto"), btn = $("#auction_btn_auto");
								btn.html("Adding Bid...");
								$.ajax({
									type: "post",
									cache: false,
									url: "' . site_url("/") . 'trade/place_bid_ajax/" ,
									data: frm.serialize(),
									success: function (data) {
										btn.html("Bid Now");
										$("#product_msg").html(data);

									}
								});

						}
						function order_now(){


								var frm = $("#order_now_frm"), btn = $("#order_now_btn");
								btn.html("Ordering...");
								$.ajax({
									type: "post",
									cache: false,
									url: "' . site_url("/") . 'trade/order_now/" ,
									data: frm.serialize(),
									success: function (data) {
										btn.html("Order Now");
										$("#product_msg").html(data);
 										btn.popover("destroy");
									}
								});

						}
						</script>';


		}
		else
		{

			echo 'Product Not Found';


		}


	}


	//+++++++++++++++++++++++++++
	//PLACE AUCTION BID
	//++++++++++++++++++++++++++
	public function place_bid()
	{

		$data['amount'] = $this->input->post('bid_amount', true);
		$data['product_id'] = $this->input->post('product_id', true);
		$reserve = $this->input->post('reserve', true);
		$autobid = $this->input->post('auto_bid', true);
		$current_bid = $this->input->post('current_bid', true);
		$data['bus_id'] = $this->input->post('bus_id', true);
		//needs to be logged in
		if ($this->session->userdata('id'))
		{

			//AUTOBID TRUE OR NOT?
			if ($autobid == 1)
			{

				$data['type'] = 'auto';

			}
			else
			{

				$data['type'] = 'bid';
			}


			//VALIDATE
			$val = true;
			if ($data['amount'] <= $current_bid)
			{
				$val = false;
				$error = '<div class="alert">The bid needs to be greater than the current bid of N$ ' . $current_bid . '</div>';
				$notice = '';

			}
			elseif ($data['amount'] < $reserve)
			{

				$error = '';
				$notice = '<div class="alert">The reserve has not been met. The product will only be auctioned once reached.</div>';
			}
			else
			{

				$error = '';
				$notice = '';
			}

			if ($val === true)
			{
				$data['client_id'] = $this->session->userdata('id');
				$this->db->insert('product_auction_bids', $data);

				echo '<div class="alert alert-success">Thanks, we have placed your bid!</div>';

			}
			else
			{

				echo $error;
			}


		}
		else
		{

			echo '<div class="alert">Please log in or register to place your bid!</div>';

		}


	}
	//+++++++++++++++++++++++++++
	//PLACE AUCTION BID
	//++++++++++++++++++++++++++
	public function place_bid_ajax()
	{

		$data['amount'] = $this->input->post('bid_amount', true);
		$data['product_id'] = $this->input->post('product_id', true);
		$reserve = $this->input->post('reserve', true);
		$autobid = $this->input->post('auto_bid', true);
		$current_bid = $this->input->post('current_bid', true);
		$data['bus_id'] = $this->input->post('bus_bid', true);
		//needs to be logged in
		if ($this->session->userdata('id'))
		{

			//VALIDATE
			$val = true;


			//SMALLER THAN CURRNT BID
			if ($data['amount'] <= $current_bid)
			{
				$val = false;
				$error = '<div class="alert">The bid needs to be greater than the current bid of N$ ' . $current_bid . '</div>';
				$notice = '';
				//SMALLER THAN RESERVE
			}
			elseif ($data['amount'] < $reserve)
			{

				$error = '';
				$notice = '<div class="alert">The reserve has not been met. The product will only be auctioned once reached.</div>';
			}
			else
			{

				$error = '';
				$notice = '';
			}

			if ($val === true)
			{

				//GET LEADING BID CONTACT
				$lead = $this->db->query("SELECT * FROM product_auction_bids
										  JOIN u_client ON product_auction_bids.client_id = u_client.ID
										  JOIN products ON product_auction_bids.product_id = products.product_id
										  JOIN product_images ON product_auction_bids.product_id = product_images.product_id
										  WHERE product_auction_bids.amount = '" . $current_bid . "' AND product_auction_bids.product_id = '" . $data['product_id'] . "' 
										  AND product_auction_bids.client_id != '" . $this->session->userdata('id') . "'");
				//IF LEADING BID EXISTS
				if ($lead->result())
				{
					$row = $lead->row();
					$img_str = '';
					if ($row->img_file != '')
					{

						$img_str .= '<img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row->img_file . '&w=190&h=130" />';


					}

					//SEND NOTIFICATION OF OUTBID
					$emailTO = array(array('email' => $row->CLIENT_EMAIL));
					$emailFROM = 'no-reply@my.na';
					$name = 'My Namibia Trade';
					$subject = 'You have been Outbid - ' . $row->title;
					$body = 'Hi ' . $row->CLIENT_NAME . ', <br /><br /> 
							Your leading bid has been outbid in the auction for ' . $row->title . ' on My Namibia &trade;
							<br /><br />
							<table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px">
									 <tr>
										<td style="width:30%">' . $img_str . '</td>
										<td style="width:50%"><p style="color:#060;font-size:20px;line-height:30px;height:30px;">Bid Amount</p>
															  <p style="color:#900;font-size:20px;line-height:30px;height:30px;">Current Bid</p>
															  <p style="color:#060;font-size:20px;line-height:30px;height:30px;">Your Last Bid</p>
										</td>
										<td style="width:20%"><p style="color:#060;font-size:20px;line-height:30px;height:30px;"><span style="font-size:10px;">+ N$ </span> ' . $this->smooth_price($data['amount'] - $row->amount) . '</p>
															  <p style="color:#900;font-size:20px;line-height:30px;height:30px;"><span style="font-size:10px;">N$ </span>' . $this->smooth_price($data['amount']) . '</p>
															  <p style="color:#060;font-size:20px;line-height:30px;height:30px;"><span style="font-size:10px;">N$ </span> ' . $this->smooth_price($row->amount) . '</p></td>
									</tr>
							</table>			
							<font style="font-size:10px; font-style:italic">' . $row->description . '</font>
							<br />
							To compete please visit the auction now.
							View the auction <a href="' . site_url('/') . 'product/' . $row->product_id . '/">here.</a><br /><br />
							<br />
							Have a !tna day!<br />
							My Namibia';
					$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news', $data_view, true);
					$TAGS = array('tags' => 'trade_outbid');
					$this->load->model('email_model');

					$this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
					//IF CLIENT MOBILE VERIFIED
					if ($row->VERIFIED == 'Y')
					{

						//SEND SMS
						$msg = 'You have been outbid in the auction for ' . $this->shorten_string($row->title, 3) . '. Current bid is N$' . $data['amount'] . ' http://my.na/u/p/' . $data['product_id'];

						//LOAD LIBRARIES FOR API AND SEND SMS
						$this->load->library('curl');
						$this->load->library('rest', array(
							'server'    => 'http://sms.my.na/api/sms/',
							'http_user' => 'myna_ma$ster',
							'http_pass' => '#$5_jh56_hdgd',
							'http_auth' => 'basic' // or 'digest'
						));

						$user = $this->rest->get('send', array('number' => $row->CLIENT_CELLPHONE, 'msg' => $msg), 'json');
					}

				}
				else
				{//OTHERWISE NO LEADING BID, SEND OWNER NOTIFIXCATION


					//GET PRODUCT LISTER / OWNER DETAILS TO Notify
					$owner = $this->db->query("SELECT u_client.*, products.title as product_title FROM products
										  JOIN u_client ON products.client_id = u_client.ID
										  WHERE products.product_id = '" . $data['product_id'] . "'
										  LIMIT 1");

					if ($owner->result())
					{

						$ownerR = $owner->row();

						//IF CLIENT MOBILE VERIFIED
						if ($ownerR->VERIFIED == 'Y')
						{

							//SEND SMS
							$msg2 = 'Your product: ' . $this->shorten_string($ownerR->product_title, 3) . ' on My Namibia received a new bid. Current bid is N$' . $data['amount'] . ' http://my.na/u/p/' . $data['product_id'];

							//LOAD LIBRARIES FOR API AND SEND SMS
							$this->load->library('curl');
							$this->load->library('rest', array(
								'server'    => 'http://sms.my.na/api/sms/',
								'http_user' => 'myna_ma$ster',
								'http_pass' => '#$5_jh56_hdgd',
								'http_auth' => 'basic' // or 'digest'
							));

							$owner = $this->rest->get('send', array('number' => $ownerR->CLIENT_CELLPHONE, 'msg' => $msg2), 'json');
						}

					}

				}//END IF LEADING BID EXISTS


				//AUTOBID TRUE OR NOT?
				if ($autobid == 1)
				{

					//INSERT AUTO BID
					$data['client_id'] = $this->session->userdata('id');
					$data['type'] = 'auto';
					$data['amount'] = $data['amount'];
					$this->db->insert('product_auction_bids', $data);

					//INSERT BID
					$data2['client_id'] = $this->session->userdata('id');
					$data2['amount'] = $current_bid + 10;
					$data2['product_id'] = $data['product_id'];
					$data2['bus_id'] = $data['bus_id'];
					$data2['type'] = 'bid';
					$this->db->insert('product_auction_bids', $data2);

				}
				else
				{
					//INSERT BID
					$data['client_id'] = $this->session->userdata('id');
					$data['amount'] = $data['amount'];
					$data['type'] = 'bid';
					$this->db->insert('product_auction_bids', $data);

				}

				//CHECK IF AUTOBID EXISTS
				$this->db->where('type', 'auto');
				$this->db->where('product_id', $data['product_id']);
				$this->db->where('amount >', $data['amount']);
				$this->db->order_by('amount', 'DESC');
				$has_auto = $this->db->get('product_auction_bids');

				if ($has_auto->result())
				{

					$amount_new = $data['amount'];
					foreach ($has_auto->result() as $has_auto_row)
					{
						//INSERT AUTO BID	
						if ($has_auto_row->client_id != $data['client_id'])
						{
							//NEXT AUTO BID AMOUNT
							$next = $this->auto_bid_value($has_auto_row->amount, $amount_new);
							$has_auto_row_insert['type'] = 'bid';
							$has_auto_row_insert['bid_id'] = null;
							$has_auto_row_insert['client_id'] = $has_auto_row->client_id;
							$has_auto_row_insert['product_id'] = $data['product_id'];

							if ($next == 0)
							{
								$has_auto_row_insert['amount'] = $has_auto_row->amount;
								$amount_new = $has_auto_row->amount;
							}
							else
							{
								$has_auto_row_insert['amount'] = $next;
								$amount_new = $next;
							}

							$this->db->insert('product_auction_bids', $has_auto_row_insert);


						}
					}
				}

				echo '<div class="alert alert-success">Thanks, we have placed your bid!</div>
					  <script data-cfasync="false" type="text/javascript">
					  		window.setTimeout(load_product_details, 1800);	
					  </script>		
						';

			}
			else
			{

				echo $error;
			}


		}
		else
		{

			echo '<div class="alert">Please log in or register to place your bid!</div>';

		}


	}
	//+++++++++++++++++++++++++++
	//AUTO BID INCREMENT
	//++++++++++++++++++++++++++
	public function auto_bid_value($max, $next)
	{
		if ($next < $max)
		{
			//5 %
			if (strlen($next) > 6)
			{
				return $next + ($next * 0.05);

				//10 %		
			}
			elseif (strlen($next) > 3)
			{
				return $next + ($next * 0.1);

				//5	
			}
			else
			{
				return $next + 5;

			}

		}
		else
		{

			return 0;
		}
	}
	//+++++++++++++++++++++++++++
	//BUY NOW BUTTON
	//++++++++++++++++++++++++++
	public function buy_now()
	{
		error_reporting(E_ALL);
		//IS loggged in
		if ($this->session->userdata('id') && $data['product_id'] = $this->input->post('product_id', true))
		{


			$data['bus_id'] = $this->input->post('bus_id', true);
			$data['seller_id'] = $this->input->post('seller_id', true);
			$data['amount'] = $this->input->post('amount', true);
			$product_title = $this->input->post('title', false);
			$data['client_id'] = $this->session->userdata('id');

			//TEST IF ALREADY BOUGHT, DEDUCT QUANTITIES
			$bought = $this->db->where('products.product_id', $data['product_id']);
			$bought = $this->db->join('products_buy_now', 'products_buy_now.product_id = products.product_id', 'left');
			$bought = $this->db->get('products');

			if ($bought->result())
			{

				$brow = $bought->row();

				if ($brow->total_quantity == 1)
				{


					if ($brow->buy_now_id != null && $brow->quantity == 0)
					{

						echo '<div class="alert alert-danger">Sorry, the item has already been purchased.</div>';
						die();

					}
					else
					{

						$this->db->where('product_id', $data['product_id']);
						$this->db->set('quantity', 'quantity-1', false);
						$this->db->set('status', 'sold');
						$this->db->update('products');
					}

				}
				else
				{

					$this->db->where('product_id', $data['product_id']);
					$this->db->set('quantity', 'quantity-1', false);
					$this->db->update('products');

				}


			}

			//Insert product buy now
			$this->db->insert('products_buy_now', $data);


			//GET PRODUCT AND SELLER DETAILS and save in $row
			$s = $this->db->query("SELECT product_images.img_file, products.*,u_client.CLIENT_NAME,u_client.CLIENT_SURNAME, u_client.CLIENT_CELLPHONE, u_client.ID as buyer_id,
                                              u_client.VERIFIED, u_client.CLIENT_EMAIL
                                              FROM products
											  LEFT JOIN product_images ON product_images.product_id = products.product_id
                                              JOIN u_client on products.client_id = u_client.ID
                                              WHERE products.product_id = '" . $data['product_id'] . "'
											  GROUP BY products.product_id
                                              LIMIT 1
                                              ", false);

			$row = $s->row_array();
			$emailTO = array(array('email' => $row['CLIENT_EMAIL']));

			//GET BUYER DETAILS
			$this->db->where('ID', $data['client_id']);
			$this->db->from('u_client');
			$query = $this->db->get();
			$rowB = $query->row_array();
			$emailTO_buyer = array(array('email' => $rowB['CLIENT_EMAIL']));


			$images = '<table>
									<tbody>
										<tr class="white_box">';
			if ($row['img_file'] != null)
			{

				$images .= '<td style="width:100%;"><img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row['img_file'] . '&w=580&h=320" style="width:100%; "></td>';


			}
			else
			{
				$images .= '<td style="width:100%;"><img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'img/product_blank.png&w=580&h=320" style="width:100%; "></td>';

			}
			$images .= "		</tr>
									</tbody>
								</table>";
			//BUILD BODY EMAIL TO SELLER
			$body_seller = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
						Your product ' . $product_title . ' listed on My Namibia&trade; trade has been sold. The buyer has confirmed his purchase and has received an email
						containing your payment instructions.
						<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">SOLD!</h1>
						' . $images . '
						<br /><br />
						If you have any questions or need to arrange shipping please contact the buyer below.<br />
						Name: ' . $rowB['CLIENT_NAME'] . '<br/>
						Email: ' . $rowB['CLIENT_EMAIL'] . '<br/>
						Cell: ' . $rowB['CLIENT_CELLPHONE'] . '<br/><br/>
						The item has now been marked as sold. Maintain your products from your dashboard.<br /><br />
						' . site_url('/') . 'members/<br /><br />
						Please remember to leave a review regarding this transaction and the buying party.
						<br /><br />
						Have a !tna day!<br />
						My Namibia';


			$seller_MSG['bus_id'] = 0;
			$seller_MSG['bus_id_logo'] = 1290;
			$seller_MSG['client_id_logo'] = 0;
			$seller_MSG['client_id'] = $data['seller_id'];
			$seller_MSG['nameFROM'] = 'My Namibia';
			$seller_MSG['nameTO'] = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
			$seller_MSG['email'] = 'trade@my.na';
			$seller_MSG['emailTO'] = $row['CLIENT_EMAIL'];
			$seller_MSG['body'] = $body_seller;
			$seller_MSG['subject'] = 'Sold: ' . $product_title;
			$seller_MSG['status'] = 'sent';
			$seller_MSG['status_client'] = 'unread';
			$this->db->insert('u_business_messages', $seller_MSG);

			$data_view['body'] = $body_seller;
			$body_seller_final = $this->load->view('email/body_news', $data_view, true);
			$subject = 'Sold: ' . $product_title;
			$fromEMAIL = 'no-reply@my.na';
			$fromNAME = 'My Namibia Trade';
			$TAG = array('tags' => 'trade_buy_now');

			//SEND EMAIL LINK
			$this->load->model('email_model');
			$this->email_model->send_mail($body_seller_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
			//IF CLIENT MOBILE VERIFIED
			if ($row['VERIFIED'] == 'Y')
			{

				//SEND SMS
				$msg = 'Your product ' . $this->shorten_string($product_title, 3) . ' listed on My Namibia trade has been sold. Payment Instructions have been sent. Dont forget to review the buyer. http://my.na/u/p/' . $data['product_id'];

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server'    => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$user = $this->rest->get('send', array('number' => $row['CLIENT_CELLPHONE'], 'msg' => $msg), 'json');
			}


			//GET BUYER DETAILS
			//$this->db->where('ID' , $data['client_id']);
//				$this->db->from('u_client');
//				$query = $this->db->get();
//				$rowB = $query->row_array();
//				$emailTO_buyer = array(array('email' => $rowB['CLIENT_EMAIL'] ));

			//BUILD BODY EMAIL TO BUYER
			$body_buyer = 'Hi ' . $this->session->userdata('u_name') . ',<br /><br />
						Congratulations you have confirmed the purchase of ' . $product_title . ' listed on My Namibia&trade;. Please follow the payment instructions below to
						complete the transaction.

						<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">I am Yours!</h1>
						' . $images . '
						<br /><br />
						<em>' . $row['email_instructions'] . '</em>
						<br />
						If you have any questions or need to arrange shipping please contact the seller below.<br />
						Name: ' . $row['CLIENT_NAME'] . '<br/>
						Email: ' . $row['CLIENT_EMAIL'] . '<br/>
						Cell: ' . $row['CLIENT_CELLPHONE'] . '<br/><br/>
						The item has now been marked as sold. If the payment has not been made or the product is not collected after 7 days you will receive
						bad feedback which will impact your account and buying reputation.<br /><br />
						' . site_url('/') . 'members/<br /><br />
						Please remember to leave a review regarding this transaction and the selling party.
						<br /><br />
						Have a !tna day!<br />
						My Namibia';

			$data_view2['body'] = $body_buyer;
			$body_buyer_final = $this->load->view('email/body_news', $data_view2, true);
			$subject_buyer = 'You have purchased ' . $product_title;
			$fromEMAIL_buyer = $row['CLIENT_EMAIL'];
			$fromNAME_buyer = 'My Namibia Trade';
			$TAG_buyer = array('tags' => 'trade_buy_now');

			$buyer_MSG['bus_id'] = 1290;
			$buyer_MSG['bus_id_logo'] = 1290;
			$buyer_MSG['client_id_logo'] = $data['seller_id'];
			$buyer_MSG['client_id'] = $data['client_id'];
			$buyer_MSG['nameFROM'] = 'My Namibia';
			$buyer_MSG['nameTO'] = $rowB['CLIENT_NAME'] . ' ' . $rowB['CLIENT_SURNAME'];
			$buyer_MSG['email'] = $row['CLIENT_EMAIL'];
			$buyer_MSG['emailTO'] = $rowB['CLIENT_EMAIL'];
			$buyer_MSG['body'] = $body_buyer;
			$buyer_MSG['subject'] = $subject_buyer;
			$buyer_MSG['status'] = 'sent';
			$buyer_MSG['status_client'] = 'unread';
			$this->db->insert('u_business_messages', $buyer_MSG);
			//IF CLIENT MOBILE VERIFIED
			if ($rowB['VERIFIED'] == 'Y')
			{

				//SEND SMS
				$msgB = 'Congratulations ' . $this->shorten_string($product_title, 3) . ' is yours. Payment Instructions have been sent to ' . $rowB['CLIENT_EMAIL'] . '. Dont forget to review the seller. http://my.na/u/p/' . $data['product_id'];

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server'    => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$userb = $this->rest->get('send', array('number' => $rowB['CLIENT_CELLPHONE'], 'msg' => $msgB), 'json');
			}

			$this->email_model->send_mail($body_buyer_final, $subject_buyer, $emailTO_buyer, $fromEMAIL_buyer, $fromNAME_buyer, $TAG_buyer);

			//redirect
			echo '<div class="alert alert-success"><h4>Wohooo!</h4>
						You have successfully purchased the item. Please check your inbox for payment instructions.</div>
						<script>window.setTimeout(load_product_details, 3800);</script>
						';

		}
		else
		{

			echo '<div class="alert alert-danger">Please log in or register to buy the item!</div>';

		}


	}
	//+++++++++++++++++++++++++++
	//ORDER NOW BUTTON
	//++++++++++++++++++++++++++
	public function order_now()
	{
		error_reporting(E_ALL);
		//IS loggged in
		if ($this->session->userdata('id') && $data['product_id'] = $this->input->post('product_id', true))
		{


			$data['bus_id'] = $this->input->post('bus_id', true);
			$data['seller_id'] = $this->input->post('seller_id', true);
			$data['amount'] = $this->input->post('amount', true);
			$product_title = $this->input->post('title', false);
			$data['client_id'] = $this->session->userdata('id');

			//TEST IF ALREADY BOUGHT, DEDUCT QUANTITIES
			/*$bought = $this->db->where('products.product_id', $data['product_id']);
			$bought = $this->db->join('products_order_now','products_order_now.product_id = products.product_id', 'left');
			$bought = $this->db->get('products');

			if($bought->result()){

				$brow = $bought->row();

				if($brow->total_quantity == 1){


					if($brow->buy_now_id != null && $brow->quantity == 0){

						echo '<div class="alert alert-danger">Sorry, the item has already been purchased.</div>';
						die();

					}else{

						$this->db->where('product_id', $data['product_id']);
						$this->db->set('quantity', 'quantity-1', FALSE);
						$this->db->set('status', 'sold');
						$this->db->update('products');
					}

				}else{

					$this->db->where('product_id', $data['product_id']);
					$this->db->set('quantity', 'quantity-1', FALSE);
					$this->db->update('products');

				}



			}*/

			//Insert product buy now
			$this->db->insert('products_order_now', $data);


			//GET PRODUCT AND SELLER DETAILS and save in $row
			$s = $this->db->query("SELECT product_images.img_file, products.*,u_client.CLIENT_NAME,u_client.CLIENT_SURNAME, u_client.CLIENT_CELLPHONE, u_client.ID as buyer_id,
                                              u_client.VERIFIED, u_client.CLIENT_EMAIL
                                              FROM products
											  LEFT JOIN product_images ON product_images.product_id = products.product_id
                                              JOIN u_client on products.client_id = u_client.ID
                                              WHERE products.product_id = '" . $data['product_id'] . "'
											  GROUP BY products.product_id
                                              LIMIT 1
                                              ", false);

			$row = $s->row_array();
			$emailTO = array(array('email' => $row['CLIENT_EMAIL']));

			//GET BUYER DETAILS
			$this->db->where('ID', $data['client_id']);
			$this->db->from('u_client');
			$query = $this->db->get();
			$rowB = $query->row_array();
			$emailTO_buyer = array(array('email' => $rowB['CLIENT_EMAIL']));


			$images = '<table>
									<tbody>
										<tr class="white_box">';
			if ($row['img_file'] != null)
			{

				$images .= '<td style="width:100%;"><img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL. 'assets/products/images/' . $row['img_file'] . '&w=580&h=320" style="width:100%; "></td>';


			}
			else
			{
				$images .= '<td style="width:100%;"><img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'img/product_blank.png&w=580&h=320" style="width:100%; "></td>';

			}
			$images .= "		</tr>
									</tbody>
								</table>";
			//BUILD BODY EMAIL TO SELLER
			$body_seller = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
						Your service ' . $product_title . ' listed on My Namibia&trade; trade has been ordered. The buyer has confirmed his order and has received an email
						containing your payment instructions.
						<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">SOLD!</h1>
						' . $images . '
						<br /><br />
						If you have any questions please contact the client below.<br />
						Name: ' . $rowB['CLIENT_NAME'] . '<br/>
						Email: ' . $rowB['CLIENT_EMAIL'] . '<br/>
						Cell: ' . $rowB['CLIENT_CELLPHONE'] . '<br/><br/>
						Maintain your services from your dashboard.<br /><br />
						' . site_url('/') . 'members/<br /><br />
						Please remember to leave a review regarding this transaction and the buying party.
						<br /><br />
						Have a !tna day!<br />
						My Namibia';


			$seller_MSG['bus_id'] = 0;
			$seller_MSG['bus_id_logo'] = 1290;
			$seller_MSG['client_id_logo'] = 0;
			$seller_MSG['client_id'] = $data['seller_id'];
			$seller_MSG['nameFROM'] = $rowB['CLIENT_NAME'] . ' ' . $rowB['CLIENT_SURNAME'];
			$seller_MSG['nameTO'] = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
			$seller_MSG['email'] = $rowB['CLIENT_EMAIL'];
			$seller_MSG['emailTO'] = $row['CLIENT_EMAIL'];
			$seller_MSG['body'] = $body_seller;
			$seller_MSG['subject'] = 'New Service Request for ' . $product_title;
			$seller_MSG['status'] = 'sent';
			$seller_MSG['status_client'] = 'unread';
			$this->db->insert('u_business_messages', $seller_MSG);

			$data_view['body'] = $body_seller;
			$body_seller_final = $this->load->view('email/body_news', $data_view, true);
			$subject = 'New Service Request for ' . $product_title;
			$fromEMAIL = $seller_MSG['email'];
			$fromNAME = $seller_MSG['nameFROM'];
			$TAG = array('tags' => 'trade_order_now');

			//SEND EMAIL LINK
			$this->load->model('email_model');
			$this->email_model->send_mail($body_seller_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
			//IF CLIENT MOBILE VERIFIED
			if ($row['VERIFIED'] == 'Y')
			{

				//SEND SMS
				$msg = 'Your service ' . $this->shorten_string($product_title, 3) . ' has received a new order request on My Namibia. Open your inbox for details. http://my.na/u/p/' . $data['product_id'];

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server'    => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$user = $this->rest->get('send', array('number' => $row['CLIENT_CELLPHONE'], 'msg' => $msg), 'json');
			}


			//GET BUYER DETAILS
			//$this->db->where('ID' , $data['client_id']);
//				$this->db->from('u_client');
//				$query = $this->db->get();
//				$rowB = $query->row_array();
//				$emailTO_buyer = array(array('email' => $rowB['CLIENT_EMAIL'] ));

			//BUILD BODY EMAIL TO BUYER
			$body_buyer = 'Hi ' . $this->session->userdata('u_name') . ',<br /><br />
						We have placed your order for ' . $product_title . ' listed on My Namibia&trade;. You will be contacted by the provider.

						<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">' . $product_title . '</h1>
						' . $images . '
						<br /><br />
						<em>' . $row['email_instructions'] . '</em>
						<br />
						If you have any questions or need to contact the provider please use.<br />
						Name: ' . $row['CLIENT_NAME'] . '<br/>
						Email: ' . $row['CLIENT_EMAIL'] . '<br/>
						Cell: ' . $row['CLIENT_CELLPHONE'] . '<br/><br/>
						If the payment has not been made or the service is not submitted you will receive
						bad feedback which will impact your account and buying reputation.<br /><br />
						' . site_url('/') . 'members/<br /><br />
						Please remember to leave a review regarding this transaction and the servicing party.
						<br /><br />
						Have a !tna day!<br />
						My Namibia';

			$data_view2['body'] = $body_buyer;
			$body_buyer_final = $this->load->view('email/body_news', $data_view2, true);
			$subject_buyer = 'You have ordered ' . $product_title;
			$fromEMAIL_buyer = $row['CLIENT_EMAIL'];
			$fromNAME_buyer = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
			$TAG_buyer = array('tags' => 'trade_order_now');

			$buyer_MSG['bus_id'] = 1290;
			$buyer_MSG['bus_id_logo'] = 1290;
			$buyer_MSG['client_id_logo'] = $data['seller_id'];
			$buyer_MSG['client_id'] = $data['client_id'];
			$buyer_MSG['nameFROM'] = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
			$buyer_MSG['nameTO'] = $rowB['CLIENT_NAME'] . ' ' . $rowB['CLIENT_SURNAME'];
			$buyer_MSG['email'] = $row['CLIENT_EMAIL'];
			$buyer_MSG['emailTO'] = $rowB['CLIENT_EMAIL'];
			$buyer_MSG['body'] = $body_buyer;
			$buyer_MSG['subject'] = $subject_buyer;
			$buyer_MSG['status'] = 'sent';
			$buyer_MSG['status_client'] = 'unread';
			$this->db->insert('u_business_messages', $buyer_MSG);
			//IF CLIENT MOBILE VERIFIED
			if ($rowB['VERIFIED'] == 'Y')
			{

				//SEND SMS
				$msgB = 'Congratulations ' . $this->shorten_string($product_title, 3) . ' has been ordered. Please view the email sent to ' . $rowB['CLIENT_EMAIL'] . '. Dont forget to review the provider. http://my.na/u/p/' . $data['product_id'];

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server'    => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$userb = $this->rest->get('send', array('number' => $rowB['CLIENT_CELLPHONE'], 'msg' => $msgB), 'json');
			}

			$this->email_model->send_mail($body_buyer_final, $subject_buyer, $emailTO_buyer, $fromEMAIL_buyer, $fromNAME_buyer, $TAG_buyer);

			//redirect
			echo '<div class="alert alert-success"><h4>Wohooo!</h4>
						You have successfully ordered the service. Please check your inbox for further instructions.</div>
						<script>window.setTimeout(load_product_details, 3800);</script>
						';

		}
		else
		{

			echo '<div class="alert alert-danger">Please log in or register to order the service!</div>';

		}


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//RATE SELLER BUYER
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function review_participant($id)
	{

		$q = $this->db->query("SELECT * FROM products_buy_now
                              JOIN u_client ON u_client.ID = products_buy_now.client_id
                              WHERE products_buy_now.buy_now_id = '" . $id . "'
                             ");
		if ($q->result())
		{

			$data = $q->row();

			if ($this->session->userdata('id') == $data->client_id)
			{

				$data->type = 'Seller';
			}
			else
			{

				$data->type = 'Buyer';
			}

			$this->load->view('trade/inc/review_participant_inc', $data);

		}
		else
		{

			echo '<div class="alert">The transaction was nut fulfilled on the server.</div>';

		}

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//RATE SELLER BUYER
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function review_participant_do()
	{

		if ($client_id = $this->session->userdata('id'))
		{

			$data['seller_id'] = $this->input->post('seller_id');
			$data['buy_now_id'] = $this->input->post('buy_now_id');
			$data['product_id'] = $this->input->post('product_id');
			$data['bus_id'] = $this->input->post('bus_id');
			$data['client_id'] = $this->input->post('client_id');

			$data['review'] = $this->input->post('reviewtxt');
			$data['type'] = $this->input->post('type');

			//var_dump($this->input->post());
			$val = true;
			if (! $data['rating'] = $this->input->post('star1'))
			{

				$val = false;
				$err = 'Please select a star rating.';

			}
			elseif (strlen($data['review']) < 15)
			{

				$val = false;
				$err = 'Please provide a full review. eg: Great Seller, good communication. Will trade again.';

			}
			//IF VALID
			if ($val)
			{

				if ($data['type'] == 'Seller')
				{

					$data['client_id'] = $data['client_id'];
				}
				else
				{

					$data['client_id'] = $data['seller_id'];
				}


				$this->db->where('type', $data['type']);
				$this->db->where('client_id', $data['client_id']);
				$this->db->where('buy_now_id', $data['buy_now_id']);
				$t = $this->db->get('trade_rating');
				if ($t->result())
				{

					echo '<div class="alert alert-error">You have already reviewed this transaction.</div>';

				}
				else
				{

					$this->db->insert('trade_rating', $data);
					echo '<div class="alert alert-success">Thanks, we have received your review.</div>';
				}

				//GET CURRENT
				//$u = $this->db->query("")

			}
			else
			{

				echo '<div class="alert alert-error">' . $err . '</div>';


			}


		}

	}
	//+++++++++++++++++++++++++++
	//ADD TO WATHCLIST 
	//++++++++++++++++++++++++++	
	function add_watchlist($product_id)
	{

		$this->db->where('product_id', $product_id);
		$product = $this->db->get('products');
		if ($product->result())
		{

			$product = $product->row();

			//NOT OWN PRODUCT
			if ($this->session->userdata('id') != $product->client_id)
			{

				$this->db->where('client_id', $this->session->userdata('id'));
				$this->db->where('product_id', $product_id);
				$has = $this->db->get('products_watchlist');

				//IF Already in watchlist
				if ($has->result())
				{

					$has_row = $has->row();
					$this->db->where('watch_id', $has_row->watch_id);
					$this->db->delete('products_watchlist');

				}
				else
				{

					$data['client_id'] = $this->session->userdata('id');
					$data['product_id'] = $product_id;
					$this->db->insert('products_watchlist', $data);

				}
			}
		}

	}
	//+++++++++++++++++++++++++++
	//ADD TO WATHCLIST  TEST
	//++++++++++++++++++++++++++	
	function watch_list_test($product_id)
	{

		if ($this->session->userdata('id'))
		{


			$this->db->select('product_id, client_id');
			$this->db->where('product_id', $product_id);
			$product = $this->db->get('products');
			if ($product->result())
			{

				$product = $product->row();

				//NOT OWN PRODUCT
				if ($this->session->userdata('id') != $product->client_id)
				{

					$this->db->select('product_id');
					$this->db->where('client_id', $this->session->userdata('id'));
					$this->db->where('product_id', $product_id);
					$has = $this->db->get('products_watchlist');

					//IF Already in watchlist
					if ($has->result())
					{

						echo '<a class="btn btn-inverse" href="' . site_url('/') . 'trade/add_watchlist/' . $product_id . '" id="watch_btn" rel="tooltip" title="You are watching this item" onClick="save_watchlist"><i class="icon-remove-circle icon-white"></i> Watching</a>';

					}
					else
					{

						echo '<a class="btn btn-inverse" href="' . site_url('/') . 'trade/add_watchlist/' . $product_id . '" id="watch_btn" rel="tooltip" title="Save this item to your watchlist" onClick="save_watchlist"><i class="icon-plus icon-white"></i> Watchlist</a>';

					}
				}
				else
				{

					echo '<a class="btn btn-inverse" rel="tooltip" title="This is your item" ><i class="icon-plus icon-white"></i> Watchlist</a>';

				}
			}


		}
		else
		{


			echo '<a class="btn btn-inverse" href="' . site_url('/') . 'members/register/" rel="tooltip" title="Add to Watchlist" ><i class="icon-plus icon-white"></i> Watchlist</a>';


		}


	}

	function get_payment_instruction($product_id)
	{

		$this->db->select('email_instructions');
		$this->db->where('product_id', $product_id);
		$product = $this->db->get('products');
		if ($product->result())
		{

			$row = $product->row();

			return $row->email_instructions;
		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW EXTRAS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_extras($extras)
	{

		$extras = json_decode($extras, true);
		$output = '';
		if ($extras != null)
		{

			$output .= '<table class="table table-striped table-condensed">
					   	<thead>
							<tr>
								<th style="width:30%"></th>
								<th style="width:70%"></th>
							</tr>	
						</thead>
						<tbody>
						';

			foreach ($extras as $row => $value)
			{

				// if Array
				if (is_array($value))
				{

					//AUTOHAUS + MZ
					if ($row == 'mz_motors' || $row == 'autohaus')
					{

						//if not empty
					}
					elseif (count($value) > 0)
					{
						$output .= '<tr>
												<td>
												' . ucfirst(str_replace('_', ' ', $row)) . '
												
												</td>
												<td>
												';
						foreach ($value as $finalrow => $final_val)
						{

							$output .= '<span class="badge">' . $final_val . '</span> ';

						}
						$output .= '	</td>
											</tr>
											';
					}

				}
				elseif ($row == 'product_id')
				{

					//SKIP FEATURES KEY
				}
				elseif ($row == 'featured')
				{

				}
				elseif ($row == 'bus_id')
				{

				}
				elseif ($row == 'features')
				{

				}
				elseif ($row == 'seller_contact')
				{


				}
				else
				{

					//MAP FUNCTIONS
					if ($row == 'prop_lat' || $row == 'prop_lon' || $row == 'toggle_map' || $row == 'address' || $row == 'location')
					{


						//INVESTMENT FETAURES PROPERTY
					}
					elseif ($row == 'sole_mandate' || $row == 'cc_registered' || $row == 'PTY_Ltd' || $row == 'negotiable' || $row == 'transfer_costs_included' || $row == 'vat_inclusive' || $row == 'warranty')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_chk.png" width="20" height="20" />
											' . ucfirst(str_replace('_', ' ', $row)) . '
											</td>
										</tr>
										';
						//AGENCY	
					}
					elseif ($row == 'agency')
					{


						//SIZES PROPERTY
					}
					elseif ($row == 'erf_size' || $row == 'house_size' || $row == 'property_size' || $row == 'building_size')
					{

						$unit = substr(trim($value), strpos($value, ' '), strlen(trim($value)));
						if (is_numeric($unit))
						{
							$unit = 'm<sup>2</sup>';
						}
						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_size.png" width="20" height="20" />
											' . ucfirst(str_replace('_', ' ', $row)) . ' ' . ucfirst(number_format((int) $value)) . ' ' . $unit . '
											</td>
										</tr>
										';
						//BEDROOMS PROPERTY
					}
					elseif ($row == 'bedrooms' || $row == 'offices')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_beds.png" width="20" height="20" />
											' . ucwords($value) . ' ' . '
											</td>
										</tr>
										';

						//BATHROOMA PROPERTY
					}
					elseif ($row == 'bathrooms')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_baths.png" width="20" height="20" />
											' . ucwords($value) . ' ' . '
											</td>
										</tr>
										';

						//PARKIN PROPERTY
					}
					elseif ($row == 'parking' || $row == 'garages')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_park.png" width="20" height="20" />
											' . ucwords($value) . ' ' . '
											</td>
										</tr>
										';


						////METRES Squared
					}
					elseif ($row == 'erf_size' || $row == 'house_size')
					{

						$output .= '<tr>
											<td>
											' . ucfirst(str_replace('_', ' ', $row)) . '
											
											</td>
											<td>
											' . ucfirst(number_format((int) $value)) . ' m<sup>2</sup>
											</td>
										</tr>
										';
						//CAR SPECIFIC - doors
					}
					elseif ($row == 'doors')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL. 'img/icons/trade/icn_car_doors.png" width="20" height="20" />
											' . ucfirst(number_format((int) $value)) . ' ' . $row . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - body style
					}
					elseif ($row == 'body_style')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_body.png" width="20" height="20" />
											' . ucfirst($value) . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - fuel tyoe
					}
					elseif ($row == 'fuel_type')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_petrol.png" width="20" height="20" />
											' . ucfirst($value) . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - transmission
					}
					elseif ($row == 'transmission')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_transmission.png" width="20" height="20" />
											' . ucfirst($value) . ' ' . $row . '
											</td>
										</tr>
										';


						//CAR SPECIFIC - transmission
					}
					elseif ($row == 'cylinders')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_cylinders.png" width="20" height="20" />
											' . ucfirst(number_format((int) $value)) . ' ' . $row . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - engine size
					}
					elseif ($row == 'engine_size')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_engine.png" width="20" height="20" />
											' . ucfirst(number_format((int) $value)) . ' ' . ucfirst(str_replace('_', ' ', $row)) . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - year make
					}
					elseif ($row == 'year')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_year.png" width="20" height="20" />
											' . ucfirst((int) $value) . ' model
											</td>
										</tr>
										';
						//CAR SPECIFIC - kilometres
					}
					elseif ($row == 'kilometres')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_kilometers.png" width="20" height="20" />
											' . ucfirst(number_format((int) $value)) . ' km
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}
					elseif ($row == 'color')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_color.png" width="20" height="20" />
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}
					elseif ($row == '4wd')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_4x4.png" width="20" height="20" />
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';


						//CAR SPECIFIC - color
					}
					elseif ($row == 'owners')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_car_owner.png" width="20" height="20" />
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';
						//MONEY FORMAT	
					}
					elseif ($row == 'valuation')
					{

						$output .= '<tr>
											<td colspan="2">
											<img src="' . NA_SITE_URL . 'img/icons/trade/icn_cash.png" width="20" height="20" />
											N$ ' . ucfirst(number_format((int) $value)) . '
											</td>
										</tr>
										';


					}
					else
					{

						$output .= '<tr>
											<td>
											' . ucfirst(str_replace('_', ' ', $row)) . '
											
											</td>
											<td>
											' . ucfirst($value) . '
											</td>
										</tr>
										';

					}


				}


			}
			$output .= '</tbody>
			   			</table>';

			return $output;

		}
		//var_dump($extras);
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW EXTRAS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_extras_short($extras)
	{

		$extras = json_decode($extras, true);
		$output = '';
		$x = 0;
		if ($extras != null)
		{

			$output .= '<table class="table table-striped table-condensed" style="width:100%">
					   	<thead>
							<tr>
								<th style="width:30%"></th>
								<th style="width:70%"></th>
							</tr>	
						</thead>
						<tbody>
						';

			foreach ($extras as $row => $value)
			{


				if ($x > 3)
				{

					$output .= '</tbody>
								</table>';

					return $output;
					// if Array	
				}
				elseif (is_array($value))
				{

					//AUTOHAUS + MZ
					if ($row == 'mz_motors' || $row == 'autohaus')
					{

						//if not empty
					}
					elseif (count($value) > 0)
					{
						$output .= '<tr>
												<td>
												' . ucfirst(str_replace('_', ' ', $row)) . '
												
												</td>
												<td>
												';
						$y = 0;
						foreach ($value as $finalrow => $final_val)
						{
							if ($y < 2)
							{
								$output .= '<span class="badge">' . $final_val . '</span> ';
							}
							$y++;
						}
						$output .= '	</td>
											</tr>
											';
					}

				}
				elseif ($row == 'product_id')
				{

				}
				elseif ($row == 'features')
				{

				}
				elseif ($row == 'bus_id')
				{

					//AUTOHAUS
				}
				elseif ($row == 'mz_motors' || $row == 'autohaus')
				{


				}
				else
				{

					//MAP FUNCTIONS
					if ($row == 'prop_lat' || $row == 'prop_lon' || $row == 'toggle_map' || $row == 'address' || $row == 'location')
					{
						$x = $x - 1;
						//INVESTMENT FETAURES PROPERTY
					}
					elseif ($row == 'sole_mandate' || $row == 'cc_registered' || $row == 'PTY_Ltd' || $row == 'negotiable' || $row == 'transfer_costs_included' || $row == 'vat_inclusive')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_chk.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px"  width="20" height="20"/>
											' . ucfirst(str_replace('_', ' ', $row)) . '
											</td>
										</tr>
										';
						//AGENCY	
					}
					elseif ($row == 'agency')
					{
						$x = $x - 1;
						//SIZES PROPERTY
					}
					elseif ($row == 'erf_size' || $row == 'house_size' || $row == 'property_size' || $row == 'building_size')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_size.png'));
						$unit = substr(trim($value), strpos($value, ' '), strlen(trim($value)));
						if (is_numeric($unit))
						{
							$unit = 'm<sup>2</sup>';
						}
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst(str_replace('_', ' ', $row)) . ' ' . ucfirst(number_format((int) $value)) . ' ' . $unit . '
											</td>
										</tr>
										';

						//BEDROOMS PROPERTY
					}
					elseif ($row == 'bedrooms' || $row == 'offices')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_beds.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucwords($value) . ' 
											</td>
										</tr>
										';

						//BATHROOMA PROPERTY
					}
					elseif ($row == 'bathrooms')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_baths.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucwords($value) . ' 
											</td>
										</tr>
										';

						//PARKIN PROPERTY
					}
					elseif ($row == 'parking' || $row == 'garages')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_park.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											
									
											' . $value . ' ' . ucwords($row) . '
											</td>
										</tr>
										';


						//SKIP FEATURES KEY
					}
					elseif ($row == 'featured')
					{

						$x = $x - 1;
						////METRES Squared
					}
					elseif ($row == 'erf_size' || $row == 'house_size' || $row == 'property_size')
					{

						$output .= '<tr>
											<td>
											' . ucfirst(str_replace('_', ' ', $row)) . '
											
											</td>
											<td>
											' . ucfirst(number_format((int) $value)) . ' m<sup>2</sup>
											</td>
										</tr>
										';
						//CAR SPECIFIC - doors
					}
					elseif ($row == 'doors')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_doors.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst(number_format((int) $value)) . ' ' . $row . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - body style
					}
					elseif ($row == 'body_style')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_body.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst($value) . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - fuel tyoe
					}
					elseif ($row == 'fuel_type')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_petrol.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst($value) . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - transmission
					}
					elseif ($row == 'transmission')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_transmission.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst($value) . '
											</td>
										</tr>
										';


						//CAR SPECIFIC - transmission
					}
					elseif ($row == 'cylinders')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_cylinders.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20" />
											' . ucfirst(number_format((int) $value)) . ' ' . $row . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - engine size
					}
					elseif ($row == 'engine_size')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_engine.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst(number_format((int) $value)) . ' ' . $row . '
											</td>
										</tr>
										';
						//CAR SPECIFIC - year make
					}
					elseif ($row == 'year')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_year.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst((int) $value) . ' model
											</td>
										</tr>
										';
						//CAR SPECIFIC - kilometres
					}
					elseif ($row == 'kilometres')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_kilometers.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst(number_format((int) $value)) . ' km
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}
					elseif ($row == 'color')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_color.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}
					elseif ($row == '4wd')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_4x4.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20" />
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}
					elseif ($row == 'owners')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_car_owner.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											' . ucfirst($value) . ' 
											</td>
										</tr>
										';
						//MONEY FORMAT	
					}
					elseif ($row == 'valuation')
					{
						$img = base64_encode(file_get_contents(NA_SITE_URL . 'img/icons/trade/icn_cash.png'));
						$output .= '<tr>
											<td colspan="2">
											<img src="data:image/png;base64,' . $img . '" style="width:20px;height:20px" width="20" height="20"/>
											
										
											N$ ' . ucfirst(number_format((double) $value)) . '
											</td>
										</tr>
										';


					}
					else
					{

						$output .= '<tr>
											<td>
											' . ucfirst(str_replace('_', ' ', $row)) . '
											
											</td>
											<td>
											' . ucfirst($value) . '
											</td>
										</tr>
										';

					}
					$x++;
				}


			}
			$output .= '</tbody>
			   			</table>';

			return $output;

		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET IMAGES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_images_mobile($product_id, $size)
	{

		//get images
		$this->db->order_by('sequence', 'ASC');
		$this->db->where('product_id', $product_id);
		$images = $this->db->get('product_images');

		$data = '';
		//GET MAIN IMAGE				
		if ($images->result())
		{

			//SHOW MAIN PIC
			$x = 0;

			$data .= ' <style type="text/css"> #owl-demo .owl-item div{padding:2px;}
							
							#owl-demo .owl-item img{display: block; width: 100%;height: auto;}
 							</style>
							<link href="' . NA_SITE_URL . 'js/owl-carousel/owl.carousel.css" rel="stylesheet">
							<div id="owl-demo" class="owl-carousel">';

			foreach ($images->result() as $row)
			{

				//IF IMAGE IS EDITED
				$rand = '';
				$temp = '';
				if ($row->edited != 'N')
				{
					$rand = '?ed=' . $row->edited;
					$temp = $row->edited;
				}
				$active = '';
				if ($x == 0)
				{

					$active = 'active';
					$single = CDN_URL . 'assets/products/images/' . $row->img_file . $rand;
				}
				$data .= '<div class="item ' . $active . ' white_box padding2" data-slide-number="' . $x . '"> 
													<img onclick="img_show(' . "'" . $row->img_file . $rand . "'" . ')" class="image_' . $x . '" itemprop="image" data-original="" src="' . CDN_URL . 'assets/products/images/' . $row->img_file . $rand . '" />
												  </div>';
				$x++;
			}
			$data .= '
										
                           </div>
                          ';
			$z = 0;
			$y = 0;


			$data .= '
						 ';

			$btnhtml = '["<a class=' . "'btn btn-inverse pull-left clearfix'>Prev</a>" . '","<a class=' . "'btn btn-inverse pull-right clearfix'" . '>Next</a>"]';
			$data .= "<script src='" . NA_SITE_URL . "js/owl-carousel/owl.carousel.min.js'></script>
							<script data-cfasync='false'>
							$(document).ready(function() {
								$('#owl-demo').owlCarousel({
									autoPlay : 3000,
									stopOnHover : true,
									navigation:false,
									pagination: true,
									paginationSpeed : 1000,
									goToFirstSpeed : 2000,
									lazyLoad : true,
									singleItem : true,
									autoHeight : true,
									transitionStyle:'fade'
								  });
							});
							function change_pic(id){
								var image = $('.image_'+id);
								image.attr('src', image.attr('data-original'));
								$('#prod_carousel').carousel(id);
							}
												
					</script>";


		}
		else
		{

			if ($size == 'big')
			{

				$data .= '<div  class="white_box padding10"><img src="' . NA_SITE_URL . 'img/product_blank_big.png" /></div>';
				$single = NA_SITE_URL . 'img/product_blank_big.png';
			}
			else
			{

				$data .= '<img src="' . NA_SITE_URL . 'img/product_blank.jpg" />';
				$single = NA_SITE_URL . 'img/product_blank.jpg';
			}


		}

		$data1['images'] = $data;
		$data1['single'] = $single;

		return $data1;


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET IMAGES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_images($product_id, $size)
	{

		//get images
		$this->db->order_by('sequence', 'ASC');
		$this->db->where('product_id', $product_id);
		$images = $this->db->get('product_images');

		$data = '';
		//GET MAIN IMAGE				
		if ($images->result())
		{

			//SHOW MAIN PIC
			$x = 0;

			$data .= '
                        <!-- Top part of the slider -->
                        <div class="row-fluid">
                            <div class="span12" id="carousel-bounding-box">
                                <div class="carousel slide" id="prod_carousel">
                                    <!-- Carousel items -->
                                    <div class="carousel-inner">';

			foreach ($images->result() as $row)
			{

				//IF IMAGE IS EDITED
				$rand = '';
				$temp = '';
				if ($row->edited != 'N')
				{
					$rand = 'ed=' . $row->edited;
					$temp = $row->edited;
				}
				$active = '';
				if ($x == 0)
				{

					$active = 'active';
					$single = CDN_URL . 'assets/products/images/' . $row->img_file . '?' . $rand;
				}
				$med = NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row->img_file . '&w=700&h=520&' . $rand;

				$data .= '<div style="border:2px solid #fff" class="item ' . $active . ' white_box" data-slide-number="' . $x . '">
													<a href="' . CDN_URL . 'assets/products/images/' . $row->img_file . '?' . $rand . '" rel="prettyPhoto[gal]" ><img class="lazy image_' . $x . '" itemprop="image" data-original="' . $med . '" src="' . NA_SITE_URL . 'img/deal_place_load.gif" /></a>
												  </div>';
				$x++;
			}
			$data .= '</div>
										<!-- Carousel nav -->
										<a class="left carousel-control" href="#prod_carousel" data-slide="prev">‹</a>
										<a class="right carousel-control" href="#prod_carousel" data-slide="next">›</a>
                                </div>
                            </div>
						</div><!--/Slider-->';
			$z = 0;
			$y = 0;
			//LOOP NAVIGATION FOR THUMBNAILS
			$data .= '
						<div id="thumb_nav_carousel" class="carousel slide hidden-phone">
						<!-- Carousel items -->
						<div class="carousel-inner">';

			foreach ($images->result() as $row2)
			{

				//IF IMAGE IS EDITED
				$rand = '';
				$temp = '';
				if ($row2->edited != 'N')
				{
					$rand = '?ed=' . $row2->edited;
					$temp = $row2->edited;
				}

				if ($y == 0)
				{

					$data .= '
								  <div class="item active">
									<div class="row-fluid">
								   ';

				}
				elseif ($y % 4 == 0)
				{

					$data .= '
									</div><!--/row-fluid-->
								  </div><!--/item-->
								  <div class="item">
									<div class="row-fluid">
								   ';
				}


				$data .= '
									  <div class="span3 padding2 white_box hidden-mobile"><a href="javascript:void(0)" onclick="change_pic(' . $y . ')" class="item_no' . $y . '" data-target="' . CDN_URL . 'assets/products/images/' . $row2->img_file . $rand . '"><img itemprop="image" src="' . NA_SITE_URL . 'img/timbthumb.php?src=' .CDN_URL. 'assets/products/images/' . $row2->img_file . '&w=190&h=130' . $rand . '" alt="Image" style="max-width:100%;"></a></div>
									 
									';
				$y++;


			}

			$data .= '  </div><!--/row-fluid-->
					 </div><!--/item-->
				   </div><!--/carousel-inner-->
						 
						<a class="left carousel-control" href="#thumb_nav_carousel" data-slide="prev">‹</a>
						<a class="right carousel-control" href="#thumb_nav_carousel" data-slide="next">›</a>
						</div><!--/thumb_nav_carousel-->';


			$data .= "<script data-cfasync='false'>
							
							$(document).ready(function(){
								
						 	});
							function change_pic(id){
								var image = $('.image_'+id);
								image.attr('src', image.attr('data-original'));
								$('#prod_carousel').carousel(id);
							}
												
					</script>";


		}
		else
		{

			if ($size == 'big')
			{

				$data .= '<div  class="white_box padding10"><img src="' . NA_SITE_URL . 'img/product_blank_big.png" /></div>';
				$single = NA_SITE_URL . 'img/product_blank_big.png';
			}
			else
			{

				$data .= '<img src="' . NA_SITE_URL . 'img/product_blank.jpg" />';
				$single = NA_SITE_URL . 'img/product_blank.jpg';
			}


		}

		$data1['images'] = $data;
		$data1['single'] = $single;

		return $data1;


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET IMAGES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_images_mosaic($images, $size)
	{

		$imgA = explode(',', $images);


		//GET MAIN IMAGE				
		if (count($imgA) > 0)
		{

			//SHOW MAIN PIC
			$x = 0;

			$data['str'] = '<ul class="thumbnails">';
			foreach ($imgA as $row)
			{

				//IF IMAGE IS EDITED
				$rand = '';
				$temp = '';
				/*if($row->edited != 'N'){
						$rand = '?ed='.$row->edited;
						$temp = $row->edited;
					}*/

				//FIRST BIG SPAN
				if ($x == 0)
				{

					$data['str'] .= '<li class="span6  mosaic">
								  <a href="#"  style="background:#fff;">
									<img alt="" style="min-height:280px;min-width:380px" class="white_box padding2" src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row . '&w=420&h=350' . $rand . '" >
								  </a>
								</li>';
					$data['file'] = NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row . '&w=420&h=330';

				}
				elseif ($x <= 4)
				{

					$data['str'] .= '<li class="span3 hidden-phone">
								  <a href="#"  style="background:#fff;">
									<img alt="" class="white_box padding2" src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $row . '&w=190&h=150' . $rand . '">
								  </a>
								</li>';

				}

				$x++;
			}
			$data['str'] .= '</ul>';

		}
		else
		{

			$data['str'] = '';
			$data['file'] = NA_SITE_URL . 'img/timbthumb.php?src=' . NA_SITE_URL . 'img/product_blank.jpg';

		}

		return $data;
	}


	//Shorten Price
	function smooth_price($price)
	{

		if (strpos($price, '.00'))
		{

			$price = str_replace('.00', '', $price);
		}

		if (strlen(trim($price)) > 8)
		{

			//$price = number_format($price, 2, ',', ' ');
			$price1 = number_format($price, 2);

		}
		elseif (strlen($price) > 7)
		{

			$price1 = number_format($price, 2);

		}
		elseif (strlen($price) > 6)
		{

			$price1 = number_format($price, 2);

		}
		elseif (strlen($price) > 5)
		{

			$price1 = number_format($price, 2);

		}
		elseif (strlen($price) > 3)
		{

			$price1 = number_format($price, 2);

		}
		else
		{

			$price1 = number_format($price, 2);
		}

		return $price1;
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET CURRENT BID
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_current_bid($bid)
	{

		/*$this->db->where('product_id', $product_id);
		$this->db->where('type', 'bid');
		$this->db->order_by('amount', 'DESC');
		$this->db->limit('1');
		$bid = $this->db->get('product_auction_bids');*/

		if ($bid)
		{


			$data['current'] = $bid;
			$data['price'] = $bid + 5;
			$data['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price"> ' . $this->smooth_price($bid) . '</span>';

			return $data;

		}
		else
		{

			$data['current'] = 0;
			$data['price'] = 5;
			$data['str'] = 'No Bids';

			return $data;

		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BIDDING HISTORY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_bid_history($product_id)
	{

		$this->db->where('product_id', $product_id);
		$this->db->where('type', 'bid');
		$this->db->order_by('amount', 'DESC');
		$this->db->limit('5');
		$bid = $this->db->get('product_auction_bids');

		if ($bid->result())
		{

			$x = 0;
			$output = '';

			foreach ($bid->result() as $row)
			{


				$prev = $row->amount;
				if ($x == 0)
				{

					$max = $row->amount;
					$prev = '';
					$client_id = $row->client_id;
				}

				$client = $this->get_user_avatar($row->client_id);
				$bid = $row->amount;
				$amount = $bid - $prev;

				$output .= '
						<div class="media well well-mini">
							  <a class="pull-left" href="#" title="Placed on ' . date('F j, Y', strtotime($row->datetime)) . '" rel="tooltip">
							    <span class="avatar-overlay60"></span>
								<img class="media-object" style="border:1px solid #333333;width:60px; margin-right:10px; height:60px" src="' . $client['image'] . '">
							  </a>
							  <div class="media-body">
							  <a title="' . $client['name'] . ' placed a bid of ' . $bid . '" rel="tooltip" class="btn btn-success pull-right"><i class="icon icon-plus icon-white"></i>' . $bid . '</a> 
						
							  
							   <font style="font-size:14px;">' . $client['name'] . '</font>	<br/>
								
							   <font style="font-size:10px;">
							  ' . date('g:i a F j, Y', strtotime($row->datetime)) . '</font>
							  <br />Current Bid: N$ = ' . $bid . '
							  </div>
							 
						 </div>';
				$x++;


			}
			$head = '<h3 class="na_script">Bid History</h3>';

			$auto_bid_txt = $this->get_auto_bid_note($product_id, $max);

			//SHOW IF USER IS LEADING
			if ($client_id == $this->session->userdata('id'))
			{


				$head = '<h3 class="na_script">Bid History</h3>
				<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
						<h3 class="na_script">You are leading this auction</h3>
						Your <strong>leading bid</strong> is currently at N$ ' . $max . '<br />' .
					$auto_bid_txt . '
				</div>';

			}
			else
			{
				$head = '<h3 class="na_script">Bid History</h3>';
				if ($auto_bid_txt != '')
				{

					$head .= '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
						' .
						$auto_bid_txt . '
							</div>';
				}


			}

			return $head . $output;

		}
		else
		{

			return '';

		}

	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT AUTO BID 
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_auto_bid_note($product_id, $amount)
	{


		//SHOW AUTO BID
		$this->db->where('type', 'auto');
		$this->db->where('product_id', $product_id);
		$this->db->where('client_id', $this->session->userdata('id'));
		$this->db->order_by('bid_id', 'DESC');
		$this->db->limit(1);
		$auto_bid = $this->db->get('product_auction_bids');
		$auto_bid_txt = '';
		if ($auto_bid->result())
		{

			$auto_bid_row = $auto_bid->row();
			if ($auto_bid_row->amount > $amount)
			{

				$auto_bid_txt = 'You have got a auto bid up to N$ ' . $auto_bid_row->amount;

			}


		}

		return $auto_bid_txt;

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT PAGE BREADCRUMBS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location = '', $suburb = '')
	{


		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if (! $output = $this->cache->get('trade/show_categories_breadcrumb_' . $main_cat_id . '_' . $sub_cat_id . '_' . $sub_sub_cat_id . '_' . $sub_sub_sub_cat_id . '_' . $location . '_' . $suburb))
		{
			$output = '';
			$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . '" itemprop="url"><span itemprop="title">My</span></a><span class="divider">/</span></li>';

			$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'trade/" itemprop="url"><span itemprop="title">Trade</span></a><span class="divider">/</span></li>';

			if ($main_cat_id != 0)
			{

				$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($main_cat_id)) . '/"  itemprop="url"><span itemprop="title">' . $this->get_category_name($main_cat_id) . '</span></a><span class="divider">/</span></li>';

				if ($sub_cat_id != 0)
				{

					$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($main_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/"  itemprop="url"><span itemprop="title">' . $this->get_category_name($sub_cat_id) . '</span></a><span class="divider">/</span></li>';

					if ($sub_sub_cat_id != 0)
					{

						$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($main_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_cat_id)) . '/"  itemprop="url"><span itemprop="title">' . $this->get_category_name($sub_sub_cat_id) . '</span></a><span class="divider">/</span></li>';

						if ($sub_sub_sub_cat_id != 0)
						{

							$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($main_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_sub_cat_id)) . '/"  itemprop="url"><span itemprop="title">' . $this->get_category_name($sub_sub_sub_cat_id) . '</span></a><span class="divider">/</span></li>';

							if ($location != '' && $location != 'national')
							{

								$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($main_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_sub_cat_id)) . '/"  itemprop="url"></a><span itemprop="title">' . ucwords($location) . '</span></li>';
							}

						}
					}


				}

			}
			$this->cache->save('trade/show_categories_breadcrumb_' . $main_cat_id . '_' . $sub_cat_id . '_' . $sub_sub_cat_id . '_' . $sub_sub_sub_cat_id . '_' . $location . '_' . $suburb, $output, 3600);
		}
		//$this->output->set_output($output);
		echo $output;


	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+LOAD WATCHLIST
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function load_watchlist()
	{

		$id = $this->session->userdata('id');
		$pSQL = "SELECT products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id, product_categories.category_name,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN products_watchlist ON products_watchlist.product_id = products.product_id
                                      JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                      ";
		$query = $this->db->query($pSQL . " WHERE products_watchlist.client_id = '" . $id . "' AND products_watchlist.bus_id = '0' GROUP BY products.product_id ORDER BY products_watchlist.product_id DESC ", false);


		if ($query->result())
		{

			echo '
			<h4>My Watchlist<small> Your current items on watch</small></h4>
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped datatable" id="" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:8%;min-width:40px"></th>
           				<th style="width:20%">Title</th>
						<th style="width:12%">Type</th>
						<th style="width:20%">Price</th>
						<th style="width:10%">End</th>

						<th style="width:20%;min-width:130px"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row)
			{


				if ($row->img_file != null)
				{


					$img = CDN_URL . 'assets/products/images/' . $row->img_file;
				}
				else
				{

					$img = CDN_URL . 'img/product_blank.jpg';
				}

				//Check Price
				//Fixed price
				if ($row->listing_type == 'S')
				{

					$type = '<span class="label">Buy Now</span>';
					$price = 'N$ ' . $row->sale_price;

					$bids = '';
					//Auction	
				}
				else
				{

					//GET CURRENT BID
					$bids = $this->get_current_bid($row->current_bid);
					$type = '<span class="label">Auction</span>';
					$price = 'Current Bid: N$ ' . $bids['current'] . ' Res: ' . $row->reserve;

				}

				if ($row->is_active == 'Y')
				{

					$active = '<a class="btn btn-mini btn-success" title="Product is live" rel="tooltip"><i class="icon-ok icon-white"></i></a>';

				}
				else
				{

					$active = '<a class="btn btn-mini btn-warning" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';

				}

				if (date('Y-m-d', strtotime($row->end_date)) < date('Y-m-d'))
				{

					$active = '<a class="btn btn-mini btn-warning" title="Item is expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';

				}


				echo '<tr>
						<td style="width:8%;min-width:40px"><img src="' . $img . '" 
							alt="" style="width:80%;height:auto" class="img-polaroid"/> </td>
						<td style="width:20%">' . $this->get_cat_name($row->sub_sub_cat_id) . ' > ' . $row->title . '</td>
						<td style="width:12%">' . $type . '</td>
						<td style="width:15%">' . $price . '</td>
						<td style="width:13%">' . date('Y-m-d', strtotime($row->end_date)) . '</td>

					  	<td style="width:20%;min-width:130px;text-align:right">  
							'
					. $active .
					'
							<!--<a onclick="update_product(' . $row->product_id . ');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a> 
							<a onclick="delete_product(' . $row->product_id . ');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a>-->
							<a href="' . site_url('/') . 'product/' . $row->product_id . '/" target="_blank" class="btn btn-mini btn-inverse"> View</a></td>
					  </tr>';
			}
			$exit_str = "javascript:$('#modal-product-delete').modal('hide')";
			$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div id="modal-product-delete" class="modal hide fade">

					<div class="modal-header">
					  <a href="#" onclick="' . $exit_str . '" class="close">&times;</a>
					  <h3>Delete the Product</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current product and all of its resources?</p>
						
					</div>
				
					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a> 
					  <a href="#" onclick="' . $exit_str . '" class="btn btn-secondary">No</a>
					</div>
				 
				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script data-cfasync="false" type="text/javascript">
					$("[rel=tooltip]").tooltip();		
					$(".datatable").dataTable( {
					  "sDom": "' . $table_str . '",
					  "sPaginationType": "bootstrap",
					  "oLanguage": {
						  "sLengthMenu": "_MENU_ records per page"
					  },
					  "aaSorting":[],
					  "bSortClasses": false
	
					} );
					function update_product(id){
	
							var cont = $("#admin_content");
							$.get("' . site_url('/') . 'trade/update_product/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);
									  
							});
							
					}
					function get_questions(id){
	
							var cont = $("#admin_content");
							$.get("' . site_url('/') . 'trade/product_questions/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);
									  
							});
							
					}
					function delete_product(id){
	
						$("#modal-product-delete").appendTo("body").unbind("show").bind("show", function()  {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");
								
								removeBtn.click(function(e) { 
										
									e.preventDefault();
					
											$.ajax({
												type: "get",
												url: "' . site_url('/') . 'trade/delete_product/"+id ,
												success: function (data) {
													 
													 $("#modal-product-delete").modal("hide");
													 $("#msg").html(data);
													 load_trade("products", "live");	
												}
											});
								});
						}).modal({ backdrop: true });
					}	
				</script>';

		}
		else
		{

			$str = "'sell'";
			echo '<div class="alert">
				
				 <h4>No Items in your watchlist</h4> No items have been added. Save items to your watchlist to access them quick and easily.<br /><br />
				
				</div>';


		}


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+LOAD SELL AN ITEM 1
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function load_sell()
	{

		$this->load->view('trade/inc/list_groups');

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+LIST ALL CATEGORIES 1
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function list_categories1_btns()
	{

		$test = $this->db->where('main_cat_id', '0');
		$test = $this->db->get('product_categories');

		if ($test->num_rows() > 0)
		{

			foreach ($test->result() as $row)
			{

				$cat_id = $row->cat_id;
				echo '<a onclick="load_sub_cats(this.value)" value="' . $cat_id . '" href="javascript:void(0);" style="margin:5px" class="btn"><i class="icon-plus"></i> ' . $row->category_name . '</a>';

			}
			echo '<hr />
				  <div id="sub_category" style="height:300px"></div>
			      <a id="add_cat" class="btn pull-right disabled"><i class="icon-plus"></i> Add category</a>';

		}
		else
		{

			echo '<span class="label">No category</span>';


		}

	}

	public function list_categories1()
	{

		$test = $this->db->where('main_cat_id', '0');
		$test = $this->db->get('product_categories');

		if ($test->num_rows() > 0)
		{
			echo '<select style="height:300px;float:left" class="span12" multiple="multiple">';
			foreach ($test->result() as $row)
			{

				$cat_id = $row->cat_id;
				echo '<option onclick="load_ajax_product_cat(this.value, ' . $bus_id . ')" value="' . $cat_id . '">' . $row->category_name . '</option>';

			}

			echo '</select>
			<div id="sub_category" style="height:300px"></div>
			<hr />
			<a id="add_cat" class="btn pull-right disabled"><i class="icon-plus"></i> Add category</a>
			';

		}
		else
		{

			echo '<span class="label">No category</span>';


		}

	}


	//++++++++++++++++++++++++++++++++++++
	//GET CATEGORY NAMES
	//++++++++++++++++++++++++++++++++++++
	public function get_cat_names($row)
	{

		if ($row['main_cat_id'] == 0)
		{

			$str = $this->get_cat_name($row['main_cat_id']);

			return $str;

		}
		elseif ($row['sub_cat_id'] == 0)
		{

			$str = $this->get_cat_name($row['main_cat_id']);

			return $str;

		}
		elseif ($row['sub_sub_cat_id'] == 0)
		{

			$str = $this->get_cat_name($row['main_cat_id']) . ' > ' . $this->get_cat_name($row['sub_cat_id']);

			return $str;

		}
		elseif ($row['sub_sub_sub_cat_id'] == 0)
		{

			$str = $this->get_cat_name($row['main_cat_id']) . ' > ' . $this->get_cat_name($row['sub_cat_id']) . ' > ' . $this->get_cat_name($row['sub_sub_cat_id']);

			return $str;

		}
		else
		{

			$str = $this->get_cat_name($row['main_cat_id']) . ' > ' . $this->get_cat_name($row['sub_cat_id']) . ' > ' . $this->get_cat_name($row['sub_sub_cat_id'])
				. ' > ' . $this->get_cat_name($row['sub_sub_sub_cat_id']);

			return $str;

		}
	}

	//++++++++++++++++++++++++++++++++++++
	//GET CATEGORY NAMES
	//++++++++++++++++++++++++++++++++++++
	public function get_cat_name($cat_id)
	{

		$this->db->where('cat_id', $cat_id);
		$query = $this->db->get('product_categories');

		if ($query->result())
		{

			$res = $query->row_array();

			return $res['category_name'];

		}
		else
		{

			return '';

		}


	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+BUILD CATEGORY SEARCH
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function build_typehead($bus_id, $type)
	{


		$str = array();
		$q = $this->input->get('q');
		$test = $this->db->query("SELECT product_categories.cat_id as ID, product_categories.category_name as CATEGORY_NAME,
									product_categories.main_cat_id, product_categories.sub_cat_id,product_categories.sub_sub_cat_id, product_categories.sub_sub_sub_cat_id,
									tableA.CATEGORY_NAME as maincatNAME,
									tableB.CATEGORY_NAME as subcatNAME,
									tableC.CATEGORY_NAME as subsubcatNAME,
									tableD.CATEGORY_NAME as subsubsubcatNAME
									FROM product_categories
									JOIN product_categories as tableA ON tableA.cat_id = product_categories.main_cat_id
									LEFT JOIN product_categories as tableB ON tableB.cat_id = product_categories.sub_cat_id
									LEFT JOIN product_categories as tableC ON tableC.cat_id = product_categories.sub_sub_cat_id
									LEFT JOIN product_categories as tableD ON tableD.cat_id = product_categories.sub_sub_sub_cat_id

									ORDER BY product_categories.sub_sub_cat_id  DESC", false);
		//WHERE product_categories.category_name LIKE '%".$q."'
		$x = 1;
		//$str .= '[';
		if ($test->result())
		{

			foreach ($test->result() as $row)
			{

				$strt = '';
				if ($row->main_cat_id != 0)
				{
					$strt .= '' . $row->maincatNAME . ' > ';
					$cat1 = $row->main_cat_id;
					$cat1name = $row->maincatNAME;

					if ($row->sub_cat_id != 0)
					{

						$strt .= $row->subcatNAME . ' > ';
						$cat2 = $row->sub_cat_id;
						$cat2name = $row->subcatNAME;

						if ($row->sub_sub_cat_id != 0)
						{

							$strt .= $row->subsubcatNAME . ' > ';
							$cat3 = $row->sub_sub_cat_id;
							$cat3name = $row->subsubcatNAME;

							if ($row->sub_sub_sub_cat_id != 0)
							{

								$strt .= $row->subsubsubcatNAME . ' > ';
								$cat4 = $row->sub_sub_sub_cat_id;
								$cat4name = $row->subsubsubcatNAME;

							}
							else
							{
								$cat4 = $row->ID;
								$cat4name = $row->CATEGORY_NAME;

							}

						}
						else
						{
							$cat3 = $row->ID;
							$cat3name = $row->CATEGORY_NAME;
							$cat4 = 0;
							$cat4name = '_';

						}

					}
					else
					{
						$cat2 = $row->ID;
						$cat2name = $row->CATEGORY_NAME;
						$cat3 = 0;
						$cat3name = '_';
						$cat4 = 0;
						$cat4name = '_';
					}


				}
				else
				{
					$cat1 = $row->ID;
					$cat1name = $row->CATEGORY_NAME;

				}
				$name = $row->CATEGORY_NAME;
				$array = explode(" ", str_replace(' > ', ' ', $strt . ' ' . $name));
				$temp = implode('","', $array);
				$t = array(

					"link1"  => "javascript:load_ajax_product_cat(" . $cat1 . ",'" . $cat1name . "'," . $cat2 . ",'" . $cat2name . "'," . $cat3 . ",'" . $cat3name . "'," . $cat4 . ",'" . $cat4name . "'," . $bus_id . ",'" . $type . "')",
					"value"  => $name,
					"body"   => $strt,
					"tokens" => $array

				);
				array_push($str, $t);

				$x++;
			}

		}
		echo json_encode($str);

		$this->output->set_content_type('application/json');
	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+LIST ALL CATEGORIES 1
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//Get Product` Categories
	function load_product_categories($bus_id, $ultype)
	{

		$cat1 = $this->input->post('cat1', true);
		$cat1name = str_replace("'", " ", $this->input->post('cat1name', true));
		$cat2 = $this->input->post('cat2', true);
		$cat2name = str_replace("'", " ", $this->input->post('cat2name', true));
		$cat3 = $this->input->post('cat3', true);
		$cat3name = str_replace("'", " ", $this->input->post('cat3name', true));
		$cat4 = $this->input->post('cat4', true);
		$cat4name = str_replace("'", " ", $this->input->post('cat4name', true));

		if (! $ltype = $this->input->post('type'))
		{
			if (! $ltype = $this->input->get('type'))
			{

				if ($ultype != '')
				{

					$ltype = $ultype;
				}
				else
				{

					$ltype = 'general';
				}

			}


		}


		//SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
		if ($cat4 > 0)
		{

			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, sub_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_sub_sub_cat_id = '" . trim($cat4) . "'", false);
			$type = '<a href="#" class="btn btn-inverse disabled"> ' . $cat1name . ' <i class="icon-chevron-right icon-white"></i></a> 
					 <a href="#" class="btn btn-inverse disabled"> ' . $cat2name . ' <i class="icon-chevron-right icon-white"></i></a> 
					 <a href="#" class="btn btn-inverse disabled"> ' . $cat3name . ' <i class="icon-chevron-right icon-white"></i></a>
					 <a href="#" class="btn btn-inverse disabled">' . $cat4name . '</a>';

		}
		elseif ($cat3 > 0)
		{

			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, sub_cat_id, sub_sub_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_sub_cat_id = '" . $cat3 . "' AND sub_sub_sub_cat_id = '0'", false);
			$type = '
					 <a href="#" class="btn btn-inverse disabled"> ' . $cat1name . ' <i class="icon-chevron-right icon-white"></i></a> 
					 <a href="#" class="btn btn-inverse disabled"> ' . $cat2name . ' <i class="icon-chevron-right icon-white"></i></a> 
					 <a href="#" class="btn btn-inverse disabled">' . $cat3name . '</a>';

		}
		elseif ($cat2 > 0)
		{

			$query = $this->db->query("SELECT cat_id as ID, sub_cat_id, main_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_cat_id = '" . $cat2 . "'  AND sub_sub_cat_id = '0'", false);
			$type = '
			          <a href="#" class="btn btn-inverse disabled"> ' . $cat1name . ' <i class="icon-chevron-right icon-white"></i></a> 
					  <a href="#" class="btn btn-inverse disabled">' . $cat2name . ' <i class="icon-chevron-right icon-white"></i></a>';

		}
		elseif ($cat1 > 0)
		{

			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, category_name as CATEGORY_NAME FROM product_categories WHERE main_cat_id = '" . $cat1 . "' AND sub_cat_id = '0'", false);
			$type = ' 
					 <a href="#" class="btn btn-inverse disabled">' . $cat1name . ' <i class="icon-chevron-right icon-white"></i></a>';
		}
		else
		{

			$query = $this->db->query("SELECT cat_id as ID, category_name as CATEGORY_NAME FROM product_categories WHERE main_cat_id = '0'", false);
			$type = '';
			echo '<div class="clearfix" style="height:40px;"></div>';
		}

		if ($cat1 == 0)
		{

		}
		else
		{
			$btn_next = $cat1 . ", '" . $cat1name . "', " . $cat2 . ", '" . $cat2name . "', " . $cat3 . ", '" . $cat3name . "', " . $cat4 . ", '" . $cat4name . "'";
			$btn_back = $cat1 . ", '" . $cat1name . "', " . $cat2 . ", '" . $cat2name . "', " . $cat3 . ", '" . $cat3name . "', " . $cat4 . ", '" . $cat4name . "','" . $ltype . "'";
			echo '<a href="javascript:back_(' . $btn_back . ');" class="btn btn-inverse" style="margin:5px"><i class="icon-chevron-left icon-white"></i> Back</a>';

		}
		echo $type . '';
		if ($query->result())
		{

			echo '<select style="height:300px;" onchange="bypass(this)" class="span12" multiple="multiple">';
			foreach ($query->result() as $row)
			{

				//SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
				if ($cat4 > 0)
				{

					$str = $row->ID . "," . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4;
					$java = "void(0)";
					$btn = '';

				}
				elseif ($cat3 > 0)
				{

					$str = $row->ID . "," . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4;
					$java = "" . $row->main_cat_id . ", '" . $cat1name . "' , " . $row->sub_cat_id . " ,'" . $cat2name . "',  " . $row->sub_sub_cat_id . ", '" . $cat3name . "'," . trim($row->ID) . ", '" . str_replace("'", "", trim($row->CATEGORY_NAME)) . "'";

					$btn = '';

				}
				elseif ($cat2 > 0)
				{

					$str = $row->ID . "," . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4;
					$java = "" . $row->main_cat_id . ", '" . $cat1name . "' , " . $row->sub_cat_id . ", '" . $cat2name . "', " . trim($row->ID) . " ,'" . str_replace("'", "", trim($row->CATEGORY_NAME)) . "' ,0, '" . $cat4name . "'";

					$btn = '';

				}
				elseif ($cat1 > 0)
				{

					$str = $row->ID . "," . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4;
					$java = "" . $row->main_cat_id . ", '" . $cat1name . "', " . $row->ID . ", '" . str_replace("'", "", trim($row->CATEGORY_NAME)) . "' , 0, '_' , 0, '_'";
					$btn = 'disabled';

				}
				else
				{

					$str = $row->ID . "," . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4;
					$java = "" . $row->ID . ", '" . str_replace("'", "", trim($row->CATEGORY_NAME)) . "' , 0, '_' , 0, '_', 0, '_'";
					$btn = 'disabled';
				}

				$cat_id = $row->ID;
				echo '<option id="' . $java . '" value="' . $cat_id . '"  >' . $row->CATEGORY_NAME . '</option>';

			}


			echo '</select>
			 	<hr />
   				<a id="add_cat" href="javascript:void(0)" class="btn btn-success pull-right disabled"> Next <i class="icon-chevron-right icon-white"></i></a>
				<div class="clearfix">&nbsp;</div>
				';
			echo '<script data-cfasync="false" type="text/javascript">

					function bypass(s){
						var str = s[s.selectedIndex].id;
						var array = str.split(",");
						var v1 = array[0], v2 = array[1], v3 = array[2], v4 = array[3], v5 = array[4], v6 = array[5], v7 = array[6], v8 = array[7];
						load_ajax_product_cat(v1, v2, v3, v4, v5, v6, v7, v8, ' . $bus_id . ', ' . "'" . $ltype . "'" . ');
					
					}
				
				</script>';

		}
		else
		{

			echo '<input type="hidden" name="selected_category" id="selected_category" val="' . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4 . '"/>
				<div class="clearfix">&nbsp;</div>
			    <div class="alert">
				  <i class="icon-thumbs-up"></i> Category selected, please proceed by clicking the next button below</div>
			 	<hr />
   				<a id="add_cat" onclick="go_step_3(' . $btn_next . ', ' . $bus_id . ",'" . $ltype . "'" . ')" href="javascript:void(0)" class="btn btn-success pull-right"> Next <i class="icon-chevron-right icon-white"></i></a>
				<div class="clearfix">&nbsp;</div>';

		}

	}




	//++++++++++++++++++++++++++++++++++++
	//GENRAL ITEM STEP 
	//++++++++++++++++++++++++++
	//Updload General Details
	//++++++++++++++++++++++++++++++++++++

	function add_general_item()
	{

		//$deal_id = $this->input->post('deal_id',TRUE);
		$cat1 = $this->input->post('cat1');
		$cat1name = $this->input->post('cat1name');
		$cat2 = $this->input->post('cat2');
		$cat2name = $this->input->post('cat2name');
		$cat3 = $this->input->post('cat3');
		$cat3name = $this->input->post('cat3name');
		$cat4 = $this->input->post('cat4');
		$cat4name = $this->input->post('cat4name');
		$product_id = $this->input->post('product_id', true);
		$title = $this->input->post('item_title', true);
		$start = $this->input->post('dpstart', true);
		$end = $this->input->post('dpend', true);
		$cont = $this->input->post('item_content', true);
		$price = $this->input->post('price', true);
		$cents = $this->input->post('price_c', true);
		$price = $price . '.' . $cents;
		//IF POR
		$por = 'N';
		if ($this->input->post('por'))
		{

			$price = 'POR';
			$por = 'Y';
		}

		$start_price = $this->input->post('start_price', true);
		$reserve = $this->input->post('reserve', true);
		$item_loc = $this->input->post('item_loc', true);
		$item_suburb = $this->input->post('suburb', true);
		$item_email = $this->input->post('item_email', true);
		$listing_type = $this->input->post('listing_type', true);
		$quantity = $this->input->post('quantity', true);
		$bus_id = $this->input->post('bus_id', true);
		$client_id = $this->session->userdata('id');

		$val = true;


		if ($title == '')
		{

			$error = 'Item title is required';
			$val = false;

		}
		elseif ($listing_type == 'A')
		{

			if (! is_numeric(trim($start_price)) || (int) $start_price == 0)
			{
				$error = 'Please provide us with a valid starting bid';
				$val = false;
			}

		}
		elseif ($listing_type == 'S')
		{

			if (! $this->input->post('por'))
			{
				if (! is_numeric(trim($price)) || (int) $price == 0)
				{
					$error = 'Please provide us with a valid sales price';
					$val = false;
				}
			}

		}

		if ($val == true)
		{

			//ACTIVATE AUTOHAUS AUTO
			$active = 'N';
			if ($bus_id != '0')
			{

				$active = 'Y';

			}

			//DATA
			$insertdata = array(
				'bus_id'             => $bus_id,
				'is_active'          => $active,
				'title'              => $title,
				'description'        => $cont,
				'sale_price'         => $price,
				'por'                => $por,
				'start_price'        => $start_price,
				'reserve'            => $reserve,
				'start_date'         => $start,
				'listing_type'       => $listing_type,
				'location'           => $item_loc,
				'suburb'             => $item_suburb,
				'email_instructions' => $item_email,
				'quantity'           => $quantity,
				'main_cat_id'        => $cat1,
				'sub_cat_id'         => $cat2,
				'sub_sub_cat_id'     => $cat3,
				'sub_sub_sub_cat_id' => $cat4
			);


			//IF NEW PRODUCT
			if ($product_id == 0)
			{

				$insertdata['client_id'] = $client_id;
				$insertdata['total_quantity'] = $quantity;

				//EXPIRY DATES auction none; sale = 30 days 1 month
				if ($listing_type == 'S')
				{

					if ($bus_id == '2666' || $bus_id == '8785' || $bus_id == '2706')
					{
						//YEARLY EXPIRY
						$insertdata['end_date'] = date('Y-m-d', strtotime("+360 days"));

					}
					elseif ($bus_id != 0)
					{

						$insertdata['end_date'] = date('Y-m-d', strtotime("+91 days"));
					}
					else
					{
						$insertdata['status'] = 'moderate';
						$insertdata['end_date'] = date('Y-m-d', strtotime("+31 days"));
					}
				}
				else
				{
					$insertdata['status'] = 'moderate';
					$insertdata['end_date'] = date('Y-m-d H:i:s', strtotime("+7 days"));
				}


				//INSERT
				$this->db->insert('products', $insertdata);
				$product_id = $this->db->insert_id();

				//PRODUXCT EXTRA DATA
				$extradata = array(
					'product_id'     => $product_id,
					'property_agent' => $client_id

				);
				$this->db->insert('product_extras', $extradata);
				echo '<script data-cfasync="false" type="text/javascript">
						
							$("#product_id").val(' . $product_id . ');

						</script>';

				//$product_id = $this->db->insert_id(); 

			}
			else
			{
				//ONLY AUCTIONS CAN BE EXTENDED
				if ($listing_type == 'A')
				{

					$insertdata['end_date'] = $end;
				}
				//UPDATE
				$this->db->where('product_id', $product_id);
				$this->db->update('products', $insertdata);

				//PRODUXCT EXTRA DATA
				$extradata = array(
					'product_id' => $product_id

				);
				$this->db->where('product_id', $product_id);
				$this->db->update('product_extras', $extradata);

				//DELETE CACHE
				$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
				if ($this->cache->get('trade/single_' . $product_id))
				{

					$this->cache->delete('trade/single_' . $product_id);
				}


			}

			if ($cat4 > 0)
			{
				$catname = $cat4name;

			}
			elseif ($cat4 == 0)
			{
				$catname = $cat3name;
				$cat4name = '';
			}
			elseif ($cat3 == 0)
			{
				$catname = $cat2name;
				$cat3name = '';
			}
			elseif ($cat2 == 0)
			{
				$catname = $cat1name;
				$cat2name = '';
			}
			elseif ($cat1 == 0)
			{
				$catname = 'Please select category';
			}
			$data['step'] = 3;
			$data['product_id'] = $product_id;
			$data['bus_id'] = $bus_id;
			$data['cat1'] = $cat1;
			$data['cat1name'] = $cat1name;
			$data['cat2'] = $cat2;
			$data['cat2name'] = $cat2name;
			$data['cat3'] = $cat3;
			$data['cat3name'] = $cat3name;
			$data['cat4'] = $cat4;
			$data['cat4name'] = $cat4name;
			$data['bool'] = true;
			$data['catname'] = $catname;

			return $data;


			//VALIDATION FAILED
		}
		else
		{

			$row = $this->input->post();
			if ($row['item_loc'] == 'national')
			{
				$row['item_suburb'] = '';
			}
			if (! $this->input->post('item_suburb'))
			{

				$row['item_suburb'] = '';
			}

			$row['is_active'] = 'N';
			$row['title'] = $row['item_title'];
			$row['description'] = $row['item_content'];
			$row['price'] = $row['price'];
			$row['start_price'] = $row['start_price'];
			$row['location'] = $row['item_loc'];
			$row['suburb'] = $row['item_suburb'];
			$row['listing_type'] = $row['listing_type'];
			$row['step'] = 2;
			$row['main_cat_id'] = $row['cat1'];
			$row['cat1name'] = '';
			$row['sub_cat_id'] = $row['cat2'];
			$row['cat2name'] = '';
			$row['sub_sub_cat_id'] = $row['cat3'];
			$row['cat3name'] = '';
			$row['sub_sub_sub_cat_id'] = $row['cat4'];
			$row['cat4name'] = '';
			$row['catname'] = $this->get_cat_names($row);
			$row['bool'] = false;
			$row['error'] = $error;

			return $row;
		}

	}

	//+++++++++++++++++++++++++++
	//UPLOAD PRODUCT IMAGES     
	//++++++++++++++++++++++++++

	function add_product_images()
	{
		ini_set('memory_limit', '128M');
		$this->load->library('image_lib');
		$this->load->library('upload');  // NOTE: always load the library outside the loop
		$bus_id = $this->input->post('bus_id', true);
		$product_id = $this->input->post('product_id', true);

		$sequence = 0;
		if ($this->input->post('img_sequence'))
		{

			$sequence = $this->input->post('img_sequence', true);


		}


		if (isset($_FILES['files']['name']))
		{
			$this->total_count_of_files = count($_FILES['files']['name']);
			/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */

			for ($i = 0; $i < $this->total_count_of_files; $i++)
			{

				$_FILES['userfile']['name'] = $_FILES['files']['name'][$i];
				$_FILES['userfile']['type'] = $_FILES['files']['type'][$i];
				$_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['userfile']['error'] = $_FILES['files']['error'][$i];
				$_FILES['userfile']['size'] = $_FILES['files']['size'][$i];


				$config['upload_path'] = NA_SITE_URL . 'assets/products/images/';
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['overwrite'] = false;
				$config['max_size'] = '0';
				$config['max_width'] = '8324';
				$config['max_height'] = '8550';
				$config['min_width'] = '200';
				$config['min_height'] = '200';
				$config['remove_spaces'] = true;
				$config['encrypt_name'] = true;

				$this->upload->initialize($config);

				if ($this->upload->do_upload())
				{
					//$file = array('upload_data'
					$data = array('upload_data' => $this->upload->data());
					$file = $this->upload->file_name;
					$width = $this->upload->image_width;
					$height = $this->upload->image_height;
					$type = $this->upload->file_ext;
					$file_no_ext = $data['upload_data']['raw_name'];

					//GET NEW SEQUENCE
					if ($sequence == 0)
					{

						$newsequence = 1;

					}
					else
					{

						$newsequence = $sequence + 1;

					}

					//CONVERT TO JPEG
					if (strtolower($type) != '.jpg' && strtolower($type) != '.jpeg')
					{

						//$input = $config['upload_path'].$file;
						//$output = $config['upload_path'].$file_no_ext.'.jpg';

						$input_file = $config['upload_path'] . $file;
						$output_file = $config['upload_path'] . $file_no_ext . '.jpg';

						if ($this->convert_jpeg($input_file, $output_file))
						{

							$file = $file_no_ext . '.jpg';
						};


					}

					//DOWNSIZE IMAGE
					$this->downsize_image($file);
					if (($width > 1200) || ($height > 1200))
					{

						//$this->downsize_image($file);

					}
					//WATERMARK IMAGE	
					$this->watermark_image($file);

					//populate array with values
					$data = array(

						'img_file'   => $file,
						'product_id' => $product_id,
						'sequence'   => $newsequence

					);

					//insert into database
					$this->db->insert('product_images', $data);
					//SEND TO BUCKET
					$this->load->model('gcloud_model');
					$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
					//crop 
					$data['filename'] = $file;
					$data['width'] = $this->upload->image_width;
					$data['height'] = $this->upload->image_height;
					$val = true;
					$image = CDN_URL . 'assets/products/images/' . $file;

					//$this->output->set_header("HTTP/1.0 200 OK");


				}
				else
				{
					//ERROR
					$val = false;
					$data['error'] = $this->upload->display_errors();


				}
			}
			//redirect
			if ($val == true)
			{

				$data['basicmsg'] = $i . ' Photos added successfully!';
				echo '<div class="alert alert-success">
						 <button type="button" class="close" data-dismiss="alert">×</button>
						' . $data['basicmsg'] . '
						 </div>
					';

			}
			else
			{

				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>'
					. $data['error'] . '
							 </div>';
			}
		}
		else
		{
			echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						 No Files Selected - Please select some files and try again
						 </div>';

		}
	}


	//DELETE PRODUCT IMAGES
	function product_img_delete($img_id)
	{


		$this->db->where('img_id', $img_id);
		$query = $this->db->get('product_images');
		$row = $query->row_array();

		$img_file = $row['img_file'];
		$product_id = $row['product_id'];

		if ($row['img_file'] != '0')
		{

			$file_large = NA_SITE_URL . 'assets/products/images/' . $img_file; # build the full path		

			if (file_exists($file_large))
			{

				if (unlink($file_large))
				{

					//delete image

					$this->db->where('img_id', $img_id);
					$this->db->delete('product_images');

					echo
					'<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully!</p>
									';


				}


			}
			else
			{

				//delete image
				$this->db->where('img_id', $img_id);
				$this->db->delete('product_images');


				echo
				'<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully</p>
									 </div>
									 ';

			}


			//no existing image	
		}
		else
		{

			echo
			'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Image could not be deleted!</p>
						';
		}

	}

	//SHOW ALL PRODUCT IMAGES IMAGE MANAGER		
	function show_all_product_images($product_id)
	{
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('product_id', $product_id);
		$query = $this->db->get('product_images');
		$x2 = 0;
		$amt = 4;
		if ($query->num_rows() > 0)
		{

			echo '<div class="row-fluid">';
			$x = 0;
			foreach ($query->result() as $row)
			{
				$id = $row->img_id;
				$img_file = $row->img_file;
				//$title = $row->CLIENT_PHOTO_TITLE;

				if ($x2 % $amt == 0 && $x2 != 0)
				{


					echo '
					   </div>
					   <div class="clearfix">&nbsp;</div>
					   <div class="row-fluid">
					   ';
				}

				if ($img_file != '')
				{

					if (strpos($img_file, '.') == 0)
					{

						$format = '.jpg';
						$img_str = CDN_URL . 'assets/products/images/' . $img_file . $format;
						$file = $img_file . $format;

					}
					else
					{

						$img_str = CDN_URL . 'assets/products/images/' . $img_file;
						$file = $img_file;
					}

				}
				else
				{

					$img_str = CDN_URL . 'img/bus_blank.jpg';
					$file = '';

				}
				$sequence = '';
				$imgsequence = $row->sequence;
				if ($row->sequence == 0 && $x2 == 0)
				{

					$sequence = '<a class="btn btn-mini btn-success" style="margin:5px 5px 0 0;"><i class="icon-ok icon-white"></i> FEATURED</a>';


				}

				if ($row->sequence == 0)
				{

					$imgsequence = $x2;

				}
				//TIMBTHUMB
				//echo '<li class="thumbnail"><img src="'.NA_SITE_URL.'img/timbthumb.php?src='.NA_SITE_URL.'assets/business/gallery/'.$img_file.'&q=100&w=180&h=100" />
//							<a style="float:right;margin:0 3px;" onclick="delete_gallery_img('.$id .');" href="#"><i class="icon-remove"></i></a>
//							</li>';

				//IF IMAGE IS EDITED
				$rand = '';
				$temp = '';
				if ($row->edited != 'N')
				{
					$rand = '&ed=' . $row->edited;
					$temp = $row->edited;
				}

				//NO TIMBTHUMB
				echo '<div id="img_' . $id . '" class="span3 thumbnail" ><img id="pro_img_att_' . $id . '" onclick="make_primary(' . $id . ');" src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . $img_str . '&w=190&h=130' . $rand . '" />
								<input type="hidden" value="' . $imgsequence . '" name="img_sequence" />
								<a style="float:left;margin:5px 5px 0 0" onclick="delete_product_img(' . $id . ');" class="btn btn-mini btn-danger" href="javascript:void(0)"><i class="icon-trash icon-white"></i></a>
								 ' . $sequence . '
								 <a style="float:left;margin:5px 5px 0 0" id="rotate_btn_' . $id . '" onclick="rotate_img(90, ' . "'" . $file . "'" . ', ' . $id . ',' . "'" . $temp . "'" . ');" class="btn btn-mini btn-warning" href="javascript:void(0)"><i class="icon-refresh icon-white"></i></a>
						  	 </div>';
				$x++;
				$x2++;

			}

			//show gallery
			echo '<input type="hidden" name="max_sequence" value="' . $x . '"></div>';

		}
		else
		{

			echo '<div class="alert alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h4>No Product Images Added</h4>
					Please add some product images to enhance your listing by clicking on the select images button below
				</div>';
		}


	}
	//+++++++++++++++++++++++++++
	//MAKE PRIMARY IMAGE  
	//++++++++++++++++++++++++++

	function make_primary_image($product_id, $img_id)
	{

		$data['sequence'] = 1;
		$this->db->where('sequence', 0);
		$this->db->where('product_id', $product_id);
		$this->db->update('product_images', $data);

		$data2['sequence'] = 0;
		$this->db->where('img_id', $img_id);
		$img = $this->db->update('product_images', $data2);


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CONVERT IMAGE TO JPEG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function convert_jpeg($inputJ, $outputJ)
	{

		$input_file = $inputJ;
		$output_file = $outputJ;

		$input = imagecreatefrompng($input_file);
		list($width, $height) = getimagesize($input_file);
		$output = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($output, 255, 255, 255);
		imagefilledrectangle($output, 0, 0, $width, $height, $white);
		imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
		imagejpeg($output, $output_file);
		//imagedestroy(NA_SITE_URL.'assets/products/images/'.$file);

		if (file_exists($inputJ))
		{

			unlink($inputJ);

		}

		return true;

	}




	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file)
	{

		$config = array(
			'source_image'   => (NA_SITE_URL . 'assets/products/images/' . $file),
			'width'          => '900',
			'master_dim'     => 'width',
			'maintain_ratio' => true
		);

		$this->load->library('image_lib', $config);
		if (! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();

			return;
		}
		$this->image_lib->clear();

		/*$config = array( 
		   'source_image' => (NA_SITE_URL .'assets/products/images/'. $file),
		   'width' => '200',
		   'height' => '200',
		   'quality' => 10,
		   'new_image' => (NA_SITE_URL .'assets/products/images/thumb_'. $file),
		   'maintain_ratio' => false
		  ); 
		 
		 
		  $this->image_lib->initialize($config);
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	echo $this->image_lib->display_errors();
			    return;
		  } 
		  $this->image_lib->clear();  */

		return $data;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//WATERMARK IMAGE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function watermark_image($file)
	{

		//$id = $this->input->post('pro_id');

		$config['source_image'] = NA_SITE_URL . 'assets/products/images/' . $file;
		$config['wm_type'] = 'overlay';
		$config['wm_overlay_path'] = NA_SITE_URL . 'img/icons/watermark.png';
		$config['padding'] = 30;
		$config['wm_opacity'] = 80;
		//$config['wm_font_color'] = 'ffffff';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';
		$config['wm_x_transp'] = 4;
		$config['wm_y_transp'] = 4;
		//$config['dynamic_output'] = TRUE;

		$this->image_lib->initialize($config);

		$this->image_lib->watermark();

		//$this->load->library('image_lib'); 

		if (! $this->image_lib->watermark())
		{
			$data['error'] = $this->image_lib->watermark_errors();

			return $data;
		}
		$this->image_lib->clear();

		return;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET CITIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	//Get Main Categories
	function get_cities()
	{

		$this->db->order_by('MAP_LOCATION', 'ASC');
		$test = $this->db->get('a_map_location');

		return $test;
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PUBLISH DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function publish_item($id, $bus_id)
	{

		$this->load->model('email_model');

		$query = $this->db->query("SELECT * FROM `products` WHERE product_id = '" . $id . "'", false);
		if ($query->result())
		{

			$row = $query->row_array();
			$emailTO = 'roland@my.na';
			$emailTO = array(array('email' => $emailTO), array('email' => 'ernst@my.na'), array('email' => 'info@my.na'), array('email' => 'wilko@my.na'));
			$emailFROM = 'trade@my.na';
			$name = 'My Namibia Trade';
			$subject = 'New Product Listed - ' . $row['title'];
			$body = 'Hi, <br /><br /> A new product has been listed . Please review the product and approve it in the Admin section. http://my.na/my_admin/
			
			<br /><br /><br />
			My Namibia Trade
			';


			$this->email_model->send_email($emailTO, $emailFROM, $name, $body, $subject);

			echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<h4>Your listing has been Added</h4>
						<p>Product will be reviewed within 24 hours</p></div>
				  <script type="text/javascript">
						window.setTimeout(function(){

						    window.location = "' . site_url('/') . 'sell/my_trade/' . $bus_id . '/";
                        }
						, 2000);
				  </script>';
			//LOAD PRODUCTS
			//$this->get_client_products($bus_id, 'all');


		}
		else
		{

			echo '<div class="alert">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Item not found</p></div>
				  <script type="text/javascript">
							
				  </script>';

		}


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCTS FOR EDIT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_client_products($bus_id, $section)
	{

		$id = $this->session->userdata('id');

		if ($section == '')
		{
			$section = 'live';
		}
		$legend = '<div class="well well-mini">
					<small class="muted"><strong>What do the buttons do?</strong> Move the mouse over each button for descriptions <i class="icon-question-sign icon-white"></i></small>
					<div class="pull-right">
						<a class="btn btn-mini btn-success" title="The item is live and not expired" rel="tooltip" href="javascript:void(0)"><i class="icon-ok icon-white"></i></a>
						<a href="javascript:void(0)" class="btn btn-mini btn-warning" title="Listing date. Is product expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>
						<a class="btn btn-mini btn-success" href="javascript:void(0)" title="Mark item as sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>
						<a href="javascript:void(0)" class="btn btn-mini btn-inverse" title="Update the current item details" rel="tooltip"><i class="icon-pencil icon-white"></i></a> 
						<a href="javascript:void(0)" class="btn btn-mini btn-inverse" title="Delete the item" rel="tooltip"><i class="icon-trash icon-white"></i></a>
						<a href="javascript:void(0)" class="btn btn-mini btn-inverse" title="Preview the current item" rel="tooltip"> View</a>
					</div>	
				 </div>';

		if ($bus_id == 0)
		{
			$col4H = '<th style="width:12%">Q</th>';
			$bstr = '';
			$query = $this->db->query("SELECT * FROM products WHERE client_id = '" . $id . "' AND bus_id = '0' AND status = '" . $section . "' ORDER BY product_id DESC ", false);

		}
		elseif ($section == 'live_agent')
		{
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE product_extras.property_agent = '" . $id . "' AND products.bus_id = '" . $bus_id . "'  AND products.status = 'live' ORDER BY products.product_id DESC ", false);

		}
		elseif ($section == 'sold_agent')
		{
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE product_extras.property_agent = '" . $id . "' AND products.bus_id = '" . $bus_id . "'  AND products.status = 'sold' ORDER BY products.product_id DESC ", false);

		}
		else
		{
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Business';
			$query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE products.bus_id = '" . $bus_id . "' AND products.status = '" . $section . "' ORDER BY products.product_id DESC", false);
		}
		if ($query->result())
		{

			echo $legend . '
			<h4>Listings<small> Your current ' . $bstr . ' items</small></h4>
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped datatable" id="" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:8%;min-width:40px"></th>
           				<th style="width:20%">Title</th>
						<th style="width:10%">Type</th>
						<th style="width:15%">Price</th>
						<th style="width:10%">End</th>
						' . $col4H . '
						<th style="width:25%;min-width:130px"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row)
			{

				//AGENCY COLUMN

				$col4 = '<td style="width:5%">' . $row->quantity . '</td>';
				if ($section == 'live_agent' || $section == 'sold_agent' || $bus_id != 0)
				{
					$col4 = '<td style="width:12%">None</td>';
					//GET AGENT DETAILS
					if ($row->property_agent != 0)
					{
						$this->db->where('ID', $row->property_agent);
						$agent = $this->db->get('u_client');
						if ($agent->result())
						{

							$agentR = $agent->row();
							$col4 = '<td style="width:12%">' . $agentR->CLIENT_NAME . ' ' . $agentR->CLIENT_SURNAME . '</td>';
						}
					}


				}

				//get images
				$this->db->where('product_id', $row->product_id);
				$this->db->limit('1');
				$images = $this->db->get('product_images');


				if ($images->result())
				{

					$imgrow = $images->row_array();
					$img = CDN_URL . 'assets/products/images/' . $imgrow['img_file'];
				}
				else
				{

					$img = CDN_URL . 'img/product_blank.jpg';
				}

				//CHECK SOLD BUTTON
				$soldBTN = '';
				if ($bus_id != 0)
				{
					$soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status(' . $row->product_id . ', ' . "'live'" . ');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star icon-white"></i></a>';
					if ($row->status == 'live')
					{
						$soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status(' . $row->product_id . ', ' . "'sold'" . ');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>';
					}
					else
					{
						$soldBTN = '<a class="btn btn-mini btn-warning" onclick="update_product_status(' . $row->product_id . ', ' . "'live'" . ');" title="Mark Item as Live" rel="tooltip"><i class="icon-star icon-white"></i></a>';

					}
				}

				//Check Price
				//Fixed price
				if ($row->listing_type == 'S')
				{

					$type = '<span class="label">Buy Now</span>';
					$price = 'N$ ' . $row->sale_price;

					$bids = '';
					//Auction	
				}
				else
				{

					//GET CURRENT BID
					$bids = $this->get_current_bid($row->product_id);
					$type = '<span class="label">Auction</span>';
					$price = 'Current Bid: N$ ' . $bids['current'] . ' Res: ' . $row->reserve;

				}

				if ($row->is_active == 'Y')
				{

					$active = '<a class="btn btn-mini btn-success" title="Product is live" rel="tooltip"><i class="icon-ok icon-white"></i></a>';

				}
				else
				{

					$active = '<a class="btn btn-mini btn-warning" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';

				}

				if (date('Y-m-d', strtotime($row->end_date)) < date('Y-m-d'))
				{

					$active = '<a class="btn btn-mini btn-warning" title="Item is expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';

				}

				//GET QUESTIONS
				$this->db->where('product_id', $row->product_id);
				$q = $this->db->get('product_questions');
				$questions = '';


				if ($q->result())
				{

					$questions = '<a onclick="get_questions(' . $row->product_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Click to view questions"><i class="icon-question-sign icon-white"></i></a> ';
				}

				echo '<tr>
						<td style="width:8%;min-width:40px"><img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . $img . '&w=190&h=130" 
							alt="" style="width:80%;height:auto" class="img-polaroid"/> </td>
						<td style="width:20%">' . $this->get_cat_name($row->sub_sub_cat_id) . ' > ' . $row->title . '</td>
						<td style="width:10%">' . $type . '</td>
						<td style="width:15%">' . $price . '</td>
						<td style="width:10%">' . date('Y-m-d', strtotime($row->end_date)) . '</td>
						' . $col4 . '
					  	<td style="width:25%;min-width:130px;text-align:right">  
							' .
					$questions
					. $active . ' ' .
					$soldBTN .
					'
							<a onclick="update_product(' . $row->product_id . ');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a> 
							<a onclick="delete_product(' . $row->product_id . ');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a>
							<a href="' . site_url('/') . 'product/' . $row->product_id . '/" target="_blank" class="btn btn-mini btn-inverse"> View</a></td>
					  </tr>';
			}
			$exit_str = "javascript:$('#modal-product-delete').modal('hide')";
			$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div id="modal-product-delete" class="modal hide fade">

					<div class="modal-header">
					  <a data-dismiss="modal" aria-hidden="true" class="close">&times;</a>
					  <h3>Delete the Product</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current product and all of its resources?</p>
						
					</div>
				
					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a> 
					  <a data-dismiss="modal" aria-hidden="true" class="btn btn-secondary">No</a>
					</div>
				 
				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script data-cfasync="false" type="text/javascript">
					$("[rel=tooltip]").tooltip();		
					$(".datatable").dataTable( {
					  "sDom": "' . $table_str . '",
					  "sPaginationType": "bootstrap",
					  "oLanguage": {
						  "sLengthMenu": "_MENU_ records per page"
					  },
					  "aaSorting":[],
					  "bSortClasses": false
	
					} );
					function update_product(id){
	
							var cont = $("#admin_content");
							$.get("' . site_url('/') . 'trade/update_product/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);
									  
							});
							
					}
					function get_questions(id){
	
							var cont = $("#admin_content");
							$.get("' . site_url('/') . 'trade/product_questions/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);
									  
							});
							
					}
					function update_product_status(id, str){

						var cont = $("#admin_content");
						cont.empty();
						cont.addClass("loading_img"); 
						$.ajax({
								type: "get",
								cache: false,
								url: "' . site_url('/') . 'trade/update_product_status/"+id+"/"+str ,
								success: function (data) {
									cont.removeClass("loading_img"); 
									cont.html(data);	
									load_trade("products", "live");	
								}
							});	 
						
					}
					
					function delete_product(id){
	
						$("#modal-product-delete").appendTo("body").unbind("show").bind("show", function()  {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");
								
								removeBtn.click(function(e) { 
										
									e.preventDefault();
					
											$.ajax({
												type: "get",
												url: "' . site_url('/') . 'trade/delete_product/"+id ,
												success: function (data) {
													 
													 $("#modal-product-delete").modal("hide");
													 $("#msg").html(data);
													 load_trade("products", "live");	
												}
											});
								});
						}).modal({ backdrop: true });
					}	
				</script>';

		}
		else
		{

			if ($section == 'sold')
			{
				echo '<div class="alert">
						 <h4>No Items have been Sold</h4> No items have been sold. Once you sell an item it will be saved here.
						 
						</div>';

			}
			elseif ($section == 'bought')
			{
				echo '<div class="alert">
						 <h4>No Bought items</h4>You havent bought any items. Once you purchase an item it will be saved here.
						 
						</div>';
			}
			else
			{

				$str = "'sell'";
				echo '<div class="alert">
						
						 <h4>No ' . $bstr . ' Products added</h4> No items have been added. Please add a new product below.<br /><br />
						 <a href="javascript:void(0)" onclick="load_trade(' . $str . ')" class="btn btn-inverse"><i class="icon-plus icon-white"></i> Add a New Product</a>
						</div>';
			}


		}


	}

	//+++++++++++++++++++++++++++
	//GET SIMILAR PRODUCTS
	//++++++++++++++++++++++++++	
	public function get_similar_products($cat1, $cat2, $product_id)
	{

		//$query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE  (products.sub_cat_id = '".$cat2."' OR products.main_cat_id = '".$cat1."') AND products.product_id <> (".$product_id.")  ORDER BY products.listing_date DESC LIMIT 8 ", FALSE);

		$query = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        WHERE products.is_active = 'Y' AND products.status = 'live' AND  (products.sub_cat_id = '" . $cat2 . "' OR products.main_cat_id = '" . $cat1 . "') AND products.product_id <> (" . $product_id . ")
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 30", false);


		if ($query->result())
		{

			echo '
			<h2 class="na_script">You may also be interested in</h2>
			<div class="row-fluid">
					<div id="similar_nav_carousel" class="carousel slide">
					<div class="carousel-inner">	  
			 		
			';
			$x2 = 0;
			foreach ($query->result() as $row)
			{

				//get images
				$xx = 0;
				$img = array();
				$img_Cycle = '';
				if ($row->images != null)
				{

					$imgA = explode(',', $row->images);
					$imgAa = array();
					foreach ($imgA as $imgR)
					{
						$lazy = '';
						if ($xx == 0)
						{
							$lazy = 'lazy active';
							$img_str = CDN_URL . 'assets/products/images/' . $imgR;
							$img[$xx] = '<li><img class="' . $lazy . ' vignette" src="' . NA_SITE_URL . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-original="' .
								NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $imgR . '&w=360&h=230"/></li>';
						}
						else
						{

							$at = '<img class="vignette" alt="' . strip_tags($row->title) . '" src="' .
								NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $imgR . '&w=360&h=230"/>';
							array_push($imgAa, $at);

						}
						/*$img[$xx] = '<li><img class="'.$lazy.' vignette" src="'.NA_SITE_URL.'img/deal_place_load.gif" alt="'.strip_tags($row->title).'" data-original="'.
										NA_SITE_URL.'img/timbthumb.php?src='. NA_SITE_URL.'assets/products/images/'.$imgR.'&w=340&h=200"/></li>';*/


						$xx++;
					}

					$img_Cycle = '<script id="images_' . $row->product_id . '" type="text/cycle">
								' . json_encode($imgAa) . '
						 </script>';


				}
				else
				{

					$img[0] = '<li><img class="lazy vignette active" src="' . NA_SITE_URL . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-original="' .
						NA_SITE_URL . 'img/timbthumb.php?src=' . CDN_URL . 'img/product_blank.jpg&w=360&h=230" /></li>';
					$img_str = NA_SITE_URL . 'img/product_blank.jpg';
				}

				//CHECK IF AGENCY PROPERTY LISTING
				$b_logo = '';
				if ($row->IS_ESTATE_AGENT == 'Y')
				{

					if (trim($row->BUSINESS_LOGO_IMAGE_NAME) != '')
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . NA_SITE_URL . 'assets/business/photos/' . $row->BUSINESS_LOGO_IMAGE_NAME . '" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}
					else
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . NA_SITE_URL . 'img/bus_blank.jpg" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}

				}

				$btn_txt = 'Buy Now';
				if ($row->main_cat_id == 3408)
				{

					$btn_txt = 'Enquire Now';

				}
				//Check Price
				//Fixed price
				if ($row->listing_type == 'S')
				{

					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">' . $btn_txt . '</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';
					$price = '<span style=" font-size:18px">N$</span> ' . $this->smooth_price($row->sale_price);
					if ($row->por == 'Y')
					{

						$price = '<span itemprop="price"> POR</span> <span style=" font-size:14px">Price On Request</span>';

					}
					//Auction	
				}
				else
				{
					//$price = '<span style=" font-size:18px">N$</span> '.$this->smooth_price($row->sale_price);
					$price = $this->get_current_bid($row->current_bid);
					if ($price['str'] != 'No Bids')
					{
						$price = '<span style=" font-size:10px">BID</span> ' . $price['str'];

					}
					else
					{
						$price = $price['str'];
					}
					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">Place Bid</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';


				}
				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
				);
				$tweet_url = $this->clean_url_str($row->title) . '&text=' . substr(strip_tags($row->title . ' ' . $row->description), 0, 60) . ' ' . site_url('/') . 'product/' . $row->product_id . '&via=MyNamibia';
				$fb = "postToFeed(" . $row->product_id . ", '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . "','" . trim($img_str) . "', '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->description, " ", " ")), 50)))) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . trim($this->clean_url_str($row->title)) . "')";


				if ($x2 == 0)
				{

					echo '
					  <div class="item active">
						<div class="row-fluid">
					   ';

				}
				elseif ($x2 % 4 == 0)
				{

					echo '
						</div><!--/row-fluid-->
					  </div><!--/item-->
					  <div class="item">
						<div class="row-fluid">
					   ';
				}
				$ribbon = $this->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
				echo ' <div class="span3 white_box" >
							' . $ribbon . '
							<div class="slideshow-block">
								<a href="#" class="link"></a>
								<ul class="cycle-slideshow cycle-paused" data-cycle-speed="500" data-cycle-timeout="500" data-cycle-loader=true data-cycle-progressive="#images_' . $row->product_id . '" data-cycle-slides="> li">
									' . implode($img) . '
								</ul>
								' . $img_Cycle . '
							</div>
							<div class="padding10">
								   <div class="price_label">' . $price . '</div>
									<span class="pull-right" style="margin-top:-55px">
									<a onClick="' . $fb . '" class="facebook"></a>
									' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
									</span>
									<h4 class="upper na_script">' . $row->title . '</h4>
									
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:13px;margin-bottom:10px;min-height:90px;max-height:180px;overflow:hidden">' . $this->shorten_string(strip_tags($row->description), 10) .
					$this->show_extras_short($row->extras) . $b_logo .
					'</div>
									<div class="clearfix"></div>
									<p>
										
									' . $type_btn . '</p>
									<div class="clearfix"></div>
							</div>			
					  </div>
					  ';

				$x2++;


			}


			echo ' </div><!--/row-fluid-->
					 </div><!--/item-->
				   </div><!--/carousel-inner-->
						 
						<a class="left carousel-control" href="#similar_nav_carousel" data-slide="prev">‹</a>
						<a class="right carousel-control" href="#similar_nav_carousel" data-slide="next">›</a>
				</div><!--/thumb_nav_carousel-->
			
				<div class="clearfix" style="height:30px;"></div>
				<script data-cfasync="false" type="text/javascript">
						
					$(document).ready(function(){
						  $("img.lazy").lazyload();
						   $("[rel=tooltip]").tooltip();
							$(".cycle-slideshow").cycle();
							var c = $(".cycle-slideshow").cycle("pause");
							c.hover(function () {
								//mouse enter - Resume the slideshow
								$(this).cycle("resume");
							},
							function () {
								//mouse leave - Pause the slideshow
								$(this).cycle("pause");
							});
						  
						  $("#similar_nav_carousel").on("slid", function(e) {
								
								$("img.lazy").each(function(){
									$(this).attr("src", $(this).attr("data-original"));
									$(this).removeClass("lazy");
									
								});

						  });

					});
				</script>';

		}
		else
		{

			echo '';


		}


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT QUESTIONS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_product_questions($product_id)
	{

		$id = $this->session->userdata('id');

		$query = $this->db->query("SELECT product_questions.*, u_client.CLIENT_NAME, u_client.CLIENT_SURNAME, u_client.CLIENT_PROFILE_PICTURE_NAME
                                  FROM product_questions
                                  JOIN u_client ON u_client.Id = product_questions.asking_client_id
                                  WHERE product_id = '" . $product_id . "' AND status = 'live'", false);

		if ($query->result())
		{

			foreach ($query->result() as $row)
			{


				$client_id = $row->client_id;
				$bus_id1 = $row->bus_id;
				$question = $row->question;
				$q_date = $row->datetime;

				$img = $row->CLIENT_PROFILE_PICTURE_NAME;

				if (strstr($img, "http"))
				{

					$data['image'] = $img . '?width=60&height=60';

				}
				elseif ($img != '')
				{

					$data['image'] = NA_SITE_URL . 'assets/users/photos/' . $img;

				}
				else
				{

					$data['image'] = NA_SITE_URL . 'img/user_blank.jpg';

				}
				$data['user'] = $row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME;
				$reply = $row->answer;

				if ($row->answer == '')
				{

					$answer = '
							<div id="answer_' . $row->question_id . '">

								<a class="btn btn-inverse pull-right" id="answer_btn_' . $row->question_id . '" onclick="reply_question(' . $row->question_id . ')" >Answer Question</a>
							</div>	
									';

				}
				else
				{

					$answer = '<div id="answer_' . $row->question_id . '"><strong>A:</strong>' . strip_tags($row->answer) . '</div>';

				}

				echo '<div class="media">
						  <div class="well well-mini">
						  <a class="pull-left" href="#" title="Reviewed on ' . date('F j, Y', strtotime($q_date)) . '" rel="tooltip">
							<span class="avatar-overlay60"></span>
							<img class="media-object" style="border:1px solid #333333;width:60px; margin-right:10px; height:60px" src="' . $data['image'] . '">
						  </a>
						  
						  <div class="media-body">
						 <span style="font-size:50px;margin-top:15px;" class="pull-right na_script">?</span>
						  <blockquote style="margin-bottom:0px;font-size:14px;"><strong>Q:</strong>' . strip_tags($question) . '</blockquote>
						  <div style="font-size:10px;"><span itemprop="reviewer">' . $data['user'] . '</span></div>
						  <div class="clearfix"></div>
						  <time itemprop="dtreviewed" style="display:none;font-size:10px;height:30px;font-style:italic" datetime="' . date('m-d-Y', strtotime($q_date)) . '">'
					. date('F j, Y', strtotime($q_date)) . '</time>
						   <blockquote style="margin-bottom:0px;font-size:14px">' . $answer . '</blockquote>
						  
						  </div>
						 
						  
						  </div>
					  </div>';


			}


		}
		else
		{


			echo '<div class="alert">
					
					 <h4>No Questions asked</h4> No queries have been made. Ask a question above.
					 
					</div>';


		}


	}



//++++++++++++++++++++++++++++++++++++++++++++++++++++++
//RATING WIDGET
//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function rate_product($product_id)
	{

		if ($this->session->userdata('id'))
		{

			$button_txt1 = "<img src='" . NA_SITE_URL("/") . "img/load.gif' /> Submitting...";
			$button_txt2 = "<i class='icon-envelope'></i> Submit Review";


			echo ' <p>Your rating (On a scale of 1 to 5, with 5 being the best)</p>
				   <form id="reviewfrm" name="reviewfrm" enctype="application/x-www-form-urlencoded" method="post" action="' . site_url('/') . 'trade/submit_review/' . $product_id . '/">
					   <input name="star1" type="radio" value="1" class="star"/>
					   <input name="star1" type="radio" value="2" class="star"/>
					   <input name="star1" type="radio" value="3" class="star"/>
					   <input name="star1" type="radio" value="4" class="star"/>
					   <input name="star1" type="radio" value="5" class="star"/>

					   <br /><br />
					   <input type="hidden" value="' . $this->session->userdata('id') . '" name="client_id" />
					   <textarea rows="3" class="redactor span12" id="reviewtxt" name="reviewtxt"  placeholder="Review product here."></textarea>
					   <br />
					   <button type="submit" id="reviewbut" class="btn pull-right btn-inverse"><i class="icon-comment icon-white"></i> Submit Review</button>
				   </form>
				   <div class="clearfix" style="height:20px;"></div>
				   <div id="review_msg"></div>
				   
				   <script data-cfasync="false" type="text/javascript">
					$(document).ready(function(){
						//$("input .star").rating();
						$("#reviewbut").on("click", function(e) {
								e.preventDefault();
								var frm = $("#reviewfrm");
								console.log(frm);
								$("#reviewbut").html("' . $button_txt1 . '");
								$.ajax({
									type: "POST",
									url: "' . site_url("/") . 'trade/submit_review/' . $product_id . '/' . rand(9999, 99999) . '" ,
									data: frm.serializeArray(),
									success: function (data) {
										 $("#review_msg").html(data);
										 $("#reviewbut").html("' . $button_txt2 . '");
										 $("input .star").rating();
									}
								});	
						});	
					});

				   </script>';

		}
		else
		{

			echo '<p>Only My.na users can review products. Please register or log in to review the product.</p>
					<form class="form-signin" action="' . site_url('/') . 'members/login/" enctype="application/x-www-form-urlencoded">
						<input type="hidden" class="input" name="redirect" value="' . current_url() . '">
						<div class="row-fluid">
							<div class="span12">
								<input type="text" class="input span12" name="email"  placeholder="Email">
							</div>
						</div>	
						<div class="row-fluid">
							<div class="span12">
								<input type="password" name="pass" class="input span12" placeholder="Password">
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-scope="email" onlogin="checkLoginState()" data-auto-logout-link="false"></div>
							</div>
							<div class="span4">	
								<a class="btn btn-block btn-inverse" href="' . site_url('/') . 'members/register/"><i class="icon-star icon-white"></i> Join</a> 
							</div>
							<div class="span4">	
								<button type="submit" class="btn btn-block btn-inverse"><i class="icon-lock icon-white"></i> Sign in</button>
							</div>
						</div>
						
					</form>
					';

		}


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//Show Reviews FRONT END
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_reviews($product_id)
	{

		$query = $this->db->query("SELECT u_business_vote.*, products.product_id, products.title, u_client.CLIENT_NAME, u_client.CLIENT_SURNAME, u_client.CLIENT_PROFILE_PICTURE_NAME
                                        FROM u_business_vote
										JOIN products ON products.product_id = u_business_vote.PRODUCT_ID
										JOIN u_client ON u_client.ID = u_business_vote.CLIENT_ID
										WHERE u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND
										 u_business_vote.REVIEW_TYPE = 'product_review' AND u_business_vote.PRODUCT_ID = '" . $product_id . "'", false);

		if ($query->num_rows() > 0)
		{
			echo '<h4 class="na_script">Product Reviews</h4>';

			$x = 0;
			foreach ($query->result() as $row)
			{

				$id = $row->ID;
				$client_id = $row->CLIENT_ID;
				$product_id1 = $row->PRODUCT_ID;
				$review = $row->REVIEW;
				$review_date = $row->TIME_VOTED;
				$rating = $row->RATING;


				$img = $row->CLIENT_PROFILE_PICTURE_NAME;

				if (strstr($img, "http"))
				{

					$data['image'] = $img . '?width=60&height=60';

				}
				elseif ($img != '')
				{

					$data['image'] = NA_SITE_URL . 'assets/users/photos/' . $img;

				}
				else
				{

					$data['image'] = NA_SITE_URL . 'img/user_blank.jpg';

				}
				$data['user'] = $row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME;
				echo '<div class="media well well-mini">
							  <div itemscope itemtype="http://data-vocabulary.org/Review">
							  <span itemprop="itemreviewed" style="display:none">' . $row->title . '</span>
							  <a class="pull-left" href="#" title="Reviewed on ' . date('F j, Y', strtotime($review_date)) . '" rel="tooltip">
							    <span class="avatar-overlay60"></span>
								<img class="media-object" style="border:1px solid #333333;width:60px; margin-right:10px; height:60px" src="' . $data['image'] . '">
							  </a>
							  <span itemprop="summary" style="display:none;height:0px">' . strip_tags($this->shorten_string($review, 8)) . '</span>
							  <div class="media-body">
							  ' . implode($this->get_review_stars($rating, $client_id)) . '
							   <br/>
							  <span itemprop="description">' . $review . '</span>
							   <div style="font-size:10px;"><span itemprop="reviewer">' . $data['user'] . '</span></div>
								
							  <time itemprop="dtreviewed" style="display:none;font-size:10px;font-style:italic" datetime="' . date('m-d-Y', strtotime($review_date)) . '">'
					. date('F j, Y', strtotime($review_date)) . '</time>
							  <span itemprop="rating" style="visibility:hidden">' . ($rating / 2) . '</span>
							  </div>
							  </div>
						  </div>';

			}
			echo '<script type="text/javascript">
							/*$(function(){
								$("input .star").rating();
							});*/
						</script>';

		}
		else
		{

			echo '<div class="alert alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<h4>No Reviews Added</h4>
						No Reviews have been added for the current product.
					  </div>';
		}

	}


	function get_review_stars_show($rating, $id, $rand2 = '', $count)
	{

		$x = 1;
		$x2 = 0;
		$rand = rand(999, 999);
		if (($rating != ''))
		{

			while ($x <= 5)
			{

				if ($rating == $x)
				{

					$str = 'checked="checked"';
				}
				else
				{

					$str = '';

				}

				$arr[$x] = '<input name="' . $id . '-' . $rating . '_' . $rand2 . '" type="radio" value="' . $x . '" class="star' . ' ' . $rand . '" disabled="disabled" ' . $str . '/>
				';
				$x++;
				$x2++;
			}

			$val = $x2 / 2;

			$arr = '<div style="font-size:10px;font-style:italic;" class="clearfix"><span class="pull-left">' . implode($arr) . '</span><br />
	                        <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	                        <br /><span itemprop="ratingValue">' . number_format($rating, 0) . '</span> Stars
	                         Based on: <b><span itemprop="reviewCount">' . $count . '</span></b> reviews</span>
					</div>';

			return $arr;

		}
		else
		{

			$arr = '<p class="clearfix"><a class="pull-left clearfix"><span class="label label-warning" title="Review this business to help them feature" rel="tooltip">No reviews yet. Be the first</span></a></p>';

			return $arr;

		}
	}


	//Shorten String
	function shorten_string($phrase, $max_words)
	{

		$phrase_array = explode(' ', $phrase);

		$end = '...';
		if (trim(strlen($phrase)) < 1)
		{
			$end = '';
		}

		if (count($phrase_array) > $max_words && $max_words > 0)
		{

			$phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . $end;
		}

		return $phrase;

	}

	function get_user_avatar($id)
	{


		if ($id != '0')
		{

			$this->db->from('u_client');
			$this->db->where('ID', $id);
			$query = $this->db->get();
			$row = $query->row_array();

			if ($query->result())
			{

				$img = $row['CLIENT_PROFILE_PICTURE_NAME'];

				if (strstr($img, "http"))
				{

					$data['image'] = $img . '?width=60&height=60';

				}
				elseif ($img != '')
				{

					$data['image'] = NA_SITE_URL . 'assets/users/photos/' . $img;

				}
				else
				{

					$data['image'] = NA_SITE_URL . 'img/user_blank.jpg';

				}

				$data['name'] = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];

				return $data;

			}
			else
			{

				$data['image'] = NA_SITE_URL . 'img/user_blank.jpg';
				$data['name'] = 'user';

				return $data;

			}
		}

	}

	//+++++++++++++++++++++++++++
	//GET PRODUCT NAME
	//++++++++++++++++++++++++++
	public function get_product_name($id)
	{
		$this->db->select('title');
		$this->db->where('product_id', $id);
		$query = $this->db->get('products');

		if ($query->num_rows() > 0)
		{

			$row = $query->row_array();
			$name = $row['title'];

			return $name;

		}
		else
		{

			$data = 'No Name';

			return $data;


		}


	}

	//+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS
	//++++++++++++++++++++++++++
	public function populate_suburb_name($reg, $suburb_current)
	{

//		$this->db->where('SUBURB_NAME' , $reg);
//		$this->db->from('a_map_suburb');
//		$query = $this->db->get();
		$query = $this->db->query("SELECT * FROM a_map_location JOIN a_map_suburb ON a_map_location.ID = a_map_suburb.CITY_ID WHERE a_map_location.MAP_LOCATION = '" . $this->decode_url($reg) . "' ORDER BY a_map_suburb.SUBURB_NAME", false);
		if ($query->num_rows() > 0)
		{


			echo '<select id="suburb" name="suburb" class="span12">
						<option value="all">Please Select</option>';

			foreach ($query->result() as $row)
			{

				$suburb = $row->SUBURB_NAME;
				$sub_id = $row->ID;

				if (trim(ucwords($this->decode_url($suburb_current))) == trim($suburb))
				{
					$str = 'selected="selected"';
				}
				else
				{
					$str = '';
				}

				echo '<option value="' . $suburb . '" ' . $str . ' >' . $suburb . '</option>';


			}
			echo '</select> 

               ';
		}
		else
		{

			echo '<select id="suburb" name="suburb" class="span12" disabled="disabled"></select>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET PRODUCT NAME
	//++++++++++++++++++++++++++
	public function get_category_name($id)
	{
		$this->db->select('category_name');
		$this->db->where('cat_id', $id);
		$query = $this->db->get('product_categories');

		if ($query->result())
		{

			$row = $query->row_array();
			$name = $row['category_name'];

			return $name;

		}
		else
		{

			$data = 'No Name';

			return $data;


		}


	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY ID
	//++++++++++++++++++++++++++
	public function get_category_id($name, $level, $top_id)
	{
		$this->db->select('category_name, cat_id');

		if ($level == 'main')
		{

			$this->db->where($level . '_cat_id', '0');

		}
		if ($level == 'sub')
		{
			$this->db->where('main_cat_id =', $top_id);
			$this->db->where($level . '_cat_id', '0');

		}
		if ($level == 'sub_sub')
		{
			$this->db->where('main_cat_id !=', '0');
			$this->db->where('sub_cat_id =', $top_id);
			$this->db->where($level . '_cat_id', '0');

		}
		if ($level == 'sub_sub_sub')
		{
			$this->db->where('main_cat_id !=', '0');
			$this->db->where('sub_cat_id !=', '0');
			$this->db->where('sub_sub_cat_id =', $top_id);
			$this->db->where($level . '_cat_id', '0');

		}
		$this->db->where('category_name', $name);
		$this->db->limit(1);
		$query = $this->db->get('product_categories');

		if ($query->num_rows() > 0)
		{

			$row = $query->row_array();
			$id = $row['cat_id'];

			return $id;

		}
		else
		{

			$data['cat_id'] = '0';

			return $data;


		}


	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW CATEGORY FEATURE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_feature($cat_id, $type)
	{

		if ($cat_id == 0)
		{

			//Get FEATURED PRODUCTS
			$main = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
										WHERE products.is_active = 'Y' AND products.status = 'live'
                                        GROUP BY product_images.product_id HAVING COUNT(product_images.product_id) > 4
                                        ORDER BY rand() LIMIT 5", false);

			//WHERE products.is_active = 'Y' AND products.status = 'live' AND product_extras.featured = 'Y'


		}
		else
		{

			//Get FEATURED PRODUCTS
			$main = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                         MAX(product_auction_bids.amount) as current_bid,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
										WHERE " . $type . "_cat_id = '" . $cat_id . "' AND product_extras.featured = 'Y' AND products.is_active = 'Y' AND products.status = 'live'
                                        GROUP BY product_images.product_id HAVING COUNT(product_images.product_id) > 4
                                        ORDER BY rand() LIMIT 5", false);

			//WHERE ".$type."_cat_id = '".$cat_id."' AND product_extras.featured = 'Y' AND products.is_active = 'Y' AND products.status = 'live'
		}

		if ($main->result())
		{
			$x = 0;
			echo '<div class="product_ribbon"><small>My Namibia&trade;</small>FEATURED LISTINGS<span></span></div>';
			echo '<div id="featureCarousel" class="carousel min400 slide_420" style="">
					<div id="feat_progress" style="position:absolute; height:3px;margin-top:-3px;border-top:1px solid #ED891F; background:#000; opacity:0.7"></div>
					<div class="carousel-inner feature-cycle-slideshow" data-cycle-fx="scrollHorz"
    							data-cycle-pause-on-hover="true" data-cycle-pause-on-hover="true"  data-cycle-timeout="4000"
    							 data-cycle-slides="> div">';
			foreach ($main->result() as $row)
			{

				$active = '';
				if ($x == 0)
				{

					$active = 'active';
				}
				//images
				$images = $this->show_images_mosaic($row->images, $size = '');

				$fb = "postToFeed(" . $row->product_id . ", '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . "','" . trim($images['file']) . "', '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->description, " ", " ")), 50))) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . trim($this->clean_url_str($row->title)) . "')";
				//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";

				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
				);

				$tweet_url = $this->clean_url_str($row->title) . '&text=' . substr(strip_tags($row->title . ' ' . $row->description), 0, 60) . ' ' . site_url('/') . 'product/' . $row->product_id . '&via=MyNamibia';
				//CHECK IF AGENCY PROPERTY LISTING
				//CHECK IF AGENCY PROPERTY LISTING
				$b_logo = '';
				if ($row->IS_ESTATE_AGENT == 'Y')
				{

					if (trim($row->BUSINESS_LOGO_IMAGE_NAME) != '')
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . NA_SITE_URL . 'assets/business/photos/' . $row->BUSINESS_LOGO_IMAGE_NAME . '" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}
					else
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . NA_SITE_URL . 'img/timbthumb.php?w=50&h=50&src=' . NA_SITE_URL . 'img/bus_blank.jpg" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}

				}
				if ($row->listing_type == 'S')
				{

					if ($row->status == 'sold')
					{
						$price['str'] = ' Sold';
					}
					else
					{
						if ($row->sub_cat_id == 3410)
						{
							$price['str'] = '<span style=" font-size:12px">N$</span> ' . $this->smooth_price($row->sale_price) . ' pm';
						}
						else
						{
							$price['str'] = '<span style=" font-size:12px">N$</span> ' . $this->smooth_price($row->sale_price);
						}
						if ($row->por == 'Y')
						{

							$price['str'] = '<span itemprop="price"> POR</span> <span style=" font-size:14px">Price On Request</span>';

						}
					}

				}
				else
				{

					$price = $this->get_current_bid($row->current_bid);

				}
				//get REVIEWS
				//get REVIEWS
				$rating = 0;
				$total_reviews = 0;
				if ($row->TOTAL != null)
				{

					$rating = $row->TOTAL;
					$total_reviews = $row->TOTAL_REVIEWS;
				}


				echo '<div class="item"  style="padding:2px;">
					   <div class="row-fluid">
					  	<div class="span8">' . $images['str'] . '</div>
						<div class="span4 white_box padding10">
							<h3 class="upper na_script">' . $this->shorten_string($row->title, 5) . '</h3>
							<h4 class="upper na_script">' . $price['str'] . '</h4>
							<div  style="min-height:170px">
							    <p>' . $this->show_extras_short($row->extras) . '</p>
							    ' . $this->get_review_stars_show($rating, $row->product_id, rand(1000, 9999), $total_reviews) . '
							    <a href="javascript:void(0)" onclick="' . $tweet_url . '" class="twitter"></a>
							    <a href="javascript:void(0)" onclick="' . $fb . '" class="facebook"></a>
							' . $b_logo . '
							</div>
							<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right" ><i class="icon-share icon-white"></i> View</a>
					  		<div class="clearfix">&nbsp;</div>
						</div>
					   </div>
					 </div>';

				$x++;
			}

			echo '<a class="carousel-control left Cleft cycle-prev">&lsaquo;</a>
				  <a class="carousel-control right Cright cycle-next">&rsaquo;</a>
				  </div>
				  
				</div>';

		}
		else
		{


		}

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW POPULAR CATEGORIES 
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_popular_cats($id = 0, $type = '', $location = '')
	{


		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if (! $output = $this->cache->get('trade/show_popular_cats_' . $id . '_' . $type . '_' . $location))
		{
			$output = '';
			if ($id == 0)
			{
				//LOCATION
				$locationSQL = '';
				if ($location != 'national' && $location != '')
				{
					$locationSQL = " WHERE location = '" . $location . "' ";
				}
				//Get Main
				$main = $this->db->query("SELECT DISTINCT(products.main_cat_id), COUNT(products.main_cat_id) as num, products.title,
										product_categories.category_name FROM products JOIN product_categories ON products.main_cat_id = product_categories.cat_id
										" . $locationSQL . "
										GROUP BY products.main_cat_id ORDER BY num DESC LIMIT 20", false);
				$ref = 'main';
				$output .= '<h4 class="upper">Browse By Category</h4>';
				foreach ($main->result() as $row)
				{

					$main_id = $row->main_cat_id;
					$main_name = $row->category_name;

					//echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';
					$output .= '<a class="btn btn-mini btn-inverse" href="' . site_url('/') . 'buy/' . $this->encode_url($main_name) . '/" style="margin:5px"> ' . $main_name . ' <i class="icon-chevron-right icon-white"></i></a>';

				}

			}
			else
			{
				//LOCATION
				$locationSQL = '';
				$locationN = $location;
				if ($location != 'national' && $location != '')
				{
					$locationSQL = " AND location = '" . $location . "' ";
				}
				if ($type == 'main')
				{

					$sub = 'sub';
					$ref = 'sub';

					//Get sub
					$main = $this->db->query("SELECT DISTINCT(products." . $sub . "_cat_id), COUNT(products." . $sub . "_cat_id) as num, products.title,
											product_categories.category_name, product_categories.main_cat_id FROM products
											JOIN product_categories ON products." . $sub . "_cat_id = product_categories.cat_id
											WHERE products." . $type . "_cat_id = '" . $id . "' " . $locationSQL . "
											GROUP BY products." . $sub . "_cat_id ORDER BY num DESC LIMIT 20", false);
					echo '<h4>Browse By Category</h4>';

					//$output .= 'Level 2';

					foreach ($main->result() as $row)
					{

						$main_id = $row->main_cat_id;
						//$main_name = $this->get_category_name($row->main_cat_id).' - '.$row->category_name;

						//echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';
						$output .= '<a class="btn btn-mini btn-inverse" href="' . site_url('/') . 'buy/' . $this->encode_url($this->get_category_name($row->main_cat_id)) . '/' . $this->encode_url($row->category_name) . '/" style="margin:5px"> ' . $row->category_name . ' <i class="icon-chevron-right icon-white"></i></a>';

					}


				}
				elseif ($type == 'sub')
				{

					$sub = 'sub_sub';
					$ref = 'sub_sub';

					//Get sub
					$sub = $this->db->query("SELECT DISTINCT(products." . $sub . "_cat_id), COUNT(products." . $sub . "_cat_id) as num, products.title,
											product_categories.category_name, product_categories.main_cat_id, product_categories.sub_cat_id FROM products JOIN product_categories ON products." . $sub . "_cat_id = product_categories.cat_id
											WHERE products." . $type . "_cat_id = '" . $id . "' GROUP BY products." . $sub . "_cat_id ORDER BY num DESC LIMIT 20", false);

					foreach ($sub->result() as $row2)
					{

						$main_id = $row2->main_cat_id;
						$main_name = $this->get_category_name($row2->main_cat_id);
						$sub_id = $row2->sub_cat_id;
						$sub_name = $this->get_category_name($row2->sub_cat_id);
						//echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';
						$output .= '<a class="btn btn-mini btn-inverse" href="' . site_url('/') . 'buy/' . $this->encode_url($main_name) . '/' . $this->encode_url($sub_name) . '/' . $this->encode_url($row2->category_name) . '/" style="margin:5px"> ' . $row2->category_name . ' <i class="icon-chevron-right icon-white"></i></a>';

					}


				}
				elseif ($type == 'sub_sub')
				{

					$sub = 'sub_sub_sub';
					$ref = 'sub_sub_sub';

					//Get sub
					$sub_sub = $this->db->query("SELECT DISTINCT(products." . $sub . "_cat_id), COUNT(products." . $sub . "_cat_id) as num, products.title,
											product_categories.category_name, product_categories.main_cat_id, product_categories.sub_cat_id, product_categories.sub_sub_cat_id FROM products JOIN product_categories ON products." . $sub . "_cat_id = product_categories.cat_id
											WHERE products." . $type . "_cat_id = '" . $id . "' GROUP BY products." . $sub . "_cat_id ORDER BY num DESC LIMIT 20", false);

					foreach ($sub_sub->result() as $row3)
					{

						$main_id = $row3->main_cat_id;
						$main_name = $this->get_category_name($row3->main_cat_id);
						$sub_id = $row3->sub_cat_id;
						$sub_name = $this->get_category_name($row3->sub_cat_id);
						$sub_sub_id = $row3->sub_sub_cat_id;
						$sub_sub_name = $this->get_category_name($row3->sub_sub_cat_id);
						//echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';
						$output .= '<a class="btn btn-mini btn-inverse" href="' . site_url('/') . 'buy/' . $this->encode_url($main_name) . '/' . $this->encode_url($sub_name) . '/' . $this->encode_url($sub_sub_name) . '/' . $this->encode_url($row3->category_name) . '/" style="margin:5px"> ' . $row3->category_name . ' <i class="icon-chevron-right icon-white"></i></a>';

					}


				}


			}

			$this->cache->save('trade/show_popular_cats_' . $id . '_' . $type . '_' . $location, $output, 3600);
		}
		//$this->output->set_output($output);
		echo $output;

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW LOCATION LISTING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_location_items($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb)
	{

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if (! $output = $this->cache->get('trade/show_location_items_' . $main_cat_id . '_' . $sub_cat_id . '_' . $sub_sub_cat_id . '_' . $sub_sub_sub_cat_id . '_' . $location . '_' . $suburb))
		{

			$output = '';
			if ($sub_sub_sub_cat_id != 0)
			{
				$catname = $this->get_category_name($main_cat_id) . ' ' . $this->get_category_name($sub_cat_id) . ' ' . $this->get_category_name($sub_sub_cat_id) . ' ' . $this->get_category_name($sub_sub_sub_cat_id);
				$catnameURL = $this->get_category_name($main_cat_id) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_sub_cat_id)) . '/n/n/' . $main_cat_id . '/' . $sub_cat_id . '/' . $sub_sub_cat_id . '/' . $sub_sub_sub_cat_id . '/';
				$catSQL = " WHERE sub_sub_sub_cat_id = " . $sub_sub_sub_cat_id . "";

			}
			elseif ($sub_sub_cat_id != 0)
			{
				$catname = $this->get_category_name($main_cat_id) . ' ' . $this->get_category_name($sub_cat_id) . ' ' . $this->get_category_name($sub_sub_cat_id);
				$catnameURL = $this->get_category_name($main_cat_id) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/' . $this->encode_url($this->get_category_name($sub_sub_cat_id)) . '/no-name/n/n/' . $main_cat_id . '/' . $sub_cat_id . '/' . $sub_sub_cat_id . '/' . $sub_sub_sub_cat_id . '/';
				$catSQL = " WHERE sub_sub_cat_id = " . $sub_sub_cat_id . "";

			}
			elseif ($sub_cat_id != 0)
			{
				$catname = $this->get_category_name($main_cat_id) . ' ' . $this->get_category_name($sub_cat_id);
				$catnameURL = $this->get_category_name($main_cat_id) . '/' . $this->encode_url($this->get_category_name($sub_cat_id)) . '/no-name/no-name/n/n/' . $main_cat_id . '/' . $sub_cat_id . '/' . $sub_sub_cat_id . '/' . $sub_sub_sub_cat_id . '/';
				$catSQL = " WHERE sub_cat_id = " . $sub_cat_id . "";

			}
			elseif ($main_cat_id != 0)
			{
				$catname = $this->get_category_name($main_cat_id);
				$catnameURL = $this->encode_url($this->get_category_name($main_cat_id)) . '/no-name/no-name/no-name/n/n/' . $main_cat_id . '/' . $sub_cat_id . '/' . $sub_sub_cat_id . '/' . $sub_sub_sub_cat_id . '/';
				$catSQL = " WHERE main_cat_id = " . $main_cat_id . "";

			}
			else
			{
				$catname = 'Items';
				$catnameURL = '';
				$catSQL = "";

			}

			//LOCATION
			$locationN = $location;
			$locationSQL = '';
			if ($location != 'national' && $location != '')
			{
				$locationN = $location;
				if ($catSQL == '')
				{
					$locationSQL = " WHERE location = '" . $location . "' ";
				}
				else
				{

					$locationSQL = " AND location = '" . $location . "' ";
				}


			}
			elseif ($location == 'national' || $location == '')
			{
				$locationN = 'Namibia';
			}


			$query = $this->db->query("SELECT COUNT(location) as count_, products.* FROM products " . $catSQL . $locationSQL . " GROUP BY location", false);

			//echo "SELECT COUNT(location) as count_, products.* FROM products ".$catSQL.$locationSQL." GROUP BY location";

			if ($query->result())
			{
				$output .= '<h4>' . $catname . ' in ' . ucwords($locationN) . '</h4>';
				foreach ($query->result() as $row)
				{
					$link = $this->encode_url($this->get_category_name($row->main_cat_id)) . '/' . $this->encode_url($this->get_category_name($row->sub_cat_id)) . '/no-name/no-name/' . $this->encode_url($row->location) . '/all/n/n/' . $row->main_cat_id . '/' . $row->sub_cat_id . '/0/0/';
					$output .= '<a href="' . site_url('/') . 'buy/' . $link . '/" class="btn btn-mini btn-inverse" style="margin:5px">' . $row->location . ' <span class="badge badge-inverse">' . $row->count_ . '</span> <i class="icon-chevron-right icon-white"></i></a> ';

				}

			}
			$this->cache->save('trade/show_location_items_' . $main_cat_id . '_' . $sub_cat_id . '_' . $sub_sub_cat_id . '_' . $sub_sub_sub_cat_id . '_' . $location . '_' . $suburb, $output, 3600);
		}
		//$this->output->set_output($output);
		echo $output;

	}


	//Get Main Categories
	function get_categories_populated()
	{

		$test = $this->db->query("SELECT DISTINCT(products.main_cat_id), COUNT(products.main_cat_id) as num, products.title, 
									product_categories.category_name FROM products JOIN product_categories ON products.main_cat_id = product_categories.cat_id 
									GROUP BY products.main_cat_id ORDER BY num DESC LIMIT 20", false);

		return $test;
	}
	//+++++++++++++++++++++++++++
	//GET PRODUCT EXTRAS
	//++++++++++++++++++++++++++
	public function property_agents($bus_id, $curr)
	{

		//get BUSINESS
		$this->db->where('ID', $bus_id);
		$bus = $this->db->get('u_business');

		if ($bus->result())
		{

			$row = $bus->row();

			if ($row->IS_ESTATE_AGENT == 'Y')
			{

				echo '<div class="control-group">
						  <label class="control-label" for="property_agent">Select Agent</label>
						  <div class="controls">
							  <select name="property_agent"  class="span12">
								  <option value="0">None</option>';


				//Get all Agents
				$agents = $this->db->query("SELECT * FROM i_client_business 
											JOIN u_client ON i_client_business.CLIENT_ID = u_client.ID 
											WHERE i_client_business.BUSINESS_ID = '" . $bus_id . "'", false);

				if ($agents->result())
				{

					foreach ($agents->result() as $arow)
					{

						if ($curr == $arow->CLIENT_ID)
						{

							echo '<option value="' . $arow->CLIENT_ID . '" selected>' . $arow->CLIENT_NAME . ' ' . $arow->CLIENT_SURNAME . '</option>';
						}
						else
						{

							echo '<option value="' . $arow->CLIENT_ID . '">' . $arow->CLIENT_NAME . ' ' . $arow->CLIENT_SURNAME . '</option>';
						}

					}

				}

				echo '			</select>
							  <span class="help-block"  style="font-size:11px">
							Please select the Agent</span>
						  </div>
					 </div>';


			}


			//SHOW FEATURED PROPERTY OPTION
			return true;


		}
		else
		{

			//DONT SHOW FEATURED PROPERTY OPTION
			return false;

		}


	}


	//+++++++++++++++++++++++++++
	//GET COMPANY DETAILS
	//++++++++++++++++++++++++++
	public function show_company($bus_id, $client_id, $sub_cat_id = 3408)
	{

		if ($bus_id != 0)
		{

			//$this->db->where('ID', $bus_id);
			$bus = $this->db->query("SELECT  u_business.*, a_map_location.MAP_LOCATION as city, a_map_region.REGION_NAME as region FROM u_business
									LEFT JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
									LEFT JOIN a_map_region ON a_map_location.MAP_REGION_ID = a_map_region.ID
									WHERE u_business.ID = '" . $bus_id . "'
									");

			if ($bus->result())
			{

				$row = $bus->row();
				$img = $row->BUSINESS_LOGO_IMAGE_NAME;
				//Build image string
				$format = substr($img, (strlen($img) - 4), 4);
				$str = substr($img, 0, (strlen($img) - 4));

				if ($img != '')
				{

					if (strpos($img, '.') == 0)
					{

						$format = '.jpg';
						$img_str = NA_SITE_URL . 'img/timbthumb.php?w=200&h=200&src=' . NA_SITE_URL . 'assets/business/photos/' . $img . $format;

					}
					else
					{

						$img_str = NA_SITE_URL . 'img/timbthumb.php?w=200&h=200&src=' . NA_SITE_URL . 'assets/business/photos/' . $img;

					}

				}
				else
				{

					$img_str = NA_SITE_URL . 'img/timbthumb.php?w=200&h=200&src=' . NA_SITE_URL . 'img/bus_blank.png';

				}
				//COVER IMAGE
				$cover_img = $row->BUSINESS_COVER_PHOTO;

				if ($cover_img != '')
				{

					if (strpos($cover_img, '.') == 0)
					{

						$format2 = '.jpg';
						$cover_str = NA_SITE_URL . 'assets/business/photos/' . $cover_img . $format2;

					}
					else
					{

						$cover_str = NA_SITE_URL . 'assets/business/photos/' . $cover_img;

					}

				}
				else
				{

					$cover_str = NA_SITE_URL . 'img/business_cover_blank.jpg';

				}
				$link = site_url('/') . 'b/' . $bus_id . '/' . $this->encode_url($row->BUSINESS_NAME) . '/';
				$agent = '<a href="' . $link . '" class="btn btn-inverse pull-right"><i class="icon-share icon-white"></i> View Details</a>';
				if ($row->IS_ESTATE_AGENT == 'Y' && $client_id != 0)
				{

					$agent = $this->show_estate_agent($client_id, $bus_id, $row->BUSINESS_NAME, false, $sub_cat_id);

				}

				echo '<div class="white_box padding10">
							<div class="row-fluid vignette" style="min-height:180px;background:url(' . $cover_str . ') no-repeat;background-size:cover;z-index:88; position:relative">
							 <div class="row-fluid " style="height:200px;">
											
								<div class="span8">
								
								
								</div>
								
								<div class="span4">
								
								
								</div>
						   
					  
							</div>
						  </div>
						   <div class="row-fluid" style="margin-top:-100px;z-index:9999; position:relative">
											
								<div class="span1">
								
								</div>
								<div class="span3">
	
										<a href="' . $link . '">
											<img class="img-polaroid" src="' . $img_str . '" alt="' . $row->BUSINESS_NAME . '" style="width: 110px; height:110px;">
										</a>	
						 
								</div>
								
								<div class="span8">
								
									 <div class="media">
										<div class="row-fluid" style="min-height:80px;">
										
											<div class="span6">
											
											</div>
											<div class="span6">
																   
											 
											</div>                           
										
										</div>
										
									 </div>
									 
								</div>
  
                		 </div><!-- row -->
						 <div class="row-fluid">
								<div itemscope style="display:none;padding:0;margin:0" itemtype="http://data-vocabulary.org/Organization"> 
								<span itemprop="name">' . $row->BUSINESS_NAME . '</span></div>

								<h1 style="font-size:130%;line-height:30px">' . $row->BUSINESS_NAME . '</h1>

								<div itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
									<span itemprop="street-address"><i class="icon-map-marker"></i> ' . $row->BUSINESS_PHYSICAL_ADDRESS . '</span>
									<span itemprop="locality">' . $row->city . '</span>
									<span itemprop="region">' . $row->region . '</span>
									<span itemprop="country-name">Namibia</span>
								</div>
						 </div>
						 <div class="row-fluid">
								' . $agent . '
						 </div>
						
					</div>
					
					
					  ';

			}
			else
			{


			}


		}

	}


	//+++++++++++++++++++++++++++
	//GET ESTATE AGENT
	//++++++++++++++++++++++++++
	public function show_estate_agent($client_id, $bus_id, $bus_name, $val = false, $sub_cat_id)
	{
		$agent = $this->db->where('ID', $client_id);
		$agent = $this->db->get('u_client');
		$res = '';

		$tstr = 'Properties';
		if ($sub_cat_id != 3408)
		{

			$tstr = 'Products';

		}

		if ($agent->result())
		{

			$row = $agent->row();
			$img_file = $row->CLIENT_PROFILE_PICTURE_NAME;

			if ($img_file != '')
			{

				$img = NA_SITE_URL . 'assets/users/photos/' . $img_file;

			}
			else
			{

				$img = NA_SITE_URL . 'img/user_blank.jpg';

			}
			$UAagent = 'href="javascript:void(0)"';
			if ($this->agent->is_mobile())
			{
				$UAagent = 'href="tel:' . substr($row->CLIENT_CELLPHONE, 0, 8) . substr($row->CLIENT_CELLPHONE, 8, strlen($row->CLIENT_CELLPHONE)) . '"';
			}
			if ($val)
			{
				$res = '<div class="span12">	
							<div class="clearfix">&nbsp;</div>
							<img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . $img . '&w=100&h=100" style="margin-right:10px;" class="img-polaroid pull-left" />
							<h4>' . ucwords($row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME) . '</h4>
							<p><a href="' . site_url('/') . 'trade/agent/' . $bus_id . '/' . $row->ID . '/' . $this->encode_url($bus_name) . '/' . $this->encode_url($row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME) . '/" class="btn btn-inverse btn-mini">View Agent ' . $tstr . '</a></p>
							<p><a ' . $UAagent . ' class="btn btn-inverse btn-mini"><i class="icon-calendar icon-white"></i> ' . $row->CLIENT_CELLPHONE . '</a></p>
						</div>
						';

			}
			else
			{


				$res = '<div class="span8">	
							<div class="clearfix">&nbsp;</div>
							<img src="' . NA_SITE_URL . 'img/timbthumb.php?src=' . $img . '&w=100&h=100" style="margin-right:10px;" class="img-polaroid pull-left" />
							<h4>' . ucwords($row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME) . '</h4>
							<p><a href="' . site_url('/') . 'trade/agent/' . $bus_id . '/' . $row->ID . '/' . $this->encode_url($bus_name) . '/' . $this->encode_url($row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME) . '/" class="btn btn-inverse btn-mini">View Agent ' . $tstr . '</a></p>
							<p><a ' . $UAagent . ' class="btn btn-inverse btn-mini"><i class="icon-calendar icon-white"></i> ' . $row->CLIENT_CELLPHONE . '</a></p>
						</div>
						<div class="span4 text-right">
							<a href="' . site_url('/') . 'trade/agent/' . $bus_id . '/0/' . $this->encode_url($bus_name) . '/" class="btn btn-inverse"><i class="icon-home icon-white"></i> View ' . $tstr . '</a>
							<a href="' . site_url('/') . 'b/' . $bus_id . '/' . $this->encode_url($bus_name) . '/" class="btn btn-inverse hide hidden-phone hidden-tablet"><i class="icon-share icon-white"></i> View Details</a> 
						</div>
						';

			}


		}

		return $res;
	}

	//+++++++++++++++++++++++++++
	//GET PRODUCT EXTRAS
	//++++++++++++++++++++++++++
	public function build_canonical()
	{
		$url = '';
		if ($this->uri->segment(7) != '0' && $this->uri->segment(7) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $this->uri->segment(7) . '/';

		}
		elseif ($this->uri->segment(6) != 'no-name' && $this->uri->segment(6) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/';

		}
		elseif ($this->uri->segment(5) != 'no-name' && $this->uri->segment(5) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/';

		}
		elseif ($this->uri->segment(4) != 'no-name' && $this->uri->segment(4) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/';

		}
		elseif ($this->uri->segment(3) != 'no-name' && $this->uri->segment(3) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';

		}
		elseif ($this->uri->segment(2) != 'no-name' && $this->uri->segment(2) != '')
		{

			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';

		}
		elseif ($this->uri->segment(1) != 'no-name' && $this->uri->segment(1) != '')
		{

			$url = $this->uri->segment(1) . '/';

		}

		echo site_url('/') . $url;

	}
	//+++++++++++++++++++++++++++
	//GET PRODUCT EXTRAS
	//++++++++++++++++++++++++++
	public function get_extras($product_id)
	{

		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product_extras');

		if ($query->result())
		{

			$row = $query->row_array();
			$data['extras'] = json_decode($row['extras'], true);
			$data['property_agent'] = $row['property_agent'];
			$data['featured'] = $row['featured'];
			$data['adjustment'] = $row['adjustment'];
			$data['seller_contact'] = $row['seller_contact'];

			return $data;

		}
		else
		{
			$data['property_agent'] = 0;
			$data['featured'] = 'N';
			$data['extras'] = '';
			$data['adjustment'] = 'N';
			$data['seller_contact'] = '';

			return $data;


		}

	}


	//+++++++++++++++++++++++++++
	//TEST PRODUCT EXTRAS SELECT
	//++++++++++++++++++++++++++
	function test_extras($existing, $extra, $type, $extra_value)
	{

		//$existing = unserialize($existing);
		if (count($existing) > 0 && is_array($existing))
		{

			foreach ($existing as $key => $value)
			{
				//echo $key . ' ' .$value;
				//FEATURES ARRAY
				if (is_array(json_decode($value)))
				{

					foreach (json_decode($value) as $subkey)
					{

						if ($subkey == $extra_value)
						{

							echo $type;
						}

					}
					//STNDARD EXTRAS	 
				}
				elseif ($key == $extra && $value == $extra_value)
				{

					echo $type;
				}


			}

		}


	}
	//+++++++++++++++++++++++++++
	//TEST PRODUCT EXTRAS SELECT
	//++++++++++++++++++++++++++
	function test_extras_features($existing, $extra, $type, $extra_value)
	{

		//$existing = unserialize($existing);
		if (count($existing) > 0 && is_array($existing))
		{

			foreach ($existing as $key => $value)
			{
				echo $key . ' ' . $value;
				if ($key == $extra && $value == $extra_value)
				{

					echo $type;
				}


			}

		}


	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS RATING STARS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET BUSINESS RATING
	public function get_rating($id)
	{

		$query = $this->db->query("SELECT AVG(RATING)as TOTAL FROM u_business_vote WHERE PRODUCT_ID ='" . $id . "' AND IS_ACTIVE = 'Y' AND TYPE = 'review' ORDER BY TOTAL ");


		if ($query->result())
		{

			$row = $query->row_array();

			return round($row['TOTAL']);

		}
		else
		{

			return 0;

		}


	}

	//GET BUSINESS RATING COUNT
	public function get_rating_count($id)
	{

		$query = $this->db->query("SELECT RATING FROM u_business_vote WHERE PRODUCT_ID ='" . $id . "' AND IS_ACTIVE = 'Y' AND TYPE = 'review'");

		return $query->num_rows();


	}

	function get_review_stars($rating, $id)
	{

		$x = 1;

		while ($x <= 5)
		{

			if ($rating == $x)
			{

				$str = 'checked="checked"';
			}
			else
			{

				$str = '';

			}

			$arr[$x] = '<input name="' . $id . '-' . $rating . '" type="radio" value="' . $x . '" class="star" disabled="disabled" ' . $str . '/>
			';
			$x++;
		}

		return $arr;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN URL
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function encode_url($str, $replace = array())
	{

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = str_replace(" ", '-', $clean);
		$clean = strtolower(trim($clean));
		$clean = str_replace("&", 'and', $clean);

		return $clean;
	}

	//setlocale(LC_ALL, 'en_US.UTF8');
	function decode_url($str, $replace = array())
	{

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = str_replace("-", ' ', $clean);
		$clean = str_replace("and", '&', $clean);
		$clean = ucwords(trim($clean));


		return $clean;
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace = array(), $delimiter = '-')
	{
		if (! empty($replace))
		{
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}


	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //ENCODING ENCRYPTION
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++ */


	public function decrypt($string)
	{
		$this->load->library('encrypt');
		$data = str_replace('_-_', '/', str_replace('-_-', '+', str_replace('-a-', '=', ($this->encrypt->decode($string)))));

		//$data =  $this->encrypt->decode($string);
		return $data;
	}

	public function encrypt($string)
	{
		$this->load->library('encrypt');

		$data = str_replace('/', '_-_', str_replace('+', '-_-', str_replace('=', '-a-', ($this->encrypt->encode($string)))));

		//$data = $this->encrypt->encode($string);
		return $data;
	}


}

?>