<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itinerary extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Itinerary()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('itinerary_model');
		//force_ssl();
	}
	
	 
//-------------------DESTINATIONS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD DESTINATIONS
	 //++++++++++++++++++++++++++
	 public function destinations()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/destinations/destinations');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD DESTINATION VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_destination()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/destinations/add_destination');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD DESTINATION DO
	 //+++++++++++++++++++++++++++
	 public function add_destination_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_destination_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 
	 

	 //++++++++++++++++++++++++++++
	 //LOAD UPDATE DESTINATION VIEW
	 //++++++++++++++++++++++++++++
	
	 public function update_destination($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_destination($id);
			   $this->load->view('admin/itineraries/destinations/update_destination', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE DESTINATION DO
	 //+++++++++++++++++++++++++++
	
	 public function update_destination_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_destination_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_destination($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_destination_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	
	
	
//-------------------ACCOMMODATIONS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD ACCOMMODATIONS
	 //++++++++++++++++++++++++++
	 public function accommodations()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/accommodations/accommodations');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD ACCOMMODATION VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_accommodation()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/accommodations/add_accommodation');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD ACCOMMODATION DO
	 //+++++++++++++++++++++++++++
	 public function add_accommodation_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_accommodation_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE ACCOMMODATION VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_accommodation($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_accommodation($id);
			   $this->load->view('admin/itineraries/accommodations/update_accommodation', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE ACCOMMODATION DO
	 //+++++++++++++++++++++++++++
	
	 public function update_accommodation_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_accommodation_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_accommodation($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_accommodation_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	
	
//-------------------HIGHLIGHTS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD HIGHLIGHTS
	 //++++++++++++++++++++++++++
	 public function highlights()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/highlights/highlights');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD HIGHLIGHT VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_highlight()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/highlights/add_highlight');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD HIGHLIGHT DO
	 //+++++++++++++++++++++++++++
	 public function add_highlight_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_highlight_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE HIGHLIGHT VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_highlight($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_highlight($id);
			   $this->load->view('admin/itineraries/highlights/update_highlight', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE HIGHLIGHT DO
	 //+++++++++++++++++++++++++++
	
	 public function update_highlight_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_highlight_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_highlight($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_highlight_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
//-------------------ACTIVITIES MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD ACTIVITIES
	 //++++++++++++++++++++++++++
	 public function activities()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/activities/activities');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD ACTIVITY VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_activity()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/activities/add_activity');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD ACTIVITY DO
	 //+++++++++++++++++++++++++++
	 public function add_activity_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_activity_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE ACTIVITY VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_activity($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_activity($id);
			   $this->load->view('admin/itineraries/activities/update_activity', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE ACTIVITY DO
	 //+++++++++++++++++++++++++++
	
	 public function update_activity_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_activity_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE ACTIVITY DO
	//++++++++++++++++++++++++++
	function delete_activity($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_activity_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	
	
	
//-------------------TOUR TYPE MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD TOUR TYPES
	 //++++++++++++++++++++++++++
	 public function tour_types()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/tour_types/tour_types');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD TOUR TYPE VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_tour_type()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/tour_types/add_tour_type');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD TOUR TYPE DO
	 //+++++++++++++++++++++++++++
	 public function add_tour_type_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_tour_type_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE TOUR TYPE VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_tour_type($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_tour_type($id);
			   $this->load->view('admin/itineraries/tour_types/update_tour_type', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE TOUR TYPE DO
	 //+++++++++++++++++++++++++++
	
	 public function update_tour_type_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_tour_type_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE TOUR TYPE DO
	//++++++++++++++++++++++++++
	function delete_tour_type($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_tour_type_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	//+++++++++++++++++++++++++++
	//UPDATE TOUR TYPE SEQUENCE
	//++++++++++++++++++++++++++
	public function update_tour_type_sequence($type_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('type_id' , $type_id);
			$this->db->update('i_tour_types', $data);

		
	}	
	
	
	
	
	
	
//-------------------SPECIAL MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD SPECIALS
	 //++++++++++++++++++++++++++
	 public function specials()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/specials/specials');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD SPECIAL VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_special()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/specials/add_special');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //ADD SPECIAL DO
	 //+++++++++++++++++++++++++++
	 public function add_special_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_special_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 } 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE SPECIAL VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_special($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_special($id);
			   $this->load->view('admin/itineraries/specials/update_special', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE SPECIAL DO
	 //+++++++++++++++++++++++++++
	
	 public function update_special_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_special_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE SPECIAL DO
	//++++++++++++++++++++++++++
	function delete_special($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_special_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	//+++++++++++++++++++++++++++
	//UPDATE SPECIAL SEQUENCE
	//++++++++++++++++++++++++++
	public function update_special_sequence($special_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('special_id' , $special_id);
			$this->db->update('i_tour_specials', $data);

		
	}	
	
	
	
	
	
	
	
	
	
	
	
//-------------------TOUR MANAGEMENT-------------------------//
//------------------------------------------------------------------// 

	 //+++++++++++++++++++++++++++
	 //LOAD TOURS
	 //++++++++++++++++++++++++++
	 public function tours()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/itineraries/tours');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD TOUR VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_tour()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/itineraries/add_tour');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //ADD TOUR DO
	 //+++++++++++++++++++++++++++
	 public function add_tour_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_tour_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 } 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE TOUR VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_tour($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_tour($id);
			   $this->load->view('admin/itineraries/update_tour', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE TOUR DO
	 //+++++++++++++++++++++++++++
	
	 public function update_tour_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_tour_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE TOUR DO
	//++++++++++++++++++++++++++
	function delete_tour($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_tour_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	//+++++++++++++++++++++++++++
	//UPDATE TOUR TYPE SEQUENCE
	//++++++++++++++++++++++++++
	public function update_tour_sequence($tour_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('tour_id' , $tour_id);
			$this->db->update('i_tours', $data);

		
	}		

	 //+++++++++++++++++++++++++++
	 //ADD TOUR HIGHLIGHT DO
	 //+++++++++++++++++++++++++++
	 public function add_tour_highlight()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_tour_highlight_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE TOUR HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_tour_highlight($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_tour_highlight_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//++++++++++++++++++++++++++++++
	//UPDATE TOUR HIGHLIGHT SEQUENCE
	//++++++++++++++++++++++++++++++
	public function update_tour_highlight_sequence($th_id, $tour_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('tour_id' , $tour_id);
			$this->db->where('th_id' , $th_id);
			$this->db->update('i_tour_highlights', $data);

		
	}


	//+++++++++++++++++++++++++++
	// RELOAD TOUR HIGHLIGHTS ALL
	//+++++++++++++++++++++++++++

	public function reload_tour_highlights_all($id)
	{
		$this->itinerary_model->get_tour_highlights($id);
		
	}










	//+++++++++++++++++++++++++++
	//ADD TOUR ACCOMMODATION DO
	//+++++++++++++++++++++++++++
	public function add_tour_accommodation()
	{
		if($this->session->userdata('admin_id')){

			$this->itinerary_model->add_tour_accommodation_do();

		}else{

			$this->load->view('admin/login');

		}
	}

	//+++++++++++++++++++++++++++
	//DELETE TOUR ACCOMMODATION DO
	//++++++++++++++++++++++++++
	function delete_tour_accommodation($id){

		if($this->session->userdata('admin_id')){

			$this->itinerary_model->delete_tour_accommodation_do($id);

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//++++++++++++++++++++++++++++++
	//UPDATE TOUR ACCOMMODATION SEQUENCE
	//++++++++++++++++++++++++++++++
	public function update_tour_accommodation_sequence($ta_id, $tour_id, $sequence)
	{

		$data['sequence'] = $sequence;

		$this->db->where('tour_id' , $tour_id);
		$this->db->where('ta_id' , $ta_id);
		$this->db->update('i_tour_accommodations', $data);


	}


	//+++++++++++++++++++++++++++
	// RELOAD TOUR HIGHLIGHTS ALL
	//+++++++++++++++++++++++++++

	public function reload_tour_accommodations_all($id)
	{
		$this->itinerary_model->get_tour_accommodations($id);

	}



	 //+++++++++++++++++++++++++++
	 //ADD TOUR DESTINATION DO
	 //+++++++++++++++++++++++++++
	 public function add_tour_destination()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_tour_destination_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE TOUR DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_tour_destination($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_tour_destination_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//++++++++++++++++++++++++++++++
	//UPDATE TOUR DESTINATION SEQUENCE
	//++++++++++++++++++++++++++++++
	public function update_tour_destination_sequence($th_id, $tour_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('tour_id' , $tour_id);
			$this->db->where('th_id' , $th_id);
			$this->db->update('i_tour_destinations', $data);

		
	}


	//+++++++++++++++++++++++++++
	// RELOAD TOUR DESTINATIONS ALL
	//+++++++++++++++++++++++++++

	public function reload_tour_destinations_all($id)
	{
		$this->itinerary_model->get_tour_destinations($id);
		
	}

	
	
	
	
	 //+++++++++++++++++++++++++++
	 //LOAD ADD ITINERARY VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_itinerary($id)
	 {
		  if($this->session->userdata('admin_id')){
			  
			   $data['tour_id'] = $id;
		   
			   $this->load->view('admin/itineraries/add_itinerary', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //ADD ITINERARY DO
	 //+++++++++++++++++++++++++++
	 public function add_itinerary_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_itinerary_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 } 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE ITINERARY VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_itinerary($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_itinerary($id);
			   $this->load->view('admin/itineraries/update_itinerary', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE ITINERARY DO
	 //+++++++++++++++++++++++++++
	
	 public function update_itinerary_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_itinerary_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE ITINERARY DO
	//++++++++++++++++++++++++++
	function delete_itinerary($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_itinerary_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	//++++++++++++++++++++++++++++++
	//UPDATE PRICE SEQUENCE
	//++++++++++++++++++++++++++++++
	public function update_price_sequence($price_id, $itinerary_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('itinerary_id' , $itinerary_id);
			$this->db->where('price_id' , $price_id);
			$this->db->update('i_prices', $data);

		
	}	

	 //+++++++++++++++++++++++++++
	 //LOAD ADD PRICE VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_price($tid, $id)
	 {
		  if($this->session->userdata('admin_id')){
			  
			   $data['tour_id'] = $tid;
			   $data['itinerary_id'] = $id;
		   
			   $this->load->view('admin/itineraries/add_price', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	
	//+++++++++++++++++++++++++++
	//ADD PRICE DO
	//++++++++++++++++++++++++++
	function add_price_do(){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->add_price_do();

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	 //+++++++++++++++++++++++++++
	 //LOAD UPDATE PRICE VIEW
	 //+++++++++++++++++++++++++++
	
	 public function update_price($id)
	 {
		  if($this->session->userdata('admin_id')){
			  
 			   $info = $this->itinerary_model->get_price($id);
			   $this->load->view('admin/itineraries/update_price', $info);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	
	//+++++++++++++++++++++++++++
	//UPDATE PRICE DO
	//++++++++++++++++++++++++++
	function update_price_do(){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->update_price_do();

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
		

	//+++++++++++++++++++++++++++
	//DELETE PRICE DO
	//++++++++++++++++++++++++++
	function delete_price($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_price_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	
	//+++++++++++++++++++++++++++
	// RELOAD PRICES ALL
	//+++++++++++++++++++++++++++

	public function reload_prices_all($id)
	{
		$this->itinerary_model->get_itinerary_prices($id);
		
	}		
	



	

	 //+++++++++++++++++++++++++++
	 //LOAD ADD DAY VIEW
	 //+++++++++++++++++++++++++++
	
	 public function add_day($tour_id, $itinerary_id, $type_id)
	 {
		  if($this->session->userdata('admin_id')){
			  
			   $data['tour_id'] = $tour_id;
			   $data['itinerary_id'] = $itinerary_id;
			   $data['type_id'] = $type_id;
		   
			   $this->load->view('admin/itineraries/add_day', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //ADD DAY DO
	 //+++++++++++++++++++++++++++
	 public function add_day_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_day_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 } 
	 

	 //++++++++++++++++++++++++++++++
	 //LOAD UPDATE DAY VIEW
	 //++++++++++++++++++++++++++++++
	
	 public function update_day($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $info = $this->itinerary_model->get_day($id);
			   $this->load->view('admin/itineraries/update_day', $info);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE DAY DO
	 //+++++++++++++++++++++++++++
	
	 public function update_day_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->update_day_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	 	  	



	//+++++++++++++++++++++++++++
	//DELETE DAY DO
	//++++++++++++++++++++++++++
	function delete_day($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_day_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//++++++++++++++++++++++++++++++
	//UPDATE DAY SEQUENCE
	//++++++++++++++++++++++++++++++
	public function update_day_sequence($day_id, $itinerary_id, $sequence)
	{		
		    $data['sequence'] = $sequence;
			
			$this->db->where('itinerary_id' , $itinerary_id);
			$this->db->where('day_id' , $day_id);
			$this->db->update('i_days', $data);

		
	}		
	




	 //+++++++++++++++++++++++++++
	 //ADD DAY DESTINATION DO
	 //+++++++++++++++++++++++++++
	 public function add_day_destination()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_day_destination_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE DAY DESTINAION DO
	//++++++++++++++++++++++++++
	function delete_day_destination($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_day_destination_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//+++++++++++++++++++++++++++++++
	//UPDATE DAY DESTINATION SEQUENCE
	//+++++++++++++++++++++++++++++++
	public function update_day_destination_sequence($id, $day_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('day_id' , $day_id);
			$this->db->where('id' , $id);
			$this->db->update('i_day_destinations', $data);

	}


	//++++++++++++++++++++++++++++
	// RELOAD DAY DESTINATIONS ALL
	//++++++++++++++++++++++++++++

	public function reload_day_destinations_all($id)
	{
		$this->itinerary_model->get_day_destinations($id);
		
	}
	
	
	
	
	
	
	 //+++++++++++++++++++++++++++
	 //ADD DAY HIGHLIGHT DO
	 //+++++++++++++++++++++++++++
	 public function add_day_highlight()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_day_highlight_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE DAY HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_day_highlight($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_day_highlight_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//+++++++++++++++++++++++++++++++
	//UPDATE DAY HIGHLIGHT SEQUENCE
	//+++++++++++++++++++++++++++++++
	public function update_day_highlight_sequence($id, $day_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('day_id' , $day_id);
			$this->db->where('id' , $id);
			$this->db->update('i_day_highlights', $data);

	}


	//++++++++++++++++++++++++++++
	// RELOAD DAY HIGHLIGHTS ALL
	//++++++++++++++++++++++++++++

	public function reload_day_highlights_all($id)
	{
		$this->itinerary_model->get_day_highlights($id);
		
	}	
	
	


	
	
	
	 //+++++++++++++++++++++++++++
	 //ADD DAY ACCOMMODATION DO
	 //+++++++++++++++++++++++++++
	 public function add_day_accommodation()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_day_accommodation_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//+++++++++++++++++++++++++++
	//DELETE DAY ACCOMMODATION DO
	//++++++++++++++++++++++++++
	function delete_day_accommodation($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_day_accommodation_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//++++++++++++++++++++++++++++++++
	//UPDATE DAY ACCOMODATION SEQUENCE
	//++++++++++++++++++++++++++++++++
	public function update_day_accommodation_sequence($id, $day_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('day_id' , $day_id);
			$this->db->where('id' , $id);
			$this->db->update('i_day_accommodations', $data);

	}


	//+++++++++++++++++++++++++++++
	// RELOAD DAY ACCOMMODATION ALL
	//+++++++++++++++++++++++++++++

	public function reload_day_accommodations_all($id)
	{
		$this->itinerary_model->get_day_accommodations($id);
		
	}	
	
	
	
	
	
	 //+++++++++++++++++++++++++++
	 //ADD DAY ACTIVITIES DO
	 //+++++++++++++++++++++++++++
	 public function add_day_activity()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->itinerary_model->add_day_activity_do();
		   
		  }else{
		   
		       $this->load->view('admin/login');
		   
		  }
	 }	
	 
	//++++++++++++++++++++++++++
	//DELETE DAY ACTIVITIES DO
	//++++++++++++++++++++++++++
	function delete_day_activity($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->itinerary_model->delete_day_activity_do($id);

		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	  


	//++++++++++++++++++++++++++++++++
	//UPDATE DAY ACTIVITY SEQUENCE
	//++++++++++++++++++++++++++++++++
	public function update_day_activity_sequence($id, $day_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('day_id' , $day_id);
			$this->db->where('id' , $id);
			$this->db->update('i_day_activities', $data);

	}


	//+++++++++++++++++++++++++++++
	// RELOAD DAY ACTIVITY ALL
	//+++++++++++++++++++++++++++++

	public function reload_day_activity_all($id)
	{
		$this->itinerary_model->get_day_activities($id);
		
	}	
	
	
	
	
		

	//+++++++++++++++++++++++++++
	//UPLOAD IMAGES
	//++++++++++++++++++++++++++
	
	function add_images()
	{
		if($this->session->userdata('admin_id')){
		
			$this->itinerary_model->add_images();
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE IMAGE
	//++++++++++++++++++++++++++

	public function update_image($img_id)
	{
		
		$query = $this->db->limit(1);	
		$query = $this->db->where('image_id', $img_id);	
		$query = $this->db->get('i_images');

		if($query->result()){
			
			$row = $query->row();
			
			$selected = '';
			
			if($row->featured == 'Y') { $selected = 'selected'; } else { $selected = ''; }
			if($row->featured == 'N') { $selected = 'selected'; } else { $selected = ''; }
			
			echo '<div class="row-fluid">
					<form id="image-update" name="image-update" method="post" action="'.site_url('/').'itinerary/update_image_do" >
                       <fieldset>
                        <input type="hidden" id="update_img_id" name="id" value="'.$row->image_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="img_title">Featured</label>
                              <div class="controls">
                                      <select class="span12" id="featured" name="featured">
									  	<option value="Y" '.$selected.'>Yes</option>
										<option value="N" '.$selected.'>No</option>
									  </select>
                              </div>
                        </div>						
                        <div class="control-group">
                              <label class="control-label" for="img_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_title" name="title" placeholder="Image title" value="'.$row->title.'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="content">Description</label>
                              <div class="controls">
                                      
									  <textarea name="content" class="redactor" style="display:block">'.$row->description.'</textarea>
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="img_title">URL</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_url" name="img_url" placeholder="URL" value="'.$row->img_url.'">
                              </div>
                        </div>						
						<input type="submit" id="update_img_but" value="Update Image" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					
					
					  $(".redactor").redactor({ 	
								  buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
								  "unorderedlist", "orderedlist", "outdent", "indent", "|","image",
								  "video", "table","|",
								   "alignment", "|", "horizontalrule"]
					  });
					
					$("#update_img_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#image-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'itinerary/update_image_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_images();
							  $("#modal-img-update").modal("hide");
							}
						  });
		
					});
				
				</script>
				
				';	
			
		}
			
	}	
	
	//+++++++++++++++++++++++++++
	//UPDATE IMAGE
	//++++++++++++++++++++++++++

	public function update_image_do()
	{
		if($this->session->userdata('admin_id')){
		
			$this->itinerary_model->update_image_do();
			
		}else{	
			
			redirect(site_url('/').'admin/logout/','refresh');
		
		}
			
	}	
	
	//+++++++++++++++++++++++++++
	//UPDATE IMAGE SEQUENCE
	//++++++++++++++++++++++++++
	public function update_img_sequence($img_id, $type, $type_id, $sequence)
	{
		
		    $data['sequence'] = $sequence;
			
			$this->db->where('type_id' , $type_id);
			$this->db->where('type' , $type);
			$this->db->where('image_id' , $img_id);
			$this->db->update('i_images', $data);

		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE IMAGE
	//++++++++++++++++++++++++++
	function delete_image($id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->itinerary_model->delete_image_do($id);
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	//+++++++++++++++++++++++++++
	//LOAD IMAGES
	//++++++++++++++++++++++++++
	
	function load_images($type, $type_id)
	{
		
		$this->itinerary_model->load_images($type, $type_id);
		
	}


	
	//+++++++++++++++++++++++++++
	//LOAD IMAGES UPDATE
	//++++++++++++++++++++++++++
	
	function load_images_update($type, $type_id)
	{
		
		$this->itinerary_model->load_images_update($type, $type_id);
		
	}
	
	
	//+++++++++++++++++++++++++++
	//LOAD DOCUMENTS UPDATE
	//++++++++++++++++++++++++++
	
	function load_documents_update($id)
	{
		
		$this->itinerary_model->load_documents_update($id);
		
	}
		
	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS 
	//++++++++++++++++++++++++++
	
	function plupload_server()
	{
		//Document is for distinguisj=hing between projects and normal documents
		$this->itinerary_model->plupload_server();
		
	}		
	
	//+++++++++++++++++++++++++++
	//DELETE DOCUMENT
	//++++++++++++++++++++++++++
	function update_document_do($id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->itinerary_model->update_document_do($id);
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	

	//+++++++++++++++++++++++++++
	//DELETE DOCUMENT
	//++++++++++++++++++++++++++
	function delete_document($id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->itinerary_model->delete_document_do($id);
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	

	
	//+++++++++++++++++++++++++++
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document($id)
	{
		
		$this->db->where('doc_id', $id);	
		$query = $this->db->get('i_tour_docs');

		if($query->result()){
			
			$row = $query->row_array();
			
			$selected = '';
			
			
			echo '<div class="row-fluid">
					<form id="doc-update" name="doc-update" method="post" action="'. site_url('/').'itinerary/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="id" value="'.$id.'" />					
                        <div class="control-group">
                              <label class="control-label" for="img_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_title" name="title" placeholder="Image title" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="content">Description</label>
                              <div class="controls">
                                      
									  <textarea name="content" class="redactor" style="display:block">'.$row['description'].'</textarea>
                              </div>
                        </div>
					
						<input type="submit" id="update_doc_but" value="Update Document" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					
					
					  $(".redactor").redactor({ 	
								  buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
								  "unorderedlist", "orderedlist", "outdent", "indent", "|","image",
								  "video", "table","|",
								   "alignment", "|", "horizontalrule"]
					  });
					
					$("#update_doc_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#doc-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'itinerary/update_document_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_documents();
							  $("#modal-doc-update").modal("hide");
							  
							}
						  });
		
					});
				
				</script>
				
				';	
			
		}
			
	}		








	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function add_featured_image()
	{
		if($this->session->userdata('admin_id')){
			
			$this->vacancy_model->add_featured_image();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//REMOVE FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function remove_featured_image($id)
	{
		$this->vacancy_model->remove_featured_image($id);
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