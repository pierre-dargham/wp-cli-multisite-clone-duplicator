<?php

if ( ! class_exists( 'MUCD_Functions' ) ) {

	class MUCD_Functions {

		/**
		 * Check if a path is valid MS-windows path
		 * @since 0.2.0
		 * @param  string $path the path
		 * @return boolean true | false
		 */
		public static function valid_windows_dir_path( $path ) {
			if ( 1 == strpos( $path, ':' ) && preg_match( '/[a-zA-Z]/', $path[0] ) ) { // check if it's something like C:\
				$tmp = substr( $path, 2 );
				$bool = preg_match( '/^[^*?"<>|:]*$/', $tmp );
				return ( $bool == 1 ); // so that it will return only true and false
			}
			return false;
		}

		/**
		 * Check if a path is valid UNIX path
		 * @since 0.2.0
		 * @param  string $path the path
		 * @return boolean true | false
		 */
		public static function valid_unix_dir_path( $path ) {
			$reg = '/^(\/([a-z0-9+\$_-])+)*\/?$/';
			$bool = preg_match( $reg, $path );
			return ($bool == 1);
		}

		/**
		 * Check if a path is valid MS-windows or UNIX path
		 * @since 0.2.0
		 * @param  string $path the path
		 * @return boolean true | false
		 */
		public static function valid_path( $path ) {
			return ( MUCD_Functions::valid_unix_dir_path( $path ) || MUCD_Functions::valid_windows_dir_path( $path ) );
		}

		/**
		 * Removes completely a blog from the network
		 * @since 0.2.0
		 * @param  int $blog_id the blog id
		 */
		public static function remove_blog( $blog_id ) {
			switch_to_blog( $blog_id );
			$wp_upload_info = wp_upload_dir();
			$dir = str_replace( ' ', '\\ ', trailingslashit( $wp_upload_info['basedir'] ) );
			restore_current_blog();

			wpmu_delete_blog( $blog_id, true );

			// wpmu_delete_blog leaves an empty site upload directory, that we want to remove :
			MUCD_Files::rrmdir( $dir );
		}

		/**
		 * Check if site is duplicable
		 * @since 0.2.0
		 * @param  int $blog_id the blog id
		 * @return boolean true | false
		 */
		public static function is_duplicable( $blog_id ) {
			if ( 'all' == get_site_option( 'mucd_duplicables', 'all', 'selected' ) ) {
				return true;
			}

			if ( 'yes' == get_blog_option( $blog_id, 'mucd_duplicable' , 'no' ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Get all duplicable sites
		 * @since 0.2.0
		 * @return array of blog data
		 */
		public static function get_site_list() {
			$site_list = array();

			$network_blogs = wp_get_sites( apply_filters( 'mucd_get_site_list_args', array( 'limit' => MUCD_MAX_NUMBER_OF_SITE ) ) );
			foreach ( $network_blogs as $blog ) {
				if ( MUCD_Functions::is_duplicable( $blog['blog_id'] ) && MUCD_SITE_DUPLICATION_EXCLUDE != $blog['blog_id'] ) {
					$site_list[] = $blog;
				}
			}

			return $site_list;
		}

		/**
		 * Check if a value is in an array for a specific key
		 * @since 0.2.0
		 * @param  mixte $value the value
		 * @param  array $array the array
		 * @param  string $key  the key
		 * @return boolean true | false
		 */
		public static function value_in_array( $value, $array, $key ) {
			foreach ( $array as $row ) {
				if ( isset ( $row[ $key ] ) && $value == $row[ $key ] ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Get upload directory of the entire network
		 * @since 0.2.0
		 * @return string path of the upload directory
		 */
		public static function get_primary_upload_dir() {
			$current_blog = get_current_blog_id();
			switch_to_blog( MUCD_PRIMARY_SITE_ID );
			$wp_upload_info = wp_upload_dir();
			switch_to_blog( $current_blog );

			return $wp_upload_info['basedir'];
		}

		/**
		 * Check if site exists
		 * @since 1.3.0
		 * @param  int $blog_id the blog id
		 * @return boolean true | false
		 */
		public static function site_exists( $blog_id ) {
			return ( get_blog_details( $blog_id ) !== false );
		}

		/**
		 * Set locale to en_US
		 * @since 1.3.1
		 */
		public static function set_locale_to_en_us() {

			// Bugfix Pierre Dargham : relocating this declaration outside of the call to add_filter
			// PHP < 5.3 does not accept anonymous functions
			function mucd_locale_en_us( $locale ) { return 'en_US'; }

			add_filter( 'locale', 'mucd_locale_en_us' );
		}

		/**
		 * Get network data for a given id.
		 *
		 * @author wp-cli
		 * @see https://github.com/wp-cli/wp-cli/blob/master/php/commands/site.php
		 *
		 * @param int     $network_id
		 * @return bool|array False if no network found with given id, array otherwise
		 */
		public static function get_network( $network_id ) {
			global $wpdb;

			// Load network data
			$networks = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->site WHERE id = %d", $network_id ) );

			if ( ! empty( $networks ) ) {
				// Only care about domain and path which are set here
				return $networks[0];
			}

			return false;
		}

	}
}