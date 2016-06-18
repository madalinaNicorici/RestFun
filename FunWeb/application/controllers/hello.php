<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hello extends CI_Controller{

	public function index(){
		echo "This is the index function.";

	}
	public function one($name){
		$this->load->model("hello_model","model");

		$profile = $this->model->getProfile("Cosmina");
		$this->load->view('header');

		$data = array("name"=>$name);
		$data['profile'] = $profile;
		$this->load->view('one',$data);
	}
	public function two(){
		echo "This is two.";
	}
}