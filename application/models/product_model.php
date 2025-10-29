<?php
class Product_model extends CI_Model{
	
 	function product_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++

	function get_stock_product($stock_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('stock_id', $stock_id);
		$test = $this->db->get('product_stock');
		return $test->row_array();

	}



	//+++++++++++++++++++++++++++
	//GET PRODUCT LIST
	//++++++++++++++++++++++++++
	public function get_product_list($product_id='')
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('products');


		if($query->result()){

			foreach($query->result() as $row){

				if($row->product_id == $product_id) { $selected = 'selected'; } else { $selected = ''; }

				echo '<option value="'.$row->product_id.'" '.$selected.'>'.$row->title.'</option>';
			}

		}



	}


	//+++++++++++++++++++++++++++
	//ADD STOCK PRODUCT DO
	//++++++++++++++++++++++++++
	function add_stock_product_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$price = $this->input->post('price', TRUE);
		$product_id = $this->input->post('product_id', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		//$id = $this->input->post('page_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		//get_category_id
		$query = $this->db->where('product_id', $product_id);
		$query = $this->db->get('products');

		if($query->result()){

			$row = $query->row();

			$cat_id = $row->category;

		} else {

			$cat_id = 0;

		}

		if($slug == ''){

			$slug = $this->clean_url_str($title);

		}else{

			$slug = $this->clean_url_str($slug);

		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Product title Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'product_id'=> $product_id ,
			'category_id'=> $cat_id ,
			'price'=> $price ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$this->db->insert('product_stock', $insertdata);
			$productid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_stock_product-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Stock Product added successfully');
			$data['basicmsg'] = 'Stock Product has been added successfully';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'product/update_stock_product/'.$productid.'/";
					</script>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE PRODUCT
	//++++++++++++++++++++++++++
	function update_stock_product_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$status = $this->input->post('status', TRUE);
		$product_id = $this->input->post('product_id', TRUE);
		$price = $this->input->post('price', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('stock_id', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		//get_category_id
		$query = $this->db->where('product_id', $product_id);
		$query = $this->db->get('products');

		if($query->result()){

			$row = $query->row();

			$cat_id = $row->category;

		} else {

			$cat_id = 0;

		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Product title Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'product_id'=> $product_id ,
			'category_id'=> $cat_id ,
			'body'=> $body ,
			'price'=> $price ,
			'slug'=> $slug,
			'status'=> strtolower($status),
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('stock_id' , $id);
			$this->db->update('product_stock', $insertdata);
			//success redirect
			$data['stock_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_stock_product-'. $id);
			$data['basicmsg'] = 'Stock Product has been updated successfully'.strtolower($status);
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//DELETE STOCK PRODUCT
	function delete_stock_product($stock_id){

		if($this->session->userdata('admin_id')){


			//delete from database
			$test = $this->db->where('stock_id', $stock_id);
			$this->db->delete('product_stock');
			//LOG
			$this->admin_model->system_log('delete_stock_product-'.$stock_id);
			$this->session->set_flashdata('msg','Stock Product deleted successfully');


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}



	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS Chunked
	//++++++++++++++++++++++++++

	public function plupload_server($document)
	{

		if($document == 'sliders'){

			$targetDir = BASE_URL.'assets/images/';

		}elseif($document == 'documents'){

			$targetDir = BASE_URL.'assets/documents/';

		}elseif($document == 'project_docs'){

			$targetDir = BASE_URL.'assets/documents/';

		}else{
			$targetDir = BASE_URL.'assets/documents/';
		}



		//$cleanupTargetDir = false; // Remove old files
		//$maxFileAge = 60 * 60; // Temp file age in seconds

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		$product_id = $_REQUEST['product_id'];
		$oname = $_FILES['file']['name'];
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName))
		{
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;

		}

		// Create target dir
		if (!file_exists($targetDir)){
			@mkdir($targetDir);
		}
		if (isset($_SERVER["HTTP_CONTENT_TYPE"])){
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		}
		if (isset($_SERVER["CONTENT_TYPE"])){
			$contentType = $_SERVER["CONTENT_TYPE"];
		}
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false)
		{
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out)
				{
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);

				}
				else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}
			else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		}
		else
		{
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out)
			{
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			}
			else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if ($chunk < 1 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			//Insert DB
			$this->insert_property_docs($product_id, $fileName, $oname , $document);
		}
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : "'.$fileName.'", "id" : '.$product_id.', "oname" : "'.$oname.'"}');

	}

	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS INSERT DB
	//++++++++++++++++++++++++++

	function insert_property_docs($product_id, $file,  $oname, $document)
	{
		$bus_id = $this->session->userdata('bus_id');

		//GET DOcumnet sequence
		$this->db->where('product_id' ,$product_id);
		$query = $this->db->get('product_documents');
		if($query->result()){

			$seq = 'Appendix '. $query->num_rows();

		}else{

			$seq = 'Appendix 1';

		}
		//populate array with values
		$data = array(
			'product_id' => $product_id,
			'doc_file'=> $file,
			'title' => $oname,
			'bus_id' => $bus_id,
			'sequence' => $seq

		);
		//insert into database
		$this->db->insert('product_documents',$data);



	}


	//+++++++++++++++++++++++++++
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$title = $this->input->post('doc_title', TRUE);
		$name = $this->input->post('doc_name', TRUE);
		$id = $this->input->post('update_doc_id', TRUE);

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Document title Required';

		}elseif($name == ''){
			$val = FALSE;
			$error = 'Documant Name Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'description'=> $name

		);



		if($val == TRUE){

			$this->db->where('doc_id' , $id);
			$this->db->update('product_documents', $insertdata);


			//LOG
			$this->admin_model->system_log('update_product_document-'. $id);
			$data['basicmsg'] = 'Document has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}

	}

	//+++++++++++++++++++++++++++
	//GET ALL DOCUMENTS
	//++++++++++++++++++++++++++
	public function get_all_documents($pid)
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('product_id', $pid);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('product_documents');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">

				<tbody>';

			foreach($query->result() as $row){

				//$link = base_url('/').'assets/documents/'.$row->doc_file;

				$ext = substr($row->title, strpos($row->title, '.'), strlen($row->title));

				if($ext == '.doc' || $ext == '.docx'){

					$icon = '<img src="'.base_url('/').'admin_src/img/doc_icon.png" >';

				}elseif($ext == '.pdf'){

					$icon = '<img src="'.base_url('/').'admin_src/img/pdf_icon.png" >';

				}elseif($ext == '.xls' || $ext == '.xlsx'){

					$icon = '<img src="'.base_url('/').'admin_src/img/xls_icon.png" >';

				}elseif(strtolower($ext) == '.jpg' || strtolower($ext) == '.png' ||  strtolower($ext) == '.gif'){

					$icon = '<img src="'.base_url('/').'admin_src/img/img_icon.png" >';
				}

				echo '<tr>
						<td style="width:5%"><input name="doc_files[]" type="checkbox" value="'.$row->doc_id.'" id="ts"></td>
						<td style="width:5%">'.$icon.'</td>
						<td style="width:30%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></td>

            			<td style="width:15%;text-align:right">
						<a title="Edit document" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						onclick="update_document('.$row->doc_id.')"><i class="icon-pencil"></i></a>
						<a title="Delete Document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_document('.$row->doc_id.')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';

		}else{

			echo '<div class="alert"><h3>No Documents added</h3> No documents have been added. Add one by using the tool on the right</div>';
		}


	}



	//+++++++++++++++++++++++++++
	//GET ALL EXTRAS
	//++++++++++++++++++++++++++
	public function get_all_extras()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('product_extras');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:40%;font-weight:normal">Title </th>
           				<th style="width:40%;font-weight:normal">Price </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">N$ '.$row->price.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit Extra" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'product/update_extra/'.$row->extra_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete Extra" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_extra('.$row->extra_id.')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';

		}else{

			echo '<div class="alert"><h3>No Extras added</h3> No extras have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++++++++++++++
	//ADD EXTRA DO
	//++++++++++++++++++++++++++
	function add_extra_do()
	{
		$title = $this->input->post('title', TRUE);
		$price = $this->input->post('price', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);



		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Extra title Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'price'=> $price ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$this->db->insert('product_extras', $insertdata);
			$extraid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_product_extra-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Productb Extra added successfully');
			$data['basicmsg'] = 'Product Extra has been added successfully';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'product/update_extra/'.$extraid.'/";
					</script>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE EXTRA DO
	//++++++++++++++++++++++++++
	function update_extra_do()
	{
		$title = $this->input->post('title', TRUE);
		$price = $this->input->post('price', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('extra_id', TRUE);

		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Extra title Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'price'=> $price ,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$this->db->where('extra_id' , $id);
			$this->db->update('product_extras', $insertdata);
			//success redirect
			$data['extra_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_product_extra-'. $id);
			$data['basicmsg'] = 'Product Extra has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//DELETE Extra
	function delete_extra($extra_id){

		if($this->session->userdata('admin_id')){


			//delete from database
			$test = $this->db->where('extra_id', $extra_id);
			$this->db->delete('product_extras');
			//LOG
			$this->admin_model->system_log('delete_product_extra-'.$extra_id);
			$this->session->set_flashdata('msg','Product Extra deleted successfully');


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}




	//+++++++++++++++++++++++++++
	//GET EXTRA DETAILS
	//++++++++++++++++++++++++++

	function get_extra($extra_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('extra_id', $extra_id);
		$test = $this->db->get('product_extras');
		return $test->row_array();

	}





	//+++++++++++++++++++++++++++
	//GET MANUFACTURER DETAILS
	//++++++++++++++++++++++++++

	function get_manufacturer($manufacturer_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('manufacturer_id', $manufacturer_id);
		$test = $this->db->get('product_manufacturer');
		return $test->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET CATEGORY DETAILS
	//++++++++++++++++++++++++++

	function get_category($category_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('cat_id', $category_id);
		$test = $this->db->get('product_cats');
		return $test->row_array();

	}


	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_product($product_id){
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $test = $this->db->where('bus_id', $bus_id);	
		  $test = $this->db->where('product_id', $product_id);
		  $test = $this->db->get('products');
		  return $test->row_array(); 
	
	 }
	 
	 
	//DELETE PRODUCT
	function delete_product($product_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('product_id', $product_id);
			  $this->db->delete('products');
			  //LOG
			  $this->admin_model->system_log('delete_product-'.$product_id);
			  $this->session->set_flashdata('msg','Product deleted successfully');
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	 

	 //+++++++++++++++++++++++++++
	 //GET NEXT PRODUCT ID
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product_id($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id > '".$product_id."' ORDER BY product_id ASC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
			  return $row->pid;
				 			  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   return $row2->minpid; 			 
			   
		  }
	
	 }
	 



	 
	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id > '".$product_id."' ORDER BY product_id ASC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'product/update_product/'.$row->pid.'" class="btn btn-inverse btn">View Next Product</a>';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'product/update_product/'.$row2->minpid.'" class="btn btn-inverse btn">View Next Product</a>'; 			 
			 
			  
		  }
	
	 }
	 
	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_prev_product($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id < '".$product_id."' ORDER BY product_id DESC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'product/update_product/'.$row->pid.'" class="btn btn-inverse btn">View Prev Product</a>&nbsp;';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'product/update_product/'.$row2->maxpid.'" class="btn btn-inverse btn">View Prev Product</a>&nbsp;'; 			 
			 
			  
		  }
	
	 }		 
	 
	//+++++++++++++++++++++++++++
	//GET ALL PRODUCT MANUFACTURERS
	//++++++++++++++++++++++++++
	public function get_all_product_manufacturers($mid)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_manufacturer');
		  if($query->result()){
			
			foreach($query->result() as $row){
				
				if($mid == '') {
				
				echo '<option value="'.$row->slug.'">'.$row->manufacturer.'</option>';
				
				} else {
				
				if($mid == $row->slug) { $selected = 'selected="selected"'; } else { $selected = ''; }
				
				echo '<option value="'.$row->slug.'" '.$selected.'>'.$row->manufacturer.'</option>';	
					
				}
			}
			  
		}
	}	 




	 //+++++++++++++++++++++++++++
	//UPDATE PRODUCT
	//++++++++++++++++++++++++++	
	function update_product_do() 
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$special = $this->input->post('special', TRUE);
			$featured = $this->input->post('featured', TRUE);
			$top_seller = $this->input->post('top_seller', TRUE);
			$custom = $this->input->post('custom', TRUE);
			$new = $this->input->post('new', TRUE);
			$status = $this->input->post('status', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$category = $this->input->post('category', TRUE);
			$manufacturer = $this->input->post('manufacturer', TRUE);
			$url_link = $this->input->post('url_link', TRUE);			
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('product_id', TRUE);
			
			$product_type = $this->input->post('product_type', TRUE);
			
			$pubdate = $this->input->post('pub_date', TRUE);
			$bus_id = $this->session->userdata('bus_id');
	
			$input = trim($url_link, '/');
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}
			
			$branch = array();

			$cat_array = $this->cat_array($category, $branch);
			
			$cats = json_encode($cat_array);	
			
			if($special == 'Y') { $special = $special; } else { $special = 'N'; }		
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'title'=> $title ,
					  'heading'=> $heading ,
					  'sku_code'=> $sku ,
					  'category'=> $category ,
					  'category_array'=> $cats,
					  'product_type'=> $product_type ,
					  'manufacturer'=> $manufacturer ,
					  'description'=> $body ,
					  'start_price'=> $start_price ,
					  'sale_price'=> $sale_price ,
					  'special'=> $special,
					  'featured'=> $featured,
					  'top_seller'=> $top_seller,
					  'custom'=> $custom,
					  'new'=> $new,
					  'url_link'=> $url_link ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'listing_date'=> date('Y-m-d h:i:s',strtotime($pubdate)),
					  'slug'=> $slug,
					  'status'=> strtolower($status),
					  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('product_id' , $id);
					$this->db->update('products', $insertdata);
					//success redirect	
					$data['product_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_product-'. $id);
					$data['basicmsg'] = 'Product has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}



	//+++++++++++++++++++++++++++
	//ADD PRODUCT DO
	//++++++++++++++++++++++++++	
	function add_product_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$category = $this->input->post('category', TRUE);
			$url_link = $this->input->post('url_link', TRUE);
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');

			$input = trim($url_link, '/');
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}

		
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//$cat_array = array();
			//Get category array
			
			$branch = array();

			$cat_array = $this->cat_array($category, $branch);
			
			$cats = json_encode($cat_array);
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
//							
			}else{
				$val = TRUE;
			}
			
			$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'sku_code'=> $sku ,
								  'category'=> $category ,
								  'category_array'=> $cats ,
								  'description'=> $body ,
								  'start_price'=> $start_price ,
								  'sale_price'=> $sale_price ,
								  'url_link'=> $url_link ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug,
								  'bus_id'=>$bus_id
					);
	
			
			if($val == TRUE){
				
					$this->db->insert('products', $insertdata);
					$productid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_product-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Product added successfully');
					$data['basicmsg'] = 'Product has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'product/update_product/'.$productid.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	
	public function cat_array($id, $branch)
	{
		if($id != 0) {
			
	   		$bus_id = $this->session->userdata('bus_id');
		
			$query = $this->db->where('cat_id', $id);
	    	$query = $this->db->where('bus_id', $bus_id);
	   	 	$query = $this->db->get('product_cats');	
		
			$row = $query->row();
			
			array_push($branch, $row->cat_id);
			
			return $this->cat_array($row->parent_id, $branch);			
				
		} else {
			
			return $branch;
		
		}

	}

	//+++++++++++++++++++++++++++
	//GET ALL PRODUCTS
	//++++++++++++++++++++++++++
	public function get_all_products()
	{
		  $bus_id = $this->session->userdata('bus_id');
/*		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'ASC');
		  $query = $this->db->get('products');*/
		  
		  $query = $this->db->query("SELECT * FROM products AS A
		  							 LEFT JOIN product_cats AS B on A.category = B.cat_id
									 LEFT JOIN product_types AS C on A.product_type = C.type_id
									 WHERE A.bus_id = '".$bus_id."' ORDER BY A.listing_date ASC
									");
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:15%;font-weight:normal">Type </th>
						<th style="width:15%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal">Manufacturer </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}


				if($bus_id == '10591') {
					$type = '';
					$val = '';
					$prod_type = array();

					if($row->featured == 'Y'){
						$val = 'Featured';
						array_push($prod_type, $val);
					}

					if($row->top_seller == 'Y'){
						$val = 'Top Seller';
						array_push($prod_type, $val);
					}

					if($row->new == 'Y'){
						$val = 'New Arrival';
						array_push($prod_type, $val);
					}

					if($row->custom == 'Y'){
						$val = 'Custom Made';
						array_push($prod_type, $val);
					}

					if(!empty($prod_type)) {

						$lastElement = end($prod_type);

						foreach ($prod_type as $item) {

							if($item == $lastElement) {

								$type .= $item;

							} else {

								$type .= $item.', ';

							}

						}

					}

				} else {

					$type = $row->type_name;

				}



				echo '<tr id="row-'.$row->product_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'product/update_product/'.$row->product_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:15%">'.$type.'</td>
						<td style="width:15%">'.$row->cat_name.'</td>
						<td style="width:15%">'.$row->manufacturer.'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit product" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'product/update_product/'.$row->product_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Product" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_product('.$row->product_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';

				unset($test); 
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Products added</h3>
					No products have been added. to add a new product please click on the add product button on the right</div>';
		  
		 }
				
		
	}


	//+++++++++++++++++++++++++++
	//GET ALL PRODUCTS
	//++++++++++++++++++++++++++
	public function get_all_stock_products()
	{
		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->query("SELECT * FROM product_stock AS A WHERE A.bus_id = '".$bus_id."' ORDER BY A.listing_date ASC");

		if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->stock_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer"
						href="'.site_url('/').'product/update_stock_product/'.$row->stock_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit product" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'product/update_stock_product/'.$row->stock_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Stock Product" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_stock_product('.$row->stock_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';

		}else{

			echo '<div class="alert">
			 		<h3>No Stock Products added</h3>
					No stock products have been added. to add a new product please click on the add stock product button on the right</div>';

		}


	}





	//+++++++++++++++++++++++++++
	//GET CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_category_list()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_cats');
		  
		  echo '
		  <select class="span10" name="parent">
		  <option value="0">Choose Category Parent</option>
		  <option value="0">None</option>';		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){				
				echo '<option value="'.$row->cat_id.'">'.$row->cat_name.'</option>';
			}

		  }
		 
		  echo '</select>';
		
	}
	
	//+++++++++++++++++++++++++++
	//GET PRODUCTS CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_product_category_list($cat_id=0)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_cats');
		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){	
			
			
			if($cat_id == $row->cat_id) { $selected = "selected"; }	else { 	$selected = ""; }

				//get_parent
				$query2 = $this->db->select('cat_name');
				$query2 = $this->db->where('cat_id', $row->parent_id);
				$query2 = $this->db->get('product_cats');

				$row2 = $query2->row();

				if($row2->cat_name){
					$parent = $row2->cat_name . ' / ';
				}else{
					$parent = '';
				}

						
				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$parent.$row->cat_name.'</option>';
			}

		  }
		
	}


	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{
		
	    $bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('parent_id', $id);
	    $query = $this->db->where('bus_id', $bus_id);
	    $query = $this->db->get('product_cats');		
			
			foreach($query->result() as $row){		
				
				$this->delete_category($row->cat_id);
				
			}
			
			$this->db->where('cat_id', $id);
			$this->db->delete('product_cats');			

	}


	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++	
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');
		
			
		//INSERT INTO CATEGORIES
		$cat_name = $this->input->post('category_name');
		$parent = $this->input->post('parent');

		$slug = $this->clean_url_str($cat_name);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('parent_id', $parent);
		$this->db->where('cat_name', $cat_name);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('product_cats');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'cat_name'=> $cat_name ,
			  'cat_slug'=> $slug ,
			  'parent_id'=> $parent ,
			  'bus_id'=> $bus_id,
			);			
			
			$this->db->insert('product_cats', $insertdata);	
		}
		
		//GET NEW CAT ID
