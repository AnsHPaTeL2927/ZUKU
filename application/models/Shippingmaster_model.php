<?php
class Shippingmaster_model extends CI_Model 
{
	
	public function updateprivious_data($ornumber,$id)
		{
			$q=$this->db->where('order_no >=',$ornumber);
			$q=$this->db->where('shipping_id !=',$id);
			$q=$this->db->where('status',0);
			$q=$this->db->get('tbl_shipping_line_master');
			foreach($q->result() as $updaterow)
			{
				$data = array(
					'order_no' => ($updaterow->order_no + 1),
				);
				
				$this->db->where('shipping_id',$updaterow->shipping_id);	
				$q = $this->db->update('tbl_shipping_line_master',$data);
			} 
			return $q;
		} 

	public function shipping_insert($data)
		{
			  $id = $this->db->insert('tbl_shipping_line_master',$data); 
			  return $this->db->insert_id();
		}
		
	public function check_doc_update($shipping_name)
		{
			$q=$this->db->where('shipping_line_name',$shipping_name);
			// $q=$this->db->where('status',0);
			$q=$this->db->get('tbl_shipping_line_master');

			return $q->row();
		} 
		
	public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("shipping_id",$id);
		 $q= $this->db->get("tbl_shipping_line_master");
		  
		 return $q->row();
	 }
		
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("shipping_id",$id);
		 $q= $this->db->get("tbl_shipping_line_master");
		  
		 return $q->row();
	 }
	 
	 public function updatedata($data,$id)
	{ 	
		$this->db->where('shipping_id',$id);
		$updateid= $this->db->update('tbl_shipping_line_master',$data);
		return $updateid;
	}
	
	//For Update*/
	public function shipping_update($data,$id)
	{
	  	$this->db->where('shipping_id',$id);	
		$q = $this->db->update('tbl_shipping_line_master',$data);	
		return $q;
	}
	
	public function deleteimage($data,$id)
	 { 	
		$this->db->where('shipping_id',$id);
		$updateid= $this->db->update('tbl_shipping_line_master',$data);
		return $updateid;
	 }
	 
	public function deleterecord($id)
	{
		//$data= array("status"=>"2");
		$this->db->where('shipping_id',$id);
		$updateid= $this->db->delete('tbl_shipping_line_master');
				   
		return $updateid;
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('shipping_id',$id);
		$q =  $this->db->update('tbl_shipping_line_master',$data);	
		
		return $q;	
	}
	
	//to get last no from fetch table
	function getno()  
    {  
		$q = $this->db->select('MAX(order_no) as order_no')
			->from('tbl_shipping_line_master')
			->get();  
		
			return $q->row();  
    }
}

?>