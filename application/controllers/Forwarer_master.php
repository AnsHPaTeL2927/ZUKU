<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Forwarer_master extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('forwarer_master_model','supplier');
			$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index(){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data['result']=$this->supplier->supplier_select();
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['forwarer_data']	= $this->supplier->bank_select(); 			
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/forwarer_master',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deletedata = $this->supplier->getsupplier_record($id);
					
		$deleteid=$this->supplier->delete_supplier($id);
		$row=array();
		if($deleteid)
		{
			$row['res'] = 1;
			
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
}

?>