/*		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('categories');
		$row = $result->row_array();*/

		
	}


	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY
	//++++++++++++++++++++++++++
	function update_category_do()
	{
		$cat_name = $this->input->post('cat_name', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('cat_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if($cat_name == ''){
			$val = FALSE;
			$error = 'Category title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'cat_name'=> $cat_name ,
			'body'=> $body ,
			'cat_slug'=> $slug,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('cat_id' , $id);
			$this->db->update('product_cats', $insertdata);
			//success redirect
			$data['manufacturer_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_product_category-'. $id);
			$data['basicmsg'] = 'Category has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}




	//Get Main Categories Typehead
	function load_category_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->get('product_cats');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->cat_id;
			$cat = $row->cat_name;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	
	
	 //+++++++++++++++++++++++++++
	 //GET PARENT NAME
	 //++++++++++++++++++++++++++   
	   
	 function get_parent($parent_id){
		 
		  if($parent_id != 0) {
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->select('cat_name');	
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('cat_id', $parent_id);
		  $query = $this->db->get('product_cats');
		  
		  $row = $query->row();
		  
		  return $row->cat_name; 
		  
		  } else {
			
		  return 'none';	  
			  
		  }
	
	 }	
	
	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_cats');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
           				<th style="width:40%;font-weight:normal">Category </th>
						<th style="width:40%;font-weight:normal">Parent </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr>
						<td style="width:5%">'.$row->cat_id.'</td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->cat_name.'</div></td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$this->get_parent($row->parent_id).'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit category" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'product/update_category/'.$row->cat_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category('.$row->cat_id.')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
	
	//+++++++++++++++++++++++++++
	//GET ALL PRODUCT TYPES
	//++++++++++++++++++++++++++
	public function get_all_product_types_option($pid)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_types');
		  if($query->result()){


			foreach($query->result() as $row){
				
				if($pid == $row->type_id) { $selected = 'selected="selected"'; } else { $selected = ''; }		
				echo '<option value="'.$row->type_id.'" '.$selected.'>'.$row->type_name.'</option>';
				
			}
			
			
		 }else{
			 
		 }
	}
	
	
	
	//+++++++++++++++++++++++++++
	//GET ALL PRODUCT TYPES
	//++++++++++++++++++++++++++
	public function get_all_product_types()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_types');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Product Type </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr class="myDragClass">
					  <input type="hidden" value="'.$row->type_id.'" />
						<td style="width:6%">'.$row->type_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->type_name.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Product Type" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_product_type('.$row->type_id.')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var type_id = $(this).val(), index = i;
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'product/update_product_type_sequence/"+type_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Product Types added</h3> No product types have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
	
	//+++++++++++++++++++
	//DELETE PRODUCT TYPE
	//+++++++++++++++++++

	public function delete_product_type($id)
	{
		
	    $bus_id = $this->session->userdata('bus_id');
		
			
		$this->db->where('bus_id', $bus_id);
		$this->db->where('type_id', $id);
		$this->db->delete('product_types');			

	}


	//+++++++++++++++
	//ADD PRODUCT TYPE
	//+++++++++++++++	
	public function add_product_type()
	{
		$bus_id = $this->session->userdata('bus_id');
		
			
		//INSERT INTO CATEGORIES
		$type = $this->input->post('product_type');

		$slug = $this->clean_url_str($type);


		//TEST DUPLICATE
		$this->db->where('slug', $slug);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('product_types');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'type_name'=> $type ,
			  'slug'=> $slug ,
			  'bus_id'=> $bus_id,
			);			
			
			$this->db->insert('product_types', $insertdata);	
		}
			
	}	

	//Get Main Product Type Typehead
	function load_product_type_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->get('product_types');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->type_id;
			$cat = $row->type_name;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }


	//+++++++++++++++++++++++++++
	//GET PRODUCT FEATURES LIST
	//++++++++++++++++++++++++++
	public function get_feature_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('product_features');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->feature.'">'.$row->feature.'</option>';

			}
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_product_features($product_id)
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('product_id', $product_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('product_feature_int');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:40%;font-weight:normal">Feature </th>
						<th style="width:40%;font-weight:normal">Info </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->feature.'</div></td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->body.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Delete Feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feature('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';
		}else{

			echo '<div class="alert"><h3>No Features added</h3> No features have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++++++++++++++
	//GET ALL FEATURES
	//++++++++++++++++++++++++++
	public function get_all_features()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('product_features');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:65%;font-weight:normal">Feature </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->feature.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Delete Feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feature('.$row->feature_id.')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';

		}else{

			echo '<div class="alert"><h3>No Features added</h3> No features have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++
	//ADD FEATURE
	//+++++++++++++++
	public function add_feature()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO FEATURES
		$feature = $this->input->post('feature');

		$slug = $this->clean_url_str($feature);


		//TEST DUPLICATE
		$this->db->where('feature', $feature);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('product_features');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'feature'=> $feature ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('product_features', $insertdata);
		}

	}


	//+++++++++++++++
	//ADD FEATURE
	//+++++++++++++++
	public function add_product_feature()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO FEATURES
		$feature = $this->input->post('feature');
		$body = $this->input->post('body');
		$product_id = $this->input->post('product_id');

		if($feature != 'none'){

			$insertdata = array(
				'bus_id'=> $bus_id ,
				'product_id'=> $product_id ,
				'feature'=> $feature ,
				'body'=> $body ,
			);

			$this->db->insert('product_feature_int', $insertdata);
		}

	}



	//+++++++++++++++++++
	//DELETE FEATURE
	//+++++++++++++++++++

	public function delete_feature($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('feature_id', $id);
		$this->db->delete('product_features');

	}

	//+++++++++++++++++++
	//DELETE PRODUCT FEATURE
	//+++++++++++++++++++

	public function delete_product_feature($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('id', $id);
		$this->db->delete('product_feature_int');

	}



	//Get Main FEATURE Typehead
	function load_feature_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('product_features');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->feature_id;
			$cat = $row->feature;

			if($x == ($test->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$cat."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}







	//+++++++++++++++++++++++++++
	//GET ALL MANUFACTURERS
	//++++++++++++++++++++++++++
	public function get_all_manufacturers()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_manufacturer');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Manufacturer </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr class="myDragClass">
					  <input type="hidden" value="'.$row->manufacturer_id.'" />
						<td style="width:6%">'.$row->manufacturer_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->manufacturer.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit manufacturer" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'product/update_manufacturer/'.$row->manufacturer_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete Manufacturer" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_manufacturer('.$row->manufacturer_id.')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var manufacturer_id = $(this).val(), index = i;
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'product/update_manufacturer_sequence/"+manufacturer_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Manufacturers added</h3> No manufacturers have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
	
	//+++++++++++++++++++
	//DELETE MANUFACTURER
	//+++++++++++++++++++

	public function delete_manufacturer($id)
	{
		
	    $bus_id = $this->session->userdata('bus_id');
		
			
		$this->db->where('bus_id', $bus_id);
		$this->db->where('manufacturer_id', $id);
		$this->db->delete('product_manufacturer');			

	}


	//+++++++++++++++
	//ADD MANUFACTURER
	//+++++++++++++++	
	public function add_manufacturer()
	{
		$bus_id = $this->session->userdata('bus_id');
		
			
		//INSERT INTO CATEGORIES
		$manufacturer = $this->input->post('manufacturer');

		$slug = $this->clean_url_str($manufacturer);


		//TEST DUPLICATE
		$this->db->where('manufacturer', $manufacturer);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('product_manufacturer');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'manufacturer'=> $manufacturer ,
			  'slug'=> $slug ,
			  'bus_id'=> $bus_id,
			);			
			
			$this->db->insert('product_manufacturer', $insertdata);	
		}
			
	}


	//+++++++++++++++++++++++++++
	//UPDATE MANUFACTURER
	//++++++++++++++++++++++++++
	function update_manufacturer_do()
	{
		$manufacturer = $this->input->post('manufacturer', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$link = $this->input->post('link', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('manufacturer_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$input = trim($link, '/');

		if($link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$link = 'http://' . $input;
			}
		} else {

			$link = "";

		}

		$branch = array();


		//VALIDATE INPUT
		if($manufacturer == ''){
			$val = FALSE;
			$error = 'Manufacturer title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'manufacturer'=> $manufacturer ,
			'body'=> $body ,
			'link'=> $link ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('manufacturer_id' , $id);
			$this->db->update('product_manufacturer', $insertdata);
			//success redirect
			$data['manufacturer_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_manufacturer-'. $id);
			$data['basicmsg'] = 'Manufacturer has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}




	//Get Main Manufacturers Typehead
	function load_manufacturer_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->get('product_manufacturer');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->manufacturer_id;
			$cat = $row->manufacturer;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }		
	
	
			
	
    function import_product_csv() {
			
			$bus_id = $this->session->userdata('bus_id');
 			$csv = $this->input->post('csv', TRUE);
		
			//upload file
			$config['upload_path'] = BASE_URL.'assets/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
 
        	$this->load->library('upload', $config);
 
 
        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
 
            //$this->load->view('csvindex', $data);
			echo $data['error'];
        } else {
			
            $file_data = $this->upload->data();
			$file_path = BASE_URL .'assets/csv/'.$file_data['file_name'];
 			
			$this->load->library('csvimport');
			
            if ($this->csvimport->get_array($file_path)) {
				
                $csv_array = $this->csvimport->get_array($file_path);
				
                foreach ($csv_array as $row) {
					
					
					$slug = $this->clean_slug_str($row['title'], $replace=array(), $delimiter='-' , 'products');
											
                    $insert_data = array(
                        'bus_id'=>$bus_id,
                        'sku_code'=>$row['sku_code'],
						'category'=>$row['category'],
						'category_type'=>$row['category_type'],
                        'manufacturer'=>$row['manufacturer'],
                        'title'=>$row['title'],
						'slug'=>$slug,
						'sale_price'=>$row['sale_price'],
						'start_price'=>$row['start_price'],
                    );
                    $this->db->insert('products', $insert_data);
                }
				

            } else {

            }
 
        } 	
	
	}	
	

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
	 	
	
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


}
?>