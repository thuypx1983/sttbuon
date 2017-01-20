<?php 
/* 
Template Name: Template - Default with Sidebar
*/ 
?>
<?php get_header(); // add header ?>  


<!-- Begin Content -->
<div class="wrap-fullwidth">

    <div class="single-content">
        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">             

                  <div id="page-title-box">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="clear"></div>
                  </div>

                  <div class="entry">
                    <?php the_content(''); // content ?>
                    <?php wp_link_pages(); // content pagination ?>
                    <div class="clear"></div>
                  </div><!-- end #entry -->
            </div><!-- end .post -->
            <?php endwhile; endif; ?>
        </article>


        <?php // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) { ?>

            <div class="line_bottom_related"></div>

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
        <?php } ?> 
            
    </div><!-- end .single-content -->

    <!-- Begin Sidebar (right) -->    
    <?php get_template_part('functions/custom/sidebar-page'); ?>
    <!-- end #sidebar (right) -->  

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>