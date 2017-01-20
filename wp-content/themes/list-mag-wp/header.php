<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<?php
    // Logo
    $list_mag_wp_logo = get_theme_mod('list_mag_wp_logo');
    if (empty($list_mag_wp_logo)) { $list_mag_wp_logo = get_template_directory_uri().'/images/logo.png'; }

    // header icons
    $list_mag_wp_top_icons = get_theme_mod('list_mag_wp_top_icons'); 
?>
    <!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <!-- Mobile Device Meta -->
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui' /> 

    <!-- Theme output -->
    <?php wp_head(); ?> 

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89918354-1', 'auto');
  ga('send', 'pageview');

</script>



</head>
<body <?php body_class(); ?>>


<!-- Begin Header -->
<header>
    <div class="main-menu">
            <!-- Logo -->    
            <a href="<?php echo esc_url(home_url( '/' )); ?>"><img class="logo" src="<?php echo esc_url($list_mag_wp_logo); ?>" alt="<?php esc_attr(bloginfo('sitename')); ?>" /></a>

            <!-- Navigation Menu -->
            <?php if ( has_nav_menu( 'list-mag-wp-primary-menu' ) ) : // Check if there's a menu assigned to the 'Header Navigation' location. ?>
            <nav id="myjquerymenu" class="jquerycssmenu">
                <?php wp_nav_menu( array( 'container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' =>   'list-mag-wp-primary-menu' ) ); ?>
            </nav><!-- end #myjquerymenu -->
            <?php endif; // End check for menu. ?>

            <ul class="top-social">
                <?php if (!empty($list_mag_wp_top_icons)) { ?><?php echo wp_kses_post(stripslashes($list_mag_wp_top_icons)); ?><?php } ?>
                <li class="md-trigger search" data-modal="modal-7"><i class="fa fa-search"></i></li>
            </ul>
     </div><!-- end .main-menu -->  
</header><!-- end #header -->

<div class="md-modal md-effect-7" id="modal-7">
    <div class="md-content">
      <div>
        <!-- Search form  -->
        <button class="md-close"><i class="fa fa-times"></i></button><?php get_search_form(); ?>
      </div>
    </div><!-- end .md-content -->
</div><!-- end .md-modal -->