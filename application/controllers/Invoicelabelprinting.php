<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Invoicelabelprinting extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_invoice','pinv');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id){
		
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			
			$datap= $this->pinv->productdata_select($id);
			$this->load->model('admin_company_detail');
			$userdata = $this->pinv->ciadmin_login();	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
				'product_data'		=> $datap,
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
//				'container_data'	=> $container_data,
				'userdata'			=> $userdata,
				'mode'			 	=> "0"
				);
		$this->load->view('admin/exportinvoicelabelprinting',$v);
		 }
		 else
		 {
		 	redirect(base_url().'');
		 }

	}
	function view_pdf(){
		
		 
		$this->load->view('admin/exportinvoicelabelprintingpdf');
	}

 
}
