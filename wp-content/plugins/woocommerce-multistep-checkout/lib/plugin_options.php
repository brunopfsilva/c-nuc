<?php
//must check that the user has the required capability 
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}


//Submit form
if (isset($_POST['send_form']) && $_POST['send_form'] == 'Y') {

    $do_not_save = array('send_form', 'submit', 'wmc_restore_default');
    foreach ($_POST as $option_name => $option_value) {
        if (in_array($option_name, $do_not_save))
            continue;

        // Save the posted value in the database
        update_option($option_name, $option_value);
    }

    // If restore to default
    if (isset($_POST['wmc_restore_default']) && $_POST['wmc_restore_default']) {
        $do_not_save = array('wmc_merge_order_payment_tabs', 'wmc_zipcode_validation', 'wmc_email_error', 'wmc_phone_error', 'wmc_empty_error', 'wmc_add_coupon_form', 'wmc_add_register_form');
        foreach ($_POST as $option_name => $option_value) {
            if (in_array($option_name, $do_not_save))
                continue;
            delete_option($option_name);
        }
    }
    ?>
    <div class="updated"><p><strong><?php _e('settings saved.', 'woocommerce-multistep-checkout'); ?></strong></p></div>
    <?php
}
?>
<div class="wrapper">
    <div id="icon-edit" class="icon32"></div><h2><?php _e('WooCommerce MultiStep-Checkout', 'woocommerce-multistep-checkout') ?></h2>
    <form name="wccheckout_options" method="post" action="">
        <input type="hidden" name="send_form" value="Y">
        <table class="form-table">

            <tr>
                <td><?php _e('Wizard Type', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_wizard_type">
                        <option value="elegant" <?php selected(get_option('wmc_wizard_type'), 'elegant', true); ?>><?php _e('Elegant', 'woocommerce-multistep-checkout') ?></option>
                        <option value="classic" <?php selected(get_option('wmc_wizard_type'), 'classic', true); ?>><?php _e('Classic', 'woocommerce-multistep-checkout') ?></option>
                        <option value="modern" <?php selected(get_option('wmc_wizard_type'), 'modern', true); ?>><?php _e('Modern', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Select the type of Wizard', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Add Login to Wizard', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_add_login_form">
                        <option value="true" <?php selected(get_option('wmc_add_login_form'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                        <option value="false" <?php selected(get_option('wmc_add_login_form'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Add Login form to wizard', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Add Registration to Wizard', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_add_register_form">                            
                        <option value="false" <?php selected(get_option('wmc_add_register_form'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                        <option value="true" <?php selected(get_option('wmc_add_register_form'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Registration form will added into wizard (Registration form will be shown only if Login form is part of wizard)', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Add Coupon to Wizard', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_add_coupon_form">
                        <option value="true" <?php selected(get_option('wmc_add_coupon_form'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>                                                        
                        <option value="false" <?php selected(get_option('wmc_add_coupon_form'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Add Coupon form to wizard', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Combine Billing & shipping', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_merge_billing_shipping_tabs">
                        <option value="true" <?php selected(get_option('wmc_merge_billing_shipping_tabs'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                        <option value="false" <?php selected(get_option('wmc_merge_billing_shipping_tabs'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('If you want to combine Billing and Shipping steps then set this to "Yes"', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Combine order Infomation and Payment Steps', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_merge_order_payment_tabs">
                        <option value="true" <?php selected(get_option('wmc_merge_order_payment_tabs'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                        <option value="false" <?php selected(get_option('wmc_merge_order_payment_tabs'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('If you want to combine Order information and Payment steps then set this to "Yes"', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Product Thumbnail', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_show_product_thumbnail">
                        <option value="false" <?php selected(get_option('wmc_show_product_thumbnail'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                        <option value="true" <?php selected(get_option('wmc_show_product_thumbnail'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Show product thumbnail in the order information table', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Animation', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_animation">
                        <option value="fade" <?php selected(get_option('wmc_animation'), 'fade', true); ?>><?php _e('Fade', 'woocommerce-multistep-checkout') ?></option>
                        <option value="slide" <?php selected(get_option('wmc_animation'), 'slide', true); ?>><?php _e('Slide', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Select the type of animation', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>


            <tr>
                <td><?php _e('Orientation', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_orientation">
                        <option value="horizontal" <?php selected(get_option('wmc_orientation'), 'horizontal', true); ?>><?php _e('Horizontal', 'woocommerce-multistep-checkout') ?></option>
                        <option value="vertical" <?php selected(get_option('wmc_orientation'), 'vertical', true); ?>><?php _e('Vertical', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Vertical orientation is not applicable to Modern wizard type', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Enable Pagination', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_enable_pagination">
                        <option value="true" <?php selected(get_option('wmc_enable_pagination'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                        <option value="false" <?php selected(get_option('wmc_enable_pagination'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Enable/Disable Pagination', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Remove Numbers', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_remove_numbers">
                        <option value="false" <?php selected(get_option('wmc_remove_numbers'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                        <option value="true" <?php selected(get_option('wmc_remove_numbers'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Remove Numbers From Steps', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Zip/Postcode Validation', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_zipcode_validation">
                        <option value="false" <?php selected(get_option('wmc_zipcode_validation'), 'false', true); ?>><?php _e('No', 'woocommerce-multistep-checkout') ?></option>
                        <option value="true" <?php selected(get_option('wmc_zipcode_validation'), 'true', true); ?>><?php _e('Yes', 'woocommerce-multistep-checkout') ?></option>
                    </select>
                    <span class="description"><?php _e('Zip/Postcode validation done by this plugin', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td colspan="2"><h3 style="margin: 0;padding: 0"><?php _e('Steps Customization', 'woocommerce-multistep-checkout') ?></h3></td>
            </tr>

            <tr>
                <td width="200"><?php _e('Steps Color', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_tabs_color" id="tabs_color" type="text" value="<?php echo get_option('wmc_tabs_color') ?>" class="regular-text" /><br /><span class="description"><?php _e('Select background color for active steps', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Color for inactive steps', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_inactive_tabs_color" id="inactive_tabs_color" type="text" value="<?php echo get_option('wmc_inactive_tabs_color') ?>" class="regular-text" /><br /><span class="description"><?php _e('Select background color for inactive steps', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Completed steps color', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_completed_tabs_color" id="completed_tabs_color" type="text" value="<?php echo get_option('wmc_completed_tabs_color') ?>" class="regular-text" /><br /><span class="description"><?php _e('Select background color for completed steps', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Step font color', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_font_color" id="font_color" type="text" value="<?php echo get_option('wmc_font_color') ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Select Tabs Font Color', '') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Buttons Color', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_buttons_bg_color" id="buttons_bg_color" type="text" value="<?php echo get_option('wmc_buttons_bg_color') ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Next/Previous/Login buttons color', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Buttons Font color', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_buttons_font_color" id="buttons_font_color" type="text" value="<?php echo get_option('wmc_buttons_font_color') ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Next/Previous/Login/Coupon button font color', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>


            <tr>
                <td><?php _e('Checkout form Labels', 'woocommerce-multistep-checkout') ?></td>
                <td><input name="wmc_form_labels_color" id="form_labels_color" type="text" value="<?php echo get_option('wmc_form_labels_color') ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Set Form Labels color', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>


            <tr>
                <td colspan="2"><h3 style="margin: 0;padding: 0"><?php _e('Buttons Text', 'woocommerce-multistep-checkout') ?></h3></td>
            </tr>

            <tr>
                <td><?php _e('Next Button', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_btn_next" value="<?php echo get_option('wmc_btn_next') ? get_option('wmc_btn_next') : "Next" ?>" />
                    <span class="description"><?php _e('Enter text for Next button', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Previous Button', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_btn_prev" value="<?php echo get_option('wmc_btn_prev') ? get_option('wmc_btn_prev') : "Previous" ?>" />
                    <span class="description"><?php _e('Enter text for Previous button', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Place Order Button', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_btn_finish" value="<?php echo get_option('wmc_btn_finish') ? get_option('wmc_btn_finish') : "Place Order" ?>" />
                    <span class="description"><?php _e('Enter text for Place Order Button', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('No Account Button', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_no_account_btn" value="<?php echo get_option('wmc_no_account_btn') ? stripslashes(get_option('wmc_no_account_btn')) : "I don't have an account" ?>" />
                    <span class="description"><?php _e('Enter text for No Account Button', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>




            <tr>
                <td colspan="2"><h3 style="margin: 0;padding: 0"><?php _e('Step Titles', 'woocommerce-multistep-checkout') ?></h3></td>
            </tr>

            <tr>
                <td><?php _e('Coupon', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_coupon_label" value="<?php echo get_option('wmc_coupon_label') ? get_option('wmc_coupon_label') : "Coupon" ?>" />
                    <span class="description"><?php _e('Enter text for Coupon label', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Billing', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_billing_label" value="<?php echo get_option('wmc_billing_label') ? get_option('wmc_billing_label') : "Billing" ?>" />
                    <span class="description"><?php _e('Enter text for Billing label', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Shipping', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_shipping_label" value="<?php echo get_option('wmc_shipping_label') ? get_option('wmc_shipping_label') : "Shipping" ?>" />
                    <span class="description"><?php _e('Enter text for Shipping label', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Billing & Shipping', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_billing_shipping_label" value="<?php echo get_option('wmc_billing_shipping_label') ? get_option('wmc_billing_shipping_label') : "Billing & Shipping" ?>" />
                    <span class="description"><?php _e('Text for combined Billing & Shipping step', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Order Information', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_orderinfo_label" value="<?php echo get_option('wmc_orderinfo_label') ? get_option('wmc_orderinfo_label') : "Order Information" ?>" />
                    <span class="description"><?php _e('Enter text for Order Information label', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Payment Info', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_paymentinfo_label" value="<?php echo get_option('wmc_paymentinfo_label') ? get_option('wmc_paymentinfo_label') : "Payment Info" ?>" />
                    <span class="description"><?php _e('Enter text for Payment Info label', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td colspan="2"><h3 style="margin: 0;padding: 0"><?php _e('Error Messages', 'woocommerce-multistep-checkout') ?></h3></td>
            </tr>
            <tr>
                <td><?php _e('Empty Fields', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_empty_error" value="<?php echo get_option('wmc_empty_error') ?>" />
                    <span class="description"><?php _e('Enter text for empty field error', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Invalid E-mail', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_email_error" value="<?php echo get_option('wmc_email_error'); ?>" />
                    <span class="description"><?php _e('Enter text for invalid email error', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Invalid Phone', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_phone_error" value="<?php echo get_option('wmc_phone_error') ?>" />
                    <span class="description"><?php _e('Enter text for invalid phone number error', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Terms and condition', 'woocommerce-multistep-checkout') ?></td>
                <td>
                    <input type="text" name="wmc_terms_error" value="<?php echo get_option('wmc_terms_error') ?>" />
                    <span class="description"><?php _e('Enter text for Terms & Conditions error', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td colspan="2"><h3 style="margin: 0;padding: 0"><?php _e('Code Location', 'woocommerce-multistep-checkout') ?></h3></td>
            </tr>

            <tr>
                <td><?php _e('Add wizard code to theme', 'woocommerce-multistep-checkout') ?></td>
                <td><select name="wmc_add_code_footer">
                        <option value="false" <?php selected(get_option('wmc_add_code_footer'), 'false', true); ?>><?php _e('Header', 'woocommerce-multistep-checkout') ?></option>
                        <option value="true" <?php selected(get_option('wmc_add_code_footer'), 'true', true); ?>><?php _e('Footer', 'woocommerce-multistep-checkout') ?></option>                            
                    </select>
                    <span class="description"><?php _e('Add WooCommerce Multistep JS files to Footer/Header', 'woocommerce-multistep-checkout') ?></span></td>
            </tr>

            <tr>
                <td><?php _e('Restore Plugin Defaults', 'woocommerce-multistep-checkout') ?></td>
                <td><input type="checkbox" name="wmc_restore_default" value="yes" /></td>
            </tr>

        </table>


        <p class="submit">
            <input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>

    </form>

</div>