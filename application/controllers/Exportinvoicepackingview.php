<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoicepackingview extends CI_controller
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
			$data = $this->export->get_invoice_data($id);
				$datap = $this->export->getinvoiceproductdata($id);
			 
				 $sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				  
				$this->load->model('admin_company_detail');
				 $container_data 		= $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			  
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'sample_data'			=> $sample_data,
				  	'menu_data'				=> $menu_data,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
				 	'userdata'				=> $userdata,
					'container_data'		=> $container_data,
					'annexuredata'			=> $get_annexuredata,
					'direct_invoice'		=> $data->direct_invoice,
					'export_supplier_data'	=> $export_supplier_data,
					'mode' 					=> "0" 
				);
			$this->load->view('admin/exportinvoicepackingview',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	

 
}
