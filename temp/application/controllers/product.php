<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Product()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('product_model');
		$this->load->model('branch_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//PRODUCT FEATURES
	//++++++++++++++++++++++++++

	public function stock_products()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/new_products/stock_products');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD STOCK PRODUCT
	//++++++++++++++++++++++++++

	public function add_stock_product()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/new_products/add_stock_product');

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD PRODUCT DO
	//++++++++++++++++++++++++++

	public function add_stock_product_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->add_stock_product_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE STOCK PRODUCT DO
	//++++++++++++++++++++++++++

	public function update_stock_product_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->update_stock_product_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update stock product
	//++++++++++++++++++++++++++

	public function update_stock_product($stock_id)
	{
		if($this->session->userdata('admin_id')){

			$product = $this->product_model->get_stock_product($stock_id);
			$this->load->view('admin/new_products/update_stock_product', $product);

		}else{

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//DELETE STOCK PRODUCT DO
	//++++++++++++++++++++++++++

	public function delete_stock_product($id)
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->delete_stock_product($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//load_documents
	//++++++++++++++++++++++++++

	public function get_all_documents($pid)
	{

		$this->product_model->get_all_documents($pid);


	}
	//+++++++++++++++++++++++++++
	//delete document
	//++++++++++++++++++++++++++

	public function delete_document($doc_id, $type)
	{

		$this->db->where('doc_id', $doc_id);
		$query = $this->db->get('product_documents');


		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/documents/' . $row['doc_file']; # build the full path

			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('doc_id', $doc_id);
			$this->db->delete('product_documents');
			$this->session->set_flashdata('msg','Document removed successfully');

		}

	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);



		$query = $this->db->get('product_documents');



		if($query->result()){

			$row = $query->row_array();


			echo '<div class="row-fluid">
					<form id="document-update" name="document-update" method="post" action="'. site_url('/').'product/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="update_doc_id" value="'.$doc_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="doc_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_title" name="doc_title" placeholder="Document title eg: Appendix A" value="'.$row['title'].'">
                              </div>
                        </div>


                        <div class="control-group">
                              <label class="control-label" for="doc_name">Name</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_name" name="doc_name" placeholder="Document name" value="'.$row['description'].'">
                              </div>
                        </div>

						<input type="submit" id="update_doc_but" value="Update Document" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					$("#update_doc_but").click(function(e){

						  e.preventDefault();

						  var frm = $("#document-update");

						  $.ajax({
							cache: false,
							url: "'. site_url("/").'product/update_document_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {

							  load_documents();
							  $("#modal-doc-update").modal("hide");

							}
						  });

					});



				$("div.download button").live("click", function(){

					$("#download").attr("value", $(this).html());
				});
				</script>

				';

		}

	}
	//+++++++++++++++++++++++++++
	//update Doc sequence
	//++++++++++++++++++++++++++

	public function update_doc_sequence($doc_id , $sequence)
	{

		$data['sequence'] = $sequence;
		$this->db->where('doc_id' , $doc_id);
		$this->db->update('product_documents', $data);


	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$this->product_model->update_document_do();

	}



	//+++++++++++++++++++++++++++
	//upload property docs
	//++++++++++++++++++++++++++

	function plupload_server($document)
	{
		//Document is for distinguisj=hing between projects and normal documents
		$this->product_model->plupload_server($document);

	}




	//+++++++++++++++++++++++++++
	//PRODUCT EXTRAS
	//++++++++++++++++++++++++++

	public function extras()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/new_products/extras');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD EXTRA PAGE
	//++++++++++++++++++++++++++

	public function add_extra()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/new_products/add_extra');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE EXTRA PAGE
	//++++++++++++++++++++++++++

	public function update_extra($extra_id)
	{
		if($this->session->userdata('admin_id')){

			$extra = $this->product_model->get_extra($extra_id);
			$this->load->view('admin/new_products/update_extra', $extra);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE EXTRA
	//++++++++++++++++++++++++++

	public function delete_extra($id)
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->delete_extra($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//ADD EXTRA DO
	//++++++++++++++++++++++++++

	public function add_extra_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->add_extra_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD EXTRA DO
	//++++++++++++++++++++++++++

	public function update_extra_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->update_extra_do();

		}else{

			$this->load->view('admin/login');

		}

	}







	//+++++++++++++++++++++++++++
	//PRODUCT FEATURES
	//++++++++++++++++++++++++++

	public function features()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/new_products/features');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD FEATURE
	//++++++++++++++++++++++++++

	public function add_feature()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->add_feature();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD PRODUCT FEATURE
	//++++++++++++++++++++++++++

	public function add_product_feature()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->add_product_feature();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD FEATURES ALL
	//++++++++++++++++++++++++++

	public function load_product_features($product_id)
	{
		$this->product_model->get_product_features($product_id);
	}


	//+++++++++++++++++++++++++++
	//DELETE FEATURE
	//++++++++++++++++++++++++++

	public function delete_feature($id)
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->delete_feature($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE FEATURE
	//++++++++++++++++++++++++++

	public function delete_product_feature($id)
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->delete_product_feature($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//RELOAD FEATURES ALL
	//++++++++++++++++++++++++++

	public function reload_features_all()
	{
		$this->product_model->get_all_features();

	}






	//+++++++++++++++++++++++++++
	//PRODUCTS
	//++++++++++++++++++++++++++

	public function products()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/new_products/products');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD PRODUCT
	//++++++++++++++++++++++++++

	public function add_product()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/new_products/add_product');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD PRODUCT DO
	//++++++++++++++++++++++++++

	public function add_product_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->add_product_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//DELETE PRODUCT DO
	//++++++++++++++++++++++++++

	public function delete_product($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->delete_product($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		

	public function import_product_csv() {

		if($this->session->userdata('admin_id')){

			$this->product_model->import_product_csv();
			
		}else{
			
			$this->load->view('admin/login');
			
		}		
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE PRODUCT DO
	//++++++++++++++++++++++++++

	public function update_product_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->update_product_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}					

	 //+++++++++++++++++++++++++++
	 //update product
	 //++++++++++++++++++++++++++

	 public function update_product($product_id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $product = $this->product_model->get_product($product_id);
			   $this->load->view('admin/new_products/update_product', $product);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	  
	  
	 }

	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/new_products/categories');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//ADD CATEGORY
	//++++++++++++++++++++++++++

	public function add_category()
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->add_category();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY DO
	//++++++++++++++++++++++++++

	public function update_category_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->update_category_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update category
	//++++++++++++++++++++++++++

	public function update_category($category_id)
	{
		if($this->session->userdata('admin_id')){

			$category = $this->product_model->get_category($category_id);
			$this->load->view('admin/new_products/update_category', $category);

		}else{

			$this->load->view('admin/login');

		}


	}

	
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->delete_category($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->product_model->get_all_categories();
		
	}
	
	//+++++++++++++++++++++++++++
	//RELOAD PARENTS ALL
	//++++++++++++++++++++++++++

	public function reload_parent_all()
	{
		$this->product_model->get_category_list();
		
	}
	
	
	//+++++++++++++++++++++++++++
	//MANUFACTURERS
	//++++++++++++++++++++++++++

	public function manufacturers()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/new_products/manufacturers');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//ADD MANUFACTURER
	//++++++++++++++++++++++++++

	public function add_manufacturer()
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->add_manufacturer();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE MANUFACTURER DO
	//++++++++++++++++++++++++++

	public function update_manufacturer_do()
	{
		if($this->session->userdata('admin_id')){

			$this->product_model->update_manufacturer_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update manufacturer
	//++++++++++++++++++++++++++

	public function update_manufacturer($manufacturer_id)
	{
		if($this->session->userdata('admin_id')){

			$manufacturer = $this->product_model->get_manufacturer($manufacturer_id);
			$this->load->view('admin/new_products/update_manufacturer', $manufacturer);

		}else{

			$this->load->view('admin/login');

		}


	}
	
	//+++++++++++++++++++++++++++
	//DELETE MANUFACTURER
	//++++++++++++++++++++++++++

	public function delete_manufacturer($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->delete_manufacturer($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD MANUFACTURERS ALL
	//++++++++++++++++++++++++++

	public function reload_manufacturer_all()
	{
		$this->product_model->get_all_manufacturers();
		
	}	
	
	//+++++++++++++++++++++++++++
	//update Manufacturer sequence
	//++++++++++++++++++++++++++

	public function update_manufacturer_sequence($man_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('manufacturer_id' , $man_id);
			$this->db->update('product_manufacturer', $data);

		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//PRODUCT TYPES
	//++++++++++++++++++++++++++

	public function product_types()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/new_products/product_types');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//ADD PRODUCT TYPE
	//++++++++++++++++++++++++++

	public function add_product_type()
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->add_product_type();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE PRODUCT TYPE
	//++++++++++++++++++++++++++

	public function delete_product_type($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->product_model->delete_product_type($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD PRODUCT TYPES ALL
	//++++++++++++++++++++++++++

	public function reload_product_types_all()
	{
		$this->product_model->get_all_product_types();
		
	}	
	
	//+++++++++++++++++++++++++++
	//update PRODUCT TYPE sequence
	//++++++++++++++++++++++++++

	public function update_product_type_sequence($typ_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('type_id' , $typ_id);
			$this->db->update('product_types', $data);

		
	}


	//+++++++++++++++++++++++++++
	//GET CATEGORIES MY>NA
	//++++++++++++++++++++++++++

	public function get_myna_categories($main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0)
	{
		$qstr = '';
		//MAIN CAT
		if($main_cat_id != 0)
		{
			$qstr .= '?main_cat_id='.$main_cat_id;
		}
		//SUB CAT
		if($sub_cat_id != 0)
		{
			$qstr .= '&sub_cat_id='.$sub_cat_id;
		}
		//MAIN CAT
		if($sub_sub_cat_id != 0 )
		{
			$qstr .= '&sub_sub_cat_id='.$sub_sub_cat_id;
		}
		//MAIN CAT
		if($sub_sub_sub_cat_id != 0)
		{
			$qstr .= '&sub_sub_sub_cat_id='.$sub_sub_sub_cat_id;
		}

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('product_cats_'.$main_cat_id.'_'.$sub_cat_id.'_'.$sub_sub_cat_id.'_'.$sub_sub_sub_cat_id))
		{
			$o = file_get_contents(NA_SITE_URL . 'products_api/categories/' . $qstr);
			$this->cache->save('product_cats_'.$main_cat_id.'_'.$sub_cat_id.'_'.$sub_sub_cat_id.'_'.$sub_sub_sub_cat_id, $o, 8000000);
		}
		
		var_dump(json_decode($o));

	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS NAME
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $replace=array(), $delimiter='-' , $type) {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		
		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);
		
		if($res->result()){
			
			$clean = $clean .'-'.rand(0,99);
			return $clean;
			
		}else{
			
			return $clean;
		}
		
		
	}
	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */