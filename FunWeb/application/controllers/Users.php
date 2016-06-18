<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Users extends REST_Controller {
	function __construct() {
		parent::__construct();
		//incarca helperul care elimina campurile nenecesare
		$this->load->helper('my_api');
	}

	function user_get(){
		//acceseaza id-ul utilizatorului din URL
		$user_id = $this->uri->segment(3);
		//incarca clasa model pentru acest controller
		$this->load->model('Model_users');
		//returneaza un singur rand din tabel dupa criteriile date ca parametru(care vor fi folosite la clauza "where")
		$user=$this->Model_users->get_by(array('user_id'=>$user_id,'status'=>'active'));
		//daca a fost intors un rand(adica daca s-a gasit in tabel acel user)
		if (isset($user['user_id'])){
			//atunci se trimite succes impreuna cu informatiile despre utilizator
			$this->response(array('status'=>'success','message'=>$user));
		}
		//altfel se trimite eroarea NOT Found(codul 404)
		else{
			$this->response(array('status'=>'failure','message'=>'The specified user could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	//folosit pentru sign up
	/*function user_put(){
		//incarcam libraria form_validation
		$this->load->library('form_validation');
		//indepartam campurile care sunt in plus fata de ce avem nevoie
		$data = remove_unknown_fields($this->put(),$this->form_validation->get_field_names('user_put'));
		//dam datele obtinute dupa remove unknown fields la validat
		$this->form_validation->set_data($data);
		
		//daca datele vor fi validate pentru put
		if($this->form_validation->run('user_put')!=false){
			//incarcam modelul
			$this->load->model('Model_users');
			//cautam sa vedem daca emailul e deja prezent in baza de date
			//TO DO CAUTAM SA FIE UNIC SI USERNAMEUL
			$exists=$this->Model_users->get_by(array('email'=>$this->put('email')));
			//daca emailul deja exista, ii returnam failure
			if($exists){
				$this->response(array('status'=>'failure','message'=>'The specified email adress already exists.'),REST_Controller::HTTP_CONFLICT);
			}
			//daca nu exista, incercam sa facem un insert cu datele introduse de utilizator
			$user_id=$this->Model_users->insert($data);
			//daca insertul nu s-a efectuat cu succes, ii returnam eroare
			if(!$user_id){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the user'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			//altfel ii returnam succes
			else{
				$this->response(array('status'=>'success','message'=>'created'));
			}
		}
		// daca datele nu trec de validare
		else{
			$this->response(array('status'=>'failure','message'=>$this->form_validation->get_errors_as_array()),REST_Controller::HTTP_BAD_REQUEST);
		}
	}
	*/
	//login
	function user_post(){
		//in userlog primit datele de la post, adica username si parola
		$userlog=$this->post();
		
		if(!isset($userlog['name']))
		{
			//incarcam modelul
			$this->load->model('Model_users');
			//cautam userul in baxa de date
			$user=$this->Model_users->get_by(array('username'=>$userlog['username']));
			//daca l-am gasit
			if (isset($user['username'])&&isset($user['user_password'])){
				//incarcam libraria pentru validare
				$this->load->library('form_validation');
				//stergem campurile de care nu avem nevoie
				$data = remove_unknown_fields($this->post(),$this->form_validation->get_field_names('user_post'));
				//pregatim datele de validare
				$this->form_validation->set_data($data);
				
				//daca validarea reuseste
				if($this->form_validation->run('user_post')!=false){
					//incarcam modelul
					$this->load->model('Model_users');
					//daca parolele coincid, avem succes
					//DONE TIRMITE ID_USER
						if($user['user_password']==md5($userlog['user_password'])){
							$this->response(array('status'=>'success','message'=>$user['user_id']));
						}
						else {
						$this->response(array('status'=>'failure','message'=>'The password is incorrect.'),REST_Controller::HTTP_CONFLICT);
					}
						
				}
				else{
					$this->response(array('status'=>'failure','message'=>$this->form_validation->get_errors_as_array()),REST_Controller::HTTP_BAD_REQUEST);
				}
			}
			else{
				$this->response(array('status'=>'failure','message'=>'The specified user could not be found'),REST_Controller::HTTP_NOT_FOUND);
			}
		}
		else
		{
			//incarcam libraria form_validation
			$this->load->library('form_validation');
			//indepartam campurile care sunt in plus fata de ce avem nevoie
			$data = remove_unknown_fields($this->post(),$this->form_validation->get_field_names('user_put'));
			//dam datele obtinute dupa remove unknown fields la validat
			$this->form_validation->set_data($data);
			
			//daca datele vor fi validate pentru put
			if($this->form_validation->run('user_put')!=false){
				//incarcam modelul
				$this->load->model('Model_users');
				//cautam sa vedem daca emailul e deja prezent in baza de date
				//TO DO CAUTAM SA FIE UNIC SI USERNAMEUL
				$exists=$this->Model_users->get_by(array('email'=>$this->post('email')));
				//daca emailul deja exista, ii returnam failure
				if($exists){
					$this->response(array('status'=>'failure','message'=>'The specified email adress already exists.'),REST_Controller::HTTP_CONFLICT);
				}
				//daca nu exista, incercam sa facem un insert cu datele introduse de utilizator
				$user_id=$this->Model_users->insert($data);
				//daca insertul nu s-a efectuat cu succes, ii returnam eroare
				if(!$user_id){
					$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to create the user'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				//altfel ii returnam succes
				else{
					$this->response(array('status'=>'success','message'=>$user_id));
				}
			}
			// daca datele nu trec de validare
			else{
				$this->response(array('status'=>'failure','message'=>$this->form_validation->get_errors_as_array()),REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		
	}
	function user_delete(){
		//preia id-ul userului
		$user_id = $this->uri->segment(3);
		//incarca modelul
		$this->load->model('Model_users');
		//cauta utilizatorul dupa id
		$user=$this->Model_users->get_by(array('user_id'=>$user_id,'status'=>'active'));
		//daca il gaseste, ii modifica statusul din activ in delete printr-un update
		if (isset($user['user_id'])){
			$data['status']='deleted';
			$deleted=$this->Model_users->update($user_id, $data);
			if(!$deleted){
				$this->response(array('status'=>'failure','message'=>'An unexpected error occured while trying to delete the user'),REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			else{
				$this->response(array('status'=>'success','message'=>'deleted'));
			}
		}
		else{
			$this->response(array('status'=>'failure','message'=>'The specified user could not be found'),REST_Controller::HTTP_NOT_FOUND);
		}
	}
}