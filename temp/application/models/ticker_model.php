<?php
class Ticker_model extends CI_Model{
	
 	function ticker_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
 	}
	

	//+++++++++++++++++++++++++++
	//GET ALL SIDEBARS
	//++++++++++++++++++++++++++
	public function get_all_tickers()
	{
	  	  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');	
		  $query = $this->db->get('news_ticker');
		  if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">ID</th>
						<th style="width:60%;font-weight:normal">Name </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass">
						<td style="width:10%">
						<input type="hidden" value="'.$row->ticker_id.'" />
						'.$row->ticker_id.'</td>
			
						<td style="width:60%">'.$row->title.'</td>
            			<td style="width:15%;text-align:right">
						<a title="Update Ticker" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_ticker('.$row->ticker_id.')"><i class="icon-pencil"></i></a>
						<a title="Delete Ticker" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_ticker('.$row->ticker_id.')">
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
									var ticker_id = $(this).val(), index = i;
									console.log(ticker_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'ticker/update_ticker_sequence/"+ticker_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No SNews Tickers added</h3> No tickers have been added. Add one by using the tool on the right</div>';  
		 }
			
			
		
	}
	
	//GET TICKER FOR EDIT
	function get_ticker($id){

		$this->db->where('ticker_id', $id);
		$query = $this->db->get('news_ticker');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				
				echo '<form id="ticker-update" name="ticker-update" method="post" action="'.site_url('/').'ticker/update_ticker _do" class="form-horizontal">
    						<input type="hidden" id="ticker_id_edit" name="ticker_id_edit" value="'.$row['ticker_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Ticker Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
							 </div>

						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
								  <label class="control-label" for="link_edit">Link</label>
								<div class="controls">
								   <input type="text" id="link_edit" name="link_edit" value="'.$row['link'].'">                    
								</div>
							 </div>							
							<div class="control-group">
                				<h5>Body</h5>
                   				<textarea id="ticker_edit" name="ticker_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									
									$("#ticker_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Ticker not found');	
			}
	}	
	
		

		function add_ticker_do(){
			
			$title = $this->input->post('title', TRUE);
			$link = $this->input->post('link', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE))); 
			$bus_id = $this->session->userdata('bus_id');
					
			$insertdata = array(
							  'title'=> $title ,
							  'body'=> $body ,
							  'link'=> $link,
							  'bus_id'=> $bus_id
							  
				);
			$this->db->insert('news_ticker',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully added entry');	

		}	
		
	//+++++++++++++++++++++++++++
	//UPDATE TICKER
	//++++++++++++++++++++++++++	
	function update_ticker_do(){
			
		$status = strtolower($this->input->post('status_edit', TRUE));
		$title = $this->input->post('title_edit', TRUE);
		$link = $this->input->post('link_edit', TRUE);
		
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('ticker_edit', FALSE))); 
		$id = $this->input->post('ticker_id_edit', TRUE);
			
		$insertdata = array(
		  'title'=> $title,
		  'body'=> $body,
		  'link'=> $link,
		  'status'=> $status
		);

		$this->db->where('ticker_id', $id);
		$this->db->update('news_ticker',$insertdata);
		$this->session->set_flashdata('msg', 'Successfully updated entry');	

	}		
	

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
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


}
?>