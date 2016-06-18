<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Scores extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('my_api');
	}

	function score_get(){
		$user_id = $this->uri->segment(3);
		$this->load->model('Model_scores');
		$score=$this->Model_scores->get_by(array('user_id'=>$user_id));
		if (isset($score['user_id'])){
			$this->response(array('status'=>'success','message'=>$score));
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified score could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	function score_put(){
		$data = $this->put();
		
		$this->load->model('Model_scores');
		$user_id=$this->Model_scores->insert($data);
		if(!$user_id){
			$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the score'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else{
			$this->response(array('status'=>'success','message'=>'created'));
		}
		
	}
	
	function score_post(){
		$this->load->model('Model_scores');
		$data=$this->post();
		$this->Model_scores->add_result($data['user_id'],$data['quiz_id'],$data['result']);
	}
	
	function score_delete(){
		$user_id = $this->uri->segment(3);
		$this->load->model('Model_scores');
		$score=$this->Model_scores->get_by(array('user_id'=>$user_id));
		if (isset($score['user_id'])){
			$data['status']='deleted';
			$deleted=$this->Model_scores->update($user_id, $data);
			if(!$deleted){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to delete the score'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'deleted'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified score could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
}