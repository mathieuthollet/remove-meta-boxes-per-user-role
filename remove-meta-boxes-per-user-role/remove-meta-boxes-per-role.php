<?php
/*
 Plugin Name: Remove meta boxes per user role
 Plugin URI: https://wordpress.org/plugins/remove-meta-boxes-per-user-role/
 Description: Remove meta boxes from new post / post edit pages, depending on user role 
 Version: 1.01
 Author: Mathieu Thollet
 Author URI: http://www.awebvision.fr
 Text Domain: remove-meta-boxes-per-user-role
 */

define("RMBPUR_PLUGIN_SLUG", "remove-meta-boxes-per-user-role");
define('RMBPUR_PATH', plugin_dir_path(__FILE__));
define('RMBPUR_WEB_PATH', plugin_dir_url(__FILE__));
define('RMBPUR_I18N_DOMAIN', 'remove-meta-boxes-per-user-role');



load_plugin_textdomain(RMBPUR_I18N_DOMAIN , false , dirname(plugin_basename( __FILE__ )).'/lang/');



/** Plugin install */
function rmbpur_install() {
	// Nothing to do !
}
register_activation_hook(__FILE__,'rmbpur_install');



/** Plugin uninstall */
function rmbpur_uninstall() {
	// Nothing to do !
}
register_deactivation_hook(__FILE__,'rmbpur_uninstall');



/** 
 * Add new admin menu
 */
function rmbpur_annuaire_admin_menu() {
	add_submenu_page('options-general.php', 'Remove meta boxes per user role', 'Remove meta boxes per user role', 'manage_options', 'remove-meta-boxes-per-user-role', 'rmbpur_settings_admin_page');
}
add_action('admin_menu', 'rmbpur_annuaire_admin_menu');



/** 
 * Displays admin settings page 
 */
function rmbpur_settings_admin_page() {
	require_once (RMBPUR_PATH.'admin_pages/settings.php');
}



/**
 * Hook admin_head
 * Remove boxes (call to wordpress function remove_meta_box)
 */
function rmbpur_admin_head() {
	global $wp_roles;
	foreach ($wp_roles->roles as $role => $wp_role) {
		if (current_user_can($role)) {
			$meta_boxes_to_hide = json_decode(get_option("rmbpur_".$role, "")); 
			if (!is_array($meta_boxes_to_hide))
				$meta_boxes_to_hide = array();
			foreach ($meta_boxes_to_hide as $meta_box_to_hide) {
				foreach (get_post_types() as $post_type) {
					$contexts = array('normal', 'advanced', 'side');
					foreach ($contexts as $context)
						remove_meta_box($meta_box_to_hide, $post_type, $context);
				}
			}			
		}
	}
}
add_action('admin_head', 'rmbpur_admin_head', 11);

?>