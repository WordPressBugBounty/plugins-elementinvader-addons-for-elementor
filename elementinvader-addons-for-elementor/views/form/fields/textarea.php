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
if($element['required']){
    $required = 'required="required"';
    $required_icon = '*';
}

if($element['label_position'] == 'inline'){
    $helper_classes .='inline';
}

$field_name = $element['field_id'];

if(empty($field_name)) {
    $field_name = $element['field_label'];
} 

if(empty($field_name)) {
    $field_name = $element['placeholder'];
} 

if(empty($field_name)) {
    $field_name = 'field_id_'.$element['_id'];
} 
?>
<div class="eli_f_group eli_f_group_el_<?php echo esc_attr($element['_id']); ?> <?php echo esc_attr($helper_classes); ?>" style="<?php echo esc_attr($styles); ?>">

<?php if (!empty($element['show_label'])) : ?>
    <label for="<?php echo esc_attr($field_id); ?>">
        <?php echo esc_html($element['field_label']); ?>
        <?php echo esc_html($required_icon); ?>
    </label>
<?php endif; ?>

<textarea
    name="<?php echo esc_attr($field_name); ?>"
    id="<?php echo esc_attr($field_id); ?>"
    rows="<?php echo esc_attr($element['rows']); ?>"
    class="eli_f_field"
    <?php echo wp_kses_post($required); ?>
    placeholder="<?php echo esc_attr($element['placeholder']); ?>"
><?php echo esc_textarea($value); ?></textarea>

</div>