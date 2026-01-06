<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Create_production_entry extends CI_controller
{
    function __construct()
	{
		parent::__construct();
	 
		$this->load->model('Admin_pdf','po');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
	

    function index($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			 	$this->load->model('admin_exportinvoice_product','export');	
			$company			=	$this->admin_company_detail->s_select();
		    $producation_data 	= $this->po->producation_mst_data($id);  
		 	$producation_trn 	= $this->po->producation_trn_data($id);  
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 
		 	$v = array(
					'menu_data'			=>	$menu_data,
					'invoicedata'		=>	$producation_data,
					'allproduct'	 	=>	$this->export->allproductsize(),
				 	'company_detail'	=>	$company,
				 	'packing_data'		=>	$producation_trn,
					"mode"				=>	"Add"
				);
			$this->load->view('admin/create_production_entry',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	function edit($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company			= $this->po->company_select();
			$bank				= $this->po->bselect($bankid);
			$data				= $this->po->pallet_order($id);
			$supplier			= $this->po->select_supplier();
			$pallet_order_party	= $this->po->get_pallet_order_pary();
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$getpallet_type		= $this->po->get_pallet_type();
			 
		 	$v = array(
					'palletpary_detail'	=>	$pallet_order_party,
					'supplier_detail'	=>	$supplier,
					'menu_data'			=>	$menu_data,
					'invoicedata'		=>	$data,
					'pallet_type_data'	=>	$getpallet_type,
				 	'company_detail'	=>	$company,
				 	'packing_data'		=>	$this->po->palletordertrn1($id),
					"mode"				=>	"Edit"
				);
			$this->load->view('admin/create_production_entry',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	
	// function manage(){
		
		
					// $no=0;
					// foreach($this->input->post('size_type_mm') as $pallet_order_trn)
					// {
						// $data_trn = array(
							// 'performa_invoice_id' => $this->input->post('performa_invoice_id'),
							// 'production_mst_id' => $this->input->post('production_mst_id'),
							// 'description' 			=> $this->input->post('size_type_mm')[$no],
							// 'product_id' 			=> $this->input->post('product_id')[$no],
							// 'design_id' 			=> $this->input->post('design_name')[$no],
							// 'finish_id' 			=> $this->input->post('finish_name')[$no],
							// 'no_of_pallet'	 		=> $this->input->post('no_of_pallet')[$no],
							// 'no_of_big_pallet'		=> $this->input->post('no_of_big_pallet')[$no],
							// 'no_of_small_pallet'	=> $this->input->post('no_of_small_pallet')[$no],
							// 'boxes_per_pallet'		=> $this->input->post('boxes_per_pallet')[$no],
							// 'box_per_big_pallet'	=> $this->input->post('box_per_big_pallet')[$no],
							// 'box_per_small_pallet'	=> $this->input->post('box_per_small_pallet')[$no],
							// 'pallet_type' 			=> $this->input->post('pallet_type')[$no],
							// 'factory'				=> $this->input->post('factory_name')[$no],
							// 'remarks'				=> $this->input->post('remarks')[$no],
							// 'batchnproduction'				=> $this->input->post('batchnproduction')[$no],
							// 'shadenproduction'				=> $this->input->post('shadenproduction')[$no],
							// 'available_box'				=> $this->input->post('available_box')[$no],
							// 'difference'				=> $this->input->post('difference')[$no],
							// 'cdate' 				=> date('Y-m-d H:i:s') 
						// );
						// $rdata_trn = $this->po->insert_pallet_order_entry($data_trn);
						// $no++;
					// }
					// $row['res'] = 1;
					// $row['pallet_order_id'] = $this->input->post('production_mst_id');
				
		// echo json_encode($row);

	// } 
public function manage()
{
    $production_mst_id = $this->input->post('production_mst_id');
    $row = [];

    $total_rows = count($this->input->post('size_type_mm'));

    $extra_batch1_arr     = $this->input->post('extra_batch1');
    $extra_shade1_arr     = $this->input->post('extra_shade1');
    $extra_design1_arr    = $this->input->post('extra_design1');
    $extra_pallet1_arr    = $this->input->post('extra_pallet1');
    $extra_total_box1_arr = $this->input->post('extra_total_box1');

    $extra_batch2_arr     = $this->input->post('extra_batch2');
    $extra_shade2_arr     = $this->input->post('extra_shade2');
    $extra_design2_arr    = $this->input->post('extra_design2');
    $extra_pallet2_arr    = $this->input->post('extra_pallet2');
    $extra_total_box2_arr = $this->input->post('extra_total_box2');

    $manual_pallet_arr     = $this->input->post('manual_pallet');
    $default_pallet_arr    = $this->input->post('default_pallet');
    $manual_total_box_arr  = $this->input->post('manual_total_box');
    $default_total_box_arr = $this->input->post('default_total_box');

    if (!empty($production_mst_id)) {
        $this->db->where('production_mst_id', $production_mst_id);
        $this->db->delete('tbl_pallet_order_entry');

        for ($i = 0; $i < $total_rows; $i++) {
            $design_name = $this->input->post('design_name')[$i];

            // Extra batch/shade/pallet/box 1
            $extra_batch1     = null;
            $extra_shade1     = null;
            $extra_pallet1    = null;
            $extra_total_box1 = null;
            if (!empty($extra_design1_arr)) {
                foreach ($extra_design1_arr as $j => $dname) {
                    if ($dname === $design_name) {
                        $extra_batch1     = isset($extra_batch1_arr[$j]) ? $extra_batch1_arr[$j] : null;
                        $extra_shade1     = isset($extra_shade1_arr[$j]) ? $extra_shade1_arr[$j] : null;
                        $extra_pallet1    = isset($extra_pallet1_arr[$j]) ? $extra_pallet1_arr[$j] : null;
                        $extra_total_box1 = isset($extra_total_box1_arr[$j]) ? $extra_total_box1_arr[$j] : null;
                        break;
                    }
                }
            }

            // Extra batch/shade/pallet/box 2
            $extra_batch2     = null;
            $extra_shade2     = null;
            $extra_pallet2    = null;
            $extra_total_box2 = null;
            if (!empty($extra_design2_arr)) {
                foreach ($extra_design2_arr as $j => $dname) {
                    if ($dname === $design_name) {
                        $extra_batch2     = isset($extra_batch2_arr[$j]) ? $extra_batch2_arr[$j] : null;
                        $extra_shade2     = isset($extra_shade2_arr[$j]) ? $extra_shade2_arr[$j] : null;
                        $extra_pallet2    = isset($extra_pallet2_arr[$j]) ? $extra_pallet2_arr[$j] : null;
                        $extra_total_box2 = isset($extra_total_box2_arr[$j]) ? $extra_total_box2_arr[$j] : null;
                        break;
                    }
                }
            }

            $manual_pallet    = !empty($manual_pallet_arr[$i]) ? $manual_pallet_arr[$i] : $default_pallet_arr[$i];
            $manual_total_box = !empty($manual_total_box_arr[$i]) ? $manual_total_box_arr[$i] : $default_total_box_arr[$i];

            $data_trn = [
                'performa_invoice_id'     => $this->input->post('performa_invoice_id'),
               'production_trn_id' => $this->input->post('production_trn_id')[$i],

                'production_mst_id'       => $production_mst_id,
                'description'             => $this->input->post('size_type_mm')[$i],
                'product_name'            => $this->input->post('product_name')[$i],
                'packing_name'            => $this->input->post('packing_name')[$i],
                'design_name'             => $design_name,
                'finish_name'             => $this->input->post('finish_name')[$i],
                'product_id'              => $this->input->post('product_id')[$i],
                'design_id'               => $design_name,
                'finish_id'               => $this->input->post('finish_name')[$i],
                'no_of_boxes'             => $manual_total_box,
                'no_of_pallet'            => $manual_pallet,
                'no_of_big_pallet'        => $this->input->post('no_of_big_pallet')[$i],
                'no_of_small_pallet'      => $this->input->post('no_of_small_pallet')[$i],
                'boxes_per_pallet'        => $this->input->post('boxes_per_pallet')[$i],
                'box_per_big_pallet'      => $this->input->post('box_per_big_pallet')[$i],
                'box_per_small_pallet'    => $this->input->post('box_per_small_pallet')[$i],
                'pallet_type'             => $this->input->post('pallet_type')[$i],
                'factory'                 => $this->input->post('factory_name')[$i],
                'remarks'                 => $this->input->post('remarks')[$i],
                'batchnproduction'        => $this->input->post('batchnproduction')[$i],
                'shadenproduction'        => $this->input->post('shadenproduction')[$i],

                'extra_batch1'            => $extra_batch1,
                'extra_shade1'            => $extra_shade1,
                'extra_pallet1'           => $extra_pallet1,
                'extra_total_box1'        => $extra_total_box1,

                'extra_batch2'            => $extra_batch2,
                'extra_shade2'            => $extra_shade2,
                'extra_pallet2'           => $extra_pallet2,
                'extra_total_box2'        => $extra_total_box2,

                'available_box'           => $this->input->post('available_box')[$i],
                'difference'              => $this->input->post('difference')[$i],
                'cdate'                   => date('Y-m-d H:i:s'),
            ];
            $this->po->insert_pallet_order_entry($data_trn);
        }

        $row['res'] = 2;

    } else {
        $mst_data = [
            'performa_invoice_id' => $this->input->post('performa_invoice_id'),
            'cdate'               => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('tbl_pallet_order_entry', $mst_data);
        $production_mst_id = $this->db->insert_id();

        if ($production_mst_id) {
            for ($i = 0; $i < $total_rows; $i++) {
                $design_name = $this->input->post('design_name')[$i];

                $extra_batch1     = null;
                $extra_shade1     = null;
                $extra_pallet1    = null;
                $extra_total_box1 = null;
                if (!empty($extra_design1_arr)) {
                    foreach ($extra_design1_arr as $j => $dname) {
                        if ($dname === $design_name) {
                            $extra_batch1     = isset($extra_batch1_arr[$j]) ? $extra_batch1_arr[$j] : null;
                            $extra_shade1     = isset($extra_shade1_arr[$j]) ? $extra_shade1_arr[$j] : null;
                            $extra_pallet1    = isset($extra_pallet1_arr[$j]) ? $extra_pallet1_arr[$j] : null;
                            $extra_total_box1 = isset($extra_total_box1_arr[$j]) ? $extra_total_box1_arr[$j] : null;
                            break;
                        }
                    }
                }

                $extra_batch2     = null;
                $extra_shade2     = null;
                $extra_pallet2    = null;
                $extra_total_box2 = null;
                if (!empty($extra_design2_arr)) {
                    foreach ($extra_design2_arr as $j => $dname) {
                        if ($dname === $design_name) {
                            $extra_batch2     = isset($extra_batch2_arr[$j]) ? $extra_batch2_arr[$j] : null;
                            $extra_shade2     = isset($extra_shade2_arr[$j]) ? $extra_shade2_arr[$j] : null;
                            $extra_pallet2    = isset($extra_pallet2_arr[$j]) ? $extra_pallet2_arr[$j] : null;
                            $extra_total_box2 = isset($extra_total_box2_arr[$j]) ? $extra_total_box2_arr[$j] : null;
                            break;
                        }
                    }
                }

                $manual_pallet    = !empty($manual_pallet_arr[$i]) ? $manual_pallet_arr[$i] : $default_pallet_arr[$i];
                $manual_total_box = !empty($manual_total_box_arr[$i]) ? $manual_total_box_arr[$i] : $default_total_box_arr[$i];

                $data_trn = [
                    'performa_invoice_id'     => $this->input->post('performa_invoice_id'),
                   'production_trn_id' => $this->input->post('production_trn_id')[$i],

                    'production_mst_id'       => $production_mst_id,
                    'description'             => $this->input->post('size_type_mm')[$i],
                    'product_name'            => $this->input->post('product_name')[$i],
                    'packing_name'            => $this->input->post('packing_name')[$i],
                    'design_name'             => $design_name,
                    'finish_name'             => $this->input->post('finish_name')[$i],
                    'product_id'              => $this->input->post('product_id')[$i],
                    'design_id'               => $design_name,
                    'finish_id'               => $this->input->post('finish_name')[$i],
                    'no_of_boxes'             => $manual_total_box,
                    'no_of_pallet'            => $manual_pallet,
                    'no_of_big_pallet'        => $this->input->post('no_of_big_pallet')[$i],
                    'no_of_small_pallet'      => $this->input->post('no_of_small_pallet')[$i],
                    'boxes_per_pallet'        => $this->input->post('boxes_per_pallet')[$i],
                    'box_per_big_pallet'      => $this->input->post('box_per_big_pallet')[$i],
                    'box_per_small_pallet'    => $this->input->post('box_per_small_pallet')[$i],
                    'pallet_type'             => $this->input->post('pallet_type')[$i],
                    'factory'                 => $this->input->post('factory_name')[$i],
                    'remarks'                 => $this->input->post('remarks')[$i],
                    'batchnproduction'        => $this->input->post('batchnproduction')[$i],
                    'shadenproduction'        => $this->input->post('shadenproduction')[$i],

                    'extra_batch1'            => $extra_batch1,
                    'extra_shade1'            => $extra_shade1,
                    'extra_pallet1'           => $extra_pallet1,
                    'extra_total_box1'        => $extra_total_box1,

                    'extra_batch2'            => $extra_batch2,
                    'extra_shade2'            => $extra_shade2,
                    'extra_pallet2'           => $extra_pallet2,
                    'extra_total_box2'        => $extra_total_box2,

                    'available_box'           => $this->input->post('available_box')[$i],
                    'difference'              => $this->input->post('difference')[$i],
                    'cdate'                   => date('Y-m-d H:i:s'),
                ];
                $this->po->insert_pallet_order_entry($data_trn);
            }

            $row['res'] = 1;
        } else {
            $row['res'] = 0;
        }
    }

    $row['production_mst_id'] = $production_mst_id;
    echo json_encode($row);
}

public function manage_new()
{
    $production_mst_id = $this->input->post('production_mst_id');
    $row = [];

    $total_rows = count($this->input->post('size_type_mm'));

    $extra_batch1_arr     = $this->input->post('extra_batch1');
    $extra_shade1_arr     = $this->input->post('extra_shade1');
    $extra_design1_arr    = $this->input->post('extra_design1');
    $extra_pallet1_arr    = $this->input->post('extra_pallet1');
    $extra_total_box1_arr = $this->input->post('extra_total_box1');

    $extra_batch2_arr     = $this->input->post('extra_batch2');
    $extra_shade2_arr     = $this->input->post('extra_shade2');
    $extra_design2_arr    = $this->input->post('extra_design2');
    $extra_pallet2_arr    = $this->input->post('extra_pallet2');
    $extra_total_box2_arr = $this->input->post('extra_total_box2');

    $manual_pallet_arr     = $this->input->post('manual_pallet');
    $default_pallet_arr    = $this->input->post('default_pallet');
    $manual_total_box_arr  = $this->input->post('manual_total_box');
    $default_total_box_arr = $this->input->post('default_total_box');

    if (!empty($production_mst_id)) {
        $this->db->where('production_mst_id', $production_mst_id);
        $this->db->delete('tbl_pallet_order_entry');

        for ($i = 0; $i < $total_rows; $i++) {
            $design_name = $this->input->post('design_name')[$i];

            // Extra batch/shade/pallet/box 1
            $extra_batch1     = null;
            $extra_shade1     = null;
            $extra_pallet1    = null;
            $extra_total_box1 = null;
            if (!empty($extra_design1_arr)) {
                foreach ($extra_design1_arr as $j => $dname) {
                    if ($dname === $design_name) {
                        $extra_batch1     = isset($extra_batch1_arr[$j]) ? $extra_batch1_arr[$j] : null;
                        $extra_shade1     = isset($extra_shade1_arr[$j]) ? $extra_shade1_arr[$j] : null;
                        $extra_pallet1    = isset($extra_pallet1_arr[$j]) ? $extra_pallet1_arr[$j] : null;
                        $extra_total_box1 = isset($extra_total_box1_arr[$j]) ? $extra_total_box1_arr[$j] : null;
                        break;
                    }
                }
            }

            // Extra batch/shade/pallet/box 2
            $extra_batch2     = null;
            $extra_shade2     = null;
            $extra_pallet2    = null;
            $extra_total_box2 = null;
            if (!empty($extra_design2_arr)) {
                foreach ($extra_design2_arr as $j => $dname) {
                    if ($dname === $design_name) {
                        $extra_batch2     = isset($extra_batch2_arr[$j]) ? $extra_batch2_arr[$j] : null;
                        $extra_shade2     = isset($extra_shade2_arr[$j]) ? $extra_shade2_arr[$j] : null;
                        $extra_pallet2    = isset($extra_pallet2_arr[$j]) ? $extra_pallet2_arr[$j] : null;
                        $extra_total_box2 = isset($extra_total_box2_arr[$j]) ? $extra_total_box2_arr[$j] : null;
                        break;
                    }
                }
            }

            $manual_pallet    = !empty($manual_pallet_arr[$i]) ? $manual_pallet_arr[$i] : $default_pallet_arr[$i];
            $manual_total_box = !empty($manual_total_box_arr[$i]) ? $manual_total_box_arr[$i] : $default_total_box_arr[$i];

            $data_trn = [
                'performa_invoice_id'     => $this->input->post('performa_invoice_id'),
               'production_trn_id' => $this->input->post('production_trn_id')[$i],

                'production_mst_id'       => $production_mst_id,
                'description'             => $this->input->post('size_type_mm')[$i],
                'product_name'            => $this->input->post('product_name')[$i],
                'packing_name'            => $this->input->post('packing_name')[$i],
                'design_name'             => $design_name,
                'finish_name'             => $this->input->post('finish_name')[$i],
                'product_id'              => $this->input->post('product_id')[$i],
                'design_id'               => $design_name,
                'finish_id'               => $this->input->post('finish_name')[$i],
                'no_of_boxes'             => $manual_total_box,
                'no_of_pallet'            => $manual_pallet,
                'no_of_big_pallet'        => $this->input->post('no_of_big_pallet')[$i],
                'no_of_small_pallet'      => $this->input->post('no_of_small_pallet')[$i],
                'boxes_per_pallet'        => $this->input->post('boxes_per_pallet')[$i],
                'box_per_big_pallet'      => $this->input->post('box_per_big_pallet')[$i],
                'box_per_small_pallet'    => $this->input->post('box_per_small_pallet')[$i],
                'pallet_type'             => $this->input->post('pallet_type')[$i],
                'factory'                 => $this->input->post('factory_name')[$i],
                'remarks'                 => $this->input->post('remarks')[$i],
                'batchnproduction'        => $this->input->post('batchnproduction')[$i],
                'shadenproduction'        => $this->input->post('shadenproduction')[$i],

                'extra_batch1'            => $extra_batch1,
                'extra_shade1'            => $extra_shade1,
                'extra_pallet1'           => $extra_pallet1,
                'extra_total_box1'        => $extra_total_box1,

                'extra_batch2'            => $extra_batch2,
                'extra_shade2'            => $extra_shade2,
                'extra_pallet2'           => $extra_pallet2,
                'extra_total_box2'        => $extra_total_box2,

                'available_box'           => $this->input->post('available_box')[$i],
                'difference'              => $this->input->post('difference')[$i],
                'cdate'                   => date('Y-m-d H:i:s'),
            ];
            $this->po->insert_pallet_order_entry($data_trn);
        }

        $row['res'] = 2;

    } else {
        $mst_data = [
            'performa_invoice_id' => $this->input->post('performa_invoice_id'),
            'cdate'               => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('tbl_pallet_order_entry', $mst_data);
        $production_mst_id = $this->db->insert_id();

        if ($production_mst_id) {
            for ($i = 0; $i < $total_rows; $i++) {
                $design_name = $this->input->post('design_name')[$i];

                $extra_batch1     = null;
                $extra_shade1     = null;
                $extra_pallet1    = null;
                $extra_total_box1 = null;
                if (!empty($extra_design1_arr)) {
                    foreach ($extra_design1_arr as $j => $dname) {
                        if ($dname === $design_name) {
                            $extra_batch1     = isset($extra_batch1_arr[$j]) ? $extra_batch1_arr[$j] : null;
                            $extra_shade1     = isset($extra_shade1_arr[$j]) ? $extra_shade1_arr[$j] : null;
                            $extra_pallet1    = isset($extra_pallet1_arr[$j]) ? $extra_pallet1_arr[$j] : null;
                            $extra_total_box1 = isset($extra_total_box1_arr[$j]) ? $extra_total_box1_arr[$j] : null;
                            break;
                        }
                    }
                }

                $extra_batch2     = null;
                $extra_shade2     = null;
                $extra_pallet2    = null;
                $extra_total_box2 = null;
                if (!empty($extra_design2_arr)) {
                    foreach ($extra_design2_arr as $j => $dname) {
                        if ($dname === $design_name) {
                            $extra_batch2     = isset($extra_batch2_arr[$j]) ? $extra_batch2_arr[$j] : null;
                            $extra_shade2     = isset($extra_shade2_arr[$j]) ? $extra_shade2_arr[$j] : null;
                            $extra_pallet2    = isset($extra_pallet2_arr[$j]) ? $extra_pallet2_arr[$j] : null;
                            $extra_total_box2 = isset($extra_total_box2_arr[$j]) ? $extra_total_box2_arr[$j] : null;
                            break;
                        }
                    }
                }

                $manual_pallet    = !empty($manual_pallet_arr[$i]) ? $manual_pallet_arr[$i] : $default_pallet_arr[$i];
                $manual_total_box = !empty($manual_total_box_arr[$i]) ? $manual_total_box_arr[$i] : $default_total_box_arr[$i];

                $data_trn = [
                    'performa_invoice_id'     => $this->input->post('performa_invoice_id'),
                   'production_trn_id' => $this->input->post('production_trn_id')[$i],

                    'production_mst_id'       => $production_mst_id,
                    'description'             => $this->input->post('size_type_mm')[$i],
                    'product_name'            => $this->input->post('product_name')[$i],
                    'packing_name'            => $this->input->post('packing_name')[$i],
                    'design_name'             => $design_name,
                    'finish_name'             => $this->input->post('finish_name')[$i],
                    'product_id'              => $this->input->post('product_id')[$i],
                    'design_id'               => $design_name,
                    'finish_id'               => $this->input->post('finish_name')[$i],
                    'no_of_boxes'             => $manual_total_box,
                    'no_of_pallet'            => $manual_pallet,
                    'no_of_big_pallet'        => $this->input->post('no_of_big_pallet')[$i],
                    'no_of_small_pallet'      => $this->input->post('no_of_small_pallet')[$i],
                    'boxes_per_pallet'        => $this->input->post('boxes_per_pallet')[$i],
                    'box_per_big_pallet'      => $this->input->post('box_per_big_pallet')[$i],
                    'box_per_small_pallet'    => $this->input->post('box_per_small_pallet')[$i],
                    'pallet_type'             => $this->input->post('pallet_type')[$i],
                    'factory'                 => $this->input->post('factory_name')[$i],
                    'remarks'                 => $this->input->post('remarks')[$i],
                    'batchnproduction'        => $this->input->post('batchnproduction')[$i],
                    'shadenproduction'        => $this->input->post('shadenproduction')[$i],

                    'extra_batch1'            => $extra_batch1,
                    'extra_shade1'            => $extra_shade1,
                    'extra_pallet1'           => $extra_pallet1,
                    'extra_total_box1'        => $extra_total_box1,

                    'extra_batch2'            => $extra_batch2,
                    'extra_shade2'            => $extra_shade2,
                    'extra_pallet2'           => $extra_pallet2,
                    'extra_total_box2'        => $extra_total_box2,

                    'available_box'           => $this->input->post('available_box')[$i],
                    'difference'              => $this->input->post('difference')[$i],
                    'cdate'                   => date('Y-m-d H:i:s'),
                ];
                $this->po->insert_pallet_order_entry($data_trn);
            }

            $row['res'] = 1;
        } else {
            $row['res'] = 0;
        }
    }

    $row['production_mst_id'] = $production_mst_id;
    echo json_encode($row);
}



	
	function manage1(){
		
		//$product_name = $this->input->post('product_name'); // confirm it is not null
		
    $data_trn = array(
        'performa_invoice_id'   => $this->input->post('performa_invoice_id'),
     //   'production_trn_id'   => $this->input->post('production_trn_id'),
        'production_mst_id'     => $this->input->post('production_mst_id'),

        // Insert names instead of IDs
        'product_name'          => $this->input->post('product_name'),
        'design_name'           => $this->input->post('design_name'),
        'finish_name'           => $this->input->post('finish_name'),
        'packing_name'          => $this->input->post('packing_name'),

        'no_of_pallet'          => $this->input->post('no_of_pallet'),
        'no_of_big_pallet'      => $this->input->post('no_of_big_pallet'),
        'no_of_small_pallet'    => $this->input->post('no_of_small_pallet'),
        'boxes_per_pallet'      => $this->input->post('boxes_per_pallet'),
        'box_per_big_pallet'    => $this->input->post('big_boxes_per_pallet'),
        'box_per_small_pallet'  => $this->input->post('small_boxes_per_pallet'),
        'pallet_type'           => $this->input->post('pallet_status'),
        'remarks'               => $this->input->post('sampleremark'),
        'batchnproduction'      => $this->input->post('batch_no'),
        'shadenproduction'      => $this->input->post('shade_no'),
        'no_of_boxes'           => $this->input->post('boxes'),
        'available_box'         => $this->input->post('boxes'),
        'cdate'                 => date('Y-m-d H:i:s')
    );

    // Insert to DB
  //  $rdata_trn = $this->po->insert_pallet_order_extraentry($data_trn);
    $rdata_trn = $this->po->insert_pallet_order_entry($data_trn);

    $row['res'] = $rdata_trn ? 1 : 0;
    echo json_encode($row);
}

// public function delete($id)
// {
    // // Optional: Check permissions or validations here

    // // Delete logic (example)
    // $this->db->where('production_mst_id', $id);
    // $this->db->delete('tbl_pallet_order_entry');

    // // Also delete related entries from detail tables if needed

    // // Set flash message and redirect
    // $this->session->set_flashdata('success', 'Production entry deleted successfully.');
    // redirect('production_detail/index/'); // Change to your actual listing page
// }

public function delete_production($id)
{
    // Load DB
    $this->load->database();

    // Get file name
    $this->db->where('production_mst_id', $id);
    $query = $this->db->get('tbl_pallet_order_entry');
    $row = $query->row();

    if ($row) {
        
        // Delete DB record
        $this->db->where('production_mst_id', $id);
        $this->db->delete('tbl_pallet_order_entry');

        $this->session->set_flashdata('success', 'Production entry deleted successfully.');

        // Redirect to specific invoice view if needed
        redirect('producation_detail');
    } else {
        $this->session->set_flashdata('error', 'Production entry not found.');
        redirect('producation_detail'); // fallback if record not found
    }
}

	
}
?>