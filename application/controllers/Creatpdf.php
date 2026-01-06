<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Creatpdf extends CI_controller{
	public function __construct(){
		parent:: __construct();
	 
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
			$company=$this->pinv->company_select();
			$bankid=$company[0]->bank_name;
			$bank= $this->pinv->bselect($bankid);
			$data= $this->pinv->select_invoice_data($id);
			$datap= $this->pinv->product_data($id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array('invoicedata'=>$data,'product_data'=>$datap,'bank'=>$bank,'company_detail'=>$company,'mode' => "1","fields_detail"=>$this->pinv->fields_data($id),"packing_data"=>$this->pinv->packing_data($id),'menu_data' => $menu_data);
			$this->load->view('admin/pdf_performa_invoice',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	function view_pdf(){
		$this->load->view('admin/pdfreport1');
	}
}