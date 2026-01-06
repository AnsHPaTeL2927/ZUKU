<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Currency_list extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
	 	$this->load->model('admin_currency_list','currency');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index()
	{ 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['currencydata'] = $this->currency->getcurrencydata();	
			$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/currency_list',$data);		
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	public function manage()
	{
		$data = array(
			 'currency_name' 	=> $this->input->post('currency'),
			 'currency_code' 	=> $this->input->post('currency_code'),
			 'currency_status' 	=> $this->input->post('currency_status'),
			 'status' =>0 
		 );
		$insertid = $this->currency->insertdata($data);
			if($insertid)
			{
				if($this->input->post('currency_status') == 1)
				{
					$update_table = $this->currency->remove_defualt_currency($insertid);
				}
				 $row['id'] = $insertid;
				 $row['currency'] = $this->input->post('currency');
				 $row['res'] = 1;
				
			}
			else
			{
				 $row['id'] =0;
				 $row['currency'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->currency->deleterecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function defualt_currency()
	{
		$id		=	$this->input->post('id');
		$status	=	$this->input->post('status');
		$data = array(
			"currency_status" => $status
		);
		$update_table = $this->currency->remove_defualt_currency($id);
		$deleteid=$this->currency->updatedata($data,$id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchmodeldata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->currency->fetchmodeldata($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$data = array(
			 'currency_name' => $this->input->post('edit_currency'),
			 'currency_code' => $this->input->post('edit_currency_code'),
			 'currency_status' => $this->input->post('edit_currency_status'),
			 'status' =>0 
		 );
			$id = $this->input->post('eid');
			$updatedid = $this->currency->updatedata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['currency'] = $this->input->post('edit_currency');
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['currency'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}
}
?>