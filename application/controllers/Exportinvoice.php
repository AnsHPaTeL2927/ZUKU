<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Exportinvoice extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice','exportinvoice');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
	function add_invoice()
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$array 	= explode("-",$id);
				$exporter			= $this->exportinvoice->select_exporter();
				//$supplierdetail			= $this->exportinvoice->select_supplier_data();
			 	$selectinvoicetype 	= $this->exportinvoice->selectinvoicetype(2);
				$this->load->model('admin_company_detail');	
				$this->load->model('supplier_list_model');	
				$company 			= $this->admin_company_detail->s_select();
				$supplierdetail 			= $this->supplier_list_model->companydata();
				$this->load->model('admin_country_detail');	
				$data 				= $this->exportinvoice->get_all_performainvoice();
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 	$bank				= $this->exportinvoice->bank_detail($company[0]->bank_name);
				$consign			= $this->exportinvoice->select_consigner($data->consiger_id);
			$this->load->model('admin_currency_list');
			$this->load->model('admin_bank_detail','bd');
			
			$v = array( 
						'consign_detail'	=> $consign,
						'exporter_detail'	=> $exporter,
						'supplier_detail'	=> $supplierdetail,
						'bank'				=> $bank,
				 		'menu_data'			=> $menu_data,
						'mode'				=> 'Add',
						'invoicetype'		=> $selectinvoicetype,
						'company_detail'	=> $company,
						'countrydata'		=> $this->admin_country_detail->s_select(),
						'performa_data'		=> $data,
						'currencydata'		=> $this->admin_currency_list->getcurrencydata(),
						'termsdata'			=> $this->exportinvoice->gettermsdata(),
						'all_bank'		  	=> $this->bd->b_select(),
						'direct_invoice'	=> 1,
						'mutiple_status'	=> 1
				);
			$this->load->view('admin/exportinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function index($id,$supplier_id,$value)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$array 	= explode("-",$id);
			$exporter			= $this->exportinvoice->select_exporter();
			//$supplierdetail			= $this->exportinvoice->select_supplier_data();
			$selectinvoicetype 	= $this->exportinvoice->selectinvoicetype(2);
			$this->load->model('admin_company_detail');	
			$this->load->model('supplier_list_model');	
			$company 			= $this->admin_company_detail->s_select();
			$supplierdetail 			= $this->supplier_list_model->companydata();
			$this->load->model('admin_country_detail');	
			$data				= $this->exportinvoice->select_invoice_data($id,$array);
			$consign_other		= $this->exportinvoice->other_consigner($data->consigne_id);
	 		$pastinvoicedata 	= $this->exportinvoice->getpastexportinvoice(0,$id);
			$bank				= $this->exportinvoice->bank_detail($company[0]->bank_name);
	 		$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);
			$supplier_array 	= explode("-",$supplier_id);		
			$containerdetail	 = $this->exportinvoice->product_set_data($id,$supplier_array,'',$value);
			  $consign			= $this->exportinvoice->select_consigner($data->consiger_id);
				  
				$this->load->model('admin_currency_list');	
			$v = array( 
						'supplier_detail'	=> $supplierdetail,
						'consign_detail'	=> $consign,
						'invoice_html_data'	=> $html_data,
						'packing_html_data'	=> $packing_html_data,
						'annexure_html_data'=> $annexure_html_data,
						'exporter_detail'	=> $exporter,
						'containerdetail'	=> $containerdetail,
						'menu_data'			=> $menu_data,
						'mode'				=> 'Add',
						'invoicetype'		=> $selectinvoicetype,
						'company_detail'	=> $company,
						'countrydata'		=> $this->admin_country_detail->s_select(),
						'invoicedata'		=> $data,
						'consignother'		=> $consign_other,
						'bank'				=> $bank,
						'pastinvoicedata'	=> $pastinvoicedata,
						'supplier_id'		=> $supplier_id,
						'container_status'	=> $value,
						'currencydata'		=> $this->admin_currency_list->getcurrencydata(),
						'termsdata'			=> $this->exportinvoice->gettermsdata(),
						'direct_invoice'	=> 2,
						'mutiple_status'	=> 1
				);
			$this->load->view('admin/exportinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function mutiplecopy($id,$supplier_id,$value)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
			$array 				= explode("-",$id);
			$supplier_array 	= explode("-",$supplier_id);
			$lastid 			= end($array);
			$exporter			= $this->exportinvoice->select_exporter();
			 
			$selectinvoicetype 	= $this->exportinvoice->selectinvoicetype(2);
			$this->load->model('admin_company_detail');	
			$company 			= $this->admin_company_detail->s_select();
			$this->load->model('admin_country_detail');	
			$data				= $this->exportinvoice->select_invoice_data($lastid,$array);
			$consign_other		= $this->exportinvoice->other_consigner($data->consigne_id);
			$bank				= $this->exportinvoice->bank_detail($company[0]->bank_name);
			$this->load->model('admin_currency_list');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$containerdetail	= $this->exportinvoice->product_set_data($lastid,$supplier_array,$array,$value);
			$consign			= $this->exportinvoice->select_consigner($data->consiger_id);	 
				$v = array( 
						'consign_detail'		=> $consign,
						'menu_data'				=> $menu_data,
					 	'exporter_detail'		=> $exporter,
						'containerdetail'		=> $containerdetail,
						'mode'					=> 'Add',
						'invoicetype'			=> $selectinvoicetype,
						'company_detail'		=> $company,
						'countrydata'			=> $this->admin_country_detail->s_select(),
						'invoicedata'			=> $data,
						'consignother'			=> $consign_other,
						'bank'					=> $bank,
						'container_status'		=> $value,
						'currencydata'			=> $this->admin_currency_list->getcurrencydata(),
						'termsdata'				=> $this->exportinvoice->gettermsdata(),
						'supplier_id'			=> $supplier_id,
						'direct_invoice'		=> 2,
						'mutiple_status'		=> 2,
						"performa_invoice_id"	=> $id
				);
			$this->load->view('admin/exportinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function container_details($export_id)
	{
		
		
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$this->load->model('admin_exportinvoice_product','export');
			$company		=	$this->admin_company_detail->s_select();
			$data			= 	$this->exportinvoice->exportinvoice_data($export_id);
			$custdata		= 	$this->exportinvoice->exportinvoice_cust_data($export_id);
			$set_container	= 	$this->export->getinvoiceproductdata($export_id);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'invoicecustdata' 	=>	$custdata,
					'set_container'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->export->allproductsize(),
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
		
			
			$this->load->view('admin/export_container_detail',$v);
		}
		else
		{
			redirect(base_url().'');
		}
			
	}
	public function deleteloading()
	{
	 	$export_loading_trn_id 	= $this->input->post('export_loading_trn_id');
	 	$export_packing_id		= $this->input->post('export_packing_id');
	 	$exportproduct_trn_id	= $this->input->post('exportproduct_trn_id');
		
		$deleteid=$this->exportinvoice->delete_loadingtrn($export_loading_trn_id,$export_packing_id,$exportproduct_trn_id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function delete_pallet()
	{
	 	$export_loading_trn_id 	= $this->input->post('export_loading_trn_id');
	 	$export_make_pallet_no 	= $this->input->post('export_make_pallet_no');
	 	 
		
		$deleteid=$this->exportinvoice->delete_pallet($export_loading_trn_id,$export_make_pallet_no);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function delete_design()
	{
	 	$export_loading_trn_id 	= $this->input->post('export_loading_trn_id');
	 	$status 				= $this->input->post('status');
	 	$con_entry 				= $this->input->post('con_entry');
	 	$export_invoice_id 	 	= $this->input->post('export_invoice_id');
	 	$data = array(
			"after_invoice_delete" => $status
		);  
		
		$deleteid=$this->exportinvoice->delete_design($export_loading_trn_id,$data);
		 
			$update_weight = $this->exportinvoice->update_weight_detail($export_invoice_id,$export_loading_trn_id,$con_entry,$status);
		 
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function editloading()
	{
		 $this->load->model('admin_exportinvoice_product','export');
		 $con_entry				= $this->input->post('con_entry');
		 $export_invoice_id		= $this->input->post('export_invoice_id');
		
		$get_data=$this->export->edit_loadingtrn($con_entry,$export_invoice_id);
		$str = '
			<div class="col-md-12">
			<table class="table table-bordered" width="100%">
					<tr>
						<td class="text-center" width="5%">  </td>
						<td class="text-center" width="10%">Product Name</td>
						<td class="text-center" width="10%">Design Name</td>
						<td class="text-center" width="10%">Finish Name</td>
						<td class="text-center" width="9%">Pallet</td>
						<td class="text-center" width="9%">Boxes</td>
						<td class="text-center" width="9%">SQM</td>
						<td class="text-center" width="10%">Batch No</td>
						<td class="text-center" width="10%">Shade No</td>
						<td class="text-center" width="9%">Product Rate</td>
						<td class="text-center" width="9%">Product Amt</td>
					</tr>';
					$row_array = array();
					$make_once_pallet	=  array();
					$export_loading_trn_id = 0;
					$no	= 1;
					$no_of_design	= 0;
		foreach($get_data as $packing)
		{
			 
			$row_array['container_no'] 		= $packing->container_no;
			$row_array['container_size'] 	= $packing->container_size;
			$row_array['seal_no'] 			= $packing->seal_no;
			$row_array['rfidseal_no'] 		= $packing->self_seal_no;
			$row_array['booking_no'] 		= $packing->booking_no;
			$row_array['lr_no'] 			= $packing->lr_no;
			$row_array['truck_no'] 			= $packing->truck_no;
			$row_array['mobile_no'] 		= $packing->mobile_no;
			$row_array['remark'] 			= $packing->remark;
			$row_array['con_entry'] 		= $packing->con_entry;
			$row_array['tare_weight'] 		= $packing->tare_weight;
		 	$row_array['container'] 		= $packing->container;
				 $count = explode(",",$packing->export_make_pallet_no);
				 $export_rowspan = count($count);
				 $color = ($packing->after_invoice_delete == 2)?'#ddd':'';
				 $disableddelete = ($packing->after_invoice_delete == 2)?'readonly':'';
			$str .= '  <tr style="background:'.$color.'">
						<td class="text-center">';
					  		$pallet_ids = explode(",",$packing->pallet_row);
					 		$checked 	= ''; 
							$readonly 	= 'readonly';
							 
							if(in_array($packing->pi_loading_plan_id,$pallet_ids) && !empty($packing->pi_loading_plan_id))
							{
								$checked = 'checked';
								$readonly = 'disabled';
								array_push($make_once_pallet,1);
								$str .= '<input type="hidden" name="already_export_loading_trn_id[]" id="already_export_loading_trn_id'.$packing->pi_loading_plan_id.'" value="1"  />';
							}
							else if($packing->make_pallet_no > 0 && $packing->origanal_pallet < 1)
							{ 
								$pi_loading_plan_id = ($no==1)?$packing->pi_loading_plan_id:$pi_loading_plan_id;
								$str .= '<input type="hidden" name="already_export_loading_trn_id[]" id="0'.$packing->pi_loading_plan_id.'" value="2"  />';
								 
									array_push($make_once_pallet,2);
								 
								$no++;
							}
							 
							if(empty($packing->pi_loading_plan_id))
							{
								
								if($packing->export_half_pallet > 0)
								{ 
									$str .= ' ';
								}
								else if($packing->origanal_pallet < 1)
								{
									$str .= ' <input type="checkbox" name="make_pallet[]" id="make_pallet'.$packing->export_loading_trn_id.'" value="'.$packing->export_loading_trn_id.'" '.$checked.' '.$readonly.' style="width: 30px;height: 30px;" />  ';
									$str .= ' <a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Delete Extra Product" onclick="delete_loading('.$packing->export_loading_trn_id.','.$packing->con_entry.','.$packing->exportproduct_trn_id.','.$packing->export_packing_id.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>';	
									array_push($make_once_pallet,2);		
								}
								else
								{
									if($packing->after_invoice_delete == 2)
									{
										$str .= ' <a class="tooltips btn" data-toggle="tooltip" data-title="Recover Design" onclick="recover_design('.$packing->export_loading_trn_id.','.$packing->con_entry.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
									}
									else
									{
										$str .= ' <a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Delete Design" onclick="delete_design('.$packing->export_loading_trn_id.','.$packing->con_entry.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
										$no_of_design 	  += 1;
									}
								}
							}
							else
							{
								if($packing->after_invoice_delete == 2)
									{
										$str .= ' <a class="tooltips btn" data-toggle="tooltip" data-title="Recover Design" onclick="recover_design('.$packing->export_loading_trn_id.','.$packing->con_entry.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
									}
									else
									{
										$str .= ' <a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Delete Design" onclick="delete_design('.$packing->export_loading_trn_id.','.$packing->con_entry.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>';
										$no_of_design 	  += 1;
									}

							}
							
							 
				 	$str .= '
						</td>';
						
						if($packing->product_id == 0)
						{
							$str .= '<td class="text-center" colspan="3">'.$packing->description_goods.' </td>';
						}
						else
						{
							
							$str .= '<td class="text-center">'.$packing->size_type_mm.'('.$packing->series_name.')</td>
									 <td class="text-center">'.$packing->model_name.'</td>
									 <td class="text-center">'.$packing->finish_name.'</td>';
						}
						 
						
						if(!empty($packing->pallet_ids)  && $packing->make_pallet_no > 0)
						{
							 
							$pallet_ids = explode(",",$packing->pallet_row);
							$str .= '<td class="text-center" rowspan="'.count($pallet_ids).'">
											'.$packing->make_pallet_no.'    
									</td>';	
						 
						}
						else if(!empty($packing->export_make_pallet_no))
						{
							
							$str .= '<td class="text-center" rowspan="'.$export_rowspan.'">
											'.$packing->export_half_pallet.'   <a href="javascript:;" onclick="delete_pallet(&quot;'.$packing->export_make_pallet_no.'&quot;,'.$packing->export_loading_trn_id.','.$packing->con_entry.')"  >Delete Pallet</a>
									</td>';	
						}
						else if(empty($packing->pallet_row) && empty($packing->export_half_pallet))
						{
						 	if($packing->origanal_pallet>0)
							{
							
								$str .= '<td class="text-center">
										
										<input type="text" class="form-control" name="no_of_pallet[]" id="no_of_pallet'.$packing->export_packing_id.'" value="'.$packing->origanal_pallet.'" onblur="cal_product_invoice('.$packing->export_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->export_packing_id.',2)" '.$disableddelete.' />
										
										<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->export_packing_id.'" value="0"   />
									
										<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->export_packing_id.'" value="0"  />
									</td>';
							}
							else if($packing->orginal_no_of_big_pallet>0 || $packing->orginal_no_of_small_pallet>0)
							{
								$str .= '<td class="text-center">
											<input type="hidden"  name="no_of_pallet[]" id="no_of_pallet'.$packing->export_packing_id.'" value="0" />
											
											<input type="text" class="form-control" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->export_packing_id.'" value="'.$packing->orginal_no_of_big_pallet.'" onblur="cal_product_invoice('.$packing->export_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->export_packing_id.',2)" '.$disableddelete.' />
											<br>
											
											<input type="text" class="form-control" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->export_packing_id.'" value="'.$packing->orginal_no_of_small_pallet.'" onblur="cal_product_invoice('.$packing->export_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->export_packing_id.',2)" '.$disableddelete.'/>
										</td>';
							}
							else 
							 {
								$str .= '<td class="text-center">
									
											<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->export_packing_id.'" value="0" />
											
											<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->export_packing_id.'" value="0"   />
											 
											<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->export_packing_id.'" value="0" />
										</td>'; 
								 
							 }
						}
						$no_of_boxes = $packing->origanal_boxes;
					 	$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						 
						if($no_of_boxes > 0)
						{	
						$str .= '<td class="text-center">
									<input type="text" class="form-control" name="no_of_boxes[]" id="no_of_boxes'.$packing->export_packing_id.'" value="'.$packing->origanal_boxes.'" onblur="cal_box_invoice('.$packing->export_packing_id.',1)" '.$disableddelete.' onkeyup="cal_box_invoice('.$packing->export_packing_id.',1)" />
								</td>';
						}
						else
						{
							$str .= '<td class="text-center">
									<input type="hidden" name="no_of_boxes[]" id="no_of_boxes'.$packing->export_packing_id.'" value="0"  />
								</td>
								';
						}							
						 
						$str .= '
							<td class="text-center">
									
									<span id="sqmhtml'.$packing->export_packing_id.'">'.$no_of_sqm.'</span>
								
									<input type="hidden" name="no_of_sqm[]" id="no_of_sqm'.$packing->export_packing_id.'" value="'.$no_of_sqm.'" />
								
								 </td>
								 
								 <td class="text-center">
									<input type="text" name="batch_no[]" id="batch_no'.$packing->export_packing_id.'" value="'.$packing->batch_no.'" class="form-control" '.$disableddelete.'/>
								</td>
								 <td class="text-center"> 
									<input type="text" name="shade_no[]" id="shade_no'.$packing->export_packing_id.'" value="'.$packing->shade_no.'" class="form-control" '.$disableddelete.'/>
								</td>
								 <td class="text-center"> 
									<input type="text" name="product_rate[]" id="product_rate'.$packing->export_packing_id.'" value="'.$packing->product_rate.'" class="form-control" onblur="cal_box_invoice('.$packing->export_packing_id.',1)"  onkeyup="cal_box_invoice('.$packing->export_packing_id.',1)" '.$disableddelete.' />
									 
								</td>
								 <td class="text-center"> 
									<span id="product_amt_html'.$packing->export_packing_id.'">'.$packing->product_amt.'</span>
								
									<input type="hidden" name="product_amt[]" id="product_amt'.$packing->export_packing_id.'" value="'.$packing->product_amt.'" />
								</td>
								 <input type="hidden" name="pallet_status[]" id="pallet_status'.$packing->export_packing_id.'" value="'.$packing->pallet_status.'" />
								 <input type="hidden" name="sqm_per_box[]" id="sqm_per_box'.$packing->export_packing_id.'" value="'.$packing->sqm_per_box.'" />
							 
								 <input type="hidden" name="weight_per_box[]" id="weight_per_box'.$packing->performa_packing_id.'" value="'.$packing->weight_per_box.'" />
							
								<input type="hidden" name="pallet_weight[]" id="pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->pallet_weight.'" />
								
								<input type="hidden" name="big_pallet_weight[]" id="big_pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->big_pallet_weight.'" />
								
								<input type="hidden" name="small_pallet_weight[]" id="small_pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->small_pallet_weight.'" />
							 
							 
								 <input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet'.$packing->export_packing_id.'" value="'.$packing->boxes_per_pallet.'" />
								 <input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet'.$packing->export_packing_id.'" value="'.$packing->box_per_big_pallet.'" />
								 <input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet'.$packing->export_packing_id.'" value="'.$packing->box_per_small_pallet.'" />
								 <input type="hidden" name="export_packing_id[]" id="export_packing_id'.$packing->export_packing_id.'" value="'.$packing->export_packing_id.'" />
								 <input type="hidden" name="exportproduct_trn_id[]" id="exportproduct_trn_id'.$packing->export_packing_id.'" value="'.$packing->performa_trn_id.'" />
								 <input type="hidden" name="product_id[]" id="product_id'.$packing->export_packing_id.'" value="'.$packing->product_id.'" />
								  
								 <input type="hidden" name="cont_no[]" id="cont_no'.$packing->export_packing_id.'" value="'.$packing->container_no.'" />
								 <input type="hidden" name="con_entry[]" id="con_entry'.$packing->export_packing_id.'" value="'.$packing->con_entry.'" />
								 <input type="hidden" name="container_size[]" id="container_size'.$packing->export_packing_id.'" value="'.$packing->container_size.'" />
								 <input type="hidden" name="export_invoice_id[]" id="export_invoice_id'.$packing->export_packing_id.'" value="'.$packing->export_invoice_id.'" />
								 <input type="hidden" name="export_loading_trn_id[]" id="export_loading_trn_id'.$packing->export_packing_id.'" value="'.$packing->export_loading_trn_id.'" />
						</tr>';	
						$supplier_id  = $packing->supplier_id;
						$container_no = $packing->container_no;
						$seal_no 	  = $packing->seal_no;
						$rfidseal_no  = $packing->self_seal_no;
						$booking_no   = $packing->booking_no;
						$lr_no 		  = $packing->lr_no;
						$truck_no	  = $packing->truck_no;
						$mobile_no	  = $packing->mobile_no;
						$remark 	  = $packing->remark;
						
				 
		}
		 
		if(in_array(2,$make_once_pallet))
		{
		 $str .= '<tr>
				<td colspan="2">
					 <span class="col-md-6"> No Of Pallet :</span>
					 <div class="col-md-6">
					 <input type="text" name="make_pallet_no" id="make_pallet_no" placeholder="No Of Pallet" value="1" class="form-control " />
					 </div>
					 <br>
					 <br>
					 <button type="button" onclick="make_pallet('.$con_entry.','.$export_invoice_id.')" class="btn btn-primary" >Make Pallet</button>
				</td>
		 </tr>';
		}
		$str .= ' </table>
		
			<input type="hidden" name="container_no" id="container_no" value="'.$container_no.'" />
			<input type="hidden" name="seal_no" id="seal_no" value="'.$seal_no.'" />
			<input type="hidden" name="rfidseal_no" id="rfidseal_no" value="'.$rfidseal_no.'" />
			<input type="hidden" name="booking_no" id="booking_no" value="'.$booking_no.'" />
			<input type="hidden" name="lr_no" id="lr_no" value="'.$lr_no.'" />
			<input type="hidden" name="truck_no" id="truck_no" value="'.$truck_no.'" />
			<input type="hidden" name="mobile_no" id="mobile_no" value="'.$mobile_no.'" />
			<input type="hidden" name="remark" id="remark" value="'.$remark.'" />
			<input type="hidden" name="no_of_design" id="no_of_design" value="'.$no_of_design.'" />
		</div>
		';
				
				$row_array['html'] = $str;
		echo json_encode($row_array);
	}
 	public function make_pallet()
	{
		$export_loading_trn_id		= $this->input->post('export_loading_trn_id');
		$exportloading_trn_id		= array($this->input->post('exportloading_trn_id'));
	 	$make_pallet_no				= $this->input->post('make_pallet_no');
		$data = array(
			"export_make_pallet_no" => implode(",",$export_loading_trn_id),
			"export_half_pallet" 	=>	$make_pallet_no,
			"origanal_pallet" 		=>	0,
			"orginal_no_of_big_pallet" 		=>	0,
			"orginal_no_of_small_pallet" 		=>	0
		);
		
		$data1 = array(
		 	"export_half_pallet" 	=>	$make_pallet_no,
			"origanal_pallet" 		=>	0,
			"orginal_no_of_big_pallet" 		=>	0,
			"orginal_no_of_small_pallet" 		=>	0
		);
		 
		
		$deleteid=$this->exportinvoice->update_make_cointainer($data,$exportloading_trn_id);
		$deleteid=$this->exportinvoice->update_make_cointainer($data1,$export_loading_trn_id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function manage()
	{
	 	$data = array(
			'performa_invoice_id' 		=> ($this->input->post('performa_invoice_id')),
			'igst_status' 				=> $this->input->post('igst_status'),
			'exporter_detail' 			=> nl2br($this->input->post('exporter_detail')),
			'export_invoice_no' 		=> $this->input->post('export_invoice_no'),
			'invoice_date' 				=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
			'eta_date' 					=> date('Y-m-d',strtotime($this->input->post('eta_date'))),
			'export_ref_no' 			=> $this->input->post('export_ref_no'),
			'performa_date' 			=> $this->input->post('date'),
			'export_buy_order_no' 		=>  nl2br($this->input->post('export_buy_order_no')),
			'e_email' 					=> $this->input->post('e_email'),
			'e_mobile' 					=> $this->input->post('e_mobile'),
			'e_gstin' 					=> $this->input->post('e_gstin'),
			'exporter_pan' 				=> nl2br($this->input->post('exporter_pan')),
			'exporter_iec' 				=> $this->input->post('exporter_iec'),
			'consiger_id' 				=> $this->input->post('consiger_id'),
			'notify_id' 				=> $this->input->post('notify_id'),
			'consign_address' 			=> nl2br($this->input->post('consign_address')),
			'invoice_currency_id' 		=> ($this->input->post('invoice_currency_id')),
			'buyer_other_consign' 		=> nl2br($this->input->post('buyer_other_consign')),
			'consignee_for_famigation' 	=> nl2br($this->input->post('consignee_for_famigation')),
			'containee_other_famigation'=> nl2br($this->input->post('containee_other_famigation')),
			'lc_no'	 					=> $this->input->post('lc_no'),
			'idf_no'	 				=> $this->input->post('idf_no'),
			'export_house'	 			=> $this->input->post('export_house'),
			'contract'	 				=> $this->input->post('contract'),
			'pre_carriage_by'	 		=> $this->input->post('pre_carriage_by'),
			'place_of_receipt' 			=> $this->input->post('place_of_receipt'),
			'country_origin_goods' 		=> $this->input->post('country_origin_goods'),
			'country_final_destination' => $this->input->post('country_final_destination'),
			'bank_detail' 				=> nl2br($this->input->post('bank_detail')),
			'flight_name_no' 			=> $this->input->post('flight_name_no'),
			'port_of_loading' 			=> $this->input->post('port_of_loading'),
			'port_of_discharge' 		=> $this->input->post('port_of_discharge'),
			'final_destination' 		=> $this->input->post('final_destination'),
			'district_of_origin' 		=> $this->input->post('district_of_origin'),
			'state_of_origin' 			=> $this->input->post('state_of_origin'),
			'payment_terms' 			=> nl2br($this->input->post('payment_terms')),
			'container_details' 		=> $this->input->post('container_details'),
			'container_size' 			=> $this->input->post('container_size'),
			'terms_id' 					=> $this->input->post('terms_id'),
			'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
			'calculation_operator' 		=> $this->input->post('calculation_operator'),
			'certification_charge' 		=> $this->input->post('certification_charge'),
			'insurance_charge' 			=> $this->input->post('insurance_charge'),
			'seafright_charge' 			=> $this->input->post('seafright_charge'),
			'seafright_action' 			=> $this->input->post('seafright_action'),
			'extra_calc_name' 			=> $this->input->post('extra_calc_name'),
			'extra_calc_amt' 			=> $this->input->post('extra_calc_amt'),
			'extra_calc_opt' 			=> $this->input->post('extra_calc_opt'),
			'bank_charge' 				=> $this->input->post('bank_charge'),
			'courier_charge' 			=> $this->input->post('courier_charge'),
			'discount' 					=> $this->input->post('discount'),
			'grand_total' 				=> $this->input->post('grand_total'),
			'mutiple_status' 			=> $this->input->post('mutiple_status'),
			'container_twenty'			=> $this->input->post('container_twenty'),
			'container_forty' 			=> $this->input->post('container_forty'),
			'supplier_id' 				=> $this->input->post('supplier_id'),
			'direct_invoice' 			=> $this->input->post('direct_invoice'),
			'bank_id' 					=> $this->input->post('bank_id'),
			'supplier_other_company' 					=> $this->input->post('supplier_other_company'),
			'container_status' 		 	=> $this->input->post('container_status'),
			'other_reference' 		 	=> $this->input->post('other_reference'),
			'advance_payment_id'		=> $this->input->post('payment_id'),
			'status' 					=> 0
			);
			$row['res'] = 0;
			if(strtolower($this->input->post('mode'))=="add")
			{				
				$data['step']  = 1;
				$data['cdate'] = date('Y-m-d H:i:s');
				$data['mdate'] = date('Y-m-d H:i:s');
				$rdata = $this->exportinvoice->invoice_firststep($data);
			 	if($rdata)
				{	
					$no_of_export = ($this->input->post('no_of_export')+1);
					$performa_invoice_id_array = explode("-",$this->input->post('performa_invoice_id'));
					foreach($performa_invoice_id_array as $pid)
					{
						$updateperformainvoice = $this->exportinvoice->update_performa($pid,$no_of_export);
					}
					$update = $this->exportinvoice->update_invoicenumber(2,$this->input->post('invoice_series'));
					$row['res'] = 1;
					$row['invoiceid'] = $rdata;
				}
			}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				$data['mdate'] 	= date('Y-m-d H:i:s');
				$id 			= $this->input->post('export_invoice_id');
				$rs 			= $this->exportinvoice->exportinvoice_update($data,$id);
				$htmldetele		= $this->exportinvoice->exportinvoice_html_delete($id);
				if($rs)
				{	
					$row['res'] = 3;
					$row['invoiceid'] = $id;
				}

			}
			 
			if(!empty($this->input->post('payment_id')))
			{
				$update_payment  = $this->exportinvoice->updatepayment($this->input->post('payment_id'),$id);
			}
		echo json_encode($row);

	}
	public function export_edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_bank_detail','bd');
			 
			$this->load->model('admin_company_detail');
			$this->load->model('admin_country_detail');			
			$this->load->model('supplier_list_model');	
				$supplierdetail 			= $this->supplier_list_model->companydata();
			$company = $this->admin_company_detail->s_select();
			$data= $this->exportinvoice->exportinvoice_data($id);
			$consign_other=$this->exportinvoice->other_consigner($data->consiger_id);
			//$datap= $this->exportinvoice->exportinvoice_data($id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$exporter			= $this->exportinvoice->select_exporter();
		 	 $this->load->model('admin_currency_list');
			$pastinvoicedata = $this->exportinvoice->getpastexportinvoice($id,$data->performa_invoice_id);  
			$consign			= $this->exportinvoice->select_consigner($data->consiger_id);
			$v = array( 
					'supplier_detail'	=> $supplierdetail,
					'consign_detail'	=> $consign,
					'mode'				=> 'Edit',
					'exporter_detail'	=> $exporter,
					'company_detail'	=> $company,
					'menu_data'			=> $menu_data,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
				//	'product_data'		=>$datap,
					"consignother"		=> $consign_other,
					"pastinvoicedata"	=> $pastinvoicedata,
					"currencydata"		=> $this->admin_currency_list->getcurrencydata(),
					'termsdata'			=> $this->exportinvoice->gettermsdata(),
					'all_bank'		  	=> $this->bd->b_select(),
					'direct_invoice'	=> $data->direct_invoice
				);
			$this->load->view('admin/exportinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function add_product()
	{
		$id1= $this->input->post('einvoice_id');
		
		 $this->load->model('admin_exportinvoice_product','export');
			$description_goodsarray = $this->export->hsncproductsizedetail($this->input->post('product_id'),2);
			$thickness = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
			  $description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
			   $pallet_status = 2;
			   if($this->input->post('no_of_pallet') > 0)
			   {
				   $pallet_status = 1;
			   }
			   else if($this->input->post('no_of_big_pallet') > 0 || $this->input->post('no_of_small_pallet') > 0)
			   {
				    $pallet_status = 3;
			   }
			  
			$data = array(
				'export_invoice_id'		=> $this->input->post('einvoice_id'),
				'product_id' 			=> $this->input->post('product_id'),
				'product_size_id' 	 	=> $this->input->post('packing_id'),
				'performa_trn_id' 		=> 0,
				'product_container' 	=> 0,
				'description_goods' 	=> $description,
				'pallet_status' 		=> $pallet_status,
				'weight_per_box' 		=> $this->input->post('weight_per_box'),
				'pallet_weight'	 		=> $this->input->post('pallet_weight'),
				'big_pallet_weight'	 	=> $this->input->post('big_pallet_weight'),
				'small_pallet_weight'	=> $this->input->post('small_pallet_weight'),
				'boxes_per_pallet'  	=> $this->input->post('boxes_per_pallet'),
				'box_per_big_pallet'  	=> $this->input->post('big_boxes_per_pallet'),
				'box_per_small_pallet'  => $this->input->post('small_boxes_per_pallet'),
				'sqm_per_box' 			=> $this->input->post('sqm_per_box'),
				'pcs_per_box' 			=> $this->input->post('pcs_per_box'),
				'total_no_of_pallet' 	=> ($this->input->post('no_of_pallet') + $this->input->post('no_of_big_pallet') +$this->input->post('no_of_small_pallet')),
				'total_no_of_boxes' 	=> $this->input->post('boxes'),
				'total_no_of_sqm' 		=> $this->input->post('total_no_of_sqm'),
			 	'total_product_amt' 	=> 0,
				'total_pallet_weight' 	=> $this->input->post('pallet_weight'),
				'total_net_weight' 		=> $this->input->post('net_weight'),
				'total_gross_weight' 	=> $this->input->post('gross_weight'),
				'container_half' 		=> 0,
			   	'cdate'				 	 =>date('Y-m-d H:i:s')
				);
			 
			 $insertid = $this->export->insert_productrecord($data);
				 
					$packing_data = array(
						"exportproduct_trn_id"	 => $insertid,
						"export_invoice_id" 	 => $this->input->post('einvoice_id'),
						"design_id" 			 => $this->input->post('design_id'),
						"finish_id" 			 => $this->input->post('finish_id'),
						"client_name" 			 => '',
						"barcode_no" 			 => '',
						"product_rate" 			 => 0,
						"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
						"no_of_boxes" 			 => $this->input->post('boxes'),
						"no_of_sqm" 			 => $this->input->post('total_no_of_sqm'),
						"per" 					 => 'SQM',
						"product_amt" 			 => 0,
						"packing_net_weight"	 => $this->input->post('net_weight'),
						"packing_gross_weight" 	 => $this->input->post('gross_weight') 
						);
						$insertrecord = $this->export->insert_packing_data($packing_data);
						 
			$pi_data = array(
					'export_invoice_id'			=>	 $this->input->post('einvoice_id'),
					'container_no'				=>	 $this->input->post('new_container_no'),
					'seal_no'					=>	 $this->input->post('new_seal_no'),
					'self_seal_no'				=>	 $this->input->post('new_rfidseal_no'),
					'container_size'	 		=>	 $this->input->post('new_container_size'),
					'exportproduct_trn_id'	 	=>	 $insertid,
					'export_packing_id'			=>	 $insertrecord,
					'product_id'				=>	 $this->input->post('product_id'),
					'origanal_pallet'			=>	 $this->input->post('no_of_pallet'),
					'orginal_no_of_big_pallet'	=>	 $this->input->post('no_of_big_pallet'),
					'orginal_no_of_small_pallet'=>	 $this->input->post('no_of_small_pallet'),
					'con_entry'					=>	 $this->input->post('new_con_entry'),
					'origanal_boxes'			=>	 $this->input->post('boxes'),
					'origanal_sqm'				=>	 $this->input->post('total_no_of_sqm'),
				 	'batch_no'					=>	 $this->input->post('batch_no'),
				 	'shade_no'					=>	 $this->input->post('shade_no'),
				   	'status' 					=>	 0
			); 
			$insertid = $this->export->insert_export_loading($pi_data);
			
					
			
			echo "1";
	}
	public function container_manage()
	{
		$id1 = $this->input->post('einvoice_id');
		$first=1;
		$no = 0;
		 $this->load->model('admin_exportinvoice_product','export'); 
		foreach($this->input->post('export_packing_id') as $row)
		{
		 	if($this->input->post('no_of_boxes')[$no] > 0)
			{
				$data = array(
					'export_packing_id'			 =>	$row,
				 	'container_size'	 		 =>	$this->input->post('container_size')[$no],
				 	'container_no'				 =>	$this->input->post('cont_no')[$no],
				 	'con_entry'					 =>	$this->input->post('con_entry')[$no],
				 	'origanal_pallet'			 =>	$this->input->post('no_of_pallet')[$no],
					'orginal_no_of_big_pallet'   =>	$this->input->post('no_of_big_pallet')[$no],
					'orginal_no_of_small_pallet' =>	$this->input->post('no_of_small_pallet')[$no],
					'origanal_boxes'			 =>	$this->input->post('no_of_boxes')[$no],
					'origanal_sqm'				 =>	$this->input->post('no_of_sqm')[$no],
					'batch_no'					 =>	$this->input->post('batch_no')[$no],
					'shade_no'					 =>	$this->input->post('shade_no')[$no],
			 		'status' 					 =>	 "0"
				); 
				 
				$id = $this->input->post('export_loading_trn_id')[$no];
				$updateid = $this->export->updatecointainer($data,$id);
				 
			}
			  $updateweight_data = array
						(
						
						'updated_net_weight'		=>	0,
						'updated_gross_weight'		=>	0
						
						);
						
			$insertrecord1 = $this->export->update_data($updateweight_data,$id1);
			
			$no++;
		}
		$no=0;
	
		foreach($this->input->post('export_packing_id') as $row)
		{
			if(!empty($this->input->post('product_rate')[$no]))
			{
				$data = array(
					'product_rate' 	=>	$this->input->post('product_rate')[$no],
					'product_amt'	=>	$this->input->post('product_amt')[$no],
		 	); 
			$id = $row;
			 
				$updateid = $this->export->update_cointainer($data,$id);
			}
			$no++;
		}
		 $row = array();
		 $row['res'] = 1;
			
		 
			
		echo json_encode($row);
			 
	}
	function container_detail_entry()
	{
	 $this->load->model('admin_exportinvoice_product');
			 $no=0;
			foreach($this->input->post('export_loading_trn_id') as $key)
			{
			 	$data2 = array(
					"container_no"				=> $this->input->post('container_no')[$no], 
					"seal_no" 	  				=> $this->input->post('seal_no')[$no],
					"self_seal_no" 				=> $this->input->post('rfidseal_no')[$no],
					"booking_no" 				=> $this->input->post('booking_no')[$no],
					"lr_no" 					=> $this->input->post('lr_no')[$no],
					"truck_no" 					=> $this->input->post('truck_no')[$no],
					"mobile_no" 				=> $this->input->post('mobile_no')[$no],
				 	"remark" 					=> $this->input->post('remarks')[$no],
					"tare_weight" 				=> $this->input->post('tare_weight')[$no],
					 
			 	);
				 
				$data3 = array(
				 	"updated_net_weight"  		=> $this->input->post('net_weight')[$no],
					"updated_gross_weight"  	=> $this->input->post('gross_weight')[$no],
					"final_updated_net_weight"  	=> $this->input->post('final_updated_net_weight')[$no],
					"final_updated_gross_weight"  	=> $this->input->post('final_updated_gross_weight')[$no]
			 	);
				
				$trnupdatedid = $this->exportinvoice->update_export_weight_cointainer($key,$data3);
				
				$trnupdatedid = $this->exportinvoice->update_exportcointainer($this->input->post('con_entry')[$no],$this->input->post('export_invoiceid'),$data2);
				
				$updateid = $this->admin_exportinvoice_product->update_vgm($this->input->post('export_invoiceid'),$this->input->post('container_no')[$no],$this->input->post('containerno')[$no]);
			 	$no++; 
			}				
			
			 
		 $row['res'] = "1";
		echo json_encode($row);

	}
	public function invoice_html_update()
	{
	 
		$export_invoice_id	= $this->input->post('export_invoice_id');
		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$export_invoice_id,
			"invoice_html" 			=> 	$invoice_html,
			"invoice_table_name" 	=> 	'export_invoice',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->exportinvoice->check_invoice_html('export_invoice',$export_invoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->exportinvoice->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->exportinvoice->update_invoice_html($data,$export_invoice_id,'export_invoice');
		}
		if($insertid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function loadingpdf_html_update()
	{
	 
		$export_invoice_id	= $this->input->post('export_invoice_id');
		$loadingpdf_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('loadingpdf_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$export_invoice_id,
			"invoice_html" 			=> 	$loadingpdf_html,
			"invoice_table_name" 	=> 	'loadingpdf_html',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->exportinvoice->check_invoice_html('loadingpdf_html',$export_invoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->exportinvoice->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->exportinvoice->update_invoice_html($data,$export_invoice_id,'loadingpdf_html');
		}
		if($insertid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function packing_html_update()
	{
	 
		$export_invoice_id	= $this->input->post('export_invoice_id');
		$packing_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('packing_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$export_invoice_id,
			"invoice_html" 			=> 	$packing_html,
			"invoice_table_name" 	=> 	'packing_html',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->exportinvoice->check_invoice_html('packing_html',$export_invoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->exportinvoice->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->exportinvoice->update_invoice_html($data,$export_invoice_id,'packing_html');
		}
		if($insertid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function annexure_html_update()
	{
	 
		$export_invoice_id	= $this->input->post('export_invoice_id');
		$annexure_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('annexure_html'));
	 	 
		$data = array(
			"table_id" 				=> 	$export_invoice_id,
			"invoice_html" 			=> 	$annexure_html,
			"invoice_table_name" 	=> 	'annexure',
			"cdate" 				=>	date('Y-m-d H:i:s'),
			"status" 				=>	0
		);
		 
		$check_id = $this->exportinvoice->check_invoice_html('annexure',$export_invoice_id);
		 
		if(empty($check_id))
		{
			$insertid = $this->exportinvoice->insert_invoice_html($data);
		}
		else
		{
			$insertid = $this->exportinvoice->update_invoice_html($data,$export_invoice_id,'annexure');
		}
		if($insertid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function search(){
 
        $term = $this->input->get('term');
 
        $this->db->like('payment_terms', $term);
		$this->db->limit(5);
        $data = $this->db->get("tbl_payment_terms")->result();
 
        echo json_encode($data);
    } 
	
	public function search1(){
 
        $term = $this->input->get('term');
 
        $this->db->like('port_name', $term);
		$this->db->limit(10);
        $data = $this->db->get("tbl_port_master")->result();
 
        echo json_encode( $data);
    }
}
