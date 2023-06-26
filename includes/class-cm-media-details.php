<?php

namespace CodeMilitant\CodeMeta;

defined('ABSPATH') || exit;

trait CM_Media_Details
{
	use CM_Meta_Base;
	use CM_Article_Details;
	use CM_Mime_Type;

	public static $media_details = array();
	public static $getMediaMeta = array();
	public static $getMediaDetails = array();

	public static function cm_get_media_details($id)
	{

		self::$media_details = static::getMetaBase($id);
		static::$getMediaDetails = self::$media_details ? self::cm_media_details(self::$media_details) : null;
		return static::$getMediaDetails;
	}

	private static function get_media_ids($media_details)
	{

		$media_ids = array();
		$combined_ids = array();

		// must return an associative array to ensure that empty arrays are parsed without error when combining
		if (isset($media_details['post_meta']['_thumbnail_id'])) {
			$media_ids['featured'][] = (int) $media_details['post_meta']['_thumbnail_id'];
		}

		if (!empty($media_details['post_meta']['_product_image_gallery'])) {
			$media_ids['gallery'] = array_map('intval', explode(',', $media_details['post_meta']['_product_image_gallery']));
		}

		// get content media ids regardless of post type
		$media_ids['content'] = self::get_content_ids($media_details);

		if (!empty($media_ids)) {
			foreach ($media_ids as $value) {
				foreach ($value as $v) {
					$combined_ids[] = $v;
				}
			}
		}

		//must return an array to ensure that empty arrays are parsed without error when combining
		return array_unique($combined_ids);
	}

	private static function get_content_ids($media_details)
	{

		$post_content_images = '';
		$media_content = array();
		$media_content_ids = array();

		$post_content_images = trim($media_details['post_content']);
		$post_content_images .= trim($media_details['post_excerpt']);

		if (!empty($post_content_images)) {
			preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $post_content_images, $img_content) ? $media_content[] = $img_content['src'] : '';
		}

		if (empty($media_content)) {
			return (array) (int) get_theme_mod('custom_logo');
		}

		if (!empty($media_content)) {
			array_map(function ($a) use (&$media_content_ids) {
				$media_full_size = preg_replace('/\-\d{1,5}x\d{1,5}\./', '.', $a);
				attachment_url_to_postid($media_full_size) !== 0 ? $media_content_ids[] = attachment_url_to_postid($media_full_size) : '';
			}, $media_content[0]);
		}

		//must return array to ensure that empty arrays are parsed without error when combining
		return array_unique($media_content_ids);
	}

	private static function cm_media_details($media_details)
	{
		
		//must return an associative array to ensure all images are listed in meta tags
		$media_meta = array();

		// if media ids are empty, return empty array
		if( self::get_media_ids($media_details)[0] === 0 ) {
			return $media_meta;
		}

		$media_meta = array_map(function ($a) use (&$media_meta) {

			$media_meta_raw = get_post_meta($a);
			if( !empty($media_meta_raw['_wp_attachment_metadata']) ) {
				$media_meta['metadata'] = unserialize($media_meta_raw['_wp_attachment_metadata'][0]);
			}
			$media_meta['og_image_url'] = wp_upload_dir()['baseurl'] . '/' .  $media_meta['metadata']['file'];
			$media_meta['mime_type'] = self::getFilename($media_meta['metadata']['file']);
			$media_meta['og_type'] = preg_replace('/(image|audio|video|application|text).{1,60}/i', "og_$1_", $media_meta['mime_type']);
			$media_meta[$media_meta['og_type'] . 'width'] = $media_meta['metadata']['width'];
			$media_meta[$media_meta['og_type'] . 'height'] = $media_meta['metadata']['height'];
			if (!empty($media_meta_raw['_wp_attachment_image_alt'])) {
				$media_meta_raw['_wp_attachment_image_alt'][0] ? $media_meta[$media_meta['og_type'] . 'alt'] = $media_meta_raw['_wp_attachment_image_alt'][0] : '';
			}
			$media_meta['exif'] = $media_meta['metadata']['image_meta'];
			$media_meta[$media_meta['og_type'] . 'caption'] = $media_meta['exif']['caption'];
			$media_meta[$media_meta['og_type'] . 'copyright'] = $media_meta['exif']['copyright'];
			$media_meta[$media_meta['og_type'] . 'type'] = $media_meta['mime_type'];
			unset($media_meta_raw, $media_meta['metadata'], $media_meta['exif'], $media_meta['mime_type'], $media_meta['og_type']);
			return $media_meta;
		}, self::get_media_ids($media_details));

		return $media_meta;
	}
}
