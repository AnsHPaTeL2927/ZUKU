<?php
class Payment_terms_model extends CI_Model 
{
	public function updateprivious_data($ornumber,$id)
		{
			$q=$this->db->where('order_no >=',$ornumber);
			$q=$this->db->where('id !=',$id);
			$q=$this->db->where('status',0);
			$q=$this->db->get('tbl_payment_terms');
			foreach($q->result() as $updaterow)
			{
				$data = array(
					'order_no' => ($updaterow->order_no + 1),
				);
				
				$this->db->where('id',$updaterow->id);	
				$q = $this->db->update('tbl_payment_terms',$data);
			} 
			return $q;
		} 
	
	function getno()  
    {  
		$q = $this->db->select('MAX(order_no) as order_no')
		->from('tbl_payment_terms')
		->get();  
          return $q->row();  
    }
	
	public function get_payment_terms_data()
	{
	
		$q = $this->db->select('*')
			 ->from('tbl_payment_terms')
			 ->where('status',"0")
			 ->where('is_active',"Yes")
			 ->get();
		 
		return $q->result();
	}
		
	public function payment_terms_insert($data)
	{
		  $id = $this->db->insert('tbl_payment_terms',$data); 
		  return $this->db->insert_id();
	}
	
	public function check_payment_terms_update($payment_terms)
	{
		$q=$this->db->where('payment_terms',$payment_terms);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_payment_terms');

		return $q->row();
	} 
	
	public function fetch_payment_terms_data($id){
		$q=$this->db->where('id',$id);
		$q=$this->db->get('tbl_payment_terms');
		 
		return $q->row();
	}
	
	//For Update*/
	public function payment_terms_update($data,$id)
	{
	  	$this->db->where('id',$id);	
		$q = $this->db->update('tbl_payment_terms',$data);	
		return $q;
	}	
	
	//delete data
	public function payment_terms_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('tbl_payment_terms');
		
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_payment_terms',$data);	
		return $q;	
	}
	
	public function updatedata($data,$id)
	{ 	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_payment_terms',$data);
		return $updateid;
	}
	
	
	
}