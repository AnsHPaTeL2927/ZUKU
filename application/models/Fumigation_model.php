<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Fumigation_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}


	public function insert_fumigation($data){

		$id = $this->db->insert('tbl_fumigation',$data);
		return $this->db->insert_id();
	}
	public function get_fumigation($id){

		$q=$this->db->where('fumigation_id',$id);
		$q=$this->db->get('tbl_fumigation');
		 
		return $q->row();
	}

	public function update_fumigation($data,$id){

		$this->db->where('fumigation_id',$id);
		$q=$this->db->update('tbl_fumigation',$data);
		return $q;
	}
	public function delete_record($id){
		$data = array(
			"status" => 2
		);
		
		$this->db->where('fumigation_id',$id);
		return $this->db->update('tbl_fumigation',$data);
	}
	public function check_fumigation($fumigation_name)
	{
		$q=$this->db->where('fumigation_name',$fumigation_name);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_fumigation');

		return $q->row();
	} 
}


?>