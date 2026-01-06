<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoicepackingpdf extends CI_controller
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
			$data= $this->export->get_invoice_data($id);
			$datap= $this->export->getinvoice_productdata($id,$data->performa_invoice_id,0,1,0);
			 
			$this->load->model('admin_company_detail');
			$userdata = $this->export->ciadmin_login();	
			$get_annexuredata = $this->export->getannexuredata($id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
						
			$v = array(
				'invoicedata'=>$data,
				'menu_data'=>$menu_data,
				'product_data'=>$datap,
				'company_detail'=>$this->admin_company_detail->s_select(),
				'allproduct'=>$this->export->allproductsize(),
				 
				'userdata'=>$userdata,
				'annexuredata'=>$get_annexuredata,
				'mode' => "1"
				);
			 
			$this->load->view('admin/exportinvoicepackingview',$v);
			}
			else
			{
				redirect(base_url().'');
			}
	}
	function view_pdf(){
		
		 
		$this->load->view('admin/exportinvoicepackingpdf');
	}
	

 
}
