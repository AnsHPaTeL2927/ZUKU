<?php

class Changepasswordmodel extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
			
	}
	public function check_oldpassword($old_password,$id)
	{
		$qry = $this->db->where('password',md5($old_password));
		$qry = $this->db->where('user_id',$id);
		$qry =  $this->db->get('tbl_user');
		return $qry->num_rows();
	}
	public function updatepassword($new_password,$id)
	{
		$data =  array(	'password'=> md5($new_password));
		 $qry = $this->db->where('user_id',$id);
		 return $this->db->update('tbl_user',$data);	
	}
 
}

?>