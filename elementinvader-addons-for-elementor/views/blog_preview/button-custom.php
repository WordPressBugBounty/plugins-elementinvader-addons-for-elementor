<div class="widget-eli eli_blog_preview_button" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <a href="<?php echo $this->set_dinamic_field($eli_post_id, $settings['config_fields_meta']); ?>" class="eli_blog_preview_button--btn">
        <?php if ($settings['link_icon_position'] == 'left') : ?>
            <?php \Elementor\Icons_Manager::render_icon($settings['btn_icon'], ['aria-hidden' => 'true', 'class' => 'icon-left']); ?>
        <?php endif; ?>
        <?php echo esc_html($settings['view_btn_text']); ?>
        <?php if ($settings['link_icon_position'] == 'right') : ?>
            <?php \Elementor\Icons_Manager::render_icon($settings['btn_icon'], ['aria-hidden' => 'true', 'class' => 'icon-right']); ?>
        <?php endif; ?>
    </a>
</div>