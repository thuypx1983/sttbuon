<?php
/*
Plugin Name: Cool Image Share
Plugin URI: https://wordpress.org/plugins/cool-image-share/
Description: This plugin adds social sharing icons to each image in your posts.
Version: 2.00
Author: Flector
Author URI: https://profiles.wordpress.org/flector#content-plugins
Text Domain: cool-image-share
*/ 

function cis_init() {
    $cis_options = array(); cis_setup();
    $cis_options['position'] = "bottomright";
    $cis_options['offsetx'] = "0";
    $cis_options['offsety'] = "0";
    $cis_options['orientation'] = "vertical";
    $cis_options['iconssize'] = "32";
    $cis_options['paddingx'] = "0";
    $cis_options['paddingy'] = "0";
    $cis_options['minwidth'] = "150";
    $cis_options['minheight'] = "150";
    $cis_options['reduce'] = "enabled";
    $cis_options['mobile'] = "enabled";
    $cis_options['iconshoverin'] = "zoomIn";
    $cis_options['iconshoverout'] = "zoomOut";
    $cis_options['iconshover'] = "brightness-more";
    $cis_options['imagehover'] = "sepia";
    $cis_options['netw'] = "facebook,twitter,google,pinterest,";
    $cis_options['theme'] = "default";
    $cis_options['dont_load_animatecss'] = "disabled";
    $cis_options['ignore_thumbnails'] = "enabled";
    $cis_options['exclude'] = ".no-share";
    $cis_options['visibility'] = "disabled";
    $cis_options['iconstitle'] = "";
    $cis_options['shortlinks'] = "disabled";


    add_option('cis_options', $cis_options);
}
add_action('activate_cool-image-share/cool-image-share.php', 'cis_init');

function cis_setup(){
    load_plugin_textdomain('cool-image-share');
}
add_action('init', 'cis_setup');

function cis_actions($links) {
	return array_merge(array('settings' => '<a href="options-general.php?page=cool-image-share.php">' . __('Settings', 'cool-image-share') . '</a>'), $links);
}
add_filter('plugin_action_links_' . plugin_basename( __FILE__ ),'cis_actions');

function add_image_wrap_class($content) {
    global $post; $purl = plugins_url();
    $cis_options = get_option('cis_options'); 
   
    if($cis_options['mobile']=='disabled' and wp_is_mobile()) {return $content;}
    if(is_feed()) {return $content;}
    if($cis_options['visibility']=='enabled' and !is_singular()) {return $content;}
    
    
    $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
    $replacement = '<img tid="cis"$1class="$2 cool-image-share"$3>';
    $content = preg_replace($pattern, $replacement, $content);
    
    $pattern = "/<img(?!([^>]*\b)class=)([^>]*?)>/i";
    $replacement = '<img tid="cis"$1class="cool-image-share"$2>';
    $content = preg_replace( $pattern, $replacement, $content );
    
   
    $mytitle = rawurlencode(esc_html($post->post_title));
    $mysitetitle = rawurlencode(esc_html(get_bloginfo('name')));
    $myexcerpt = wp_trim_words( get_the_content(), 40, '...' );
    $myexcerpt = rawurlencode(esc_html(strip_tags(strip_shortcodes(apply_filters( 'the_excerpt', $myexcerpt )))));
    if ($cis_options['shortlinks'] != 'enabled') {
        $myurl =  rawurlencode(esc_html(get_permalink($post->ID)));
    } else {
        $myurl =  rawurlencode(esc_html(wp_get_shortlink($post->ID)));
    }
    $tags = get_the_tags($post->ID);
    $mytags = '';
    if ($tags!='') {
    foreach ($tags as $tag){
        $mytags .= $tag->name . ",";
    }}
    $mytags = rawurlencode(esc_html(substr($mytags, 0, strlen($mytags)-1))); 
    $iconstitle = $cis_options['iconstitle'];

    
    $temp = "";
    $networks = explode(",",$cis_options['netw']);
    foreach ($networks as $network) {
        switch ($network) { 
        case "facebook":
            $temp .= "<a rel='nofollow' href=\"https://www.facebook.com/sharer/sharer.php?u={$myurl}&picture=$5\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/facebook.png'."' /></a>";
            break;
        case "twitter":
            $temp .= "<a rel='nofollow' href=\"http://twitter.com/share?text={$mytitle}&url={$myurl}&hashtags={$mytags}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/twitter.png'."' /></a>";
            break;
        case "google":
            $temp .= "<a rel='nofollow' href=\"https://plus.google.com/share?url={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/google.png'."' /></a>";
            break;
        case "pinterest":
            $temp .= "<a rel='nofollow' href=\"http://pinterest.com/pin/create/button/?url={$myurl}&media=$5&description={$myexcerpt}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/pinterest.png'."' /></a>";
            break;
        case "reddit":
            $temp .= "<a rel='nofollow' href=\"http://www.reddit.com/submit?url={$myurl}&title={$mytitle}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/reddit.png'."' /></a>";
            break;
        case "linkedin":
            $temp .= "<a rel='nofollow' href=\"https://www.linkedin.com/shareArticle?mini=true&url={$myurl}&title={$mytitle}&summary={$myexcerpt}&source={$mysitetitle}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/linkedin.png'."' /></a>";
            break;           
        case "tumblr":
            $temp .= "<a rel='nofollow' href=\"https://www.tumblr.com/widgets/share/tool?canonicalUrl={$myurl}&title={$mytitle}&content={$myexcerpt}&tags={$mytags}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/tumblr.png'."' /></a>";
            break;  
        case "odnoklassniki":
            $temp .= "<a rel='nofollow' href=\"https://connect.ok.ru/offer?url={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/odnoklassniki.png'."' /></a>";
            break;
        case "vk":
            $temp .= "<a rel='nofollow' href=\"http://vk.com/share.php?url={$myurl}&image=$5\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/vk.png'."' /></a>";
            break;
        case "lj":
            $temp .= "<a rel='nofollow' href=\"http://www.livejournal.com/update.bml?subject={$mytitle}&event={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/lj.png'."' /></a>";
            break;
        }
    }
    unset($network);
    
    if ($cis_options['orientation'] == "vertical"){
        $orientation = 'style="width:'.$cis_options['iconssize'].'px;"';
    }else{
        $orientation = 'style=""';
    }
    $wrap_open = '<span class="mycenter"><span class="image-share-wrap"><span class="hidden-share" '.$orientation.'>'.$temp.'</span>';
    $wrap_close = '</span></span>';
    
    $pattern ='/<a(?!([^>]*\b)>)([^>]*?)>([^>]*?)<img tid="cis"(.*?)src="(.*?)"(.*?)>([^>]*?)<\/a>/i';
    $replacement = $wrap_open . '<a$1$2>$3<img $4src="$5"$6>$7</a>' . $wrap_close;
    $content = preg_replace($pattern, $replacement, $content);
    
    $pattern ="/<img(.*?)tid=(.*?)\"cis\"(.*?)(.*?)src=\"(.*?)\"(.*?)>/i";
    $replacement = $wrap_open . '<img$1$2$3$4src="$5"$6>' . $wrap_close;
    $content = preg_replace($pattern, $replacement, $content);
    

    return $content;
}
add_filter('the_content', 'add_image_wrap_class', 999);

function check_ignore_thumbnails($content) {
    $cis_options = get_option('cis_options'); 
    if (!isset($cis_options['ignore_thumbnails'])) {
        $cis_options['ignore_thumbnails']='enabled';
        update_option('cis_options', $cis_options);
    }
    if ($cis_options['ignore_thumbnails'] != "enabled"){
        return add_image_wrap_class($content);
    }else{
        return $content;
    }
}
add_filter('post_thumbnail_html', 'check_ignore_thumbnails', 999, 3);

function repair_wrong_html($buffer) {
    
    $pattern ='/<a(?!([^>]*\b)>)([^>]*?)>([^>]*?)<span class="mycenter">(.*?)<\/span><img(.*?)<\/span><\/span>(.*?)<\/a>/i';
    $replacement = '<span class="mycenter">$4</span><a$1$2>$3<img$5$6</a></span></span>';
    $buffer = preg_replace($pattern, $replacement, $buffer);
    
    return $buffer;
}
function callback($buffer) {
    $cis_options = get_option('cis_options'); 
    if (!isset($cis_options['ignore_thumbnails'])) {
        $cis_options['ignore_thumbnails']='enabled';
        update_option('cis_options', $cis_options);
    }
    if ($cis_options['ignore_thumbnails'] != "enabled"){
        return repair_wrong_html($buffer);
    }else{
        return $buffer;
    }
}
function buffer_start() { ob_start("callback"); }
function buffer_end() { ob_end_flush(); }
add_action('wp_head', 'buffer_start');
add_action('wp_footer', 'buffer_end');

