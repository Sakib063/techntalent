<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller{
	public function index(){
		$this->load->view('login');
	}
	public function login(){
		$data=[
			'username'=>$this->input->post('username'),
			'password'=>$this->input->post('password'),
		];
		if($data['username']=='admin@email.com' && $data['password']=='1234'){
			$token = bin2hex(random_bytes(16)); // Secure token
			$session_data=[
				'user_id'   => $auth->id,
				'username'  => $auth->username,
				'token'     => $token,
				'logged_in' => true,
			];
			$this->session->set_userdata($session_data);
			redirect('question');
		}
		else{
			echo 'Invalid Credentials';
		}
	}

	public function logout(){
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect('login');
	}
}
