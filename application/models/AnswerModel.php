<?php

class AnswerModel extends CI_Model{
	public function fetch(){
		$query=$this->db->get('answers');
		return $query->result_array();
	}

	public function create($data){
		$this->db->insert('answers',$data);
	}

	public function update($id,$title,$is_correct){
		$this->db->where('id',$id);
		$this->db->set('title',$title);
		$this->db->set('is_correct',$is_correct);
		$this->db->update('answers');
	}
}
