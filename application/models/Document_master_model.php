<?php
class Document_master_model extends CI_Model 
{
	
	public function updateprivious_data($ornumber,$id)
		{
			$q=$this->db->where('order_no >=',$ornumber);
			$q=$this->db->where('document_master_id !=',$id);
			$q=$this->db->where('status',0);
			$q=$this->db->get('tbl_document_master');
			foreach($q->result() as $updaterow)
			{
				$data = array(
					'order_no' => ($updaterow->order_no + 1),
				);
				
				$this->db->where('document_master_id',$updaterow->id);	
				$q = $this->db->update('tbl_document_master',$data);
			} 
			return $q;
		} 

	public function document_insert($data)
		{
			  $id = $this->db->insert('tbl_document_master',$data); 
			  return $this->db->insert_id();
		}
		
	public function check_doc_update($label_name)
		{
			$q=$this->db->where('label_name',$label_name);
			// $q=$this->db->where('status',0);
			$q=$this->db->get('tbl_document_master');

			return $q->row();
		} 
		
	public function updatedata($data,$id)
	{ 	
		$this->db->where('document_master_id',$id);
		$updateid= $this->db->update('tbl_document_master',$data);
		return $updateid;
	}
		
	public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("document_master_id",$id);
		 $q= $this->db->get("tbl_document_master");
		  
		 return $q->row();
	 }
		
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("document_master_id",$id);
		 $q= $this->db->get("tbl_document_master");
		  
		 return $q->row();
	 }
	 
	public function deleteimage($data,$id)
	 { 	
		$this->db->where('document_master_id',$id);
		$updateid= $this->db->update('tbl_document_master',$data);
		return $updateid;
	 }
	 
	public function deleterecord($id)
	{
		//$data= array("status"=>"2");
		$this->db->where('document_master_id',$id);
		$updateid= $this->db->delete('tbl_document_master');
				   
		return $updateid;
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('document_master_id',$id);
		$q =  $this->db->update('tbl_document_master',$data);	
		
		return $q;	
	}
	
	//to get last no from fetch table
	function getno()  
    {  
		$q = $this->db->select('MAX(order_no) as order_no')
			->from('tbl_document_master')
			->get();  
		
			return $q->row();  
    }
}
?>