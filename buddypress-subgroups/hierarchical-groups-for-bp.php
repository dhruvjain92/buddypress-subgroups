<?php
/**
 * Add hierarchical group functionality to your BuddyPress-powered community site.
 *
 * @package   BustomBPGroups
 * @author    Dhruv Jain
 * @license   GPL-2.0+
 * @copyright 2017 Dhruv Jain
 *
 * @wordpress-plugin
 * Plugin Name:       Buddypress Child Groups
 * Plugin URI:        http://junkyardcoders.com
 * Description:       Add hierarchical group functionality to your BuddyPress-powered community site.
 * Version:           1.0.0
 * Author:            Dhruv Jain
 * License:           GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

function hierarchical_groups_for_bp_init() {

	// Take an early out if the groups component isn't activated.
	if ( ! bp_is_active( 'groups' ) ) {
		return;
	}

	// This plugin requires BuddyPress 2.7 or greater.
	if ( ! function_exists( 'bp_get_version' ) || version_compare( bp_get_version(), '2.7', '<' ) ) {
		bp_core_add_message( __( 'Hierarchical Groups for BuddyPress requires BuddyPress 2.7 or newer.', 'hierarchical-groups-for-bp' ), 'error' );
		return;
	}

	// Helper functions
	require_once( plugin_dir_path( __FILE__ ) . 'includes/hgbp-internal-functions.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/hgbp-functions.php' );

	// Template output functions
	require_once( plugin_dir_path( __FILE__ ) . 'public/views/template-tags.php' );

	// The BP_Group_Extension class
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-bp-group-extension.php' );

	// The main class
	require_once( plugin_dir_path( __FILE__ ) . 'public/class-hgbp.php' );
	$hgbp_public = new HGBP_Public();
	$hgbp_public->add_action_hooks();

	// Admin and dashboard functionality
	if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		require_once( plugin_dir_path( __FILE__ ) . 'admin/class-hgbp-admin.php' );
		$hgbp_admin = new HGBP_Admin();
		$hgbp_admin->add_action_hooks();
	}

}
add_action( 'bp_loaded', 'hierarchical_groups_for_bp_init' );

/**
 * Helper function.
 *
 * @return Fully-qualified URI to the root of the plugin.
 */
function hgbp_get_plugin_base_uri(){
	return plugin_dir_url( __FILE__ );
}

/**
 * Helper function.
 *
 * @return Fully-qualified URI to the root of the plugin.
 */
function hgbp_get_plugin_base_name(){
	return plugin_basename( __FILE__ );
}

/**
 * Helper function to return the current version of the plugin.
 *
 * @return string Current version of plugin.
 */
function hgbp_get_plugin_version(){
	return '1.0.0';
}
