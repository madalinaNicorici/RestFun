<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hello_model extends CI_Model{

	public function getProfile($name){
		return array("fullName"=>"Asofiei Cosmina","age"=>21);
	}
}