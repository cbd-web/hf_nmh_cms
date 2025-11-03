<?php
class Admin_model extends CI_Model
{

	function admin_model()
	{
		//parent::CI_model();
		$this->load->library('encrypt');
	}

	public function add_people()
	{

		$people = [
			[
				'name' => 'Zaa Nashandi',
				'position' => 'PAAB Head of Secretariat',
				'image' => base_url('assets/images/team/zaa_nashandi.jpg'),
				'bio' => '.....'
			],
			[
				'name' => 'Leilani Riddles',
				'position' => 'Executive Assistant',
				'image' => base_url('assets/images/team/leilanie.jpg'),
				'bio' => 'Leilani started her employment with PAAB in April 2017, in the position of Executive Assistant to the Head of
Secretariat. She is currently pursuing the LLB Honours degree through UNAM, and she holds a National Diploma
in Marketing from the Polytechnic of Namibia (now NUST). Her professional career started in 2003 and she has
held various positions in tourism, sales, marketing, program coordination and executive assistance, in both the
NGO and corporate environments'
			],
			[
				'name' => 'Olivia PS Abiatal',
				'position' => 'Manager: Standards',
				'image' => base_url('assets/images/team/olivia.jpg'),
				'bio' => '...'
			],
			[
				'name' => 'Monica Kaisi-Festus',
				'position' => 'Manager: Membership and Training',
				'image' => base_url('assets/images/team/monica.jpg'),
				'bio' => 'Monica is a Chartered Accountant through the Institute of Chartered Accountants in Zimbabwe, and a PAAB registered Assessor. She started her career in 2010 and has held positions in accounting and audit in both Zimbabwe and Namibia. Her employment with PAAB started in May 2020 and she holds the position of Manager: Membership & Training.'
			],
			[
				'name' => 'Mbavanga Tjiueza.',
				'position' => 'Manager: Investigations',
				'image' => base_url('assets/images/team/mbavanga.jpg'),
				'bio' => 'Ms. Mbavanga Tjiueza is an accomplished Investigator at the Public Accountants and Auditors Board, bringing
over 12 years of extensive experience in the accounting profession. She is a seasoned chartered accountant with a
robust background in banking, insurance, financial services, and audit industries, having thrived in diverse
management environments.<br><br>
Ms. Tjiueza holds an Honours degree in Accounting and a Masters in Business Management and Administration,
reflecting her commitment to continuous professional development and academic excellence. She is a
distinguished member of both the Institute of Chartered Accountants of Namibia and the South African Institute
of Chartered Accountants, showcasing her dedication to upholding the highest standards of ethical practice and
professional integrity in the accounting field.
<br><br>
With her comprehensive expertise and leadership acumen, Ms. Tjiueza is adept at navigating complex financial
landscapes and driving strategic initiatives to optimize organizational performance. Her analytical prowess and
meticulous attention to detail underscore her ability to deliver impactful solutions and insights that drive
sustainable business growth and regulatory compliance.'
			],
			[
				'name' => 'Martha Shiimi',
				'position' => 'Manager: Finance & Administration',
				'image' => base_url('assets/images/team/martha.jpg'),
				'bio' => 'Martha holds a Bachelors Degree in Business Administration from the Polytechnic of Namibia. She started her career in 2009 and has held positions as Assistant Financial Officer and Finance Coordinator. Her employment with PAAB started in March 2017 and she holds the position of Manager: Finance & Administration.'
			],
			[
				'name' => 'Elijah Mafanire',
				'position' => 'Manager: Inspections',
				'image' => base_url('assets/images/team/elijah.jpg'),
				'bio' => 'Elijah is a qualified Chartered Accountant through the Institute of Chartered Accountants in Zimbabwe and has more than 7 years of experience in the field of auditing. His employment with PAAB started in July 2021 and he holds the position of Manager: Inspections.'
			],
			[
				'name' => 'Naveuye Hamutumua',
				'position' => 'Administrative Officer',
				'image' => base_url('assets/images/team/naveuye.jpg'),
				'bio' => 'Nave holds a Diploma in Business Management from Business Management Training College of Southern Africa. She has 15 years experience in Administration and Finance from various organisations. Her employment with PAAB started in July 2015 and she holds the position of Administrative Officer.'
			],
			[
				'name' => 'Georgina van Rooyen',
				'position' => 'Finance Clerk',
				'image' => base_url('assets/images/team/georgina.jpg'),
				'bio' => 'Georgina holds a Diploma in Finance & Audit. Her career path started in 2014 in the fields of sales, administration, and finance. Her employment with PAAB started in July 2020 and she holds the position of Finance Clerk.'
			],
			[
				'name' => 'Ebenesia Tjitunga',
				'position' => 'Cleaner',
				'image' => base_url('assets/images/team/ebenesia.jpg'),
				'bio' => 'Ebenesia was the newly independent PAABs first employee in 2014, along with the then Head of Secretariat. She holds the position of Cleaner and also assists with general admin-related tasks.'
			],
			[
				'name' => 'Willem Simeon',
				'position' => '....',
				'image' => base_url('assets/images/team/simeon.jpg'),
				'bio' => '...'
			],
			[
				'name' => 'Julia Nghishekwa',
				'position' => '....',
				'image' => base_url('assets/images/team/julia.jpg'),
				'bio' => '...'
			]
		];



		foreach ($people as $key => $person) {
			$names = explode(' ', $person['name'], 3);


			$data['name'] = $names[0];
			$data['lname'] = $names[1];

			$data['position'] = $person['position'];
			$data['education'] = $person['bio'];
			$data['status'] = 'live';
			$data['bus_id'] = 15411;


			// if ($this->db->insert('people', $data)) {
			echo 'Done with ' . $data['name'] . '<br>';
			// } else {
			echo 'Failed with ' . $data['name'] . '<br>';
			// }

			// echo $person['name'] . '<br>';
			// echo $person['name'] . '<br>';
			echo '<br><br>';
		}
		echo 123;

	}
	//+++++++++++++++++++++++++++
	//GET NAVIGATION
	//++++++++++++++++++++++++++
	function get_navigation()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('status', 'live');
		$pages = $this->db->get('pages');

		echo '<ol class="sortable">';

		if ($pages->result()) {

			foreach ($pages->result() as $page_row) {

				echo '<li id="page_' . $page_row->page_id . '">
                         <div class="box">
                               <div class="box-header">
                                    <h2><i class="icon-list"></i><span class="break"></span>' . $page_row->title . '</h2>
                                    <div class="box-icon">
                                           <a href="#" class="disclose btn-close rem_men"><i class="icon-remove"></i></a>
                                     </div>    
                                </div>
                         </div>
                      </li>';
			}

			//GET POSTS
			$test = $this->db->where('bus_id', $bus_id);
			$test = $this->db->where('status', 'live');
			$posts = $this->db->get('posts');

			if ($posts->result()) {

				echo '<li id="post_0">
							 <div class="box">
								   <div class="box-header">
										<h2><i class="icon-list"></i><span class="break"></span>News</h2>
										<div class="box-icon">
											   <a href="#" class="disclose btn-close rem_men"><i class="icon-remove"></i></a>
										 </div>    
									</div>
							 </div>
                      	
							 <ol>';

				foreach ($posts->result() as $post_row) {

					echo '<li id="post_' . $post_row->post_id . '">
												<div class="box">
													   <div class="box-header">
															<h2><i class="icon-list"></i><span class="break"></span>' . $post_row->title . '</h2>
															<div class="box-icon">
																   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
															 </div>    
														</div>
												 </div>
											  </li>';
				}
				echo ' </ol>
							</li>';
			}
		} else {

			echo '<div class="alert">
			 		<h3>No Pages added</h3>
					No Pages or posts have been added. Please add some content first</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL PAGES
	//++++++++++++++++++++++++++
	public function get_all_menus()
	{


		$bus_id = $this->session->userdata('bus_id');
		$slq = ' WHERE menus.bus_id = ' . $bus_id . ' ';

		$sql = "SELECT menus.*, IFNULL(group_concat(settings.title), '') as pubs, ANY_VALUE(settings.url) as url from menus

										LEFT JOIN settings ON menus.bus_id = settings.bus_id
										" . $slq . "
										GROUP BY  menus.menu_id
										ORDER BY  menus.type ASC
										";

		//echo $sql;
		$query = $this->db->query($sql);
		//$query = $this->db->query("SELECT pages.*, settings.url FROM pages JOIN settings ON pages.bus_id = settings.bus_id WHERE pages.bus_id = '" . $bus_id . "'");
		if ($query->result()) {


			echo '

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Website </th>
						<th style="width:10%;font-weight:normal">Position</th>
						<th style="width:10%;font-weight:normal">Type</th>
						<th style="width:24%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$url = $row->url;

				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				$parent = '';

				$reps = explode(',', $row->pubs);
				$str = '';
				if (count($reps) > 0) {

					foreach ($reps as $rrow) {

						$str .= '<span class="label label-success">' . $rrow . '</span> ';
					}
				}


				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer"
						href="' . site_url('/') . 'admin/update_menu/' . $row->menu_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
						<td style="width:20%">' . $str . '</td>
						<td style="width:10%">' . $row->position . '</td>
						<td style="width:10%">' . $row->type . '</td>
						<td style="width:24%;text-align:right">
						<a title="Edit Menu" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="' . site_url('/') . 'admin/update_menu/' . $row->menu_id . '"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Manus added</h3>
					No pages have been added. to add a new page please click on the add page button on the right</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET MENU SUB LINKS
	//++++++++++++++++++++++++++
	public function echo_menu($menu, $type1 = "", $id_1 = "")
	{
		$myMenu = explode('&', $menu);

		if (count($myMenu) > 0) {
			$str = '';
			foreach ($myMenu as $row) {

				$substr = substr($row, strpos($row, '[') + 1);
				$type = substr($row, 0, 4);
				//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
				$id = substr($substr, 0, strpos($substr, ']', 1));
				$parent = substr($row, strpos($row, '=') + 1, strlen($row));

				if ($parent == $id_1) {

					$content = $this->get_content_title($type, $id);
					$sub_link = $this->get_menu_sub($type, $id, $menu);
					$str .= '<ol>
									<li id="' . $type . '_' . $id . '">                        
										<div class="box">
											   <div class="box-header">
																	<h2><i class="icon-list"></i><span class="break"></span>' . (isset($content['title']) ? $content['title'] : '') . '  <em><code>' . $type . '</code></em></h2>
													<div class="box-icon">
														   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
													 </div>    
												</div>
										 </div>' .
						$sub_link . '
									</li>
								</ol> ';
				}
			}
			return $str;
		}
	}








	//+++++++++++++++++++++++++++
	//SHOW MENU
	//++++++++++++++++++++++++++

	public function show_menu($menu)
	{

		$myMenu = explode('&', $menu);

		if (count($myMenu) > 0) {

			echo '<ol class="sortable">';

			foreach ($myMenu as $row) {

				$substr = substr($row, strpos($row, '[') + 1);
				$type = substr($row, 0, 4);
				//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
				$id = substr($substr, 0, strpos($substr, ']', 1));
				$parent = substr($row, strpos($row, '=') + 1, strlen($row));

				$content = $this->get_content_title($type, $id);

				if ($parent == 'null') {

					$sub_link = $this->get_menu_sub($type, $id, $menu);
					echo '<li id="' . $type . '_' . $id . '">                        
									<div class="box">
										   <div class="box-header">
												<h2><i class="icon-list"></i><span class="break"></span>' . $content['title'] . ' <em><code>' . $type . '</code></em></h2>
												<div class="box-icon">
													   <a href="#" class="disclose btn-close rem_men"><i class="icon-remove"></i></a>
												 </div>    
											</div>
									 </div>' .
						$sub_link .
						'
								</li> ';
				} else {
				}



				//echo 'Type: '. $type. ' --  ID: '.$id.' Parent: '.$parent.'<br/>';

			}

			echo '</ol>';
		} else {


			echo '<div class="alert">
			 		<h3>No Menu added</h3>
					No menu has been added. to add a new menu please click on the add menu button on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET MENU SUB LINKS
	//++++++++++++++++++++++++++
	public function get_menu_sub($type1, $id_1, $menu)
	{
		$myMenu = explode('&', $menu);

		if (count($myMenu) > 0) {
			$str = '';
			foreach ($myMenu as $row) {

				$substr = substr($row, strpos($row, '[') + 1);
				$type = substr($row, 0, 4);
				//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
				$id = substr($substr, 0, strpos($substr, ']', 1));
				$parent = substr($row, strpos($row, '=') + 1, strlen($row));

				if ($parent == $id_1) {

					$content = $this->get_content_title($type, $id);
					$sub_sub_link = $this->get_menu_sub_sub($type, $id, $menu);
					$str .= '<ol>
									<li id="' . $type . '_' . $id . '">                        
										<div class="box">
											   <div class="box-header">
													<h2><i class="icon-list"></i><span class="break"></span>' . $content['title'] . '  <em><code>' . $type . '</code></em></h2>
													<div class="box-icon">
														   <a href="#" class="disclose btn-close  rem_men"><i class="icon-remove"></i></a>
													 </div>    
												</div>
										 </div>' . $sub_sub_link . '
									</li>
								</ol> ';
				}
			}
			return $str;
		}
	}

	//+++++++++++++++++++++++++++
	//GET MENU SUB LINKS
	//++++++++++++++++++++++++++
	public function get_menu_sub_sub($type1, $id_1, $menu)
	{
		$myMenu = explode('&', $menu);

		if (count($myMenu) > 0) {
			$str = '';
			foreach ($myMenu as $row) {

				$substr = substr($row, strpos($row, '[') + 1);
				$type = substr($row, 0, 4);
				//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
				$id = substr($substr, 0, strpos($substr, ']', 1));
				$parent = substr($row, strpos($row, '=') + 1, strlen($row));

				if ($parent == $id_1) {

					$content = $this->get_content_title($type, $id);
					//$sub_link = $this->get_menu_sub($type, $id, $menu);	
					$str .= '<ol>
									<li id="' . $type . '_' . $id . '">                        
										<div class="box">
											   <div class="box-header">
													<h2><i class="icon-list"></i><span class="break"></span>' . $content['title'] . '  <em><code>' . $type . '</code></em></h2>
													<div class="box-icon">
														   <a href="#" class="disclose btn-close  rem_men"><i class="icon-remove"></i></a>
													 </div>    
												</div>
										 </div>
									</li>
								</ol> ';
				}
			}
			return $str;
		}
	}


	//+++++++++++++++++++++++++++
	//GET CONTENT TITLE
	//++++++++++++++++++++++++++
	public function get_content_title($type, $id)
	{
		if ($type == 'page') {

			$this->db->where('page_id', $id);
			$query = $this->db->get('pages');
		} elseif ($type == 'post') {

			$this->db->where('post_id', $id);
			$query = $this->db->get('posts');
		} elseif ($type == 'cats') {
			$this->db->select("cat_name as title", FALSE);
			$this->db->where('cat_id', $id);
			$query = $this->db->get('categories');
		} elseif ($type == 'link') {
			$this->db->select("title, url as slug", FALSE);
			$this->db->where('link_id', $id);
			$query = $this->db->get('links');
		}
		if ($id == 0) {

			$row['title'] = 'News';

			return $row;
		} else {

			return $query->row_array();
		}
	}

	//+++++++++++++++++++++++++++
	//Updte Menu
	//++++++++++++++++++++++++++
	public function update_menu_do()
	{
		$menu = $this->input->post('menu', true);
		$title = $this->input->post('title', true);
		$menu_id = $this->input->post('menu_id', true);
		$status = $this->input->post('status', true);
		$position = $this->input->post('position', true);
		$type = $this->input->post('type', true);
		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('menu_id', $menu_id);
		$query = $this->db->get('menus');

		$o_menu = $menu_id;

		$insertdata = array(
			'bus_id' => $bus_id,
			'admin_id' => $this->session->userdata('admin_id'),
			'menu' => $menu,
			'title' => $title,
			'status' => strtolower($status),
			'position' => $position,
			'type' => strtolower($type)

		);

		if ($query->result()) {

			$this->db->where('menu_id', $menu_id);
			$this->db->update('menus', $insertdata);
		} else {

			$this->db->insert('menus', $insertdata);
			$menu_id = $this->db->insert_id();
		}



		if ($o_menu == 0) {

			//LOG
			$this->admin_model->system_log('add_menu-' . $menu_id);
			$data['basicmsg'] = 'Menu has been added successfully';
			echo "<script>

						var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
					  noty(options);
					  window.location = '" . site_url('/') . "admin/update_menu/" . $menu_id . "';
					  </script>";
		} else {

			//LOG
			$this->admin_model->system_log('update_menu-' . $menu_id);
			$data['basicmsg'] = 'Menu has been updated successfully';
			echo "<script>
						var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
					  noty(options);</script>";
		}
	}
	//+++++++++++++++++++++++++++
	//BUILD MENU
	//++++++++++++++++++++++++++
	public function build_menu()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('pages');

		if ($query->result()) {
		} else {

			echo '<div class="alert">
			 		<h3>No Menu added</h3>
					No menu has been added. to add a new menu please click on the add menu button on the right</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//LIST PAGES MENU BUILDER
	//++++++++++++++++++++++++++

	function get_pages_nav_builder()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('pages');

		if ($test->result()) {

			echo '<div class="well well-mini">
					<h3>Pages</h3>
					<select id="pagesP" name="pages" onchange="changeFuncP();">
					<option value="">Choose a Menu Item</option>
					';

			foreach ($test->result() as $row) {
				$titlep = preg_replace('/[^\da-z]/i', '', $row->title);

				$str = "page_" . $row->page_id . "," . $titlep;

				echo '<option value="' . $str . '" label="' . $titlep . '">' . $titlep . '</option>';
				//$str = "'page_".$row->page_id."' , '".$titlep."'";


				echo '<a class="btn " style="margin:5px;" href="javascript:void(0);" onclick="add_menu_item(' . $str . ')"><i class="glyphicon glyphglyphicon glyphicon-chevron-left"></i>' . $row->title . '</a>';
			}

			echo '</select></div>';
		}
		/*$this->db->cache_on();
																																						//$test2 = $this->db->where('bus_id', $bus_id);
																																						$test2 = $this->db->get('posts');

																																						if ($test2->result())
																																						{

																																							echo '<div class="well well-mini">
																																									<h3>Posts/News Items</h3>
																																									<select id="postsS" name="posts" onchange="changeFunc();">';

																																							foreach ($test2->result() as $row2)
																																							{

																																								$title = preg_replace('/[^\da-z]/i', '', $row2->title);
																																								$str1 = "post_" . $row2->post_id . "," . $title;
																																								$str2 = "'post_" . $row2->post_id . "' , '" . $title . "'";
																																								echo '<option value="' . $str1 . '" label="' . $title . '">' . $title . '</option>';


																																								//echo '<a class="btn" style="margin:5px;" href="javascript:void(0);" onclick="add_menu_item('.$str2.')"><i class="glyphicon glyphglyphicon glyphicon-chevron-left"></i>'.$row2->title.'</a>';
																																							}

																																							echo '</select></div>';

																																						}*/
		//$this->db->cache_on();
		$test3 = $this->db->where('bus_id', $bus_id);
		$test3 = $this->db->get('categories');


		if ($test3->result()) {

			echo '<div class="well well-mini">
					<h3>Categories</h3>
					<select id="catsC" name="categories" onchange="changeFuncC();">';

			foreach ($test3->result() as $row3) {

				$title = preg_replace('/[^\da-z]/i', ' ', $row3->cat_name);
				$str1 = "cats_" . $row3->cat_id . "," . $title;
				$str2 = "'cats_" . $row3->cat_id . "' , '" . $title . "'";
				echo '<option value="' . $str1 . '" label="' . $title . '">' . $title . '</option>';


				//echo '<a class="btn" style="margin:5px;" href="javascript:void(0);" onclick="add_menu_item('.$str2.')"><i class="glyphicon glyphglyphicon glyphicon-chevron-left"></i>'.$row2->title.'</a>';
			}

			echo '</select></div>';
		}

		$str3 = "<li id='";
		$str4 = "'><div class='box'><div class='box-header'><h2><i class='icon-list'></i><span class='break'></span>";
		$str5 = "</h2><div class='box-icon'><a href='javascript:return false;' class='rem_men'><i class='icon-remove'></i></a></div></div></div></li>";

		$url_link = "'link_'";
		echo '<div class="well well-mini">
			  <div class="input-group">
			      <input type="text" class="form-control" name="category_name"  id="link_name" placeholder="eg: About Us" value="">
			      <input type="text" class="form-control" name="category_link"  id="link_url" placeholder="eg: http://example.com/page" value="">
			      <span class="input-group-btn">
			        <button class="btn btn-default" id="add_url" onclick="add_menu_link(' . "$('#link_name').val()" . ',' . "$('#link_url').val()" . ',' . "$('#link_url').val()" . ')" type="button">Add URL</button>
			      </span>
			  </div></div><!-- /input-group -->


			  <script type="text/javascript">


				function changeFunc() {


				    var selectBox = $("#postsS");
				    var selectedValue = selectBox.val();
				    var ar = selectedValue.split(",");

				   // console.log( ar[0]+" "+ ar[1] );

				    add_menu_item(ar[0], ar[1]);
				}
				function changeFuncP() {


				    var selectBox = $("#pagesP");
				    var selectedValue = selectBox.val();
				    var ar = selectedValue.split(",");

				   // console.log( ar[0]+" "+ ar[1] );

				    add_menu_item(ar[0], ar[1]);
				}
				function changeFuncC() {


				    var selectBox = $("#catsC");
				    var selectedValue = selectBox.val();
				    var ar = selectedValue.split(",");

				   // console.log( ar[0]+" "+ ar[1] );

				    add_menu_item(ar[0], ar[1]);
				}

				function add_menu_item(str, title){

					$("ol.sortable").append("' . $str3 . '"+str+"' . $str4 . '"+title+"' . $str5 . '");

						$("ol.sortable").nestedSortable({
							forcePlaceholderSize: true,
							handle: "div",
							helper:	"clone",
							items: "li",
							opacity: .6,
							placeholder: "placeholder",
							revert: 250,
							tabSize: 25,
							tolerance: "pointer",
							toleranceElement: "> div",
							maxLevels: 3,

							isTree: true,
							expandOnHover: 700,
							startCollapsed: true
						});
						$(".rem_men").on("click", function() {
							console.log(this+"yeah");
							$(this).closest("li").remove();
						});

				}

				function add_menu_link(str,url, title){

					$.ajax({
						type: "get",
						url: "' . site_url("/") . 'admin/add_menu_link/?title="+str+"&str="+str+"&url="+url ,
						dataType: "json",
						success: function (dataresult) {

							console.log(dataresult);
							add_menu_item("link_"+dataresult.link_id, dataresult.title)

						}
					});

				}


			  </script>
		';
	}
	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES
	//++++++++++++++++++++++++++
	public function get_all_galleries()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'ASC');
		$query = $this->db->get('galleries');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:40%;font-weight:normal">Description </th>
						<th style="width:20%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr>
						
						<td style="width:30%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_gallery/' . $row->gal_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
            			<td style="width:40%">' . strip_tags(substr($row->description, 0, 80)) . '</td>
						<td style="width:20%">' . date('Y-m-d', strtotime($row->review)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Gallery" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_gallery/' . $row->gal_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Gallery" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_gallery(' . $row->gal_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Galleries added</h3>
					No galleries have been added. to add a new gallery please click on the add gallery button on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES FOR SELECT
	//++++++++++++++++++++++++++
	public function get_all_galleries_select()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'ASC');
		$query = $this->db->get('galleries');
		if ($query->result()) {
			echo '<select name="gallery_select" class="span12" id="gallery_select">
				    <option value="0">No Gallery</option>';

			foreach ($query->result() as $row) {

				echo '<option value="' . $row->gal_id . '">' . $row->title . '</option>';
				;
			}


			echo '</select><br />
			
				 <a href="#" onclick="attach_gallery()" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Add Gallery</a>';
		} else {

			echo '<div class="alert">
			 		No Galleries added</div>';
		}
	}





	//+++++++++++++++++++++++++++
	//UPDATE IMAGE
	//++++++++++++++++++++++++++

	public function update_image_do()
	{
		$title = $this->input->post('img_title', TRUE);
		$name = $this->input->post('img_body', TRUE);
		$url = $this->input->post('img_url', TRUE);
		$id = $this->input->post('update_img_id', TRUE);

		$val = TRUE;

		$insertdata = array(
			'title' => $title,
			'body' => $name,
			'url' => $url

		);



		if ($val == TRUE) {

			$this->db->where('img_id', $id);

			$this->db->update('images', $insertdata);

			//LOG
			$this->admin_model->system_log('update_image-' . $id);
			$data['basicmsg'] = 'Image has been updated successfully';
			echo "<script>var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
		} else {

			echo "<script>var options = {'text':'" . $error . "','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
		}
	}

	//+++++++++++++++++++++++++++
	//GET GALLERY DETAILS
	//++++++++++++++++++++++++++		 

	function get_gallery($gal_id)
	{

		$test = $this->db->where('gal_id', $gal_id);
		$test = $this->db->get('galleries');
		return $test->row_array();
	}


	//+++++++++++++++++++++++++++
	//GET ALL GALLERY CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_gallery_categories()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('gallery_categories');
		if ($query->result()) {
			echo '

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr>
						<td style="width:6%">' . $row->cat_id . '</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->cat_name . '</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category(' . $row->cat_id . ')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';
		} else {

			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';
		}
	}


	//+++++++++++++++
	//ADD GALLERY CATEGORY
	//+++++++++++++++
	public function add_gallery_category()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO CATEGORIES
		$cat_name = $this->input->post('category_name');

		$slug = $this->clean_url_str($cat_name);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $cat_name);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('gallery_categories');

