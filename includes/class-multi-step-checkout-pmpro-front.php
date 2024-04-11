<?php

if ( ! class_exists( 'Multi_Step_Checkout_Pmpro_Front' ) ) {


	class Multi_Step_Checkout_Pmpro_Front {



		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_enqueue_scripts' ) );
			// add_action( 'template_redirect', array( $this, 'enqueue_scripts_and_styles' ) );
			add_action( 'pmpro_checkout_before_form', array( $this, 'display_header_steps' ) );
		}

		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		public function register_enqueue_styles() {

			wp_register_style( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/css/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.css', array(), Multi_Step_Checkout_Pmpro()->get_plugin_version() );

		}

		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		public function register_enqueue_scripts() {
			wp_register_script( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/js/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.js', array( 'jquery' ), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
			$script_params = array(
				'admin_ajax'                          => admin_url( 'admin-ajax.php' ),
				'ets_multi_step_checkout_pmpro_nonce' => wp_create_nonce( 'ets-_multi-step-checkout-pmpro-ajax-nonce' ),
			);
			wp_localize_script( Multi_Step_Checkout_Pmpro()->get_plugin_name(), 'etsMultiStepCheckoutPmproParams', $script_params );
		}


		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		// public function enqueue_scripts_and_styles() {
		// global $pmpro_pages;

		// if ( ! empty( $pmpro_pages ) && is_page( $pmpro_pages['checkout'] ) ) {
		// wp_enqueue_style( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/css/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.css', array(), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
		// wp_enqueue_script( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/js/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.js', array( 'jquery' ), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
		// }
		// }

		public function display_header_steps() {
			wp_enqueue_style( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/css/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.css', array(), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
			wp_enqueue_script( Multi_Step_Checkout_Pmpro()->get_plugin_name(), Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/public/js/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.js', array( 'jquery' ), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
			echo '<div id="progress-steps">
			<div class="step active" data-step="pmpro_checkout_box-custom-fields">Your Information</div>
			<div class="step" data-step="pmpro_pricing_fields">Membership Level</div>
			<div class="step" data-step="pmpro_user_fields">Account Information</div>
			
			<div class="step" data-step="pmpro_billing_address_fields">Billing Address</div>
			<div class="step" data-step="pmpro_payment_information_fields">Payment Information</div>
			</div>
			<div id="ets-navigation-buttons-wrapper">
				<div  class="ets-navigation-buttons">
				<span class="ets-button ets-prevBtn">Previous</span>
				<span class="ets-button ets-nextBtn">Next</span>
				</div>
			</div>	
	';
		}

	}
}
