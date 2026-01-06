<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Exportinvoice_listing extends CI_controller
{
		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('url');
			$this->load->library(array('form_validation','session','encrypt'));
			$this->load->model('admin_exportinvoice_list','export');
			$this->load->model('menu_model','menu');	
			include APPPATH . 'third_party/PHPExcel.php';
			if (!isset($_SESSION['id']) && $this->session->title == TITLE)
			{
				redirect(base_url());
			}  
		}	
		public function index()
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{
			 	$this->load->model('admin_company_detail');	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
				$data['consign_data']	 = $this->export->select_consigner();
				$data['export_data']	 = $this->export->getexportdata();
			 	$this->load->view('admin/exportinvoice_list',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function deleterecord()
		{
			 
			$id = $this->input->post('id');
			$deleterecord = $this->export->exportinvoicedelete($id);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
		}
		
			public function deleterecord_vgm()
		{
			 
			$id = $this->input->post('id');
			$deleterecord = $this->export->deleterecordvgm($id);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
		}
		
		public function delete_shipping_bill()
		{
			$shipping_bill_id = $this->input->post('id');
			 
			$deleterecord = $this->export->delete_shipping_bill($shipping_bill_id);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
		}
		public function updateperforma_invoice()
		{
			$id = $this->input->post('id');
			$no_of_export = ($this->input->post('no_of_export')-1);
			$updaterecord = $this->export->updateperformainvoice($id,$no_of_export);	
			echo 1;
		}
		public function manage_ewb()
		{
			$data = array(
					'shipping_bill_no'	=> $this->input->post('Shipping_Bill_no'),
					'shipping_date' 	=> date('Y-m-d',strtotime($this->input->post('shipping_date'))),
					'ewaybill_no' 		=> $this->input->post('ewaybill_no'),
					'sealing_date'	 	=> date('Y-m-d',strtotime($this->input->post('sealing_date'))),
					'sealing_time' 		=> $this->input->post('sealing_time'),
					'export_invoice_id' => $this->input->post('export_invoice_id'),  
					'cdate' 			=> date('Y-m-d H:i:s')
					);
					$id = $this->input->post('ewb_template_id');
					$row = array();
					if(empty($id))
					{
						$rdata = $this->export->insert_ewb($data);
						 $row['res']	= 1;
					}
					else
					{
						$rdata = $this->export->update_ewb($data,$id);
						$row['res']	= 2;
				 	}
				echo json_encode($row);
		}
		public function download_excel($id)
		{
			 if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$data 	= $this->export->get_ewb_template($id);
				$datap 	= $this->export->loading_data($id);
				
					
				$objPHPExcel	=	new	PHPExcel();
			 	$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SHIPPING_BILL_NO');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'SHIPPING BILL DATE(dd/mm/yyyy)');
				$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'VEHICLE NUMBER');
				$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CONTAINER NUMBER');
				$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ESEAL NUMBER');
				$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SEALING TIME(HH:mm)');
				$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'SEALING DATE(dd/mm/yyyy)');
				$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'E-Way Bill No');
				$objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true);
				$rowCount	=	2;
				 
				$con_array = array();
				foreach($datap as $row)
				{
					if(!in_array($row->con_entry,$con_array))
					{
					$shipping_date = !empty($data)?mb_strtoupper(date("d/m/Y",strtotime($data->shipping_date)),'UTF-8'):"";
					$shipping_time = !empty($data)?mb_strtoupper(date("H:i",strtotime($data->sealing_time)),'UTF-8'):"";
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,mb_strtoupper($data->shipping_bill_no,'UTF-8'));
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$shipping_date);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,mb_strtoupper($row->truck_no,'UTF-8'));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,mb_strtoupper($row->container_no,'UTF-8'));
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,mb_strtoupper($row->self_seal_no,'UTF-8'));
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$shipping_time);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$shipping_date);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,mb_strtoupper($data->ewaybill_no,'UTF-8'));
					$rowCount++;
					 
						array_push($con_array,$row->con_entry);
								}
				}
 

						$objWriter	=	new PHPExcel_Writer_Excel2007($objPHPExcel);
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$data->export_invoice_no.'_self_sealing.xlsx"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
						ob_end_clean();						
						$objWriter->save('php://output');
		 			

			 }
			 else
			 {
				 redirect(base_url().'');
			 }
		}
		
		public function upload_warner($id)
		{
			 if(!empty($this->session->id)  && $this->session->title == TITLE)
			 { 
				$this->load->model('admin_company_detail');	
				$datap 	= $this->export->loading_data($id);
				$data['company_detail'] 	= $this->admin_company_detail->s_select();	
				$exportinvoice_data	= $this->export->exportinvoice_data($id);
				$ewb_data	 		= $this->export->get_ewb_template($id); 
				
				$port_data	 		= $this->export->get_port_data($exportinvoice_data->port_of_loading); 
				$warner_data	 	= $this->export->warner_data($data['company_detail'][0]->s_id); 
			  	$con_array = array();
				if(!empty($port_data))
				{
					foreach($datap as $row)
					{
						if(!in_array($row->con_entry,$con_array))
						{
								$api_key 			= $warner_data->api_key;
								$latitude 			= $warner_data->latitude;
								$longitude 			= $warner_data->longitude;
								$warner_company_id 	= $warner_data->warner_company_id;
								$customer_id 		= $warner_data->customer_id;
								$enter_by 			= $warner_data->enter_by;
								$ebn_enter_type 	= $warner_data->ebn_enter_type;
								$exporter_iec 		= $exportinvoice_data->exporter_iec;
								$Shipping_Bill_no 	= $ewb_data->shipping_bill_no;
								$self_seal_no 		= $row->self_seal_no;
								$truck_no 			= $row->truck_no;
								$port_code 			= $port_data->port_code;
								$container_no 		= $row->container_no;
								$ewaybill_no 		= $ewb_data->ewaybill_no;
								$sealing_time		= date("H:i",strtotime($ewb_data->sealing_time));
								$shipping_date		= date("m/d/Y",strtotime($ewb_data->shipping_date));
								
							$url = 'http://automationcpl.com/esealconnpentagoneEWBill.php?API_KEY='.$api_key.'&IEC_CODE='.$exporter_iec.'&S_BILL_NO='.$Shipping_Bill_no.'&TID_NO='.$self_seal_no.'&VEHICLE_NO='.$truck_no.'&DESTINATION_PORT='.$port_code.'&CONTAINER_NO='.$container_no.'&SEALING_TIME='.$sealing_time.'&SEALING_DATE='.$shipping_date.'&SHIPPING_DATE='.$shipping_date.'&ENTER_DATE='.date('m/d/Y').'&latitude='.$latitude.'&longitude='.$longitude.'&Company_Id='.$warner_company_id.'&Customer_Id='.$customer_id.'&ENTER_BY='.$enter_by.'&EBN='.$ewaybill_no.'&EBN_ENTRY_TYPE='.$ebn_enter_type;
								$ch = curl_init($url);
								$headers = array(
									'Content-Type:application/json',
									'Authorization: Basic ZWxpdGVvZmZzZXQ6ZWxpdGVvZmZzZXQ6WnVrdUAyMDIxOnRydWU6' // <---
								);
								curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
								
								$result = curl_exec($ch);
								curl_close($ch);
								array_push($con_array,$row->con_entry);
						}
					
					}
					
					echo "<script>alert('check your data will upload in warner side if not then contact to ZUKU Team.')</script>";
					redirect(base_url().'upload_warner/index/'.$id);
				}
				else
				{
						echo "<script>alert('DESTINATION PORT NOT FOUND')</script>";
						redirect(base_url().'upload_warner/index/'.$id);
				}
			}
			 else
			 {
				 redirect(base_url().'');
			 }
		}
	  
		public function create_ewb($id)
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{ 
			 	$data['export_data']		= $this->export->exportinvoice_data($id);
				$data['loading_data'] 		= $this->export->loading_data($id);
				$this->load->model('admin_company_detail');	
				$data['company_detail'] 	= $this->admin_company_detail->s_select();	
				$data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id); 
				$data['shipping_bill_data']	= $this->export->shipping_bill_data($id); 
				$data['ewb_data']	 		= $this->export->get_ewb_template($id); 
				$this->load->view('admin/create_ewb',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function fetch_record()
		{
			 
			$invoice_status = $this->input->get('invoice_status');
			$invoicedate 	= explode(" - ",$this->input->get('date'));
			$cust_id 		= $this->input->get('cust_id');
			$export_invoice_id 	= $this->input->get('export_invoice_id');
			
			$_SESSION['export_s_date'] = $invoicedate[0];
			$_SESSION['export_e_date'] = $invoicedate[1];
		
			$where = ' and invoice_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
			
			if(!empty($cust_id))
			{
				$where .= ' and mst.consiger_id = '.$cust_id;
				$_SESSION['export_cust_id'] = $cust_id;
			}	
			else
			{
				$_SESSION['export_cust_id'] = '';
			}	
			
			if(!empty($export_invoice_id))
			{
				$where .= ' and mst.export_invoice_id = '.$export_invoice_id;
				$_SESSION['get_exportdata'] = $export_invoice_id;
			}	
			else
			{
				$_SESSION['get_exportdata'] = '';
			}
		 
			if($invoice_status==1)
			{
				$where .= ' and mst.step=4';
				
			}
			else if($invoice_status==2)
			{
				$where .= ' and mst.step=1';
			}
			else if($invoice_status==3)
			{
				$where .= ' and mst.step=3';
			}	
			else if($invoice_status==4)
			{
				$where .= ' and mst.step=2';
			} 
			else if($invoice_status==5)
			{
				$where .= ' and mst.step=5';
			} 
			else if($invoice_status==6)
			{
				$where .= ' and mst.step=6';
			} 
			 // if($this->session->usertype_id != 1)
			// {
				// $where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			// }
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.export_invoice_id','consign.c_name', 'mst.invoice_date', 'mst.export_ref_no','mst.export_invoice_no','consign.c_companyname','mst.container_details','mst.port_of_discharge','mst.terms_id','mst.grand_total','mst.status','mst.cdate','mst.step','mst.performa_invoice_id','tax_status', 'cur.currency_name','cur.currency_code','cur.currency_id','mst.certification_charge', 'mst.insurance_charge','mst.seafright_charge','mst.calculation_operator','mst.customer_invoice','mst.direct_invoice','bill.id as upload_shiping_bill_id');
			$isWhere = array("mst.status = 0".$where);
			$table = "tbl_export_invoice as mst";
			$isJOIN = array(
				'left join customer_detail consign on consign.id	= mst.consiger_id',
		 		'left join tbl_currency cur on cur.currency_id	= mst.invoice_currency_id',
				'left join upload_shiping_bill bill on bill.export_invoice_id	= mst.export_invoice_id'
				);
			
			$hOrder = "ExtractNumber(mst.export_invoice_no) desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = 1;
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				$step_status='';
				if($row->step==1)
				{
					if($row->direct_invoice == 1)
					{
						$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="'.base_url().'exportinvoiceproduct/direct/'.$row->export_invoice_id.'"><i class="glyphicon glyphicon-stop"></i></a>';
					}
					else
					{
						$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="'.base_url().'exportinvoiceproduct/index/'.$row->export_invoice_id.'"><i class="glyphicon glyphicon-stop"></i></a>';
					}
				}
				else if($row->step==2)
				{
					if($row->direct_invoice == 1)
					{
						
						$step_status = '<a class="btn btn-primary tooltips" data-toggle="tooltip" data-title="Packing Pending" href="'.base_url().'exportinvoicepacking/index/'.$row->export_invoice_id.'"><i class="fa fa-square-o"></i></a>';
					}
					else
					{
						$step_status = '<a class="btn btn-info tooltips" data-toggle="tooltip" data-title="Annexure Pending" href="'.base_url().'exportinvoiceannexure/index/'.$row->export_invoice_id.'"><i class="fa fa-square-o"></i></a>';
					}
				}
				else if($row->step==6)
				{
					$step_status = '<a class="btn btn-info tooltips" data-toggle="tooltip" data-title="Sample Entry" href="'.base_url().'exportinvoicesample/index/'.$row->export_invoice_id.'"><i class="fa fa-square-o"></i></a>';
				}
				else if($row->step==3)
				{
					$step_status = '<a class="btn btn-info tooltips" data-toggle="tooltip" data-title="Annexure Pending" href="'.base_url().'exportinvoiceannexure/index/'.$row->export_invoice_id.'"><i class="fa fa-square-o"></i></a>';
				}
				else if($row->step==5)
				{
					$step_status = '<a class="btn btn-primary tooltips" data-toggle="tooltip" data-title="EPCG Pending" href="'.base_url().'exportinvoicesupplier/index/'.$row->export_invoice_id.'"><i class="fa fa-square-o"></i></a>';
				}
				else 
				{
					$step_status = '<a class="btn btn-success tooltips" data-toggle="tooltip" data-title="Export Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i></a>';
				}
				if($row->step==4 && $row->customer_invoice==0)
				{
					$row_data[] =  '<input type="checkbox" name="allexport_invoice[]" id="allexport_invoice'.$row->export_invoice_id.'" value="'.$row->export_invoice_id.'" style="width: 30px;" class="form-control"/>';
				}
				else
				{
					$row_data[] =  '';
				}
				$row_data[] = $step_status;
				$row_data[] = date('d/m/Y',strtotime($row->invoice_date));
				if($row->step==4)
				{
					$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('exportinvoiceview/index/'.$row->export_invoice_id).'" >'.$row->export_invoice_no.'</a>';
				}
				else
				{
					$row_data[] = $row->export_invoice_no;
				}
				$row_data[] = $row->export_ref_no;
				$row_data[] = $row->c_name;
				$row_data[] = $row->c_companyname;
				$row_data[] = $row->container_details;
				$row_data[] = $row->port_of_discharge;
				if($row->terms_id == 1)
				{
					$grand_total = $row->grand_total;
				}
				else if($row->terms_id == 3)
				{
					$grand_total = ($row->grand_total - $row->seafright_charge - $row->insurance_charge - $row->certification_charge);
				}
				else
				{
					$grand_total = $row->grand_total;
				}
				//$grand_total = $row->grand_total;
				 
				$locale='en-US'; //browser or user locale
				$currency=$row->currency_code; 
				$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
				$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
				$row_data[] = $currency_symbol.' '.number_format($grand_total,2,'.','');
				$viewinvoice='';
				$extradetail='';
				$performa_invoice_id = !empty($row->performa_invoice_id)?$row->performa_invoice_id:0;
				$no_of_export = !empty($row->no_of_export)?$row->no_of_export:0;
				$deletebtn = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->export_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
							</li>';

				
				$actionbtn = '<li> 
								<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'exportinvoice/export_edit/'.$row->export_invoice_id.'"><i class="fa fa-pencil"></i> Edit</a>
							</li>';
					
				$taxinvoice='';
				$vgmbtn='';
				$fumigationbtn='';
				$qc_btn = '';
				$customer_invoice = '';
				$viewinvoice = '';
				$extradetail = '';
				$taxinvoice1 = '';
				$upload_shiping_bill = '';
				$warner_upload = '';
				$upload_bltn = '';
				$bl_draft = '';
				$coo_draft = '';
				if($row->step==4)
				{
					$actionbtn .= '<li> 
										<a class="tooltips" data-toggle="tooltip" data-title="Manage Container File/Photos" href="'.base_url().'exportinvoice/container_details/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-pencil"></i> Manage Container File/Photos</a> 
										</li>';
										
					if(empty($row->upload_shiping_bill_id))
					{
						$upload_shiping_bill = '<li>
													<a class="tooltips" data-toggle="tooltip" data-title="Shipping Bill" href="'.base_url().'upload_shiping_bill/index/'.$row->export_invoice_id.'"><i class="fa fa-plus"></i> Shipping Bill</a>
												</li>';
					}
					else
					{
						$upload_shiping_bill = '<li>
													<a class="tooltips" data-toggle="tooltip" data-title="Edit Shipping Bill" href="'.base_url().'upload_shiping_bill/form_edit/'.$row->upload_shiping_bill_id.'"><i class="fa fa-pencil"></i> Edit Shipping Bill</a>
												</li>
												 
												';
					}
					$warner_upload = '<li> 	
									<a class="tooltips" data-toggle="tooltip" data-title="Upload Warner Seals" href="'.base_url().'upload_warner/index/'.$row->export_invoice_id.'"><i class="fa fa-plus"></i> Upload Warner Seals</a>
												</li>';
					$viewinvoice='<li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('exportinvoiceview/without_design/'.$row->export_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice</a>
								  </li> 
								  <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('exportinvoiceview1/index/'.$row->export_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (With Sign)</a>
								  </li> 
								  <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('exportinvoiceview/other_product/'.$row->export_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (Other Product)</a>
								  </li>
								   

								   <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('exportinvoiceview/index_kg/'.$row->export_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (KG)</a>
								  </li>
									<li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Packing List" href="'.base_url('exportinvoicepackingview/index/'.$row->export_invoice_id).'" ><i class="fa fa-file-pdf-o"></i> View Packing List (FAMIGATION)</a>
								  </li>								  
							
								  <li>
											<a class="tooltips" data-toggle="tooltip" data-title="View Loading Pdf" href="'.base_url('loadingpdf/index/'.$row->export_invoice_id).'" target="_blank" ><i class="fa fa-eye"></i> Loading Pdf</a>
										</li>
								  ';
					 
						 
					 $extradetail='<li>
									<a class="tooltips" data-toggle="tooltip" data-title="Extra Details" href="'.base_url().'Extra_detail/index/'.$row->export_invoice_id.'"><i class="fa fa-info-circle"></i> Extra Details</a>
								</li>
								 
								  ';
								  
				 	$check_vgm = $this->export->vgmrecord($row->export_invoice_id);
					if(empty($check_vgm))
					{
						$vgmbtn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Create VGM" href="'.base_url('create_vgm/index/'.$row->export_invoice_id).'"><i class="fa fa-plus"></i> 	Create VGM</a>
									</li>';
					}
					else
					{
						$vgmbtn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Edit VGM" href="'.base_url('create_vgm/edit_vgm/'.$check_vgm->vgm_id).'"><i class="fa fa-pencil"></i> 	Edit VGM</a>
									  </li>
									  <li>
											<a class="tooltips" data-toggle="tooltip" data-title="View VGM Pdf" href="'.base_url('vgmpdf/index/'.$check_vgm->vgm_id).'" target="_blank" ><i class="fa fa-eye"></i> VGM PDF</a>
										</li> 
										<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record_vgm('.$check_vgm->vgm_id.')" href="javascript:;" ><i class="fa fa-trash"></i>VGM Detele</a>
										</li>
										
										';
					}
					
					$check_fumigation = $this->export->fumigationrecord($row->export_invoice_id);
					if(empty($check_fumigation))
					{
						$fumigationbtn = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Create Fumigation" href="'.base_url('create_fumigation/index/'.$row->export_invoice_id).'"><i class="fa fa-plus"></i> 	Create Fumigation</a>
									</li>';
					}
					else
					{
						$fumigationbtn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Edit Fumigation" href="'.base_url('create_fumigation/edit_fumigation/'.$check_fumigation->export_invoice).'"><i class="fa fa-pencil"></i> 	Edit Fumigation</a>
									  </li>
									  <li>
											<a class="tooltips" data-toggle="tooltip" data-title="View Fumigation Pdf" href="'.base_url('create_fumigation/view/'.$check_fumigation->export_invoice).'" target="_blank" ><i class="fa fa-eye"></i> FUMIGATION PDF</a>
										</li> 
										
										
										';
					}
						// $fumigationbtn = '<li>
								// <a class="tooltips" data-toggle="tooltip" data-title="Create Fumigation" href="'.base_url('create_fumigation/index/'.$row->export_invoice_id).'"><i class="fa fa-plus"></i> Create Fumigation</a>
							// </li>';
						// $fumigationbtn = '<li>
							// <a class="tooltips" data-toggle="tooltip" data-title="Edit Fumigation" href="'.base_url('create_fumigation/edit_fumigation/'.$row->export_invoice_id).'"><i class="fa fa-pencil"></i> Edit Fumigation</a>
						// </li>';
					$check_qc = $this->export->qcrecord($row->export_invoice_id);
						
						if(!empty($check_qc))
						{
							$qc_btn = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View QC Doc" href="'.base_url().'upload_qc_doc/view/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-eye"></i> View QC Doc. </a>
								</li>';
						}
						else
						{
							$qc_btn = '
							<li>
									<a class="tooltips" data-toggle="tooltip" data-title="QC Doc" href="'.base_url().'upload_qc_doc/index/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-upload"></i> Upload QC Doc </a>
							</li>';
						}
						$doc_btn = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Document" href="'.base_url().'exportinvoiceview/document/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-upload"></i> Document. </a>
										</li> ';
					
					if($row->customer_invoice == 0)
					{
						$customer_invoice = '<li>
												<a class="tooltips" data-toggle="tooltip" data-title="Create Commercial Invoice" href="'.base_url('create_customer_invoice/index/'.$row->export_invoice_id).'"><i class="fa fa-plus"></i> 	Create Commercial Invoice</a>
										</li>';
					}
					else
					{
						$customer_invoice = '<li>
												<a class="tooltips" data-toggle="tooltip" data-title="Commercial Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i> Commercial Invoice Done</a>
										</li>';
										$deletebtn ='';
										$actionbtn ='';
										
							if($row->direct_invoice == 2)
							{
								$actionbtn = '<li> <a class="tooltips" data-toggle="tooltip" data-title="Edit Contaier Data" href="'.base_url().'exportinvoice/container_details/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-pencil"></i> Manage Container File/Photos</a> </li> ';
							}
					
					}
					$taxinvoice1 = '<li>
									<a class="tooltips" data-toggle="tooltip" data-title="Tax Invoice" href="'.base_url('taxinvoice/index/'.$row->export_invoice_id).'"><i class="fa fa-plus"></i> Tax Invoice</a>
								</li>';
								if($row->tax_status==1)
								{
						$taxinvoice1= '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="Tax Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i>  Tax Invoice </a>
										</li>';
						$actionbtn = '<li> <a class="tooltips" data-toggle="tooltip" data-title="Edit Contaier Data" href="'.base_url().'exportinvoice/container_details/'.$row->export_invoice_id.'"   data-original-title="" title=""><i class="fa fa-pencil"></i> Manage Container File/Photos</a> </li> ';
										$actionbtn ='';
					}
					
	 			}
				
					 
				$row_data[] = '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
									<span class="caret"></span></button>
									<ul class="dropdown-menu">
										'.$actionbtn .'
										'.$viewinvoice.'
										'.$extradetail.'
										'.$vgmbtn.'
										'.$fumigationbtn.'
										'.$editfugbtn.'
										'.$upload_shiping_bill.'
										'.$warner_upload.'
									 	'.$taxinvoice.'
									 	'.$customer_invoice.'
										'.$taxinvoice1.'
									 	'.$qc_btn.'
										 
										
										'.$deletebtn.'
								</div>';
				$appData[] = $row_data;
			}
			$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
			$numrecord=$sqlReturn['data'];
			$output = array(
					"sEcho" => intval($this->input->get('sEcho')),
					"iTotalRecords" =>  $numrecord,
					"iTotalDisplayRecords" =>$totalrecord,
					"aaData" => $appData
			);
				echo json_encode( $output );
		}
		function check_congine()
		{
			$export_invoice_array = $this->input->post('export_invoice_id');
		 	$checkcongine = $this->export->check_congine($export_invoice_array);
			$row=array();
			if($checkcongine == 1)
			{
				$row['res'] = 1;
			}	
			else
			{
				 $row['res'] = 2;
			}
			echo json_encode($row);
	  
		}
}
?>