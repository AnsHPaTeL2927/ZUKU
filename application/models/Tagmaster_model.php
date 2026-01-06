<?php
class Tagmaster_model extends CI_Model 
{
	function getno()  
    {  
		$q = $this->db->select('MAX(order_no) as order_no')
			->from('company_tag_master')
			->get();  
	
			return $q->row();  
    }
	
	public function gettagdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("company_tag_master");
		  
		 return $q->result();
	 }
		
	/*View*/
    function fetchtable()  
    {  
			$this->db->select('*');
			$this->db->from('company_tag_master');
			
			
            $query = $this->db->get();  
			
            return $query->result();  
    }
		
	public function tag_insert($data)
	{
			  $id = $this->db->insert('company_tag_master',$data); 
			  return $this->db->insert_id();
	}
	
	public function tag_party($id){
		$q=$this->db->where('tag_id',$id);
		$q=$this->db->get('company_tag_master');
		 
		return $q->row();
	}
	
	public function manage()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_company_document_setup as mst")
			 // ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 // ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->where('mst.status',"0")
			 // ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->get();
		 return $q->result();
	 }
	//For Update*/
	public function tag_update($data,$id)
	{
	  	$this->db->where('tag_id',$id);	
		$q = $this->db->update('company_tag_master',$data);	
		return $q;
	}	
	
	public function check_tag_update($tagname)
	{
		$q=$this->db->where('tag_name',$tagname);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('company_tag_master');

		return $q->row();
	} 
	
	//delete data
	public function tag_delete($id)
	{
		$this->db->where('tag_id',$id);
		return $this->db->delete('company_tag_master');
		
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('tag_id',$id);	
		$q =  $this->db->update('company_tag_master',$data);	
		return $q;	
	}
	
}