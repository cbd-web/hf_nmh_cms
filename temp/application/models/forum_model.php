<?php
class Forum_model extends CI_Model{
	
 	function forum_model(){
  		//parent::CI_model();
			
 	}
	

	 //GET CATEGORIES
	function get_topics(){
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('chart_topics');
		return $query;	  
    }


	//+++++++++++++++++++++++++++
	//USERS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD USERS AND INTERSECTION FOR USERS
	//++++++++++++++++++++++++++

	//+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_all_users()
	{
		  $bus_id = $this->session->userdata('bus_id');

		  $query = $this->db->query("SELECT * FROM forum_users
									LEFT JOIN forum_user_types ON forum_user_types.f_type_id = forum_users.f_type_id
									WHERE forum_users.bus_id = '".$bus_id."'
									");
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal">Status </th>
						<th style="width:20%;font-weight:normal">Name </th>
           				<th style="width:30%;font-weight:normal">Email </th>
						<th style="width:10%;font-weight:normal">Role </th>
						<th style="width:10%;font-weight:normal">Type </th>
						<th style="width:10%;font-weight:normal">Created </th>
						<th style="width:10%;font-weight:normal">Last Login </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$type = '<div class="label">admin</div>';
				if($row->type == 'editor'){
					
					$type = '<div class="label label-important">editor</div>';
					
				}elseif($row->type == 'super'){
					
					$type = '<div class="label label-danger">superuser</div>';
				}

				$status = '<span class="badge badge-success">Active</span>';
				if($row->status != 'active'){
					$status = '<span class="badge badge-important">'.$row->status.'</span>';

				}

				echo '<tr>
						<td style="width:5%">'.$status.'</td>
						<td style="width:20%">'.$row->fname. ' ' .$row->sname.'</td>
						<td style="width:30%">' .$row->email.'</td>
						<td style="width:10%">' .$type.'</td>
						<td style="width:10%">' .$row->type_name.'</td>
						<td style="width:10%">' .date('Y-m-D',strtotime($row->startdate)).'</td>
						<td style="width:10%">' .date('Y-m-D',strtotime($row->last_login)).'</td>
            			<td style="width:10%;text-align:right">
						<a title="Edit User" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_forum_user('.$row->forum_users_id.')"><i class="icon-pencil"></i></a>
						<a title="Delete User" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_user('.$row->forum_users_id.')">
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
			 		<h3>No Users added</h3>
					No users have been added. to add a new user please click on the add user button on the right</div>';
		  
		 }
			
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_users()
	{

		$bus_id = $this->session->userdata('bus_id');
		$name = $this->session->userdata('site_title');
		//GET SUBSCRIBERS
		$q = $this->db->query("SELECT forum_users.*, forum_user_types.type_name FROM forum_users
									LEFT JOIN forum_user_types ON forum_user_types.f_type_id = forum_users.f_type_id
									WHERE forum_users.bus_id = '".$bus_id."'
									", FALSE);

		$this->load->helper('csv');
		//var_dump($array);
		echo query_to_csv($q, TRUE, 'forum_users_'.$name.'.csv');
		//echo array_to_csv($array);

	}

	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function get_user_types($page_template)
	{
		$bus_id = $this->session->userdata('bus_id');	
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('forum_user_types');
		$out = '';
		$out .= '<select id="user_type_div" name="f_type_id">
					';

			if($query->result()){
			
							foreach($query->result() as $row){
								
								$str = '';
								if($page_template == $row->f_type_id){
									
									$str = 'selected';
									
									
								}
									
								$out .= '<option value="'.$row->f_type_id.'" '.$str.'>'.ucwords($row->type_name).'</option>';	
									
			
							}
	
				
			}
			
		
		
		  $out .= ' </select>
					';
		
		return $out;
	}

	//+++++++++++++++++++++++++++
	//TOPICS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD TOPICS AND INTERSECTION FOR TOPICS
	//++++++++++++++++++++++++++
	
	//+++++++++++++++++++++++++++
	//GET ALL TOPICS
	//++++++++++++++++++++++++++
	public function get_all_topics()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('forum_topics');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr>
						<td style="width:6%">'.$row->topic_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->topic_name.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Topic" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_topic('.$row->topic_id.')">
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
			 
			echo '<div class="alert"><h3>No Topics added</h3> No topics have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
	 //Get topics for sidebar
	function get_topics_current($post_id){
      	
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->where('forum_discussion_id', $post_id);
		$test = $this->db->get('forum_topic_int');
		if($test->result()){
			
			foreach($test->result() as $row){
				
				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->topic_name.'</span>';
				
			}
				
			
		}else{
			
			echo '<div class="alert"> No Categories added</div>';
			
		}
		
			  
    }	
	



	//Get Main Categories Typehead
	function load_topic_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->get('forum_topics');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->topic_id;
			$cat = $row->topic_name;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'" .preg_replace('/[^\da-z]/i', '', $cat)."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	

	//+++++++++++++++++++++++++++
	//DISCUSSIONS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD DISCUSSIONS AND INTERSECTION FOR DISCUSSIONS
	//++++++++++++++++++++++++++


	//+++++++++++++++++++++++++++
	//GET ALL DISCUSSIONS
	//++++++++++++++++++++++++++
	public function get_all_discussions()
	{
		  $bus_id = $this->session->userdata('bus_id');
		 // $query = $this->db->where('bus_id', $bus_id);
		 // $query = $this->db->get('forum_discussions');
		  $query = $this->db->query("SELECT forum_discussions.*, settings.url FROM forum_discussions JOIN settings ON forum_discussions.bus_id = settings.bus_id WHERE forum_discussions.bus_id = '".$bus_id."'");
		  if($query->result()){
			  
			 
			  
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Body </th>
						<th style="width:10%;font-weight:normal">Parent</th>
						<th style="width:10%;font-weight:normal">Discussion Template</th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$url =  $row->url;
				
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				
				$parent = '';
				if($row->parent != 0){
					
					$this->db->where('forum_discussion_id', $row->parent);
					$par = $this->db->get('forum_discussions');
					
					$prow = $par->row();
					$parent = $prow->title; 
					
				}
				echo '<tr>
						<td style="width:6%">'.$status.'</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'forum/update_discussion/'.$row->forum_discussion_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
						<td style="width:10%">'.$parent.'</td>
						<td style="width:10%">'.$row->template.'</td>
						<td style="width:20%;text-align:right">
						<a title="Edit Discussion" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'forum/update_discussion/'.$row->forum_discussion_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Discussion" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_discussion('.$row->forum_discussion_id.')">
						<i class="icon-trash icon-white"></i></a>
						<a title="Preview Discussion" rel="tooltip" class="btn btn-mini btn-success" style="cursor:pointer" target="_blank" href="'.$url.'/discussion/'.$row->slug.'">
						<i class="icon-search icon-white"></i></a>
						</td>
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
			 		<h3>No Discussions added</h3>
					No forum_discussions have been added. to add a new forum_discussion please click on the add forum_discussion button on the right</div>';
		  
		 }
				
				
		
	}
	
	//+++++++++++++++++++++++++++
	//GET ALL PARENTS SELECT
	//++++++++++++++++++++++++++
	public function parent_discussion_list()
	{
		$bus_id = $this->session->userdata('bus_id');	
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('parent', '0');
		$query = $this->db->get('forum_discussions');
		if($query->result()){
		echo'<div class="control-group"><label class="control-label" for="page_parent">Parent:</label>
		<div class="controls">
		<select name="page_parent" class="span6"><option value="Null">None</option>';
		
		foreach($query->result() as $row){
		print '<option value="'.$row->forum_discussion_id.'">'.$row->title.'</option>';
		}
		
		echo'</select>
		</div>
		</div>';	
		}
	}
		//+++++++++++++++++++++++++++
	//GET ALL PARENTS SELECT
	//++++++++++++++++++++++++++	
	public function slct_parent_discussion_list($pid, $page_id)
	{
		$bus_id = $this->session->userdata('bus_id');
			
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('forum_discussions');
		if($query->result()){
		echo'<div class="control-group"><label class="control-label" for="page_parent">Parent:</label>
		<div class="controls">
		<select name="page_parent" class="span6"><option value="Null">None</option>';
		
		foreach($query->result() as $row){
	
			$selected = '';
			if($pid == $row->forum_discussion_id) { $selected = 'selected="selected"'; }
				if($page_id != $row->forum_discussion_id) {
					print '<option value="'.$row->forum_discussion_id.'" '.$selected.'>'.$row->title.'</option>';
				}
			}
			
		echo'</select>
		<span class="help-block" style="font-size:11px">Select a parent page or leave none to keep as a main page</span>
		</div>
		</div>';	
		}
	}
	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function get_discussion_templates($page_template)
	{
		$bus_id = $this->session->userdata('bus_id');	
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('forum_discussion_templates');
		
		echo '<div class="control-group">
			<label class="control-label" for="page_template">Forum Template</label>
			  <div class="controls">
				  <select id="forum_temp_div" name="forum_template" class="span6">
					<option value="Null">None</option>';

			if($query->result()){
			
							foreach($query->result() as $row){
								
								$str = '';
								if($page_template == $row->forum_template){
									
									$str = 'selected';
									
									
								}
									
								echo '<option value="'.$row->forum_template.'" '.$str.'>'.ucwords($row->forum_template).'</option>';	
									
			
							}
	
				
			}
			//DEFAULT
			$str1 = '';$str2 = '';$str3 = '';$str4 = '';$str5 = '';
			
			if($page_template == 'full_width'){ 
				$str1 = ' selected';
			}elseif($page_template == 'home'){
				$str2 = ' selected';
			}elseif($page_template == 'contact'){
				$str3 = ' selected';				
			}elseif($page_template == 'gallery'){
				$str4 = ' selected';
			}elseif($page_template == 'blogroll'){
				$str5 = ' selected';
			}
			
			echo ' 
					  <option value="full_width" '.$str1.'>Full Width Page</option>
					  <option value="home" '.$str2.'>Home Page</option>
					  <option value="contact" '.$str3.'>Contact Page</option>
					  <option value="gallery" '.$str4.'>Gallery Page</option>
					  <option value="blogroll" '.$str5.'>News Page</option>
						';	
			
			
		
		
		  echo ' </select>
					<span class="help-block" style="font-size:11px">Set what kind of forum this needs to be</span>
				</div>
		  </div>';
		
		
	}
	
	
		
	//+++++++++++++++++++++++++++
	//GET DOWNLOADS
	//++++++++++++++++++++++++++		 
		 
	function get_discussion_sidebars($type, $id){
		
		$bus_id = $this->session->userdata('bus_id');	
		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('sidebar_content');

	  if($query->result()){
			echo'
			<form id="sidebars_frm">
			<input type="hidden" value="'.$id.'" name="type_id" />
			<input type="hidden" value="'.$type.'" name="type" />
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				
				$check = '';
				$query2 = $this->db->where('type', $type);
				$query2 = $this->db->where('type_id', $id);
				$query2 = $this->db->where('sidebar_id', $row->sidebar_id);
				$query2 = $this->db->get('content');
				if($query2->result()){
					
					$check = 'checked="checked"';	
					
				}
				
				echo '<tr>
						<td style="width:10%"><input type="checkbox" name="sidebars[]" value="'.$row->sidebar_id.'" '.$check.'/></td>
						<td style="width:70%"><div style="top:0;left:0;right:0;bottom:0;border:none">
						<a href="'.$link.'" target="_blank">'.$row->title.'</a></div></td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				</form>
				<a href="javascript:void" class="btn btn-inverse pull-right" id="save_sidebars_btn"><i class="icon-check icon-white"></i> Save Sidebars</a>
				
				<div class="clearfix" style="height:30px;"></div>
				
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Sidebars added</h3> No sidebars have been added. Add one by using the tool on the right</div>';  
		 }

	}	
	
		//+++++++++++++++++++++++++++
	//GET COMMENTS
	//++++++++++++++++++++++++++
	function get_discussion_comments($forum_discussion_id){

		//GET COMMENTS
		$output = '';
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->query("SELECT forum_comments.*,forum_users.img_file, settings.url  FROM forum_comments
								JOIN forum_users ON forum_comments.forum_users_id = forum_users.forum_users_id
								JOIN settings ON forum_comments.bus_id = settings.bus_id
								WHERE forum_comments.type = 'discussion' AND forum_comments.bus_id = '".$bus_id."' AND forum_comments.cont_id = '".$forum_discussion_id."'
								AND forum_comments.comment_type = 'top'
								");
		
		if($test->result()){
			echo '<h2 class="section_header elegant"><b>All</b> comments</h2>
					';	
			foreach($test->result() as $row){
					
					//GET SUB COMMENTS
					$sub = $this->db->query("SELECT forum_comments.*,forum_users.img_file , settings.url  FROM forum_comments
								JOIN forum_users ON forum_comments.forum_users_id = forum_users.forum_users_id
								JOIN settings ON forum_comments.bus_id = settings.bus_id
								WHERE forum_comments.type = 'discussion' AND forum_comments.bus_id = '".$bus_id."' AND forum_comments.comment_top_id = '".$row->com_id."'
								AND forum_comments.comment_type = 'sub' ORDER BY forum_comments.datetime ASC
								");
					$subF = '';
					if($sub->result()){
						
						foreach($sub->result_array() as $srow){
							$subF .= $this->get_sub_comments( $srow);
							
						}
					}
					$status = '<a onClick="update_comment_status('.$row->com_id.",'moderate')".'" class="btn btn-mini"  id="btn_'.$row->com_id.'"><i class="icon-pause"></i> Deactivate</a> ';
					$str = '<span class="label label-warning hide" id="mod_'.$row->com_id.'">Please Moderate</span>';
					if($row->status == 'moderate'){
						$str = '<span class="label label-warning" id="mod_'.$row->com_id.'">Please Moderate</span>';
						$status = '<a onClick="update_comment_status('.$row->com_id.",'live')".'" class="btn btn-mini"  id="btn_'.$row->com_id.'"><i class="icon-play"></i> Activate</a> ';
						
					}
						
					
						
						$img = '<img src="'.$row->url.'/img/logo_nav.png" class="media-object img-thumbnail img-circle" style="width: 64px; height: 64px;"/>';
					if(strlen($row->img_file) > 1){
						$imgurl = $row->url.'/assets/images/'.$row->img_file;
						$img = '<img src="'.$row->url.'/img/timbthumb.php?src='.$imgurl.'&q=100&w=64&h=64" class="media-object 
								img-thumbnail img-circle"data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
					}
					  
					  /*<img src="'.base_url('/').'img/timbthumb.php?src='.$avatar['image'].'&q=100&w=40&h=40'.'" class="img-thumbnail" style="float:left;margin:0px 5px 5px 0px"/>*/
					$output .= ' <div class="media" id="comment_box_'.$row->com_id.'">
                               <a class="pull-left" href="#">
                                  '.$img.'
                               </a>
                               <div class="media-body">
                                  <h4 class="media-heading">'.$row->name .'<small style="color:#CCC"> '.date('M d',strtotime($row->datetime)).'</small></h4>
								'.$row->body.'
									
								'.$str.'<br />
								'.$status.' 
								 <a title="Delete Comment" rel="tooltip" class="btn btn-mini"  style="cursor:pointer" onclick="delete_comment('.$row->com_id.')">
											<i class="icon-trash"></i> Delete Comment</a> 
								
								'.$subF.'
                               </div>
                            </div>
							';
						
						
					
					
				
			}
			
		}else{
			
		}
		return $output;
	}
	
	
		
	//+++++++++++++++++++++++++++
	//GET SUB CONTENTS
	//++++++++++++++++++++++++++
	public function get_sub_comments($data)
	{
			$img = '<img src="'.$data['url'].'/img/logo_nav.png" class="media-object img-thumbnail img-circle"data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
			if(strlen($data['img_file']) > 1){
				$imgurl = $data['url'].'/assets/images/'.$data['img_file'];
				$img = '<img src="'.$data['url'].'/img/timbthumb.php?src='.$imgurl.'&q=100&w=64&h=64" class="media-object img-thumbnail img-circle"data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
			}
		  
			$status = '<a onClick="update_comment_status('.$data['com_id'].",'moderate')".'" class="btn btn-mini" id="btn_'.$data['com_id'].'"><i class="icon-pause"></i> Deactivate</a>';
			$str = '<span class="label label-warning hide" id="mod_'.$data['com_id'].'">Please Moderate</span>';
			if($data['status'] == 'moderate'){
				$str = '<span class="label label-warning" id="mod_'.$data['com_id'].'">Please Moderate</span>';
				$status = '<a onClick="update_comment_status('.$data['com_id'].",'live')".'" class="btn btn-mini"  id="btn_'.$data['com_id'].'"><i class="icon-play"></i> Activate</a>';
				
			}
		  $out =' <div class="media" id="comment_box_'.$data['com_id'].'">
					 <a class="pull-left" href="#">
						'.$img.'
					 </a>
					 <div class="media-body">
						<h4 class="media-heading">'.$data['name'] .'<small style="color:#CCC"> '.date('M d',strtotime($data['datetime'])).'</small></h4>
					  '.$data['body'].'
			  
						'.$str.'<br />'.$status.' <a title="Delete Comment" rel="tooltip" class="btn btn-mini" style="cursor:pointer" onclick="delete_comment('.$data['com_id'].')">
									<i class="icon-trash"></i> Delete Comment</a>
						
					 </div>
					 
				  </div>
				  ';
		return $out;
	}
	
		//+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_all_comments()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->query("SELECT forum_comments.*, forum_users.forum_users_id, forum_users.fname,forum_users.sname,forum_discussions.title as dtitle  FROM forum_comments
		  							JOIN forum_discussions ON forum_discussions.forum_discussion_id = forum_comments.cont_id AND forum_comments.type = 'discussion'
									JOIN forum_users ON forum_users.forum_users_id = forum_comments.forum_users_id AND forum_comments.type = 'discussion'
									WHERE forum_comments.bus_id = '".$bus_id."' ORDER BY forum_comments.datetime DESC
									
									");
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:25%;font-weight:normal">Name </th>
           				<th style="width:30%;font-weight:normal">Comment </th>
						<th style="width:10%;font-weight:normal">Discussion </th>
						<th style="width:10%;font-weight:normal">Created </th>
						<th style="width:5%;font-weight:normal"> </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$type = '<div class="label">admin</div>';
				if($row->type == 'editor'){
					
					$type = '<div class="label label-important">editor</div>';
					
				}elseif($row->type == 'super'){
					
					$type = '<div class="label label-danger">superuser</div>';
				}
				
				$status = '<a onClick="update_comment_status('.$row->com_id.",'moderate')".'" id="btn_'.$row->com_id.'"><i class="icon-pause"></i> Deactivate</a>';
				$str = '<span class="label label-warning hide" id="mod_'.$row->com_id.'">Please Moderate</span>';
				if($row->status == 'moderate'){
					$str = '<span class="label label-warning" id="mod_'.$row->com_id.'">Please Moderate</span>';
					$status = '<a onClick="update_comment_status('.$row->com_id.",'live')".'" id="btn_'.$row->com_id.'"><i class="icon-play"></i> Activate</a>';
					
				}
				echo '<tr id="tr_'.$row->com_id.'">
						<td style="width:25%">'.$row->fname. ' ' .$row->sname.'</td>
						<td style="width:30%">' .$row->body.'</td>
						<td style="width:15%">' .$row->dtitle.'</td>
						<td style="width:10%">' .date('Y-m-d h:i',strtotime($row->datetime)).'</td>
						<td style="width:5%"></td>
            			<td style="width:15%;min-width:160px;text-align:right">
						'.$str.'
						<div class="btn-group">
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"  id="cog_'.$row->com_id.'">
							<i class="icon-cog"></i>
							
						  </a>
						  <ul class="dropdown-menu text-left pull-right" role="menu" aria-labelledby="dLabel">
							<li>'.$status.'</li>
							<li><a title="Delete Comment" rel="tooltip" style="cursor:pointer" onclick="delete_comment('.$row->com_id.')">
								<i class="icon-trash"></i> Delete Comment</a>
							</li>
						  </ul>
						</div>
						
						</td>
						
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
			 		<h3>No Users added</h3>
					No users have been added. to add a new user please click on the add user button on the right</div>';
		  
		 }
			
		
	}
	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function check_discussion_feature($feature, $page_id)
	{
		$bus_id = $this->session->userdata('bus_id');		
		
	
		$query = $this->db->select('discussion_features');	
		$query = $this->db->where('forum_discussion_id', $page_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('forum_discussions');	
		
		if($query->result()){
			
			$row = $query->row();	
			
			$page_features = json_decode($row->discussion_features);
			if(is_array($page_features)){
				if (in_array($feature, $page_features)) {
					return $feature; 
				} else {
					return 'false';	
				}
			}else{
				return 'false';	
			}

			
		}
		
	}
	//+++++++++++++++++++++++++++
	//GET ACCCOUNT SETTINGS
	//++++++++++++++++++++++++++

	public function get_config()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('config');
		if($query->result()){
			
			$row = $query->row_array();
			return $row['components'];
			
		}else{
			
			return '';	
		}
		
	}  
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));
		
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
			
		 
		/*$sql = $this->db->query("SELECT *
			  					FROM `admin`
								WHERE
				  			   `email` = '".$username."' LIMIT 1",TRUE);*/
		$sql = $this->db->where('email', $username);
		$sql = $this->db->limit('1');
		$sql = $this->db->get('forum_users');					   
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['forum_users_id'] = $r['forum_users_id'];
			$res['img_file'] = $r['img_file'];
			$res['last_login'] = $r['last_login'];
			$res['bus_id'] = $r['bus_id'];
			$res['type'] = $r['type'];
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
			   //break;
			}else{
			  
			   $res['bool'] = FALSE;
				
			}
		}else{//no username match
			
			$res['bool'] = FALSE;
		}

		return $res;
	}
	
	
	//+++++++++++++++++++++++++++
	//NOTIFICATIONS
	//++++++++++++++++++++++++++
	//
	//
	//	
	//+++++++++++++++++++++++++++
	//NOTIFICATIONS COMMENT APPROVAL
	//++++++++++++++++++++++++++	
	public function send_comment_approval($id, $settings)
	{
			
			
			//SEND Notifications to user who submitted
			//GET EMAIL TEMPLATE USER AND COMMENT DETAILS
			$u = $this->db->query("SELECT forum_comments.*,forum_discussions.slug,forum_discussions.title as discussion_title, forum_discussions.body as discussion_body, 
									forum_users.email, forum_users.img_file , forum_users.fname, forum_users.sname, email_templates.header, email_templates.footer ,settings.url
									FROM forum_comments
									JOIN forum_users ON forum_users.forum_users_id = forum_comments.forum_users_id
									JOIN forum_discussions ON forum_discussions.forum_discussion_id = forum_comments.cont_id AND forum_comments.type = 'discussion'
									JOIN settings ON forum_comments.bus_id = settings.bus_id
									LEFT JOIN email_templates ON forum_discussions.bus_id = email_templates.bus_id
									WHERE forum_comments.com_id = '".$id."'
									");
									
			if($u->result()){
			
				 $urow = $u->row();
				 $body =  '';
				 //GET EMAIL TEMPLATE
				 if($urow->header != null){
					 
					 $body .= $urow->header;
					
					//PLAIN TEXT 
				 }else{
					 
					 
					 
				 }
				 $img = '<img src="'.$urow->url.'/img/logo_nav.png" class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
				if(strlen($urow->img_file) > 1){
					$imgurl = $urow->url.'/assets/images/'.$urow->img_file;
					$img = '<img src="'.$urow->url.'/img/timbthumb.php?src='.$imgurl.'&q=100&w=64&h=64" class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
				}

				 $emailTO =  array(array('email' => $urow->email), array('email' => 'roland@intouch.com.na'));
				  //echo ' <br /> FINAL------- <br />';
				  //var_dump($emailTO);
	
				  $emailFROM = $settings['contact_email'];
				  $name = $settings['title']. ' Forum';
				  $subject = 'Forum Comment Approval - '.$urow->discussion_title;
				  $body1 = 'Hi '.$urow->fname.', <br /><br />
							  The comment that you made on '.$urow->discussion_title.' has been approved.
							  <br /><br />
							  <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
									 <tr>
										<td style="width:10%" class="white_box"> '.$img.'</td>
										<td style="width:90%"><blockquote><p>'.$urow->body.'</p><small>'.$urow->fname.' '.$urow->sname.'</small><em style="font-size:12px; font-style:italic;">'.$this->time_passed(strtotime($urow->datetime)).'</em></blockquote></td>
									 </tr>
							  </table>

							  <br /><br />
	
							  Thanks for your engagement
							  <br /><br />
							  View your comment here <a href="'.$urow->url.'/forum/discussion/'.$urow->slug.'">here.</a><br /><br />
							  <br />
							  Have a great day!<br />
							  Erongo Med';
							  
				 //GET EMAIL TEMPLATE
				 if($urow->footer != null){
					 $body .= $body1;
					 $body .= $urow->footer;
					 $body_final = $body;
				//PLAIN TEXT
				 }else{
					$data_view['body'] = $body1;
				  	$body_final = $this->load->view('email/body_news',$data_view,true); 
					 
				 }
				  $this->load->model('email_model');
				  $TAGS = array('tags' => 'forum_notification');
				  $out = $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS, $important = true, $global_merge = '', $merge = '');
				
				
			}
			return $urow; 
		
	}
	
	//+++++++++++++++++++++++++++
	//NOTIFICATIONS COMMENT APPROVAL
	//++++++++++++++++++++++++++	
	public function send_new_comment_notification($id, $settings)
	{
			
			
		
			//GET EMAIL TEMPLATE USER AND COMMENT DETAILS
			$e = $this->db->query("SELECT 
									DISTINCT(forum_users.email), forum_users.fname, forum_users.sname
									FROM forum_comments
									JOIN forum_users ON forum_users.forum_users_id = forum_comments.forum_users_id
									JOIN forum_discussions ON forum_discussions.forum_discussion_id = forum_comments.cont_id AND forum_comments.type = 'discussion'
									WHERE forum_comments.cont_id = '".$id."' AND forum_comments.type = 'discussion' AND forum_comments.status = 'live' GROUP BY forum_users.email");
			
			if($e->result()){
					$array = array();
					//BUILD EMAIL ARRAY
					foreach($e->result() as $erow){
						
						$t = array('email' => $erow->email);
						array_push($array, $t); 
				
					}
					//SEND Notifications to user who submitted
					//GET EMAIL TEMPLATE USER AND COMMENT DETAILS
					$u = $this->db->query("SELECT forum_comments.*,forum_discussions.slug,forum_discussions.title as discussion_title, forum_discussions.body as discussion_body, 
											group_concat(forum_users.email),
											forum_users.email, forum_users.img_file , forum_users.fname, forum_users.sname, email_templates.header, email_templates.footer ,settings.url
											FROM forum_comments
											JOIN forum_users ON forum_users.forum_users_id = forum_comments.forum_users_id
											JOIN forum_discussions ON forum_discussions.forum_discussion_id = forum_comments.cont_id AND forum_comments.type = 'discussion'
											JOIN settings ON forum_comments.bus_id = settings.bus_id
											LEFT JOIN email_templates ON forum_discussions.bus_id = email_templates.bus_id
											WHERE forum_comments.cont_id = '".$id."' AND forum_comments.type = 'discussion' AND forum_comments.status = 'live' 
											AND forum_comments.comment_type = 'top' 
											GROUP BY forum_comments.com_id ORDER BY forum_comments.datetime DESC
											LIMIT 3
											");
					//$comments = $this->get_discussion_comments($id);
									
					if($u->result()){
					
						 $urow = $u->row();
						 $body =  '';
						 //GET EMAIL TEMPLATE
						 if($urow->header != null){
							 
							 $body .= $urow->header;
							
							//PLAIN TEXT 
						 }else{
							 
							 
							 
						 }
						 $com = '';
						 //BUILD COMMENT CONTENT
						 foreach($u->result() as $row){
							 	
									
								//get all sub
								//GET SUB COMMENTS
								$u = $this->db->query("SELECT forum_comments.*,forum_users.img_file ,forum_users.fname , forum_users.sname ,settings.url  FROM forum_comments
											JOIN forum_users ON forum_comments.forum_users_id = forum_users.forum_users_id
											JOIN settings ON forum_comments.bus_id = settings.bus_id
											WHERE forum_comments.type = 'discussion' AND forum_comments.bus_id = '".$settings['bus_id']."' AND forum_comments.comment_top_id = '".$row->com_id."'
											AND forum_comments.comment_type = 'sub' ORDER BY forum_comments.datetime DESC LIMIT 5
											");
								$c2 ='';
								if($u->result()){
									
									foreach($u->result() as $rows){
									
										
											$c2 .= '';
											$img2 = '<img src="'.$rows->url.'/img/logo_nav.png" class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
											if(strlen($rows->img_file) > 1){
												$imgurl2 = $rows->url.'/assets/images/'.$rows->img_file;
												$img2 = '<img src="'.$rows->url.'/img/timbthumb.php?src='.$imgurl2.'&q=100&w=64&h=64" 
														class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
											}
											
											$c2 .= '<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
														 <tr>
															<td style="width:10%" class="white_box"></td>
															<td style="width:10%" class="white_box"> <blockquote>'.$img2.'</blockquote></td>
															<td style="width:80%"><p>'.$rows->body.'</p><small>'.$rows->fname.' '.$rows->sname.'</small>
															<em style="font-size:12px; font-style:italic;">'.$this->time_passed(strtotime($rows->datetime)).'</em></td>
														 </tr>
												  </table>';
										
										
									}
									
									
								}
								
								
								 
								$img = '<img src="'.$row->url.'/img/logo_nav.png" class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
								if(strlen($row->img_file) > 1){
									$imgurl = $urow->url.'/assets/images/'.$row->img_file;
									$img = '<img src="'.$row->url.'/img/timbthumb.php?src='.$imgurl.'&q=100&w=64&h=64" 
											class="media-object img-polaroid img-circle" data-holder-rendered="true" style="width: 64px; height: 64px;"/>';
								}
								
								$com .= '<blockquote><table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
											 <tr>
												<td style="width:10%" class="white_box"> '.$img.'</td>
												<td style="width:90%"><p>'.$row->body.'</p><small>'.$row->fname.' '.$row->sname.'</small>
												<em style="font-size:12px; font-style:italic;">'.$this->time_passed(strtotime($row->datetime)).'</em></td>
											 </tr>
									  </table></blockquote>'
									  .$c2
									  ;
								
						 }
					
		
						  $emailTO =  array($array, array('email' => 'roland@intouch.com.na'));
						  //echo ' <br /> FINAL------- <br />';
						  var_dump($emailTO);
			
						  $emailFROM = $settings['contact_email'];
						  $name = $settings['title']. ' Forum';
						  $subject = 'New Comment on - '.$urow->discussion_title;
						  $body1 = 'Hi , <br /><br />
									  A new comment has been made on '.$urow->discussion_title.' which you are involved in.
									  <br /><br />
									  
										'.$com.'
									  <br /><br />
			
									  Thanks for your engagement
									  <br /><br />
									  View your comment here <a href="'.$urow->url.'/forum/discussion/'.$urow->slug.'">here.</a><br /><br />
									  <br />
									  Have a great day!<br />
									  Erongo Med';
									  
						 //GET EMAIL TEMPLATE
						 if($urow->footer != null){
							 $body .= $body1;
							 $body .= $urow->footer;
							 $body_final = $body;
						//PLAIN TEXT
						 }else{
							$data_view['body'] = $body1;
							$body_final = $this->load->view('email/body_news',$data_view,true); 
							 
						 }
						  $this->load->model('email_model');
						  $TAGS = array('tags' => 'forum_notification');
						  $out = $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS, $important = true, $global_merge = '', $merge = '');
							
						  echo $body_final;
						
					}
				
			}//IF PEOPLE HAVE COMMENTED

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+SEND WELCOME EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function register_email($id)
	{

		$u = $this->db->query("SELECT forum_users.forum_users_id, forum_users.email, forum_users.img_file , forum_users.fname,
										forum_users.sname, email_templates.header, email_templates.footer ,
											settings.url, settings.contact_email, settings.title
											FROM forum_users
											JOIN settings ON forum_users.bus_id = settings.bus_id
											LEFT JOIN email_templates ON forum_users.bus_id = email_templates.bus_id
											WHERE forum_users.forum_users_id = '".$id."'
											");
		if($u->result()){

			$urow = $u->row();
			$body = '';
			$array = array('email' => $urow->email);
			//GET EMAIL TEMPLATE
			if($urow->header != null){

				$body .= $urow->header;

				//PLAIN TEXT
			}else{



			}

			$emailTO =  array($array, array('email' => 'info@erongomed.com'));
			//echo ' <br /> FINAL------- <br />';
			var_dump($emailTO);

			$emailFROM = $urow->contact_email;
			$name = $urow->title. ' Forum';
			$subject = 'Welcome to the '.$urow->title. ' Forum';
			$body1 = 'Hi '.$urow->fname.', <br /><br />
									 You have been successfully registered on the '.$name.'.
									  <br /><br />
									  Please confirm and verify your account by clicking on the link below.
									  <br /><br />
									  <a href="'.$urow->url.'/forum/account_verify/'.$urow->forum_users_id.'/">Activate your account here.</a><br /><br />
									  <br />
									  Or copy the link below and paste it into the address bar of your browser.
									  <br />
									  '.$urow->url.'/forum/account_verify/'.$urow->forum_users_id.'/
									  Have a great day!<br />
									  '.$urow->title. '';


			//GET EMAIL TEMPLATE
			if($urow->footer != null){
				$body .= $body1;
				$body .= $urow->footer;
				$body_final = $body;
				//PLAIN TEXT
			}else{
				$data_view['body'] = $body1;
				$body_final = $this->load->view('email/body_news',$data_view,true);

			}
			$this->load->model('email_model');
			$TAGS = array('tags' => 'forum_activation');
			$out = $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS, $important = true, $global_merge = '', $merge = '');

			echo $body_final;

		}else{

			echo 'User not Found';


		}


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TIME PAST
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function time_passed($timestamp){
		//type cast, current time, difference in timestamps
		$timestamp      = (int) $timestamp;
		$current_time   = time();
		$diff           = $current_time - $timestamp;
		
		//intervals in seconds
		$intervals      = array (
			'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
		);
		
		//now we just find the difference
		if ($diff == 0)
		{
			return 'just now';
		}    
	
		if ($diff < 60)
		{
			return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
		}        
	
		if ($diff >= 60 && $diff < $intervals['hour'])
		{
			$diff = floor($diff/$intervals['minute']);
			return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
		}        
	
		if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
		{
			$diff = floor($diff/$intervals['hour']);
			return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
		}    
	
		if ($diff >= $intervals['day'] && $diff < $intervals['week'])
		{
			$diff = floor($diff/$intervals['day']);
			return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
		}    
	
		if ($diff >= $intervals['week'] && $diff < $intervals['month'])
		{
			$diff = floor($diff/$intervals['week']);
			return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
		}    
	
		if ($diff >= $intervals['month'] && $diff < $intervals['year'])
		{
			$diff = floor($diff/$intervals['month']);
			return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
		}    
	
		if ($diff >= $intervals['year'])
		{
			$diff = floor($diff/$intervals['year']);
			return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
		}
	}	
}
?>