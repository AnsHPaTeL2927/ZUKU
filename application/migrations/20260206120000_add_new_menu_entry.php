<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_new_menu_entry extends CI_Migration {

	public function up()
	{
		// Add new menu entry
		// Customize these values according to your needs:
		// - menu_name: Display name in sidebar
		// - url_name: Controller name (must match your controller file name)
		// - fa_icon: Font Awesome icon class (without 'fa-' prefix)
		// - order_by: Display order (higher numbers appear later)
		// - pid: Parent menu ID (0 for main menu, or menu_id for submenu)
		// - status: 0 = active, 1 = inactive
		
		$url_name = 'stock'; // Change this to your controller name
		
		// Check if menu already exists
		$existing_menu = $this->db->get_where('tbl_menu', array('url_name' => $url_name))->row();
		
		if ($existing_menu) {
			// Menu already exists, use existing menu_id
			$menu_id = $existing_menu->menu_id;
		} else {
			// Insert new menu entry
			$menu_data = array(
				'menu_name' => 'Stock',  // Change this to your menu name
				'url_name' => $url_name,
				'fa_icon' => 'inventory',              // Change this to your icon (e.g., 'home', 'user', 'cog', etc.)
				'order_by' => 100,                // Change this to your desired order
				'pid' => 0,                       // 0 for main menu, or parent menu_id for submenu
				'status' => 0,                    // 0 = active, 1 = inactive
				'cdate' => date('Y-m-d H:i:s')
			);
			
			if (!$this->db->insert('tbl_menu', $menu_data)) {
				$error = $this->db->error();
				log_message('error', 'Menu migration failed: ' . $error['message']);
				show_error('Failed to insert menu entry: ' . $error['message']);
				return FALSE;
			}
			
			$menu_id = $this->db->insert_id();
		}
		
		// Check if permission already exists
		$existing_permission = $this->db->get_where('tbl_userpermission', array(
			'usertype_id' => 1,
			'menu_id' => $menu_id
		))->row();
		
		if (!$existing_permission) {
			// Add permission for user type 1 (Admin) - Change usertype_id as needed
			// You may need to add permissions for other user types as well
			$permission_data = array(
				'usertype_id' => 1,  // Change this to the appropriate user type ID
				'menu_id' => $menu_id
			);
			
			if (!$this->db->insert('tbl_userpermission', $permission_data)) {
				$error = $this->db->error();
				log_message('error', 'Permission migration failed: ' . $error['message']);
				show_error('Failed to insert permission entry: ' . $error['message']);
				return FALSE;
			}
		}
	}

	public function down()
	{
		// Remove the menu entry and permissions
		// First, get the menu_id by url_name
		$menu = $this->db->get_where('tbl_menu', array('url_name' => 'stock'))->row();
		
		if ($menu) {
			// Delete permissions first
			$this->db->where('menu_id', $menu->menu_id);
			$this->db->where('usertype_id', 1);
			$this->db->delete('tbl_userpermission');
			
			// Delete menu entry
			$this->db->where('menu_id', $menu->menu_id);
			$this->db->delete('tbl_menu');
		}
	}
}
