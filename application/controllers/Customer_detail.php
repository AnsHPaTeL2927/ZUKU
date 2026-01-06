<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Customer_detail extends CI_controller
{
		public function __construct()
		{
			parent:: __construct();
			 
			 $this->load->model('admin_customer_detail','sli');
			$this->load->model('menu_model','menu');
			if(!isset($_SESSION['id']) && $this->session->title == TITLE) {
					redirect(base_url());
				} 
		}	
	 	public function index($m="")
		{
			 
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{
			 	$this->load->model('admin_company_detail');	
				$data['bank_data']			= $this->sli->bank_select(); 
				$data['cust_data']			= $this->sli->s_edit_select($id); 
				$data['design_data']			= $this->sli->getdesigndata(); 
				$data['forwarerdata']		= $this->sli->getforwarerdata();
				$data['company_detail'] 	= $this->admin_company_detail->s_select();	
				$data['agentname'] 			= $this->sli->agentdata();
				$data['paymenttermsdata']	= $this->sli->getpaymenttermsdata();
				$data['currencydata'] 		= $this->sli->getcurrencydata();
				$data['company_data']	 	= $this->sli->getcompanydata();	
				$data['getcustdata'] 		= $this->sli->get_customer($id);
				$data['mode'] 				= 'View';
				$data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id);	
			
				$this->load->view('admin/customer_detail',$data);
			}
			else
			{
				$this->load->view('admin/index');
			}				
		}
	public function fetch_record()
	{
		$companydata = $this->input->get('companydata');
	
		 $status = $this->input->get('status');
		 
		 if($status == 2)
		 {
			 $where = ' mst.status = 0';
		 }
		 else  if($status == 1)
		 {
			 $where = ' mst.status = 2';
		 }
		 
		// if(!empty($companydata))
			// {
				// $where .= ' and mst.id = '.$companydata;
				// $_SESSION['get_companydata'] = $companydata;
			// }	
			// else
			// {
				// $_SESSION['get_companydata'] = '';
			// }
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.id','agent_id','forwarer_id','customer_type','c_companyname','mst.c_name','c_nick_name','c_contact','c_email_address' ,'mst.opening_balance','con_detail.c_name as country_name','currency.currency_code','(SELECT count(*) FROM `tbl_performa_invoice` where consigne_id = mst.id) as total_cnt','mst.bank_id','mst.status');
		 $isWhere = array($where);
		 $table = "customer_detail as mst";
		 $isJOIN = array(
						 'left join country_detail as con_detail on  con_detail.id = mst.c_country',
						 'left join tbl_payment_terms as payment_terms on  payment_terms.id = mst.payment_terms',
						 'left join tbl_agent_master as agent_name on  agent_name.id = mst.agent_id', 
						 'left join tbl_forwarer_master as forwarer_name on  forwarer_name.id = mst.forwarer_id',
						 'left join tbl_currency as currency on currency.currency_id = mst.currency_id'
						 );
		 $hOrder = "status asc, mst.id desc";
		$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
				
				$locale='en-US'; //browser or user locale
				$currency=$row->currency_code; 
				$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
				$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
				
					if($row->customer_type == 1)
					{
						$cust_type = "Export";
					}
					else if($row->customer_type == 2)
					{
						$cust_type = "Merchant";
					}
					$name = $row->c_name;
					$name .= (!empty($row->c_name) && !empty($row->c_nick_name))?" - ": "";
					$name .= $row->c_nick_name;
					$balance_status = ($row->open_balance_status == 1)?"Credit":"Debit";						
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $cust_type;
					$row_data[] = $row->c_companyname;
					$row_data[] = $name;
					$row_data[] = $row->c_contact;
					$row_data[] = $row->c_email_address;
					$row_data[] = $row->country_name;
					$row_data[] = $currency_symbol.' '.$row->opening_balance.' '.$balance_status;
					$actionbtn = '';
					$delete_btn = '';
					
					if($row->status==0)
					{
						$actionbtn = '<li>
										<a class="tooltips" data-title="Set Price" href="'.base_url().'add_design_detail/index/'.$row->id.'" ><i class="fa fa-money"></i> Set Price</a>
									</li>
									
									<li>
										<a class="tooltips" data-title="Additional Detail" href="'.base_url().'add_customer_detail/index/'.$row->id.'" ><i class="fa fa-plus"></i> Additional Detail</a>
									</li>
									<li>
										<a class="tooltips" data-title="Set Design" href="'.base_url().'add_design_detail/design_detail/'.$row->id.'" ><i class="fa fa-image"></i> Set Design</a>
									</li>
									<li>
										<a class="tooltips" data-title="Set Product Detail" href="'.base_url().'customer_detail/product_detail/'.$row->id.'" ><i class="fa fa-product-hunt"></i> Set Product Detail</a>
									</li>
									<li>
										<a class="tooltips" data-title="Notify Party" href="'.base_url().'add_notify_detail/index/'.$row->id.'" ><i class="fa fa-plus"></i> Notify Party</a>
									</li>
									
									<li>
										<a class="tooltips" data-title="Add Opening Balance" href="javascript:;" onclick="opening_balance_modal('.$row->id.')"><i class="fa fa-money"></i> Opening Balance</a>
									</li>
									<li>
										<a class="tooltips" data-title="Edit" href="'.base_url().'customer_detail/form_edit/'.$row->id.'"><i class="fa fa-pencil"></i> Edit</a>
									</li>
									<li>
										<a class="tooltips " data-toggle="tooltip" data-title="Customer Document"  href="'.base_url().'customerdata_document/index/'.$row->id.'"><i class="fa fa-file"></i>Document</a>
									</li>
									<!--<li>
										<a class="tooltips" onclick="assign_user('.$row->id.')" data-title="Assign User" href="javascript:;" ><i class="fa fa-user-plus"></i> Assign User</a>
									</li>
									<li>
										<a class="tooltips" onclick="assign_designs('.$row->id.')" data-title="Assign User" href="javascript:;" ><i class="fa fa-user-plus"></i> Assign Designs</a>
									</li>-->
									<li>
										<a class="tooltips" data-title="Archive" href="javascript:;" onclick="archive_record('.$row->id.',2)" ><i class="fa fa-archive"></i> Archive</a>
									</li>';
									
									if($row->total_cnt==0)
									{  
										$delete_btn = '<li>
															<a class="tooltips" data-title="Detele"  onclick="delete_record('.$row->id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
													 </li>';
									}
									
									$bankdetailbtn = '<li>
														<a class="tooltips" data-title="Bank Details" id="bankmodal" data-toggle="modal" data-target="" onclick="bank_data('.$row->id.','.$row->bank_id.');"><i class="fa fa-bank"></i>Bank Details</a>
													  </li>';
								

					}	
					else
					{
						$actionbtn = '<li>
											<a class="tooltips" data-title="Unarchive" href="javascript:;" onclick="archive_record('.$row->id.',0)" ><i class="fa fa-archive"></i> Unarchive</a>
										</li>';
					}
					
					
					
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$delete_btn .'
											'.$bankdetailbtn .'
											 
									</div>';
					$appData[] = $row_data;
					$no++;
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
	
	public function product_detail($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['get_product_name_data'] 	= $this->sli->getproductdata(0,$id); 
			$data['cust_data']				= $this->sli->s_edit_select($id); 
		 	$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/customer_product_detail',$data);
		}
		else
		{
			$this->load->view('admin/index');
		}				
	}
	
	public function load_product_data()
	{
		$str = '  <table class="table table-bordered" style="margin-top:50px" >
						<tr>
							<th class="text-center" width="5">Sr no</th>
							<th class="text-center" width="20%">Product Name</th>
							<th class="text-center" width="10%">HSN Code</th>
							<th class="text-center" width="10%">Customer Product name</th>
							<th class="text-center" width="10%">Customer HSN Code</th>
							<th class="text-center" width="10%">Customer Invoice & Packing list </th> 
							<th class="text-center" width="10%">Export Invoice & packing list</th> 
							<th class="text-center" width="10%">BL</th> 
							<th class="text-center" width="10%">COO</th> 
						</tr>';
					 $n=0; 
					 $n1=1; 
					 $product_id = $this->input->post('filter_product_id');
					 $cust_id = $this->input->post('cust_id');
					 $_SESSION['customer_product_id'] = $product_id;
					$get_product_name_data	= $this->sli->getproductdata($product_id,$cust_id); 
				 	foreach($get_product_name_data as $product_row)
					{
						$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
						$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
					 $get_product_detail = $this->sli->get_cust_product_detail($product_row->product_id,$cust_id);
					 
					 $checkbox1 = ($get_product_detail->show_export == 1)?"checked":"";
					 $checkbox2 = ($get_product_detail->show_cust == 1)?"checked":"";
					 $checkbox3 = ($get_product_detail->show_bl == 1)?"checked":"";
					 $checkbox4 = ($get_product_detail->show_coo == 1)?"checked":"";
						$str .= '<tr>
								  		<td  class="text-center">'.$n1.'</td>
								  		<td  class="text-center">'.$product_name.'</td>
								  		<td  class="text-center">'.$product_row->hsnc_code.'</td>
								  		<td  class="text-center"> 
											<input type="text" class="form-control" name="cust_product_name'.$product_row->product_id.'" id="cust_product_name'.$product_row->product_id.'" placeholder="Customer Product name"  value="'.$get_product_detail->cust_product_name.'"/> 
										</td>
								  		<td   class="text-center">
											<input type="text" class="form-control" name="cust_hsncode'.$product_row->product_id.'" id="cust_hsncode'.$product_row->product_id.'" placeholder="Customer HSN Code"  value="'.$get_product_detail->cust_hsncode.'" />
										</td>
								  		<td   class="text-center">	
											<input type="checkbox"  name="show_export'.$product_row->product_id.'" id="show_export'.$product_row->product_id.'" '.$checkbox1.' />
										</td>
								  		<td   class="text-center">	
											<input type="checkbox"  name="show_cust'.$product_row->product_id.'" id="show_cust'.$product_row->product_id.'"  '.$checkbox2.'/>
										</td>
								  		<td   class="text-center">
											<input type="checkbox"  name="show_bl'.$product_row->product_id.'" id="show_bl'.$product_row->product_id.'" '.$checkbox3.'/>
										</td>
								  		<td   class="text-center">	
											<input type="checkbox" name="show_coo'.$product_row->product_id.'" id="show_coo'.$product_row->product_id.'"  '.$checkbox4.'/>
										</td>
							 	 </tr>
								 <input type="hidden"  name="product_id[]" id="product_id'.$product_row->product_id.'"  value="'.$product_row->product_id.'" />	
								 <input type="hidden"  name="cust_product_detail_id'.$product_row->product_id.'" id="cust_product_detail_id'.$product_row->product_id.'"  value="'.$get_product_detail->cust_product_detail_id.'" />	
								 ';
								
							 $n1++; 
							 $n++; 
								
					}
									  
										  
									$str .='</table>';
					
						 
		echo $str; 		
	}		
	public function update_product_detail()
	{
		$product_array_id = $this->input->post('productid_array');
		$no=0;
		
		foreach($product_array_id as $row)
		{
			$cust_product_detail_id = $this->input->post('cust_product_detail_id')[$no];
			 $data=array(
				'customer_id' 		=> $this->input->post('cust_id'),
				'product_id'		=> $row,
				'cust_product_name'	=> $this->input->post('cust_product_name_array')[$no],
				'cust_hsncode' 		=> $this->input->post('cust_hsncode_array')[$no],
			 	'show_export' 		=> $this->input->post('show_export_array')[$no],
			 	'show_cust' 		=> $this->input->post('show_cust_array')[$no],
			 	'show_bl' 			=> $this->input->post('show_bl_array')[$no],
			 	'show_coo' 			=> $this->input->post('show_coo_array')[$no],
				'cdate'		 		=> date('d-m-Y h:i:s') 
			);
			  
			if($cust_product_detail_id > 0)
			{
				 
				$insert_id = $this->sli->update_product_detail($data,$cust_product_detail_id);
				  
			}
			else  
			{
		 
				$insert_id = $this->sli->insert_product_detail($data);
					 
			}
			$no++;
		}
		$row = array();
        	$row['res'] = 1;
		echo json_encode($row);
	}
	
	public function import_customer()
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
		 	$this->upload->initialize($this->set_upload_options1('csvfile',$_FILES['import_file']['name'],$path));
			$this->upload->do_upload('import_file');
			$upload_image 		= $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			 
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				 
				$fields = fgetcsv($file);
				 
				if(count($fields)==17)
				{
					$farray = array("Expoter/Merchant","Customer Name","Company Name","Address","Zipcode","City","State","Country","Currency","Company Regestration No","Contact No","Email Address","Web Address","Port Of Discharge","Payment Terms","Opening Balance","Balance Status");
					 
				 	if($fields == $farray)
					{
						 
						$line_no = 2;
						$error = array();
						$error_line = array();
					 	while(($row = fgetcsv($file)) != false ) 
						{        
						
							$error_array = '';
							$complete_status = '';
							if(!empty(trim($row[0])))
							{ 
								$checkcountry = $this->sli->checkcountry($row[7]);
								 
								if(!empty($checkcountry))
								{
									$check_currency = $this->sli->checkcurrency($row[8]);
								 	if(!empty($check_currency))
									{
										$customer_type =  ($row[0] == "Export")?1:2;
										 $data = array(
												'customer_type' 	 	=> $customer_type,
												'c_name' 				=> $row[1],
												'c_companyname' 		=> $row[2],
												'c_address' 			=> $row[3],
												'c_postcode' 			=> $row[4],
											 	'c_city' 				=> $row[5],
												'c_state' 				=> $row[6],
												'c_country' 			=> $checkcountry->id,
												'currency_id' 			=> $check_currency->currency_id,
												'c_registration_detail' => $row[9],
												'c_contact' 			=> $row[10],
												'c_email_address' 		=> $row[11],
												'c_web_address' 		=> $row[12],
												'port_of_discharge' 	=> $row[13],
												'payment_terms'  		=> $row[14],
												'opening_balance' 		=> $row[15],
												'open_balance_status' 	=> ($row[16] == "Credit")?1:2
											);
											$checkalready_exit = $this->sli->checkalready($data);
											if($checkalready_exit == 0)
											{
													$rdata = $this->sli->s_insert($data);
														if(!empty($rdata))
														{
															$error_array = "Ok";
														}
														else
														{
															$error_array = "Record Not Inserted.";
															$complete_status = 1;
														}
											}
											else
											{
												$error_array = "Record already inserted.";
												$complete_status = 1;
											}
								  	}
									else
									{
										$error_array = "Currency Not Found.";
										$complete_status = 1;
									}
								}
								else
								{
										$error_array = "Country Not Found.";
										$complete_status = 1;
								}
							}
							else
							{
									$error_array = "Blank Row.";
									$complete_status = 1;
							}
							if($complete_status ==1)
							{
								array_push($error,$error_array);
								array_push($error_line,$line_no);
							}
						 $line_no++;
					}
						fclose($file);
					  
					 if(empty($error_array))
					 {
					 	 $row['res'] = 1;
					 }
					 else
					 {
						  $row['res'] = 4;
						  $str = '<table class="table table-bordered" width="100%"> 
									<tr>
										<td>Line No</td>
										<td>Error</td>
									</tr>
								';
								for($e=0;$e<count($error);$e++)
								{
									$str .= '
										<tr>
											<td>'.$error_line[$e].'</td>
											<td>'.$error[$e].'</td>
										</tr>
									';
									
								}
							$str .= '</table>';
						  $row['error_html'] =$str; 
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
	private function set_upload_options1($newfilename,$filename)
	{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.'.'.$extension;
			$config['upload_path'] = './upload/csv/';
			$config['allowed_types'] = 'csv';
			$config['max_size']      = '5000';
			$config['overwrite']     = TRUE;

			return $config;
	}

	public function form()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data['forwarername'] = implode(",",$this->input->post('forwarer_id'));
			$data['fd']	= 'manage';
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();
			//country Data
			$this->load->model('admin_country_detail');
			$data['countrydata'] = $this->admin_country_detail->s_select();
			$this->load->model('Payment_terms_model');
			$data['paymenttermsdata']	= $this->Payment_terms_model->get_payment_terms_data();	
			
			$this->load->model('Agentmaster_model');
			$data['agentname']	= $this->Agentmaster_model->showagent_records1();	
			//$data['getcustdata'] 		= $this->sli->get_customer($id);
			$this->load->model('Forwarer_master_model');
			$data['forwarerdata']	= $this->Forwarer_master_model->supplier_select();	
			$data['company_data']	 	= $this->sli->getcompanydata();	
			$data['mode'] = 'New';
			$data['currencydata'] = $this->sli->getcurrencydata();
			$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
						
			$this->load->view('admin/customer_detail',$data);
		}
		else
		{
			$this->load->view('admin/index');
		}	

	}
		private function set_upload_options()
		{   
			//upload an image options
			$config = array();
			$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = '5000';
			$config['overwrite']     = FALSE;

			return $config;
		}
		
		public function manage()
		{
			$check_consigne = $this->sli->check_consigne_id($this->input->post('c_companyname'));
			$forwarername = implode(",",$this->input->post('forwarer_id'));
		 	$data = array(
						'agent_id'				=> $this->input->post('agent_id'),
						'forwarer_id'			=> $forwarername,
						'c_name' 				=> $this->input->post('c_name'),
						'c_companyname' 		=> $this->input->post('c_companyname'),
						'c_nick_name' 			=> $this->input->post('c_nick_name'),
						'c_postcode' 			=> $this->input->post('c_postcode'),
						'c_address' 			=> nl2br($this->input->post('c_address')),
						'c_city' 				=> $this->input->post('c_city'),
						'c_state' 				=> $this->input->post('c_state'),
						'c_country' 			=> $this->input->post('country_id'),
						'shippment_days' 			=> $this->input->post('shippment_days'),
						'currency_id' 			=> $this->input->post('currency_id'),
						'c_registration_detail' => $this->input->post('c_registration_detail'),
						'c_contact' 			=> $this->input->post('c_contact'),
						'c_email_address' 		=> $this->input->post('c_email_address'),
						'c_web_address' 		=> $this->input->post('c_web_address'),
						'port_of_discharge' 	=> $this->input->post('custport_of_discharge'),
						'payment_terms'			 => $this->input->post('payment_terms'),
						'payment_type'			 => $this->input->post('payment_type'),
						'auto_payment_remainder' => $this->input->post('auto_payment_remainder'),
						'credit_days' 			 => $this->input->post('credit_days'),
						'credit_limit' 			 => $this->input->post('credit_limit'),
						'customer_type'			 => $this->input->post('customer_type'),
						'rex_detail_status'		 => $this->input->post('rex_detail_status'),
						'rex_no_detail'			 => $this->input->post('rex_no_detail')
				 	);
					
				$id = $this->input->post('cust_id');
				if(!empty($id))
				{					
					if(empty($check_consigne) || $this->input->post('edit_companyname') == $this->input->post('c_companyname'))
					{
						$rs = $this->sli->s_edit($data,$id);
						if($rs)
						{
							$row['id'] = $id;
							$row['res'] = 2;
						}
						else
						{
							$row['res'] = 0;
						}
					}
					else
					{
						$row['res'] = 3;
					}
				}
				else
				{
					if(empty($check_consigne))
					{
									
						$rdata = $this->sli->s_insert($data);
						if(!empty($rdata))
						{
							if($this->session->usertype_id != 1)
							{
								$data = array(
									'user_id' 	 	=> $this->session->user_id,
									'customer_id' 	=> $rdata,
									'cdate'   		=> date('Y-m-d H:i:s'),
									'status'   	   	=> 0
								);
								
								$insertid = $this->sli->insert_user_customer($data);
								
							}
							$check_box_design = $this->sli->check_terms_update($this->input->post('payment_terms'));
							if(empty($check_box_design ))
							{
								$data1 = array(
										'payment_terms' => $this->input->post('payment_terms')	
								);
								$rdata1 = $this->sli->terms_insert($data1);
							}
							$row['id'] = $rdata;
							$row['cname'] = $this->input->post('c_name');
							$row['c_companyname'] = $this->input->post('c_companyname');
							$row['res'] = 1;
						
						}
						else
						{
							$row['res'] = 0;
							
						}
					}
					else
					{
						$row['res'] = 3;
					}
				}
				 echo json_encode($row);
			
		}	
		
		public function opening_balance_manage()
		{
			$data = array(
						'opening_balance' 		=> $this->input->post('opening_balance'),
						'open_balance_status' 	=> $this->input->post('open_balance_status') 
				 	);
			$id = $this->input->post('customerid');	 
		 
			$rs = $this->sli->s_edit($data,$id);		 
			if($rs)
			{
				$row['res'] = 1;
			}
			else{
				$row['res'] = 2;
			}
				 echo json_encode($row);
			
		}	
		
		public function form_edit($id)
		{

				if(!empty($this->session->id)  && $this->session->title == TITLE)
				{
				$data = $this->sli->s_edit_select($id);
				$consign = 	$this->sli->consign_select($id);
				$this->load->model('admin_company_detail');	
				$this->load->model('Payment_terms_model');
				$this->load->model('Agentmaster_model');	
				$this->load->model('Forwarer_master_model');
				//country Data
				$this->load->model('admin_country_detail');
				$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			 	$v = array('fd'=>'edit','fdv'=>$data,'consign_detail'=>$consign,'company_detail' => $this->admin_company_detail->s_select(),'countrydata' => $this->admin_country_detail->s_select(),'paymenttermsdata' => $this->Payment_terms_model->get_payment_terms_data(),'agentname' => $this->Agentmaster_model->showagent_records1(),'forwarerdata' => $this->Forwarer_master_model->supplier_select(),'getcustdata' => $this->sli->get_customer($id),'currencydata' => $this->sli->getcurrencydata(),'mode' => 'Edit','menu_data' => $menu_data);
	
				$this->load->view('admin/customer_detail',$v);	
			}
			else
			{
				$this->load->view('admin/index');
			}					
		 }

	 
		public function delete_record(){
			
			$id = $this->input->post('id');
			$deleterecord = $this->sli->s_del($id);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
	
		}
		public function archive_record()
		{
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$deleterecord = $this->sli->archive_record($id,$status);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
	
		}
	
	public function assignmanage()
	{
		foreach($this->input->post('user_id') as $user)
		{
			$data = array(
					'customer_id' 	 	=> $this->input->post('customer_id1'),
					'user_id' 			=> $user,
				 	'cdate'   			=> date('Y-m-d H:i:s'),
					'status'   	   		=> 0
				);
				$insertid = $this->sli->insert_customer_user($data);
		}
		 
			$row['res'] = 1;
			$row['customer_id'] =  $this->input->post('customer_id1');
		 echo json_encode($row);
	}
	
	public function assignmanagedesign()
	{
		foreach($this->input->post('user_id1') as $user)
		{
    foreach ($this->input->post('designid1') as $designid) {
        $data = array(
            'customer_id' => $this->input->post('customer_id1'),
            'designid'    => $designid,
           	'user_id' 			=> $user,
            'cdate'       => date('Y-m-d H:i:s'),
            'status'      => 0
        );
        $insertid = $this->sli->insert_customer_design($data);
    }
	}


		 
			$row['res'] = 1;
			$row['customer_id'] =  $this->input->post('customer_id1');
			$row['designid'] =  $this->input->post('designid1');
		 echo json_encode($row);
	}
	
	public function fetchuser_data()
	{
		$get_customer_wise_user = $this->sli->get_customer_wise_user($this->input->post('customer_id1'));
		$row['user_cust_data'] = '';
		$str = '<table class="table table-bordered">
					<tr>
						<td>Sr No</td>
						<td>User Name</td>
						<td>Action</td>
					</tr>';
					$cust_array = array();
					if(!empty($get_customer_wise_user))
					{
						$no =1;
		foreach($get_customer_wise_user as $custrow)
		{
			$str .= ' 
					<tr>
						<td>'.$no.'</td>
						<td>'.$custrow->user_name.'</td>
						<td>
							<a class="tooltips btn btn-danger" onclick="reamove_assign_user('.$custrow->user_wise_customer_id.','.$custrow->customer_id.')" data-title="Remove Customer" href="javascript:;" ><i class="fa fa-user-minus"></i> Remove User</a>
						</td>
					</tr>';
					$no++;
					array_push($cust_array,$custrow->user_id);
		}
					}
					else
					{
						$str .= ' 
					<tr>
						<td colspan="3" class="text-center">Not Assigned Yet</td>
						 
					</tr>';
					}
			$str .= '</table>';
		
		$get_customer_name = $this->sli->getuser();
		$row_array = array();
		$cust= '';
		foreach($get_customer_name as $cust_row)
		{
			if(!in_array($cust_row->user_id,$cust_array))
			{
				$cust .= '<option  value="'.$cust_row->user_id.'">'.$cust_row->user_name.'</option>';
			}
		}
		$row['cust_data'] = $cust;
		$row['assigncust'] = $str;
		
		echo json_encode($row);
	}
	
	
	public function fetchudesign_data()
	{
		$get_customer_wise_designs = $this->sli->get_customer_wise_designs($this->input->post('designid1'));
		$row['user_design_data'] = '';
		$str = '<table class="table table-bordered">
					<tr>
						<td>Sr No</td>
						<td>Design Name</td>
						<td>Action</td>
					</tr>';
					$cust_array = array();
					if(!empty($get_customer_wise_designs))
					{
						$no =1;
		foreach($get_customer_wise_designs as $custrow)
		{
			$str .= ' 
					<tr>
						<td>'.$no.'</td>
						<td>'.$custrow->model_name.'</td>
						<td>
							<a class="tooltips btn btn-danger" onclick="reamove_assign_user('.$custrow->design_wise_customer_id .','.$custrow->designid.')" data-title="Remove Design" href="javascript:;" ><i class="fa fa-user-minus"></i> Remove Design</a>
						</td>
					</tr>';
					$no++;
					array_push($cust_array,$custrow->designid);
		}
					}
					else
					{
						$str .= ' 
					<tr>
						<td colspan="3" class="text-center">Not Assigned Yet</td>
						 
					</tr>';
					}
			$str .= '</table>';
		
		$get_customer_name = $this->sli->getdesigndata();
		$row_array = array();
		$cust= '';
		foreach($get_customer_name as $cust_row)
		{
			if(!in_array($cust_row->packing_model_id,$cust_array))
			{
				$cust .= '<option  value="'.$cust_row->packing_model_id.'">'.$cust_row->model_name.'</option>';
			}
		}
		$row['design_data'] = $cust;
		$row['assigndesign'] = $str;
		
		echo json_encode($row);
	}
	
	public function remove_user_record()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data = array(
				 'status'    => 2
			 );
			 
	 	$updatedid = $this->sli->remove_user_record($id,$data);
		$row = array();
		if($updatedid)
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
 
       echo json_encode( $data);
    } 
	
	public function searchforconsigner(){
 
       $term = $this->input->get('term');
 
       $this->db->like('payment_terms', $term);
		$this->db->limit(5);
       $data = $this->db->get("tbl_payment_terms")->result();
 
       echo json_encode( $data);
    } 	
	
	public function search1(){
 
        $term = $this->input->get('term');
 
        $this->db->like('port_name', $term);
		$this->db->limit(10);
        $data = $this->db->get("tbl_port_master")->result();
 
        echo json_encode( $data);
    }
	
	public function portsearchforconsigner(){
 
        $term = $this->input->get('term');
 
        $this->db->like('port_name', $term);
		$this->db->limit(15);
        $data = $this->db->get("tbl_port_master")->result();
 
        echo json_encode( $data);
    }
     
}
?>