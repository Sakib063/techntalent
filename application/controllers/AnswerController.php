<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('AnswerModel');
	}
	public function store(): void{
		$data=[
			'question_id'=>$this->input->post('question_id'),
			'title'=>$this->input->post('answer_title'),
			'is_correct'=>$this->input->post('is_correct'),
		];
		$this->AnswerModel->create($data);
	}

	public function update(){
		$answers = $this->input->post('answers');
		foreach ($answers as $answer) {
			$update_status=$this->AnswerModel->update($answer['id'],$answer['answer_title'],$answer['is_correct']);
		}

		if ($update_status) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to update the answer']);
		}
	}
}
