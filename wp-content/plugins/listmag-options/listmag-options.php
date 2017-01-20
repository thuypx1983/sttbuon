<?php
/*
Plugin Name: List Mag Options
Plugin URL: http://www.anthemes.net
Description: Theme Functionality: Post Views / Custom Styles / etc.
Version: 1.0
Author: An-Themes
Author URI: http://themeforest.net/user/An-Themes/portfolio
*/


// ------------------------------------------------ 
// ---- Display custom color CSS ------------------
// ------------------------------------------------ 
function list_mag_wp_colors_css_wrap() {
    include( get_template_directory() . '/functions/custom/custom-style-min.php');
?>
<style type="text/css"><?php echo list_mag_wp_custom_colors_css(); ?></style>
<?php }
add_action( 'wp_head', 'list_mag_wp_colors_css_wrap' );


// ------------------------------------------------
// ---- Add  rel attributes to embedded images ----
// ------------------------------------------------ 
function insert_rel_list_mag_wp($content) {
    $pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
    $replacement = '<a$1href="$2.$3" class=\'wp-img-bg-off\' rel=\'mygallery\'$4>';
    $content = preg_replace( $pattern, $replacement, $content );
    return $content;
}
add_filter( 'the_content', 'insert_rel_list_mag_wp' );


// ------------------------------------------------ 
// --- Pagination class/style for entry articles --
// ------------------------------------------------ 
function custom_nextpage_links_list_mag_wp($defaults) {
$args = array(
'before' => '<div class="my-paginated-posts"><p>' . '<span>',
'after' => '</span></p></div>',
);
$r = wp_parse_args($args, $defaults);
return $r;
}
add_filter('wp_link_pages_args','custom_nextpage_links_list_mag_wp');


// ------------------------------------------------ 
// ------------ Nr of Topics for Tags -------------
// ------------------------------------------------  
add_filter ( 'wp_tag_cloud', 'tag_cloud_count_list_mag_wp' );
function tag_cloud_count_list_mag_wp( $return ) {
return preg_replace('#(<a[^>]+\')(\d+)( topics?\'[^>]*>)([^<]*)<#imsU','$1$2$3$4 <span>($2)</span><',$return);
}


// ------------------------------------------------ 
// --------------- Posts Time Ago -----------------
// ------------------------------------------------  
function time_ago_list_mag_wp( $type = 'post' ) {
    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';
    return human_time_diff($d('U'), current_time('timestamp')) . " ";
}


// ------------------------------------------------ 
// ------------ Number of post views --------------
// ------------------------------------------------

 // function to display number of posts.
function getPostViews_list_mag_wp($postID){
    $count_key = 'post_views_count_list_mag_wp';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return '0 <span>' . esc_html__('View', 'list-mag-wp') . '</span>';
    }
    return $count.' <span>' . esc_html__('Views', 'list-mag-wp') . '</span>';
}

// function to count views.
function setPostViews_list_mag_wp($postID) {
    $count_key = 'post_views_count_list_mag_wp';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


?>