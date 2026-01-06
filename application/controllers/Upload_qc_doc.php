<?php 
defined("BASEPATH") or exit('no direct script allowed');
class Upload_qc_doc extends CI_controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_exportinvoice_list','invoice');
		$this->load->model('menu_model','menu');
		$this->load->model('admin_exportinvoice');
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session'));
		
	}
	
	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail']  	= $this->admin_company_detail->s_select();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['invoicedata']		= $this->admin_exportinvoice->exportinvoice_data($id);	
		  	$this->load->view('admin/upload_qc',$data);
		 }
		 else
		 {
			redirect(base_url().'');
		 }
	}
	public function view($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail']  	= $this->admin_company_detail->s_select();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['invoicedata']		= $this->admin_exportinvoice->exportinvoice_data($id);	
			$data['qcdata']				= $this->admin_exportinvoice->qcrecord($id);	
		  	$this->load->view('admin/view_upload_qc',$data);
		 }
		 else
		 {
			redirect(base_url().'');
		 }
	}
	public function edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail']  	= $this->admin_company_detail->s_select();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['invoicedata']		= $this->admin_exportinvoice->exportinvoice_data($id);	
			$data['qcdata']				= $this->admin_exportinvoice->qcrecord($id);	
		  	$this->load->view('admin/edit_upload_qc',$data);
		 }
		 else
		 {
			redirect(base_url().'');
		 }
	}
	public function updaterecord()
	{
		$id= $this->input->post('eid');
			 
			if($_FILES['edit_photo_name']['name'] != "" )	
			{
				$id = $this->input->post('eid');
				$data = $this->invoice->qc_photo_record($id);
				unlink("./upload/qc_image/".$data->photo_name);
				
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('photo_name',$_FILES['edit_photo_name']['name']));
				$this->upload->do_upload('edit_photo_name');
				$upload_image = $this->upload->data();
				$data_photos['photo_name']  = $upload_image['file_name'];
				  
					$update_trn_id = $this->invoice->update_qc_photos($data_photos,$id);
			} 
		$row=array();
				if($update_trn_id)
				{
				 	$row['res'] = "2";
				}
				else
				{
					$row['res'] = "0";
				}
			echo json_encode($row);				
	}
	public function manage()
	{
		 $data = array(
			'performa_invoice_id' 		=> $this->input->post('performa_invoice_id'),
			'export_invoice_id' 		=> $this->input->post('export_invoice_id'),
		 	'qc_text' 					=> nl2br($this->input->post('qc_content')),
		 	'cdate'		 				=> date('Y-m-d H:i:s'),
	 	);
		if(!empty($this->input->post('qc_table_id')))
		{
			 $update_id = $this->invoice->update_qc($data,$this->input->post('qc_table_id'));
			  $row['res'] = 2;
				
		}
		else
		{
		 $insert_id = $this->invoice->insert_qc($data);
		  $row['res'] = 0;
				
			if(!empty($_FILES['qc_image']['name'][0]))	
			{		
				$files = $_FILES;
				$no	= 0;
				$cpt 	= count($_FILES['qc_image']['name']);
				 
					for($i=0; $i<$cpt; $i++)
					{   
						$this->load->library('upload');
						$_FILES['filename']['name']		= $files['qc_image']['name'][$i];
						$_FILES['filename']['type']		= $files['qc_image']['type'][$i];
						$_FILES['filename']['tmp_name']	= $files['qc_image']['tmp_name'][$i];
						$_FILES['filename']['error']	= $files['qc_image']['error'][$i];
						$_FILES['filename']['size'] 	= $files['qc_image']['size'][$i];    
						 
						$this->upload->initialize($this->set_upload_options('qc_image',$_FILES['filename']['name']));
						$this->upload->do_upload('filename');
						$dataInfo = $this->upload->data();
						
						$design_name  =$dataInfo['file_name'];
						 $data_photos = array(
							'qc_table_id' 		=> $insert_id,
							'photo_name' 		=> $design_name,
						 	'cdate'		 		=> date('Y-m-d H:i:s'),
						);
						
						$insert_trn_id = $this->invoice->insert_qc_photos($data_photos);
		  
					}
				  
				
			} 
				if($insert_id)
				{
				 	$row['res'] = "1";
				}
				else
				{
					$row['res'] = "0";
				}
		}
			echo json_encode($row);
	}
	private function set_upload_options($newfilename,$filename)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] = './upload/qc_image/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = '5000';
		$config['overwrite']     = FALSE;

		return $config;
	}
	public function delete_photo()
	{
		 
		$id = $this->input->post('id');
		$data = $this->invoice->qc_photo_record($id);
		unlink("./upload/qc_image/".$data->photo_name);
			
		$deleterecord = $this->invoice->qc_photo_delete($id);	
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function fetchdata()
	{
		$id = $this->input->post('id');
		$data = $this->invoice->qc_photo_record($id);
		echo json_encode($data);
	}
}	
	 


?>