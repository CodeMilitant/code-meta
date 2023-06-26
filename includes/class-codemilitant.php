<?php

use CodeMilitant\CodeMeta\Admin\CM_Admin_Menu;
use CodeMilitant\CodeMeta\Admin\CM_Add_Social_Profile_Fields;
use CodeMilitant\CodeMeta\Templates\CM_Content_Meta_Tags;

/**
 * CodeMeta setup
 *
 * @package CodeMeta
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main CodeMeta Class.
 *
 * @class CodeMeta
 */
final class CodeMeta
{

        const CM_ABSPATH = __DIR__ . '/';
        const CM_PLUGIN_BASENAME = '/code-meta/code-meta.php';
        const CM_VERSION = '2.6.5';

        /**
         * The single instance of the class.
         *
         * @var CodeMeta
         */
        private static $_instance = null;

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
        public static function get_instance()
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
                $this->define_constants();
                $this->cm_includes();
        }

        /**
         * Define CM Constants
         */
        public function define_constants()
        {
                $this->cm_define('CM_ABSPATH', self::CM_ABSPATH);
                $this->cm_define('CM_PLUGIN_BASENAME', self::CM_PLUGIN_BASENAME);
                $this->cm_define('CM_VERSION', self::CM_VERSION);
        }

        /**
         * Define constant if not already set.
         *
         * @param string      $name  Constant name.
         * @param string|bool $value Constant value.
         */
        public function cm_define($name, $value)
        {
                if (!defined($name))
                        define($name, $value);
        }

        /**
         * Include required core files used in admin and on the frontend
         */
        public function cm_includes()
        {

                include_once self::CM_ABSPATH . 'class-autoloader.php';
                add_action('plugins_loaded', 'cm_codemeta_load_textdomain');

                if ($this->is_request('admin')) {
                        new CM_Admin_Menu();
                        new CM_Add_Social_Profile_Fields();
                }

                if ($this->is_request('templates')) {
                        add_filter('wp_head', array($this, 'cm_code_meta'), 6);
                }
        }

        public function cm_code_meta()
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

        function cm_codemeta_load_textdomain() {
                // The path to the 'languages' directory inside your plugin's folder
                $lang_dir = $this->plugin_path() . '/languages';
                
                // Load the text domain
                load_plugin_textdomain('code-meta', false, $lang_dir);
        }
        
}