function cis_print_style() {
    $cis_options = get_option('cis_options'); 
?>
<style>
.hidden-share{position:absolute;display:none;z-index:100;}
.hidden-share a{text-decoration:none;!important;border:0!important;outline:0;!important;}
.hidden-share a:active,.hidden-share a:focus{outline:0;!important;box-shadow:none!important;}
.mycenter{text-align:left;}
.hidden-share img:focus,.hidden-share img:active{outline:0;!important;box-shadow:none!important;}
.hidden-share img{-webkit-transition: all 0.6s ease;-moz-transition: all 0.6s ease;-o-transition: all 0.6s ease;-ms-transition: all 0.6s ease;transition: all 0.6s ease;line-height:1!important;padding:0!important;margin:0!important;vertical-align:top!important;border-radius:0px!important;box-shadow:none!important;border:0!important;outline:0;!important;max-width:100%!important;
<?php if ($cis_options['orientation']=='vertical') { ?>
<?php if ($cis_options['position']=='bottomleft' or $cis_options['position']=='bottomright' or $cis_options['position']=='center') { ?>
margin-top:<?php echo $cis_options['paddingy']; ?>px!important;}
<?php } ?>
<?php } ?>
<?php if ($cis_options['orientation']=='vertical') { ?>
<?php if ($cis_options['position']=='topleft' or $cis_options['position']=='topright') { ?>
margin-bottom:<?php echo $cis_options['paddingy']; ?>px!important;}
<?php } ?>
<?php } ?>
<?php if ($cis_options['orientation']=='horizontal') { ?>
<?php if ($cis_options['position']=='bottomleft' or $cis_options['position']=='topleft' or $cis_options['position']=='center') { ?>
margin-right:<?php echo $cis_options['paddingx']; ?>px!important;}
<?php } ?>
<?php } ?>
<?php if ($cis_options['orientation']=='horizontal') { ?>
<?php if ($cis_options['position']=='bottomright' or $cis_options['position']=='topright') { ?>
margin-left:<?php echo $cis_options['paddingx']; ?>px!important;}
<?php } ?>
<?php } ?>
.image-share-wrap{position:relative;display:inline-block;}
.cool-image-share{-webkit-transition: all 1s ease;-moz-transition: all 1s ease;-o-transition: all 1s ease;-ms-transition: all 1s ease;transition: all 1s ease;}
.grayscale{-webkit-filter:grayscale(100%);filter:grayscale(100%);}
.sepia{-webkit-filter:sepia(1);filter:sepia(1);}
.saturation{-webkit-filter:saturate(2);filter:saturate(2);}
.hue-rotate{-webkit-filter:hue-rotate(90deg);filter:hue-rotate(90deg);}
.invert{-webkit-filter:invert(.8);filter:invert(.8);}
.myopacity{-webkit-filter:opacity(.5);filter:opacity(.5);}
.brightness-less{-webkit-filter:brightness(.7);filter:brightness(.7);}
.brightness-more{-webkit-filter:brightness(1.4);filter:brightness(1.4);}
.contrast{-webkit-filter:contrast(3);filter:contrast(3);}
.blur{-webkit-filter:blur(3px);filter:blur(3px);}
.tint{-webkit-filter:sepia(1) hue-rotate(200deg);filter:sepia(1)hue-rotate(200deg);}
</style>
<?php } 
add_action('wp_head', 'cis_print_style');

