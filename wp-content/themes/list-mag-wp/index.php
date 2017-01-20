<?php get_header(); // add header  ?>
<?php
    // Pagination or Infinite Scroll
    $list_mag_wp_home_pag_select = get_theme_mod('list_mag_wp_home_pag_select');
    if (empty($list_mag_wp_home_pag_select)) { $list_mag_wp_home_pag_select = 'Default Pagination'; }

    // Metadata
    $list_mag_wp_metadata_info = get_theme_mod('list_mag_wp_metadata_info');
    if (empty($list_mag_wp_metadata_info)) { $list_mag_wp_metadata_info = 'No'; }
  
    // AD Area
    $list_mag_wp_add200 = get_theme_mod('list_mag_wp_add200');
    $list_mag_wp_add728 = get_theme_mod('list_mag_wp_add728');

    // Display Banners (Yes/No)
    $list_mag_wp_display_banners = get_theme_mod('list_mag_wp_display_banners');
    if (empty($list_mag_wp_display_banners)) { $list_mag_wp_display_banners = 'No'; }      
?>

<!-- Begin wrap container -->
<div class="wrap-container">

    <!-- Small sidebar LEft -->
    <div class="left-sidebar">
        <div class="wrap-categories">
        <?php if ( has_nav_menu( 'list-mag-wp-secondary-menu' ) ) { ?>
        <?php wp_nav_menu(
            array(
                'theme_location'     => 'list-mag-wp-secondary-menu',
                'container'          => 'nav',
                'menu_class'         => 'menu-left',
                'echo'               => true,
                'fallback_cb'        => 'false'
                ));
        ?>
        <?php } else { ?><ul class="menu-left"><li><a href="#"><?php esc_html_e( 'Add Categories Here', 'list-mag-wp' ); ?></a></li></ul><?php } ?>
        </div><!-- end .wrap-categories -->

        <div class="clear"></div>
        <?php if ($list_mag_wp_display_banners == 'Yes') { ?>
        <?php if (!empty($list_mag_wp_add200)) { ?>
            <div class="img-200">
                <?php echo stripslashes($list_mag_wp_add200); ?>
            </div>
        <?php } } ?>
    </div><!-- end #small-sidebar -->


    <!-- Begin Main Wrap left Content -->
    <div class="wrap-left-content">

        <?php if (is_category()) { ?> 
            <h3 class="index-title"><i class="fa fa-bomb" aria-hidden="true"></i><?php esc_html_e( 'All posts in:', 'list-mag-wp' ); ?> <?php single_cat_title(''); ?></h3>
        <?php } elseif (is_tag()) { ?>
            <h3 class="index-title"><i class="fa fa-bomb" aria-hidden="true"></i><?php esc_html_e( 'All posts tagged in:', 'list-mag-wp' ); ?> <?php single_tag_title(''); ?></h3>
        <?php } elseif (is_search()) { ?>
            <h3 class="index-title"><i class="fa fa-bomb" aria-hidden="true"></i><?php printf( esc_html__( 'Search Results for: %s', 'list-mag-wp' ), '' . get_search_query() . '' ); ?></h3>
        <?php } elseif (is_author()) { ?> 
            <h3 class="index-title"><i class="fa fa-bomb" aria-hidden="true"></i><?php esc_html_e( 'All posts by:', 'list-mag-wp' ); ?> <?php the_author(); ?></h3>
        <?php } elseif (is_404()) { ?> 
            <h3 class="index-title"><i class="fa fa-bomb" aria-hidden="true"></i><?php esc_html_e('Error 404 - Not Found', 'list-mag-wp'); ?></h3>
            <?php esc_html_e('Sorry, but you are looking for something that isn\'t here.', 'list-mag-wp'); ?>
        <?php } ?><div class="clear"></div>

        <ul id="infinite-articles" class="modern-list js-masonry">
            <?php $num=0; if (have_posts()) : while (have_posts()) : the_post(); $num++; ?>

            <?php if ($list_mag_wp_display_banners == 'Yes') { ?>
            <?php if (!empty($list_mag_wp_add728)) { ?>
                <?php if($num==2) { ?><li class="homeadv"><?php echo stripslashes($list_mag_wp_add728); ?></li><?php } ?>
            <?php } } ?>

            <li <?php post_class('ms-item') ?> id="post-<?php the_ID(); ?>">
                <?php if ( has_post_thumbnail()) { ?>
                    <ul class="meta-icons-home">
                        <?php if (get_comments_number() > 5) { ?><li class="trending-lm"><i class="fa fa-bolt" aria-hidden="true"></i><span class="tooltiptext"><?php esc_html_e( 'Trending post!', 'list-mag-wp' ); ?></span></li><?php } ?>
                        <?php if (is_sticky()) { ?><li class="sticky-lm"><i class="fa fa-lightbulb-o" aria-hidden="true"></i><span class="tooltiptext"><?php esc_html_e( 'Sticky post!', 'list-mag-wp' ); ?></span></li><?php } ?>
                    </ul><div class="clear"></div>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('list_mag_wp_thumbnail_blog_list', array('title' => "")); ?></a>
                <div class="modern-list-content">
                <?php } else { ?>
                <div class="modern-list-content-full">
                <?php } // post thumbnail ?>
                    <div class="listbtn-category"><?php $category = get_the_category(); if ($category) 
                        { echo wp_kses_post('<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->name.'</a> ');}  ?>
                    </div><!-- end .artbtn-category -->
                    <div class="time-ago"><?php if ( function_exists( 'time_ago_list_mag_wp' ) ) { ?><span><?php echo time_ago_list_mag_wp(); ?></span> <?php esc_html_e('ago', 'list-mag-wp'); ?> <?php } ?></div>                 
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php echo list_mag_wp_excerpt(strip_tags(strip_shortcodes(get_the_excerpt())), 160); ?></p>

                    <?php if ($list_mag_wp_metadata_info == 'Yes') { ?>
                    <ul class="meta-content-home">
                        <li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 24 ); ?></a></li>
                        <li class="aut-name"><?php the_author_posts_link(); ?></li>
                        <li class="lm-space"><i class="fa fa-times"></i></li>
                        <li><?php if ( function_exists( 'getPostViews_list_mag_wp' ) ) { echo getPostViews_list_mag_wp(get_the_ID()); } ?></li>
                        <li class="lm-space"><i class="fa fa-times"></i></li>
                        <li class="thumbs-ranting"><?php if (function_exists('thumbs_rating_getlink')) { echo thumbs_rating_getlink(); } ?></li>
                    </ul><!-- end .meta-content-home -->
                    <?php } ?>

                    <div class="clear"></div>
                </div><!-- end .modern-list-content -->              
            </li><!-- end .ms-item -->   

            <?php endwhile; endif; ?>             
        </ul><!-- end .modern-list -->

            <!-- Pagination -->
            <?php if ($list_mag_wp_home_pag_select == 'Infinite Scroll') { ?>
                <div id="nav-below" class="pagination" style="display: none;">
                        <div class="nav-previous"><?php previous_posts_link('&lsaquo; ' . esc_html__('Newer Entries', 'list-mag-wp') . ''); ?></div>
                        <div class="nav-next"><?php next_posts_link('' . esc_html__('Older Entries', 'list-mag-wp') . ' &rsaquo;'); ?></div>
                </div>
            <?php } else { // Infinite Scroll ?>
                <div class="clear"></div>
                <div class="defaultpag">
                    <div class="sright"><?php next_posts_link('' . esc_html__('Older Entries', 'list-mag-wp') . ' &rsaquo;'); ?></div>
                    <div class="sleft"><?php previous_posts_link('&lsaquo; ' . esc_html__('Newer Entries', 'list-mag-wp') . ''); ?></div>
                </div>
            <?php } // Default Pagination ?>
            <!-- pagination -->

    </div><!-- end .wrap-left-content -->
    
     
    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->    

        
<div class="clear"></div>
</div><!-- end .wrap-container -->
<?php get_footer(); // add footer  ?>