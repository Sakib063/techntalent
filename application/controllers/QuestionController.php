<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionController extends CI_Controller{
	public function index(){
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		$this->load->view('question');
	}
}
