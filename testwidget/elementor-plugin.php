<?php 
/*
Plugin Name: Elementor Theshape
Plugin URI: http://themeshape.com/
Author: Themeshape
Author URI: http://themeshape.com/
Version:1.0.0
Text Domain: elementortheshape
Domain Path: /languages/
Description: Any extension developed for Elementor should have an unified and pleasant experience while maintaining WordPress plugin guidelines, coding standards, best practice, and not do anything malicious.plugin guidelines, coding standards, best practice, and not do anything malicious.
*/

use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	die(__("Direct Access Not Allow",'elementortheshape'));
}

final class Elementorelementortheshape {

	const VERSION = "1.0.0";
	const MINIMUM_ELEMENTOR_VERSION = "2.6.8";
	const MINIMUM_PHP_VERSION = "7.0";

	private static $_instance = null;
   
    //instance 
    public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}


	public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }
	public function init() {
        load_plugin_textdomain( 'elementortheshape' );

        // Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
        }
        
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
        }
        
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        
    }

    public function init_widgets(){
        // Include Widget files
        require_once( __DIR__ . '/widgets/shape-widget.php' );
        
        // Register widget
		Plugin::instance()->widgets_manager->register_widget_type( new \Elementoreshapewidget() );
    }
    public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortheshape' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortheshape' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementortheshape' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    
    public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortheshape' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortheshape' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementortheshape' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

    public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementortheshape' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortheshape' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementortheshape' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }
    
	public function includes() {}

}
Elementorelementortheshape::instance();