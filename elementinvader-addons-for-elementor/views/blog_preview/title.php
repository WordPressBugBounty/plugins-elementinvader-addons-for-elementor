<div class="widget-eli eli_blog_preview_title" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php if($is_edit_mode):?>
        <?php echo esc_html__('This is example title', 'elementinvader-addons-for-elementor');?> 
    <?php else:?>
        <?php echo wp_kses_post(get_the_title($eli_post_id));?>
    <?php endif?>
</div>