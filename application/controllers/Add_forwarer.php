<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_forwarer extends CI_controller{
	public function __construct(){
		parent:: __construct();
		 
		$this->load->model('forwarer_master_model','supplier');
			$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($m="")
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['mode']="Add";
			$this->load->model('admin_currency_list');	
			$data['currencydata'] = $this->admin_currency_list->getcurrencydata();
			$data['epcgdata']	= 1;
			$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
			 			
			$this->load->view('admin/add_forwarer',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	public function manage()
	{
		
		 $data=array(
			
			'c_name' 			=> $this->input->post('c_name'),
			'address' 			=> nl2br($this->input->post('address')),
			'city' 				=> $this->input->post('city'),
			'field1' 			=> $this->input->post('field1'),
			'field2' 			=> $this->input->post('field2'),
			'field3' 			=> $this->input->post('field3'),
			'field4' 			=> $this->input->post('field4'),
			
			
			'cdate'						=> date('Y-m-d H:i:s')
			);
			
			
			if(strtolower($this->input->post('mode'))=="add")
			{
				
				$rdata = $this->supplier->supplierinsert($data);
				
				if($rdata)
				{
					$row['res'] = 1;
					$row['id'] = $rdata;
					$row['c_name'] = $this->input->post('c_name');
				}
				else{
					$row['res'] = 0;
				}
			}
			else{
				$id= $this->input->post('cha_id');
				
				$rdata = $this->supplier->supplierupdate($id,$data);
				if($rdata)
				{
					$row['res'] = 2;
					$row['id'] = $id;
				}
				else{
					$row['res'] = 0;
				}
			}
		   echo json_encode($row);
		
	}	

	public function form_edit($id){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['edit_record']=$this->supplier->getsupplier_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['mode']="Edit";
			$this->load->model('admin_currency_list');	
			$data['currencydata'] 		= $this->admin_currency_list->getcurrencydata();
			$data['epcgdata']			= $this->supplier->get_epcg_data($id);
			$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
			
		 	$this->load->view('admin/add_forwarer',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}		

	}
	 

	 
}
?>