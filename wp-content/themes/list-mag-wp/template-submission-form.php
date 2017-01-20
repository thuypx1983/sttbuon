<?php 
/* 
Template Name: Template - Submission Form
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

            <div class="line_bottom_related"></div>

            <!-- Begin Sidebar (Left bottom) -->    
            <?php get_template_part('functions/custom/sidebar-post-bottom'); ?>
            <!-- end #sidebar (Left bottom) -->  

            <!-- Submission Form -->
            <div id="submission-form" class="submission-form">
                <?php echo do_shortcode('[ap-form]');?>
            </div>
            <div class="clear"></div>
            
    </div><!-- end .single-content -->

    <!-- Begin Sidebar (right) -->    
    <?php get_template_part('functions/custom/sidebar-page'); ?>
    <!-- end #sidebar (right) -->  

    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->

<?php get_footer(); // add footer  ?>