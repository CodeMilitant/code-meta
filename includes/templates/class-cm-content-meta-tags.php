<?php

namespace CodeMilitant\CodeMeta\Templates;

use CodeMilitant\CodeMeta\CM_Article_Details;
use CodeMilitant\CodeMeta\CM_Media_Details;

defined('ABSPATH') || exit;

class CM_Content_Meta_Tags
{
    use CM_Article_Details;
    use CM_Media_Details;

    public static $metaTags;
    public static $articleDetails;
    public static $mediaDetails;

    public static function cm_get_meta_tag_content($id = null)
    {
        $metaTags = self::cm_get_meta_tags($id);
        return self::generateMetaTags($metaTags);
    }

    public static function cm_get_meta_tags($id)
    {
        $articleDetails = static::cm_get_article_details($id);
        $mediaDetails = static::cm_get_media_details($id);
        $metaTags = array_merge((array) $articleDetails, (array) $mediaDetails);
        return $metaTags;
    }

    public static function generateMetaTags($metaTags)
    {
        $generate = '<!-- CodeMilitant Search Engine Optimization (SEO) AI ' . CM_VERSION . ' https://codemilitant.com/ -->' . PHP_EOL;
        $metaHeadStructure = array('og_description', 'og_keywords');
        foreach ($metaTags as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaHeadStructure, true) && !empty($metaValue)) {
                $generate .= '<meta name="' . str_replace('og_', '', $metaKey) . '" content="' . esc_attr_e($metaValue, 'code-meta') . '" />' . PHP_EOL;
            }
        }
        $metaBodyStructure = array('og_type', 'og_title', 'og_url', 'og_description', 'og_determiner', 'og_product_sku', 'og_product_price', 'og_product_price_currency', 'og_product_availability', 'og_product_color', 'og_product_size', 'og_date_on_sale_from', 'og_date_on_sale_to');
        foreach ($metaTags as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaBodyStructure, true) && !empty($metaValue)) {
                $generate .= '<meta property="' . str_replace('_', ':', $metaKey) . '" content="' . esc_attr_e($metaValue, 'code-meta') . '" />' . PHP_EOL;
            }
        }
        foreach ($metaTags as $metaKey => $metaValue) {
            $metaMediaStructure = array('og_image_url', 'og_image_width', 'og_image_height', 'og_image_alt', 'og_image_caption', 'og_image_copyright', 'og_image_type', 'og_audio_type', 'og_video_type');
            foreach($metaValue as $mk => $mv) {
                if (in_array($mk, $metaMediaStructure, true) && !empty($mv)) {
                    $generate .= '<meta property="' . str_replace('_', ':', $mk) . '" content="' . esc_attr_e($mv, 'code-meta') . '" />' . PHP_EOL;
                }
            }
        }
        return $generate;
    }
}
