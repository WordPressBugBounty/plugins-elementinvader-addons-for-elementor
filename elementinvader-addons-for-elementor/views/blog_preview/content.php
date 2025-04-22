<div class="widget-eli eli_blog_preview_content" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php
        if($is_edit_mode) {
            $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ';
        } else {
            $content = get_post($eli_post_id)->post_content;
            $content = strip_tags(strip_shortcodes($content));
        }

		if(!empty($settings['text_limit'])) {
			echo (wp_strip_all_tags(html_entity_decode(wp_trim_words(htmlentities(wpautop($content)), $settings['text_limit'], '...'))));
		} else {
			echo wp_strip_all_tags(html_entity_decode(htmlentities(wpautop($content))));
		}

    ?>
</div>
