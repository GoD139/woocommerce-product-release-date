<?php
/*
Plugin Name: Product Released
Plugin URI: http://fanboy.dk
description: Lets you enter when a product was originally released
Version: 1.0
Author: Benjamin Behrens
Author URI: http://benjaminbehrens.com
License: GPL2
*/


$productReleased = new productReleased();


/**
 *
 */
class productReleased
{

  private $releaseDate_id;

    public function __construct() {

      $this->releaseDate_id = 'product_released_date';

        add_action( 'woocommerce_product_options_general_product_data', array( $this,'cfwc_create_custom_field') );

        add_action('woocommerce_process_product_meta',array( $this, 'add_custom_linked_field_save' ));

    }






    function cfwc_create_custom_field() {
       $args = array(
       'id' => $this->releaseDate_id,
       'label' => __( 'Products release date', 'cfwc' ),
       'class' => 'cfwc-custom-field',
       'type' => 'date',
       'desc_tip' => true,
       'description' => __( 'Enter products release date', 'ctwc' ),
       );
       woocommerce_wp_text_input( $args );
      }



      public function add_custom_linked_field_save( $post_id ) {

        if ( !( isset( $_POST['woocommerce_meta_nonce'], $_POST[ $this->releaseDate_id ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
          return false;
        }

        $product_teaser = sanitize_text_field(wp_unslash( $_POST[ $this->releaseDate_id ] ));

        update_post_meta($post_id,$this->releaseDate_id,esc_attr( $product_teaser ));
      }


}
