<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Excel_error extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		
		$this->load->model('admin_product_invoice','pinv');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
				redirect(base_url());
        }
	}	
	
	public function index($id)
	{ 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 { 
			 $data['tempdata'] 				= $this->pinv->get_tempdata($id);
			 $data['performa_invoice_id'] 	= $id;
			  $data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/excel_error',$data);
		}
		else
		{
			redirect(base_url().'');
		}			
	}
}
?>