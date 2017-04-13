<?php

global $ae_db_version;
$ae_db_version = '1.0';

function ae_install() {
	global $wpdb;
	global $ae_db_version;

	$table_name = $wpdb->prefix . 'assembly_events';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		event_id int NOT NULL AUTO_INCREMENT,
		date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		event_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		event_title VARCHAR(75) NOT NULL,
		event_location CHAR(75) NOT NULL,
		event_link CHAR(255) NOT NULL,
		PRIMARY KEY  (event_id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'ae_db_version', $ae_db_version );
	$installed_ver = get_option( 'ae_db_version' );

	if ( $installed_ver != $ae_db_version ) {

		$sql = <<<SQL
CREATE TABLE $table_name (
		event_id int NOT NULL AUTO_INCREMENT,
		date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		event_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		event_title VARCHAR(75) NOT NULL,
		event_location CHAR(75),
		event_link CHAR(255),
		PRIMARY KEY  (event_id)
	) $charset_collate;
SQL;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( 'ae_db_version', $ae_db_version );
	}
}

function events_update_db_check() {
	global $ae_db_version;
	if ( get_site_option( 'ae_db_version' ) != $ae_db_version ) {
		ae_install();
	}
}

add_action( 'plugins_loaded', 'events_update_db_check' );