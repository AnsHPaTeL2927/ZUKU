<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Box_design_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
 	public function insertdata($data){

		$id = $this->db->insert('tbl_box_design',$data);
		return $this->db->insert_id();
	}
	public function fetch_data($id){

		$q=$this->db->where('box_design_id',$id);
		$q=$this->db->get('tbl_box_design');
		 
		return $q->row();
	}

	public function updatedata($data,$id){

		$this->db->where('box_design_id',$id);
		$q=$this->db->update('tbl_box_design',$data);
		return $q;
	}
	public function deleterecord($id){
		
		$data = array(
			"status" => 2
		);
		$this->db->where('box_design_id',$id);
		return $this->db->update('tbl_box_design',$data);
	}
	public function check_box_design($box_design_name)
	{
		$q=$this->db->where('box_design_name',$box_design_name);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_box_design');

		return $q->row();
	} 
}


?>