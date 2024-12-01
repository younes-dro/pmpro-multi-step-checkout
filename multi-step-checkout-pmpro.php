<?php
/**
 * @link              https://expresstechsoftwares.com
 * @since             1.0.0
 * @package           Multi_Step_Checkout_Pmpro
 *
 * @wordpress-plugin
 * Plugin Name:       MultiStep Checkout for Paid Memberships Pro
 * Plugin URI:        https://expresstechsoftwares.com
 * Description:       This plugin enhances the checkout experience for Paid Memberships Pro users by converting the checkout process into a multi-step form, allowing for smoother navigation and improved user experience. Additionally, it provides flexibility to add custom fields tailored to specific user requirements during the checkout process.
 * Version:           1.0.0
 * Author:            ExpressTech Softwares Solutions Pvt Ltd
 * Author URI:        https://expresstechsoftwares.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multi-step-checkout-pmpro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'MULTI_STEP_CHECKOUT_PMPRO_VERSION', '1.0.0' );

/**
 * Multi_Step_Checkout_Pmpro
 *
 * The main instance if the plugin
 *
 * @since 1.0.0
 */
class Multi_Step_Checkout_Pmpro {

	/**
	 * The Single instance of the class.
	 *
	 * @var obj Multi_Step_Checkout_Pmpro
	 */
	protected static $instance;

	/**
	 * Plugin Version.
	 *
	 * @var String
	 */
	public $plugin_version;

	/**
	 * Plugin Name
	 *
	 * @var String
	 */
	public $plugin_name;

	/**
	 * Instance of the Multi_Step_Checkout_Pmpro_Dependencies class.
	 *
	 * Verify the requirements.
	 *
	 * @var obj Multi_Step_Checkout_Pmpro_Dependencies object
	 */
	protected static $dependencies;

	/**
	 * @var array the admin notices to add
	 * */
	protected $notices = array();

	/**
	 * Check the dependencies that the plugin needs.
	 *
	 * @param obj dependencies
	 */
	public function __construct( Multi_Step_Checkout_Pmpro_Dependencies $dependencies ) {

		self::$dependencies = $dependencies;
		if ( ! defined( 'MULTI_STEP_CHECKOUT_PMPRO_VERSION' ) ) {
			$this->plugin_version = '1.0.0';
		} else {
			$this->plugin_version = MULTI_STEP_CHECKOUT_PMPRO_VERSION;
		}

		$this->plugin_name = 'multi-step-checkout-pmpro';

		register_activation_hook( __FILE__, array( $this, 'activation_check' ) );

		add_action( 'admin_init', array( $this, 'add_plugin_notices' ) );

		add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

		add_action( 'init', array( $this, 'load_textdomain' ) );

	}

	/**
	 * Gets the main Multi_Step_Checkout_Pmpro instance.
	 *
	 * Ensures only one instance of Multi_Step_Checkout_Pmpro is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @param Obj $dependencies Check the dependencies that the plugin needs
	 *
	 * @return Multi_Step_Checkout_Pmpro instance
	 */
	public static function start( Multi_Step_Checkout_Pmpro_Dependencies $dependencies ) {
		if ( null === self::$instance ) {
			self::$instance = new self( $dependencies );
		}

		return self::$instance;
	}

	/**
	 * Cloning is forbidden due to singleton pattern.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		$cloning_message = sprintf(
			esc_html__( 'You cannot clone instances of %s.', 'multi-step-checkout-pmpro' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, $cloning_message, $this->version );
	}

	/**
	 * Unserializing instances is forbidden due to singleton pattern.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		$unserializing_message = sprintf(
			esc_html__( 'You cannot clone instances of %s.', 'multi-step-checkout-pmpro' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, $unserializing_message, $this->version );
	}

	/**
	 * Checks the pmpro and deactivates plugins as necessary.
	 *
	 * @since 1.0.0
	 */
	public function activation_check() {

		if ( ! self::$dependencies->check_pmpro_version() ) {

			$this->deactivate_plugin();

			// wp_die( $this->plugin_name . esc_html__( ' could not be activated. ', 'multi-step-checkout-pmpro' ) . self::$dependencies->get_pmpro_notice() );

		}

		// Maybe save some options value on activate the add-on
	}


