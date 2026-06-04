<?php

/**
 * Plugin Name: ElementInvader Addons for Elementor
 * Description: Ready to use Elementor Addon Elements like Menu, Forms, Maps, Newsletter with many styling options
 * Plugin URI:  https://elementinvader.com
 * Version:     1.4.5
 * Requires PHP:      7.4
 * Author:      ElementInvader
 * Author URI:  https://elementinvader.com
 * Text Domain: elementinvader-addons-for-elementor
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * Elementor tested up to: 3.32.2
 * Elementor Pro tested up to: 3.34.2
 * 
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

define('ELI_VERSION', '1.4.5');
define('ELI_FILE__', __FILE__);
define('ELI_PATH', plugin_dir_path(__FILE__));
define('ELI_URL', plugin_dir_url(__FILE__));

$eli_server_prtc = wp_get_server_protocol();
$ELI_PROTOCOL = stripos($eli_server_prtc, 'https') !== false ? 'https://' : 'http://';
define('ELI_PROTOCOL', $ELI_PROTOCOL);



/**
 * Elementor Blocks
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */

 add_action('init', function ()
{

    // Notice if the Elementor is not active
    if (! did_action('elementor/loaded')) {
        $message = sprintf(
            /* translators: 1: Plugin name, 2: Elementor name. */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementinvader-addons-for-elementor'),
            '<strong>' . esc_html__('ElementInvader Addons for Elementor', 'elementinvader-addons-for-elementor') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'elementinvader-addons-for-elementor') . '</strong>'
        );
        eli_notify_admin(
            'fail_load',
            $message,
            function () {
                $admin_page = get_current_screen();
                if ($admin_page->base != "dashboard") return true;
                if (! current_user_can('update_plugins')) return true;
            },
            'notice notice-warning'
        );

        return;
    }

    // Check required version
    $elementor_version_required = '1.8.0';
    if (! version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
        $file_path = 'elementor/elementor.php';
        $upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
        $message = '<p>' . esc_html__('ElementInvader Addon Elements for Elementor doesn\'t working because you are using an old version of Elementor.', 'elementinvader-addons-for-elementor') . '</p>';
        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__('Update Elementor Now', 'elementinvader-addons-for-elementor')) . '</p>';

        eli_notify_admin(
            'fail_load_out_of_date',
            $message,
            function () {
                $admin_page = get_current_screen();
                if ($admin_page->base != "dashboard") return true;
                if (! current_user_can('update_plugins')) return true;
            },
            'notice notice-warning'
        );
        return;
    }
});



/**
 * Elementor Blocks
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function ELI_load()
{

    // Notice if the Elementor is not active
    if (! did_action('elementor/loaded')) {
        return;
    }

    // Check required version
    $elementor_version_required = '1.8.0';
    if (! version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
        return;
    }

    // Require the main plugin file
    require(__DIR__ . '/plugin.php');
}

add_action('plugins_loaded', 'ELI_load');


function eli_add_elementor_widget_categories($elements_manager)
{

    $elements_manager->add_category(
        'elementinvader',
        [
            'title' => esc_html__('Elementinvader', 'elementinvader-addons-for-elementor'),
            'icon' => 'fa fa-plug',
        ]
    );
}

add_action('elementor/elements/categories_registered', 'eli_add_elementor_widget_categories');


if (!function_exists('elementinvader-addons-for-elementor')) {
    function eli_eli_esc_elemviewe($content)
    {
        // @codingStandardsIgnoreStart
        echo ($content); // WPCS: XSS ok, sanitization ok.
        // @codingStandardsIgnoreEnd
    }
}

if (!function_exists('eli_esc_elemview')) {
    function eli_esc_elemview($content)
    {
        // @codingStandardsIgnoreStart
        return ($content); // WPCS: XSS ok, sanitization ok.
        // @codingStandardsIgnoreEnd
    }
}

function eli_setup()
{
    wp_enqueue_style('fontawesome-5', plugins_url('/assets/libs/fontawesome-5.8/css/fontawesome-5.css', ELI_FILE__), false, ELI_VERSION);
    wp_enqueue_style('elementinvader_addons_for_elementor-main', plugins_url('/assets/css/main.css', ELI_FILE__), false, ELI_VERSION);
    wp_enqueue_style('elementinvader_addons_for_elementor-widgets', plugins_url('/assets/css/widgets.css', ELI_FILE__), array(), ELI_VERSION);
    wp_enqueue_style('elementinvader_addons_for_elementor-hover-animations', plugins_url('/assets/css/eli-hover.css', ELI_FILE__), false, ELI_VERSION);

    wp_enqueue_style('wdk-scroll-mobile-swipe', plugins_url('/assets/libs/wdkscrollmobileswipe/wdk-scroll-mobile-swipe.css', ELI_FILE__), false, ELI_VERSION);
    wp_register_script('wdk-scroll-mobile-swipe', plugins_url('/assets/libs/wdkscrollmobileswipe/wdk-scroll-mobile-swipe.js', ELI_FILE__), array('jquery'), '1.0', false);
    wp_enqueue_script('wdk-scroll-mobile-swipe');

    wp_enqueue_script('elementinvader_addons_for_elementor-main');
}

add_action('wp_enqueue_scripts', 'eli_setup');



function eli_installer()
{
    include(ELI_PATH . "/include/intall.php");
}
add_action('plugins_loaded', 'eli_installer');


/* include */
include(ELI_PATH . "/modules/mail_base/mail_base.php");
include(ELI_PATH . "/helpers/plugin_helpers.php");
include(ELI_PATH . "/shortcodes/shortcodes-init.php");

