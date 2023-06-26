<?php

namespace CodeMilitant\CodeMeta\Admin;

/**
 * Add social network profile fields to user profile page
 */

defined ( 'ABSPATH' ) || exit;

/**
 * CM_Add_Social_Profile_Fields Class
 */

class CM_Add_Social_Profile_Fields
{

    public function __construct()
    {
        add_action('show_user_profile', array(__CLASS__, 'add_social_profile_fields'));
        add_action('edit_user_profile', array(__CLASS__, 'add_social_profile_fields'));

        add_action('personal_options_update', array(__CLASS__, 'save_social_profile_fields'));
        add_action('edit_user_profile_update', array(__CLASS__, 'save_social_profile_fields'));
    }

    /**
     * Get social profile fields for the edit user pages.
     *
     * @return array Fields to display which are filtered through codemilitant_social_profile_fields before being returned
     */
    public static function get_social_profile_fields()
    {
        $show_social_fields = apply_filters(
            'codemilitant_social_profile_fields',
            array(
                'social_profiles'  => array(
                    'title'  => __('Social Network Usernames', 'code-meta'),
                    'fields' => array(
                        'twitter_username' => array(
                            'label'       => __('Twitter Username', 'code-meta'),
                            'description' => 'Enter your Twitter username with the @ symbol.',
                            'placeholder' => '@username',
                            'class'       => 'code-meta-twitter-username',
                        ),
                        'twitter_url' => array(
                            'label'       => __('Twitter URL', 'code-meta'),
                            'description' => 'Enter your Twitter profile URL.',
                            'placeholder' => 'https://twitter.com/username',
                            'class'       => 'code-meta-twitter-url',
                        ),
                        'twitter_card' => array(
                            'label'       => __('Twitter Card', 'code-meta'),
                            'description' => 'Enter preferred Twitter card (summary, summary_large_image), default is "summary_large_image".',
                            'default'     => 'summary_large_image',
                            'class'       => 'code-meta-twitter-card',
                        ),
                        'facebook_username'  => array(
                            'label'       => __('Facebook Username', 'code-meta'),
                            'description' => 'Enter your Facebook username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-facebook-username',
                        ),
                        'facebook_url'  => array(
                            'label'       => __('Facebook URL', 'code-meta'),
                            'description' => 'Enter your Facebook URL.',
                            'placeholder' => 'https://www.facebook.com/username',
                            'class'       => 'code-meta-facebook-url',
                        ),
                        'linkedin_username'      => array(
                            'label'       => __('LinkedIn Username', 'code-meta'),
                            'description' => 'Enter your LinkedIn username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-linkedin-username',
                        ),
                        'linkedin_url'      => array(
                            'label'       => __('LinkedIn URL', 'code-meta'),
                            'description' => 'Enter your LinkedIn URL.',
                            'placeholder' => 'https://www.linkedin.com/in/username',
                            'class'       => 'code-meta-linkedin-url',
                        ),
                        'bitchute_username'      => array(
                            'label'       => __('BitChute Username', 'code-meta'),
                            'description' => 'Enter BitChute username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-bitchute-username',
                        ),
                        'bitchute_url'      => array(
                            'label'       => __('BitChute URL', 'code-meta'),
                            'description' => 'Enter BitChute URL.',
                            'placeholder' => 'https://www.bitchute.com/channel/username',
                            'class'       => 'code-meta-bitchute-url',
                        ),
                        'brighteon_username'      => array(
                            'label'       => __('Brighteon Username', 'code-meta'),
                            'description' => 'Enter your Brighteon username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-brighteon-username',
                        ),
                        'brighteon_url'      => array(
                            'label'       => __('Brighteon URL', 'code-meta'),
                            'description' => 'Enter your Brighteon URL.',
                            'placeholder' => 'https://www.brighteon.com/channels/username',
                            'class'       => 'code-meta-brighteon-url',
                        ),
                        'dailymotion_username'      => array(
                            'label'       => __('Dailymotion Username', 'code-meta'),
                            'description' => 'Enter your LinkedIn username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-dailymotion-username',
                        ),
                        'dailymotion_url'      => array(
                            'label'       => __('Dailymotion URL', 'code-meta'),
                            'description' => 'Enter your Dailymotion URL.',
                            'placeholder' => 'https://www.dailymotion.com/username',
                            'class'       => 'code-meta-dailymotion-url',
                        ),
                        'discord_username'      => array(
                            'label'       => __('Discord Username', 'code-meta'),
                            'description' => 'Enter your LinkedIn username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-discord-username',
                        ),
                        'discord_url'      => array(
                            'label'       => __('Discord URL', 'code-meta'),
                            'description' => 'Enter your Discord URL.',
                            'placeholder' => 'https://discord.gg/username',
                            'class'       => 'code-meta-discord-url',
                        ),
                        'freespace_username'      => array(
                            'label'       => __('Freespace Social Username', 'code-meta'),
                            'description' => 'Enter your Freespace Social username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-freespace-username',
                        ),
                        'freespace_url'      => array(
                            'label'       => __('Freespace Social URL', 'code-meta'),
                            'description' => 'Enter your Freespace Social URL.',
                            'placeholder' => 'https://freespace.social/username',
                            'class'       => 'code-meta-freespace-url',
                        ),
                        'gab_username'      => array(
                            'label'       => __('Gab Username', 'code-meta'),
                            'description' => 'Enter your Gab username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-gab-username',
                        ),
                        'gab_url'      => array(
                            'label'       => __('Gab URL', 'code-meta'),
                            'description' => 'Enter your Gab URL.',
                            'placeholder' => 'https://gab.com/username',
                            'class'       => 'code-meta-gab-url',
                        ),
                        'gettr_username'      => array(
                            'label'       => __('Gettr Username', 'code-meta'),
                            'description' => 'Enter your Gettr username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-gettr-username',
                        ),
                        'gettr_url'      => array(
                            'label'       => __('Gettr URL', 'code-meta'),
                            'description' => 'Enter your Gettr URL.',
                            'placeholder' => 'https://gettr.com/user/username',
                            'class'       => 'code-meta-gettr-url',
                        ),
                        'goodreads_username'      => array(
                            'label'       => __('Goodreads Username', 'code-meta'),
                            'description' => 'Enter your Goodreads username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-goodreads-username',
                        ),
                        'goodreads_url'      => array(
                            'label'       => __('Goodreads URL', 'code-meta'),
                            'description' => 'Enter your Goodreads URL.',
                            'placeholder' => 'https://www.goodreads.com/username',
                            'class'       => 'code-meta-goodreads-url',
                        ),
                        'instagram_username'      => array(
                            'label'       => __('Instagram Username', 'code-meta'),
                            'description' => 'Enter your Instagram username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-instagram-username',
                        ),
                        'instagram_url'      => array(
                            'label'       => __('Instagram URL', 'code-meta'),
                            'description' => 'Enter your Instagram URL.',
                            'placeholder' => 'https://www.instagram.com/username',
                            'class'       => 'code-meta-instagram-url',
                        ),
                        'lbry_username'      => array(
                            'label'       => __('LBRY Username', 'code-meta'),
                            'description' => 'Enter your LBRY username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-lbry-username',
                        ),
                        'lbry_url'      => array(
                            'label'       => __('LBRY URL', 'code-meta'),
                            'description' => 'Enter your LBRY URL.',
                            'placeholder' => 'https://lbry.tv/@username',
                            'class'       => 'code-meta-lbry-url',
                        ),
                        'medium_username'      => array(
                            'label'       => __('Medium Username', 'code-meta'),
                            'description' => 'Enter your Medium username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-medium-username',
                        ),
                        'medium_url'      => array(
                            'label'       => __('Medium URL', 'code-meta'),
                            'description' => 'Enter your Medium URL.',
                            'placeholder' => 'https://medium.com/@username',
                            'class'       => 'code-meta-medium-url',
                        ),
                        'minds_username'      => array(
                            'label'       => __('Minds Username', 'code-meta'),
                            'description' => 'Enter your Minds username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-minds-username',
                        ),
                        'minds_url'      => array(
                            'label'       => __('Minds URL', 'code-meta'),
                            'description' => 'Enter your Minds URL.',
                            'placeholder' => 'https://www.minds.com/username',
                            'class'       => 'code-meta-minds-url',
                        ),
                        'mixer_username'      => array(
                            'label'       => __('Mixer Username', 'code-meta'),
                            'description' => 'Enter your Mixer app username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-mixer-username',
                        ),
                        'mixer_url'      => array(
                            'label'       => __('Mixer URL', 'code-meta'),
                            'description' => 'Enter your Mixer URL.',
                            'placeholder' => 'https://mixer.com/username',
                            'class'       => 'code-meta-mixer-url',
                        ),
                        'parler_username'      => array(
                            'label'       => __('Parler Username', 'code-meta'),
                            'description' => 'Enter your Parler username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-parler-username',
                        ),
                        'parler_url'      => array(
                            'label'       => __('Parler URL', 'code-meta'),
                            'description' => 'Enter your Parler URL.',
                            'placeholder' => 'https://parler.com/profile/username',
                            'class'       => 'code-meta-parler-url',
                        ),
                        'pinterest_username'      => array(
                            'label'       => __('Pinterest Username', 'code-meta'),
                            'description' => 'Enter your Pinterest username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-pinterest-username',
                        ),
                        'pinterest_url'      => array(
                            'label'       => __('Pinterest URL', 'code-meta'),
                            'description' => 'Enter your Pinterest URL.',
                            'placeholder' => 'https://www.pinterest.com/username',
                            'class'       => 'code-meta-pinterest-url',
                        ),
                        'pin_confirm'      => array(
                            'label'       => __('Pinterest Confirmation Number', 'code-meta'),
                            'description' => 'Enter your Pinterest confirmation number.',
                            'placeholder' => 'Pinterest Confirmation Number',
                            'class'       => 'code-meta-pin-number-username',
                        ),
                        'quora_username'      => array(
                            'label'       => __('Quora Username', 'code-meta'),
                            'description' => 'Enter your Quora username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-quora-username',
                        ),
                        'quora_url'      => array(
                            'label'       => __('Quora URL', 'code-meta'),
                            'description' => 'Enter your Quora URL.',
                            'placeholder' => 'https://www.quora.com/profile/username',
                            'class'       => 'code-meta-quora-url',
                        ),
                        'reddit_username'      => array(
                            'label'       => __('Reddit Username', 'code-meta'),
                            'description' => 'Enter your Reddit username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-reddit-username',
                        ),
                        'reddit_url'      => array(
                            'label'       => __('Reddit URL', 'code-meta'),
                            'description' => 'Enter your Reddit URL.',
                            'placeholder' => 'https://www.reddit.com/user/username',
                            'class'       => 'code-meta-reddit-url',
                        ),
                        'rumble_username'      => array(
                            'label'       => __('Rumble Username', 'code-meta'),
                            'description' => 'Enter your Rumble username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-rumble-username',
                        ),
                        'rumble_url'      => array(
                            'label'       => __('Rumble URL', 'code-meta'),
                            'description' => 'Enter your Rumble URL.',
                            'placeholder' => 'https://rumble.com/username',
                            'class'       => 'code-meta-rumble-url',
                        ),
                        'snapchat_username'      => array(
                            'label'       => __('Snapchat Username', 'code-meta'),
                            'description' => 'Enter your Snapchat username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-snapchat-username',
                        ),
                        'snapchat_url'      => array(
                            'label'       => __('Snapchat URL', 'code-meta'),
                            'description' => 'Enter your Snapchat URL.',
                            'placeholder' => 'https://www.snapchat.com/add/username',
                            'class'       => 'code-meta-snapchat-url',
                        ),
                        'telegram_username'      => array(
                            'label'       => __('Telegram Username', 'code-meta'),
                            'description' => 'Enter your Telegram username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-telegram-username',
                        ),
                        'telegram_url'      => array(
                            'label'       => __('Telegram URL', 'code-meta'),
                            'description' => 'Enter your Telegram URL.',
                            'placeholder' => 'https://t.me/username',
                            'class'       => 'code-meta-telegram-url',
                        ),
                        'tiktok_username'      => array(
                            'label'       => __('TikTok Username', 'code-meta'),
                            'description' => 'Enter your TikTok username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-tiktok-username',
                        ),
                        'tiktok_name'      => array(
                            'label'       => __('TikTok Display Name', 'code-meta'),
                            'description' => 'Enter your TikTok display name.',
                            'placeholder' => 'TikTok Display Name',
                            'class'       => 'code-meta-tiktok-display-name',
                        ),
                        'tiktok_url'      => array(
                            'label'       => __('TikTok URL', 'code-meta'),
                            'description' => 'Enter your TikTok URL.',
                            'placeholder' => 'TikTok URL',
                            'class'       => 'code-meta-tiktok-url',
                        ),
                        'truth_social_username'      => array(
                            'label'       => __('Truth Social Username', 'code-meta'),
                            'description' => 'Enter your Truth Social username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-truth-social-username',
                        ),
                        'truth_social_url'      => array(
                            'label'       => __('Truth Social URL', 'code-meta'),
                            'description' => 'Enter your Truth Social URL.',
                            'placeholder' => 'https://truthsocial.com/user/username',
                            'class'       => 'code-meta-truth-social-url',
                        ),
                        'tumblr_username'      => array(
                            'label'       => __('Tumblr Username', 'code-meta'),
                            'description' => 'Enter your Tumblr username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-tumblr-username',
                        ),
                        'tumblr_url'      => array(
                            'label'       => __('Tumblr URL', 'code-meta'),
                            'description' => 'Enter your Tumblr URL.',
                            'placeholder' => 'https://username.tumblr.com',
                            'class'       => 'code-meta-tumblr-url',
                        ),
                        'twitch_username'      => array(
                            'label'       => __('Twitch Username', 'code-meta'),
                            'description' => 'Enter your Twitch username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-twitch-username',
                        ),
                        'twitch_url'      => array(
                            'label'       => __('Twitch URL', 'code-meta'),
                            'description' => 'Enter your Twitch URL.',
                            'placeholder' => 'https://www.twitch.tv/username',
                            'class'       => 'code-meta-twitch-url',
                        ),
                        'vimeo_username'      => array(
                            'label'       => __('Vimeo Username', 'code-meta'),
                            'description' => 'Enter your Vimeo username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-vimeo-username',
                        ),
                        'vimeo_url'      => array(
                            'label'       => __('Vimeo URL', 'code-meta'),
                            'description' => 'Enter your Vimeo URL.',
                            'placeholder' => 'https://vimeo.com/username',
                            'class'       => 'code-meta-vimeo-url',
                        ),
                        'wechat_username'      => array(
                            'label'       => __('WeChat Username', 'code-meta'),
                            'description' => 'Enter your WeChat username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-wechat-username',
                        ),
                        'wechat_url'      => array(
                            'label'       => __('WeChat URL', 'code-meta'),
                            'description' => 'Enter your WeChat URL.',
                            'placeholder' => 'https://wechat.com/username',
                            'class'       => 'code-meta-wechat-url',
                        ),
                        'weibo_username'      => array(
                            'label'       => __('Weibo Username', 'code-meta'),
                            'description' => 'Enter your Weibo username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-weibo-username',
                        ),
                        'weibo_url'      => array(
                            'label'       => __('Weibo URL', 'code-meta'),
                            'description' => 'Enter your Weibo URL.',
                            'placeholder' => 'https://weibo.com/username',
                            'class'       => 'code-meta-weibo-url',
                        ),
                        'whatsapp_username'      => array(
                            'label'       => __('WhatsApp Username', 'code-meta'),
                            'description' => 'Enter your WhatsApp username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-whatsapp-username',
                        ),
                        'whatsapp_url'      => array(
                            'label'       => __('WhatsApp URL', 'code-meta'),
                            'description' => 'Enter your WhatsApp URL.',
                            'placeholder' => 'https://wa.me/username',
                            'class'       => 'code-meta-whatsapp-url',
                        ),
                        'youtube_username'      => array(
                            'label'       => __('YouTube Username', 'code-meta'),
                            'description' => 'Enter your YouTube username.',
                            'placeholder' => 'username',
                            'class'       => 'code-meta-youtube-username',
                        ),
                        'youtube_url'      => array(
                            'label'       => __('YouTube URL', 'code-meta'),
                            'description' => 'Enter your YouTube URL.',
                            'placeholder' => 'https://www.youtube.com/user/username',
                            'class'       => 'code-meta-youtube-url',
                        ),
                    ),
                ),
            )
        );
        return $show_social_fields;
    }

