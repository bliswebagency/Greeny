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
 * Greeny Accessory
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Accessory
 * @author		Blis Web Agency
 * @link		http://blis.net.au
 */
 
class Greeny_acc {
	
	public $name			= 'Greeny';
	public $id				= 'greeny';
	public $version			= '1.0';
	public $description		= 'Greeny';
	public $sections		= array();
	
	/**
	 * Set Sections
	 */
	function Greeny_acc()
	{
		$this->EE =& get_instance();
		$this->CI =& get_instance(); // since we need to load CI libraries
	} 
	 
	function set_sections()
	{
		
		$results = $this->EE->db->query("SELECT action_id FROM exp_actions WHERE class = 'Greeny' AND method = 'update' ORDER BY action_id DESC LIMIT 0,1");

		$act_id = $results->row('action_id');
		
		$vars['actid'] = $act_id;				
		
		//now let's load the view
		$this->sections['Status'] = $this->EE->load->view('accessory_status', $vars, TRUE);
		
	}
	
	// ----------------------------------------------------------------
	
}
 
/* End of file acc.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/acc.greeny.php */