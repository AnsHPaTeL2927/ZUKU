<?php
class Companydocumentupload_model extends CI_Model 
{
	
function blog_img($files)
{
    $this->db->set('document_file', $files);
    return $this->db->insert('tbl_document_upload');
}

	public function filedata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_company_document_setup as mst")
			 ->where('mst.status',"0")
			 ->where('is_active',"Yes")
			  ->get();
			 
			  
		return $q->result();
	 }
	 
public function documentdata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_company_document_setup as mst")
			 ->where('mst.status',"0")
			 ->where('mst.cmp_doc_setup_id not in (select cmp_doc_setup_id from tbl_document_upload where cmp_doc_setup_id = mst.cmp_doc_setup_id and status=0) and mst.cmp_doc_setup_id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	public function tag_insert($data)
	{
				
			  $id = $this->db->insert('tbl_document_upload',$data); 
			  return $this->db->insert_id();
	}
	
	public function check_tag_update($document_id)
	{
		$q=$this->db->where('document_id',$document_id);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_document_upload');

		return $q->row();
	} 
	
	//For Update*/
	public function tag_update($data,$id)
	{
	  	$this->db->where('document_id',$id);	
		$q = $this->db->update('tbl_document_upload',$data);	
		return $q;
	}	
	
	public function updatedata($data,$id)
	{ 	
		$this->db->where('document_id',$id);
		$updateid= $this->db->update('tbl_document_upload',$data);
		return $updateid;
	}
	
	
	 public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("document_id",$id);
		 $q= $this->db->get("tbl_document_upload");
		  
		 return $q->row();
	 }
	 
	
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("document_id",$id);
		 $q= $this->db->join("tbl_company_document_setup as com","com.cmp_doc_setup_id = mst.cmp_doc_setup_id");
		 $q= $this->db->get("tbl_document_upload as mst");
		  
		 return $q->row();
	 }
	
	 public function deleterecord($id){
		//$data= array("status"=>"2");
		$this->db->where('document_id',$id);
		$updateid= $this->db->delete('tbl_document_upload');
				   
		return $updateid;
	}
	
	public function deleteimage($data,$id)
	 { 	
		$this->db->where('document_id',$id);
		$updateid= $this->db->update('tbl_document_upload',$data);
		return $updateid;
	 }
	
	 public function gettagdata()
	 {
		$q= $this->db->select("mst.*")
			->from("company_tag_master as mst")
		    ->where('mst.status',"0")
			->get();
		 return $q->result();
	 }
		
	 public function get_data($id)
	 {
	 	$q= $this->db->select("*")
			->from("tbl_company_document_setup")
		    ->where('cmp_doc_setup_id',$id)
			->get();
		 return $q->row();
	 } 
	 

	 
	 //archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('document_id',$id);	
		$q =  $this->db->update('tbl_document_upload',$data);	
		return $q;	
	}
	 
	//delete data
	public function tag_delete($id)
	{
		$this->db->where('document_id',$id);
		return $this->db->delete('tbl_document_upload');
		
	}

	
		
	
	
}