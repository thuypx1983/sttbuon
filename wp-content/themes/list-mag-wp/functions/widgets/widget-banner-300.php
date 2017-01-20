<?php
// ------------------------------------------------------
// ------ Widget Banner  -------------------------------
// ------ by Anthemes.net -------------------------------
//        http://themeforest.net/user/An-Themes/portfolio
//        http://themeforest.net/user/An-Themes/follow 
// ------------------------------------------------------

class list_mag_wp_300px extends WP_Widget {
     function list_mag_wp_300px() {
	    $widget_ops = array('description' => esc_html__('Advertisement - Paste your HTML or JavaScript code.', 'list-mag-wp'));
        parent::__construct(false, $name = ''. esc_html__('Custom: Advertisement 300px', 'list-mag-wp') .'',$widget_ops); 
    }

   function widget($args, $instance) {  
		extract( $args );
		$title_tw = $instance['title_tw'];
		$bcode = $instance['bcode'];
?>		
 
<?php echo $before_widget; ?>	
<?php if ( $title_tw ) echo $before_title . esc_attr( $title_tw ) . $after_title; ?>

<div class="img-300"><?php echo stripslashes_deep($bcode); // esc_textarea() if is added will be shown as a text ?></div>

  <?php echo $after_widget; ?>
  
<?php
    }

     function update($new_instance, $old_instance) {				
			$instance = $old_instance;
			$instance['title_tw'] = strip_tags($new_instance['title_tw']);
			$instance['bcode'] = stripslashes($new_instance['bcode']);
     return $instance;
    }

 	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance );
?>

        <p>
          <label for="<?php echo $this->get_field_id('title_tw'); ?>"><?php esc_html_e( 'Title:', 'list-mag-wp' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title_tw'); ?>" name="<?php echo $this->get_field_name('title_tw'); ?>" type="text" value="<?php if( isset($instance['title_tw']) ) echo esc_attr($instance['title_tw']); ?>" />
        </p>
        
        <p>
          <label for="<?php echo $this->get_field_id('bcode'); ?>"><?php esc_html_e( 'Paste your HTML or JavaScript code here:', 'list-mag-wp' ); ?></label>      
          <textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id('bcode'); ?>" name="<?php echo $this->get_field_name('bcode'); ?>" ><?php if( isset($instance['bcode']) ) echo stripslashes($instance['bcode']); ?></textarea>
        </p> 

<?php  } }
add_action('widgets_init', create_function('', 'return register_widget("list_mag_wp_300px");')); // register widget
?>