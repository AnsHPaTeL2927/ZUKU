<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Branch_model extends CI_model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
 	public function insert_company_branch($data){

		$id = $this->db->insert('tbl_company_branch',$data);
		return $this->db->insert_id();
	}
	public function get_company_branch($id){

		$q=$this->db->where('company_branch_id',$id);
		$q=$this->db->get('tbl_company_branch');
		 
		return $q->row();
	}

	public function update_company_branch($data,$id){

		$this->db->where('company_branch_id',$id);
		$q=$this->db->update('tbl_company_branch',$data);
		return $q;
	}
	public function delete_record($id){
		
		$data = array(
			"status" => 2
		);
		$this->db->where('company_branch_id',$id);
		return $this->db->update('tbl_company_branch',$data);
	}
	public function update_onoff($value)
	{
		
		$data = array(
			"branch_code" => $value
		);
		$this->db->where('log_id',1);
		return $this->db->update('ciadmin_login',$data);
	}
	public function check_pallet_cap($company_branch_code)
	{
		$q=$this->db->where('company_branch_code',$company_branch_code);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_company_branch');
		return $q->row();
	} 
}


?>