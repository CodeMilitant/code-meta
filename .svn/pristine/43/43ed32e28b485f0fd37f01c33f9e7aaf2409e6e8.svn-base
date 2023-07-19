<?php

namespace CodeMilitant\CodeMeta;

defined('ABSPATH') || exit;

use Exception;

trait CM_Meta_Base
{
    public static $metaBase = array();
    public static $metaPost = array();

    public static function getMetaBase($id = null)
    {
        self::$metaPost = get_post($id, ARRAY_A, 'display');
        ($id == '' || $id == null) ? $id = (int) self::$metaPost['ID'] : $id = (int) $id;

        static::$metaBase = self::$metaPost;
        static::$metaBase['post_meta'] = array_map(function ($a) {
            return $a[0];
        }, get_post_meta($id));
        // If the post type is a WooCommerce product, get the product data and merge it with the post data
        if (function_exists('WC') && self::$metaPost == 'product') {
            static::$metaBase = (array) get_product($id, '')->get_data();
            static::$metaBase['currency'] = get_option('woocommerce_currency');
            static::$metaBase = array_map(function ($a) {
                if (is_array($a)) {
                    foreach ($a as $key => $value) {
                        $b = (array) $value;
                        $a[$key] = array_shift($b);
                    }
                }
                (is_object($a)) ? $a = '' : '';
                return $a;
            }, static::$metaBase);
            static::$metaBase = array_merge(static::$metaBase, self::$metaPost);
        }
        if (!is_wp_error(static::$metaBase) && !empty(static::$metaBase)) {
            return static::$metaBase;
        } else {
            throw new Exception('Error fetching meta data for post ID ' . $id);
        }
    }
}
