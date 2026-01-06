<?php
class Portmaster_model extends CI_Model 
{

	public function getcountrydata()
	{
		 $q= $this->db->get("country_detail");
		  
		 return $q->result();
	}
	
	public function countryinsert($data)
	{
		$id = $this->db->insert('country_detail',$data); 
		return $this->db->insert_id();
	}
	 
	public function port_insert($data)
	{
		$id = $this->db->insert('tbl_port_master',$data); 
		return $this->db->insert_id();
	}
	
	public function insertcountry($data)
	{
		$id = $this->db->insert('country_detail',$data); 
		return $this->db->insert_id();
	}
		
	public function s_insert($data)
	{
		$insertid = $this->db->insert('tbl_port_master',$data);
		return $this->db->insert_id();
	}
		
	public function checkcountry($country_name)
	{
		
		$countries = explode(",",$country_name);
		
		 $q = "SELECT GROUP_CONCAT(id) as  id FROM `country_detail` where c_name in ('".implode("','",$countries)."')";
		 
		 $query = $this->db->query($q);
		 return $query->row();
	}
	
	public function updatedata($data,$id)
	{ 	
	
		$this->db->where('id',$id);
		$updateid= $this->db->update('tbl_port_master',$data);
						
		return $updateid;
	}
	
	
	public function check_port_update($port_name)
	{
		$q=$this->db->where('port_name',$port_name);
		
		$q=$this->db->get('tbl_port_master');

		return $q->row();
	}
	
	public function fetchmodeldata($id)
	 {
		 $q = $this->db->where("id",$id);
		 $q= $this->db->get("tbl_port_master");
		  
		 return $q->row();
	 }
	 
	 //For Update*/
	public function port_update($data,$id)
	{
	  	$this->db->where('id',$id);	
		$q = $this->db->update('tbl_port_master',$data);	
		return $q;
	}	
	
	 //archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_port_master',$data);	
		return $q;	
	}
	
	//delete data
	public function port_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('tbl_port_master');
		
	}
	
	public function checkalready($data)
	{
		
		  $q =  "SELECT `mst`.* FROM `tbl_port_master` as `mst` WHERE  LOWER(mst.port_name) Like '%".strtolower($data['port_name'])."%' and c_name ='".$data['c_name']."' ";
		 $query = $this->db->query($q);
		 return $query->num_rows();
	}
	


}
?>