function cis_print_scripts() {
    $cis_options = get_option('cis_options'); 
?>
<script type="text/javascript">    
jQuery(document).ready(function() { 
        
        $floatchildren = jQuery(".image-share-wrap");
        $floatchildren.each(function() {
            var myfloat = jQuery(this).find(".cool-image-share").css("float"); 
            if(myfloat!="none") {
                jQuery(this).css("float", myfloat); 
            }else{             
                if (jQuery(this).find(".cool-image-share").hasClass("aligncenter")){
                jQuery(this).parent(".mycenter").css("text-align", "center"); 
                jQuery(this).parent(".mycenter").css("display", "block"); 

                var tempmt = jQuery(this).find(".cool-image-share").css("margin-top");
                tempmt = -parseInt(tempmt,10);
                var tempmb = jQuery(this).find(".cool-image-share").css("margin-bottom");
                tempmb = -parseInt(tempmb,10);
                jQuery(this).parent(".mycenter").next(".wp-caption-text").css("margin-top", tempmt); 
                jQuery(this).css("margin-top", tempmt);
                jQuery(this).css("margin-bottom", tempmb);
            }}
       });
    
    <?php if ($cis_options['iconshover']!="disabled") { ?>
    jQuery(".hidden-share img").hover(function() {   
       jQuery(this).addClass("<?php echo $cis_options['iconshover'] ?>");
    }, function() {
       jQuery(this).removeClass("<?php echo $cis_options['iconshover'] ?>");
    });
    <?php } ?>
        
    jQuery(".image-share-wrap").hover(function() {
        if (jQuery(this).find(".cool-image-share").width() > <?php echo $cis_options['minwidth'] ?> && jQuery(this).find(".cool-image-share").height() > <?php echo $cis_options['minheight'] ?> && !jQuery(this).find(".cool-image-share").is("<?php echo $cis_options['exclude'] ?>")) {
            $this = jQuery(this).find(".hidden-share"); 
            
            $this.hide();
            jQuery(this).find(".cool-image-share").addClass("<?php echo $cis_options['imagehover'] ?>");
            jQuery(this).find(".cool-image-share").addClass("hover");
            
            <?php if ($cis_options['reduce']=='enabled') { ?>
            $this2 = jQuery(this).find(".hidden-share img");         
            <?php if ($cis_options['orientation']=='horizontal') { ?>
            $this2.width(<?php echo $cis_options['iconssize']; ?>);$this2.height(<?php echo $cis_options['iconssize']; ?>);$this.css("height",<?php echo $cis_options['iconssize']; ?>);
            $this2.css("display","inline-block"); 
            var twidth=0;
            $this2.each(function() {twidth = twidth + <?php echo $cis_options['iconssize']; ?> + <?php echo $cis_options['paddingx']; ?>;})
            $this.width( twidth + <?php echo $cis_options['offsetx']; ?>);
            while (twidth>jQuery(this).find(".cool-image-share").width()-<?php echo $cis_options['offsetx']; ?>) {
                $this2.height($this2.height()-1);$this2.width($this2.width()-1);
                $this.css("height",$this.height()-1);
                var twidth=0;
                $this2.each(function() {twidth = twidth + $this2.width() + <?php echo $cis_options['paddingx']; ?> ;})
                $this.width( twidth +1);
            }
            $this.width( twidth);
            <?php } else { ?>
            $this2.height(<?php echo $cis_options['iconssize']; ?>);$this2.width(<?php echo $cis_options['iconssize']; ?>);$this.css("width",<?php echo $cis_options['iconssize']; ?>);
            $this2.css("display","block"); 
            while ($this.height()+<?php echo $cis_options['offsety']; ?>>jQuery(this).find(".cool-image-share").height()) {
                $this2.height($this2.height()-1);$this2.width($this2.width()-1);
                $this.css("width",$this.width()-1);
            }
            <?php } ?>
            <?php } else { ?>
            $this2 = jQuery(this).find(".hidden-share img");         
            <?php if ($cis_options['orientation']=='horizontal') { ?>
            $this2.width(<?php echo $cis_options['iconssize']; ?>);$this2.height(<?php echo $cis_options['iconssize']; ?>);$this.css("height",<?php echo $cis_options['iconssize']; ?>);
            $this2.css("display","inline-block"); 
            var twidth=0;
            $this2.each(function() {twidth = twidth + <?php echo $cis_options['iconssize']; ?> + <?php echo $cis_options['paddingx']; ?>;})
            $this.width( twidth);
            <?php } else { ?>
            $this2.height(<?php echo $cis_options['iconssize']; ?>);$this2.width(<?php echo $cis_options['iconssize']; ?>);$this.css("width",<?php echo $cis_options['iconssize']; ?>);
            $this2.css("display","block"); 
            <?php } ?>
            <?php } ?>
            
    
            <?php if ($cis_options['position']=='topleft') { ?>
            var left = jQuery(this).find(".cool-image-share").css("left");
            $this.css("left",left); 
            var top = jQuery(this).find(".cool-image-share").css("top");
            $this.css("top",top); 
            
            var p = jQuery(this).find(".cool-image-share");
            var position = p.position();
            $this.offset({ top: position.top, left: position.left });
            
            var marginleft = jQuery(this).find(".cool-image-share").css("margin-left");
            var paddingleft = jQuery(this).find(".cool-image-share").css("padding-left");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-left-width");
            marginleft = parseInt(marginleft,10);
            paddingleft = parseInt(paddingleft,10);
            imageborder = parseInt(imageborder,10);
            var templeft = marginleft + paddingleft + <?php echo $cis_options['offsetx']; ?> + imageborder;
            $this.css("left","+=" + templeft); 
            
            var paddingtop = jQuery(this).find(".cool-image-share").css("padding-top");
            var margintop = jQuery(this).find(".cool-image-share").css("margin-top");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-top-width");
            paddingtop = parseInt(paddingtop,10);
            margintop = parseInt(margintop,10);
            imageborder = parseInt(imageborder,10);
            var temptop = paddingtop + margintop + <?php echo $cis_options['offsety']; ?> + imageborder;
            $this.css("top","+=" + temptop); 
            <?php } ?>
        
            <?php if ($cis_options['position']=='topright') { ?>
            var left = jQuery(this).find(".cool-image-share").css("left");
            $this.css("left",left); 
            var top = jQuery(this).find(".cool-image-share").css("top");
            $this.css("top",top); 
            
            var p = jQuery(this).find(".cool-image-share");
            var position = p.position();
            $this.offset({ top: position.top, left: position.left + jQuery(this).find(".cool-image-share").width() - $this.width()});
            
            var marginleft = jQuery(this).find(".cool-image-share").css("margin-left");
            var paddingleft = jQuery(this).find(".cool-image-share").css("padding-left");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-left-width");
            marginleft = parseInt(marginleft,10);
            paddingleft = parseInt(paddingleft,10);
            imageborder = parseInt(imageborder,10);
            var templeft = marginleft + paddingleft - <?php echo $cis_options['offsetx']; ?> + imageborder;
            $this.css("left","+=" + templeft); 
            
            var paddingtop = jQuery(this).find(".cool-image-share").css("padding-top");
            var margintop = jQuery(this).find(".cool-image-share").css("margin-top");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-top-width");
            paddingtop = parseInt(paddingtop,10);
            margintop = parseInt(margintop,10);
            imageborder = parseInt(imageborder,10);
            var temptop = paddingtop + margintop + <?php echo $cis_options['offsety']; ?> + imageborder;
            $this.css("top","+=" + temptop); 
            <?php } ?>   

            <?php if ($cis_options['position']=='bottomleft') { ?>
            var left = jQuery(this).find(".cool-image-share").css("left");
            $this.css("left",left); 
            var top = jQuery(this).find(".cool-image-share").css("top");
            $this.css("top",top); 
            
            var p = jQuery(this).find(".cool-image-share");
            var position = p.position();
            $this.offset({ top: position.top, left: position.left });

            var marginleft = jQuery(this).find(".cool-image-share").css("margin-left");
            var paddingleft = jQuery(this).find(".cool-image-share").css("padding-left");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-left-width");
            marginleft = parseInt(marginleft,10);
            paddingleft = parseInt(paddingleft,10);
            imageborder = parseInt(imageborder,10);
            var templeft = marginleft + paddingleft + <?php echo $cis_options['offsetx']; ?> + imageborder;

            $this.css("left","+=" + templeft); 
            
            var paddingtop = jQuery(this).find(".cool-image-share").css("padding-top");
            var margintop = jQuery(this).find(".cool-image-share").css("margin-top");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-bottom-width");
            
            var tempmt = 0;
            var myfloat = jQuery(this).find(".cool-image-share").css("float"); 
            if(myfloat=="none") {
                tempmt = jQuery(this).find(".cool-image-share").css("margin-top");
                tempmt = parseInt(tempmt,10);
            }
            
            paddingtop = tempmt+parseInt(paddingtop,10);
            margintop = parseInt(margintop,10);
            if(jQuery(this).css("float")=="none"){margintop = 0;}
            imageborder = parseInt(imageborder,10);
            imageborder = parseInt(imageborder,10);
            var tempbottom = jQuery(this).find(".cool-image-share").height() - $this.height() + paddingtop + margintop - <?php echo $cis_options['offsety']; ?> + imageborder;
            $this.css("top",tempbottom); 
            <?php } ?>       

            <?php if ($cis_options['position']=='bottomright') { ?>
            
            var left = jQuery(this).find(".cool-image-share").css("top");
            $this.css("left",left); 
            var top = jQuery(this).find(".cool-image-share").css("top");
            $this.css("top",top); 

            
            var p = jQuery(this).find(".cool-image-share");
            var position = p.position();
            $this.offset({ top: position.top, left: position.left + jQuery(this).find(".cool-image-share").width() - $this.width()});
            
            var marginleft = jQuery(this).find(".cool-image-share").css("margin-left");
            var paddingleft = jQuery(this).find(".cool-image-share").css("padding-left");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-left-width");
            marginleft = parseInt(marginleft,10);
            paddingleft = parseInt(paddingleft,10);
            imageborder = parseInt(imageborder,10);
            var templeft = marginleft + paddingleft - <?php echo $cis_options['offsetx']; ?> + imageborder;
            $this.css("left","+=" + templeft); 
            
            var paddingtop = jQuery(this).find(".cool-image-share").css("padding-top");
            var margintop = jQuery(this).find(".cool-image-share").css("margin-top");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-bottom-width");

            var tempmt = 0;
            var myfloat = jQuery(this).find(".cool-image-share").css("float"); 
            if(myfloat=="none") {
                tempmt = jQuery(this).find(".cool-image-share").css("margin-top");
                tempmt = parseInt(tempmt,10);
            }
            
            paddingtop = tempmt+parseInt(paddingtop,10);
            margintop = parseInt(margintop,10);
            if(jQuery(this).css("float")=="none"){margintop = 0;}
            
            imageborder = parseInt(imageborder,10);
            var tempbottom = jQuery(this).find(".cool-image-share").height() - $this.height() + paddingtop + margintop - <?php echo $cis_options['offsety']; ?> + imageborder;
            $this.css("top",tempbottom); 
            <?php } ?>        

            <?php if ($cis_options['position']=='center') { ?>
            var left = jQuery(this).find(".cool-image-share").css("left");
            $this.css("left",left); 
            var top = jQuery(this).find(".cool-image-share").css("top");
            $this.css("top",top); 
            
            var p = jQuery(this).find(".cool-image-share");
            var position = p.position();
            $this.offset({ top: position.top, left: position.left });
            
            var marginleft = jQuery(this).find(".cool-image-share").css("margin-left");
            var paddingleft = jQuery(this).find(".cool-image-share").css("padding-left");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-left-width");
            marginleft = parseInt(marginleft,10);
            paddingleft = parseInt(paddingleft,10);
            imageborder = parseInt(imageborder,10);
            var templeft = marginleft + paddingleft + <?php echo $cis_options['offsetx']; ?> + jQuery(this).find(".cool-image-share").width()/2 - $this.width()/2 + imageborder;
            $this.css("left","+=" + templeft); 
            
            var paddingtop = jQuery(this).find(".cool-image-share").css("padding-top");
            var margintop = jQuery(this).find(".cool-image-share").css("margin-top");
            var imageborder = jQuery(this).find(".cool-image-share").css("border-bottom-width");
            paddingtop = parseInt(paddingtop,10);
            margintop = parseInt(margintop,10);
            imageborder = parseInt(imageborder,10);
            var temptop = paddingtop + margintop + <?php echo $cis_options['offsety']; ?> + jQuery(this).find(".cool-image-share").height()/2 - $this.height()/2 + imageborder;
            $this.css("top","+=" + temptop); 
            <?php } ?>      
            
            $this.removeClass("animated <?php echo $cis_options['iconshoverout']; ?>");
            $this.addClass("animated <?php echo $cis_options['iconshoverin']; ?>");
            $this.show();
        }
    }, function() {
            if (jQuery(this).find(".cool-image-share").width() > <?php echo $cis_options['minwidth'] ?> && jQuery(this).find(".cool-image-share").height() > <?php echo $cis_options['minheight'] ?>) {
                $this.removeClass("animated <?php echo $cis_options['iconshoverin']; ?>");
                $this.addClass("animated <?php echo $cis_options['iconshoverout']; ?>");
                <?php if ($cis_options['iconshoverout']=="Disabled") { ?>$this.hide();<?php } ?>
                jQuery(this).find(".cool-image-share").removeClass("<?php echo $cis_options['imagehover'] ?>");
                jQuery(this).find(".cool-image-share").removeClass("hover");
            }
    });
});
</script>
<script>
function newMyWindow(e){
    var h = 500,
    w = 700;
    window.open(e, '', 'scrollbars=1,height='+Math.min(h, screen.availHeight)+',width='+Math.min(w, screen.availWidth)+',left='+Math.max(0, (screen.availWidth - w)/2)+',top='+Math.max(0, (screen.availHeight - h)/2));}
</script>
<?php }    
add_action('wp_footer', 'cis_print_scripts');


function cis_files_admin() {
	$purl = plugins_url();
	
    if(is_admin()){
    
    wp_register_script('cis-lettering', $purl . '/cool-image-share/inc/jquery.lettering.js');  
    wp_register_script('cis-textillate', $purl . '/cool-image-share/inc/jquery.textillate.js');  
	wp_register_style('cis-animate', $purl . '/cool-image-share/inc/animate.min.css');
	
	if(!wp_script_is('jquery')) {wp_enqueue_script('jquery');}
    wp_enqueue_script('cis-lettering');
    wp_enqueue_script('cis-textillate');
    wp_enqueue_style('cis-animate');
    }
}
add_action('admin_enqueue_scripts', 'cis_files_admin');

function cis_files_frontend() {
	$purl = plugins_url();
    $cis_options = get_option('cis_options');
	
    wp_register_style('cis-animate', $purl . '/cool-image-share/inc/animate.min.css');

	if(!wp_script_is('jquery')) {wp_enqueue_script('jquery');}
    
    if ($cis_options['dont_load_animatecss'] != 'enabled') {wp_enqueue_style('cis-animate');};
  
}
add_action('wp_enqueue_scripts', 'cis_files_frontend');


