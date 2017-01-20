<?php 
// Register widgetized areas
function list_mag_wp_widgets_init() {

	register_sidebar( array (
		'name' => esc_html__( 'Sidebar #1 = Home Page', 'list-mag-wp' ),
		'id' => 'sidebar_home_list_mag_wp',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'list-mag-wp' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<div class="widget-title"><h3>',
		'after_title' => '</h3></div><div class="clear"></div>',
	) );

	register_sidebar( array (
		'name' => esc_html__( 'Sidebar #2 = Article Page', 'list-mag-wp' ),
		'id' => 'sidebar_article_list_mag_wp',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'list-mag-wp' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<div class="widget-title"><h3>',
		'after_title' => '</h3></div><div class="clear"></div>',
	) );

	register_sidebar( array (
		'name' => esc_html__( 'Sidebar #3 = Article Page Bottom', 'list-mag-wp' ),
		'id' => 'sidebar_article_bottom_list_mag_wp',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar, next to the comments form.', 'list-mag-wp' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<div class="widget-title"><h3>',
		'after_title' => '</h3></div><div class="clear"></div>',
	) );


	register_sidebar( array (
		'name' => esc_html__( 'Sidebar #4 = Default Page', 'list-mag-wp' ),
		'id' => 'sidebar_page_list_mag_wp',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'list-mag-wp' ),
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div><div class="clear"></div>',
		'before_title' => '<div class="widget-title"><h3>',
		'after_title' => '</h3></div><div class="clear"></div>',
	) );

}

add_action( 'widgets_init', 'list_mag_wp_widgets_init' );
?>