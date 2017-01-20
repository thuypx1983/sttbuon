<?php
    // header icons
    $list_mag_wp_bottom_icons = get_theme_mod('list_mag_wp_bottom_icons'); 
    // Copyright
    $list_mag_wp_copyright = get_theme_mod('list_mag_wp_copyright'); 
?>
<!-- Begin Footer -->
<div class="clear"></div>
<footer>
    <?php if (!empty($list_mag_wp_bottom_icons)) { ?>             
    <div class="social-section">
        <!-- footer social icons. -->
        <?php echo wp_kses_post(stripslashes($list_mag_wp_bottom_icons)); ?>
    </div>
    <?php } ?>

    <div class="wrap-footer">
        <?php if (!empty($list_mag_wp_copyright)) { ?>
          <?php echo wp_kses_post(stripslashes($list_mag_wp_copyright)); ?>
        <?php } else { ?>
          <p><?php esc_html_e( 'Go to Theme Options > Footer Settings and add your Copyright text and click Save All Changes!', 'list-mag-wp' ); ?></p>
        <?php } ?>
    </div><!-- end .wrap-middle -->



	<p id="back-top"><a href="#top"><span></span></a></p>
</footer><!-- end #footer -->

<!-- Footer Theme output -->
<?php wp_footer();?>
</body>
</html>