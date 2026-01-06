<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Without_image_con extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice_product','export');
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
			$company 			= $this->admin_company_detail->s_select();
			$data				= $this->export->get_invoice_data($id);
				 
			$productdata 		= $this->export->getinvoiceproductdata($id);
			 
			 
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array( 
					  'direct_invoice'	=> $data->direct_invoice,  
					  'menu_data'		=> $menu_data,
					  'mode'			=> '1',
					  'company_detail'	=> $company,
					  'invoicedata'		=> $data,
					  'product_data'	=> $productdata 
				 );
			$this->load->view('admin/without_image',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf(){
		 $this->load->view('admin/loadingpdf');
	}
	

 
}
