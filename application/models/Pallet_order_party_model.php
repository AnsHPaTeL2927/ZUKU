<?php
class Pallet_order_party_model extends CI_model
{
	public function __construct()
	{
	parent:: __construct();	
		$this->load->database();
	}

	public function pallet_insert($data){
		  $this->db->insert('tbl_pallet_party',$data); 
		return $this->db->insert_id();
	}
	
	public function pallet_bankid_insert($data1){
		  $this->db->insert('tbl_pallet_party',$data1); 
		return $this->db->insert_id();
	}

	public function pallet_party($id){
		$q=$this->db->where('pallet_party_id',$id);
		$q=$this->db->get('tbl_pallet_party');

		return $q->row();
	}
	public function b_form_edit($id){

		$q= $this->db->select("mst.*,pro.size_width_mm,pro.size_width_cm,pro.size_height_mm,pro.size_height_cm")
			 ->from("tbl_product_size as mst")
			 ->join("tbl_product as pro","pro.product_id=mst.product_id","LEFT")
			  ->where('product_size_id',$id)
			 ->get();
	  
		return $q->row();
	}
	
	public function get_customer_wise_user($customer_id1)
	{
		$sql = "select * from bank_detail where mst.status = 0 and mst.customer_id=".$customer_id1;
		$query = $this->db->query($sql);
	    return $query->result(); 
	}

	
	
	public function insert_bank_data($data){
		$this->db->where('pallet_party_id',$id);	
		return $this->db->update('tbl_pallet_party',$data);	
	}
	
	public function bank_select()
	 {
		$q= $this->db->select("mst.*")
			 ->from("bank_master as mst")
			 //->where('mst.status',"0")
			->where('mst.id not in (select pallet_party_id from tbl_pallet_party where pallet_party_id = mst.id ) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
		
	public function pallet_delete($id)
	{
		$this->db->where('pallet_party_id',$id);
		$this->db->delete('tbl_pallet_party');
		return 1;
	}

	public function pallet_update($data,$id)
	{
	  	$this->db->where('pallet_party_id',$id);	
		return $this->db->update('tbl_pallet_party',$data);	
	}
	
	public function check_pallet_party($party_name)
	{
		$q=$this->db->where('party_name',$party_name);
		$q=$this->db->where('status',0);
		$q=$this->db->get('tbl_pallet_party');

		return $q->row();
	} 
	
	// public function pallet_data($id)
	// {
		// $q = $this->db->select('invoice.*, consign.c_name , consign.c_companyname , consign.shippment_days')
			 // ->from('tbl_pallet_contact as invoice')
			// ->join('customer_detail as consign', 'invoice.consiger_id = consign.id', 'LEFT')
			// ->where('export_invoice_id',$id)
			// ->get();
			// //echo $this->db->last_query();
			// return $q->row();
	// }
	
}

?>