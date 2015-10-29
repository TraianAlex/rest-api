<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('my_api');
	}
	/*
	* after url http://name/api/student/1?format=xml, php, csv, json, etc. default json
	*/
	function student_get() {
		//$id = $this->get('id');
		$student_id = $this->uri->segment(3);
		// $student = [
		// 	1 => ['first' => 'Jim', 'last_name' => 'Test'],
		// 	2 => ['first' => 'Jane', 'last_name' => 'Doe' ]
		// 	];
		$this->load->model('model_students');
		$student = $this->model_students->get_by(['student_id' => $student_id, 'status' => 'active']);

		if (isset($student['student_id'])) {
			$this->response(['status' => 'success', 'message' => $student]);//'My first API response'//'message' => $student[$id]]
		}else{
			$this->response(['status' => 'failure', 'message' => 'The specified student could not be found'], REST_Controller::HTTP_NOT_FOUND);//404
		}
	}

	public function student_put(){
		//var_dump($this->put());
		$this->load->library('form_validation');
		$data = remove_unknown_fields($this->put(), $this->form_validation->get_field_names('student_put'));
		$this->form_validation->set_data($data);
		if($this->form_validation->run('student_put') != false){
			$this->load->model('model_students');
			$exists = $this->model_students->get_by(['email_address' => $this->put('email_address')]);
			if ($exists) {
				$this->response(['status' => 'failure', 'message' => 'The specified email address already exists in the system'], REST_Controller::HTTP_CONFLICT);
			}
			$student_id = $this->model_students->insert($data);
			if (!$student_id) {
				$this->response(['status' => 'failure', 'message' => 'An unexpected error occured while trying to create the student'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}else{
				$this->response(['status' => 'success', 'message' => 'created']);
			}
		}else{
			$this->response(['status' => 'failure', 'message' => $this->form_validation->get_errors_as_array()], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	function student_post() {

		$student_id = $this->uri->segment(3);
		$this->load->model('model_students');
		$student = $this->model_students->get_by(['student_id' => $student_id, 'status' => 'active']);

		if (isset($student['student_id'])) {
			$this->load->library('form_validation');
			$data = remove_unknown_fields($this->post(), $this->form_validation->get_field_names('student_post'));
			$this->form_validation->set_data($data);
			if($this->form_validation->run('student_post') != false){
				$this->load->model('model_students');
				$safe_email = !isset($data['email_address']) || $data['email_address'] == $student['email_address']|| !$this->model_students->get_by(['email_address' => $data['email_address']]);
				if (!$safe_email) {
					$this->response(['status' => 'failure', 'message' => 'The specified email address is already in use'], REST_Controller::HTTP_CONFLICT);
				}
				$updated = $this->model_students->update($student_id, $data);
				if (!$student_id) {
					$this->response(['status' => 'failure', 'message' => 'An unexpected error occured while trying to update the student'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}else{
					$this->response(['status' => 'success', 'message' => 'updated']);
				}
			}else{
				$this->response(['status' => 'failure', 'message' => $this->form_validation->get_errors_as_array()], REST_Controller::HTTP_BAD_REQUEST);
			}
		}else{
			$this->response(['status' => 'failure', 'message' => 'The specified student could not be found'], REST_Controller::HTTP_NOT_FOUND);//404
		}
	}

	function student_delete() {

		$student_id = $this->uri->segment(3);
		
		$this->load->model('model_students');
		$student = $this->model_students->get_by(['student_id' => $student_id, 'status' => 'active']);

		if (isset($student['student_id'])) {
			$data['status'] = 'deleted';
			$deleted = $this->model_students->update($student_id, $data);
			if (!$deleted) {
				$this->response(['status' => 'failure', 'message' => 'An unexpected error occured while trying to delete the student'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}else{
				$this->response(['status' => 'success', 'message' => 'deleted']);
			}
		}else{
			$this->response(['status' => 'failure', 'message' => 'The specified student could not be found'], REST_Controller::HTTP_NOT_FOUND);//404
		}
	}
	
}