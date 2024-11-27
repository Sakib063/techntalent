<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}
	public function index(): void{
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$questions=$this->QuestionModel->fetch();
		$this->load->view('question',['questions' => $questions]);
	}

	public function store(): void{
		$data=[
			'title'=>$this->input->post('question'),
		];
		$question_id=$this->QuestionModel->create($data);
		$this->output->set_content_type('application/json')->set_output(json_encode($question_id));
	}

	public function delete(): void{
		$id=$this->input->post('question_id');
		$this->QuestionModel->delete($id);
	}

}
