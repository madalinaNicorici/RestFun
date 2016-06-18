<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Questions extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('my_api');
	}

	function question_get(){
		$question_id = $this->uri->segment(3);
		$this->load->model('Model_questions');
		$question=$this->Model_questions->get_by(array('question_id'=>$question_id));
		if (isset($question['question_id'])){
			$this->response(array('status'=>'success','message'=>$question));
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified question could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	function question_put(){
		$data = $this->put();
		
		$this->load->model('Model_questions');
		$question_id=$this->Model_questions->insert($data);
		if(!$question_id){
			$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the question'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else{
			$this->response(array('status'=>'success','message'=>'created'));
		}
		
	}
	
	function question_post(){
		$question_id = $this->uri->segment(3);
		$this->load->model('Model_questions');
		$question=$this->Model_questions->get_by(array('question_id'=>$question_id));
		if (isset($question['question_id'])){
			$data = $this->post();
			
			$this->load->model('Model_questions');
			$update=$this->Model_questions->update($question_id, $data);
			if(!$question_id){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to update the question'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'updated'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified question could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	function question_delete(){
		$question_id = $this->uri->segment(3);
		$this->load->model('Model_questions');
		$question=$this->Model_questions->get_by(array('question_id'=>$question_id));
		if (isset($question['question_id'])){
			$data['status']='deleted';
			$deleted=$this->Model_questions->update($question_id, $data);
			if(!$deleted){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to delete the question'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'deleted'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified question could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
}