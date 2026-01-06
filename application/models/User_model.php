<?php 
class User_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();	
		$this->load->database();
	}
	public function insert_user_customer($data){
		$q =  $this->db->insert('tbl_user_wise_customer',$data);
		
		return $this->db->insert_id();
	}
	public function update_user_customer($user_wise_customer_id,$data){
		$this->db->where('user_wise_customer_id',$id);
		$q=$this->db->update('tbl_user_wise_customer',$data);
		return $q;
	}
 	public function get_user_list()
	{
		$sql = "select * from tbl_user as mst inner join tbl_usertype as type on type.usertype_id = mst.usertype_id where mst.status = 0";
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	public function get_user_wise_customer($user_id)
	{
		$sql = "select * from tbl_user_wise_customer as mst inner join customer_detail as  cust on  cust.id = mst.customer_id where mst.status = 0 and mst.user_id=".$user_id;
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	public function getcustomer(){
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function select_all_usertype()
	{
		$sql = "SELECT usertype_id,user_type FROM  tbl_usertype  where status = 0";
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	public function insert_user($data){
		$q =  $this->db->insert('tbl_user',$data); 
		return $this->db->insert_id();
	}
	public function deleterecord($id)
	{
		$this->db->where('user_id',$id);
		return $this->db->delete('tbl_user');
	}
	public function remove_cust_record($id,$data)
	{
		$q = $this->db->where('user_wise_customer_id',$id);
		$q = $this->db->update('tbl_user_wise_customer',$data);
		
		return $q;
	}
	public function loadmain_menu()
	{
		$sql = "SELECT menu_id, menu_name, fa_icon, url_name, pid  FROM tbl_menu where pid = 0";
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	public function loadsub_menu($menu_id)
	{
		$sql = "SELECT menu_id, menu_name, fa_icon, url_name, pid  FROM tbl_menu where pid = ".$menu_id;
		$query = $this->db->query($sql);
	    return $query->result(); 
	}
	public function insert_userpermission($data){
		$q =  $this->db->insert('tbl_userpermission',$data);
		
		return $this->db->insert_id();
	}
	public function delete_userpermission($id)
	{
		$this->db->where('usertype_id',$id);
		return $this->db->delete('tbl_userpermission');
	}
	public function updaterecord($id,$data)
	{
		$this->db->where('user_id',$id);
		$q=$this->db->update('tbl_user',$data);
		return $q;
 	}
	public function delete_userwise_permission($id)
	{
		$this->db->where('user_id',$id);
		return $this->db->delete('tbl_userpermission');
	}
	public function checkmenu_permission($menu_id,$user_type_id)
	{
		$sql = "SELECT *  FROM tbl_userpermission where menu_id = ".$menu_id." and usertype_id=".$user_type_id;
		$query = $this->db->query($sql);
	    return $query->num_rows(); 
	}
	public function checkmenu_userwise_permission($menu_id,$user_id)
	{
		$sql = "SELECT *  FROM tbl_userpermission where menu_id = ".$menu_id." and user_id=".$user_id.' and usertype_id is null';
		$query = $this->db->query($sql);
	    return $query->num_rows(); 
	}
	public function check_user_pin($pin_no,$employee_id)
	{
		$sql = "SELECT *  FROM tbl_user where pin_no = '".$pin_no."' and employee_id = ".$employee_id;
		$query = $this->db->query($sql);
	    return $query->num_rows(); 
	}
	 
	public function usermain_menu($user_type_id)
	{
		$user_id = $this->session->usertableid;
		$usersql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where user_id = ".$user_id." and usertype_id is null and pid = 0 order by order_by asc";
		$userquery = $this->db->query($usersql);
		 if($userquery->num_rows()>0)
		{
				$return = array();
				foreach($userquery->result() as $userrow)
				{
					$sub = $userrow->menu_id;
					$userrow->submenu  = $this->userwise_sub_menu($user_id,$userrow->menu_id);
					$return[] = $userrow;
				}
				return $return;
		
		}
		else
		{
				$sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and user_id is null and pid = 0 order by order_by asc";
				$query = $this->db->query($sql);
				$return = array();
				foreach($query->result() as $row)
				{
					$sub = $row->menu_id;
					$row->submenu  = $this->usersub_menu($user_type_id,$row->menu_id);
					$return[] = $row;
				}
				return $return;
		}
	}
	public function usersub_menu($user_type_id,$pid)
	{
		 $sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and user_id is null and pid != 0 and pid = ".$pid." order by order_by asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function userwise_sub_menu($user_id,$pid)
	{
		 $sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where user_id = ".$user_id." and usertype_id is null and pid != 0 and pid = ".$pid." order by order_by asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function allbranch($work_location)
	{
		 $where = '';
		 if(!empty($work_location) && $this->session->user_type_id != 4)
		 {
		 	$where = " and  work_location = '".$work_location."'";
		 }
	 
		$sql = "SELECT  work_location,count(*) as no_of_emp FROM hr_employee where work_location != '' and work_location != 'LEFT' ".$where." Group by work_location order by work_location";
		$query = $this->db->query($sql);
	    return $query->result(); 
	} 
	public function get_userdata($id)
	{
		$sql = "SELECT * FROM tbl_user as mst  where mst.user_id = ".$id;
		$query = $this->db->query($sql);
	  	return $query->row(); 
	}

}


?>