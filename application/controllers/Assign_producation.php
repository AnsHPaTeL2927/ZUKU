<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Assign_producation extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->load->model('Admin_Producation','producation');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id'])) {
			redirect(base_url());
		}
	}
 	function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
		 	$data = array(
			 	'mode'					=> 'Add',
				'menu_data'				=> $menu_data,
				'company_detail'		=> $this->admin_company_detail->s_select(),
				'allconsign'			=> $this->producation->allconsign(),
			);
		 	$this->load->view('admin/assign_producation',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	// public function fetch_record()
	// {
		 
	// 	$where = '';
		 
	// 	 $this->load->model('Pagging_model');//call module 
	// 	 $aColumns = array('mst.producation_id','producation_date','product.size_type_mm','series.series_name','series.hsnc_code','thickness','boxes','mst.status');
	// 	 $isWhere = array("mst.status = 0".$where);
	// 	 $table = "tbl_producation as mst";
	// 	 $isJOIN = array(	
	// 						"inner join tbl_product as product on product.product_id=mst.product_id",
	// 						"left join tbl_series as series on series.series_id = product.series_id"
	// 					);
	// 	 $hOrder = "mst.producation_id desc";
	// 	  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
	// 		$appData = array();
	// 		$no = ($this->input->get('iDisplayStart') + 1);
	// 		foreach($sqlReturn['data'] as $row) {
	// 				$row_data = array();
	// 				$thickness = (!empty($row->thickness))?" - ".$row->thickness." MM":"";
	// 			 	$row_data[] = $no;
	// 			 	$row_data[] = date('d-m-Y',strtotime($row->producation_date));
	// 			 	$row_data[] = $row->size_type_mm.' ('.$row->series_name.')'.$thickness;
	// 			 	$row_data[] = $row->boxes;
	// 			  	$delete_btn = '';
	// 				if($row->total_cnt==0)
	// 				{
	// 					$delete_btn = '<li>
	// 										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_producation('.$row->producation_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
	// 									</li>';
	// 				}			 
	// 				 $actionbtn = '<li> 
	// 							 	<a class="tooltips" data-toggle="tooltip" data-title="Edit Producation" href="javascript:;" onclick="edit_producation('.$row->producation_id.');"><i class="fa fa-pencil"></i> Edit</a>
	// 							 </li>
	// 							'.$delete_btn;
					 
	// 				$row_data[] = '<div class="dropdown">
	// 									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
	// 									<span class="caret"></span></button>
	// 									<ul class="dropdown-menu">
	// 										'.$actionbtn .'
	// 								</div>';
	// 				$appData[] = $row_data;
	// 				$no++;
	// 			 }
	// 		$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
	// 		$numrecord=$sqlReturn['data'];
	// 		$output = array(
	// 				"sEcho" => intval($this->input->get('sEcho')),
	// 				"iTotalRecords" =>  $numrecord,
	// 				"iTotalDisplayRecords" =>$totalrecord,
	// 				"aaData" => $appData
	// 		);
	// 			echo json_encode( $output );
	// }
	public function fetch_record()
	{
		// Load necessary models
		$this->load->model('Pagging_model');
		$this->load->model('Admin_producation');
		$this->load->model('Admin_pdf'); // Assuming this is where product_set_data is located
		
		// Retrieve input values
		$customer_id = $this->input->get('customer_id');
		$invoicedate = explode(" - ", $this->input->get('date'));
		
		// Prepare the WHERE clause for the query
		$where = ' and performa_date BETWEEN "' . date('Y-m-d', strtotime($invoicedate[0])) . '" and "' . date('Y-m-d', strtotime($invoicedate[1])) . '"';
		
		$_SESSION['pi_s_date'] = $invoicedate[0];
		$_SESSION['pi_e_date'] = $invoicedate[1];
		
		if (!empty($customer_id)) {
			$where .= ' and mst.consigne_id = ' . $customer_id;
			$_SESSION['pi_customer_id'] = $customer_id;
		} else {
			$_SESSION['pi_customer_id'] = '';
		}
		
		// if ($this->session->usertype_id != 1) {
			// $where .= " and find_in_set(mst.consigne_id, (SELECT GROUP_CONCAT(customer_id) FROM tbl_user_wise_customer WHERE user_id = " . $this->session->id . " and status = 0))";
		// }
		
		$aColumns = array('mst.performa_invoice_id', 'mst.invoice_no', 'mst.performa_date', 'consign.c_companyname', 'mst.container_details', 'pmst.producation_no');
		$isWhere = array("mst.status = 0 and confirm_status != 1" . $where);
		$table = "tbl_performa_invoice as mst";
		$isJOIN = array(
			'left join customer_detail consign on consign.id = mst.consigne_id',
			'left join tbl_production_mst pmst on pmst.performa_invoice_id = mst.performa_invoice_id',
			'left join tbl_user user on user.user_id = mst.user_id'
		);
		$hOrder = "mst.performa_invoice_id desc";
		
		// Get paginated data
		$sqlReturn = $this->Pagging_model->get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $this->input->get());
		$resultdata = $this->Admin_producation->get_all_cofirm_pi($customer_id, $invoicedate[0], $invoicedate[1]);
		
		$appData = [];
		$no = ($this->input->get('iDisplayStart') + 1);
		$toalcon = 0;
		$totalprosheetdone = 0;
		$totalloadingpending = 0;
		$totalloadingdone = 0;
		$readyforexport = 0;
		$exportdone = 0;

		// Fetch all way dates and estimated arrival dates in one query for better performance
		$way_dates_map = array();
		if (!empty($resultdata)) {
			$performa_invoice_ids = array();
			foreach ($resultdata as $row) {
				$performa_invoice_ids[] = $row->performa_invoice_id;
			}
			
			if (!empty($performa_invoice_ids)) {
				$this->db->select('performa_invoice_id, way_date, estimated_arrival_date');
				$this->db->from('tbl_pi_loading_plan');
				$this->db->where_in('performa_invoice_id', $performa_invoice_ids);
				$this->db->where('way_date IS NOT NULL');
				$this->db->group_by('performa_invoice_id');
				$way_dates_query = $this->db->get();
				$way_dates_result = $way_dates_query->result();
				
				foreach ($way_dates_result as $way_date_row) {
					$way_dates_map[$way_date_row->performa_invoice_id] = array(
						'way_date' => $way_date_row->way_date,
						'estimated_arrival_date' => $way_date_row->estimated_arrival_date
					);
				}
			}
		}

		if (!empty($resultdata)) {
			foreach ($resultdata as $row) {
				$set_container = $this->Admin_pdf->product_set_data($row->performa_invoice_id, -1);
				$setcontainer = 0;
				$con_array = array();
				$exportcontainer = 0;
				$readyforexport_row = 0;

				foreach ($set_container as $container) {
					if (!in_array($container->con_entry, $con_array)) {
						if (!empty($container->container_no)) {
							$readyforexport_row += $container->container;
						}
						$setcontainer += $container->container;
						if ($container->export_done_status == 1) {
							$exportcontainer += $container->container;
						}
						array_push($con_array, $container->con_entry);
					}
				}

				$pending_sheet_con = $row->container_details - $setcontainer;
				$get_po_container = $this->Admin_pdf->get_producation_data($row->performa_invoice_id, 1);

				if ($get_po_container['total_con'] > 0 && $exportcontainer < $row->container_details) {
					$cust_name = !empty($row->c_nick_name) ? $row->c_nick_name : $row->c_companyname;
					$tt = ($readyforexport_row - $exportcontainer);
					
					// Get way_date and estimated_arrival_date from the pre-fetched map
					$way_date_display = '-';
					$estimated_arrival_date_display = '-';
					
					if (isset($way_dates_map[$row->performa_invoice_id])) {
						$way_date_info = $way_dates_map[$row->performa_invoice_id];
						if (!empty($way_date_info['way_date'])) {
							$way_date_display = date('d/m/Y', strtotime($way_date_info['way_date']));
						}
						if (!empty($way_date_info['estimated_arrival_date'])) {
							$estimated_arrival_date_display = date('d/m/Y', strtotime($way_date_info['estimated_arrival_date']));
						}
					}
					
					$appData[] = array(
						$no,
						$row->producation_no,
						$row->invoice_no,
						date('d/m/Y', strtotime($row->performa_date)),
						$cust_name,
						$row->container_details,
						$get_po_container['total_con'],
						$pending_sheet_con,
						$setcontainer,
						$tt,
						$exportcontainer,
						trim($way_date_display),
						trim($estimated_arrival_date_display),
						'<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li>' . $this->generateActionButtons($row) . '</li>
							</ul>
						</div>'
					);
					$no++;

					$toalcon += $row->container_details;
					$totalprosheetdone += $get_po_container['total_con'];
					$totalloadingpending += $pending_sheet_con;
					$totalloadingdone += $setcontainer;
					$readyforexport += $tt;
					$exportdone += $exportcontainer;
				}
			}
		}

		$appData[] = array(
			'',
			'',
			'',
			'',
			'<strong>Total</strong>',
			$toalcon,
			$totalprosheetdone,
			$totalloadingpending,
			$totalloadingdone,
			$readyforexport,
			$exportdone,
			'-',
			'-',
			''
		);

		$totalrecord = $this->Pagging_model->count_all($aColumns, $table, $hOrder, $isJOIN, $isWhere, '');
		$numrecord = $sqlReturn['data'];
		$output = array(
			"sEcho" => intval($this->input->get('sEcho')),
			"iTotalRecords" => $numrecord,
			"iTotalDisplayRecords" => $totalrecord,
			"aaData" => $appData
		);
		
		echo json_encode($output);
	}

	// Helper function to generate action buttons (you may need to adjust this based on your specific requirements)
	private function generateActionButtons($row)
	{
		$btn = '<a href="' . base_url() . 'create_pi_loading/index/' . $row->performa_invoice_id . '" type="button" class="tooltips" data-title="PI Loading Plan">+ Loading Plan</a>';
		$btn .= ' <a href="' . base_url() . 'create_pi_loading/container_details/' . $row->performa_invoice_id . '/0" type="button" class="tooltips" data-title="Container Detail">+ Container Detail</a>';
		//$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="Print Remaining Pi Wise" href="javascript:;" onclick="remaining_pi(' . $row->performa_invoice_id . ');" data-original-title="" title=""><i class="fa fa-print"></i> Remaining PI</a>';
		$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="Print Company Wise" href="javascript:;" onclick="company_wise_print(' . $row->performa_invoice_id . ');" data-original-title="" title=""><i class="fa fa-print"></i> Loading Print</a>';
		$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="Envelope Print" href="' . base_url() . 'producation_detail/envelope_print/' . $row->performa_invoice_id . '"  data-original-title="" title=""><i class="fa fa-print"></i> Envelope Print</a>';
		$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="Label Print" href="' . base_url() . 'producation_detail/label_print/' . $row->performa_invoice_id . '"  data-original-title="" title=""><i class="fa fa-print"></i> Label Print</a>';
		$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="On the Way" href="javascript:;" onclick="open_on_the_way_modal(' . $row->performa_invoice_id . ');" data-original-title="" title=""><i class="fa fa-truck"></i> On the Way</a>';
		$btn .= ' <a class="tooltips" data-toggle="tooltip" data-title="Add to Inventory" href="javascript:;" onclick="open_add_to_inventory_modal(' . $row->performa_invoice_id . ');" data-original-title="" title=""><i class="fa fa-archive"></i> Add to Inventory</a>';
		
		return $btn;
	}
	public function fetch_producationdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->producation->get_producation($id);
		 $resultdata->producation_date = date('d-m-Y',strtotime($resultdata->producation_date));
		echo json_encode($resultdata);
	}
	public function delete_producation()
	{
		$id=$this->input->post('id');
		$deleteid=$this->producation->delete_record($id);
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
					'producation_date' => date("Y-m-d",strtotime($this->input->post('date'))), 
					'product_id' 	   => $this->input->post('productid'), 
					'boxes' 	   	   => $this->input->post('boxes'), 
					'cdate' 	   	   => date('Y-m-d H:i:s'),
					'status'		   => 0
				);
				$row = array();
		if(empty($this->input->post('eid')))
		{
			$insertid = $this->producation->insert_producation($data);
		
			if($insertid)
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
			$updateid = $this->producation->update_producation($data,$this->input->post('eid'));
		
			if($updateid)
			{
				$row['res'] = 2;
			}
			else
			{
				$row['res'] = 0;
			}
		}			
			echo json_encode($row);
	}
	
	public function allsizewise_detail()
	{
		 $product_id= $this->input->post('product_id');
		$resultdata=$this->producation->get_all_size_producation($product_id);
		
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th>Sr No</th>
							<th>Product Name</th>
							<th>Boxes</th>
							<th>Producated Boxes</th>
							<th>Assign Boxes</th>
							<th>Remainig Boxes</th>
				 		</tr>';
						$no=1;
						 
										
		foreach($resultdata as $row)
		{
			 $thickness = (!empty($row->thickness))?" - ".$row->thickness." MM":"";
			 $producationdata=$this->producation->get_all_size_producationdata($row->product_id);
			$str .= '<tr>
						<td>'.$no.'</td>
						<td> '.$row->size_type_mm.' ('.$row->series_name.')'.$thickness.'</td>
						<td> '.$row->total_boxes.'</td>
						 <td> '.$producationdata->producated_boxes.'</td>
						<td> 0</td>
						<td> 0</td>
					 
				 	</tr>';
						$no++;
					 
		}
		
					 
					$str .= ' 
				</table>
				</div>';
		echo $str;
	
	}

	public function get_on_the_way_data()
	{
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		
		$row = array();
		
		if(empty($performa_invoice_id))
		{
			$row['res'] = 0;
			$row['msg'] = "Performa Invoice ID is required";
			echo json_encode($row);
			return;
		}
		
		// Load the Admin_pdf model
		$this->load->model('Admin_pdf', 'pinv');
		
		// Get way_date, estimated_arrival_date, and on_the_way_notes from tbl_pi_loading_plan
		// Get any record for this performa_invoice_id (we update all records with same data)
		$this->db->select('way_date, estimated_arrival_date, on_the_way_notes');
		$this->db->from('tbl_pi_loading_plan');
		$this->db->where('performa_invoice_id', $performa_invoice_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
		
		if (!empty($result)) {
			// Convert dates from yyyy-mm-dd to dd-mm-yyyy for display
			$way_date_formatted = '';
			$estimated_arrival_date_formatted = '';
			
			if (!empty($result->way_date) && $result->way_date != '0000-00-00' && $result->way_date != '1970-01-01') {
				$way_timestamp = strtotime($result->way_date);
				if ($way_timestamp !== false) {
					$way_date_formatted = date('d-m-Y', $way_timestamp);
				}
			}
			
			if (!empty($result->estimated_arrival_date) && $result->estimated_arrival_date != '0000-00-00' && $result->estimated_arrival_date != '1970-01-01') {
				$arrival_timestamp = strtotime($result->estimated_arrival_date);
				if ($arrival_timestamp !== false) {
					$estimated_arrival_date_formatted = date('d-m-Y', $arrival_timestamp);
				}
			}
			
			$row['res'] = 1;
			$row['way_date'] = $way_date_formatted;
			$row['estimated_arrival_date'] = $estimated_arrival_date_formatted;
			$row['on_the_way_notes'] = !empty($result->on_the_way_notes) ? $result->on_the_way_notes : '';
		} else {
			$row['res'] = 0;
			$row['way_date'] = '';
			$row['estimated_arrival_date'] = '';
			$row['on_the_way_notes'] = '';
		}
		
		echo json_encode($row);
	}

	public function save_on_the_way()
	{
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$way_date = $this->input->post('way_date');
		$estimated_arrival_date = $this->input->post('estimated_arrival_date');
		$on_the_way_notes = $this->input->post('on_the_way_notes');
		
		$row = array();
		
		if(empty($performa_invoice_id))
		{
			$row['res'] = 0;
			$row['msg'] = "Performa Invoice ID is required";
			echo json_encode($row);
			return;
		}
		
		// Convert date format from dd-mm-yyyy to yyyy-mm-dd
		$way_date_formatted = null;
		$estimated_arrival_date_formatted = null;
		
		if(!empty($way_date)) {
			$date_parts = explode('-', $way_date);
			if(count($date_parts) == 3) {
				// Validate date parts are numeric
				if(is_numeric($date_parts[0]) && is_numeric($date_parts[1]) && is_numeric($date_parts[2])) {
					// Validate date is valid
					if(checkdate($date_parts[1], $date_parts[0], $date_parts[2])) {
						$way_date_formatted = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
					}
				}
			}
		}
		
		if(!empty($estimated_arrival_date)) {
			$date_parts = explode('-', $estimated_arrival_date);
			if(count($date_parts) == 3) {
				// Validate date parts are numeric
				if(is_numeric($date_parts[0]) && is_numeric($date_parts[1]) && is_numeric($date_parts[2])) {
					// Validate date is valid
					if(checkdate($date_parts[1], $date_parts[0], $date_parts[2])) {
						$estimated_arrival_date_formatted = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
					}
				}
			}
		}
		
		// Prepare data array
		$data = array(
			'way_date' => $way_date_formatted,
			'estimated_arrival_date' => $estimated_arrival_date_formatted,
			'on_the_way_notes' => $on_the_way_notes
		);
		
		// Load the Admin_pdf model
		$this->load->model('Admin_pdf', 'pinv');
		
		// Update all records for this performa_invoice_id
		$update_result = $this->pinv->update_on_the_way_details($performa_invoice_id, $data);
		
		if($update_result)
		{
			$row['res'] = 1;
			$row['msg'] = "On the Way information saved successfully";
		}
		else
		{
			$row['res'] = 0;
			$row['msg'] = "Something went wrong. Please try again.";
		}
		
		echo json_encode($row);
	}
}
