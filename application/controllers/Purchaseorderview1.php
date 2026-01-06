<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Purchaseorderview1 extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_purchaseorderpdf','po');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company	= $this->po->company_select();
			$bank		= $this->po->bselect($bankid);
			$data		= $this->po->po_data($id);
			$datap		= $this->po->getpo_productdata($id,$data->performa_invoice_id);
			$menu_data	= $this->menu->usermain_menu($this->session->usertype_id);	
			
	 		$v = array(
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					'menu_data'			=> $menu_data,
					'company_detail'	=> $company 
				);
			$this->load->view('admin/purchaseorderview1',$v);
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
			$company	= $this->po->company_select();
			$bank		= $this->po->bselect($bankid);
			$data		= $this->po->po_data($id);
			$datap		= $this->po->getpo_productdata($id,$data->performa_invoice_id);
			$menu_data	= $this->menu->usermain_menu($this->session->usertype_id);	
			
	 		$v = array(
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					'menu_data'			=> $menu_data,
					'company_detail'	=> $company 
				);
			$this->load->view('admin/purchaseorderview_other_product',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function purchase_pdf($id)
	{
	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company	= $this->po->company_select();
			$bank		= $this->po->bselect($bankid);
			$data		= $this->po->po_data($id);
			$datap		= $this->po->getpo_productdata($id,$data->performa_invoice_id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
	 		$v = array(
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					'menu_data'			=> $menu_data,
					'company_detail'	=> $company,
					'mode'				=> 1
					 				
				);
				 
			$this->load->view('admin/purchaseorderview',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf()
	{
		$this->load->view('admin/purchaseorderpdf');
	}
	
}
