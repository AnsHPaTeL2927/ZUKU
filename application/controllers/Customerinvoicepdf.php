<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Customerinvoicepdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Customer_invoice_model','custinvoice');
		$this->load->model('menu_model','menu');
		$this->load->model('admin_exportinvoice_product');		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data= $this->custinvoice->get_invoice_data($id);
				 
				$array 				= explode("-",$data->export_invoice_id);
				$loading_trn = $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data		= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
		
		 	
			 	$this->load->model('admin_company_detail');
				$userdata 	= $this->custinvoice->ciadmin_login();
				$menu_data 	= $this->menu->usermain_menu($this->session->usertype_id);	
			 		$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			
			  	$v = array(
					'invoicedata'		=> $data,
					'product_data'		=> $loading_trn,
					'sample_data'		=> $sample_data,
					'direct_invoice' 	=> $data->direct_invoice,  
					'menu_data'			=> $menu_data,
				 	'company_detail'	=> $this->admin_company_detail->s_select(),
					'export_supplier_data'	=> $export_supplier_data,
				 	'userdata'			=> $userdata,
				 	'mode'				=> "1" 
				 );
				$this->load->view('admin/customerinvoiceview',$v); 
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function other_product($id){
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
			$data= $this->custinvoice->get_invoice_data($id);
				 
				$array 				= explode("-",$data->export_invoice_id);
				$loading_trn = $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data		= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
		
		 	
			 	$this->load->model('admin_company_detail');
				$userdata 	= $this->custinvoice->ciadmin_login();
				$menu_data 	= $this->menu->usermain_menu($this->session->usertype_id);	
			 		$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			
			  	$v = array(
					'invoicedata'		=> $data,
					'product_data'		=> $loading_trn,
					'sample_data'		=> $sample_data,
					'direct_invoice' 	=> $data->direct_invoice,  
					'menu_data'			=> $menu_data,
				 	'company_detail'	=> $this->admin_company_detail->s_select(),
					'export_supplier_data'	=> $export_supplier_data,
				 	'userdata'			=> $userdata,
				 	'mode'				=> "0" 
				 );
				$this->load->view('admin/customerinvoice_other_product',$v); 
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf(){
		
		 
		$this->load->view('admin/customerinvoicepdf');
	}
	

 
}
