<style type="text/css"> <?php
// Main Color (yellow)
$list_mag_wp_main_color1 = get_theme_mod('list_mag_wp_main_color1');
if (!empty($list_mag_wp_main_color1)) {
    // BG Color
    echo esc_html('
    	ul.meta-icons-home li.trending-lm,
    	.trending-lm .tooltiptext, 
    	.sticky-lm .tooltiptext,
    	ul.article_list li ul.meta-icons-home li.trending-lm { background-color: '. $list_mag_wp_main_color1 .' !important;} ');

    // Border
    echo esc_html('
 		.trending-lm .tooltiptext::after, .sticky-lm .tooltiptext::after
    	{ border-color: transparent transparent '. $list_mag_wp_main_color1 .' !important transparent;} ');    
}

// Main Color (green)
$list_mag_wp_main_color2 = get_theme_mod('list_mag_wp_main_color2');
if (!empty($list_mag_wp_main_color2)) {
    // BG Color
    echo esc_html('
    ul.meta-icons-home li.sticky-lm,
    .sticky-lm .tooltiptext,
    .listbtn-category,
    ul.menu-left li a:hover,
    .single-category a { background-color: '. $list_mag_wp_main_color2 .' !important;} ');
    // Border
    echo esc_html('.sticky-lm .tooltiptext::after { border-color: transparent transparent '. $list_mag_wp_main_color2 .' !important transparent;} ');    
}

// Main Color (orange)
$list_mag_wp_main_color3 = get_theme_mod('list_mag_wp_main_color3');
if (!empty($list_mag_wp_main_color3)) {
    // BG Color
    echo esc_html('
    #infscr-loading,
    #searchform2 .buttonicon,
    .my-paginated-posts span,
    #tags-wrap,
    #back-top span { background-color: '. $list_mag_wp_main_color3 .' !important;} ');
    // Border
    echo esc_html('h3.index-title i, .widget-title h3 i, .wrap-footer p a, a:hover, .top-social li a:hover, ul.top-social li.search   { color: '. $list_mag_wp_main_color3 .' !important;} ');    
}

// Header Section Background Color
$list_mag_wp_header_bg = get_theme_mod('list_mag_wp_header_bg');
if (!empty($list_mag_wp_header_bg)) {
    // BG Color
    echo esc_html('.main-menu { background-color: '. $list_mag_wp_header_bg .' !important;} ');
}

// Footer Social Section Background Color
$list_mag_wp_footer_bg1 = get_theme_mod('list_mag_wp_footer_bg1');
if (!empty($list_mag_wp_footer_bg1)) {
    // BG Color
    echo esc_html('.social-section { background-color: '. $list_mag_wp_footer_bg1 .' !important;} ');
}

// Footer Copyright Section Background Color
$list_mag_wp_footer_bg2 = get_theme_mod('list_mag_wp_footer_bg2');
if (!empty($list_mag_wp_footer_bg2)) {
    // BG Color
    echo esc_html('.wrap-footer { background-color: '. $list_mag_wp_footer_bg2 .' !important;} ');
}

// Entry Link Color
$list_mag_wp_entry_linkcolor = get_theme_mod('list_mag_wp_entry_linkcolor');
if (!empty($list_mag_wp_entry_linkcolor)) {
    // BG Color
    echo esc_html('.entry p a { color: '. $list_mag_wp_entry_linkcolor .' !important;} ');
}

 // Custom Style CSS.
$list_mag_wp_custom_css_style = get_theme_mod('list_mag_wp_custom_css_style');
if (!empty($list_mag_wp_custom_css_style)) { 
    echo stripslashes($list_mag_wp_custom_css_style); 
}

?>
</style>

