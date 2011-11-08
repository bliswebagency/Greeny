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
	
		if (strtolower($this->EE->config->item('greeny_enabled')) == "false"){
			die("Greeny has been disabled in the config settings.");
		}
		
		$newrecord = false;
		$out = "";
		//temp array... this will be replace by an array populated by the db
		$results = $this->EE->db->query("SELECT dir_path, env_key FROM exp_greeny");
		$roots = array();
		$envs = array();
		
		foreach ($results->result_array() as $row){
			array_push($roots, $row['dir_path']);
			array_push($envs, $row['env_key']);
		}
		
		
		//grab this site's root
		$current_root = $_SERVER['DOCUMENT_ROOT'];
		
		//make sure slashes are treated consistently
		if (substr($current_root, -1) != "/")
		$current_root = $current_root . "/";
		$current_env = $this->EE->config->item('greeny_env');
		
		//this automatically detects and records new environments... which is a lazy way of 
		//avoiding a bells and whistles CP screen - it's also better for the user!
		if (!in_array($current_root,$roots) && !in_array($current_env,$envs))
		{
			//whoa, hold your horses! what's this? a new environment? let's make a record of it.
			$data = array(
				'dir_path' => $current_root,
				'env_key'  => ($current_env) ? $current_env : NULL // insert NULL to the db rather than FALSE (empty string)
			);
			$sql = $this->EE->db->insert_string('exp_greeny', $data);
			$this->EE->db->query($sql);
			
			//display "new environment recorded"
			$out .= "New Environment Recorded...<br />";
			
			$newrecord = true;
		}
		
		//now let's check if this CMS knows which environment we're using
		$results = $this->EE->db->query("SELECT server_path FROM exp_upload_prefs LIMIT 0,1");

		$test_path = $results->row('server_path');
		
		if ($results->num_rows() == 0){
			$out .= "No upload locations defined";
			exit($out);
		}
		
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
						$current_id = $row['id'];

						//set new value
						$new_val = str_replace($old_path,$current_root,$current_val);
						
						$out .= "new record [$new_val]...<br />\r\n";
						
						//update this record with new value
						$data = array('server_path' => $new_val);
						$sql = $this->EE->db->update_string('exp_upload_prefs', $data, "id = '$current_id'");
						$this->EE->db->query($sql);
					}
					
				} else {
				
					//display "environment paths not correct - no previous match found"
					# OUTPUT MESSAGE
					$out .= "No previous environments matched - so nothing was changed. Maybe try relative paths or Deploy Helper..!";					
				
				}						
			
			} else {
				if ($newrecord == true) $out .= "All your paths checked out - you must have done it manually";
				else {					
					$out .= "Paths are all good sherif.";
					$out .= "Paths are all good sheriff.";
				}
			}
		}
		
		exit($out);
		 
	}
	
	// ----------------------------------------------------------------

	/**
	 * Start on your custom code here...
	 */
	
}
/* End of file mod.greeny.php */
/* Location: /system/expressionengine/third_party/greeny/mod.greeny.php */