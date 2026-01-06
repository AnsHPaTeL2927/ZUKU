<?php
class Manage_pallet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_pallet_data($production_mst_id) {
        return $this->db
            ->select('*')
            ->from('tbl_pallet_order_entry')
            ->where('production_mst_id', $production_mst_id)
            ->get()
            ->result();
    }

    public function get_existing_entries($production_mst_id) {
        $result = $this->db
            ->select('*')
            ->from('tbl_pallet_box_entry')
            ->where('production_mst_id', $production_mst_id)
            ->get()
            ->result();

        $grouped = [];
        foreach ($result as $row) {
            $key = $row->design_id . '_' . $row->finish_id;
            $grouped[$key][] = $row;
        }

        return $grouped;
    }
}