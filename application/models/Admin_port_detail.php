<?php 
class Admin_port_detail extends CI_Model{

	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function p_insert($data)
	{

	return $this->db->insert('port_detail',$data);

	}	

	public function p_select(){
		
		$q = $this->db->get('port_detail');
		return $q->result();
	}

	public function p_edit_select($id){
		$this->db->where('id',$id);
		$q = $this->db->get('port_detail');
		return $q->row();
	}

	public function p_edit($data,$id)
	{
	
	//print_r($data);
	//echo $id;	
		
	$this->db->where('id',$id);	
	return $this->db->update('port_detail',$data);	
		
	}

	public function p_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('port_detail');
	}
	
	
}

?>