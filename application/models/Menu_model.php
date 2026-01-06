<?php
class Menu_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
			
	}
	 public function usermain_menu($user_type_id)
	{
		$files = glob(FCPATH.'/archivefiles/*'); 
		foreach($files as $file) {
   
			if(is_file($file)) 
			// Delete the given file
			unlink($file); 
		}
		 
		$url_name 	= end(explode("/",$_SERVER['REQUEST_URI']));
		$url 		= $_SERVER['REQUEST_URI'];
		
		$sql_url = 'SELECT group_concat(url_name) as allurl FROM  tbl_menu where  status = 0';
		$qry_menu = $this->db->query($sql_url); 
		$allurl = $qry_menu->row();
		 
		if(in_array($url_name,explode(",",$allurl->allurl)))
		{
			 $check_urlsql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 and url_name = '".$url_name."' order by order_by asc"; 
			 $check_yrl_qry = $this->db->query($check_urlsql);
			
			 if($check_yrl_qry->num_rows() == 0)
			 {
				 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
				 $check_yrlqry = $this->db->query($check_urlqry);
				 $url = $check_yrlqry->row();
				 echo "<script>window.location = '".base_url().$url->url_name."'</script>";
			 }
			 else
			 {
				$sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0  and pid = 0 order by order_by asc";
				$query = $this->db->query($sql);
				$return = array();
				foreach($query->result() as $row)
				{
					$sub 			= $row->menu_id;
					 
					if($row->url_name == "invoice_listing")
					{
						$_SESSION['p_menu']	= $row->url_name;
					}
					
					$row->submenu   = $this->usersub_menu($user_type_id,$row->menu_id);
					$return[] = $row;
				}
				return $return; 
			 }
		}
		else
		{
			
				$sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0  and pid = 0 order by order_by asc";
				$query = $this->db->query($sql);
				$return = array();
				$url_array = array();
				foreach($query->result() as $row)
				{
					$sub = $row->menu_id;
					$row->submenu  = $this->usersub_menu($user_type_id,$row->menu_id);
					array_push($url_array,$row->url_name);
					$return[] = $row;
				}
			 
				if(strpos($url,'invoice') !== false && !in_array("invoice_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				}
				if(strpos($url,'performa_invoice_pdf') !== false && !in_array("invoice_listing",$url_array) && !in_array("confirm_pi",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				}
				if(strpos($url,'product') !== false && !in_array("invoice_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'addition_details') !== false && !in_array("invoice_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'create_producation') !== false && !in_array("producation_detail",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'createpo') !== false && !in_array("purchaseorder_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'poproduct') !== false && !in_array("purchaseorder_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'create_pi_loading') !== false && !in_array("assign_producation",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'exportinvoice') !== false && !in_array("exportinvoice_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'customer_invoice') !== false && !in_array("customer_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'cutomerinvoiceproduct') !== false && !in_array("customer_listing",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'customer_detail') !== false && !in_array("customer_detail",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'quotation_listing') !== false && !in_array("quotation",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				if(strpos($url,'supplier_list') !== false && !in_array("supplier",$url_array))
				{
					 $check_urlqry = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id." and menu.status=0 order by order_by asc limit 1";
					$check_yrlqry = $this->db->query($check_urlqry);
					$url = $check_yrlqry->row();
					echo "<h3> you don't have authority to use this page. <h3> <a href='".base_url().$url->url_name."' >Back </a>";
					exit;
				} 
				return $return;
		}
		 
	}
	public function usersub_menu($user_type_id,$pid)
	{
		 $sql = "SELECT menu.* FROM  tbl_userpermission as mst inner join tbl_menu as menu on menu.menu_id=mst.menu_id where usertype_id = ".$user_type_id."  and pid != 0 and menu.status=0 and pid = ".$pid." order by order_by asc";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function user_data()
	{
		 $sql = "SELECT * from tbl_user where sign_pi_status = 1";
		 $query = $this->db->query($sql);
		 return $query->result();
	}
	public function setting_data($id)
	{
		$array = array('log_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('ciadmin_login');
		 //echo $this->db->last_query();
		return $q->row();
	}
	
	public function setting_data1($id)
	{
		$array = array('pi_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('pi_format_onoff');
		 //echo $this->db->last_query();
		return $q->row();
	}
}

?>