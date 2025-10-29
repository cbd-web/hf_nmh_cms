<?php
class Chart_model extends CI_Model{
	
 	function chart_model(){
  		//parent::CI_model();
			
 	}
	

	//+++++++++++++++++++++++++++
	//GET ALL CHARTS
	//++++++++++++++++++++++++++
	public function get_all_charts()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->order_by('sequence','ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('charts');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:24%;font-weight:normal">Type </th>
						<th style="width:15%;font-weight:normal">Listing date</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->active == 'N'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr class="myDragClass"> 
						<input type="hidden" value="'.$row->chart_id.'" />
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_chart/'.$row->chart_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:24%">'.$row->type.'</td>
						<td style="width:15%">'.date('d M Y',strtotime($row->listing_date)).'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit Chart" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_chart/'.$row->chart_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Chart" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_chart('.$row->chart_id.')">
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
									var chart_id = $(this).val(), index = i;
									console.log(chart_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'admin/update_chart_sequence/"+chart_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		  }else{
			 
			 echo '<div class="alert">
			 		<h3>No Charts added</h3>
					No charts have been added. to add a new chart please click on the add chart button on the right</div>';
		  
		 }
		  
				
				
		
	}
	
	
	//+++++++++++++++++++++++++++
	//GET ALL DATASETS
	//++++++++++++++++++++++++++		 
		 
	function get_datasets($chart_id){
		
		$bus_id = $this->session->userdata('bus_id');
			
		$query = $this->db->where('chart_id', $chart_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_datasets');
		
		if($query->result()){
			
			foreach($query->result() as $row){
				
				if(isset($row->data_color)) { $color_primary = $row->data_color; } else { $color_primary = ""; }
				
				echo '

					<div class="row-fluid">
						<div class="box span12" id="dataset_'.$row->dataset_id.'">
							<div class="box-header">
								<h2><i class="icon-th"></i><span class="break"></span>Dataset: '.$row->set_title.'</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="icon-remove"></i></a>
								</div>
							</div>
							<div class="box-content" id="content_'.$row->dataset_id.'">
							
								<p>
								<form id="dataset-update-'.$row->dataset_id.'" name="dataset-update-'.$row->dataset_id.'" method="post" action="'.site_url('/').'admin/update_dataset_do" class="form-inline">
								<input name="did" type="hidden" value="'.$row->dataset_id.'" />
								<input name="cid" type="hidden" value="'.$row->chart_id.'" />
									<fieldset>
									<input type="text" class="span6" id="upd_title" name="upd_title" placeholder="Dataset title" value="'.$row->set_title.'">
									      
									<div class="controls pull-right" style="margin-right:20px;">
									Colour:
										 <div class="input-append color_primary">
										  
											<input type="text" value="'.$color_primary.'" name="upd_color" class="form-control" />
											<span class="add-on"><i></i></span>
										</div>  
									</div>									
										
									</fieldset>
									<hr>
									Data Values: <a href="javascript:void(0)" onclick="add_data_row('.$row->dataset_id.','.$chart_id.')" role="button" class="btn btn-inverse btn-mini" style="margin-bottom:10px">+ ADD ROW</a>
									
									<div class="row-fluid">
									<div class="span6">
									';
									
									$labels = json_decode($row->labels);
									
									
									$l=1;
									foreach($labels as $lab) {
										echo '
										<fieldset style="margin-bottom:10px">
											<input type="text" class="span6 label_'.$l.'" id="label_'.$l.'_'.$row->dataset_id.'" name="set_label[]" placeholder="Label" value="'.$lab.'" onkeyup="clone_input('.$l.','.$row->dataset_id.')">								
										</fieldset>
										';
									$l++;
									}
									
				echo '			</div>
								<div class="span6">';
								
									$values = json_decode($row->data_values);
									
									
									$v=1;
									foreach($values as $val) {
									
										echo '
										<fieldset style="margin-bottom:10px">
											<input type="text" class="span6" id="value_'.$v.'" name="set_value[]" placeholder="Value" value="'.$val.'"> 
											<a title="Delete Datarow" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_datarow('.$v.','.$chart_id.','.$row->dataset_id.')"><i class="icon-trash icon-white"></i></a>						
										</fieldset>
										';
									$v++;
									}								
								
				echo '			</div>
								</div>
								<a rel="tooltip" href="javascript:void(0)" class="btn btn-danger btn pull-right" onclick="delete_dataset('.$row->dataset_id.')">Delete Dataset</a>
								<button type="submit" class="btn btn-inverse btn pull-right b-d" id="data-butt-'.$row->dataset_id.'" style="margin-right:20px;">Update Dataset</button>
								
								<div class="clearfix" style="height:10px;"></div>												
								</form>
								</p>
					
							</div>							
							
						</div>
						
					</div>				
				
				';
				
				
			}
		}
	}	
	
	
	
	
	//+++++++++++++++++++++++++++
	//GET CHART DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_chart($chart_id){
			
		$query = $this->db->where('chart_id', $chart_id);
		$query = $this->db->get('charts');
		return $query->row_array();	

	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY
	//++++++++++++++++++++++++++		 
		 
	function get_category($cat_id){
			
		$cat = $this->db->select('title');
		$cat = $this->db->where('cat_id', $cat_id);
		$cat = $this->db->get('chart_categories');
		
		if($cat->result()){
		
		$row = $cat->row();	
		
			return $row->title;
		
		} else {
			
			return 'none';
			
		}

	}



	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION LIST
	//++++++++++++++++++++++++++
	public function get_category_option_list()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('chart_categories');
		  if($query->result()){


			foreach($query->result() as $row){
				echo '<option value="'.$row->cat_id.'">'.$row->title.'</option>';
			}
			
			
		 }else{
			 
		 }
				
	}
	
	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION SELECT LIST
	//++++++++++++++++++++++++++
	public function get_category_option_select_list($id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('chart_categories');
		  if($query->result()){


			foreach($query->result() as $row){
				
				if($id == $row->cat_id) { $sel = 'selected'; } else { $sel = ''; }
				
				echo '<option value="'.$row->cat_id.'" '.$sel.'>'.$row->title.'</option>'; 
			}
			
			
		 }else{
			 
		 }
				
	}	



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('chart_categories');
		  if($query->result()){
			echo'
	
			<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr class="myDragClass">
						<input type="hidden" value="'.$row->cat_id.'" />
						<td style="width:6%">'.$row->cat_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_chart_category('.$row->cat_id.')">
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
									var cat_id = $(this).val(), index = i;
									console.log(cat_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'admin/update_chart_cat_sequence/"+cat_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
		
	
	//GET CATEGORY TYPEHEAD
	function load_category_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('chart_categories');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->cat_id;
			$title = $row->title;
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$title."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	
	
	
	 //GET CATEGORIES
	function get_categories(){
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_categories');
		return $query;	  
    }





}
?>