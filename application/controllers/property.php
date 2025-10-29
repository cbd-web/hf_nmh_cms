<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Property extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Property()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('property_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//GET SUBURB SELECT
	//++++++++++++++++++++++++++

	public function get_suburb_select($loc)
	{

		$sub_data = $this->property_model->get_suburb_list($loc);

		$this->output
			->set_content_type('application/json')
			->set_output($sub_data);


	}


	//+++++++++++++++++++++++++++
	//GET TYPE SELECT
	//++++++++++++++++++++++++++

	public function get_sub_select($sub_id)
	{
		if($this->session->userdata('admin_id')){

			$sub_sub_data = $this->property_model->get_category_select(3408,$sub_id);

			$data = json_decode($this->property_model->get_myna_categories(3408,$sub_id));

			$i=1;
			foreach($data->categories as $sel) {

				$sub_sub_id = $sel->cat_id;

			if($i==1) { break; }
			$i++;
			}

			$sub_sub_sub_data = $this->property_model->get_category_select(3408,$sub_id,$sub_sub_id);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('sub_sub_data' => $sub_sub_data, 'sub_sub_sub_data' => $sub_sub_sub_data)));


		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//GET TYPE SELECT
	//++++++++++++++++++++++++++

	public function get_sub_sub_select($sub_id,$sub_sub_id)
	{
		if($this->session->userdata('admin_id')){

			$sub_sub_sub_data = $this->property_model->get_category_select(3408,$sub_id,$sub_sub_id);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array('sub_sub_sub_data' => $sub_sub_sub_data)));

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//ADD PROPERTY AGENT
	//++++++++++++++++++++++++++

	public function add_property_agent()
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->add_property_agent();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD AGENTS ALL
	//++++++++++++++++++++++++++

	public function load_property_agents($prop_id)
	{
		$this->property_model->get_property_agents($prop_id);
	}



	//+++++++++++++++++++++++++++
	//DELETE PROPERTY AGENT
	//++++++++++++++++++++++++++

	public function delete_property_agent($id)
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->delete_property_agent($id);

		}else{

			$this->load->view('admin/login');

		}

	}





	//+++++++++++++++++++++++++++
	//PROPERTY FEATURES
	//++++++++++++++++++++++++++

	public function features()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/properties/features');

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

			$this->property_model->add_feature();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD PROPERTY FEATURE
	//++++++++++++++++++++++++++

	public function add_property_feature()
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->add_property_feature();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD FEATURES ALL
	//++++++++++++++++++++++++++

	public function load_property_features($prop_id)
	{
		$this->property_model->get_property_features($prop_id);
	}


	//+++++++++++++++++++++++++++
	//DELETE FEATURE
	//++++++++++++++++++++++++++

	public function delete_feature($id)
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->delete_feature($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE PROPERTY FEATURE
	//++++++++++++++++++++++++++

	public function delete_property_feature($id)
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->delete_property_feature($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//RELOAD FEATURES ALL
	//++++++++++++++++++++++++++

	public function reload_features_all()
	{
		$this->property_model->get_all_features();

	}






	//+++++++++++++++++++++++++++
	//PROPERTIES
	//++++++++++++++++++++++++++

	public function properties()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/properties/properties');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD PROPERTY
	//++++++++++++++++++++++++++

	public function add_property()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/properties/add_property');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD PROPERTY DO
	//++++++++++++++++++++++++++

	public function add_property_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->property_model->add_property_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	//+++++++++++++++++++++++++++
	//ADD LOCATION DO
	//++++++++++++++++++++++++++

	public function add_location_do()
	{
		if($this->session->userdata('admin_id')){

			$this->property_model->add_location_do();

		}else{

			$this->load->view('admin/login');

		}

	}
	
	//+++++++++++++++++++++++++++
	//DELETE PROPERTY DO
	//++++++++++++++++++++++++++

	public function delete_property($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->property_model->delete_property($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		

	
	//+++++++++++++++++++++++++++
	//UPDATE PROPERTY DO
	//++++++++++++++++++++++++++

	public function update_property_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->property_model->update_property_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}					

	 //+++++++++++++++++++++++++++
	 //UPDATE PROPERTY
	 //++++++++++++++++++++++++++
	
	 public function update_property($prop_id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $data = $this->property_model->get_property($prop_id);
			   $this->load->view('admin/properties/update_property', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	  
	  
	 }



	//+++++++++++++++++++++++++++
	//load_documents
	//++++++++++++++++++++++++++

	public function get_all_documents($pid)
	{

		$this->property_model->get_all_documents($pid);


	}
	//+++++++++++++++++++++++++++
	//delete document
	//++++++++++++++++++++++++++

	public function delete_document($doc_id, $type)
	{

		$this->db->where('doc_id', $doc_id);
		$query = $this->db->get('property_documents');


		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/documents/' . $row['doc_file']; # build the full path

			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('doc_id', $doc_id);
			$this->db->delete('property_documents');
			$this->session->set_flashdata('msg','Document removed successfully');

		}

	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);



		$query = $this->db->get('property_documents');



		if($query->result()){

			$row = $query->row_array();

			if($row['doc_type'] == 'booklet') { $booklet_sel = 'selected'; } else { $booklet_sel = ''; }
			if($row['doc_type'] == 'brochure') { $brochure_sel = 'selected'; } else { $brochure_sel = ''; }
			if($row['doc_type'] == 'option_sheet') { $os_sel = 'selected'; } else { $os_sel = ''; }
			if($row['doc_type'] == 'none') { $none_sel = 'selected'; } else { $none_sel = ''; }

			echo '<div class="row-fluid">
					<form id="document-update" name="document-update" method="post" action="'. site_url('/').'property/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="update_doc_id" value="'.$doc_id.'" />
						<input type="hidden" id="doc_type" name="doc_type" value="'.$type.'" />
                        <div class="control-group">
                              <label class="control-label" for="doc_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_title" name="doc_title" placeholder="Document title eg: Appendix A" value="'.$row['title'].'">
                              </div>
                        </div>

									 <div class="control-group">
										 <label class="control-label">Property Status</label>
										 <div class="controls">
											 <select name="doc_type">
												 <option value="booklet" '.$booklet_sel.'>Booklet</option>
												 <option value="brochure" '.$brochure_sel.'>Brochure</option>
												 <option value="option_sheet" '.$os_sel.'>Option Sheet</option>
												 <option value="none" '.$none_sel.'>None</option>
											 </select>
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
							url: "'. site_url("/").'property/update_document_do/'.rand(0,99999).'",
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
		$this->db->update('property_documents', $data);


	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$this->property_model->update_document_do();

	}



	//+++++++++++++++++++++++++++
	//upload property docs
	//++++++++++++++++++++++++++

	function plupload_server($document)
	{
		//Document is for distinguisj=hing between projects and normal documents
		$this->property_model->plupload_server($document);

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