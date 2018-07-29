<?php
if (is_checkout() || defined('ICL_LANGUAGE_CODE')):
    $wizard_type = get_option('wmc_wizard_type');
    ?>

    <?php if ($wizard_type == 'classic' || $wizard_type == 'elegant' || $wizard_type == '') { //if this is a classic wizard type            ?>
        <style>

            .wizard > .steps .current a, .wizard > .steps .current a:hover{
                background: <?php echo get_option('wmc_tabs_color') ?>;
                color: <?php echo get_option('wmc_font_color') ?>;
            }

            .wizard > .steps .disabled a{
                background: <?php echo get_option('wmc_inactive_tabs_color') ?>;
            }

            .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active, #wizard form.login input.button, #wizard .checkout_coupon .button, #wizard .woocommerce-Button{
                background: <?php echo get_option('wmc_buttons_bg_color') ?>;
                color: <?php echo get_option('wmc_buttons_font_color') ?>;
            }
            .wizard > .steps .done a{
                background: <?php echo get_option('wmc_completed_tabs_color') ?>;
            }
            .wizard > .content{
                background: <?php echo get_option('wmc_wrapper_bg') ?>;
            }

            .woocommerce form .form-row label, .woocommerce-page form .form-row label, .woocommerce-checkout .shop_table, .woocommerce table.shop_table tfoot th,
            .woocommerce table.shop_table th, .woocommerce-page table.shop_table th, #ship-to-different-address
            {
                color: <?php echo get_option('wmc_form_labels_color') ?>;
            }

        </style>

    <?php } else { //if modern wizard
        ?>
        <style>
        <?php if (get_option('wmc_tabs_color')): ?>
                .wizard > .steps li.current a:before{
                    border-bottom: 30px solid <?php echo get_option('wmc_tabs_color') ?>;
                    border-top: 30px solid <?php echo get_option('wmc_tabs_color') ?>
                }
                .wizard > .steps li.current a:after{
                    border-left: 20px solid <?php echo get_option('wmc_tabs_color') ?>
                }                 
                .wizard > .steps li.current a{
                    background-color: <?php echo get_option('wmc_tabs_color') ?>
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                    
        <?php if (get_option('wmc_buttons_bg_color')): ?>
                .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active, .login .form-row .button{
                    background: <?php echo get_option('wmc_buttons_bg_color') ?>;
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                            
        <?php if (get_option('wmc_buttons_font_color')): ?>
                .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active, #wizard form.login input.button{
                    color: <?php echo get_option('wmc_buttons_font_color') ?>;
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                
        <?php if (get_option('wmc_inactive_tabs_color')): ?>
                .wizard > .actions .disabled a{
                    background: <?php echo get_option('wmc_inactive_tabs_color') ?>
                }

                .wizard > .steps a:before {
                    border-bottom: 30px solid <?php echo get_option('wmc_inactive_tabs_color') ?>;
                    border-top: 30px solid <?php echo get_option('wmc_inactive_tabs_color') ?>;
                }

                .wizard > .steps a:after{
                    border-left: 20px solid <?php echo get_option('wmc_inactive_tabs_color') ?>;
                }

                .wizard > .steps a{
                    background-color: <?php echo get_option('wmc_inactive_tabs_color') ?>;
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                    
        <?php if (get_option('wmc_font_color')): ?> 
                .wizard > .steps li.current a{
                    color: <?php echo get_option('wmc_font_color') ?>
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                    
        <?php if (get_option('wmc_buttons_bg_color')): ?> 
                .wizard > .actions a, #wizard .checkout_coupon .button, #wizard .checkout_coupon .button, #wizard form.login input.button, #wizard .woocommerce-Button{
                    background-color: <?php echo get_option('wmc_buttons_bg_color') ?>
                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                    
        <?php if (get_option('wmc_completed_tabs_color')): ?> 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                .wizard > .steps li.done a:before {
                    border-bottom: 30px solid <?php echo get_option('wmc_completed_tabs_color') ?>;
                    border-top: 30px solid <?php echo get_option('wmc_completed_tabs_color') ?>;
                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                .wizard > .steps li.done a:after{
                    border-left: 20px solid <?php echo get_option('wmc_completed_tabs_color') ?>;
                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                .wizard > .steps li.done a{
                    background-color: <?php echo get_option('wmc_completed_tabs_color') ?>;
                }
        <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                    
        <?php if (get_option('wmc_form_labels_color')): ?> 
                .woocommerce form .form-row label, .woocommerce-page form .form-row label, .woocommerce-checkout .shop_table, .woocommerce table.shop_table tfoot th,
                .woocommerce table.shop_table th, .woocommerce-page table.shop_table th, #ship-to-different-address
                {
                    color: <?php echo get_option('wmc_form_labels_color') ?>;
                }
        <?php endif; ?>
        </style>
        <?php
    }
    endif;