	/**
	 * Deactivate the plugin
	 *
	 * @since 1.0.0
	 */
	protected function deactivate_plugin() {

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	/**
	 * Adds an admin notice to be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug message slug
	 * @param string $class CSS classes
	 * @param string $message notice message
	 */
	public function add_admin_notice( $slug, $class, $message ) {

		$this->notices[ $slug ] = array(
			'class'   => $class,
			'message' => $message,
		);
	}

	/**
	 * Add admin notice.
	 *
	 * @return void
	 */
	public function add_plugin_notices() {

		if ( ! self::$dependencies->check_pmpro_version() ) {

			$this->add_admin_notice( 'update_pmpro', 'error', self::$dependencies->get_pmpro_notice() );
		}

	}

	/**
	 * Displays any admin notices added with \Multi_Step_Checkout_Pmpro::add_admin_notice()
	 *
	 * @since 1.0.0
	 */
	public function admin_notices() {

		foreach ( (array) $this->notices as $notice_key => $notice ) {

			echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
			echo wp_kses(
				$notice['message'],
				array(
					'a'      => array(
						'href' => array(),
					),
					'strong' => array(),
				)
			);
			echo '</p></div>';
		}
	}

	/**
	 * Initializes the plugin.
	 *
	 * @since 1.0.0
	 */
	public function init_plugin() {

		if ( ! self::$dependencies->is_compatible() ) {

			return;

		}
		if ( is_admin() ) {

			new Multi_Step_Checkout_Pmpro_Settings();

		}
		$this->frontend_includes();
	}

	/**
	 * Include frontend template functions and hooks.
	 */
	public function frontend_includes() {

		new Multi_Step_Checkout_Pmpro_Front();
	}

	/** -----------------------------------------------------------------------------------*/
	/** Helper Functions                                                                  */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Get the plgun name.
	 *
	 * @return string
	 */

	public function get_plugin_name() {

		return $this->plugin_name;
	}

	/**
	 * Get the plugin version.
	 *
	 * @return string
	 */
	public function get_plugin_version() {

		return $this->plugin_version;
	}

	/**
	 * Get the plugin url.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function plugin_url() {

		return untrailingslashit( plugins_url( '/', __FILE__ ) );

	}

	/**
	 * Get the plugin path.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function plugin_path() {

		return untrailingslashit( plugin_dir_path( __FILE__ ) );

	}

	/**
	 * Get the plugin base path name.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function plugin_basename() {

		return plugin_basename( __FILE__ );

	}

	/**
	 * Register the built-in autoloader
	 *
	 * @codeCoverageIgnore
	 */
	public static function register_autoloader() {
		spl_autoload_register( array( 'Multi_Step_Checkout_Pmpro', 'autoloader' ) );
	}

	/**
	 * Register autoloader.
	 *
	 * @param string $class_name Class name to load.
	 */
	public static function autoloader( $class_name ) {

		$class = strtolower( str_replace( '_', '-', $class_name ) );
		$file  = plugin_dir_path( __FILE__ ) . '/includes/class-' . $class . '.php';
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}

	/**
	 * Load the plugin text domain.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'multi-step-checkout-pmpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}

/**
 * Returns the main instance of Multi_Step_Checkout_Pmpro.
 */
function Multi_Step_Checkout_Pmpro() {

	Multi_Step_Checkout_Pmpro::register_autoloader();
	return Multi_Step_Checkout_Pmpro::start( new Multi_Step_Checkout_Pmpro_Dependencies() );

}

Multi_Step_Checkout_Pmpro();
