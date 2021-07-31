<?php
/**
 * Kpi Series
 *
 * Plugin Name:       Kpi Series
 * Plugin URI:        https://github.com/limikael/wp-kpi-series
 * Description:       Visualize data series.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mikael Lindqvist
 */

defined( 'ABSPATH' ) || exit;

define('KPISER_URL',plugin_dir_url(__FILE__));
define('KPISER_PATH',plugin_dir_path(__FILE__));

require_once(__DIR__."/inc/plugin/KpiSerPlugin.php");

/*function tonopah_activate() {
	tonopah\TonopahPlugin::instance()->activate();
}
register_activation_hook( __FILE__, 'tonopah_activate' );

function tonopah_deactivate() {
	tonopah\TonopahPlugin::instance()->deactivate();
}
register_deactivation_hook( __FILE__, 'tonopah_deactivate' );

function tonopah_uninstall() {
	tonopah\TonopahPlugin::instance()->uninstall();
}
register_uninstall_hook( __FILE__, 'tonopah_uninstall' );*/

kpiser\KpiSerPlugin::instance();
