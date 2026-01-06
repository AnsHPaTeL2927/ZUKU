<?php
class Container_loading_model extends CI_Model 
{

	 
	public function showcontainer_records()
	{
		//$q=$this->db->select ("group_concat (c_name) from country_detail as c where find_in_set(c.id,mst.c_name) and status = 0 as c_name FROM tbl_agent_master");
		$q=$this->db->order_by('status','asc');
		$q=$this->db->order_by('pi_no','asc');
		$q=$this->db->get('tbl_container_loading');
		return $q->result();
	}
	
	public function data_update($names)
	{ 	
		$q = $this->db->where('container_loading_id',$id);	
		$q =  $this->db->update('tbl_container_loading',$names);	
		return $q;
	}
	
	public function update_container_loading($data,$container_loading_id)
	{ 	
		 
		$q = $this->db->where('container_loading_id',$container_loading_id);	
		$q =  $this->db->update('tbl_container_loading',$data);	
		return $q;
	}
	
	 public function get_extra_detail($id){
		
		$q = $this->db->select('*')
			 ->from('tbl_container_loading')
			 ->where('container_loading_id',$id)
			 
			->get();	
		
		return $q->row();
	}

public function check_terms_update($container_loading_id)
	{
		$q=$this->db->where('container_photos_id',$container_loading_id);
		
		$q=$this->db->get('container_photos');

		return $q->row();
	}
	
	public function get_photos_detail(){
		
		$q = $this->db->select('*')
			 ->from('container_photos')
			 //->where('container_photos_id',$id)
			 // ->where('container_loading_id',$container_loading_id)
			 // ->where('document_master_id',$document_master_id)
			 
			->get();	
		
		return $q->row();
	}
	
	public function insert_container_photos_mst($data)
	{
		$insertid = $this->db->insert('tbl_container_loading',$data);
		return $this->db->insert_id();

	}
	
	public function container_insert($data)
	{
		$insertid = $this->db->insert('tbl_container_loading',$data);
		return $this->db->insert_id();

	}
	
	public function update_additional_detail($data,$customer_add_detail_id)
	{
		$q = $this->db->where('container_loading_id',$customer_add_detail_id);	
		$q =  $this->db->update('tbl_container_loading',$data);	
		return $q;	
	}
	
	public function update_photos($container_photos_id,$images_array)
	{
		$data = array(
			"upload_logo"=>implode(",",$images_array)
		);
		$q = $this->db->where('container_photos_id',$container_photos_id);	
		$q =  $this->db->update('container_photos',$data);	
		return $q;	
	}
	
	public function data_additional_update($names,$customer_add_detail_id)
	{
		$q = $this->db->where('container_photos_id',$customer_add_detail_id);	
		$q =  $this->db->update('container_photos',$names);	
		return $q;	
	}
	
	public function get_image_data($document_master_id,$pi_loading_plan_id,$container_no)
	{
		
		$q = $this->db->select('*')
			 ->from('tbl_container_loading as mst')
			 ->join('container_photos as trn','trn.container_loading_id = mst.container_loading_id','inner')
			 ->where('pi_loading_plan_id ',$pi_loading_plan_id)
			 ->where('trn.document_master_id ',$document_master_id)
			 ->where('mst.container_no ',$container_no)
		 	 ->get();	
		 
		return $q->row();
	}
	
	public function labeldata($pi_loading_plan_id,$container_no)
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_document_master as mst")
			 ->where('mst.status',"0")
			 ->where('is_active',"Yes")
			  ->get();
			  $return = array();
			   $i=0;
			  foreach($q->result() as $row)
			  {
				  $return[$i] = $row;
				  $row->images_data = $this->get_image_data($row->document_master_id,$pi_loading_plan_id,$container_no);
				  
				  $i++;
			  }
			  
		 return $return;
	 }
	 
	 public function insert_container_photos_trn($names)
		{
			  $id =  $this->db->insert('container_photos',$names);
			   // $id = $this->db->where('upload_logo',$filename); 
			  return $this->db->insert_id();
			  
		}
	 
	 public function delete_photos($container_loading_id,$document_master_id)
		{
			$q = $this->db->where('container_loading_id',$container_loading_id);
			$q = $this->db->where('document_master_id',$document_master_id);
			$q = $this->db->delete('container_photos');
			
			//print_r($q);
			// var_dump($q);
		return $q;
			  
		}
		
	public function fetchimagedata($container_photos_id)
	 {
		
		$q = $this->db->where('container_photos_id',$container_photos_id);
		 $q= $this->db->get("container_photos");
		
		  
		 return $q->row();
	 }
	 
	 public function deleteimage($container_loading_id,$document_master_id)
	 { 	
		$q = $this->db->where('container_loading_id',$container_loading_id);
		$q = $this->db->where('document_master_id',$document_master_id);
		$q = $this->db->delete('container_photos');
		 
		return $q;
	 }
	 
	 public function delete_photosdata($container_photos_id)
	 { 	
		$q = $this->db->where('container_photos_id',$container_photos_id);
		
		$q = $this->db->delete('container_photos');
		 
		return $q;
	 }
	 
		
}
?>