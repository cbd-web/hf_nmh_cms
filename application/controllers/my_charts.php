<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_charts extends CI_Controller {
	/**
	 OWNERS
	 */
	function my_charts()
	{
		parent::__construct();
		$this->load->model('image_model');;
		//force_ssl();
	}

	public function index()
	{
		echo 'Going Nowhere slowly!';
		
	}
	
	
    //Display sparkline overview
	function analytics_spark_overview()
	{
		function sparkline_charts() {
		
		//generate random number for charts
		randNum = function(){
			//return Math.floor(Math.random()*101);
			return (Math.floor( Math.random()* (1+40-20) ) ) + 20;
		}
	
		var chartColours = ['#2FABE9', '#FA5833', '#b9e672', '#bbdce3', '#9a3b1b', '#5a8022', '#2c7282'];
	
		//sparklines (making loop with random data for all 7 sparkline)
		i=1;
		for (i=1; i<9; i++) {
			var data = [[1, 1], [2, 10], [3, 8+randNum()], [4, 11+randNum()],[5, 14+randNum()],[6, 17+randNum()],[7, 20+randNum()], [8, 15+randNum()], [9, 18+randNum()], [10, 22+randNum()]];
			placeholder = '.sparkLineStats' + i;
			$(placeholder).sparkline(data, { 
				width: 100,//Width of the chart - Defaults to 'auto' - May be any valid css width - 1.5em, 20px, etc (using a number without a unit specifier won't do what you want) - This option does nothing for bar and tristate chars (see barWidth)
				height: 30,//Height of the chart - Defaults to 'auto' (line height of the containing tag)
				lineColor: '#2FABE9',//Used by line and discrete charts to specify the colour of the line drawn as a CSS values string
				fillColor: '#f2f7f9',//Specify the colour used to fill the area under the graph as a CSS value. Set to false to disable fill
				spotColor: '#467e8c',//The CSS colour of the final value marker. Set to false or an empty string to hide it
				maxSpotColor: '#b9e672',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
				minSpotColor: '#FA5833',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
				spotRadius: 2,//Radius of all spot markers, In pixels (default: 1.5) - Integer
				lineWidth: 1//In pixels (default: 1) - Integer
			});
		}
		
	}
		
	}
		
		


}
	
	
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */