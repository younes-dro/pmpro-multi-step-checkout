<?php

if ( ! class_exists( 'Multi_Step_Checkout_Pmpro_Settings' ) ) {
	/**
	 * Class Multi_Step_Checkout_Pmpro_Settings
	 * Handles settings and administration for the Multi Step Checkout PMPro plugin.
	 */
	class Multi_Step_Checkout_Pmpro_Settings {

		/**
		 * Multi_Step_Checkout_Pmpro_Settings constructor.
		 * Initializes the class and registers necessary actions.
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_enqueue_scripts' ) );
			add_action( 'admin_menu', array( $this, 'multi_step_checkout' ) );
		}

		/**
		 * Register and enqueue styles for the plugin.
		 */
		public function register_enqueue_styles() {
			wp_register_style( Multi_Step_Checkout_Pmpro()->get_plugin_name() . '-admin', Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/admin/css/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.css', array(), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
		}

		/**
		 * Register and enqueue scripts for the plugin.
		 */
		public function register_enqueue_scripts() {
			wp_register_script( Multi_Step_Checkout_Pmpro()->get_plugin_name() . '-admin', Multi_Step_Checkout_Pmpro()->plugin_url() . '/assets/admin/js/' . Multi_Step_Checkout_Pmpro()->get_plugin_name() . '.js', array( 'jquery' ), Multi_Step_Checkout_Pmpro()->get_plugin_version() );
			$script_params = array(
				'admin_ajax'                          => admin_url( 'admin-ajax.php' ),
				'ets_multi_step_checkout_pmpro_nonce' => wp_create_nonce( 'ets-_multi-step-checkout-pmpro-ajax-nonce' ),
			);
			wp_localize_script( Multi_Step_Checkout_Pmpro()->get_plugin_name() . '-admin', 'etsMultiStepCheckoutPmproParamsAdmin', $script_params );
		}

		/**
		 * Add submenu page for Multi Step Checkout settings under PMPro dashboard.
		 */
		public function multi_step_checkout() {
			add_submenu_page( 'pmpro-dashboard', esc_html( 'multi-step-checkout', 'multi-step-checkout-pmpro' ), esc_html( 'MSC', 'multi-step-checkout-pmpro' ), 'manage_options', 'multi-step-checkout', array( $this, 'settings_page' ) );
		}

		/**
		 * Render settings page for Multi Step Checkout.
		 */
		public function settings_page() {
			wp_enqueue_style( Multi_Step_Checkout_Pmpro()->get_plugin_name() . '-admin' );
			wp_enqueue_script( Multi_Step_Checkout_Pmpro()->get_plugin_name() . '-admin' );
			ob_start();
			require_once Multi_Step_Checkout_Pmpro()->plugin_path() . '/admin/template/settings.php';
			$settings = ob_get_clean();
			echo( $settings );
		}

		/**
		 * Get allowed HTML tags and attributes for output sanitization.
		 *
		 * @return array Allowed HTML tags and attributes.
		 */
		public static function allowed_html() {
			$allowed_html = array(
				'div' => array(
					'class' => array(),
				),
				'p'   => array(
					'class' => array(),
				),
				'a'   => array(
					'id'           => array(),
					'href'         => array(),
					'class'        => array(),
					'style'        => array(),
				),
				'img' => array(
					'src'   => array(),
					'class' => array(),
				),
				'h1'  => array(),
				'b'   => array(),
			);

			return $allowed_html;
		}
	}
}
