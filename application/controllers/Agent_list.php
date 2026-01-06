<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Agent_list extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		 
		$this->load->model('Agentmaster_model','mode');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}


	public function index()
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$data['result']=$this->mode->showagent_records();
			//$data['no']	= $this->mode->getno();
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$this->load->view('admin/agent_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
		
		public function deleterecord()
		{
			$id = $this->input->post('id');
			$deletedata = $this->mode->getagent_record($id);
			unlink('upload/agreement_doc/'.$resultdata->agreement_logo);
			unlink('upload/agreement_doc/'.$resultdata->agreement_logo1);
			unlink('upload/agreement_doc/'.$resultdata->agreement_logo2);
			
			$deleteid=$this->mode->delete_agent($id);
			$row=array();
			if($deleteid)
			{
				$row['res'] = 1;
				
			}
			else
			{
				$row['res'] = 0;
			}
			echo json_encode($row);
		}
		
public function download($agreement_logo = NULL) 
{
	// load download helder
	$this->load->helper('download');
	// read file contents
	$data = file_get_contents(base_url('./upload/agreement_doc/'.$agreement_logo));
	force_download($agreement_logo, $data);
}

public function download1($agreement_logo1 = NULL) 
{
	// load download helder
	$this->load->helper('download');
	// read file contents
	$data = file_get_contents(base_url('./upload/agreement_doc/'.$agreement_logo1));
	force_download($agreement_logo1, $data);
}

public function download2($agreement_logo2 = NULL) 
{
	// load download helder
	$this->load->helper('download');
	// read file contents
	$data = file_get_contents(base_url('./upload/agreement_doc/'.$agreement_logo2));
	force_download($agreement_logo2, $data);
}

public function archive_record()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$deleterecord = $this->mode->archive_record($id,$status);
		
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
}

public function changestatus()
	{
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$deleteid=$this->mode->chnagerecord($id,$status);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
		
		
	
	
}

?>