include(ELI_PATH . "/modules/forms/ajax-handler.php");

use ELI\Modules\Forms\Ajax_Handler;

new Ajax_Handler();


/*
* Add admin notify
* @param (string) $key unique key of notify, prefix included related plugin
* @param (string) $text test of message
* @param (function) $callback_filter custom function should be return true if not need show
* @param (string) $class notify alert class, by default 'notice notice-error'
* @return boolen true 
*/
function eli_notify_admin($key = '', $text = 'Custom Text of message', $callback_filter = '', $class = 'notice notice-error')
{
    $key = 'eli_notify_' . $key;
    $key_diss = $key . '_dissmiss';

    // Nonce action and name for this specific key
    $nonce_action = $key_diss . '_dismiss_action';
    $nonce_name   = $key_diss . '_dismiss_nonce';

    $eli_notinstalled_admin_notice__error = function () use ($key_diss, $text, $class, $callback_filter, $nonce_action, $nonce_name) {
        global $wpdb;
        $user_id = get_current_user_id();
        if (!get_user_meta($user_id, $key_diss)) {
            if (!empty($callback_filter)) if ($callback_filter()) return false;

            $message = '';
            $message .= $text;
            $current_uri = isset($_SERVER['REQUEST_URI']) ? esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : '';
       

            // Add nonce to the dismiss URL for verification
            $url = add_query_arg([
                $key_diss => '1',
                $nonce_name => wp_create_nonce($nonce_action)
            ], $current_uri);

            printf(
                '<div class="%1$s" style="position:relative;"><p>%2$s</p><a href="%3$s"><button type="button" class="notice-dismiss"></button></a></div>',
                esc_html($class),
                wp_kses_post($message),
                esc_url($url)
            );
        }
    };

    add_action('admin_notices', function () use ($eli_notinstalled_admin_notice__error) {
        $eli_notinstalled_admin_notice__error();
    });

    $eli_notinstalled_admin_notice__error_dismissed = function () use ($key_diss, $nonce_action, $nonce_name) {
        $user_id = get_current_user_id();
        if (isset($_GET[$key_diss]) && isset($_GET[$nonce_name])) {
            // Nonce verification
            if (wp_verify_nonce(sanitize_text_field(wp_unslash($_GET[$nonce_name])), $nonce_action)) {
                add_user_meta($user_id, $key_diss, 'true', true);
            }
            // else nonce is invalid, do nothing (could log or show error)
        }
    };
    add_action('admin_init', function () use ($eli_notinstalled_admin_notice__error_dismissed) {
        $eli_notinstalled_admin_notice__error_dismissed();
    });

    return true;
}


function eli_customize_register($wp_customize)
{
    /********************
	Define generic controls
     *********************/

    $wp_customize->add_setting('footer_logo', array('sanitize_callback' => 'eli_sanitize_callback'));
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'footer_logo',
        array(
            'label' => esc_html__('Upload your custom footer image', 'elementinvader-addons-for-elementor'),
            'section' => 'title_tagline',
            'settings' => 'footer_logo'
        )
    ));
}

add_action('customize_register', 'eli_customize_register');

function eli_sanitize_callback($value)
{
    return $value;
}
