<?php

/**
 * Fired during plugin activation
 *
 * @link       https://***********
 * @since      1.0.0
 *
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/includes
 * @author     *********** <webmaster@***********>
 */
class Bcbs_Qr_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        flush_rewrite_rules();
	}

}
