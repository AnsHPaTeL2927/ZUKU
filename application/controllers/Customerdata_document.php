<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Customerdata_document extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	 
	
	/*load Model*/
	$this->load->model('Customerdata_document_model','mode');
	$this->load->model('menu_model','menu');
	
	
	}
	
	public function index($id)
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 
			 $this->load->model('admin_company_detail');	
			 $this->load->model('admin_customer_detail');
			 $data['detail'] = $this->mode->get_document_detail($id);
			
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['cust_data']		= $this->admin_customer_detail->s_edit_select($id); 
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/customerdata_document',$data);
			 $rdbutton = $detail->file_type;
			
			
		}
		else
		{
			redirect(base_url().'');
		}	
    }
	
	
	
	
	public function manage()
	{
		 $data=array(
						'customer_id' 	 		=> $this->input->post('customer_data'),
						'document_type' 		=> $this->input->post('radiofiles'),
						'document_address' 		=> $this->input->post('postal_address'),
						'notes'					=> $this->input->post('notes'),
						'field_1'				=> $this->input->post('field1'),
						'field_2'				=> $this->input->post('field2'),
						'field_3'				=> $this->input->post('field3'),
						'field_4'				=> $this->input->post('field4'),
						'field_5'				=> $this->input->post('field5'),
						
						'status'   	   	=> 0
	 	);
		
		$customer_add_detail_id = $this->input->post('customer_add_detail_id');
		if($customer_add_detail_id > 0)
		{
			
			if($_FILES['file_upload']['name'] != "" )	
			{
				unlink("./upload/customer_document/".$this->input->post('file_upload_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload',$_FILES['file_upload']['name']));
				$this->upload->do_upload('file_upload');
				$upload_image = $this->upload->data();
				$data['file_upload']  = $upload_image['file_name'];
				
			} 
			if($_FILES['file_upload1']['name'] != "" )	
			{
				unlink("./upload/customer_document/".$this->input->post('file_upload1_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload1',$_FILES['file_upload1']['name']));
				$this->upload->do_upload('file_upload1');
				$upload_image = $this->upload->data();
				$data['file_upload1']  = $upload_image['file_name'];
				
			} 
			
			$insert_id = $this->mode->update_additional_detail($data,$customer_add_detail_id);
				if($insert_id)
				 {
				 	$row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
		else
		{
			
			if($_FILES['file_upload']['name'] != "" )	
			{
				
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload',$_FILES['file_upload']['name']));
				$this->upload->do_upload('file_upload');
				$upload_image = $this->upload->data();
				$data['file_upload']  = $upload_image['file_name'];
				
			} 
			if($_FILES['file_upload1']['name'] != "" )	
			{
				
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload1',$_FILES['file_upload1']['name']));
				$this->upload->do_upload('file_upload1');
				$upload_image = $this->upload->data();
				$data['file_upload1']  = $upload_image['file_name'];
				
			} 
						
			$insert_id = $this->mode->insert_additional_detail($data);
				if($insert_id)
				 {
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
		}
          
		echo json_encode($row);
	}
	
	
	private function set_upload_options($newfilename,$filename)
	{   
		$this->load->library('image_lib');
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/customer_document/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
	
		return $config;
	}
	
	
}
?>