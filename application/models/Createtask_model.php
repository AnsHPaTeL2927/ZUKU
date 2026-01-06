<?php
class Createtask_model extends CI_Model 
{
		
	public function tag_insert($data)
	{
			  $id = $this->db->insert('task_list_managment',$data); 
			  return $this->db->insert_id();
	}
	
	// get user data
	 public function getuserdata()
	 {
		$q= $this->db->select("mst.*")
			->from("tbl_user as mst")
		    ->where('mst.status',"0")
			->get();
		 return $q->result();
	 }
	 
	 //For Update*/
	public function tag_update($data,$id)
	{
	  	$this->db->where('id',$id);	
		$q = $this->db->update('task_list_managment',$data);	
		return $q;
	}	
	

	
	public function check_tag_update($title)
	{
		$q=$this->db->where('title',$title);
		
		$q=$this->db->get('task_list_managment');

		return $q->row();
	} 
	
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("task_list_managment");
		  
		 return $q->row();
	 }
	 
	 //delete data
	public function task_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('task_list_managment');
		
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('task_list_managment',$data);	
		$resultdata->date = date('d/m/Y',strtotime($resultdata->date));
		return $q;	
	}
	
	public function documentdata()
	 {
		 $q= $this->db->select("*")
			 ->from("data_renew as mst")
			 ->where('mst.status',"0")
			 ->where('mst.id not in (select id from task_list_managment where id = mst.id and status=0) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
}
?>