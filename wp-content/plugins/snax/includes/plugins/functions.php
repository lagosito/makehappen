<?php
/**
 * Snax 3rd party plugins integration
 *
 * @package snax
 * @subpackage Plugins
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( snax_can_use_plugin( 'wordpress-social-login/wp-social-login.php' ) ) {
	require_once( 'wordpress-social-login.php' );
}

if ( snax_can_use_plugin( 'buddypress/bp-loader.php' ) ) {
	require_once( 'buddypress/loader.php' );
}

if ( snax_can_use_plugin( 'quick-adsense-reloaded/quick-adsense-reloaded.php' ) ) {
	require_once( 'quick-adsense-reloaded.php' );
}

if ( snax_can_use_plugin( 'sitepress-multilingual-cms/sitepress.php' ) ) {
	require_once( 'wpml.php' );
}

if ( snax_can_use_plugin( 'fb-instant-articles/facebook-instant-articles.php' ) ) {
	require_once( 'facebook-instant-articles.php' );
}

if ( snax_can_use_plugin( 'woocommerce/woocommerce.php' ) ) {
	require_once( 'woocommerce.php' );
}

if ( snax_can_use_plugin( 'media-ace/media-ace.php' ) ) {
	require_once( 'media-ace.php' );
}
