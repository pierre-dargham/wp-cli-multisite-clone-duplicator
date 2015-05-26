<?php

/**
 * Site to excude
 */
define( 'MUCD_SITE_DUPLICATION_EXCLUDE', '' );

/**
 * Environment constants
 */
define( 'MUCD_PRIMARY_SITE_ID', 1 );
define( 'MUCD_MAX_NUMBER_OF_SITE', 5000 );


/**
 * Option management for the plugin
 */
if ( ! class_exists( 'MUCD_Option' ) ) {

	class MUCD_Option {


		/**
		 * Get directories to exclude from file copy when duplicated site is primary site
		 * @since 0.2.0
		 * @return  array of string
		 */
		public static function get_primary_dir_exclude() {
			return array(
				'sites',
			);
		}

		/**
		 * Get default options that should be preserved in the new blog.
		 * @since 0.2.0
		 * @return  array of string
		 */
		public static function get_default_saved_option() {
			return array(
				'siteurl' 			=> '',
				'home' 				=> '',
				'upload_path' 		=> '',
				'fileupload_url' 	=> '',
				'upload_url_path' 	=> '',
				'admin_email' 		=> '',
				'blogname' 			=> '',
			);
		}

		/**
		 * Get filtered options that should be preserved in the new blog.
		 * @since 0.2.0
		 * @return  array of string (filtered)
		 */
		public static function get_saved_option() {
			return apply_filters( 'mucd_copy_blog_data_saved_options', MUCD_Option::get_default_saved_option() );
		}

		/**
		 * Get default fields to scan for an update after data copy
		 * @since 0.2.0
		 * @return array '%table_name' => array('%field_name_1','%field_name_2','%field_name_3', ...)
		 */
		public static function get_default_fields_to_update() {
			return array(
				'commentmeta' 			=> array(),
				'comments' 				=> array(),
				'links' 				=> array( 'link_url', 'link_image' ),
				'options' 				=> array( 'option_name', 'option_value' ),
				'postmeta' 				=> array( 'meta_value' ),
				'posts' 				=> array( 'post_content', 'guid' ),
				'terms' 				=> array(),
				'term_relationships'	=> array(),
				'term_taxonomy' 		=> array(),
			);
		}

		/**
		 * Get filtered fields to scan for an update after data copy
		 * @since 0.2.0
		 * @return  array of string (filtered)
		 */
		public static function get_fields_to_update() {
			return apply_filters( 'mucd_default_fields_to_update', MUCD_Option::get_default_fields_to_update() );
		}

		/**
		 * Get default tables to duplicate when duplicated site is primary site
		 * @since 0.2.0
		 * @return  array of string
		 */
		public static function get_default_primary_tables_to_copy() {
			return array(
				'commentmeta',
				'comments',
				'links',
				'options',
				'postmeta',
				'posts',
				'terms',
				'term_relationships',
				'term_taxonomy',
			);
		}

		/**
		 * Get filtered tables to duplicate when duplicated site is primary site
		 * @since 0.2.0
		 * @return  array of string (filtered)
		 */
		public static function get_primary_tables_to_copy() {
			return apply_filters( 'mucd_default_primary_tables_to_copy', MUCD_Option::get_default_primary_tables_to_copy() );
		}

	}
}
