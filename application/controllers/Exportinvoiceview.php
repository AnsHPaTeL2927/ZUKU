<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoiceview extends CI_controller
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
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				$datadirect		 	= $this->export->getinvoice_direct_productdata($id);
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				  
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
				$this->load->view('admin/exportinvoiceview',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	
	
		function index_new($id)
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
				$this->load->view('admin/exportinvoiceview_new',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function index_cnf($id)
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
				$this->load->view('admin/exportinvoiceview_cnf',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}

	function exportinvoice_invoice($id)
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
				$this->load->view('admin/export-invoicedata',$v); 
		}
			else
			{
				redirect(base_url().'');
			}	
	}
	
	function index_nepal($id)
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
				$this->load->view('admin/exportinvoiceview_nepal',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index_nepal_packing($id)
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
				$this->load->view('admin/exportinvoiceview_nepal_packing',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index_icolux($id)
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
				$this->load->view('admin/exportinvoiceview_icolux',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index_velsa($id)
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
				$this->load->view('admin/exportinvoiceview_velsa',$v); 
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
				$this->load->view('admin/exportinvoiceview_supplier',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index_batch_shade($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
					 
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
				$this->load->view('admin/exportinvoiceview_batch_shade',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	
	function index_kg($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
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
				$this->load->view('admin/exportinvoiceview_kg',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function invoice_inr($id)
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
				  
				$this->load->model('admin_company_detail');
				$container_data 		= $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			  
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/exportinvoiceview_inr',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	
	function other_product($id)
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
				  
				$this->load->model('admin_company_detail');
				$container_data 		= $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			  
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/exportinvoice_other_product_view',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function onlyinvoice($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data = $this->export->get_invoice_data($id);
				$datap = $this->export->getinvoiceproductdata($id);
				$datadirect = $this->export->getinvoice_direct_productdata($id);
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
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/export_only_invoice_view',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function onlyinvoicepacking($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data = $this->export->get_invoice_data($id);
				$datap = $this->export->getinvoiceproductdata($id);
				$datadirect = $this->export->getinvoice_direct_productdata($id);
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
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/export_only_invoice_packing_view',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function onlyinvoicepacking_nodesign($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data = $this->export->get_invoice_data($id);
				$datap = $this->export->getinvoiceproductdata($id);
				$datadirect = $this->export->getinvoice_direct_productdata($id);
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
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/export_only_invoice_packing_view_nodesign',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function onlyinvoiceannexure($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data = $this->export->get_invoice_data($id);
				$datap = $this->export->getinvoiceproductdata($id);
				$datadirect = $this->export->getinvoice_direct_productdata($id);
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
					'productdata'			=> $datadirect,
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
				$this->load->view('admin/export_only_invoice_annexure_view',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function without_design($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
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
				$this->load->view('admin/exportinvoiceview_without_design',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function with_design($id)
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data			    = $this->export->get_invoice_data($id);
				$datap 				= $this->export->getinvoiceproductdata($id);
				 
				$sample_data		= $this->export->getinvoicesampleproductdata($id,0);
				$html_data			= $this->export->get_invoice_html($id);
				$packing_html_data	= $this->export->get_packing_html($id);
				$annexure_html_data	= $this->export->get_annexure_html($id);
				  
				$this->load->model('admin_company_detail');
			 
				$userdata 				= $this->export->ciadmin_login();	
				$get_annexuredata 		= $this->export->getannexuredata($id);
				$export_supplier_data 	= $this->export->get_export_supplier($id);
				$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			 	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'annexure_html_data'	=> $annexure_html_data,
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
				$this->load->view('admin/exportinvoiceview_with_design',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	function excel()
	{ 	
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
					$this->load->view('admin/exportinvoiceexcel',$v); 
			 }
	}

 
}
