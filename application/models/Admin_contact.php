<?php 
class Admin_contact extends CI_Model{

public function __construct()
{
parent:: __construct();	
$this->load->database();
	
}



public function s_edit_select(){
	$q = $this->db->get('contact');
	return $q->row();
}

public function s_edit($data,$id)
{
//print_r($data);
//echo $id;	
	
$this->db->where('c_id',$id);	
return $this->db->update('contact',$data);	
	
}

	
}

?>