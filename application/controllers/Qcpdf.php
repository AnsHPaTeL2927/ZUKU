<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Qcpdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$company = $this->admin_company_detail->s_select();
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array( 
					  'menu_data'=>$menu_data,
					  'mode'=>'1',
					  'company_detail'=>$company,
					  'invoicedata'=>$data,
					
				 );
			$this->load->view('admin/view_qc',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf()
	{
		 $this->load->view('admin/qcpdf');
	}
	

 
}
