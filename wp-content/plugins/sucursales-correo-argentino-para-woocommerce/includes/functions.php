<?php
  global $wp_session;

  add_action('wp_ajax_get_sucursales_ca', 'get_sucursales_ca', 1);
  add_action('wp_ajax_nopriv_get_sucursales_ca', 'get_sucursales_ca', 1);

  add_action('wp_ajax_get_localidades_ca', 'get_localidades_ca', 1);
  add_action('wp_ajax_nopriv_get_localidades_ca', 'get_localidades_ca', 1);

  function get_localidades_ca(){
    $client_state = $_POST['state'];
    if ($client_state == 'C') {$client_state = 'CAPITAL FEDERAL';}
    if ($client_state == 'B') { $client_state = 'Buenos Aires'; }
    if ($client_state == 'K') { $client_state = 'Catamarca';  }
    if ($client_state == 'H') { $client_state = 'Chaco';  }
    if ($client_state == 'U') { $client_state = 'Chubut'; }
    if ($client_state == 'X') { $client_state = 'Cordoba';  }
    if ($client_state == 'W') { $client_state = 'Corrientes'; }
    if ($client_state == 'E') { $client_state = 'Entre Rios'; }
    if ($client_state == 'P') { $client_state = 'Formosa';  }
    if ($client_state == 'Y') { $client_state = 'Jujuy';  }
    if ($client_state == 'L') { $client_state = 'La Pampa'; }
    if ($client_state == 'F') { $client_state = 'La Rioja'; }
    if ($client_state == 'M') { $client_state = 'Mendoza';  }
    if ($client_state == 'N') { $client_state = 'Misiones'; }
    if ($client_state == 'Q') { $client_state = 'Neuquen';  }
    if ($client_state == 'R') { $client_state = 'Rio Negro';  }
    if ($client_state == 'A') { $client_state = 'Salta';  }
    if ($client_state == 'J') { $client_state = 'San Juan'; }
    if ($client_state == 'D') { $client_state = 'San Luis'; }
    if ($client_state == 'Z') { $client_state = 'Santa Cruz'; }
    if ($client_state == 'S') { $client_state = 'Santa Fe'; }
    if ($client_state == 'G') { $client_state = 'Santiago del Estero';  }
    if ($client_state == 'V') { $client_state = 'Tierra del Fuego'; }
    if ($client_state == 'T') { $client_state = 'Tucuman';  } 
    
    $f_pointer = fopen( plugin_dir_path( __FILE__ ) . "assets/localidades.csv","r"); // file pointer
    $listado = array();

    $all_rows = array();
    $header = fgetcsv($f_pointer);
    while ($row = fgetcsv($f_pointer)) {
      $all_rows[] = array_combine($header, $row);
    }
    
    foreach($all_rows as $sucursales){
       if($sucursales['PROVINCIA'] == strtoupper($client_state) && $sucursales['HABILITADA'] == 'SI'){
        $listado[] = $sucursales['PARTIDO'];
      }
    }

    $casa = array_unique($listado, SORT_REGULAR  );
 
    echo '<select id="listas" name="listas" style="border-radius: 5px;">';
      
        $listado_ca = array();
      
        foreach($casa as $sucursales){
          $idCentroImposicion = $sucursales;
          $sucursales = ucwords(strtolower($sucursales));
         
          echo '<option value="'. $idCentroImposicion.'">'. $sucursales . '</option>';
        }
      
        echo '</select>';
  die();
  }


  function get_sucursales_ca() {
    global $wp_session;
    
    if (isset($_POST['state'])) {
      
      $params = array(
            "method" => array(
                 "get_sucursales" => array(
                        'state' => $_POST['state'],
                        'partido' => $_POST['partido'],
                 )
            )
        );
                  
        $ca_response = wp_remote_post( $wp_session['url_ca'], array(
          'body'    => $params,
        ) );
  
        $ca_response = json_decode($ca_response['body']);     
       
      
        echo '<select id="pv_centro_ca_estandar" name="pv_centro_ca_estandar">';
      
        $listado_ca = array();
      
        foreach($ca_response as $sucursales){
          $idCentroImposicion = $sucursales->CALLE . ' - ' . $sucursales->NUMERO . ' - ' . $sucursales->LOCALIDAD . ' - ' . $sucursales->PROVINCIA;
      
         
          echo '<option value="'. $idCentroImposicion.'">'. $sucursales->CALLE . ' - ' . $sucursales->NUMERO . ' - ' . $sucursales->LOCALIDAD . ' - ' . $sucursales->PROVINCIA . '</option>';
        }
      
        echo '</select>';
        
               
      die();
    }
  }

   


  add_action( 'wp_footer', 'only_numbers_cas');
  function only_numbers_cas(){ 
    if ( is_checkout() ) { ?>
      <script type="text/javascript">
        jQuery(document).ready(function () {  
                   
        jQuery('#order_sucursal_main_ca').insertAfter( jQuery( '.woocommerce-checkout-review-order-table' ) );
          
            jQuery('#billing_state').change(function () {  
              
              var state = jQuery('#billing_state').val();
               
              jQuery.ajax({
                type: 'POST',
                cache: false,
                url: wc_checkout_params.ajax_url,
                data: {
                  action: 'get_localidades_ca',
                  state: state,
                },
                success: function(data, textStatus, XMLHttpRequest){
                      jQuery('#order_partido_main').insertAfter( jQuery( '#billing_state_field' ) );
                      jQuery('#order_partido_main').fadeIn();
                      jQuery('#lista').html(data);
                      jQuery("#listas").prepend("<option value='0' selected='selected'>Seleccionar Partido</option>");
                  
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){ }
                  });
                return false;
            });
          
          
            jQuery(document).on('change', '#listas', function() {
              
              if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
                var state = jQuery('#shipping_state').val();
              } else {
                var state = jQuery('#billing_state').val();
              }
              
              var partido = jQuery('#listas').val();
               
              if ( jQuery('#shipping_method li').length > 1 ) {
                var selectedMethod = jQuery('input:checked', '#shipping_method').val();
                var selectedMethodb = jQuery( "#order_review .shipping .shipping_method option:selected" ).val();
                if (selectedMethod == null) {
                    if(selectedMethodb != null){
                      selectedMethod = selectedMethodb;
                    } else {
                      return false;
                    }
                } 
              } else {
               var selectedMethod = jQuery('#shipping_method li .shipping_method').val();
              }
                            
              var order_sucursal = 'ok';
             
              if (selectedMethod == 'sucursal_correo_argentino') {
                jQuery('#order_sucursal_main_ca').show();
                jQuery('#order_sucursal_main_ca').insertAfter( jQuery('.shop_table') );
                jQuery("#order_sucursal_main_ca_result").fadeOut(100);
                jQuery("#order_sucursal_main_ca_result_cargando").fadeIn(100);  
                jQuery.ajax({
                  type: 'POST',
                  cache: false,
                  url: wc_checkout_params.ajax_url,
                  data: {
                    action: 'get_sucursales_ca',
                    state: state,
                    partido: partido,
                  },
                  success: function(data, textStatus, XMLHttpRequest){
                        jQuery("#order_sucursal_main_ca_result").fadeIn(100);
                        jQuery("#order_sucursal_main_ca_result_cargando").fadeOut(100); 
                        jQuery("#order_sucursal_main_ca_result").html('');
                        jQuery("#order_sucursal_main_ca_result").append(data);

                        var selectList = jQuery('#pv_centro_ca_estandar option');
                        var arr = selectList.map(function(_, o) { return { t: jQuery(o).text(), v: o.value }; }).get();
                        arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                        selectList.each(function(i, o) {
                          o.value = arr[i].v;
                          jQuery(o).text(arr[i].t);
                        });
                        jQuery('#pv_centro_ca_estandar').html(selectList);
                        jQuery("#pv_centro_ca_estandar").prepend("<option value='0' selected='selected'>Sucursales Disponibles</option>");

                      },
                      error: function(MLHttpRequest, textStatus, errorThrown){ }
                });
                return false;   
              }
            });   
          
        });

        function toggleCustomBox() {
          
              if ( jQuery('#shipping_method li').length > 1 ) {
                var selectedMethod = jQuery('input:checked', '#shipping_method').val();
                var selectedMethodb = jQuery( "#order_review .shipping .shipping_method option:selected" ).val();
                if (selectedMethod == null) {
                    if(selectedMethodb != null){
                      selectedMethod = selectedMethodb;
                    } else {
                      return false;
                    }
                } 
              } else {
               var selectedMethod = jQuery('#shipping_method li .shipping_method').val();
              }
          
                 if (selectedMethod == 'sucursal_correo_argentino') {
                  var partido = jQuery('#listas').val();
                  if (partido != null){
                     
                    jQuery(document).on('updated_checkout', function(data) {
                      jQuery('#order_sucursal_main_ca').show();
                      jQuery('#order_sucursal_main_ca').insertAfter( jQuery('.shop_table') );
                    });
                  

                  if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
                    var state = jQuery('#shipping_state').val();
                  } else {
                    var state = jQuery('#billing_state').val();
                  }
                  
                    var order_sucursal = 'ok';
                    jQuery("#order_sucursal_main_ca_result").fadeOut(100);
                    jQuery("#order_sucursal_main_ca_result_cargando").fadeIn(100);  
                    jQuery.ajax({
                      type: 'POST',
                      cache: false,
                      url: wc_checkout_params.ajax_url,
                      data: {
                        action: 'get_sucursales_ca',
                        state: state,
                        partido: partido,
                      },
                      success: function(data, textStatus, XMLHttpRequest){
                            jQuery("#order_sucursal_main_ca_result").fadeIn(100);
                            jQuery("#order_sucursal_main_ca_result_cargando").fadeOut(100); 
                            jQuery("#order_sucursal_main_ca_result").html('');
                            jQuery("#order_sucursal_main_ca_result").append(data);

                          var selectList = jQuery('#pv_centro_ca_estandar option');
                          var arr = selectList.map(function(_, o) { return { t: jQuery(o).text(), v: o.value }; }).get();
                          arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                          selectList.each(function(i, o) {
                            o.value = arr[i].v;
                            jQuery(o).text(arr[i].t);
                          });
                          jQuery('#pv_centro_ca_estandar').html(selectList);
                          jQuery("#pv_centro_ca_estandar").prepend("<option value='0' selected='selected'>Sucursales Disponibles</option>");                    

                          },
                          error: function(MLHttpRequest, textStatus, errorThrown){ }
                        });
                    return false;         
                  }  
                } else {
                  jQuery('#order_sucursal_main_ca').hide();
                  jQuery('#order_sucursal_main_ca').fadeOut();
                }
        }; //ends toggleCustomBox

        jQuery(document).ready(toggleCustomBox);
        //jQuery(document).on('change', '#shipping_method input:radio', toggleCustomBox);
        jQuery(document).on('change', '#order_review .shipping .shipping_method', toggleCustomBox);

        jQuery(document).on('updated_checkout', function() {
          var selectedMethod = jQuery('input:checked', '#shipping_method').val();
                var selectedMethodb = jQuery( '#order_review .shipping .shipping_method option:selected' ).val();
                if (selectedMethod == null) {
                  if(selectedMethodb != null){
                    selectedMethod = selectedMethodb;
                  } else {
                    return false;
                  }
                }                   
                   
          
                if (selectedMethod == 'sucursal_correo_argentino') {
                  jQuery('#order_sucursal_main_ca').show();
                  jQuery('#order_sucursal_main_ca').fadeIn();
                  var partido = jQuery('#listas').val();
                  if (partido != null){
                    
                    if (partido == 0){
                      jQuery('#order_sucursal_main_ca').hide();
                      jQuery('#order_sucursal_main_ca').fadeOut(); 
                     
                    } else {
                     
                    }
                     

                  } else {
                     
                    jQuery('#order_sucursal_main_ca').hide();
                    jQuery('#order_sucursal_main_ca').fadeOut();                   
                  }
                    
                } else {
                  jQuery('#order_sucursal_main_ca').hide();
                  jQuery('#order_sucursal_main_ca').fadeOut();
                }
          
        });       
      </script>

      <style type="text/css">
         #order_sucursal_main_ca h3 {
            text-align: left;
            padding: 5px 0 5px 115px;
        }
        .ca-logo {
          position: absolute;
          margin: 0px;
        }
      </style>
    <?php }
  } //ends only_numbers_cas

  /**
   * Add the field to the checkout
   */
  add_action( 'woocommerce_after_order_notes', 'order_sucursal_main_ca' );
  function order_sucursal_main_ca( $checkout ) {
    global $woocommerce, $wp_session;
  
     echo '<div id="order_partido_main" style="display:none; margin-bottom: 5px;  margin-top: 10px;"><span>Partido</span><div id="lista"></div></div>';
     
   
    echo '<div id="order_sucursal_main_ca" style="display:none; margin-bottom: 50px;"><img class="ca-logo" src="'. plugins_url( 'img/suc-ca.png', __FILE__ ) . '"><h3>' . __('Sucursal Correo Argentino') . '</h3>';
      echo '<small>Si seleccionaste retirar por sucursal, elegí tu sucursal en el listado.</small>';
      echo '<div id="order_sucursal_main_ca_result_cargando">Cargando Sucursales...';echo '</div>';
      echo '<div id="order_sucursal_main_ca_result" style="display:none;">Cargando Sucursales...';echo '</div>';
    echo '</div>';
  
  }


   /**
   * Process the checkout
   */
  add_action('woocommerce_checkout_process', 'checkout_field_ca_process');
  function checkout_field_ca_process() {
      global $woocommerce, $wp_session;
    
      $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      $chosen_shipping = $chosen_methods[0]; 
      $wp_session['chosen_shipping'] = $chosen_shipping;
      if (strpos($chosen_shipping, 'sucursal_correo_argentino') !== false) {
        if (empty($_POST['pv_centro_ca_estandar']) )
                  wc_add_notice( __( 'Por favor, seleccionar sucursal de retiro.' ), 'error' ); 
      } 
  }

  add_action( 'woocommerce_admin_order_data_after_shipping_address', 'edit_woocommerce_checkout_page_ca', 10, 1 );

  function edit_woocommerce_checkout_page_ca($order){
      global $post_id;
      $order = wc_get_order( $post_id );
      echo '<p><strong>'.__('Sucursal Correo Argentino').':</strong> ' . get_post_meta($post_id, '_sucursal_pv_centro_ca_estandar', true ) . '</p>';
  }

    add_action( 'woocommerce_thankyou', 'ca_add_content_thankyou' );

    function ca_add_content_thankyou($order_id) {
      $sucursal = get_post_meta($order_id, '_sucursal_pv_centro_ca_estandar', true );
      if($sucursal){
        echo '<p><strong>'.__('Sucursal Correo Argentino').':</strong> ' . $sucursal . '</p>';
      }
    }

   /**
   * Update the order meta with field value
   */
  add_action( 'woocommerce_checkout_update_order_meta', 'order_sucursal_main_update_order_meta_ca', 10);
  function order_sucursal_main_update_order_meta_ca( $order_id ) {
    global $wp_session;
   
      if ( ! empty( $_POST['pv_centro_ca_estandar'] ) ) {
        
        update_post_meta( $order_id, '_sucursal_pv_centro_ca_estandar', $_POST['pv_centro_ca_estandar'] );
        
      }
       
  }  

?>