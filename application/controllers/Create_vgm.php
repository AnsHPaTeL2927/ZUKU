<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Create_vgm extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 	$this->load->model('Admin_create_vgm','vgm');
		$this->load->model('admin_model_list','model');
		$this->load->model('Admin_pdf','pinv');
		$this->load->model('admin_exportinvoice_product');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id){
		
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$this->load->model('admin_company_detail');	
				$company 		= $this->admin_company_detail->s_select();
				$data			= $this->vgm->select_invoice_data($id);
				$datap 			= $this->admin_exportinvoice_product->getinvoiceproductdata($data->export_invoice_id);
			 	$menu_data		= $this->menu->usermain_menu($this->session->usertype_id);	
			 	$container_data = $this->vgm->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
				$datamodeldata 	= $this->model->getproductdata();
				$v = array( 
					  'consign_detail'	=> $consign,
					  'exporter_detail'	=> $exporter,
					  'menu_data'		=> $menu_data,
					  'mode'			=> 'Add',
					  'company_detail'	=> $company,
					  'invoicedata'		=> $data,
					  'product_data'	=> $datap,
					  'direct_invoice' 	=> $data->direct_invoice,  
					  'container_data'	=> $container_data
				 );
		$this->load->view('admin/create_vgm',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	function edit_vgm($id)
	{
		$this->load->model('admin_company_detail');	
		$company = $this->admin_company_detail->s_select();
		$data= $this->vgm->vgm_data($id);
		$datap= $this->vgm->vgmtrn_data($data->vgm_id);
		 $menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			   $v = array( 
					  'consign_detail'=>$consign,
					  'exporter_detail'=>$exporter,
					  'menu_data'=>$menu_data,
					  'mode'=>'Edit',
					  'company_detail'=>$company,
					  'invoicedata'=>$data,
					  'vgmdata'=>$datap 
				 );
		$this->load->view('admin/edit_vgm',$v);
	}
	function manage(){
		
		$data = array(
			//'booking_no' 			=> $this->input->post('booking_no'),
			'shipper_name'			=> $this->input->post('shipper_name'),
			'shipper_address'  		=> $this->input->post('shipper_address'),
			'name_officer' 			=> $this->input->post('name_officer'),
			'iec_no' 				=> $this->input->post('iec_no'),
			'pan_no' 				=> $this->input->post('pan_no'),
			'gst_no' 				=> $this->input->post('gst_no'),
			'contact_no' 			=> $this->input->post('contact_no'),
			'method_vgm' 			=> $this->input->post('method_vgm'),
			'weighment_slipno' 		=> $this->input->post('weighbridge_slip_no'),
			'weighbridge_reg_no' 	=> $this->input->post('weighbridge_reg_no'),
			'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
			'datetime_weighment' 	=> $this->input->post('datetime_weighment'),
			'container_no' 			=> $this->input->post('container_no'),
			
			'container_size' 		=> $this->input->post('container_size'),
			'permissible_weight' 	=> $this->input->post('permissible_weight'),
			'verified_container' 	=> $this->input->post('verified_container'),
			'unit_measure' 			=> $this->input->post('unit_measure'),
			'type' 					=> $this->input->post('type'),
			'imdg_class' 			=> $this->input->post('imdg_class'),
			'vgm_remakrs' 			=> nl2br($this->input->post('vgm_remakrs')),
		 	'status' 				=> 0,
			);		
			$row['res'] = 0;
			if(strtolower($this->input->post('mode'))=="add")
			{				
				$data['cdate'] = date('Y-m-d H:i:s');
				 
			 	$insertid = $this->vgm->insert_vgm($data);
				$t=0;
			 	foreach($this->input->post('container_detail') as $key)
				{
					 $data1 = array(
							"container_no" 		=> $this->input->post('container_detail')[$t],
							"truck_no" 			=> $this->input->post('truck_no')[$t],
							"booking_no" 		=> $this->input->post('booking_no')[$t],
					 		"max_permissible" 	=> $this->input->post('max_permissible')[$t],
							"date_weighment" 	=> $this->input->post('date_weighment')[$t],
							"gross_mass1" 		=> $this->input->post('gross_mass1')[$t],
							"gross_mass2" 		=> $this->input->post('gross_mass2')[$t],
							"gross_mass3" 		=> $this->input->post('gross_mass3')[$t],
							"time_weighment" 	=> $this->input->post('time_weighment')[$t],
							"shilp_no" 			=> $this->input->post('shilp_no')[$t],
							"vgm_id" 			=> $insertid,
				 		);
						$inserttrnid = $this->vgm->insert_vgmtrn($data1);
						 	
				 	$t++;	 				
				}
				$row['res'] = 1;
				$row['id'] = $insertid;
		 	}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				 $id = $this->input->post('vgm_id');
				 
					$update_id = $this->vgm->update_vgm($data,$id);
					 $delete_id = $this->vgm->delete_vgmtrn($id);
					 $t=0;
				 	 
					foreach($this->input->post('container_detail') as $key)
					{
						$data1 = array(
								"container_no" 		=> $this->input->post('container_detail')[$t],
								"truck_no" 			=> $this->input->post('truck_no')[$t],
								"booking_no" 		=> $this->input->post('booking_no')[$t],
								"max_permissible" 	=> $this->input->post('max_permissible')[$t],
								"date_weighment" 	=> $this->input->post('date_weighment')[$t],
								"gross_mass1" 		=> $this->input->post('gross_mass1')[$t],
								"gross_mass2" 		=> $this->input->post('gross_mass2')[$t],
								"gross_mass3" 		=> $this->input->post('gross_mass3')[$t],
								"time_weighment" 	=> $this->input->post('time_weighment')[$t],
								"shilp_no" 			=> $this->input->post('shilp_no')[$t],
								"vgm_id" 			=> $id,
							);
							$inserttrnid = $this->vgm->insert_vgmtrn($data1);
								
						$t++;	 				
					}	
				$row['res'] = 1;
				$row['id'] 	= $id;
			}
		echo json_encode($row);

	}
	
	public function design_image()
	{
		$design_id = $this->input->post('design_id');
		echo $this->loading->getimage($design_id); 
	}
	public function add_design()
	{
		$m = $this->input->post('no');
		$j = $this->input->post('j');
		$size_width_mm  = $this->input->post('size_width_mm');
		$size_height_mm = $this->input->post('size_height_mm');
		$id = $this->input->post('product_id');
		$seriesgroup_id = $this->input->post('seriesgroup_id');
		$description = $this->input->post('description');
		$pallet = $this->input->post('pallet');
		$boxes = $this->input->post('boxes');
		$exportproduct_trn_id = $this->input->post('exportproduct_trn_id');
		 $design_data = 	$this->loading->regualr_packing_model_data_image($id);
		 
		$str = '<tr id="trhtml'.$j.$m.'">
				<td style="text-align:center">
					<input type="text" name="batch'.$j.'[]" id="batch'.$j.$m.'" class="form-control" placeholder="Batch"  />
					<input type="hidden" name="exportproduct_trn_id'.$j.'[]" id="exportproduct_trn_id'.$j.$m.'" value="'.$exportproduct_trn_id.'"   />
					<input type="hidden" name="product_id'.$j.'[]" id="product_id'.$j.$m.'"  value="'.$id.'"   />
					<input type="hidden" name="seriesgroup_id'.$j.'[]" id="seriesgroup_id'.$j.$m.'"  value="'.$seriesgroup_id.'"   />
					<input type="hidden" name="description'.$j.'[]" id="description'.$j.$m.'"  value="'.$description.'"   />
					<input type="hidden" name="pallet'.$j.'[]" id="pallet'.$j.$m.'"  value="'.$pallet.'"   />
					<input type="hidden" name="boxes'.$j.'[]" id="boxes'.$j.$m.'"  value="'.$boxes.'"   />
					 
					
				</td>
				<td style="text-align:center" class="tdcls">
					<select class="select2" id="design_id'.$j.$m.'" name="design_id'.$j.'[]" onchange="load_image(this.value,'.$m.','.$j.','.$size_width_mm.','.$size_height_mm.')">
						<option value="">Select Design</option>';
						  
							foreach($design_data as $designrow)
							{
								$str .= '<option value="'.$designrow->packing_model_id.'">'.$designrow->model_name.'</option>';
							}
						 
				$str .= '	</select> 
				</td>
				<td style="text-align:center" >
					   <img src="" id="view_image'.$m.$j.'" style="display:none" />
				</td>
				<td style="text-align:center" >
					   <button type="button" class="btn btn-danger" onclick="remove_other_design('.$j.','.$m.')">
							-
						</button>
				</td>
				</tr>';
		echo $str;
		 
	}
}
