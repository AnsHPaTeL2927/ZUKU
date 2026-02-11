<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Performa_invoice_pdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_pdf','pinv');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf');
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'setting_data'			=> $this->menu->setting_data1(1),
					'mode' 			 		=> "0" 
					 
				);

			
			$this->load->view('admin/performa_invoice_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	/**
	 * Download PI PDF (uses Email_service: template + download).
	 */
	function download_pdf($id)
	{
		if (!empty($this->session->id) && $this->session->title == TITLE) {
			$this->load->library('Email_service');
			$this->email_service->download_pi_pdf($id);
		} else {
			redirect(base_url().'');
		}
	}
	
	function index_inr_dollar($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf');
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'setting_data'			=> $this->menu->setting_data1(1),
					'mode' 			 		=> "0" 
					 
				);
			$this->load->view('admin/performa_invoice_pdf_inr_dollar',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	
	function index_pending($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data11($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf');
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'setting_data'			=> $this->menu->setting_data1(1),
					'mode' 			 		=> "0" 
					 
				);
			$this->load->view('admin/performa_invoice_pdf_pending',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	function index_concor($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf');
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'setting_data'			=> $this->menu->setting_data1(1),
					'mode' 			 		=> "0" 
					 
				);
			$this->load->view('admin/performa_invoice_pdf_concor',$v);
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
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf');
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'setting_data'			=> $this->menu->setting_data1(1),
					'mode' 			 		=> "0" 
					 
				);
			$this->load->view('admin/performa_invoice_pdf_asiaceramic',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function index2($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_with_clientdetail_pdf');
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_with_clientdetail_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
		function index3($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_with_clientdetail_pdf2');
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_with_clientdetail_pdf2',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	
	function index_accord($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_accord_pdf');
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_accord_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function index_olwin($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_olwin_pdf');
		
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_olwin_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function index_withthickness($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->pinv->get_invoice_html($id,'performa_invoice_with_thickness_pdf');
		
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_with_thickness_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function delete_editable()
	{
		$performa_invoice_id  = $this->input->post('performa_invoice_id');
		$performa_invoice_pdf = $this->input->post('performa_invoice_pdf');
	  	$rs					  = $this->pinv->delete_editable($performa_invoice_id,$performa_invoice_pdf);
		if($this->input->post('invoiceview') == 'export_invoice')
		{
			$rs = $this->pinv->delete_editable($performa_invoice_id,'packing_html');
			$rs = $this->pinv->delete_editable($performa_invoice_id,'annexure');
		}
		else if($this->input->post('invoiceview') == 'commercial_invoice')
		{
			$rs = $this->pinv->delete_editable($performa_invoice_id,'commercial_packing_html');
			 
		}
		echo 1;
	}
	function view_pdf()
	{
		$this->load->view('admin/pdfreport1');
	}
}
