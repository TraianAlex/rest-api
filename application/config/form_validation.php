<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = [
	'student_put' => [
		['field' => 'email_address', 'label' => 'email_address', 'rules' => 'trim|required|valid_email'],
		['field' => 'password', 'label' => 'password', 'rules' => 'trim|required|min_length[8]|max_length[16]'],
		['field' => 'first_name', 'label' => 'first_name', 'rules' => 'trim|required|max_length[50]'],
		['field' => 'last_name', 'label' => 'last_name', 'rules' => 'trim|required|max_length[50]'],
		['field' => 'phone_number', 'label' => 'phone_number', 'rules' => 'trim|required|alpha_dash']
	],
	'student_post' => [
		['field' => 'email_address', 'label' => 'email_address', 'rules' => 'trim|valid_email'],
		['field' => 'first_name', 'label' => 'first_name', 'rules' => 'trim|max_length[50]'],
		['field' => 'last_name', 'label' => 'last_name', 'rules' => 'trim|max_length[50]'],
		['field' => 'phone_number', 'label' => 'phone_number', 'rules' => 'trim|alpha_dash'],
	]
];