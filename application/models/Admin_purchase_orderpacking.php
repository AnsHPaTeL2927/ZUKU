<?php

class Admin_purchase_orderpacking extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function select_exporter(){
		$q = $this->db->get('tbl_company_profile');
		return $q->row();
	}

	public function select_consigner(){
		$q = $this->db->get('customer_detail');
		return $q->result();
	}

	public function b_insert($data){
		 $this->db->insert('performa_invoice',$data);
		 return $cid = $this->db->insert_id();
		} 
	public function lastid($id){
	$this->db->where('performa_date',$id);
	$q = $this->db->get('performa_invoice');
		return $q->num_rows();
	}

	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('performa_invoice');
		return $q->row();
	}
	public function s_edit($data,$id)
	{

		$this->db->where('id',$id);	
		return $this->db->update('performa_invoice',$data);	
		
	}
}
