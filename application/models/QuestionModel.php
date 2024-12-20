<?php

class QuestionModel extends CI_Model{
	public function fetch(){
		$this->db->select('questions.id AS question_id, questions.title AS question_title, answers.id AS answer_id, answers.title AS answer_title, answers.is_correct, answers.question_id AS answer_question_id');
		$this->db->from('questions');
		$this->db->join('answers','questions.id=answers.question_id');
		$query=$this->db->get();
		return $query->result_array();
	}
	public function create($data): int{
		$this->db->insert('questions',$data);
		return $this->db->insert_id();
	}

	public function update($id, $title){
		$this->db->where('id',$id);
		$this->db->set('title', $title);
		$this->db->update('questions');
	}

	public function delete($id){
		$this->db->where('id',$id);
		$this->db->delete('questions');
		return true;
	}
}
