<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Greeny Module Install/Update File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Blis Web Agency
 * @link		http://blis.net.au
 */

class Greeny_upd {
	
	public $version = '1.0.3';
	
	private $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Installation Method
	 *
	 * @return 	boolean 	TRUE
	 */
	public function install()
	{
		$mod_data = array(
			'module_name'			=> 'Greeny',
			'module_version'		=> $this->version,
			'has_cp_backend'		=> "y",
			'has_publish_fields'	=> 'n'
		);
		
		$this->EE->db->insert('modules', $mod_data);
				
		$data = array(
			'class' 	=> 'Greeny',
			'method' 	=> 'update'
		);
		
		$this->EE->db->insert('actions', $data);
		
		$fields = array(
			'greeny_id'   => array('type' => 'int', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'dir_path'  => array('type' => 'varchar', 'constraint' => 1024),
			'env_key'  => array('type' => 'varchar', 'constraint' => 15)
		);
		
		$this->EE->load->dbforge();
		
		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('greeny_id', TRUE);
		$this->EE->dbforge->add_key('dir_path');
		$this->EE->dbforge->create_table('greeny');
		
		// 
		/**
		 * In order to setup your custom tables, uncomment the line above, and 
		 * start adding them below!
		 */
		
		return TRUE;
	}

	// ----------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function uninstall()
	{
    $this->EE->load->dbforge();
    
		// Delete your custom tables & any ACT rows 
		// you have in the actions table
		
		$mod_id = $this->EE->db->select('module_id')
								->get_where('modules', array(
									'module_name'	=> 'Greeny'
								))->row('module_id');
		
		$this->EE->db->where('module_id', $mod_id)
					 ->delete('module_member_groups');
		
		$this->EE->db->where('module_name', 'Greeny')
					 ->delete('modules');					 
		
		$this->EE->db->where('class', 'Greeny')
					 ->delete('actions');
		
		$this->EE->dbforge->drop_table('greeny');			 
		
		
		return TRUE;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Module Updater
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		if ($current == $this->version)
		{
			return TRUE;
		}
		
		$this->EE->load->dbforge();
		
		if (version_compare($current, '1.0.3') < 0) 
		{
			$fields = array(
				'env_key'  => array('type' => 'varchar', 'constraint' => 15)
			);
			$this->EE->dbforge->add_column('greeny', $fields);
		} 
		
		return TRUE;
	}
	
}
/* End of file upd.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/upd.greeny.php */