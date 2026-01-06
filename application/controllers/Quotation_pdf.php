<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Quotation_pdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_quotation','quotation');
		$this->load->model('admin_product_invoice','pinv');
		
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->quotation->company_select();
			$bankid			=	$company[0]->bank_name;
			 
			$data			= 	$this->quotation->select_quotation_data($id);
			$datap			= 	$this->quotation->productdata_select($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data	 	= 	$this->quotation->get_invoice_html($id);
			$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $datap,
					'invoice_html_data'		=> $html_data,
					'menu_data'		 		=> $menu_data,
					'user_data'		 		=> $user_data,
					'bank'			 		=> $bank,
					'company_detail' 		=> $company,
					'mode' 			 		=> "0" 
					 
				);
			$this->load->view('admin/quotation_pdf',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function invoice_html_update()
	{
	 
		$performa_invoice_id	= $this->input->post('performa_invoice_id');
		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$performa_invoice_id,
			"invoice_html" 			=> 	$invoice_html,
			"invoice_table_name" 	=> 	'performa_invoice_pdf1',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->pinv->check_invoice_html('performa_invoice_pdf1',$performa_invoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->pinv->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->pinv->update_invoice_html($data,$performa_invoice_id);
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
	function index_withoutfinish($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$datap			= 	$this->pinv->product_data($id);
			$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
					'company_detail'=>$company,
					'mode' => "0" 
					 
				);
			$this->load->view('admin/performa_invoice_without_finish_pdf',$v);
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
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
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
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
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
			
			$v = array(
					'invoicedata'=>$data,
					'product_data'=>$datap,
					'menu_data'=>$menu_data,
					'bank'=>$bank,
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
	function view_pdf()
	{
		$this->load->view('admin/pdfreport1');
	}
}
