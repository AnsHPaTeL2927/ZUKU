<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_tbl_warehouse_inventory extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => TRUE,
				'auto_increment' => TRUE
			),
			'performa_invoice_id' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => FALSE,
				'comment'    => 'FK to tbl_performa_invoice'
			),
			'pi_loading_plan_id' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => TRUE,
				'comment'    => 'FK to tbl_pi_loading_plan'
			),
			'design_id' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => FALSE,
				'comment'    => 'FK to tbl_packing_model (packing_model_id)'
			),
			'warehouse_id' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => FALSE,
				'comment'    => 'FK to tbl_warehouse_master'
			),
			'quantity' => array(
				'type'       => 'DECIMAL',
				'constraint' => '10,2',
				'default'    => 0,
				'null'       => FALSE,
				'comment'    => 'Quantity (boxes, pallets, or SQM)'
			),
			'notes' => array(
				'type'    => 'TEXT',
				'null'    => TRUE,
				'comment' => 'Optional notes about the inventory'
			),
			'created_by' => array(
				'type'       => 'INT',
				'constraint' => 11,
				'unsigned'   => TRUE,
				'null'       => TRUE,
				'comment'    => 'User ID who created the record'
			),
			'created_at' => array(
				'type'    => 'DATETIME',
				'null'    => TRUE,
				'comment' => 'Record created timestamp'
			),
			'updated_at' => array(
				'type'    => 'DATETIME',
				'null'    => TRUE,
				'comment' => 'Record updated timestamp'
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('performa_invoice_id');
		$this->dbforge->add_key('pi_loading_plan_id');
		$this->dbforge->add_key('design_id');
		$this->dbforge->add_key('warehouse_id');
		$this->dbforge->add_key('created_at');
		$this->dbforge->create_table('tbl_warehouse_inventory', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('tbl_warehouse_inventory', TRUE);
	}
}
