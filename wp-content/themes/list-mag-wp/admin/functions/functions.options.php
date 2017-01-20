<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);

 
	
		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		$imgs_url = get_template_directory_uri().'/images/';
		$imgs_url_demo = get_template_directory_uri().'/demo';



// Set the Options Array
global $of_options;
$of_options = array();
 

 

/*-----------------------------------------------------------------------------------*/
/* Header Settings */
/*-----------------------------------------------------------------------------------*/

$of_options[] = array( 	"name" 		=> esc_html__( 'General Settings', 'list-mag-wp' ),
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-header.png"
				);


$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "",
						"id" 		=> "introduction_7",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('Custom Logo.', 'list-mag-wp') ."</h3>
						". esc_html__('Upload a custom logo image for your site.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Custom Logo.', 'list-mag-wp' ),
						"desc" 		=> esc_html__('Upload a custom logo image for your site here. Size for height should be 60px or 120px for a better display, for retina screens.', 'list-mag-wp'),
						"id" 		=> "list_mag_wp_logo",
						"std" 		=> $imgs_url.'logo.png',
						"type" 		=> "upload");
					

$of_options[] = array( 	"name" 		=> esc_html__( 'Header Social Icons', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_social",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('Header Social Icons.', 'list-mag-wp') ."</h3>
						<strong>". esc_html__('Social Icons', 'list-mag-wp') ."</strong> ". esc_html__('- Header Social Icons.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Social Icons.', 'list-mag-wp' ),
						"desc" 		=> "". esc_html__('You can use HTML code. For more social icons go to', 'list-mag-wp') ." <a href=\"http://fontawesome.io/icons/\" target=\"_blank\">Font Awesome</a> ". esc_html__('and at the bottom you have Brand Icons!', 'list-mag-wp') ."",
						"id" 		=> "list_mag_wp_top_icons",
						"std" 		=> "
<li><a href=\"#\"><i class=\"fa fa-facebook\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-twitter\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-instagram\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-pinterest\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-google-plus\"></i></a></li>
<li><a href=\"#\"><i class=\"fa fa-youtube\"></i></a></li>
",
						"type" 		=> "textarea");	


$of_options[] = array( 	"name" 		=> esc_html__( 'Blog General Settings.', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "choose_options_home",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('Blog General Settings.', 'list-mag-wp') ."</h3>
						". esc_html__('Blog General Settings: Infinite scroll, metadata; author name, likes, views.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Metadata: Author avatar / name, views and likes.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Metadata: Author avatar / name, views and likes. In order to display the likes, install the plugin Thumbs Rating that comes with the theme.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_metadata_info",
						"std" 		=> "0",
						"type" 		=> "select",
						"options" 	=> array(
										esc_html__( 'No', 'list-mag-wp' ),
										esc_html__( 'Yes', 'list-mag-wp' )
									),
					);

$of_options[] = array( 	"name" 		=> esc_html__( 'Pagination or Infinite Scroll.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Choose the option that better fits your needs, default is Infinite Scroll.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_home_pag_select",
						"std" 		=> "0",
						"type" 		=> "select",
						"options" 	=> array(
										esc_html__( 'Default Pagination', 'list-mag-wp' ),
										esc_html__( 'Infinite Scroll', 'list-mag-wp' )
									),
					);


/*-----------------------------------------------------------------------------------*/
/* Advertisement Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> esc_html__( 'Advertisement', 'list-mag-wp' ),
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-money.png"
				);

$of_options[] = array( 	"name" 		=> esc_html__( 'Display All Banners?', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Display Banners? By default the banners are hidden.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_display_banners",
						"std" 		=> esc_html__( 'No', 'list-mag-wp' ),
						"type" 		=> "select",
						"options" 	=> array(
										esc_html__( 'No', 'list-mag-wp' ),
										esc_html__( 'Yes', 'list-mag-wp' )
									),
					);

$of_options[] = array( 	"name" 		=> esc_html__( '200x200 AD AREA', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_add",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('200x200 AD AREA', 'list-mag-wp') ."</h3>
						<strong>". esc_html__('AD AREA', 'list-mag-wp') ."</strong> ". esc_html__('- Paste your HTML or JavaScript code here.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( '200x200 AD AREA.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Paste your HTML or JavaScript code here. AD Area displayed in the left corner after the categories menu.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_add200",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/200x200\" width=\"200\" height=\"200\" alt=\"img\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> esc_html__( 'Responsive 728x90 AD AREA', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_add",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('Responsive 728x90 AD AREA', 'list-mag-wp') ."</h3>
						<strong>". esc_html__('Responsive AD AREA', 'list-mag-wp') ."</strong> ". esc_html__('- Paste your HTML or JavaScript code here.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Responsive 728x90 AD AREA.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Paste your HTML or JavaScript code here. AD Area displayed in the middle after the first post. Banner displayed in the layout = List =', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_add728",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/728x90\" width=\"728\" height=\"90\" alt=\"img\" /></a>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> esc_html__( 'Responsive 300x250 AD AREA', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_add",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">". esc_html__('Responsive 300x250 AD AREA', 'list-mag-wp') ."</h3>
						<strong>". esc_html__('Responsive AD AREA', 'list-mag-wp') ."</strong> ". esc_html__('- Paste your HTML or JavaScript code here.', 'list-mag-wp') ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Responsive 300x250 AD AREA.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Paste your HTML or JavaScript code here. AD Area displayed after the first post. Banner displayed in the layout = Grid =', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_add300",
						"std" 		=> "<a href=\"#\"><img src=\"http://placehold.it/300x250\" width=\"300\" height=\"250\" alt=\"img\" /></a>",
						"type" 		=> "textarea");	


/*-----------------------------------------------------------------------------------*/
/* Style Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> esc_html__( 'Style Settings', 'list-mag-wp' ),
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-paint.png");


$of_options[] = array( 	"name" 		=> esc_html__( 'Style', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_14",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".esc_html__( 'Style Settings', 'list-mag-wp' )."</h3>
						". esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ) ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Main Color (yellow)', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_main_color1",
						"std" 		=> "#ffd933",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> esc_html__( 'Main Color (green)', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_main_color2",
						"std" 		=> "#cccc52",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> esc_html__( 'Main Color (orange)', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_main_color3",
						"std" 		=> "#ff7f00",
						"type" 		=> "color"
				);




$of_options[] = array( 	"name" 		=> esc_html__( 'Style', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_11",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".esc_html__( 'Style Settings', 'list-mag-wp' )."</h3>
						". esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ) ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Header Section Background Color', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_header_bg",
						"std" 		=> "#192b33",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> esc_html__( 'Footer Social Section Background Color', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_footer_bg1",
						"std" 		=> "#cccc52",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> esc_html__( 'Footer Copyright Section Background Color', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the main color of the site to match your brand color.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_footer_bg2",
						"std" 		=> "#192b33",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> esc_html__( 'Entry Link Color', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Use the color picker to change the entry link color on article or default / full width pages.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_entry_linkcolor",
						"std" 		=> "#ff7f00",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> esc_html__( 'Custom CSS.', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_customcss",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom CSS.</h3>
						". esc_html__( 'Enter your custom CSS code. It will be included in the head section of the page.', 'list-mag-wp' ) ."",
						"icon" 		=> true,
						"type" 		=> "info");

$of_options[] = array( 	"name" 		=> esc_html__( 'Custom CSS.', 'list-mag-wp' ),
						"desc" 		=> esc_html__( 'Enter your custom CSS code. It will be included in the head section of the page.', 'list-mag-wp' ),
						"id" 		=> "list_mag_wp_custom_css_style",
						"std" 		=> "",
						"type" 		=> "textarea");





/*-----------------------------------------------------------------------------------*/
/* Footer Settings */
/*-----------------------------------------------------------------------------------*/
$of_options[] = array( 	"name" 		=> esc_html__( 'Footer Settings', 'list-mag-wp' ),
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-settings.png");



$of_options[] = array( 	"name" 		=> esc_html__( 'Social Icons', 'list-mag-wp' ),
						"desc" 		=> "You can use HTML code.<br /> For more social icons go to <a href=\"http://fontawesome.io/icons/\" target=\"_blank\">Font Awesome</a> and at the bottom you have Brand Icons!",
						"id" 		=> "list_mag_wp_bottom_icons",
						"std" 		=> "<ul class=\"footer-social\">
<li><a href=\"#\"><i class=\"fa fa-facebook\"></i> <span>Facebook</span></a></li>
<li><a href=\"#\"><i class=\"fa fa-twitter\"></i> <span>Twitter</span></a></li>
<li><a href=\"#\"><i class=\"fa fa-pinterest\"></i> <span>Pinterest</span></a></li>
<li><a href=\"#\"><i class=\"fa fa-youtube\"></i> <span>Youtube</span></a></li>
</ul>",
						"type" 		=> "textarea");	

$of_options[] = array( 	"name" 		=> esc_html__( 'Copyright', 'list-mag-wp' ),
						"desc" 		=> "",
						"id" 		=> "introduction_copy",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Copyright.</h3>
						<strong>Copyright</strong> - Footer Copyright.",
						"icon" 		=> true,
						"type" 		=> "info");


$of_options[] = array( 	"name" 		=> esc_html__( 'Copyright', 'list-mag-wp' ),
						"desc" 		=> "You can use HTML code.",
						"id" 		=> "list_mag_wp_copyright",
						"std" 		=> "<p>851 E. Tropicana Avenue Las Vegas <i class=\"fa fa-times\"></i> (702)&nbsp;895-3174 <i class=\"fa fa-times\"></i> <a href=\"#\">Grid Style</a> <i class=\"fa fa-times\"></i> <a href=\"#\">Submit</a> <i class=\"fa fa-times\"></i> <a href=\"mailto:info@listmagwp.com\">info@listmag.com</a> </p>
<p><span>&copy; 2016 Listmag. All Rights Reserved.</span></p>",
						"type" 		=> "textarea");	
 



				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
