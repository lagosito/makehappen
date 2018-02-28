<?php
/**
Plugin Name:    Snax
Plugin URI:     http://www.snax.bringthepixel.com
Description:    Viral Front-End Uploader with Open Lists
Author:         bringthepixel
Version:        1.8
Author URI:     http://www.bringthepixel.com
Text Domain:    snax
Domain Path:    /languages/
Network:		false
License: 		Located in the 'Licensing' folder
License URI: 	Located in the 'Licensing' folder

@package snax
@subpackage Main
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! class_exists( 'Snax' ) ) :

	/**
	 * Main Snax class
	 */
	final class Snax {

		/**
		 * The Snax object instance
		 *
		 * @var Snax
		 */
		private static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Database version
		 *
		 * @var string
		 */
		public $db_version;

		/**
		 * Plugin settings name
		 *
		 * @var string
		 */
		public $option_name;

		/**
		 * Votes table name
		 *
		 * @var string
		 */
		public $votes_table_name;

		/**
		 * Plugin filename
		 *
		 * @var string
		 */
		public $file;

		/**
		 * Plugin basename
		 *
		 * @var string
		 */
		public $basename;

		/**
		 * Plugin dir path
		 *
		 * @var string
		 */
		public $plugin_dir;

		/**
		 * Plugin dir url
		 *
		 * @var string
		 */
		public $plugin_url;

		/**
		 * Plugin assets dir path
		 *
		 * @var string
		 */
		public $assets_dir;

		/**
		 * Plugin assets dir url
		 *
		 * @var string
		 */
		public $assets_url;

		/**
		 * Plugin includes dir path
		 *
		 * @var string
		 */
		public $includes_dir;

		/**
		 * Plugin includes dir url
		 *
		 * @var string
		 */
		public $includes_url;

		/**
		 * Plugin languages dir path
		 *
		 * @var string
		 */
		public $languages_dir;

		/**
		 * Plugin templates dir path
		 *
		 * @var string
		 */
		public $templates_dir;

		/**
		 * Snax Item post type name
		 *
		 * @var string
		 */
		public $item_post_type;

		/**
		 * Translation domain
		 *
		 * @var string
		 */
		public $domain;

		/**
		 * Plugins extensions append to this (BuddyPress, etc...)
		 *
		 * @var stdClass
		 */
		public $plugins;

		/**
		 * Current posts query object
		 *
		 * @var WP_Query
		 */
		public $posts_query;

		/**
		 * Current cards query object
		 *
		 * @var WP_Query
		 */
		public $cards_query;

		/**
		 * Current votes query object
		 *
		 * @var WP_Query
		 */
		public $votes_query;

		/**
		 * Current items query object
		 *
		 * @var WP_Query
		 */
		public $items_query;

		/**
		 * Front-end submission page format
		 *
		 * @var string
		 */
		public $current_format;

		/**
		 * Return the only existing instance of Snax object
		 *
		 * @return Snax
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new Snax();
			}

			return self::$instance;
		}

		/**
		 * Set current format
		 *
		 * @param string $format		Snax format.
		 */
		public function set_current_format( $format ) {
			$this->current_format = $format;
		}

		/**
		 * Return current format
		 *
		 * @return string
		 */
		public function get_current_format() {
			return $this->current_format;
		}

		/**
		 * Snax constructor.
		 */
		private function __construct() {
			$this->setup_globals();
			$this->includes();
			$this->setup_hooks();
		}

		/**
		 * Prevent object cloning
		 */
		private function __clone() {}

		/**
		 * Define plugin vars
		 */
		private function setup_globals() {

			/** Versions ********************************************************* */

			$this->version      = '1.8';
			$this->db_version   = '1.0';

			/** Database ********************************************************* */

			$this->option_name      = 'snax';
			$this->votes_table_name = 'snax_votes';

			/** Paths ************************************************************ */

			// Base.
			$this->file       = __FILE__;
			$this->basename   = apply_filters( 'snax_plugin_basename', plugin_basename( $this->file ) );
			$this->plugin_dir = apply_filters( 'snax_plugin_dir_path', plugin_dir_path( $this->file ) );
			$this->plugin_url = apply_filters( 'snax_plugin_dir_url', plugin_dir_url( $this->file ) );

			// Assets.
			$this->assets_dir = apply_filters( 'snax_assets_dir', trailingslashit( $this->plugin_dir . 'assets' ) );
			$this->assets_url = apply_filters( 'snax_assets_url', trailingslashit( $this->plugin_url . 'assets' ) );

			// Includes.
			$this->includes_dir = apply_filters( 'snax_includes_dir', trailingslashit( $this->plugin_dir . 'includes' ) );
			$this->includes_url = apply_filters( 'snax_includes_url', trailingslashit( $this->plugin_url . 'includes' ) );

			// Languages.
			$this->languages_dir = apply_filters( 'snax_languages_dir', trailingslashit( $this->plugin_dir . 'languages' ) );

			// Templates.
			$this->templates_dir = apply_filters( 'snax_templates_dir', trailingslashit( $this->plugin_dir . 'templates' ) );

			/** Identifiers ****************************************************** */

			// Post types.
			$this->item_post_type = apply_filters( 'snax_item_post_type', 'snax_item' );

			/** Misc ************************************************************* */

			$this->domain   = 'snax';           // Unique identifier for retrieving translated strings.
			$this->plugins  = new stdClass();   // Plugins add data here.
		}

		/**
		 * Include required files
		 */
		private function includes() {

			/** Core ************************************************************* */

			require( $this->includes_dir . 'core/capabilities.php' );
			require( $this->includes_dir . 'core/functions.php' );
			require( $this->includes_dir . 'core/hooks.php' );
			require( $this->includes_dir . 'core/install.php' );
			require( $this->includes_dir . 'core/mirror-functions.php' );
			require( $this->includes_dir . 'core/options.php' );
			require( $this->includes_dir . 'core/template-functions.php' );

			/** Components ******************************************************* */

			// Common.
			require( $this->includes_dir . 'common/ajax.php' );
			require( $this->includes_dir . 'common/functions.php' );
			require( $this->includes_dir . 'common/widgets.php' );
			require( $this->includes_dir . 'common/shortcodes.php' );
			require( $this->includes_dir . 'common/popup.php' );
			require( $this->includes_dir . 'common/login.php' );
			require( $this->includes_dir . 'common/cron.php' );

			// Posts.
			require( $this->includes_dir . 'posts/capabilities.php' );
			require( $this->includes_dir . 'posts/functions.php' );
			require( $this->includes_dir . 'posts/template.php' );

			// Items.
			require( $this->includes_dir . 'items/ajax.php' );
			require( $this->includes_dir . 'items/capabilities.php' );
			require( $this->includes_dir . 'items/functions.php' );
			require( $this->includes_dir . 'items/embeds.php' );
			require( $this->includes_dir . 'items/template.php' );

			// Votes.
			require( $this->includes_dir . 'votes/ajax.php' );
			require( $this->includes_dir . 'votes/capabilities.php' );
			require( $this->includes_dir . 'votes/functions.php' );
			require( $this->includes_dir . 'votes/template.php' );

			// Users.
			require( $this->includes_dir . 'users/functions.php' );
			require( $this->includes_dir . 'users/roles.php' );
			require( $this->includes_dir . 'users/capabilities.php' );

			// Frontend Submission.
			require( $this->includes_dir . 'frontend-submission/ajax.php' );
			require( $this->includes_dir . 'frontend-submission/functions.php' );
			require( $this->includes_dir . 'frontend-submission/demo.php' );
			require( $this->includes_dir . 'frontend-submission/edit.php' );
			require( $this->includes_dir . 'frontend-submission/cards.php' );
			require( $this->includes_dir . 'frontend-submission/formats.php' );
			require( $this->includes_dir . 'frontend-submission/embeds.php' );
			require( $this->includes_dir . 'frontend-submission/template.php' );

			// Quizzes.
			require( $this->includes_dir . 'quizzes/loader.php' );

			// Plugins.
			require( $this->includes_dir . 'plugins/functions.php' );

			/** Admin ************************************************************ */

			if ( is_admin() ) {
				require( $this->includes_dir . 'admin/admin.php' );
			}
		}

		/**
		 * Setup the default actions and filters
		 */
		public function setup_hooks() {

			/** Standard plugin hooks ************************** */

			register_activation_hook( $this->basename, array( $this, 'activate' ) );
			register_deactivation_hook( $this->basename, array( $this, 'deactivate' ) );
			register_uninstall_hook( $this->basename, array( 'Snax', 'uninstall' ) );

			/** Init ******************************************* */

			add_action( 'init', array( $this, 'register_post_type' ) );
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

			/** Assets ***************************************** */

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Register dependend post types
		 */
		public function register_post_type() {
			$args = array(
				'labels' => array(
					'name'                  => _x( 'Snax Items', 'post type general name', 'snax' ),
					'singular_name'         => _x( 'Snax Item', 'post type singular name', 'snax' ),
					'menu_name'             => _x( 'Snax Items', 'admin menu', 'snax' ),
					'name_admin_bar'        => _x( 'Snax Item', 'add new on admin bar', 'snax' ),
					'add_new'               => _x( 'New Item', 'snax item', 'snax' ),
					'add_new_item'          => __( 'Add New Item', 'snax' ),
					'new_item'              => __( 'New Item', 'snax' ),
					'edit_item'             => __( 'Edit Item', 'snax' ),
					'view_item'             => __( 'View Item', 'snax' ),
					'all_items'             => __( 'All Items', 'snax' ),
					'search_items'          => __( 'Search Items', 'snax' ),
					'parent_item_colon'     => __( 'Parent Items:', 'snax' ),
					'not_found'             => __( 'No items found.', 'snax' ),
					'not_found_in_trash'    => __( 'No items found in Trash.', 'snax' ),
				),
				'public'                    => true,
				// Below values are inherited from the 'public' if not set.
				// ------.
				'exclude_from_search'       => false,        // for readers
				'publicly_queryable'        => true,        // for readers
				'show_in_nav_menus'         => false,       // for authors
				'show_ui'                   => true,        // for authors
				// ------.
				/**
				'capability_type'           => 'snax_item',
				'capabilities'               => array(
					// These capabilites can be assigned to roles.
					'publish_posts'         => 'snax_publish_items',        // This allows a user to publish an item.
					'edit_posts'            => 'snax_edit_items',           // Allows editing of the user’s own items but does not grant publishing permission.
					'edit_others_posts'     => 'snax_edit_others_items',    // Allows the user to edit everyone else’s items but not publish.
					'delete_posts'          => 'snax_delete_items',         // Grants the ability to delete items written by that user but not others’ items.
					'delete_others_posts'   => 'snax_delete_others_items',  // Capability to edit items written by other users.
					'read_private_posts'    => 'snax_read_private_items',   // Allows users to read private items.

					// Meta capabilities. Do not assign them to any role.
					'edit_post'             => 'snax_edit_item',            // Meta capability assigned by WordPress. Do not give to any role.
					'delete_post'           => 'snax_delete_item',          // Meta capability assigned by WordPress. Do not give to any role.
					'read_post'             => 'snax_read_item',            // Meta capability assigned by WordPress. Do not give to any role.
				),
				*/
				'supports'                  => array(
					'title',
					'editor',
					'author',
					'thumbnail',
					'comments',
				),
				'rewrite'                   => array(
					'slug'					=> snax_get_item_slug(),
				),
			);

			register_post_type( 'snax_item', apply_filters( 'snax_item_post_type_args', $args ) );

			// Add post formats support to 'snax_item' post_type.
			add_post_type_support( 'snax_item', 'post-formats' );
		}

		/**
		 * Load plugin translations.
		 */
		public function load_textdomain() {
			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );
			$mofile = sprintf( '%1$s-%2$s.mo', $this->domain, $locale );

			// Setup paths to current locale file.
			$mofile_local  = $this->languages_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/snax/' . $mofile;

			// Look in global /wp-content/languages/snax folder.
			load_textdomain( $this->domain, $mofile_global );

			// Look in local /wp-content/plugins/snax/languages/ folder.
			load_textdomain( $this->domain, $mofile_local );

			// Look in global /wp-content/languages/plugins/.
			load_plugin_textdomain( $this->domain );
		}

		/**
		 * Load CSS.
		 */
		public function enqueue_styles() {

			/** Core (loaded all across the site) ************************** */

			// Popup.
			wp_enqueue_style( 'jquery-magnific-popup', $this->assets_url . 'js/jquery.magnific-popup/magnific-popup.css' );

			// Front.
			wp_enqueue_style( 'snax', $this->assets_url . 'css/snax.css', array(), $this->version );
			wp_style_add_data( 'snax', 'rtl', 'replace' );

			if ( snax_is_frontend_submission_page() ) {
				wp_enqueue_style( 'jquery-tag-it', $this->assets_url . 'js/jquery.tagit/css/jquery.tagit.css', array(), '2.0' );
				wp_enqueue_style( 'jquery-tag-it-theme', $this->assets_url . 'js/jquery.tagit/css/tagit.ui-zendesk.css', array(), '2.0' );

				// Froala editor (Simple).
				wp_enqueue_style( 'snax-froala-editor', 		$this->assets_url . 'js/froala/css/froala_editor.min.css', array(), '2.3.4' );
				wp_enqueue_style( 'snax-froala-style',			$this->assets_url . 'js/froala/css/froala_style.min.css', array(), '2.3.4' );
				wp_enqueue_style( 'snax-froala-quick-insert',	$this->assets_url . 'js/froala/css/plugins/quick_insert.min.css', array(), '2.3.4' );
				wp_enqueue_style( 'snax-froala-char-counter',	$this->assets_url . 'js/froala/css/plugins/char_counter.min.css', array(), '2.3.4' );
				wp_enqueue_style( 'snax-froala-line-breaker',	$this->assets_url . 'js/froala/css/plugins/line_breaker.min.css', array(), '2.3.4' );

				if ( snax_is_format_submission_page( 'text' ) ) {
					// Froala editor (Rich).
					wp_enqueue_style( 'snax-froala-draggable',		$this->assets_url . 'js/froala/css/plugins/draggable.min.css', array(), '2.3.4' );
					wp_enqueue_style( 'snax-froala-image',			$this->assets_url . 'js/froala/css/plugins/image.min.css', array(), '2.3.4' );
					wp_enqueue_style( 'snax-froala-image-manager',	$this->assets_url . 'js/froala/css/plugins/image_manager.min.css', array(), '2.3.4' );
					wp_enqueue_style( 'snax-froala-video',			$this->assets_url . 'js/froala/css/plugins/video.min.css', array(), '2.3.4' );
				}

				// Froala requires FontAwesome.
				wp_enqueue_style( 'font-awesome', $this->assets_url . 'font-awesome/css/font-awesome.min.css' );
			}

			// Enqueue icon font used in social login buttons.
			if ( snax_can_use_plugin( 'wordpress-social-login/wp-social-login.php' ) ) {
				// We don't need to prefix it, because it's not plugin specific.
				wp_enqueue_style( 'font-awesome', $this->assets_url . 'font-awesome/css/font-awesome.min.css' );
			}
		}

		/**
		 * Load javascripts.
		 */
		public function enqueue_scripts() {
			$developer_mode = defined( 'SNAX_DEVELOPER_MODE' ) ? constant( 'SNAX_DEVELOPER_MODE' ) : false;

			/** Core ************************************** */

			// Popup.
			wp_enqueue_script( 'jquery-magnific-popup', $this->assets_url . 'js/jquery.magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

			// Convert dates into timestamps.
			wp_enqueue_script( 'jquery-timeago', $this->assets_url . 'js/jquery.timeago/jquery.timeago.js', array( 'jquery' ), '1.5.2', true );
			$this->localize_timeago_script();

			$is_list_open_for_contribution  = snax_is_format( 'list' ) && is_single();
			$is_frontend_submission_page    = snax_is_frontend_submission_page();

			$is_snax_page = $is_list_open_for_contribution || $is_frontend_submission_page;

			$deps = array( 'jquery' );

			if ( $is_snax_page ) {
				wp_enqueue_script( 'plupload-handlers' );
				wp_enqueue_script( 'utils' );

				$deps[] = 'plupload-handlers';
				$deps[] = 'utils';
			}

			// Front needs to loaded on all pages (voting, login popup).
			wp_enqueue_script( 'snax-front', $this->assets_url . 'js/front.js', $deps, $this->version, true );

			// Front config.
			$front_config = array(
				'ajax_url'          => admin_url( 'admin-ajax.php' ),
				'autosave_interval' => (int) constant( 'AUTOSAVE_INTERVAL' ),
			);

			if ( current_user_can( 'administrator' ) || apply_filters( 'snax_debug_mode', false ) ) {
				$front_config['debug_mode'] = true;
			}

			wp_localize_script( 'snax-front', 'snax_front_config', wp_json_encode( $front_config ) );

			/** List ************************************** */

			if ( $is_list_open_for_contribution ) {
				wp_enqueue_script( 'snax-add-to-list', $this->assets_url . 'js/add-to-list.js', array( 'snax-front' ), $this->version, true );
			}

			/** Submit form ****************************** */
			if ( $is_frontend_submission_page ) {
				// Enqueue input::placeholder polyfill for IE9.
				wp_enqueue_script( 'jquery-placeholders', $this->assets_url . 'js/jquery.placeholder/placeholders.jquery.min.js', array( 'jquery' ), '4.0.1', true );

				// Tag editing UI snippet.
				wp_enqueue_script( 'jquery-tag-it', $this->assets_url . 'js/jquery.tagit/js/tag-it.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-autocomplete' ), '2.0', true );

				wp_enqueue_script( 'snax-fabric', $this->assets_url . 'js/fabric/fabric.min.js', array(), '1.6.4', true );

				wp_enqueue_script( 'snax-front-submission', 		$this->assets_url . 'js/front-submission.js', array( 'snax-front' ), $this->version, true );

				$front_submission_config = array(
					'tags_limit' 		=> snax_get_tags_limit(),
					'tags' 				=> snax_get_tags_array( apply_filters( 'snax_tags_autoloaded_limit', 100 ) ),
					'tags_force_ajax'	=> apply_filters( 'snax_tags_force_ajax', false ),
					'items_limit' 		=> snax_get_new_post_items_limit(),
					'assets_url' 		=> snax_get_assets_url(),
				);

				$froala_suffix = $developer_mode ? '' : '.min';

				// Froala editor (Simple).
				wp_enqueue_script( 'snax-froala-editor',		$this->assets_url . 'js/froala/js/froala_editor' . $froala_suffix . '.js', array( 'jquery' ), '2.3.4', true );
				$froala_editor_language = $this->load_froala_editor_translation();
				wp_enqueue_script( 'snax-froala-link',	 		$this->assets_url . 'js/froala/js/plugins/link' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
				wp_enqueue_script( 'snax-froala-lists', 		$this->assets_url . 'js/froala/js/plugins/lists' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
				wp_enqueue_script( 'snax-froala-quick-insert', 	$this->assets_url . 'js/froala/js/plugins/quick_insert' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
				wp_enqueue_script( 'snax-froala-char-counter', 	$this->assets_url . 'js/froala/js/plugins/char_counter' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
				wp_enqueue_script( 'snax-froala-line-breaker', 	$this->assets_url . 'js/froala/js/plugins/line_breaker' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );

				if ( snax_is_format_submission_page( 'text' ) ) {
					// Froala editor (Rich).
					wp_enqueue_script( 'snax-froala-draggable',		$this->assets_url . 'js/froala/js/plugins/draggable' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
					wp_enqueue_script( 'snax-froala-image',	 		$this->assets_url . 'js/froala/js/plugins/image' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
					wp_enqueue_script( 'snax-froala-image-manager',	$this->assets_url . 'js/froala/js/plugins/image_manager' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
					wp_enqueue_script( 'snax-froala-custom-video',	$this->assets_url . 'js/froala-custom/js/plugins/video' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
					wp_enqueue_script( 'snax-froala-p-format', 		$this->assets_url . 'js/froala/js/plugins/paragraph_format' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );
					wp_enqueue_script( 'snax-froala-quote', 		$this->assets_url . 'js/froala/js/plugins/quote' . $froala_suffix . '.js', array( 'snax-froala-editor' ), '2.3.4', true );

					// Text format.
					wp_enqueue_script( 'snax-front-submission-text',	$this->assets_url . 'js/front-submission-text.js', array( 'snax-front-submission', 'snax-froala-editor' ), $this->version, true );
				}

				$front_submission_config['froala'] = array(
					'language'				=> $froala_editor_language,
					'async_upload_url'		=> admin_url( 'async-upload.php' ),
					'image_max_size' 		=> snax_get_max_upload_size(),
					'image_allowed_types'	=> snax_get_image_allowed_types(),
				);

				// i18n.
				$front_submission_config['i18n'] = array(
					'are_you_sure'          => __( 'Are you sure?', 'snax' ),
					'meme_top_text'         => __( 'Top text...', 'snax' ),
					'meme_bottom_text'      => __( 'Bottom text...', 'snax' ),
					'multi_drop_forbidden'  => __( 'You can drop only one file here.', 'snax' ),
					'upload_failed'  		=> __( 'Upload failed. Check if the file is a valid image.', 'snax' ),
				);

				wp_localize_script( 'snax-front-submission', 'snax_front_submission_config', wp_json_encode( $front_submission_config ) );
			}
		}

		/**
		 * Load Froala translation if exists
		 *
		 * @return mixed		Loaded language or null if not exits.
		 */
		public function load_froala_editor_translation() {
			$locale       = strtolower( get_locale() );
			$locale_parts = explode( '_', $locale );

			// Check by full locale code (eg. pt_br).
			$language_id  = $locale;

			// If translation for that code doesn't exist, try to use only lang code (eg. pt).
			if ( ! file_exists( $this->assets_dir . 'js/froala/js/languages/' . $language_id . '.js' ) ) {
				$language_id = $locale_parts[0];
			}

			if ( ! file_exists( $this->assets_dir . 'js/froala/js/languages/' . $language_id . '.js' ) ) {
				return null;
			}

			// Use this filter in case you need to map resolved language id to some other locale.
			$language_id = apply_filters( 'snax_froala_editor_language_id', $language_id );

			wp_add_inline_script( 'snax-froala-editor', 'var _$ = $; $ = jQuery; // Now $ points to jQuery. Fix for Froala language loading bug.' );
			wp_enqueue_script( 'snax-froala-editor-' . $language_id, $this->assets_url . 'js/froala/js/languages/' . $language_id . '.js', array( 'snax-froala-editor' ), null, true );
			wp_add_inline_script( 'snax-froala-editor-' . $language_id, '$ = _$; // Restore original $.' );

			return $language_id;
		}

		/**
		 * Run during plugin activation
		 *
		 * @param bool $network_wide Whether or not it's a network wide activation.
		 */
		public function activate( $network_wide ) {
			if ( $network_wide ) {
				$sites = get_sites();

				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					do_action( 'snax_activation' );

					restore_current_blog();
				}
			} else {
				do_action( 'snax_activation' );
			}
		}

		/**
		 * Run during plugin deactivation
		 */
		public function deactivate() {
			do_action( 'snax_deactivation' );
		}

		/**
		 * Run during plugin uninstallation
		 */
		public static function uninstall() {
			do_action( 'snax_uninstall' );
		}

		/**
		 * Load translation for the timeago script
		 */
		protected function localize_timeago_script() {
			$locale       = get_locale();
			$locale_parts = explode( '_', $locale );
			$lang_code    = $locale_parts[0];

			$exceptions_map = array(
				'pt_BR' => 'pt-br',
				'zh_CN' => 'zh-CN',
				'zh_TW' => 'zh-TW',
			);

			$script_i10n_ext = $lang_code;

			if ( isset( $exceptions_map[ $locale ] ) ) {
				$script_i10n_ext = $exceptions_map[ $locale ];
			}

			// Check if translation file exists in "locales" dir.
			if ( ! file_exists( $this->assets_dir . 'js/jquery.timeago/locales/jquery.timeago.' . $script_i10n_ext . '.js' ) ) {
				return;
			}

			wp_enqueue_script( 'jquery-timeago-' . $script_i10n_ext, $this->assets_url . 'js/jquery.timeago/locales/jquery.timeago.' . $script_i10n_ext . '.js', array( 'jquery-timeago' ), null, true );
		}
	}

	/**
	 * The main function responsible for returning the Snax instance.
	 *
	 * @return Snax
	 */
	function snax() {
		return Snax::get_instance();
	}

	snax();

endif;
