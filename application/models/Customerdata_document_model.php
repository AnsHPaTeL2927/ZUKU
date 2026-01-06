<?php
class Customerdata_document_model extends CI_Model 
{
	
	public function insert_additional_detail($data)
	{
		$insertid = $this->db->insert('tbl_customer_document',$data);
		return $this->db->insert_id();

	}
	public function update_additional_detail($data,$customer_add_detail_id)
	{
		$q = $this->db->where('customer_id',$customer_add_detail_id);	
		$q =  $this->db->update('tbl_customer_document',$data);	
		return $q;	
	}
	
	public function get_document_detail($id){
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_customer_document as cust')
			 ->where('customer_id',$id)
			 
			->get();	
		
		return $q->row();
	}
	 
	 
}
?>