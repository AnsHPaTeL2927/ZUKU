<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Performa_invoice_pdf7 extends CI_controller
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

	function index($id){
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company			=	$this->pinv->company_select();
			$bankid				=	$company[0]->bank_name;
			$bank				= 	$this->pinv->bselect($bankid);
			$data				= 	$this->pinv->select_invoice_data($id);
			$datap				= 	$this->pinv->product_data($id);
			$menu_data			=   $this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 		= 	$this->pinv->get_invoice_html($id,'performa_invoice_pdf7');
		 
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'invoice_html_data'	=> $html_data,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_pdf7',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf(){
		$this->load->view('admin/pdfreport1');
	}
}
