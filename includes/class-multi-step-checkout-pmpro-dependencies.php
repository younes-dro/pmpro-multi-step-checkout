<?php

/**
 * Manages the dependencies that the Plugin needs to operate.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check the compatibility of the environment.
 *
 * @class Multi_Step_Checkout_Pmpro_Dependencies
 * @author Younes DRO <younesdro@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class Multi_Step_Checkout_Pmpro_Dependencies {

	/** minimum pmpro version required by this plugin */
	const MINIMUM_PMPRO_VERSION = '3.0';

	public function __construct() {

	}


	/**
	 * Checks Paid Memberships Pro is installed, activated and compatible.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Return true if the Paid Memberships Pro is installed , activated and the version is compatible.Otherwise, will return false.
	 */
	public static function check_pmpro_version() {

		return defined( 'PMPRO_VERSION' ) && version_compare( PMPRO_VERSION, self::MINIMUM_PMPRO_VERSION, '>=' );
	}

	/**
	 * Gets the message for display when Paid Memberships Pro version is not installed , not activated or incompatible with this plugin.
	 *
	 * @return string Return an informative message.
	 */
	public function get_pmpro_notice() {

		return sprintf(
			esc_html__( '%1$s, as it requires %2$sPaid Memberships Pro%3$s version %4$s or higher. Please %5$supdate%6$s or activate Paid Memberships Pro ', 'multi-step-checkout-pmpro' ),
			'<strong>' . Multi_Step_Checkout_Pmpro()->plugin_name . ' is inactive </strong>',
			'<a href="' . esc_url( 'https://wordpress.org/plugins/paid-memberships-pro/' ) . '">',
			'</a>',
			self::MINIMUM_PMPRO_VERSION,
			'<a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">',
			'</a>'
		);
	}


	/**
	 * Determines if all the requirements are valid .
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_compatible() {

		return ( self::check_pmpro_version() );
	}

}
