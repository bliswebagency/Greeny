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
 * Greeny Module Front End File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Blis Web Agency
 * @link		http://blis.net.au
 */

class Greeny {
	
	public $return_data;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	public function update(){
		
		$newrecord = false;
		
		//temp array... this will be replace by an array populated by the db
		$roots = array("/var/www/vhosts/mysite.net/subdomains/stage/httpdocs/","/var/www/vhosts/mysite.net/httpdocs/","/var/www/vhosts/mysite.net/subdomains/dev/httpdocs/","/Users/admin/Sites/ee2/");
		
		//grab this site's root
		$current_root = $_SERVER['DOCUMENT_ROOT'];
		
		//make sure slashes are treated consistently
		if (substr($current_root, -1) != "/")
		$current_root = $current_root . "/";
		
		//this automatically detects and records new environments... which is a lazy way of 
		//avoiding a bells and whistles CP screen - it's also better for the user!
		if (!in_array($current_root,$roots))
		{
		    //whoa, hold your horses! what's this? a new environment? let's make a record of it.
			
			//display "new environment recorded"
			echo "New Environment Recorded...";
			
			$newrecord = true;
		}
		
		//now let's check if this CMS knows which environment we're using
		$results = $this->EE->db->query("SELECT server_path FROM exp_upload_prefs LIMIT 0,1");

		$test_path = $results->row('server_path');
		
		if ($test_path !== NULL){

			if (strpos($test_path, $current_root) != 0 || strpos($test_path, $current_root) === FALSE)
			{
				//You're operating without a T-437 Springfield!!! 
				// - let's see if we can identify which environment this came from

				//loop through all of our environments and find a match
				$old_path = false;
				foreach($roots as $r){
			 	    $str = str_replace($r,$current_root,$test_path,$count);
					if ($count == 1) $old_path = $r;
				}
				
				if ($old_path){					
					
					$results = $this->EE->db->query("SELECT id,server_path FROM exp_upload_prefs");
					
					//ok, we know where these paths came from, let fix them
					foreach($results->result_array() as $row){
					
						//get current value
						$current_val = $row['server_path'];

						//set new value
						$new_val = str_replace($old_path,$current_root,$current_val);
						
						echo "new record [$new_val]...\r\n";
						//update this record with new value
						# WRITE TO DB
					}
					
				} else {
				
					//display "environment paths not correct - no previous match found"
					# OUTPUT MESSAGE
					echo "No previous environments matched - so nothing was changed. Maybe try relative paths or Deploy Helper..!";					
				
				}						
			
			} else {
				if ($newrecord == true) echo "All your paths checked out - you must have done it manually";
				else echo "Paths are all good sherif.";
			}
		}
		 
	}
	
	// ----------------------------------------------------------------

	/**
	 * Start on your custom code here...
	 */
	
}
/* End of file mod.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/mod.greeny.php */