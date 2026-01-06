<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Taxinvoiceview extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_taxinvoice','taxinvoice');
		$this->load->model('admin_exportinvoice','exportinvoice');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 { 
			$consign=$this->taxinvoice->select_consigner();
			$this->load->model('admin_company_detail');
			$this->load->model('admin_country_detail');			
			$company = $this->admin_company_detail->s_select();
			$html_data				= $this->taxinvoice->get_invoice_html($id);
			$data= $this->taxinvoice->taxinvoice_data($id);
			$consign_other=$this->taxinvoice->other_consigner($data->consiger_id);
			$datap= $this->taxinvoice->gettaxproductdata($id);
			$tax_sample_data		= $this->taxinvoice->gettax_sample_productdata($id);
						$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 			
			$v = array( 
						'consign_detail'=>	$consign,
						'company_detail'=>	$company,
						'invoice_html_data'		=> $html_data,
						'menu_data'		=>	$menu_data,
						'countrydata'	=>	$this->admin_country_detail->s_select(),
						'invoicedata'	=>	$data,
						'product_data'	=>	$datap,
						"consignother"	=>	$consign_other,
						'sample_data'	=>  $tax_sample_data,
						"mode"=>0
					);
			$this->load->view('admin/taxinvoiceview',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	public function invoice_html_update()
	{
	 
		$taxinvoice_id	= $this->input->post('taxinvoice_id');
		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$taxinvoice_id,
			"invoice_html" 			=> 	$invoice_html,
			"invoice_table_name" 	=> 	'tax_invoice',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->exportinvoice->check_invoice_html('tax_invoice',$taxinvoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->exportinvoice->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->exportinvoice->update_invoice_html($data,$taxinvoice_id,'tax_invoice');
		}
		if($insertid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	 function other_product($id)
	{
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
						'consign_detail'=>	$consign,
						'company_detail'=>	$company,
						'menu_data'		=>	$menu_data,
						'countrydata'	=>	$this->admin_country_detail->s_select(),
						'invoicedata'	=>	$data,
						'product_data'	=>	$datap,
						"consignother"	=>	$consign_other,
						'sample_data'	=>  $tax_sample_data,
						"mode"=>0
					);
			$this->load->view('admin/taxinvoice_other_view',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	

}
