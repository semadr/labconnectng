<?php
/**
 * Plugin Name:       LabConnect Widgets for Elementor
 * Description:       The LabConnect NG design system as Elementor widgets — atoms (buttons, badges, headings…), molecules (cards, pricing, steps…) and full sections.
 * Version:           1.0.0
 * Author:            LabConnect NG
 * Text Domain:       labconnect-widgets
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Elementor tested up to: 3.27
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LCW_VERSION', '1.0.0' );
define( 'LCW_FILE', __FILE__ );
define( 'LCW_PATH', plugin_dir_path( __FILE__ ) );
define( 'LCW_URL', plugin_dir_url( __FILE__ ) );

require_once LCW_PATH . 'includes/class-plugin.php';

add_action( 'plugins_loaded', [ 'LCW\\Plugin', 'instance' ] );
