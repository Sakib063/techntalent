<?php

class AnswerModel extends CI_Model{
	public function fetch(){
		$query=$this->db->get('answers');
		return $query->result_array();
	}

	public function create($data){
		$this->db->insert('answers',$data);
	}
}
