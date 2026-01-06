<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_permission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','type');
		$this->load->model('menu_model','menu');		
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session'));
				
	}
	public function index()
	{	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 $data['afterstep'] = 0;
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();
			$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$data['usertype'] = $this->type->select_all_usertype();
		 	 $this->load->view('admin/user_permission',$data);
		}
		else
		{
			$this->load->view('admin/login');
		}
	}
	public function set_permission($userid)
	{	
		if(!empty($this->session->user_id))
		{
			 $data['afterstep'] = 0;
			 $data['usertype']  = $this->type->select_all_usertype();
			 $data['menu_data'] = $this->type->usermain_menu($this->session->user_type_id);
			 $data['name']	    = $this->type->get_userdata($userid);
			 $data['userid'] 	= $userid;
			 $data['loadmenu']  = $this->type->loadmain_menu();
		 	 $this->load->view('user_wise_permission',$data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	public function load_menu()
	{
		$loadmenu = $this->type->loadmain_menu();
		$user_type_id = $this->input->post('user_type_id');
		$str = '';
		$m=0;
		foreach($loadmenu as $menu)
		{
			$checked = '';
			$checkmenu_no = $this->type->checkmenu_permission($menu->menu_id,$user_type_id);
			 
			if($checkmenu_no > 0)
			{
				$checked = "checked='checked'";
			}
			$str .= ' 
				 	<div class="col-md-6">
						<label>
							<input type="checkbox" name="menu_name[]" id="menu_name'.$m.'" value="'.$menu->menu_id.'" onclick="check_submenu('.$menu->menu_id.',this.checked)" '.$checked.'/> 
								'.$menu->menu_name.'
						</label>';
				$subloadmenu = $this->type->loadsub_menu($menu->menu_id);
				$j=1;
				foreach($subloadmenu as $submenu)
				{		
					$checked1 = '';
					$checkmenu_no1 = $this->type->checkmenu_permission($submenu->menu_id,$user_type_id);
					 
					if($checkmenu_no1 > 0)
					{
						$checked1 = "checked='checked'";
					}
					$str .= '<div class="col-md-offset-1 ">
								<label>
									<input type="checkbox" name="menu_name'.$menu->menu_id.'[]" id="menu_name'.$menu->menu_id.$j.'"  value="'.$submenu->menu_id.'" '.$checked1.' /> '.$submenu->menu_name.'
							</label>
							</div>';
							$j++;
				}
				$str .= ' </div> 
					';
					$m++;
		}
				 echo $str;
	}
	public function manage()
	{
		$id = $this->input->post('user_type_id');
		$deleteid= $this->type->delete_userpermission($id);
		 
		$loadmenu = $this->type->loadmain_menu();
		$no=0;
		foreach($loadmenu as $menu)
		{
		 	  
			if(in_array($menu->menu_id,$this->input->post('menu_name')))
			{
				$data = array(
						"usertype_id"	=> $this->input->post('user_type_id'),
						"menu_id"		=> $menu->menu_id
					);
					 
				 $insertid = $this->type->insert_userpermission($data);
			}
				$subloadmenu = $this->type->loadsub_menu($menu->menu_id);	
			$sno = 0;
			foreach($subloadmenu as $submenu)
			{	
				if(in_array($submenu->menu_id,$this->input->post('menu_name'.$menu->menu_id)))
				{
					$data1 = array(
						"usertype_id"	=> $this->input->post('user_type_id'),
						"menu_id"		=> $submenu->menu_id
					);
					$insertid = $this->type->insert_userpermission($data1);
				}
				$sno++;
			}	
				$no++;
		}
		$r['res'] = 1;
		echo json_encode($r);
	}
	public function user_manage()
	{
		$id = $this->input->post('user_id');
		$deleteid= $this->type->delete_userwise_permission($id);
		 
		$loadmenu = $this->type->loadmain_menu();
		$no=0;
		foreach($loadmenu as $menu)
		{
		 	  
			if(in_array($menu->menu_id,$this->input->post('menu_name')))
			{
				$data = array(
						"user_id"		=> $this->input->post('user_id'),
						"menu_id"		=> $menu->menu_id
					);
					 
				 $insertid = $this->type->insert_userpermission($data);
			}
				$subloadmenu = $this->type->loadsub_menu($menu->menu_id);	
			$sno = 0;
			foreach($subloadmenu as $submenu)
			{	
				if(in_array($submenu->menu_id,$this->input->post('menu_name'.$menu->menu_id)))
				{
					$data1 = array(
						"user_id"		=> $this->input->post('user_id'),
						"menu_id"		=> $submenu->menu_id
					);
					$insertid = $this->type->insert_userpermission($data1);
				}
				$sno++;
			}	
				$no++;
		}
		$r['res'] = 1;
		echo json_encode($r);
	}

}
