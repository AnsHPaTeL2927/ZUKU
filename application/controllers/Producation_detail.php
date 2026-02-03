<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Producation_detail extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_Producation','producation');
		$this->load->model('Admin_pdf','pinv');
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
			//$data['supplier_data']		= $this->producation->getsupplierdata();
			//$data['payment_data']	 = $this->expense->getpaymentdata();
			
			$data = array(
			 	'mode'				=> 'Add',
				'invoicetype'		=> $selectinvoicetype,
				'menu_data'			=> $menu_data,
				'setting_data'		=> $this->menu->setting_data(1),
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allproduct'		=> $this->producation->allproductsize(),
				'consign_data'		=> $this->producation->select_consigner(),
				'supplier_data'		=> $this->producation->getsupplierdata()
			);
			$this->load->view('admin/producation_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	 public function fetch_record()
	 {
		$setting_data = $this->menu->setting_data(1);
		$invoice_status = $this->input->get('invoice_status');
		$cust_id = $this->input->get('cust_id');
		$supplierdata = $this->input->get('supplierdata');
		
		$invoicedate = explode(" - ",$this->input->get('date'));
		$_SESSION['po_s_date'] = $invoicedate[0];
		$_SESSION['po_e_date'] = $invoicedate[1];
		
		$where = ' and producation_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
		
		 if(!empty($cust_id))
		{
			$where .= ' and invoice.consigne_id = '.$cust_id;
			$_SESSION['po_cust_id'] = $cust_id;
		}	
		else
		{
			$_SESSION['po_cust_id'] = '';
		}

		if(!empty($supplierdata))
		{
			$where .= ' and mst.supplier_id = '.$supplierdata;
			$_SESSION['get_supplierdata'] = $supplierdata;
		}	
		else
		{
			$_SESSION['get_supplierdata'] = '';
		}
			
			if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(invoice.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('mst.production_mst_id','step_status', 'invoice.invoice_no','producation_no','producation_date','consign.c_companyname','sup.company_name','no_of_countainer','sup.supplier_name','po_status','mst.performa_invoice_id','production_status','production_complete_date','qc_status','mst.pallet_status','(select group_concat(production_mst_id) from  tbl_pi_loading_plan where  production_mst_id =mst.production_mst_id) as already_loading');
				$isWhere 	= array("mst.status = 0".$where);
				$table 		= "tbl_production_mst as mst";
				$isJOIN 	= array(
								'INNER join tbl_performa_invoice as invoice on  invoice.performa_invoice_id = mst.performa_invoice_id',
								'left join customer_detail consign on consign.id = invoice.consigne_id',
								'left join tbl_supplier as sup on sup.supplier_id = mst.supplier_id',
								'INNER join tbl_performa_additional_detail as additional on additional.production_mst_id = mst.production_mst_id'
								);
				$hOrder = "mst.production_mst_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
				foreach($sqlReturn['data'] as $row) {
						$row_data 	= array();
					 	$row_data[] =  $no;
						if(empty($trn->already_loading) && empty($row->po_status))
						{
							$row_data[] =  '<input type="checkbox" name="allproduction_mst_id[]" id="allproduction_mst_id'.$row->production_mst_id.'" value="'.$row->production_mst_id.'" style="width: 30px;" class="form-control" onclick="add_producation_detail('.$row->production_mst_id.',this.checked)" />';
						}
						else
						{
							$row_data[] =  '';
						}
						$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('view_producation/index/'.$row->production_mst_id).'" >'.$row->producation_no.'</a>';
						$row_data[]  = date('d/m/Y',strtotime($row->producation_date));
						$row_data[]  = $row->invoice_no;
						$name = !empty($row->name)?' - '.$row->name:'';
						$row_data[]  = $row->c_companyname;
						$row_data[]  = $row->company_name.$name;
					 
						$row_data[]  = number_format($row->no_of_countainer,2);
						 
							 
							if($row->production_status == 1)
							{
								$row_data[]  = ' 
									<a class=" tooltips" data-toggle="tooltip" data-title="Production Done" href="javascript:;">
									Production Done</a>';
							}
							else
							{
								$row_data[]  = ' 
								
											<a class=" tooltips" data-toggle="tooltip" data-title="Click to confirm Production" href="javascript:;" onclick="open_production_popup('.$row->production_mst_id.');"> <input type="checkbox" id="productionsheet_mst_id'.$row->production_mst_id.'"  name="productionsheet_mst_id[]"   value="'.$row->production_mst_id.'" />   Production Pending   </a>
										';
							}
							
							if(!empty($setting_data->qc_checked))
							 {
								if($row->qc_status == 1)
								{
									$row_data[]  = ' 
										<a class=" tooltips" data-toggle="tooltip" data-title="QC Done" href="javascript:;">
										QC Done</a>';
								}
								else
								{
									$row_data[]  = ' 
									
												<a class=" tooltips" data-toggle="tooltip" data-title="Click to confirm QC" href="javascript:;" onclick="click_for_qc('.$row->production_mst_id.',1);"> <input type="checkbox" id="qcproduction_mst_id'.$row->production_mst_id.'"  name="qcproduction_mst_id[]"   value="'.$row->production_mst_id.'"      />   QC Pending   </a>
											';
								}
							}
							if(!empty($setting_data->palletization_checked))
							{
								if($row->pallet_status == 1)
								{
									$row_data[]  = ' 
									
												<a  class=" tooltips" data-toggle="tooltip" data-title="Pallatazation Done" href="javascript:;" >    Pallatazation Done</a> ';
								}
								else
								{
									$row_data[]  = ' 
									
												<a onclick="click_for_pallet('.$row->production_mst_id.',1)"  class=" tooltips" data-toggle="tooltip" data-title="Click to confirm Pallatazation" href="javascript:;" >  <input type="checkbox" id="palletproduction_mst_id'.$row->production_mst_id.'"  name="palletproduction_mst_id[]"   value="'.$row->production_mst_id.'"  />   Pallatazation Pending </a>
											';
								}
							}
							
				 	$viewinvoice	= '';
				 	$po_btn	= '';
				 	$action_btn	= '';
					$checkbox 		= '';
					$qcbtn='';
					$pallet_order ='';
					$production_entry = '';
					 $viewinvoice	= ' 
					 
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> View PDF </a>
							</li>
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index_extrapallet/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> View Production (Barcode/Client) </a>
							</li>
							
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index_pro/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> View Pallet Packing Planning</a>
							</li>
							
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index2/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> View Production </a>
							</li>
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index1/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> View PDF (Other Product)</a>
							</li>
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation2/index/'.$row->production_mst_id).'"><i class="fa fa-eye"></i> View Producation 2</a>
							</li>
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation3/index/'.$row->production_mst_id).'"><i class="fa fa-eye"></i> View Producation 3</a>
							</li>
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation4/index/'.$row->production_mst_id).'"><i class="fa fa-eye"></i> View Producation 4</a>
							</li>
							
							';
							$next_btn = '';
							
							$po_btn = '
									<li>
										<a class=" tooltips" data-toggle="tooltip" data-title="Create Purchase Order" href="'.base_url('createpo/index/'.$row->production_mst_id).'"> <i class="fa fa-plus"></i> Create PO </a>
									</li>';
									
								
							if(empty($trn->already_loading) && empty($row->po_status))
							{
								 
								$action_btn = '	<li>							
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url('create_producation/edit/'.$row->production_mst_id).'"><i class="fa fa-pencil"></i> Edit</a>
									</li>
									<li>	
										<a class="tooltips" data-toggle="tooltip" data-title="Delete"  onclick="delete_record('.$row->production_mst_id.','.$row->performa_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
									</li>	
									';
							}	
							
							
							$action_btn = '<li>	
										<a class="tooltips" data-toggle="tooltip" data-title="Delete"  onclick="delete_record('.$row->production_mst_id.','.$row->performa_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Delete</a>
									</li>';
									
							if($row->po_status == 1)
							{
								$po_btn = '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="PO Done" href="javascript:;"> <i class="fa fa-thumbs-up"></i> PO Done </a>
										</li>';
							}
							
							
							 					//for production entry

			
	
							
							 $check_pallet_order = $this->pinv->pallet_orderrecord($row->production_mst_id);
					if(empty($check_pallet_order))
					{
						$pallet_order = '<li>
										<a class="tooltips" data-toggle="tooltip" data-title="Create Pallet Order" href="'.base_url('create_pallet_order/index/'.$row->production_mst_id).'"><i class="fa fa-plus"></i> 	Create Pallet Order</a>
									</li>';
					}
					else
					{
						$pallet_order = '<li>
											<a class="tooltips" data-toggle="tooltip" data-title="Edit Pallet Order" href="'.base_url('create_pallet_order/edit/'.$row->production_mst_id).'"   ><i class="fa fa-pencil"></i> Edit Pallet Order</a>
									</li>
									<li>
											<a class="tooltips" data-toggle="tooltip" data-title="View Pallet Order Pdf" href="'.base_url('pallent_order/view_pdf/'.$row->production_mst_id).'" target="_blank" ><i class="fa fa-file-pdf-o"></i> View Pallet Order Pdf</a>
										</li>
										
';
					}
					
					$check_qc = $this->producation->qcrecord($row->production_mst_id);
					if(empty($check_qc))
					{
						$qcbtn = '<li>
							<a class="tooltips" data-toggle="tooltip" data-title="Create QC" href="'.base_url('create_qc/index/'.$row->production_mst_id).'"><i class="fa fa-plus"></i> Create QC</a>
						</li>';
					}
					else
					{
						$qcbtn = '<li>
							<a class="tooltips" data-toggle="tooltip" data-title="Edit QC" href="'.base_url('create_qc/edit_qc/'.$check_qc->production_mst_id).'"><i class="fa fa-pencil"></i> Edit QC</a>
						</li>
						<li>
							<a class="tooltips" data-toggle="tooltip" data-title="QC Pdf" href="'.base_url('create_qc/view/'.$check_qc->production_mst_id).'" target="_blank"><i class="fa fa-file-pdf-o"></i> QC PDF</a>
						</li>
						<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View Pdf" href="'.base_url('view_producation/index3/'.$row->production_mst_id).'"><i class="fa fa-eye"></i> View  QC DATA</a>
							</li>
						';
					}
					
				 	$row_data[] = $check_box.'  &nbsp; &nbsp; <div class="dropdown" style="float: left;width:70%">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
									 			'.$viewinvoice.'
												'.$next_btn.' 	
												
												'.$pallet_order.' 	
												'.$qcbtn.' 													
											 	'.$po_btn.' 
											 	'.$action_btn.' 
												
												 
									  </div> ';
					 
					 $appData[] = $row_data;
					 $no++;
				}
				$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
				$numrecord=$sqlReturn['data'];
				$output = array(
							"sEcho" 				=> intval($this->input->get('sEcho')),
							"iTotalRecords" 		=> $numrecord,
							"iTotalDisplayRecords" 	=> $totalrecord,
							"aaData" 				=> $appData
					);
				echo json_encode($output);
	  } 
	  
	  	  
  public function final_production()
	{
		$id = $this->input->post('production_mst_id');

		$this->db->where('production_mst_id', $id)
				 ->update('tbl_production_mst', [
						'production_status' => 1,
						'production_complete_date' => date('Y-m-d')
				 ]);

		echo "1";
	}

public function mark_trn_done()
{
    $trn_id = $this->input->post('production_trn_id');

    $this->db->where('production_trn_id', $trn_id);
    $this->db->update('tbl_production_trn', [
        'production_done' => 2,
        'done_date' => date('Y-m-d H:i:s')
    ]);

    echo 1;
}

public function mark_master_done()
{
    $id = $this->input->post('production_mst_id');

    $this->db->where('production_mst_id', $id);
    $this->db->update('tbl_production_mst', [
        'production_status' => 1,
        'production_complete_date' => date('Y-m-d')
    ]);

    echo 1;
}


public function get_container_data()
{
    $id = $this->input->post('production_mst_id');
    if (empty($id)) {
        echo '<div class="alert alert-warning">Production ID is required.</div>';
        return;
    }

   $this->db->select('
    trn.*, 
    mst.producation_no, 
    pmodel.model_name, 
    f.finish_name, 
    pro.size_type_mm, 
    ptrn.sqm_per_box, 
    ptrn.boxes_per_pallet as trnboxes_per_pallet, 
    ptrn.box_per_big_pallet as trnbox_per_big_pallet, 
    ptrn.box_per_small_pallet as trnbox_per_small_pallet, 
    ptrn.boxes_per_pallet, 
    ptrn.box_per_big_pallet, 
    ptrn.box_per_small_pallet
');
$this->db->from('tbl_production_trn trn');

$this->db->join('tbl_production_mst mst', 'mst.production_mst_id = trn.production_mst_id', 'INNER');
$this->db->join('tbl_performa_packing ppacking', 'ppacking.performa_packing_id = trn.performa_packing_id', 'INNER');
$this->db->join('tbl_performa_trn ptrn', 'ptrn.performa_trn_id = ppacking.performa_trn_id', 'INNER');
$this->db->join('tbl_product pro', 'pro.product_id = ptrn.product_id', 'INNER');
$this->db->join('tbl_packing_model pmodel', 'pmodel.packing_model_id = ppacking.design_id', 'INNER');
$this->db->join('tbl_finish f', 'f.finish_id = ppacking.finish_id', 'INNER');

$this->db->where('trn.production_mst_id', $id);

/* ORDERING */
$this->db->order_by('pmodel.model_name', 'ASC');
$this->db->order_by('IFNULL(trn.parent_trn_id, trn.production_trn_id)', 'ASC', FALSE);
$this->db->order_by('trn.parent_trn_id IS NOT NULL', 'ASC', FALSE);
$this->db->order_by('trn.production_trn_id', 'ASC');

$data['rows'] = $this->db->get()->result();


    /* =====================================================
       CHECK IF ALL PRODUCTION ROWS ARE DONE
    ===================================================== */
    $this->db->where('production_mst_id', $id);
    $this->db->where('production_done !=', 2);
    $remaining = $this->db->count_all_results('tbl_production_trn');

    $data['all_done'] = ($remaining == 0 ? 2 : 0);
    $data['production_mst_id'] = $id;

    $this->load->view('admin/container_production_view', $data);
}


public function update_all()
{
    $id = $this->input->post('id');

    $data = array(
        'no_of_pallet'       => $this->input->post('pallet') ?? 0,
        'no_of_big_pallet'   => $this->input->post('big') ?? 0,
        'no_of_small_pallet' => $this->input->post('small') ?? 0,
        'no_of_boxes'        => $this->input->post('box') ?? 0,
        'no_of_sqm'          => $this->input->post('sqm') ?? 0,
        'pro_batch'          => $this->input->post('pro_batch'),
        'pro_shade'          => $this->input->post('pro_shade'),
    );

    /* ==========================
       SAVE BOX / PALLET VALUES
    ========================== */

    // Normal pallet
    if ($this->input->post('boxes_per_pallet') !== null) {
        $data['boxes_per_pallet'] = $this->input->post('boxes_per_pallet');
    }

    // Big / Small pallet
    if ($this->input->post('box_per_big_pallet') !== null) {
        $data['box_per_big_pallet'] = $this->input->post('box_per_big_pallet');
    }

    if ($this->input->post('box_per_small_pallet') !== null) {
        $data['box_per_small_pallet'] = $this->input->post('box_per_small_pallet');
    }

    $this->db->where('production_trn_id', $id);
    $this->db->update('tbl_production_trn', $data);

    echo "success";
}


public function insert_extra()
{
    $parent_id = $this->input->post('parent_id');

    // Fetch parent row
    $parent = $this->db
        ->where('production_trn_id', $parent_id)
        ->get('tbl_production_trn')
        ->row_array();

    if (!$parent) {
        echo json_encode(['status' => 'error']);
        return;
    }

    // Remove primary key
    unset($parent['production_trn_id']);

    // Reset production values for extra row
    $parent['no_of_pallet']       = 0;
    $parent['no_of_big_pallet']   = 0;
    $parent['no_of_small_pallet'] = 0;
    $parent['no_of_boxes']        = 0;
    $parent['no_of_sqm']          = 0;
    $parent['pro_batch']          = '';
    $parent['pro_shade']          = '';
    $parent['production_done']    = 0;
    $parent['parent_trn_id']    = $parent_id;
	

    // Insert new extra row
    $this->db->insert('tbl_production_trn', $parent);

    $new_id = $this->db->insert_id();

    // Return ONLY new id (UI will clone parent display)
    echo json_encode([
        'status' => 'success',
        'new_id' => $new_id
    ]);
}


public function delete_row()
{
    $id = $this->input->post('id');
    $this->db->where('production_trn_id', $id)
             ->delete('tbl_production_trn');
}




public function update_pallet()
{
    $id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->where('production_trn_id', $id)
             ->update('tbl_production_trn', ['no_of_pallet' => $value]);

    echo "success";
}

public function update_big_pallet()
{
    $id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->where('production_trn_id', $id)
             ->update('tbl_production_trn', ['no_of_big_pallet' => $value]);

    echo "success";
}

public function update_small_pallet()
{
    $id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->where('production_trn_id', $id)
             ->update('tbl_production_trn', ['no_of_small_pallet' => $value]);

    echo "success";
}

public function update_box()
{
    $id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->where('production_trn_id', $id)
             ->update('tbl_production_trn', ['no_of_boxes' => $value]);

    echo "success";
}

public function update_sqm()
{
    $id = $this->input->post('id');
    $value = $this->input->post('value');

    $this->db->where('production_trn_id', $id)
             ->update('tbl_production_trn', ['no_of_sqm' => $value]);

    echo "success";
}




	function check_suppier()
	{
			$po_array 		= $this->input->post('production_mst_id');
		 	$checkcongine 	= $this->producation->check_suppier($po_array);
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
	function send_next_step()
	{
			$productionmst_id 	= $this->input->post('productionmst_id');
			$step_status 		= $this->input->post('step_status');
	 	
			$update_step 	= $this->producation->update_step_status($productionmst_id,$step_status);
			$row=array();
			if($update_step)
			{
				$row['res'] = 1;
			}	
			else
			{
				$row['res'] = 0;
			}
			echo json_encode($row);
	  
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
		$no=0;
		foreach($this->input->post('product_id') as $product_id)
		{
			$data = array(
					'producation_date' => date("Y-m-d",strtotime($this->input->post('producation_date'))), 
					'producation_time' => $this->input->post('producation_time'), 
					'id' 		       => $this->input->post('customer_id'),
					'box_design_id'    => $this->input->post('box_design_id'), 
					'product_id' 	   => $product_id, 
					'design_id' 	   => $this->input->post('packing_model_id')[$no], 
					'finish_id' 	   => $this->input->post('finish_id')[$no], 
					'packing_model_id' => $this->input->post('packing_model_id')[$no], 
					'boxes' 	   	   => $this->input->post('producation_box')[$no],
					'shade_no' 	   	   => $this->input->post('shade_no')[$no], 
					'batch_no' 	   	   => $this->input->post('batch_no')[$no], 
					'cdate' 	   	   => date('Y-m-d H:i:s'),
					'status'		   => 0
				);
				$insertid = $this->producation->insert_producation($data);
				$no++;
		}
			
		 
			if($insertid)
			{
				$row['res'] = 1;
			}
			else
			{
				$row['res'] = 0;
			}
		 	
			echo json_encode($row);
	}
	public function all_confirm_performa()
	{
		$customer_id = $this->input->post('customer_id');
	 	$invoicedate = explode(" - ",$this->input->post('date'));
		
		$_SESSION['assign_s_date'] = $invoicedate[0];
		$_SESSION['assign_e_date'] = $invoicedate[1];
		$_SESSION['assign_cust_id'] = !empty($customer_id)?$customer_id:"";
				
		
		$resultdata=$this->producation->get_all_cofirm_pi($customer_id,$invoicedate[0],$invoicedate[1]);
			$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th>Sr No</th>
						 	<th>Performa Invoice No</th>
						 	<th>Performa Invoice Date</th>
							<th>Consignee Name</th>
							<th>No Of Container</th>
							<th>Producation Sheet Done Container</th>
							<th>Pending For Loading</th>
							<th>Loading Done</th>
							<th>Ready For Export</th>
							<th>Export Done</th>
							<th>Action</th>
					 	</tr>';
						$no=1;
			if(!empty($resultdata))
					{	
				$black = array();
		foreach($resultdata as $row)
		{
				 $set_container 		 = $this->pinv->product_set_data($row->performa_invoice_id,-1);
				 $setcontainer 			 = 0;
				 $con_array 			 = array();
				 $check_container_detail = array();
				 $exportcontainer		 = 0;
				 $readyforexport		 = 0;
			 		for($i=0; $i<count($set_container);$i++)
					{
						 
						if(!in_array($set_container[$i]->con_entry,$con_array))
						{
							if(!empty($set_container[$i]->container_no))
							{
								$readyforexport += $set_container[$i]->container;
							}
							$setcontainer += $set_container[$i]->container;
						 	array_push($check_container_detail,$set_container[$i]->already_done);
						 	if($set_container[$i]->export_done_status  == 1)
							{
								$exportcontainer += $set_container[$i]->container;
							}
							array_push($con_array,$set_container[$i]->con_entry);
						}
					}
				$checkbox='';	
			$btn = '<a href="'.base_url().'create_pi_loading/index/'.$row->performa_invoice_id.'" type="button" class="tooltips" data-title="PI Loading Plan">
					 + Loading Plan
	 				</a>';
			$pending_sheet_con = ($row->container_details - $setcontainer);	
				
			if(floatval($setcontainer) > 0)
			{
				$btn = '<a href="'.base_url().'create_pi_loading/index/'.$row->performa_invoice_id.'" type="button" class="tooltips" data-title="PI Loading Plan">
								+ Loading Plan
	 				</a>
					<a href="'.base_url().'create_pi_loading/container_details/'.$row->performa_invoice_id.'/0" type="button" class="tooltips" data-title="Container Detail">
								+ Container Detail
	 				</a>
					 ';
					 
						$btn .= '
						<a class="tooltips" data-toggle="tooltip" data-title="Print Company Wise" href="javascript:;" onclick="company_wise_print('.$row->performa_invoice_id.');" data-original-title="" title=""><i class="fa fa-print"></i> Loading Print </a> 
						<a class="tooltips" data-toggle="tooltip" data-title="Envelope Print" href="'.base_url().'producation_detail/envelope_print/'.$row->performa_invoice_id.'"  data-original-title="" title=""><i class="fa fa-print"></i> Envelope Print</a> 
						<a class="tooltips" data-toggle="tooltip" data-title="Label Print" href="'.base_url().'producation_detail/label_print/'.$row->performa_invoice_id.'"  data-original-title="" title=""><i class="fa fa-print"></i> Label Print</a> 
						'; 
			 }		
					if($pending_con == 0)
					 {
						$checkbox = '<input type="checkbox" name="all_performa_invoice[]" id="all_performa_invoice'.$row->performa_invoice_id.'" value="'.$row->performa_invoice_id.'" style="width: 30px;" class="form-control"/>  ';
					 }
										
			$get_po_container = $this->pinv->get_producation_data($row->performa_invoice_id,1);
			 
			 
				if($get_po_container['total_con'] > 0 && $exportcontainer < $row->container_details)
				{	
					array_push($black,'true');
					$cust_name = !empty($row->c_nick_name)?$row->c_nick_name:$row->c_companyname;
			 $str .= '<tr>
						<td>'.$no.'</td>
						<td> '.$row->invoice_no.' </td>
						<td> '.date('d/m/Y',strtotime($row->performa_date)).' </td>
						<td> '.$cust_name.'</td>
						<td> '.$row->container_details.'</td>
						<td> '.$get_po_container['total_con'].'</td>
						<td> '.$pending_sheet_con.'</td>
						<td> '.$setcontainer.'</td>
						<td> '.($readyforexport - $exportcontainer).'</td>
						<td> '.$exportcontainer.'</td>
						<td> 
							 <div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>'.$btn.'</li>
									</div>
						</td>
					 
				 	</tr>';
						$no++;
						
					$tt = ($readyforexport - $exportcontainer);
					$toalcon += $row->container_details;
					$totalprosheetdone += $get_po_container['total_con'];
					$totalloadingpending += $pending_sheet_con;
					$totalloadingdone += $setcontainer;
					$readyforexport += $tt;
					$exportdone += $exportcontainer;
				}
					 
		}
		
		}
					else
					{
							$str .= '<tr> <td colspan="11" class="text-center"> No Data Found</td></tr>';
							$black = array('true');
					}
					if(empty($black))
					{
						$str .= '<tr> <td colspan="11" class="text-center"> No Data Found</td></tr>';
				 	}
		$str .= ' 
				<tr>
					<th colspan="4" style="text-align:right">Total</th>
					<th>'.$toalcon.'</th>
					<th>'.$totalprosheetdone.'</th>
					<th>'.$totalloadingpending.'</th>
					<th>'.$totalloadingdone.'</th>
					<th>'.$readyforexport.'</th>
					<th>'.$exportdone.'</th>
					
				</tr>
				</table>
				</div>';
		echo $str;
	
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
							<th>(Producated + PO) Boxes</th>
							<th>Remaining Boxes</th>
						 	<th>Assign Boxes</th>
							<th>Stock Boxes</th>
							
				 		</tr>';
						$no=1;
				if(!empty($resultdata))	
				{					
		foreach($resultdata as $row)
		{
				$total_boxes = $row->performa_boxes;
				$assign_box = $row->assign_boxes;
				$producation_box = ($row->producation_boxes + $row->po_boxes);
				
				$remaining_box = 0;
				$stock_box = 0;
				if(($total_boxes - $producation_box) > 0)
				{
					$remaining_box = ($total_boxes - $producation_box);
				}
				else 
				{
					$stock_box = ($producation_box - $total_boxes);
				}
			 $str .= '<tr>
						<td>'.$no.'</td>
						<td> '.$row->size_type_mm.' ('.$row->series_name.')</td>
						<td> '.$total_boxes.'</td>
						 <td> '.$producation_box.'</td>
						 <td> '.$remaining_box.'</td>
						<td> '.$assign_box.'</td>
						<td> '.$stock_box.'</td>
						
				 	</tr>';
						$no++;
					 
		}
				}
				else{
					$str .= '<tr>
								<td class="text-center" colspan="7"> No Data Found</td>
							</tr>';
						$no++;
				}
		$str .= ' 
				</table>
				</div>';
		echo $str;
	
	}
	public function view_pdf()
	{
		$str = '<table class="table table-bordered table-hover display" width="100%">
					<thead>
						<tr>
							<th width="2%">SR No</th>
							<th width="15%">Company Name</th>
							<th width="22%">Po Date</th>
							<th width="22%">Expected Cargo Readiness Date</th>
							<th width="22%">No Of Container</th>
						 	<th width="15%">Action</th>
						</tr>
					</thead>
					<tbody>';
					$producation_data 	= 	$this->Admin_pdf->get_producation_data($this->input->post('performa_invoice_id'));
					 
		         if(!empty($producation_data["total_con"]>0))
				{
					$sr =1;
					foreach($producation_data as $row)
					{
						 if($row->no_of_countainer> 0)
						{													
						 
								$str .= '<tr>
											<td>'.$sr.'</td>
											<td>'.$row->company_name.'</td>
											<td>'.date("d/m/Y",strtotime($row->producation_date)).'</td>
											<td>'.date("d/m/Y",strtotime($row->readiness_date)).'</td>
											<td>'.number_format($row->no_of_countainer,2).'</td>
											<td> 
												<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Producation Pdf" href="'.base_url('view_producation/index/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> Producation PDF </a>
												<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit" href="'.base_url('create_producation/edit/'.$row->production_mst_id).'"><i class="fa fa-pencil"></i> Edit</a>
												<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->production_mst_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
												
											</td>
										</tr>';
												$sr++;
						}
					}
				}
				else
				{
				 
					$str .= '<tr>
								<td colspan="4" class="text-center">No Data Found</td>
							</tr>';
					 
				}
					 
				$str .= '</tbody>
				</table> ';
			echo $str;
	}
	public function envelope_print($performa_invoice_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company		=	$this->pinv->company_select();
			 
			$data			= 	$this->pinv->select_invoice_data($performa_invoice_id);
			$set_container	= 	$this->pinv->product_set_data($performa_invoice_id,0);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'set_container'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->pinv->allproductsize(),
					'bank'				=>	$bank,
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
			$this->load->view('admin/envelope-print',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		
	}
	public function label_print($performa_invoice_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company		=	$this->pinv->company_select();
			 
			$data			= 	$this->pinv->select_invoice_data($performa_invoice_id);
			$set_container	= 	$this->pinv->product_data($performa_invoice_id);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'product_data'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->pinv->allproductsize(),
					'bank'				=>	$bank,
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
			$this->load->view('admin/label-print',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		
	}
	public function label_print1($performa_invoice_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company		=	$this->pinv->company_select();
			 
			$data			= 	$this->pinv->select_invoice_data($performa_invoice_id);
			$set_container	= 	$this->pinv->product_data($performa_invoice_id);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'product_data'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->pinv->allproductsize(),
					'bank'				=>	$bank,
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
			$this->load->view('admin/label-print1',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		
	}
	public function label_print2($performa_invoice_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company		=	$this->pinv->company_select();
			 
			$data			= 	$this->pinv->select_invoice_data($performa_invoice_id);
			$set_container	= 	$this->pinv->product_data($performa_invoice_id);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'product_data'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->pinv->allproductsize(),
					'bank'				=>	$bank,
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
			$this->load->view('admin/label-print2',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		
	}
	
		public function deletemanageproducation()
		{
			$id					 = $this->input->post('production_mst_id');
			
			$deleterecord = $this->producation->delete_manageproducation($id);
			
						 
						
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
