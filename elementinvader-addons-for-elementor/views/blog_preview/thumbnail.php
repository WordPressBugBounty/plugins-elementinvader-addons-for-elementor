<div class="widget-eli eli_blog_preview_thumbnail" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php if($is_edit_mode):?>
        <img src="<?php echo ELEMENTINVADER_ADDONS_FOR_ELEMENTOR_URL;?>/assets/img/placeholder.jpg" alt="">
    <?php else:?>
        <?php
        // Get the post thumbnail of 'medium' size
        $post_thumbnail = get_the_post_thumbnail($eli_post_id, 'full');

        // Check if the post has a thumbnail
        if ($post_thumbnail) {
            // Display the post thumbnail
            echo $post_thumbnail;
        } else {
            // Post does not have a thumbnail
            echo '<img src="'.ELEMENTINVADER_ADDONS_FOR_ELEMENTOR_URL.'/assets/img/placeholder.jpg" alt="">';
        }
    ?>
    <?php endif?>
    <?php if(!empty($settings['link_enabled'])):?>
    <a href="<?php echo esc_url(get_permalink($eli_post_id)); ?>" class="complete"></a>
    <?php endif;?>
</div>
