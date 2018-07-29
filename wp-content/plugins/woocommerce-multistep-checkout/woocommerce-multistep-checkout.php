<?php
/**
 * Plugin Name: WooCommerce MultiStep Checkout
 * Description: WooCommerce Multi-Step-Checkout enable multi-step-checkout functionality on WooCommerce checkout page.
 * Version: 2.9.2
 * Author: Kole Roy
 * Author URI: http://woocommerce-multistep-checkout.com/
 * Text Domain: woocommerce-multistep-checkout
 * Domain Path: /languages/
 */
if (!defined('ABSPATH'))
    die();

define("WMC_VERSION", "2.9.2");
include_once( ABSPATH . 'wp-admin/includes/plugin.php');

/**
 * Actions to be performed on plugin activation
 */
function dependentplugin_activate() {
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        // deactivate dependent plugin
        deactivate_plugins(plugin_basename(__FILE__));
        exit('<strong>WooCommerce Multistep Checkout</strong> requires <a target="_blank" href="http://wordpress.org/plugins/woocommerce/">WooCommerce</a> Plugin to be installed first.');
    } else {
        //default option for plugin        
        update_option('wmc_add_register_form', 'false');
        update_option('wmc_add_login_form', 'true');
        update_option('wmc_show_product_thumbnail', 'false');
        update_option('wmc_merge_order_payment_tabs', 'true');
        update_option('wmc_merge_billing_shipping_tabs', 'false');
        update_option('wmc_orientation', 'horizontal');
        update_option('wmc_zipcode_validation', 'false');
        update_option('wmc_add_code_footer', 'false');
        update_option('wmc_add_coupon_form', 'false');
        update_option('wmc_empty_error', 'This field is required');
        update_option('wmc_email_error', 'Please enter a valid email address');
        update_option('wmc_phone_error', 'Please enter valid phone number');
        update_option('wmc_terms_error', 'You must accept our Terms & Conditions');
    }
}

register_activation_hook(__FILE__, 'dependentplugin_activate');


load_plugin_textdomain('woocommerce-multistep-checkout', false, dirname(plugin_basename(__FILE__)) . '/languages/');

/**
 * Load checkout template from this plugin
 */
add_filter('woocommerce_locate_template', 'wcmultichecout_woocommerce_locate_template', PHP_INT_MAX, 3);

function wcmultichecout_woocommerce_locate_template($template, $template_name, $plugin_path) {

    $plugin_path = untrailingslashit(plugin_dir_path(__FILE__)) . '/woocommerce/';
    if (file_exists($plugin_path . $template_name)) {
        $template = $plugin_path . $template_name;
        return $template;
    }

    return $template;
}

/* * *
 * Enque necessary scripts and CSS files
 */

function enque_woocommerce_multistep_checkout_scripts() {
    $wizard_type = get_option('wmc_wizard_type');
    wp_register_script('jquery-validate', plugins_url('/js/jquery.validate.min.js', __FILE__), array('jquery'), WMC_VERSION);
    wp_register_script('jquery-steps', plugins_url('/js/jquery.steps.min.js', __FILE__), array('jquery', 'jquery-validate'), WMC_VERSION);

    if ($wizard_type == '' || $wizard_type == 'elegant') {
        wp_register_style('jquery-steps', plugins_url('/css/jquery.steps-elegant.minify.css', __FILE__), null, WMC_VERSION);
    } elseif ($wizard_type == 'classic') {
        wp_register_style('jquery-steps', plugins_url('/css/jquery.steps-classic.minify.css', __FILE__), null, WMC_VERSION);
    } else {
        wp_register_style('jquery-steps', plugins_url('/css/jquery.steps-modern.minify.css', __FILE__), null, WMC_VERSION);
    }
    wp_register_style('jquery-steps-main', plugins_url('/css/main.minify.css', __FILE__), null, WMC_VERSION);

    /*     * ***Only add on WooCommerce checkout page * */
    if (is_checkout()) {
        wp_enqueue_script('jquery-steps');
        wp_enqueue_script('jquery-validate');
        wp_enqueue_style('jquery-steps');
        wp_enqueue_style('jquery-steps-main');
    }
}

add_action('wp_enqueue_scripts', 'enque_woocommerce_multistep_checkout_scripts');


/* * *
 * Loading variables to wizard file
 */

