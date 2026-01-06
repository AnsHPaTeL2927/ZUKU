<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Pallent_order extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_pdf','po');
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
			$data		= $this->po->pallet_order($id);
			$menu_data  = $this->menu->usermain_menu($this->session->usertype_id);	
			
			
		 	$v = array(
					'invoicedata'	=> $data,
				 	'company_detail'=> $company,
				 	'menu_data'		=> $menu_data,
				 	'packing_data'	=> $this->po->palletordertrn($data->pallet_order_id),
					
					"mode"=>0
				);
			$this->load->view('admin/pallent_order_view',$v);
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
				$this->load->model('admin_exportinvoice_product','export');	
			$company	= $this->po->company_select();
			$bank		= $this->po->bselect($bankid);
			$data		= $this->po->pallet_ordernew($id);
			$menu_data  = $this->menu->usermain_menu($this->session->usertype_id);	
			
			
		 	$v = array(
					'invoicedata'	=> $data,
				 	'company_detail'=> $company,
				 	'menu_data'		=> $menu_data,
					'allproduct'	 	=>	$this->export->allproductsize(),
				 	'packing_data'	=> $this->po->palletordertrn1($data->production_mst_id),
					
					"mode"=>0
				);
			$this->load->view('admin/create_production_view',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	function view_pdf($id)
	{
			$company=$this->po->company_select();
			$bank= $this->po->bselect($bankid);
			$data= $this->po->pallet_order($id);
		 	$v = array(
					'invoicedata'=>$data,
				 	'company_detail'=>$company,
				 	'packing_data'=>$this->po->palletordertrn($data->pallet_order_id),
					"mode"=>1
				);
			$this->load->view('admin/pallent_order_view',$v);
	}
	function viewpdf(){
		
		$this->load->view('admin/pallent_order_pdf');
	}
	
}
