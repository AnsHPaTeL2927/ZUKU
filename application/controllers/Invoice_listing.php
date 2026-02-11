<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Invoice_listing extends CI_controller
{
	  public function __construct()
	  {
	  	parent:: __construct();
	  	$this->load->helper('url');
	  	$this->load->library(array('form_validation','session','encrypt'));
	  	$this->load->model('admin_invoice_list','invoice');
	  	$this->load->model('menu_model','menu');
		$this->load->library('Email_service');
	  	if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
	  		redirect(base_url());
	  	}
	  }	
	  public function index($m="")
	  {
	  	if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data['erd']= $m;
			$this->load->model('admin_company_detail');	
			$data['company_detail']  = $this->admin_company_detail->s_select();	
			$data['menu_data']		 = $this->menu->usermain_menu($this->session->usertype_id);	
			$data['allproductsize']	 = $this->invoice->allproductsize();
			$data['alldesign']	 	 = $this->invoice->alldesign();
			$data['allfinish']	 	 = $this->invoice->allfinish();
			$data['consign_data']	 = $this->invoice->select_consigner();
			$this->load->view('admin/invoice_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}

	  }
	  public function fetch_record()
	  {
	 	$cust_id = $this->input->get('cust_id');
		$invoice_status = $this->input->get('invoice_status');
		if ($invoice_status === null || $invoice_status === '') {
			$invoice_status = '0';
		}
		$dateVal = $this->input->get('date');
		if (empty($dateVal) || strpos($dateVal, ' - ') === false) {
			$year = date('n') > 3 ? date('d/m/Y', strtotime('1 April ' . date('Y'))) . ' - ' . date('d/m/Y', strtotime('31 March ' . (date('Y') + 1))) : date('d/m/Y', strtotime('1 April ' . (date('Y') - 1))) . ' - ' . date('d/m/Y', strtotime('31 March ' . date('Y')));
			$dateVal = $year;
		}
		$invoicedate = explode(" - ", $dateVal);
		$start = isset($invoicedate[0]) ? strtotime(trim($invoicedate[0])) : strtotime('-1 year');
		$end = isset($invoicedate[1]) ? strtotime(trim($invoicedate[1])) : strtotime('today');
		if ($start === false) { $start = strtotime('-1 year'); }
		if ($end === false) { $end = strtotime('today'); }
		$where = ' and performa_date BETWEEN "' . date('Y-m-d', $start) . '" and "' . date('Y-m-d', $end) . '"';

		$countGet = array('iDisplayLength' => '-1');
		 
		if($invoice_status==1)
		{
			$where .= ' and step=3';
			$where .= ' and confirm_status!=2';
		}
		else if($invoice_status==0)
		{
			$where .= ' and confirm_status!=2';
		}
		else if($invoice_status==2)
		{
			$where .= ' and step=1';
			$where .= ' and confirm_status!=2';
		}
	  	else if($invoice_status==3)
		{
			$where .= ' and step=2';
			$where .= ' and confirm_status!=2';
		 
		}
		else if($invoice_status==4)
		{
			$where .= ' and confirm_status=2';
		 
		}
		$_SESSION['pi_s_date'] = isset($invoicedate[0]) ? trim($invoicedate[0]) : '';
		$_SESSION['pi_e_date'] = isset($invoicedate[1]) ? trim($invoicedate[1]) : '';
		$_SESSION['pi_step_status'] = $invoice_status;
		
		if(!empty($cust_id))
		{
			$where .= ' and mst.consigne_id = '.$cust_id;
			$_SESSION['pi_cust_id'] = $cust_id;
		}	
		else
		{
			$_SESSION['pi_cust_id'] = '';
		}
		 // if($this->session->usertype_id != 1)
		// {
			// $where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		// }

		try {
				$this->load->model('Pagging_model');
				$aColumns = array('performa_invoice_id', 'invoice_no','performa_date','consign.c_companyname','mst.country_final_destination','mst.container_details','(SELECT GROUP_CONCAT(distinct  product.size_type_mm) from tbl_performa_trn as ptrn inner join tbl_product as product on product.product_id = ptrn.product_id where invoice_id = mst.performa_invoice_id) as size_ordered','(SELECT sum(no_of_boxes) from tbl_performa_packing as packing inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id where ptrn.invoice_id = mst.performa_invoice_id ) as total_boxes','(SELECT sum(no_of_sqm) from tbl_performa_packing as packing inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id where ptrn.invoice_id = mst.performa_invoice_id ) as total_sqm','grand_total','(SELECT DATEDIFF(CURDATE(),performa_date) FROM `tbl_performa_invoice` as daysinvoice where daysinvoice.performa_invoice_id = mst.performa_invoice_id ) as ago_days','user.user_name','mst.port_of_discharge','mst.status','mst.cdate','step','no_of_export','no_of_po','cur.currency_name','cur.currency_id','cur.currency_code','mst.consigne_id','addition_detail_status','confirm_status','consign.c_nick_name');
				$isWhere = array("mst.status = 0 and confirm_status != 1".$where);
				$table = "tbl_performa_invoice as mst";
				$isJOIN = array(
								'left join customer_detail consign on consign.id=mst.consigne_id',
								'left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id',
								'left join country_detail country on country.id=mst.invoice_currency_id',
								'left join tbl_user user on user.user_id=mst.user_id'
								);
				$hOrder = "mst.performa_invoice_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $this->input->get());
				$appData = array();
				$no = (int) $this->input->get('iDisplayStart') + 1;
				$rows = isset($sqlReturn['data']) && is_array($sqlReturn['data']) ? $sqlReturn['data'] : array();

				foreach ($rows as $row)
				{
					$row_data = array();
					$step_status='';
					 
					if($row->step==1)
					{
						$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="'.base_url().'product/index/'.$row->performa_invoice_id.'"><i class="glyphicon glyphicon-stop"></i></a> ';
					}
					else if($row->step==2)
					{
						$step_status = '<a class="btn btn-info tooltips" data-toggle="tooltip" data-title="Add Additional Detail" href="'.base_url().'addition_details/index/'.$row->performa_invoice_id.'"><i class="fa fa-square-o"></i></a> ';
					}
					else if($row->step==3)
					{ 
						$step_status = '<a class="btn btn-success tooltips" data-toggle="tooltip" data-title="Proforma Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i></a> ';
					}
					$row_data[] = $step_status;
					if($row->step==3)
					{
						$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="Open Page" href="javascript:;"  onclick="view_detail('.$row->performa_invoice_id.')">'.$row->invoice_no.'</a>';
					}
					else
					{
						$row_data[] = $row->invoice_no;
					}
					$row_data[] = date('d/m/Y',strtotime($row->performa_date));
					$consige_name = !empty($row->c_nick_name)?$row->c_nick_name:$row->c_companyname;
					$row_data[] = $consige_name;
					 
					$row_data[] = $row->country_final_destination;
					$row_data[] = $row->container_details;
					$row_data[] = str_replace(",","<br>",$row->size_ordered);
					$row_data[] = ($row->total_boxes > 0)?$row->total_boxes:0;
					$row_data[] = number_format($row->total_sqm,2,'.','');
				 
					 
					$currency = !empty($row->currency_code) ? $row->currency_code : 'USD';
					$currency_symbol = '$';
					if (class_exists('NumberFormatter')) {
						try {
							$fmt = new NumberFormatter('en-US@currency=' . $currency, NumberFormatter::CURRENCY);
							$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
						} catch (Exception $e) {
							$currency_symbol = ($currency === 'USD') ? '$' : $currency . ' ';
						}
					}

					$row_data[] = $currency_symbol . ' ' . number_format((float) $row->grand_total, 2, '.', '');

					$color = '';
					$ago_days = isset($row->ago_days) ? (int) $row->ago_days : 0;
					$months = (int)($ago_days / 30);
					$d = (int)($ago_days - ($months * 30));
					$m_str = $months > 0 ? $months . ' Months ' : '';
					$label = $m_str . $d . ' days';
				if ($ago_days > 7 && $ago_days < 14)
				{
					
					$color = '<a class="tooltips btn" style="background:green;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				 
				}
				else if ($ago_days >= 14 && $ago_days < 21)
				{
					$color = '<a class="tooltips btn" style="background:blue;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if ($ago_days >= 21 && $ago_days < 28)
				{
					$color = '<a class="tooltips btn" style="background:purple;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if ($ago_days >= 28 && $ago_days < 60)
				{
					$color = '<a class="tooltips btn" style="background:orange;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if ($ago_days >= 60 && $ago_days < 90)
				{
					$color = '<a class="tooltips btn" style="background:gray;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if ($ago_days >= 90)
				{
					$color = '<a class="tooltips btn" style="background:red;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if ($ago_days == 0)
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="Today" href="javascript:;">Today</a>';
				}
				else
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
			 	
				$row_data[] 	= $color;
					$row_data[] = $row->user_name;
					$viewinvoice='';
					$checkbox = '';
					
					$edit='<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'invoice/form_edit/'.$row->performa_invoice_id.'"><i class="fa fa-pencil"></i>Edit</a>
							</li>';
					$delete='<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->performa_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
							</li>';

					// if($this->session->usertype_id != 3)
					// {
					// $edit='<li>
								// <a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'invoice/form_edit/'.$row->performa_invoice_id.'"><i class="fa fa-pencil"></i>Edit</a>
							// </li>';
					// $delete='<li>
								// <a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->performa_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
							// </li>';
					// }
					
					if ($ago_days > 90)	
					{
						if($row->confirm_status == 2)
						{
							$delete .='<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Archived"  onclick="confirm_pi('.$row->performa_invoice_id.',0)" href="javascript:;" ><i class="fa fa-archive"></i> Archived</a>
								</li>';
						}
						else
						{
							$delete .='<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Archive"  onclick="confirm_pi('.$row->performa_invoice_id.',2)" href="javascript:;" ><i class="fa fa-archive"></i> Archive</a>
								</li>';
						}	
					}						
					if($row->step==3)
					{
						if($row->confirm_status == 1)
						{
							$exportinvoice= '
							 	<a class="tooltips" data-toggle="tooltip" data-title="Confirm PI" href="javascript:;" ><i class="fa fa-check-square-o"></i> Confirmed PI</a>
								<a class="tooltips" data-toggle="tooltip" data-title="Label Printing" href="'.base_url('invoicelabelprinting/index/'.$row->performa_invoice_id).'"   ><i class="fa fa-print"></i> Pallets Label </a>
								<a class=" tooltips" data-toggle="tooltip" data-title="Create Purchase Order" href="'.base_url('createpo/index/'.$row->performa_invoice_id).'"> <i class="fa fa-plus"></i> Create PO ('.$row->no_of_po.')</a>
						 		
								<!--<a class=" tooltips" data-toggle="tooltip" data-title="Create Export Invoice" href="'.base_url('exportinvoice/index/'.$row->performa_invoice_id).'"> <i class="fa fa-plus"></i>  Export Invoice ('.$row->no_of_export.')</a>-->';
								$edit ='';
								$delete ='';
						}
						else
						{
							
							$exportinvoice = '<a class="tooltips" data-toggle="tooltip" data-title="Confirm PI"  onclick="confirm_pi('.$row->performa_invoice_id.',1)" href="javascript:;" ><i class="fa fa fa-square-o"></i> Confirm PI</a>';
						}
					 
					 	$viewinvoice='<li>
										 
											<a class="tooltips" data-toggle="tooltip" data-title="View PI" href="'.base_url('performa_invoice_pdf/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> View PI</a>
										  '.$exportinvoice.'
									 </li> ';
					}
					
					 
						
					 
					$row_data[] = '
								 <div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
												'.$edit.'
												'.$viewinvoice.' 
												'.$delete.'
									</div> 
								 ';
					 $appData[] = $row_data;
				}
			$totalrecord = $this->Pagging_model->count_all($aColumns, $table, $hOrder, $isJOIN, $isWhere, $countGet);
					$numrecord = is_array($sqlReturn['data']) ? count($sqlReturn['data']) : 0;
				$output = array(
							"sEcho" => intval($this->input->get('sEcho')),
							"iTotalRecords" => (int) $totalrecord,
							"iTotalDisplayRecords" => (int) $totalrecord,
							"aaData" => $appData
					);
				$this->output->set_content_type('application/json')->set_output(json_encode($output));
		} catch (Exception $e) {
				log_message('error', 'Invoice_listing fetch_record: ' . $e->getMessage());
				$err = array(
					'sEcho' => (int) $this->input->get('sEcho'),
					'iTotalRecords' => 0,
					'iTotalDisplayRecords' => 0,
					'aaData' => array()
				);
				$this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($err));
		}
	  } 
	  public function confirmpi()
	  {
	  	$id     = $this->input->post('id');
	  	$status = $this->input->post('status');
	  	$deleterecord = $this->invoice->confirmpi($id, $status);
	  	if ($deleterecord && $status == 1) {
	  		$this->email_service->send_pi_confirmed_email($id);
	  	}
	  	$row = array('res' => $deleterecord ? '1' : '0');
	  	echo json_encode($row);
	  }
	  
	   public function loaded_size()
	  {
				$id = $this->input->post('performa_invoice_id');
				$size_id 	  = $this->input->post('size_id');
				$finish_id	  = $this->input->post('finish_id');
				$design_id 	  = $this->input->post('design_id');
				$product_data = $this->invoice->get_productdetail($id,$size_id,$finish_id,$design_id);
					
				$str = '<table class="table table-bordered table-hover" id="sample-table-1">
								<thead>
									<tr>
									 	<th>Sr No.</th>
										<th>Size</th>
										<th>Design Name</th>
										<th>Finish</th>
										<th>Boxes</th>
								 	</tr>
								</thead>
								<tbody>';
						 $no=1;
						for($i=0; $i<count($product_data);$i++)
						{ 
								$str .= '<tr>
										<td rowspan="'.$rowspan.'">'.$no.'</td>
										<td>'.$product_data[$i]->size_type_mm.'</td>
										<td>'.$product_data[$i]->model_name.'</td>
										<td>'.$product_data[$i]->finish_name.'</td>
										<td>'.$product_data[$i]->origanal_boxes.'</td>
										 
								 	</tr>
									';
									$no++;
							  
							
						}							
													
						$str .= '</tbody></table>';
				echo $str;
			}
	   public function remaining_size()
	  {
				$id = $this->input->post('performa_invoice_id');
				$size_id 	  = $this->input->post('size_id');
				$finish_id	  = $this->input->post('finish_id');
				$design_id 	  = $this->input->post('design_id');
				
				$product_data = $this->invoice->get_remainingproductdetail($id,$size_id,$finish_id,$design_id);
				 	
				$str = ' <table class="table table-bordered table-hover" id="sample-table-1">
								<thead>
									<tr>
									
										<th>Sr No.</th>
										<th>Size</th>
										<th>Design Name</th>
										<th>Finish</th>
										<th>Boxes</th>
										<th>SQM</th>
								 	</tr>
								</thead>
								<tbody>';
													$no=1;
						for($i=0; $i<count($product_data);$i++)
						{ 
							 
							foreach($product_data[$i]->packing  as $packing_row)
							 {
								$str .= '<tr>
										<td rowspan="'.$rowspan.'">'.$no.'</td>
										<td>'.$product_data[$i]->size_type_mm.'</td>
										<td>'.$packing_row->model_name.'</td>
										<td>'.$packing_row->finish_name.'</td>
										<td>'.$packing_row->no_of_boxes.'</td>
										<td>'.$packing_row->no_of_sqm.'</td>
								 	</tr>
									';
									$no++;
							}	 
							
						}							
													
						$str .= '</tbody></table>';
				echo $str;
			}
	 
	  public function deleterecord()
	  {
		  $this->load->model('admin_invoice');
	  	$id = $this->input->post('id');
		$selectinvoicetype 	= $this->admin_invoice->selectinvoicetype(1);
		$update = $this->admin_invoice->update_invoicenumber(1,(str_pad($selectinvoicetype->invoice_series - 1,strlen($selectinvoicetype->invoice_series), '0', STR_PAD_LEFT)));
		
	  	$deleterecord = $this->invoice->invoice_delete($id);
		
	  		if($deleterecord)
	  		{
	  			$row['res'] = '1';
	  		}
	  		else{
	  			$row['res'] = '0';
	  		}
	  		echo json_encode($row);
	  }
	   
	  public function viewproductdetail(){
				$id = $this->input->post('id');
				$result = $this->invoice->get_productdetail($id);
				$currency_id = $this->input->post('currency_id');
				$ratelabel = ($currency_id==1)?"Rate In USD":"Rate In Ëuro";
				$currency_sybol = ($currency_id==1)?"$":"&euro;";
					
				$str = ' <table class="table table-bordered table-hover" id="sample-table-1">
								<thead>
									<tr>
									
										<th width="5%">Sr No.</th>
										<th width="55%">Description od Goods</th>
										<th width="5%">Plts</th>
										<th width="5%">Boxes</th>
										<th width="5%">SQM</th>
										<th width="10%">'.$ratelabel.'</th>
										<th width="5%">Per</th>
										<th width="10%">Total Amount</th>
										
									</tr>
								</thead>
								<tbody>';
													$no=1;
						for($i=0; $i<count($result);$i++)
						{
							 
							$jsondata = $result[$i];
							$rate =  $jsondata->Rate_In_USD;
						 
							if($jsondata->defualt_status==1)
							{
							 $rowspan=(count($jsondata->serices)>0)?(count($jsondata->serices)+1):'';
							 
							$str .= '<tr>
										<td rowspan="'.$rowspan.'">'.$no.'</td>
										<td>'.$jsondata->description_goods.'</td>
										<td>'.$jsondata->total_pallet.'</td>
										<td>'.$jsondata->Boxes.'</td>
										<td>'.$jsondata->SQM.'</td>
										<td>'.$currency_sybol.' '.$rate.'</td>
										<td>'.$jsondata->Per.'</td>
										<td>'.$currency_sybol.' '.$jsondata->Total_Amount.'</td>
										 
									</tr>
									';
							}	 
								for($s=0;$s<count($jsondata->serices);$s++)
								{
									$str .= '<tr>';
									  if($jsondata->defualt_status==0)
									 {
										
										if($s==0)
										{
											
											$str .='<td rowspan="'.count($jsondata->serices).'">'.$no.'</td>';
										}
									 }
										$str .='<td>'.$jsondata->serices[$s]->description_goods.' - '.$jsondata->serices[$s]->seriesgroup_name.'</td>
										<td>'.$jsondata->serices[$s]->group_total_pallet.'</td>
										<td>'.$jsondata->serices[$s]->group_total_boxes.'</td>
										<td>'.$jsondata->serices[$s]->group_SQM.'</td>
										<td>'.$currency_sybol.' '.$jsondata->serices[$s]->group_Rate_In_USD.'</td>
										<td>'.$jsondata->Per.'</td>
										<td>'.$currency_sybol.' '.$jsondata->serices[$s]->group_productrate.'</td>
									</tr>
									';
								}
							 
									$no++;
						}							
													
						$str .= '</tbody></table>';
				echo $str;
			}
	  public function copy_mutiple_invoice()
	  {
	  	  	$performa_invoice_id = $this->input->post('performa_invoice_id');
		 	$checkcongine = $this->invoice->check_congine($performa_invoice_id);
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
