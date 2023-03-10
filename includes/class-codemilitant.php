<?php

use CodeMilitant\CodeMeta\Admin\CM_Admin_Menu;
use CodeMilitant\CodeMeta\Templates\CM_Content_Meta_Tags;

/**
 * CodeMeta setup
 *
 * @package CodeMeta
 */

// defined( 'ABSPATH' ) || exit;

/**
 * Main CodeMeta Class.
 *
 * @class CodeMeta
 */
final class CodeMeta
{

        /**
         * CodeMeta version.
         *
         * @var string
         */
        public $version = '2.2.1';

        /**
         * WP_Query object.
         */
        public $query = null;

        /**
         * The single instance of the class.
         *
         * @var CodeMeta
         */
        protected static $_instance = null;

        /**
         * Content meta tags
         */

        public $contentMetaTags = null;

        /**
         * Main CodeMeta Instance.
         *
         * Ensures only one instance of CodeMeta is loaded
         *
         * @static
         * @see CM()
         * @return CodeMeta - Main instance
         */
        public static function instance()
        {
                if (is_null(self::$_instance)) {
                        self::$_instance = new self();
                }
                return self::$_instance;
        }

        /**
         * CodeMeta Constructor
         */
        public function __construct()
        {
                $this->cm_plugin_load();
        }

        /**
         * Load plugins after all plugins are loaded
         *
         */
        public function cm_plugin_load()
        {
                add_action('init', array($this, 'fire_init'));
        }

        /**
         * Init CodeMeta when WordPress Initialises.
         */
        public function fire_init()
        {
                // echo 'This is the fire_init method.';
                $this->define_constants();
                $this->includes();
        }

        /**
         * Define CM Constants
         */
        private function define_constants()
        {
                $this->define('UPLOADS', wp_upload_dir(null, false));
                $this->define('CM_ABSPATH', dirname(CM_META_FILE) . '/');
                $this->define('CM_PLUGIN_BASENAME', plugin_basename(CM_META_FILE));
                $this->define('CM_VERSION', $this->version);
        }

        /**
         * Define constant if not already set.
         *
         * @param string      $name  Constant name.
         * @param string|bool $value Constant value.
         */
        private function define($name, $value)
        {
                if (!defined($name))
                        define($name, $value);
        }

        /**
         * Include required core files used in admin and on the frontend
         */
        public function includes()
        {

                include_once CM_ABSPATH . 'includes/class-autoloader.php';

                if ($this->is_request('admin')) {
                        new CM_Admin_Menu();
                }

                if ($this->is_request('templates')) {
                        add_filter('wp_head', array($this, 'cm_code_seo_social_meta'), 6);
                }
        }

        public function cm_code_seo_social_meta()
        {
                if ($this->is_request('found')) {
                        $get_content_tags = new CM_Content_Meta_Tags();
                        echo $get_content_tags->cm_get_meta_tag_content();
                }
                unset($get_content_tags);
        }

        /**
         * What are all the post types found in the database?
         * 
         * @return array
         */
        public function cm_get_post_types()
        {
                $args = array(
                        'public'   => true,
                        '_builtin' => false
                );

                $output = 'names'; // 'names' or 'objects' (default: 'names')
                $operator = 'and'; // 'and' or 'or' (default: 'and')

                $post_types = get_post_types($args, $output, $operator);
                $post_types = array_diff($post_types, array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'wp_block'));
                return $post_types;
        }
        /**
         * What type of request is this?
         *
         * @param  string $type admin, ajax, cron, found, templates
         * @return bool
         */
        private function is_request($type)
        {
                $post_types = $this->cm_get_post_types();
                if (!empty($post_types)) {
                        $post_types = array_merge($post_types, array('post', 'page'));
                }
                switch ($type) {
                        case 'admin':
                                return is_admin();
                        case 'ajax':
                                return defined('DOING_AJAX');
                        case 'cron':
                                return defined('DOING_CRON');
                        case 'found':
                                return (!is_404() && is_singular($post_types) || (!is_404() && function_exists('WC') && is_singular('product')));
                        case 'templates':
                                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
                }
        }

        /**
         * Get the plugin url
         *
         * @return string
         */
        public function plugin_url()
        {
                return untrailingslashit(plugins_url('/', CM_META_FILE));
        }

        /**
         * Get the plugin path
         *
         * @return string
         */
        public function plugin_path()
        {
                return untrailingslashit(plugin_dir_path(CM_META_FILE));
        }
}
