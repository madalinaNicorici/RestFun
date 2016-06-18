<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_quizzes extends MY_Model{
	protected $_table='quizzes';
	protected $primary_key='quiz_id';
	protected $return_type='array';
	
	public function get_quiz_id($user)
	{	
		if (!($res = $this->_database->query("SELECT return_quiz_id($user) as quiz_id"))) 
		{
			//echo "Fetch failed: (" . $this->_database->errno . ") " . $this->_database->error;
			return null;
		}
		$row = $res->result();
		return $row;		
	}
	
	public function add_result($user, $quiz, $result)
	{
		$this->_database->query("CALL add_answer($user, $quiz, $result)");
	}
	
	
}