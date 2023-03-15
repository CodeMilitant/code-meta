<?php

namespace CodeMilitant\CodeMeta\Admin;

// defined('ABSPATH') || exit;

use CodeMilitant\CodeMeta\CM_Post_Analysis;
use CodeMilitant\CodeMeta\Templates\CM_Content_Meta_Tags;

class CM_Admin_Menu
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'cm_codemeta_admin_menu'));
        add_action('admin_menu', array($this, 'cm_codeseo_admin_submenu'));
        add_action('admin_enqueue_scripts', array($this, 'cm_admin_menu_styles'));
    }

    public function cm_codemeta_admin_menu()
    {
        add_menu_page(
            'Code Meta',
            'Code Meta',
            'edit_posts',
            'code-meta',
            array($this, 'code_meta_menu_content'),
            'dashicons-admin-site',
            21
        );
    }

    public function cm_codeseo_admin_submenu()
    {
        add_submenu_page(
            'code-meta',
            'Code Meta Upgrade',
            'Upgrade',
            'edit_posts',
            'code-meta-upgrade',
            array($this, 'code_seo_submenu_upgrade'),
            21
        );
    }

    public static $sample_code = '';

    public function code_meta_menu_content()
    {
        echo '<table id="codemilitant-congratulations">
            <thead>
            <tr>
            <th scope="row">Congratulations!</th>
            <th scope="row">Sample Meta Tags</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td class="code-meta-congratulations">
            <div>
            <p>You have installed the foundation for the most effective AI for SEO.</p>
            <p>The column on the right is showing random meta tags that have been generated from your posts, pages, projects or products.</p>
            <p>This plugin is the free foundation to a highly intelligent SEO algorithm for automatically populating categories and keyword phrases (tags) to all of your post content.</p>
            <p>Upgrading for just $3 dollars (USD) per month to connect your social networks will produce even better search engine results and is vital for more website clicks.</p>
            <p>With over 30 social networks to choose from, the search engines and your social networks will love your website!</p>
            <p>Click the <a href="/wp-admin/admin.php?page=code-meta-upgrade">Upgrade</a> menu to learn more about the importance of connecting your social networks and generating proper keyword phrases.</p>
            </div>
            </td>
            <td class="code-meta-tags">
            <p style="text-align:center;width:80%;">These are the sample meta tags this plugin installed from a random blog post, page, project or product on your website.</p>
            <table id="codemilitant-sample-meta">
            <thead></thead>
            <tbody>';
            if (is_admin() && !is_404()) {
                echo str_replace(array('&lt;', '&gt;'), array('<tr><td class="code-meta-color">&lt;', '&gt;</td></tr>'), htmlspecialchars(CM_Content_Meta_Tags::cm_get_meta_tag_content(CM_Post_Analysis::cm_get_random_post_id())));
            }
            echo '</tbody></table></td></tr></tbody></table>';
    }
    public function code_seo_submenu_upgrade() {
        echo '<table id="codemilitant-upgrades">
            <thead>
            <tr>
            <th scope="row" class="code-meta-social-profiles">Upgrade to CodeSEO Social Profiles</th>
            <th scope="row" class="code-seo-ai">Upgrade to CodeSEO AI</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td class="code-seo-ai-content">
            <div>
            <p>Connecting your social networks will produce even better search engine results and is vital for more website clicks.</p>
            <p>With over 30 social networks to connect, the search engines, and your social networks will love your website!</p>
            <p>Click the button below to upgrade this free plugin to connect your social networks for just $3 dollars (USD) per month.</p>
            </div>
            <div class="code-seo-ai-button">
            <a target="_blank" href="https://codemilitant.com/downloads/code-seo-social-network-add-on/" class="button button-primary">CodeSEO Social Profiles $3/month</a>
            </div>
            </td>
            <td class="code-seo-ai-content">
            <div>
            <p>The most advanced SEO algorithm plugin for generating impactful categories and keyword phrases (tags) from your WordPress content.</p>
            <p>By automatically creating the categories and keywords your site needs for top search results,
            <p>CodeSEO AI uses the power of complex algorithms for optimal key phrases based on your post/product content.</p>
            <p>Just write your page, post or product content and let our algorithm\'s do the rest.</p>
            <p>Truly set it and forget it.</p>
            <p>Click the button below to get the full CodeMilitant CodeSEO AI suite (including social profiles) for just $9 dollars (USD) per month for every 300 post/products.</p>
            <p>CodeMilitant CodeSEO AI enables large scale operations for the most powerful SEO results your company has ever seen. Here\'s how it works:</p>
            <ul>
            <li>Search Engine Optimization (SEO) for unlimited blog posts, products or projects.</li>
            <li>Sliding scale costs that ensure you know your total monthly costs.</li>
            <li>When maintaining an active subscription, the CodeSEO AI will continually check for new content and optimize for automated peace of mind.</li>
            </ul>

            <p>Let\'s go over each of these points:</p>
            <ol>
            <li>Most websites contain less than 300 pages, posts, projects or products, and will never need to pay more than just $9 dollars per month.</li>
            <li>For every website exceeding 300 combined pages, posts, projects or products, a sliding scale charge of $9.00 per 300 post types will be assessed. The sliding scale cost is based on the total number of pages, posts, projects or products that are being optimized. For every post type over the incremental 300 elements, there is an additional $9 monthly subscription fee assessed. For example, up to 300 post types, you pay $9 per month, post number 301 adds an additional $9 per month for a total of $18 dollars (USD) per month. The next increment incurs an additional $9 dollars at post number 601, and so on, and so on.</li>
            <li>There\'s no limit to the number of pages, posts, projects or products that can be optimized. The CodeSEO AI will continue to optimize your content until all content has been parsed. It will continue to optimize the content even if posts are updated or added. Because internet content is constantly evolving, your website must be updated in perpetuity, or get left behind. The CodeSEO AI will continue to optimize your content in perpetuity, so you can focus on your business.</li>
            </ol>
            <p>CodeSEO AI is a cloud based service that will optimize your content from our servers so the AI doesn\'t exhaust your CPU and memory resources.</p>
            <p>We don\'t store your data, we just analyze it remotely, encrypt the categories and keywords, then return the results back to your WordPress database.</p>
            <p>We currently offer these services for the English language only, however, we are developing these services for all languages.</p>
            </div>
            <div class="code-seo-ai-button">
            <a target="_blank" href="https://codemilitant.com/downloads/code-seo-ai-keyword-meta-tag-generator/" class="button button-primary">Full CodeSEO AI $9/300/month</a>
            </div>
            </td>
            </tr>
            </tbody>
            </table>';
    }
    public function cm_admin_menu_styles()
    {
        wp_enqueue_style('cm-codemeta-styles', CM()->plugin_url() . '/assets/cm_codemeta_admin.css', array(), CM()->version, 'all');
    }
}