<div class="widget-eli eli_blog" id="eli_<?php echo esc_html($this->get_id_int());?>">
    <?php if($wp_query->have_posts()):?>
    <div class="eli_row <?php if($settings['masonry_enable'] == 'yes'):?> masonry <?php endif;?> <?php if($settings['is_mobile_view_enable'] == 'yes'):?> EliScrollMobileSwipe_enable <?php endif;?>">
        <?php
        $date_format = get_option('date_format');
        while ($wp_query->have_posts()) : $wp_query->the_post(); 
        $helper_style = '';
        ?>
        <div class="eli_col" style="<?php echo wp_kses_post($helper_style);?>">
            <div class=" elementor-clickable eliblog-card <?php if($settings['thumbnail_cover'] == 'yes'):?> cover <?php endif;?> <?php if($settings['thumbnail_fixed_size'] == 'yes'):?> fixed-size <?php endif;?>"
                <?php if(isset($settings['is_popup_enable']) && $settings['is_popup_enable'] == 'yes'):?>
                data-eli-toggle="modal" data-eli-target="#eli_popup_modal_<?php echo esc_html($this->get_id_int());?>_<?php echo esc_html(get_the_ID()); ?>"
                <?php endif;?>
                >
                <div class="eliblog-card-content">
                    <div class="eliblog-card-title-box">
                        <h2 class="eliblog-card-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title(); ?>"><?php echo $this->set_dinamic_field(get_the_ID(), $settings['config_fields_title'], get_the_title()); ?></a></h2>
                    </div>
                    <div class="eliblog-card-subtitle-box">
                        <span class="eliblog-card-subtitle">
                            <?php
                                // If we have a single page and the author bio exists, display it
                                echo $this->set_dinamic_field(get_the_ID(), $settings['config_fields_subtitle']);
                            ?>
                        </span>
                    </div>
                    <div class="eliblog-card-date-box">
                        <span class="eliblog-card-date">
                            <?php echo get_the_date( '', get_the_ID() ); ?>
                        </span>
                    </div>
                    <div class="eliblog-card-meta-box">
                        <ul class="eli-post-meta">
                            <li class="calendar"><i class="fa fa-calendar"></i><?php echo get_the_date($date_format) ?></li>
                            <?php if(have_comments()):?>
                                <li class="comment"><i class="fa fa-comment-o"></i><a href="<?php the_permalink(); ?>#comment-form" title="<?php echo esc_attr__('Comment', 'elementinvader-addons-for-elementor'); ?>"><?php comments_number(); ?></a></li>
                            <?php endif;?>
                            <li class="user">
                                <?php
                                    printf(
                                        '<i class="fa fa-user-o"></i><a href="%1$s" class="">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), get_the_author()
                                    );
                                ?>
                            </li>
                            <?php
                            if (has_tag()) {
                                $eli_tags = wp_get_post_tags(get_the_ID());
                                foreach ($eli_tags as $eli_tag) {
                                    $eli_tag_link = get_tag_link($eli_tag->term_id);
                                    $eli_tag_name = $eli_tag->name;
                                    echo '<li class="tags"><i class="fa fa-bookmark-o"></i>';
                                    echo '<a href="' . esc_url($eli_tag_link) . '">' . esc_html($eli_tag_name) . '</a>';
                                    echo '</li>';
                                }
                            }
                            ?>
                            <?php
                            if (has_category()) {
                                $categories = get_the_category();
                                foreach ($categories as $category) {
                                    $cat_link = get_category_link($category->term_id);
                                    $cat_name = $category->name;
                                    echo '<li class="cat-link"><i class="fa fa-folder-o"></i>';
                                    echo '<a href="' . esc_url($cat_link) . '">' . esc_html($cat_name) . '</a>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="eliblog-card-text-box">
                        <?php
                        $content = get_the_excerpt();
                        $content = strip_tags(strip_shortcodes($content));
                        echo (wp_strip_all_tags(html_entity_decode(wp_trim_words(htmlentities(wpautop($content)), $settings['text_limit'], '...'))));
                        ?>
                    </div>
                    <div class="eliblog-card-btn-box"><a href="<?php echo esc_url( get_permalink() ); ?>" class="eliblog-card-view"><?php echo esc_html($settings['style_options_view_btn_text']);?></a></div>
                </div>
                <div class="eliblog-card-thumbnail">
                    <?php
                    if (has_category()) {
                        $categories = get_the_category();
                        foreach ($categories as $category) {
                            $cat_link = get_category_link($category->term_id);
                            $cat_name = $category->name;
                            ?>
                            <span class="label"><?php echo esc_html($cat_name);?></span>
                            <?php break;
                        }
                    }
                    ?>
                    <?php
                    if (has_post_thumbnail() && !post_password_required()) :
                        ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="">
                            <figure class="entry-thumbnail entry-thumbnail-full">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                            <?php
                            ?>
                        </a>
                    <?php else: ?>
                        <img src="<?php echo ELEMENTINVADER_ADDONS_FOR_ELEMENTOR_URL;?>/assets/img/placeholder.jpg" alt="">
                    <?php endif; ?>

                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="hover_link  elementor-clickable"
                        <?php if(isset($settings['is_popup_enable']) && $settings['is_popup_enable'] == 'yes'):?>
                            data-eli-toggle="modal" data-eli-target="#eli_popup_modal_<?php echo esc_html($this->get_id_int());?>_<?php echo esc_html(get_the_ID()); ?>"
                        <?php endif;?>
                    ></a>
                </div>
                
                <?php if(isset($settings['is_complete_link']) && $settings['is_complete_link'] == 'yes'):?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="complete_hover_link"></a>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($settings['is_popup_enable']) && $settings['is_popup_enable'] == 'yes'):?>
        <div class="eli-modal wkd-fade eli-search-popup-modal elementor-clickable nodetach eli_popup_modal_preview eli_popup_modal_<?php echo esc_html($this->get_id());?>" id="eli_popup_modal_<?php echo esc_html($this->get_id_int());?>_<?php echo esc_html(get_the_ID()); ?>" tabindex="-1" role="dialog"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-notice">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-eli-dismiss="modal" aria-hidden="true" >
                            <span class="dashicons dashicons-no-alt"></span>
                        </button>
                    <?php if(!empty($settings['popup_layout'])):?>
                    <?php
                        $content = '';
                        global $eli_post_id;
                        $eli_post_id = get_the_ID();

                        $post_data = get_post($settings['popup_layout']);
                        if($post_data){
                            if (!$post_data || $post_data->post_status != 'publish' || post_password_required($post_data)) {
                                $content = esc_html__( 'Page is not public', 'elementinvader-addons-for-elementor' );
                            } else {
                                if($post_data->post_type == 'page' || $post_data->post_type == 'elementor_library') {
                                    $elementor_instance = \Elementor\Plugin::instance();
                                    $content = $elementor_instance->frontend->get_builder_content_for_display($settings['popup_layout']);
                                    if(empty($content ))
                                        $content = $post_data->post_content;
                                } else {
                                    $content = $post_data->post_content;
                                }
                            }
                                if($is_edit_mode) {
                                    echo ($content);
                                } else { 
                                    echo wp_kses_post($content);
                                }
                           
                        }
                    ?>
                    <?php else: ?>
                        <div class="elementinvader_addons_for_elementor_alert elementinvader_addons_for_elementor_alert-danger" role="alert">
                            <?php esc_html_e( 'Please create Layout and attache in elementor option Popup Layout', 'elementinvader-addons-for-elementor' );?>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endwhile; ?>
    </div>
    <?php  if($settings['is_pagination_enable'] == 'yes'):?>
    <div class="col-lg-12">
        <div class="load-more-posts-grid">
            <nav class="navigation pagination eli-pagination" role="navigation">
                <div class="nav-links">
                <?php
                    echo paginate_links( array(
                            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'total'        => $wp_query->max_num_pages,
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'format'       => '?paged=%#%',
                            'prev_text' => '<<',
                            'next_text' => '>>'
                    ) );
                ?>
                </div>
            </nav>
        </div><!--load-more-posts end-->
    </div>
    <?php endif;?>
    <?php else:?>
        <div class="elementinvader_addons_for_elementor_alert elementinvader_addons_for_elementor_alert-danger" role="alert">
            <?php esc_html_e( 'Posts not found', 'elementinvader-addons-for-elementor' );?>
        </div>
    <?php endif;?>

    
    <?php if($is_edit_mode):?>
    <script>
    jQuery(document).ready(function($) {
        eli_log_modal();
    });
    </script>
    <?php endif;?>
</div>
