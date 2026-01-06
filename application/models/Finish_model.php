<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Finish_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	public function insert_finish($data){

		$id = $this->db->insert('tbl_finish',$data);
		return $this->db->insert_id();
	}
	public function get_finish($id){

		$q=$this->db->where('finish_id',$id);
		$q=$this->db->get('tbl_finish');
		 
		return $q->row();
	}

	public function update_finish($data,$id){

		$this->db->where('finish_id',$id);
		$q=$this->db->update('tbl_finish',$data);
		return $q;
	}
	public function delete_record($id){
		
		$data = array("status"=>2);
		$this->db->where('finish_id',$id);
		return $this->db->update('tbl_finish',$data);
	}
	public function check_finish($finish_name)
	{
		$q=$this->db->where('finish_name',$finish_name);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_finish');

		return $q->row();
	} 
}


?>