<?php
/*
Plugin Name: Mobile Preview
Plugin URI: http://upstatement.com/mobile-preview
Description: Preview your site in a variety of mobile devices
Author: Jared Novack + Upstatement
Version: 0.0.1
Author URI: http://upstatement.com/
*/

class Upstatement_MobilePreview {

	function __construct() {
		$this->load_dependencies();
		$this->add_toolbar_action();
		if (!is_admin()) {
			$this->detect_viewed_in_iframe();
			$this->inject_html();
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_static' ) );
		}
	}

	function load_dependencies() {
		if ( !class_exists( 'Jigsaw' ) ) {
			require_once __DIR__.'/vendor/upstatement/jigsaw/jigsaw.php';
		}
	}

	function add_toolbar_action() {
		if ( !is_admin() ) {
			Jigsaw::add_admin_bar_item( 'Mobile Preview', '#mobile-preview' );
		}
	}

	function inject_html() {
		add_action('wp_footer', function(){
			require_once 'mobile-preview-window.twig';
		}, 10);
	}

	function enqueue_static() {
		wp_enqueue_style( 'mobile-preview-styles', plugins_url( '/css/screen.css', __FILE__ ) );
		wp_enqueue_script( 'mobile-preview-js', plugins_url('/js/mobile-preview.js', __FILE__), array(), '1.0.0', true );
	}

	function detect_viewed_in_iframe() {
		if (isset($_REQUEST['admin_bar']) && $_REQUEST['admin_bar'] == 'false'){
			add_filter('show_admin_bar', '__return_false');
		}
	}
}

global $upstatement_mobile_preview;
$upstatement_mobile_preview = new Upstatement_MobilePreview();
