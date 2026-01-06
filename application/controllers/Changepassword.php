<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Changepassword extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->load->model('Changepasswordmodel','changepassword');
		$this->load->model('menu_model','menu');	
	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index(){
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
			$response['status'] = '0';
			$this->load->model('admin_company_detail');	
			$response['company_detail'] = $this->admin_company_detail->s_select();
			$response['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
						
			$this->load->view('admin/change-password',$response);
		}
		else
		{
			$this->load->view('admin/index');
		}
	}
	public function manage(){
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');
		$confirm_new_password = $this->input->post('confirm_new_password');
		if($new_password==$confirm_new_password)
		{
			 
			 $old_passwordmatch = $this->changepassword->check_oldpassword($old_password,$this->session->id);
			 if($old_passwordmatch == 0)
			 {
				 $response['status'] = 2;
				 $this->load->model('admin_company_detail');	
				$response['company_detail'] = $this->admin_company_detail->s_select();	
		 
				 $this->load->view('admin/change-password',$response);
			 }
			 else{
				  $this->changepassword->updatepassword($new_password,$this->session->id);
				 $response['status'] = 1;
				 $this->load->model('admin_company_detail');	
				$response['company_detail'] = $this->admin_company_detail->s_select();	
		 
				$this->load->view('admin/change-password',$response);
			 }
			 
		}
		else
		{
			$response['status'] =3;
			$this->load->view('admin/change-password',$response);
		}
	}
 
}



?>