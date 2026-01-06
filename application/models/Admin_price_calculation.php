<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Admin_price_calculation extends CI_model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function select_hsnc(){

		$q=$this->db->get('hsnc_product_size');
		return $q->result();
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->result();
	}

	public function pc_insert($data){

		return $this->db->insert('hsnc_product_size',$data);
	}
	public function pc_select_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('hsnc_product_size');
		return $q->row();
	}

	public function pc_edit($data,$id){

		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		return $q;
	}
	public function pc_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('hsnc_product_size');
	}
	public function ciadmin_login()
	{
		$q = $this->db->get('ciadmin_login');
		return $q->row();
	}
	public function select_hsnc_product_size($id){

		$query = $this->db->where('id', $id);
		$query = $this->db->get('hsnc_product_size');
		//  $this->db->last_query();
		return $query->result();
	}
	public function hsnc_product_size($json_data,$id){

		$data = array("size_details"=>$json_data);
		$this->db->where('id',$id);
		$q=$this->db->update('hsnc_product_size',$data);
		if ($this->db->affected_rows() > 0)
		{
		  echo "Data update successfully";
		}
		else
		{
		  echo "Nothing to update";
		}
	}

}


?>