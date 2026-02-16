<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Add production_reminder_days to ciadmin_login
 * Number of days before estimated date to show production reminder notification
 */
class Migration_Add_production_reminder_days extends CI_Migration {

	public function up()
	{
		if (!$this->db->field_exists('production_reminder_days', 'ciadmin_login')) {
			$fields = array(
				'production_reminder_days' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'null'       => TRUE,
					'default'    => 2,
					'comment'    => 'Days before estimated date to fire production reminder notification'
				)
			);
			$this->dbforge->add_column('ciadmin_login', $fields);
		}
	}

	public function down()
	{
		if ($this->db->field_exists('production_reminder_days', 'ciadmin_login')) {
			$this->dbforge->drop_column('ciadmin_login', 'production_reminder_days');
		}
	}
}
