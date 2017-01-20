<?php get_header(); // add header ?>  
<?php
    // Metadata
    $list_mag_wp_metadata_info = get_theme_mod('list_mag_wp_metadata_info');
    if (empty($list_mag_wp_metadata_info)) { $list_mag_wp_metadata_info = 'No'; }
?>

<!-- Begin Content -->
<div class="wrap-fullwidth">

    <div class="single-content">
        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
        <div class="entry-top">
            <div class="single-category"> 
                <?php the_category(' '); ?>
                <ul class="single-share">
                    <li><?php $list_mag_wp_facebooklink = 'https://www.facebook.com/sharer/sharer.php?u='; ?><a class="fbbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_facebooklink); ?><?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-facebook" aria-hidden="true"></i> <span><?php esc_html_e( 'Share on Facebook', 'list-mag-wp' ); ?></span></a></li>
                    <li><?php $list_mag_wp_twitterlink = 'https://twitter.com/home?status=Check%20out%20this%20article:%20'; ?><a class="twbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_twitterlink); ?><?php the_title(); ?>%20-%20<?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-twitter"></i></a></li>
                    <li><?php $list_mag_wp_articleimage = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?><?php $list_mag_wp_pinlink = 'https://pinterest.com/pin/create/button/?url='; ?><a class="pinbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_pinlink); ?><?php the_permalink(); ?>&amp;media=<?php echo esc_html($list_mag_wp_articleimage); ?>&amp;description=<?php the_title(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-pinterest"></i></a></li>
                    <li><?php $list_mag_wp_googlelink = 'https://plus.google.com/share?url='; ?><a class="googlebutton" target="_blank" href="<?php echo esc_url($list_mag_wp_googlelink); ?><?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li> 
                </ul><!-- end .single-share -->
            </div><!-- end .single-category -->
            <div class="clear"></div>

            <h1 class="article-title entry-title"><?php the_title(); ?></h1>
            <?php if ($list_mag_wp_metadata_info == 'Yes') { ?>
            <ul class="meta-single-content">
                <li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 24 ); ?></a></li>
                <li class="aut-name"><span class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></span></li>
                <li class="lm-space"><i class="fa fa-times"></i></li>
                <li class="time-article updated"><?php if ( function_exists( 'time_ago_list_mag_wp' ) ) { echo time_ago_list_mag_wp(); ?> <?php esc_html_e('ago', 'list-mag-wp'); } ?></li>
                <li class="lm-space"><i class="fa fa-times"></i></li>
                <li><?php if ( function_exists( 'getPostViews_list_mag_wp' ) ) { echo getPostViews_list_mag_wp(get_the_ID()); } ?></li>
                <li class="lm-space"><i class="fa fa-times"></i></li>
                <li><?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?></li>
            </ul><!-- end .meta-single-content -->
            <?php } ?>
            <div class="clear"></div>
        </div><div class="clear"></div>
        <?php endwhile; endif; ?>


        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <?php if ( function_exists( 'getPostViews_list_mag_wp' ) ) { setPostViews_list_mag_wp(get_the_ID()); } ?>
            <div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">

          <!--      <?php the_post_thumbnail('list_mag_wp_thumbnail_single_image'); ?>-->
                <div class="entry">
                    <!-- excerpt -->
                    <?php if ( !empty( $post->post_excerpt ) ) : ?> <div class="entry-excerpt"><h3> <?php echo the_excerpt(); ?> </h3></div> <?php else : false; endif;  ?> 

                    <!-- entry content -->
                    <?php the_content(''); // content ?>
                    <?php wp_link_pages(); // content pagination ?>
                    <div class="clear"></div>
                
                    <ul class="single-share">
                    <li><?php $list_mag_wp_facebooklink = 'https://www.facebook.com/sharer/sharer.php?u='; ?><a class="fbbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_facebooklink); ?><?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-facebook" aria-hidden="true"></i> <span><?php esc_html_e( 'Share on Facebook', 'list-mag-wp' ); ?></span></a></li>
                    <li><?php $list_mag_wp_twitterlink = 'https://twitter.com/home?status=Check%20out%20this%20article:%20'; ?><a class="twbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_twitterlink); ?><?php the_title(); ?>%20-%20<?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-twitter"></i></a></li>
                    <li><?php $list_mag_wp_articleimage = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?><?php $list_mag_wp_pinlink = 'https://pinterest.com/pin/create/button/?url='; ?><a class="pinbutton" target="_blank" href="<?php echo esc_url($list_mag_wp_pinlink); ?><?php the_permalink(); ?>&amp;media=<?php echo esc_html($list_mag_wp_articleimage); ?>&amp;description=<?php the_title(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-pinterest"></i></a></li>
                    <li><?php $list_mag_wp_googlelink = 'https://plus.google.com/share?url='; ?><a class="googlebutton" target="_blank" href="<?php echo esc_url($list_mag_wp_googlelink); ?><?php the_permalink(); ?>" onClick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li> 
                    </ul><!-- end .single-share -->
                </div><!-- end .entry -->
                <div class="clear"></div> 
            </div><!-- end #post -->
            <?php endwhile; endif; ?>
        </article><!-- end article -->
   

        <!-- Related Articles  -->    
        <div id="related-wrap">
            <div class="one_half_rw">
                <div class="widget-title"><h3><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php esc_html_e( 'Bài mới', 'list-mag-wp' ); ?></h3></div>
                <ul class="article_list">
                <?php $list_mag_wp_latest = new WP_Query(array('post_type' => 'post', 'ignore_sticky_posts' => 1, 'posts_per_page' => esc_attr(3) )); // number to display more / less ?>
                <?php while ( $list_mag_wp_latest->have_posts() ) : $list_mag_wp_latest->the_post(); ?>
                 
                    <li>
                      <?php if ( has_post_thumbnail()) { ?>
                          <ul class="meta-icons-home">
                              <?php if (get_comments_number() > 5) { ?><li class="trending-lm"><i class="fa fa-bolt" aria-hidden="true"></i><span class="tooltiptext"><?php esc_html_e( 'Trending post!', 'list-mag-wp' ); ?></span></li><?php } ?>
                          </ul><div class="clear"></div>      
                          <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('list_mag_wp_thumbnail_widget_small'); ?></a>
                      <div class="author-il">
                      <?php } else { ?>
                      <div class="author-il-full">
                      <?php } ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ($list_mag_wp_metadata_info == 'Yes') { ?>
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 19 ); ?></a>
                        <div class="likes-widget"><?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?></div>
                        <?php } ?>
                      </div>
                    </li>

                <?php endwhile; 
                /* Restore original Post Data */
                wp_reset_postdata(); ?>
                </ul>
            </div>
            <div class="one_half_last_rw">
                <div class="widget-title"><h3><i class="fa fa-fire" aria-hidden="true"></i> <?php esc_html_e( 'Cùng chuyên mục', 'list-mag-wp' ); ?></h3></div>
                <ul class="article_list">
                <?php $list_mag_wp_related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'ignore_sticky_posts' => 1, 'numberposts' => esc_attr(3), 'post__not_in' => array($post->ID) ) );
                if( $list_mag_wp_related ) foreach( $list_mag_wp_related as $post ) { setup_postdata($post); ?>                    
                 
                    <li>
                      <?php if ( has_post_thumbnail()) { ?>
                          <ul class="meta-icons-home">
                              <?php if (get_comments_number() > 5) { ?><li class="trending-lm"><i class="fa fa-bolt" aria-hidden="true"></i><span class="tooltiptext"><?php esc_html_e( 'Trending post!', 'list-mag-wp' ); ?></span></li><?php } ?>
                          </ul><div class="clear"></div>      
                          <a href="<?php the_permalink(); ?>"> <?php echo the_post_thumbnail('list_mag_wp_thumbnail_widget_small'); ?></a>
                      <div class="author-il">
                      <?php } else { ?>
                      <div class="author-il-full">
                      <?php } ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php if ($list_mag_wp_metadata_info == 'Yes') { ?>
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 19 ); ?></a>
                        <div class="likes-widget"><?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?></div>
                        <?php } ?>
                      </div>
                    </li>

                <?php } ?>
                </ul>
            </div>
            <div class="clear"></div>
        </div><!-- end #related-wrap -->


        <!-- Tags Articles -->
        <?php $tags = get_the_tags(); 
        if ($tags) { ?> 
        <div id="tags-wrap">
            <div class="tags-btns"><?php the_tags('<i class="fa fa-tags" aria-hidden="true"></i>', '<i class="fa fa-tags" aria-hidden="true"></i>'); // tags ?></div>
        <div class="clear"></div>
        </div><!-- end #tags-wrap -->
        <?php } else { ?><div class="line_bottom_related"></div><?php } ?>

        <!-- Begin Sidebar (Left bottom) -->    
        <?php get_template_part('functions/custom/sidebar-post-bottom'); ?>
        <!-- end #sidebar (Left bottom) -->         

        <!-- Comments -->
        <div id="comments" class="comments">
            <?php if (get_comments_number()==0) { } else { ?>
                <div class="article-btn"><h3><?php esc_html_e( 'All Comments', 'list-mag-wp' ); ?></h3></div>
            <?php } ?>
            <div class="clear"></div>
            <?php comments_template('', true); // comments ?>
        </div>
        <div class="clear"></div>
    </div><!-- end .single-content -->


    <!-- Begin Sidebar (right) -->    
    <?php get_template_part('functions/custom/sidebar-post'); ?>
    <!-- end #sidebar (right) --> 


    <div class="clear"></div>
</div><!-- end .wrap-fullwidth  -->
<?php get_footer(); // add footer  ?>