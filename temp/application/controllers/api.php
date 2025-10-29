<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller{

	/**
	 * REST Controller for My.na CMS.
	 *
	 * Roland Ihms
	 */
	//++++++++++++++++++++++++++++++++++++++++
	//PRE FLIGHT OPTIONS REQUEST
	public function index_options() {
		return $this->response(NULL, 200);
	}


	public function index_get()
	{
 		// echo $this->rest->debug();
		$this->response('Going Nowhere Slowly!!', 200);
	}

	public function index_post()
	{

		$this->response('Going Nowhere Slowly!!', 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN CONTROLLER QUERY SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++
	function settings_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->settings($bus_id);

		$this->response($o, 200);
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET PAGE BY SLUG
	//++++++++++++++++++++++++++
	function page_by_slug_get()
	{
		//error_reporting(E_ALL);

		if(!$slug = $this->get('slug')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid slug';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->page_by_slug($bus_id,$slug,$language);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//GET PAGE BY ID
	//++++++++++++++++++++++++++
	function page_by_id_get()
	{
		//error_reporting(E_ALL);

		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->page_by_id($bus_id,$page_id,$language);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//GET PAGE BY TEMPLATE
	//++++++++++++++++++++++++++
	function page_by_template_get()
	{
		//error_reporting(E_ALL);

		if(!$template = $this->get('template')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid template';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->page_by_template($bus_id,$template,$language);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//GET ALL LIVE PAGES
	//++++++++++++++++++++++++++
	function page_all_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->page_all($bus_id);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SUB PAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SUB PAGE CONTENT
	//+++++++++++++++++++++++++++
	function sub_pages_content_get()
	{
		//error_reporting(E_ALL);

		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->sub_pages_content($bus_id,$page_id, $language);

		$this->response($o, 200);

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MENU SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET MENU ITEMS
	//+++++++++++++++++++++++++++
	function menu_items_get()
	{
		//error_reporting(E_ALL);

		if(!$type = $this->get('type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid menu type';
			$this->response($o, 200);

		}
		if(!$position = $this->get('position')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid position';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->menu_items($bus_id, $type, $position);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//GET CONTENT TITLE
	//++++++++++++++++++++++++++
	function content_title_get()
	{
		//error_reporting(E_ALL);
		if(!$language = $this->get('language')){

			$language = '';

		}
		if(!$type = $this->get('type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid menu type';
			$this->response($o, 200);

		}
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';
			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->content_title($bus_id, $language, $type, $id);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET NAVIGATION
	//++++++++++++++++++++++++++
	function navigation_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->navigation($bus_id, $language);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//BREADCRUMB SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET PARENT
	//++++++++++++++++++++++++++
	function parent_get()
	{
		if(!$parent_id = $this->get('parent_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid parent_id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->parent($bus_id, $parent_id, $language);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET CATEGORY TREE IDS
	//++++++++++++++++++++++++++
	function CategoryTreeIDs_get()
	{
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->CategoryTreeIDs($bus_id, $id, $language);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET BREADCRUMBS
	//++++++++++++++++++++++++++
	function breadcrumbs_get()
	{
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->breadcrumbs($bus_id, $id, $language);

		$this->response($o, 200);
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//POSTS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET POST BY SLUG, IF NO SLUG BRING BACK ALL
	//++++++++++++++++++++++++++
	function posts_get()
	{
		//error_reporting(E_ALL);

		if(!$slug = $this->get('slug')){

			$slug = false;

		}
		//LIMIT
		if(!$limit = $this->get('limit')){

			$limit = 10;

		}
		//OFFSET
		if(!$offset = $this->get('offset')){

			$offset = 0;

		}
		if(!$category = $this->get('category')){

			$category = '';

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$language = $this->get('language')){
			$language = 'english';
		}
		$this->load->model('api_model');
		$o = $this->api_model->posts($bus_id,$slug, $limit, $offset, $category, $language);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET POST BY ALL - NO LIMIT
	//++++++++++++++++++++++++++
	function all_posts_get()
	{

		if(!$category = $this->get('category')){

			$category = '';

		}
		if(!$language = $this->get('language')){

			$language = '';

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->all_posts($bus_id, $category, $language);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET POST CATEGORIES
	//++++++++++++++++++++++++++
	function post_cats_get()
	{

		if(!$category = $this->get('category')){

			$category = '';

		}
		if(!$slug = $this->get('slug')){

			$slug = '';

		}
		if(!$id = $this->get('id')){

			$id = '';

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->post_cats($bus_id, $category, $slug, $id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET POST CATEGORIES
	//++++++++++++++++++++++++++
	function post_comments_get()
	{

		if(!$post_id = $this->get('post_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid post id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'subscriber';

		}
		$this->load->model('api_model');
		$o = $this->api_model->post_comments($bus_id, $post_id, $type);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET POST CATEGORIES
	//++++++++++++++++++++++++++
	function insert_post_comments_get()
	{

		if(!$post_id = $this->get('post_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid post id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$subscriber_id = $this->get('subscriber_id')){
			$subscriber_id = '';
		}
		if(!$name = $this->get('name')){
			$name = '';
		}
		if(!$email = $this->get('email')){
			$email = '';
		}
		if(!$body = $this->get('body')){
			$body = '';
		}
		if(!$type = $this->get('type')){
			$type = 'comment';
		}
		if(!$datetime = $this->get('datetime')){
			$datetime = date("r");
		}
		if(!$status = $this->get('status')){
			$status = 'moderate';
		}
		$this->load->model('api_model');
		$o = $this->api_model->insert_post_comments($post_id, $bus_id, $name, $email, $body, $type, $datetime, $status, $subscriber_id);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//IMAGES SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS
	//+++++++++++++++++++++++++++
	function sliders_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->sliders($bus_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES -- NADJA
	//+++++++++++++++++++++++++++
	// function galleries_get()
	// {

	// 	if(!$bus_id = $this->get('bus_id')){

	// 		$o['success'] = false;
	// 		$o['msg'] = 'PLease provide us with a valid bus_id';

	// 		$this->response($o, 200);

	// 	}
	// 	if(!$gal_id = $this->get('gal_id')){

	// 		$gal_id = false;

	// 	}
	// 	if(!$type = $this->get('type')){

	// 		$o['success'] = false;
	// 		$o['msg'] = 'PLease provide us with a valid type';

	// 		$this->response($o, 200);

	// 	}
	// 	if(!$category = $this->get('category')){

	// 		$category = '';

	// 	}
	// 	$this->load->model('api_model');
	// 	$o = $this->api_model->galleries($bus_id, $gal_id, $type, $category);

	// 	$this->response($o, 200);
	// }
	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES -- JEROLD
	//+++++++++++++++++++++++++++
	function galleries_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$gal_id = $this->get('gal_id')){

			$gal_id = false;

		}
		if(!$type = $this->get('type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid type';

			$this->response($o, 200);

		}
		if(!$category = $this->get('category')){

			$category = '';

		}

		if(!$page_id = $this->get('page_id')){

			$page_id = '';

		}

		$this->load->model('api_model');
		$o = $this->api_model->galleries($bus_id, $gal_id, $type, $category, $page_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE
	//+++++++++++++++++++++++++++
	function featured_image_get()
	{
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';
			$this->response($o, 200);

		}
		//LIMIT
		if(!$type = $this->get('type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid type';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->featured_image($bus_id, $id, $type);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET FEATURED GALLERY
	//+++++++++++++++++++++++++++
	function featured_gallery_get()
	{
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';
			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid type';
			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->featured_gallery($bus_id, $id, $type);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//VIDEO SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function videos_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$limit = $this->get('limit')){

			$limit = '';

		}
		if(!$groupBy = $this->get('groupBy')){

			$groupBy = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->videos($bus_id, $limit, $groupBy);

		$this->response($o, 200);
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADVERTS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function adverts_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$category = $this->get('category')){

			$category = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->adverts($bus_id, $category);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//FAQ's SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function faqs_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->faqs($bus_id);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAP SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET MAP MARKERS
	//+++++++++++++++++++++++++++
	function map_markers_get()
	{
		if(!$slug = $this->get('slug')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid slug';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->map_markers($bus_id, $slug);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CONTACT SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//INSERT ENQUIRY
	//+++++++++++++++++++++++++++
	function enquire_get()
	{
		if(!$name = $this->get('name')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid name';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$email = $this->get('email')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid email';

			$this->response($o, 200);

		}
		if(!$msg = $this->get('body')){

			$o['success'] = false;
			$o['msg'] = 'No message received?';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'enquiry';

		}
		if(!$datetime = $this->get('datetime')){

			$datetime = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->insert_enquiry($bus_id, $name, $email, $msg, $type, $datetime);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//INSERT Newsletter - Subscribers
	//+++++++++++++++++++++++++++
	function insert_newsletter_get()
	{

		if(!$name = $this->get('name')){

			$name = '';

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$email = $this->get('email')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid email';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'Subscriber';

		}
		if(!$type_id = $this->get('type_id')){

			$type_id = false;

		}
		if(!$time = $this->get('time')){

			//local time
			$time = date("r");

		}
		if(!$categories = $this->get('categories')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid category';

			$this->response($o, 200);

		}
		if(!$phone = $this->get('phone')){
			$phone = '';
		}
		if(!$city = $this->get('city')){
			$city = '';
		}
		if(!$company = $this->get('company')){
			$company = '';
		}
		if(!$country = $this->get('country')){
			$country = '';
		}
		if(!$password = $this->get('password')){
			$password = '';
		}
		if(!$sname = $this->get('sname')){
			$sname = '';
		}
		if(!$status = $this->get('status')){
			$status = '';
		}
		if(!$activation_code = $this->get('activation_code')){
			$activation_code = '';
		}
		if(!$mem_no = $this->get('mem_no')){
			$mem_no = '';
		}
		if(!$dob = $this->get('dob')){
			$dob = '';
		}
		if(!$job_title = $this->get('job_title')){
			$job_title = '';
		}
		if(!$department = $this->get('department')){
			$department = '';
		}
		if(!$gender = $this->get('gender')){
			$gender = '';
		}
		if(!$region = $this->get('region')){
			$region = '';
		}
		if(!$address = $this->get('address')){
			$address = '';
		}
		if(!$contact = $this->get('contact')){
			$contact = '';
		}
		if(!$website = $this->get('website')){
			$website = '';
		}
		if(!$profile_pic = $this->get('profile_pic')){
			$profile_pic = '';
		}
		if(!$pass_code = $this->get('pass_code')){
			$pass_code = '';
		}
		if(!$ip = $this->get('ip')){
			$ip = '';
		}


		$this->load->model('api_model');
		$o = $this->api_model->insert_newsletter($bus_id, $name, $sname, $email, $type, $type_id, $time, $categories,  $phone, $city, $company, $country, $password, $status, $activation_code, $mem_no,$dob, $job_title, $department, $gender, $region, $address, $contact, $website, $profile_pic, $pass_code, $ip );

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS GET
	//+++++++++++++++++++++++++++
	function subscribers_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$email = $this->get('email')){

			$email = '';

		}
		if(!$subscriber_id = $this->get('subscriber_id')){

			$subscriber_id = '';
		}
		if(!$mem_no = $this->get('mem_no')){

			$mem_no = '';
		}
		if(!$activation_code = $this->get('activation_code')){

			$activation_code = '';
		}
		if(!$type = $this->get('type')){

			$type = '';
		}
		if(!$type_id = $this->get('type_id')){

			$type_id = false;
		}
		if(!$new_type = $this->get('new_type')){

			$new_type = '';
		}
		if(!$status = $this->get('status')){

			$status = '';
		}
		if(!$password = $this->get('password')){

			$password = '';
		}
		if(!$pass_code = $this->get('pass_code')){

			$pass_code = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->subscribers($bus_id, $email, $subscriber_id, $mem_no, $activation_code, $type, $type_id, $new_type, $status, $password, $pass_code);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS GET
	//+++++++++++++++++++++++++++
	function subscribers_update_get()
	{

		if(!$name = $this->get('name')){
			$name = false;
		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$email = $this->get('email')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid email';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){
			$type = false;
		}
		if(!$time = $this->get('time')){
			//local time
			$time = date("r");
		}
		if(!$phone = $this->get('phone')){
			$phone = false;
		}
		if(!$city = $this->get('city')){
			$city = false;
		}
		if(!$company = $this->get('company')){
			$company = false;
		}
		if(!$country = $this->get('country')){
			$country = false;
		}
		if(!$password = $this->get('password')){
			$password = false;
		}
		if(!$sname = $this->get('sname')){
			$sname = false;
		}
		if(!$status = $this->get('status')){
			$status = false;
		}
		if(!$activation_code = $this->get('activation_code')){
			$activation_code = false;
		}
		if(!$mem_no = $this->get('mem_no')){
			$mem_no = false;
		}

		if(!$dob = $this->get('dob')){
			$dob = false;
		}
		if(!$job_title = $this->get('job_title')){
			$job_title = false;
		}
		if(!$department = $this->get('department')){
			$department = false;
		}
		if(!$gender = $this->get('gender')){
			$gender = false;
		}
		if(!$region = $this->get('region')){
			$region = false;
		}
		if(!$address = $this->get('address')){
			$address = false;
		}
		if(!$contact = $this->get('contact')){
			$contact = false;
		}
		if(!$website = $this->get('website')){
			$website = false;
		}
		if(!$profile_pic = $this->get('profile_pic')){
			$profile_pic = false;
		}
		if(!$pass_code = $this->get('pass_code')){
			$pass_code = false;
		}
		if(!$ip = $this->get('ip')){
			$ip = false;
		}

		$this->load->model('api_model');
		$o = $this->api_model->subscribers_update($name, $bus_id, $email, $type, $time, $phone, $city, $company, $country, $password, $sname, $status, $activation_code, $mem_no, $dob, $job_title, $department, $gender, $region, $address, $contact, $website, $profile_pic, $pass_code, $ip);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//Remove/delete image
	//+++++++++++++++++++++++++++
	function remove_image_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'subscriber';
		}
		if(!$type_id = $this->get('type_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);
		}

		$this->load->model('api_model');
		$o = $this->api_model->remove_image($bus_id, $type, $type_id);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/// GET MEMBERS SECTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	// GET MEMBERS
	//+++++++++++++++++++++++++++
	function members_get()
	{
		if(!$cat = $this->get('cat')){

			$cat = false;

		}
		if(!$people_id = $this->get('people_id')){

			$people_id = false;

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->members($bus_id, $cat, $people_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	// GET MEMBERS ATTACHED TO PAGES
	//+++++++++++++++++++++++++++
	function page_people_get()
	{
		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->page_people($bus_id, $page_id);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//business_classifications
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL business_classifications
	//+++++++++++++++++++++++++++
	function business_classifications_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$bus_id = false;
		}
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';

			$this->response($o, 200);
		}
		$this->load->model('api_model');
		$o = $this->api_model->business_classifications($bus_id , $id);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//LOCATION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET ALL LOCATIONS
	//+++++++++++++++++++++++++++
	function locations_get()
	{
		if(!$locationID_arr = $this->get('locationID_arr')){

			$locationID_arr = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->locations($locationID_arr);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET ALL  SUBURBS
	//+++++++++++++++++++++++++++
	function suburbs_get()
	{
		if(!$location = $this->get('location')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid location';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->suburbs($location);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//SIMPLE SEARCH
	//+++++++++++++++++++++++++++
	function simple_search_get()
	{
		if(!$str = $this->get('str')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid search string';

			$this->response($o, 200);

		}
		if(!$table = $this->get('table')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid table name';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$status = $this->get('status')){

			$status = 'live';

		}
		if(!$language = $this->get('language')){

			$language = 'english';

		}
		$this->load->model('api_model');
		$o = $this->api_model->simple_search($bus_id, $table, $str, $status, $language);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Properties
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple properties
	//+++++++++++++++++++++++++++
	function properties_get()
	{
		if(!$slug = $this->get('slug')){

			$slug = false;

		}
		if(!$is_featured = $this->get('is_featured')){

			$is_featured = false;

		}
		if(!$p_id = $this->get('p_id')){

			$p_id = false;

		}
		//LIMIT
		if(!$limit = $this->get('limit')){

			$limit = 10;

		}
		//OFFSET
		if(!$offset = $this->get('offset')){

			$offset = 0;

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->properties($bus_id, $p_id, $slug, $limit, $offset, $is_featured);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//Get property features
	//+++++++++++++++++++++++++++
	function property_feature_get()
	{
		//OFFSET
		if(!$p_id = $this->get('p_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid property_id';

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->property_feature($bus_id, $p_id);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNLOADS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//PAGE DOWNLOADS
	//+++++++++++++++++++++++++++
	function page_downloads_get()
	{

		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$order = $this->get('order')){

			$order = 'date';
		}
		if(!$limit = $this->get('limit')){

			$limit = '';
		}
		if(!$offset = $this->get('offset')){

			$offset = 0;
		}
		$this->load->model('api_model');
		$o = $this->api_model->page_downloads($bus_id, $page_id, $limit, $offset,$order);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//PAGE DOWNLOADS SEARCH
	//+++++++++++++++++++++++++++
	function page_downloads_search_get()
	{

		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$order = $this->get('order')){

			$order = 'date';
		}
		if(!$limit = $this->get('limit')){

			$limit = '';
		}
		if(!$offset = $this->get('offset')){

			$offset = 0;
		}
		if(!$str = $this->get('str')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid search string';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->page_downloads_search($bus_id, $page_id, $limit, $offset,$order, $str);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EVENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET EVENTS
	//+++++++++++++++++++++++++++
	function event_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$slug = $this->get('slug')){

			$slug = FALSE;

		}
		if(!$cat_id = $this->get('cat_id')){

			$cat_id = '';

		}
		if(!$limit = $this->get('limit')){

			$limit = '';

		}
		if(!$week = $this->get('week')){

			$week = 'N';

		}
		if(!$check_date = $this->get('check_date')){

			$check_date = 'Y';

		}
		if(!$type = $this->get('type')){

			$type = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->event($bus_id, $slug, $cat_id, $limit, $week, $check_date, $type);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET ALL EVENT CATEGORIES
	//+++++++++++++++++++++++++++
	function event_categories_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$event_id = $this->get('event_id')){

			$event_id = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->event_categories($bus_id, $event_id );

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//TESTIMONIALS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET TESTIMONIALS
	//+++++++++++++++++++++++++++
	function testimonials_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$id = $this->get('id')){

			$id = false;

		}
		if(!$language = $this->get('language')){

			$language = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->testimonials($bus_id, $id, $language );

		$this->response($o, 200);

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SIDEBARS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET SIDEBARS
	//+++++++++++++++++++++++++++
	function sidebars_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$page_id = $this->get('page_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';

			$this->response($o, 200);

		}
		if(!$content_type = $this->get('content_type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid content_type';

			$this->response($o, 200);

		}
		if(!$sidebar_type = $this->get('sidebar_type')){

			$sidebar_type = false;

		}
		if(!$order_by = $this->get('order_by')){

			$order_by = '';
		}
		if(!$limit = $this->get('limit')){

			$limit = '';
		}
		$this->load->model('api_model');
		$o = $this->api_model->sidebars($bus_id, $page_id, $content_type, $sidebar_type, $order_by, $limit );

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Products
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple products
	//+++++++++++++++++++++++++++
	function products_get()
	{
		if(!$slug = $this->get('slug')){

			$slug = false;

		}
		if(!$featured = $this->get('featured')){

			$featured = '';

		}
		if(!$special = $this->get('special')){

			$special = '';

		}
		if(!$top_seller = $this->get('top_seller')){

			$top_seller = '';

		}
		if(!$custom = $this->get('custom')){

			$custom = '';

		}
		if(!$new = $this->get('new')){

			$new = '';

		}
		if(!$category = $this->get('category')){

			$category = '';

		}
		if(!$manufacturer = $this->get('manufacturer')){

			$manufacturer = '';

		}
		if(!$sort = $this->get('sort')){

			$sort = 'DESC';

		}
		if(!$orderby = $this->get('orderby')){

			$orderby = 'listing_date';

		}
		if(!$product_id = $this->get('product_id')){

			$product_id = false;

		}
		//LIMIT
		if(!$limit = $this->get('limit')){

			$limit = 10;

		}
		//OFFSET
		if(!$offset = $this->get('offset')){

			$offset = 0;

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->products($bus_id, $product_id, $slug, $limit, $offset, $featured, $special, $top_seller, $custom, $new, $category, $manufacturer, $sort, $orderby);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//PRODUCT DOWNLOADS
	//+++++++++++++++++++++++++++
	function product_downloads_get()
	{

		if(!$product_id = $this->get('product_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid page_id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$limit = $this->get('limit')){

			$limit = '';
		}
		if(!$offset = $this->get('offset')){

			$offset = 0;
		}
		$this->load->model('api_model');
		$o = $this->api_model->product_downloads($bus_id, $product_id, $limit, $offset);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//PRODUCT FEATURES
	//+++++++++++++++++++++++++++
	function product_features_get()
	{

		if(!$product_id = $this->get('product_id')){

			$product_id = false;

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->product_features($bus_id, $product_id);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PROJECTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//Get single/multiple projects
	//+++++++++++++++++++++++++++
	function projects_get()
	{
		if(!$slug = $this->get('slug')){

			$slug = false;

		}
		if(!$featured = $this->get('featured')){

			$featured = '';

		}
		if(!$type = $this->get('type')){

			$type = '';

		}
		if(!$category = $this->get('category')){

			$category = '';

		}
		if(!$sort = $this->get('sort')){

			$sort = 'DESC';

		}
		if(!$orderby = $this->get('orderby')){

			$orderby = 'project_id';

		}
		if(!$project_id = $this->get('project_id')){

			$project_id = false;

		}
		//LIMIT
		if(!$limit = $this->get('limit')){

			$limit = 10;

		}
		//OFFSET
		if(!$offset = $this->get('offset')){

			$offset = 0;

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->projects($bus_id, $project_id, $slug, $limit, $offset, $featured, $category, $sort, $orderby, $type);

		$this->response($o, 200);
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//NMC - CONTRIBUTIONS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//CONTRIBUTIONS
	//+++++++++++++++++++++++++++
	function nmc_contributions_get()
	{

		if(!$type = $this->get('type')){

			$type = '';

		}
		if(!$age_band = $this->get('age_band')){

			$age_band = '';

		}
		if(!$dependency = $this->get('dependency')){

			$dependency = '';

		}
		if(!$option = $this->get('option')){

			$option = '';

		}
		$this->load->model('api_model');
		$o = $this->api_model->nmc_contributions($type, $age_band, $dependency, $option);

		$this->response($o, 200);

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//USER_VOTES (kosmos)
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//SET VOTES FOR VIDEOS::
	//+++++++++++++++++++++++++++
	function set_votes_get()
	{

		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$id = $this->get('id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid video id';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'video';

		}
		if(!$vote_type = $this->get('vote_type')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid vote type';

			$this->response($o, 200);

		}
		if(!$user_ip = $this->get('user_ip')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid user ip';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->set_votes($bus_id, $id, $type, $vote_type, $user_ip);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//SET VOTES FOR VIDEOS::
	//+++++++++++++++++++++++++++
	function check_votes_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$type_id = $this->get('type_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid type_id';

			$this->response($o, 200);

		}
		if(!$type = $this->get('type')){

			$type = 'video';

		}
		if(!$user_ip = $this->get('user_ip')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid id';

			$this->response($o, 200);

		}
		$this->load->model('api_model');
		$o = $this->api_model->check_votes($bus_id, $type_id, $type,  $user_ip);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//COUNT VOTES::
	//+++++++++++++++++++++++++++
	function count_votes_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$gal_id = $this->get('gal_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid gal_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->count_votes($bus_id, $gal_id);

		$this->response($o, 200);
	}


	//+++++++++++++++++++++++++++
	//GET PUBLICATIONS
	//+++++++++++++++++++++++++++
	function publications_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$cat_slug = $this->get('cat_slug')){

			$cat_slug = false;

		}
		if(!$slug = $this->get('slug')){

			$slug = false;

		}

		$this->load->model('api_model');
		$o = $this->api_model->publications($bus_id, $cat_slug, $slug);

		$this->response($o, 200);
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SURVEYS (kosmos)
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//GET LATEST SURVEY::
	//+++++++++++++++++++++++++++
	function latest_survey_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->latest_survey($bus_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET SURVEY QUESTION::
	//+++++++++++++++++++++++++++
	function survey_question_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}

		if(!$survey_id = $this->get('survey_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid survey_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->survey_question($bus_id, $survey_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//INSERT ENQUIRY
	//+++++++++++++++++++++++++++
	function insert_survey_feedback_get()
	{

		if(!$survey_id = $this->get('survey_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid survey_id';

			$this->response($o, 200);

		}
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}
		if(!$answer = $this->get('answer')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid answer';

			$this->response($o, 200);

		}
		if(!$ip = $this->get('ip')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid ip';

			$this->response($o, 200);

		}
		if(!$member_id = $this->get('member_id')){

			$member_id = 0;

		}
		if(!$type = $this->get('type')){

			$type = 'input';

		}
		if(!$name = $this->get('name')){

			$name = '';

		}
		if(!$email = $this->get('email')){

			$email = '';

		}
		if(!$cell = $this->get('cell')){

			$cell = '';

		}
		if(!$age = $this->get('age')){

			$age = '';

		}
		if(!$datetime = $this->get('datetime')){

			$datetime = date("r");

		}

		$this->load->model('api_model');
		$o = $this->api_model->insert_survey_feedback($survey_id, $bus_id, $answer, $ip, $member_id, $type, $name, $email, $cell, $age, $datetime);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET SURVEY QUESTION::
	//+++++++++++++++++++++++++++
	function survey_feedback_get()
	{
		if(!$bus_id = $this->get('bus_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid bus_id';

			$this->response($o, 200);

		}

		if(!$survey_id = $this->get('survey_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid survey_id';

			$this->response($o, 200);

		}

		$this->load->model('api_model');
		$o = $this->api_model->survey_feedback($bus_id, $survey_id);

		$this->response($o, 200);
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//END OF DOCUMENT !!!!
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