function wmc_load_scripts() {
    $vars = array(
        'transitionEffect' => get_option('wmc_animation') ? get_option('wmc_animation') : 'fade',
        'stepsOrientation' => get_option('wmc_orientation') ? get_option('wmc_orientation') : 'horizontal',
        'enableAllSteps' => get_option('wmc_enable_all_steps') ? get_option('wmc_enable_all_steps') : 'false',
        'enablePagination' => get_option('wmc_enable_pagination') ? get_option('wmc_enable_pagination') : 'true',
        'next' => get_option('wmc_btn_next') ? __(get_option('wmc_btn_next'), 'woocommerce-multistep-checkout') : __('Next', 'woocommerce-multistep-checkout'),
        'previous' => get_option('wmc_btn_prev') ? __(get_option('wmc_btn_prev'), 'woocommerce-multistep-checkout') : __('Previous', 'woocommerce-multistep-checkout'),
        'finish' => get_option('wmc_btn_finish') ? __(get_option('wmc_btn_finish'), 'woocommerce-multistep-checkout') : __('Place Order', 'woocommerce-multistep-checkout'),
        'error_msg' => get_option('wmc_empty_error') ? __(get_option('wmc_empty_error'), 'woocommerce-multistep-checkout') : __('This field is required', 'woocommerce-multistep-checkout'),
        'email_error_msg' => get_option('wmc_email_error'),
        'phone_error_msg' => get_option('wmc_phone_error'),
        'terms_error' => get_option('wmc_terms_error'),
        'remove_numbers' => get_option('wmc_remove_numbers'),
        'zipcode_validation' => get_option('wmc_zipcode_validation'),
        'isAuthorizedUser' => isAuthorizedUser(),
        'loading_img' => plugins_url('images/animatedEllipse.gif', __FILE__),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'wmc_remove_numbers' => get_option('wmc_remove_numbers'),
        'include_login' => get_option('wmc_add_login_form'),
        'include_register_form' => get_option('wmc_add_register_form'),
        'include_coupon_form' => get_option('wmc_add_coupon_form'),
        'woo_include_login' => get_option('woocommerce_enable_checkout_login_reminder'),
        'no_account_btn' => get_option('wmc_no_account_btn') ? __(stripslashes(get_option('wmc_no_account_btn')), 'woocommerce-multistep-checkout') : __("I don't have an account", 'woocommerce-multistep-checkout'),
        'login_nonce' => wp_create_nonce('wmc-login-nonce'),
        'register_nonce' => wp_create_nonce('wmc-register-nonce'),
    );
    if (is_checkout()) {
        if (get_option('wmc_add_code_footer') == 'true') {
            wp_register_script('wmc-wizard', plugins_url('/js/wizard.min.js', __FILE__), array('jquery-steps', 'jquery-validate'), WMC_VERSION, true);
        } else {
            wp_register_script('wmc-wizard', plugins_url('/js/wizard.min.js', __FILE__), array('jquery-steps', 'jquery-validate'), WMC_VERSION, false);
        }
        wp_enqueue_script('wmc-wizard');
        wp_localize_script('wmc-wizard', 'wmc_wizard', $vars);
    }
}

wmc_enque_wizard_scripts();

function wmc_enque_wizard_scripts() {
    if (get_option('wmc_add_code_footer') == 'true') {
        add_action('wp_enqueue_scripts', 'wmc_load_scripts', 100);
    } else {
        add_action('wp_enqueue_scripts', 'wmc_load_scripts', 1);
    }
}

/* * *******
 * Plugin Options Page
 * * */

add_action('admin_menu', 'woocommercemultichekout_menu_page');

function woocommercemultichekout_menu_page() {
    add_submenu_page('woocommerce', 'WooCommerce MultiStepCheckout', 'Checkout Wizard', 'manage_options', 'wcmultichekout', 'wcmultichekout_options');
}

function wcmultichekout_options() {
    require_once(plugin_dir_path(__FILE__) . '/lib/plugin_options.php');
}

/* * * Add Color Picker * */
add_action('admin_enqueue_scripts', 'wmc_enqueue_color_picker');

function wmc_enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker-script', plugins_url('js/script.js', __FILE__), array('wp-color-picker'), false, true);
}

function add_jquery_steps_options() {
    require_once(plugin_dir_path(__FILE__) . '/lib/step_options.php');
}

add_action('wp_head', 'add_jquery_steps_options');


add_action('woocommerce_checkout_order_review', 'update_shipping_info');

function update_shipping_info() {
    ?>
    <?php if (get_option('wmc_merge_order_payment_tabs') != "true" || get_option('wmc_merge_order_payment_tabs') == ""): ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".shipping-tab .shop_table").empty();
                jQuery(".shop_table").appendTo(".shipping-tab");

            })
        </script>
        <?php
    endif;
}

/**
 * Add Login form to wizard
 */
