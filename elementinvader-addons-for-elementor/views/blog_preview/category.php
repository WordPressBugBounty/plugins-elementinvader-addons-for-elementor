<div class="widget-eli eli_blog_preview_category" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php if($is_edit_mode):?>
        <?php if($settings['is_link'] == 'yes'):?>
            <a href="#" class="category"><?php echo esc_html__('This is example category', 'elementinvader-addons-for-elementor');?> </a>
        <?php else:?>
            <span class="category"><?php echo esc_html__('This is example category', 'elementinvader-addons-for-elementor');?> </span>
        <?php endif?>
    <?php else:?>
        <?php
            $categories = get_the_category($eli_post_id);

            if(empty($categories)){
                $categories = wp_get_post_terms($eli_post_id, 'product_cat');
            }

            foreach ($categories as $category) {
                $cat_link = get_category_link($category->term_id);
                $cat_name = $category->name;

                if($settings['is_link'] == 'yes'):
                    echo '<a href="' . esc_url($cat_link) . '">' . esc_html($cat_name) . '</a>';
                else:
                    echo '<span>' . esc_html($cat_name) . '</span>';
                endif;
            }
        ?>
    <?php endif?>
</div>