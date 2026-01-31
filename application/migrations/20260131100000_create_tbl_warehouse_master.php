<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tbl_warehouse_master extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'customer_id' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => FALSE,
				'comment'    => 'FK to customer master'
			),
			'warehouse_number' => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => TRUE,
				'comment'    => 'Warehouse number'
			),
			'name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'comment'    => 'Warehouse name'
			),
			'address' => array(
				'type'    => 'TEXT',
				'null'    => TRUE,
				'comment' => 'Warehouse address'
			),
			'country' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => TRUE,
				'comment'    => 'Country ID (FK to country master)'
			),
			'created_at' => array(
				'type'    => 'DATETIME',
				'null'    => TRUE,
				'comment' => 'Record created at'
			),
			'created_by' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => TRUE,
				'comment'    => 'User ID who created the record'
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('customer_id');
		$this->dbforge->create_table('tbl_warehouse_master', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('tbl_warehouse_master', TRUE);
	}
}
