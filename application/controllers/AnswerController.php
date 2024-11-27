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
}