if (is_login_in_wizard() && !is_register_in_the_wizard()) {
    add_action('after_setup_theme', 'wmc_add_checkout_login_form');

    function wmc_add_checkout_login_form() {
        if (!has_action('woocommerce_before_checkout_form')) {
            add_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
        }
    }

//add login form to wizard
    add_action('woocommerce_multistep_checkout_before', 'add_login_to_wizard');

    function add_login_to_wizard() {
        if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
            return;
        }
        ?>
        <script>
            jQuery(function () {
                jQuery(".woocommerce-info a.showlogin").parent().detach();
                jQuery("form.woocommerce-form-login").appendTo('.login-step');
                jQuery(".login-step form.woocommerce-form-login").show();
            });</script>    
        <h1 class="title-login-wizard"><?php _e('Login', 'woocommerce') ?></h1>
        <div class="login-step">


        </div>
        <?php
    }

}

/**
 * Add Regiseter form to wizard
 */
if (is_login_in_wizard() && is_register_in_the_wizard()) {
    add_action('woocommerce_multistep_checkout_before', 'wmc_checkout_login_register_form');

    function wmc_checkout_login_register_form() {
        if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
            return;
        }
        ?>
        <h1 class="title-login-wizard"><?php _e('Login', 'woocommerce') ?></h1>
        <div class="login-step">
            <script>
                jQuery(function () {
                    jQuery(".woocommerce-info a.showlogin").parent().detach();
                    jQuery("#customer_login").appendTo('.login-step');
                });</script>    

        </div>
        <?php
    }

}

/**
 * Add Coupon form to wizard
 */
$add_coupon_form = get_option('wmc_add_coupon_form');
if ($add_coupon_form == 'true') {
    /*     * Check if coupons are enabled. */
    if (get_option('woocommerce_enable_coupons') != "yes") {
        return;
    }
    add_action('woocommerce_multistep_checkout_before', 'wmc_add_coupon_form', 20);

    function wmc_add_coupon_form() {
        ?>
        <script>
            jQuery(function () {
                jQuery(".woocommerce-info a.showcoupon").parent().detach();
                jQuery("form.checkout_coupon").appendTo('.coupon-step');
                jQuery(".coupon-step form.checkout_coupon").show();
            });</script>

        <h1 class="title-coupon-wizard"><?php echo get_option('wmc_coupon_label') ? __(get_option('wmc_coupon_label'), 'woocommerce-multistep-checkout') : __('Coupon', 'woocommerce-multistep-checkout'); ?></h1>
        <div class="coupon-step">


        </div>
        <?php
    }

}

function isAuthorizedUser() {
    return get_current_user_id();
}

add_action('wp_ajax_valid_post_code', 'wmc_validate_post_code');
add_action('wp_ajax_nopriv_valid_post_code', 'wmc_validate_post_code');

//validate PostCode
function wmc_validate_post_code() {
    $country = $_POST['country'];
    $postCode = strtoupper(str_replace(' ', '', $_POST['postCode']));
    echo WC_Validation::is_postcode($postCode, $country);

    exit();
}

add_action('wp_ajax_validate_phone', 'wmc_validate_phone_number');
add_action('wp_ajax_nopriv_validate_phone', 'wmc_validate_phone_number');

function wmc_validate_phone_number() {
    $phone = $_POST['phone'];
    echo WC_Validation::is_phone($phone);

    exit();
}

//Handle Login form

add_action('wp_ajax_wmc_check_user_login', 'wmc_authenticate_user');
add_action('wp_ajax_nopriv_wmc_check_user_login', 'wmc_authenticate_user');

function wmc_authenticate_user() {
    check_ajax_referer('wmc-login-nonce');
    if (is_email($_POST['username']) && apply_filters('woocommerce_get_username_from_email', true)) {
        $user = get_user_by('email', $_POST['username']);

        if (isset($user->user_login)) {
            $creds['user_login'] = $user->user_login;
        }
    } else {
        $creds['user_login'] = $_POST['username'];
    }

    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = isset($_POST['rememberme']);
    $secure_cookie = is_ssl() ? true : false;
    $user = wp_signon(apply_filters('woocommerce_login_credentials', $creds), $secure_cookie);


    if (wmc_is_eruser_authenticate($user)) {
        echo '<p class="error-msg">' . __('Incorrect username/password.', 'woocommerce-multistep-checkout') . ' </p>';
    } else {
        echo 'successfully';
    }

    exit();
}

function wmc_is_eruser_authenticate($result) {
    return is_wp_error($result);
}

/* * **
 * Handle User registeration
 */

add_action('wp_ajax_wmc_user_registration', 'wmc_handle_registration');
add_action('wp_ajax_nopriv_wmc_user_registration', 'wmc_handle_registration');