function cis_options_page() {
$purl = plugins_url();

if (isset($_POST['submit'])) {
    $cis_options = get_option('cis_options');
    
    $cis_options['position'] = $_POST['position'];
    if (is_numeric($_POST['offsetx'])) {$cis_options['offsetx'] = $_POST['offsetx'];}
    if (is_numeric($_POST['offsety'])) {$cis_options['offsety'] = $_POST['offsety'];}
    $cis_options['orientation'] = $_POST['orientation'];
    if (is_numeric($_POST['iconssize'])) {$cis_options['iconssize'] = $_POST['iconssize'];}
    if (is_numeric($_POST['paddingx'])) {$cis_options['paddingx'] = $_POST['paddingx'];}
    if (is_numeric($_POST['paddingy'])) {$cis_options['paddingy'] = $_POST['paddingy'];}
    if (is_numeric($_POST['minwidth'])) {$cis_options['minwidth'] = $_POST['minwidth'];}
    if (is_numeric($_POST['minheight'])) {$cis_options['minheight'] = $_POST['minheight'];}
    $cis_options['reduce'] = $_POST['reduce'];
    $cis_options['mobile'] = $_POST['mobile'];
    $cis_options['iconshoverin'] = $_POST['iconshoverin'];
    $cis_options['iconshoverout'] = $_POST['iconshoverout'];
    $cis_options['iconshover'] = $_POST['iconshover'];
    $cis_options['imagehover'] = $_POST['imagehover'];
    $cis_options['netw'] = $_POST['netwspan'];
    $cis_options['theme'] = $_POST['theme'];
    if(isset($_POST['dont_load_animatecss'])){$cis_options['dont_load_animatecss'] = $_POST['dont_load_animatecss'];}else{$cis_options['dont_load_animatecss'] = 'disable';}
    if(isset($_POST['ignore_thumbnails'])){$cis_options['ignore_thumbnails'] = $_POST['ignore_thumbnails'];}else{$cis_options['ignore_thumbnails'] = 'disable';}
    $cis_options['exclude'] = htmlspecialchars($_POST['exclude']);
    if(isset($_POST['visibility'])){$cis_options['visibility'] = $_POST['visibility'];}else{$cis_options['visibility'] = 'disable';}
    $cis_options['iconstitle'] = htmlspecialchars($_POST['iconstitle']);
    if(isset($_POST['shortlinks'])){$cis_options['shortlinks'] = $_POST['shortlinks'];}else{$cis_options['shortlinks'] = 'disable';}
    

    update_option('cis_options', $cis_options);
}
$cis_options = get_option('cis_options');
if (!isset($cis_options['ignore_thumbnails'])) {
    $cis_options['ignore_thumbnails']='enabled';
    update_option('cis_options', $cis_options);
}
cis_print_scripts();
cis_print_style();
?>
<?php if (!empty($_POST)) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'cool-image-share') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php _e('Cool Image Share Settings', 'cool-image-share'); ?></h2>

<div class="metabox-holder" id="poststuff">
<div class="meta-box-sortables">

<?php $lang = get_locale(); ?>
<?php if ($lang != "ru_RU") { ?>
<div class="postbox">

  
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("Do you like this plugin ?", 'cool-image-share'); ?></span></h3>
    <div class="inside" style="display: block;margin-right: 12px;">
        <img src="<?php echo $purl . '/cool-image-share/img/icon_coffee.png'; ?>" title="<?php _e("buy me a coffee", 'cool-image-share'); ?>" style=" margin: 5px; float:left;" />
		
        <p><?php _e("Hi! I'm <strong>Flector</strong>, developer of this plugin.", 'cool-image-share'); ?></p>
        <p><?php _e("I've been spending many hours to develop this plugin.", 'cool-image-share'); ?> <br />
		<?php _e("If you like and use this plugin, you can <strong>buy me a cup of coffee</strong>.", 'cool-image-share'); ?></p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHHgYJKoZIhvcNAQcEoIIHDzCCBwsCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYArwpEtblc2o6AhWqc2YE24W1zANIDUnIeEyr7mXGS9fdCEXEQR/fHaSHkDzP7AvAzAyhBqJiaLxhB+tUX+/cdzSdKOTpqvi5k57iOJ0Wu8uRj0Yh4e9IF8FJzLqN2uq/yEZUL4ioophfiA7lhZLy+HXDs/WFQdnb3AA+dI6FEysTELMAkGBSsOAwIaBQAwgZsGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIENObySN2QMSAeP/tj1T+Gd/mFNHZ1J83ekhrkuQyC74R3IXgYtXBOq9qlIe/VymRu8SPaUzb+3CyUwyLU0Xe4E0VBA2rlRHQR8dzYPfiwEZdz8SCmJ/jaWDTWnTA5fFKsYEMcltXhZGBsa3MG48W0NUW0AdzzbbhcKmU9cNKXBgSJaCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTE0MDcxODE5MDcxN1owIwYJKoZIhvcNAQkEMRYEFJHYeLC0TWMGeUPWCfioIIsO46uTMA0GCSqGSIb3DQEBAQUABIGATJQv8vnHmpP3moab47rzqSw4AMIQ2dgs9c9F4nr0So1KZknk6C0h9T3TFKVqnbGTnFaKjyYlqEmVzsHLQdJwaXFHAnF61Xfi9in7ZscSZgY5YnoESt2oWd28pdJB+nv/WVCMfSPSReTNdX0JyUUhYx+uU4VDp20JM85LBIsdpDs=-----END PKCS7-----">
            <input type="image" src="<?php echo $purl . '/cool-image-share/img/donate.gif'; ?>" border="0" name="submit" title="<?php _e("Donate with PayPal", 'cool-image-share'); ?>">
        </form>
        <div style="clear:both;"></div>
    </div>
</div>
<?php } ?>

<form action="" method="post">



<div class="postbox">

    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Preview', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="display: inline-block;">
 
        <?php 
        $mytitle = rawurlencode(esc_html('Cool Image Share'));
        $myurl =  rawurlencode(esc_html('https://wordpress.org/plugins/cool-image-share/'));
        $iconstitle = $cis_options['iconstitle'];
        $myexcerpt = rawurlencode('This plugin adds social sharing icons to each image in your posts.');
        $mytags = "WordPress Plugin";

        $temp = "";
        $networks = explode(",",$cis_options['netw']);
        foreach ($networks as $network) {
            switch ($network) {
            case "facebook":
                $temp .= "<a href=\"https://www.facebook.com/sharer/sharer.php?u={$myurl}&picture=$3\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/facebook.png'."' /></a>";
                break;
            case "twitter":
            $temp .= "<a href=\"http://twitter.com/share?text={$mytitle}&url={$myurl}&hashtags={$mytags}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/twitter.png'."' /></a>";
                break;
            case "google":
            $temp .= "<a href=\"https://plus.google.com/share?url={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/google.png'."' /></a>";
                break;
            case "pinterest":
                $temp .= "<a href=\"http://pinterest.com/pin/create/button/?url={$myurl}&media=$3\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/pinterest.png'."' /></a>";
                break;
            case "reddit":
            $temp .= "<a href=\"http://www.reddit.com/submit?url={$myurl}&title={$mytitle}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/reddit.png'."' /></a>";
                break;
                
            case "linkedin":
                $temp .= "<a href=\"https://www.linkedin.com/shareArticle?mini=true&url={$myurl}&title={$mytitle}&summary={$myexcerpt}&source={$mytitle}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/linkedin.png'."' /></a>";
            break;   
            case "tumblr":
                $temp .= "<a href=\"https://www.tumblr.com/widgets/share/tool?canonicalUrl={$myurl}&title={$mytitle}&caption={$myexcerpt}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/tumblr.png'."' /></a>";
            break;      
            case "odnoklassniki":
                $temp .= "<a href=\"https://connect.ok.ru/offer?url={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/odnoklassniki.png'."' /></a>";
                break;
            case "vk":
                $temp .= "<a href=\"http://vk.com/share.php?url={$myurl}&image=$3\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/vk.png'."' /></a>";
                break;
            case "lj":
            $temp .= "<a href=\"http://www.livejournal.com/update.bml?subject={$mytitle}&event={$myurl}\" onclick=\"newMyWindow(this.href); return false;\"><img title='{$iconstitle}' width='{$cis_options['iconssize']}' height='{$cis_options['iconssize']}' src='" . $purl . '/cool-image-share/img/'.$cis_options['theme'].'/lj.png'."' /></a>";
                break;
            }
        }
        unset($network);
    
        if ($cis_options['orientation'] == "vertical"){
            $orientation = 'style="width:'.$cis_options['iconssize'].'px;"';
        }else{
            $orientation = 'style=""';
        }
        $wrap_open = '<span class="mycenter"><span class="image-share-wrap"><span class="hidden-share" '.$orientation.'>'.$temp.'</span>';
        $wrap_close = '</span></span>';
     ?>   
        
     <?php 
     $out1 = '<img tid="cis" class="cool-image-share" style="margin-top:8px;max-width:100%;padding: 5px;border: 1px solid #ccc;background: #fff;" src="'.$purl.'/cool-image-share/img/preview.jpg" />';
      ?>
     
     <?php 
     $pattern ="/<img(.*?)tid=\"cis\"(.*?)src=\"(.*?)\"(.*?)>/i";
     $replacement = $wrap_open . '<img$1$2src="$3"$4>' . $wrap_close;
     $out1 = preg_replace($pattern, $replacement, $out1);
      ?> 
      <?php echo $out1; ?>
   
      <p class="ptest" style="margin:0;"><?php _e('Save plugin settings to apply the changes.', 'cool-image-share'); ?></p>
    
    </div>
</div>


