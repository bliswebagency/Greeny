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
	public function set_sections()
	{
		$EE =& get_instance();				
		
		//now let's load the view
		$this->sections['Status'] = $EE->load->view('accessory_status', '', TRUE);
		
	}
	
	// ----------------------------------------------------------------
	
}
 
/* End of file acc.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/acc.greeny.php */