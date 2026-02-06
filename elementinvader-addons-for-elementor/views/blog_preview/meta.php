<div class="widget-eli eli_blog_preview_meta" id="eli_<?php echo esc_html($this->get_id_int());?>">
<?php if(!empty($settings['link_enabled'])):?>
    <a href="<?php echo esc_url(get_permalink($eli_post_id)); ?>">
    <?php endif?>
    <?php if($is_edit_mode):?>
        <?php echo esc_html__('This is example meta', 'elementinvader-addons-for-elementor');?>
    <?php else:?>
        <?php 
        $meta_value = $this->set_dinamic_field($eli_post_id, $settings['config_fields_title']);
        if (is_array($meta_value)) {
            echo '<ul class="eli-meta-list">';
            foreach ($meta_value as $item) {
                echo '<li>' . wp_kses_post($item) . '</li>';
            }
            echo '</ul>';
        } else {
            echo wp_kses_post($meta_value); 
        }
        ?>
    <?php endif?>
    <?php if(!empty($settings['link_enabled'])):?>
    </a>
    <?php endif?>
</div>