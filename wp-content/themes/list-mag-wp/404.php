<?php get_header(); // add header ?>  

<section id="list-mag-404">
    <div class="middle-404">
        <div class="one_half">
            <h1><?php esc_html_e('Error 404!', 'list-mag-wp'); ?></h1>
            <p><?php esc_html_e('Sorry, but you are looking for something that isn\'t here.', 'list-mag-wp'); ?></p>
        </div>

        <div class="one_half_last">
            <?php the_widget( 'WP_Widget_Recent_Posts', 'number=4' ); ?>
        </div><div class="clear"></div>
    </div>
</section>

<?php get_footer(); // add footer  ?>