function wmc_handle_registration() {

    check_ajax_referer('wmc-register-nonce');

    $username = 'no' === get_option('woocommerce_registration_generate_username') ? trim($_POST['username']) : '';
    $password = 'no' === get_option('woocommerce_registration_generate_password') ? trim($_POST['password']) : '';
    $email = trim($_POST['email']);

    $form_errors = array();
    if (empty($email) || !is_email($email)) {
        $form_errors[] = 'Please provide a valid email address.';
    }

    if (email_exists($email)) {
        $form_errors[] = 'An account is already registered with your email address. Please log in.';
    }

    if ('no' === get_option('woocommerce_registration_generate_username') || !empty($username)) {
        $username = sanitize_user($username);

        if (empty($username) || !validate_username($username)) {
            $form_errors[] = 'Please enter a valid account username.';
        }

        if (username_exists($username)) {
            $form_errors[] = 'An account is already registered with that username. Please choose another.';
        }
    }

    if ('no' === get_option('woocommerce_registration_generate_password')) {
        if (empty($password)) {
            $form_errors[] = 'Please enter an account password.';
        }
    }

    if ($form_errors) {
        echo '<ul class="register_form_error" style="color:red">';
        foreach ($form_errors as $error) {
            echo '<li style="margin:0 0 0 10px;list-style:disc !important"> ' . $error . '</li>';
        }
        echo '</ul>';
        exit();
    } else {
        $new_customer = wc_create_new_customer(sanitize_email($email), wc_clean($username), $password);
        wc_set_customer_auth_cookie($new_customer);
        echo 'success';
        exit();
    }
}

/* * *
 * Add plugin info to the plugin listing page
 */
if (isset($_GET['page']) && $_GET['page'] == "wcmultichekout") {
    add_filter('admin_footer_text', 'wmc_admin_footer_text');

    function wmc_admin_footer_text() {

        echo sprintf(__('If you like <strong>WooCommerce MultiStep Checkout</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating.'), '<a href="http://codecanyon.net/item/woocommerce-multistep-checkout/8125187" target="_blank" class="wc-rating-link" data-rated="' . __('Thanks :)', 'woocommerce') . '">', '</a>');
    }

}

add_filter('plugin_row_meta', 'wmc_Register_Plugins_Links', 10, 2);

function wmc_Register_Plugins_Links($links, $file) {
    $base = plugin_basename(__FILE__);
    if ($file == $base) {
        $links[] = '<a href="http://woocommerce-multistep-checkout.com/documentation/">' . __('Documentation') . '</a>';
        $links[] = '<a href="http://woocommerce-multistep-checkout.com/faq/">' . __('FAQ') . '</a>';
    }
    return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wmc_link_action_on_plugin');

function wmc_link_action_on_plugin($links) {
    if (class_exists('WooCommerce')) {
        return array_merge(array('settings' => '<a href="' . admin_url('admin.php?page=wcmultichekout') . '">' . __('Settings', 'domain') . '</a>'), $links);
    } else {
        return $links;
    }
}

function is_login_in_wizard() {
    if (get_option('wmc_add_login_form') == 'false') {
        return false;
    } else {
        return true;
    }
}

function is_register_in_the_wizard() {
    if (get_option('wmc_add_register_form') == 'false') {
        return false;
    } else {
        return true;
    }
}

/* * *
 * Checkout Fixes for Avada theme
 */
add_action('after_setup_theme', 'avada_checkoutfix');

function avada_checkoutfix() {
    if (function_exists('avada_woocommerce_checkout_after_customer_details')) {
        remove_action('woocommerce_checkout_after_customer_details', 'avada_woocommerce_checkout_after_customer_details');
    }

    if (function_exists('avada_woocommerce_checkout_before_customer_details')) {
        remove_action('woocommerce_checkout_before_customer_details', 'avada_woocommerce_checkout_before_customer_details');
    }

    if (class_exists('Avada_Woocommerce')) {
        global $avada_woocommerce;
        remove_action('woocommerce_checkout_before_customer_details', array($avada_woocommerce, 'checkout_before_customer_details'));
        remove_action('woocommerce_checkout_after_customer_details', array($avada_woocommerce, 'checkout_after_customer_details'));
    }
}

/**
 * Fix Stripe Apple Pay button
 */
function wmc_remove_apple_pay_btn() {
    if (class_exists('WC_Stripe_Apple_Pay')) {
        remove_action('woocommerce_checkout_before_customer_details', array(WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_button'), 1);
        remove_action('woocommerce_checkout_before_customer_details', array(WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_separator_html'), 1);

        add_action('woocommerce_before_checkout_form', array(WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_button'), 1);
        add_action('woocommerce_before_checkout_form', array(WC_Stripe_Apple_Pay::instance(), 'display_apple_pay_separator_html'), 1);
    }
}

//add_action('init', 'wmc_remove_apple_pay_btn', 20);