<div class="postbox">

    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e("Icons Panel", 'cool-image-share'); ?></span></h3>
    <div class="inside" style="display: block;">

        <table class="form-table">
        
          
            <tr>
                <th><?php _e("Position:", 'cool-image-share') ?></th>
                <td>
                     <select name="position">
                        <option value="topleft" <?php if ($cis_options['position'] == 'topleft') echo "selected='selected'" ?>><?php _e("Top Left", "cool-image-share"); ?></option>
                        <option value="topright" <?php if ($cis_options['position'] == 'topright') echo "selected='selected'" ?>><?php _e("Top Right", "cool-image-share"); ?></option>
                        <option value="bottomleft" <?php if ($cis_options['position'] == 'bottomleft') echo "selected='selected'" ?>><?php _e("Bottom Left", "cool-image-share"); ?></option>
                        <option value="bottomright" <?php if ($cis_options['position'] == 'bottomright') echo "selected='selected'" ?>><?php _e("Bottom Right", "cool-image-share"); ?></option>
                        <option value="center" <?php if ($cis_options['position'] == 'center') echo "selected='selected'" ?>><?php _e("Center", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("Icons panel placement on the image.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Offset:", "cool-image-share") ?></th>
                <td>
                    X: <input type="text" name="offsetx" size="1" value="<?php echo stripslashes($cis_options['offsetx']); ?>" />
                    Y: <input type="text" name="offsety" size="1" value="<?php echo stripslashes($cis_options['offsety']); ?>" />
                    
                    <br /><small><?php _e("Panel offset from image borders (in px).", "cool-image-share"); ?> </small>
                </td>
            </tr>
          
            
            <tr>
                <th><?php _e("Orientation:", 'cool-image-share') ?></th>
                <td>
                     <select name="orientation">
                        <option value="vertical" <?php if ($cis_options['orientation'] == 'vertical') echo "selected='selected'" ?>><?php _e("Vertical", "cool-image-share"); ?></option>
                        <option value="horizontal" <?php if ($cis_options['orientation'] == 'horizontal') echo "selected='selected'" ?>><?php _e("Horizontal", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("Display icons in the panel as a row or a column.", "cool-image-share"); ?> </small>
                </td>
            </tr>
             
           <tr>
                <th><?php _e("Icons Size:", "cool-image-share") ?></th>
                <td>
                    <input type="text" name="iconssize" size="1" value="<?php echo stripslashes($cis_options['iconssize']); ?>" />
                    
                    
                    <br /><small><?php _e("Width and height of social icons (in px).", "cool-image-share"); ?> </small>
                </td>
            </tr>

            <tr>
                <th><?php _e("Padding:", "cool-image-share") ?></th>
                <td>
                    X: <input type="text" name="paddingx" size="1" value="<?php echo stripslashes($cis_options['paddingx']); ?>" />
                    Y: <input type="text" name="paddingy" size="1" value="<?php echo stripslashes($cis_options['paddingy']); ?>" />
                    
                    <br /><small><?php _e("Padding between the icons, X for horizontal orientation, Y for vertical orientation (in px).", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Minimum Image Size:", "cool-image-share") ?></th>
                <td>
                    <?php _e("Width:", "cool-image-share") ?> <input type="text" name="minwidth" size="2" value="<?php echo stripslashes($cis_options['minwidth']); ?>" /> <?php _e("and", "cool-image-share") ?>
                    <?php _e("Height:", "cool-image-share") ?> <input type="text" name="minheight" size="2" value="<?php echo stripslashes($cis_options['minheight']); ?>" />
                    
                    <br /><small><?php _e("The icons panel will only be displayed on images with larger size (in px).", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Reduce Icons:", 'cool-image-share') ?></th>
                <td>
                     <select name="reduce">
                        <option value="enabled" <?php if ($cis_options['reduce'] == 'enabled') echo "selected='selected'" ?>><?php _e("Enabled", "cool-image-share"); ?></option>
                        <option value="disabled" <?php if ($cis_options['reduce'] == 'disabled') echo "selected='selected'" ?>><?php _e("Disabled", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("Icons will be reduced if the panel does not fit in the image.<br />Be careful with <strong>Offset</strong> and <strong>Padding</strong> options - they will not be reduced.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Mobile Devices:", 'cool-image-share') ?></th>
                <td>
                     <select name="mobile">
                        <option value="enabled" <?php if ($cis_options['mobile'] == 'enabled') echo "selected='selected'" ?>><?php _e("Enabled", "cool-image-share"); ?></option>
                        <option value="disabled" <?php if ($cis_options['mobile'] == 'disabled') echo "selected='selected'" ?>><?php _e("Disabled", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("Show or hide the icons panel on mobile devices.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', 'cool-image-share'); ?>" />
                </td>
            </tr>
            
            
        </table>

    </div>
</div>



<div class="postbox">

    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Effects and Animations', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="display: block;"><p>
	 
	  <table class="form-table">
        
          
            <tr>
                <th><?php _e("Icons Animation:", 'cool-image-share') ?></th>
                <td>
                     <?php _e("In:", 'cool-image-share') ?> 
        <select name="iconshoverin">
        <option value="Disabled" <?php if ($cis_options['iconshoverin'] == 'Disabled') echo "selected='selected'" ?>><?php _e('Disabled', 'cool-image-share'); ?></option>


        <optgroup label="Bouncing Entrances">
          <option value="bounceIn" <?php if ($cis_options['iconshoverin'] == 'bounceIn') echo "selected='selected'" ?>>bounceIn</option>
          <option value="bounceInDown" <?php if ($cis_options['iconshoverin'] == 'bounceInDown') echo "selected='selected'" ?>>bounceInDown</option>
          <option value="bounceInLeft" <?php if ($cis_options['iconshoverin'] == 'bounceInLeft') echo "selected='selected'" ?>>bounceInLeft</option>
          <option value="bounceInRight" <?php if ($cis_options['iconshoverin'] == 'bounceInRight') echo "selected='selected'" ?>>bounceInRight</option>
          <option value="bounceInUp" <?php if ($cis_options['iconshoverin'] == 'bounceInUp') echo "selected='selected'" ?>>bounceInUp</option>
        </optgroup>

        <optgroup label="Fading Entrances">
          <option value="fadeIn" <?php if ($cis_options['iconshoverin'] == 'fadeIn') echo "selected='selected'" ?>>fadeIn</option>
          <option value="fadeInDown" <?php if ($cis_options['iconshoverin'] == 'fadeInDown') echo "selected='selected'" ?>>fadeInDown</option>
          <option value="fadeInDownBig" <?php if ($cis_options['iconshoverin'] == 'fadeInDownBig') echo "selected='selected'" ?>>fadeInDownBig</option>
          <option value="fadeInLeft" <?php if ($cis_options['iconshoverin'] == 'fadeInLeft') echo "selected='selected'" ?>>fadeInLeft</option>
          <option value="fadeInLeftBig" <?php if ($cis_options['iconshoverin'] == 'fadeInLeftBig') echo "selected='selected'" ?>>fadeInLeftBig</option>
          <option value="fadeInRight" <?php if ($cis_options['iconshoverin'] == 'fadeInRight') echo "selected='selected'" ?>>fadeInRight</option>
          <option value="fadeInRightBig" <?php if ($cis_options['iconshoverin'] == 'fadeInRightBig') echo "selected='selected'" ?>>fadeInRightBig</option>
          <option value="fadeInUp" <?php if ($cis_options['iconshoverin'] == 'fadeInUp') echo "selected='selected'" ?>>fadeInUp</option>
          <option value="fadeInUpBig" <?php if ($cis_options['iconshoverin'] == 'fadeInUpBig') echo "selected='selected'" ?>>fadeInUpBig</option>
        </optgroup>

        <optgroup label="Flippers">
          <option value="flip" <?php if ($cis_options['iconshoverin'] == 'flip') echo "selected='selected'" ?>>flip</option>
          <option value="flipInX" <?php if ($cis_options['iconshoverin'] == 'flipInX') echo "selected='selected'" ?>>flipInX</option>
          <option value="flipInY" <?php if ($cis_options['iconshoverin'] == 'flipInY') echo "selected='selected'" ?>>flipInY</option>
        </optgroup>

        <optgroup label="Lightspeed">
          <option value="lightSpeedIn" <?php if ($cis_options['iconshoverin'] == 'lightSpeedIn') echo "selected='selected'" ?>>lightSpeedIn</option>
        </optgroup>

        <optgroup label="Rotating Entrances">
          <option value="rotateIn" <?php if ($cis_options['iconshoverin'] == 'rotateIn') echo "selected='selected'" ?>>rotateIn</option>
          <option value="rotateInDownLeft" <?php if ($cis_options['iconshoverin'] == 'rotateInDownLeft') echo "selected='selected'" ?>>rotateInDownLeft</option>
          <option value="rotateInDownRight" <?php if ($cis_options['iconshoverin'] == 'rotateInDownRight') echo "selected='selected'" ?>>rotateInDownRight</option>
          <option value="rotateInUpLeft" <?php if ($cis_options['iconshoverin'] == 'rotateInUpLeft') echo "selected='selected'" ?>>rotateInUpLeft</option>
          <option value="rotateInUpRight" <?php if ($cis_options['iconshoverin'] == 'rotateInUpRight') echo "selected='selected'" ?>>rotateInUpRight</option>
        </optgroup>


        <optgroup label="Sliding Entrances">
          <option value="slideInUp" <?php if ($cis_options['iconshoverin'] == 'slideInUp') echo "selected='selected'" ?>>slideInUp</option>
          <option value="slideInDown" <?php if ($cis_options['iconshoverin'] == 'slideInDown') echo "selected='selected'" ?>>slideInDown</option>
          <option value="slideInLeft" <?php if ($cis_options['iconshoverin'] == 'slideInLeft') echo "selected='selected'" ?>>slideInLeft</option>
          <option value="slideInRight" <?php if ($cis_options['iconshoverin'] == 'slideInRight') echo "selected='selected'" ?>>slideInRight</option>

        </optgroup>

        
        <optgroup label="Zoom Entrances">
          <option value="zoomIn" <?php if ($cis_options['iconshoverin'] == 'zoomIn') echo "selected='selected'" ?>>zoomIn</option>
          <option value="zoomInDown" <?php if ($cis_options['iconshoverin'] == 'zoomInDown') echo "selected='selected'" ?>>zoomInDown</option>
          <option value="zoomInLeft" <?php if ($cis_options['iconshoverin'] == 'zoomInLeft') echo "selected='selected'" ?>>zoomInLeft</option>
          <option value="zoomInRight" <?php if ($cis_options['iconshoverin'] == 'zoomInRight') echo "selected='selected'" ?>>zoomInRight</option>
          <option value="zoomInUp" <?php if ($cis_options['iconshoverin'] == 'zoomInUp') echo "selected='selected'" ?>>zoomInUp</option>
        </optgroup>
        

        <optgroup label="Specials">
          <option value="rollIn" <?php if ($cis_options['iconshoverin'] == 'rollIn') echo "selected='selected'" ?>>rollIn</option>

        </optgroup>
      </select>
                     &nbsp;&nbsp;&nbsp;<?php _e("Out:", 'cool-image-share') ?> 
        <select name="iconshoverout">
        <option value="Disabled" <?php if ($cis_options['iconshoverout'] == 'Disabled') echo "selected='selected'" ?>><?php _e('Disabled', 'cool-image-share'); ?></option>

        <optgroup label="Bouncing Exits">
          <option value="bounceOut" <?php if ($cis_options['iconshoverout'] == 'bounceOut') echo "selected='selected'" ?>>bounceOut</option>
          <option value="bounceOutDown" <?php if ($cis_options['iconshoverout'] == 'bounceOutDown') echo "selected='selected'" ?>>bounceOutDown</option>
          <option value="bounceOutLeft" <?php if ($cis_options['iconshoverout'] == 'bounceOutLeft') echo "selected='selected'" ?>>bounceOutLeft</option>
          <option value="bounceOutRight" <?php if ($cis_options['iconshoverout'] == 'bounceOutRight') echo "selected='selected'" ?>>bounceOutRight</option>
          <option value="bounceOutUp" <?php if ($cis_options['iconshoverout'] == 'bounceOutUp') echo "selected='selected'" ?>>bounceOutUp</option>
        </optgroup>

        <optgroup label="Fading Exits">
          <option value="fadeOut" <?php if ($cis_options['iconshoverout'] == 'fadeOut') echo "selected='selected'" ?>>fadeOut</option>
          <option value="fadeOutDown" <?php if ($cis_options['iconshoverout'] == 'fadeOutDown') echo "selected='selected'" ?>>fadeOutDown</option>
          <option value="fadeOutDownBig" <?php if ($cis_options['iconshoverout'] == 'fadeOutDownBig') echo "selected='selected'" ?>>fadeOutDownBig</option>
          <option value="fadeOutLeft" <?php if ($cis_options['iconshoverout'] == 'fadeOutLeft') echo "selected='selected'" ?>>fadeOutLeft</option>
          <option value="fadeOutLeftBig" <?php if ($cis_options['iconshoverout'] == 'fadeOutLeftBig') echo "selected='selected'" ?>>fadeOutLeftBig</option>
          <option value="fadeOutRight" <?php if ($cis_options['iconshoverout'] == 'fadeOutRight') echo "selected='selected'" ?>>fadeOutRight</option>
          <option value="fadeOutRightBig" <?php if ($cis_options['iconshoverout'] == 'fadeOutRightBig') echo "selected='selected'" ?>>fadeOutRightBig</option>
          <option value="fadeOutUp" <?php if ($cis_options['iconshoverout'] == 'fadeOutUp') echo "selected='selected'" ?>>fadeOutUp</option>
          <option value="fadeOutUpBig" <?php if ($cis_options['iconshoverout'] == 'fadeOutUpBig') echo "selected='selected'" ?>>fadeOutUpBig</option>
        </optgroup>

        <optgroup label="Flippers">
          <option value="flipOutX" <?php if ($cis_options['iconshoverout'] == 'flipOutX') echo "selected='selected'" ?>>flipOutX</option>
          <option value="flipOutY" <?php if ($cis_options['iconshoverout'] == 'flipOutY') echo "selected='selected'" ?>>flipOutY</option>
        </optgroup>

        <optgroup label="Lightspeed">
          <option value="lightSpeedOut" <?php if ($cis_options['iconshoverout'] == 'lightSpeedOut') echo "selected='selected'" ?>>lightSpeedOut</option>
        </optgroup>


        <optgroup label="Rotating Exits">
          <option value="rotateOut" <?php if ($cis_options['iconshoverout'] == 'rotateOut') echo "selected='selected'" ?>>rotateOut</option>
          <option value="rotateOutDownLeft" <?php if ($cis_options['iconshoverout'] == 'rotateOutDownLeft') echo "selected='selected'" ?>>rotateOutDownLeft</option>
          <option value="rotateOutDownRight" <?php if ($cis_options['iconshoverout'] == 'rotateOutDownRight') echo "selected='selected'" ?>>rotateOutDownRight</option>
          <option value="rotateOutUpLeft" <?php if ($cis_options['iconshoverout'] == 'rotateOutUpLeft') echo "selected='selected'" ?>>rotateOutUpLeft</option>
          <option value="rotateOutUpRight" <?php if ($cis_options['iconshoverout'] == 'rotateOutUpRight') echo "selected='selected'" ?>>rotateOutUpRight</option>
        </optgroup>


        <optgroup label="Sliding Exits">
          <option value="slideOutUp" <?php if ($cis_options['iconshoverout'] == 'slideOutUp') echo "selected='selected'" ?>>slideOutUp</option>
          <option value="slideOutDown" <?php if ($cis_options['iconshoverout'] == 'slideOutDown') echo "selected='selected'" ?>>slideOutDown</option>
          <option value="slideOutLeft" <?php if ($cis_options['iconshoverout'] == 'slideOutLeft') echo "selected='selected'" ?>>slideOutLeft</option>
          <option value="slideOutRight" <?php if ($cis_options['iconshoverout'] == 'slideOutRight') echo "selected='selected'" ?>>slideOutRight</option>
          
        </optgroup>
        
        
        <optgroup label="Zoom Exits">
          <option value="zoomOut" <?php if ($cis_options['iconshoverout'] == 'zoomOut') echo "selected='selected'" ?>>zoomOut</option>
          <option value="zoomOutDown" <?php if ($cis_options['iconshoverout'] == 'zoomOutDown') echo "selected='selected'" ?>>zoomOutDown</option>
          <option value="zoomOutLeft" <?php if ($cis_options['iconshoverout'] == 'zoomOutLeft') echo "selected='selected'" ?>>zoomOutLeft</option>
          <option value="zoomOutRight" <?php if ($cis_options['iconshoverout'] == 'zoomOutRight') echo "selected='selected'" ?>>zoomOutRight</option>
          <option value="zoomOutUp" <?php if ($cis_options['iconshoverout'] == 'zoomOutUp') echo "selected='selected'" ?>>zoomOutUp</option>
        </optgroup>

        <optgroup label="Specials">
          <option value="hinge" <?php if ($cis_options['iconshoverout'] == 'hinge') echo "selected='selected'" ?>>hinge</option>
          <option value="rollOut" <?php if ($cis_options['iconshoverout'] == 'rollOut') echo "selected='selected'" ?>>rollOut</option>
        </optgroup>
      </select>
                    <br /><small><?php _e("The animation of showing and hiding icons when hovering the image.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            
            <tr>
                <th><?php _e("Icons Hover Effect:", 'cool-image-share') ?></th>
                <td>
                     <select name="iconshover">
                        <option value="disabled" <?php if ($cis_options['iconshover'] == 'disabled') echo "selected='selected'" ?>><?php _e("Disabled", "cool-image-share"); ?></option>
                        <option style="color:#BCB8B8;" disabled>──────────</option>
                        <option value="grayscale" <?php if ($cis_options['iconshover'] == 'grayscale') echo "selected='selected'" ?>><?php _e("Grayscale", "cool-image-share"); ?></option>
                        <option value="sepia" <?php if ($cis_options['iconshover'] == 'sepia') echo "selected='selected'" ?>><?php _e("Sepia", "cool-image-share"); ?></option>
                        <option value="saturation" <?php if ($cis_options['iconshover'] == 'saturation') echo "selected='selected'" ?>><?php _e("Saturation", "cool-image-share"); ?></option>
                        <option value="hue-rotate" <?php if ($cis_options['iconshover'] == 'hue-rotate') echo "selected='selected'" ?>><?php _e("Hue-rotate", "cool-image-share"); ?></option>
                        <option value="invert" <?php if ($cis_options['iconshover'] == 'invert') echo "selected='selected'" ?>><?php _e("Invert", "cool-image-share"); ?></option>
                        <option value="myopacity" <?php if ($cis_options['iconshover'] == 'myopacity') echo "selected='selected'" ?>><?php _e("Opacity", "cool-image-share"); ?></option>
                        <option value="brightness-less" <?php if ($cis_options['iconshover'] == 'brightness-less') echo "selected='selected'" ?>><?php _e("Brightness (less)", "cool-image-share"); ?></option>
                        <option value="brightness-more" <?php if ($cis_options['iconshover'] == 'brightness-more') echo "selected='selected'" ?>><?php _e("Brightness (more)", "cool-image-share"); ?></option>
                        <option value="contrast" <?php if ($cis_options['iconshover'] == 'contrast') echo "selected='selected'" ?>><?php _e("Contrast", "cool-image-share"); ?></option>
                        <option value="blur" <?php if ($cis_options['iconshover'] == 'blur') echo "selected='selected'" ?>><?php _e("Blur", "cool-image-share"); ?></option>
                        <option value="tint" <?php if ($cis_options['iconshover'] == 'tint') echo "selected='selected'" ?>><?php _e("Tint", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("The effect used when hovering a social icon.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            <tr>
                <th><?php _e("Image Hover Effect:", 'cool-image-share') ?></th>
                <td>
                     <select name="imagehover">
                        <option value="disabled" <?php if ($cis_options['imagehover'] == 'disabled') echo "selected='selected'" ?>><?php _e("Disabled", "cool-image-share"); ?></option>
                        <option style="color:#BCB8B8;" disabled>──────────</option>
                        <option value="grayscale" <?php if ($cis_options['imagehover'] == 'grayscale') echo "selected='selected'" ?>><?php _e("Grayscale", "cool-image-share"); ?></option>
                        <option value="sepia" <?php if ($cis_options['imagehover'] == 'sepia') echo "selected='selected'" ?>><?php _e("Sepia", "cool-image-share"); ?></option>
                        <option value="saturation" <?php if ($cis_options['imagehover'] == 'saturation') echo "selected='selected'" ?>><?php _e("Saturation", "cool-image-share"); ?></option>
                        <option value="hue-rotate" <?php if ($cis_options['imagehover'] == 'hue-rotate') echo "selected='selected'" ?>><?php _e("Hue-rotate", "cool-image-share"); ?></option>
                        <option value="invert" <?php if ($cis_options['imagehover'] == 'invert') echo "selected='selected'" ?>><?php _e("Invert", "cool-image-share"); ?></option>
                        <option value="myopacity" <?php if ($cis_options['imagehover'] == 'myopacity') echo "selected='selected'" ?>><?php _e("Opacity", "cool-image-share"); ?></option>
                        <option value="brightness-less" <?php if ($cis_options['imagehover'] == 'brightness-less') echo "selected='selected'" ?>><?php _e("Brightness (less)", "cool-image-share"); ?></option>
                        <option value="brightness-more" <?php if ($cis_options['imagehover'] == 'brightness-more') echo "selected='selected'" ?>><?php _e("Brightness (more)", "cool-image-share"); ?></option>
                        <option value="contrast" <?php if ($cis_options['imagehover'] == 'contrast') echo "selected='selected'" ?>><?php _e("Contrast", "cool-image-share"); ?></option>
                        <option value="blur" <?php if ($cis_options['imagehover'] == 'blur') echo "selected='selected'" ?>><?php _e("Blur", "cool-image-share"); ?></option>
                        <option value="tint" <?php if ($cis_options['imagehover'] == 'tint') echo "selected='selected'" ?>><?php _e("Tint", "cool-image-share"); ?></option>
                    </select>
                    <br /><small><?php _e("The effect used when hovering the image.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            

            
             <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', 'cool-image-share'); ?>" />
                </td>
            </tr>
        </table>
    
    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Social Networks', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="padding-bottom:15px;display: block;">
      
            <table class="form-table">        
            <tr>
            
                <th><?php _e("Networks:", "cool-image-share") ?></th>
                <td style="padding:0;">
                   
                   <table><tr style="margin-left:-5px;">
                   
                   <td>
                    <label for="facebook"><img title="Facebook" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/facebook.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="facebook" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="twitter"><img title="Twitter" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/twitter.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="twitter" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="google"><img title="Google Plus" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/google.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="google" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="pinterest"><img title="Pinterest" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/pinterest.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="pinterest" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="reddit"><img title="Reddit" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/reddit.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="reddit" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="linkedin"><img title="Linkedin" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/linkedin.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="linkedin" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="tumblr"><img title="Tumblr" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/tumblr.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="tumblr" style="margin-left:16px;" />
                   </td>
                   
                   
                   <td>
                    <label for="odnoklassniki"><img title="Odnoklassniki" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/odnoklassniki.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="odnoklassniki" style="margin-left:16px;">
                   </td>
                   
                   <td>
                    <label for="vk"><img title="VKontakte" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/vk.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="vk" style="margin-left:16px;" />
                   </td>
                   
                   <td>
                    <label for="lj"><img title="LiveJournal" src="<?php echo $purl . '/cool-image-share/img/'.$cis_options['theme'].'/lj.png'; ?>" style="margin-bottom: 5px;width:48px;height:48px; vertical-align: middle; " /><br /></label>
                    <input type="checkbox" name="networks[]" id="lj" style="margin-left:16px;" />
                   </td>
     
                </tr>
                </table>
                    
                   
                </td>
            </tr>
            
            
            
            <tr>
                <th><?php _e("Order:", "cool-image-share") ?></th>
                <td>
                   <input style="" type="text" name="netw" id="netw" size="62" value="<?php echo $cis_options['netw']; ?>" disabled="disabled" />
                   <input type="text" style="display:none;"  name="netwspan" id="netwspan" value="<?php echo $cis_options['netw']; ?>"/>
                    <br /><small style=""><?php _e("To sort the icons, remove all the checkboxes first, and then select the ones you need in the preferred order. Drag and Drop is not available, sorry.", "cool-image-share"); ?> </small>
                   
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input style="" type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', 'cool-image-share'); ?>" />
                </td>
            </tr>
            
            
        </table>
      
      
   
    </div>
</div>

<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Icons Theme', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="padding-bottom:15px;display: block;">
      
            <table class="form-table">        
            <tr>
            
                <th><?php _e("Theme:", "cool-image-share") ?></th>
                <td width="10%" style="padding-bottom: 0px !important;">
                   
 
 <label for="default"><img title="Default" src="<?php echo $purl . '/cool-image-share/img/default.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="default" <?php if ($cis_options['theme'] == 'default') echo "checked='checked'" ?> name="theme" id="default" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="default">Default</label>
 <br /> <br /></td>
 <td style="padding-bottom: 0px !important;">
  <label for="blackbox"><img title="Black Box" src="<?php echo $purl . '/cool-image-share/img/blackbox.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="blackbox" <?php if ($cis_options['theme'] == 'blackbox') echo "checked='checked'" ?> name="theme" id="blackbox" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="blackbox">Black Box</label>
 <br /> <br />
                    
                   
                </td>
            </tr>
            
            
            <tr>
            
                <th></th>
                <td width="10%" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                   
 
 <label for="flat3d"><img title="Flat 3D" src="<?php echo $purl . '/cool-image-share/img/flat3d.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="flat3d" <?php if ($cis_options['theme'] == 'flat3d') echo "checked='checked'" ?> name="theme" id="flat3d" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="flat3d">Flat 3D</label>
 <br /> <br /></td>
 <td style="padding-top: 0px !important;padding-bottom: 0px !important;">
  <label for="hex"><img title="Hex" src="<?php echo $purl . '/cool-image-share/img/hex.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="hex" <?php if ($cis_options['theme'] == 'hex') echo "checked='checked'" ?> name="theme" id="hex" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="hex">Hex</label>
 <br /> <br />
                    
                   
                </td>
            </tr>
            
            
            <tr>
            
                <th></th>
                <td width="10%" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                   
 
 <label for="purple"><img title="Purple" src="<?php echo $purl . '/cool-image-share/img/purple.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="purple" <?php if ($cis_options['theme'] == 'purple') echo "checked='checked'" ?> name="theme" id="purple" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="purple">Purple</label>
 <br /> <br /></td>
 <td style="padding-top: 0px !important;padding-bottom: 0px !important;">
  <label for="pink"><img title="Pink" src="<?php echo $purl . '/cool-image-share/img/pink.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="pink" <?php if ($cis_options['theme'] == 'pink') echo "checked='checked'" ?> name="theme" id="pink" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="pink">Pink</label>
 <br /> <br />
                    
                   
                </td>
            </tr>
            
            
               <tr>
            
                <th></th>
                <td width="10%" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                   
 
 <label for="stamp"><img title="Stamp" src="<?php echo $purl . '/cool-image-share/img/stamp.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="stamp" <?php if ($cis_options['theme'] == 'stamp') echo "checked='checked'" ?> name="theme" id="stamp" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="stamp">Stamp</label>
 <br /> <br /></td>
 <td style="padding-top: 0px !important;padding-bottom: 0px !important;">
  <label for="volumetric"><img title="Volumetric" src="<?php echo $purl . '/cool-image-share/img/volumetric.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="volumetric" <?php if ($cis_options['theme'] == 'volumetric') echo "checked='checked'" ?> name="theme" id="volumetric" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="volumetric">Volumetric</label>
 <br /> <br />
                    
                   
                </td>
            </tr>
            
             <tr>
            
                <th></th>
                <td width="10%" style="padding-top: 0px !important;padding-bottom: 0px !important;">
                   
 
 
  <label for="roundsimple"><img title="Round Simple" src="<?php echo $purl . '/cool-image-share/img/roundsimple.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="roundsimple" <?php if ($cis_options['theme'] == 'roundsimple') echo "checked='checked'" ?> name="theme" id="roundsimple" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="roundsimple">Round Simple</label>
 <br /> <br />
                    
                   
                </td>
              <td style="padding-top: 0px !important;padding-bottom: 0px !important;">
  <label for="flatshadow"><img title="Flat Shadow" src="<?php echo $purl . '/cool-image-share/img/flatshadow.png'; ?>" style="width:190px;height:38px; vertical-align: middle; " /><br /></label>
 <input type="radio" value="flatshadow" <?php if ($cis_options['theme'] == 'flatshadow') echo "checked='checked'" ?> name="theme" id="flatshadow" style="margin-left: 55px;margin-top: 4px;" />
  <label style="vertical-align: sub;margin-left: -5px;" for="flatshadow">Flat Shadow</label>
 <br /> <br />
                    
                   
                </td>  
                
            </tr>

            
            <tr>
                <th></th>
                <td>
                    <input style="" type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', 'cool-image-share'); ?>" />
                </td>
            </tr>
            
            
        </table>
      
      
   
    </div>
</div>

<div class="postbox">

    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('Advanced Options', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="display: block;">
      
        <table class="form-table">
            
            <tr>
                <th><?php _e("Loading:", 'cool-image-share') ?></th>
                <td>
                    <label for="dont_load_animatecss"><input type="checkbox" value="enabled" name="dont_load_animatecss" id="dont_load_animatecss" <?php if ($cis_options['dont_load_animatecss'] == 'enabled') echo "checked='checked'"; ?> /><?php _e("Don't load Animate.css", "cool-image-share"); ?></label>
                    <br /><small><?php _e("Do not load the Animate.css library (in case it's already loaded by your theme or another plugin).", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Featured images:", 'cool-image-share') ?></th>
                <td>
                    <label for="ignore_thumbnails"><input type="checkbox" value="enabled" name="ignore_thumbnails" id="ignore_thumbnails" <?php if ($cis_options['ignore_thumbnails'] == 'enabled') echo "checked='checked'"; ?> /><?php _e("Ignore featured images", "cool-image-share"); ?></label>
                    <br /><small><?php _e("Do not show the icon panel on images that are showed separately from the content of posts through the <strong>the_post_thumbnail</strong> function.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Exclude:", 'cool-image-share') ?></th>
                <td>
                    <input type="text" name="exclude" size="50" value="<?php echo $cis_options['exclude']; ?>" />
                    <br /><small><?php _e("Specify the CSS classes of the images this plugin should not be applied to.", "cool-image-share"); ?> <br />
                    <?php _e('(separated with commas and prefixed with a dot, e.g. "<strong>.no-share,.thumbnail</strong>" etc.)', 'cool-image-share'); ?>
                    </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Visibility:", 'cool-image-share') ?></th>
                <td>
                    <label for="visibility"><input type="checkbox" value="enabled" name="visibility" id="visibility" <?php if ($cis_options['visibility'] == 'enabled') echo "checked='checked'"; ?> /><?php _e("Show icons panel only on single pages", "cool-image-share"); ?></label>
                    <br /><small><?php _e("The icons panel will only be displayed on singular pages (posts, pages and attachments).", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Icons Title:", 'cool-image-share') ?></th>
                <td>
                    <input type="text" name="iconstitle" size="50" value="<?php echo $cis_options['iconstitle']; ?>" />
                    <br /><small><?php _e('The <strong>title</strong> attribute for the icons. Can be something like: "<strong>Share post with this image!</strong>', "cool-image-share"); ?>
                    </small>
                </td>
            </tr>
            
            <tr>
                <th><?php _e("Short Links:", 'cool-image-share') ?></th>
                <td>
                    <label for="shortlinks"><input type="checkbox" value="enabled" name="shortlinks" id="shortlinks" <?php if ($cis_options['shortlinks'] == 'enabled') echo "checked='checked'"; ?> /><?php _e("Use short links", "cool-image-share"); ?></label>
                    <br /><small><?php _e("Use short links for sharing, e.g. <strong>http://example.com/?p=1234</strong>.", "cool-image-share"); ?> </small>
                </td>
            </tr>
            
            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', 'cool-image-share'); ?>" />
                </td>
            </tr>
            
            
        </table>
    
    </div>
</div>


<div class="postbox">
    <h3 style="border-bottom: 1px solid #EEE;background: #f7f7f7;"><span class="tcode"><?php _e('About', 'cool-image-share'); ?></span></h3>
	  <div class="inside" style="padding-bottom:15px;display: block;">
      
	  <p><?php _e('<strong>Cool Image Share</strong> uses the following libraries:', 'cool-image-share'); ?></p>
      <div class="about">
        <ul>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a target="_blank" href="http://daneden.github.io/animate.css/">animate.css</a>, <?php _e('by', 'cool-image-share'); ?> Daniel Eden</li>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a target="_blank" href="https://jschr.github.io/textillate/">textillate.js</a>, <?php _e('by', 'cool-image-share'); ?> Jordan Schroter</li>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a target="_blank" href="http://letteringjs.com/">lettering.js</a>, <?php _e('by', 'cool-image-share'); ?> Dave Rupert</li>
            </ul>
      </div>
      <p><?php _e('If you liked my plugin, please <a target="new" href="https://wordpress.org/plugins/cool-image-share/"><strong>rate</strong></a> it.', 'cool-image-share'); ?></p>
      <p style="margin-top:20px;margin-bottom:10px;"><?php _e('You may also like my other plugins:', 'cool-image-share'); ?></p>
      
      <div class="about">
        <ul>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a class="myplugin" target="new" href="https://wordpress.org/plugins/bbspoiler/">BBSpoiler</a> - <?php _e('this plugin allows you to hide text under the tags [spoiler]your text[/spoiler].', 'cool-image-share'); ?></li>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a class="myplugin" target="new" href="https://wordpress.org/plugins/cool-tag-cloud/">Cool Tag Cloud</a> - <?php _e('a simple, yet very beautiful tag cloud.', 'cool-image-share'); ?> </li>
            <li style="list-style-type: square;margin: 0px 0px 3px 35px;"><a class="myplugin" target="new" href="https://wordpress.org/plugins/easy-textillate/">Easy Textillate</a> - <?php _e('very beautiful text animations (shortcodes in posts and widgets or PHP code in theme files).', 'cool-image-share'); ?> </li>
            </ul>
      </div>
      

    </div>
</div>




</form>
</div>
</div>
<?php 
}

function cis_menu() {
	add_options_page('Cool Image Share', 'Cool Image Share', 'manage_options', 'cool-image-share.php', 'cis_options_page');
}
add_action('admin_menu', 'cis_menu');

function cis_admin_print_scripts() {
$post_permalink = $_SERVER["REQUEST_URI"];
if(strpos($post_permalink, 'cool-image-share.php') == true) : 
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
$('.tcode').textillate({
  loop: true,
  minDisplayTime: 5000,
  initialDelay: 800,
  autoStart: true,
  inEffects: [],
  outEffects: [],
  in: {
    effect: 'rollIn',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: true,
    reverse: false,
    callback: function () {}
  },
   out: {
    effect: 'fadeOut',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: true,
    reverse: false,
    callback: function () {}
  },
  callback: function () {}
});})
</script>

<script type="text/javascript">
String.prototype.replaceAll = function(search, replace){
  return this.split(search).join(replace);
}

jQuery(document).ready(function($) {
    var temp = jQuery('#netw').val();
    if (temp!==undefined) {
    if (temp.indexOf("facebook") !== -1) {jQuery('#facebook').attr("checked", "checked");}
    if (temp.indexOf("vk") !== -1) {jQuery('#vk').attr("checked", "checked");}
    if (temp.indexOf("twitter") !== -1) {jQuery('#twitter').attr("checked", "checked");}
    if (temp.indexOf("google") !== -1) {jQuery('#google').attr("checked", "checked");}
    if (temp.indexOf("pinterest") !== -1) {jQuery('#pinterest').attr("checked", "checked");}
    if (temp.indexOf("reddit") !== -1) {jQuery('#reddit').attr("checked", "checked");}
    if (temp.indexOf("linkedin") !== -1) {jQuery('#linkedin').attr("checked", "checked");}
    if (temp.indexOf("tumblr") !== -1) {jQuery('#tumblr').attr("checked", "checked");}
    if (temp.indexOf("odnoklassniki") !== -1) {jQuery('#odnoklassniki').attr("checked", "checked");}
    if (temp.indexOf("lj") !== -1) {jQuery('#lj').attr("checked", "checked");}
    }
});
jQuery(function() {
    jQuery('#facebook').click(function(){
        if (jQuery('#netw').val().indexOf("facebook") == -1) {
            temp = jQuery('#netw').val()  + "facebook" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('facebook,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
});
jQuery(function() {
    jQuery('#vk').click(function(){
        if (jQuery('#netw').val().indexOf("vk") == -1) {
            temp = jQuery('#netw').val()  + "vk" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('vk,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
});
jQuery(function() {
    jQuery('#twitter').click(function(){
        if (jQuery('#netw').val().indexOf("twitter") == -1) {
            temp = jQuery('#netw').val()  + "twitter" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('twitter,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
});
jQuery(function() {
    jQuery('#google').click(function(){
        if (jQuery('#netw').val().indexOf("google") == -1) {
            temp = jQuery('#netw').val()  + "google" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('google,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#pinterest').click(function(){
        if (jQuery('#netw').val().indexOf("pinterest") == -1) {
            temp = jQuery('#netw').val()  + "pinterest" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('pinterest,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#reddit').click(function(){
        if (jQuery('#netw').val().indexOf("reddit") == -1) {
            temp = jQuery('#netw').val()  + "reddit" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('reddit,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#odnoklassniki').click(function(){
        if (jQuery('#netw').val().indexOf("odnoklassniki") == -1) {
            temp = jQuery('#netw').val()  + "odnoklassniki" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('odnoklassniki,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#lj').click(function(){
        if (jQuery('#netw').val().indexOf("lj") == -1) {
            temp = jQuery('#netw').val()  + "lj" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('lj,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#linkedin').click(function(){
        if (jQuery('#netw').val().indexOf("linkedin") == -1) {
            temp = jQuery('#netw').val()  + "linkedin" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('linkedin,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 
jQuery(function() {
    jQuery('#tumblr').click(function(){
        if (jQuery('#netw').val().indexOf("tumblr") == -1) {
            temp = jQuery('#netw').val()  + "tumblr" + ",";
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
        } else {
            temp = jQuery('#netw').val();
            temp = temp.replaceAll('tumblr,', '');
            jQuery('#netw').val(temp);
            jQuery('#netwspan').val(temp);
            
        }
    })
}); 

</script>
<?php endif; ?>
<?php }    
add_action('admin_head', 'cis_admin_print_scripts');

?>