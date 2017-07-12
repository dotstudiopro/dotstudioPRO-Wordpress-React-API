<?php

/*
** Plugin Name: API Routes
** Version: 1.00
** Author: dotstudioPRO
** Author URI: http://dotstudiopro.com
*/

if (!defined('ABSPATH'))
    die();

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

/*** SWAGGER DOCS FOR WP: https://github.com/starfishmod/WPAPI-SwaggerGenerator ***/

function swagger_rest_api_init() {

	if ( class_exists( 'WP_REST_Controller' )
		&& ! class_exists( 'WP_REST_Swagger_Controller' ) ) {
		require_once dirname( __FILE__ ) . '/lib/class-wp-rest-swagger-controller.php';
	}

	$swagger_controller = new WP_REST_Swagger_Controller();
	$swagger_controller->register_routes();

}

add_action( 'rest_api_init', 'swagger_rest_api_init', 11 );

function dspapi_namespace(){
	die("YUP!");
}

function dspapi_namespace_settings(){
	register_setting('general', 'dspapi_namespace', 'esc_attr');
	add_settings_field( "dspapi_namespace", "DSP API Namespace", 'dspapi_namespace', "general", "dspapi_setting-blah", array('label_for' => 'dspapi_setting-id') );
}

add_action( 'admin_init', 'dspapi_namespace_settings', 11 );