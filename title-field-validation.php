<?php
/**
 * @package Title Field Validation
 */
/*
/*
Plugin Name: Title Field Validation
Plugin URI: http://wordpress.org/plugins/title-field-validation/
Description: This is custom plugin for wordpress title and content field validation.
Author: Shamini K.N
Version: 1.1
Author URI: 
textdomain: title-field-validation
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
/*
Copyright 2017  Shamini K.N  (email : shamini.kn@gmail.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2017-2017 Automattic, Inc.
*/
define( 'TFV_VERSION', '1.0' );
define( 'TFV__MINIMUM_WP_VERSION', '3.5' );
define( 'TFV__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TFV_DELETE_LIMIT', 100000 );

require(TFV__PLUGIN_DIR . 'includes/title-field-validation-forms.php' );

if (!function_exists('tfv_load_scripts')) {
/**
* Function that enqueue scripts.
*/
	function tfv_load_scripts(){

		wp_enqueue_script('tfv_ajax',plugin_dir_url(__FILE__).'js/title-field-validation-scripts.js',array('jquery'));
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('tfv_validation',plugin_dir_url(__FILE__).'js/jquery-validate.js',array('jquery'));
	    wp_enqueue_script('tfv_bootstrapcdn',plugin_dir_url(__FILE__).'js/bootstrap-min.js',array('jquery')); 

	}

	add_action('admin_enqueue_scripts','tfv_load_scripts');
}

if (!function_exists('tfv_load_styles')) {
/**
* Function that enqueue styles.
*/
	function tfv_load_styles(){

		wp_register_style('tfv_style',plugin_dir_url(__FILE__).'css/title-field-validation-styles.css');
		wp_enqueue_style( 'tfv_style' );

	}
	add_action('admin_enqueue_scripts','tfv_load_styles');
}

if (!function_exists('tfv_create_table')) {
/**
* Function that adds new table for validation settings
*/

	function tfv_create_table(){

		global $wpdb;
		//---------------Table for Validation
		$table_validation = $wpdb->prefix."tfv_validation";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_validation'") !== $table_validation)
		{
			$tbl_validation="CREATE TABLE $table_validation(
			 `validation_id` int(11) NOT NULL AUTO_INCREMENT,
			 `post_type` varchar(255) NOT NULL,
			 `title_label` varchar(255) NOT NULL,
			 `title_error_msg` varchar(255) NOT NULL,
			 `content_label` varchar(255) NOT NULL,
			 `content_error_msg` varchar(255) NOT NULL,
			 `created_at` datetime NOT NULL,
			 `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			 `flag` int(11) NOT NULL DEFAULT '1',
			 PRIMARY KEY (`validation_id`)
			)";
		}
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	    dbDelta($tbl_validation);

	}
	register_activation_hook( __FILE__, 'tfv_create_table' );
}

if (!function_exists('tfv_admin_head_add_fields')) {
/**
* Function that adds new hidden fields for validation settings
*/

	function tfv_admin_head_add_fields() {
	?>
	    <input type="hidden" id="new-post-type">
	    <input type="hidden" id="new-title-label">
		<input type="hidden" id="new-title-error">
		<input type="hidden" id="new-content-label">
		<input type="hidden" id="new-content-error">
	<?php
	}
	add_action('edit_form_after_title', 'tfv_admin_head_add_fields');
}
?>