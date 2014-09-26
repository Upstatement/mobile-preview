<?php
/*
Plugin Name: Mobile Preview
Plugin URI: http://upstatement.com/mobile-preview
Description: Preview your site in a variety of mobile devices
Author: Jared Novack + Upstatement
Version: 0.0.2
Author URI: http://upstatement.com/
*/

class Upstatement_MobilePreview {

	function __construct() {
		$this->load_dependencies();
		$this->add_toolbar_action();
		$this->detect_viewed_in_iframe();
		add_action( 'wp_footer', array($this, 'inject_html'));
		add_action( 'admin_footer', array($this, 'inject_html'));
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_static' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_static') );
	}

	function load_dependencies() {
		if ( !class_exists( 'Jigsaw' ) ) {
			require_once __DIR__.'/vendor/upstatement/jigsaw/jigsaw.php';
		}
	}

	function add_toolbar_action() {
		Jigsaw::add_admin_bar_item( 'Mobile Preview', '#mobile-preview' );
	}

	function inject_html() {
		$iframe_url = self::get_current_url();
		if (is_admin()) {
			global $post;
			$iframe_url = home_url('/?p='.$post->ID);
		}
		$iframe_url = add_query_arg('admin_bar', 'false', $iframe_url);
		require_once 'mobile-preview-window.twig';
	}

	public static function get_current_url() {
        $pageURL = "http://";
        if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {
            $pageURL = "https://";;
        }
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
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
