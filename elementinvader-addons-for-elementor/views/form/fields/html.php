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

$field_tyle = 'html';
?>

<div class="eli_f_group <?php echo esc_attr($field_tyle); ?> eli_f_group_el_<?php echo esc_attr($element['_id']); ?> <?php echo esc_attr($helper_classes); ?>" style="<?php echo esc_attr($styles); ?>">

    <?php echo wp_kses_post($element['field_html']); ?>

</div>