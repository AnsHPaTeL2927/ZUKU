<?php
class Companydocument_model extends CI_Model 
{
	
	// function saverecords($data)
	// {
		// $id = $this->db->insert('tbl_company_document_setup',$data);
		// // echo $this->db->last_query();
		// return $this->db->insert_id();
		// echo "succuessfully insert";
	// }
	function getno()  
        {  
			$q = $this->db->select('MAX(order_no) as order_no')
				->from('tbl_company_document_setup')
				->get();  
			
            return $q->row();  
        }
		
	/*View*/
    function fetchtable()  
        {  
			$this->db->select('*');
			$this->db->from('tbl_company_document_setup');
			
			
            $query = $this->db->get();  
			
            return $query->result();  
        }  
		
	/*Check*/
    function checkdata($dname)  
        {  
			$this->db->select('*');
			$this->db->from('tbl_company_document_setup');
			
		
			$this->db->where(['document_name' => $dname]);
						
            $query = $this->db->get();  
			
            return $query->result();  
        } 
		
		
	//updated insert data
	public function doc_insert($data){
		  $id = $this->db->insert('tbl_company_document_setup',$data); 
		  return $this->db->insert_id();
	}
	
	
	public function doc_party($id){
		$q=$this->db->where('cmp_doc_setup_id',$id);
		$q=$this->db->get('tbl_company_document_setup');
		 
		return $q->row();
	}
	
	
	//For Update*/
	public function doc_update($data,$id)
	{
	  	$this->db->where('cmp_doc_setup_id',$id);	
		$q = $this->db->update('tbl_company_document_setup',$data);	
		return $q;
	}	
	
	public function check_doc_update($dname)
	{
		$q=$this->db->where('document_name',$dname);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_company_document_setup');

		return $q->row();
	} 
	
	//delete data
	public function doc_delete($id)
	{
		$this->db->where('cmp_doc_setup_id',$id);
		return $this->db->delete('tbl_company_document_setup');
		
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('cmp_doc_setup_id',$id);	
		$q =  $this->db->update('tbl_company_document_setup',$data);	
		return $q;	
	}
	
	
		
	
	
}