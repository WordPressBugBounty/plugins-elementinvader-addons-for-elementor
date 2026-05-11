<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$eli_helper_button_class = '';
$eli_helper_button_class .= ' '.$this->get_align_class($settings['button_align']);
$eli_helper_button_class .= ' '.$this->get_align_class($settings['button_align_tablet'],'tablet_');
$eli_helper_button_class .= ' '.$this->get_align_class($settings['button_align_mobile'],'phone_');
?>
<div class="widget-elementinvader_addons_for_elementor elementinvader_contact_form contact-form" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <div class="eli-container elementinvader_addons_for_elementor-container">
        <form class="eli_f eli_f_container elementinvader_addons_for_elementor_f" <?php if(isset($settings['disable_scroll_to_form']) && $settings['disable_scroll_to_form'] == 'yes'):?> scroll-disabled="disabled"<?php endif;?>>
            <input type="hidden" name="element_id" value="<?php echo esc_attr($this->get_id_int());?>"/>
            <input type="hidden" name="eli_token" value="<?php echo esc_attr(eli_generate_form_token()); ?>">
            
            <?php
            // Add a nonce field for AJAX security
            wp_nonce_field( 'eli_forms_send_form', 'eli_nonce' );
            ?>
            
            <input type="hidden" name="eli_id" value="<?php echo esc_attr($this->get_id());?>"/>
            <input type="hidden" name="eli_type" value="<?php echo esc_attr($this->get_name());?>"/>
            <?php
                $post_id = get_the_ID();
                $post_object_id = get_queried_object_id();
                if($post_object_id)
                    $post_id = $post_object_id;
                    
                global $wdk_listing_page_id;
                if(!empty($wdk_listing_page_id))
                    $post_id = $wdk_listing_page_id;
                
            
               $document = \Elementor\Plugin::$instance->documents->get_current();
                if ( $document && method_exists( $document, 'get_main_id' ) ) {
                    $post_id = $document->get_main_id();
                } 

            ?>
            <input type="hidden" name="eli_page_id" value="<?php echo esc_attr($post_id);?>"/>
            <?php if(isset($settings['send_action_type'])):?>
                <?php if(!empty($settings['send_action_mailchimp_api_key']) && !empty($settings['send_action_mailchimp_list_id'])):?>
                    <input type="hidden" name="send_action_type" value="mail_base,mailchimp"/>
                <?php else:?>
                    <input type="hidden" name="send_action_type" value="mail_base"/>
                <?php endif;?>
            <?php endif;?>
            
            <div class="config" data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"></div>
            <?php if(!isset($settings['alert_box_bellow_form']) || (isset($settings['alert_box_bellow_form']) && $settings['alert_box_bellow_form'] != 'yes')):?>
                <?php if($settings['show_alerts_example']):?>
                <div class="eli_f_box_alert">
                    <div class="eli_alert eli_alert-primary" role="alert">
                      <?php esc_html_e( 'This is a primary alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                    <div class="eli_alert eli_alert-success" role="alert">
                      <?php esc_html_e( 'This is a success alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                    <div class="eli_alert eli_alert-danger" role="alert">
                      <?php esc_html_e( 'This is a danger alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                </div>
                <?php endif;?>
                <div class="eli_f_box_alert"></div>
            <?php endif;?>
            <div class="eli_f_container elementinvader_addons_for_elementor_f_container">
                <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is generated internally and already sanitized.
                echo $smart_data['wlisting_fields'];?>
                <div class="eli_f_group eli_f_group_el_button <?php echo esc_html($eli_helper_button_class);?>" <?php echo esc_attr($this->get_render_attribute_string( 'submit-group' )); ?>>
                    <button type="submit" <?php echo esc_attr($this->get_render_attribute_string( 'button' )); ?>>
                        <span <?php echo esc_attr($this->get_render_attribute_string( 'content-wrapper' )); ?>>
                            <?php if ( ! empty( $settings['selected_button_icon'] ) ) : ?>
                                <span <?php echo esc_attr($this->get_render_attribute_string( 'icon-align' )); ?>>
                                    <?php $this->el_icon_with_fallback( $settings ); ?>
                                    <?php if ( empty( $settings['button_text'] ) ) : ?>
                                        <span class="elementor-screen-only"><?php esc_html_e( 'Submit', 'elementinvader-addons-for-elementor' ); ?></span>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                                    <span class="elementor-button-text"><?php echo esc_html($settings['button_text']); ?></span>
                            <?php endif; ?>
                            <i class="fa fa-spinner fa-spin fa-custom-ajax-indicator ajax-indicator-masking " style="display: none;"></i>
                        </span>
                    </button>
                </div>
            </div>
            <?php if(isset($settings['alert_box_bellow_form']) && $settings['alert_box_bellow_form'] == 'yes'):?>
                <?php if($settings['show_alerts_example']):?>
                <div class="eli_f_box_alert">
                    <div class="eli_alert eli_alert-primary" role="alert">
                      <?php esc_html_e( 'This is a primary alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                    <div class="eli_alert eli_alert-success" role="alert">
                      <?php esc_html_e( 'This is a success alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                    <div class="eli_alert eli_alert-danger" role="alert">
                      <?php esc_html_e( 'This is a danger alert—check it out!', 'elementinvader-addons-for-elementor' );?>
                    </div>
                </div>
                <?php endif;?>
                <div class="eli_f_box_alert"></div>
            <?php endif;?>

            <?php if(isset($settings['recaptcha_version_3']) && $settings['recaptcha_version_3'] == 'yes'):?>
                <input type="hidden" name="g-recaptcha-response" id="recaptcha_called_v3_<?php echo esc_html($this->get_id_int());?>">
                <?php
                // Enqueue Google reCAPTCHA v3 script only once
                if (!wp_script_is('google-recaptcha-v3', 'enqueued')) {
                    wp_enqueue_script(
                        'google-recaptcha-v3',
                        'https://www.google.com/recaptcha/api.js?render=' . esc_attr(trim($settings['recaptcha_site_key'])),
                        array(),
                        null,
                        true
                    );
                }
                ?>
      
                <script>
                (function(){
                    grecaptcha.ready(function() {
                        grecaptcha.execute('<?php echo esc_attr(trim($settings['recaptcha_site_key']));?>', {action: 'submit'}).then(function(token) {
                            document.getElementById('recaptcha_called_v3_<?php echo esc_html($this->get_id_int());?>').value = token;
                        });
                    });

                    // Reload token after form submit
                    document.querySelector('#eli_<?php echo esc_html($this->get_id_int());?> form.eli_f').addEventListener('submit', function(e) {
                        e.preventDefault();
                        grecaptcha.execute('<?php echo esc_attr(trim($settings['recaptcha_site_key']));?>', {action: 'submit'}).then(function(token) {
                            document.getElementById('recaptcha_called_v3_<?php echo esc_html($this->get_id_int());?>').value = token;
                        });
                    });
                })();
                </script>
            <?php endif;?>
        </form>
    </div>
</div>