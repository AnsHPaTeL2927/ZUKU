<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_pallet extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Manage_pallet_model', 'pallet');
        $this->load->model('menu_model','menu');	
        $this->load->model('Admin_pdf','po');

        if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
            redirect(base_url());
        }
    }

    public function index($production_mst_id) {
        if (!empty($this->session->id) && $this->session->title == TITLE) {
            $data = [
                'pallets'           => $this->pallet->get_pallet_data($production_mst_id),
                'existing_entries'  => $this->pallet->get_existing_entries($production_mst_id),
                'menu_data'         => $this->menu->usermain_menu($this->session->usertype_id),
                'production_id'     => $production_mst_id,
                'company_detail'    => $this->po->company_select()
            ];
            $this->load->view('admin/manage_pallet', $data);
        } else {
            redirect(base_url());
        }
    }

   public function insert_pallet_entries() {
    $production_mst_id = $this->input->post('production_mst_id');

    $input_boxes         = $this->input->post('input_boxes');
    $input_pallets       = $this->input->post('input_pallets');
    $input_big_pallets   = $this->input->post('input_big_pallets');
    $input_small_pallets = $this->input->post('input_small_pallets');
    $batchno = $this->input->post('batchno');
    $shadeno = $this->input->post('shadeno');
    $design_id           = $this->input->post('design_id');
    $finish_id           = $this->input->post('finish_id');
    $design_name         = $this->input->post('design_name');
    $size_name           = $this->input->post('size_name');
    $finish_name         = $this->input->post('finish_name');
    $available_box       = $this->input->post('available_box');
    $available_pallets       = $this->input->post('available_pallets');
    $available_big_pallets       = $this->input->post('available_big_pallets');
    $available_small_pallets       = $this->input->post('available_small_pallets');
    $box_per_pallet      = $this->input->post('box_per_pallet');
    $performa_invoice_id = $this->input->post('performa_invoice_id');
    $create_production_id= $this->input->post('create_production_id');
    $production_trn_id   = $this->input->post('production_trn_id');
    $pallet_id           = $this->input->post('pallet_id');

    foreach ($input_boxes as $row => $box_arr) {
        foreach ($box_arr as $i => $box_val) {
            
            $has_entry = ($box_val > 0) 
                      || (!empty($input_pallets[$row][$i]) && $input_pallets[$row][$i] > 0) 
                      || (!empty($input_big_pallets[$row][$i]) && $input_big_pallets[$row][$i] > 0) 
                      || (!empty($input_small_pallets[$row][$i]) && $input_small_pallets[$row][$i] > 0);

            if ($has_entry) {
                $data = [
                    'production_mst_id'    => $production_mst_id,
                    'create_production_id' => $create_production_id[$row][$i],
                    'performa_invoice_id'  => $performa_invoice_id[$row][$i],
                    'production_trn_id'    => $production_trn_id[$row][$i],
                    'design_id'            => $design_id[$row][$i],
                    'finish_id'            => $finish_id[$row][$i],
                    'design_name'          => $design_name[$row][$i],
                    'size_name'            => $size_name[$row][$i],
                    'finish_name'          => $finish_name[$row][$i],
                    'available_box'        => $available_box[$row][$i],
                    'available_pallets'        => $available_pallets[$row][$i],
                    'available_big_pallets'        => $available_big_pallets[$row][$i],
                    'available_small_pallets'        => $available_small_pallets[$row][$i],
                    'box_per_pallet'       => $box_per_pallet[$row][$i],
                    'input_boxes'          => $box_val,
                    'input_pallets'        => $input_pallets[$row][$i] ?? 0,
                    'input_big_pallets'    => $input_big_pallets[$row][$i] ?? 0,
                    'input_small_pallets'  => $input_small_pallets[$row][$i] ?? 0,
                    'batchno'  => $batchno[$row][$i] ?? 0,
                    'shadeno'  => $shadeno[$row][$i] ?? 0,
                    'pallet_id'            => $pallet_id[$row][$i],
                ];
                $this->db->insert('tbl_pallet_box_entry', $data);
            }
        }
    }

    echo json_encode(['status' => 'success']);
}

    
    public function delete_pallet_entry() {
        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id)->delete('tbl_pallet_box_entry');
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

}
