<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$styles = '';
$helper_classes = '';

$field_id = $this->_ch(
    $element['custom_id'],
    'eli_f_field_id_' . $element['_id']
) . strtolower(str_replace(' ', '_', $element['field_label']));

$value = $this->_ch($element['field_value']);

$this->add_field_css($element);

$required = '';
$required_icon = '';

if (!empty($element['required'])) {
    $required = 'required="required"';
    $required_icon = '*';
}

$helper_attr = '';

if (!empty($element['allow_multiple'])) {
    $helper_attr .= 'multiple="multiple" ';
    $helper_attr .= 'size="' . esc_attr($this->_ch($element['select_size'], 3)) . '" ';
    $helper_attr .= 'style="height:' . esc_attr($this->_ch($element['select_height']['size'], 80)) . 'px" ';
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
?>

<div class="eli_f_group eli_f_group_el_<?php echo esc_attr($element['_id']); ?> <?php echo esc_attr($helper_classes); ?>" style="<?php echo esc_attr($styles); ?>">

    <?php if (!empty($element['show_label'])) : ?>
        <label for="<?php echo esc_attr($field_id); ?>">
            <?php echo esc_html($element['field_label']); ?>
            <?php echo esc_html($required_icon); ?>
        </label>
    <?php endif; ?>

    <select
        name="<?php echo esc_attr($field_name); ?>"
        id="<?php echo esc_attr($field_id); ?>"
        class="eli_f_field"
        <?php echo wp_kses_post($helper_attr); ?>
        <?php echo wp_kses_post($required); ?>
    >

        <?php
        $options = explode('|', $element['field_options']);

        foreach ($options as $option) :
            $option = trim($option);

            if ($option === '') {
                continue;
            }
        ?>

            <option value="<?php echo esc_attr($option); ?>">
                <?php echo esc_html($option); ?>
            </option>

        <?php endforeach; ?>

    </select>

</div>