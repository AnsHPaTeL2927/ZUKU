<?php
class Extra_detail_model extends CI_Model 
{
	
	public function insert_additional_detail($data)
	{
		$insertid = $this->db->insert('tbl_extra_detail',$data);
		return $this->db->insert_id();

	}
	
	public function terms_insert($data1)
	{
		$id = $this->db->insert('customer_detail',$data1); 
		return $this->db->insert_id();
	}
	
	public function check_terms_update($forwarer_id)
	{
		$q=$this->db->where('forwarer_id',$forwarer_id);
		
		$q=$this->db->get('customer_detail');

		return $q->row();
	}
	
	public function update_additional_detail($data,$customer_add_detail_id)
	{
		$q = $this->db->where('exportinvoice_id',$customer_add_detail_id);	
		$q =  $this->db->update('tbl_extra_detail',$data);	
		return $q;	
	}
	
	 
	 public function cha_data()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_cha_master as mst")
			 ->where('mst.status',"0")
			
			 ->get();
			  
		 return $q->result();
	 }
	 
	 public function forwarer_data()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_forwarer_master as mst")
			 ->where('mst.status',"0")
			
			 ->get();
			  
		 return $q->result();
	 } 
	 
	 public function shipping_data()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_shipping_line_master as mst")
			 ->where('mst.status',"0")
			 ->where('is_active',"Yes")
			
			 ->get();
			  
		 return $q->result();
	 } 
	 
	 public function vessel_data()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_vessel_data as mst")
			 ->where('mst.status',"0")
			
			 ->get();
			  
		 return $q->result();
	 }
	 
	 public function customer_data()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("customer_detail as mst")
			 ->where('mst.status',"0")
			
			 ->get();
			  
		 return $q->result();
	 }
	 
	 public function get_extra_detail($id){
		
		$q = $this->db->select('*')
			 ->from('tbl_extra_detail')
			 ->where('exportinvoice_id',$id)
			 
			->get();	
		
		return $q->row();
	}
	
}
?>