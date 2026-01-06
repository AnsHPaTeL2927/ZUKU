<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_customer_detail extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		 
		$this->load->model('Admin_customer_detail','customer');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE)
		{
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{
		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_bank_detail','bd');
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 		= $this->admin_company_detail->s_select();	
			$data['cust_data']				= $this->customer->s_edit_select($id); 
			$data['pallet_type_data']		= $this->customer->get_pallet_type(); 
			$data['all_size']				= $this->customer->get_all_size($id); 
			$data['box_design_data']		= $this->customer->get_box_design();
			$data['detail']					= $this->customer->get_additional_detail($id);
			$data['getfumigation']			= $this->customer->get_fumigation();
			$data['getpallet_cap']			= $this->customer->get_pallet_cap();
			$data['menu_data'] 				= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['all_bank']				 	= $this->bd->b_select();
			$this->load->view('admin/add_customer_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}				
	}
	 
	 
	public function manage()
	{
		 $data=array(
			'customer_id' 	 		=> $this->input->post('customer_id'),
		 	'container_weight' 		=> $this->input->post('container_weight'),
		 	'fumigation_id' 		=> $this->input->post('fumigation_id'),
		 	'pallet_cap_id' 		=> $this->input->post('pallet_cap_id'),
		 	'factory_logo_status' 	=> $this->input->post('factory_logo_status'),
		 	'air_bag_status' 		=> $this->input->post('air_bag_status'),
		 	'mosqure_bag_status' 	=> $this->input->post('mosqure_bag_status'),
		 	'corner_protector' 		=> $this->input->post('corner_protector'),
		 	'separation_tiles' 		=> $this->input->post('separation_tiles'),
		 	'safety_belt' 		=> $this->input->post('safety_belt'),
		 	'quonitiy_status' 		=> $this->input->post('quonitiy_status'),
		 	'note'  				=> nl2br($this->input->post('note')),
		 	'made_in_india_status' 	=> $this->input->post('made_in_india_status'),
		 	'bank_id' 				=> $this->input->post('bank_id'),
		 	'igst_per' 				=> $this->input->post('igst_per'),
		 	'cgst_per' 				=> $this->input->post('cgst_per'),
		 	'sgst_per' 				=> $this->input->post('sgst_per'),
		 	'field1' 				=> $this->input->post('field1'),
		 	'field2' 				=> $this->input->post('field2'),
		 	'field3' 				=> $this->input->post('field3'),
		 	'field4' 				=> $this->input->post('field4'),
		 	'field5' 				=> $this->input->post('field5'),
			'cdate'		 			=> date('d-m-Y H:i:s'),
	 	);
		$customer_add_detail_id = $this->input->post('customer_add_detail_id');
		if($customer_add_detail_id > 0)
		{
			$files = $_FILES;
				$no	= 0;
				$cpt 	= count($_FILES['barcode_sticker_file']['name']);
				 
			if(!empty($_FILES['barcode_sticker_file']['name'][0]))	
			{		
					$images_name = array();
					$imagesname = explode(",",$this->input->post('barcode_sticker_filename'));
					foreach($imagesname as $img)
					{
						unlink("./upload/".$img);
					}
					
					for($i=0; $i<$cpt; $i++)
					{   
						$this->load->library('upload');
						$_FILES['filename']['name']		= $files['barcode_sticker_file']['name'][$i];
						$_FILES['filename']['type']		= $files['barcode_sticker_file']['type'][$i];
						$_FILES['filename']['tmp_name']	= $files['barcode_sticker_file']['tmp_name'][$i];
						$_FILES['filename']['error']	= $files['barcode_sticker_file']['error'][$i];
						$_FILES['filename']['size'] 	= $files['barcode_sticker_file']['size'][$i];    
						
						$this->upload->initialize($this->set_upload_options('barcodesticker',$_FILES['filename']['name']));
						$this->upload->do_upload('filename');
						$dataInfo = $this->upload->data();
						$design_name  =$dataInfo['file_name'];
						 
					 	 array_push($images_name,$design_name);
					}
				 
						$data['barcode_sticker_file']  	= implode(",",$images_name);
				
			} 
			 
			if($_FILES['box_sticker_file']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('box_sticker_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
				$this->upload->do_upload('box_sticker_file');
				$upload_image = $this->upload->data();
				$data['box_sticker_file']  = $upload_image['file_name'];
				
			} 
			
			if($_FILES['special_sticker_file']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('special_sticker_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('special_sticker',$_FILES['special_sticker_file']['name']));
				$this->upload->do_upload('special_sticker_file');
				$upload_image = $this->upload->data();
				$data['special_sticker_file']  = $upload_image['file_name'];
				
			} 
			if($_FILES['file_upload1']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('file_upload1_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload1',$_FILES['file_upload1']['name']));
				$this->upload->do_upload('file_upload1');
				$upload_image = $this->upload->data();
				$data['file_upload1']  = $upload_image['file_name'];
				
			} 
			if($_FILES['file_upload2']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('file_upload2_filename'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload2',$_FILES['file_upload2']['name']));
				$this->upload->do_upload('file_upload2');
				$upload_image = $this->upload->data();
				$data['file_upload2']  = $upload_image['file_name'];
				
			} 
			$insert_id = $this->customer->update_additional_detail($data,$customer_add_detail_id);
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
			$files = $_FILES;
				$no	= 0;
				$cpt 	= count($_FILES['barcode_sticker_file']['name']);
				 
			if(!empty($_FILES['barcode_sticker_file']['name'][0]))	
			{		
					$images_name = array();
					 
					
					for($i=0; $i<$cpt; $i++)
					{   
						$this->load->library('upload');
						$_FILES['filename']['name']		= $files['barcode_sticker_file']['name'][$i];
						$_FILES['filename']['type']		= $files['barcode_sticker_file']['type'][$i];
						$_FILES['filename']['tmp_name']	= $files['barcode_sticker_file']['tmp_name'][$i];
						$_FILES['filename']['error']	= $files['barcode_sticker_file']['error'][$i];
						$_FILES['filename']['size'] 	= $files['barcode_sticker_file']['size'][$i];    
						
						$this->upload->initialize($this->set_upload_options('barcodesticker',$_FILES['filename']['name']));
						$this->upload->do_upload('filename');
						$dataInfo = $this->upload->data();
						$design_name  =$dataInfo['file_name'];
						 
					 	 array_push($images_name,$design_name);
					}
				 
						$data['barcode_sticker_file']  	= implode(",",$images_name);
				
			}
			if($_FILES['box_sticker_file']['name'] != "" )	
			{
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
				$this->upload->do_upload('box_sticker_file');
				$upload_image = $this->upload->data();
				$data['box_sticker_file']  = $upload_image['file_name'];
				
			}
			if($_FILES['special_sticker_file']['name'] != "" )	
			{
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('special_sticker',$_FILES['special_sticker_file']['name']));
				$this->upload->do_upload('special_sticker_file');
				$upload_image = $this->upload->data();
				$data['special_sticker_file']  = $upload_image['file_name'];
				
			}
			if($_FILES['file_upload1']['name'] != "" )	
			{
		 		$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload1',$_FILES['file_upload1']['name']));
				$this->upload->do_upload('file_upload1');
				$upload_image = $this->upload->data();
				$data['file_upload1']  = $upload_image['file_name'];
				
			} 
			if($_FILES['file_upload2']['name'] != "" )	
			{
			 
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('file_upload2',$_FILES['file_upload2']['name']));
				$this->upload->do_upload('file_upload2');
				$upload_image = $this->upload->data();
				$data['file_upload2']  = $upload_image['file_name'];
				
			} 
						
			$insert_id = $this->customer->insert_additional_detail($data);
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
	public function manage_box_design()
	{
		 $data=array(
			'customer_id' 	 	=> $this->input->post('customer_id'),
			'box_design_id'  	=> $this->input->post('box_design_id'),
			'product_id' 		=> $this->input->post('product_id'), 
			'status'		  	=> 0
	 	);
		 
		 $customer_box_design_id = $this->input->post('customer_box_design_id');
		if($customer_box_design_id > 0)
		{
			$insert_id = $this->customer->update_customer_box_design($data,$customer_box_design_id);
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
			$insert_id = $this->customer->insert_customer_box_design($data);
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
	public function manage_pallet_design()
	{
		 $data=array(
			'customer_id' 	 	=> $this->input->post('customer_id'),
			'pallet_type_id'  	=> $this->input->post('pallet_type_id'),
			'product_id' 		=> $this->input->post('product_id'), 
			'status'		  	=> 0
	 	);
		$customer_box_design_id = $this->input->post('customer_box_design_id');
		if($customer_box_design_id > 0)
		{
			$insert_id = $this->customer->update_customer_box_design($data,$customer_box_design_id);
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
			$insert_id = $this->customer->insert_customer_box_design($data);
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
	public function manage_pallet_packing()
	{
		 $data=array(
			'customer_id' 	 	=> $this->input->post('customer_id'),
			'product_size_id'  	=> $this->input->post('product_size_id'),
			'product_id' 		=> $this->input->post('product_id'), 
			'status'		  	=> 0
	 	);
		$customer_box_design_id = $this->input->post('customer_box_design_id');
		if($customer_box_design_id > 0)
		{
			$insert_id = $this->customer->update_customer_box_design($data,$customer_box_design_id);
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
			$insert_id = $this->customer->insert_customer_box_design($data);
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
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = '5000';
		$config['overwrite']     = FALSE;

		return $config;
	}
}
?>