<?php

/*
** Plugin Name: dotstudioPRO React API Routes
** Version: 1.08
** Author: dotstudioPRO
** Author URI: http://dotstudiopro.com
*/

if (!defined('ABSPATH'))
    die();

// Plugin Update Checker
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'http://updates.wordpress.dotstudiopro.com/wp-update-server/?action=get_metadata&slug=dspdev-react-api-routes',
	__FILE__,
	'dspdev-react-api-routes'
);

// Plugin functions outside of routing
require_once("functions.php");

// The various filters we use on call returns
require_once("filters.php");

// Include the 1st version of the API
require_once("v1/functions-v1.php");
require_once("v1/schema-v1.php");
require_once("v1/routes-v1.php");

// load css into the website's front-end
function dspapi_api_routes_enqueue_style() {
    wp_enqueue_style( 'dspapi-api-routes-style', plugins_url( 'styles/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'dspapi_api_routes_enqueue_style' );

if(!function_exists('swagger_rest_api_init')){

	/*** SWAGGER DOCS FOR WP: https://github.com/starfishmod/WPAPI-SwaggerGenerator ***/

	function swagger_rest_api_init() {

		if ( class_exists( 'WP_REST_Controller' )
			&& ! class_exists( 'WP_REST_Swagger_Controller' ) ) {
			require_once dirname( __FILE__ ) . '/lib/class-wp-rest-swagger-controller.php';
		}

		$swagger_controller = new WP_REST_Swagger_Controller();
		$swagger_controller->register_routes();

	}

	add_action( 'rest_api_init', 'swagger_rest_api_init', 10 );
}

/** Add Menu Entry **/
function dspdev_react_api_routes_menu() {

	add_menu_page( 'React API Options', 'React API Options', 'manage_options', 'dspdev-react-api-routes', 'dspdev_react_api_routes_menu_page', plugins_url( 'react-logo.png', __FILE__ ) );

}

add_action( 'admin_menu', 'dspdev_react_api_routes_menu' );

// Set up the page for the plugin, pulling the content based on various $_GET global variable contents
function dspdev_react_api_routes_menu_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	echo "<div class='wrap'>";


	include("templates/menu.tpl.php");


	echo "</div>";

}
/** End Menu Entry **/

function dspdev_save_react_api_routes_options(){
	if(!empty($_POST['dspdev-save-react-api-routes-options'])){
		update_option('dspapi-api-key', $_POST['dspapi-api-key']);
		update_option('dspapi-api-namespace', $_POST['dspapi-api-namespace']);
		update_option('dspapi_transient_cache_timeout', $_POST['dspapi_transient_cache_timeout']);
	}

}

add_action("init", "dspdev_save_react_api_routes_options");

function dspdev_react_icon_styles(){
	?>
	<style type="text/css">.toplevel_page_dspdev-react-api-routes > .wp-menu-image.dashicons-before > img{padding: 6px 0px 0px 0px!important;}</style>
	<?php
}
add_action('admin_head', 'dspdev_react_icon_styles', 99);