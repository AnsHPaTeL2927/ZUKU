<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Forwarer_contact_list extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('forwarer_master_model','supplier');
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
			$data['supplier_id'] = $id;	
			$data['epcgdata']	 = $this->supplier->get_epcg_data($id);
			$data['menu_data']   = $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/forwarer_contact_list',$data);	
		}
 		else
		{
			redirect(base_url().'');
		}		
	}
	public function manage()
	{
		$supplier_id = $this->input->post('supplier_id');
		$Contact_Name = $this->input->post('Contact_Name');
		$Department = $this->input->post('Department');
		$Contact_Number = $this->input->post('Contact_Number');
		
		$check_data = $this->supplier->check_epcg_data($supplier_id,$Contact_Name);
		if(!empty($check_data))
		{
			$row['id'] = $check_data->contact_id;
			$row['epcg_no'] = $Contact_Name;
			$row['res'] = 2;
		}
		else{
		$data = array(
			 'Contact_Name' => $this->input->post('Contact_Name'),
			 'Department' => $this->input->post('Department'),
			 'Contact_Number' => $this->input->post('Contact_Number'),
			 'cha_id' => $this->input->post('supplier_id'),
			 'status' =>0 
		 );
		$insertid = $this->supplier->insert_epcg_data($data);
			if($insertid)
			{
				 $row['id'] = $insertid;
				 $row['Contact_Name'] = $this->input->post('Contact_Name');
				 $row['Department'] = $this->input->post('Department');
				 $row['Contact_Number'] = $this->input->post('Contact_Number');
				 
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
	//	 $resultdata->edit_epcg_date = date("d-m-Y",strtotime($resultdata->epcg_date));
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$data = array(
			 'Contact_Name' => $this->input->post('Contact_Name'),
			 'Department' => $this->input->post('Department'),
			 'Contact_Number' => $this->input->post('Contact_Number'),
			 'cha_id' => $this->input->post('edit_supplier_id'),
			 'status' =>0 
		 );
			$id = $this->input->post('eid');
			$updatedid = $this->supplier->update_epcgdata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['epcg_no'] = $this->input->post('Contact_Name');
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