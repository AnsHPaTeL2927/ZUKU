<?php 
defined("BASEPATH") or exit('no direct script allowed');
class Dashboard_payment extends CI_controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Order_report_model','order');	
		$this->load->model('menu_model','menu');
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session'));
	}
	
	public function index()
	{
	 	 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
		 	 
		 	$this->load->model('admin_company_detail');	
			$this->load->model('admin_bank_detail','bd');
			$checkdata['company_detail'] 				= $this->admin_company_detail->s_select();	
			$checkdata['menu_data']						= $this->menu->usermain_menu($this->session->usertype_id);	
			$checkdata['all_bank']	  					= $this->bd->b_select(); 
			$checkdata['drawback_pending'] 				= $this->order->drawback_pending();	
			$checkdata['outstanding_report'] 			= $this->order->outstanding_report();
			 
			$checkdata['factory_outstanding_report'] 	= $this->order->factory_outstanding_report();	
			$checkdata['expense_outstanding_report'] 	= $this->order->expense_outstanding_report();	
			 
		  	$this->load->view('admin/dashboard_payment',$checkdata);
		 }
		 else
		 {
			redirect(base_url().'');
		 }
	}
	public function set_session()
	{
		$_SESSION['add_payment_consiger_id'] = $this->input->post('consiger_id');
		$_SESSION['add_export_invoice_id'] 	 = $this->input->post('export_invoice_id');
		echo "1";
	} 
	public function add_factory_payment()
	{
	 	$_SESSION['add_expense_party_id'] 	 = $this->input->post('expense_party_id');
		echo "1";
	}
}

?>