<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Create_producation extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_pdf','pinv');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) 
		{
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company			=	$this->pinv->company_select();
			$bankid				=	$company[0]->bank_name;
			$bank				= 	$this->pinv->bselect($bankid);
			$data				= 	$this->pinv->select_invoice_data($id);
			$datap				= 	$this->pinv->product_data($id,$data->production_mst_id);
		 	$producation_data 	= 	$this->pinv->get_producation_data($id,0);
			$customer_detail	= 	$this->pinv->get_cust_additional_data($data->consigne_id);
		 	$getfumigation		= 	$this->pinv->get_fumigation();
			$getpallet_type		= 	$this->pinv->get_pallet_type($customer_detail->pallet_type_id);
			$getpallet_cap		= 	$this->pinv->get_pallet_cap();
			$getbox_design		= 	$this->pinv->get_box_design();
			$all_size			= 	$this->pinv->all_size($id,$data->consigne_id); 
		 	$menu_data			= 	$this->menu->usermain_menu($this->session->usertype_id);	
		 	$v = array(
					'invoicedata'	 	=> $data,
					'menu_data'	 		=> $menu_data,
					'product_data'	 	=> $datap,
					'all_size'	 		=> $all_size,
					'bank'			 	=> $bank,
					'company_detail' 	=> $company,
					'customerdetail' 	=> $customer_detail,
					'fumigation_data'	=> $getfumigation,
					'pallet_type_data'	=> $getpallet_type,
					'pallet_cap_data'	=> $getpallet_cap,
					'box_design_data'	=> $getbox_design,
					'all_supplier'		=> $this->pinv->select_supplier(),
				 	'mode' 			 	=> "0",
				 	'producationdata' 	=> $producation_data	
					 
				);
			$this->load->view('admin/create_producation' ,$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function edit($production_mst_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company			=	$this->pinv->company_select();
			//$data				= 	$this->pinv->select_invoice_data($id);
		  	$producation_data 	= 	$this->pinv->producation_mst_data($production_mst_id);  
		 	$producation_trn 	= 	$this->pinv->producation_trn_data($production_mst_id);  
			//$supplier			=	$this->pinv->select_supplier(); 
			$menu_data			= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$getfumigation		= 	$this->pinv->get_fumigation();
			$getpallet_type		= 	$this->pinv->get_pallet_type($customer_detail->pallet_type_id);
			$getpallet_cap		= 	$this->pinv->get_pallet_cap();
			$getbox_design		= 	$this->pinv->get_box_design();
			$all_size			=   $this->pinv->all_performa_size($production_mst_id,$producation_data->performa_invoice_id); 
			 
		 
		 	$v = array(
					'menu_data'	 		=> $menu_data,
					'producation_data'	=> $producation_data,
					'producation_trn'	=> $producation_trn,
					'company_detail' 	=> $company,
					'customerdetail' 	=> $customer_detail,
					'fumigation_data'	=> $getfumigation,
					'pallet_type_data'	=> $getpallet_type,
					'pallet_cap_data'	=> $getpallet_cap,
					'box_design_data'	=> $getbox_design,
					'all_size'			=> $all_size,
					'all_supplier'		=> $this->pinv->select_supplier(),
					'mode' 			 	=> "0" 
					 
				);
			$this->load->view('admin/edit_producation' ,$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function copy_containter()
	{
		$performa_trn_id 		 = $this->input->post('performa_trn_id');
		 
		$performa_invoice_id	 = $this->input->post('performa_invoice_id');
		 $data = array(
				"performa_invoice_id" => $performa_invoice_id,
				"no_of_countainer"	  => $this->input->post('container'),
				"con_fourty"		  => $this->input->post('container_fourty'),
				"con_twentry"		  => $this->input->post('container_twenty'),
				"producation_date"	  => date('Y-m-d',strtotime($this->input->post('producation_date'))),
				"producation_no"	  => $this->input->post('producation_no'),
				"supplier_id"	 	  => $this->input->post('supplier_id'),
				"note"				  => nl2br($this->input->post('note')),
				"status"			  => 0,
				"cdate"				  => date('Y-m-d H:i:s')
		 );
		 
		 if(empty($this->input->post('production_mst_id')))
		 {
				$insertid = $this->pinv->insert_producation_mst($data);
				 $data_additional = array(
						'performa_id' 			=> $this->input->post('performa_invoice_id'),
						'production_mst_id'  	=> $insertid,
						'readiness_date' 		=> date('Y-m-d',strtotime($this->input->post('readiness_date'))),
						'fumigation_id' 		=> $this->input->post('fumigation_id'),
						'mgf_company_name'  	=> $this->input->post('supplier_id'),
						'pallet_cap_id' 		=> $this->input->post('pallet_cap_id'),
						'air_bag_status' 		=> $this->input->post('air_bag_status'),
						'mosqure_bag_status' 		=> $this->input->post('mosqure_bag_status'),
					
						'quonitiy_status' 		=> $this->input->post('quonitiy_status'),
						'made_in_india_status' 	=> $this->input->post('made_in_india_status'),
						'corner_protector' 		=> $this->input->post('corner_protector'),
						'safety_belt' 		=> $this->input->post('safety_belt'),
						'separation_tiles' 		=> $this->input->post('separation_tiles'),
						'barcode_sticker' 		=> 'YES',
						'box_sticker'			=> 'YES',
						'box_sticker_remarks' 	=> $this->input->post('box_sticker_remarks'),
						'pallet_label' 			=> 'YES',
						'loading_by' 			=> $this->input->post('loading_by'),
						'pallet_by' 			=> $this->input->post('pallet_by'),
						'qc_by' 				=> $this->input->post('qc_by'),
						'extra_field_1' 		=> $this->input->post('extra_field_1'),
						'extra_field_value_1' 	=> $this->input->post('extra_field_value_1'),
						'extra_field_2' 		=> $this->input->post('extra_field_2'),
						'extra_field_value_2' 	=> $this->input->post('extra_field_value_2'),
						'extra_field_3' 		=> $this->input->post('extra_field_3'),
						'extra_field_value_3' 	=> $this->input->post('extra_field_value_3'),
						'extra_field_4' 		=> $this->input->post('extra_field_4'),
						'extra_field_value_4' 	=> $this->input->post('extra_field_value_4'),
						'extra_field_5' 		=> $this->input->post('extra_field_5'),
						'extra_field_value_5' 	=> $this->input->post('extra_field_value_5'),
						'cdate'		 			=> date('Y-m-d H:i:s'),
					);
					$files = $_FILES;
					$no	= 0;
					$cpt 	= count($_FILES['barcode_sticker_file']['name']);
					 
					if(!empty($_FILES['barcode_sticker_file']['name'][0]))	
					{		
							$images_name =array();
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
							$data_additional['barcode_sticker_file']  	= implode(",",$images_name);
						
					} 
					else
					{
						$data_additional['barcode_sticker_file']  = $this->input->post('barcode_sticker_file_name');
					}
					if($_FILES['box_sticker_file']['name'] != "" )	
					{
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
						$this->upload->do_upload('box_sticker_file');
						$upload_image = $this->upload->data();
						$data_additional['box_sticker_file']  = $upload_image['file_name'];
						
					} 
					else
					{
						$data_additional['box_sticker_file']  = $this->input->post('box_sticker_file_name');
					}
					
					if($_FILES['special_sticker_file']['name'] != "" )	
					{
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['special_sticker_file']['name']));
						$this->upload->do_upload('special_sticker_file');
						$upload_image = $this->upload->data();
						$data_additional['special_sticker_file']  = $upload_image['file_name'];
						
					} 
					else
					{
						$data_additional['special_sticker_file']  = $this->input->post('special_sticker_file_name');
					}
					 
					$resultdata = $this->pinv->insert_additional($data_additional);
					$no=0;
					$performa_packing_id = $this->input->post('copy_make_container');
					 
					foreach($performa_packing_id as $row)
					{
					 	 
							$data_performa = array(
								'production_mst_id'  	 => $insertid,
								'performa_packing_id' 	 => $row,
								'performa_trn_id' 		 => 0,
								'no_of_pallet'  		 => $this->input->post('no_of_pallet'.$row),
								'no_of_big_pallet' 		 => $this->input->post('no_of_big_pallet'.$row),
								'no_of_small_pallet'	 => $this->input->post('no_of_small_pallet'.$row),
								'no_of_boxes' 			 => $this->input->post('no_of_boxes'.$row),
								'no_of_sqm' 			 => $this->input->post('no_of_sqm'.$row),
								'box_design_id' 		 => $this->input->post('box_design_id'.$row),
								'pallet_type_id' 		 => $this->input->post('pallet_type_id'.$row),
								'thickness' 			 => $this->input->post('thickness'.$row),
									'd_container' 			 => $this->input->post('d_container'.$row),
								'extra_pallet' 			 => $this->input->post('extra_pallet'.$row),
								'location' 			 => $this->input->post('location'.$row),
								'status' 		    	 => 0
						 
						);
						$resultdata = $this->pinv->insert_producation_trn($data_performa);
					 
						$no++;	
					}
					$no=0;
					//foreach($this->input->post('size_type_mm') as $size_type_mm)
					//{
					//	$modelpricedata = array(
					//		"size_type_mm"		  => $size_type_mm,
					//		"performa_invoice_id" => $this->input->post('performa_invoice_id'),
					//		"production_mst_id"   => $insertid,
					//	 	"thickness" 	  	   => $this->input->post('thickness')[$no],
					//	 
					//	);
					//	$insertrecord = $this->pinv->insert_boxdesign_data($modelpricedata);
					//	$no++;
					//}
						
		}
		 else
		 {
				 $insertid = $this->pinv->update_producation_mst($data,$this->input->post('production_mst_id'));
				 $insertid = $this->input->post('production_mst_id');
				  
				  $data_additional = array(
						'performa_id' 			=> $this->input->post('performa_invoice_id'),
						'production_mst_id'  	=> $insertid,
						'readiness_date' 		=> date('Y-m-d',strtotime($this->input->post('readiness_date'))),
						'fumigation_id' 		=> $this->input->post('fumigation_id'),
						'mgf_company_name'  	=> $this->input->post('supplier_id'),
						'pallet_cap_id' 		=> $this->input->post('pallet_cap_id'),
						'air_bag_status' 		=> $this->input->post('air_bag_status'),
						'mosqure_bag_status' 		=> $this->input->post('mosqure_bag_status'),
						'quonitiy_status' 		=> $this->input->post('quonitiy_status'),
						'made_in_india_status' 	=> $this->input->post('made_in_india_status'),
						'corner_protector' 		=> $this->input->post('corner_protector'),
						'safety_belt' 		=> $this->input->post('safety_belt'),
						'separation_tiles' 		=> $this->input->post('separation_tiles'),
						'barcode_sticker' 		=> 'YES',
						'box_sticker'			=> 'YES',
						'loading_by' 			=> $this->input->post('loading_by'),
						'pallet_by' 			=> $this->input->post('pallet_by'),
						'qc_by' 				=> $this->input->post('qc_by'),
						'extra_field_1' 		=> $this->input->post('extra_field_1'),
						'extra_field_value_1' 	=> $this->input->post('extra_field_value_1'),
						'extra_field_2' 		=> $this->input->post('extra_field_2'),
						'extra_field_value_2' 	=> $this->input->post('extra_field_value_2'),
						'extra_field_3' 		=> $this->input->post('extra_field_3'),
						'extra_field_value_3' 	=> $this->input->post('extra_field_value_3'),
						'extra_field_4' 		=> $this->input->post('extra_field_4'),
						'extra_field_value_4' 	=> $this->input->post('extra_field_value_4'),
						'extra_field_5' 		=> $this->input->post('extra_field_5'),
						'extra_field_value_5' 	=> $this->input->post('extra_field_value_5'),
						'box_sticker_remarks' 	=> $this->input->post('box_sticker_remarks'),
						'pallet_label' 			=> 'YES',
						'cdate'		 			=> date('Y-m-d H:i:s'),
					);
					$files = $_FILES;
					$no	= 0;
					$cpt 	= count($_FILES['barcode_sticker_file']['name']);
					
					if(!empty($_FILES['barcode_sticker_file']['name'][0]))	
					{		
							$images_name =array();
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
								$design_name  = $dataInfo['file_name'];
								
								array_push($images_name,$design_name);
							}
							 
								$data_additional['barcode_sticker_file']  	= implode(",",$images_name);
						
					} 
					else
					{
						$data_additional['barcode_sticker_file']  = $this->input->post('barcode_sticker_file_name');
					}
					if($_FILES['box_sticker_file']['name'] != "" )	
					{
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
						$this->upload->do_upload('box_sticker_file');
						$upload_image = $this->upload->data();
						$data_additional['box_sticker_file']  = $upload_image['file_name'];
						
					} 
					else
					{
						$data_additional['box_sticker_file']  = $this->input->post('box_sticker_file_name');
					}
					
					if($_FILES['special_sticker_file']['name'] != "" )	
					{
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['special_sticker_file']['name']));
						$this->upload->do_upload('special_sticker_file');
						$upload_image = $this->upload->data();
						$data_additional['special_sticker_file']  = $upload_image['file_name'];
						
					} 
					else
					{
						$data_additional['special_sticker_file']  = $this->input->post('special_sticker_file_name');
					}
					 
					$updatedata = $this->pinv->update_additional($data_additional,$this->input->post('performa_additional_detail_id'));
					 
					 $delete_producation_trn = $this->pinv->deleteproducation($insertid);
						$no=0;
						$performa_packing_id = $this->input->post('copy_make_container');
						foreach($performa_packing_id as $row)
						{
					 	 
							$data_performa = array(
								'production_mst_id'  	 => $insertid,
								'performa_packing_id' 	 => $row,
								'performa_trn_id' 		 => 0,
								'no_of_pallet'  		 => $this->input->post('no_of_pallet'.$row),
								'no_of_big_pallet' 		 => $this->input->post('no_of_big_pallet'.$row),
								'no_of_small_pallet'	 => $this->input->post('no_of_small_pallet'.$row),
								'no_of_boxes' 			 => $this->input->post('no_of_boxes'.$row),
								'no_of_sqm' 			 => $this->input->post('no_of_sqm'.$row),
								'box_design_id' 		 => $this->input->post('box_design_id'.$row),
								'pallet_type_id' 		 => $this->input->post('pallet_type_id'.$row),
								'thickness' 			 => $this->input->post('thickness'.$row),
								'd_container' 			 => $this->input->post('d_container'.$row),
								'extra_pallet' 			 => $this->input->post('extra_pallet'.$row),
								'location' 			 => $this->input->post('location'.$row),
								'status' 		    	 => 0
						 
						);
						$resultdata = $this->pinv->insert_producation_trn($data_performa);
					 
						$no++;	
					}
					//$deletedataid = $this->pinv->delete_boxdesign_data($insertid);
					$deletedataid = $this->pinv->auto_loading($this->input->post('performa_invoice_id'));
					 
					//$no=0;
					//foreach($this->input->post('size_type_mm') as $size_type_mm)
					//{
					//	$modelpricedata = array(
					//		"size_type_mm"		  => $size_type_mm,
					//		"performa_invoice_id" => $this->input->post('performa_invoice_id'),
					//		"production_mst_id"   => $insertid,
					//		"thickness" 	  	   => $this->input->post('thickness')[$no]
					//		 
					//	);
					//	$insertrecord = $this->pinv->insert_boxdesign_data($modelpricedata);
					//				$no++;
					//}
		 }
		
			
		$row = array();
		$row['production_mst_id'] = $insertid;
		$row['res'] = 1;
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
	public function edit_copy_containter()
	{
		$production_mst_id 		 = $this->input->post('production_mst_id');
		 
		  $data = array(
				"no_of_countainer"	  => $this->input->post('container'),
				"producation_date"	  => date('Y-m-d',strtotime($this->input->post('producation_date'))),
				"producation_no"	  => $this->input->post('producation_no'),
				"supplier_id"	 	  => $this->input->post('supplier_id'),
				"note"				  => nl2br($this->input->post('note')),
				"status"			  => 0,
				"cdate"				  => date('Y-m-d H:i:s')
		 );
		 $insertid = $this->pinv->update_producation_mst($data,$production_mst_id);
		 $delete_producation_trn = $this->pinv->deleteproducation($production_mst_id);
		$no=0;
		$producttrn_id = $this->input->post('producttrn_id');
		foreach($producttrn_id as $row)
		{
			 $data_performa = array(
					'production_mst_id'  	 => $production_mst_id,
				 	'performa_packing_id' 	 => $this->input->post('performa_packing_id')[$no],
				 	'performa_trn_id' 		 => 0,
				 	'no_of_pallet'  		 => $this->input->post('no_of_pallet')[$no],
					'no_of_big_pallet' 		 => $this->input->post('no_of_big_pallet')[$no],
					'no_of_small_pallet'	 => $this->input->post('no_of_small_pallet')[$no],
					'no_of_boxes' 			 => $this->input->post('no_of_boxes')[$no],
					'no_of_sqm' 			 => $this->input->post('no_of_sqm')[$no],
					'status' 		    	 => 0
			);
			$no++;
			$resultdata = $this->pinv->insert_producation_trn($data_performa);
		}
	 
		echo $insertid;
	}
	
	function view_pdf()
	{
		$this->load->view('admin/producationpdf');
	}
	public function deleterecord()
	{
		$id					 = $this->input->post('production_mst_id');
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$deleterecord = $this->pinv->delete_producation($id);
		$deletedataid = $this->pinv->auto_loading($this->input->post('performa_invoice_id'));
					 
					
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
	public function click_for_production()
	{
		$production_mst_id	 = str_ireplace("-","','",$this->input->post('qcproduction_mst_id'));
		 
		$status = $this->input->post('status');
		
		$deleterecord = $this->pinv->update_producationsheet($production_mst_id,$status);
		 			 
					
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
	
	public function click_for_qc()
	{
		$production_mst_id	 = str_ireplace("-","','",$this->input->post('qcproduction_mst_id'));
		 
		$status = $this->input->post('status');
		
		$deleterecord = $this->pinv->update_producation($production_mst_id,$status);
		 			 
					
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
	public function click_for_pallet()
	{
		$production_mst_id	 = str_ireplace("-","','",$this->input->post('qcproduction_mst_id'));
		
		$status = $this->input->post('status');
		$deleterecord = $this->pinv->update_producation_pallet($production_mst_id,$status);
		 			 
					
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
}
