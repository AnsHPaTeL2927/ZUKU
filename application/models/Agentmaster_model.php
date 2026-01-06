<?php
class Agentmaster_model extends CI_Model 
{

	//show in fetch table of agent_list
	public function showagent_records()
	{
		//$q=$this->db->select ("group_concat (c_name) from country_detail as c where find_in_set(c.id,mst.c_name) and status = 0 as c_name FROM tbl_agent_master");
		$q=$this->db->order_by('status','asc');
		$q=$this->db->order_by('agent_name','asc');
		$q=$this->db->order_by('is_active','asc');
		$q=$this->db->get('tbl_agent_master');
		return $q->result();
	}
	
	public function showagent_records1()
	{
		//$q=$this->db->select ("group_concat (c_name) from country_detail as c where find_in_set(c.id,mst.c_name) and status = 0 as c_name FROM tbl_agent_master");
		$q=$this->db->order_by('status','asc');
		$q=$this->db->order_by('agent_name','asc');
		$q=$this->db->order_by('is_active','asc');
		$q=$this->db->where('status',"0");
		$q=$this->db->where('is_active',"Yes");
		$q=$this->db->get('tbl_agent_master');
		return $q->result();
	}
	
	public function s_insert($data)
	{
		$insertid = $this->db->insert('tbl_agent_master',$data);
		return $this->db->insert_id();

	}
	
	public function agentinsert($data)
	{
		$q = $this->db->insert('tbl_agent_master',$data);
		return $this->db->insert_id();
	}
	
		
	public function agentupdate($id,$data)
	{
		$this->db->where('id', $id); 
		return $this->db->update('tbl_agent_master',$data); 
	}
	
	public function getagent_record($id)
	{
		$q = $this->db->where("id",$id);
		$q = $this->db->get('tbl_agent_master');
		//echo $this->db->last_query();
		return $q->row();
	}
	
	public function getcountrydata()
	{
		$q= $this->db->select("mst.*")
		->from("country_detail as mst")
		
		->get();
		return $q->result();
	}
	
	public function getpaymentmethoddata()
	{
		$q= $this->db->select("mst.*")
		->from("tbl_payment_mode as mst")
		
		->get();
		return $q->result();
	}
	
	public function getpaymenttermsdata()
	{
		$q= $this->db->select("mst.*")
		->from("tbl_payment_terms as mst")
		->where('mst.status',"0")
		->where('is_active',"Yes")
		->get();
		return $q->result();
	}
	 
	public function chnagerecord($id,$status)
	{
		$data= array("status"=>$status);
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_agent_master',$data);
		return $updateid;
	}
	public function agent_insert($data)
	{
		$id = $this->db->insert('tbl_agent_master',$data); 
		return $this->db->insert_id();
	}
	
	public function terms_insert($data1)
	{
		$id = $this->db->insert('tbl_payment_terms',$data1); 
		return $this->db->insert_id();
	}

	public function check_agent_update($agent_name)
	{
		$q=$this->db->where('agent_name',$agent_name);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_agent_master');

		return $q->row();
	} 
	
	//to get last no from fetch table
	
	
	
	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('tbl_agent_master');
		return $q->row();
	}
	
	public function s_edit($data,$id)
	{
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_agent_master',$data);	
		return $q;	
	}
	
	public function delete_agent($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('tbl_agent_master');
	}
	
	
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_agent_master',$data);	
		return $q;	
	}
	
	 public function get_data($id)
	 {
	 	$q= $this->db->select("*")
			->from("tbl_payment_terms")
		    ->where('id',$id)
			->get();
		 return $q->row();
	 } 
	 
	 public function get_agent($data)
	 {
	 	$q= $this->db->select("*")
			->from("tbl_agent_master",$data)
		    //->where('payment_terms',$payment_terms)
			->get();
		 return $q->row();
	 }
	 
	 public function terms_update($data1)
	{
		$this->db->where('id', $id);  
		return $this->db->update('tbl_payment_terms',$data1); 
	}
	
	public function check_terms_update($payment_terms)
	{
		$q=$this->db->where('payment_terms',$payment_terms);
		
		$q=$this->db->get('tbl_payment_terms');

		return $q->row();
	}
	
	public function fetchdocumentdata($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("tbl_agent_master");
		  
		 return $q->row();
	 }
	 
	public function deleteimage($data,$id)
	{ 	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_agent_master',$data);
		return $updateid;
	}
	


}
?>

