<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Supplier_epcg_list extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Supplier_list_model','supplier');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{ 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['epcg_data']		= $this->supplier->getsupplier_record($id); 
			$data['supplier_id'] 	= $id;	
			$data['epcgdata']		= $this->supplier->get_epcg_data($id);
			$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/supplier_epcg_list',$data);	
		}
 		else
		{
			redirect(base_url().'');
		}		
	}
	public function manage()
	{
		$supplier_id = $this->input->post('supplier_id');
		$epcg_no = $this->input->post('epcg_no');
		$epcg_date = date('Y-m-d',strtotime($this->input->post('epcg_date')));
		$epcg_amount = $this->input->post('epcg_amount');
		$check_data = $this->supplier->check_epcg_data($supplier_id,$epcg_no);
		if(!empty($check_data))
		{
			$row['id'] = $check_data->supplie_epcg_id;
			$row['epcg_no'] = $epcg_no;
			$row['res'] = 2;
		}
		else{
		$data = array(
			 'epcg_no' => $this->input->post('epcg_no'),
			 'epcg_date' => $epcg_date,
			 'epcg_amount' => $this->input->post('epcg_amount'),
			 'supplier_id' => $this->input->post('supplier_id'),
			 'status' =>0 
		 );
		$insertid = $this->supplier->insert_epcg_data($data);
			if($insertid)
			{
				 $row['id'] = $insertid;
				 $row['epcg_no'] = $this->input->post('epcg_no'); 
				 $row['epcg_date'] = date('d.m.Y',strtotime($epcg_date));
				 $row['epcg_amount'] = $this->input->post('epcg_amount');
				 $row['res'] = 1;
				
			}
			else
			{
				 $row['id'] =0;
				 $row['epcg_no'] =0;
				 $row['res'] = 0;
			}
		}
			 echo json_encode($row);
		
	}
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->supplier->deleteepcgrecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->supplier->fetchepcgdata($id);
		 $resultdata->edit_epcg_date = date("d-m-Y",strtotime($resultdata->epcg_date));
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$data = array(
			 'epcg_no' => $this->input->post('edit_epcg_detail'),
			  'epcg_date' => date("Y-m-d",strtotime($this->input->post('edit_epcg_date'))),
			   'epcg_amount' => $this->input->post('edit_epcg_amount'),
			 'supplier_id' => $this->input->post('edit_supplier_id'),
			 'status' =>0 
		 );
			$id = $this->input->post('eid');
			$updatedid = $this->supplier->update_epcgdata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['epcg_no'] = $this->input->post('edit_epcg_detail');
				 $row['res'] = 1;
				
			}
			else
			{
				 $row['id']		 =	0;
				 $row['epcg_no'] =	0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}
	
}
?>