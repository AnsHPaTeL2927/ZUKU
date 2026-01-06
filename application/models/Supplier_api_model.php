<?php
class Supplier_api_model extends CI_Model 
{
	public function supplier_insert($data)
		{
			
			  $id = $this->db->insert('tbl_supplier_api',$data); 
			  return $this->db->insert_id();
		}
		
	public function check_supplier_update($supplier_companyname)
		{
			
			$q=$this->db->where('supplier_companyname',$supplier_companyname);
			// $q=$this->db->where('status',0);
			$q=$this->db->get('tbl_supplier_api');

			return $q->row();
		} 
		
	
	public function updatedata($data,$id)
	{ 	
	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_supplier_api',$data);
						
		return $updateid;
	}
	public function fetchmodeldata1($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("tbl_supplier_api");
		  
		 return $q->row();
	 }
		
	 //archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_supplier_api',$data);	
		return $q;	
	}
	
	//delete data
	public function supplier_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('tbl_supplier_api');
		
	}
	
	public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("tbl_supplier_api");
		  
		 return $q->row();
	 }
	 
	public function deleteimage($data,$id)
	 { 	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_supplier_api',$data);
		return $updateid;
	 }
}
?>