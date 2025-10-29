<?php
class Cron_model extends CI_Model{
	
 	function cron_model(){
  		//parent::CI_model();
			
 	}




	//+++++++++++++++++++++++++++
	//OPTIMIZE DATABASE
	//++++++++++++++++++++++++++
	public function optimize_db()
	{
		$this->load->dbutil();
		$result = $this->dbutil->optimize_database();

		if ($result !== FALSE)
		{
			print_r($result);
		}
		 
	}

	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db()
	{
		$this->load->dbutil();
		$name = 'cms_db_'.date('Y-m-d');
		$prefs = array(
                'tables'      => array(),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs); 
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.$name.'.gz', $backup); 
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($name.'.gz', $backup);
		
		//UPLOAD S3
		$this->send_s3(BASE_URL.$name.'.gz');
		 
	}



	//+++++++++++++++++++++++++++
	//SEND TO S3
	//++++++++++++++++++++++++++
	public function send_s3($path)
	{
		//use Aws\S3\S3Client;
		require BASE_URL.'aws/aws-autoloader.php';

		$bucket = 'my.na';
		$keyname = 'AKIAINV57JJJV4JESUNA';
		// $filepath should be absolute path to a file on disk						
		$filepath = $path;
								
		// Instantiate the client.
		$s3 = S3Client::factory();
		
		// Upload a file.
		$result = $s3->putObject(array(
			'Bucket'       => $bucket,
			'Key'          => $keyname,
			'SourceFile'   => $filepath,
			'ContentType'  => 'text/plain',
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY',
			'Metadata'     => array(    
				'param1' => 'value 1',
				'param2' => 'value 2'
			)
		));
		
		echo $result['ObjectURL'];
		 
	}



	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_system()
	{

		/*
		 * This script only works on linux.
		 * It keeps only 31 backups of past 31 days, and backups of each 1st day of past months.
		 */

		define('DB_HOST', 'localhost');
		define('DB_NAME', 'cmsmy_db');
		define('DB_USER', 'cmsmy_user');
		define('DB_PASSWORD', '6kT{#rpx@}R.');

		$date = date('Y-m-d');

		$backupFile = BASE_URL . 'backup/' . DB_NAME . '_' . $date . '.sql.gz';
		if (file_exists($backupFile)) {
			unlink($backupFile);
		}
		$command = 'mysqldump --opt -h ' . DB_HOST . ' -u ' . DB_USER . ' -p\'' . DB_PASSWORD . '\' ' . DB_NAME . ' | gzip > ' . $backupFile;
		system($command);

	}



    //+++++++++++++++++++++++++++
    //EMAIL STATS PER TAG
    //++++++++++++++++++++++++++
    public function get_email_tags_stats($id = '')
    {


        $q = $this->db->get('emails');

        $str = 'Email logs for: ';

        $emails = array();
        $emailsA = array();
        $x = 0;
        if($q->result()){

            //loop each
            foreach($q->result() as $erow){

                $t = 'email_id_'.$erow->email_id;

                $emailsA[$t]['email_id'] = $t;
                $emailsA[$t]['opens'] = $erow->opens;
                $emailsA[$t]['unique_opens'] = $erow->unique_opens;
                $emailsA[$t]['clicks'] = $erow->clicks;
                $emailsA[$t]['unique_clicks'] = $erow->unique_clicks;
                $emailsA[$t]['sends'] = $erow->sends;
                $emailsA[$t]['soft_bounces'] = $erow->soft_bounces;
                $emailsA[$t]['hard_bounces'] = $erow->hard_bounces;
                $emailsA[$t]['unsubscribes'] = $erow->unsubscribes;
                $emailsA[$t]['complaints'] = $erow->complaints;
                $emailsA[$t]['reputation'] = $erow->reputation;
                $emailsA[$t]['rejects'] = $erow->rejects;
                array_push($emails, $t);
                //array_push($emailsA, $erow);
                $x ++;
            }


        }

        //var_dump($emails);

        $this->load->model('email_model');
        $x2 = 0;
        $result = $this->email_model->get_email_stats($query = '' , $date_from = '', $date_to = '', $tags = array(), $senders = array(), $limit = 1000);

        if(count($result) > 0){

            foreach($result as $row){

                if(in_array($row['tag'], $emails)){

                    $val = false;
                    //COMPARE EXISTING
                    if($emailsA[$row['tag']]['sends'] < $row['sent']){

                        $insert['sends'] = $row['sent'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['opens'] < $row['opens']){

                        $insert['opens'] = $row['opens'];
                        $val = true;

                    }
                    if($emailsA[$row['tag']]['unique_opens'] < $row['unique_opens']){

                        $insert['unique_opens'] = $row['unique_opens'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['unique_clicks'] < $row['unique_clicks']){

                        $insert['unique_clicks'] = $row['unique_clicks'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['clicks'] < $row['clicks']){

                        $insert['clicks'] = $row['clicks'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['complaints'] < $row['complaints']){

                        $insert['complaints'] = $row['complaints'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['unsubscribes'] < $row['unsubs']){

                        $insert['unsubscribes'] = $row['unsubs'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['reputation'] < $row['reputation']){

                        $insert['reputation'] = $row['reputation'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['rejects'] < $row['rejects']){

                        $insert['rejects'] = $row['rejects'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['soft_bounces'] < $row['soft_bounces']){

                        $insert['soft_bounces'] = $row['soft_bounces'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['hard_bounces'] < $row['hard_bounces']){

                        $insert['hard_bounces'] = $row['hard_bounces'];
                        $val = true;
                    }

                    $clean_id = str_replace('email_id_', '' , $row['tag']);

                    if($val){
                        $this->db->where('email_id', $clean_id);
                        $this->db->update('emails', $insert);

                        echo 'Existing Sends: '.$emailsA[$row['tag']]['sends'] . '  -  API Sends: '.$row['sent']. ' ';
                        echo 'Wohoo ' .$row['tag']. ' - <br />';
                    }else{

                        echo 'Not Updated: '.$emailsA[$row['tag']]['sends'] . '  -  API Sends: '.$row['sent']. ' ';


                    }





                }

                //echo $row['tag']. ' - ';
                //var_dump($row);


            }



        }



    }




}
?>