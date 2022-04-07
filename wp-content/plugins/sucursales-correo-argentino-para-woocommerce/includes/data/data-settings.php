<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Array of settings
 */
return array(
	'enabled'           => array(
		'title'           => __( 'Activar Correo Argentino - Sucursales', 'woocommerce-shipping-ca' ),
		'type'            => 'checkbox',
		'label'           => __( 'Activar este método de envió', 'woocommerce-shipping-ca' ),
		'default'         => 'no'
	),

	'title'             => array(
		'title'           => __( 'Título', 'woocommerce-shipping-ca' ),
		'type'            => 'text',
		'description'     => __( 'Controla el título que el usuario ve durante el pago.', 'woocommerce-shipping-ca' ),
		'default'         => __( 'Correo Argentino - Sucursales', 'woocommerce-shipping-ca' ),
		'desc_tip'        => true
	),
 
   'api'              => array(
		'title'           => __( 'Configuración de la API', 'woocommerce-shipping-ca' ),
		'type'            => 'title',
		'description'     => __( '', 'woocommerce-shipping-ca' ),
    ),
	
   'api_key'          => array(
		'title'           => __( 'Wanderlust API Key', 'woocommerce-shipping-ca' ),
		'type'            => 'text',
		'description'     => __( 'Wanderlust API Key', 'woocommerce-shipping-ca' ),
		'default'         => __( 'wEWW5yPc2zEpsXOjD', 'woocommerce-shipping-ca' ),
    'placeholder' => __( 'wEWW5yPc2zEpsXOjD', 'meta-box' ),
    ),
	
	
   'ajuste_precio'    => array(
		'title'           => __( 'Costo a Sucursal', 'woocommerce-shipping-ca' ),
		'type'            => 'text',
		'description'     => __( 'Agregar costo a Sucursal.', 'woocommerce-shipping-ca' ),
		'default'         => __( '', 'woocommerce-shipping-ca' ),
    'placeholder' => __( '1', 'meta-box' ),		
    ),	
   'precio_gratis'    => array(
		'title'           => __( 'Envio Gratis', 'woocommerce-shipping-ca' ),
		'type'            => 'text',
		'description'     => __( 'Envio gratis para montos superiores a:', 'woocommerce-shipping-ca' ),
		'default'         => __( '', 'woocommerce-shipping-ca' ),
    'placeholder' => __( '1', 'meta-box' ),		
    ),	
);