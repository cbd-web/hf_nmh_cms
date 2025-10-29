<?php

class Api_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN CONTROLLER QUERY SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++
	function settings($bus_id)
	{

		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->get('settings');

		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET PAGE BY SLUG
	//++++++++++++++++++++++++++
	function page_by_slug($bus_id, $slug, $language)
	{
		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

			$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
				FROM pages AS A
				LEFT JOIN pages_german AS B ON A.page_id = B.page_id
				LEFT JOIN pages_french AS C ON A.page_id = C.page_id
				LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
				LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
				LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
				WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".slug = '".$slug."' ORDER BY A.page_sequence ASC ", TRUE);


		//error_reporting(E_ALL);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('slug', $slug);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages'.$str);

		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET PAGE BY ID
	//++++++++++++++++++++++++++
	function page_by_id($bus_id, $id, $language)
	{

		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

			$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
				FROM pages AS A
				LEFT JOIN pages_german AS B ON A.page_id = B.page_id
				LEFT JOIN pages_french AS C ON A.page_id = C.page_id
				LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
				LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
				LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
				WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".page_id = '".$id."' ORDER BY A.page_sequence ASC ", TRUE);


		//error_reporting(E_ALL);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('page_id', $id);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages'.$str);

		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET PAGE BY TEMPLATE
	//++++++++++++++++++++++++++
	function page_by_template($bus_id, $template, $language)
	{

		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

			$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
				FROM pages AS A
				LEFT JOIN pages_german AS B ON A.page_id = B.page_id
				LEFT JOIN pages_french AS C ON A.page_id = C.page_id
				LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
				LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
				LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
				WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND A.page_template = '".$template."' ORDER BY A.page_sequence ASC ", TRUE);

		//error_reporting(E_ALL);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('page_template', $template);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages'.$str);

		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET ALL LIVE PAGES - Caching purposes (SME)
	//++++++++++++++++++++++++++
	function page_all($bus_id)
	{

		//error_reporting(E_ALL);
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('status', 'live');
		$q = $this->db->get('pages');

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//MORE PAGE METHODS HERE ......
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SUB_PAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SUB PAGE CONTENT
	//++++++++++++++++++++++++++
	function sub_pages_content($bus_id,$page_id, $language)
	{

		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

			$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
				FROM pages AS A
				LEFT JOIN pages_german AS B ON A.page_id = B.page_id
				LEFT JOIN pages_french AS C ON A.page_id = C.page_id
				LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
				LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
				LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
				WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND A.page_parent = '".$page_id."' ORDER BY A.page_sequence ASC ", TRUE);


		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MENU SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET MENU ITEMS
	//+++++++++++++++++++++++++++
	function menu_items($bus_id, $type, $position)
	{
		//error_reporting(E_ALL);
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('type', $type);
		$q = $this->db->where('position', $position);
		$q = $this->db->get('menus');

		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET CONTENT TITLE
	//+++++++++++++++++++++++++++
	function content_title($bus_id, $language, $type, $id)
	{
		// $str = '';
		// $status = 'live';
		// if($language != ''){

		// 	$str = '_'.$language;
		// 	$status = '';
		// }

		if($type == 'page'){

			if($language != ''){

				if($language == 'german'){
					$language = 'B';
				}else if($language == 'french') {
					$language = 'C';
				}else if($language == 'protuguese') {
					$language = 'D';
				}if($language == 'russian') {
					$language = 'E';
				}if($language == 'spanish') {
					$language = 'C';
				}

			}else {
				$language = 'A';
			}

			$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
				FROM pages AS A
				LEFT JOIN pages_german AS B ON A.page_id = B.page_id
				LEFT JOIN pages_french AS C ON A.page_id = C.page_id
				LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
				LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
				LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
				WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".page_id = ".$id." ORDER BY A.page_sequence ASC ", TRUE);
			// $q = $this->db->where('bus_id', $bus_id);
			// $q = $this->db->where('page_id', $id);
			// $q = $this->db->where('status', $status);
			// $q = $this->db->get('pages'.$str);

		} else {


			$q = $this->db->where('bus_id', $bus_id);
			$q = $this->db->where('post_id', $id);
			$q = $this->db->where('language', $language);
			$q = $this->db->where('status', 'live');
			$q = $this->db->get('posts');

		}


		if($q->result()){

			$row = $q->row_array();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET CONTENT TITLE
	//+++++++++++++++++++++++++++
	function navigation($bus_id, $language)
	{
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->where('page_parent', '0');
		// $q = $this->db->order_by('title', 'ASC');
		// $q = $this->db->get('pages');

		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

		$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title, ".$language.".body, ".$language.".metaD, ".$language.".metaT, ".$language.".heading ,A.page_template, A.url, A.document, A.icon, A.page_features, A.page_parent, A.page_sequence
			FROM pages AS A
			LEFT JOIN pages_german AS B ON A.page_id = B.page_id
			LEFT JOIN pages_french AS C ON A.page_id = C.page_id
			LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
			LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
			LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
			WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND A.page_parent = '0' ORDER BY ".$language.".title ASC ", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//BREADCRUMB SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET PARENT
	//++++++++++++++++++++++++++
	function parent($bus_id, $parent_id, $language)
	{
		// $q = $this->db->select('slug, title');
		// $q = $this->db->where('page_id', $parent_id);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages');

		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

		$q = $this->db->query("SELECT ".$language.".slug, ".$language.".title
			FROM pages AS A
			LEFT JOIN pages_german AS B ON A.page_id = B.page_id
			LEFT JOIN pages_french AS C ON A.page_id = C.page_id
			LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
			LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
			LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
			WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".page_id = ".$parent_id."  ", TRUE);

		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET CATEGORY TREE IDS
	//++++++++++++++++++++++++++
	function CategoryTreeIDs($bus_id, $id, $language)
	{
		// $q = $this->db->select('page_parent');
		// $q = $this->db->where('page_id', $id);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages');


		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

		$q = $this->db->query("SELECT A.page_parent
			FROM pages AS A
			LEFT JOIN pages_german AS B ON A.page_id = B.page_id
			LEFT JOIN pages_french AS C ON A.page_id = C.page_id
			LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
			LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
			LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
			WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".page_id = ".$id."  ORDER BY ".$language.".title ASC ", TRUE);

		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET BREADCRUMBS
	//++++++++++++++++++++++++++
	function breadcrumbs($bus_id, $id, $language)
	{
		// $q = $this->db->select('title, slug, page_id');
		// $q = $this->db->where('page_id', $id);
		// $q = $this->db->where('bus_id', $bus_id);
		// $q = $this->db->where('status', 'live');
		// $q = $this->db->get('pages');
		if($language != ''){

			if($language == 'german'){
				$language = 'B';
			}else if($language == 'french') {
				$language = 'C';
			}else if($language == 'protuguese') {
				$language = 'D';
			}if($language == 'russian') {
				$language = 'E';
			}if($language == 'spanish') {
				$language = 'C';
			}

		}else {
			$language = 'A';
		}

		$q = $this->db->query("SELECT ".$language.".page_id, ".$language.".slug, ".$language.".title
			FROM pages AS A
			LEFT JOIN pages_german AS B ON A.page_id = B.page_id
			LEFT JOIN pages_french AS C ON A.page_id = C.page_id
			LEFT JOIN pages_portuguese AS D ON A.page_id = D.page_id
			LEFT JOIN pages_russian AS E ON A.page_id = E.page_id
			LEFT JOIN pages_spanish AS F ON A.page_id = F.page_id
			WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND ".$language.".page_id = ".$id." ", TRUE);

		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//POSTS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET POST BY SLUG
	//++++++++++++++++++++++++++
	function posts($bus_id, $slug, $limit, $offset, $category, $language)
	{

		//IF SLUG PRESENT
		if($language != ''){
			$qry = ' AND A.language = "'.$language.'"';
		}else {
			$qry = '';
		}

		if ($category != ''){
			$cat = 'AND C.cat_name LIKE "%'.$category.'%"';
		}else {
			$cat = '';
		}
		if($slug !== false){

			$q = $this->db->query("SELECT A.*, C.cat_name as cats
									  FROM posts AS A
									  LEFT JOIN post_cat_int AS B ON B.post_id = A.post_id
									  LEFT JOIN categories AS C ON C.cat_id = B.cat_id
									  WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.slug = '".$slug."' ".$cat." ".$qry." ", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}
		}else{

			$q = $this->db->query("SELECT A.*, C.cat_name as cats
									  FROM posts AS A
									  LEFT JOIN post_cat_int AS B ON B.post_id = A.post_id
									  LEFT JOIN categories AS C ON C.cat_id = B.cat_id
									  WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' ".$cat." ".$qry." GROUP BY A.post_id ORDER BY A.datetime DESC LIMIT ".$limit." OFFSET ".$offset." ", TRUE);


			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}



		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET POST BY ALL - NO LIMIT
	//++++++++++++++++++++++++++
	function all_posts($bus_id, $category, $language)
	{
		if ($category != ''){
			$cat = ' AND C.cat_name = "'.$category.'" ';
		}else {
			$cat = '';
		}

		if ($language != ''){
			$lang = ' AND A.language = "'.$language.'" ';
		}else {
			$lang = '';
		}

		$q = $this->db->query("SELECT COUNT(*) AS `numrows`
							         FROM posts AS A
							         LEFT JOIN post_cat_int AS B ON B.post_id = A.post_id
							         LEFT JOIN categories AS C ON C.cat_id = B.cat_id
							         WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' ".$cat.$lang." ", TRUE);


		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//+++++++++++++++++++++++++++
	//GET POST BY ALL - NO LIMIT
	//++++++++++++++++++++++++++
	function post_cats($bus_id, $category, $slug)
	{
		if ($category != ''){
			//$cat = ' AND  C.cat_name LIKE "%'.$category.'%" ';
			$cat = ' HAVING cats LIKE "%'.$category.'%" ';
		}else {
			$cat = '';
		}

		if($slug != false){
			$str = ' AND A.slug = "'.$slug.'"  ';
		}else {
			$str = '';
		}

		$q = $this->db->query("SELECT COUNT(*) AS `numrows`, C.*,  group_concat(DISTINCT C.cat_name) as all_cats, group_concat(DISTINCT C.cat_name,'_', C.cat_id) as cats
							         FROM posts AS A
							         LEFT JOIN post_cat_int AS B ON B.post_id = A.post_id
							         LEFT JOIN categories AS C ON C.cat_id = B.cat_id
							         WHERE A.status = 'live' AND A.bus_id = '".$bus_id."'  ".$str."  ".$cat."  ", TRUE);


		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//+++++++++++++++++++++++++++
	//GET POST COMMENTS
	//++++++++++++++++++++++++++
	function post_comments($bus_id, $post_id, $type)
	{
		$q = $this->db->query("SELECT A.*, B.img_file, B.title AS img_title, B.body AS img_body, B.url
								FROM comments AS A
								LEFT JOIN images AS B ON B.type_id = A.subscriber_id AND B.type = '".$type."'
								WHERE A.cont_id = '".$post_id."' AND A.status = 'live' AND A.bus_id = '".$bus_id."' ", TRUE);

		if($this->db->trans_status() == TRUE){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No comment found.';

		}

		return $o;
	}
	//+++++++++++++++++++++++++++
	//GET INSERT COMMENTS
	//++++++++++++++++++++++++++
	function insert_post_comments($post_id, $bus_id, $name, $email, $body, $type, $datetime, $status, $subscriber_id)
	{
		date_default_timezone_set('Africa/Windhoek');
		$datetime = date("r");
		//INSERT COMMENT INTO COMMENTS TABLE
		$data = array(
			'name'=> $name,
			'email'=> $email,
			'cont_id'=> $post_id,
			'body'=> $body,
			'type'=> $type,
			'datetime' => date('y-m-d h:i:S',strtotime($datetime)),
			'status' => $status,
			'bus_id'=> $bus_id,
			'subscriber_id' => $subscriber_id
		);

		if($this->db->insert('comments',$data)){

			$o['success'] = true;
			$o['msg'] = 'Successfully inserted comment.';
			$o['com_id'] = $this->db->insert_id();

		}else{

			$o['success'] = false;
			$o['msg'] = 'There was a problem inserting comment.';

		}

		return $o;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//IMAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS
	//+++++++++++++++++++++++++++
	function sliders($bus_id)
	{
		//error_reporting(E_ALL);
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('status', 'live');
		$q = $this->db->order_by('sequence', 'ASC');
		$q = $this->db->get('sliders');

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS ----- NADJA
	//+++++++++++++++++++++++++++
	// function galleries($bus_id, $gal_id, $type, $category)
	// {
	// 	//error_reporting(E_ALL);
	// 	if($category != ''){
	// 		$cat = ' AND C.cat_id = '.$category;
	// 	}else {
	// 		$cat = '';
	// 	}

	// 	if($type == 'images'){

	// 		if($gal_id == "0" || $gal_id == false ) { $qry = "AND A.gal_id != '0' "; } else { $qry = "AND A.gal_id = '".$gal_id."'"; }

	// 		$q = $this->db->query("SELECT *, A.title as img_title
	// 			FROM images as A
	// 			LEFT JOIN galleries as B on A.gal_id = B.gal_id
	// 			LEFT JOIN gallery_cat_int as C on B.gal_id = C.gallery_id
	// 			WHERE A.bus_id = '".$bus_id."' ".$qry."  ".$cat." ORDER BY A.sequence ASC", TRUE);

	// 	}else if($type == 'gallery'){

	// 		$q = $this->db->query("SELECT A.* , B.cat_id
	// 			FROM galleries as A
	// 			LEFT JOIN gallery_cat_int as B on A.gal_id = B.gallery_id
	// 			LEFT JOIN gallery_categories as C on B.cat_id = C.cat_id
	// 			WHERE A.bus_id = '".$bus_id."'  ".$cat." ORDER BY A.gal_id DESC", TRUE);

	// 	}

	// 	if($q->result()){

	// 		$row = $q->result();
	// 		$o['success'] = true;
	// 		$o['msg'] =  '';
	// 		$o['data'] = $row;

	// 	}else{

	// 		$o['success'] = false;
	// 		$o['msg'] = 'No record found';

	// 	}

	// 	return $o;

	// }
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS ---- JEROLD
	//+++++++++++++++++++++++++++
	function galleries($bus_id, $gal_id, $type, $category, $page_id)
	{
		//error_reporting(E_ALL);
		if($category != ''){
			$cat = ' AND C.cat_id = '.$category;
		}else {
			$cat = '';
		}

		if($page_id != ''){
			$pid = ' AND D.page_id = '.$page_id;
			$sidebars = ' LEFT JOIN sidebars as D on A.gal_id = D.type_id';

		}else {
			$pid = '';
			$sidebars = '';
		}

		if($type == 'images'){

			if($gal_id == "0" || $gal_id == false ) { $qry = "AND A.gal_id != '0' "; } else { $qry = "AND A.gal_id = '".$gal_id."'"; }

			$q = $this->db->query("SELECT *, A.title as img_title
				FROM images as A
				LEFT JOIN galleries as B on A.gal_id = B.gal_id
				LEFT JOIN gallery_cat_int as C on B.gal_id = C.gallery_id
				WHERE A.bus_id = '".$bus_id."' ".$qry."  ".$cat." ORDER BY A.sequence ASC", TRUE);

		}else if($type == 'gallery'){

			$q = $this->db->query("SELECT A.* , B.cat_id
				FROM galleries as A
				LEFT JOIN gallery_cat_int as B on A.gal_id = B.gallery_id
				LEFT JOIN gallery_categories as C on B.cat_id = C.cat_id
				".$sidebars."
				WHERE A.bus_id = '".$bus_id."' ".$pid."  ".$cat." ORDER BY A.gal_id DESC", TRUE);

		}

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] =  '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE
	//+++++++++++++++++++++++++++
	function featured_image($bus_id, $id, $type)
	{
		//error_reporting(E_ALL);
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('type', $type);
		$q = $this->db->where('type_id', $id);
		$q = $this->db->get('images');

		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}

/*	//++++++++++++++++++++++++++++++++++
	//GET FEATURED GALLERY -- NADJA
	//++++++++++++++++++++++++++++++++++
	function featured_gallery($bus_id, $id, $type)
	{
		//error_reporting(E_ALL);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where($type, $id);
		$query = $this->db->where('type', 'gallery');
		$query = $this->db->select('type_id');
		$query = $this->db->group_by($type);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('sidebars');
		$row1 = $query->row();

		if($query->result()){

			//GET BRAND IMAGE
			$img = $this->db->where('gal_id', $row1->type_id);
			$img = $this->db->get('galleries');

			if($img->result()){

				$q = $this->db->where('gal_id', $row1->type_id);
				$q = $this->db->order_by('sequence', 'ASC');
				$q = $this->db->get('images');


				if($q->result()){

					$row = $q->result();
					$o['success'] = true;
					$o['msg'] = '';
					$o['data'] = $row;

				}else{

					$o['success'] = false;
					$o['msg'] = 'No record found';

				}
			}else {
				$o['success'] = false;
				$o['msg'] = 'No record found';
			}
		}else {

			$o['success'] = false;
			$o['msg'] = 'No record found';
		}

		return $o;

	}*/

	//++++++++++++++++++++++++++++++++
	//GET FEATURED GALLERY -- JEROLD
	//++++++++++++++++++++++++++++++++
	function featured_gallery($bus_id, $id, $type)
	{
		//error_reporting(E_ALL);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where($type, $id);
		$query = $this->db->where('type', 'gallery');
		$query = $this->db->select('type_id');
		//$query = $this->db->group_by($type);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('sidebars');

		$result = array();

		if($query->result()){

			foreach ($query->result() as $row1) {

				//GET BRAND IMAGE
				$img = $this->db->where_in('gal_id', $row1->type_id);
				$img = $this->db->get('galleries');

				if($img->result()){

					foreach ($img->result() as $row2) {

						$q = $this->db->where('gal_id', $row2->gal_id);
						$q = $this->db->order_by('sequence', 'ASC');
						$q = $this->db->get('images');


						if($q->result()){

							foreach ($q->result() as $test) {

								$val_array = array('img_id' => $test->img_id, 'bus_id' => $test->bus_id, 'img_file' => $test->img_file, 'title' => $test->title, 'body' => $test->body, 'url' => $test->url, 'type' => $test->type, 'type_id' => $test->type_id, 'status' => $test->status, 'gal_id' => $test->gal_id, 'datetime' => $test->datetime, 'sequence' => $test->sequence);

								array_push($result, $val_array);

								$val_array = '';

							}

							$o['success'] = true;
							$o['msg'] = '';
							$o['data'] = $result;

						} else{

							$o['success'] = false;
							$o['msg'] = 'No record found';

						}

					} /*end foreach loop*/


				} else {
					$o['success'] = false;
					$o['msg'] = 'No record found';
				}

			} /*end foreach loop*/

		} else {

			$o['success'] = false;
			$o['msg'] = 'No record found';
		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//VIDEO SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function videos($bus_id, $limit, $groupBy)
	{
		$group = '';
		if($groupBy != ''){
			$group .= ' GROUP BY B.gal_id ';
		}
		if($limit != ''){
			$qry = ' LIMIT '.$limit;
		}else {
			$qry = '';
		}

		$q = $this->db->query("SELECT B.*, A.vid_id AS video_id, A.vid_file AS video_file, A.title AS video_title, A.heading AS video_heading, A.body AS video_body
								   FROM videos AS A
								   LEFT JOIN video_galleries AS B ON  A.gal_id = B.gal_id
								   WHERE A.bus_id = '".$bus_id."'  ".$group." ORDER BY A.datetime DESC
								    ".$qry."  ", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADVERTS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function adverts($bus_id, $category)
	{

		if(isset($category) && is_array($category) || $category != '' && is_array($category)){

			$array= implode("','", $category);
			$cat = " AND B.title IN ('".$array."') ";

		}else {
			$cat = '';
		}

		//var_dump($array);

		$q = $this->db->query("SELECT A.*, D.img_file, B.title AS cat_title, B.cat_id
           FROM adverts AS A
           LEFT JOIN adverts_cat_int as B ON A.advert_id = B.advert_id
           LEFT JOIN advert_categories as C ON B.cat_id = C.cat_id
           LEFT JOIN images AS D on A.advert_id = D.type_id AND D.type = 'advert'
           WHERE A.status = 'live' ".$cat." AND A.bus_id = '".$bus_id."' GROUP BY A.advert_id ORDER BY A.sequence ASC ", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{
			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//FAQ's SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function faqs($bus_id)
	{
		// error_reporting(E_ALL);
		$q = $this->db->query("SELECT A.*, B.*

									FROM faq AS A

									LEFT JOIN faq_topics AS B ON A.topic_id = B.topic_id

									WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' ORDER BY A.sequence", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAPS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET MAP MARKER DESTINATIONS
	//+++++++++++++++++++++++++++
	function map_markers($bus_id, $slug)
	{
		// error_reporting(E_ALL);
		$q = $this->db->query("SELECT A.*, B.slug AS mapSlug, B.title AS mapTitle, B.body AS mapBody

								   FROM map_markers AS A

								   INNER JOIN maps AS B on A.map_id = B.map_id AND B.slug = '".$slug."'

								   WHERE A.bus_id = '".$bus_id."'", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CONTACT US SECTION -
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//INSERT ENQUIRY
	//+++++++++++++++++++++++++++
	function insert_enquiry($bus_id, $name, $email, $msg, $type, $datetime)
	{

		//INSERT INTO MESSAGES TABLE
		date_default_timezone_set('Africa/Windhoek');
		//local time
		$datetime = date("r");

		$insertdata1 = array(
			'name'=> $name ,
			'email'=> $email ,
			'body'=> $msg ,
			'type'=> $type,
			'datetime' => date('Y-m-d H:i:S',strtotime($datetime)),
			'bus_id'=> $bus_id
			);


		if($this->db->insert('enquiries',$insertdata1)){

			//$row = $q->result();
			$o['success'] = true;
			$o['msg'] = 'Successfully sent your enquiry';
			$o['enquiry_id'] = $this->db->insert_id();

		}else{

			$o['success'] = false;
			$o['msg'] = 'Could not insert into database';

		}

		return $o;

	}

	//+++++++++++++++++++++++++++
	//INSERT Newsletter - Subscribers
	//+++++++++++++++++++++++++++
	function insert_newsletter($bus_id, $name, $sname, $email, $type, $type_id, $time, $categories,  $phone, $city, $company, $country, $password, $status, $activation_code, $mem_no,$dob, $job_title, $department, $gender, $region, $address, $contact, $website, $profile_pic, $pass_code, $ip )
	{
		//INSERT INTO MESSAGES TABLE
		date_default_timezone_set('Africa/Windhoek');

		if($type_id != false ){

			$q = $this->db->query("SELECT *, A.subscriber_id AS member_id FROM subscribers AS A LEFT JOIN subscriber_type_int AS B ON A.subscriber_id = B.subscriber_id AND B.type_id = '".$type_id."' WHERE A.bus_id = '".$bus_id."' AND A.email = '".$email."'   ", TRUE);
		}else {
			$q = $this->db->query("SELECT *, a.subscriber_id AS member_id FROM subscribers AS a WHERE a.email = '".$email."' AND a.bus_id = '".$bus_id."'", FALSE);
		}

		if(!$q->result()){

			$insertdata1 = array(
				'name'=> $name ,
				'sname'=> $sname ,
				'email'=> $email ,
				'type'=> $type,
				'datetime' => date('Y-m-d H:i:s',strtotime($time)),
				'bus_id'=> $bus_id,
				'phone' => $phone,
				'city' => $city,
				'company' => $company,
				'country' => $country,
				'password' => $password,
				'status' => $status,
				'activation_code' => $activation_code,
				'mem_no' => $mem_no,
				'dob' => $dob,
				'job_title' => $job_title,
				'department' => $department,
				'gender' => $gender,
				'region' => $region,
				'address ' => $address,
				'contact' => $contact,
				'website' => $website,
				'profile_pic' => $profile_pic,
				'pass_code' => $pass_code,
				'ip' => $ip
				);

			if($this->db->insert('subscribers',$insertdata1)){

				//$row = $q->result();
				$o['success'] = true;
				$o['msg'] = 'Successfully inserted Subscriber';
				$o['enquiry_id'] = $this->db->insert_id();

				if( is_array($categories)){

					$member_id = $o['enquiry_id'];

					foreach ($categories as $cats) {

						$insertdata2 = array(
							'subscriber_id'=> $member_id,
							'type_id'=> $cats,
							'bus_id'=> $bus_id,
							'type_name'=> $type
							);

						$this->db->insert('subscriber_type_int',$insertdata2);
					}

				}else {

					$member_id = $o['enquiry_id'];

					$insertdata2 = array(
						'subscriber_id'=> $member_id,
						'type_id'=> $categories,
						'bus_id'=> $bus_id,
						'type_name'=> $type
						);

					$this->db->insert('subscriber_type_int',$insertdata2);
				}

			}else{

				$o['success'] = false;
				$o['msg'] = 'Could not insert subscriber into database';

			}

		}else {

			$o['success'] = false;
			$o['msg'] = 'Already a subscriber';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS GET
	//+++++++++++++++++++++++++++
	function subscribers($bus_id, $email, $subscriber_id, $mem_no, $activation_code, $type, $type_id, $new_type, $status, $password, $pass_code)
	{
		$qry = "";
		if($email != ''){
			$qry .= " AND a.email = '".$email."' ";
		}
		if($subscriber_id != ''){
			$qry .= " AND a.subscriber_id = '".$subscriber_id."' ";
		}
		if($mem_no != ''){
			$qry .= " AND a.mem_no = '".$mem_no."' ";
		}
		if($activation_code != ''){
			$qry .= " AND a.activation_code = '".$activation_code."' ";
		}
		if($type != ''){
			$qry .= " AND a.type = '".$type."' ";
		}
		if($status != ''){
			$qry .= " AND a.status = '".$status."' ";
		}
		if($password != ''){
			$qry .= " AND a.password = '".$password."' ";
		}
		if($pass_code != ''){
			$qry .= " AND a.pass_code = '".$pass_code."' ";
		}

		if($type_id != false){

			$q = $this->db->query("SELECT *, a.subscriber_id AS member_id FROM subscribers AS a WHERE a.bus_id = '".$bus_id."'  ".$qry." ", TRUE);

			if($q->result()){

				$row = $q->row();
				$mem_id = $row->member_id;

				$p = $this->db->query("SELECT *, a.subscriber_id AS member_id FROM subscribers AS a INNER JOIN subscriber_type_int AS b ON a.subscriber_id = b.subscriber_id AND b.type_id = '".$type_id."' WHERE a.bus_id = '".$bus_id."' AND a.subscriber_id = '".$mem_id."' ", TRUE);

				if($p->result()){

					$o['success'] = false;
					$o['msg'] = 'Already Subscriber';

				}else {

					// if(!isset($row2->type_id)) {

						$insertdata = array(
							'subscriber_id'=> $mem_id,
							'type_id'=> $type_id ,
							'type_name'=> $new_type,
							'bus_id'=> $bus_id
						);

						if($this->db->insert('subscriber_type_int',$insertdata)){

							$o['success'] = true;
							$o['msg'] = 'Successfully updated Subscriber type';

						}else {
							$o['success'] = false;
							$o['msg'] = 'Something must have gone wrong. Please try again later.';
						}

					// }else {
					// 	$o['success'] = false;
					// 	$o['msg'] = 'Something must have gone wrong. Please try again later. Confusion??';
					// }
				}

			}else {

				$o['success'] = false;
				$o['msg'] = 'No record found here';

			}

			// if(!$q->result()){

			// 	$row = $q->row();

			// 	if(!isset($row['type_id'])) {

			// 		$insertdata = array(
			// 			'subscriber_id'=> $row['member_id'],
			// 			'type_id'=> $type_id ,
			// 			'type_name'=> $new_type,
			// 			'bus_id'=> $bus_id
			// 		);

			// 		if($this->db->insert('subscriber_type_int',$insertdata)){

			// 			$o['success'] = true;
			// 			$o['msg'] = 'Successfully updated Subscriber type';

			// 		}else {
			// 			$o['success'] = false;
			// 			$o['msg'] = 'Something must have gone wrong. Please try again later.';
			// 		}

			// 	} else {

			// 		$o['success'] = false;
			// 		$o['msg'] = 'Already Subscriber';

			// 	}

			// }else{

			// 	$o['success'] = false;
			// 	$o['msg'] = 'Already Subscriber';

			// }

		}else {

			$q = $this->db->query("SELECT *, a.subscriber_id AS member_id FROM subscribers AS a WHERE a.bus_id = '".$bus_id."'  ".$qry." ", TRUE);

			if($q->result()){

				$row = $q->row();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found here';

			}
		}

		return $o;
	}
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS UPDATE
	//+++++++++++++++++++++++++++
	function subscribers_update($name, $bus_id, $email, $type, $time, $phone, $city, $company, $country, $password, $sname, $status, $activation_code, $mem_no, $dob, $job_title, $department, $gender, $region, $address, $contact, $website, $profile_pic, $pass_code, $ip)
	{
		//INSERT INTO MESSAGES TABLE
		date_default_timezone_set('Africa/Windhoek');

		$qry = '';

		if($mem_no != false){
			$qry .= " AND mem_no = '".$mem_no."' ";
		}
		if($type != false){
			$qry .= " AND type = '".$type."' ";
		}

		$q = $this->db->query("SELECT *, a.subscriber_id AS member_id FROM subscribers AS a WHERE a.email = '".$email."' AND a.bus_id = '".$bus_id."'  ".$qry." ", TRUE);

		$updatedata = array();

		if ($name != false) {
			$updatedata['name'] = $name;
		}
		if ($sname != false) {
			$updatedata['sname'] = $sname;
		}
		if ($email != false) {
			$updatedata['email'] = $email;
		}
		if ($phone != false) {
			$updatedata['phone'] = $phone;
		}
		if ($city != false) {
			$updatedata['city'] = $city;
		}
		if ($company != false) {
			$updatedata['company'] = $company;
		}
		if ($country != false) {
			$updatedata['country'] = $country;
		}
		if ($password != false) {
			$updatedata['password'] = $password;
			// if(!preg_match('/^[a-f0-9]{32}$/', $password)){
			// 	$pass = md5($password);
			// }else {
			// 	$pass = $password;
			// }
		}
		if ($status != false) {
			$updatedata['status'] = $status;
		}
		if ($activation_code != false) {
			$updatedata['activation_code'] = $activation_code;
		}

		if ($dob != false) {
			$updatedata['dob'] = date('Y-m-d',strtotime($dob));
		}
		if ($job_title != false) {
			$updatedata['job_title'] = $job_title;
		}
		if ($department != false) {
			$updatedata['department'] = $department;
		}
		if ($gender != false) {
			$updatedata['gender'] = $gender;
		}
		if ($region != false) {
			$updatedata['region'] = $region;
		}
		if ($address != false) {
			$updatedata['address'] = $address;
		}
		if ($contact != false) {
			$updatedata['contact'] = $contact;
		}
		if ($website != false) {
			$updatedata['website'] = $website;
		}
		if ($profile_pic != false) {
			$updatedata['profile_pic'] = $profile_pic;
		}
		if ($pass_code != false) {
			$updatedata['pass_code'] = $pass_code;
		}
		if ($ip != false) {
			$updatedata['ip'] = $ip;
		}
		$updatedata['datetime'] = date('Y-m-d h:i:S',strtotime($time));

		if($q->result()){

			if($mem_no != false){
				$this->db->where('mem_no',$mem_no);
			}
			if($type != false){
				$this->db->where('type',$type);
			}
			$this->db->where('email',$email);
			$this->db->where('bus_id',$bus_id);
			$this->db->update('subscribers',$updatedata);

			// echo $this->db->last_query();

			if($this->db->trans_status() == TRUE){

				//$row = $q->result();
				$o['success'] = true;
				$o['msg'] = 'Successfully updated Subscriber';
				//$o['enquiry_id'] = $this->db->insert_id();


			}else{

				$o['success'] = false;
				$o['msg'] = 'Could not update subscriber';

			}

		}else {

			$o['success'] = false;
			$o['msg'] = 'No records found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//Remove/delete image
	//+++++++++++++++++++++++++++
	function remove_image($bus_id, $type, $type_id)
	{
		$this->db->where('bus_id', $bus_id);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$query = $this->db->get('images');

		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path

			if (file_exists($file)) {
				unlink($file);
			}

			$this->db->where('bus_id', $bus_id);
			$this->db->where('type', $type);
			$this->db->where('type_id', $type_id);
			$this->db->delete('images');

			$o['success'] = true;
			$o['msg'] = '';

		} else {

			$o['success'] = false;
			$o['msg'] = 'Oops, something went wrong! Please try again later!';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MEMBERS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET MEMBERS
	//+++++++++++++++++++++++++++
	function members($bus_id, $cat, $people_id)
	{

		//IF SLUG PRESENT
		if($cat !== false){

			$q = $this->db->query("SELECT *, B.img_file AS img
								   FROM people AS A
								   LEFT JOIN images AS B ON A.people_id = B.type_id AND B.type = 'people'
								   LEFT JOIN people_cat_int as C ON A.people_id = C.people_id
								   WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND C.cat_name = '".$cat."' ORDER BY A.sequence ASC", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}else if ($people_id !== false){

			$q = $this->db->query("SELECT *, B.img_file AS img
								   FROM people AS A
								   LEFT JOIN images AS B on A.people_id = B.type_id AND B.type = 'people'
								   WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.people_id = '".$people_id."' ORDER BY A.sequence ASC", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found here';

			}

		}else{


			$q = $this->db->query("SELECT *, B.img_file AS img
								   FROM people AS A
								   LEFT JOIN images AS B on A.people_id = B.type_id AND B.type = 'people'
								   WHERE A.status = 'live' AND A.bus_id = '".$bus_id."'  ORDER BY A.sequence ASC", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found here';

			}



		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	// GET MEMBERS ATTACHED TO PAGES
	//+++++++++++++++++++++++++++
	function page_people($bus_id, $page_id)
	{
		$q = $this->db->query("SELECT A.*, C.img_file, D.cat_name as cats
						   FROM people AS A
						   LEFT JOIN page_people_int AS B ON B.people_id = A.people_id
						   LEFT JOIN images AS C on A.people_id = C.type_id AND C.type = 'people'
						   LEFT JOIN people_cat_int AS D ON A.people_id = D.people_id
						   LEFT JOIN people_categories AS E ON D.cat_name = E.cat_name
						   WHERE A.status = 'live' AND B.page_id = '$page_id' AND A.bus_id = ".$bus_id."", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found here';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//business_classifications
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL business_classifications
	//+++++++++++++++++++++++++++
	function business_classifications($bus_id, $id)
	{
		// error_reporting(E_ALL);
		if($bus_id != false){
			$q = $this->db->where('parent', $id);
			$q = $this->db->where('bus_id',$bus_id);
			$q = $this->db->order_by('title','ASC');
			$q = $this->db->get('business_classifications');
		}else {
			$q = $this->db->where('parent', $id);
			$q = $this->db->order_by('title','ASC');
			$q = $this->db->get('business_classifications');
		}


		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//LOCATION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL LOCATIONS
	//+++++++++++++++++++++++++++
	function locations($locationID_arr)
	{

		if($locationID_arr != '' && is_array($locationID_arr)){

			$q = $this->db->where_in('location_id',$locationID_arr);
			$q = $this->db->order_by('location','ASC');
			$q = $this->db->get('locations');
		}else {

			$q = $this->db->order_by('location','ASC');
			$q = $this->db->get('locations');
		}

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET ALL  SUBURBS
	//+++++++++++++++++++++++++++
	function suburbs($location)
	{
		$q = $this->db->where('location_id',$loc);
		$q = $this->db->order_by('suburb','ASC');
		$q = $this->db->get('suburbs');

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//SIMPLE SEARCH
	//+++++++++++++++++++++++++++
	function simple_search($bus_id, $table, $str, $status, $language)
	{
		//error_reporting(E_ALL);
		if($language == 'english'){
			$key = '';
		}else {

			$key = 'A.';
		}

		$strA = explode(' ',trim($this->db->escape_like_str($str)));
		$sql = ' WHERE ';
		$result = array();

		//$tblA = explode(',',trim($this->db->escape_like_str($table)));

		if(count($strA) > 1){
			$cc = 0;
			foreach($strA as $strrow){

				if($cc >= 5){

					break;
				}


				$sql .= " ( ".$key."title LIKE '%".$strrow."%' OR ".$key."body LIKE '%".$strrow."%' )  AND";
				$cc ++;
			}


		}else{

			$sql .= " ( ".$key."title LIKE '%".$this->db->escape_like_str($str)."%' OR ".$key."body LIKE '%".$this->db->escape_like_str($str)."%' ) AND";

		}

		//LOOP TABLES
		foreach($table as $trow){

			if($language == 'english' || $trow == 'posts'){

				if(strstr($sql, 'A.') !== false){
					$sql = str_replace( "A.", '', $sql);
				}

				$q = $this->db->query("SELECT * FROM ".$trow." ".$sql." status = 'live' AND bus_id = '".$bus_id."' ", TRUE);
			}else {
				$q = $this->db->query("SELECT A.*, B.page_parent, B.status , B.page_features, B.page_sequence, B.icon, B.url, B.document
					FROM ".$trow." AS A
					INNER JOIN pages AS B on A.page_id = B.page_id
					".$sql." B.status = 'live' AND  B.bus_id = '".$bus_id."' ", TRUE);
			}



			if($q->result()){

				array_push($result, $q->result());

			}

		}

		//echo $this->db->last_query();

		if(count($result) > 0){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $result;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found here';

		}


		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Properties
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple properties
	//+++++++++++++++++++++++++++
	function properties($bus_id, $p_id, $slug, $limit, $offset, $is_featured, $location="", $status_type="", $property_type="", $building_type="", $price_from="", $price_to="", $string="")
	{
		if ($is_featured != false) {
			$feat = " AND featured = 'Y' " ;
		}else {
			$feat =  " ";
		}
		//IF SLUG PRESENT
		if($slug !== false){

			$q = $this->db->query("SELECT A.*,A.body AS property_body, A.title AS property_title, A.property_id AS pid, B.*, C.people_id AS agent_id, C.name AS agent_name, C.lname AS agent_surname, C.specialization AS agent_bio, group_concat(C.email) AS agent_email, C.cell AS agent_cell, D.img_file as agent_img, I.img_file as prop_img, E.type_id AS side_gal_id, GROUP_CONCAT(F.feature) as features, GROUP_CONCAT(F.body) as feature_text
									 FROM properties AS A
									LEFT JOIN property_agent_int AS B ON A.property_id = B.property_id
									LEFT JOIN people AS C ON B.people_id = C.people_id
									LEFT JOIN images AS I on A.property_id = I.type_id AND I.type = 'property'
									LEFT JOIN images AS D on C.people_id = D.type_id AND D.type = 'people'
									LEFT JOIN sidebars AS E on A.property_id = E.property_id
									LEFT JOIN property_feature_int AS F on A.property_id = F.property_id
									WHERE A.status = 'live' AND A.slug = '".$slug."' AND A.bus_id = ".$bus_id." ".$feat."
									GROUP BY A.property_id  ", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}
		}else {

			$qry = '';
			$qry2 = '';

			if ($location != '') {
				if ($location != 'all') {
					$qry .= " AND A.location = '$location'";
				}

			}
			if ($status_type != '') {
				if ($status_type != 'any') {
					$qry .= " AND A.type = '$status_type'";
				}
			}
			if ($property_type != '') {
				if ($property_type != 'any') {
					$qry .= " AND A.sub_type = '$property_type'";
				}
			}
			if ($building_type != '') {
				if ($building_type != 'any') {
					$qry .= " AND A.sub_sub_type = '$building_type'";
				}
			}
			if ($price_from != '') {
				if ($price_from != 'none') {
					$qry .= " AND A.price >= '$price_from'";
				}

				if ($price_to != '') {
					if ($price_from != 'none') {
						$qry .= " AND A.price <= '$price_to'";
					}
				}
			}
			if ($string != '') {

				$features = explode('_-_', $string);

				$i = 1;

				foreach ($features as $row) {

					$features_new = str_replace('feat-', ' ', $row);

					$features_clean = trim(str_replace('-', ' ', $features_new));


						$qry2 .= " AND C.feature = '$features_clean'";

				}

			}


			$q = $this->db->query("SELECT A.*, B.img_file AS img, C.feature

								   FROM properties AS A

								   LEFT JOIN images AS B on A.property_id = B.type_id AND B.type = 'property'

								   LEFT JOIN property_feature_int AS C on A.property_id = C.property_id ".$qry2."

								   WHERE A.status = 'live' ".$qry." AND A.bus_id = ".$bus_id." ".$feat." GROUP BY A.property_id ORDER BY A.listing_date DESC LIMIT ".$limit." OFFSET ".$offset." ", TRUE);



			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}


		return $o;


	}
	//+++++++++++++++++++++++++++
	//Get property features
	//+++++++++++++++++++++++++++
	function property_feature($bus_id, $p_id)
	{
		$q = $this->db->query("SELECT property_id, feature, body

								   FROM property_feature_int

								   WHERE property_id = ".$p_id." AND bus_id = ".$bus_id." ORDER BY sequence ASC ", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNLOADS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//PAGE DOWNLOADS
	//+++++++++++++++++++++++++++
	function page_downloads($bus_id, $page_id, $limit, $offset, $order)
	{
		if($limit != ''){
			$qry_str = ' LIMIT '.$limit.' OFFSET '.$offset;
		}else {
			$qry_str = '';
		}

		if($order == 'date' ){
			$od = 'A.date_added DESC';
		}else {
			$od = 'A.'.$order;
		}


		$q = $this->db->query("SELECT A.*
								   FROM documents AS A
								   LEFT JOIN content AS B ON B.doc_id = A.doc_id AND B.type_id = ".$page_id." AND B.type = 'page'
								   LEFT JOIN pages AS C ON C.page_id = B.type_id
								   WHERE C.status = 'live' AND A.bus_id = '".$bus_id."' ORDER BY ".$od."  ".$qry_str." " , TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}

	//+++++++++++++++++++++++++++
	//PAGE DOWNLOADS SEARCH
	//+++++++++++++++++++++++++++
	function page_downloads_search($bus_id, $page_id, $limit, $offset, $order, $str)
	{
		if($limit != ''){
			$qry_str = ' LIMIT '.$limit.' OFFSET '.$offset;
		}else {
			$qry_str = '';
		}

		if($order == 'date' ){
			$od = 'A.date_added DESC';
		}else {
			$od = 'A.'.$order;
		}


		$q = $this->db->query("SELECT A.*
								   FROM documents AS A
								   LEFT JOIN content AS B ON B.doc_id = A.doc_id AND B.type_id = ".$page_id." AND B.type = 'page'
								   LEFT JOIN pages AS C ON C.page_id = B.type_id
								   WHERE C.status = 'live' AND A.bus_id = '".$bus_id."' 
								   AND A.title LIKE '%".$str."%' OR A.description LIKE '%".$str."%'
								   ORDER BY ".$od."  ".$qry_str." " , TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EVENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL EVENTS/CAT EVENTS / SINGLE EVENT
	//+++++++++++++++++++++++++++
	function event($bus_id, $slug, $cat_id, $limit, $week, $check_date, $type)
	{
		$str = '';
		//$limit = '';

		if($cat_id != ''){
			$str .= ' AND B.cat_id = '.$cat_id.' ';
		}
		if($week == 'Y'){
			$str .= ' AND YEARWEEK(A.startdate) = YEARWEEK(NOW()) ';
		}
		if($check_date == 'Y'){
            $str .= ' AND A.startdate >= DATE(NOW()) ';
		}
        if($type != ''){
            $str .= ' AND A.type = "'.$type.'" ';
		}
		if($limit != ''){
			$limit = ' LIMIT '.$limit;
		}else {
			$limit = '';
		}


		if($slug != FALSE){
			$q = $this->db->query("SELECT DISTINCT A.event_id, A.title, A.heading, A.description,A.slug, A.type, A.startdate, DATE_FORMAT(A.startdate, '%Y-%m-%d %H:%i' ) AS startDate,A.url, A.enddate, A.allday as allDay , C.title AS category_title, C.body AS category_body, C.slug AS category_slug, C.sequence AS category_sequence, A.location, A.web_link, A.venue, A.contact, A.duration, D.img_file
					FROM calendar_events as A
					LEFT JOIN events_cat_int as B ON A.event_id = B.event_id
					LEFT JOIN event_categories as C ON B.cat_id = C.cat_id
					LEFT JOIN images as D ON A.event_id = D.type_id AND D.type = 'event'
					WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' ".$str." AND A.slug = '".$slug."' GROUP BY A.event_id ORDER BY A.startdate ASC ".$limit." ", TRUE);

				if($q->result()){

					$row = $q->row_array();
					$o['success'] = true;
					$o['msg'] = '';
					$o['data'] = $row;
				}else{

					$o['success'] = false;
					$o['msg'] = 'No record found';

				}
		}else {
			$q = $this->db->query("SELECT DISTINCT A.event_id, A.title, A.heading, A.description, A.slug, A.type, A.startdate, DATE_FORMAT(A.startdate, '%Y-%m-%d %H:%i' ) AS startDate,A.url, A.enddate, A.allday as allDay, A.duration, C.title AS category_title, C.body AS category_body, C.slug AS category_slug, C.sequence AS category_sequence, A.location, A.web_link, D.img_file
					FROM calendar_events as A
					LEFT JOIN events_cat_int as B ON A.event_id = B.event_id
					LEFT JOIN event_categories as C ON B.cat_id = C.cat_id
					LEFT JOIN images as D ON A.event_id = D.type_id AND D.type = 'event'
					WHERE A.status = 'live' AND A.bus_id = ".$bus_id." ".$str." GROUP BY A.event_id ORDER BY A.startdate ASC ".$limit." ", TRUE);

				if($q->result()){

					$row = $q->result();
					$o['success'] = true;
					$o['msg'] = '';
					$o['data'] = $row;
				}else{

					$o['success'] = false;
					$o['msg'] = 'No record found';

				}
		}

		return $o;
	}
	//+++++++++++++++++++++++++++
	//GET ALL EVENT CATEGORIES
	//+++++++++++++++++++++++++++
	function event_categories($bus_id, $event_id)
	{
		$q = $this->db->query("SELECT calendar_events.*, event_categories.title,
						  group_concat(DISTINCT event_categories.title) as cat_title
						  FROM calendar_events
						  LEFT JOIN events_cat_int ON events_cat_int.event_id = calendar_events.event_id
						  LEFT JOIN event_categories ON event_categories.cat_id = events_cat_int.cat_id
						  WHERE calendar_events.status = 'live' AND calendar_events.event_id = '".$event_id."' AND calendar_events.bus_id = '".$bus_id."'
						  GROUP BY calendar_events.event_id" , TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//TESTIMONIALS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET TESTIMONIALS / ALL OR SINGLE
	//+++++++++++++++++++++++++++
	function testimonials($bus_id , $id, $language)
	{

		if($language != '') {
			$qry = ' AND A.language = "'.$language.'"';
		}else {
			$qry = '';
		}

		if($id != false){

			$q = $this->db->query("SELECT A.*, B.img_file, B.title as img_title, B.body as img_body
								   FROM testimonials as A
								   LEFT JOIN images as B ON A.testimonial_id = B.type_id AND B.type = 'testimonial'
								   WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' AND A.testimonial_id = '".$id."'  ".$qry." ORDER BY A.sequence ASC", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}else {

			$q = $this->db->query("SELECT A.*, B.img_file, B.title as img_title, B.body as img_body
									   FROM testimonials as A
									   LEFT JOIN images as B ON A.testimonial_id = B.type_id AND B.type = 'testimonial'
									   WHERE A.bus_id = '".$bus_id."' AND A.status = 'live' ".$qry." GROUP BY A.testimonial_id ORDER BY A.sequence ASC ", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}
		}


		return $o;


	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SIDEBARS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SIDEBARS
	//+++++++++++++++++++++++++++
	function sidebars($bus_id, $page_id, $content_type, $sidebar_type, $order_by, $limit)
	{


		$str = '';
		if($order_by != ''){
			if($order_by == 'images'){
				$str = ' ORDER BY E.sequence';
			}
			if($order_by == 'sidebar'){
				$str = ' ORDER BY A.sequence';
			}
			if($order_by == 'content'){
				$str = ' ORDER BY B.sequence';
			}

		}else {
			$str = '';
		}
		if($limit != ''){
			$qry = 'LIMIT '.$limit;
		}else {
			$qry = '';
		}


		if($sidebar_type == false ){

			$q = $this->db->query("SELECT A.*
			 					   FROM sidebar_content AS A
		 						   LEFT JOIN content AS B ON B.sidebar_id = A.sidebar_id AND B.type_id = '".$page_id."' AND B.type = '".$content_type."'
			 					   LEFT JOIN pages AS C ON C.page_id = B.type_id
		  						   WHERE C.status = 'live' AND A.bus_id = '".$bus_id."' AND A.status = 'live' ".$str." ".$qry." " , TRUE);

		}else {


			$q = $this->db->query("SELECT A.*,B.content_id,	 D.title AS gallery_title, D.description AS gallery_description, D.gal_id AS gallery_id, D.slug AS gallery_slug, E.img_file, E.title AS image_title, E.body AS image_body, E.url AS image_url
								   FROM sidebar_content AS A
		 						   LEFT JOIN content AS B ON B.sidebar_id = A.sidebar_id AND B.type_id = '".$page_id."' AND B.type = '".$content_type."'
								   LEFT JOIN pages AS C ON C.page_id = B.type_id
								   LEFT JOIN galleries AS D ON A.gal_id = D.gal_id
								   LEFT JOIN images AS E ON E.gal_id = D.gal_id
		 						   WHERE C.status = 'live' AND A.bus_id = '".$bus_id."' AND A.status = 'live' AND A.sidebar_type = '".$sidebar_type."' ".$str." ".$qry." " , TRUE);
		}




		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Properties
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple properties
	//+++++++++++++++++++++++++++
	function products($bus_id, $product_id, $slug, $limit, $offset, $featured, $special, $top_seller, $custom, $new, $category, $manufacturer, $sort, $orderby)
	{
		if ($featured != '') {
			$feat = " AND A.featured = 'Y' " ;
		}else {
			$feat =  "";
		}

		if ($special != '') {
			$spe = " AND A.special = 'Y' " ;
		}else {
			$spe =  "";
		}

		if ($top_seller != '') {
			$ts = " AND A.top_seller = 'Y' " ;
		}else {
			$ts =  "";
		}

		if ($custom != '') {
			$cu = " AND A.custom = 'Y' " ;
		}else {
			$cu =  "";
		}

		if ($new != '') {
			$nw = " AND A.new = 'Y' " ;
		}else {
			$nw =  "";
		}

		$cat_query = '';

		if($category != '') {

			$cat_query.=" AND (";

			$i=1;
			foreach($cats AS $cat_id) {
				if($i==1) {
					$cat_query.= "A.category_array LIKE '%".$cat_id."%' ";
				}else{
					$cat_query.= "OR A.category = '".$cat_id."' ";
				}
			$i++;
			}
			$cat_query.=")";
		}else {
			$cats = array();
		}

		if ($manufacturer != '') {
			$mf = " AND A.manufacturer LIKE '%".$manufacturer."%' " ;
		}else {
			$mf =  " ";
		}

		//IF SLUG PRESENT
		if($slug !== false){

			$q = $this->db->query("SELECT A.*,B.img_file AS img, C.body as category_description, D.type_name, D.slug AS type_slug
					FROM products AS A
					LEFT JOIN images AS B on A.product_id = B.type_id AND B.type = 'product'
					LEFT JOIN product_cats AS C on A.category = C.cat_id
					LEFT JOIN product_types AS D ON A.product_type = D.type_id
					WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.slug = '".$slug."'  ".$cat_query."  ".$feat.$spe.$ts.$cu.$nw." GROUP BY A.product_id ORDER BY A.".$orderby." ".$sort." LIMIT ".$limit." OFFSET ".$offset." ", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

			//echo $this->db->last_query();
		}else if($product_id !== false ){


			$q = $this->db->query("SELECT A.*,B.img_file AS img, C.body as category_description, D.type_name, D.slug AS type_slug
										FROM products AS A
										LEFT JOIN images AS B on A.product_id = B.type_id AND B.type = 'product'
										LEFT JOIN product_cats AS C on A.category = C.cat_id
										LEFT JOIN product_types AS D ON A.product_type = D.type_id
										WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.product_id = '".$product_id."' ".$cat_query."  ".$feat.$spe.$ts.$cu.$nw." GROUP BY A.product_id ORDER BY A.".$orderby." ".$sort." LIMIT ".$limit." OFFSET ".$offset." ", TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}else {


			$q = $this->db->query("SELECT A.*,B.img_file AS img,  C.body as category_description, D.type_name, D.slug AS type_slug
										FROM products AS A
										LEFT JOIN images AS B on A.product_id = B.type_id AND B.type = 'product'
										LEFT JOIN product_cats AS C on A.category = C.cat_id
										LEFT JOIN product_types AS D ON A.product_type = D.type_id
										WHERE A.status = 'live' AND A.bus_id = '".$bus_id."'  ".$cat_query."  ".$feat.$spe.$ts.$cu.$nw." GROUP BY A.product_id ORDER BY A.".$orderby." ".$sort." LIMIT ".$limit." OFFSET ".$offset." ", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//PRODUCT DOWNLOADS
	//+++++++++++++++++++++++++++
	function product_downloads($bus_id, $product_id, $limit, $offset)
	{
		if($limit != ''){
			$qry_str = ' LIMIT '.$limit.' OFFSET '.$offset;
		}else {
			$qry_str = '';
		}

		$q = $this->db->query("SELECT B.*
								   FROM products AS A
								   LEFT JOIN product_documents AS B ON B.product_id = A.product_id
								   WHERE A.bus_id = '".$bus_id."' AND B.product_id = '".$product_id."' ORDER BY B.date_added DESC  ".$qry_str." " , TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}

	//+++++++++++++++++++++++++++
	//PRODUCT FEATURES
	//+++++++++++++++++++++++++++
	function product_features($bus_id, $product_id)
	{

		if($product_id !== false){

			$q = $this->db->query("SELECT A.id as feat_id, A.product_id, A.feature AS product_feature, A.body AS product_body
								   FROM product_feature_int AS A
								   WHERE A.product_id = '".$product_id."' AND A.bus_id = '".$bus_id."' ", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

		}else {

			$q = $this->db->query("SELECT A.id as feat_id, A.product_id, A.feature AS product_feature, A.body AS product_body
								   FROM product_feature_int AS A
								   WHERE A.bus_id = '".$bus_id."'  ", TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}
		}


		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Projects
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple projects
	//+++++++++++++++++++++++++++
	function projects($bus_id, $project_id, $slug, $limit, $offset, $featured, $category, $sort, $orderby, $type)
	{
		if ($featured != '') {
			$feat = " AND A.featured = 'Y' " ;
		}else {
			$feat =  "";
		}

		if ($type != '') {
			$ty = " AND A.type = '".$type."' " ;
		}else {
			$ty =  "";
		}

		$cat_query = '';

		if($category != '') {

			$cat_query.=" AND (";

			$i=1;
			foreach($cats AS $cat_id) {
				if($i==1) {
					$cat_query.= "D.cat_name LIKE '%".$cat_id."%' ";
				}else{
					$cat_query.= "OR A.cat_name = '".$cat_id."' ";
				}
			$i++;
			}
			$cat_query.=")";
		}else {
			$cats = array();
		}
		//  AND C.cat_name = '".$project_category."'
		//IF SLUG PRESENT
		if($slug !== false){

			$q = $this->db->query("SELECT A.*, B.img_file, B.title as img_title, B.body as img_body, B.url as img_url, C.cat_name, C.cat_id, D.body as cat_body, D.slug as cat_slug, E.testimonial_id, E.title as testimonial_title, E.body as testimonial_body, F.people_id, F.name as people_name, F.sequence as people_sequence
				FROM projects AS A
				LEFT JOIN images AS B on A.project_id = B.type_id AND B.type = 'project'
				LEFT JOIN project_cat_int AS C ON A.project_id = C.project_id
				LEFT JOIN project_categories AS D ON C.cat_id = D.cat_id
				LEFT JOIN project_testimonials AS E ON E.testimonial_id = A.project_id
				LEFT JOIN project_people_int AS F ON F.people_id = A.project_id
				WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.slug = '".$slug."'  ".$cat_query."  ".$feat.$ty." GROUP BY A.project_id ORDER BY A.".$orderby." LIMIT ".$limit." OFFSET ".$offset." ", TRUE);


			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

			//echo $this->db->last_query();
		}else if($project_id !== false ){


			$q = $this->db->query("SELECT A.*, B.img_file, B.title as img_title, B.body as img_body, B.url as img_url, C.cat_name, C.cat_id, D.body as cat_body, D.slug as cat_slug, E.testimonial_id, E.title as testimonial_title, E.body as testimonial_body, F.people_id, F.name as people_name, F.sequence as people_sequence
				FROM projects AS A
				LEFT JOIN images AS B on A.project_id = B.type_id AND B.type = 'project'
				LEFT JOIN project_cat_int AS C ON A.project_id = C.project_id
				LEFT JOIN project_categories AS D ON C.cat_id = D.cat_id
				LEFT JOIN project_testimonials AS E ON E.testimonial_id = A.project_id
				LEFT JOIN project_people_int AS F ON F.people_id = A.project_id
				WHERE A.status = 'live' AND A.bus_id = '".$bus_id."' AND A.project_id = '".$project_id."'  ".$cat_query."  ".$feat.$ty." GROUP BY A.project_id ORDER BY A.".$orderby."  LIMIT ".$limit." OFFSET ".$offset." ", TRUE);



			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}

			//echo $this->db->last_query();

		}else {


			$q = $this->db->query("SELECT A.*, B.img_file, B.title as img_title, B.body as img_body, B.url as img_url, C.cat_name, C.cat_id, D.body as cat_body, D.slug as cat_slug, E.testimonial_id, E.title as testimonial_title, E.body as testimonial_body, F.people_id, F.name as people_name, F.sequence as people_sequence
				FROM projects AS A
				LEFT JOIN images AS B on A.project_id = B.type_id AND B.type = 'project'
				LEFT JOIN project_cat_int AS C ON A.project_id = C.project_id
				LEFT JOIN project_categories AS D ON C.cat_id = D.cat_id
				LEFT JOIN project_testimonials AS E ON E.testimonial_id = A.project_id
				LEFT JOIN project_people_int AS F ON F.people_id = A.project_id
				WHERE A.status = 'live' AND A.bus_id = '".$bus_id."'  ".$cat_query."   ".$feat.$ty."  GROUP BY A.project_id ORDER BY A.".$orderby." ".$sort." LIMIT ".$limit." OFFSET ".$offset." ", TRUE);

			//echo $this->db->last_query();

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;
			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}



		}


		return $o;


	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//NMC - CONTRIBUTIONS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//CONTRIBUTIONS
	//+++++++++++++++++++++++++++
	function nmc_contributions($type, $age_band, $dependency, $option)
	{
		//$qry = ' WHERE ';
		if($option != ''){
			$q = $this->db->where('option',$option);
		}
		if ($type != '') {
			$q = $this->db->where('type',$type);
		}
		if($age_band != ''){

			if( is_array($age_band)){

				$q = $this->db->where_in('age_band',$age_band);
			}else {
				$q = $this->db->where('age_band',$age_band);
			}
		}
		if($dependency != ''){

			if( is_array($dependency)){

				$q = $this->db->where_in('dependency', $dependency);

			}else {
				$q = $this->db->where('dependency',$dependency);
			}
		}


		$q = $this->db->order_by('con_id','ASC');
		$q = $this->db->get('nmc_contributions');

		 //echo $this->db->last_query();
		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;
		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//USER_VOTES (kosmos)
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//SET VOTES FOR VIDEOS::
	//+++++++++++++++++++++++++++
	function set_votes($bus_id, $id, $type, $vote_type, $user_ip)
	{
		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('subscriber_id', '0');
		$q = $this->db->where('type', $type);
		$q = $this->db->where('type_id', $id);
		$q = $this->db->where('ip', $user_ip);
		$q = $this->db->where('datetime', 'CURDATE()');
		$q = $this->db->get('user_votes');

		if($q->result()){

			$o['success'] = false;
			$o['msg'] = 'A vote has already been submitted.';

		} else {

			date_default_timezone_set('Africa/Windhoek');
			$time = date("r"); // local time

			$data = array(
			'bus_id' => $bus_id,
			'subscriber_id' => '0',
			'type' => $type,
			'type_id' => $id,
			'ip' => $user_ip,
			'datetime' => date('y-m-d h:i:s',strtotime($time)),
			'vote_type' => $vote_type
			);

			$this->db->insert('user_votes', $data);

			if($this->db->trans_status() == TRUE){

				$o['success'] = true;
				$o['msg'] = 'Successfully inserted entry';

			}else{
				$o['success'] = false;
				$o['msg'] = 'Could not insert entry';
			}

		}

		return $o;
	}

	function check_votes($bus_id, $type_id, $type,  $user_ip) {

		$q = $this->db->query("SELECT * FROM user_votes WHERE type = '".$type."' AND type_id = '".$type_id."' AND ip = '".$user_ip."' AND datetime >= CURDATE() AND bus_id = '".$bus_id."'", TRUE);

		// echo $this->db->last_query();

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//COUNT VOTES::
	//+++++++++++++++++++++++++++
	function count_votes($bus_id, $gal_id)
	{
		$q = $this->db->query("SELECT A.* , COUNT(B.vote_id) as total_votes
           FROM videos as A
           LEFT JOIN user_votes as B ON A.vid_id = B.type_id
           WHERE A.gal_id = '".$gal_id."' AND A.bus_id = '".$bus_id."'
           GROUP BY A.vid_id
           ORDER BY total_votes DESC, vid_id DESC", TRUE);

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}

	//+++++++++++++++++++++++++++
	//GET PUBLICATIONS
	//+++++++++++++++++++++++++++
	function publications($bus_id, $cat_slug, $slug)
	{

		if($cat_slug !== false)
		{
			$q = $this->db->query("SELECT A.*, B.*, C.*, D.cat_name AS parent_category
								  FROM publications_extended AS A
								  LEFT JOIN pub_cat_int_extended AS B ON A.pub_id = B.pub_id
								  LEFT JOIN pub_categories AS C ON C.cat_id = B.cat_id
								  LEFT JOIN pub_categories AS D ON D.cat_id = C.parent_id
								  WHERE A.status = 'live' AND C.slug = '".$cat_slug."' AND A.bus_id = '".$bus_id."'" , TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}


		}else if ($slug !== false) {

			$q = $this->db->query("SELECT A.*, B.*, C.*, D.cat_name AS parent_category
								  FROM publications_extended AS A
								  LEFT JOIN pub_cat_int_extended AS B ON A.pub_id = B.pub_id
								  LEFT JOIN pub_categories AS C ON C.cat_id = B.cat_id
								  LEFT JOIN pub_categories AS D ON D.cat_id = C.parent_id
								  WHERE A.status = 'live' AND A.slug = '".$slug."' AND A.bus_id = '".$bus_id."'" , TRUE);

			if($q->result()){

				$row = $q->row_array();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}


		}else {

			$q = $this->db->query("SELECT A.*, B.*, C.*, D.cat_name AS parent_category
								  FROM publications_extended AS A
								  LEFT JOIN pub_cat_int_extended AS B ON A.pub_id = B.pub_id
								  LEFT JOIN pub_categories AS C ON C.cat_id = B.cat_id
								  LEFT JOIN pub_categories AS D ON D.cat_id = C.parent_id
								  WHERE A.status = 'live' AND A.bus_id = '".$bus_id."'" , TRUE);

			if($q->result()){

				$row = $q->result();
				$o['success'] = true;
				$o['msg'] = '';
				$o['data'] = $row;

			}else{

				$o['success'] = false;
				$o['msg'] = 'No record found';

			}
		}

		return $o;

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SURVEYS (kosmos)
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET LATEST SURVEY::
	//+++++++++++++++++++++++++++
	function latest_survey($bus_id)
	{

		$q = $this->db->query("SELECT MAX(survey_id) AS max_id FROM surveys WHERE bus_id = '".$bus_id."'", TRUE);

		if($q->result()){

			$row = $q->row();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row->max_id;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET SURVEY QUESTION::
	//+++++++++++++++++++++++++++
	function survey_question($bus_id, $survey_id)
	{

		//$q = $this->db->query("SELECT MAX(survey_id) AS max_id FROM surveys WHERE bus_id = '".$bus_id."'", TRUE);
		// $q = $this->db->where('survey_id', $survey_id);
		// $q = $this->db->order_by('question_id', 'ASC');
		// $q = $this->db->get('survey_questions');

		$q = $this->db->query("SELECT A.survey_id as survey_id, A.bus_id as bus_id, A.creator as survey_creator, A.title as survey_title, A.description as survey_description, A.datetime as survey_datetime, A.slug as survey_slug, A.type as survey_type,A.color_primary as color_primary, A.color_secondary as color_secondary, B.question_id as question_id,B.questions as questions, B.help_text as help_text, B.video_url as video_url, B.website_url as website_url, B.answers as answers, B.correct_answer as correct_answer, B.type as type, B.sequence as sequence
							   FROM `surveys` AS A
							   LEFT JOIN survey_questions AS B on A.survey_id = B.survey_id
							   WHERE A.bus_id = '".$bus_id."'
							   AND A.survey_id = '".$survey_id."'
							   ORDER BY B.sequence ASC", TRUE);





		// SELECT A.survey_id as survey_id, A.bus_id as bus_id, A.creator as survey_creator, A.title as survey_title, A.description as survey_description, A.datetime as survey_datetime, A.slug as survey_slug, A.type as survey_type,A.color_primary as color_primary, A.color_secondary as color_secondary, B.question_id as question_id, B.help_text as help_text, B.answers as answers, B.correct_answer as correct_answer, B.type as type, B.sequence as sequence
		// FROM `surveys` AS A
		// LEFT JOIN survey_questions AS B on A.survey_id = B.survey_id
		// WHERE A.bus_id = '".$bus_id."'
		// ORDER BY B.question_id ASC

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//INSERT SURVEY FEEDBACK
	//+++++++++++++++++++++++++++
	function insert_survey_feedback($survey_id, $bus_id, $answer, $ip, $member_id, $type, $name, $email, $cell, $age, $datetime)
	{

		//INSERT INTO MESSAGES TABLE
		date_default_timezone_set('Africa/Windhoek');

		$insertdata1 = array(
			'survey_id'=> $survey_id ,
			'bus_id'=> $bus_id,
			'member_id'=> $member_id ,
			'ip'=> $ip ,
			'answer'=> $answer ,
			'type'=> $type ,
			'name'=> $name ,
			'email'=> $email ,
			'cell'=> $cell,
			'age'=> $age,
			'datetime' => date('Y-m-d H:i:S',strtotime($datetime))
			);

		if($this->db->insert('survey_feedback',$insertdata1)){

			//$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '<b>Success!</b> Thank you for taking part in our survey';
			$o['feedback_id'] = $this->db->insert_id();

		}else{

			$o['success'] = false;
			$o['msg'] = '<b>Oops!</b> Something went wrong. Please try again later';

		}

		return $o;

	}
	//+++++++++++++++++++++++++++
	//GET SURVEY QUESTION::
	//+++++++++++++++++++++++++++
	function survey_feedback($bus_id, $survey_id)
	{

		$q = $this->db->where('bus_id', $bus_id);
		$q = $this->db->where('survey_id', $survey_id);
		$q = $this->db->get('survey_feedback');

		if($q->result()){

			$row = $q->result();
			$o['success'] = true;
			$o['msg'] = '';
			$o['data'] = $row;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No record found';

		}

		return $o;

	}







//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//END OF DOCUMENT !!!!
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

}
