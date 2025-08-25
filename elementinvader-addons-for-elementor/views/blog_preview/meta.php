<div class="widget-eli eli_blog_preview_meta" id="eli_<?php echo esc_html($this->get_id_int());?>">
<?php if(!empty($settings['link_enabled'])):?>
    <a href="<?php echo esc_url(get_permalink($eli_post_id)); ?>">
    <?php endif?>
    <?php if($is_edit_mode):?>
        <?php echo esc_html__('This is example meta', 'elementinvader-addons-for-elementor');?>
    <?php else:?>
        <?php echo $this->set_dinamic_field($eli_post_id, $settings['config_fields_title']); ?>
    <?php endif?>
    <?php if(!empty($settings['link_enabled'])):?>
    </a>
    <?php endif?>
</div>