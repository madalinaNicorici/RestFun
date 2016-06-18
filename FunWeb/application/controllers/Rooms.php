<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Rooms extends REST_Controller 
{
	function __construct() {
		parent::__construct();
		$this->load->helper('my_api');
	}
	
	function room_get(){
		$room_id = $this->uri->segment(3);
		$this->load->model('Model_rooms');
		$room=$this->Model_rooms->get_by(array('room_id'=>$room_id));
		if(isset($room['room_id']))
		{
			$this->response(array('status'=>'success','message'=>$room));
		}
		else
		{
			$this->response(array('status'=>'failure','message'=>'The specified room could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}	
	}
	
	/*function room_put(){
		$data = $this->put();
		$this->load->model('Model_rooms');
		$room_id = $this->Model_rooms->insert($data);
		if(!$room_id)
		{
			$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the room'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else{
			$this->response(array('status'=>'success','message'=>'created'));
		}
		
		
	}*/
	
	function room_post(){
		$data = $this->post();
		$this->load->model('Model_rooms');
		$room_id = $this->Model_rooms->insert($data);
		if(!$room_id)
		{
			$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the room'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else{
			$this->response(array('status'=>'success','message'=>$room_id));
		}
		
	}
	
	function room_delete()
	{
		$room_id = $this->uri->segment(3);
		$this->load->model('Model_rooms');
		$room=$this->Model_rooms->get_by(array('room_id'=>$room_id));
		if(isset($room['room_id']))
		{
			$data['status']='deleted';
			$deleted = $this->Model_rooms->update($room_id,$data);
			if(!$deleted)
			{
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to delete the room'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else
			{
				$this->response(array('status'=>'success','message'=>'deleted'));
			}	
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified room could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
}