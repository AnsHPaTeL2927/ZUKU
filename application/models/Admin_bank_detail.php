<?php

class Admin_bank_detail extends CI_model
{
	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function b_insert($data)
	{
		$q = $this->db->insert('bank_detail',$data);
		return $this->db->insert_id();
	}
	
	public function b_insert1($data)
	{
		$q = $this->db->insert('bank_master',$data);
		return $this->db->insert_id();
	}

	public function b_select()
	{
		$q = $this->db->select('mst.*,(Select bank_name from tbl_company_profile where bank_name = mst.id) as bank_id');
		$q = $this->db->get('bank_detail as mst');
	 	$q = $q->result();
		return $q;
	}

	
	public function b_form_edit($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('bank_detail');
		 
		return $q->row();
	}	
	
	public function b_form_edit1($id){

		$q=$this->db->where('id',$id);
		$q=$this->db->get('bank_master');
		 
		return $q->row();
	}


	public function b_del($id)
	{
	 
	 	$this->db->where('id',$id);
		return $this->db->delete('bank_detail');
	}

	public function b_edit($data,$id)
	{
	 $this->db->where('id',$id);	
	 return $this->db->update('bank_detail',$data);	
		
	}
	
	public function b_edit1($data,$id)
	{
	 $this->db->where('id',$id);	
	 return $this->db->update('bank_master',$data);	
		
	}
	public function check_bank($data)
	{
		$q=$this->db->where('bank_name',$data['bank_name']);
		$q=$this->db->where('account_name',$data['account_name']);
		$q=$this->db->where('account_no',$data['account_no']);
	 
		$q=$this->db->get('bank_detail');

		return $q->row();
	} 
	
	
	public function update_pallet_party($data1,$id)
	{
		$this->db->where('pallet_party_id',$id);	
		return $this->db->update('tbl_pallet_party',$data1);		
	}
	
	public function update_customer_detail($data2,$id)
	{
		$this->db->where('id',$id);	
		return $this->db->update('customer_detail',$data2);		
	}
	
	public function update_cha_detail($data3,$id)
	{
		$this->db->where('id',$id);	
		return $this->db->update('tbl_cha_master',$data3);		
	}
	
	public function update_forwarer_detail($data4,$id)
	{
		$this->db->where('id',$id);	
		return $this->db->update('tbl_forwarer_master',$data4);		
	}
	
	public function update_supplier_detail($data5,$id)
	{
		$this->db->where('supplier_id',$id);	
		return $this->db->update('tbl_supplier',$data5);		
	}
	
}

?>