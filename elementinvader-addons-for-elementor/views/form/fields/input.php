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
if($element['required']){
    $required = 'required="required"';
    $required_icon = '*';
}
if($element['label_position'] == 'inline'){
    $helper_classes .='inline';
}
switch ( $element['field_type'] ){
        case 'number':
            $field_tyle = 'number';
            break;
        case 'tel':
            $field_tyle = 'tel';
            break;
        case 'text':
            $field_tyle = 'text';
            break;
        case 'email':
            $field_tyle = 'email';
            break;
        case 'url':
            $field_tyle = 'url';
            break;
        case 'password':
            $field_tyle = 'password';
            break;
        case 'file':
            $field_tyle = 'password';
            break;
        case 'hidden':
            $field_tyle = 'hidden';
            break;
        case 'date':
            $field_tyle = 'date';
            break;
        case 'time':
            $field_tyle = 'time';
            break;
        case 'upload':
            $field_tyle = 'file';
            break;
        case 'subject':
            $field_tyle = 'text';
            break;
        case 'search':
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

<?php if ($field_tyle === 'hidden') : ?>

    <input
        name="<?php echo esc_attr($element['field_label']); ?>"
        id="<?php echo esc_attr($field_id); ?>"
        type="hidden"
        class="eli_f_field"
        <?php echo wp_kses_post($required); ?>
        value="<?php echo esc_attr($value); ?>"
    >

<?php else : ?>

    <div class="eli_f_group <?php echo esc_attr($field_tyle); ?> eli_f_group_el_<?php echo esc_attr($element['_id']); ?> <?php echo esc_attr($helper_classes); ?>"
         style="<?php echo esc_attr($styles); ?>">

        <?php if (!empty($element['show_label'])) : ?>
            <label for="<?php echo esc_attr($field_id); ?>">
                <?php echo esc_html($element['field_label']); ?>
                <?php echo esc_html($required_icon); ?>
            </label>
        <?php endif; ?>

        <?php if (!empty($element['field_hint'])) : ?>
            <i class="hint"><?php echo esc_html($element['field_hint']); ?></i>
        <?php endif; ?>

        <input
            <?php if (!empty($element['custom_validation_message'])) : ?>
                oninvalid="this.setCustomValidity('<?php echo esc_js($element['custom_validation_message']); ?>')"
            <?php endif; ?>

            <?php
            if (!empty($element['field_type']) && $element['field_type'] === 'subject') {
                $element['field_label'] = 'custom_subject';
            }
            ?>

            name="<?php echo esc_attr($field_name); ?>"
            id="<?php echo esc_attr($field_id); ?>"
            type="<?php echo esc_attr($field_tyle); ?>"
            class="eli_f_field"
            <?php echo wp_kses_post($required); ?>
            value="<?php echo esc_attr($value); ?>"
            placeholder="<?php echo esc_attr($element['placeholder']); ?>"
        >

    </div>

<?php endif; ?>