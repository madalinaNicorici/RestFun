<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends MY_Model{
	protected $_table='users_profile';
	protected $primary_key='user_id';
	protected $return_type='array';
	
	protected $after_get=array('remove_sensitive_data');
	protected $before_create=array('prep_data');
	//protected $before_update=array('update_timestamp');
	
	protected function remove_sensitive_data($user){
		//unset($user['user_password']);
		unset($user['ip_address']);
		return $user;
	}
	
	protected function prep_data($user){
		if(isset($user['user_password']))$user['user_password']= md5($user['user_password']);
		//$user['ip_address']=$this->input->ip_address();
		//$user['created_timestamp']=date('Y-m-d H:i:s');
		return $user;
	}
	
	protected function update_timestamp($user){
		//$user['updated_timestamp']=date('Y-m-d H:i:s');
		return $user;
	}
}