<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Taxinvoicepdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_taxinvoice','taxinvoice');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id){
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{	
			$consign=$this->taxinvoice->select_consigner();
			$this->load->model('admin_company_detail');
			$this->load->model('admin_country_detail');			
			$company = $this->admin_company_detail->s_select();
			$data= $this->taxinvoice->taxinvoice_data($id);
			$consign_other=$this->taxinvoice->other_consigner($data->consiger_id);
			$datap= $this->taxinvoice->gettaxproductdata($id);
			$tax_sample_data		= $this->taxinvoice->gettax_sample_productdata($id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array( 
						'consign_detail'=>$consign,
						'company_detail'=>$company,
						'menu_data'=>$menu_data,
						'countrydata'=>$this->admin_country_detail->s_select(),
						'invoicedata'=>$data,
						'product_data'=>$datap,
						"consignother"=>$consign_other,
						'sample_data'=> $tax_sample_data,
						"mode"=>1
					);
			$this->load->view('admin/taxinvoiceview',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf()
	{
		 $this->load->view('admin/taxinvoicepdf');
	}
	

 
}
