<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Add PSC date columns to tbl_production_mst
 * psc_date = Today's date when submitted
 * psc_estimated_date = Estimated completion date
 * psc_count_days = Estimated date - Today date (days remaining)
 */
class Migration_Add_psc_dates_to_production_mst extends CI_Migration {

	public function up()
	{
		if (!$this->db->field_exists('psc_date', 'tbl_production_mst')) {
			$fields = array(
				'psc_date' => array(
					'type'    => 'DATE',
					'null'    => TRUE,
					'comment' => 'Today date when PSC was submitted'
				)
			);
			$this->dbforge->add_column('tbl_production_mst', $fields);
		}
		if (!$this->db->field_exists('psc_estimated_date', 'tbl_production_mst')) {
			$fields = array(
				'psc_estimated_date' => array(
					'type'    => 'DATE',
					'null'    => TRUE,
					'comment' => 'Estimated completion date'
				)
			);
			$this->dbforge->add_column('tbl_production_mst', $fields);
		}
		if (!$this->db->field_exists('psc_count_days', 'tbl_production_mst')) {
			$fields = array(
				'psc_count_days' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'null'       => TRUE,
					'comment'    => 'Estimated date - Today date (days)'
				)
			);
			$this->dbforge->add_column('tbl_production_mst', $fields);
		}
	}

	public function down()
	{
		if ($this->db->field_exists('psc_date', 'tbl_production_mst')) {
			$this->dbforge->drop_column('tbl_production_mst', 'psc_date');
		}
		if ($this->db->field_exists('psc_estimated_date', 'tbl_production_mst')) {
			$this->dbforge->drop_column('tbl_production_mst', 'psc_estimated_date');
		}
		if ($this->db->field_exists('psc_count_days', 'tbl_production_mst')) {
			$this->dbforge->drop_column('tbl_production_mst', 'psc_count_days');
		}
	}
}
