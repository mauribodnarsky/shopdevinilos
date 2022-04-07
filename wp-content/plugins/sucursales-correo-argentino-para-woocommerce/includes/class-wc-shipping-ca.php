<?php
error_reporting(0);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Shipping_CA class.
 *
 * @extends WC_Shipping_Method
 */
class WC_Shipping_CA extends WC_Shipping_Method {
	private $default_boxes;
	private $found_rates;

	/**
	 * Constructor
	 */
	public function __construct( $instance_id = 0 ) {
		
		$this->id                   = 'ca_wanderlust';
		$this->instance_id 			 		= absint( $instance_id );
		$this->method_title         = __( 'Correo Argentino - Sucursales', 'woocommerce-shipping-ca' );
 		$this->method_description   = __( 'Obtener sucursales de Correo Argentino.', 'woocommerce' );
		$this->default_boxes 				= include( 'data/data-box-sizes.php' );
		$this->supports             = array(
			'shipping-zones',
			'instance-settings',
		);

		$this->init();
		
 		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

	}

	/**
	 * init function.
	 */
	public function init() {
		// Load the settings.
		$this->init_form_fields = include( 'data/data-settings.php' );
		$this->init_settings();
		$this->instance_form_fields = include( 'data/data-settings.php' );
	 
		// Define user set variables
		$this->title           = $this->get_option( 'title', $this->method_title );
		$this->api_key    		 = $this->get_option( 'api_key' );
		$this->ajuste_precio   = $this->get_option( 'ajuste_precio' );
    $this->precio_gratis   = $this->get_option('precio_gratis');
	}

 
	/**
	 * environment_check function.
	 */
	private function environment_check() {
		if ( ! in_array( WC()->countries->get_base_country(), array( 'AR' ) ) ) {
			echo '<div class="error">
				<p>' . __( 'Argentina tiene que ser el pais de Origen.', 'woocommerce-shipping-ca' ) . '</p>
			</div>';
		}  
	}

	/**
	 * admin_options function.
	 */
	public function admin_options() {
		// Check users environment supports this method
		$this->environment_check();

		// Show settings
		parent::admin_options();
	}

 
	/**
	 * calculate_shipping function.
	 *
	 * @param mixed $package
	 */
	public function calculate_shipping( $package = array() ) {
		global $wp_session; 	
    
    $seguro = round($package['contents_cost']);

    if($seguro > $this->precio_gratis && !empty($this->precio_gratis) ){
      $costo = 0;
    } else {
      $costo = $this->ajuste_precio;
    }
    
       					
      $rate = array(
        'id' => sprintf("%s", 'sucursal_correo_argentino'),
				'label' => sprintf("%s", 'Sucursal Correo Argentino'),
				'cost' => $costo,
				'calc_tax' => 'per_item',
				'package' => $package,
      );			
      $this->add_rate( $rate );
  	 
 	}

	/**
	 * sort_rates function.
	 **/
	public function sort_rates( $a, $b ) {
		if ( $a['sort'] == $b['sort'] ) return 0;
		return ( $a['sort'] < $b['sort'] ) ? -1 : 1;
	}
}