		if ($result1->num_rows() == 0) {

			$insertdata = array(
				'cat_name' => $cat_name,
				'slug' => $slug,
				'bus_id' => $bus_id,
			);

			$this->db->insert('gallery_categories', $insertdata);
		}

		//GET NEW CAT ID
		/*		$this->db->where('cat_name', $data['cat_name']);
																																								$this->db->where('bus_id', $bus_id);
																																								$result = $this->db->get('categories');
																																								$row = $result->row_array();*/
	}


	//DELETE CATEGIRY GALLERY
	public function delete_category_gallery($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('gallery_cat_int');
	}


	//Get Main Categories Typehead
	function load_gallery_category_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('gallery_categories');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->cat_id;
			$cat = $row->cat_name;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $cat . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}


	//+++++++++++++++
	//DELETE GALLERY CATEGORY
	//+++++++++++++++

	public function delete_gallery_category($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('gallery_categories');
	}



	//Get categories for sidebar
	function get_gallery_categories_current($gallery_id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('gallery_id', $gallery_id);
		$query = $this->db->get('gallery_cat_int');
		if ($query->result()) {

			foreach ($query->result() as $row) {

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category(' . $row->id . ')"><i class="icon-remove icon-white"></i> ' . $row->cat_name . '</span>';
			}
		} else {

			echo '<div class="alert"> No Categories added</div>';
		}
	}







	//+++++++++++++++++++++++++++
	//GET ALL PROJECTS
	//++++++++++++++++++++++++++
	public function get_all_projects()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('review', 'ASC');
		$query = $this->db->get('projects');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:29%;font-weight:normal">Body </th>
						<th style="width:10%;font-weight:normal">Meta Title </th>
						<th style="width:15%;font-weight:normal">Meta Description </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_project/' . $row->project_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
            			<td style="width:29%">' . strip_tags(substr($row->body, 0, 80)) . '</td>
						<td style="width:10%">' . $row->metaT . '</td>
						<td style="width:15%">' . $row->metaD . '</td>
						<td style="width:10%">' . date('Y-m-d', strtotime($row->review)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="Edit project" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_project/' . $row->project_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Project" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_project(' . $row->project_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Projects added</h3>
					No projects have been added. to add a new project please click on the add project button on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL IMAGEs
	//++++++++++++++++++++++++++
	public function get_all_images()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'DESC');
		$query = $this->db->get('images');
		if ($query->result()) {
			echo '<ul  class="thumbnails">';

			foreach ($query->result() as $row) {
				$image = $row->img_file;

				if (!strpos($image, 'cdn.nmh.com.na')) {
					$image = S3_URL . 'assets/images/' . $row->img_file;
				}
				echo '<li  class="img-polaroid">
						<img src="' . $image . '" width="200px" style="width:200px" />
						<p style="padding:10px 0px 0px 10px;">
							<a href="#" onclick="delete_image(' . $row->img_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
							<a href="' . site_url('/') . 'my_images/edit/' . rawurlencode($this->encrypt->encode('assets/images/' . $row->img_file, $this->config->item('encryption_key'), TRUE)) . '" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a>
					    </p>
					  </li>';
			}


			echo '</ul>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Images added</h3>
					No images have been added. to add a new image please please insert it into some content on the website</div>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET GALLERY SPECIFIC IMAGEs
	//++++++++++++++++++++++++++
	public function get_sidebar_content($content)
	{
		if (is_numeric($content)) {

			$query = $this->db->where('gal_id', $gal_id);
			$query = $this->db->get('images');
			if ($query->result()) {
				echo '<ul  class="thumbnails">';

				foreach ($query->result() as $row) {

					echo '<li  class="img-polaroid">
					<img src="' . S3_URL . 'assets/images/' . $row->img_file . '" width="120px" style="width:120px" />
					<p style="padding:10px 0px 0px 10px;"><a href="#" onclick="delete_image(' . $row->img_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p>
					 </li>';
				}


				echo '</ul>
			  <script type="text/javascript">
			   
			  </script>';
			} else {

				echo ' <p>Select Gallery to attach</p>
			  <div class="alert">
			  <h3>No Gallery added</h3>
			  No gallery have been added. to add a gallery into the content please insert select it below</div>';
				$this->get_all_galleries_select();
			}

			//SPECIFIC TO A POST OR PAGE VALUE
		} else {

			if (substr($content, 0, strpos($content, '_')) == 'page') {

				$page_id = substr($content, (strpos($content, '_') + 1), strlen($content));

				$query = $this->db->query("SELECT A.type, A.type_id, B.gal_id, B.slug, B.title FROM sidebars AS A 

									   JOIN galleries AS B ON A.type_id = B.gal_id 

									   WHERE A.page_id = '" . $page_id . "'", FALSE);

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'post') {

				$post_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->query("SELECT A.type, A.type_id, B.gal_id, B.slug, B.title FROM sidebars AS A 

									   JOIN galleries AS B ON A.type_id = B.gal_id 

									   WHERE A.post_id = '" . $post_id . "'", FALSE);
				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'product') {

				$product_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('product_id', $product_id);
				$query = $this->db->get('sidebars');




				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'stock') {

				$stock_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('stock_id', $stock_id);
				$query = $this->db->get('sidebars');

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'project') {

				$project_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('project_id', $project_id);
				$query = $this->db->get('sidebars');

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'event') {

				$event_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('event_id', $event_id);
				$query = $this->db->get('sidebars');

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'property') {

				$property_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('property_id', $property_id);
				$query = $this->db->get('sidebars');

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} elseif (substr($content, 0, strpos($content, '_')) == 'vendor') {

				$vendor_id = substr($content, (strpos($content, '_') + 1), strlen($content));
				$query = $this->db->where('vendor_id', $vendor_id);
				$query = $this->db->get('sidebars');

				if ($query->result()) {

					foreach ($query->result() as $row) {

						$this->load_sidebar_content($row);
					}
				} else {
					$this->get_all_galleries_select();
				}
			} else {
			}

			//echo $content . '     -  ' .substr($content, 0, strpos($content,'_')) . '    -   ' .substr($content, (strpos($content,'_') + 1), strlen($content));

		}
	}

	//+++++++++++++++++++++++++++
	//LOAD SIDEBAR CONTENTS
	//++++++++++++++++++++++++++		 

	function load_sidebar_content($row)
	{

		//$type = substr($row->type, 0, strpos($row->type,'_'));
		//$id = substr($row->type, (strpos($row->type,'_')+ 1) , strlen($row->type) );
		$type = $row->type;
		$id = $row->type_id;

		if ($type == 'gallery') {

			//echo $id;

			echo '<hr><div style="position:relative; display: block">';
			//$this->load_gallery_images($id);
			echo $this->get_gallery_title($id);

			echo '
				<a href="#"  style="float:right" onclick="remove_gallery(' . $row->type_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a><br>
				<small><strong>Slug: </strong>' . $row->slug . '</small>';

			echo '</div><div style="clear:both"></div>';
		} elseif ($type == 'contact') {

			echo 'Gallery';
		} else {

			echo $row->type;
		}
	}


	function get_gallery_title($id)
	{



		$test = $this->db->where('gal_id', $id);
		$test = $this->db->get('galleries');

		$row = $test->row();

		return '<a href="' . base_url('/') . 'admin/update_gallery/' . $row->gal_id . '" target="_blank">' . $row->title . '</a>';
	}



	function get_gallery_titles($id)
	{

		$query = $this->db->where('gal_id', $id);
		$query = $this->db->get('galleries');

		//echo $this->get_all_galleries_select();

		foreach ($query->result() as $row) {

			$link = '<a href="' . base_url('/') . 'admin/update_gallery/' . $row->gal_id . '" target="_blank">' . $row->title . '</a>';

			echo '<hr><div style="position:relative; display: block">';
			//$this->load_gallery_images($id);
			//echo $this->get_gallery_title($id);

			echo $link . '<a href="#"  style="float:right" onclick="remove_gallery(' . $row->type_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a><br>' . $row->slug;

			echo '</div><div style="clear:both"></div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DOCUMENTS
	//++++++++++++++++++++++++++		 

	function get_project_docs($project_id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('project_id', $project_id);
		$test = $this->db->order_by('sequence', 'ASC');
		$test = $this->db->get('project_documents');
		if ($test->result()) {

			echo '<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal"></th>
						<th style="width:50%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($test->result() as $row) {

				echo '<tr class="myDragClass">
				
						<td style="width:10%">
						<input type="hidden" value="' . $row->doc_id . '" />
						<img src="' . base_url('/') . 'admin_src/img/pdf_icon.png" width="20" height="20" width="20px;height:20px" /></td>
						<td style="width:20%"><div style="font-weight:bold;font-size:11px;top:0;left:0;right:0;bottom:0;border:none">'
					. $row->description . '</div></td>
            			<td style="width:50%"><a href="' . S3_URL . 'assets/documents/' . $row->doc_file . '" target+"_blank"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Edit document" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_document(' . $row->doc_id . ')"><i class="icon-pencil"></i></a>
						<a title="Delete Document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_document(' . $row->doc_id . ')">
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
									var doc_id = $(this).val(), index = i;
									console.log(doc_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_doc_sequence/"+doc_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {
			echo '<div class="alert">
			 		<h3>No Documents added</h3>
					No project documents have been added. to add a new document please click on the add document button </div>';
		}
	}

	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++

	function add_gallery_images()
	{

		//$this->load->library('image_lib');	
		$this->load->library('upload');  // NOTE: always load the library outside the loop
		$gallery_id = $_REQUEST['gallery_id'];
		$bus_id = $this->session->userdata('bus_id');

		if (isset($_FILES['file']['name'])) {
			$this->total_count_of_files = count($_FILES['file']['name']);
			/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */

			for ($i = 0; $i < $this->total_count_of_files; $i++) {

				$_FILES['userfile']['name'] = $_FILES['file']['name'];
				$_FILES['userfile']['type'] = $_FILES['file']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				$_FILES['userfile']['error'] = $_FILES['file']['error'];
				$_FILES['userfile']['size'] = $_FILES['file']['size'];


				$config['upload_path'] = BASE_URL . 'assets/images/';
				$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF';
				$config['overwrite'] = FALSE;
				$config['max_size'] = '0';
				$config['max_width'] = '8324';
				$config['max_height'] = '8550';
				$config['min_width'] = '200';
				$config['min_height'] = '200';
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;


				$this->upload->initialize($config);

				if ($this->upload->do_upload()) {
					//$file = array('upload_data'
					$data = array('upload_data' => $this->upload->data());
					$file = $this->upload->file_name;
					$oname = $this->upload->orig_name;
					$width = $this->upload->image_width;
					$height = $this->upload->image_height;

					/*if (($width > 1950) || ($height > 900)){

																																																																																																	  $this->load->model('image_model');
																																																																																																	  $this->image_model->downsize_image($file, '1920', '1024');

																																																																																																  }*/

					// $this->load->model('s3_model');
					//$this->s3_model->upload_s3('assets/images/' . $file);
					$cdn = $this->UploudToNMHS3(base_url('assets/images/' . $file), 'mynamibia-eu/cms/assets/images', $file);

					//populate array with values
					$data = array(
						'img_file' => str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/images/', '', $cdn->filePath),
						'type' => 'gal_img',
						'bus_id' => $bus_id,
						'gal_id' => $gallery_id

					);

					//insert into database
					$this->db->insert('images', $data);

					//crop
					$data['filename'] = $cdn->filePath;
					//$data['width'] = $this->upload->image_width;
					//$data['height'] = $this->upload->image_height;
					$val = TRUE;
					// $image = base_url('/') . 'assets/business/gallery/'.$file;

					//$this->output->set_header("HTTP/1.0 200 OK");


				} else {
					//ERROR
					$val = FALSE;
					$data['error'] = $this->upload->display_errors();
				}
			}
			//redirect
			if ($val == TRUE) {

				$data['basicmsg'] = 'Document added successfully!';
				$msg = "<div class='alert alert-success'>
						 <button type='button' class='close' data-dismiss='alert'>×</button>
						" . $data['basicmsg'] . "
						 </div>";

				echo '<div class="alert alert-success">
						 <button type="button" class="close" data-dismiss="alert">×</button>
						' . $data['basicmsg'] . '
						 </div>
					<script type="text/javascript">
						$("#doc_msg").html(' . $msg . ');
						//show_docs();
					</script>';
			} else {

				echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>'
					. $data['error'] . '
							 </div>
							 <script type="text/javascript">
								console.log("error");
								
							</script>';
			}
		} else {
			echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						 No Files Selected - Please select some files and try again
						 </div><script type="text/javascript">
							console.log("error");
							
						</script>';
		}
	}
	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++

	function load_gallery_images($gal_id)
	{

		//$bus_id = $this->session->userdata('bus_id');
		//$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', 'gal_img');
		$query = $this->db->where('gal_id', $gal_id);
		$query = $this->db->get('images');
		if ($query->result()) {
			echo '<ul class="thumbnails">';

			foreach ($query->result() as $row) {

				echo '<li  class="img-polaroid">
						<img src="' . S3_URL . 'assets/images/' . $row->img_file . '" width="100px" style="width:100px;display:inline-block" />
						
					  </li>';
			}


			echo '
				</ul>
				<p style="padding:10px 0px 0px 10px;text-align:right"><a href="#" onclick="remove_gallery(' . $row->gal_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Remove Gallery</a></p>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo ' <p>Select Gallery to attach</p>
					<div class="alert">
			 		<h3>No Gallery added</h3>
					No gallery have been added. to add a gallery into the content please insert select it below</div>';
			$this->get_all_galleries_select();
		}
	}

	//+++++++++++++++++++++++++++
	//load gallery images For gallery Update
	//++++++++++++++++++++++++++

	function load_gallery_images_update_old($gal_id)
	{

		$query = $this->db->where('type', 'gal_img');
		$query = $this->db->where('gal_id', $gal_id);
		$query = $this->db->get('images');
		if ($query->result()) {
			echo '<ul class="thumbnails">';

			foreach ($query->result() as $row) {

				echo '<li  class="img-polaroid">
						<img src="' . S3_URL . 'assets/images/' . $row->img_file . '" width="100px" style="width:100px;display:inline-block" />
						<p style="padding:10px 0px 0px 10px;text-align:right"><a href="#" onclick="delete_image(' . $row->img_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p>
					  </li>';
			}


			echo '
				</ul>
				
				<script type="text/javascript">
					
				</script>';
		} else {

			echo ' <p>Select Gallery to attach</p>
					<div class="alert">
			 		<h3>No Gallery added</h3>
					No gallery have been added. to add a gallery into the content please insert select it below</div>';
			$this->get_all_galleries_select();
		}
	}
	//+++++++++++++++++++++++++++
	//GET GALLERY IMAGES SORTABLE
	//++++++++++++++++++++++++++		 

	function load_gallery_images_update($gal_id)
	{

		$this->db->where('type', 'gal_img');
		$this->db->where('gal_id', $gal_id);
		$test = $this->db->order_by('sequence', 'ASC');
		$test = $this->db->get('images');

		if ($test->result()) {

			echo '<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%"> 
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal"></th>
						<th style="width:50%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($test->result() as $row) {
				$image = $row->img_file;

				if (!strpos($image, 'cdn.nmh.com.na')) {
					$image = S3_URL . 'assets/images/' . $row->img_file;
				}
				echo '<tr class="myDragClass">
				
						<td style="width:10%">
						<input type="hidden" value="' . $row->img_id . '" />
						<img src="' . $image . '" width="100px" style="width:100px;display:inline-block"  class="img-polaroid"/></td>
						<td style="width:20%"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></td>
            			<td style="width:50%"><div style="font-weight:bold;font-size:11px;top:0;left:0;right:0;bottom:0;border:none">'
					. $row->body . '</div></td>
						<td style="width:20%;text-align:right">
						<a title="Edit image" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_image(' . $row->img_id . ')"><i class="icon-pencil"></i></a>
						<a href="#" onclick="delete_image(' . $row->img_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
						</td>
						
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
									var img_id = $(this).val(), index = i;
									console.log(img_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_img_sequence/"+img_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {
			echo '<div class="alert">
			 		<h3>No Images added</h3>
					No images have been added.</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS Chunked
	//++++++++++++++++++++++++++

	public function plupload_server($document)
	{
		if ($document == 'sliders') {

			$targetDir = BASE_URL . 'assets/images/';
			$s3_dir = 'assets/images/';
		} elseif ($document == 'documents') {

			$targetDir = BASE_URL . 'assets/documents/';
			$s3_dir = 'assets/documents/';
		} elseif ($document == 'project_docs') {

			$targetDir = BASE_URL . 'assets/documents/';
			$s3_dir = 'assets/documents/';
		} else {
			$targetDir = BASE_URL . 'assets/documents/';
			$s3_dir = 'assets/documents/';
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
		$project_id = $_REQUEST['project_id'];
		$oname = $_FILES['file']['name'];
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
		if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		}
		if (isset($_SERVER["CONTENT_TYPE"])) {
			$contentType = $_SERVER["CONTENT_TYPE"];
		}
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) {
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
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		} else {
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if ($chunk < 1 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {

			// echo base_url($s3_dir . $fileName) . '<br>';
			// echo 'mynamibia-eu/cms/'  . '<br>';
			// echo  $s3_dir . '<br>';
			// echo  $fileName . '<br>';
			// echo  'No' . '<br>';
			// die();

			$cdn = $this->UploudToNMHS3(base_url($s3_dir . $fileName), 'mynamibia-eu/cms/' . $s3_dir, $fileName, 'No');

			$fileName = str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/' . $s3_dir, '', $cdn->filePath);
			//Insert DB
			$this->insert_project_docs($project_id, $fileName, $oname, $document, $cat);


			//$this->load->model('s3_model');
			//$this->s3_model->upload_s3($s3_dir . $fileName);


		}
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : "' . $fileName . '", "id" : ' . $project_id . ', "oname" : "' . $oname . '"}');
	}

	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS INSERT DB
	//++++++++++++++++++++++++++

	function insert_project_docs($project_id, $file, $oname, $document, $cat)
	{
		$bus_id = $this->session->userdata('bus_id');


		if ($document == 'project_docs') {


			//GET DOcumnet sequence
			$this->db->where('project_id', $project_id);
			$query = $this->db->get('project_documents');
			if ($query->result()) {

				$seq = 'Appendix ' . $query->num_rows();
			} else {

				$seq = 'Appendix 1';
			}
			//populate array with values
			$data = array(
				'project_id' => $project_id,
				'doc_file' => $file,
				'title' => $oname,
				'bus_id' => $bus_id,
				'description' => $seq

			);
			//insert into database
			$this->db->insert('project_documents', $data);
		} elseif ($document == 'documents') {

			//populate array with values
			$data = array(
				'project_id' => $project_id,
				'doc_file' => $file,
				'title' => $oname,
				'bus_id' => $bus_id,
				'description' => '0'

			);
			//insert into database
			$this->db->insert('documents', $data);
			$doc_id = $this->db->insert_id();
		} elseif ($document == 'sliders') {

			//populate array with values
			$data = array(

				'img_file' => $file,
				'title' => $oname,
				'bus_id' => $bus_id,
				'type' => 'slider'

			);
			//insert into database
			$this->db->insert('sliders', $data);
		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$title = $this->input->post('doc_title', TRUE);
		$name = $this->input->post('doc_name', TRUE);
		$type = $this->input->post('doc_type', TRUE);
		$id = $this->input->post('update_doc_id', TRUE);
		$download = $this->input->post('download', TRUE);

		//VALIDATE INPUT
		if ($title == '') {
			$val = FALSE;
			$error = 'Document title Required';
		} elseif ($name == '') {
			$val = FALSE;
			$error = 'Documant Name Required';
		} else {
			$val = TRUE;
		}

		$insertdata = array(
			'title' => $title,
			'description' => $name,
			'download' => $download

		);



		if ($val == TRUE) {

			$this->db->where('doc_id', $id);

			if ($type == 'project_docs') {

				$this->db->update('project_documents', $insertdata);
			} else {

				$this->db->update('documents', $insertdata);
			}


			//success redirect	


			//LOG
			$this->admin_model->system_log('update_document-' . $id);
			$data['basicmsg'] = 'Document has been updated successfully';
			echo "<script>var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
		} else {

			echo "<script>var options = {'text':'" . $error . "','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
		}
	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++		 

	function get_project($project_id)
	{

		$test = $this->db->where('project_id', $project_id);
		$test = $this->db->get('projects');
		return $test->row_array();
	}


	//+++++++++++++++++++++++++++
	//GET ALL PAGES
	//++++++++++++++++++++++++++
	public function get_all_pages()
	{
		$bus_id = $this->session->userdata('bus_id');
		// $query = $this->db->where('bus_id', $bus_id);
		// $query = $this->db->get('pages');
		$query = $this->db->query("SELECT pages.*, settings.url FROM pages JOIN settings ON pages.bus_id = settings.bus_id WHERE pages.bus_id = '" . $bus_id . "'");
		if ($query->result()) {



			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Heading </th>
						<th style="width:10%;font-weight:normal">Parent</th>
						<th style="width:10%;font-weight:normal">Page Template</th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$url = $row->url;

				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				$parent = '';
				if ($row->page_parent != 0) {

					$this->db->where('page_id', $row->page_parent);
					$par = $this->db->get('pages');

					$prow = $par->row();
					$parent = $prow->title;
				}
				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_page/' . $row->page_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
            			<td style="width:34%">' . $row->heading . '</td>
						<td style="width:10%">' . $parent . '</td>
						<td style="width:10%">' . $row->page_template . '</td>
						<td style="width:20%;text-align:right">
						<a title="Edit Page" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_page/' . $row->page_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Page" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_page(' . $row->page_id . ')">
						<i class="icon-trash icon-white"></i></a>
						<a title="Preview Page" rel="tooltip" class="btn btn-mini btn-success" style="cursor:pointer" target="_blank" href="' . $url . '/page/' . $row->slug . '">
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
		} else {

			echo '<div class="alert">
			 		<h3>No Pages added</h3>
					No pages have been added. to add a new page please click on the add page button on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET Testimonial
	//++++++++++++++++++++++++++		 

	function get_testimonial($testimonial_id)
	{

		$test = $this->db->where('testimonial_id', $testimonial_id);
		$test = $this->db->get('testimonials');
		return $test->row_array();
	}

	//+++++++++++++++++++++++++++++++
	//GET TESTIMONIAL LANGUAGE OPTION
	//+++++++++++++++++++++++++++++++

	function get_testimonial_lang_option()
	{

		$bus_id = $this->session->userdata('bus_id');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		if ($config->result()) {

			$row = $config->row_array();
			$components = explode(",", $row['components']);

			echo '
				  <div class="control-group">
					<label class="control-label" for="slug">Language</label>
					<div class="controls">
						 <select name="language">
							<option value="english">Englisch</option>			
			';

			foreach ($components as $comps) {

				if ($comps == 'german') {

					echo '<option value="german">German</option>';
				}
			}

			echo '
					 </select>
				</div>
			  </div>				
			';
		}
	}


	//+++++++++++++++++++++++++++
	//GET POST LANGUAGE Option
	//++++++++++++++++++++++++++		
	function get_testimonial_lang_option_selected($lang)
	{

		$bus_id = $this->session->userdata('bus_id');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		if ($config->result()) {

			$row = $config->row_array();
			$components = explode(",", $row['components']);
			$eng = '';
			$ger = '';

			if ($lang == 'english') {
				$eng = 'selected="selected"';
			}
			if ($lang == 'german') {
				$ger = 'selected="selected"';
			}

			echo '
				  <div class="control-group">
					<label class="control-label" for="slug">Language</label>
					<div class="controls">
						 <select name="language">
							<option value="english" ' . $eng . '>Englisch</option>			
			';

			foreach ($components as $comps) {

				if ($comps == 'german') {

					echo '<option value="german" ' . $ger . '>German</option>';
				}
			}

			echo '
					 </select>
				</div>
			  </div>				
			';
		}
	}





	//+++++++++++++++++++++++++++
	//GET PAGE DETAILS
	//++++++++++++++++++++++++++		 

	function get_page($page_id)
	{

		$test = $this->db->where('page_id', $page_id);
		$test = $this->db->get('pages');
		return $test->row_array();
	}

	// //+++++++++++++++++++++++++++
	// //GET ALL Adverts
	// //++++++++++++++++++++++++++
	// public function get_all_adverts()
	// {
	// 	  $bus_id = $this->session->userdata('bus_id');
	// 	  $query = $this->db->order_by('sequence','ASC');
	// 	  $query = $this->db->where('bus_id', $bus_id);
	// 	  $query = $this->db->get('adverts');
	// 	  if($query->result()){
	// 		echo'

	// 		<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
	// 			<thead>
	// 				<tr style="font-size:14px">
	// 					<th style="width:6%;font-weight:normal">Status</th>
	//           				<th style="width:20%;font-weight:normal">Title </th>
	// 					<th style="width:34%;font-weight:normal">Body </th>
	// 					<th style="width:15%;font-weight:normal">Listing date</th>
	// 					<th style="width:15%;font-weight:normal"></th>
	// 				</tr>
	// 			</thead>
	// 			<tbody>';

	// 		foreach($query->result() as $row){
	// 			$status = '<span class="label label-success">Live</span>';
	// 			if($row->status == 'draft'){
	// 				$status = '<span class="label label-warning">Draft</span>';
	// 			}
	// 			echo '<tr class="myDragClass"> 
	// 					<input type="hidden" value="'.$row->advert_id.'" />
	// 					<td style="width:6%">'.$status.'</td>
	// 					<td style="width:20%"><a style="cursor:pointer" 
	// 					href="'.site_url('/').'admin/update_advert/'.$row->advert_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
	// 					.$row->title.'</div></a></td>
	//            			<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
	// 					<td style="width:15%">'.date('M d Y',strtotime($row->listing_date)).'</td>
	// 					<td style="width:15%;text-align:right">
	// 					<a title="Edit Advert" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
	// 					href="'.site_url('/').'admin/update_advert/'.$row->advert_id.'"><i class="icon-pencil"></i></a>
	// 					<a title="Delete Advert" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_advert('.$row->advert_id.')">
	// 					<i class="icon-trash icon-white"></i></a></td>
	// 				  </tr>';
	// 		}


	// 		echo '</tbody>
	// 			</table>
	// 			<hr />
	// 			<div class="clearfix" style="height:30px;"></div>
	// 			<script type="text/javascript">
	// 				// Return a helper with preserved width of cells
	// 				var fixHelper = function(e, ui) {
	// 					ui.children().each(function() {
	// 						$(this).width($(this).width());
	// 					});
	// 					return ui;
	// 				};

	// 				$("#sortable tbody").sortable({
	// 					helper: fixHelper,
	// 					connectWith: "tr",
	// 					start: function(e, info) {

	// 					},
	// 					stop: function(e, info) {

	// 					  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
	// 						info.item.after(info.item.parents("tr"));
	// 						 var sibs = $("#sortable tbody").find("input:hidden");

	// 						  sibs.each(function(i,item){
	// 								var advert_id = $(this).val(), index = i;
	// 								console.log(advert_id+" "+index); 
	// 								 $.ajax({
	// 									type: "post",

	// 									url: "'. site_url('/').'admin/update_advert_sequence/"+advert_id+"/"+index ,
	// 									success: function (data) {

	// 									}
	// 							});

	// 						  });


	// 					}

	// 				}).disableSelection();
	// 			</script>';

	// 	  }else{

	// 		 echo '<div class="alert">
	// 		 		<h3>No Adverts added</h3>
	// 				No adverts have been added. to add a new advert please click on the add advert button on the right</div>';

	// 	 }




	// }
	// //+++++++++++++++++++++++++++
	// //GET ADVERT DETAILS
	// //++++++++++++++++++++++++++		 

	// function get_advert($advert_id){

	// 	$query = $this->db->where('advert_id', $advert_id);
	// 	$query = $this->db->get('adverts');
	// 	return $query->row_array();	

	// }	



	//+++++++++++++++++++++++++++
	//GET ALL COMMENTS
	//++++++++++++++++++++++++++
	public function get_all_comments()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'DESC');
		$query = $this->db->get('comments');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Name </th>
						<th style="width:40%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Comment Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$str_live = "'" . $row->com_id . "', 'live'";
				$str_moderate = "'" . $row->com_id . "', 'moderate'";
				$status = '<a href="javascript:void" onclick="update_status(' . $str_live . ')"><span class="label label-warning">Moderate</span></a>';
				$btn = '<a class="btn btn-mini btn-warning" href="javascript:void" onclick="update_status(' . $str_live . ')"><i class="icon-off"></i></a>';
				if ($row->status == 'live') {
					$status = '<a href="javascript:void" onclick="update_status(' . $str_moderate . ')"><span class="label label-success">Live</span></a>';
					$btn = '<a class="btn btn-mini btn-success" href="javascript:void" onclick="update_status(' . $str_moderate . ')"><i class="icon-play icon-white"></i></a>';
				}
				echo '<tr>
						<td style="width:10%">' . $status . '</td>
						<td style="width:20%">' . $row->name . '</td>
            			<td style="width:40%">' . strip_tags(substr($row->body, 0, 80)) . '</td>
						<th style="width:15%;font-weight:normal">' . date('M d Y h:i', strtotime($row->datetime)) . '</th>
						<td style="width:15%;text-align:right">'
					. $btn . '
						<a title="Edit Comment" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="view_comment(' . $row->com_id . ')"><i class="icon-search"></i></a>
						<a title="Delete Comment" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_comment(' . $row->com_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Comments added</h3>
					No comments have been made. </div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL FAQ ENTRIES
	//++++++++++++++++++++++++++
	public function get_all_faq()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faq');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Question </th>
						<th style="width:25%;font-weight:normal">Answer </th>
						<th style="width:15%;font-weight:normal">Topic </th>
						<th style="width:10%;font-weight:normal">Published </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				$topic = $this->get_topic($row->topic_id);

				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%">
						<a style="cursor:pointer" href="' . site_url('/') . 'admin/update_faq/' . $row->faq_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->question . '</div></a></td>
            			<td style="width:25%">' . substr(strip_tags($row->answer), 0, 80) . '</td>
						<td style="width:15%">' . $topic . '</td> 
						<th style="width:10%;font-weight:normal">' . date('d M Y', strtotime($row->listing_date)) . '</th>
						<td style="width:15%;text-align:right">
						<a title="Edit FAQ Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_faq/' . $row->faq_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete FAQ" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_faq(' . $row->faq_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No FAQ Entries added</h3>
					No enries have been added. to add a new FAQ entry please click on the add FAQ button on the right</div>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET FAQ DETAILS
	//++++++++++++++++++++++++++		 

	function get_faq($faq_id)
	{

		$query = $this->db->where('faq_id', $faq_id);
		$query = $this->db->get('faq');
		return $query->row_array();
	}



	//+++++++++++++++++++++++++++
	//GET ALL POSTS
	//++++++++++++++++++++++++++
	public function get_all_posts()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('posts');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:29%;font-weight:normal">Body </th>
						<th style="width:10%;font-weight:normal">Meta Title </th>
						<th style="width:15%;font-weight:normal">Meta Description </th>
						<th style="width:5%;font-weight:normal">Published </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_post/' . $row->post_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
            			<td style="width:29%">' . substr(strip_tags($row->body), 0, 80) . '</td>
						<td style="width:10%">' . $row->metaT . '</td>
						<td style="width:15%">' . $row->metaD . '</td>
						<th style="width:5%;font-weight:normal">' . date('M d Y', strtotime($row->datetime)) . '</th>
						<td style="width:15%;text-align:right">
						<a title="Edit Post" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_post/' . $row->post_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Post" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_post(' . $row->post_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Posts added</h3>
					No posts have been added. to add a new post please click on the add post button on the right</div>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET POST DETAILS
	//++++++++++++++++++++++++++		 

	function get_post($post_id)
	{

		$test = $this->db->where('post_id', $post_id);
		$test = $this->db->get('posts');
		return $test->row_array();
	}

	//+++++++++++++++++++++++++++
	//GET POST LANGUAGE Option
	//++++++++++++++++++++++++++		
	function get_post_lang_option()
	{

		$bus_id = $this->session->userdata('bus_id');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		if ($config->result()) {

			$row = $config->row_array();
			$components = explode(",", $row['components']);

			echo '
				  <div class="control-group">
					<label class="control-label" for="slug">Language</label>
					<div class="controls">
						 <select name="language">
							<option value="english">Englisch</option>			
			';

			foreach ($components as $comps) {

				if ($comps == 'german') {

					echo '<option value="german">German</option>';
				}
			}

			echo '
					 </select>
				</div>
			  </div>				
			';
		}
	}


	//+++++++++++++++++++++++++++
	//GET POST LANGUAGE Option
	//++++++++++++++++++++++++++		
	function get_post_lang_option_selected($lang)
	{

		$bus_id = $this->session->userdata('bus_id');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		if ($config->result()) {

			$row = $config->row_array();
			$components = explode(",", $row['components']);
			$eng = '';
			$ger = '';

			if ($lang == 'english') {
				$eng = 'selected="selected"';
			}
			if ($lang == 'german') {
				$ger = 'selected="selected"';
			}

			echo '
				  <div class="control-group">
					<label class="control-label" for="slug">Language</label>
					<div class="controls">
						 <select name="language">
							<option value="english" ' . $eng . '>Englisch</option>			
			';

			foreach ($components as $comps) {

				if ($comps == 'german') {

					echo '<option value="german" ' . $ger . '>German</option>';
				}
			}

			echo '
					 </select>
				</div>
			  </div>				
			';
		}
	}


	//+++++++++++++++++++++++++++
	//GET FEEDBACK MESSAGE
	//++++++++++++++++++++++++++		 

	function get_feedback_message($msg_id)
	{

		$test = $this->db->where('msg_id', $msg_id);
		$test = $this->db->get('feedback');
		return $test->row_array();
	}

	//+++++++++++++++++++++++++++
	//GET FEEDBACK MESSAGE
	//++++++++++++++++++++++++++		 

	function get_feedback_process($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('msg_id', $id);
		$query = $this->db->get('feedback_updates');


		if ($query->result()) {


			foreach ($query->result() as $row) {

				echo '
					<h2>' . $row->type . '</h2>
					<div class="img-polaroid" style="margin-bottom:20px; padding:20px;">Updated on: ' . date("d-m-y g:i a", strtotime($row->update_date)) . ' by ' . $row->user . '</small><br><br>' . $row->update . '</div>
					<hr>
					';
			}
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL PUBLICATIONS
	//++++++++++++++++++++++++++
	public function get_all_publications()
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('publications');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Issue Date </th>
						<th style="width:5%;font-weight:normal">Published </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_publication/' . $row->pub_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
            			<td style="width:29%">' . $row->issue_date . '</td>
						<th style="width:5%;font-weight:normal">' . date('M d Y', strtotime($row->listing_date)) . '</th>
						<td style="width:15%;text-align:right">
						<a title="Edit Publication" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_publication/' . $row->pub_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Pupblication" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_pub(' . $row->pub_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Publications added</h3>
					No posts have been added. to add a new post please click on the add post button on the right</div>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET POST DETAILS
	//++++++++++++++++++++++++++		 

	function get_publication($pub_id)
	{

		$query = $this->db->where('pub_id', $pub_id);
		$query = $this->db->get('publications');
		return $query->row_array();
	}


	//+++++++++++++++++++++++++++++++++
	//GET EXTENDED PUBLICATION DETAILS
	//+++++++++++++++++++++++++++++++++	 

	function get_publication_extended($pub_id)
	{

		$query = $this->db->where('pub_id', $pub_id);
		$query = $this->db->get('publications_extended');
		return $query->row_array();
	}


	//+++++++++++++++++++++++++++
	//LIST GALLERIES FOR NAV
	//++++++++++++++++++++++++++		 

	function get_galleries_nav()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('galleries');

		if ($test->result()) {
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Galleries<i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach ($test->result() as $row) {

				echo '<li><a class="submenu" href="' . site_url('/') . 'admin/update_gallery/' . $row->gal_id . '/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> ' . $row->title . '</span></a></li>';
			}

			echo '</ul>	
              </li>';
		}
	}


	//+++++++++++++++++++++++++++
	//LIST PAGES FOR NAV
	//++++++++++++++++++++++++++		 

	function get_pages_nav()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('pages');

		if ($test->result()) {
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Pages<i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach ($test->result() as $row) {

				echo '<li><a class="submenu" href="' . site_url('/') . 'admin/update_page/' . $row->page_id . '/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> ' . $row->title . '</span></a></li>';
			}

			echo '</ul>	
              </li>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET POSTS FOR NAV
	//++++++++++++++++++++++++++		 

	function get_posts_nav()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('posts');

		if ($test->result()) {
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Posts <i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach ($test->result() as $row) {

				echo '<li><a class="submenu" href="' . site_url('/') . 'admin/update_post/' . $row->post_id . '/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> ' . $row->title . '</span></a></li>';
			}

			echo '</ul>	
              </li>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL DOCUMENTS
	//++++++++++++++++++++++++++
	public function get_all_documents()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('documents');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal"></th>
           				<th style="width:30%;font-weight:normal">File Name </th>
						<th style="width:45%;font-weight:normal">Link </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$link = S3_URL . 'assets/documents/' . $row->doc_file;

				$ext = substr($row->title, strpos($row->title, '.'), strlen($row->title));

				if ($ext == '.doc' || $ext == '.docx') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/doc_icon.png" >';
				} elseif ($ext == '.pdf') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/pdf_icon.png" >';
				} elseif ($ext == '.xls' || $ext == '.xlsx') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/xls_icon.png" >';
				} elseif (strtolower($ext) == '.jpg' || strtolower($ext) == '.png' || strtolower($ext) == '.gif') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/img_icon.png" >';
				}

				echo '<tr>
						<td style="width:5%"><input name="doc_files[]" type="checkbox" value="' . $row->doc_id . '" id="ts"></td>
						<td style="width:5%">' . $icon . '</td>
						<td style="width:30%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></td>
						<td style="width:45%">' . $link . '</td>
            			<td style="width:15%;text-align:right">
						<a title="Edit document" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_document(' . $row->doc_id . ')"><i class="icon-pencil"></i></a>
						<a title="Delete Document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_document(' . $row->doc_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert"><h3>No Documents added</h3> No documents have been added. Add one by using the tool on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//CATEGORY MULTI ADD
	//++++++++++++++++++++++++++		
	public function category_multi_add()
	{

		$doc_files = $this->input->post('doc_files');
		$cid = $this->input->post('category');
		$bus_id = $this->session->userdata('bus_id');

		if (!empty($doc_files)) {

			foreach ($doc_files as $rid) {

				$query = $this->db->select('cat_name');
				$query = $this->db->where('cat_id', $cid);
				$query = $this->db->where('bus_id', $bus_id);
				$query = $this->db->get('categories');

				if ($query->result()) {

					$row = $query->row();

					$query2 = $this->db->where('doc_id', $rid);
					$query2 = $this->db->where('cat_id', $cid);
					$query2 = $this->db->get('doc_cat_int');

					$row2 = $query2->row();

					if ($row2->cat_id != $cid && $row2->doc_id != $rid) {

						$updateres = array(
							'bus_id' => $bus_id,
							'doc_id' => $rid,
							'cat_id' => $cid,
							'cat_name' => $row->cat_name
						);

						$this->db->insert('doc_cat_int', $updateres);
					}
				}
			} // end for each
			$data['basicmsg'] = 'Category Update Successfull';
			echo "<script>var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
		} // end if empty				
	} // end function


	//+++++++++++++++++++++++++++
	//GET TOPIC
	//++++++++++++++++++++++++++		 

	function get_topic($topic_id)
	{

		$topic = $this->db->select('topic');
		$topic = $this->db->where('topic_id', $topic_id);
		$topic = $this->db->get('faq_topics');

		if ($topic->result()) {

			$row = $topic->row();

			return $row->topic;
		} else {

			return 'none';
		}
	}



	//+++++++++++++++++++++++++++
	//GET TOPIC OPTION LIST
	//++++++++++++++++++++++++++
	public function get_topic_option_list()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faq_topics');
		if ($query->result()) {


			foreach ($query->result() as $row) {
				echo '<option value="' . $row->topic_id . '">' . $row->topic . '</option>';
			}
		} else {
		}
	}

	//+++++++++++++++++++++++++++
	//GET TOPIC OPTION SELECT LIST
	//++++++++++++++++++++++++++
	public function get_topic_option_select_list($id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faq_topics');
		if ($query->result()) {


			foreach ($query->result() as $row) {

				if ($id == $row->topic_id) {
					$sel = 'selected';
				} else {
					$sel = '';
				}

				echo '<option value="' . $row->topic_id . '" ' . $sel . '>' . $row->topic . '</option>';
			}
		} else {
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL TOPICS
	//++++++++++++++++++++++++++
	public function get_all_topics()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faq_topics');
		if ($query->result()) {
			echo '
	
			<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Topic </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr class="myDragClass">
						<input type="hidden" value="' . $row->topic_id . '" />
						<td style="width:6%">' . $row->topic_id . '</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->topic . '</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Topic" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_topic(' . $row->topic_id . ')">
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
									var topic_id = $(this).val(), index = i;
									console.log(topic_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_topic_sequence/"+topic_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert"><h3>No Topics added</h3> No topics have been added. Add one by using the tool on the right</div>';
		}
	}


	//GET TOPICS TYPEHEAD
	function load_topic_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('faq_topics');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->topic_id;
			$topic = $row->topic;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $topic . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}


	//GET TOPICS
	function get_topics()
	{
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('faq_topics');
		return $test;
	}




	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_cat_option_list()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('categories');
		if ($query->result()) {


			foreach ($query->result() as $row) {

				echo '<option value="' . $row->cat_id . '">' . $row->cat_name . '</option>';
			}
		} else {
		}
	}





	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('categories');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable" id="sortable" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr  class="myDragClass">
						<input type="hidden" value="' . $row->cat_id . '" />
						<td style="width:6%">' . $row->cat_id . '</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->cat_name . '</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category(' . $row->cat_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';
		}
	}
	//Get categories for sidebar
	function get_categories_current($post_id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('post_id', $post_id);
		$test = $this->db->get('post_cat_int');
		if ($test->result()) {

			foreach ($test->result() as $row) {

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category(' . $row->id . ')"><i class="icon-remove icon-white"></i> ' . $row->cat_name . '</span>';
			}
		} else {

			echo '<div class="alert"> No Categories added</div>';
		}
	}


	//Get REcipe Categories Typehead
	function load_recipe_category_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('recipe_categories');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->cat_id;
			$cat = $row->title;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $cat . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}

	//Get Main Categories Typehead
	function load_category_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('categories');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->cat_id;
			$cat = $row->cat_name;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $cat . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}


	//Get Main Categories
	function get_categories()
	{
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('categories');
		return $test;
	}

	//GEt Current Categories
	function get_current_categories($post_id)
	{
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('BUSINESS_ID', $post_id);
		$test = $this->db->get('i_tourism_category');
		return $test;
	}

	//Get subscriber types
	function get_subscriber_types($type)
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('subscriber_type');
		if ($test->result()) {

			echo '<select class="span6" id="type" name="type" >
				   <option value="Subscriber">Subscriber</option>';

			foreach ($test->result() as $row) {

				if ($row->sub_type_id == $type) {

					$selected = 'selected';
				} else {

					$selected = '';
				}
				echo '<option value="' . $row->sub_type_id . '" ' . $selected . '>' . $row->type . '</option>';
			}

			echo '</select>';
		} else {

			echo '<select class="span6" id="type" name="type" >
                     <option value="subscriber">Subscriber</option>
                 </select>';
		}
	}
	//Get subscriber types
	function get_all_sub_categories()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('subscriber_type');
		if ($test->result()) {

			foreach ($test->result() as $row) {

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category(' . $row->sub_type_id . ')"><i class="icon-remove icon-white"></i> ' . $row->type . '</span>';
			}
		} else {

			echo '<div class="alert"> No Categories added</div>';
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_all_users()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('admin');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:25%;font-weight:normal">Name </th>
           				<th style="width:30%;font-weight:normal">Email </th>
						<th style="width:10%;font-weight:normal">Type </th>
						<th style="width:10%;font-weight:normal">Created </th>
						<th style="width:10%;font-weight:normal">Last Login </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$type = '<div class="label">admin</div>';
				if ($row->type == 'editor') {

					$type = '<div class="label label-important">editor</div>';
				} elseif ($row->type == 'super') {

					$type = '<div class="label label-danger">superuser</div>';
				}

				echo '<tr>
						<td style="width:25%">' . $row->fname . ' ' . $row->sname . '</td>
						<td style="width:30%">' . $row->email . '</td>
						<td style="width:15%">' . $type . '</td>
						<td style="width:10%">' . date('Y-m-D', strtotime($row->startdate)) . '</td>
						<td style="width:10%">' . date('Y-m-D', strtotime($row->last_login)) . '</td>
            			<td style="width:10%;text-align:right">
						<a title="Edit User" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_sys_user(' . $row->admin_id . ')"><i class="icon-pencil"></i></a>
						<a title="Delete User" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_user(' . $row->admin_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Users added</h3>
					No users have been added. to add a new user please click on the add user button on the right</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL TESTIMONIALS
	//++++++++++++++++++++++++++
	public function get_all_testimonials()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('testimonials');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:25%;font-weight:normal">Name </th>
           				<th style="width:40%;font-weight:normal">Body </th>
						<th style="width:10%;font-weight:normal">Status </th>
						<th style="width:10%;font-weight:normal">Created </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$type = '<div class="label">Draft</div>';
				if ($row->status == 'live') {

					$type = '<div class="label label-success">Live</div>';
				}

				echo '<tr>
						<td style="width:25%"><a href="' . site_url('/') . 'admin/update_testimonial/' . $row->testimonial_id . '">' . $row->title . '</a></td>
						<td style="width:40%">' . $row->body . '</td>
						<td style="width:15%">' . $type . '</td>
						<td style="width:10%">' . date('Y-m-D', strtotime($row->review)) . '</td>
            			<td style="width:10%;text-align:right">
						<a href="' . site_url('/') . 'admin/update_testimonial/' . $row->testimonial_id . '" title="Edit Testimonial" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-pencil"></i></a>
						<a title="Delete Testimonial" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_testimonial(' . $row->testimonial_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
						
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Testimonial added</h3>
					No testimonials have been added. to add a new testimonials please click on the add testimonials button on the right</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS
	//++++++++++++++++++++++++++
	public function get_all_sliders()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('sliders');
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
						<th style="width:50%;font-weight:normal">Link </th>
						<th style="width:10%;font-weight:normal">Status </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead> 
				<tbody>';

			foreach ($query->result() as $row) {

				$link = S3_URL . 'assets/images/' . $row->img_file;

				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				echo '<tr class="myDragClass">
						<input type="hidden" value="' . $row->slider_id . '" />
						<td style="width:10%"><img src="' . $link . '" style="width:60px; height:30px" class="img-polaroid" /></td>
			
						<td style="width:50%">' . $link . '</td>
						<td style="width:10%">' . $status . '</td>
            			<td style="width:15%;text-align:right">
            			<a href="' . site_url('/') . 'my_images/edit/' . rawurlencode($this->encrypt->encode('assets/images/' . $row->img_file, $this->config->item('encryption_key'), TRUE)) . '" class="btn btn-mini btn-primary"><i class="icon-edit icon-white"></i></a>
						<a title="Edit Slider" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_slider(' . $row->slider_id . ')"><i class="icon-pencil"></i></a>
						<a title="Delete Slider" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_slider(' . $row->slider_id . ')">
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
									var slider_id = $(this).val(), index = i;
									console.log(slider_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_slider_sequence/"+slider_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert"><h3>No Sliders added</h3> No sliders have been added. Add one by using the tool on the right</div>';
		}
	}
	//+++++++++++++++++++++++++++
	//GET ALL SIDEBARS
	//++++++++++++++++++++++++++
	public function get_all_sidebars()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('sidebar_content');
		if ($query->result()) {
			echo '

			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">ID</th>
						<th style="width:60%;font-weight:normal">Name </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr class="myDragClass">
						<td style="width:10%">
						<input type="hidden" value="' . $row->sidebar_id . '" />
						' . $row->sidebar_id . '</td>
			
						<td style="width:60%">' . $row->title . '</td>
            			<td style="width:15%;text-align:right">
						<a title="Update Sidebar" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_sidebar(' . $row->sidebar_id . ')"><i class="icon-pencil"></i></a>
						<a title="Delete Sidebar" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_sidebar(' . $row->sidebar_id . ')">
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
									var sidebar_id = $(this).val(), index = i;
									console.log(sidebar_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_sidebar_sequence/"+sidebar_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert"><h3>No Sidebars added</h3> No sidebars have been added. Add one by using the tool on the right</div>';
		}
	}

	public function get_select_gallery()
	{

		$bus_id = $this->session->userdata('bus_id');

		$gallery = $this->db->where('bus_id', $bus_id);
		$gallery = $this->db->get('galleries');

		if ($gallery->result()) {

			echo '<select name="sidebar_gal">';
			echo '<option value="">SELECT GALLERY</option>';
			foreach ($gallery->result() as $row) {

				echo '<option value="' . $row->gal_id . '">' . $row->title . '</option>';
			}

			echo '</select>';
		} else {

			echo '<i>No galleries available</i>';
		}
	}

	public function get_option_gallery($option)
	{

		$bus_id = $this->session->userdata('bus_id');

		$gallery = $this->db->where('bus_id', $bus_id);
		$gallery = $this->db->get('galleries');

		if ($gallery->result()) {

			echo '<select name="sidebar_gal">';
			echo '<option value="">SELECT GALLERY</option>';
			foreach ($gallery->result() as $row) {

				if ($option == $row->gal_id) {
					$selected = "selected";
				} else {
					$selected = '';
				}

				echo '<option value="' . $row->gal_id . '" ' . $selected . ' >' . $row->title . '</option>';
			}

			echo '</select>';
		} else {

			echo '<i>No galleries available</i>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++		 

	function get_settings()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('settings');
		return $test->row_array();
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//DISPLAY NOTIFICATION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function notify_msg()
	{
		if ($this->session->flashdata('msg')) {
			echo "<script>var options = {'text':'" . $this->session->flashdata('msg') . "','layout':'bottomLeft','type':'success'};
				  noty(options);</script>";
		}
		if ($this->session->flashdata('error')) {
			echo "<script>var options = {'text':'" . $this->session->flashdata('error') . "','layout':'bottomLeft','type':'error'};
				  noty(options);</script>";
		}
		if ($this->session->flashdata('notice')) {
			echo "<script>var options = {'text':'" . $this->session->flashdata('error') . "','layout':'bottomLeft','type':'alert'};
				  noty(options);</script>";
		}
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//INSERT SYSTEM LOG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function system_log($type)
	{

		//INSERT INTO LOG TABLE
		$logdata = array(
			'admin_id' => $this->session->userdata('admin_id'),
			'name' => $this->session->userdata('u_name'),
			'bus_id' => $this->session->userdata('bus_id'),
			'TYPE' => $type
		);
		$this->db->insert('admin_log', $logdata);
	}



	//+++++++++++++++++++++++++++
	//GET DASHBOARD NAVIGATION
	//++++++++++++++++++++++++++		 

	function get_dashboard_navigation()
	{

		$bus_id = $this->session->userdata('bus_id');
		$users = $this->db->where('bus_id', $bus_id);
		$users = $this->db->count_all_results('admin');

		$pages = $this->db->where('bus_id', $bus_id);
		$pages = $this->db->count_all_results('pages');

		$posts = $this->db->where('bus_id', $bus_id);
		$posts = $this->db->count_all_results('posts');

		$cats = $this->db->where('bus_id', $bus_id);
		$cats = $this->db->count_all_results('categories');

		$imgs = $this->db->where('bus_id', $bus_id);
		$imgs = $this->db->count_all_results('images');

		$enq = $this->db->where('bus_id', $bus_id);
		$enq = $this->db->count_all_results('enquiries');

		echo '<a href="' . site_url('/') . 'admin/users/" class="quick-button span2">
					<i class="fa-icon-group"></i>
					<p>Users</p>
					<span class="notification">' . $users . '</span>
				</a>
				<a href="' . site_url('/') . 'admin/pages/" class="quick-button span2">
					<i class="fa-icon-file"></i>
					<p>Pages</p>
					<span class="notification">' . $pages . '</span>
				</a>
				<a href="' . site_url('/') . 'admin/posts/" class="quick-button span2">
					<i class="fa-icon-copy"></i>
					<p>Posts</p>
					<span class="notification">' . $posts . '</span>
				</a>
				<a href="' . site_url('/') . 'admin/categories/" class="quick-button span2">
					<i class="fa-icon-folder-open"></i>
					<p>Categories</p>
					<span class="notification">' . $cats . '</span>
				</a>
				<a href="' . site_url('/') . 'admin/enquiries/" class="quick-button span2">
					<i class="fa-icon-envelope"></i>
					<p>Messages</p>
					<span class="notification">' . $enq . '</span>
				</a>
				<a href="' . site_url('/') . 'admin/images/" class="quick-button span2">
					<i class="fa-icon-picture"></i>
					<p>Images</p>
					<span class="notification">' . $imgs . '</span>
				</a>';
	}



	//+++++++++++++++++++++++++++
	//GET MAIN NAVIGATION FROM CONFIG
	//++++++++++++++++++++++++++		 

	function get_main_nav()
	{
		$bus_id = $this->session->userdata('bus_id');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		if ($config->result()) {

			$row = $config->row_array();
			$components = explode(",", $row['components']);
			foreach ($components as $comps) {


				if ($comps == 'pages') {

					echo '<li><a href="' . site_url('/') . 'admin/menu/"><i class="fa-icon-align-left icon-white"></i><span class="hidden-tablet"> Menu</span></a></li>
						<li>
							<a class="dropmenu" href="#"><i class="icon-file icon-white"></i><span class="hidden-tablet"> Pages</span></a>
							<ul>
								<li><a class="submenu" href="' . site_url('/') . 'admin/add_page/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> Add New Page</span></a></li>
                                <li><a class="submenu" href="' . site_url('/') . 'admin/pages/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> All Pages</span></a></li>';
					echo $this->get_pages_nav();

					echo '</ul>	
						</li>
						<li>';
				}

				if ($comps == 'posts') {

					echo '	<li>
							<a class="dropmenu" href="#"><i class="fa-icon-bullhorn icon-white"></i><span class="hidden-tablet"> News/Blog</span></a>
							<ul>
								<li><a class="submenu" href="' . site_url('/') . 'admin/add_post/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> Add New Post</span></a></li>
                                <li><a class="submenu" href="' . site_url('/') . 'admin/posts/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> All Posts</span></a></li>
								<li><a class="submenu" href="' . site_url('/') . 'admin/comments/"><i class="fa-icon-comment"></i><span class="hidden-tablet"> Comments</span></a></li>';
					echo $this->get_posts_nav();
					echo '		</ul>	
						</li>
                        <li><a href="' . site_url('/') . 'admin/categories/"><i class="icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>';
				}

				if ($comps == 'adverts') {

					echo '  <li>
							<a class="dropmenu" href="#"><i class="icon-file icon-white"></i><span class="hidden-tablet"> Adverts</span></a>
							<ul>
								<li><a class="submenu" href="' . site_url('/') . 'advert/add_advert/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> Add New Advert</span></a></li>
								<li><a class="submenu" href="' . site_url('/') . 'advert/adverts/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> All Adverts</span></a></li>
								<li><a class="submenu" href="' . site_url('/') . 'advert/categories/"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						</li>';
				}

				if ($comps == 'ticker') {

					echo '<li><a href="' . site_url('/') . 'ticker/news_ticker/"><i class="fa-icon-time icon-white"></i><span class="hidden-tablet"> News Ticker</span></a></li>';
				}

				if ($comps == 'calculators') {

					echo '<li><a href="' . site_url('/') . 'calculator/calculator/"><i class="fa-icon-building icon-white"></i><span class="hidden-tablet"> Calculators</span></a></li>';
				}

				if ($comps == 'converter') {

					echo '<li><a href="' . site_url('/') . 'converter/rates/"><i class="fa-icon-building icon-white"></i><span class="hidden-tablet"> Currency Converter</span></a></li>';
				}

				if ($comps == 'survey') {

					echo '<li><a href="' . site_url('/') . 'survey/surveys/"><i class="fa-icon-edit icon-white"></i><span class="hidden-tablet"> Survey</span></a></li>';
				}

				if ($comps == 'accountants') {

					echo '<li><a href="' . site_url('/') . 'accountant/accountants/"><i class="fa-icon-time icon-white"></i><span class="hidden-tablet"> Accountants</span></a></li>';
				}

				if ($comps == 'firms') {

					echo '<li><a href="' . site_url('/') . 'firm/firms/"><i class="fa-icon-building icon-white"></i><span class="hidden-tablet"> Firms</span></a></li>';
				}


				if ($comps == 'itineraries') {


					echo '<li>
							<a href="' . site_url('/') . 'itinerary/tours/" class="dropmenu"><i class="fa-icon-suitcase icon-white"></i><span class="hidden-tablet"> Itineraries</span></a>
							<ul>
							    <li><a href="' . site_url('/') . 'itinerary/tours/" class="submenu"><i class="fa-icon-road icon-white"></i><span class="hidden-tablet"> Tours</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/destinations/" class="submenu"><i class="fa-icon-map-marker icon-white"></i><span class="hidden-tablet"> Destinations</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/highlights/" class="submenu"><i class="fa-icon-lightbulb icon-white"></i><span class="hidden-tablet"> Highlights</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/activities/" class="submenu"><i class="fa-icon-bolt icon-white"></i><span class="hidden-tablet"> Activities</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/accommodations/" class="submenu"><i class="fa-icon-food icon-white"></i><span class="hidden-tablet"> Accommodations</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/tour_types/" class="submenu"><i class="fa-icon-flag icon-white"></i><span class="hidden-tablet"> Tour types</span></a></li>
								<li><a href="' . site_url('/') . 'itinerary/specials/" class="submenu"><i class="fa-icon-star icon-white"></i><span class="hidden-tablet"> Tour Specials</span></a></li>
							</ul>
						  </li>
                          ';
				}


				if ($comps == 'products') {

					echo '<li>
							<a href="' . site_url('/') . 'product/products/" class="dropmenu"><i class="fa-icon-shopping-cart icon-white"></i><span class="hidden-tablet"> Products</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'admin/products/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Product List</span></a></li>
								<li><a href="' . site_url('/') . 'admin/manufacturers/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Manufacturers</span></a></li>
							</ul>
						  </li>';
				}

				if ($comps == 'products_new') {


					echo '<li>
							<a href="' . site_url('/') . 'product/products/" class="dropmenu"><i class="fa-icon-shopping-cart icon-white"></i><span class="hidden-tablet"> Products</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'product/products/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Product List</span></a></li>
								<li><a href="' . site_url('/') . 'product/stock_products/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Stock Product List</span></a></li>
								<li><a href="' . site_url('/') . 'product/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
								<li><a href="' . site_url('/') . 'product/manufacturers/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Manufacturers</span></a></li>
								<li><a href="' . site_url('/') . 'product/product_types/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Product Types</span></a></li>
								<li><a href="' . site_url('/') . 'product/features/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Product Features</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'properties') {


					echo '<li>
							<a href="' . site_url('/') . 'property/properties/" class="dropmenu"><i class="fa-icon-home icon-white"></i><span class="hidden-tablet"> Properties</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'property/properties/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Property List</span></a></li>
								<li><a href="' . site_url('/') . 'property/features/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Property Features</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'people') {


					echo '<li>
							<a href="' . site_url('/') . 'people/members/" class="dropmenu"><i class="fa-icon-user icon-white"></i><span class="hidden-tablet"> People</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'people/members/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Member List</span></a></li>
								<li><a href="' . site_url('/') . 'people/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}


				if ($comps == 'events') {


					echo '<li>
							<a href="' . site_url('/') . 'event/events/" class="dropmenu"><i class="fa-icon-calendar icon-white"></i><span class="hidden-tablet"> Events</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'event/events/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Event List</span></a></li>
								<li><a href="' . site_url('/') . 'event/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'projects') {



					echo '<li>
							<a href="' . site_url('/') . 'project/projects/" class="dropmenu"><i class="fa-icon-book icon-white"></i><span class="hidden-tablet"> Projects</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'project/projects/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Project List</span></a></li>
								<li><a href="' . site_url('/') . 'project/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
								<li><a href="' . site_url('/') . 'project/clients/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Clients</span></a></li>
							</ul>
						  </li>
                          ';
				}
				if ($comps == 'email_marketing') {

					echo '<li><a href="' . site_url('/') . 'admin/email_marketing/"><i class="fa-icon-envelope icon-white"></i><span class="hidden-tablet"> Email Marketing</span></a></li>';

					if ($bus_id != '5156') {
						echo '<li><a href="' . site_url('/') . 'admin/subscribers/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Subscribers</span></a></li>';
					} else {
						echo '<li><a href="' . site_url('/') . 'admin/marathon_subscribers/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet">Marathon Subscribers</span></a></li>';
					}
				}
				if ($comps == 'sms_marketing') {

					echo '<li><a href="' . site_url('/') . 'admin/sms_marketing/"><i class="fa-icon-envelope icon-white"></i><span class="hidden-tablet"> SMS Marketing</span></a></li>';
				}
				if ($comps == 'members') {

					// OG echo '<li><a href="' . site_url('/') . 'admin/members/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Members</span></a></li>';
					echo '<li><a href="' . site_url('/') . 'member/members/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Members</span></a></li>';
				}

				if ($comps == 'magnet_members') {

					echo '<li><a href="' . site_url('/') . 'magnet_members/members/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Members</span></a></li>';
				}

				if ($comps == 'premier_members') {

					echo '<li>
							<a href="' . site_url('/') . 'premier_members/members/"  class="dropmenu"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Premier Members</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'premier_members/members/" class="submenu"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Members</span></a></li>
								<li><a href="' . site_url('/') . 'premier_members/orders/" class="submenu"><i class="fa-icon-book icon-white"></i><span class="hidden-tablet"> Orders</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'bookings') {

					echo '<li><a href="' . site_url('/') . 'admin/bookings/"><i class="fa-icon-money icon-white"></i><span class="hidden-tablet"> Bookings</span></a></li>';
				}

				if ($comps == 'lss_feedback') {

					echo '<li><a href="' . site_url('/') . 'lss_feedback/feedback/"><i class="fa-icon-bullhorn icon-white"></i><span class="hidden-tablet"> Feedback</span></a></li>';
				}

				if ($comps == 'careers') {

					echo '<li><a href="' . site_url('/') . 'career/vacancies"><i class="fa-icon-bullhorn icon-white"></i><span class="hidden-tablet"> Careers</span></a></li>';
				}

				if ($comps == 'vacancies') {

					echo '<li>
							<a href="' . site_url('/') . 'vacancy/vacancies/" class="dropmenu"><i class="fa-icon-umbrella icon-white"></i><span class="hidden-tablet"> Vacancies</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'vacancy/vacancies/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Vacancy List</span></a></li>
								<li><a href="' . site_url('/') . 'vacancy/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Career Categories</span></a></li>
								<li><a href="' . site_url('/') . 'vacancy/disciplines/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Disciplines</span></a></li>
								<li><a href="' . site_url('/') . 'vacancy/applicants/" class="submenu"><i class="fa-icon-user icon-white"></i><span class="hidden-tablet"> Applicants</span></a></li>
							</ul>
						  </li>
                          ';
				}


				if ($comps == 'vendors') {

					echo '<li>
							<a href="' . site_url('/') . 'vendor/vendors/" class="dropmenu"><i class="fa-icon-money icon-white"></i><span class="hidden-tablet"> Vendors</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'vendor/vendors/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Vendor List</span></a></li>
								<li><a href="' . site_url('/') . 'vendor/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Vendor Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}


				if ($comps == 'recipes') {


					echo '<li>
							<a href="' . site_url('/') . 'admin/recipes/" class="dropmenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Recipes</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'admin/recipes/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Recipe List</span></a></li>
								<li><a href="' . site_url('/') . 'admin/recipe_categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}



				if ($comps == 'newsletter') {

					echo '<li><a href="' . site_url('/') . 'newsletter/newsletters/"><i class="fa-icon-bullhorn icon-white"></i><span class="hidden-tablet"> Newsletter</span></a></li>
                          ';
				}

				if ($comps == 'testimonials') {

					echo '<li><a href="' . site_url('/') . 'admin/testimonials/"><i class="fa-icon-comments-alt icon-white"></i><span class="hidden-tablet"> Testimonials</span></a></li>
                          ';
				}


				if ($comps == 'faq') {

					echo '<li>
							<a href="' . site_url('/') . 'admin/faq/" class="dropmenu"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> FAQ</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'admin/faq/" class="submenu"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> FAQ list</span></a></li>
								<li><a href="' . site_url('/') . 'admin/faq_topics/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Topics</span></a></li>
							</ul>
						  </li>
                          ';
				}
				if ($comps == 'charts') {

					echo '<li>
							<a href="' . site_url('/') . 'admin/charts/" class="dropmenu"><i class="fa-icon-bar-chart icon-white"></i><span class="hidden-tablet"> Charts</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'admin/charts/" class="submenu"><i class="fa-icon-bar-chart icon-white"></i><span class="hidden-tablet"> Chart List</span></a></li>
								<li><a href="' . site_url('/') . 'admin/chart_categories" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'maps') {

					echo '<li><a href="' . site_url('/') . 'map/maps/"><i class="fa-icon-map-marker icon-white"></i><span class="hidden-tablet"> Maps</span></a></li>
                          ';
				}

				if ($comps == 'nsa_pubs') {

					echo '<li>
							<a href="' . site_url('/') . 'admin/nsa_pubs/" class="dropmenu"><i class="fa-icon-bar-chart icon-white"></i><span class="hidden-tablet"> Publications</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'admin/nsa_pubs/" class="submenu"><i class="fa-icon-bar-chart icon-white"></i><span class="hidden-tablet"> Publication List</span></a></li>
								<li><a href="' . site_url('/') . 'admin/nsa_categories" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
						  </li>
                          ';
				}

				if ($comps == 'forum') {

					echo '<li>
							<a href="' . site_url('/') . 'forum/" class="dropmenu"><i class=" icon-volume-up icon-white"></i><span class="hidden-tablet"> Forum</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'forum/users/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Users</span></a></li>
								<li><a href="' . site_url('/') . 'forum/topics/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Topics</span></a></li>
								<li><a href="' . site_url('/') . 'forum/discussions/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Discussions</span></a></li>
								<li><a href="' . site_url('/') . 'forum/comments/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Comments</span></a></li>
								<li><a href="' . site_url('/') . 'forum/settings/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Settings</span></a></li>
							</ul>
						  </li>
                          ';
				}
				if ($comps == 'publications') {

					echo '<li>
							<a href="' . site_url('/') . 'publication/publications/" class="dropmenu"><i class="fa-icon-book icon-white"></i><span class="hidden-tablet"> Publications</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'publication/publications/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Publication List</span></a></li>
								<li><a href="' . site_url('/') . 'publication/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
							</li>
                          ';
				}

				if ($comps == 'publications_extended') {

					echo '<li>
							<a href="' . site_url('/') . 'publication_extended/publications/" class="dropmenu"><i class="fa-icon-book icon-white"></i><span class="hidden-tablet"> Publications</span></a>
							<ul>
								<li><a href="' . site_url('/') . 'publication_extended/publications/" class="submenu"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Publication List</span></a></li>
								<li><a href="' . site_url('/') . 'publication_extended/categories/" class="submenu"><i class="fa-icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
							</ul>
							</li>
                          ';
				}

				if ($comps == 'sliders') {

					echo '<li><a href="' . site_url('/') . 'admin/sliders/"><i class="fa-icon-random icon-white"></i><span class="hidden-tablet"> Sliders</span></a></li>
                          ';
				}
				if ($comps == 'courses') {

					echo '<li><a href="' . site_url('/') . 'course/courses/"><i class="fa-icon-random icon-white"></i><span class="hidden-tablet"> Courses</span></a></li>
                          ';
				}
				if ($comps == 'faculties') {

					echo '<li><a href="' . site_url('/') . 'faculty/faculties/"><i class="fa-icon-random icon-white"></i><span class="hidden-tablet"> Faculties</span></a></li>
                          ';
				}

				if ($comps == 'helpdesk') {

					echo '<li><a href="' . site_url('/') . 'admin/helpdesk/"><i class="fa-icon-comments icon-white"></i><span class="hidden-tablet"> Helpdesk</span></a></li>
                          ';
				}

				if ($comps == 'feedback') {

					echo '<li><a href="' . site_url('/') . 'admin/feedback/"><i class="fa-icon-retweet icon-white"></i><span class="hidden-tablet">Enquiry Feedback</span></a></li>
                          ';
				}

				if ($comps == 'sidebars') {

					echo '<li><a href="' . site_url('/') . 'admin/sidebars/"><i class="fa-icon-columns icon-white"></i><span class="hidden-tablet"> Sidebars</span></a></li>
                          ';
				}

				if ($comps == 'agencies') {

					echo '<li><a href="' . site_url('/') . 'admin/agencies/"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Agencies</span></a></li>
                          ';
				}

				if ($comps == 'show') {

					echo '<li><a href="' . site_url('/') . 'admin/property_show"><i class="fa-icon-home icon-white"></i><span class="hidden-tablet"> Property Showcase</span></a></li>
                          ';
				}

				if ($comps == 'businesses') {

					echo '<li><a href="' . site_url('/') . 'admin/businesses/"><i class="fa-icon-list-alt icon-white"></i><span class="hidden-tablet"> Businesses</span></a></li>
                          ';
				}

				if ($comps == 'videos') {

					echo '<li><a href="' . site_url('/') . 'video/galleries/"><i class="fa-icon-film icon-white"></i><span class="hidden-tablet"> Videos</span></a></li>';
				}
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET LANGUAGE PAGES FOR EDIT
	//++++++++++++++++++++++++++		 

	function get_language_pages($settings, $page_id)
	{

		$set = str_getcsv($settings, ",");

		if (count($set) > 0) {


			foreach ($set as $row) {


				//GERMAN
				if (strpos($row, 'german') !== false) {

					$this->db->where('page_id', $page_id);
					$query = $this->db->get('pages_german');

					$row = $query->row_array();
					$data['titleD'] = $row['title'];
					$data['headingD'] = $row['heading'];
					$data['bodyD'] = $row['body'];
					$data['slugD'] = $row['slug'];
					$data['metaDD'] = $row['metaD'];
					$data['mateTD'] = $row['metaT'];
					$data['page_templateD'] = $row['page_template'];
					$data['language'] = 'german';
					$data['pageID'] = $pageID;

					$this->load->view('admin/pages/inc/languages', $data);
				}
			}
		} else {
		}
	}


	//+++++++++++++++++++++++++++
	//GET LANGUAGE PAGES FOR EDIT
	//++++++++++++++++++++++++++		 

	function get_language_page($language, $page_id)
	{

		$table = 'pages_' . $language;

		$this->db->where('page_id', $page_id);
		$query = $this->db->get($table);

		$row = $query->row_array();
		$data['titleD'] = $row['title'];
		$data['headingD'] = $row['heading'];
		$data['bodyD'] = $row['body'];
		$data['slugD'] = $row['slug'];
		$data['metaDD'] = $row['metaD'];
		$data['mateTD'] = $row['metaT'];
		$data['page_templateD'] = $row['page_template'];
		$data['page_template'] = $row['page_template'];
		$data['language'] = $language;
		$data['pageID'] = $page_id;


		$this->load->view('admin/pages/inc/languages', $data);
	}


	//+++++++++++++++++++++++++++
	//GET DOWNLOADS
	//++++++++++++++++++++++++++		 

	function get_page_sidebars($type, $id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('sidebar_content');

		if ($query->result()) {
			echo '
			<form id="sidebars_frm">
			<input type="hidden" value="' . $id . '" name="type_id" />
			<input type="hidden" value="' . $type . '" name="type" />
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {


				$check = '';
				$query2 = $this->db->where('type', $type);
				$query2 = $this->db->where('type_id', $id);
				$query2 = $this->db->where('sidebar_id', $row->sidebar_id);
				$query2 = $this->db->get('content');
				if ($query2->result()) {

					$check = 'checked="checked"';
				}

				echo '<tr>
						<td style="width:10%"><input type="checkbox" name="sidebars[]" value="' . $row->sidebar_id . '" ' . $check . '/></td>
						<td style="width:70%"><div style="top:0;left:0;right:0;bottom:0;border:none">
						<a href="' . $link . '" target="_blank">' . $row->title . '</a></div></td>
						
					  </tr>';
			}


			echo '</tbody>
				</table>
				</form>
				<a href="javascript:void" class="btn btn-inverse pull-right" id="save_sidebars_btn"><i class="icon-check icon-white"></i> Save Sidebars</a>
				
				<div class="clearfix" style="height:30px;"></div>
				
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert"><h3>No Sidebars added</h3> No sidebars have been added. Add one by using the tool on the right</div>';
		}
	}



	//+++++++++++++++++++++++++++
	//GET DOWNLOADS
	//++++++++++++++++++++++++++		 

	function get_downloads($type, $id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('bus_id', $bus_id);
		$this->db->where('download', 'yes');

		$query = $this->db->get('documents');

		if ($query->result()) {
			echo '
			<form id="download_frm">
			<input type="hidden" value="' . $id . '" name="type_id" />
			<input type="hidden" value="' . $type . '" name="type" />
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:70%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$link = S3_URL . 'assets/documents/' . $row->doc_file;

				$ext = substr($row->title, strpos($row->title, '.'), strlen($row->title));

				if ($ext == '.doc' || $ext == '.docx') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/doc_icon.png" >';
				} elseif ($ext == '.pdf') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/pdf_icon.png" >';
				} elseif ($ext == '.xls' || $ext == '.xlsx') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/xls_icon.png" >';
				} elseif (strtolower($ext) == '.jpg' || strtolower($ext) == '.png' || strtolower($ext) == '.gif') {

					$icon = '<img src="' . base_url('/') . 'admin_src/img/img_icon.png" >';
				}


				$check = '';
				$query2 = $this->db->where('type', $type);
				$query2 = $this->db->where('type_id', $id);
				$query2 = $this->db->where('doc_id', $row->doc_id);
				$query2 = $this->db->get('content');
				if ($query2->result()) {

					$check = 'checked="checked"';
				}

				echo '<tr>
						<td style="width:10%"><input type="checkbox" name="downloads[]" value="' . $row->doc_id . '" ' . $check . '/></td>
						<td style="width:10%">' . $icon . '</td>
						<td style="width:70%"><div style="top:0;left:0;right:0;bottom:0;border:none">
						<a href="' . $link . '" target="_blank">' . $row->title . '</a></div></td>
						
            			<td style="width:1%;text-align:right">
						
						</td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				</form>
				<a href="javascript:void" class="btn btn-inverse pull-right" id="save_download_btn"><i class="icon-check icon-white"></i> Save Downloads</a>
				
				<div class="clearfix" style="height:30px;"></div>
				
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert"><h3>No Documents added</h3> No documents have been added. Add one by using the tool on the right</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE
	//++++++++++++++++++++++++++		 

	function get_featured_image($type, $id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('bus_id', $bus_id);
		$this->db->where('type', $type);
		$this->db->where('type_id', $id);
		$query = $this->db->get('images');

		if ($query->result()) {

			$str = "$('#feat_img').html('');";
			$row = $query->row_array();


			$img = 'https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/images/' . $row['img_file'];


			echo '<div id="feat_img"><div class="img-polaroid"><img src="' . $img . '" />
				  <p style="padding:10px 10px 0px 0px;text-align:right">
				  <a href="' . site_url('/') . 'my_images/edit/' . urlencode($this->encrypt->encode('assets/images/' . $row['img_file'], $this->config->item('encryption_key'), TRUE)) . '" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a>
				  <a href="javascript:void(0);" onclick="remove_img(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
				  </p></div></div>';

			$str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
			echo '<div id="add_img" style="display:none">
					 <form action="' . site_url('/') . 'admin/add_featured_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
						<fieldset>
						<input type="file" class="" id="userfile" style="display:none" name="userfile">
						<input type="hidden" name="type_id" value="' . $id . '">
						<input type="hidden" name="type" value="' . $type . '">
						
						<div id="avatar_msg"></div>
						<div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>
						
						<a href="javascript:void(0)" onClick="' . $str . '" class="btn">Select Image</a>
						<button type="submit" class="btn btn-inverse" id="imgbut">Add featured Image</button>
						</fieldset>
					  </form>
					  </div>
				 
				  ';
		} else {

			$str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
			echo '<div id="feat_img"><div class="alert">No featured image selected</div></div>
				<div id="add_img">
				 <form action="' . site_url('/') . 'admin/add_featured_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
				  	<fieldset>
					<input type="file" class="" id="userfile" style="display:none" name="userfile">
					<input type="hidden" name="type_id" value="' . $id . '">
					<input type="hidden" name="type" value="' . $type . '">
					<div id="avatar_msg"></div>
                    <div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
                               <div class="bar bar-warning" style="width: 0%;"></div>
                    </div>
					
					<a href="javascript:void(0)" onClick="' . $str . '" class="btn">Select Image</a>
					<button type="submit" class="btn btn-inverse disabled" id="imgbut">Add featured Image</button>
					</fieldset>
				  </form>
				  </div>';
		}

		echo '<script type="text/javascript">
				  	function remove_img(id){
						$("#add_img").fadeIn();
				  		$("#feat_img").empty();
						
						$.ajax({
							type: "get",
							
							url: "' . site_url('/') . 'admin/remove_featured_image/' . $type . '/"+id ,
							success: function (data) {
								
								
							}
						});
						
					}
				  </script>';
	}


	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE
	//++++++++++++++++++++++++++

	function get_featured_logo($type, $id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('bus_id', $bus_id);
		$this->db->where('type', $type);
		$this->db->where('type_id', $id);
		$query = $this->db->get('images');

		if ($query->result()) {

			$str = "$('#feat_logo').html('');";
			$row = $query->row_array();
			echo '<div id="feat_logo"><div class="img-polaroid"><img src="' . S3_URL . 'assets/images/' . $row['img_file'] . '" />
				  <p style="padding:10px 10px 0px 0px;text-align:right">
				  <a href="' . site_url('/') . 'my_images/edit/' . urlencode($this->encrypt->encode('assets/images/' . $row['img_file'], $this->config->item('encryption_key'), TRUE)) . '" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a>
				  <a href="javascript:void(0);" onclick="remove_logo(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
				  </p></div></div>';

			$str = "$('#userfile2').click();$('#logobut').removeClass('disabled');";
			echo '<div id="add_logo" style="display:none">
					 <form action="' . site_url('/') . 'admin/add_featured_logo/" method="post" accept-charset="utf-8" id="add-logo" name="add-logo" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile2" style="display:none" name="userfile">
						<input type="hidden" name="type_id" value="' . $id . '">
						<input type="hidden" name="type" value="' . $type . '">

						<div id="avatar_msg2"></div>
						<div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>

						<a href="javascript:void(0)" onClick="' . $str . '" class="btn">Select Logo</a>
						<button type="submit" class="btn btn-inverse" id="logobut">Add featured Logo</button>
						</fieldset>
					  </form>
					  </div>

				  ';
		} else {

			$str = "$('#userfile2').click();$('#logobut').removeClass('disabled');";
			echo '<div id="feat_logo"><div class="alert">No featured logo selected</div></div>
				<div id="add_img">
				 <form action="' . site_url('/') . 'admin/add_featured_logo/" method="post" accept-charset="utf-8" id="add-logo" name="add-logo" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile2" style="display:none" name="userfile">
					<input type="hidden" name="type_id" value="' . $id . '">
					<input type="hidden" name="type" value="' . $type . '">
					<div id="avatar_msg2"></div>
                    <div class="progress progress-striped active" id="procover2" style="display:none;margin-top:20px">
                               <div class="bar bar-warning" style="width: 0%;"></div>
                    </div>

					<a href="javascript:void(0)" onClick="' . $str . '" class="btn">Select Logo</a>
					<button type="submit" class="btn btn-inverse disabled" id="logobut">Add featured Logo</button>
					</fieldset>
				  </form>
				  </div>';
		}

		echo ' <script type="text/javascript">
				  	function remove_logo(id){
						$("#add_logo").fadeIn();
				  		$("#feat_logo").empty();

						$.ajax({
							type: "get",

							url: "' . site_url('/') . 'admin/remove_featured_image/' . $type . '/"+id ,
							success: function (data) {


							}
						});

					}
				  </script>';
	}


	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_featured_image()
	{
		//error_reporting(E_ALL);
		$img = $this->input->post('userfile', TRUE);
		$id = $this->input->post('type_id', TRUE);
		$type = $this->input->post('type', TRUE);
		//upload file
		$config['upload_path'] = BASE_URL . 'assets/images/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '12000';
		$config['max_width'] = '8324';
		$config['max_height'] = '8550';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		//$config['file_name']  = trim(substr($img, 0, 80));

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {

			$data['error'] = $this->upload->display_errors();

			echo "<script>
					$.noty.closeAll()
					var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
				  	noty(options);
					
					</script>";
		} else {
			//LOAD library
			$this->load->library('image_lib');

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file, (strlen($file) - 4), 4);
			$str = substr($file, 0, (strlen($file) - 4));

			if (($width > 1950) || ($height > 900)) {

				//$this->load->model('image_model'); 
				//$this->image_model->downsize_image($file, '1920', '1024');

			}

			//$this->load->model('s3_model');
			//$this->s3_model->upload_s3('assets/images/' . $file);

			$cdn = $this->UploudToNMHS3(base_url('assets/images/' . $file), 'mynamibia-eu/cms/assets/images', $file, false);

			$file = str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/images/', '', $cdn->filePath);


			//populate array with values
			$data = array(
				'img_file' => $file,
				'bus_id' => $this->session->userdata('bus_id'),
				'type' => $type,
				'type_id' => $id
			);

			$this->db->insert('images', $data);

			$item_id = $this->db->insert_id();

			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = $cdn->filePath;
			//redirect 
			$data['basicmsg'] = 'Image added successfully!';
			$str = '<div id="feat_img"><div class="img-polaroid"><img src="' . $image . '" /><p style="padding:10px 10px 0px 0px;text-align:right"><a href="' . site_url('/') . 'my_images/edit/' . rawurlencode($this->encrypt->encode('assets/images/' . $file, $this->config->item('encryption_key'), TRUE)) . '" style="margin-right:5px" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a><a href="javascript:void(0);" onclick="remove_img(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
			echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#feat_img').html('" . $str . "');
					  $('#add-img').fadeOut();
					  </script>";
		}
	}
	function UploudToNMHS3($fileURL, $S3Dir, $filename_Plus_Extension)
	{
		$query = http_build_query(array(
			'fileURL' => $fileURL,
			'S3Dir' => $S3Dir,
			'filename_Plus_Extension' => $filename_Plus_Extension,
			'SecretKey' => 'NMHServer123FilesAKIA44MUTREB73NBQLK7'
		));

		$ch = curl_init('https://cdn.nmh.com.na:2083/api/Upload' . '?' . $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return json_decode($response);
	}

	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_featured_logo()
	{
		$img = $this->input->post('userfile', TRUE);
		$id = $this->input->post('type_id', TRUE);
		$type = $this->input->post('type', TRUE);

		//upload file
		$config['upload_path'] = BASE_URL . 'assets/images/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '12000';
		$config['max_width'] = '8324';
		$config['max_height'] = '8550';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		//$config['file_name']  = trim(substr($img, 0, 80));

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {

			$data['error'] = $this->upload->display_errors();

			echo "<script>
					$.noty.closeAll()
					var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
				  	noty(options);

					</script>";
		} else {
			//LOAD library
			$this->load->library('image_lib');

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file, (strlen($file) - 4), 4);
			$str = substr($file, 0, (strlen($file) - 4));

			if (($width > 1950) || ($height > 900)) {

				$this->load->model('image_model');
				$this->image_model->downsize_image($file, '1800', '1000');
			}

			//populate array with values
			$data = array(
				'img_file' => $file,
				'bus_id' => $this->session->userdata('bus_id'),
				'type' => $type,
				'type_id' => $id
			);

			$this->db->insert('images', $data);

			$item_id = $this->db->insert_id();

			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = S3_URL . 'assets/images/' . $file;
			//redirect
			$data['basicmsg'] = 'Logo added successfully!';
			$str = '<div id="feat_logo"><div class="img-polaroid"><img src="' . $image . '" /><p style="padding:10px 10px 0px 0px;text-align:right"><a href="' . site_url('/') . 'my_images/edit/' . rawurlencode($this->encrypt->encode('assets/images/' . $file, $this->config->item('encryption_key'), TRUE)) . '" style="margin-right:5px" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a><a href="javascript:void(0);" onclick="remove_logo(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
			echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#feat_logo').html('" . $str . "');
					  $('#add-logo').fadeOut();
					  </script>";
		}
	}



	//+++++++++++++++++++++++++++
	//GET DASHBOARD SYSTEM LOGS
	//++++++++++++++++++++++++++		 

	function get_system_logs()
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('bus_id', $bus_id);
		$this->db->order_by('datetime', 'DESC');
		$this->db->limit('10');
		$query = $this->db->get('admin_log');
		echo '<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>System Log</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">';
		if ($query->result()) {

			echo '<ul class="tickets">';
			foreach ($query->result() as $row) {

				echo substr($row->type, 0, strpos('-', $row->type, 0));


				echo '<li class="ticket">
											<a href="#">
												<span class="header">
													<span class="title">' . substr($row->type, 0, strpos($row->type, '-')) . '</span>
													<span class="number">[ #' . $row->log_id . ' ]</span>
												</span>	
												<span class="content">
													
													<span class="name">' . $row->name . '</span>
													
													<span class="date">' . date('jS \of F Y h:i:s A', strtotime($row->datetime)) . '</span>
												</span>	                                                        
											</a>
										</li>';
			}
			echo '</ul>';
		}

		echo '
					</div>
				</div><!--/span-->';
	}


	//+++++++++++++++++++++++++++
	//GET EMAIL LOGO
	//++++++++++++++++++++++++++		 

	function get_email_logo()
	{


		$this->load->model('my_namibia_model');

		$query = $this->my_namibia_model->get_info();

		if ($query != '') {


			$img = $query['BUSINESS_LOGO_IMAGE_NAME'];
			//Build image string
			$format = substr($img, (strlen($img) - 4), 4);
			$str = substr($img, 0, (strlen($img) - 4));

			if ($img != '') {

				if (strpos($img, '.') == 0) {

					$format = '.jpg';
					$fake_file = '<img src="' . NA_URL . 'img/timbthumb.php?w=100&h=100&src=' . NA_URL . 'assets/business/photos/' . $img . $format . '" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
				} else {

					$fake_file = '<img src="' . NA_URL . 'img/timbthumb.php?w=100&h=100&src=' . NA_URL . 'assets/business/photos/' . $img . '" style="border:3px solid #FFF; float:left;width:auto;margin:10px 20px 15px 20px" />';
				}
			} else {

				$fake_file = '<img src="' . NA_URL . 'img/timbthumb.php?w=100&h=100&src=' . NA_URL . 'img/bus_blank.png" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
			}
			echo $fake_file;
		} else {

			echo '<img src="' . NA_URL . 'img/logo_nav.png" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL ENQUIRIES
	//++++++++++++++++++++++++++
	public function get_all_feedback()
	{
		$bus_id = $this->session->userdata('bus_id');
		$role = $this->session->userdata('role');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('list_date', 'DESC');
		$query = $this->db->get('feedback');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal">Ref no.</th>
						<th style="width:20%;font-weight:normal">From</th>
						<th style="width:20%;font-weight:normal">Type</th>
						<th style="width:15%;font-weight:normal">Date</th>
						<th style="width:10%;font-weight:normal">Status</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				switch ($row->status) {
					case 'open':
						$status_icn = '<span class="label label-important">open</span>';
						break;
					case 'review':
						$status_icn = '<span class="label label-warning">review</span>';
						break;
					case 'pre-closure':
						$status_icn = '<span class="label label-warning">pre closure</span>';
						break;
					case 'closure':
						$status_icn = '<span class="label label-warning">closure</span>';
						break;
					case 'closed':
						$status_icn = '<span class="label label-success">closed</span>';
						break;
				}

				echo '<tr>
						<td style="width:2%"></td>
						<td style="width:10%">' . $row->ref_no . '</td>
						<td style="width:30%">' . $row->email . '</td>
						<td style="width:20%">' . $row->type . '</td>
						<td style="width:15%">' . date("d-m-y g:i a", strtotime($row->list_date)) . '</td>
						<td style="width:10%">' . $status_icn . '</td>
						<td style="width:10%;text-align:right">
						<a title="Manage Message" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="' . site_url('/') . 'admin/update_feedback/' . $row->msg_id . '"><i class="icon-pencil"></i></a>
						';

				if ($role == 'feedback_update' || $role == 'feedback_closure') {
					echo
						'<a title="Delete Enquiry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_message(' . $row->msg_id . ')"><i class="icon-trash icon-white"></i></a>
							';
				}
				echo
					'
						</td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Enquiries Found</h3>
					No enquiries have been made. Once the contact form has been used it will show the enquiry here</div>';
		}
	}









	//+++++++++++++++++++++++++++
	//GET ALL ENQUIRIES
	//++++++++++++++++++++++++++
	public function get_all_enquiries()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'DESC');
		$query = $this->db->get('enquiries');

		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal">From</th>
						<th style="width:53%;font-weight:normal">Type </th>
						<th style="width:15%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr>
							<td style="width:2%"></td>
							<td style="width:20%">' . $row->name . '<br /><font style="font-size:10px;">' . $row->email . '</font></td>
							<td style="width:53%">' . $row->type . '</td>
							<td style="width:15%">' . date("m-d-y g:i a", strtotime($row->datetime)) . '</td>
							<td style="width:10%;text-align:right">
							<a title="View Enquiry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
							onclick="view_enquiry(' . $row->enq_id . ')"><i class="icon-zoom-in"></i></a>
							<a title="Delete Enquiry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_enquiry(' . $row->enq_id . ')">
							<i class="icon-trash icon-white"></i></a></td>
						  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Enquiries Found</h3>
					No enquiries have been made. Once the contact form has been used it will show the enquiry here</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET SUPPORT MESAGES
	//++++++++++++++++++++++++++
	public function get_chat_content($ticket)
	{

		//$user_name = $this->session->userdata('user_name');
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM live_chat WHERE bus_id = '" . $bus_id . "' AND ticket_id = '" . $ticket . "'", FALSE);

		if ($query->result()) {

			$row = $query->row();


			foreach ($query->result() as $row) {


				echo '<tr><td><strong>' . $row->user . '</strong><br>' . $row->message . '</td></tr>';
			}
		}
	}

	//+++++++++++++++++++++++++++
	//ADD MESSAGE
	//++++++++++++++++++++++++++	
	public function add_quick_message()
	{
		$user = 'helpdesk';
		$bus_id = $this->session->userdata('bus_id');
		$message = $this->input->post('chat_body', TRUE);
		$ticket = $this->input->post('ticket', TRUE);


		$insertmessage = array(
			'bus_id' => $bus_id,
			'user' => $user,
			'ticket_id' => $ticket,
			'message' => $message

		);

		$this->db->insert('live_chat', $insertmessage);
	}

	//+++++++++++++++++++++++++++
	//GET ALL TICKETS
	//++++++++++++++++++++++++++
	public function get_all_tickets()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('listing_date', 'DESC');
		$query = $this->db->get('support_tickets');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:10%;font-weight:normal">Ticket No.</th>
						<th style="width:53%;font-weight:normal">User </th>
						<th style="width:15%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				switch ($row->status) {

					case 'active':
						$status = "success";
						break;
					case 'pending':
						$status = "warning";
						break;
					case 'closed':
						$status = "danger";
						break;
				}

				echo '<tr>
						<td style="width:2%"></td>
						<td style="width:5%"><span class="badge badge-' . $status . '">' . $row->status . '</span></td>
						<td style="width:10%">' . $row->ticket_id . '</td>
						<td style="width:50%">' . $row->email . '</td>
						<td style="width:15%">' . date("m-d-y g:i a", strtotime($row->listing_date)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="View Ticket" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="view_ticket(' . $row->ticket_id . ')"><i class="icon-zoom-in"></i></a>
						<a title="Delete Ticket" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_ticket(' . $row->ticket_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Tickets Found</h3>
					No tickets available at this moment.
					</div>';
		}
	}




	//+++++++++++++++++++++++++++
	//REPLY ENQUIRY
	//++++++++++++++++++++++++++
	public function reply_enquiry()
	{
		$email = $this->input->post('email', TRUE);
		$name = $this->input->post('name', TRUE);
		$msg = $this->input->post('content', TRUE);
		$id = $this->input->post('enq_id', TRUE);

		//VALIDATE INPUT
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$val = FALSE;
			$error = 'Email address is not valid.';
		} else {
			$val = TRUE;
		}

		$settings = $this->get_settings();
		//IF VALIDATED
		if ($val == TRUE) {

			//BUILD EMAIL BODY
			$msg_final = 'Hi, ' . ucwords($name) . ' <br /><br /> 
							  ' . $msg . '<br /><br />
							  
							  Have a great day<br /><br />
							  ' . $settings['title'] . '<br /><br />';
			$view['email'] = $email;
			$view['body'] = $msg_final;

			$data1 = array(
				'name' => $settings['title'],
				'email' => $settings['contact_email'],
				'body' => $this->load->view('email/body_news', $view, TRUE),
				'type' => 'enquiry',
				'email_to' => $email,
				'subject' => 'Enquiry from ' . $name
			);
			//GET WHK LOCAL DATE
			date_default_timezone_set('Africa/Windhoek');
			$time = date("r"); // local time
			$insertdata1 = array(
				'body' => $msg,
				'status' => 'replied'


			);
			//SEND EMAIL LINK
			$this->load->model('email_model');
			$this->email_model->send_enquiry($data1);
			//Update DB
			$this->db->where('enq_id', $id);
			$this->db->update('enquiries', $insertdata1);


			$data['basicmsg'] = 'Thanks, ' . $settings['title'] . '! We have succesfully replied.';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>
					<script type="text/javascript">
					
					</script>
					';

			//IF NOT VALIDATED	
		} else {

			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL PARENTS SELECT
	//++++++++++++++++++++++++++
	public function parent_page_list()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('page_parent', '0');
		$query = $this->db->get('pages');
		if ($query->result()) {
			echo '<div class="control-group"><label class="control-label" for="page_parent">Parent:</label>
		<div class="controls">
		<select name="page_parent" class="span6"><option value="Null">None</option>';

			foreach ($query->result() as $row) {
				print '<option value="' . $row->page_id . '">' . $row->title . '</option>';
			}

			echo '</select>
		</div>
		</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL PARENTS SELECT
	//++++++++++++++++++++++++++	
	public function slct_parent_page_list($pid, $page_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('pages');
		if ($query->result()) {
			echo '<div class="control-group"><label class="control-label" for="page_parent">Parent:</label>
		<div class="controls">
		<select name="page_parent" class="span6"><option value="Null">None</option>';

			foreach ($query->result() as $row) {

				$selected = '';
				if ($pid == $row->page_id) {
					$selected = 'selected="selected"';
				}
				if ($page_id != $row->page_id) {
					print '<option value="' . $row->page_id . '" ' . $selected . '>' . $row->title . '</option>';
				}
			}

			echo '</select>
		<span class="help-block" style="font-size:11px">Select a parent page or leave none to keep as a main page</span>
		</div>
		</div>';
		}
	}


	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function get_page_features($page_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$config = $this->db->select('components');
		$config = $this->db->where('bus_id', $bus_id);
		$config = $this->db->get('config');

		$sidebar_comp = "";

		if ($config->result()) {

			$rowc = $config->row();

			$components = $rowc->components;

			if (strpos($components, 'sidebars') !== false) {
				$sidebar_comp = 'checked';
			}

			if (strpos($components, 'people') !== false) {
				$people_comp = 'checked';
			}
		}


		$query = $this->db->select('page_features');
		$query = $this->db->where('page_id', $page_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('pages');

		if ($query->result()) {

			$row = $query->row();

			$downloads_checked = "";
			$sidebars_checked = "";
			$people_checked = "";


			if ($row->page_features == '') {
				$pf = array();
			} else {
				$pf = json_decode($row->page_features);
			}



			if (in_array("sidebars", $pf)) {
				$sidebars_checked = 'checked';
			}

			if (in_array("downloads", $pf)) {
				$downloads_checked = 'checked';
			}

			if (in_array("people", $pf)) {
				$people_checked = 'checked';
			}

			echo '<input name="p_downloads" type="checkbox" value="downloads" id="page_downloads" ' . $downloads_checked . ' > Downloads&nbsp;&nbsp;&nbsp;';

			if ($sidebar_comp == "checked") {
				echo '<input name="p_sidebars" type="checkbox" value="sidebars" id="page_sidebars" ' . $sidebars_checked . ' > Sidebars&nbsp;&nbsp;&nbsp;';
			}

			if ($people_comp == "checked") {
				echo '<input name="p_people" type="checkbox" value="people" id="page_people" ' . $people_checked . ' > People&nbsp;&nbsp;&nbsp;';
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function check_page_feature($feature, $page_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->select('page_features');
		$query = $this->db->where('page_id', $page_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('pages');

		if ($query->result()) {

			$row = $query->row();

			if ($row->page_features == '') {
				$pf = array();
			} else {
				$pf = json_decode($row->page_features);
			}

			if (in_array($feature, $pf)) {
				return $feature;
			} else {
				return 'false';
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET PAGE TEMPLATES
	//++++++++++++++++++++++++++	
	public function get_page_templates($page_template="")
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('page_templates');

		echo '<div class="control-group">
			<label class="control-label" for="page_template">Page Template</label>
			  <div class="controls">
				  <select id="page_temp_div" name="page_template" class="span6">
					<option value="Null">None</option>';

		if ($query->result()) {

			foreach ($query->result() as $row) {

				$str = '';
				if ($page_template == $row->page_template) {

					$str = 'selected';
				}

				echo '<option value="' . $row->page_template . '" ' . $str . '>' . ucwords($row->page_template) . '</option>';
			}
		}
		//DEFAULT
		$str1 = '';
		$str2 = '';
		$str3 = '';
		$str4 = '';
		$str5 = '';

		if ($page_template == 'full_width') {
			$str1 = ' selected';
		} elseif ($page_template == 'home') {
			$str2 = ' selected';
		} elseif ($page_template == 'contact') {
			$str3 = ' selected';
		} elseif ($page_template == 'gallery') {
			$str4 = ' selected';
		} elseif ($page_template == 'blogroll') {
			$str5 = ' selected';
		}

		echo ' 
					  <option value="full_width" ' . $str1 . '>Full Width Page</option>
					  <option value="home" ' . $str2 . '>Home Page</option>
					  <option value="contact" ' . $str3 . '>Contact Page</option>
					  <option value="gallery" ' . $str4 . '>Gallery Page</option>
					  <option value="blogroll" ' . $str5 . '>News Page</option>
						';




		echo ' </select>
					<span class="help-block" style="font-size:11px">Set what kind of page this needs to be</span>
				</div>
		  </div>';
	}

	//+++++++++++++++++++++++++++
	//GET POST TEMPLATES
	//++++++++++++++++++++++++++
	public function get_post_templates($post_template = '')
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('post_templates');

		echo '<div class="control-group">
			<label class="control-label" for="post_template">Post Template</label>
			  <div class="controls">
				  <select id="post_temp_div" name="post_template" class="span6">
					<option value="Null">None</option>';

		if ($query->result()) {

			foreach ($query->result() as $row) {

				$str = '';
				if ($post_template == $row->post_template) {

					$str = 'selected';
				}

				echo '<option value="' . $row->post_template . '" ' . $str . '>' . ucwords($row->post_template) . '</option>';
			}
		}



		echo ' </select>
					<span class="help-block" style="font-size:11px">Set what kind of post this needs to be</span>
				</div>
		  </div>';
	}


	//+++++++++++++++++++++++++++
	//GET ALL BOOKINGS
	//++++++++++++++++++++++++++
	public function get_all_bookings()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('arrival', 'ASC');
		$query = $this->db->get('bookings');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:20%;font-weight:normal">Name </th>
						<th style="width:20%;font-weight:normal">Email </th>
						<th style="width:10%;font-weight:normal">Payment </th>
						<th style="width:10%;font-weight:normal">Status </th>
						<th style="width:10%;font-weight:normal">Arrive </th>
						<th style="width:10%;font-weight:normal">Depart </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				if ($row->type == 'enquiry') {

					$type = "'type'";
					$str = "'confirmed'";
					$status = '<a href="javascript:void(0)" 
					onclick="update_booking_status(' . $row->booking_id . ', ' . $str . ',' . $type . ')">
					<span class="badge badge-warning">Enquiry</span></a>';
				} elseif ($row->type == 'confirmed') {

					$type = "'type'";
					$str = "'enquiry'";
					$status = '<a href="javascript:void(0)" 
					onclick="update_booking_status(' . $row->booking_id . ', ' . $str . ',' . $type . ')"><span class="badge badge-success">Confirmed</span></a>';
				} else {

					$type = "'type'";
					$str = "'confirmed'";
					$status = '<a href="javascript:void(0)" 
					onclick="update_booking_status(' . $row->booking_id . ', ' . $str . ',' . $type . ')"><span class="badge badge-warning">Enquiry</span></a>';
				}
				if ($row->status == 'paid') {

					$type2 = "'status'";
					$str2 = "'unpaid'";
					$payment = '<a href="javascript:void(0)" 
					onclick="update_booking_status(' . $row->booking_id . ', ' . $str2 . ',' . $type2 . ')"><span class="badge badge-success">Paid</span></a>';
				} else {

					$type2 = "'status'";
					$str2 = "'paid'";
					$payment = '<a href="javascript:void(0)" 
					onclick="update_booking_status(' . $row->booking_id . ', ' . $str2 . ',' . $type2 . ')"><span class="badge badge-important">Unpaid</span></a>';
				}
				echo '<tr>
						
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_booking/' . $row->gal_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->name . '</div></a></td>
            			<td style="width:20%">' . $row->email . '</td>
						<td style="width:10%">' . $payment . '</td>
						<td style="width:10%">' . $status . '</td>
						<td style="width:10%">' . date('Y-m-d', strtotime($row->arrival)) . '</td>
						<td style="width:10%">' . date('Y-m-d', strtotime($row->departure)) . '</td>
						<td style="width:20%;text-align:right;min-width:200px">
						<a title="View Enquiry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="view_enquiry(' . $row->enquiry_id . ')"><i class="icon-zoom-in"></i></a>
						
						<a title="Delete Booking" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_booking(' . $row->booking_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Bookings added</h3>
					No bookings have been made. You will receive email confirmation of new bookings made.</div>';
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL PRODUCT CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_product_categories($cat)
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('cat_id', 'ASC');
		$query = $this->db->get('product_categories');
		if ($query->result()) {

			foreach ($query->result() as $row) {

				if ($cat == 0) {

					echo '<option onclick="load_sub_cats(' . $row->cat_id . ')"  value="' . $row->cat_id . '">' . $row->cat_name . '</option>';
				} else {

					if ($cat == $row->cat_id) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}

					echo '<option onclick="load_sub_cats(' . $row->cat_id . ')"  value="' . $row->cat_id . '" ' . $selected . '>' . $row->cat_name . '</option>';
				}
			}
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL PRODUCT CATEGORIES TYPES
	//++++++++++++++++++++++++++
	public function get_all_product_category_types($check, $tid, $id)
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('cat_id', $id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('cat_type_id', 'ASC');
		$query = $this->db->get('product_category_types');
		if ($query->result()) {


			foreach ($query->result() as $row) {

				if ($check == 0) {

					echo '<option value="' . $row->cat_type_id . '">' . $row->cat_type_name . '</option>';
				} else {

					if ($tid == $row->cat_type_id) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}

					echo '<option value="' . $row->cat_type_id . '" ' . $selected . '>' . $row->cat_type_name . '</option>';
				}
			}
		} else {
			echo '<option value="0">No Category Types</option>';
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
		if ($query->result()) {

			foreach ($query->result() as $row) {

				if ($mid == '') {

					echo '<option value="' . $row->slug . '">' . $row->manufacturer . '</option>';
				} else {

					if ($mid == $row->slug) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}

					echo '<option value="' . $row->slug . '" ' . $selected . '>' . $row->manufacturer . '</option>';
				}
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++   

	function get_product($product_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('product_id', $product_id);
		$test = $this->db->get('products');
		return $test->row_array();
	}

	//+++++++++++++++++++++++++++
	//GET NEXT PRODUCT ID
	//++++++++++++++++++++++++++   

	function get_next_product_id($product_id)
	{


		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '" . $bus_id . "' AND product_id > '" . $product_id . "' ORDER BY product_id ASC LIMIT 1", FALSE);



		if ($query->result()) {

			$row = $query->row();

			return $row->pid;
		} else {

			$query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '" . $bus_id . "'", FALSE);

			$row2 = $query2->row();

			return $row2->minpid;
		}
	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++   

	function get_next_product($product_id)
	{


		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '" . $bus_id . "' AND product_id > '" . $product_id . "' ORDER BY product_id ASC LIMIT 1", FALSE);



		if ($query->result()) {

			$row = $query->row();


			echo '<a href="' . site_url('/') . 'admin/update_product/' . $row->pid . '" class="btn btn-inverse btn">View Next Product</a>';
		} else {

			$query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '" . $bus_id . "'", FALSE);

			$row2 = $query2->row();

			echo '<a href="' . site_url('/') . 'admin/update_product/' . $row2->minpid . '" class="btn btn-inverse btn">View Next Product</a>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++   

	function get_prev_product($product_id)
	{


		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '" . $bus_id . "' AND product_id < '" . $product_id . "' ORDER BY product_id DESC LIMIT 1", FALSE);



		if ($query->result()) {

			$row = $query->row();


			echo '<a href="' . site_url('/') . 'admin/update_product/' . $row->pid . '" class="btn btn-inverse btn">View Prev Product</a>&nbsp;';
		} else {

			$query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '" . $bus_id . "'", FALSE);

			$row2 = $query2->row();

			echo '<a href="' . site_url('/') . 'admin/update_product/' . $row2->maxpid . '" class="btn btn-inverse btn">View Prev Product</a>&nbsp;';
		}
	}

	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++   

	function get_next_product3($product_id)
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->select_min('product_id', 'minprod');
		$query = $this->db->select_max('product_id', 'maxprod');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('products');


		if ($query->result()) {

			$row = $query->row();

			if ($product_id < $row->maxprod) {

				$nxtprod = $product_id + 1;

				echo '<a href="' . site_url('/') . 'admin/update_product/' . $nxtprod . '" class="btn btn-inverse btn pull-right">View Next Product</a>';
			} else {

				$nxtprod = $row->minprod;

				echo '<a href="' . site_url('/') . 'admin/update_product/' . $nxtprod . '" class="btn btn-inverse btn pull-right">View Next Product</a>';
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL PRODUCTS
	//++++++++++++++++++++++++++
	public function get_all_products()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('listing_date', 'ASC');
		$query = $this->db->get('products');
		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Manufacturer </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-' . $row->product_id . '">
						<td style="width:6%">' . $status . '</td>
						<td style="width:30%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_product/' . $row->product_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
						<td style="width:20%">' . $row->manufacturer . '</td>
						<td style="width:10%">' . date('Y-m-d', strtotime($row->listing_date)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="Edit product" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_product/' . $row->product_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Product" rel="tooltip" class="btn btn-mini btn-danger rmv" style="cursor:pointer" onclick="delete_product(' . $row->product_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Products added</h3>
					No products have been added. to add a new product please click on the add product button on the right</div>';
		}
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
		if ($query->result()) {
			echo '
	
			<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Manufacturer </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr class="myDragClass">
					  <input type="hidden" value="' . $row->manufacturer_id . '" />
						<td style="width:6%">' . $row->manufacturer_id . '</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->manufacturer . '</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Manufacturer" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_manufacturer(' . $row->manufacturer_id . ')">
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
									console.log(manufacturer_id+" "+index);
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_manufacturer_sequence/"+manufacturer_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

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

		if ($result1->num_rows() == 0) {

			$insertdata = array(
				'manufacturer' => $manufacturer,
				'slug' => $slug,
				'bus_id' => $bus_id,
			);

			$this->db->insert('product_manufacturer', $insertdata);
		}
	}

	//Get Main Manufacturers Typehead
	function load_manufacturer_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('product_manufacturer');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->manufacturer_id;
			$cat = $row->manufacturer;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $cat . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}



	//+++++++++++++++++++++++++++
	//GET RECIPE PRODUCTS LIST
	//++++++++++++++++++++++++++
	public function get_recipe_products()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->select('title');
		$query = $this->db->select('product_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('products');
		if ($query->result()) {


			foreach ($query->result() as $row) {


				echo '<option value="' . $row->product_id . '">' . $row->title . '</option>';
			}
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_recipe_categories()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('recipe_categories');
		if ($query->result()) {
			echo '
	
			<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr class="myDragClass">
						<input type="hidden" value="' . $row->cat_id . '" />
						<td style="width:6%">' . $row->cat_id . '</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_recipe_category(' . $row->cat_id . ')">
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
										
										url: "' . site_url('/') . 'admin/update_recipe_cat_sequence/"+cat_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';
		}
	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY
	//++++++++++++++++++++++++++		 

	function get_recipe_category($cat_id)
	{

		$cat = $this->db->select('title');
		$cat = $this->db->where('cat_id', $cat_id);
		$cat = $this->db->get('recipe_categories');

		if ($cat->result()) {

			$row = $cat->row();

			return $row->title;
		} else {

			return 'none';
		}
	}



	//+++++++++++++++++++++++++++
	//GET RECIPECATEGORY OPTION LIST
	//++++++++++++++++++++++++++
	public function get_recipe_category_option_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('recipe_categories');
		if ($query->result()) {


			foreach ($query->result() as $row) {
				echo '<option value="' . $row->cat_id . '">' . $row->title . '</option>';
			}
		} else {
		}
	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION SELECT LIST
	//++++++++++++++++++++++++++
	public function get_recipe_category_option_select_list($id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('recipe_categories');
		if ($query->result()) {


			foreach ($query->result() as $row) {

				if ($id == $row->cat_id) {
					$sel = 'selected';
				} else {
					$sel = '';
				}

				echo '<option value="' . $row->cat_id . '" ' . $sel . '>' . $row->title . '</option>';
			}
		} else {
		}
	}



	//+++++++++++++++++++++++++++
	//GET RECIPE DETAILS
	//++++++++++++++++++++++++++		 

	function get_recipe($recipe_id)
	{

		$test = $this->db->where('recipe_id', $recipe_id);
		$test = $this->db->get('recipes');
		return $test->row_array();
	}



	//+++++++++++++++++++++++++++
	//GET ALL PAGES
	//++++++++++++++++++++++++++
	public function get_all_recipes()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM recipes WHERE bus_id = '" . $bus_id . "' ORDER BY listing_date DESC");
		if ($query->result()) {



			echo '
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Listing Date </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_recipe/' . $row->recipe_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
						<td style="width:10%">' . date('M d Y', strtotime($row->listing_date)) . '</td>
						<td style="width:20%;text-align:right">
						<a title="Edit Recipe" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="' . site_url('/') . 'admin/update_recipe/' . $row->recipe_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Recipe" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_recipe(' . $row->recipe_id . ')">
						<i class="icon-trash icon-white"></i></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Recipes added</h3>
					No recipes have been added. to add a new recipe please click on the add recipe button on the right</div>';
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL PAGES
	//++++++++++++++++++++++++++
	public function get_all_ingredients($rid)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM recipe_ingredients WHERE bus_id = '" . $bus_id . "' AND recipe_id = '" . $rid . "' ORDER BY sequence ASC");
		if ($query->result()) {



			echo '
	
			<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title</th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {


				echo '<tr class="myDragClass">
					  <input type="hidden" value="' . $row->ingredient_id . '" />
						<td style="width:80%">' . $row->ingredient . '</td>
						<td style="width:20%;text-align:right">
						<a title="Edit Ingredient" rel="tooltip" class="btn btn-mini" style="cursor:pointer" onclick="open_update_ingredient(' . $row->ingredient_id . ',' . $rid . ')"><i class="icon-pencil"></i></a>
						<a title="Delete Ingredient" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_ingredient(' . $row->ingredient_id . ')">
						<i class="icon-trash icon-white"></i></a>
						</td>
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
									var ingredient_id = $(this).val(), index = i;
									console.log(ingredient_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_ingredient_sequence/"+ingredient_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Ingredients added</h3>
					No ingredients have been added. to add a new ingredient please enter the ingredient info in the text box and click on the add ingredient button</div>';
		}
	}




	function import_product_csv()
	{

		$bus_id = $this->session->userdata('bus_id');
		$csv = $this->input->post('csv', TRUE);

		//upload file
		$config['upload_path'] = BASE_URL . 'assets/csv/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '100000';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);


		// If upload failed, display error
		if (!$this->upload->do_upload()) {
			$data['error'] = $this->upload->display_errors();

			//$this->load->view('csvindex', $data);
			echo $data['error'];
		} else {

			$file_data = $this->upload->data();
			$file_path = BASE_URL . 'assets/csv/' . $file_data['file_name'];

			$this->load->library('csvimport');

			if ($this->csvimport->get_array($file_path)) {

				$csv_array = $this->csvimport->get_array($file_path);

				foreach ($csv_array as $row) {


					$slug = $this->clean_slug_str($row['title'], $replace = array(), $delimiter = '-', 'products');

					$insert_data = array(
						'bus_id' => $bus_id,
						'sku_code' => $row['sku_code'],
						'category' => $row['category'],
						'category_type' => $row['category_type'],
						'manufacturer' => $row['manufacturer'],
						'title' => $row['title'],
						'slug' => $slug,
						'sale_price' => $row['sale_price'],
						'start_price' => $row['start_price'],
						'special' => $row['special'],
						'featured' => $row['featured'],
						'top_seller' => $row['top_seller'],
						'custom' => $row['custom'],
						'new' => $row['new']

					);
					$this->db->insert('products', $insert_data);
				}
			} else {
			}
		}
	}




	//+++++++++++++++++++++++++++
	//GET PAGE PEOPLE 
	//++++++++++++++++++++++++++
	public function get_page_people($page_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('page_id', $page_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('page_people_int');

		if ($query->result()) {
			echo '<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Name </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				echo '<tr class="myDragClass" id="row-' . $row->id . '">
						<input type="hidden" value="' . $row->id . '" />
						<td style="width:80%"><div style="top:0;left:0;right:0;bottom:0;border:none">' . $row->name . '</div></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_page_people(' . $row->id . ')">
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
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "' . site_url('/') . 'admin/update_page_people_sequence/"+id+"/' . $page_id . '/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
		} else {

			echo '<div class="alert">
			 		<h3>No Day Destinations added</h3>
					No day destinations have been added.
				   </div>';
		}
	}



	//+++++++++++++++++++++++++++
	//GET PEOPLE SELECT
	//++++++++++++++++++++++++++
	public function get_people_select()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		if ($query->result()) {

			foreach ($query->result() as $row) {
				echo '<option value="' . $row->people_id . '">' . $row->name . ' ' . $row->lname . '</option>';
			}
		} else {

			echo '';
		}
	}


	//+++++++++++++++++++++++++++
	//ADD PAGE PEOPLE DO
	//++++++++++++++++++++++++++

	public function add_page_people_do()
	{

		$bus_id = $this->session->userdata('bus_id');
		//INSERT INTO TABLE
		$data['bus_id'] = $bus_id;

		$page_id = $this->input->post('page_id');
		$people_id = $this->input->post('people');


		//TEST DUPLICATE INTERSECTION
		$this->db->where('people_id', $people_id);
		$this->db->where('page_id', $page_id);
		$result = $this->db->get('page_people_int');


		if ($result->num_rows() == 0) {

			//GET NAME
			$this->db->select('lname');
			$this->db->select('name');
			$this->db->where('people_id', $people_id);
			$query = $this->db->get('people');
			$row = $query->row();
			$name = $row->name . ' ' . $row->lname;

			//INSERT INTO INTERSECTION TABLE		
			$data2['people_id'] = $people_id;
			$data2['page_id'] = $page_id;
			$data2['name'] = $name;
			$data2['bus_id'] = $bus_id;
			$this->db->insert('page_people_int', $data2);
		}
	}

	//+++++++++++++++++++++++++++
	//DELETE PAGE PEOPLE DO
	//++++++++++++++++++++++++++
	function delete_page_people_do($id)
	{

		if ($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');

			$this->db->where('bus_id', $bus_id);
			$this->db->where('id', $id);
			$this->db->delete('page_people_int');

			//LOG
			$this->admin_model->system_log('delete_page_person-' . $id);
			$this->session->set_flashdata('msg', 'Page Person deleted successfully');
		} else {

			redirect(site_url('/') . 'admin/logout/', 'refresh');
		}
	}






	//LOAD PEOPLE TYPEHEAD
	function load_people_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($query->result() as $row) {

			$id = $row->people_id;
			$cat = $row->name . ' ' . $row->lname;

			if ($x == ($query->num_rows() - 1)) {

				$str = '';
			} else {

				$str = ' , ';
			}

			$result .= "'" . $cat . "' " . $str;
			$x++;
		}

		$result .= '];';
		return $result;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $type, $replace = array(), $delimiter = '-')
	{
		if (!empty($replace)) {
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);

		if ($res->result()) {

			$clean = $clean . '-' . rand(0, 99);
			return $clean;
		} else {

			return $clean;
		}
	}

	//Shorten String
	function shorten_string($phrase, $max_words)
	{

		$phrase_array = explode(' ', $phrase);

		if (count($phrase_array) > $max_words && $max_words > 0) {

			$phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
		}

		return $phrase;
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+eNcryption Functions
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	/*Hash password*/

	function hash_password($username, $password)
	{

		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));

		// Prefix the password with the salt
		$hash = $salt . $password;

		// Hash the salted password a bunch of times
		for ($i = 0; $i < 100000; $i++) {
			$hash = hash('sha256', $hash);
		}

		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
	}


	/*Validate password*/

	function validate_password($username, $password)
	{


		/*$sql = $this->db->query("SELECT *
																																												  FROM `admin`
																																												WHERE
																																												 `email` = '".$username."' LIMIT 1",TRUE);*/
		$sql = $this->db->where('email', $username);
		$sql = $this->db->limit('1');
		$sql = $this->db->get('admin');

		$res = array();
		//SEE IF ROW EVEN EXISTS
		if ($sql->num_rows() > 0) {

			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['admin_id'] = $r['admin_id'];
			$res['img_file'] = $r['img_file'];
			$res['last_login'] = $r['last_login'];
			$res['bus_id'] = $r['bus_id'];
			$res['type'] = $r['type'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['pass'], 0, 64);

			$hash = $salt . $password;

			// Hash the password as we did before
			for ($i = 0; $i < 100000; $i++) {
				$hash = hash('sha256', $hash);
			}

			$hash = $salt . $hash;

			if ($hash == $r['pass']) {

				$res['bool'] = TRUE;
				//break;
			} else {

				$res['bool'] = FALSE;
			}
		} else { //no username match

			$res['bool'] = FALSE;
		}

		return $res;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace = array(), $delimiter = '-')
	{
		if (!empty($replace)) {
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
}