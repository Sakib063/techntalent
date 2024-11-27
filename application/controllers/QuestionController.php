<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}
	public function index(){
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$questions=$this->QuestionModel->fetch();
		$this->load->view('question',['questions' => $questions]);
	}

	public function store(){
		$data=[
			'title'=>$this->input->post('question'),
		];
		$inserted=$this->QuestionModel->create($data);
		if($inserted){
			echo json_encode(['success' => true]);
		}
	}

	public function delete(){
		$id=$this->input->post('question_id');

		echo "Received question_id: " . $id;
		$this->QuestionModel->delete($id);
	}

}
