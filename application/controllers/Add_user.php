<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_user extends CI_Controller {

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
			$this->load->model('admin_company_detail');	
			
			 $data['usertype']  = $this->type->select_all_usertype();
			 $data['company_detail'] =$this->admin_company_detail->s_select(); 
			 	$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			 $this->load->view('admin/add_user',$data);
		}
		else
		{
			$this->load->view('admin/login');
		}
	}
	public function edit($id)
	{	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 { 
			$this->load->model('admin_company_detail');	
			
			 $data['usertype']  = $this->type->select_all_usertype();
			 $data['edit_record']  = $this->type->get_userdata($id);
			 $data['company_detail'] =$this->admin_company_detail->s_select(); 
			 	$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			 $this->load->view('admin/add_user',$data);
		}
		else
		{
			$this->load->view('login');
		}
	}
	      
	public function update_record()
	{
		$data_array = array(
			"user_type" => $this->input->post('edit_user_type') 
	 	);
		$id = $this->input->post('eid');
		$updateid = $this->type->update_data($data_array,$id);
		$row = array();
		if($updateid)
		{
			$row['res'] = 1;
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function delete_record()
	{
		$id = $this->input->post('id');
	 	$updatedid = $this->type->deleterecord($id);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
}
