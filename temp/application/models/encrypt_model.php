<?php
class Encrypt_model extends CI_Model{
	
 	function encrypt_model(){
  		//parent::CI_model();
			
 	}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
	
	function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . 'something random' . strtolower($username));
		
		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
		
	}
	

	/*Validate password*/
	
	function validate_password($username, $password){
		
		$sql = $this->db->query("SELECT *
			  					FROM `admin`
								WHERE
				  			   `email` = '".$username."' LIMIT 1",TRUE);
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['admin_id'] = $r['admin_id'];
			$res['last_login'] = $r['last_login'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['pass'], 0, 64);
			
			$hash = $salt . $password;
			
			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}
			
			$hash = $salt . $hash;
			
			if ( $hash == $r['pass'] ) {
			   $res['bool'] = TRUE;
			   return TRUE;
			   //break;
			}
		}//no username match
		return FALSE;
		//return $res;
	}
	
}
?>