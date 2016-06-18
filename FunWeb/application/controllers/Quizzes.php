<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Quizzes extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('my_api');
	}

	function quiz_get(){
		$user_id = $this->uri->segment(3);
		$this->load->model('Model_quizzes');
		$quiz['quiz_id']=$this->Model_quizzes->get_quiz_id($user_id);
		if (isset($quiz['quiz_id'])){
			$questions=$this->Model_quizzes->get_by(array('quiz_id'=>$quiz['quiz_id'][0]->quiz_id));
			if(isset($questions['quiz_id'])){
				$this->response(array('status'=>'success','message'=>$questions));
			}
			else{
				$this->response(array('status'=>'failure','message'=>'The specified quiz could not be found'),REST_Controller::HTTP_NOT_FOUND);
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified quiz could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	
	}
	
	function quiz_put(){
		$data = $this->put();
		
		$this->load->model('Model_quizzes');
		$quiz_id=$this->Model_quizzes->insert($data);
		if(!$quiz_id){
			$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the quiz'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}
		else{
			$this->response(array('status'=>'success','message'=>'created'));
		}
		
	}
	
	function quiz_post(){
		$quiz_id = $this->uri->segment(3);
		$this->load->model('Model_quizzes');
		$quiz=$this->Model_quizzes->get_by(array('quiz_id'=>$quiz_id));
		if (isset($quiz['quiz_id'])){
			$data = $this->post();
			
			$this->load->model('Model_quizzes');
			$update=$this->Model_quizzes->update($quiz_id, $data);
			if(!$quiz_id){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to update the quiz'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'updated'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified quiz could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	function quiz_delete(){
		$quiz_id = $this->uri->segment(3);
		$this->load->model('Model_quizzes');
		$quiz=$this->Model_quizzes->get_by(array('quiz_id'=>$quiz_id));
		if (isset($quiz['quiz_id'])){
			$data['status']='deleted';
			$deleted=$this->Model_quizzes->update($quiz_id, $data);
			if(!$deleted){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to delete the quiz'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'deleted'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified quiz could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
}