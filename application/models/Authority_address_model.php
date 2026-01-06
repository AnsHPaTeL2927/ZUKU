<?php
class Authority_address_model extends CI_Model 
{
	public function address_insert($data)
		{
			
			  $id = $this->db->insert('tbl_authority_address',$data); 
			  return $this->db->insert_id();
		}
		
	public function check_address_update($authority_address)
		{
			
			$q=$this->db->where('authority_address',$authority_address);
			// $q=$this->db->where('status',0);
			$q=$this->db->get('tbl_authority_address');

			return $q->row();
		} 
	
	
	public function updatedata($data,$id)
	{ 	
	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_authority_address',$data);
						
		return $updateid;
	}
		
	public function fetchmodeldata1($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("tbl_authority_address");
		  
		 return $q->row();
	 }
		
	 //archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_authority_address',$data);	
		return $q;	
	}
	
	//delete data
	public function address_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('tbl_authority_address');
		
	}
}
?>