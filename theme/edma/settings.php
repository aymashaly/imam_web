<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * edma.
 *
 * @package    theme_edma
 * @copyright  2021 EnvyTheme
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

$edmaFontList = include($CFG->dirroot . '/theme/edma/inc/font_handler/edma_font_select.php');

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingedma', get_string('configtitle', 'theme_edma'));

    /*
    * ----------------------
    * General setting
    * ----------------------
    */
    $page = new admin_settingpage('theme_edma_general', get_string('generalsettings', 'theme_edma'));

     // Back to Top
     $setting = new admin_setting_configselect('theme_edma/back_to_top', get_string('back_to_top', 'theme_edma') , get_string('back_to_top_desc', 'theme_edma') , null, array(
        '0' => 'Visible',
        '1' => 'Hidden'
    ));
    $page->add($setting);

    // Favicon
    $name='theme_edma/favicon';
    $title = get_string('favicon', 'theme_edma');
    $description = get_string('favicon_desc', 'theme_edma');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_edma/preset';
    $title = get_string('preset', 'theme_edma');
    $description = get_string('preset_desc', 'theme_edma');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_edma', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets from Boost.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_edma/presetfiles';
    $title = get_string('presetfiles','theme_edma');
    $description = get_string('presetfiles_desc', 'theme_edma');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Primary Color 
    $name = 'theme_edma/brandcolor';
    $title = get_string('brandcolor', 'theme_edma');
    $description = get_string('brandcolor_desc', 'theme_edma');
    $default = '#098b99';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Secondary Color 
    $name = 'theme_edma/secondarycolor';
    $title = get_string('secondarycolor', 'theme_edma');
    $description = get_string('secondarycolor_desc', 'theme_edma');
    $default = '#fec400';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Color 
    $name = 'theme_edma/footer_bg';
    $title = get_string('footer_bg', 'theme_edma');
    $default = '#100f1f';
    $setting = new admin_setting_configcolourpicker($name, $title, '', $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Hide Course Curriculum For Guest Access
    $setting = new admin_setting_configselect('theme_edma/hide_guest_access_curriculum', get_string('hide_guest_access_curriculum', 'theme_edma') , get_string('hide_guest_access_curriculum_desc', 'theme_edma') , null, array(
        '0' => 'Visible',
        '1' => 'Hidden'
    ));
    $page->add($setting);

    // Site Currency
    $name = 'theme_edma/site_currency';
    $title = get_string('site_currency', 'theme_edma');
    $setting = new admin_setting_configtext($name, $title, '', '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Enroll Button
    $name = 'theme_edma/enroll_btn';
    $title = 'Enroll Button Text';
    $setting = new admin_setting_configtext($name, $title, '', '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_edma/hide_banner';
    $title = get_string('hide_banner', 'theme_edma');
    $description = get_string('hide_banner_desc', 'theme_edma');
    $setting = new admin_setting_configtextarea ($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Global Banner
    $setting = new admin_setting_configselect('theme_edma/hide_global_banner', get_string('hide_global_banner', 'theme_edma') , get_string('hide_global_banner_desc', 'theme_edma') , null, array(
        '0' => 'Visible',
        '1' => 'Hidden'
    ));
    $page->add($setting);
    
    $name = 'theme_edma/hide_page_bottom_content';
    $title = get_string('hide_page_bottom_content', 'theme_edma');
    $description = get_string('hide_page_bottom_content_desc', 'theme_edma');
    $setting = new admin_setting_configtextarea ($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Logo settings
    * ----------------------
    */
    $page = new admin_settingpage('theme_edma_logo', get_string('logo_settings', 'theme_edma'));

        // Header logos
        $page->add(new admin_setting_heading('theme_edma/header_logos', get_string('header_logos', 'theme_edma'), NULL));

        // Logotype
        $setting = new admin_setting_configselect('theme_edma/logo_visibility',
            get_string('logo_visibility', 'theme_edma'), '', null,
            array(
                '0' => 'Visible',
                '1' => 'Hidden'
            ));
        $page->add($setting);

        // Main Logo
        $name='theme_edma/main_logo';
        $title = get_string('main_logo', 'theme_edma');
        $description = get_string('main_logo_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'main_logo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Logo Width
        $setting = new admin_setting_configtext('theme_edma/logo_image_width', get_string('logo_image_width','theme_edma'), get_string('logo_image_width_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Logo Height
        $setting = new admin_setting_configtext('theme_edma/logo_image_height', get_string('logo_image_height','theme_edma'), get_string('logo_image_height_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Mobile Logo
        $name='theme_edma/mobile_logo';
        $title = get_string('mobile_logo', 'theme_edma');
        $description = get_string('mobile_logo_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'mobile_logo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Mobile Logo Width
        $setting = new admin_setting_configtext('theme_edma/mobile_logo_width', get_string('mobile_logo_width','theme_edma'), get_string('mobile_logo_width_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Logo Height
        $setting = new admin_setting_configtext('theme_edma/mobile_logo_height', get_string('mobile_logo_height','theme_edma'), get_string('mobile_logo_height_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Footer logo
        $page->add(new admin_setting_heading('theme_edma/footer_logo_sec', get_string('footer_logo_sec', 'theme_edma'), NULL));

        // Logotype
        $setting = new admin_setting_configselect('theme_edma/footer_logo_visibility',
            get_string('footer_logo_visibility', 'theme_edma'), '', null,
            array(
                '0' => 'Visible',
                '1' => 'Hidden'
            ));
        $page->add($setting);

        // Footer  Logo
        $name='theme_edma/main_footer_logo';
        $title = get_string('main_footer_logo', 'theme_edma');
        $description = get_string('main_footer_logo_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'main_footer_logo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Logo Width
        $setting = new admin_setting_configtext('theme_edma/footer_logo_width', get_string('footer_logo_width','theme_edma'), get_string('footer_logo_width_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Logo Height
        $setting = new admin_setting_configtext('theme_edma/footer_logo_height', get_string('footer_logo_height','theme_edma'), get_string('footer_logo_height_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    $settings->add($page);

    /*
    * ----------------------
    * Header settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_edma_header', get_string('header_settings', 'theme_edma'));

        // Top Header
        $setting = new admin_setting_configselect('theme_edma/top_header', get_string('top_header', 'theme_edma'), '', null,
            array(
                '1' => 'Show',
                '0' => 'Hide'
            ));
        $page->add($setting);

        // Top Header Content
        $name = 'theme_edma/top_header_content';
        $title = get_string('top_header_content', 'theme_edma');
        $default = 'Keep learning with free resources during COVID-19. <a href="#" class="read-more">Learn more <i class="ri-arrow-right-line"></i></a>';
        $description = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Top Header Content
        $name = 'theme_edma/top_header_right_content';
        $title = get_string('top_header_right_content', 'theme_edma');
        $default = '<li><a href="#">Become An Instructor</a></li>';
        $description = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Search
        $setting = new admin_setting_configselect('theme_edma/header_search', get_string('header_search', 'theme_edma'),
        get_string('header_search_desc', 'theme_edma'), null,
            array(
                '1' => 'Show',
                '0' => 'Hide'
            ));
        $page->add($setting);

        // Navbar Search Placeholder Title.
        $name = 'theme_edma/search_placeholder';
        $title = get_string('search_placeholder', 'theme_edma');
        $default = 'Search for anything';
        $description = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Left Button Text
        $setting = new admin_setting_configtext('theme_edma/header_left_btn_text', get_string('header_left_btn_text','theme_edma'), get_string('header_left_btn_text_desc', 'theme_edma'), 'Login', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Left Button URL
        $setting = new admin_setting_configtext('theme_edma/header_left_btn_url', get_string('header_left_btn_url','theme_edma'), get_string('header_left_btn_url_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Button Text
        $setting = new admin_setting_configtext('theme_edma/header_btn_text', get_string('header_btn_text','theme_edma'), get_string('header_btn_text_desc', 'theme_edma'), 'Sign Up', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Button URL
        $setting = new admin_setting_configtext('theme_edma/header_btn_url', get_string('header_btn_url','theme_edma'), get_string('header_btn_url_desc', 'theme_edma'), '', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Button Icon
        $setting = new admin_setting_configselect('theme_edma/header_btn_icon_edma_icon_class',
        get_string('header_btn_icon', 'theme_edma'),
        get_string('header_btn_icon_desc', 'theme_edma'), 'ri-registered-line', $edmaFontList);
        $page->add($setting);

        // Offcanvas Content
        $setting = new admin_setting_confightmleditor('theme_edma/offcanvas_content', get_string('offcanvas_content','theme_edma'), get_string('offcanvas_content_desc', 'theme_edma'), '', PARAM_RAW, 500);                                                               
        $setting->set_updatedcallback('theme_reset_all_caches');                                                    
        $page->add($setting);

        // Offcanvas Social Title 
        $setting = new admin_setting_configtext('theme_edma/offcanvas_social_title', get_string('offcanvas_social_title','theme_edma'), get_string('offcanvas_social_title_desc', 'theme_edma'), 'Follow Us');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Banner Shape Image 1
        $name='theme_edma/banner_shape_image';
        $title = get_string('banner_shape_image', 'theme_edma');
        $description = get_string('banner_shape_image_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'banner_shape_image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Banner Shape Image 2
        $name='theme_edma/banner_shape_image2';
        $title = get_string('banner_shape_image2', 'theme_edma');
        $description = get_string('banner_shape_image2_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'banner_shape_image2');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // Banner Shape Image 3
        $name='theme_edma/banner_shape_image3';
        $title = get_string('banner_shape_image3', 'theme_edma');
        $description = get_string('banner_shape_image3_desc', 'theme_edma');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'banner_shape_image3');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    $settings->add($page);

    // Social settings
    $page = new admin_settingpage('theme_edma_social_settings', get_string('social_settings', 'theme_edma'));

        // New Window
        $setting = new admin_setting_configselect('theme_edma/social_target', get_string('social_target', 'theme_edma') , get_string('social_target_desc', 'theme_edma') , null, array(
            '0' => 'Open URLs in the same page',
            '1' => 'Open URLs in a new window'
        ));
        $page->add($setting);

        // Facebook URL
        $setting = new admin_setting_configtext('theme_edma/edma_facebook_url', get_string('edma_facebook_url', 'theme_edma') , get_string('edma_facebook_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Twitter URL
        $setting = new admin_setting_configtext('theme_edma/edma_twitter_url', get_string('edma_twitter_url', 'theme_edma') , get_string('edma_twitter_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Instagram URL
        $setting = new admin_setting_configtext('theme_edma/edma_instagram_url', get_string('edma_instagram_url', 'theme_edma') , get_string('edma_instagram_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Pinterest URL
        $setting = new admin_setting_configtext('theme_edma/edma_pinterest_url', get_string('edma_pinterest_url', 'theme_edma') , get_string('edma_pinterest_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Dribbble URL
        $setting = new admin_setting_configtext('theme_edma/edma_dribbble_url', get_string('edma_dribbble_url', 'theme_edma') , get_string('edma_dribbble_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Google URL
        $setting = new admin_setting_configtext('theme_edma/edma_google_url', get_string('edma_google_url', 'theme_edma') , get_string('edma_google_url_desc', 'theme_edma') , '#', PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // YouTube URL
        $setting = new admin_setting_configtext('theme_edma/edma_youtube_url', get_string('edma_youtube_url', 'theme_edma') , get_string('edma_youtube_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // VK URL
        $setting = new admin_setting_configtext('theme_edma/edma_vk_url', get_string('edma_vk_url', 'theme_edma') , get_string('edma_vk_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // 500px URL
        $setting = new admin_setting_configtext('theme_edma/edma_500px_url', get_string('edma_500px_url', 'theme_edma') , get_string('edma_500px_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Behance URL
        $setting = new admin_setting_configtext('theme_edma/edma_behance_url', get_string('edma_behance_url', 'theme_edma') , get_string('edma_behance_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Digg URL
        $setting = new admin_setting_configtext('theme_edma/edma_digg_url', get_string('edma_digg_url', 'theme_edma') , get_string('edma_digg_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Flickr URL
        $setting = new admin_setting_configtext('theme_edma/edma_flickr_url', get_string('edma_flickr_url', 'theme_edma') , get_string('edma_flickr_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Foursquare URL
        $setting = new admin_setting_configtext('theme_edma/edma_foursquare_url', get_string('edma_foursquare_url', 'theme_edma') , get_string('edma_foursquare_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // LinkedIn URL
        $setting = new admin_setting_configtext('theme_edma/edma_linkedin_url', get_string('edma_linkedin_url', 'theme_edma') , get_string('edma_linkedin_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Medium URL
        $setting = new admin_setting_configtext('theme_edma/edma_medium_url', get_string('edma_medium_url', 'theme_edma') , get_string('edma_medium_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Meetup URL
        $setting = new admin_setting_configtext('theme_edma/edma_meetup_url', get_string('edma_meetup_url', 'theme_edma') , get_string('edma_meetup_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Snapchat URL
        $setting = new admin_setting_configtext('theme_edma/edma_snapchat_url', get_string('edma_snapchat_url', 'theme_edma') , get_string('edma_snapchat_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Tumblr URL
        $setting = new admin_setting_configtext('theme_edma/edma_tumblr_url', get_string('edma_tumblr_url', 'theme_edma') , get_string('edma_tumblr_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Vimeo URL
        $setting = new admin_setting_configtext('theme_edma/edma_vimeo_url', get_string('edma_vimeo_url', 'theme_edma') , get_string('edma_vimeo_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // WeChat URL
        $setting = new admin_setting_configtext('theme_edma/edma_wechat_url', get_string('edma_wechat_url', 'theme_edma') , get_string('edma_wechat_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // WhatsApp URL
        $setting = new admin_setting_configtext('theme_edma/edma_whatsapp_url', get_string('edma_whatsapp_url', 'theme_edma') , get_string('edma_whatsapp_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // WordPress URL
        $setting = new admin_setting_configtext('theme_edma/edma_wordpress_url', get_string('edma_wordpress_url', 'theme_edma') , get_string('edma_wordpress_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Weibo URL
        $setting = new admin_setting_configtext('theme_edma/edma_weibo_url', get_string('edma_weibo_url', 'theme_edma') , get_string('edma_weibo_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Telegram URL
        $setting = new admin_setting_configtext('theme_edma/edma_telegram_url', get_string('edma_telegram_url', 'theme_edma') , get_string('edma_telegram_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Moodle URL
        $setting = new admin_setting_configtext('theme_edma/edma_moodle_url', get_string('edma_moodle_url', 'theme_edma') , get_string('edma_moodle_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Amazon URL
        $setting = new admin_setting_configtext('theme_edma/edma_amazon_url', get_string('edma_amazon_url', 'theme_edma') , get_string('edma_amazon_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Slideshare URL
        $setting = new admin_setting_configtext('theme_edma/edma_slideshare_url', get_string('edma_slideshare_url', 'theme_edma') , get_string('edma_slideshare_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // SoundCloud URL
        $setting = new admin_setting_configtext('theme_edma/edma_soundcloud_url', get_string('edma_soundcloud_url', 'theme_edma') , get_string('edma_soundcloud_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // LeanPub URL
        $setting = new admin_setting_configtext('theme_edma/edma_leanpub_url', get_string('edma_leanpub_url', 'theme_edma') , get_string('edma_leanpub_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Xing URL
        $setting = new admin_setting_configtext('theme_edma/edma_xing_url', get_string('edma_xing_url', 'theme_edma') , get_string('edma_xing_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Bitcoin URL
        $setting = new admin_setting_configtext('theme_edma/edma_bitcoin_url', get_string('edma_bitcoin_url', 'theme_edma') , get_string('edma_bitcoin_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Twitch URL
        $setting = new admin_setting_configtext('theme_edma/edma_twitch_url', get_string('edma_twitch_url', 'theme_edma') , get_string('edma_twitch_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Github URL
        $setting = new admin_setting_configtext('theme_edma/edma_github_url', get_string('edma_github_url', 'theme_edma') , get_string('edma_github_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Gitlab URL
        $setting = new admin_setting_configtext('theme_edma/edma_gitlab_url', get_string('edma_gitlab_url', 'theme_edma') , get_string('edma_gitlab_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Forumbee URL
        $setting = new admin_setting_configtext('theme_edma/edma_forumbee_url', get_string('edma_forumbee_url', 'theme_edma') , get_string('edma_forumbee_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Trello URL
        $setting = new admin_setting_configtext('theme_edma/edma_trello_url', get_string('edma_trello_url', 'theme_edma') , get_string('edma_trello_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Weixin URL
        $setting = new admin_setting_configtext('theme_edma/edma_weixin_url', get_string('edma_weixin_url', 'theme_edma') , get_string('edma_weixin_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        // Slack URL
        $setting = new admin_setting_configtext('theme_edma/edma_slack_url', get_string('edma_slack_url', 'theme_edma') , get_string('edma_slack_url_desc', 'theme_edma') , null, PARAM_NOTAGS, 50);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_edma_footer', get_string('footersettings', 'theme_edma'));

    // Footer Shape Image 1
    $name='theme_edma/footer_shape_image1';
    $title = get_string('footer_shape_image1', 'theme_edma');
    $description = get_string('footer_shape_image1_desc', 'theme_edma');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footer_shape_image1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Footer Shape Image 2
    $name='theme_edma/footer_shape_image2';
    $title = get_string('footer_shape_image2', 'theme_edma');
    $description = get_string('footer_shape_image2_desc', 'theme_edma');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footer_shape_image2');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer column 1
    $page->add(new admin_setting_heading('theme_edma/footer_col_1', get_string('footer_col_1', 'theme_edma') , NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edma/footer_col_1_title', get_string('footer_col_title', 'theme_edma') , get_string('footer_col_title_desc', 'theme_edma') , '', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edma/footer_col_1_body', get_string('footer_col_body', 'theme_edma') , get_string('footer_col_body_desc', 'theme_edma') , 'Body text for the first column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 2
    $page->add(new admin_setting_heading('theme_edma/footer_col_2', get_string('footer_col_2', 'theme_edma') , NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edma/footer_col_2_title', get_string('footer_col_title', 'theme_edma') , get_string('footer_col_title_desc', 'theme_edma') , 'About Us', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edma/footer_col_2_body', get_string('footer_col_body', 'theme_edma') , get_string('footer_col_body_desc', 'theme_edma') , 'Body text for the second column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 3
    $page->add(new admin_setting_heading('theme_edma/footer_col_3', get_string('footer_col_3', 'theme_edma') , NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edma/footer_col_3_title', get_string('footer_col_title', 'theme_edma') , get_string('footer_col_title_desc', 'theme_edma') , 'Resources', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edma/footer_col_3_body', get_string('footer_col_body', 'theme_edma') , get_string('footer_col_body_desc', 'theme_edma') , 'Body text for the third column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 4
    $page->add(new admin_setting_heading('theme_edma/footer_col_4', get_string('footer_col_4', 'theme_edma') , NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edma/footer_col_4_title', get_string('footer_col_title', 'theme_edma') , get_string('footer_col_title_desc', 'theme_edma') , 'Quick Link', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edma/footer_col_4_body', get_string('footer_col_body', 'theme_edma') , get_string('footer_col_body_desc', 'theme_edma') , 'Body text for the fourth column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column 5
    $page->add(new admin_setting_heading('theme_edma/footer_col_5', get_string('footer_col_5', 'theme_edma') , NULL));
    // Footer column title
    $setting = new admin_setting_configtext('theme_edma/footer_col_5_title', get_string('footer_col_title', 'theme_edma') , get_string('footer_col_title_desc', 'theme_edma') , 'Contact Us', PARAM_NOTAGS, 50);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Footer column body
    $setting = new admin_setting_configtextarea('theme_edma/footer_col_5_body', get_string('footer_col_body', 'theme_edma') , get_string('footer_col_body_desc', 'theme_edma') , 'Body text for the fifth column.', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer Copyright Text
    $name = 'theme_edma/footer_copyright';
    $title = get_string('footer_copyright', 'theme_edma');
    $description = '';
    $setting = new admin_setting_configtextarea ($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_edma_advanced', get_string('advancedsettings', 'theme_edma'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_configtextarea('theme_edma/scsspre',
        get_string('rawscsspre', 'theme_edma'), get_string('rawscsspre_desc', 'theme_edma'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_configtextarea('theme_edma/scss', get_string('rawscss', 'theme_edma'), get_string('rawscss_desc', 'theme_edma'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}