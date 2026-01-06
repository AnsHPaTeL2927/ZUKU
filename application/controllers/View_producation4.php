<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class View_producation4 extends CI_controller
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
			 
			$v = array(
					'producation_mst'	=> $data,
					'menu_data'			=> $menu_data,
					'product_data'		=> $datap,
					'bank'				=> $bank,
					'company_detail'	=> $company,
					'mode' 				=> "0" 
					 
				);
			$this->load->view('admin/view_producation4',$v);
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
			$this->load->view('admin/view_producation4',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	// function view_pdf(){
		// $this->load->view('admin/producationpdf');
	// }
}
