<?php

namespace CodeMilitant\CodeMeta;

defined( 'ABSPATH' ) || exit;

class CM_Post_Analysis
{

    public static function cm_get_random_post_id()
    {
        $rand_post_id = get_posts(['fields' => 'ids', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'rand', 'post_type' => ['post', 'page', 'project']]);
        if (function_exists('WC')) {
            $rand_post_id = get_posts(['fields' => 'ids', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'rand', 'post_type' => ['post', 'page', 'project', 'product']]);
        }
        $rand_post_id = $rand_post_id[0];
        return $rand_post_id;
    }
}
