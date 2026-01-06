<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Product_code extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_code','pc');
		$this->load->model('Admin_product_invoice','pinv');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index(){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['result']=$this->pc->pc_select();
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/product_code_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function form(){
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data = array('fd' => 'manage');
			$v['fd']= 'manage';
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/product_code_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function manage(){

		$data=array(
			'hsnc_code' => $this->input->post('hsnc_code'),
			'p_name' => $this->input->post('p_name'),
			'status' => $this->input->post('status'),
			'orderby' => $this->input->post('orderby')
			);

		$psresult = $this->pc->pc_insert($data);
		if($psresult)
		 {
			redirect(base_url('product_code/index'));
		 }
 	}

	public function form_edit($id){
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data= $this->pc->pc_select_edit($id);
			$v = array('fd'=>'edit','fdv'=>$data);
				$v['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/product_code_detail',$v);   
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function edit($eid){

		$img = str_replace(array('-', '_', '~'),array('+', '/', '='), $eid);
		
		$id = $this->encrypt->decode($img);	 
		$data=array(
			'hsnc_code' => $this->input->post('hsnc_code'),
			'p_name' => $this->input->post('p_name'),
			'size_type' => $this->input->post('size_type'),
			'status' => $this->input->post('status'),
			'orderby' => $this->input->post('orderby')
			);

		$updatedata=$this->pc->pc_edit($data,$id);
		if($updatedata)
		{
			redirect(base_url('product_code/index'));
		}	

	}

	public function del($id){

		$this->pc->pc_del($id);	
		redirect('product_code/index');
	
	}



}

?>