<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$output ='';
$styles ='';
$helper_classes ='';
$value = '';
$required = '';
$required_icon = '';
$field_id = $this->_ch($element['custom_id'],'eli_f_field_id_'.$element['_id']).strtolower(str_replace(' ', '_', $element['field_label']));
$value = $this->_ch($element['field_value']);
$this->add_field_css($element);
$field_tyle = 'text';
?>
<div class="eli_f_group recaptcha eli_f_group_el_<?php echo esc_attr($element['_id']);?>">
    <?php if(empty($settings['recaptcha_site_key']) || empty($settings['recaptcha_secret_key'])):?>
    <div class="eli_alert eli_alert-info" role="alert">
      <?php esc_html_e( 'Please configurate recaptcha', 'elementinvader-addons-for-elementor' );?>
    </div>
    <?php return false; endif;?>
    <?php
    // Properly enqueue Google reCAPTCHA script
    if ( ! wp_script_is( 'google-recaptcha', 'enqueued' ) && ! wp_script_is( 'google-recaptcha', 'done' ) ) {
        wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true );
    }
    ?>
    <?php
    static $called = 0;
    static $recaptcha_array = array();
    global $eli_recaptcha_init;
    global $eli_recaptcha_called;

    if(isset($settings['recaptcha_version_3']) &&  $settings['recaptcha_version_3'] == 'yes') {
      ?>
          <div class="eli_alert eli_alert-info" role="alert">
            <?php esc_html_e( 'Recaptcha version 3 not use accept checkbox, you can remove it field', 'elementinvader-addons-for-elementor' );?>
          </div></div>  
      <?php
      return false;
    } elseif(!isset($eli_recaptcha_called))
    {
        if ( ! wp_script_is( 'google-recaptcha-custom', 'enqueued' ) && ! wp_script_is( 'google-recaptcha-custom', 'done' ) ) {
            wp_register_script(
                'google-recaptcha-custom',
                'https://www.google.com/recaptcha/api.js?onload=CaptchaCallback_' . esc_attr( $this->get_id_int() ) . '&render=explicit',
                array(),
                null,
                true
            );
            wp_enqueue_script( 'google-recaptcha-custom' );
        }
   
        $recaptcha_init = true;
    }else {
        ?>
            <div class="eli_alert eli_alert-info" role="alert">
              <?php esc_html_e( 'Only one field can be recaptcha', 'elementinvader-addons-for-elementor' );?>
            </div> </div> 
        <?php
        return false;
    }

    
    $called++;
    $compact_tag='';
    $size_tag='';

    echo '<div id="recaptcha_called_'.esc_attr($this->get_id_int()).'" class="g-recaptcha" '.esc_attr($compact_tag).' data-sitekey="'.esc_attr($settings['recaptcha_site_key']).'"></div>';
    ?>

    <script>
    var CaptchaCallback_<?php echo esc_attr($this->get_id_int());?> = function(){
         //   grecaptcha.render(document.getElementById('recaptcha_called_<?php echo esc_attr($this->get_id_int());?>'), {'size' : '',  'sitekey' : '<?php echo esc_attr($settings['recaptcha_site_key']);?>'});
   };
    </script>
</div>