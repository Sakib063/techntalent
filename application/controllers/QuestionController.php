<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('QuestionModel');
	}


	public function index(): void {
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}

		$this->load->view('question');
	}

	public function fetch(){
		$raw_questions = $this->QuestionModel->fetch();

		$questions = [];
		foreach ($raw_questions as $row) {
			$question_id = $row['question_id'];
			if (!isset($questions[$question_id])) {
				$questions[$question_id] = [
					'question_id' => $row['question_id'],
					'question_title' => $row['question_title'],
					'answers' => [],
				];
			}
			$questions[$question_id]['answers'][] = [
				'answer_title' => $row['answer_title'],
				'is_correct' => $row['is_correct'],
			];
		}
		echo json_encode($questions);
	}

	public function store(): void{
		$data=[
			'title'=>$this->input->post('question'),
		];
		$question_id=$this->QuestionModel->create($data);
		$this->output->set_content_type('application/json')->set_output(json_encode($question_id));
	}

	public function update(){
		$question_id = $this->input->post('question_id');
		$question_title = $this->input->post('question_title');
		$update_status = $this->QuestionModel->update($question_id,$question_title);
		if ($update_status) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to update the question']);
		}
	}

	public function delete(): void{
		$id=$this->input->post('question_id');
		$this->QuestionModel->delete($id);
	}
}
