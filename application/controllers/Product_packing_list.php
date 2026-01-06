<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Product_packing_list extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_list','product');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index($id)
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');	
			$productdata = $this->product->productdata($id);
				$menu_data = $this->menu->usermain_menu($this->session->usertype_id);	
			$data = array(
					'config'			=>	$data1,
					'company_detail'	=>	$this->admin_company_detail->s_select(),
					'allproduct'	 	=> 	$this->product->seriesdata(),
					'menu_data'	 		=> 	$menu_data,
					"product_data"		=>	$productdata
					);
			$this->load->view('admin/product_packing_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}	
	}
	 
	public function manage()
	{
		$data = array(
			 'series_id'		 => $this->input->post('series_id'),
			 'size_type_cm' 	 => $this->input->post('size_type_cm'),
			 'size_width_mm' 	 => $this->input->post('size_width_mm'),
			 'size_type_mm' 	 => $this->input->post('size_type_mm'),
			 'size_width_cm' 	 => $this->input->post('size_width_cm'),
			 'size_height_mm' 	 => $this->input->post('size_height_mm'),
			 'size_height_cm' 	 => $this->input->post('size_height_cm'),
			 'thickness' 	 	 => $this->input->post('thickness'),
			 'defualt_rate' 	 => $this->input->post('defualt_rate'),
			 'status' 			 => 0,
			 'cdate' 			 => date('Y-m-d H:i:s')
			);
		$id=$this->input->post('product_id');
			
			
			$data_size=array(
			    'product_packing_name' 	  			=> $this->input->post('product_packing_name'),
			    'pcs_per_box' 			  			=> $this->input->post('pcs_per_box'),
				'weight_per_box' 		  			=> $this->input->post('weight_per_box'),
				'sqm_per_box' 			  			=> $this->input->post('sqm_per_box'),
				'boxes_per_pallet' 		  			=> $this->input->post('boxes_per_pallet'),
				'total_pallent_container' 			=> $this->input->post('total_pallent_container'),
				'pallet_weight'			  			=> $this->input->post('pallet_weight'),
				'box_per_container' 	  			=> $this->input->post('box_per_container'),
				'pallet_gross_weight_per_container' => $this->input->post('pallet_gross_weight_per_container'),
				'pallet_net_weight_per_container'   => $this->input->post('pallet_net_weight_per_container'),
				'sqm_per_container'   				=> $this->input->post('sqm_per_container'),
				'box_per_big_plt' 		  			=> $this->input->post('box_per_big_plt'),
				'box_per_small_plt_new'   			=> $this->input->post('box_per_small_plt_new'),
				'no_big_plt_container_new'			=> $this->input->post('no_big_plt_container_new'),
				'no_small_plt_container_new' 		=> $this->input->post('no_small_plt_container_new'),
				'big_plat_weight'					=> $this->input->post('big_plat_weight'),
				'small_plat_weight' 				=> $this->input->post('small_plat_weight'),
				'total_boxes' 						=> $this->input->post('total_boxes'),
				'withoutgross_weight_per_container' => $this->input->post('withoutgross_weight_per_container'),
				'withoutnet_weight_per_container'   => $this->input->post('withoutnet_weight_per_container'),
				'withoutpallet_sqm_per_container'   => $this->input->post('withoutpallet_sqm_per_container'),
				'multi_gross_weight_container'		=> $this->input->post('multi_gross_weight_container'),
				'multi_net_weight_container'		=> $this->input->post('multi_net_weight_container'),
				'multi_sqm_per_container'			=> $this->input->post('multi_sqm_per_container'),
				'multi_box_per_container'			=> $this->input->post('multi_box_per_container'),
				'cdate'		 => date('d-m-Y H:i:s'),
				'status' => 0
			);
			 
			if(!empty($id))
			{
				$updateid = $this->product->update_product($data,$id);
				$data_size['product_id'] = $id;
				$product_size_id=$this->input->post('product_size_id');
				
				$size_id = $this->product->update_packing_detail($data_size,$product_size_id);
					
				if($updateid)
				{
					$row['res'] = 2;
					
				}
				else{
					$row['res'] = 0;
				}
			}
			else
			{
				$check_data = $this->product->checkdata($data);
				if(!empty($check_data))
				{
					$row['res'] = 3;
				}
				else
				{ 
				
					$insertid = $this->product->insert_product($data);
					$data_size['product_id'] = $insertid;
					$size_id = $this->product->insert_packing_detail($data_size);
					
					if($insertid)
					{
						$row['res'] = 1;
					}
					else
					{
						$row['res'] = 0;
					}
				}
			}
		 
		echo json_encode($row);
	}
	public function fetch_record()
	{
		 
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.product_size_id','size.size_type_mm','mst.product_packing_name','mst.boxes_per_pallet','box_per_big_plt','box_per_small_plt_new','total_pallent_container','no_big_plt_container_new','no_small_plt_container_new','box_per_container','multi_box_per_container','multi_sqm_per_container','withoutpallet_sqm_per_container', 'total_boxes','product_packing_name','pcs_per_box','weight_per_box','sqm_per_box','sqm_per_container','(SELECT count(*) FROM `tbl_performa_trn` where product_size_id = mst.product_size_id) as total_cnt');
		 $isWhere = array("mst.status = 0 and mst.product_id=".$this->input->get('product_id'));
		 $table = "tbl_product_size as mst";
		 $isJOIN = array('left join tbl_product as size on size.product_id=mst.product_id');
		 $hOrder = "mst.product_size_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
					$row_data[] = $row->size_type_mm;
					$row_data[] = $row->product_packing_name;
					 
				 	if($row->boxes_per_pallet>0)
					{
						$row_data[] = $row->boxes_per_pallet;
						$row_data[] = $row->total_pallent_container;
						$row_data[] = $row->box_per_container;
						$row_data[] = $row->sqm_per_container;
					}
			 		else if($row->box_per_big_plt>0 || $row->box_per_small_plt_new>0)
					{
						$row_data[] = $row->box_per_big_plt.' <br>'.$row->box_per_small_plt_new;
						$row_data[] = $row->no_big_plt_container_new.' <br>'.$row->no_small_plt_container_new;
						$row_data[] = $row->multi_box_per_container;
						$row_data[] = $row->multi_sqm_per_container;
					}
					else if($row->total_boxes > 0)
					{
						$row_data[] = '';
						$row_data[] = '';
						$row_data[] = $row->total_boxes;
						$row_data[] = $row->withoutpallet_sqm_per_container;
					}
					
			 		$delete_btn = '';
					 
					if($this->session->usertype_id == "1")
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->product_size_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'add_product/edit_packing_detail/'.$row->product_size_id.'"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
										
								   ';
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$delete_btn .'
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
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->product->delete_product_size($id);
			
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


?>