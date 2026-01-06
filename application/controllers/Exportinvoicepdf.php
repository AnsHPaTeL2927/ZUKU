<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoicepdf extends CI_controller
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

	function index($id){
		
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data				= $this->export->get_invoice_data($id);
				$datap				= $this->export->getinvoiceproductdata($id);
				 
				$productdata		= $this->export->getinvoice_productdata($id,$data->performa_invoice_id,0,1,0,$data->direct_invoice,$data->container_status);
				$this->load->model('admin_company_detail');
				 
				$userdata 			= $this->export->ciadmin_login();	
				$get_annexuredata 	= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
					$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'menu_data'				=>	$menu_data,
					'sample_data'			=> $sample_data,
					'annxureproduct_data'	=> $productdata,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
				 	'userdata'				=> $userdata,
					'annexuredata'			=> $get_annexuredata,
					'export_supplier_data'	=> $export_supplier_data,
					'mode' 					=> "1" 
				);
			$this->load->view('admin/exportinvoiceview',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function index1($id){
		
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data				= $this->export->get_invoice_data($id);
				$datap				= $this->export->getinvoiceproductdata($id);
				 
				 $productdata		= $this->export->getinvoice_productdata($id,$data->performa_invoice_id,0,1,0,$data->direct_invoice,$data->container_status);
				$this->load->model('admin_company_detail');
				 
				$userdata 			= $this->export->ciadmin_login();	
				$get_annexuredata 	= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
					$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'menu_data'				=>	$menu_data,
					'sample_data'			=> $sample_data,
					'annxureproduct_data'	=> $productdata,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
				 	'userdata'				=> $userdata,
					'annexuredata'			=> $get_annexuredata,
					'export_supplier_data'	=> $export_supplier_data,
					'mode' 					=> "0" 
				);
			$this->load->view('admin/exportinvoiceview1',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf(){
		
		 
		$this->load->view('admin/exportinvoicepdf');
	}
	function viewdoc()
	{
	 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 
			$this->load->view('admin/exportinvoice_doc',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		 
	}

 
}
