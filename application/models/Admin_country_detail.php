<?php 
class Admin_country_detail extends CI_Model{

	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function s_insert($data)
	{
		$q = $this->db->insert('country_detail',$data);
		
		return $this->db->insert_id(); 

	}	

	public function s_select()
		{
		
		$q = $this->db->select('con.*,(SELECT count(*) FROM `customer_detail` where c_country = con.id) as total_cnt')
			 ->from('country_detail as con')
			 ->get();
		 
		return $q->result();
	}

	public function s_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('country_detail');
		return $q->row();
	}

	public function s_edit($data,$id)
	{
	
	//print_r($data);
	//echo $id;	
		
	$this->db->where('id',$id);	
	return $this->db->update('country_detail',$data);	
		
	}

	public function s_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('country_detail');
	}
	
	
}

?>