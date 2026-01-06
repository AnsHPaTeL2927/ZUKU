<?php 
class Backup_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
	}
	public function get_table()
	{
		$table_query="show tables;";
		$query = $this->db->query($table_query); 
		return $query->result();
	}
	public function from_table($table)
	{
		$q = $this->db->get($table);
		$result = array();
		$result['fieldcount'] 	= $q->num_fields();
		$result['affectedrows'] = $q->num_rows();
		$result['resultrow'] 	= $q->result_array();
		 
		return $result;
	}
	public function create_table($table)
	{
		$table_query='SHOW CREATE TABLE '.$table;
		$query = $this->db->query($table_query); 
		return $query->result_array();
	}
	public function bkp_restore_data($data)
	{
		$q =  $this->db->insert('tbl_bkp_restore',$data);
		return $this->db->insert_id();
	}
	public function trancate_table($table)
	{
		if($table != "users" && $table != "tbl_employee"  && $table != "tbl_payment_mode" && $table != "tbl_user_permission")
		{
			$table_query='TRUNCATE TABLE '.$table;
			$query = $this->db->query($table_query); 
		}
		return 1;
	}
	public function line($op_data)
	{
		$query = $this->db->query($op_data); 
		return $query;
	}
	public function insert_permission($data)
	{
		$q =  $this->db->insert('tbl_user_permission',$data);
		return $this->db->insert_id();
	}
	public function get_user($id)
	{
		$table_query="SELECT * FROM `users` as mst  where log_id = ".$id;
		$query = $this->db->query($table_query); 
		return $query->row();
	}
	public function get_permission($id)
	{
		$table_query="SELECT * FROM `tbl_user_permission` as mst  where user_id = ".$id;
		$query = $this->db->query($table_query); 
		return $query->result();
	}
	public function delete_permission($user_id)
	{
		$this->db->where('user_id',$user_id);
		return $this->db->delete('tbl_user_permission');
	}
	public function check_oldpassword($old_password,$user_id)
	{
		$qry = $this->db->where('log_password',$old_password);
		$qry = $this->db->where('log_id',$user_id);
		$qry =  $this->db->get('users');
		return $qry->num_rows();
	}
	public function updatepassword($new_password,$user_id)
	{
	  	$data1 =  array('employee_pincode'=> $new_password);
		$userid = $this->db->where('user_id',$user_id);
		$userid = $this->db->update('tbl_employee',$data1);	
		$data =  array(	'log_password'=> $new_password);
		$q =  $this->db->where('log_id',$user_id);
		return $q = $this->db->update('users',$data);	
	}
}
?>