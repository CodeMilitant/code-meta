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
        public $version = '2.2.3';

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
         * What type of request is this?
         *
         * @param  string $type admin, ajax, cron, found, templates
         * @return bool
         */
        private function is_request($type)
        {
                switch ($type) {
                        case 'admin':
                                return is_admin();
                        case 'ajax':
                                return defined('DOING_AJAX');
                        case 'cron':
                                return defined('DOING_CRON');
                        case 'found':
                                return (!is_404() && is_singular());
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
