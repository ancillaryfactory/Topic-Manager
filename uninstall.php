<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} 


global $wbdb, $user_level;
$table_name = $wpdb->prefix . "topic_manager";

	// Drop MySQL Tables
	$SQL = "DROP TABLE " . $table_name;
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());
