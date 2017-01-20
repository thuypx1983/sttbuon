<?php
// ------------------------------------------------------
// ------ Posts by Categories  --------------------------
// ------ by Anthemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class list_mag_wp_postcat extends WP_Widget {
     function list_mag_wp_postcat() {
      $widget_ops = array('description' => esc_html__('Posts by Categories', 'list-mag-wp'));
        parent::__construct(false, $name = ''. esc_html__('Custom: Posts by Categories', 'list-mag-wp') .'',$widget_ops);  
    }



    function widget($args, $instance) {   
        extract( $args );
        $number = $instance['number'];
        $title = $instance['title'];
        $category = $instance['category'];
        $icon = $instance['icon'];

    // Metadata
    $list_mag_wp_metadata_info = get_theme_mod('list_mag_wp_metadata_info');
    if (empty($list_mag_wp_metadata_info)) { $list_mag_wp_metadata_info = 'No'; }

?>



<?php echo $before_widget; ?>
<?php if ( $title ) echo $before_title . stripslashes_deep($icon) . esc_attr($title) . $after_title; ?>


<ul class="article_list">
<?php // The Query
$list_mag_wp_widget_postcat = new WP_Query(array('post_type' => 'post',  'ignore_sticky_posts' => 1, 'cat' => esc_attr($category), 'posts_per_page' => esc_attr($number) )); // number to display more / less ?>
<?php while ($list_mag_wp_widget_postcat->have_posts()) : $list_mag_wp_widget_postcat->the_post(); ?> 
 
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
</ul><div class="clear"></div>

<?php echo $after_widget; ?> 


<?php
    }
    function update($new_instance, $old_instance) {       
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['number']    = is_numeric( $new_instance['number'] ) ? intval( $new_instance['number'] ) : 5;
    $instance['category']  = wp_strip_all_tags( $new_instance['category'] );
    $instance['icon'] = stripslashes($new_instance['icon']);
    return $instance;
    }

  function form( $instance ) {
    $defaults  = array(
      'title' => '', 'category' => '', 'number' => 5,
      'icon' => stripslashes('<i class="fa fa-bolt" aria-hidden="true"></i>'),
       );
    $instance  = wp_parse_args( ( array ) $instance, $defaults );
    $title     = $instance['title'];
    $category  = $instance['category'];
    $number    = $instance['number'];
?>


        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'list-mag-wp' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset($instance['title']) ) echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('icon'); ?>"><?php esc_html_e( 'Font Awesome Icon:', 'list-mag-wp' ); ?></label>      
          <textarea style="height:30px;" class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" ><?php if( isset($instance['icon']) ) echo stripslashes($instance['icon']); ?></textarea>
          Icons: <a target="_blank" href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a>
        </p> 

        <p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of Posts:', 'list-mag-wp' ); ?></label>      
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php if( isset($instance['number']) ) echo esc_attr($instance['number']); ?>" />
        </p> 
         
        <p>
          <label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e( 'Category:', 'list-mag-wp' ); ?></label>      
            <?php
            wp_dropdown_categories( array(

              'show_count' => 1,
              'orderby'    => 'title',
              'hide_empty' => false,
              'name'       => $this->get_field_name( 'category' ),
              'id'         => 'rpjc_widget_cat_recent_posts_category',
              'class'      => 'widefat',
              'selected'   => $category

            ) );
            ?>
        </p> 

<?php  } } 
add_action('widgets_init', create_function('', 'return register_widget("list_mag_wp_postcat");')); // register widget
?>