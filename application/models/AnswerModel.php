<?php

class AnswerModel extends CI_Model{
	public function fetch(){
		$query=$this->db->get('answers');
		return $query->result_array();
	}
}
