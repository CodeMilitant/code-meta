<?php

namespace CodeMilitant\CodeMeta\Templates;

use CodeMilitant\CodeMeta\CM_Article_Details;
use CodeMilitant\CodeMeta\CM_Media_Details;

defined('ABSPATH') || exit;

class CM_Content_Meta_Tags
{
    use CM_Article_Details;
    use CM_Media_Details;

    public static $articleDetails;
    public static $mediaDetails;

    public static function cm_get_meta_tag_content($id = null)
    {
        $articleDetails = (array) static::cm_get_article_details($id);
        $mediaDetails = (array) static::cm_get_media_details($id);
        return self::generateMetaTags($articleDetails, $mediaDetails);
    }
    private static function generateMetaTags($articleDetails, $mediaDetails)
    {
        $generate = '<!-- CodeMilitant Search Engine Optimization (SEO) AI ' . CM_VERSION . ' https://codemilitant.com/ -->' . PHP_EOL;
        $metaHeadStructure = array('og_description', 'og_keywords');
        foreach ($articleDetails as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaHeadStructure, true) && !empty($metaValue)) {
                $generate .= sprintf('<meta name="%s" content="%s" />', esc_attr(__(str_replace('og_', '', $metaKey)), 'code-meta'), esc_attr(__($metaValue, 'code-meta'))) . PHP_EOL;
            }
        }
        $metaBodyStructure = array_diff(array_keys($articleDetails), $metaHeadStructure);
        foreach ($articleDetails as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaBodyStructure, true) && !empty($metaValue)) {
                if (strpos($metaKey, 'og_') === 0) {
                    $generate .= sprintf('<meta property="%s" content="%s" />', esc_attr(__(str_replace('_', ':', $metaKey)), 'code-meta'), esc_attr(__($metaValue, 'code-meta'))) . PHP_EOL;
                }
            }
        }
        foreach ($mediaDetails as $metaKey => $metaValue) {
            foreach(array_filter($metaValue, 'strlen') as $mk => $mv) {
                $generate .= sprintf('<meta property="%s" content="%s" />', esc_attr(__(str_replace('_', ':', $mk)), 'code-meta'), esc_attr(__($mv, 'code-meta'))) . PHP_EOL;
            }
        }
        return $generate;
    }
}