    /**
     * Show Address Fields on edit user pages.
     *
     * @param WP_User $user
     */
    public static function add_social_profile_fields($user)
    {
        if (!apply_filters('codemilitant_current_user_can_edit_social_profile_fields', current_user_can('edit_posts'), $user->ID)) {
            return;
        }

        $show_social_fields = self::get_social_profile_fields();

        foreach ($show_social_fields as $fieldset_key => $fieldset_val) :
?>
            <h2><?php echo $fieldset_val['title']; ?></h2>
            <table class="form-table" id="<?php echo esc_attr('fieldset-' . $fieldset_key); ?>">
                <?php foreach ($fieldset_val['fields'] as $key => $field) : ?>
                    <tr>
                        <th>
                            <label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($field['label']); ?></label>
                        </th>
                        <td>
                            <input type="text" name="<?php echo esc_attr($key); ?>" placeholder="<?php echo (!empty($field['placeholder']) ? esc_attr($field['placeholder']) : ''); ?>" id="<?php echo esc_attr($key); ?>" value="<?php echo (!empty($field['default']) ? esc_attr($field['default']) : esc_attr(self::get_user_meta($user->ID, $key))); ?>" class="<?php echo (!empty($field['class']) ? esc_attr($field['class']) : 'regular-text'); ?>" style="min-width:300px;" />
                            <p class="description"><?php echo wp_kses_post($field['description']); ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        endforeach;
    }

    /**
     * Save Address Fields on edit user pages.
     *
     * @param int $user_id User ID of the user being saved
     */
    public static function save_social_profile_fields($user_id)
    {
        if (!apply_filters('codemilitant_current_user_can_edit_social_profile_fields', current_user_can('edit_posts'), $user_id)) {
            return;
        }

        $save_fields = self::get_social_profile_fields();

        foreach ($save_fields as $fieldset) {
            foreach ($fieldset['fields'] as $key => $field) {
                if (isset($_POST[$key])) {
                    if (strpos($key, 'url') !== false) {
                        update_user_meta($user_id, $key, esc_url($_POST[$key]));
                    } else {
                        update_user_meta($user_id, $key, sanitize_text_field($_POST[$key]));
                    }
                }
            }
        }
    }

    /**
     * Get user meta for a given key, with fallbacks to core user info for pre-existing fields.
     *
     * @param int    $user_id User ID of the user being edited
     * @param string $key     Key for user meta field
     * @return string
     */
    protected static function get_user_meta($user_id, $key)
    {
        return get_user_meta($user_id, $key, true);
    }

}