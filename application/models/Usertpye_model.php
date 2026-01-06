<?php 
class Usertpye_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
	}
 	public function insert_usertype($data){
		$q =  $this->db->insert('tbl_usertype',$data); 
		return $this->db->insert_id();
	}
	public function getusertype($id)
	{
		$q = $this->db->where("usertype_id",$id);
		$q = $this->db->get("tbl_usertype");
		return $q->row();
	}
	public function update_data($data_array,$id)
	{ 
		$this->db->where('usertype_id',$id);
		$q=$this->db->update('tbl_usertype',$data_array);
		return $q;
	}
	public function deleterecord($id)
	{
		$this->db->where('usertype_id',$id);
		return $this->db->delete('tbl_usertype');
	}
	public function deletemenurecord($id)
	{
		$this->db->where('menu_id',$id);
		return $this->db->delete('tbl_menu');
	}
	public function insert_menu($data)
	{
		$q =  $this->db->insert('tbl_menu',$data); 
		return $this->db->insert_id();
	}
	public function getmenulist($id)
	{
		$q = $this->db->where("menu_id",$id);
		$q = $this->db->get("tbl_menu");
		return $q->row();
	}
	public function update_menudata($data_array,$id)
	{ 
		$this->db->where('menu_id',$id);
		$q=$this->db->update('tbl_menu',$data_array);
		return $q;
	}
}


?>