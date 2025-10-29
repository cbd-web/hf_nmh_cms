<?php  class CI_Input extends CI_Input
{
	function __construct()
    {
        parent::__construct();
    }
	
	function _clean_input_keys($str)
	{
		if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $str))
		{
			exit('Disallowed Key Characters.');
		}
	
		return $str;
	}
   
}
?>