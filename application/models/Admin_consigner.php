<?php

class Admin_consigner extends CI_model
{
	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function b_insert($data){
		return $this->db->insert('customer_add_consigner',$data);
	}

	public function b_select(){
		$q=$this->db->get('customer_add_consigner');
		return $q->result();
	}
	public function b_form_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('customer_add_consigner');
		return $q->row();

	}


	public function b_del($id){
		$this->db->where('id',$id);
		return $this->db->delete('customer_add_consigner');
	}

	public function b_edit($data,$id)
	{
	$this->db->where('id',$id);	
	return $this->db->update('customer_add_consigner',$data);	
	}

}

?>