<?php

namespace CodeMilitant\CodeMeta;

// defined( 'ABSPATH' ) || exit;

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
		static::$getMediaDetails = self::cm_media_details(self::$media_details);
		return static::$getMediaDetails;
	}

	private static function get_media_ids($media_details)
	{

		$media_details['post_meta']['_thumbnail_id'] = '';
		$media_ids = array();
		$combined_ids = array();

		// must return an associative array to ensure that empty arrays are parsed without error when combining
		if ((int) $media_details['post_meta']['_thumbnail_id']) {
			$media_ids['featured'][] = (int) $media_details['post_meta']['_thumbnail_id'];
		}
		if ($media_details['post_type'] == 'product') {
			$media_ids['featured'][] = (int) $media_details['image_id'];
			$media_ids['gallery'] = $media_details['gallery_image_ids'];
		}
		// get content media ids regardless of post type
		$media_ids['content'] = self::get_content_ids($media_details);
		if ($media_ids) {
			foreach ($media_ids as $value) {
				foreach ($value as $v) {
					($v > 0) ? $combined_ids[] = $v : '';
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

		if ($media_details['post_type'] == 'product') {
			$post_content_images = trim($media_details['description']);
			$post_content_images .= trim($media_details['short_description']);
		} else {
			$post_content_images = trim($media_details['post_content']);
			$post_content_images .= trim($media_details['post_excerpt']);
		}

		if (!empty($post_content_images)) {
			preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $post_content_images, $img_content) ? $media_content[] = $img_content['src'] : '';
		}

		if (!$media_content || $media_content == null) {
			return (array) (int) get_theme_mod('custom_logo');
		}

		$media_content_ids = array_map(function ($a) {
			$media_full_size = preg_replace('/\-\d{1,5}x\d{1,5}\./', '.', $a);
			return attachment_url_to_postid($media_full_size);
		}, $media_content[0]);
		//must return array to ensure that empty arrays are parsed without error when combining
		return array_unique($media_content_ids);
	}

	private static function cm_media_details($media_details)
	{
		$media_meta = array();

		$media_meta = array_map(function ($a) {
			$media_meta_raw = get_post_meta((int) $a);
			$media_meta['metadata'] = maybe_unserialize($media_meta_raw['_wp_attachment_metadata'][0]);
			$media_meta['og_image_url'] = UPLOADS['baseurl'] . '/' .  $media_meta['metadata']['file'];
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
