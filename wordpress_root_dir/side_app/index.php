<?php

define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
define( 'WPINC', 'wp-includes/' );
define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content/' );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'DB_NAME', '...' );
define( 'DB_USER', '...' );
define( 'DB_PASSWORD', '...' );
define( 'DB_HOST', '...' );

function __( $in ) { return $in; }
function wp_load_translations_early() {}
function wp_debug_backtrace_summary() {}
function add_filter() {}
function do_action() {}
function has_filter() {}
function apply_filters( $f, $in ) { return $in; }
function is_multisite() {}

require WP_CONTENT_DIR . '/object-cache.php';
wp_cache_init();

$now = microtime( true );
wp_cache_add( "test", $now );

require_once( ABSPATH . WPINC . '/wp-db.php' );
if ( file_exists( WP_CONTENT_DIR . '/db.php' ) ) {
	require_once( WP_CONTENT_DIR . '/db.php' );
}
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
$wpdb->set_prefix( 'wp_' );


die(
	'<pre>' . nl2br( htmlentities( json_encode(
		array(
			'wpdb'   => $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $wpdb->options WHERE `option_name` = %s LIMIT 1",
					"home"
				)
			),
			'now'    => $now,
			'cached' => wp_cache_get( "test" ),
		),
		JSON_PRETTY_PRINT
	) ) ) . '</pre>'
);
