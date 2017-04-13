<?php

/*
Plugin Name: Assembly Events
Plugin URI:
Description: A simple events list builder.
Version:     1.0.0
Author:      Jaron White
Author URI:
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

//TO DO ::  Update to use AJAX,
//          Validate form input,
//          Add calendar functionality (calendar base code: http://codepen.io/jaronwhite/pen/qbNPQo)

$tz = "America/Denver";
date_default_timezone_set( $tz );
//add page into admin menu
add_action( 'admin_menu', 'assembly_events_admin_actions' );
function assembly_events_admin_actions() {
	add_menu_page( 'assemblyevents', 'Assembly Events', 'manage_options', __FILE__, 'assembly_events_admin', 'dashicons-migrate' );
}

//Create tables
require_once( 'assembly-events-install.php' );
register_activation_hook( __FILE__, 'ae_install' );

//Add scripts and styles to admin
add_action( 'admin_enqueue_scripts', 'assembly_events_admin_enqueue' );
function assembly_events_admin_enqueue( $hook ) {
	if ( 'toplevel_page_rgm_assembly-events/assemblyevents' != $hook ) {
		return;
	}
	wp_register_script( 'assembly-events-admin-js', plugins_url( '/js/assembly-events-admin.js', __FILE__ ), array(), '1.0.0', true );
	wp_enqueue_script( 'assembly-events-admin-js' );
	wp_register_style( 'assembly-events-admin-style', plugins_url( '/css/assembly-events-admin-style.css', __FILE__ ), array(), '1.0.0' );
	wp_enqueue_style( 'assembly-events-admin-style' );
}

//Add scripts and styles doc
add_action( 'wp_enqueue_scripts', 'assembly_events_enqueue' );
function assembly_events_enqueue() {
	wp_register_style( 'assembly-events-style', plugins_url( '/css/assembly-events-style.css', __FILE__ ), array(), '1.0.0' );
	wp_enqueue_style( 'assembly-events-style' );
}

//Shortcode for slider
require_once( 'assembly-events-shortcode.php' );

//Main function for admin
function assembly_events_admin() {
	require_once( 'assembly-events-admin.php' );
}