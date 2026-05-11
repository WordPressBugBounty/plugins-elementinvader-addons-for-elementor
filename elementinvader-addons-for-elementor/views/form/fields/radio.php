<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$styles = '';
$helper_classes = '';

$field_id = $this->_ch(
    $element['custom_id'],
    'eli_f_field_id_' . $element['_id']
) . strtolower(str_replace(' ', '_', $element['field_label']));

$this->add_field_css($element);

if (!empty($element['required'])) {
    $required = 'required="required"';
    $required_icon = '*';
} else {
    $required = '';
    $required_icon = '';
}

if (!empty($element['label_position']) && $element['label_position'] === 'inline') {
    $helper_classes .= ' inline';
}

$field_name = $element['field_id'];

if (empty($field_name)) {
    $field_name = $element['field_label'];
}

if (empty($field_name)) {
    $field_name = $element['placeholder'];
}

if (empty($field_name)) {
    $field_name = 'field_id_' . $element['_id'];
}

$options = explode("\n", $element['field_options']);

foreach ($options as $option_line) {

    $option_line = trim($option_line);
    if ($option_line === '') {
        continue;
    }

    $parts = explode('|', $option_line, 2);

    $label = trim($parts[0]);
    $value = isset($parts[1]) ? trim($parts[1]) : $label;

    ?>
    
    <div class="eli_f_group checkbox eli_f_group_el_<?php echo esc_attr($element['_id']); ?>" style="<?php echo esc_attr($styles); ?>">

        <label for="<?php echo esc_attr($field_id . '_' . $value); ?>">

            <input
                name="<?php echo esc_attr($field_name); ?>"
                id="<?php echo esc_attr($field_id . '_' . $value); ?>"
                type="radio"
                class="eli_f_field_checkbox"
                value="<?php echo esc_attr($value); ?>"
            >

            <?php echo esc_html($label); ?>

        </label>

    </div>

    <?php
}
?>