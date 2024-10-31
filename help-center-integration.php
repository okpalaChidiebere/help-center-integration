<?php
/**
 * Plugin Name:     Help Center Integration
 * Description:     Add Help Center Integration feature
 * Text Domain:     help-center-integration
 * Version:         1.2.0
 *
 * @package         HelpCenter_Custom_Integration
 */

// require_once __DIR__ . "/vendor/autoload.php";

    
// Check if class name already exists
if ( ! class_exists( 'HelpCenter_Intergrations' ) ) :
    /**
	 * Main class
	 *
	 * @since 1.1.0
	 */
	final class HelpCenter_Intergrations {
        /**
		 * The one and only true HelpCenter_Intergrations instance
		 *
		 * @since 1.1.0
		 * @access private
		 * @var object $instance
		 */
		private static $instance;

		/**
		 * Instantiate the main class
		 *
		 * This function instantiates the class, initialize all functions and return the object.
		 *
		 * @return object The one and only true HelpCenter_Intergrations instance.
		 * @since 1.1.0
		 */
		public static function instance() {
            if ( ! isset( self::$instance ) && ( ! self::$instance instanceof HelpCenter_Intergrations ) ) {
				self::$instance = new HelpCenter_Intergrations();
				self::$instance->setup_constants();
				include_once HELPCENTER_INTEGRATIONS_PLUGIN_PATH . 'src/class-map.php';

                add_action(
					'plugins_loaded',
					function () {
						self::$instance->includes();
					}
				);

				add_action( 'init', array( self::$instance, 'init' ) );
			}

			return self::$instance;
        }

        /**
		 * Function for setting up constants
		 *
		 * This function is used to set up constants used throughout the plugin.
		 *
		 * @since 1.1.0
		 */
		public function setup_constants() {

			// Plugin version.
			if ( ! defined( 'HELPCENTER_INTEGRATIONS_VERSION' ) ) {
				define( 'HELPCENTER_INTEGRATIONS_VERSION', '1.0.0' );
			}

			// Plugin file.
			if ( ! defined( 'HELPCENTER_INTEGRATIONS_FILE' ) ) {
				define( 'HELPCENTER_INTEGRATIONS_FILE', __FILE__ );
			}

			// Plugin folder path.
			if ( ! defined( 'HELPCENTER_INTEGRATIONS_PLUGIN_PATH' ) ) {
				define( 'HELPCENTER_INTEGRATIONS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			}

			// Plugin folder URL.
			if ( ! defined( 'HELPCENTER_INTEGRATIONS_PLUGIN_URL' ) ) {
				define( 'HELPCENTER_INTEGRATIONS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			//Plugin environment
			if ( ! defined( 'VENDASTA_API_ENV' ) ) {
				$environment = getenv("ENVIRONMENT");
				$mEnvironment = $environment == null ? "DEMO" : $environment;
				define( 'VENDASTA_API_ENV', $mEnvironment );
			}

			//Plugin configurations for the vendastapis http request
			if ( ! defined( 'VENDASTA_API_CONFIGS' ) ) {
				$env_params = include_once HELPCENTER_INTEGRATIONS_PLUGIN_PATH . '/src/config.php';
				define( 'VENDASTA_API_CONFIGS', $env_params[VENDASTA_API_ENV] );
			}
		}

        /**
		 * Getting all registered origins, and place the sniffing here
		 */
		public function init() {
			$sources = array(
				\HelpCenter_Intergrations\Source\WP_Foro_Origin::class,
				\HelpCenter_Intergrations\Source\BP_Members_Origin::class,
				\HelpCenter_Intergrations\Source\AVIOG_Videos_Origin::class,
				\HelpCenter_Intergrations\Source\LD_Lesson_Origin::class,
				\HelpCenter_Intergrations\Source\LD_Courses_Origin::class,
				\HelpCenter_Intergrations\Source\BP_Groups_Origin::class,
				\HelpCenter_Intergrations\Source\CL_Podcasts_Origin::class,
			);
			foreach ( $sources as $source ) {
				$class = new $source();
				$class->listen();
			}
		}

        /**
		 * Includes all necessary PHP files
		 *
		 * This function is responsible for including all necessary PHP files.
		 *
		 * @since  1.1.0
		 */
		public function includes() {
			include HELPCENTER_INTEGRATIONS_PLUGIN_PATH . "vendor/autoload.php";
		}
    }
endif; // End if class exists check

function helpcenter_integrations() {
	return HelpCenter_Intergrations::instance();
}

// Run plugin
helpcenter_integrations();