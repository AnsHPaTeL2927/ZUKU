<?php
class Vessel_data_model extends CI_Model 
{
		
		
	//updated insert data
	public function doc_insert($data){
		  $id = $this->db->insert('tbl_vessel_data',$data); 
		  return $this->db->insert_id();
	}
	
		
	public function check_doc_update($dname)
	{
		$q=$this->db->where('name',$dname);
		// $q=$this->db->where('status',0);
		$q=$this->db->get('tbl_vessel_data');

		return $q->row();
	} 
	
	//For Update*/
	public function doc_update($data,$id)
	{
	  	$this->db->where('id',$id);	
		$q = $this->db->update('tbl_vessel_data',$data);	
		return $q;
	}	
	
	//delete data
	public function doc_delete($id)
	{
		$this->db->where('id',$id);
		return $this->db->delete('tbl_vessel_data');
		
	}
	
	//archieve records
	public function archive_record($id,$status)
	{
		$data = array(
			"status" => $status
		);
		
		$q = $this->db->where('id',$id);	
		$q =  $this->db->update('tbl_vessel_data',$data);	
		return $q;	
	}
	
	
	public function fetch_data($id){
		$q=$this->db->where('id',$id);
		$q=$this->db->get('tbl_vessel_data');
		 
		return $q->row();
	}
}	
?>
	