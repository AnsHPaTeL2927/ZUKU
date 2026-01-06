<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Terms_list extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_terms_list','terms');
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
			$data['termsdata'] 		= $this->terms->termsdata();	
			$data['menu_data']  	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/terms_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}			
	}
	public function manage()
	{
		$terms_name = $this->input->post('terms_name');
		 
		$check_data = $this->terms->checkdata($terms_name);
		if(!empty($check_data))
		{
			$row['id'] = $check_data->series_id;
			$row['terms_name'] = $terms_name;
			$row['res'] = 2;
		}
		else
		{
		$data = array(
			 'terms_name' => $this->input->post('terms_name'),
		 	 'status' =>0 
		 );
		$insertid = $this->terms->insertdata($data);
			if($insertid)
			{
				 $row['id'] = $insertid;
				 $row['terms_name'] = $this->input->post('terms_name');
				 $row['res'] = 1;
				
			}
			else
			{
				 $row['id'] 		= 0;
				 $row['terms_name'] = 0;
				 $row['res'] 		= 0;
			}
		}
			 echo json_encode($row);
		
	}
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->terms->deleterecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function changestatus()
	{
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$deleteid=$this->terms->chnagerecord($id,$status);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchtermsdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->terms->fetchmodeldata($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$check_data = $this->terms->checkdata($this->input->post('edit_terms_name'));
		if(!empty($check_data))
		{
			$row['terms_name'] = $this->input->post('edit_termsname');
				 $row['res'] = 2;
		}
		else
		{
				 
			$data = array(
				'terms_name' => $this->input->post('edit_terms_name'),
				'status' =>0 
			);
			$id = $this->input->post('eid');
			$updatedid = $this->terms->updatedata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['terms_name'] = $this->input->post('edit_terms_name');
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['terms_name'] =0;
				 $row['res'] = 0;
			}
		}
			 echo json_encode($row);
		
	}
}
?>