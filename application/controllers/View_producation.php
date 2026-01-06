<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class View_producation extends CI_controller
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
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	function index_pro($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->palletordertrn1($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/create_production_view',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	
	function index_extrapallet($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation_extrapallet',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}	
	
	
		function index_extrapallet2($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation_extrapallet2',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	
		function index_extrapallet3($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation_extrapallet3',$v);
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
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_qc_data',$v);
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
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$html_data			= $this->pinv->get_invoice_html($id,'producation_view'); 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'invoice_html_data'		=> $html_data,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation_rajan',$v);
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
			$company	=	$this->pinv->company_select();
			$bankid		=	$company[0]->bank_name;
			$bank		= 	$this->pinv->bselect($bankid);
			$datap		= 	$this->pinv->producation_trn_data($id);
		  	$data		= 	$this->pinv->producation_mst_data($id);
			$menu_data 	= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation1',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function view_pdf(){
		$this->load->view('admin/producationpdf');
	}
	function producation_html_update()
	{
		$production_mst_id	= $this->input->post('production_mst_id');
		$invoice_table_name		= $this->input->post('invoice_table_name');
		$invoice_html			= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$production_mst_id,
			"invoice_html" 			=> 	$invoice_html,
			"invoice_table_name" 	=> 	$invoice_table_name,
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->pinv->check_invoice_html($invoice_table_name,$production_mst_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->pinv->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->pinv->update_invoice_html($data,$production_mst_id,$invoice_table_name);
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
}
