<?php
if (!defined('BASEPATH')) exit('No direct access allowed');

$config=array(
	'user_put'=>array(
		array('field'=>'email','label'=>'email','rules'=>'trim|required|valid_email'),
		array('field'=>'user_password','label'=>'user_password','rules'=>'trim|required|min_length[8]|max_length[16]'),
		array('field'=>'name','label'=>'name','rules'=>'trim|required|max_length[50]'),
		array('field'=>'surname','label'=>'surname','rules'=>'trim|required|max_length[50]'),
		array('field'=>'username','label'=>'username','rules'=>'trim|required|max_length[50]'),
		),
		'user_post'=>array(
		array('field'=>'email','label'=>'email','rules'=>'trim|valid_email'),
		array('field'=>'user_password','label'=>'user_password','rules'=>'trim|min_length[8]|max_length[16]'),
		array('field'=>'name','label'=>'name','rules'=>'trim|max_length[50]'),
		array('field'=>'surname','label'=>'surname','rules'=>'trim|max_length[50]'),
		array('field'=>'username','label'=>'username','rules'=>'trim|max_length[50]'),
		),
	'user_update'=>array(
		array('field'=>'email','label'=>'email','rules'=>'trim|valid_email'),
		array('field'=>'user_password','label'=>'user_password','rules'=>'trim|min_length[8]|max_length[16]'),
		array('field'=>'name','label'=>'name','rules'=>'trim|max_length[50]'),
		array('field'=>'surname','label'=>'surname','rules'=>'trim|required|max_length[50]'),
		array('field'=>'username','label'=>'username','rules'=>'trim|required|max_length[50]'),
		),
	);
?>