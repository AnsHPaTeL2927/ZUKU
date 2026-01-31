<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_on_the_way_fields extends CI_Migration {

	public function up()
	{
		// Add way_date field
		$fields = array(
			'way_date' => array(
				'type' => 'DATE',
				'null' => TRUE,
				'default' => NULL,
				'comment' => 'Date when the shipment is on the way'
			)
		);
		$this->dbforge->add_column('tbl_pi_loading_plan', $fields);

		// Add estimated_arrival_date field
		$fields = array(
			'estimated_arrival_date' => array(
				'type' => 'DATE',
				'null' => TRUE,
				'default' => NULL,
				'comment' => 'Estimated date of arrival'
			)
		);
		$this->dbforge->add_column('tbl_pi_loading_plan', $fields);

		// Add on_the_way_notes field
		$fields = array(
			'on_the_way_notes' => array(
				'type' => 'TEXT',
				'null' => TRUE,
				'default' => NULL,
				'comment' => 'Additional notes for on the way status'
			)
		);
		$this->dbforge->add_column('tbl_pi_loading_plan', $fields);
	}

	public function down()
	{
		// Remove the columns if migration is rolled back
		$this->dbforge->drop_column('tbl_pi_loading_plan', 'way_date');
		$this->dbforge->drop_column('tbl_pi_loading_plan', 'estimated_arrival_date');
		$this->dbforge->drop_column('tbl_pi_loading_plan', 'on_the_way_notes');
	}
}
