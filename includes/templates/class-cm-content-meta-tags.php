<?php

namespace CodeMilitant\CodeMeta\Templates;

use CodeMilitant\CodeMeta\CM_Article_Details;
use CodeMilitant\CodeMeta\CM_Media_Details;
use CodeMilitant\CodeMeta\Admin\CM_Add_Social_Profile_Fields;
use Exception;

defined('ABSPATH') || exit;

class CM_Content_Meta_Tags
{
    use CM_Article_Details;
    use CM_Media_Details;

    public static $articleDetails;
    public static $mediaDetails;

    public static function cm_get_meta_tag_content($id = null)
    {
        $articleDetails = self::get_article_details($id);
        $mediaDetails = self::get_media_details($id);
        $getSocialProfiles = (array) static::cm_get_social_profiles($id);
        $getUserSocialKeys = (array) static::get_social_profile_keys();
        return self::generateMetaTags($articleDetails, $mediaDetails, $getSocialProfiles, $getUserSocialKeys);
    }

    public static function get_article_details($id = null)
    {
        $getArticleDetails = (array) static::cm_get_article_details($id);
        return $getArticleDetails;
    }
    public static function get_media_details($id = null)
    {
        $getMediaDetails = (array) static::cm_get_media_details($id);
        return $getMediaDetails;
    }
    public static function get_author_id($id) {
        $getAuthorId = self::get_article_details($id);
        return $getAuthorId['author_id'];
    }
    public static function get_social_profile_keys()
    {
        $getUserSocialKeys = (array) CM_Add_Social_Profile_Fields::get_social_profile_fields();
        $getUserSocialKeys = array_keys($getUserSocialKeys['social_profiles']['fields']);
        return $getUserSocialKeys;
    }
    public static function cm_get_social_profiles($id)
    {
        $getSocialProfiles = get_user_meta(self::get_author_id($id) , '', false);
        ($getSocialProfiles == false) ? $getSocialProfiles = get_user_meta(get_current_user_id(), '', false) : '';
        if ($getSocialProfiles != false) { // when not logged in, there is no user meta, so the login page will fail to load
            $getSocialProfiles = array_filter(array_map(function ($a) {
                return $a[0];
            }, $getSocialProfiles));
        }
        return $getSocialProfiles;
    }

    private static function cm_meta_error_checking($articleDetails, $mediaDetails, $getSocialProfiles, $getUserSocialKeys) {

        $verify = '';
        
        if (!is_array($articleDetails)) {
            $verify .= '<!-- An error occurred while verifying the articleDetails array -->';
        }
        if (!is_array($mediaDetails) && !empty($mediaDetails)) {
            $verify .= '<!-- An error occurred while verifying the mediaDetails array -->';
        }
        if (!is_array($getSocialProfiles)) {
            $verify .= '<!-- An error occurred while verifying the getSocialProfiles array -->';
        }
        if (!is_array($getUserSocialKeys)) {
            $verify .= '<!-- An error occurred while verifying the getUserSocialKeys array -->';
        }

        if ($verify === '') {
            // all arrays passed the check
            return true;
        } else {
            // at least one array failed the check
            return $verify;
        }
    }

    private static function generateMetaTags($articleDetails, $mediaDetails, $getSocialProfiles, $getUserSocialKeys)
    {

        $verify_meta_data = self::cm_meta_error_checking($articleDetails, $mediaDetails, $getSocialProfiles, $getUserSocialKeys);
        if( $verify_meta_data !== true ) {
            echo '<!-- CodeMilitant Search Engine Optimization (SEO) Social Networks ' . \CodeMeta::CM_VERSION . ' https://codemilitant.com/ -->' . PHP_EOL;
            echo $verify_meta_data . PHP_EOL;
            return;
        }
        $generate = '<!-- CodeMilitant Search Engine Optimization (SEO) Social Networks ' . \CodeMeta::CM_VERSION . ' https://codemilitant.com/ -->' . PHP_EOL;
        $metaHeadStructure = array('og_description', 'og_keywords');
        foreach ($articleDetails as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaHeadStructure, true) && !empty($metaValue)) {
                $generate .= '<meta name="' . str_replace('og_', '', $metaKey) . '" content="' . esc_attr__($metaValue, 'code-meta') . '" />' . PHP_EOL;
            }
        }
        $metaBodyStructure = array_diff(array_keys($articleDetails), $metaHeadStructure);
        foreach ($articleDetails as $metaKey => $metaValue) {
            if (in_array($metaKey, $metaBodyStructure, true) && !empty($metaValue)) {
                if (strpos($metaKey, 'og_') === 0) {
                    $generate .= '<meta property="' . str_replace('_', ':', $metaKey) . '" content="' . esc_attr__($metaValue, 'code-meta') . '" />' . PHP_EOL;
                }
            }
        }
        if( !empty($mediaDetails) && is_array($mediaDetails) ) {
            foreach ($mediaDetails as $metaKey => $metaValue) {
                foreach(array_filter($metaValue, 'strlen') as $mk => $mv) {
                    $generate .= '<meta property="' . str_replace('_', ':', $mk) . '" content="' . esc_attr__($mv, 'code-meta') . '" />' . PHP_EOL;
                }
            }
        }
        foreach ($getSocialProfiles as $metaKey => $metaValue) {
            if (in_array($metaKey, $getUserSocialKeys, false) && !empty($metaValue)) {
                $generate .= '<meta property="' . str_replace('_', ':', $metaKey) . '" content="' . $metaValue . '" />' . PHP_EOL;
            }
        }
        
        return $generate;
    }
}
