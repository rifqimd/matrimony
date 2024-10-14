<?php

namespace H5APPlayer\Elementor\Widgets;

final class Register {

	const VERSION = '2.2.7';

	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function register() {

		// if ( is_null( self::$_instance ) ) {
		// 	self::$_instance = new self();
		// }
		// return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		//Register Frontend Script
		add_action( "elementor/frontend/after_register_scripts", [ $this, 'frontend_assets_scripts' ] );

		// Add Plugin actions
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );

		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

	}

	public function init_controls($controls_manager){
		// Register controls
		$controls_manager->register( new \H5APPlayer\Elementor\Controls\SelectFile() );
	}


	/**
	 * Frontend script
	 */
	public function frontend_assets_scripts(){
		// library
		wp_register_script( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR. 'js/player.js' , array('jquery'), H5AP_PRO_VERSION, false );
		wp_register_style( 'bplugins-plyrio', H5AP_PRO_PLUGIN_DIR . 'assets/css/player.min.css', array(), H5AP_PRO_VERSION, 'all' );

		// playlist
		wp_register_script( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR. 'dist/playlist.js' , array('jquery', 'bplugins-plyrio'), time(), true );
		wp_register_style( 'h5ap-playlist', H5AP_PRO_PLUGIN_DIR. 'dist/playlist.css' , array('bplugins-plyrio'), H5AP_PRO_VERSION );
		
		// player
		wp_register_script( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.js' , array('jquery', 'bplugins-plyrio'), time(), true );
		wp_register_style( 'h5ap-player', H5AP_PRO_PLUGIN_DIR. 'dist/player.css' , array('bplugins-plyrio'), H5AP_PRO_VERSION );
		
	}

	public function init_widgets() {
		// Include Widget files
		\Elementor\Plugin::instance()->widgets_manager->register( new Simple() );
	}
}

Register::instance();