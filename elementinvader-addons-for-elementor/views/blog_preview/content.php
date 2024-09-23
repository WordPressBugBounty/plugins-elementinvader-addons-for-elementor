<div class="widget-eli eli_blog_preview_content" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php if($is_edit_mode):?>
        <?php echo esc_html__('This is example content', 'elementinvader-addons-for-elementor');?> 
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
    <?php else:?>
        <?php echo wp_kses_post(apply_filters('the_content', get_post($eli_post_id)->post_content));?>
    <?php endif?>
</div>
