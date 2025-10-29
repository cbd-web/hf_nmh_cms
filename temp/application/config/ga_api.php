<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//314831996097-o9831h2aa9ilvlkanvm28noajl15urh1@developer.gserviceaccount.com
$host = getEnv('APP_HOST') ?: 'localhost/cms.my.na/';
$config['client_id']	= '314831996097-o9831h2aa9ilvlkanvm28noajl15urh1.apps.googleusercontent.com'; // GA client id
$config['client_email']	= '314831996097-o9831h2aa9ilvlkanvm28noajl15urh1@developer.gserviceaccount.com'; // client email
$config['key_file']	    = $_SERVER["DOCUMENT_ROOT"].'/My_Namibia-2c04abefbbe1.p12'; // client email
$config['key_pass']	    = 'notasecret'; // client email
$config['profile_id']	= ''; // GA profile id
$config['email']		= ''; // GA Account mail
$config['password']		= ''; // GA Account password

$config['cache_data']	= false; // request will be cached
$config['cache_folder']	= '/cache'; // read/write
$config['clear_cache']	= array('date', '1 day ago'); // keep files 1 day

$config['debug']		= true; // print request url if true
