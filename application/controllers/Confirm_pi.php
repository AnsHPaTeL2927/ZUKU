<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Confirm_pi extends CI_controller
{
	  public function __construct()
	  {
	  	parent:: __construct();
	  
		$this->load->model('admin_invoice_list','invoice');
	  	$this->load->model('Admin_pdf');
		$this->load->model('admin_product_invoice','pinv');
		$this->load->model('menu_model','menu');	
	  	if (!isset($_SESSION['id']) && $this->session->title == TITLE)
		{
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
			$this->load->view('admin/confirm_pi',$data);
		}
		else
		{
			redirect(base_url().'');
		}

	  }
	  public function fetch_record()
	  {
	 
		$invoice_status = $this->input->get('invoice_status');
		$cust_id = $this->input->get('cust_id');
		$dateVal = $this->input->get('date');
		if (empty($dateVal) || strpos($dateVal, ' - ') === false) {
			$year = date('n') > 3 ? date('d-m-Y', strtotime('1 April ' . date('Y'))) . ' - ' . date('d-m-Y', strtotime('31 March ' . (date('Y') + 1))) : date('d-m-Y', strtotime('1 April ' . (date('Y') - 1))) . ' - ' . date('d-m-Y', strtotime('31 March ' . date('Y')));
			$dateVal = $year;
		}
		$invoicedate = explode(" - ", $dateVal);
		$start = isset($invoicedate[0]) ? strtotime(trim($invoicedate[0])) : strtotime('-1 year');
		$end = isset($invoicedate[1]) ? strtotime(trim($invoicedate[1])) : strtotime('today');
		if ($start === false) { $start = strtotime('-1 year'); }
		if ($end === false) { $end = strtotime('today'); }
		$where = ' and performa_date BETWEEN "' . date('Y-m-d', $start) . '" and "' . date('Y-m-d', $end) . '"';
		$_SESSION['cpi_s_date'] = isset($invoicedate[0]) ? trim($invoicedate[0]) : '';
		$_SESSION['cpi_e_date'] = isset($invoicedate[1]) ? trim($invoicedate[1]) : '';
		
		// Get days filter
$days_filter = $this->input->get('days_filter');
$_SESSION['cpi_days_filter'] = $days_filter; // Store in session for persistence
		
		if(!empty($cust_id))
		{
			$where .= ' and mst.consigne_id = '.$cust_id;
			$_SESSION['cpi_cust_id'] = $cust_id;
		}	
		else
		{
			$_SESSION['cpi_cust_id'] = '';
		}	
		// Add days after confirm filter
if (!empty($days_filter)) {
    $range = explode('-', $days_filter);
    if (count($range) == 2) {
        if ($range[1] == '') {
            // For "90-" case
            $where .= " AND (SELECT DATEDIFF(CURDATE(),confirm_date) FROM tbl_performa_invoice WHERE performa_invoice_id = mst.performa_invoice_id) >= " . (int)$range[0];
        } else {
            // For ranges like "0-7", "7-14"
            $where .= " AND (SELECT DATEDIFF(CURDATE(),confirm_date) FROM tbl_performa_invoice WHERE performa_invoice_id = mst.performa_invoice_id) BETWEEN " . (int)$range[0] . " AND " . (int)$range[1];
        }
    }
}
		// if($this->session->usertype_id != 1)
		// {
			// $where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		// } 		
		try {
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('mst.performa_invoice_id', 'invoice_no','consign.c_companyname','grand_total','performa_date','time','mst.container_details','(SELECT GROUP_CONCAT(distinct  product.size_type_mm) from tbl_performa_trn as ptrn inner join tbl_product as product on product.product_id = ptrn.product_id where invoice_id = mst.performa_invoice_id) as size_ordered','mst.port_of_discharge','mst.status','mst.cdate','step','no_of_export','no_of_po','cur.currency_name','cur.currency_id','cur.currency_code','mst.consigne_id','addition_detail_status','confirm_date','confirm_status','user.user_name','payment.pi_advance_payment_id','payment.status as payment_status','(SELECT DATEDIFF(CURDATE(),confirm_date) FROM `tbl_performa_invoice` as daysinvoice where daysinvoice.performa_invoice_id = mst.performa_invoice_id ) as ago_days');
				$isWhere = array("mst.status = 0 and confirm_status=1 and step=3 ".$where);
				$table = "tbl_performa_invoice as mst";
				$isJOIN = array(
								'left join customer_detail consign on consign.id=mst.consigne_id',
								'left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id',
								'left join tbl_pi_advance_payment payment on payment.performa_invoice_id = mst.performa_invoice_id',
								'left join tbl_user user on user.user_id=mst.user_id'
								);
				$hOrder = "mst.performa_invoice_id desc";
				$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = (int) $this->input->get('iDisplayStart') + 1;
				$rows = isset($sqlReturn['data']) && is_array($sqlReturn['data']) ? $sqlReturn['data'] : array();
				 
				foreach($rows as $row) 
				{
					
						$set_container		= 	$this->Admin_pdf->product_set_data($row->performa_invoice_id,-2);
						$setcontainer = 0;
						$conarray = array();
						if(!empty($set_container) && is_array($set_container))
						{
							for($i=0; $i<count($set_container);$i++)
							{
								 
								if(!in_array($set_container[$i]->con_entry,$conarray))
								{
									$setcontainer += $set_container[$i]->container;
									array_push($conarray,$set_container[$i]->con_entry);
																
								}
							}
						}
					
					if($setcontainer != $row->container_details || empty($set_container))
					{		
						$row_data = array();
						$viewinvoice		= '';
						$viewinvoice1		= '';
						$checkbox 			= '';
						 $edit='<li>
								<a class="tooltips" data-toggle="tooltip" data-title=" Edit" href="'.base_url().'invoice/form_edit/'.$row->performa_invoice_id.'"><i class="fa fa-pencil"></i> Edit</a>
							</li>';
							$check_production_sheet = $this->pinv->check_production_sheet($row->performa_invoice_id);
							
							$reverase_btn = '<a class="tooltips" data-toggle="tooltip" data-title="Move to Pending" href="javascript:;" onclick="confirm_pi('.$row->performa_invoice_id.',0)"  ><i class="fa fa-check-square-o"></i> Move to Pending</a>';
							
							if($check_production_sheet > 0)
							{
								$reverase_btn 	= '';
								$edit 			= '';
							}
							if($row->payment_status == 1)
							{
								$advance_payment_btn = ' <a class="tooltips" data-toggle="tooltip" data-title="Edit Advance Payment" href="javascript:;"  ><i class="fa fa-money"></i> Payment Done</a>';
								$reverase_btn 	= '';
							}
							else if(!empty($row->pi_advance_payment_id))
							{
								$advance_payment_btn = ' <a class="tooltips" data-toggle="tooltip" data-title="Edit Advance Payment" href="javascript:;" onclick="edit_advance_payment('.$row->performa_invoice_id.',&quot;'.$row->invoice_no.'&quot;,'.$row->consigne_id.')" ><i class="fa fa-money"></i> Edit Advance Payment</a>';
							}
							else
							{
								$advance_payment_btn = ' <a class="tooltips" data-toggle="tooltip" data-title="Advance Payment" href="javascript:;" onclick="advance_payment('.$row->performa_invoice_id.',&quot;'.$row->invoice_no.'&quot;,'.$row->consigne_id.')" ><i class="fa fa-money"></i> Advance Payment</a>';
							}
						$viewinvoice= '<li>
											'.$reverase_btn.'
											'.$advance_payment_btn.'
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="'.base_url('performa_invoice_pdf/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="'.base_url('performa_invoice_pdf/index_pending/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI  (Loading Pending)</a>
												
												<!--<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="'.base_url('performa_invoice_pdf/index_withoutfinish/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="'.base_url('performa_invoice_pdf/index_withthickness/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="'.base_url('performa_invoice_pdf1/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="'.base_url('performa_invoice_pdf2/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="'.base_url('performa_invoice_pdf3/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf4/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="'.base_url('performa_invoice_pdf6/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="'.base_url('performa_invoice_pdf7/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												 <a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_accord/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 10</a>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_olwin/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 11</a>-->
												<a class="tooltips" data-toggle="tooltip" data-title="Create Producation" href="'.base_url('create_producation/index/'.$row->performa_invoice_id).'" ><i class="fa fa-plus"></i> Create Producation</a>
											
												<!--<a class=" tooltips" data-toggle="tooltip" data-title="Create Purchase Order" href="'.base_url('createpo/index/'.$row->performa_invoice_id).'"> <i class="fa fa-plus"></i> Create PO ('.$row->no_of_po.')</a>-->
										
								 	 </li>';
									 $viewinvoice1= '<li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="'.base_url('performa_invoice_pdf/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>
												
												<1--<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="'.base_url('performa_invoice_pdf/index_withoutfinish/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="'.base_url('performa_invoice_pdf/index_withthickness/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="'.base_url('performa_invoice_pdf1/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="'.base_url('performa_invoice_pdf2/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="'.base_url('performa_invoice_pdf3/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf4/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="'.base_url('performa_invoice_pdf6/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="'.base_url('performa_invoice_pdf7/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_accord/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 10</a>
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf/index_olwin/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 11</a>-->
											 
										
								 	 </li>';
									 
					 	$row_data[] 	= $no;
						$in=$row->invoice_no;
						$row_data[] 	= '
			
						 <div class="dropdown">
										<a class="dropdown-toggle"  data-toggle="dropdown">'.$row->invoice_no.'
										<span class="caret"></span></a>
										<ul class="dropdown-menu">
												'.$viewinvoice1.' 
												 
												 
									</div> 
						 ';
						$row_data[] 	=  $row->c_companyname;
						$locale='en-US'; //browser or user locale
						$currency=$row->currency_code; 
						$currency_symbol = '$';
						if (!empty($currency) && class_exists('NumberFormatter')) {
							try {
								$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
								$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
							} catch (Exception $e) {
								$currency_symbol = (!empty($currency) && $currency === 'USD') ? '$' : $currency . ' ';
							}
						}
						$row_data[] 		= $currency_symbol.' '.number_format($row->grand_total,2,'.','');
						$row_data[] 		= date('d/m/Y',strtotime($row->performa_date));
						$row_data[] 		= $row->container_details;
						$row_data[] = str_replace(",","<br>",$row->size_ordered);
						$get_po_container 	= $this->Admin_pdf->get_producation_data($row->performa_invoice_id,0);
						$total_con = isset($get_po_container['total_con']) ? $get_po_container['total_con'] : 0;
						$row_data[] 		= $total_con;
						$pending_qty = floatval($row->container_details)-$total_con;
						$row_data[] 		= ($pending_qty == 0)?'<i class="fa fa-check"></i>':number_format($pending_qty,2);
						$color = '';
					$ago_days = isset($row->ago_days) ? (int) $row->ago_days : 0;
					$m = (int)($ago_days / 30);
				 	$d = (int)($ago_days - ($m * 30));
					$m = !empty($m)?$m.' Months ':'';
					$label =  $m.$d.' days';
				if( $ago_days > 7 &&  $ago_days < 14)
				{
					
					$color = '<a class="tooltips btn" style="background:green;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				 
				}
				else if($ago_days >= 14 && $ago_days < 21)
				{
					$color = '<a class="tooltips btn" style="background:blue;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if($ago_days  >= 21 &&$ago_days < 28)
				{
					$color = '<a class="tooltips btn" style="background:purple;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
					 
				}
				else if($ago_days >= 28 &&$ago_days < 60)
				{
					
					$color = '<a class="tooltips btn" style="background:orange;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
					 
				}
				else if($ago_days  >= 60 &&$ago_days  < 90)
				{
					$color = '<a class="tooltips btn" style="background:gray;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if($ago_days  >= 90)
				{
					$color = '<a class="tooltips btn" style="background:red;color:#fff" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
				else if( $ago_days == 0)
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="Today" href="javascript:;">Today</a>';
				}
				else
				{
					$color = '<a class="tooltips btn btn-defualt" style="color:#333" data-toggle="tooltip" data-title="'. $label.'" href="javascript:;">'. $label.' </a>';
				}
			 	
				$row_data[] 	= $color;
					
					
				 
					$row_data[] = '
								 <div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
												'.$viewinvoice.' 
												'.$edit.' 
												 
									</div> 
								 ';
					 $appData[] = $row_data;
					 $no++;
					}
			 	}
				$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
				$numrecord = is_array($sqlReturn['data']) ? count($sqlReturn['data']) : 0;
				$output = array(
							"sEcho" 				=> intval($this->input->get('sEcho')),
							"iTotalRecords" 		=> (int) $totalrecord,
							"iTotalDisplayRecords" 	=>	(int) $totalrecord,
							"aaData" 				=> $appData
					);
				$this->output->set_content_type('application/json')->set_output(json_encode($output));
		} catch (Exception $e) {
				log_message('error', 'Confirm_pi fetch_record: ' . $e->getMessage());
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
	  	$id = $this->input->post('id');
	  	$status = $this->input->post('status');
	  	$deleterecord = $this->invoice->confirmpi($id,$status);	
	  		if($deleterecord)
	  		{
	  			$row['res'] = '1';
	  		}
	  		else{
	  			$row['res'] = '0';
	  		}
	  		echo json_encode($row);
	  }
	  public function fetch_advance_payment_data()
	  {
			$id=$this->input->post('id');
			$resultdata=$this->invoice->get_advance_payment_data($id);
			$resultdata->payment_date = date('d-m-Y',strtotime($resultdata->payment_date)); 
			echo json_encode($resultdata);
	  }
	   public function advance_payment()
	  {
		  
		  $data = array(
					'payment_date' 			=> date("Y-m-d",strtotime($this->input->post('payment_date'))), 
					'amount' 	   			=> $this->input->post('amount'), 
					'performa_invoice_id' 	=> $this->input->post('performa_invoice_id'), 
					'consignee_id'			=> $this->input->post('pi_consignee_id'), 
				 	'cdate' 	   	   		=> date('Y-m-d H:i:s'),
					'status'		   		=> 0
				);
				
				$row = array();
				if(!empty($this->input->post('pi_advance_payment_id')))
				{
					if($_FILES['payment_document']['name'] != "")
					{
						unlink('./upload/'.$this->input->post('payment_document_file'));
						$this->load->library('upload');
						$config = array();
						$extension = end(explode(".",$_FILES['payment_document']['name']));
						$config['file_name'] = 'pi_payment_document'.rand(0,9999).'.'.$extension;
						$config['upload_path'] = './upload/';
						$config['allowed_types'] = 'pdf|doc|jpg|jpeg|png';
						$config['max_size']      = '5000';
						$config['overwrite']     = FALSE;
	
						$this->upload->initialize($config);
						$this->upload->do_upload('payment_document');
						$upload_image = $this->upload->data();
						$data['payment_document']  = $upload_image['file_name'];
					}
					$updateid = $this->invoice->update_advance($data,$this->input->post('pi_advance_payment_id'));
					if($updateid)
					{
						$row['res'] = 1;
					}
					else
					{
						$row['res'] = 0;
					}
				}
				else
				{
					if($_FILES['payment_document']['name'] != "")
					{
						$this->load->library('upload');
						$config = array();
						$extension = end(explode(".",$_FILES['payment_document']['name']));
						$config['file_name'] = 'pi_payment_document'.rand(0,9999).'.'.$extension;
						$config['upload_path'] = './upload/';
						$config['allowed_types'] = 'pdf|doc|jpg|jpeg|png';
						$config['max_size']      = '5000';
						$config['overwrite']     = FALSE;
	
						$this->upload->initialize($config);
						$this->upload->do_upload('payment_document');
						$upload_image = $this->upload->data();
						$data['payment_document']  = $upload_image['file_name'];
					}
					$insertid = $this->invoice->insert_advance($data);
					if($insertid)
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
	   public function loaded_size()
	  {
				$id = $this->input->post('performa_invoice_id');
				$size_id 	  = $this->input->post('size_id');
				$finish_id	  = $this->input->post('finish_id');
				$design_id 	  = $this->input->post('design_id');
				$product_data = $this->invoice->get_productdetail($id,$size_id,$finish_id,$design_id);
					
				$str = ' 
					
				 	 
				<table class="table table-bordered table-hover" id="sample-table-1">
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
										<td>'.$product_data[$i]->size_type_cm.'</td>
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
										<td>'.$product_data[$i]->size_type_cm.'</td>
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
	  	$id = $this->input->post('id');
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
	  public function viewproductdetail()
	  {
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