<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Pallet_type_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
 	public function insert_pallet($data){

		$id = $this->db->insert('tbl_pallet_type',$data);
		return $this->db->insert_id();
	}
	public function get_pallet($id){

		$q=$this->db->where('pallet_type_id',$id);
		$q=$this->db->get('tbl_pallet_type');
		 
		return $q->row();
	}

	public function update_pallet($data,$id){

		$this->db->where('pallet_type_id',$id);
		$q=$this->db->update('tbl_pallet_type',$data);
		return $q;
	}
	public function delete_record($id){
		
		$data = array(
			"status" => 2
		);

		$this->db->where('pallet_type_id',$id);
		return $this->db->update('tbl_pallet_type',$data);
	}
	public function check_pallet_type($pallet_type)
	{
		$q=$this->db->where('pallet_type_name',$pallet_type);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_pallet_type');

		return $q->row();
	} 
}


?>