<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Add qc_status column to tbl_production_mst
 * 0 = QC Pending, 1 = QC Done
 */
class Migration_Add_qc_status_to_production_mst extends CI_Migration {

	public function up()
	{
		if (!$this->db->field_exists('qc_status', 'tbl_production_mst')) {
			$fields = array(
				'qc_status' => array(
					'type'       => 'INT',
					'constraint' => 1,
					'default'    => 0,
					'comment'    => '0 = QC Pending, 1 = QC Done'
				)
			);
			$this->dbforge->add_column('tbl_production_mst', $fields);
		}
	}

	public function down()
	{
		if ($this->db->field_exists('qc_status', 'tbl_production_mst')) {
			$this->dbforge->drop_column('tbl_production_mst', 'qc_status');
		}
	}
}
