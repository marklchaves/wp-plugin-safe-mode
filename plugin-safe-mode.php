<?php
/**
 * Plugin Name: Plugin Safe Mode++
 * Plugin URI: http://core.trac.wordpress.org/ticket/25137
 * Description: Enables safe mode by preventing plugins from loading if
 * WP_DISABLE_PLUGINS is defined true and ?safe_mode=true appended to url
 * Author: caught my eye dev <mark@caughtmyeye.cc>
 * Version: 1.0
 * Author URI: https://www.caughtmyeye.dev/about/
 */
 
/**
 * TO DO: First iteraion. Plenty of room for refactoring.
 */

if ( defined( 'WP_DISABLE_PLUGINS' ) && WP_DISABLE_PLUGINS && isset( $_GET['safe_mode'] ) ) {

	// Blindly deactivate all plugins for the post or page.
	//add_filter( 'option_active_plugins', '__return_empty_array' );

	// Deactivate all plugins except for 1 or 2 passed in as args.
	add_filter( 'option_active_plugins', function( $plugins ){

		// Master list of what plugins we can keep. Add your keepers
		// here.
		$plugin_list = array();
		$plugin_list['block-visibility'] = 'block-visibility/block-visibility.php';
		$plugin_list['code-snippets'] = 'code-snippets/code-snippets.php';
		$plugin_list['content-control'] = 'content-control/content-control.php';
		$plugin_list['insert-headers-and-footers'] = 'insert-headers-and-footers/ihaf.php';
		$plugin_list['popup-maker'] = 'popup-maker/popup-maker.php';
		$plugin_list['query-monitor'] = 'query-monitor/query-monitor.php';
		$plugin_list['user-menus'] = 'user-menus/user-menus.php';

		// Option to deactivate this 1 plugin.
		$np = '';
		$z ='';
		if ( isset( $_GET['np'] ) ) {
			$np = $plugin_list[sanitize_text_field( $_GET['np'] )];
			$z = array_search( $np, $plugins );
			unset( $plugins[$z] );
			return $plugins;
		}

		// The first optional plugin to keep.
		$p1 = '';
		$j = '';
		if ( isset( $_GET['p1'] ) ) {
			$p1 = $plugin_list[sanitize_text_field( $_GET['p1'] )];
			$j = array_search( $p1, $plugins );
		}

		// The second optional plugin to keep.
		$p2 = '';
		$k ='';
		if ( isset( $_GET['p2'] ) ) {
			$p2 = $plugin_list[sanitize_text_field( $_GET['p2'] ) ];
			$k = array_search( $p2, $plugins );
		}

		// If no args were passed in, deactivate all plugins.
		if ( ( $j == '' ) && ( $k == '' ) ) return array();

		// Else find out which plugins to keep active.
		foreach ($plugins as $key => $value) {
			// Deactivate all plugins except for what's passed in.
			if ( ( ( $j !== '' ) && ( $value ==  $plugins[$j] ) ) ||
			     ( ( $k !== '' ) && ( $value ==  $plugins[$k] ) ) ) {  
				continue; // Skip the ones we want to keep.
			}
			unset( $plugins[$key] ); // If we get here, deactivate this plugin.
		}

		return $plugins;
	
	} );
}