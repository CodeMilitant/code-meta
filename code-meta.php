<?php

defined('ABSPATH') || exit;

/**
 * Plugin Name:     Code Meta
 * Plugin URI:      https://codemilitant.com/wordpress/code-meta-wordpress-plugin/
 * Description:     Code Meta tag generator will create the vital Opengraph meta tags required by search engines for proper SEO indexing of your website.
 * Author:          CodeMilitant
 * Author URI:      https://codemilitant.com
 * Text Domain:     code-meta
 * Domain Path:     /languages
 * Version:         2.6.5
 *
 * @package         Code_Meta
 */

if (!defined('CM_META_FILE')) {
    define('CM_META_FILE', __FILE__);
}

// Include the main CodeMilitant class
if (!class_exists('CodeMeta')) {
    include_once dirname(CM_META_FILE) . '/includes/class-codemilitant.php';
}

/**
 * Checks if a class with name "CodeMeta" already exists, and deactivates the plugin if found.
 */
function cm_activate_codemeta()
{
    // Check if there's a naming collision
    if (class_exists('CodeMeta')) {
        deactivate_plugins(plugin_basename(__FILE__), 'cm_deactivate_codemeta');
        add_action('admin_notices', 'show_collision_error');
    }

    // Add plugin activation option
    add_option('Activated_Plugin', 'code-meta');
}

// Display collision error message
function show_collision_error()
{
?>
    <div class="error notice">
        <p><?php _e('Another plugin with the class "CodeMeta" exists, please resolve the naming collision and activate the plugin again.', 'code-meta'); ?></p>
    </div>
    <?php
}

// Register activation hook and verify user permissions
add_action('admin_notices', 'check_user_role');
register_activation_hook(__FILE__, 'cm_activate_codemeta');

// Define check user role function
function check_user_role()
{
    if (!current_user_can('manage_options')) {
    ?>
        <div class="notice notice-error">
            <p><?php _e('You do not have sufficient permissions to access this page.', 'code-meta'); ?></p>
        </div>
<?php
    }
}

// Define deactivation hook function
function cm_deactivate_codemeta()
{
    if (is_admin() && get_option('Activated_Plugin') == 'code-meta') {
        delete_option('Activated_Plugin');
    }
}

/**
 * Returns the main instance of CM to prevent the need to use globals
 *
 * @return CodeMeta
 */
function CM() // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
{
    return CodeMeta::get_instance();
}
CM();