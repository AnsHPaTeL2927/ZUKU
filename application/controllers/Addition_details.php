<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Addition_details extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->load->model('Admin_product_invoice','pinv');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
 	function index($id)
	{ 	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data			= $this->pinv->select_invoice_data($id);
			$addtional_data	= $this->pinv->get_additional_data($id);
			$customer_detail= $this->pinv->get_cust_additional_data($data->consigne_id);
		 	$getfumigation	= $this->pinv->get_fumigation();
			$getpallet_type	= $this->pinv->get_pallet_type($customer_detail->pallet_type_id);
			$getpallet_cap	= $this->pinv->get_pallet_cap();
			$getbox_design	= $this->pinv->get_box_design();
			 
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			$supplier			=	$this->pinv->select_supplier();
			$this->load->model('admin_company_detail');	
			$user_data		= 	$this->menu->user_data();	
			
			$v = array(
						'invoicedata'		=>	$data,
						'product_data'		=>	$datap,
						'addtional_data' 	=>	$addtional_data,
						'menu_data' 		=>	$menu_data,
						'customerdetail' 	=>	$customer_detail,
						'company_detail'	=>  $this->admin_company_detail->s_select(),
						'all_supplier' 		=>	$supplier,
						'fumigation_data'	=>	$getfumigation,
						'pallet_type_data'	=>	$getpallet_type,
						'pallet_cap_data'	=>	$getpallet_cap,
						'user_data'			=>	$user_data,
						'box_design_data'	=>	$getbox_design
				 	);
			$this->load->view('admin/add_addition_details',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function manage()
	{

		 $data = array(
			'performa_id' 			=> $this->input->post('performa_invoice_id'),
			'readiness_date' 		=> date('Y-m-d',strtotime($this->input->post('readiness_date'))),
		 	'fumigation_id' 		=> $this->input->post('fumigation_id'),
		 	'mgf_company_name'  	=> $this->input->post('supplier_id'),
			'pallet_cap_id' 		=> $this->input->post('pallet_cap_id'),
			'air_bag_status' 		=> $this->input->post('air_bag_status'),
			'factory_logo_status' 	=> $this->input->post('factory_logo_status'),
			'quonitiy_status' 		=> $this->input->post('quonitiy_status'),
			'made_in_india_status' 	=> $this->input->post('made_in_india_status'),
		 	'mosqure_bag_status' 	=> $this->input->post('mosqure_bag_status'),
			'corner_protector' 		=> $this->input->post('corner_protector'),
			'safety_belt' 		=> $this->input->post('safety_belt'),
			'separation_tiles' 		=> $this->input->post('separation_tiles'),
	 		'barcode_sticker' 		=> 'YES',
			'box_sticker'			=> 'YES',
			'special_sticker'		=> 'YES',
			'box_sticker_remarks' 	=> $this->input->post('box_sticker_remarks'),
			'order_remarks' 		=> $this->input->post('order_remarks'),
			'pallet_label' 			=> 'YES',
			'cdate'		 			=> date('Y-m-d H:i:s'),
	 	);
		 
		 $row['res'] = 0;
		if(!empty($this->input->post('performa_additional_detail_id')))
		{
			 	$files = $_FILES;
				$no	= 0;
				$cpt 	= count($_FILES['barcode_sticker_file']['name']);
				 
			if(!empty($_FILES['barcode_sticker_file']['name'][0]))	
			{		
					$images_name = array();
					$imagesname = explode(",",$this->input->post('barcode_sticker_file_name'));
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
			else
			{
				$data['barcode_sticker_file']  = $this->input->post('barcode_sticker_file_name');
			}		
			if($_FILES['box_sticker_file']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('box_sticker_file_name'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
				$this->upload->do_upload('box_sticker_file');
				$upload_image = $this->upload->data();
				$data['box_sticker_file']  = $upload_image['file_name'];
				
			} 
			else
			{
				$data['box_sticker_file']  = $this->input->post('box_sticker_file_name');
			}	
			
			if($_FILES['special_sticker_file']['name'] != "" )	
			{
				unlink("./upload/".$this->input->post('special_sticker_file_name'));
			
				$this->load->library('upload');
				$this->upload->initialize($this->set_upload_options('special_sticker',$_FILES['special_sticker_file']['name']));
				$this->upload->do_upload('special_sticker_file');
				$upload_image = $this->upload->data();
				$data['special_sticker_file']  = $upload_image['file_name'];
				
			} 
			else
			{
				$data['special_sticker_file']  = $this->input->post('special_sticker_file_name');
			}	
			
			
			$updatedata = $this->pinv->update_additional($data,$this->input->post('performa_additional_detail_id'));
			if($updatedata)
			{
			 	$row['res'] = 2;
				$this->load->model('admin_invoice');
				$data = array(
					"addition_detail_status"	=>	2,
					"sign_detail_id"			=>	$this->input->post('sign_detail_id'),
					"step"						=>	3
				); 
				$updatestepinvoice =  $this->admin_invoice->updateperformainvoice($data,$this->input->post('performa_invoice_id'));
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
				else
				{
					$data['barcode_sticker_file']  = $this->input->post('barcode_sticker_file_name');
				}
				if($_FILES['box_sticker_file']['name'] != "" )	
				{
					$this->load->library('upload');
					$this->upload->initialize($this->set_upload_options('box_sticker',$_FILES['box_sticker_file']['name']));
					$this->upload->do_upload('box_sticker_file');
					$upload_image = $this->upload->data();
					$data['box_sticker_file']  = $upload_image['file_name'];
					
				} 
				else
				{
					$data['box_sticker_file']  = $this->input->post('box_sticker_file_name');
				}
				
				if($_FILES['special_sticker_file']['name'] != "" )	
				{
					unlink("./upload/".$this->input->post('special_sticker_file_name'));
				
					$this->load->library('upload');
					$this->upload->initialize($this->set_upload_options('special_sticker',$_FILES['special_sticker_file']['name']));
					$this->upload->do_upload('special_sticker_file');
					$upload_image = $this->upload->data();
					$data['special_sticker_file']  = $upload_image['file_name'];
					
				} 
				else
				{
					$data['special_sticker_file']  = $this->input->post('special_sticker_file_name');
				}	
			
				 
			$resultdata = $this->pinv->insert_additional($data);
			if($resultdata)
			{
				$this->load->model('admin_invoice');
				$data = array(
					"addition_detail_status"	=>	2,
					"sign_detail_id"			=>	$this->input->post('sign_detail_id'),
					"step"						=>	3 
				); 
				$updatestepinvoice =  $this->admin_invoice->updateperformainvoice($data,$this->input->post('performa_invoice_id'));
				$row['res'] = 1;
			}
		}
		
		//$deletedataid = $this->pinv->delete_boxdesign_data($this->input->post('performa_invoice_id'));
		//$no=0;
		//foreach($this->input->post('size_type_mm') as $size_type_mm)
		//{
		//	$modelpricedata = array(
		//		"size_type_mm"		  => $size_type_mm,
		//		"performa_invoice_id" => $this->input->post('performa_invoice_id'),
		//		"box_design_id" 	  => $this->input->post('box_design_id')[$no],
		//		"pallet_type_id" 	  => $this->input->post('pallet_type_id')[$no]
		// 	);
		//	$insertrecord = $this->pinv->insert_boxdesign_data($modelpricedata);
		//				$no++;
		//}
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
	function add_mutiple_record_with_design()
	{
		$modeldetail = $this->input->post('model_id');
		$no = 0;
		 
		foreach($modeldetail as $key)
		{
			$packing_model_id = $key;
			$performa_invoice_id = $this->input->post('designinvoice_id');
			$product_id = $this->input->post('design_product_id');
			$invoice_product_data_id = $this->input->post('design_invoice_product_data_id');
			
			$get_rate = $this->pinv->getrate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id);
			 $group_name = '';
			if($get_rate->group_Rate_In_USD == 0)
			{
				$get_defualt_rate = $this->pinv->getdefault_rate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id);
				$product_rate  = $get_defualt_rate->Rate_In_USD;
				 
			}
			else{
				$product_rate  = $get_rate->group_Rate_In_USD;
				$group_name = ' - '.$get_rate->seriesgroup_name;
			 }
			
			$data = array(
				'invoice_product_data_id' => $this->input->post('design_invoice_product_data_id'),
				'packing_details' => $this->input->post('design_invoice_product_data_id'),
				'model_details' => $packing_model_id,
				'design_id' => 0,
				'sqm' => $this->input->post('design_sqm'),
				'plts' => $this->input->post('design_plts'),
				'product_box_per_big_plt' => $this->input->post('design_big_plts'),
				'product_box_per_small_plt' => $this->input->post('design_small_plts'),
				'boxes' => $this->input->post('design_boxes'),
				'product_short_desc' => $this->input->post('design_product_short_desc').$group_name,
				'appsqmperboxes' => $this->input->post('design_appsqmperboxes'),
				'apwigtperbox' => $this->input->post('design_apwigtperbox'),
				'product_rate' => $product_rate,
				'fcl' => 1,
				'pcs_per_box' => $this->input->post('designpcs_per'),
				'invoice_id'=>$this->input->post('designinvoice_id'),
				'invoice_no'=>$this->input->post('designinvoice_pack'),
				'date' => $this->input->post('designdate'),
				'temp_status'=>0
			);
			 
			if($this->input->post('design_plts')>0)
			{
				$data['no_of_pallet'] 	= $this->input->post('design_pallet_in_container');
				$data['packing_boxes']  = 1 * $this->input->post('design_plts');
				$data['packing_pcs']    = $data['packing_boxes'] * $this->input->post('designpcs_per');
				$data['packing_sqmlm']  = $data['packing_boxes']  * $this->input->post('design_appsqmperboxes');
		 	}
			else if($this->input->post('design_big_plts')>0)
			{
				$data['big_pallet_qty']   = $this->input->post('design_bigpallet_in_container');
				$data['small_pallet_qty'] = $this->input->post('design_smallpallet_in_container');
				$data['packing_boxes'] = 2;
				$data['packing_pcs'] = 2 * $this->input->post('designpcs_per');
				$data['packing_sqmlm'] = 2 * $this->input->post('design_appsqmperboxes');
			}
			else{
				$data['packing_boxes'] = 1;
				$data['packing_pcs'] = 1 * $this->input->post('designpcs_per');
				$data['packing_sqmlm'] = 1 * $this->input->post('design_appsqmperboxes');
			}
		 $row['res'] = 0;
		 $resultdata = $this->pinv->packingdata_insert($data);
			 $id=$this->input->post('designinvoice_id');
			 $remarks='';
			 $image_status=2;
			 $_SESSION['checkimageradio'] = 2;
				$updatestepinvoice = $this->pinv->update_performainvoice($id,$remarks,$image_status);
		 if($resultdata)
		 {
			  $row['res'] = 1;
		 }
		 $no++;
		}
		 $row['res'] = 1;
		echo json_encode($row);
	}	 
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->pinv->packingdata_delete($id);
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function deleteallpackingrecord()
	{
		$id = $this->input->post('performa_invoice_id');
		$deleterecord = $this->pinv->packingdata_delete_all($id);
			 $remarks='';
			 $image_status=0;
			 $_SESSION['checkimageradio'] = $this->input->post('image_status');
				$updatestepinvoice = $this->pinv->update_performainvoice($id,$remarks,$image_status);
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function getmodel()
	{
		$id							= $this->input->post('product_id');
		$performa_invoice_id		= $this->input->post('performa_invoice_id');
		$image_status				= $this->input->post('image_status');
		$invoice_product_data_id	= $this->input->post('invoice_product_data_id');
		if($image_status == 2)
		{
			$str = '<div class="modaltreeview col-md-12">
						<ul class="treeview treeview1">
							 
							<li>
								<select id="model_id" name="model_id[]" multiple="multiple" required title="Select Design">';
									$fetchresult = $this->pinv->fetchrecord($invoice_product_data_id);
									if($fetchresult->defualt_status==1)
									{
									$resultdata1 = $this->pinv->regualr_packing_model_data_image($id);
									
										$str .= '<optgroup label="Regular">
													<option  value="0,Regular" style="color: blue;">Regular - Add Design</option>';
													 
											foreach($resultdata1 as $row)
											{
												$str .= '<option  value="'.$row->packing_model_id.'" style="background:url('.base_url()."upload/".$row->design_file.')no-repeat; background-size: 30px 30px; background-position: left;">'.$row->model_name.'</option>';
											}
										$str .= '</optgroup>';
									}
									$resultdata = $this->pinv->all_seriesgroup_data($id);
									foreach($resultdata as $row)
									{
										 $fetch_rate_data = $this->pinv->packing_model_data_from_invoice($invoice_product_data_id,$row->seriesgroup_id);
										if($fetch_rate_data>0)
										{
										 $str .= '<optgroup label="'.$row->seriesgroup_name.'">
														<option  value="0,'.$row->seriesgroup_id.'" style="color: blue;">  '.$row->seriesgroup_name.' - Add Design</option> ';
														$designdata = $this->pinv->group_packing_model_data_image($id,$row->seriesgroup_id);
											foreach($designdata as $designrow)
											{
												 
												$str .= '<option '.$sel.' value="'.$designrow->packing_model_id.'" style="background:url('.base_url()."upload/".$designrow->design_file.')no-repeat; background-size: 30px 30px; background-position: left;">  '.$designrow->model_name.' </option>';
												
											}
											$str .= '</optgroup>';
										}
									}  
								 
									$str .= ' </select>
									</li>';
		 
	 	 
		$str .= '</ul>
				</div>';
		echo $str;
		}
		else
		{
				echo "<option value=''>Select Design</option>";
				$fetchresult = $this->pinv->fetchrecord($invoice_product_data_id);
				if($fetchresult->defualt_status==1)
				{
					$resultdata1 = $this->pinv->regualr_packing_model_data($id,$invoice_product_data_id);
					echo "<optgroup label='Regular'>
							<option value='0,Regular,0'>Add Design (Regular)</option>
							";
						foreach($resultdata1 as $row1)
						{
							echo "<option value='".$row1->packing_model_id."'>".$row1->model_name."</option>";
						}
					echo "</optgroup>";
				}
				 $resultdata = $this->pinv->all_seriesgroup_data($id);
			 	 
				foreach($resultdata as $row)
				{
					 $fetch_rate_data = $this->pinv->packing_model_data_from_invoice($invoice_product_data_id,$row->seriesgroup_id);
					 if($fetch_rate_data>0)
						{
						echo "<optgroup label='".$row->seriesgroup_name."'>
								<option value='0,".$row->seriesgroup_name.",".$row->seriesgroup_id."'>Add Design (".$row->seriesgroup_name.")</option>";
						$resultdata2 = $this->pinv->group_packing_model_data($id,$row->seriesgroup_id);
						for($p=0;$p<count($resultdata2);$p++)
						{
							echo "<option value='".$resultdata2[$p]->packing_model_id."'>".$resultdata2[$p]->model_name."</option>";
						}  
						echo "</optgroup>";
					 }
				}
		}
	}
	public function updatelastprofoma(){
		$id=$this->input->post('invoice_id');
		$remarks=$this->input->post('remarks');
	 	$step = 3;
		$image_status = $this->input->post('image_status');
		$updatestepinvoice = $this->pinv->performa_invoice_stepupdate($id,$step,$remarks,$image_status);
		if($updatestepinvoice)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}

	public function selectinvoicedata()
	{
		$invoice_product_data_id=$this->input->post('invoice_product_data_id');
		$resultdata=$this->pinv->fetchproductrecord($invoice_product_data_id);
		echo json_encode($resultdata);
	}
	public function updatepackingdetails()
	{
		 $data = array(
			'invoice_product_data_id' => $this->input->post('packing_details'),
			'packing_details' => $this->input->post('packing_details'),
			'model_details' => $this->input->post('model_details'),
			'sqm' => $this->input->post('sqm'),
			'plts' => $this->input->post('plts'),
			'boxes' => $this->input->post('boxes'),
			'product_short_desc' => $this->input->post('product_short_desc'),
			'appsqmperboxes' => $this->input->post('appsqmperboxes'),
			'apwigtperbox' => $this->input->post('apwigtperbox'),
			'product_rate' => $this->input->post('product_rate'),
			'pcs_per_box' => $this->input->post('pack_pcs_per_box'),
			'no_of_pallet' => $this->input->post('no_of_pallet'),
			'product_box_per_big_plt' => $this->input->post('product_box_per_big_plt'),
			'product_box_per_small_plt' => $this->input->post('product_box_per_small_plt'),
			'big_pallet_qty' => $this->input->post('big_pallet_qty'),
			'small_pallet_qty' => $this->input->post('small_pallet_qty'),
			'packing_boxes' => $this->input->post('boxes'),
			'fcl' => $this->input->post('fcl'),
			'packing_pcs' => $this->input->post('packing_pcs'),
			'packing_sqmlm' => $this->input->post('packing_sqmlm'),
			'invoice_id'=>$this->input->post('invoice_id'),
			'invoice_no'=>$this->input->post('invoice_no'),
			'date' => $this->input->post('date')

      	);
		 
		$invoiceid=$this->input->post('invoice_id');
		$remarks=$this->input->post('remarks');
		$image_status = $this->input->post('image_status');
	 	$step=2;
		$temp_status=0;
		$updatestepinvoice = $this->pinv->performa_invoice_stepupdate($invoiceid,$step,$remarks,$image_status);
		 $id=$this->input->post('id');
		$updateid = $this->pinv->update_packing_details($data,$id);
		$row['res'] = 0;
		if($updateid)
		{
			$row['res'] = 1;
		}
		echo json_encode($row);
	}
	public function updateinvoice()
	{
		$invoiceid=$this->input->post('invoice_id');
		$remarks=$this->input->post('remarks');
		$image_status = $this->input->post('image_status');
	 	$step=2;
		$temp_status=0;
		$updatestepinvoice = $this->pinv->performa_invoice_stepupdate($invoiceid,$step,$remarks,$image_status);
	}
	public function updatepacking_fields()
	{
		$no = 0;
		$deletedataid = $this->pinv->delete_packing_fields_data($this->input->post('performa_invoice_id'));	
		foreach($this->input->post('update_with') as $updatewith)
		{
			$fields_data = array(
				"show_status" => (!empty($this->input->post('print_fileds'.$updatewith)))?"1":"0",
				"packing_fields_id" => $updatewith,
				"performa_invoice_id" => $this->input->post('performa_invoice_id'),
				"cdate" => date('Y-m-d H:i:s')
			 );
			$fields_insert_id = $this->pinv->insert_packing_fields($fields_data);
			 
			 $no++;
		}
		echo "<script>alert('Data Updated Successfully');window.location='".base_url()."packing/index/".$this->input->post('performa_invoice_id')."'</script>";
			 
	}
	public function getproduct_rate()
	{
		$packing_model_id = $this->input->post('packing_model_id');
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$product_id = $this->input->post('product_id');
		$invoice_product_data_id = $this->input->post('invoice_product_data_id');
		
		$get_rate = $this->pinv->getrate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id);
		
		if($get_rate->group_Rate_In_USD == 0)
		{
			$get_defualt_rate = $this->pinv->getdefault_rate($invoice_product_data_id,$performa_invoice_id,$product_id,$packing_model_id);
		  	 echo json_encode($get_defualt_rate);
		}
		else{
			$get_rate->Rate_In_USD = $get_rate->group_Rate_In_USD;
			$get_rate->total_pallet = $get_rate->group_total_pallet;
			$get_rate->total_big_pallet = $get_rate->group_total_big_pallet;
			$get_rate->total_small_pallet = $get_rate->group_total_small_pallet;
			$get_rate->product_container = $get_rate->group_total_pallet;
			 echo json_encode($get_rate);
		}
		 
	}
}
