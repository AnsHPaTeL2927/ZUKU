<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Quotation_product extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_quotation','quotation');
		$this->load->model('admin_product_invoice','pinv');
		
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
	function index($id)
	{
	  	if( $this->session->id == 1 && $this->session->title == TITLE)
		{
			$data= $this->quotation->select_quotation_data($id);
			$datap= $this->quotation->productdata_select($id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->model('admin_company_detail');	
			$v = array(
				'invoicedata'				=> $data,
				'product_data'				=> $datap,
				'allsizeproduct'			=> $this->quotation->allsizeproduct(),
				'menu_data'					=> $menu_data,
				'company_detail'			=> $this->admin_company_detail->s_select(),
				'allproduct'				=> $this->quotation->allproductsize() 
			);
			$this->load->view('admin/product_quotation',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function wallmanage()
	{
			$no=0;
			 
		 	foreach($this->input->post('product_id') as $product_row)
			{
				 
				if(!empty($product_row))
				{
					$description_goodsarray = $this->pinv->hsncproductsizedetail($product_row,2,0);
					$thickness 				= !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
					$description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
					 $productid = explode(" - ",$product_row);
					 
					$data = array(
						'estimate_id'			=> $this->input->post('wallestimate_id'),
						'product_size_id' 	 	=> $productid[1],
						'product_id' 			=> $productid[0],
					 	'description_goods' 	=> $description,
						'pallet_status' 		=> $this->input->post('pallet_status'.$this->input->post('no')[$no]),
						'weight_per_box' 		=> $this->input->post('weight_per_box')[$no],
						'pallet_weight'	 		=> $this->input->post('pallet_weight')[$no],
						'big_pallet_weight'	 	=> $this->input->post('big_pallet_weight')[$no],
						'small_pallet_weight'	=> $this->input->post('small_pallet_weight')[$no],
						'boxes_per_pallet'  	=> $this->input->post('boxes_per_pallet')[$no],
						'box_per_big_pallet'  	=> $this->input->post('box_per_big_pallet')[$no],
						'box_per_small_pallet'  => $this->input->post('box_per_small_pallet')[$no],
						'sqm_per_box' 			=> $this->input->post('sqm_per_box')[$no],
						'pcs_per_box' 			=> $this->input->post('pcs_per_box')[$no],
						'feet_per_box' 			=> $this->input->post('feet_per_box')[$no],
						'total_no_of_pallet' 	=> ($this->input->post('no_of_pallet')[$no] + $this->input->post('no_of_big_pallet')[$no] + $this->input->post('no_of_small_pallet')[$no]),
						'total_no_of_boxes' 	=> ($this->input->post('pallet_status'.$this->input->post('no')[$no]) == 2)?$this->input->post('only_no_of_boxes')[$no]:$this->input->post('no_of_boxes')[$no],
						'total_no_of_sqm' 		=> $this->input->post('no_of_sqm')[$no],
						'total_product_amt' 	=> $this->input->post('product_amt')[$no],
						'total_pallet_weight' 	=> 0,
						'total_net_weight' 		=> $this->input->post('packing_net_weight')[$no],
						'total_gross_weight' 	=> $this->input->post('packing_gross_weight')[$no],
				 		'cdate' =>date('Y-m-d H:i:s')
					);
					 
					 
						$insertid = $this->quotation->insert_quotation_trn($data);;
						$estimate_trn_id = $insertid;
					 
					$packing_data = array(
						"estimate_trn_id"		 => $estimate_trn_id,
						"design_id" 			 => $this->input->post('walldesign_id')[$no],
						"finish_id" 			 => $this->input->post('wallfinish_id')[$no],
						"client_name" 			 => $this->input->post('client_name')[$no],
						"barcode_no" 			 => $this->input->post('barcode_no')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => ($this->input->post('pallet_status'.$this->input->post('no')[$no]) == 2)?$this->input->post('only_no_of_boxes')[$no]:$this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => $this->input->post('product_rate_per')[$no],
						"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->quotation->insert_packing_data($packing_data); 
						$no++;
				}
			}
			$row = array();
			if($insertrecord)
			{
				$row['res']	=	1;
			}
			else
			{
				$row['res']	=	0;
			}
		echo json_encode($row);
	}
	public function import_order()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		error_reporting(0);
		$row = array();
		if($_FILES['import_file']['name'] != "" )	
		{
			$path = './upload/csv/';
			unlink($path."csvfile.csv");
			$this->load->library('upload');
		 	$this->upload->initialize($this->set_upload_options('csvfile',$_FILES['import_file']['name'],$path,'csv'));
			$this->upload->do_upload('import_file');
			$upload_image = $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				 
				if(count($fields)==13)
				{
					$farray = array("Size","Packing Name","Design No","Finish","Pallets","Big Pallets","Small Pallets","No of boxes","Per","Rate","sequence","Pallet Type","Box Design");
				 	if($fields == $farray)
					{
						$estimate_id = $this->input->post('importestimate_id');
						$customer_id = $this->input->post('exportcustomer_id');
						$line_no = 2;
						$trancute_temp_data = $this->pinv->trancute_tempdata();
						while(($row = fgetcsv($file)) != false ) 
						{        
						
							$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checksize = $this->pinv->getsize($row[0],$row[1]);
								 
								if(!empty($checksize))
								{
									$check_design = $this->pinv->checkdesign($row[2],$checksize->product_id);
									$model_name = $check_design->model_name;
									if(!empty($check_design))
									{
										$check_pallet_type = $this->pinv->check_pallet_type($row[11]);
										if(!empty($check_pallet_type))
										{
											$pallet_type_id = $check_pallet_type->pallet_type_id;
											$check_box_design = $this->pinv->check_box_design($row[12]);
											if(!empty($check_box_design))
											{
												$box_design_id = $check_box_design->box_design_id;
												 
													$check_finish = $this->pinv->check_finish($row[3],$check_design->packing_model_id);
												 
														
														$finish_id = $check_finish->finish_id;
														$description_goodsarray = $this->pinv->hsncproductsizedetail($checksize->product_id,2,$this->input->post('import_customer_id'));
														$thickness  = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
														$description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
														$pallet_status 			= 0;
														$no_of_boxes 			= 0;
														$packing_net_weight 	= 0;
														$packing_gross_weight 	= 0;
														if(!empty($row[4]))
														{
															$pallet_status 			= 1;
															$no_of_boxes 			= $row[4] * $checksize->boxes_per_pallet;
															$packing_net_weight 	= $no_of_boxes * $checksize->weight_per_box;
															$pallet_weight		 	= $row[4] * $checksize->pallet_weight;
															$packing_gross_weight 	= $packing_net_weight + $pallet_weight;
														}
														else if(!empty($row[5]) || !empty($row[6]))
														{
															$pallet_status 			= 3;
															$big_boxes 				= $row[5] * $checksize->box_per_big_plt;
															$big_weight 			= $big_boxes * $checksize->weight_per_box;
															$bigpallet_weight 		= $row[5] * $checksize->big_plat_weight;
															$small_boxes 			= $row[6] * $checksize->box_per_small_plt_new;
															$small_weight 			= $small_boxes * $checksize->weight_per_box;
															$smallpallet_weight 	= $row[6] * $checksize->small_plat_weight;
															$no_of_boxes 			= $big_boxes + $small_boxes;
															$packing_net_weight 	= $big_weight +  $small_weight;
															$packing_gross_weight 	= $packing_net_weight + $bigpallet_weight + $smallpallet_weight;
														}
														else
														{
															$pallet_status 			= 2;
															$no_of_boxes		 	= $row[7];
															$packing_net_weight 	= $no_of_boxes * $checksize->weight_per_box;
															$packing_gross_weight 	= $packing_net_weight;
														}
														$checkalready_exit = $this->pinv->checkalready($performa_id,$checksize->product_id,$check_design->packing_model_id,$finish_id,$no_of_boxes,$row[8],$row[9],$row[10]);
														
														if($checkalready_exit == 0)
														{
															$error_array = "";
															$complete_status = 0;
															
														}
														else
														{
															$error_array = "Record already inserted.";
															$complete_status = 1;
														}
													 
										 	}
											else
											{
												$error_array = "Box Design Not Found.";
												$complete_status = 1;
											}
										}
										else
										{
											$error_array = "Pallet Type Not Found.";
											$complete_status = 1;
										}
									}
									else
									{
										$error_array = "Design Not Found.";
										$complete_status = 1;
									}
								}
								else
								{
										$error_array = "Size Not Found.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
						  	$insert_temp_data = array(
							  	"line_no" 			=> $line_no,
							  	"performa_id" 	 	=> $estimate_id,
							  	"remarks" 			=> $error_array,
							  	"seq" 				=> $row[9],
							   	"complete_status" 	=> $complete_status
							  ); 
							 $inserttempid = $this->pinv->insert_tempdata($insert_temp_data);
						 $line_no++;
					}
					 fclose($file);
					 $response = $this->pinv->check_error_inexcel();
					 if($response == 1)
					 {
						 $file1 = fopen($path.$data['file_name'], 'r');
						 $no = 0;
						 $fields = fgetcsv($file1);
						 while(($row1 = fgetcsv($file1)) != false ) 
						 {
							  
							 if(!empty(trim($row1[0])))
							 { 
							 
								 
								$checksize = $this->pinv->getsize($row1[0],$row1[1]);
								$check_design = $this->pinv->checkdesign($row1[2],$checksize->product_id);
								$model_name = $check_design->model_name;
								$check_pallet_type = $this->pinv->check_pallet_type($row1[11]);
								$pallet_type_id = $check_pallet_type->pallet_type_id;
								$check_box_design = $this->pinv->check_box_design($row1[12]);
								$box_design_id = $check_box_design->box_design_id;
								
								$check_finish = $this->pinv->check_finish($row1[3],$check_design->packing_model_id);
								$finish_id = $check_finish->finish_id;
								$description_goodsarray = $this->pinv->hsncproductsizedetail($checksize->product_id,2,$this->input->post('import_customer_id'));
								$thickness  = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
								$description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
								$pallet_status 			= 0;
								$no_of_boxes 			= 0;
								$packing_net_weight 	= 0;
								$packing_gross_weight 	= 0;
								if(!empty($row1[4]))
								{
									$pallet_status 			= 1;
									$no_of_boxes 			= $row1[4] * $checksize->boxes_per_pallet;
									$packing_net_weight 	= $no_of_boxes * $checksize->weight_per_box;
									$pallet_weight		 	= $row1[4] * $checksize->pallet_weight;
									$packing_gross_weight 	= $packing_net_weight + $pallet_weight;
								}
								else if(!empty($row1[5]) || !empty($row1[6]))
								{
									$pallet_status 			= 3;
									$big_boxes 				= $row1[5] * $checksize->box_per_big_plt;
									$big_weight 			= $big_boxes * $checksize->weight_per_box;
									$bigpallet_weight 		= $row1[5] * $checksize->big_plat_weight;
									$small_boxes 			= $row1[6] * $checksize->box_per_small_plt_new;
									$small_weight 			= $small_boxes * $checksize->weight_per_box;
									$smallpallet_weight 	= $row1[6] * $checksize->small_plat_weight;
									$no_of_boxes 			= $big_boxes + $small_boxes;
									$packing_net_weight 	= $big_weight +  $small_weight;
									$packing_gross_weight 	= $packing_net_weight + $bigpallet_weight + $smallpallet_weight;
								}
								else
								{
									$pallet_status 			= 2;
									$no_of_boxes		 	= $row1[7];
									$packing_net_weight 	= $no_of_boxes * $checksize->weight_per_box;
									$packing_gross_weight 	= $packing_net_weight;
								}
								$sqm = $no_of_boxes * $checksize->sqm_per_box;
								if($row1[8] == "SQM")
								{
									$product_amt = $sqm * $row1[9];
								}
								else if($row1[8] == "BOX")
								{
									$product_amt = $no_of_boxes * $row1[9];	
								}
								else if($row1[8] == "SQF")
								{
									$product_amt = $checksize->feet_per_box * $no_of_boxes * $row1[9];	
								}
								else if($row1[8] == "PCS")
								{
									$product_amt = $checksize->pcs_per_box * $no_of_boxes * $row1[9];	
								}
																
								$maindata = array(
									'estimate_id' 			=> $estimate_id,
									'product_id' 			=> $checksize->product_id,
									'product_size_id' 	 	=> $checksize->product_size_id,
									'product_container' 	=> 0,
									'description_goods' 	=> $description,
									'pallet_status' 		=> $pallet_status,
									'weight_per_box'  		=> $checksize->weight_per_box,
									'pallet_weight'	  		=> $checksize->pallet_weight,
									'big_pallet_weight'		=> $checksize->big_plat_weight,
									'small_pallet_weight'	=> $checksize->small_plat_weight,
									'boxes_per_pallet'  	=> $checksize->boxes_per_pallet,
									'box_per_big_pallet'  	=> $checksize->box_per_big_plt,
									'box_per_small_pallet'  => $checksize->box_per_small_plt_new,
									'sqm_per_box' 			=> $checksize->sqm_per_box,
									'pcs_per_box' 			=> $checksize->pcs_per_box,
									'feet_per_box' 			=> $checksize->feet_per_box,
									'total_no_of_pallet' 	=> ($row1[4] + $row1[5] + $row1[6]),
									'total_no_of_boxes' 	=> $no_of_boxes,
									'total_no_of_sqm' 		=> $sqm,
									'total_product_amt' 	=> $product_amt,
									'total_pallet_weight' 	=> $checksize->pallet_weight,
									'total_net_weight' 		=> $packing_net_weight,
									'total_gross_weight' 	=> $packing_gross_weight,
									'container_half' 		=> 1,
									"seq" 				    => $row1[10], 
									'cdate'				 	=> date('Y-m-d H:i:s')
							);
							$insertid = $this->pinv->insert_quotation_trn($maindata);
							 
							
							$packing_data = array(
									"estimate_trn_id"		=> $insertid,
									"design_id" 			=> $check_design->packing_model_id,
									"finish_id" 	 		=> $finish_id,
									"client_name" 	 		=> $row1[10],
									"barcode_no" 			=> $row1[11],
									"product_rate" 			=> $row1[9],
									"no_of_pallet" 	 		=> $row1[4],
									"no_of_big_pallet"  	=> $row1[5],
									"no_of_small_pallet"	=> $row1[6],
									"no_of_boxes" 	 		=> $no_of_boxes,
									"no_of_sqm" 	 		=> $sqm,
									"per" 		 			=> $row1[8],
									"product_amt" 	 		=> $product_amt,
									"packing_net_weight"	=> $packing_net_weight ,
									"packing_gross_weight"  => $packing_gross_weight, 
									"box_design_id"  		=> $box_design_id, 
									"pallet_type_id"  		=> $pallet_type_id 
									
							);
							
							$insertrecord = $this->quotation->insert_packing_data($packing_data);
							 
							 }
							 						
						 }
					 	  fclose($file);
						 $row['res'] = $response;
					 }
					 else
					 {
						  $row['res'] = $response;
					 }
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					$row['res'] = 2;
				}
			} 
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	
	private function set_upload_options($newfilename,$filename,$upload_path,$allowed_types)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 	 = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] 	 = $upload_path;
		$config['allowed_types'] = $allowed_types;
		$config['max_size']      = '5000';
		$config['overwrite']     = TRUE;

		return $config;
	}
	public function othermanage()
	{
			$no=0;
			 
		 	foreach($this->input->post('other_product_description') as $product_row)
			{
				 
				if(!empty($product_row))
				{
					$no_of_sqm = 0;
					$no_of_box = 0;
				 
					if($this->input->post('other_unit_per')[$no] == "SQM")
					{
						$no_of_sqm =  $this->input->post('other_qty')[$no];
					}
					else if($this->input->post('other_unit_per')[$no] == "BOX")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					}
					else if($this->input->post('other_unit_per')[$no] == "SQF")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					} 
					else if($this->input->post('other_unit_per')[$no] == "PCS")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					} 
					$data = array(
						'estimate_id'			=> $this->input->post('otherestimate_id'),
						'product_size_id' 	 	=> 0,
						'product_id' 			=> 0,
					 	'description_goods' 	=> $product_row,
						'pallet_status' 		=> 0,
						'weight_per_box' 		=> 0,
						'pallet_weight'	 		=> 0,
						'big_pallet_weight'	 	=> 0,
						'small_pallet_weight'	=> 0,
						'boxes_per_pallet'  	=> 0,
						'box_per_big_pallet'  	=> 0,
						'box_per_small_pallet'  => 0,
						'sqm_per_box' 			=> 0,
						'pcs_per_box' 			=> 0,
						'feet_per_box' 			=> 0,
						'total_no_of_pallet' 	=> 0,
						'total_no_of_boxes' 	=> $no_of_box,
						'total_no_of_sqm' 		=> $no_of_sqm,
						'total_product_amt' 	=> $this->input->post('other_amt')[$no],
						'total_pallet_weight' 	=> 0,
						'total_net_weight' 		=> $this->input->post('other_net_weight')[$no],
						'total_gross_weight' 	=> $this->input->post('other_gross_weight')[$no],
					 	'cdate' =>date('Y-m-d H:i:s')
					);
					 
					$otherestimate_trn_id =  $this->input->post('otherestimate_trn_id');
					$otherestimate_packing_id 	  =  $this->input->post('otherestimate_packing_id');
					
					if(!empty($otherestimate_trn_id))
					{
						$update_id 	= $this->quotation->update_productrecord($data,$otherestimate_trn_id);
						 
					}
					else
					{
						$insertid = $this->quotation->insert_quotation_trn($data);
						$otherestimate_trn_id = $insertid;
					}
					
					$packing_data = array(
						"estimate_trn_id"		 => $otherestimate_trn_id,
						"design_id" 			 => 0,
						"finish_id" 			 => 0,
						"client_name" 			 => 0,
						"barcode_no" 			 => 0,
						"product_rate" 			 => $this->input->post('other_rate')[$no],
						"no_of_pallet" 			 => 0,
						"no_of_big_pallet" 		 => 0,
						"no_of_small_pallet" 	 => 0,
						"no_of_boxes" 			 => $no_of_box,
						"no_of_sqm" 			 => $no_of_sqm,
						"per" 					 => $this->input->post('other_unit_per')[$no],
						"product_amt" 			 => $this->input->post('other_amt')[$no],
						"packing_net_weight"	 => $this->input->post('other_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('other_gross_weight')[$no]
						);
						 
						if(!empty($_FILES['other_image']['name'][$no]))
						{
							$_FILES['filename']['name']	= $_FILES['other_image']['name'][$no];
							$_FILES['filename']['type']	= $_FILES['other_image']['type'][$no];
							$_FILES['filename']['tmp_name']= $_FILES['other_image']['tmp_name'][$no];
							$_FILES['filename']['error']	= $_FILES['other_image']['error'][$no];
							$_FILES['filename']['size'] 	= $_FILES['other_image']['size'][$no];    
						
							if($_FILES['filename']['name'] != "")	
							{
								$this->load->library('upload');
								$this->upload->initialize($this->set_upload_options('other_image',$_FILES['filename']['name'],"./upload/design/","gif|jpg|jpeg|png"));
								$this->upload->do_upload('filename');
								
								$upload_image = $this->upload->data();
								$packing_data['other_image']  = $upload_image['file_name'];
								
							}
							if(!empty($otherestimate_packing_id))
							{
							 unlink(DESIGN_PATH.$this->input->post('other_image_name')[$no]);
							}
						}
						 
						if(!empty($otherestimate_packing_id))
						{
							 
							$update_id 	= $this->quotation->update_productpackingrecord($packing_data,$otherestimate_packing_id);
							
						}
						else
						{
							$insertrecord = $this->quotation->insert_packing_data($packing_data);
						}	 
						$no++;
				}
			}
			$row = array();
			if($insertrecord)
			{
				$row['res']	=	1;
			}
			else if($update_id)
			{
				$row['res']	=	2;
			}
			else
			{
				$row['res']	=	0;
			}
		echo json_encode($row);
	}
	
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->quotation->delete_product($id);	
		$deletepackingrecord = $this->quotation->delete_product_packing($id);	
		  
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function fetchproductdata()
	{
		$id 					= $this->input->post('id');
		$estimate_packing_id 	= $this->input->post('estimate_packing_id');
		$fetchresult 			= array();
		$fetchresult 			= $this->quotation->fetchrecord($id);
		$fetchresult->packing	= $this->quotation->getpacking($estimate_packing_id);
		 
		echo json_encode($fetchresult);
	}
	public function manage()
	{
		 
			$description_goodsarray = $this->pinv->hsncproductsizedetail($this->input->post('product_details'),2,0);
			$thickness = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
			$description = $this->input->post('description_goods');
			   
			$data = array(
				'estimate_id'			=> $this->input->post('estimateid'),
				'product_id' 			=> $this->input->post('product_details'),
				'product_size_id' 	 	=> $this->input->post('product_size_id'),
				 'description_goods' 	=> $description,
				'pallet_status' 		=> $this->input->post('pallet_status'),
				'weight_per_box' 		=> $this->input->post('weight_per_box'),
				'pallet_weight'	 		=> $this->input->post('pallet_weight'),
				'big_pallet_weight'	  	=> $this->input->post('big_pallet_weight'),
				'small_pallet_weight' 	=> $this->input->post('small_pallet_weight'),
				'boxes_per_pallet'  	=> $this->input->post('boxes_per_pallet'),
				'box_per_big_pallet'  	=> $this->input->post('box_per_big_pallet'),
				'box_per_small_pallet' 	=> $this->input->post('box_per_small_pallet'),
				'sqm_per_box' 			=> $this->input->post('sqm_per_box'),
				'pcs_per_box' 			=> $this->input->post('pcs_per_box'),
				'feet_per_box' 			=> $this->input->post('feet_per_box'),
				'total_no_of_pallet' 	=> $this->input->post('total_no_of_pallet'),
				'total_no_of_boxes' 	=> $this->input->post('total_no_of_boxes'),
				'total_no_of_sqm' 		=> $this->input->post('total_no_of_sqm'),
			 	'total_product_amt' 	=> $this->input->post('total_product_amt'),
				'total_pallet_weight' 	=> $this->input->post('total_pallet_weight'),
				'total_net_weight' 		=> $this->input->post('total_net_weight'),
				'total_gross_weight' 	=> $this->input->post('total_gross_weight'),
				'seq' 					=> $this->input->post('sequeance'),
			   	'cdate' =>date('Y-m-d H:i:s')
				);
				
		 	 $id = $this->input->post('estimate_trn_id');
			if(empty($id))
			{
				$insertid = $this->quotation->insert_quotation_trn($data);
				$no=0;
				foreach($this->input->post('design_id') as $design)
				{
					if(!empty($design))
					{
					$packing_data = array(
						"estimate_trn_id"		 => $insertid,
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"client_name" 			 => $this->input->post('client_name')[$no],
						"barcode_no" 			 => $this->input->post('barcode_no')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => $this->input->post('product_rate_per')[$no],
				 		"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->quotation->insert_packing_data($packing_data);
						 
					}
					
					$no++;
				}
				if($insertid)
				{	
					$row['res'] = "1";
					$row['product_trn_id'] = $rdata;
					 
				}
				$id = $insertid;
			}
			else
			{
				$update_id = $this->quotation->update_productrecord($data,$id);
				
				 
			 	$deletedataid = $this->quotation->delete_rate_data($id);	
				$no=0;
				foreach($this->input->post('design_id') as $design)
				{
					if(!empty($design))
					{
					$packing_data = array(
						"estimate_trn_id"		 => $id,
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"client_name" 			 => $this->input->post('client_name')[$no],
						"barcode_no" 			 => $this->input->post('barcode_no')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => $this->input->post('product_rate_per')[$no],
				 		"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->quotation->insert_packing_data($packing_data);
						 
					}
					
					$no++;
				}
				if($update_id)
				{
					
					$row['res'] = "2";
					$row['product_trn_id'] = $id;
						 
					 
				}
				 
			}
		 
		 $update_seq = $this->quotation->updateseq($this->input->post('sequeance'),$this->input->post('estimateid'),$id);
		 
		echo json_encode($row);

	}
	public function update_quotation()
	{
		$quotation_data = array(
			'calculation_operator'	=> $this->input->post('calculation_operator'),
			'certification_charge'	=> $this->input->post('certification_charge'),
			'insurance_charge'		=> $this->input->post('insurance_charge'),
			'seafright_charge'		=> $this->input->post('seafright_charge'),
			'igst_per_value'		=> $this->input->post('igst_per_value'),
			'sgst_per_value'		=> $this->input->post('sgst_per_value'),
			'cgst_per_value'		=> $this->input->post('cgst_per_value'),
			'igst_value'			=> $this->input->post('igst_value'),
			'sgst_value'			=> $this->input->post('sgst_value'),
			'cgst_value'			=> $this->input->post('cgst_value'),
			'discount'				=> $this->input->post('discount'),
		 	'courier_charge'		=> $this->input->post('courier_charge'),
			'bank_charge'			=> $this->input->post('bank_charge'),
			'grand_total'			=> $this->input->post('grand_total'),
			'special_requirment'	=> nl2br($this->input->post('special_requirment')),
			'note'					=> nl2br($this->input->post('note')),
			'invoicevalue_say'		=> $this->input->post('invoicevalue_say'),
		 	 
			);
			 
		$quotation_data['step'] = $this->input->post('step');
			 
			$quotation_data_update_id = $this->quotation->update_quotation($quotation_data,$this->input->post('estimate_id'));
		echo 1;
	}
	 
	public function load_design_data()
	{
		$id = $this->input->post('id');
		$customer_id = $this->input->post('customer_id');
		$total_container = 1;
	 	$mode = $this->input->post('mode');
		
			if(strtolower($mode)=="add")
			 {
				 	$data = $this->pinv->hsncproductsizedetail($id,2,$customer_id);
					$result=$data[0];
				 	$hsnc_code	= $data[0]->hsnc_code;
					$hsncdata 	= $this->pinv->hsncproductcodedetail($hsnc_code);
					$hsnc 	  	= $hsncdata[0]->series_name;
					$hsncsize 	= $hsncdata[0]->size_type;
					$size_name	= $result->size_type_mm;
					$series_name= $result->series_name;
					$thickness  = (!empty($result->thickness))?' - '.$result->thickness.' MM':"";
					$description_goods = $size_name.' ('.$series_name.')';
					$packing_detail = $this->pinv->get_packing_detail($id,$customer_id);
					 $deletestatus = 0;
			 }
			 else if(strtolower($mode)=="edit")
			 {
				 $estimate_trn_id	 = $this->input->post('estimate_trn_id');
				 $product_id 		 = $this->input->post('id');
				 $deletestatus 		 = $this->input->post('deletestatus');
				 $fetchproductresult = $this->quotation->fetchproductrecord($estimate_trn_id);
			 
				 $packing_detail = $this->pinv->get_packing_detail($id,$customer_id);
				 $description_goods = $fetchproductresult->description_goods;
				 $disable = ($this->input->post('check_production_sheet') == 1)?"readonly":"";
			 }
			  
		$str = '<div class="col-md-12">
				 <div class="field-group">
					<input type="text" id="description_goods" name="description_goods" placeholder="Description of Goods" class="form-control" required="" title="Enter Description of Goods"  value="'.$description_goods.'"/>
				 </div>    
				</div>  
					<div class="col-md-4">
						<div>
							 <select class="select2" id="product_size_id" name="product_size_id" onchange="load_packing(this.value,&quot;Add&quot;,'.$deletestatus.')" '.$disable.'>
								<option value="">Select Packing</option>';
						 		foreach($packing_detail as $packing_row)
								{
									$sel = '';
									if($fetchproductresult->product_size_id == $packing_row->product_size_id)
									{
										$sel = 'selected="selected"';
									}
									else if($packing_row->p_size == $packing_row->product_size_id)
									{
										$sel = 'selected="selected"';
									}
									$label = $packing_row->product_packing_name;
														 
														if($packing_row->boxes_per_pallet > 0)
														{
															$label .= ' - '.$packing_row->boxes_per_pallet.' Boxes - '.$packing_row->total_pallent_container.' Pallets';
														}
														else if($packing_row->box_per_big_plt > 0 || $packing_row->no_small_plt_container_new >0)
														{
															$label .= ' - '.$packing_row->box_per_big_plt.' * '.$packing_row->no_big_plt_container_new.','.$packing_row->box_per_small_plt_new.' * '.$packing_row->no_small_plt_container_new.' Pallets';
														}
														else
														{
															$label .= ' - '.$packing_row->total_boxes.' Boxes';
														}
									
						 			$str .='<option '.$sel.' value="'.$packing_row->product_size_id.'">'.$label.'</option>';
						 		}
					 	$str .='</select>
						</div>    
				    </div>
					<div class="packing_detail"></div> ';
		
		echo $str;
	}
	public function load_packing()
	{
		$product_size_id = $this->input->post('product_size_id');
		$consigne_id = $this->input->post('customer_id');
		$total_container = 1;
	 	$mode = $this->input->post('mode'); 
			 
			 if(strtolower($mode)=="add")
			 {
				  $data 		= $this->pinv->fetch_packing_detail($product_size_id);
				  $data_product = $this->pinv->hsncproductsizedetail($data->product_id,2,$consigne_id);
					$box_design_id = $data_product[0]->box_design_id;
					 
					$pallet_type_id = $data_product[0]->pallet_type_id;
				    $fetchresult = $this->pinv->fetchdesign_detail($data->product_id);
					
					$result=$data;
					$checked1 = "";
					$checked2 = "";
					$checked3 = "";
					if($result->boxes_per_pallet>0)
					{
						$checked1 				 = "checked";
						$pallet_weight 			 = $result->pallet_weight;
						$boxes_per_pallet 		 = $result->boxes_per_pallet;
						$no_of_pallet 			 = $result->total_pallent_container;
						$no_of_pallet1 			 = $result->total_pallent_container;
						$sqm_per_container 		 =  $result->sqm_per_container;
						$defualt_netweight 		 = $fetchproductresult->pallet_net_weight_per_container;
						$defualt_grossweight 	 = $result->pallet_gross_weight_per_container;
						$total_box_per_container = $result->box_per_container;
					}
					else if($result->total_boxes>0)
					{
						$checked2 = "checked";
						$total_boxes 			 = $result->total_boxes;
						$sqm_per_container 		 =  $result->withoutpallet_sqm_per_container;
						$defualt_netweight 		 = $fetchproductresult->withoutnet_weight_per_container;
						$defualt_grossweight 	 = $result->withoutgross_weight_per_container;
						$total_box_per_container = $result->total_boxes;
					}
					else if($result->box_per_big_plt>0)
					{
						$checked3 = "checked";
						$big_pallet_weight 		 = $result->big_plat_weight;
						$small_pallet_weight 	 = $result->small_plat_weight;
						$box_per_big_pallet 	 = $result->box_per_big_plt;
						$box_per_small_pallet 	 = $result->box_per_small_plt_new;
						$no_of_big_pallet 		 = $result->no_big_plt_container_new;
					 	$no_of_small_pallet		 = $result->no_small_plt_container_new;
						 $sqm_per_container 	 =  $result->multi_sqm_per_container;
						$total_box_per_container = $result->multi_box_per_container;
					}
				  	$weight_per_box = $result->weight_per_box;
				 	$sqm_per_box 	= $result->sqm_per_box;
					$pcs_per_box 	= $result->pcs_per_box;
					$feet_per_box 	= $result->feet_per_box;
					 
					$price=$result->defualt_rate;
					$Total_Amount_usd= $price * $result->sqm_per_container;
					$usdprice = number_format((float)$price, 2, '.', '');
					$Total_Amount_euro=$price*$result->sqm_per_container;
					$europrice = number_format((float)$price, 2, '.', '');
					$totalprice = ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					$default_total = ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					
					  
					$total_container = 1;
					$container_checked ='checked';
					$displaynone = '';
					$series_id 		= $result->series_id;
					$model_type_id 	= $result->model_type_id;
					$defualt_status = 1;
					$sequeance 			= $this->input->post('no');
					 
			 }
			 else if(strtolower($mode)=="edit")
			 {
				 $estimate_trn_id = $this->input->post('estimate_trn_id');
				 $product_size_id = $this->input->post('product_size_id');
				 
				 $deletestatus 			= $this->input->post('deletestatus');
				 $fetchproductresult 	= $this->quotation->fetchproductrecord($estimate_trn_id);
				 $data_product 			= $this->pinv->hsncproductsizedetail($fetchproductresult->product_id,2,$consigne_id);
				 $design_data 			= $this->pinv->fetchdesign_detail($fetchproductresult->product_id);
				 $checked1 				= ($fetchproductresult->pallet_status==1)?"checked":"";
				 $checked2		 		= ($fetchproductresult->pallet_status==2)?"checked":"";
				 $checked3				= ($fetchproductresult->pallet_status==3)?"checked":"";
				 $container_checked 	= ($fetchproductresult->product_container>0)?'checked':'';
				 $displaynone	    	= ($fetchproductresult->product_container==0)?'display:none':'';
			 	 $total_container 		= $fetchproductresult->product_container;
				 $weight_per_box 		= $fetchproductresult->weight_per_box;
				 $pallet_weight 		= $fetchproductresult->pallet_weight;
				 $boxes_per_pallet 		= $fetchproductresult->boxes_per_pallet;
				 $big_pallet_weight  	= $fetchproductresult->big_pallet_weight;
				 $small_pallet_weight 	= $fetchproductresult->small_pallet_weight;
				 $box_per_big_pallet 	= $fetchproductresult->box_per_big_pallet;
				 $box_per_small_pallet 	= $fetchproductresult->box_per_small_pallet;
				 $sqm_per_box 			= $fetchproductresult->sqm_per_box;
				 $pcs_per_box 			= $fetchproductresult->pcs_per_box;
				 $feet_per_box 			= $fetchproductresult->feet_per_box;
		 		 $hsnc_code 			= $fetchproductresult->hsnc_code;
		 		 $sequeance 			= $fetchproductresult->seq;
				    
				$disable = ($this->input->post('check_production_sheet') == 1)?"readonly":""; 
				$disable1 = ($this->input->post('check_production_sheet') == 1)?"disabled":""; 
				 
			 }
			  
		$str = '<div class="col-md-8">
						<div>
							With/Without Pallet :
						 	<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet_status(this.value)" '.$disable.'  />With Pallet 
							</label>
							 <label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet_status(this.value)" '.$checked2.' '.$disable.'  />Without Pallet
							</label> 
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status3" value="3" onclick="check_pallet_status(this.value)" '.$checked3.' '.$disable.'   />Multi Pallet
							</label>
						</div>    
				    </div>
					 <div class="col-md-2">					
				      <div class="field-group">
				    	<lable>Weight Per Box </lable>
				         <input type="text" id="weight_per_box" name="weight_per_box" placeholder="Weight Per Box" class="form-control"  value="'.$weight_per_box.'" onkeypress="return isNumber(event)" onkeyup="cal_all_total()"  onblur="cal_all_total()" '.$disable.'  /> 
						
				    </div>                     
				    </div> 
					
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Big Pallet Weight</lable>
							<input type="text" id="big_pallet_weight" name="big_pallet_weight" placeholder="Big Pallet Weight" required="" class="form-control" value="'.$big_pallet_weight.'" '.$disable.'   title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_all_total()"   onblur="cal_all_total()"/>
				    </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Small Pallet Weight</lable>
							<input type="text" id="small_pallet_weight" name="small_pallet_weight" placeholder="Small Pallet Weight" required="" class="form-control" value="'.$small_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_all_total()"  '.$disable.'   onblur="cal_all_total()"/>
				    </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Pallet</lable>
								<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="Boxes Per Pallet" required="" class="form-control" required="" value="'.$boxes_per_pallet.'" title="Enter Boxes Per Pallet" onkeypress="return isNumber(event)" '.$disable.'   onkeyup="cal_all_total()"  onblur="cal_all_total()"/>
					 	  </div>                     
				    </div>
					
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Big Pallet</lable>
								<input type="text" id="box_per_big_pallet" name="box_per_big_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_big_pallet.'" title="Enter Boxes Per Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_all_total()"   onblur="cal_all_total()" '.$disable.'  />
						   </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Small Pallet</lable>
								<input type="text" id="box_per_small_pallet" name="box_per_small_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_small_pallet.'" title="Enter Boxes Per Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_all_total()" onblur="cal_all_total()" '.$disable.'  />
									 
						  </div>                     
				    </div> 
					<div class="col-md-2">				
					 <div class="field-group">
				    	<lable>Sqm Per box</lable>
								<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="Sqm Per box" required="" class="form-control" required="" value="'.$sqm_per_box.'" readonly '.$disable.'  />
								<input type="hidden" id="pcs_per_box" name="pcs_per_box" value="'.$pcs_per_box.'" readonly/>
								<input type="hidden" id="feet_per_box" name="feet_per_box" value="'.$feet_per_box.'" readonly/>
									 
						  </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Empty Pallet Weight</lable>
							<input id="pallet_weight" type="text" name="pallet_weight" placeholder="Pallet Weight" required="" class="form-control" value="'.$pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)"  onkeyup="cal_all_total()"  onblur="cal_all_total()" '.$disable.'  />
				    </div>                     
				    </div>
					<div class="col-md-12">
					
				<table class="table table-bordered table-hover rate_table"  >
				<tr>
					<td width="10%">Design</td>
					<td width="9%">Finish</td>
					<td width="7%">Client Name </td>
					<td width="7%">Barcode </td>
					<td width="7%">Rate </td>
					<td width="9%">Rate In</td>
					<td width="7%" class="pallet_calcution multi_pallet_calcution">No Of Pallet </td>
					 <td width="7%">Boxes</td>
					 <td width="7%"> SQM</td>
					<td width="10%">Amount</td>
					<td width="2%">Add</td>
				</tr>';
				if(strtolower($mode)=="edit")
				{
						$getpacking_detail = $this->quotation->getproductrate($estimate_trn_id);
						$str .= '<input type="hidden" id="row_cont" name="row_cont"  value="'.count($getpacking_detail).'"/>';
						$cls = count($getpacking_detail);
						$no =1;
						foreach($getpacking_detail as $row)
						{
							$product_rate_per_selected1  =  ($row->per == "SQM")?"selected='selected'":"";
							$product_rate_per_selected2  =  ($row->per == "BOX")?"selected='selected'":"";
							$product_rate_per_selected3  =  ($row->per == "SQF")?"selected='selected'":"";
							$product_rate_per_selected4  =  ($row->per == "PCS")?"selected='selected'":"";
							 
						 	$str .='<tr class="appendtr'.$no.'">
										<td class=""  >
											<select '.$disable.'   class="select1" id="design_id'.$no.'" name="design_id[]" class="select2" onchange="load_finish(this.value,'.$no.')" style="width:150px">';
											$str .= '<option value="">Select Design Name</option>
													<option value="">Add New Design</option>
											';
											foreach($design_data as $design_row)
											{
												$sel = '';
											 	if($design_row->packing_model_id == $row->design_id)
												{
													$sel = 'selected="selected"';
												}
												$str .= '<option '.$sel.' value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
											}
									$str .= '</select>
										</td>
										<td class="">
											<select '.$disable.'   class="select1" id="finish_id'.$no.'" name="finish_id[]"  onchange="load_rate('.$no.')"  style="width:150px">';
											$fetchresult = $this->pinv->fetchfinish_detail($row->design_id);
													foreach($fetchresult as $finish_row)
													{
														$sel = '';
													if($finish_row->finish_id == $row->finish_id)
													{
														$sel = 'selected="selected"';
													}
														$str .= '<option '.$sel.' value="'.$finish_row->finish_id.'">'.$finish_row->finish_name.'</option>';
													}											
										$str .= '	</select>
										</td>
										<td class="">
											<input '.$disable.'   type="text" name="client_name[]" id="client_name'.$no.'" class="form-control"   value="'.$row->client_name.'" />
										</td>
										<td class="">
											<input '.$disable.'   type="text" name="barcode_no[]" id="barcode_no'.$no.'" class="form-control"  value="'.$row->barcode_no.'" />
										</td>
									 	<td class="">
											<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.number_format($row->product_rate,2).'" />
										</td>
										<td class="">
											 <select  name="product_rate_per[]" id="product_rate_per'.$no.'" class="form-control" onchange="cal_product_trn('.$no.')">
													<option '.$product_rate_per_selected1.' value="SQM">SQM</option>
													<option '.$product_rate_per_selected2.' value="BOX">BOX</option>
													<option '.$product_rate_per_selected3.' value="SQF">SQF</option>
													<option '.$product_rate_per_selected4.' value="PCS">PCS</option>
											 </select>
										</td>
										<td class="pallet_calcution multi_pallet_calcution">
											<input type="text" '.$disable.'   name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution"  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_pallet.'"/>
											<span class="multi_pallet_calcution"> 
												Big : <input '.$disable.'   type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_big_pallet.'" placeholder ="Big Pallet"/>
												Small : <input '.$disable.'   type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_small_pallet.'"  placeholder ="Small Pallet"/>
												</span>
										</td>
										 
										<td class="">
											<input type="text" '.$disable.'   name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control without_pallet_box"   value="'.$row->no_of_boxes.'" onkeypress="return isNumber(event)" onkeyup="cal_box_trn('.$no.')"   onblur="cal_box_trn('.$no.')" />
										</td>
										 
										<td class="">
											<input '.$disable.'   type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value="'.$row->no_of_sqm.'"/>
										</td>
										<td class="">
											<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly   value="'.$row->product_amt.'"/>
											<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" value="'.$row->packing_net_weight.'" />
											<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'"   value="'.$row->packing_gross_weight.'"/>
										</td>';
										 
											$str .= '<td class="">
													<button type="button" onclick="remove_row('.$no.')"  class="btn btn-danger">-</button>
											</td>';
										 
										 
									$str .='</tr>';
									$no++;
									$cls--;
						}
				}
				else
				{
				$str .='
				<input type="hidden" id="row_cont" name="row_cont"  value="1"/>
				<tr class="appendtr1">
					<td class="">
						<select class="select1" id="design_id1" name="design_id[]" class="select2" onchange="load_finish(this.value,1)" style="width:150px">';
						$str .=    '<option value="">Select Design Name</option>
									<option value="">Add New Design</option> ';
						foreach($fetchresult as $design_row)
						{
							$str .= '<option '.$sel.' value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
						}
					$str .= '</select>
						</td>
						<td class="">
							<select style="width:100px" class="select1" id="finish_id1" name="finish_id[]" onchange="load_rate(1)">
							</select>
						</td>
						<td class="">
							<input type="text" name="client_name[]" id="client_name1" class="form-control"    />
						</td>
						<td class="">
							<input type="text" name="barcode_no[]" id="barcode_no1" class="form-control"   />
						</td>
					 	<td class="">
							<input type="text" name="product_rate[]" id="product_rate1" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)" />
						</td>
						<td class="">
							 <select  name="product_rate_per[]" id="product_rate_per1" class="form-control" onchange="cal_product_trn(1)">
									<option value="SQM">SQM</option>
									<option value="BOX">BOX</option>
									<option value="SQF">SQF</option>
									<option value="PCS">PCS</option>
							 </select>
						</td>
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" name="no_of_pallet[]" id="no_of_pallet1" class="form-control pallet_calcution" value="'.$no_of_pallet.'" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)"/>
							<span class="multi_pallet_calcution"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet1" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_big_pallet.'" placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet1" class="form-control "  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_small_pallet.'"  placeholder ="Small Pallet"/>
							</span>
						</td>
						 
						<td class="">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes1" class="form-control without_pallet_box"   value="'.$total_box_per_container.'" onkeyup="cal_box_trn(1)"   onblur="cal_box_trn(1)"  />
						</td>
						 
						<td class="">
							<input type="text" name="no_of_sqm[]" id="no_of_sqm1" class="form-control" readonly  value="'.$sqm_per_container.'"/>
						</td>
						<td class="">
							<input type="text" name="product_amt[]" id="product_amt1" class="form-control" readonly />
							<input type="hidden" name="packing_net_weight[]" id="packing_net_weight1" />
							<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight1"  />
						</td>
						<td class="">
							
						</td>
					</tr>';
				}	
				$str	.='<tr>
						<td colspan="6" style="text-align:right">
							Total
						</td>
						 
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" readonly name="total_no_of_pallet" id="total_no_of_pallet" class="form-control" />
						</td>
					 	<td class="">
							<input type="text" name="total_no_of_boxes" id="total_no_of_boxes" class="form-control" readonly />
						</td> 
						                         
						<td class="">                 
							<input type="text" name="total_no_of_sqm" id="total_no_of_sqm" class="form-control" readonly/>
						</td>                       
						<td class="">               
							<input type="text" name="total_product_amt" id="total_product_amt" class="form-control" readonly />
						</td>
						<td class="">
							 <button '.$disable1.'   type="button" onclick="add_row()" class="btn btn-info">+</button>
						</td>
					</tr>
			</table>
			</div> <div class="col-md-12"></div>	
					 
					 <div class="col-md-4 pallet_calcution multi_pallet_calcution">	
						 <div class="field-group">
							<lable><strong>Total Empty Pallet Weight</strong> : <span id="Pallet_Weight_html"></span> Kg</lable>
								<input type="hidden" id="total_pallet_weight" name="total_pallet_weight" value=""/>    
						</div> 
					</div>				
					<div class="col-md-4">	
					 <div class="field-group">
						<lable><strong>Net Weight</strong>   </lable>
							<input type="text"  id="total_net_weight" name="total_net_weight" value="" readonly/>    
						 Kg 
							  
						</div> 
					</div>
					<div class="col-md-4">	
					 <div class="field-group">
						<lable><strong>Gross Weight</strong> 
							<input type="text" readonly id="total_gross_weight" name="total_gross_weight" value=""/>  <span>Kg</span> </lable>
						 
						</div> 
					</div>
				  </div>
					<div class="col-md-4">	
					 <div class="field-group">
						<lable><strong>Sequence </strong> 
							<input type="text" id="sequeance" name="sequeance" value="'.$sequeance.'"/>    </lable>
						 
						</div> 
					</div>
				  </div> 
				  ';
		
		echo $str;
	}
	public function wall_design_data()
	{
		$id 		 = explode(" - ",$this->input->post('id'));
		$customer_id = $this->input->post('customer_id');
		$data 		 = $this->pinv->get_product_size($id[1],2,$customer_id);
		$fetchresult = $this->pinv->fetchdesign_detail($id[0]);
		$result		 = $data[0];
		$checked1 	 = "";
		$checked2 	 = "";
		$checked3 	 = "";
		$row = array();
		if($result->boxes_per_pallet>0)
		{
			$row['pallet_status']			= 1;
			$row['pallet_weight']			= $result->pallet_weight;
			$row['boxes_per_pallet'] 		= $result->boxes_per_pallet;
			$row['no_of_pallet'] 			= $result->total_pallent_container;
			$row['sqm_per_container'] 		= $result->sqm_per_container;
			$row['defualt_netweight'] 		= $result->pallet_net_weight_per_container;
			$row['defualt_grossweight'] 	= $result->pallet_gross_weight_per_container;
			$row['total_box_per_container'] = $result->box_per_container;
		}
		else if($result->total_boxes>0)
		{
			$row['pallet_status']			= 2;
			$row['total_boxes'] 			= $result->total_boxes;
			$row['sqm_per_container'] 		= $result->withoutpallet_sqm_per_container;
			$row['defualt_netweight'] 		= $result->withoutnet_weight_per_container;
			$row['defualt_grossweight'] 	= $result->withoutgross_weight_per_container;
			$row['total_box_per_container']	= $result->total_boxes;
		}
		else if($result->box_per_big_plt > 0 || $result->box_per_small_plt_new > 0)
		{
			$row['pallet_status']			= 3;
			$row['big_pallet_weight'] 		= $result->big_plat_weight;
			$row['small_pallet_weight'] 	= $result->small_plat_weight;
			$row['box_per_big_pallet'] 		= $result->box_per_big_plt;
			$row['box_per_small_pallet'] 	= $result->box_per_small_plt_new;
			$row['no_of_big_pallet'] 		= $result->no_big_plt_container_new;
		 	$row['no_of_small_pallet']		= $result->no_small_plt_container_new;
			$row['sqm_per_container'] 		= $result->multi_sqm_per_container;
			$row['total_box_per_container'] = $result->multi_box_per_container;
		}
		$row['design_data']	 = '<option value="">Select Design</option>';
		foreach($fetchresult as $design_row)
		{
			$row['design_data']	 .= ' <option value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
		}
		$row['weight_per_box']  = $result->weight_per_box;
		$row['weight_per_box']  = $result->weight_per_box;
		$row['weight_per_box']  = $result->weight_per_box;
		$row['sqm_per_box'] 	= $result->sqm_per_box;
		$row['pcs_per_box'] 	= $result->pcs_per_box;
		$row['feet_per_box'] 	= $result->feet_per_box;
		$row['box_design_id'] 	= $result->box_design_id;
		$row['pallet_type_id'] 	= $result->pallet_type_id;
		 
	 	echo json_encode($row);
	}
	public function add_wall_design_row()
	{
		 
		$no  		=  ($this->input->post('row_count') + 1);
		$allproduct = 	$this->pinv->allsizeproduct();
			$pallet_type			= $this->pinv->get_pallet_type();
		 	$box_design			= $this->pinv->get_box_design();
		 $str ='<tr class="last_row'.$no.'">
				<td class="text-center">
					<select id="product_id'.$no.'" name="product_id[]" onchange="wallload_data(this.value,'.$no.')" style="width:200px">
						<option value="">Select Product Name</option>';
						 	for($p=0;$p<count($allproduct);$p++)
							{
								$thickness = (!empty($allproduct[$p]->thickness))?" - ".$allproduct[$p]->thickness." MM":"";
							 
								$str .='<option value="'.$allproduct[$p]->product_id.' - '.$allproduct[$p]->product_size_id.'">'.$allproduct[$p]->size_type_mm.' ('.$allproduct[$p]->series_name.')'.$thickness.' - '.$allproduct[$p]->product_packing_name.' </option>';
							 
							}
							 
			$str .='</select>
				</td>
						<td>
							<label class="radio-inline">
								<input type="radio" name="pallet_status'.$no.'" id="pallet_status'.$no.'1" value="1" onclick="check_pallet_status(this.value)" checked />With   
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status'.$no.'" id="pallet_status'.$no.'2" value="2" onclick="check_pallet_status(this.value)"  />Without  
							</label> 
							<label class="radio-inline">
								<input type="radio" name="pallet_status'.$no.'" id="pallet_status'.$no.'3" value="3" onclick="check_pallet_status(this.value)"   />Multi 
							</label>
						</td>
						<td class="text-center">
							<select   id="walldesign_id'.$no.'" name="walldesign_id[]" class="select2" onchange="wallload_finish(this.value,'.$no.')" style="width:100%">
								 <option value="">Select Design  </option>
								 
							</select>
						</td>
						<td class="text-center">
							<select   id="wallfinish_id'.$no.'" name="wallfinish_id[]" class="select2" onchange="wallload_rate('.$no.')" style="width:100%"> 
								<option value="">Select Finish</option> 
							</select>
						</td>
						 <td style="text-align:center">
											<input type="text" name="client_name[]" id="client_name'.$no.'" class="form-control"  />
									</td>
									
								 	<td style="text-align:center">
											<input type="text" name="barcode_no[]" id="barcode_no'.$no.'" class="form-control"  />
									</td>
						<td class="text-center">
							<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_wallproduct_invoice('.$no.')"   onblur="cal_wallproduct_invoice('.$no.')" value="" />
						</td>
						<td class="">
							<select  name="product_rate_per[]" id="product_rate_per'.$no.'" class="form-control" onchange="cal_wallproduct_invoice('.$no.')">
									<option  value="SQM">SQM</option>
									<option  value="BOX">BOX</option>
									<option  value="SQF">SQF</option>
									<option  value="PCS">PCS</option>
							</select>
						</td>
						<td class="text-center">
								<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution'.$no.'" value="" onkeypress="return isNumber(event)" onkeyup="cal_wallproduct_invoice('.$no.')"  onblur="cal_wallproduct_invoice('.$no.')" />
								<span class="multi_pallet_calcution'.$no.'" style="display:none"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_wallproduct_invoice('.$no.')"   onkeyup="cal_wallproduct_invoice('.$no.')"  placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control "  onkeypress="return isNumber(event)" onkeyup="cal_wallproduct_invoice('.$no.')"   onblur="cal_wallproduct_invoice('.$no.')"  placeholder ="Small Pallet"/>
								 </span>
								  
						
						</td>
						<td class=" text-center">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control pallet_calcution'.$no.' multi_pallet_calcution'.$no.'" onchange="cal_wallbox_invoice('.$no.')" onkeyup="cal_wallbox_invoice('.$no.')"   value="" />
							<input type="text" name="only_no_of_boxes[]" id="only_no_of_boxes'.$no.'" class="form-control boxes_calculation'.$no.'" value="'.$total_box_per_container.'" onkeyup="cal_wallproduct_invoice('.$no.')"  onblur="cal_wallproduct_invoice('.$no.')"  style="display:none"/>
						 
						</td>
						 
						<td class="text-center">
							<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value=""/>
						</td>
						<td class="text-center">
							<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly />
					 	</td>
						<td class="text-center">
							<button type="button" onclick="remove_wall_row('.$no.')" class="btn btn-danger">-</button>
							<input type="hidden" name="weight_per_box[]" id="weight_per_box'.$no.'" />
							<input type="hidden" name="pallet_weight[]" id="pallet_weight'.$no.'" />
							<input type="hidden" name="big_pallet_weight[]" id="big_pallet_weight'.$no.'" />
							<input type="hidden" name="small_pallet_weight[]" id="small_pallet_weight'.$no.'" />
							<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet'.$no.'" />
							<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet'.$no.'" />
							<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet'.$no.'" />
							<input type="hidden" name="sqm_per_box[]" id="sqm_per_box'.$no.'" />
							<input type="hidden" name="pcs_per_box[]" id="pcs_per_box'.$no.'" />
							<input type="hidden" name="feet_per_box[]" id="feet_per_box'.$no.'" />
							<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" />
							<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'" />
							<input type="hidden" name="no[]" id="no'.$no.'" value="'.$no.'"/>
										
						</td>
					</tr>';
	  
		echo $str;
	}
	 	public function add_design_row()
	{
		$design_id 		=  $this->input->post('design_id');
		$finish_id 		=  $this->input->post('finish_id');
		$product_id		=  $this->input->post('product_id');
		$consigne_id	=  $this->input->post('consigne_id');
		$no 	   		=  ($this->input->post('no') + 1);
		$fetchresult 	= $this->pinv->fetchdesign_detail($product_id);
		$getbox_design	= $this->pinv->get_box_design();
		$getpallet_type	= $this->pinv->get_pallet_type();
		$data_product = $this->pinv->hsncproductsizedetail($product_id,2,$consigne_id);
			$box_design_id = $data_product[0]->box_design_id;
			 
			$pallet_type_id = $data_product[0]->pallet_type_id;
		$str .='<tr class="appendtr'.$no.'">
				<td >
					<select class="select1" id="design_id'.$no.'" name="design_id[]" class="select2" onchange="load_finish(this.value,'.$no.')">';
					$str .= '<option value="">Select Design Name</option>
								<option value="">Add New Design</option>';
					foreach($fetchresult as $design_row)
					{
						$str .= '<option value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
					}
				$str .= '</select>
						</td>
						<td class="">
							<select class="select1" id="finish_id'.$no.'" name="finish_id[]"  onchange="load_rate('.$no.')" style="width:100px"> 
							</select>
						</td>
						<td class="">
							<input type="text" name="client_name[]" id="client_name'.$no.'" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="barcode_no[]" id="barcode_no'.$no.'" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
						</td>
						<td class="">
							 <select  name="product_rate_per[]" id="product_rate_per'.$no.'" class="form-control" onchange="cal_product_trn(1)">
									<option value="SQM">SQM</option>
									<option value="BOX">BOX</option>
									<option value="SQF">SQF</option>
							 </select>
						</td>
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution" value="" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
							<span class="multi_pallet_calcution"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')"  placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control "  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')"  placeholder ="Small Pallet"/>
							</span>
						</td>
						 
						<td class="">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control without_pallet_box"  onblur="cal_box_trn('.$no.')"   onkeyup="cal_box_trn('.$no.')"  value="" />
						</td>
						 
						<td class="">
							<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value=""/>
						</td>
						<td class="">
							<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly />
							<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" />
							<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'"  />
						</td>
						<td class="">
							<button type="button" onclick="remove_row('.$no.')" class="btn btn-danger">-</button>
						</td>
					</tr>';
	  
		echo $str;
	}

	
}
