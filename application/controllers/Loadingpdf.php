<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Loadingpdf extends CI_controller
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

	// function index($id)
	// {
		// if(!empty($this->session->id)  && $this->session->title == TITLE)
		// {
			// $this->load->model('admin_company_detail');	
			// $company 			= $this->admin_company_detail->s_select();
			// $data				= $this->export->get_invoice_data($id);
				 
			// $productdata 		= $this->export->getinvoiceproductdata($id);
			 
			 
			// $menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			// $v = array( 
					  // 'direct_invoice'	=> $data->direct_invoice,  
					  // 'menu_data'		=> $menu_data,
					  // 'mode'			=> '1',
					  // 'company_detail'	=> $company,
					  // 'invoicedata'		=> $data,
					  // 'product_data'	=> $productdata 
				 // );
			// $this->load->view('admin/view_loading',$v);
		// }
		// else
		// {
			// redirect(base_url().'');
		// }
	// }
	
	function index($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				$datadirect		 	= $this->export->getinvoice_direct_productdata($id); 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				$loadingpdf_html_data	= $this->export->get_loadingpdf_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'productdata'			=> $datadirect,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
					'loadingpdf_html_data'	=> $loadingpdf_html_data,
					 
					'sample_data'			=> $sample_data,
				  	'menu_data'				=> $menu_data,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
				 	'userdata'				=> $userdata,
				 	'annexuredata'			=> $get_annexuredata,
					'direct_invoice'		=> $data->direct_invoice,
					'export_supplier_data'	=> $export_supplier_data,
					'mode' 					=> "0" 
				);
				$this->load->view('admin/view_loading',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index1($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				$datadirect		 	= $this->export->getinvoice_direct_productdata($id); 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				$loadingpdf_html_data	= $this->export->get_loadingpdf_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'productdata'			=> $datadirect,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
					'loadingpdf_html_data'	=> $loadingpdf_html_data,
					 
					'sample_data'			=> $sample_data,
				  	'menu_data'				=> $menu_data,
					'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
				 	'userdata'				=> $userdata,
				 	'annexuredata'			=> $get_annexuredata,
					'direct_invoice'		=> $data->direct_invoice,
					'export_supplier_data'	=> $export_supplier_data,
					'mode' 					=> "0" 
				);
				$this->load->view('admin/view_loading_print',$v); 
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
