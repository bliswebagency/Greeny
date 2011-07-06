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
 * Greeny Module Control Panel File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Blis Web Agency
 * @link		http://blis.net.au
 */

class Greeny_mcp {
	
	public $return_data;
	
	private $_base_url;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
		
		$this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=greeny';
		
		$this->EE->cp->set_right_nav(array(
			'module_home'	=> $this->_base_url,
			// Add more right nav items here.
		));
		
		
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @return 	void
	 */
	public function index()
	{
		$this->EE->cp->set_variable('cp_page_title', 
								lang('greeny_module_name'));
		
		$results = $this->EE->db->query("SELECT action_id FROM exp_actions WHERE class = 'Greeny' AND method = 'update' ORDER BY action_id DESC LIMIT 0,1");

		$act_id = $results->row('action_id');
		
		$vars['actid'] = $act_id;

		return $this->EE->load->view('index', $vars, TRUE);		
		 
	}

	/**
	 * Start on your custom code here...
	 */
	
}
/* End of file mcp.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/mcp.greeny.php */