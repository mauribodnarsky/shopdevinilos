<?php
/*
	Plugin Name: Sucursales de Correo Argentino para WooCommerce
	Plugin URI:  https://wanderlust-webdesign.com
	Description: Conector a la API de Correo Argentino. Obtener sucursales de entrega en el checkout.
	Version:     0.0.3
	Author:      wanderlust-webdesign.com
	Author URI:  https://shop.wanderlust-webdesign.com
	WC tested up to: 4.4.1
	License:     GPL2
	License URI: https://www.gnu.org/licenses/gpl-2.0.html
	Text Domain: woo-correo-argentino
	Domain Path: /languages
*/


/**
 * Plugin global API URL
*/

function wanderlust_ca_start() {
	global $wp_session;
}
add_action('init','wanderlust_ca_start');

$wp_session['url_ca'] = 'https://wanderlust.codes/correoargentino/';

require_once( 'includes/functions.php' );

/**
 * Plugin page links
*/
function wc_ca_plugin_links( $links ) {

	$plugin_links = array(
		'<a href="https://wanderlust-webdesign.com/">' . __( 'Soporte', 'woocommerce-shipping-ca' ) . '</a>',
	);

	return array_merge( $plugin_links, $links );
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_ca_plugin_links' );

/**
 * WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	/**
	 * woocommerce_init_shipping_table_rate function.
	 *
	 * @access public
	 * @return void
	 */
	function wc_ca_init() {
		include_once( 'includes/class-wc-shipping-ca.php' );
	}
  add_action( 'woocommerce_shipping_init', 'wc_ca_init' ); 

	/**
	 * wc_ca_add_method function.
	 *
	 * @access public
	 * @param mixed $methods
	 * @return void
	 */
	function wc_ca_add_method( $methods ) {
		$methods[ 'ca_wanderlust' ] = 'WC_Shipping_CA';
		return $methods;
	}

	add_filter( 'woocommerce_shipping_methods', 'wc_ca_add_method' );

	/**
	 * wc_ca_scripts function.
	 */
	function wc_ca_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	add_action( 'admin_enqueue_scripts', 'wc_ca_scripts' );

	$ca_settings = get_option( 'woocommerce_ca_settings', array() ); 
	
}       