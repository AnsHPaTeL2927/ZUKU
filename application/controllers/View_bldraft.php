<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class View_bldraft extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Customer_invoice_model','custinvoice');
		$this->load->model('admin_exportinvoice_product');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE)
		{
			redirect(base_url());
        }
	}

	function index($id)
	{
	 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
				$data					= $this->custinvoice->get_invoice_data($id);
				$array 					= explode("-",$data->export_invoice_id);
				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
				
				$this->load->model('admin_company_detail');
				$html_data				= $this->custinvoice->get_bl_html($id);
				$userdata 				= $this->custinvoice->ciadmin_login();	
				$menu_data	 			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			 	$v = array(
					'invoicedata'			=> $data,
					'html_data'				=> $html_data,
					'product_data'			=> $loading_trn,
					'sample_data'			=> $sample_data,
				 	'company_detail'		=> $this->admin_company_detail->s_select(),
			 	 	'userdata'				=> $userdata,
				 	'menu_data'				=> $menu_data,
					'mode' 					=> "0" 
				);
			$this->load->view('admin/view_bl_draft',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		 
	}
	function view_pdf($id)
	{
	 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 { 
				$data					= $this->custinvoice->get_invoice_data($id);
				$array 					= explode("-",$data->export_invoice_id);
				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
				
				$this->load->model('admin_company_detail');
				$html_data				= $this->custinvoice->get_bl_html($id);
				$userdata 				= $this->custinvoice->ciadmin_login();	
				$menu_data	 			= $this->menu->usermain_menu($this->session->usertype_id);	
			$v = array( 
						'mode'			=> '1',
					 	'bldata'		=> $get_bldraft,
					 	'invoicedata'	=> $data,
						'product_data'	=> $datap,
			 			'mutiple_status'=> 1
					);
			$this->load->view('admin/view_bl_draft',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		 
	}
	function viewpdf()
	{
	 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 
			$this->load->view('admin/bl_draft_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		 
	}
	function viewdoc()
	{
	 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 
			$this->load->view('admin/bl_draft_doc',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		 
	}
 
}
