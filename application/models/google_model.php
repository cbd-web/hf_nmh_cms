<?php
class Google_model extends CI_Model{
	
 	function google_model(){
  		//parent::CI_model();
			
 	}

	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//GOOGLE API 
	//Functions
			$this->load->library('ga_api');

		 Set new profile id if not the default id within your config document
		$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));
		
		 Query Google metrics and dimensions
		 Documentation: http://code.google.com/apis/analytics/docs/gdata/dimsmets/dimsmets.html)

		 Also please note, if you using default values you still need to init()
		$data = $this->ga_api->login()
			->dimension('keyword')
			->metric('organicSearches')
			->limit(30)
			->get_object();
   
   
		 Please note you can also query against your account and find all the profiles associated with it by
		 grab all profiles within your account
		$data['accounts'] = $this->ga_api->login()->get_accounts();
	++++++++++++++++++++++++++++++++++++++++++++	
	*/
	//30 Day Overview Summary
	public function load_overview($start, $end)
	{

		//$this->load->library('ga_api');

		// Set new profile id if not the default id within your config document
		//$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));
		
		// Query Google metrics and dimensions
		// Documentation: http://code.google.com/apis/analytics/docs/gdata/dimsmets/dimsmets.html)
		$ga = $this->set_GA($view_id = $this->session->userdata('GA_profile'));

		if($start == '' || $end == ''){

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime('-30 days')),
				'end-date' => date('Y-m-d'),
			);

		}else{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime($start)),
				'end-date' => date('Y-m-d', strtotime($end)),
			);



		}

		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics' => 'ga:sessions,ga:bounceRate,ga:bounces, ga:percentNewSessions,ga:newUsers, ga:sessionDuration, ga:avgPageLoadTime, ga:sessionsPerUser',
			'dimensions' => 'ga:date, ga:sessionDurationBucket,ga:sessionCount,ga:daysSinceLastSession',
		);

		$data = $ga->query($params);

		//echo $data['totalsForAllResults']['ga:sessions'] .'<br />';




		//LOAD CIRCLE STATS
		echo '	
				<div class="circleStats">
                    
					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem red">
							<i class="fa-icon-group"></i>
							
                        	<input type="text" value="'.$data['totalsForAllResults']['ga:sessions'].'" class="orangeCircle" />
                    	</div>
						<div class="box-small-title">Visitors this month</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem blue">
                        	<i class="fa-icon-user"></i>
                        	<input type="text" value="'.$data['totalsForAllResults']['ga:newUsers'].'" class="blueCircle" />
                    	</div>
						<div class="box-small-title">New Visitors</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem yellow">
                        	<i class="fa-icon-thumbs-down"></i>
							
							<span class="percent">%</span>
                        	<input type="text" value="'.round($data['totalsForAllResults']['ga:bounceRate'],2).'" class="yellowCircle" />
                    	</div>
						<div class="box-small-title">Bounce Rate</div>
					</div>
					<div class="noMargin span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem pink">
                        	<i class="fa-icon-user-md"></i>
							<span class="percent">%</span>
                        	<input type="text" value="'.round($data['totalsForAllResults']['ga:percentNewSessions'],2).'" class="pinkCircle" />
                    	</div>
						<div class="box-small-title">% New Visits</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
                    	<div class="circleStatsItem green">
                        	<i class="fa-icon-dashboard"></i>

							<span class="percent">s</span>
                        	<input type="text" value="'.round($data['totalsForAllResults']['ga:avgPageLoadTime'],2).'" class="greenCircle" />
                    	</div>
						<div class="box-small-title">Average Page Load Time</div>
					</div>
					<div class="span2" onTablet="span4" onDesktop="span2">
						<div class="circleStatsItem lightorange">
                        	<i class="fa-icon-bar-chart"></i>
	
							
                        	<input type="text" value="'.round($data['totalsForAllResults']['ga:sessionsPerUser'],2).'" class="lightOrangeCircle" />
                    	</div>
						<div class="box-small-title">Pageviews/Visit</div>
					</div>

                </div>';
			
			$max_visitors = round( $data['totalsForAllResults']['ga:sessions'] * 1.5);
			$max_visits = round( $data['totalsForAllResults']['ga:newUsers'] * 1.5);
			
			$txt_visitors = $this->get_text_size($data['totalsForAllResults']['ga:sessions']);
			$txt_visits = $this->get_text_size($data['totalsForAllResults']['ga:newUsers']);
			
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
									<span class="number">'.$data['totalsForAllResults']['ga:sessions'].'</span>
								</li>
	                            <li>
	                                
	                                New Visitors: 
	                                <span class="number">'.$data['totalsForAllResults']['ga:newUsers'].'</span>
	                            </li>
	                            <li>
	                                Pageviews: 
	                                <span class="number">'.$data['totalsForAllResults']['ga:newUsers'].'</span>
	                            </li>
	                            <li>
	                                Pages / Visit: 
	                                <span class="number">'.round($data['totalsForAllResults']['ga:sessionsPerUser'],2).'</span>
	                            </li>
	                            <li>
	                                Avg. Visit Duration: 
	                                <span class="number">'.round($data['totalsForAllResults']['ga:sessionDuration'],2).' s</span>
	                            </li>
	                            <li>
	                                Bounce Rate: <span class="number">'.round($data['totalsForAllResults']['ga:bounceRate'],2).' %</span>
	                            </li>
	                            <li>
	                                % New Visits: 
	                                <span class="number">'.round($data['totalsForAllResults']['ga:percentNewSessions'],2).' %</span>
	                            </li>
	                            <li>
	                                Average page load time (s): 
	                                <span class="number">'.round($data['totalsForAllResults']['ga:avgPageLoadTime'],2).' s</span>
	                            </li>

	                        </ul>
	
	                    </div><!-- End .sparkStats -->
						</div>
				</div><!--/span-->
				</div>';		
			
			

	}

    //Shorten Price
	function get_text_size($price) {
		
		
   		if($price > '9999999'){
			
		   //$price = number_format($price, 2, ',', ' ');
			$price1 = '90%';
		
		}elseif($price > '999999'){
			
			$price1 = '100%';
		
		}elseif($price > '99999'){	
			
			$price1 = '100%';
		
		}elseif($price > '9999'){
		
		  $price1 = '150%';
		
		}elseif($price > '999'){
			
			 $price1 = '180%';
			
		}else{
			
			 $price1 = '30px';
		}
		return $price1;
	}


	
	public function traffic_graph_og($start, $end){
		


		$ga = $this->set_GA($view_id = $this->session->userdata('GA_profile'));

		if($start == '' || $end == ''){

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime('-1 day')),
				'end-date' => date('Y-m-d'),
			);

		}else{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime($start)),
				'end-date' => date('Y-m-d', strtotime($end)),
			);



		}

		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics' => 'ga:sessions,,ga:hits',
			'dimensions' => 'ga:date, ga:sessionDurationBucket,ga:sessionCount',
		);

		$data = $ga->query($params);
   
   		$x = 30;
		$c = 30;

		$tooltip = "class='tooltip' style='z-index:9999'";
		//LOAD MAIN TRAFFIC GRAPH
		echo '<div class="box span8" onTablet="span12" onDesktop="span8">
						<div class="box-header">
							<h2><i class="icon-signal"></i><span class="break"></span>Site Statistics</h2>
							<div class="box-icon">
								<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<div id="stats-chart"  class="center" style="height:430px" ></div>
						</div>
			</div>
			<script type="text/javascript">
			/* ---------- Chart with points ---------- */
			$(document).ready(function(){
				
			
				var pageviews = [';
					
				foreach($data as $key => $value){
				   if($key != 'summary'){	
						$comma = ',';
								 
						if($c == 0){
							$comma = '';
						 }
							   
						 $final = $value['visits'];
						
						 echo '['.$c.', ' .$final. ']'.$comma;
						 $c = $c - 1;
				   }
				}
				  
		   
				
						
				echo '];
				
				var visitors = [';
				
				foreach($data as $key => $value){
				   if($key != 'summary'){	
						$comma = ',';
								 
						if($x == 0){
							$comma = '';
						 }
							   
						 $final = $value['visitors'];
						
						 echo '['.$x.', ' .$final. ']'.$comma;
						 $x = $x - 1;
				   }
				}
						
				echo '];
				
				var plot = $.plot($("#stats-chart"),
					   [ { data: pageviews, label: "pageviews"}, { data: visitors, label: "visitors" } ], {
						   series: {
							   lines: { show: true,
										lineWidth: 3,
										fill: true, fillColor: { colors: [ { opacity: 0.08 }, { opacity: 0.01 } ] }
									 },
							   points: { show: true },
							   shadowSize: 2
						   },
						   grid: { hoverable: true, 
								   clickable: true, 
								   tickColor: "#eee",
								   borderWidth: 0,
								 },
						   colors: ["#FA5833", "#2FABE9"],
							xaxis: {ticks:11, tickDecimals: 0},
							yaxis: {ticks:11, tickDecimals: 0},
						 });
				
				function showTooltip(x, y, contents) {
					$("<div '.$tooltip.'>" + contents + "</div>").css( {
						position: "absolute",
						display: "none",
						top: y + 5,
						left: x + 5,
						border: "1px solid #fdd",
						padding: "2px",
						"background-color": "#dfeffc",
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}
		
				var previousPoint = null;
				$("#stats-chart").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));
		
						if (item) {
							if (previousPoint != item.dataIndex) {
								previousPoint = item.dataIndex;
		
								$(".tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);
		
								showTooltip(item.pageX, item.pageY,
											item.series.label + " of " + x + " = " + y);
							}
						}
						else {
							$("#tooltip").remove();
							previousPoint = null;
						}
				});
				
		
		
				$("#sincos").bind("plotclick", function (event, pos, item) {
					if (item) {
						$("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
						plot.highlight(item.series, item.datapoint);
					}
				});
			});
			
			</script>
			
			';
				
				
		
	}
	
	public function traffic_graph($start, $end){



		$ga = $this->set_GA($view_id = $this->session->userdata('GA_profile'));

		if($start == '' || $end == ''){

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime('-30 days')),
				'end-date' => date('Y-m-d'),
			);

		}else{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime($start)),
				'end-date' => date('Y-m-d', strtotime($end)),
			);



		}

		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics' => 'ga:sessions, ga:hits',
			'dimensions' => 'ga:date',
		);

		$visits = $ga->query($params);


   		$x = 30;
		$c = 30;
		
		//var_dump($visits);
		if(count($visits['rows']) > 0)
		{
			foreach ($visits['rows'] as $day => $visit)
			{

				if (is_array($visit))
				{
					$count = array();
					//$count[$visit[0]] = 0;
					$temp = $visit[0];
					$x = 0;
					foreach ($visit as $row3 => $val3)
					{

						//skip date vale
						if ($val3 == $visit[0]){

							$x++;

							//get sessions
						}elseif($row3 == 1){

								$flot_datas_visits[] = '[ gd(' . date('Y', strtotime($visit[0])) . ',' . date('n', strtotime($visit[0])) . ',' . date('j', strtotime($visit[0])) . '),' . $val3 . ']';

						}else{
								//echo 'Row 3: ' . $row3 . ' = ' . $val3 . '<br />';
								$flot_datas_views[] = '[ gd(' . date('Y', strtotime($visit[0])) . ',' . date('n', strtotime($visit[0])) . ',' . date('j', strtotime($visit[0])) . '),' . $val3 . ']';
								$x = 0;
						}

						$temp = $visit[0];


					}

					//$flot_datas_views[] = '['.$day.','.$views[$day].']';
				}
			}
			$flot_data_visits = '['.implode(',',$flot_datas_visits).']';
			$flot_data_views = '['.implode(',',$flot_datas_views).']';
		}
		$tooltip = "id='tooltip' class='tooltip' style='z-index:9999'";
		//LOAD MAIN TRAFFIC GRAPH
		echo '<div class="box span8" onTablet="span12" onDesktop="span8">
						<div class="box-header">
							<h2><i class="icon-signal"></i><span class="break"></span>Site Statistics</h2>
							<div class="box-icon">
								<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<div id="stats-chart"  class="center" style="height:430px" ></div>
						</div>
			</div>
			<script type="text/javascript">
			/* ---------- Chart with points ---------- */
			$(document).ready(function(){
				
				
				var plot = $.plot($("#stats-chart"),
					   [ { data: '.$flot_data_views.', label: "pageviews"}, { data:  '.$flot_data_visits.', label: "visitors" } ], {
						  
						   series: {
							   lines: { show: true,
										lineWidth: 3,
										fill: true, fillColor: { colors: [ { opacity: 0.08 }, { opacity: 0.01 } ] }
									 },
							   points: { show: true },
							   shadowSize: 2
						   },
						   grid: { hoverable: true, 
								   clickable: true, 
								   tickColor: "#eee",
								   borderWidth: 0,
								 },
						   colors: ["#FA5833", "#2FABE9"],
							xaxis: { mode: "time",minTickSize: [1, "day"]
							},
							yaxis: {ticks:11, tickDecimals: 0},
						 });
								
				function gd(year, month, day) {
					return new Date(year, month - 1, day).getTime();
				}
				
				function showTooltip(x, y, contents) {
					$("<div '.$tooltip.'>" + contents + "</div>").css( {
						position: "absolute",
						display: "none",
						top: y + 5,
						left: x + 5,
						color: "#fff",
						border: "1px solid #000",
						"font-weight":"bold",
						padding: "2px",
						"background-color": "#111111",
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}
		
				var previousPoint = null;
				$("#stats-chart").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));
		
						if (item) {
							if (previousPoint != item.dataIndex) {
								previousPoint = item.dataIndex;
		
								$("#tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);
		
								showTooltip(item.pageX, item.pageY,
											item.series.label + " = " + Math.round(y));
							}
						}
						else {
							$("#tooltip").remove();
							previousPoint = null;
						}
				});
				
		
		
				$("#sincos").bind("plotclick", function (event, pos, item) {
					if (item) {
						$("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
						plot.highlight(item.series, item.datapoint);
					}
				});
			});
			
			</script>
			
			';
				
			
			
	}	
	
	
	public function traffic_graph3_OG($start, $end){
		
		$this->load->library('ga_api');

		// Set new profile id if not the default id within your config document
		$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));
		$data = $this->ga_api->login()
			->dimension('visitCount, pageDepth')
			->metric('visitors, pageviews')
			->limit(30)
			->when('1 month ago', 'yesterday')
			->get_array();
   
   		$x = 0;
		$c = 0;
		
		$data2 = $this->ga_api->login()
			->dimension('date')
			->metric('visitors, visits')
			->when('1 month ago', 'yesterday')
			->get_array();
		
		
		$tooltip = "id='tooltip'";
		//LOAD MAIN TRAFFIC GRAPH
		echo '<div class="box span8" onTablet="span12" onDesktop="span8">
						<div class="box-header">
							<h2><i class="icon-signal"></i><span class="break"></span>Site Statistics</h2>
							<div class="box-icon">
								<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<div id="stats-chart"  class="center" style="height:300px" ></div>
						</div>
			</div>
			<script type="text/javascript">
			/* ---------- Chart with points ---------- */
			$(document).ready(function(){
				
			
				var pageviews = [';
				
				foreach($data as $key => $value){
   		   			
				   if($key != 'summary'){
						foreach($value as $key2 => $value2){
				   			 $comma = ',';
							 
							 if($c == 29){
								 $comma = '';
							 }
							 
							 $final = $value2['pageviews'];
							 if($value2['pageviews'] > 100){
								 $final = $value2['pageviews'] = '99';
							 }
							 echo '['.$c.', ' .$final. ']'.$comma;
							$c ++;
						}
				   }
		   
				}
						
				echo '];
				
				var visitors = [';
				
				foreach($data2 as $keyv => $valuev){
				   if($keyv != 'summary'){	
						$comma = ',';
								 
						if($c == 29){
							$comma = '';
						 }
							   
						 $finalv = $valuev['visitors'];
						
						 echo '['.$c.', ' .$finalv. ']'.$comma;
						 $c ++;
				   }
				}
						
				echo '];
				
				var plot = $.plot($("#stats-chart"),
					   [ { data: pageviews, label: "pageviews"}, { data: visitors, label: "visitors" } ], {
						   series: {
							   lines: { show: true,
										lineWidth: 3,
										fill: true, fillColor: { colors: [ { opacity: 0.08 }, { opacity: 0.01 } ] }
									 },
							   points: { show: true },
							   shadowSize: 2
						   },
						   grid: { hoverable: true, 
								   clickable: true, 
								   tickColor: "#eee",
								   borderWidth: 0,
								 },
						   colors: ["#FA5833", "#2FABE9"],
							xaxis: {ticks:11, tickDecimals: 0},
							yaxis: {ticks:11, tickDecimals: 0},
						 });
				
				function showTooltip(x, y, contents) {
					$("<div '.$tooltip.'>" + contents + "</div>").css( {
						position: "absolute",
						display: "none",
						top: y + 5,
						left: x + 5,
						border: "1px solid #fdd",
						padding: "2px",
						"background-color": "#dfeffc",
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}
		
				var previousPoint = null;
				$("#stats-chart").bind("plothover", function (event, pos, item) {
					$("#x").text(pos.x.toFixed(2));
					$("#y").text(pos.y.toFixed(2));
		
						if (item) {
							if (previousPoint != item.dataIndex) {
								previousPoint = item.dataIndex;
		
								$("#tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);
		
								showTooltip(item.pageX, item.pageY,
											item.series.label + " of " + x + " = " + y);
							}
						}
						else {
							$("#tooltip").remove();
							previousPoint = null;
						}
				});
				
		
		
				$("#sincos").bind("plotclick", function (event, pos, item) {
					if (item) {
						$("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
						plot.highlight(item.series, item.datapoint);
					}
				});
			});
			
			</script>
			
			';
				
				
		
	}
	//30 Organic Searches per day
	public function organic_searches($start, $end)
	{

		$this->load->library('ga_api');

		// Set new profile id if not the default id within your config document
		$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));

		if($start == '' || $end == '')
		{
			$data = $this->ga_api->login()
				->dimension('keyword')
				->metric('organicSearches')
				->limit(50)
				->get_object();

		}else{

			$data = $this->ga_api->login()
				->dimension('keyword')
				->metric('organicSearches')
				->when($start, $end)
				->limit(150)
				->get_object();


		}




   
		$array =  (array) $data;
		$x = 0;
		foreach($array as $row){
			
			if(isset($row->organicSearches)){
				echo $x .' ' . $row->organicSearches .'<br />';
			}

			$x ++;
		}
		echo 'Total Organic Searches: '.$array['summary']->metrics->organicSearches;

	}
	
	
	//day Organic Keywords
	public function organic_keywords($start, $end)
	{


		$ga = $this->set_GA($view_id = $this->session->userdata('GA_profile'), true);

		if($start == '' || $end == ''){

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime('-30 days')),
				'end-date' => date('Y-m-d'),
			);

		}else{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime($start)),
				'end-date' => date('Y-m-d', strtotime($end)),
			);



		}

		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics' => 'ga:organicSearches',
			'dimensions' => 'ga:date,ga:keyword',
		);

		$data = $ga->query($params);

			     
  		$datatable = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
   		echo '<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Organic Keyword Traffic</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					     <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed" id="kw_table" width="100%">
						 <thead>
						 	<tr>
								<td style="width:80%"></td>
								<td style="width:10%"></td>
								<td style="width:20px"></td>
							</tr>	
						 
						 </thead>
						 <tbody>
						 ';
						foreach($data['rows'] as $row => $val){

							if(is_array($val)){

                                if($val[1] == '(not set)' || $val[1] == '(not provided)'){



                                }else{

                                    //var_dump($val);
                                    echo '<tr> ';
                                    foreach($val as $row5 => $val5)
                                    {


                                        //echo $row.' '.$val;
                                        //0 is date
                                        if($row5 == 0){



                                            //1 is term
                                        }elseif($row5 == 1){

                                            $link = 'https://www.google.com/search?q=' . str_replace(' ', '+', $val5) . '&pws=0';
                                            echo '<td style="width:10%;text-align:right">
                                            <a href="'.$link.'" target="_blank"><i class="fa-icon-search blue"></i></a>
                                         </td>';

                                            echo '<td style="width:80%">
                                            <span>'.$val5.'</span>
                                        </td>';


                                            //2 is quantity
                                        }else{

                                            echo '<td style="width:10%">
                                        <span class="blue">'.$val5.'</span>
                                    </td>';

                                        }



                                    }


                                }

								echo '</tr>';
							}



						}

			
			
			echo '</tbody>
				</table>
			   </div>
			</div><!--/span-->
			<script type="text/javascript">
				 $(document).ready(function(){
				  
					  $("#kw_table").dataTable( {
							"sDom": "'.$datatable.'",
							"sPaginationType": "bootstrap",
							"oLanguage": {
								"sLengthMenu": "_MENU_ "
							},
							"aaSorting":[],
							"bSortClasses": false
				
						} );
						
					$(".dataTables_paginate").parent().removeClass("span6").addClass("span12");
					$("#kw_table_length").find("select").addClass("span6");
					$("#kw_table_length").parent().removeClass("span6").addClass("span4");
					$("#kw_table_filter").parent().removeClass("span6").addClass("span8");
						
				});
			</script>
			
			';

	}



	public function location_map($start, $end)
	{


		$ga = $this->set_GA($view_id = $this->session->userdata('GA_profile'));

		if ($start == '' || $end == '')
		{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime('-30 days')),
				'end-date'   => date('Y-m-d'),
				'sort'  => '-ga:hits'
			);

		}
		else
		{

			// Set the default params. For example the start/end dates and max-results
			$defaults = array(
				'start-date' => date('Y-m-d', strtotime($start)),
				'end-date'   => date('Y-m-d', strtotime($end)),
				'sort'  => '-ga:hits'
			);


		}

		$ga->setDefaultQueryParams($defaults);


		$params = array(
			'metrics'    => 'ga:sessions,ga:hits',
			'dimensions' => 'ga:country,ga:countryIsoCode',
		);

		$data = $ga->query($params);


		//var_dump($data);
		$d = '';$x = 0;
		foreach($data['rows'] as $row){

			if(count($data['rows']) == $x){

				$d .= "'".$row[1] ."'".' : '.$row[2].'';

			}else{

				$d .= "'".$row[1] ."'".' : '.$row[2].',';

			}

			$x ++;
		}


		$t = '';

		$t .='<table id="loc_table" class="datatable table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Country</th>
						<th>Sessions</th>
						<th class="text-align-center">Hits</th>
						<th class="text-align-center hidden-xs">Online</th>
						<th class="text-align-center">Demographic</th>
					</tr>
			</thead>
			<tbody>';


		foreach($data['rows'] as $row){


			$t .= '<tr>
					<td>'.$row[0].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[3].'</td>
					<td></td>
					<td></td>
				  </tr>
				  ';

			$x ++;
		}
		$t .= '</tbody>
		</table>';



		echo '<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Geographic Traffic </h2>
					</div>
					<div class="box-content">
						<div class="vector-map" id="vector-map"></div>
						<div id="heat-fill">
							<span class="fill-a">0</span>

							<span class="fill-b">5,000</span>
						</div>
					</div>
				</div><!--/span-->

				<div class="box span4" onTablet="span8" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Traffic by Country</h2>
					</div>
					<div class="box-content" id="stat_overview_map">
						'.$t.'
					</div>
				</div><!--/span-->';


		$datatable = '<"row-fluid"<"span6"l><"span6"f>r>t<"row-fluid"<"span6"i><"span6"p>>';
		echo "<script>

				/*
				 * VECTOR MAP
				 */
				window.setTimeout(function(){
					data_array = {
						". $d ."
					};

					$('#vector-map').vectorMap({
						map : 'world_mill_en',
						backgroundColor : '#fff',
						regionStyle : {
						initial : {
							fill : '#c4c4c4'
										},
						hover : {
							'fill-opacity' : 1
										}
					},
									series : {
						regions : [{
							values : data_array,
											scale : ['#85a8b6', '#4d7686'],
											normalizeFunction : 'polynomial'
										}]
									},
									onRegionLabelShow : function(e, el, code) {
						if ( typeof data_array[code] == 'undefined') {
							e.preventDefault();
						} else {
							var countrylbl = data_array[code];
											el.html(el.html() + ': ' + countrylbl + ' visits');
										}
							}
					});


					$('#loc_table').dataTable( {
										'sDom': '" . $datatable . "',
										'sPaginationType': 'bootstrap',
										'oLanguage': {
										'sLengthMenu': '_MENU_ '
										},
										'aaSorting':[],
										'bSortClasses': false

									} );

					$('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
					$('#loc_table_length').find('select').addClass('span6');
					$('#loc_table_length').parent().removeClass('span6').addClass('span4');
					$('#loc_table_filter').parent().removeClass('span6').addClass('span8');
				}, 1000);
			</script>";

	}


	function sortByOrder($a, $b) {
		return $a['3'] - $b['3'];
	}


	//INITIATE CONNECTION ACCESS TOKENS
	function set_GA($view_id, $inc = false){

		//$this->ci =& get_instance();
		$this->load->config('ga_api');

		$client_id = $this->config->item('client_id');

		// From the APIs console
		$client_email =  $this->config->item('client_email');

		$key =  $this->config->item('key_file');

		$key_pass = $this->config->item('notasecret');


		// Analytics account id like, 'ga:xxxxxxx'
		$account_id = 'ga:'.$view_id;

		if(!$inc){
			include(BASE_URL.'application/libraries/GoogleAnalyticsAPI.class.php');
		}


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
			//var_dump($auth);
		} else {
			// error...
			$ga = false;;
		}


		// Set the accessToken and Account-Id
		$ga->setAccessToken($accessToken);
		$ga->setAccountId($account_id);

		return $ga;

	}



}
?>