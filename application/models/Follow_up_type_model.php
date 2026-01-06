<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Follow_up_type_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
 	public function insert_follow_up_type($data){

		$id = $this->db->insert('tbl_follow_up_type',$data);
		return $this->db->insert_id();
	}
	public function get_follow_up_type($id){

		$q=$this->db->where('follow_up_type_id',$id);
		$q=$this->db->get('tbl_follow_up_type');
		 
		return $q->row();
	}

	public function update_follow_up_type($data,$id){

		$this->db->where('follow_up_type_id',$id);
		$q=$this->db->update('tbl_follow_up_type',$data);
		return $q;
	}
	public function delete_record($id){
		
		$data = array(
			"status" => 2
		);

		$this->db->where('follow_up_type_id',$id);
		return $this->db->update('tbl_follow_up_type',$data);
	}
	public function check_follow_up_type($follow_up_type)
	{
		$q=$this->db->where('follow_up_type',$follow_up_type);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_follow_up_type');

		return $q->row();
	} 
}


?>