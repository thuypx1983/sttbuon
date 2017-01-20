<aside class="sidebar-bottom">
	<?php if ( is_active_sidebar( 'sidebar_article_bottom_list_mag_wp' ) ) { ?>
	    <?php dynamic_sidebar( 'sidebar_article_bottom_list_mag_wp' ); ?>
	<?php } else { ?>
		<?php the_widget( 'WP_Widget_Recent_Posts', 'number=4' ); ?>
	<?php } ?>
</aside>