<?php
class Help_master_model extends CI_Model 
{
	public function help_insert($data)
		{
			  $id = $this->db->insert('tbl_help_master',$data); 
			  return $this->db->insert_id();
		}
		
	public function check_doc_update($module_name)
		{
			$q=$this->db->where('module_name',$module_name);
			// $q=$this->db->where('status',0);
			$q=$this->db->get('tbl_help_master');

			return $q->row();
		}
		
	public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("help_id",$id);
		 $q= $this->db->get("tbl_help_master");
		  
		 return $q->row();
	 }
		
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("help_id",$id);
		 $q= $this->db->get("tbl_help_master");
		  
		 return $q->row();
	 }
	 
	 public function updatedata($data,$id)
	{ 	
		$this->db->where('help_id',$id);
		$updateid= $this->db->update('tbl_help_master',$data);
		return $updateid;
	}
	
	//For Update*/
	public function shipping_update($data,$id)
	{
	  	$this->db->where('help_id',$id);	
		$q = $this->db->update('tbl_help_master',$data);	
		return $q;
	}
	
	public function deleteimage($data,$id)
	 { 	
		$this->db->where('help_id',$id);
		$updateid= $this->db->update('tbl_help_master',$data);
		return $updateid;
	 }
	 
	public function deleterecord($id)
	{
		//$data= array("status"=>"2");
		$this->db->where('help_id',$id);
		$updateid= $this->db->delete('tbl_help_master');
				   
		return $updateid;
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('help_id',$id);
		$q =  $this->db->update('tbl_help_master',$data);	
		
		return $q;	
	}
}
?>