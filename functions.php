<?php
/**
 * dgc-theme functions and definitions
 *
 * @package dgc-theme
 * @since dgc-theme 1.0
 */

 /**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since dgc-theme 1.0
 */
if ( ! isset( $content_width ) ) $content_width = 960; /* pixels */

/*woocommerce theme support*/
add_theme_support( 'woocommerce' );

function dgc_theme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'dgc_theme_setup' );

/*Infinite scroll theme support*/
add_theme_support( 'infinite-scroll', array(
    'type'           => 'scroll',
    'footer_widgets' => false,
    'container'      => 'content',
    'wrapper'        => false,
    'render'         => false,
    'posts_per_page' => false,
) );

if ( ! function_exists( 'dgc_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since dgc-theme 1.0
 */

/* 
 *Elementor Partner ID 
 */
if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) { 
	define( 'ELEMENTOR_PARTNER_ID', 2120 ); 
}

/**
 * Set the WPForms ShareASale ID.
 */
function dgc_wpforms_shareasale_id( $shareasale_id ) {
    if ( ! empty( $shareasale_id ) ) {
        return $shareasale_id;
    }
    $shareasale_id = '64312';
    update_option( 'wpforms_shareasale_id', $shareasale_id );
    return $shareasale_id;
}
add_filter( 'wpforms_shareasale_id', 'dgc_wpforms_shareasale_id' );

/**
 * Implement the Custom Header feature
 */
 
 /*require get_template_directory() . '/includes/custom-header.php';*/

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/template-tags.php';
//require get_template_directory() . '/includes/widgets.php';
//require get_template_directory() . '/widgets/widget-news-archive.php';
//require get_template_directory() . '/widgets/widget-filter-refine.php';


/**
 * Adding recommended plugins for dgc-theme.
 */
require_once('includes/func/plugins-included.php');


/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/includes/tweaks.php';
require get_template_directory() . '/includes/func/dgc-function.php';
require get_template_directory() . '/includes/func/comment-inline-error.php';
require get_template_directory() . '/includes/metaboxes/init-for-objestcs-mb.php';
	
/**
 * Custom Theme Options
 */
require get_template_directory() . '/includes/theme-options/theme-options.php';
require get_template_directory() . '/includes/theme-options/customizer/customizer.php';

if ( ! function_exists( 'dgc_fonts_url' ) ) {
    function dgc_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		 * supported by Source Sans Pro, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'textdomain' );

		/* Translators: If there are characters in your language that are not
		 * supported by Bitter, translate this to 'off'. Do not translate into your
		 * own language.
		 */
		$bitter = _x( 'on', 'Bitter font: on or off', 'textdomain' );

		if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
			$font_families = array();

			if ( 'off' !== $source_sans_pro )
				$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

			if ( 'off' !== $bitter )
				$font_families[] = 'Bitter:400,700';

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		}
		return $fonts_url;
	}
}

function dgc_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on dgc-theme, use a find and replace
	 * to change 'textdomain' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'textdomain', get_template_directory() . '/languages' );
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'textdomain' ),
	) );

	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );
	add_image_size( 'full-post-thumbnails', 900, 400, true );
	add_image_size( 'slider-thumb', 608, 300, true );
	add_image_size( 'main-slider', 1920, 900, true );

	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', dgc_fonts_url() ) );
	
	$defaults = array(
		'default-color'          => 'fff',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
		);
	/*add_theme_support( 'custom-background', $defaults );*/
	
	add_filter( 'use_default_gallery_style', '__return_false' );
	
}
endif; 
add_action( 'after_setup_theme', 'dgc_setup' );
// dgc_setup

if ( ! function_exists( 'dgc_wp_title' ) ) {
	function dgc_wp_title( $title, $sep ) {
		global $paged, $page;
		if ( is_feed() ) return $title;

		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
 			$title = "$title $sep $site_description";
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'textdomain' ), max( $paged, $page ) );
		return $title;
	}
}
add_filter( 'wp_title', 'dgc_wp_title', 10, 2 );

//Change thumbnail size by parameter sidebar
if ( ! function_exists( 'dgc_thumbnail_size' ) ) {
	function dgc_thumbnail_size( $html, $post_id ) {
		$options = dgc_get_theme_options();
		if (($options['layout_page_templ'] === '0' && is_page() )||
			($options['layout_single_templ']  === '0'  && is_single()) ||
			($options['layout_tag_templ']  === '0' && is_archive()) ||
			($options['layout_cat_templ'] === '0' && is_archive()) ||
			($options['layout_archive_templ'] === '0' && is_archive())) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
			$html = '<img class="attachment-post-thumbnail wp-post-image" src="'.$src[0].'"/>';
		}
		return $html;
	}
}
add_filter( 'post_thumbnail_html', 'dgc_thumbnail_size', 0, 5 );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since dgc-theme 1.0
 */
if ( ! function_exists( 'dgc_widgets_init' ) ) {
	function dgc_widgets_init() {
	
		register_sidebar( array(
			'name' => __( 'Footer Widget 1', 'textdomain' ),
			'id' => 'footer-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Footer Widget 2', 'textdomain' ),
			'id' => 'footer-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Footer Widget 3', 'textdomain' ),
			'id' => 'footer-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Footer Widget 4', 'textdomain' ),
			'id' => 'footer-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Main Sidebar', 'textdomain' ),
			'id' => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'textdomain' ),
			'id' => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Single Post Sidebar', 'textdomain' ),
			'id' => 'sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		register_sidebar( array(
			'name' => __( 'Homepage Sidebar', 'textdomain' ),
			'id' => 'sidebar-4',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		if (class_exists('woocommerce')){
			register_sidebar( array(
				'name' => __( 'Shop Page Sidebar', 'textdomain' ),
				'id' => 'sidebar-5',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		
			register_sidebar( array(
				'name' => __( 'Product Page Sidebar', 'textdomain' ),
				'id' => 'sidebar-6',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
	}
	add_action( 'widgets_init', 'dgc_widgets_init' );
}

/**
 * Enqueue scripts and styles
 */
if ( ! function_exists( 'dgc_scripts' ) ) {
	function dgc_scripts() {
		global $post;
		$prefix 	   = '_dgc_';
		$slider_layout = false;
		$theme_options  = dgc_get_theme_options();
		$front_page_id  = get_option('page_on_front');
		$blog_page_id   = get_option('page_for_posts ');
	
		if (is_page() && !is_front_page() && !is_home()) {
			$slider_layout  = get_post_meta( $post->ID, $prefix . 'slider_layout', true);
		} elseif(!is_front_page() && is_home() && ($blog_page_id != 0)) {
			/*Only for blog posts loop*/
			$slider_layout  = get_post_meta( $blog_page_id, $prefix . 'slider_layout', true);
		} elseif (is_front_page()) {
			$slider_layout  = get_post_meta( $front_page_id, $prefix . 'slider_layout', true);
		}	
	
		if ($slider_layout) {
			if (isset($theme_options['select_slider'])) {
				if ($theme_options['select_slider'] == "1") {
					wp_enqueue_style( 'flex-slider', 		get_template_directory_uri() . '/js/flex_slider/slider.css');
					wp_enqueue_script('flex-fitvid-j',		get_template_directory_uri() . '/js/flex_slider/jquery.flexslider-min.js', array( 'jquery' ), '20130930', false );
					wp_enqueue_script('flex-froogaloop-j',	get_template_directory_uri() . '/js/flex_slider/froogaloop.js', 	array( 'jquery' ), '20130930', false );
					wp_enqueue_script('flex-easing-j', 		get_template_directory_uri() . '/js/flex_slider/jquery.easing.js', 	array( 'jquery' ), '20130930', false );
					wp_enqueue_script('flex-fitvid-j',		get_template_directory_uri() . '/js/flex_slider/jquery.fitvid.js', 	array( 'jquery' ), '20130930', false);
					wp_enqueue_script('flex-mousewheel-j',	get_template_directory_uri() . '/js/flex_slider/jquery.mousewheel.js', array( 'jquery' ), '20130930', false );
					wp_enqueue_script('flex-modernizr-j',	get_template_directory_uri() . '/js/flex_slider/modernizr.js', array( 'jquery' ), '20130930', false );
				} else if ($theme_options['select_slider'] == "2") {
					wp_enqueue_style( 'nivo-bar-skin', 		get_template_directory_uri() . '/js/nivo_slider/skins/bar/bar.css');
					wp_enqueue_style( 'nivo-dark-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/dark/dark.css');
					wp_enqueue_style( 'nivo-default-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/default/default.css');
					wp_enqueue_style( 'nivo-light-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/light/light.css');
					wp_enqueue_style( 'nivo-style', 		get_template_directory_uri() . '/js/nivo_slider/nivo-slider.css');
					wp_enqueue_script('nivo-slider',		get_template_directory_uri() . '/js/nivo_slider/jquery.nivo.slider.pack.js', array( 'jquery' ), '20130930', false );
				}
			}
		}
	
		/*add woocommerce styles for ie*/
		wp_enqueue_style( 'ie-style', get_template_directory_uri() . '/woocommerce/ie.css');
	
		/*add fancybox*/
		wp_enqueue_script('fn-box',				get_template_directory_uri() . '/js/fnBox/jquery.fancybox.pack.js',   array( 'jquery' ), '20140525', false );
		wp_enqueue_style( 'fn-box-style',		get_template_directory_uri() . '/js/fnBox/jquery.fancybox.css');
	
		wp_enqueue_script('fancy-select',		get_template_directory_uri() . '/js/fancySelect.js',   array( 'jquery' ), '20140525', false );
		wp_enqueue_style( 'fancy-select',		get_template_directory_uri() . '/css/fancySelect.css');
	
		wp_enqueue_script('resp-dropdown',		get_template_directory_uri() . '/js/mobile-dropdown.min.js', 	array( 'jquery' ), '20130930', false );
		wp_enqueue_script('init',				get_template_directory_uri() . '/js/init.min.js', array( 'jquery' ), '20130930', false );
	
		$is_fixed_header = -1;
		if (isset($theme_options['is_fixed_header']) && ($theme_options['is_fixed_header'] == 'on')) {
			$is_fixed_header = 1;
		}
	
		wp_localize_script( 'init', 'ThGlobal', array( 
			'ajaxurl' 				  => admin_url( 'admin-ajax.php' ), 													   
			'is_fixed_header' 		  => $is_fixed_header,													   
			'mobile_menu_default_text' => __('Navigate to...', 'textdomain'),											
			) 
		);  
	
		wp_enqueue_script('small-menu-select', get_template_directory_uri() . '/js/small-menu-select.js', array( 'jquery' ), '20130930', false );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'dgc_scripts' );
}

if ( ! function_exists( 'dgc_get_link_url' ) ) {
	function dgc_get_link_url() {
		$content = get_the_content();
		$has_url = get_url_in_content( $content );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}

/*check googleapis custom fonts*/
if ( ! function_exists( 'dgc_check_gg_custom_fonts' ) ) {
	function dgc_check_gg_custom_fonts($inFont = null) {
		$font_name = null;
		$http_ = 'http://';
		if (is_ssl()) {
			$http_ = 'https://';
		}
		
		$fonts_ = array();
		$fonts_[] = 'fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300&subset=latin,latin-ext';
		$fonts_[] = 'fonts.googleapis.com/css?family=Lobster&subset=cyrillic-ext,latin-ext,latin,cyrillic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Josefin+Slab:400,100,100italic,300,300italic,400italic,600,600italic,700,700italic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Arvo:400,400italic,700,700italic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Vollkorn:400,400italic,700,700italic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Abril+Fatface';
		$fonts_[] = 'fonts.googleapis.com/css?family=Ubuntu:400,300italic,400italic,500,500italic,700,700italic,300&subset=latin,greek,latin-ext,cyrillic';
		$fonts_[] = 'fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,cyrillic';
		$fonts_[] = 'fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic,700';
		$fonts_[] = 'fonts.googleapis.com/css?family=Droid+Sans:400,700';	

		if (!empty($inFont)) {
			$font_name = $inFont;
			$font_name = urlencode(substr($font_name, 0, strrpos($font_name, ',')));
			$in 	   = preg_quote($font_name, '~'); 	
			$res	   = preg_grep('~' . $in . '~', $fonts_);
			if (!empty($res)) {
				return $http_ . current($res);
			} else {
				return null;
			}
		}
	}
}	
		
/*function for including google fonts*/
if ( ! function_exists( 'dgc_add_custom_fonts' ) ) {
	function dgc_add_custom_fonts() {
		$font_url = array();
		$theme_options = dgc_get_theme_options();
		
		if (isset($theme_options['h_font_family'])) $font_url[] = dgc_check_gg_custom_fonts(esc_attr($theme_options['h_font_family']));
		if (isset($theme_options['m_font_family'])) $font_url[] = dgc_check_gg_custom_fonts(esc_attr($theme_options['m_font_family']));
		if (isset($theme_options['p_font_family'])) $font_url[] = dgc_check_gg_custom_fonts(esc_attr($theme_options['p_font_family']));
		
		$font_url = array_filter($font_url);
		$font_url = array_unique($font_url);
		
		if (!empty($font_url)) {
			foreach ($font_url as $font) {
				$unq_id = uniqid('custom_fonts_');
				wp_register_style($unq_id, $font);
				wp_enqueue_style($unq_id);
			}
		}	
	}
}

/*Slider*/
if (!function_exists('dgc_get_slider_layout_flex')) {
	function dgc_get_slider_layout_flex() {
		global $post;
		$out = "";
		$prefix = '_dgc_';	
		$slider_layout = false;
		$theme_options  = dgc_get_theme_options();
		$front_page_id  = get_option('page_on_front');
		$blog_page_id   = get_option('page_for_posts ');
		
		if (is_page() && !is_front_page() && !is_home()) {
			$slider_layout  = get_post_meta( $post->ID, $prefix . 'slider_layout', true);
		} elseif(!is_front_page() && is_home() && ($blog_page_id != 0)) {
			/*Only for blog posts loop*/
			$slider_layout  = get_post_meta( $blog_page_id, $prefix . 'slider_layout', true);
		} elseif (is_front_page()) {
			$slider_layout  = get_post_meta( $front_page_id, $prefix . 'slider_layout', true);
		}	
			
		if(!empty($slider_layout) && ($slider_layout)) {
			$out .= '$(".flexslider").flexslider({';
			$out .= 'animation: "'			. esc_attr($theme_options['s_animation'])		.'",';
			$out .= 'direction: "'  		. esc_attr($theme_options['s_direction'])   	.'",';
			$out .= 'reverse: '				. esc_attr($theme_options['s_reverse']) 		. ',';
			$out .= 'slideshow: ' 		  	. esc_attr($theme_options['s_slideshow']) 		. ',';
			$out .= 'slideshowSpeed: ' 		. esc_attr($theme_options['s_slideshowSpeed']) 	. ',';
			$out .= 'animationSpeed: ' 		. esc_attr($theme_options['s_animationSpeed']) 	. ',';
			$out .= 'controlNav: ' 			. esc_attr($theme_options['s_controlnav']) 		. ',';
			$out .= 'touch: ' 				. esc_attr($theme_options['s_touch']) 			. ',';
			
			if (isset($theme_options['s_initDelay'])) {
				$out .= 'initDelay: ' . $theme_options['s_initDelay'] .',';
			}
			$out .= 'randomize: '	. $theme_options['s_randomize'];
			$out .= '});';
		}
		
		return $out;
	}	  
}

if (!function_exists('dgc_get_slider_layout_nivo')) {
	function dgc_get_slider_layout_nivo() {
		global $post;
		$out = "";
		$prefix = '_dgc_';	
		$slider_layout = false;
		$theme_options  = dgc_get_theme_options();
		$front_page_id  = get_option('page_on_front');
		$blog_page_id   = get_option('page_for_posts ');
		
		if (is_page() && !is_front_page() && !is_home()) {
			$slider_layout  = get_post_meta( $post->ID, $prefix . 'slider_layout', true);
		} elseif(!is_front_page() && is_home() && ($blog_page_id != 0)) {
			/*Only for blog posts loop*/
			$slider_layout  = get_post_meta( $blog_page_id, $prefix . 'slider_layout', true);
		} elseif (is_front_page()) {
			$slider_layout  = get_post_meta( $front_page_id, $prefix . 'slider_layout', true);
		}	
		
		if(!empty($slider_layout) && ($slider_layout)){
			$out .= '$(".nivoSlider").nivoSlider({' . "\n";
			$out .= 'effect: "'				. esc_attr($theme_options['nv_animation'])		. '",';
			$out .= 'slices: '				. esc_attr($theme_options['nv_slice'])			.  ',';
			$out .= 'boxCols: '				. esc_attr($theme_options['nv_boxCols'])		.  ',';
			$out .= 'boxRows: '				. esc_attr($theme_options['nv_boxRows'])		.  ',';
			$out .= 'animSpeed: '			. esc_attr($theme_options['nv_animSpeed'])		.  ',';
			$out .= 'pauseTime: '			. esc_attr($theme_options['nv_pauseTime'])		.  ',';
			$out .= 'startSlide:' . (isset($theme_options['nv_startSlide']) ? $theme_options['nv_startSlide'] : 0) . ',';
			$out .= 'directionNav: '		. esc_attr($theme_options['nv_directionNav'])		.  ',';
			$out .= 'controlNav: '			. esc_attr($theme_options['nv_controlNav'])			.  ',';
			$out .= 'controlNavThumbs: '	. esc_attr($theme_options['nv_controlNavThumbs'])	.  ',';
			$out .= 'pauseOnHover: '		. esc_attr($theme_options['nv_pauseOnHover'])	.  ',';
			$out .= 'manualAdvance: '		. esc_attr($theme_options['nv_manualAdvance'])	.  ',';
			$out .= 'prevText: "'			. esc_attr($theme_options['nv_prevText'])		.  '",';
			$out .= 'nextText: "'			. esc_attr($theme_options['nv_nextText'])		.  '",';
			$out .= 'randomStart: '			. esc_attr($theme_options['nv_randomStart']);
			$out .= '});';
		}
		
		return $out;
	}
}

if (!function_exists('dgc_get_slider')) {
	function dgc_get_slider() {
		if (is_404()) return;
		global $post;
		$prefix 	= '_dgc_';
		$slider_  	= $slider_layout = '';
		$id 		= 'dgc-slider-'.rand(1, 250); 	
		
		$theme_options  = dgc_get_theme_options();
		$front_page_id  = get_option('page_on_front');
		$blog_page_id   = get_option('page_for_posts ');
		
		if (is_page() && !is_front_page() && !is_home()) {
			$slider_layout  = get_post_meta( $post->ID, $prefix . 'slider_layout', true);
		} elseif(!is_front_page() && is_home() && ($blog_page_id != 0)) {
			/*Only for blog posts loop*/
			$slider_layout  = get_post_meta( $blog_page_id, $prefix  . 'slider_layout', true);
		} elseif (is_front_page()) {
			$slider_layout  = get_post_meta( $front_page_id, $prefix . 'slider_layout', true);
		}	
		
		/*Full Backend Options*/
		if(!empty($theme_options['slides']) && (count($theme_options['slides']) > 0)) {
			foreach ($theme_options['slides'] as $key=>$slide) {
				$path_to_img = $val = '';
				$val = wp_get_attachment_image_src( esc_attr($slide['attach_id']), 'main-slider');
				$path_to_img = esc_url_raw($val[0]);
			}
			
			if ($path_to_img){
				if ($theme_options['select_slider'] == "1") {
						
					if ($slider_layout == 1) {
						$slider_ .= '<div class="main-slider-container fullwidth">';
					} else {
						$slider_ .= '<div class="main-slider-container">';
					}
						$slider_ .= '<section class="slider">';
							$slider_ .= '<div class= "flexslider" id="' . $id . '">';
								$slider_ .= '<ul class="slides">';
								foreach ($theme_options['slides'] as $key=>$slide) {
									if (isset($slide['is_active']) && $slide['is_active'] == 'on') { //ERICH is_active
                                        $val = wp_get_attachment_image_src( esc_attr($slide['attach_id']), 'main-slider');
                                        $path_to_img = esc_url_raw($val[0]);
                                        $slider_ .= '<li>';
                                        if (!empty($slide['link'])) {
                                            if (!empty($slide['is_blank'])) {
                                                $slider_ .= '<a href="'.esc_url($slide['link']).'" target="_blank">';
                                            } else {
                                                $slider_ .= '<a href="'.esc_url($slide['link']).'">';
                                            }
                                            $slider_ .= '<img src="'.$path_to_img.'" />';
                                            $slider_ .= '</a>';
                                        } else {
                                            $slider_ .= '<img src="'.$path_to_img.'" />';
                                        }
                                        $slider_ .= '</li>';
                                    }
								}
								$slider_ .= '</ul></div></section></div>';
									
				} else if ($theme_options['select_slider'] == "2") {
						
						if ($slider_layout == 1) {
							$slider_ .= '<div class="main-slider-container slider-wrapper fullwidth '. $theme_options['nv_skins'] .'">';
						} else {
							$slider_ .= '<div class="main-slider-container slider-wrapper '. $theme_options['nv_skins'] .'">'; 
						}
						
							$slider_ .= '<div id="nivo-slider-'. $id . '" class="nivoSlider">';
							foreach ($theme_options['slides'] as $key=>$slide) {
								if ( $slide['is_active'] == 'on' ) //ERICH is_active
                                                                {
									$val = wp_get_attachment_image_src( esc_attr($slide['attach_id']), 'main-slider');
									$path_to_img = esc_url_raw($val[0]);
									if (!empty($slide['link'])) {
										if (!empty($slide['is_blank'])) {
											$slider_ .= '<a href="'.esc_url($slide['link']).'" target="_blank">';
										} else {
											$slider_ .= '<a href="'.esc_url($slide['link']).'">';
										}	
											$slider_ .= '<img src="'. $path_to_img .'" data-thumb="'. $path_to_img .'" alt="" />';
										$slider_ .= '</a>';	
									} else {
										$slider_ .= '<img src="'. $path_to_img .'" data-thumb="'. $path_to_img .'" alt="" />';
									}
								}
							}	
							$slider_ .= '</div>';
						$slider_ .= '</div>';
				}	
			} else {
				$slider_ = '<div class="main-slider-container">';
					$slider_ .= '<section class="slider"><h3 class="no-slider-text">'. __('Please add images for slider in theme options!', 'textdomain') .'</h3></section>';
				$slider_ .= '</div>';
			}
		} else {
			$slider_ = '<div class="main-slider-container">';
				$slider_ .= '<section class="slider"><h3 class="no-slider-text">'. __('Please add images for slider in theme options!', 'textdomain') .'</h3></section>';
			$slider_ .= '</div>';
		}
		
		if (!empty($slider_layout)) {
			if ($slider_layout != 1) {
				$slider_ = '<div class="container"><div class="sixteen columns">' . $slider_ . '</div></div>';
			} 
			echo '<div id="slider-container">'.$slider_.'</div>';
		}
	}
}

/*Get logo img*/
if (!function_exists('dgc_get_logo')) {
	function dgc_get_logo () {
		$theme_options  = dgc_get_theme_options();
		if (!empty($theme_options['logo_w'])) {$logo_w = intval($theme_options['logo_w']); }
		if (!empty($theme_options['logo_h'])) {$logo_h = intval($theme_options['logo_h']); }
		$url_logo = $url_retina_logo = '';
	
		if (!empty($theme_options['logo_img'])) { $url_logo_id	= esc_attr($theme_options['logo_img']); } else { $url_logo_id 	= ''; }
		if (!empty($logo_w)) { $logo_width	= $logo_w; } else { $logo_width 	= ''; }
		if (!empty($logo_h)) { $logo_height = $logo_h; } else { $logo_height 	= ''; }		
		if (!empty($theme_options['logo_img_retina'])) { $url_retina_logo_id	= esc_attr($theme_options['logo_img_retina']); } else { $url_retina_logo_id 	= ''; }
		if (!empty($logo_w)) { $logo_retina_width	= $logo_width; } else { $logo_retina_width 	= ''; }
		if (!empty($logo_h)) { $logo_retina_height = $logo_height; } else { $logo_retina_height 	= ''; }	
	
		/*Full Backend Options*/
		$description  = $name = '';
		$description  = esc_attr(get_bloginfo('description'));
		$name  		  = esc_attr(get_bloginfo('name'));
	
		if (!empty($url_logo_id) || !empty($url_retina_logo_id)) {
			$url_logo = wp_get_attachment_image_src($url_logo_id, 'full');
			if (!empty($url_logo)) {
				$image_link = esc_url_raw($url_logo[0]);
			} else {
				$image_link = $url_logo_id;
			}			
			
			$url_retina_logo = wp_get_attachment_image_src($url_retina_logo_id, 'full');
			if (!empty($url_retina_logo)) {
				$image_link_retina = esc_url_raw($url_retina_logo[0]);
			} else {
				$image_link_retina = $url_retina_logo_id;
			}	

			if (!empty($url_logo_id)) 	echo  '<a class="link-logo" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. $image_link  .'" width="' . $logo_width . '" height="' . $logo_height . '" alt="' . $description . '"/></a>';
			if (!empty($url_retina_logo_id)) echo  '<a class="link-logo-retina" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><img class="logo retina" src="'. $image_link_retina	  .'" width="' . $logo_retina_width . '" height="' . $logo_retina_height . '" alt="' . $description . '"/></a>';
			if (!empty($url_logo_id) && empty($url_retina_logo_id)) echo  '<a class="link-logo-retina" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><img class="logo retina" src="'. $image_link  .'" width="' . $logo_retina_width . '" height="' . $logo_retina_height . '" alt="' . $description . '"/></a>';
			if (empty($url_logo_id) && !empty($url_retina_logo_id)) echo  '<a class="link-logo" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. $image_link_retina  .'" width="' . $logo_width . '" height="' . $logo_height . '" alt="' . $description . '"/></a>';								
			
		} else {
			echo  '<a class="logo-description" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><h1 class="site-title">'. $name .'</h1><h2 class="site-description">'. $description .'</h2></a>';
		}	
	}
}

/*Get Favicon*/
if (!function_exists('dgc_get_favicon')) {
	function dgc_get_favicon () {
		$out_fav_html = null;
		$url_favicon = $fav_icon_iphone = $fav_icon_iphone_retina = $fav_icon_ipad = $fav_icon_ipad_retina = null;
		$theme_options = dgc_get_theme_options();
		
		if (!empty($theme_options['fav_icon'])) {
			$fav_icon_url = esc_attr($theme_options['fav_icon']);
			$fav_icon_id = wp_get_attachment_image_src($fav_icon_url, 'full');
			if (!empty($fav_icon_id)) {
				$image_link = esc_url_raw($fav_icon_id[0]);
			} else {
				$image_link = $fav_icon_url;
			}	
			
			$out_fav_html .=  '<link rel="shortcut icon" href="'. esc_url($image_link) .'">';	
			$out_fav_html .=  '<link rel="apple-touch-icon-precomposed" sizes="16x16" href="'. $image_link .'">';	
		} 	
		
		if (!empty($theme_options['fav_icon_iphone'])) {
			$fav_icon_iphone_url = esc_attr($theme_options['fav_icon_iphone']);
			$fav_icon_iphone_id = wp_get_attachment_image_src($fav_icon_iphone_url, 'full');
			if (!empty($fav_icon_iphone_id)) {
				$image_link = esc_url_raw($fav_icon_iphone_id[0]);
			} else {
				$image_link = $fav_icon_iphone_url;
			}				
			
			$out_fav_html .= '<link rel="apple-touch-icon" 	href="' .esc_url($image_link) .'">';
		}
		
		if (!empty($theme_options['fav_icon_iphone_retina'])) {
			$fav_icon_iphone_retina_url = esc_attr($theme_options['fav_icon_iphone_retina']);
			$fav_icon_iphone_retina_id = wp_get_attachment_image_src($fav_icon_iphone_retina_url, 'full');
			if (!empty($fav_icon_iphone_retina_id)) {
				$image_link = esc_url_raw($fav_icon_iphone_retina_id[0]);
			} else {
				$image_link = $fav_icon_iphone_retina_url;
			}
			
			$out_fav_html .= '<link rel="apple-touch-icon" sizes="114x114" 	href="'. esc_url($image_link) .' ">';
		}
		
		if (!empty($theme_options['fav_icon_ipad'])) {
			$fav_icon_ipad_url = esc_attr($theme_options['fav_icon_ipad']);
			$fav_icon_ipad_id = wp_get_attachment_image_src($fav_icon_ipad_url, 'full');
			if (!empty($fav_icon_ipad_id)) {
				$image_link = esc_url_raw($fav_icon_ipad_id[0]);
			} else {
				$image_link = $fav_icon_ipad_url;
			}	
			
			$out_fav_html .= '<link rel="apple-touch-icon" sizes="72x72" 	href="'. esc_url($image_link) .'">'; 
		}
		
		if (!empty($theme_options['fav_icon_ipad_retina'])) {
			$fav_icon_ipad_retina_url = esc_attr($theme_options['fav_icon_ipad_retina']);
			$fav_icon_ipad_retina_id = wp_get_attachment_image_src($fav_icon_ipad_retina_url, 'full');
			if (!empty($fav_icon_ipad_retina_id)) {
				$image_link = esc_url_raw($fav_icon_ipad_retina_id[0]);
			} else {
				$image_link = $fav_icon_ipad_retina_url;
			}		
			
			$out_fav_html .= '<link rel="apple-touch-icon" sizes="144x144" 	href="'. esc_url($image_link) .'">'; 
		}
		
		echo $out_fav_html;
	}
}

/*Get footer text*/
if (!function_exists('dgc_get_footer_text')) {
	function dgc_get_footer_text () {
		$out_footer_text = $footer_text = '';
		$theme_options   = dgc_get_theme_options(); 
		if (!empty($theme_options['footer_text'])) {
			$footer_text = dgc_kses_data(stripslashes($theme_options['footer_text']));
			
			if (is_home() || is_front_page()) {
				$out_footer_text .= $footer_text;
			} else {
				$out_footer_text .= '<nofollow>';
					$out_footer_text .= $footer_text;
				$out_footer_text .= '</nofollow>';				
			}		
			echo $out_footer_text;
		}	
	}
}

/*Get position for social icons*/
if (!function_exists('dgc_is_social_header')) {
	function dgc_is_social_header () {
		$pos = false;
		$theme_options = dgc_get_theme_options(); 
		if(!empty($theme_options['sl_position']))	{ $pos =  esc_attr($theme_options['sl_position']); }
		return $pos;
	}
}

/*Get footer social icons*/
if (!function_exists('dgc_get_socials_icon')) {
	function dgc_get_socials_icon () {
		$out = '';
		$theme_options  = dgc_get_theme_options(); 
		
		if(!empty($theme_options['facebook_url'])) 		{ $out .= '<a class="facebook" 	 title="facebook"	href="'	.	esc_url($theme_options['facebook_url']) 	. '" target="_blank"><i class="fa"></i></a>'; }
		if(!empty($theme_options['twitter_url']))		{ $out .= '<a class="twitter" 	 title="twitter"	href="'	.	esc_url($theme_options['twitter_url']) 		. '" target="_blank"><i class="fa"></i></a>'; }
		if(!empty($theme_options['linkedin_url'])) 		{ $out .= '<a class="linkedin" 	 title="linkedin"	href="'	.	esc_url($theme_options['linkedin_url']) 	. '" target="_blank"><i class="fa"></i></a>'; }
		if(!empty($theme_options['myspace_url'])) 		{ $out .= '<a class="myspace" 	 title="myspace"	href="'	.	esc_url($theme_options['myspace_url']) 		. '" target="_blank"></a>'; }	
		if(!empty($theme_options['googleplus_url'])) 	{ $out .= '<a class="googleplus" title="google+"	href="'	.	esc_url($theme_options['googleplus_url']) 	. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['dribbble_url'])) 	 	{ $out .= '<a class="dribbble" 	 title="dribbble"	href="'	.	esc_url($theme_options['dribbble_url']) 	. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['skype_link'])) 		{ $out .= '<a class="skype" 	 title="skype"		href="skype:'.esc_attr($theme_options['skype_link'])	. '?call"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['flickr_link'])) 		{ $out .= '<a class="flickr" 	 title="flickr"		href="' 	.esc_url($theme_options['flickr_link']) 	. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['youtube_url'])) 		{ $out .= '<a class="youtube" 	 title="youtube"	href="'	.	esc_url($theme_options['youtube_url']) 		. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['vimeo_url'])) 		{ $out .= '<a class="vimeo" 	 title="vimeo"		href="'	.	esc_url($theme_options['vimeo_url']) 		. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['rss_link'])) 			{ $out .= '<a class="rss" 		 title="rss"		href="'	.	esc_url($theme_options['rss_link']) 		. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['vk_link'])) 			{ $out .= '<a class="vk" 		 title="vk"			href="'	.	esc_url($theme_options['vk_link'])			. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['instagram_url']))		{ $out .= '<a class="instagram"	 title="instagram"	href="'	.	esc_url($theme_options['instagram_url'])	. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['pinterest_url']))		{ $out .= '<a class="pinterest"	 title="pinterest"	href="'	.	esc_url($theme_options['pinterest_url'])	. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['yelp_url']))			{ $out .= '<a class="yelp"		 title="yelp"		href="'	.	esc_url($theme_options['yelp_url'])			. '" target="_blank"></a>'; }			
		if(!empty($theme_options['email_link'])) 		{ $out .= '<a class="email" 	 title="email"		href="mailto:'.sanitize_email($theme_options['email_link']). '"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['github_link'])) 		{ $out .= '<a class="github" 	 title="github"		href="'	.	esc_url($theme_options['github_link']) 		. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['tumblr_link'])) 		{ $out .= '<a class="tumblr" 	 title="tumblr"		href="'	.	esc_url($theme_options['tumblr_link']) 		. '" target="_blank"><i class="fa"></i></a>'; }			
		if(!empty($theme_options['soundcloud_link'])) 	{ $out .= '<a class="soundcloud" title="soundcloud" href="'	.	esc_url($theme_options['soundcloud_link']) 	. '" target="_blank"><i class="fa"></i></a>'; }		
		if(!empty($theme_options['tripadvisor_link'])) 	{ $out .= '<a class="tripadvisor" title="tripadvisor" href="'	.	esc_url($theme_options['tripadvisor_link']) 	. '" target="_blank"><i class="fa"></i></a>'; }	
		if(!empty($theme_options['ello_link'])) 	{ $out .= '<a class="ello" title="ello" href="'	.	esc_url($theme_options['ello_link']) 	. '" target="_blank"></a>'; }			
		
		echo '<div class="ff-social-icon social-icon">' . $out . '</div>';
	}
}


/*Enable Comment*/
if ( ! function_exists( 'dgc_state_post_comment' ) ) {
	function dgc_state_post_comment () {
		$theme_options  = dgc_get_theme_options(); 
		if (!empty($theme_options['postcomment'])) {
			return ($theme_options['postcomment'] == "on");
		} else {
			return false;
		}	
	}
}

if ( ! function_exists( 'dgc_state_page_comment' ) ) {
	function dgc_state_page_comment () {
		$theme_options  = dgc_get_theme_options(); 
		if (!empty($theme_options['pagecomment'])) {
			return ($theme_options['pagecomment'] == "on");
		} else {
			return false;
		}	
	}
}

/*Compress code*/
if ( ! function_exists( 'dgc_compress_code' ) ) {				
	function dgc_compress_code($code) {
		$code = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
		$code = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $code);
    
		return $code;
	}
}  

if ( ! function_exists( 'dgc_hex2rgb' ) ) {
	function dgc_hex2rgb( $colour ) {
		if ( $colour[0] == '#' ) {
			 $colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}
}	

if ( ! function_exists( 'dgc_get_responsive_style' ) ) {
	function dgc_get_responsive_style () {
		$style_ = $back_style = $woo_style_ = '';
		$theme_options  = dgc_get_theme_options(); 
		dgc_add_custom_fonts();
		$rand = rand(1, 999999999999);
		if (isset($theme_options['responsive']) && ($theme_options['responsive'] == 'on')) {
			if (class_exists('woocommerce')){
				wp_enqueue_style( 'woo-style', get_template_directory_uri() . '/woocommerce/woo.css?v='. $rand);
			}
			if (!class_exists('ffs')){
				//wp_enqueue_style('fontawesome-style',  get_template_directory_uri() . '/css/font-awesome.min.css');
				wp_enqueue_style('fontawesome-style',  get_template_directory_uri() . '/assets/css/all.css');
			}
			wp_enqueue_style('main-style',  get_stylesheet_uri(), '', $rand);
		} else {
			if (class_exists('woocommerce')){
				wp_enqueue_style( 'woo-style', get_template_directory_uri() . '/woocommerce/woo-fixed.css?v='. $rand);
			}
			if (!class_exists('ffs')){
				//wp_enqueue_style('fontawesome-style',  get_stylesheet_directory_uri() . '/css/font-awesome.min.css');
				wp_enqueue_style('fontawesome-style',  get_stylesheet_directory_uri() . '/assets/css/all.css');
			}
			wp_enqueue_style('main-style',  get_stylesheet_directory_uri()  .'/fixed-style.css?v='. $rand);
		}
	 
		//if (!empty($theme_options['styletheme'])) {
			//if ($theme_options['styletheme'] == 'off') {
				
				$style_ .= 'h1 {font-size : '.esc_attr($theme_options['h1_size']) .'px; }' . "\n";
				$style_ .= 'h2 {font-size : '.esc_attr($theme_options['h2_size']) .'px; }' . "\n";
				$style_ .= 'h3 {font-size : '.esc_attr($theme_options['h3_size']) .'px; }' . "\n";
				$style_ .= 'h4 {font-size : '.esc_attr($theme_options['h4_size']) .'px; }' . "\n";
				$style_ .= 'h5 {font-size : '.esc_attr($theme_options['h5_size']) .'px; }' . "\n";
				$style_ .= 'h6 {font-size : '.esc_attr($theme_options['h6_size']) .'px; }' . "\n";
	 
				$style_ .= 'h1, h2, h3, h4, h5, h6 {font-family : '. esc_attr($theme_options['h_font_family']) .'; } ' . "\n";
				$style_ .= '.main-navigation a     {font-family : '. esc_attr($theme_options['m_font_family']) .'; color : '.esc_attr($theme_options['menu_font_color']). '; } ' . "\n";
				$style_ .= '.main-navigation ul:not(.sub-menu) > li > a, .main-navigation ul:not(.sub-menu) > li:hover > a   { font-size : '.esc_attr($theme_options['m_size']) .'px;    } ' . "\n";
								
				if (!empty($theme_options['menu_bg_color'])) { 
					$style_ .= '.main-navigation {background-color : ' .esc_attr($theme_options['menu_bg_color']) . '; }' . "\n";  
				}
	   
				$style_ .= '#header-language-select a {font-family : '.  esc_attr($theme_options['m_font_family']) .';} ' . "\n";
				$style_ .= 'body {font-size : '. esc_attr($theme_options['p_size']) .'px; font-family : ' . esc_attr($theme_options['p_font_family']) . '; }' . "\n";
	 	  
				if(!empty($theme_options['background_color'])) { 
					$back_style .= ' background-color : '. esc_attr($theme_options['background_color']) .'; '; 
				}
				if(!empty($theme_options['backgroung_img'])) { 
					$bg_url = esc_attr($theme_options['backgroung_img']); 
					$image_attributes = wp_get_attachment_image_src($bg_url, 'full'); 
	
					if (!empty($image_attributes)) {
						$image_link = esc_url_raw($image_attributes[0]);
					} else {
						$image_link = $bg_url;
					}	
					
					if(isset($theme_options['bg_repeating']) && ($theme_options['bg_repeating'] == 'on')) { 
						$back_style .= 'background-image : url(' .$image_link .'); background-repeat : repeat; ';  
					} else {
						$back_style .= 'background-image : url(' .$image_link .'); background-repeat : no-repeat; background-size:100% 100%; background-size:cover; background-attachment:fixed; ';  
					}
				}

				$style_ .= 'body {'. $back_style .'}' . "\n";
	 
				if(!empty($theme_options['container_bg_color'])) {
					$style_ .= '.page-container .container {background-color : '. esc_attr($theme_options['container_bg_color']) . '; } ' . "\n";
				}
	 
				/*Header styles*/
				if (($theme_options['header_bg_color']) != null) { 
					$style_ .= '.head-container, .head-container.fixed  {background-color : ' .esc_attr($theme_options['header_bg_color']) . '; }' . "\n";  
				}
				if (!empty($theme_options['header_img'])) {
					$header_url = wp_get_attachment_image_src(intval($theme_options['header_img']), 'full'); 
					if (!empty($header_url)) {
						$image_link = esc_url_raw($header_url[0]);
					} else {
						$image_link = $theme_options['header_img'];
					}	
					$style_ .= '.head-container {background-image : url(' .esc_attr($image_link) . '); } ' . "\n";  
					
					if (!empty($theme_options['header_img_size'])){
						if ($theme_options['header_img_size'] == 'full'){
							$style_ .= '.head-container {background-size :cover; background-position:center center;} ' . "\n";  
						} else {
							$style_ .= '@media only screen and (max-width:480px){'."\n";
								$style_ .= '.head-container {background-size :300px; background-position:top center;} ' . "\n"; 
							$style_ .= '}'."\n";
							$style_ .= '@media only screen and (min-width:481px) and (max-width:767px){'."\n";
								$style_ .= '.head-container {background-size :420px; background-position:top center;} ' . "\n"; 
							$style_ .= '}'."\n";
							$style_ .= '@media only screen and (min-width:768px) and (max-width:959px){'."\n";
								$style_ .= '.head-container {background-size :768px; background-position:top center;} ' . "\n"; 
							$style_ .= '}'."\n";
							$style_ .= '@media only screen and (min-width:960px){'."\n";
								$style_ .= '.head-container {background-size :960px; background-position:top center;} ' . "\n"; 
							$style_ .= '}'."\n";
						}
					}
				}
				if (!empty($theme_options['header_height'])) {
					$style_ .= '.head-container {min-height : '.esc_attr($theme_options['header_height']).'px; }' . "\n";  
				}
				if (!empty($theme_options['is_fixed_header'])) {
					if (isset($theme_options['is_fixed_header']) && ($theme_options['is_fixed_header'] == 'on')) {
						$style_ .= '.head-container {position : fixed; }' . "\n";  
					} else {
						$style_ .= '.head-container {position : relative; }' . "\n";  
					}
				}
				if (!empty($theme_options['logo_h'])) {
					$style_ .= '.site-header img {max-height : '.esc_attr($theme_options['logo_h']).'px; }' . "\n";  
				}
				if (!empty($theme_options['logo_retina_h'])) {
					$style_ .= '.site-header img {max-height : '.esc_attr($theme_options['logo_retina_h']).'px; }' . "\n";  
				}
				/*end of header styles*/
				
				if (!empty($theme_options['menu_btn_color']))    { $style_ .= '.main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a {background-color : '.esc_attr($theme_options['menu_btn_color']) . '; }' . "\n";  }
				if (!empty($theme_options['menu_hover_color']))  { $style_ .= '.main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a {color : '.esc_attr($theme_options['menu_hover_color']) . '; } ' . "\n";  }
	  
				$style_ .= '.main-navigation ul > li:hover>a {' . "\n";
					if (!empty($theme_options['menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 
	  
				/*styles for dropdown menu*/
				$style_ .= '#masthead .main-navigation ul > li > ul > li > a {' . "\n";
					if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 

				$style_ .= '#masthead .main-navigation ul > li > ul > li:hover > a {' . "\n";
					if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 
				
				$style_ .= '#masthead .main-navigation ul > li ul > li.current-menu-item > a {' . "\n";
					if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 
				
				$style_ .= '#masthead div .main-navigation ul > li > ul > li > ul a {' . "\n";
					if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 

				$style_ .= '#masthead div .main-navigation ul > li > ul > li  ul li:hover a {' . "\n";
					if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= ' } ' . "\n"; 
					
				$style_ .= '#lang-select-block li ul li a{'. "\n";
					if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
				$style_ .= '}' . "\n";
				
				$style_ .= '#lang-select-block li ul li a:hover{'. "\n";
					if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= '}' . "\n";
				
				$style_ .= '#lang-select-block li ul li.active a{'. "\n";
					if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
					if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
				$style_ .= '}' . "\n";
				/*end of styles for dropdown menu*/
				
				/*styles for responsive full width menu*/
				if (!empty($theme_options['menu_type_responsive']) && ($theme_options['menu_type_responsive'] == 'full_width')) {
					$style_ .= '.resp_full_width_menu .site-header .menu_wrapper{'. "\n";
						if (!empty($theme_options['dd_menu_bg_color'])) { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
					$style_ .= '}' . "\n";
					$style_ .= '.resp_full_width_menu .site-header .menu_wrapper .menu li a{'. "\n";
						if (!empty($theme_options['dd_menu_font_color'])) { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
					$style_ .= '}' . "\n";
					$style_ .= '.resp_full_width_menu .site-header .menu_wrapper .menu li.current-menu-item>a,'. "\n";
					$style_ .= '.resp_full_width_menu .site-header .menu_wrapper .menu li.current_page_item>a,'. "\n";
					$style_ .= '.resp_full_width_menu .site-header .menu_wrapper .menu a:hover{'. "\n";
						if (!empty($theme_options['dd_menu_btn_color'])) { $style_ .= 'background-color : '. esc_attr($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
						if (!empty($theme_options['dd_menu_hover_color'])) { $style_ .= 'color : '.esc_attr($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
					$style_ .= '}' . "\n";
				}
				/*end of styles for responsive full width menu*/
	  
				$style_ .= '#header-language-select ul li.current > a { color : '.esc_attr($theme_options['menu_font_color']). '; } ' . "\n";
				if (!empty($theme_options['menu_bg_color'])) { $style_ .= '#header-language-select { background-color : '.esc_attr($theme_options['menu_bg_color']) . '; } ' . "\n";  }
	  
				$style_ .= '#header-language-select ul li.current:hover > a { ' . "\n";
					if (!empty($theme_options['menu_btn_color'])) { $style_ .= 'background-color : '. esc_attr($theme_options['menu_btn_color']) . ';' . "\n"; }
					if (!empty($theme_options['menu_hover_color'])) { $style_ .= 'color : '.esc_attr($theme_options['menu_hover_color']) . ';' . "\n"; }
				$style_ .= '} ' . "\n";
				
				/*Add Custom Colors to theme*/
				if (!empty($theme_options['p_font_color'])) { $style_ .= 'body {color : '. esc_attr($theme_options['p_font_color']) .'; } ' . "\n"; }
				if (!empty($theme_options['widgets_sep_color'])) { 
					$style_ .= '#page .container #secondary .widget h3.widget-title, #page .container #secondary .widget h1.widget-title, header.post-header .post-title  {border-color : '. esc_attr($theme_options['widgets_sep_color']) .'; } ' . "\n";
					$style_ .= 'body.single-product #page .related.products h2  {border-bottom-color : '. esc_attr($theme_options['widgets_sep_color']) .'; } ' . "\n";
				}
				if (!empty($theme_options['a_font_color'])) { 
					
					$a_font_color = esc_attr($theme_options['a_font_color']); 
					 
					$style_ .= 'a {color : '.$a_font_color.'; }'; 
					$style_ .= '#page .container #secondary>.widget_nav_menu>div>ul>li ul>li>a:before {color : '.$a_font_color.'; }'; 
					$style_ .= '#page .container #secondary .widget ul li.cat-item a:before {color : '.$a_font_color.'; }'; 
					$style_ .= 'html[dir="rtl"] #page .container #secondary>.widget_nav_menu>div>ul>li ul>li>a:after {color : '. $a_font_color .'; }'; 
					$style_ .= 'html[dir="rtl"] #page .container #secondary .widget ul li.cat-item a:after {color : '. $a_font_color .'; }'; 
				}
				
				if (!empty($theme_options['a_hover_font_color'])) { 
					$style_ .= 'a:hover   {color : '. esc_attr($theme_options['a_hover_font_color']) .'; } '  . "\n"; 
					
					$style_ .= '#page .container #secondary>.widget_nav_menu li.current-menu-item>a {color : '. esc_attr($theme_options['a_hover_font_color']) .'; } '; 
					
					$style_ .= '#page .container #secondary>.widget_nav_menu>div>ul>li ul>li>a:hover:before,
								#page .container #secondary>.widget_nav_menu>div>ul>li ul>li.current-menu-item>a:before,
								#page .container #secondary>.widget_nav_menu>div>ul>li ul>li.current-menu-item>a:hover:before{color : '. esc_attr($theme_options['a_hover_font_color']) .'; }'; 
					
					$style_ .= '#page .container #secondary .widget ul li.current-cat>a,
								#page .container #secondary .widget ul li.cat-item ul li.current-cat a:before,
								#page .container #secondary .widget ul li.cat-item a:hover:before{color : '. esc_attr($theme_options['a_hover_font_color']) .'; }'; 
					
					$style_ .= 'html[dir="rtl"] #page .container #secondary>.widget_nav_menu>div>ul>li ul>li>a:hover:after,'; 
					$style_ .= 'html[dir="rtl"] #page .container #secondary>.widget_nav_menu>div>ul>li ul>li.current-menu-item>a:after,'; 
					$style_ .= 'html[dir="rtl"] #page .container #secondary>.widget_nav_menu>div>ul>li ul>li.current-menu-item>a:hover:after{color : '. esc_attr($theme_options['a_hover_font_color']) .'; } '  . "\n"; 

					$style_ .= 'html[dir="rtl"] #page .container #secondary .widget ul li.current-cat>a,
								html[dir="rtl"] #page .container #secondary .widget ul li.current-cat>a:after,
								html[dir="rtl"] #page .container #secondary .widget ul li.cat-item a:hover:after{color : '. esc_attr($theme_options['a_hover_font_color']) .'; } '; 
				}
				
				if (!empty($theme_options['a_focus_font_color'])) { $style_ .= 'a:focus   {color : '. esc_attr($theme_options['a_focus_font_color']) .'; } '  . "\n"; }

				if (!empty($theme_options['a_active_font_color'])) { $style_ .= 'a:active  {color : '. esc_attr($theme_options['a_active_font_color']) .'; } ' . "\n"; }
				
				if (!empty($theme_options['date_of_post_b_color'])) { 
					$style_ .= '.blog_post .date_of_post  {background : none repeat scroll 0 0 '. esc_attr($theme_options['date_of_post_b_color']) .'; } ' . "\n";
				}
				
				if (!empty($theme_options['date_of_post_f_color'])) { 
					$style_ .= '.blog_post .date_of_post  {color : '. esc_attr($theme_options['date_of_post_f_color']) .'; } ' . "\n";
				}
				
				if (!empty($theme_options['my_account_button_color'])) {
					$style_ .= '.fas fa-user {color: '. esc_attr($theme_options['my_account_button_color']) . '; }  ' . "\n"; 
				}
				
				if (!empty($theme_options['cart_color'])) {
					$woo_style_ .= '.fas fa-shopping-cart {color: '. esc_attr($theme_options['cart_color']) . '; }  ' . "\n"; 
					$woo_style_ .= '.num_of_product_cart {border-color: '. esc_attr($theme_options['cart_color']) . '; }  ' . "\n"; 
				}
				
				if (!empty($theme_options['btn_color'])) {
					$btn_color = esc_attr($theme_options['btn_color']);
					
					$style_		 .= 'button, input[type="button"], input[type="submit"], input[type="reset"], .wc-proceed-to-checkout a{background-color : '.$btn_color.' !important; } ';
					$style_		 .= 'body a.btn.btn-primary, body button.btn.btn-primary, body input[type="button"].btn.btn-primary , body input[type="submit"].btn.btn-primary {background-color : '.$btn_color.' !important; }';
					$woo_style_  .= '.woocommerce table.my_account_orders .order-actions .button, .woocommerce-page table.my_account_orders .order-actions .button{background-color : '.$btn_color.' !important; }';
					$style_ 	 .= '.nav-links.shop .pages-links .page-numbers, .nav-links.shop .nav-next a, .nav-links.shop .nav-previous a, .woocommerce .return-to-shop .button {background-color : '.$btn_color.' !important; }';
				}
				
				if (!empty($theme_options['btn_active_color'])) {
					$btn_active_color = esc_attr($theme_options['btn_active_color']);
					
					$style_ .= 'button:hover, button:active, button:focus{background-color : '.$btn_active_color.' !important; }';
					$style_ .= 'input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus{background-color : '.$btn_active_color.' !important; }';
					$style_ .= 'input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus, .wc-proceed-to-checkout a:focus, .wc-proceed-to-checkout a:hover, .wc-proceed-to-checkout a:active{background-color : '.$btn_active_color.' !important; }';
					$style_ .= 'input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus{background-color : '.$btn_active_color.' !important; }';
					$style_	.= 'body a.btn.btn-primary:hover, body button.btn.btn-primary:hover, body input[type="button"].btn.btn-primary:hover , body input[type="submit"].btn.btn-primary:hover {background-color : '.$btn_active_color.' !important; }';
					$woo_style_  .= '.woocommerce table.my_account_orders .order-actions .button:hover, .woocommerce-page table.my_account_orders .order-actions .button:hover{background-color : '.$btn_active_color.' !important; }';
					$style_ .= '.nav-links.shop .pages-links .page-numbers:hover, .nav-links.shop .nav-next a:hover, .nav-links.shop .nav-previous a:hover, .nav-links.shop .pages-links .page-numbers.current, .woocommerce .return-to-shop .button:hover {background-color : '.$btn_active_color.' !important; }';
				}
				
				/*social icons styles*/
				if (!empty($theme_options['soc_icon_bg_color'])) {
					$style_ .= '.social-icon>a>i{background:'.$theme_options['soc_icon_bg_color'].'}' . "\n";
				}

				if (!empty($theme_options['soc_icon_color'])) {
					$style_ .= '.social-icon>a>i{color:'.$theme_options['soc_icon_color'].'}' . "\n";
				}
								
				/*Woocommerce styles*/
				if (class_exists('woocommerce')){
					
					if (!empty($theme_options['woo_shop_sidebar']) && !is_tax('product_tag')) {
						$shop_sidebar_template = $theme_options['woo_shop_sidebar'];
						if ($shop_sidebar_template == 3){	/*right sidebar template*/
							$woo_style_ .= '#page .container .woo-loop-content{float:left}'."\n";
							$woo_style_ .= '#page .container .woo-loop-sidebar{float:right}'."\n";
							$woo_style_ .= '#page .container .woo-loop-sidebar #secondary{float:right}'."\n";
							$woo_style_ .= '.woocommerce .woocommerce-ordering, .woocommerce-page .woocommerce-ordering{float:left}'."\n";
						} else {
							$woo_style_ .= '#page .container .woo-loop-content{float:right}'."\n";
							$woo_style_ .= '#page .container .woo-loop-sidebar{float:left}'."\n";
							$woo_style_ .= '#page .container .woo-loop-sidebar #secondary{float:left}'."\n";
							$woo_style_ .= '.woocommerce .woocommerce-ordering, .woocommerce-page .woocommerce-ordering{float:right}'."\n";
						}
					}
					
					if (!empty($theme_options['woo_product_sidebar'])) {
						$product_sidebar_template = $theme_options['woo_product_sidebar'];
						if ($product_sidebar_template == 3){	/*right sidebar template*/
							$woo_style_ .= '.single-product #page .container .woo-loop-content{float:left}'."\n";
							$woo_style_ .= '.single-product #page .container .woo-loop-sidebar{float:right}'."\n";
							$woo_style_ .= '.single-product #page .container .woo-loop-sidebar #secondary{float:right}'."\n";
						} else {
							$woo_style_ .= '.single-product #page .container .woo-loop-content{float:right}'."\n";
							$woo_style_ .= '.single-product #page .container .woo-loop-sidebar{float:left}'."\n";
							$woo_style_ .= '.single-product #page .container .woo-loop-sidebar #secondary{float:left}'."\n";
						}
					}
					
					/*price color*/
					if (!empty($theme_options['a_hover_font_color'])) { 
						$woo_style_ .= '.woocommerce ul.products li.product .price ,
										.woocommerce-page ul.products li.product .price,
										body.woocommerce div.product span.price, 
										body.woocommerce-page div.product span.price, 
										body.woocommerce #content div.product span.price,
										body.woocommerce-page #content div.product span.price,
										body.woocommerce div.product p.price, 
										body.woocommerce-page div.product p.price,
										body.woocommerce #content div.product p.price, 
										body.woocommerce-page #content div.product p.price{color : '. esc_attr($theme_options['a_hover_font_color']) .'; }'; 
					}
					
					/*buttons color*/
					if (!empty($theme_options['btn_color'])) {
						$btn_color = esc_attr($theme_options['btn_color']);
						
						$woo_style_ .= '.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message{border-top:3px solid '.$btn_color.';}';
						$woo_style_ .= '.woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info{border-top:3px solid '.$btn_color.';}';
						$woo_style_ .= '.single-product .woocommerce-message .button{background-color:'.$btn_color.';}';
					}
					
					/*buttons hover color*/
					if (!empty($theme_options['btn_active_color']))
					$woo_style_ .= '.single-product .woocommerce-message .button:hover{background-color:'.esc_attr($theme_options['btn_active_color']).';}';
					
					if (!empty($theme_options['woo_sale_price_color'])) {
						$color_rgba = dgc_hex2rgb($theme_options['woo_sale_price_color']);
						$color = $color_rgba['red'] . ',' . $color_rgba['green'] . ',' . $color_rgba['blue'];
						$woo_style_ .= '.woocommerce ul.products li.product .price del, .woocommerce-page ul.products li.product .price del {color:rgba('.$color.',.5); }';
					}	
					
					if (!empty($theme_options['woo_rating_color_regular'])) {
						$woo_style_ .= '.woocommerce .star-rating, .woocommerce-page .star-rating,
										.woocommerce p.stars a.star-1, 
										.woocommerce p.stars a.star-2, 
										.woocommerce p.stars a.star-3, 
										.woocommerce p.stars a.star-4,
										.woocommerce p.stars a.star-5, 
										.woocommerce-page p.stars a.star-1, 
										.woocommerce-page p.stars a.star-2, 
										.woocommerce-page p.stars a.star-3, 
										.woocommerce-page p.stars a.star-4, 
										.woocommerce-page p.stars a.star-5 { 
											color:' .esc_attr($theme_options['woo_rating_color_regular']). '; }';
					}
					
					if (!empty($theme_options['woo_rating_color_active'])) {
						$woo_style_ .= '.woocommerce p.stars a.star-1:hover, 
										.woocommerce p.stars a.star-2:hover, 
										.woocommerce p.stars a.star-3:hover, 
										.woocommerce p.stars a.star-4:hover,
										.woocommerce p.stars a.star-5:hover, 
										.woocommerce-page p.stars a.star-1:hover, 
										.woocommerce-page p.stars a.star-2:hover, 
										.woocommerce-page p.stars a.star-3:hover, 
										.woocommerce-page p.stars a.star-4:hover, 
										.woocommerce-page p.stars a.star-5:hover,
										.woocommerce .star-rating:hover, .woocommerce-page .star-rating:hover { color:' .esc_attr($theme_options['woo_rating_color_active']). '; }';
					}				
				}
				
				if (class_exists('BuddyPress')){
					if (!empty($theme_options['btn_color'])) {
						$style_ .= '#buddypress input[type=submit]{background-color : '.esc_attr($theme_options['btn_color']).' !important; } ' . "\n";
					}
					if (!empty($theme_options['btn_active_color'])) {
						$style_ .= '#buddypress input[type=submit]:hover, #buddypress input[type=submit]:active, #buddypress input[type=submit]:focus{background-color : '.esc_attr($theme_options['btn_active_color']).' !important; } ' . "\n";
					}
				}
				
			//} 
			//else {
				//$style_ .= 'body {font-family:Open Sans, sans-serif}' . "\n";
			//}
		//} 
			
		if (!empty($theme_options['custom_css'])) {
			$style_ .= wp_kses_stripslashes($theme_options['custom_css']) . "\n";
		}	
		
		wp_add_inline_style( 'main-style', dgc_compress_code($style_)); 
		if ($woo_style_ != '') {
			wp_add_inline_style( 'woo-style', dgc_compress_code($woo_style_)); 
		}	
	}
	add_action('wp_enqueue_scripts', 'dgc_get_responsive_style', 99);
}

if ( ! function_exists( 'dgc_get_sliders' ) ) {
	function dgc_get_sliders() {
		global $post;
		$prefix = '_dgc_';
		$theme_options  = dgc_get_theme_options();
		$front_page_id  = get_option('page_on_front');
		$blog_page_id   = get_option('page_for_posts ');
	
		$slider_layout = 0;
		if (is_page() && !is_front_page() && !is_home()) {
			$slider_layout  = get_post_meta( $post->ID, $prefix . 'slider_layout', true);
		} elseif(!is_front_page() && is_home() && ($blog_page_id != 0)) {
			/*Only for blog posts loop*/
			$slider_layout  = get_post_meta( $blog_page_id, $prefix . 'slider_layout', true);
		} elseif (is_front_page()) {
			$slider_layout  = get_post_meta( $front_page_id, $prefix . 'slider_layout', true);
		}	
		
		if ($slider_layout){
			if (!empty($theme_options['select_slider'])) {
				if ($theme_options['select_slider'] == "1") {
					echo dgc_get_slider_layout_flex(); 
				} else if ($theme_options['select_slider'] == "2") {	
					echo dgc_get_slider_layout_nivo();
				}	
			}
		}
	}
}

/* Woocommerce functions */
if (class_exists('Woocommerce')) { 
	/*change number of products per row shop page*/
	if (!function_exists('dgc_loop_columns')) {
		function dgc_loop_columns() {
			$theme_options = dgc_get_theme_options();
			return '1';
			/*
			if (!empty($theme_options['shop_num_row'])){
				return esc_attr($theme_options['shop_num_row']);
			} else {
				return '4';
			}*/
		}
	}
	add_filter('loop_shop_columns', 'dgc_loop_columns');
	
	/*change number of products per page shop page*/
	if (!function_exists('dgc_loop_shop_per_page')) {
		function dgc_loop_shop_per_page(){
			$theme_options 	   = dgc_get_theme_options();
			$woo_shop_num_prod = get_option('posts_per_page');
			if (!empty($theme_options['woo_shop_num_prod'])) $woo_shop_num_prod  = esc_attr($theme_options['woo_shop_num_prod']);
			return $woo_shop_num_prod;
		}
	}
	add_filter( 'loop_shop_per_page', 'dgc_loop_shop_per_page', 20);
	
	/*remove sidebar from all woocommerce pages except shop page*/
	function init() {
		if ( !is_shop() && !is_product_category()) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		}
	}
	add_action( 'wp', 'init' );
	
	/*remove woocommerce sidebar on some pages*/
	if (!function_exists('dgc_remove_woo_sidebar')) {
		function dgc_remove_woo_sidebar() {
			if (dgc_get_woo_sidebar() == 1){
				remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
			}
		}
	}
	add_action('template_redirect', 'dgc_remove_woo_sidebar');
	
	/*check is woocommerce sidebar will be hidden*/
	if (!function_exists('dgc_get_woo_sidebar')) {
		function dgc_get_woo_sidebar() {
			$woo_sidebar = 2;
			
			if ( is_shop() || is_product_category() || is_tax('product_tag')) {
				$theme_options = dgc_get_theme_options();
				if (!empty($theme_options['woo_shop_sidebar'])){
					$woo_sidebar =  esc_attr($theme_options['woo_shop_sidebar']);
				} 
			}
			if ( is_product() ) {
				$theme_options = dgc_get_theme_options();
				if (!empty($theme_options['woo_product_sidebar'])){
					$woo_sidebar =  esc_attr($theme_options['woo_product_sidebar']);
				} 
			}
			return $woo_sidebar;
		}
	}
	
	/*rewrite pagenavi for woocommerce*/
	if ( ! function_exists( 'woocommerce_pagination' ) ) {
		function woocommerce_pagination() { 
			dgc_wp_corenavi();
		}
	}
	remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
	add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);

	/*change title in tabs on single product page*/
	function dgc_product_description_heading() {
	   return '';
	}
	add_filter('woocommerce_product_description_heading','dgc_product_description_heading');
	
	/*4 cross products for cart*/
	if ( ! function_exists( 'dgc_woocommerce_cross_sell_display' ) ) {
		function dgc_woocommerce_cross_sell_display() {
			
			if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
			global $woocommerce_loop, $woocommerce, $product;
			$crosssells = $woocommerce->cart->get_cross_sells();
			if ( sizeof( $crosssells ) == 0 ) return;
			$meta_query = $woocommerce->query->get_meta_query();
			$args = array(
				'post_type'           => 'product',
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 4 ),
				'no_found_rows'       => 1,
				'orderby'             => 'rand',
				'post__in'            => $crosssells,
				'meta_query'          => $meta_query
			);
			$products = new WP_Query( $args );
			//$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 4 );
			$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 1 );
			if ( $products->have_posts() ) : ?>
				<div class="cross-sells">
					<h2><?php _e( 'You may be interested in&hellip;', 'textdomain' ) ?></h2>
					<?php woocommerce_product_loop_start(); ?>
						<?php while ( $products->have_posts() ) : $products->the_post(); ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; // end of the loop. ?>
					<?php woocommerce_product_loop_end(); ?>
				</div>
			<?php endif;
			wp_reset_query();
		}
	}
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_cart_collaterals', 'dgc_woocommerce_cross_sell_display' );

    /*4 of related products per row*/
    if ( ! function_exists( 'dgc_after_single_product_summary' ) ) {
        function dgc_after_single_product_summary() {
            $args = array(
                'posts_per_page' => 2,
                'columns'        => 2,
                'orderby'        => 'rand'
            );
            dgc_woocommerce_related_products( $args );
        }
    }
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    add_action( 'woocommerce_after_single_product_summary', 'dgc_after_single_product_summary', 20 );

    /*function for change posts per row and number of related products on single product page*/
    if ( ! function_exists( 'dgc_woocommerce_related_products' ) ) {
        function dgc_woocommerce_related_products( $args = array() ){
            $defaults = array(
                'posts_per_page' => 2,
                'columns'        => 2,
                'orderby'        => 'rand'
            );
            $args = wp_parse_args( $args, $defaults );
            woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
            // wc_get_template( 'single-product/related.php', $args );
        }
    }
	
	/*Update cart contents update when products are added to the cart via AJAX */
	if ( ! function_exists( 'dgc_woocommerce_header_add_to_cart_fragment' ) ) {
		function dgc_woocommerce_header_add_to_cart_fragment( $fragments ) {
			global $woocommerce;
			$out  = '<a href= "'.get_permalink( wc_get_page_id( 'cart' ) ).'" class="cart-contents">';
			//$out .= '<div class="cart_image"></div>';
			$out .= '<div class="fas fa-shopping-cart"></div>';
			$out .= '<span class="num_of_product_cart">';
			$out .= sprintf(_n('%d ', '%d ', $woocommerce->cart->cart_contents_count, 'textdomain'), $woocommerce->cart->cart_contents_count) .'</span></a>';
			$fragments['a.cart-contents'] = $out;
			return $fragments;
		}
	}
	add_filter('woocommerce_add_to_cart_fragments', 'dgc_woocommerce_header_add_to_cart_fragment');

	/*custom shop search form*/
	function woo_custom_product_searchform( $form ) {

		$form = '<form role="search" method="get" class="woocommerce-product-search" action="' . esc_url( home_url( '/' ) ) . '">
            <label class="screen-reader-text" for="woocommerce-product-search-field-' . (isset( $index ) ? absint( $index ) : 0) . '">' . _e( '', 'textdomain' ) . '</label>
            <input type="search" id="woocommerce-product-search-field-' . (isset( $index ) ? absint( $index ) : 0) . '" class="search-field" placeholder="' . esc_attr__( 'Search products&hellip;', 'textdomain' ) . '" value="' . get_search_query() . '" name="s" />
            <input type="submit" value="' . esc_attr_x( 'Search', 'submit button', 'textdomain' ) . '" />
            <input type="hidden" name="post_type" value="product" />
        </form>';
		return $form;

	}
	add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );

	/* Shortcode for industry list included the link */
	function dgc_industry_list() {
		// Get the taxonomy's terms
		$terms = get_terms(
    		array(
        		'taxonomy'   => 'industry',
        		'hide_empty' => false,
    		)
		);

		// Check if any term exists
		if ( ! empty( $terms ) && is_array( $terms ) ) {
    		// Run a loop and print them all
    		foreach ( $terms as $term ) { ?>
        		<a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
            		<?php //echo $term->name; ?>
        		</a><?php
    		}
			echo '<div id="industry-select">';
				echo '<ul id="lang-select-block">';
					echo '<li class="current">'.__('Industries','textdomain');
						echo '<ul id="lang-select-popup">';					
						foreach($terms as $term){
							echo '<li class="unactive">';
							echo '<a class="'.$term->name.'" href="'.esc_url( get_term_link( $term ) ).'">';
								echo $term->name;
							echo '</a></li>';
						}
						echo '</ul>';
					echo '</li>';					
				echo '</ul>';
			echo '</div>';
		}
	}
	add_shortcode('dgc-industry-list','dgc_industry_list');

	/* Shortcode for publisher list included the link */
	function dgc_publisher_list() {
		// Get the taxonomy's terms
		$terms = get_terms(
    		array(
        		'taxonomy'   => 'publisher',
        		'hide_empty' => false,
    		)
		);

		// Check if any term exists
		if ( ! empty( $terms ) && is_array( $terms ) ) {
    		// Run a loop and print them all
			echo '<div id="publisher-select">';
				echo '<ul id="publisher-select-block">';
					echo '<li class="current">'.__('Publishers','textdomain');
						echo '<ul id="publisher-select-popup">';					
						foreach($terms as $term){
							echo '<li class="unactive">';
							echo '<a class="'.$term->name.'" href="'.esc_url( get_term_link( $term ) ).'">';
								echo $term->name;
							echo '</a></li>';
						}
						echo '</ul>';
					echo '</li>';					
				echo '</ul>';
			echo '</div>';
		} 	
	}
	add_shortcode('dgc-publisher-list','dgc_publisher_list');

	/* Shortcode for status list included the link */
	function dgc_status_list() {
		// Get the taxonomy's terms
		$terms = get_terms(
    		array(
        		'taxonomy'   => 'status',
        		'hide_empty' => false,
    		)
		);

		// Check if any term exists
		if ( ! empty( $terms ) && is_array( $terms ) ) {
    		// Run a loop and print them all
			echo '<div id="status-select">';
				echo '<ul id="status-select-block">';
					echo '<li class="current">'.__('Statuses','textdomain');
						echo '<ul id="status-select-popup">';					
						foreach($terms as $term){
							echo '<li class="unactive">';
							echo '<a class="'.$term->name.'" href="'.esc_url( get_term_link( $term ) ).'">';
								echo $term->name;
							echo '</a></li>';
						}
						echo '</ul>';
					echo '</li>';					
				echo '</ul>';
			echo '</div>';
		} 	
	}
	add_shortcode('dgc-status-list','dgc_status_list');

	/* Shortcode for language list included the link */
	function dgc_language_list() {
		// Get the taxonomy's terms
		$terms = get_terms(
    		array(
        		'taxonomy'   => 'language',
        		'hide_empty' => false,
    		)
		);

		// Check if any term exists
		if ( ! empty( $terms ) && is_array( $terms ) ) {
    		// Run a loop and print them all
			echo '<div id="language-select">';
				echo '<ul id="language-select-block">';
					echo '<li class="current">'.__('Languages','textdomain');
						echo '<ul id="language-select-popup">';					
						foreach($terms as $term){
							echo '<li class="unactive">';
							echo '<a class="'.$term->name.'" href="'.esc_url( get_term_link( $term ) ).'">';
								echo $term->name;
							echo '</a></li>';
						}
						echo '</ul>';
					echo '</li>';					
				echo '</ul>';
			echo '</div>';
		} 	
	}
	add_shortcode('dgc-language-list','dgc_language_list');

	/* custom search page included the search section and register section */
	function dgc_product_search_content() {

		//if (!empty($theme_options['show_feature_image']) && (esc_attr($theme_options['show_feature_image']) == 'on')) {
			//echo '<div class="dgc-search-content-with-image">';
			$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			echo '<div class="dgc-search-content" style="background: url('. $url.') no-repeat center center">';
		//} else {
			//echo '<div class="dgc-search-content">';
		//}

			//if (is_advance_search()) dgc_advance_search_html();
			
			if (is_user_logged_in()) {} else dgc_register_section_html();

			dgc_advance_search_section();

			echo '<div class="dgc-search-bar">';
				echo '<div class="dgc-search-icon"><div class="fas fa-search"></div></div>';			
				//echo '<div id="dgc-search-icon"></div>';
				//echo '<img class="search-icon" src="'.bloginfo('template_directory').'/assets/images/search.png">';
				//get_product_search_form();
				//echo do_shortcode('[wcas-search-form]');
				$short_code = '[woof_text_filter placeholder="'.dgc_get_search_placeholder().'"]';
				echo do_shortcode($short_code);
				echo '<div class="dgc-advance-search-button"><a href="#dgc-advance-search-section">'.__('Advance Search','textdomain').'</a></div>';				
			echo '</div>';

		echo '</div>';
	}
	add_shortcode('dgc-product-search-content','dgc_product_search_content');

	function dgc_advance_search_section(){
		echo '<div id="dgc-advance-search-section">';
			$short_code = '[woof is_ajax=0 sid ="flat_grey woof_auto_4_columns"]';
			echo do_shortcode($short_code);
			echo '<div id="dgc-industry-list">';
				//dgc_industry_list();
			echo '</div>';
			echo '<div class="dgc-publisher-list">';
				//dgc_publisher_list();
			echo '</div>';
			echo '<div class="dgc-status-list">';
				//dgc_status_list();
			echo '</div>';
			echo '<div class="dgc-language-list">';
				//dgc_language_list();
			echo '</div>';
		echo '</div>';
	}

	function dgc_register_section_html(){
		echo '<div class="dgc-register-section">';
			echo '<div class="dgc-register-warning">';
				echo '<div class="fas fa-user-plus"></div>';
				//echo '<img class="registration-icon" src="'.bloginfo('template_directory').'/assets/images/registration.png">';
				echo '<div class="dgc-register-text">'.dgc_get_register_text().'</div>';				
				echo '<div class="dgc-register-button"><a href="/my-account/">'.__('免费注册','textdomain').'</a></div>';
			echo '</div>';
		echo '</div>';
	}

}

/* Get search bar placeholder */
if (!function_exists('dgc_get_search_placeholder')) {
	function dgc_get_search_placeholder () {
		$out_search_placeholder = $search_placeholder = '';
		$theme_options   = dgc_get_theme_options(); 
		if (!empty($theme_options['search_placeholder'])) {
			$out_search_placeholder = esc_attr($theme_options['search_placeholder']);
			//echo $out_search_placeholder;
		}	
		return $out_search_placeholder;
	}
}

/* Get register text */
if (!function_exists('dgc_get_register_text')) {
	function dgc_get_register_text () {
		$out_register_text = $register_text = '';
		$theme_options   = dgc_get_theme_options(); 
		if (!empty($theme_options['register_text'])) {
			$register_text = dgc_kses_data(stripslashes($theme_options['register_text']));
			
			if (is_home() || is_front_page()) {
				$out_register_text .= $register_text;
			} else {
				$out_register_text .= '<nofollow>';
					$out_register_text .= $register_text;
				$out_register_text .= '</nofollow>';				
			}		
			//echo $out_register_text;
		}	
		return $out_register_text;
	}
}

if ( ! function_exists( 'dgc_custom_css_and_slider_scripts' ) ) {
	function dgc_custom_css_and_slider_scripts() {
		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function($) { ';
				dgc_get_sliders();
			echo '});';
		echo '</script>';
	}
	add_action('wp_head', 'dgc_custom_css_and_slider_scripts', 25);
}

if ( ! function_exists( 'dgc_entry_meta' ) ) {
	function dgc_entry_meta() { 
	?>
		<!-- <span class="author-link author"><a href="<?php //print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?php //print get_the_author(); ?></a></span> -->
	<?php 
		if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
		 	$categories_list = get_the_category_list( __( ', ', 'textdomain' ) );
			if ( $categories_list && dgc_categorized_blog() ) : ?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'textdomain' ), $categories_list ); ?>
			</span>
		<?php endif; // End if categories ?>

		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'textdomain' ) );
			if ( $tags_list ) : ?>
			<span class="tag-links">
				<?php // printf( __( 'Tagged %1$s', 'textdomain' ), $tags_list ); ?>
				<?php echo $tags_list; ?>
			</span> 
		<?php endif; // End if $tags_list ?>
		
	<?php endif; // End if 'post' == get_post_type() ?>
	<?php 
	}
}

if ( ! function_exists( 'dgc_entry_date' ) ) {
	function dgc_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'textdomain' );
		else
			$format_prefix = '%2$s';

		$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'textdomain' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ($echo ) echo $date;
		return $date;
	}
}

if ( ! function_exists( 'dgc_theme_options_validate' ) ) {
	function dgc_theme_options_validate($value) {
		return $value;
	}
}	

if ( ! function_exists( 'dgc_customize_preview_js' ) ) {
	function dgc_customize_preview_js() {
		wp_enqueue_script( 'dgc-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
	}
	add_action( 'customize_preview_init', 'dgc_customize_preview_js' );
}

if ( ! function_exists( 'dgc_metadevice' ) ) {
    function dgc_metadevice() {
        $browser = '';
        $browser_ip	= strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $browser_ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
        if ($browser_ip  	== true) { $browser = 'iphone';  }
        if ($browser_ipad 	== true) { $browser = 'ipad'; }

        if ( ($browser == 'iphone') || ($browser == 'ipad') ) {
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
        } else {
            echo '<meta name="viewport" content="width=device-width" />';
        }
    }
}
add_action( 'wp_head', 'dgc_metadevice' );

if ( ! function_exists( 'dgc_esc_content_pbr' ) ) {
	function dgc_esc_content_pbr($content = null) {
		 $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content );
		 $Old     = array( '<br />', '<br>' );
		 $New     = array( '','' );
		 $content = str_replace( $Old, $New, $content );
		 return $content;
	}
}

if ( ! function_exists( 'dgc_get_class_pos' ) ) {
	function dgc_get_class_pos($index)  {
		if ($index == 0) { $pos_class = 'left-pos'; } 
		else if ($index == 1) {	$pos_class = 'center-pos';	} 
		else { $pos_class = 'right-pos'; }
		
		return esc_attr($pos_class);
	}
}

if ( ! function_exists( 'dgc_kses_data' ) ) {
	function dgc_kses_data($text = null) {
		$allowed_tags = wp_kses_allowed_html( 'post' );
		return wp_kses($text, $allowed_tags);
	}
}

/* get cart button html */
if ( ! function_exists( 'dgc_get_cart_button_html' ) ) {
	function dgc_get_cart_button_html() {
		$btn_cart = '';
		$theme_options = dgc_get_theme_options();
		
		if (class_exists('Woocommerce')) { 
			global $woocommerce;
			if (!empty($theme_options['showcart']) && (esc_attr($theme_options['showcart']) == 'on')) {
					$btn_cart = '<div class="cart-button">
						<a href="'.get_permalink( wc_get_page_id( 'cart' ) ).'" class="cart-contents">
							<div class="fas fa-shopping-cart"></div> 
							<span class="num_of_product_cart">'.$woocommerce->cart->cart_contents_count.'</span>
						</a>
					</div>';
			}
		} 
		echo $btn_cart;
	}
}	

/* get my account button html */
if ( ! function_exists( 'dgc_get_my_account_html' ) ) {
	function dgc_get_my_account_html() {
		$btn_my_account = '<div class="my-account">
			<a href="'.get_permalink( wc_get_page_id( 'myaccount' ) ).'">
			<div class="fas fa-user"></div>
			</a></div>';
		echo $btn_my_account;
		//<div><img class="my-account-icon" src="'.bloginfo('template_directory').'/assets/images/my-account.png"></div>
	}
}	

/* get qTranslate-x languages list */
if ( ! function_exists( 'dgc_get_qtranslate_languages_list' ) ) {
	function dgc_get_qtranslate_languages_list(){
		if( defined( 'QTRANSLATE_FILE' ) ){
			global $q_config;
			$languages = qtranxf_getSortedLanguages();			
			if(!empty($languages)){
				echo '<div id="qtranslate-select">';
					echo '<ul id="lang-select-block">';
						echo '<li class="current">';
							echo '<div class="fas fa-globe"></div>';
							//echo '<img class="globe-icon" src="'.bloginfo('template_directory').'/assets/images/globe.png">';
							echo '<ul id="lang-select-popup">';					
							foreach($languages as $language){
								echo '<li class="unactive">';
								echo '<a class="'.$language.'" href="'.qtranxf_convertURL($url, $language, false, true).'">';
									echo $q_config['language_name'][$language];
								echo '</a></li>';
							}
							echo '</ul>';
						echo '</li>';					
					echo '</ul>';
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'dgc_get_wpml_languages_list' ) ) {
	function dgc_get_wpml_languages_list(){
		$theme_options = dgc_get_theme_options();
		if( function_exists('icl_get_languages') && $theme_options['is_wpml_ready'] == 'on' ){ 
			$languages = icl_get_languages('skip_missing=0');
			
			if(!empty($languages)){
			
				echo '<div id="header-language-select"><ul id="lang-select-block">';
				foreach($languages as $l){
					if($l['active']) {
						echo '<li class="current">';
							echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'" onclick="return false">';
								echo $l['language_code'];
							echo '</a>';
						echo '<ul id="lang-select-popup">';					
						
							echo '<li class="active">';
								echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'" onclick="return false">';
									echo $l['native_name'];
								echo '</a>';
							echo '</li>';
					} 
						
				}
				foreach($languages as $l){
					if(!($l['active'])) {
							echo '<li class="unactive">';
							echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'">';
								echo $l['native_name'];
							echo '</a></li>';
					}
				}
						echo '</ul>';
					echo '</li>';					
				echo '</ul></div>';
			}
		}
	}
}

if ( ! function_exists( 'dgc_wp_corenavi' ) ) {
	function dgc_wp_corenavi() {  
		global $wp_query, $wp_rewrite;  
		$next_label = $prev_label = '';
		if (wp_is_mobile()) {
			$next_label = __(' &laquo; ','textdomain'); 
			$prev_label = __(' &raquo; ','textdomain');
		} else {
			$next_label = __('&laquo; Previous Page','textdomain');
			$prev_label = __('Next Page &raquo;','textdomain'); 
		}
		
		$pages = '';  
		$max = $wp_query->max_num_pages;  
		if (!$current = get_query_var('paged')) {
			$current = 1;  
		} 
		 
		$a['base']    = str_replace(999999999, '%#%', get_pagenum_link(999999999));  
		$a['total']   = $max;  
		$a['current'] = $current;  
		  
		$total = 0;    //1 - display the text "Page N of N", 0 - not display  
		$a['mid_size'] = 2;  //how many links to show on the left and right of the current  
		$a['end_size'] = 1;  //how many links to show in the beginning and end  
		$a['prev_text'] = '';  //text of the "Previous page" link  
		$a['next_text'] = '';  //text of the "Next page" link  
		  
		if  ($max > 1) {
			echo '<div class="pagination nav-links shop aligncenter">';  
		} 
		if  ($total == 1 && $max > 1) {
			$pages = '<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n";  
		} 
		echo '<div class="nav-previous ">'; previous_posts_link($next_label); echo '</div>';
			echo '<div class="pages-links">';
				echo $pages . paginate_links($a);  
			echo '</div>';
		echo '<div class="nav-next">';  next_posts_link($prev_label); echo '</div>';
		if ($max > 1) {
			echo '</div>';  
		} 
	}
}

/*rewrite get_product_search_form() function*/
if ( ! function_exists( 'dgc_get_product_search_form' ) ) {
	function dgc_get_product_search_form(){
		?>
		<form role="search" method="get" id="searchform" class="fas fa-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<div>
				<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Search for products', 'textdomain' ); ?>" />
				<input type="submit" id="searchsubmit" value="<?php echo esc_attr__( 'Search', 'textdomain' ); ?>" />
				<input type="hidden" name="post_type" value="product" />
			</div>
		</form>
		<?php
	}
}

if ( ! function_exists( 'dgc_is_woo_sidebar' ) ) {
	function dgc_is_woo_sidebar() {
		$is_sidebar = true;
		if (class_exists('Woocommerce')) { 
			if (is_cart() || is_checkout() || is_account_page()) {
				 $is_sidebar = false;
			}
		}	
		return $is_sidebar;
	}
}

if(!function_exists('dgc_is_blog')){
	function dgc_is_blog () {
		global  $post;
		$posttype = get_post_type($post );
		return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
	}
}

if(!function_exists('dgc_is_latest_posts_page')){
	function dgc_is_latest_posts_page () {
		global  $post;
		$blog_id = get_option('page_for_posts', true);
		return ( is_home() && is_front_page() && ($post->ID != $blog_id) ) ? true : false ;
	}
}

if ( ! function_exists( 'dgc_get_content_with_custom_sidebar' ) ) {
	function dgc_get_content_with_custom_sidebar($curr_sidebar = null) {
		global $post;
		
		function get_content_part() {
			global $post;
			
			?>
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">	
			<?php			
				/* Start the Loop */
				$page_on_front  = get_option('page_on_front');
				$page_for_posts = get_option('page_for_posts');
								
				if (is_page() && !empty($page_on_front) &&  !empty($page_for_posts) && ($page_on_front == $page_for_posts)) {
					echo '<div class="alert alert-danger"><strong>'.__("Front page displays Error.", 'textdomain').'</strong> '.__('Select different pages!', 'textdomain').'</div>';
					
				} else {
					if (!is_archive() && !is_search() && !is_404()) {
						if (is_home()) {
							if ( have_posts() ) : 
								/* The loop */ 
								while ( have_posts() ) : the_post(); 
									do_action('before_post_content_loop');
										get_template_part( 'content', get_post_format() ); 
									do_action('after_post_content_loop');
								endwhile; 
								dgc_content_nav( 'nav-below' ); 
							else :
								get_template_part( 'no-results', 'index' ); 
							endif;

						} else {							
							if ( have_posts() ) {
								while ( have_posts() ) : the_post();
									if (is_page() && !is_front_page() && !is_home()) {
										get_template_part( 'content', 'page' ); 

										if (dgc_state_page_comment()) { 
											comments_template( '', true );  
										}

									} else if (is_single()) {
										get_template_part( 'content', get_post_format() );
										dgc_content_nav( 'nav-below' );
									
										if (dgc_state_post_comment()) { 
											if ( comments_open() || '0' != get_comments_number() ) comments_template();  
										}

									} else if (is_front_page())	{
										get_template_part( 'content', 'page' );
									}
							   	endwhile;
							}
						}

					} else {
						?>
							<section id="primary" class="content-area">
								<div id="content" class="site-content" role="main">

								<?php if ( have_posts() ) : ?>
										<header class="page-header">
											<h1 class="page-title">
												<?php
													
													if ( is_archive()) {
														if ( is_category() ) {
															printf( __( 'Category Archives: %s', 'textdomain' ), '<span>' . single_cat_title( '', false ) . '</span>' );

														} elseif ( is_tag() ) {
															printf( __( 'Tag Archives: %s', 'textdomain' ), '<span>' . single_tag_title( '', false ) . '</span>' );

														} elseif ( is_author() ) {
															the_post();
															printf( __( 'Author Archives: %s', 'textdomain' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
															rewind_posts();

														} elseif ( is_day() ) {
															printf( __( 'Daily Archives: %s', 'textdomain' ), '<span>' . get_the_date() . '</span>' );
	
														} elseif ( is_month() ) {
															printf( __( 'Monthly Archives: %s', 'textdomain' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

														} elseif ( is_year() ) {
															printf( __( 'Yearly Archives: %s', 'textdomain' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

														} else {
															_e( 'Archives', 'textdomain' );
														}
													}
													
													if (is_search())
														printf( __( 'Search Results for: %s', 'textdomain' ), '<span>' . get_search_query() . '</span>' ); 
												?>
											</h1>
											<?php
												if ( is_category() ) {
													$category_description = category_description();
													if ( ! empty( $category_description ) )
														echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

												} elseif ( is_tag() ) {
													$tag_description = tag_description();
													if ( ! empty( $tag_description ) )
														echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
												}
											?>
										</header><!-- .page-header -->

										<?php /* Start the Loop */ 
										while ( have_posts() ) : the_post(); 
											do_action('before_post_content_loop');
												get_template_part( 'content', get_post_format() );
											do_action('after_post_content_loop');	
										endwhile; 
										dgc_content_nav( 'nav-below' );
										
									else : 
										if (is_404()) {
											get_template_part( 'content', '404' );	
										} else {
											get_template_part( 'no-results', 'archive' );
										}	
										
									endif; ?>

								</div><!-- #content .site-content -->
							</section><!-- #primary .content-area -->
						<?php
					}
				}
			?>
				</div>
			</div>	
		<?php 
		}
		
		function get_html_custom_post_template($content_class, $sidebar_class, $curr_sidebar, $content_type) {
			global $post;
			$is_sidebar = true;
			$is_sidebar = dgc_is_woo_sidebar();
				
			if ($content_type == 0) {
				get_content_part();
			
			} else if ($content_type == 1) { ?>				
				<div class="eleven columns <?php echo $content_class;?>"><?php get_content_part(); ?> </div>	
				
				<?php if ($is_sidebar && is_page()) { ?>
					<div class="five columns <?php echo $sidebar_class;?>"> <?php get_sidebar($curr_sidebar); ?> </div>
				<?php } else { ?>	
					<div class="five columns <?php echo $sidebar_class;?>"> <?php get_sidebar($curr_sidebar); ?> </div>
				<?php }
			
			} else if ($content_type == 2) { ?>				
				<div class="eleven columns <?php echo $content_class;?>"> <?php get_content_part(); ?> </div>	
				
				<?php if ($is_sidebar && is_page()) { ?>
					<div class="five columns <?php echo $sidebar_class;?>"> <?php get_sidebar($curr_sidebar); ?> </div>
				<?php } else { ?>	
					<div class="five columns <?php echo $sidebar_class;?>"> <?php get_sidebar($curr_sidebar); ?> </div>
				<?php }
			} 
		}
		
		$curr_template = '';
		$options = dgc_get_theme_options();
		
		if (dgc_is_latest_posts_page()) {
			if (!empty($options['latest_posts_templ'])){
				$curr_template = esc_attr($options['latest_posts_templ']);
			}

		} elseif (is_archive()) {
			if (is_tag()) {
				if (!empty($options['layout_tag_templ'])){
					$curr_template = esc_attr($options['layout_tag_templ']);	
				}

			} elseif (is_category()) {
				if (!empty($options['layout_cat_templ'])){
					$curr_template = esc_attr($options['layout_cat_templ']);
				}

			} elseif (is_author()) {
				if (!empty($options['layout_author_templ'])){
					$curr_template = esc_attr($options['layout_author_templ']);
				}

			} else {
				if (!empty($options['layout_archive_templ'])){
					$curr_template = esc_attr($options['layout_archive_templ']); 
				}
			}

		} elseif (is_404()) {
			if (!empty($options['layout_404_templ'])){
				$curr_template = esc_attr($options['layout_404_templ']);
			}

		} elseif (is_search()) {
			if (!empty($options['layout_search_templ'])){
				$curr_template = esc_attr($options['layout_search_templ']);
			}

		} else {
			$default_blog_template = (get_post_meta( get_option('page_for_posts', true), '_dgc_page_layout', true ))?(get_post_meta( get_option('page_for_posts', true), '_dgc_page_layout', true )-1) : 1;			
			$default_post_template = (get_post_meta( $post->ID , '_dgc_page_layout', true ))?(get_post_meta(  $post->ID , '_dgc_page_layout', true )-1):esc_attr($options['layout_single_templ']);
			$default_page_template = (get_post_meta( $post->ID , '_dgc_page_layout', true ))?(get_post_meta(  $post->ID , '_dgc_page_layout', true )-1):esc_attr($options['layout_page_templ']);
			if (!dgc_is_blog()) {
				if (is_archive()) {
					$curr_template = $default_blog_template;

				} else {						
					if (class_exists('BuddyPress')){
						$bp_pages = get_option('bp-pages');			//possible pages - activity, members, register, activate
						foreach ($bp_pages as $bp_page_slug => $bp_page_id){
							if (bp_is_current_component($bp_page_slug)){
								$curr_template = (get_post_meta( $bp_page_id , '_dgc_page_layout', true ))?(get_post_meta( $bp_page_id , '_dgc_page_layout', true )-1):0;
							} else {
								$curr_template = $default_page_template;
							}
						}

					} else {
						$curr_template = $default_page_template;
					}					
				}

			} else {
				if (is_single()) {
					$curr_template = $default_post_template;
				} else {
					$curr_template = $default_blog_template;
				}
			}
		}
		
		if ($curr_template == 0) { 
			get_html_custom_post_template('alpha', 'omega', $curr_sidebar, $curr_template);

		} else if ($curr_template == 1) { 
			get_html_custom_post_template('alpha', 'omega', $curr_sidebar, $curr_template);

		} else if ($curr_template == 2) {
			get_html_custom_post_template('omega', 'alpha', $curr_sidebar, $curr_template);
			
		} else {
			if (is_home()) {
				$curr_template = 1;
			}		
			get_html_custom_post_template('alpha', 'omega', $curr_sidebar, $curr_template);
		}
	}
}

if (class_exists('Woocommerce')) { 	
	function dgc_init_woo_actions() {
		function go_hooks() {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);		
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5);
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 10);
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_rating', 20);		
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_price', 20); 
			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);			
		}		
		$woo_tabs_pos = dgc_get_woo_sidebar();
		if ($woo_tabs_pos == 4) go_hooks();			
	}
	add_action( 'wp', 'dgc_init_woo_actions' , 10);
}

if (class_exists('Woocommerce')) { 	
	function dgc_init_woo_styles() {
		
		function go_woo_tabs_left(){
			$style_ = $back_style = $woo_style_ = '';
			$theme_options  = dgc_get_theme_options(); 
			//$style_ .= '@media only screen and (min-width: 1024px) {body.woocommerce div.product div.summary, body.woocommerce-page div.product div.summary, body.woocommerce #content div.product div.summary, body.woocommerce-page #content div.product div.summary {max-width : 100%; }}' . "\n";
			$style_ .= '@media only screen and (min-width: 1024px) {body.woocommerce div.product .woocommerce-tabs, body.woocommerce-page div.product .woocommerce-tabs, body.woocommerce #content div.product .woocommerce-tabs, body.woocommerce-page #content div.product .woocommerce-tabs {float: left; }}' . "\n";
			$style_ .= '@media only screen and (max-width: 1024px) {body.woocommerce div.product .woocommerce-tabs, body.woocommerce-page div.product .woocommerce-tabs, body.woocommerce #content div.product .woocommerce-tabs, body.woocommerce-page #content div.product .woocommerce-tabs {margin: 0 0 15px 0;}}' . "\n";
			$style_ .= '@media only screen and (min-width: 1024px) {body.woocommerce div.product div.images, body.woocommerce-page div.product div.images, body.woocommerce #content div.product div.images, body.woocommerce-page #content div.product div.images {margin: 0 0 0 25px; float: right}}' . "\n";
			$style_ .= '.single.woocommerce span.onsale, .single.woocommerce-page span.onsale {  top: 6px; right:15px; left: auto; position: absolute;  display: block;}' . "\n";
			$style_ .= '@media only screen and (max-width: 1024px) {body.woocommerce div.product div.images, body.woocommerce-page div.product div.images, body.woocommerce #content div.product div.images, body.woocommerce-page #content div.product div.images{ clear: both; position: relative; margin: 20px auto; }}' . "\n";
			$style_ .= '@media only screen and (min-width: 1024px) {.entry-title, .woocommerce-product-rating, div[itemprop="offers"], div[itemprop="offers"].price{ display:inline-block; width: 565px;}}' . "\n";
			wp_add_inline_style( 'main-style', dgc_compress_code($style_)); 
			if ($woo_style_ != '') {
				wp_add_inline_style( 'woo-style', dgc_compress_code($woo_style_)); 
			}	
		}
		
		function go_woo_tabs_center(){
			$style_ = $back_style = $woo_style_ = '';
			$theme_options  = dgc_get_theme_options(); 
			$style_ .= '@media only screen and (min-width: 1024px) {body.woocommerce div.product .woocommerce-tabs, body.woocommerce-page div.product .woocommerce-tabs, body.woocommerce #content div.product .woocommerce-tabs, body.woocommerce-page #content div.product .woocommerce-tabs {max-width : 100%; margin-top: 20px;}}' . "\n";
				wp_add_inline_style( 'main-style', dgc_compress_code($style_)); 
			if ($woo_style_ != '') {
				wp_add_inline_style( 'woo-style', dgc_compress_code($woo_style_)); 
			}	
		}
		
		$woo_tabs_pos = dgc_get_woo_sidebar();
		if ($woo_tabs_pos == 4) go_woo_tabs_left();
		if ($woo_tabs_pos == 5) go_woo_tabs_center();
	}
	add_action(	'wp_enqueue_scripts', 'dgc_init_woo_styles', 100);
}
add_action( 'after_setup_theme', 'wpse_theme_setup' );

function wpse_theme_setup() {
	add_theme_support( 'title-tag' );
}

function dgc_frontend_scripts_include_lightbox() {
    global $woocommerce;
    if(!class_exists( 'WooCommerce' )) return;
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    //$lightbox_en = get_option( 'woocommerce_enable_lightbox' ) == 'yes' ? true : false; //deprecated woocommerce 3.0 option. Need to update
    $lightbox_en = true;

    if ( $lightbox_en ) {
        if ( !wp_script_is( 'prettyPhoto') ) {
            wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
        }
        if ( !wp_script_is( 'prettyPhoto-init') ) {
            wp_enqueue_script( 'prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
        }
        if ( !wp_style_is( 'woocommerce_prettyPhoto_css') ) {
            wp_enqueue_style( 'woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
        }
    }
}
add_action('wp_enqueue_scripts', 'dgc_frontend_scripts_include_lightbox');

/**
* Creates the custom field in the WooCommerce product data meta box
*/
function dgc_create_custom_field_product_date() {
	$args = array(
		'id' => 'custom_field_product_date',
		'label' => __( 'Published Date', 'textdomain' ),
		'class' => 'dgc-custom-field',
		'desc_tip' => true,
		'description' => __( 'Enter the title of your custom field.', 'textdomain' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'dgc_create_custom_field_product_date' );

function dgc_save_custom_field_product_date( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['custom_field_product_date'] ) ? $_POST['custom_field_product_date'] : '';
	$product->update_meta_data( 'custom_field_product_date', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'dgc_save_custom_field_product_date' );

function dgc_display_custom_field_product_date() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID );
	$title = $product->get_meta( 'custom_field_product_date' );
	if( $title ) {
		echo get_post_meta($post->ID, 'custom_field_product_date', true);
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'dgc_display_custom_field_product_date' );

/**
* Creates the custom fieldin the WooCommerce product data meta box
*/
/*
function dgc_create_custom_field_product_doi() {
	$args = array(
		'id' => 'custom_field_product_doi',
		'label' => __( 'DOI', 'textdomain' ),
		'class' => 'dgc-custom-field',
		'desc_tip' => true,
		'description' => __( 'Enter the title of your custom field.', 'textdomain' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'dgc_create_custom_field_product_doi' );

function dgc_create_custom_field_product_revision() {
	$args = array(
		'id' => 'custom_field_product_revision',
		'label' => __( 'Revision', 'textdomain' ),
		'class' => 'dgc-custom-field',
		'desc_tip' => true,
		'description' => __( 'Enter the title of your custom field.', 'textdomain' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'dgc_create_custom_field_product_revision' );

function dgc_create_custom_field_product_pages() {
	$args = array(
		'id' => 'custom_field_product_pages',
		'label' => __( 'Pages', 'textdomain' ),
		'class' => 'dgc-custom-field',
		'desc_tip' => true,
		'description' => __( 'Enter the title of your custom field.', 'textdomain' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'dgc_create_custom_field_product_pages' );
*/
/**
* Saves the custom field data to product meta data
*/
/*
function dgc_save_custom_field_product_doi( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['custom_field_product_doi'] ) ? $_POST['custom_field_product_doi'] : '';
	$product->update_meta_data( 'custom_field_product_doi', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'dgc_save_custom_field_product_doi' );

function dgc_save_custom_field_product_revision( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['custom_field_product_revision'] ) ? $_POST['custom_field_product_revision'] : '';
	$product->update_meta_data( 'custom_field_product_revision', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'dgc_save_custom_field_product_revision' );

function dgc_save_custom_field_product_pages( $post_id ) {
	$product = wc_get_product( $post_id );
	$title = isset( $_POST['custom_field_product_pages'] ) ? $_POST['custom_field_product_pages'] : '';
	$product->update_meta_data( 'custom_field_product_pages', sanitize_text_field( $title ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'dgc_save_custom_field_product_pages' );
*/
/**
* Displays custom field data after the add to cart button
*/
/*
function dgc_display_custom_field_product_doi() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID );
	$title = $product->get_meta( 'custom_field_product_doi' );
	if( $title ) {
		echo get_post_meta($post->ID, 'custom_field_product_doi', true);
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'dgc_display_custom_field_product_doi' );

function dgc_display_custom_field_product_revision() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID );
	$title = $product->get_meta( 'custom_field_product_revision' );
	if( $title ) {
		echo get_post_meta($post->ID, 'custom_field_product_revision', true);
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'dgc_display_custom_field_product_revision' );

function dgc_display_custom_field_product_pages() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID );
	$title = $product->get_meta( 'custom_field_product_pages' );
	if( $title ) {
		echo get_post_meta($post->ID, 'custom_field_product_pages', true);
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'dgc_display_custom_field_product_pages' );
*/
/**
 * Add product custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy_for_object_type
 * 
 * Custom Product Search:
 * (1) Title
 * (2) Publisher
 * (3) Industry
 * (4) Keyword
 * (5) Price
 * (6) Date
 * (7) Language
 * (8) Version
 * (9) Status
 */
function dgc_custom_taxonomy_product_publisher()  {
	$labels = array(
    	'name'                       => __( 'Publishers', 'textdomain' ),
    	'singular_name'              => __( 'Publisher', 'textdomain' ),
    	'menu_name'                  => __( 'Publisher', 'textdomain' ),
    	'all_items'                  => __( 'All Publishers', 'textdomain' ),
    	'parent_item'                => __( 'Parent Publisher', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Publisher:', 'textdomain' ),
    	'new_item_name'              => __( 'New Publisher Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Publisher', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Publisher', 'textdomain' ),
    	'update_item'                => __( 'Update Publisher', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Publisher with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Publishers', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Publishers', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Publishers', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'publisher', 'product', $args );
	register_taxonomy_for_object_type( 'publisher', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_publisher' );

function dgc_custom_taxonomy_product_industry()  {
	$labels = array(
    	'name'                       => __( 'Industries', 'textdomain' ),
    	'singular_name'              => __( 'Industry', 'textdomain' ),
    	'menu_name'                  => __( 'Industry', 'textdomain' ),
    	'all_items'                  => __( 'All Industries', 'textdomain' ),
    	'parent_item'                => __( 'Parent Industry', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Industry:', 'textdomain' ),
    	'new_item_name'              => __( 'New Industry Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Industry', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Industry', 'textdomain' ),
    	'update_item'                => __( 'Update Industry', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Industry with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Industries', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Industries', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Industries', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'industry', 'product', $args );
	register_taxonomy_for_object_type( 'industry', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_industry' );

function dgc_custom_taxonomy_product_keyword()  {
	$labels = array(
    	'name'                       => __( 'Keywords', 'textdomain' ),
    	'singular_name'              => __( 'Keyword', 'textdomain' ),
    	'menu_name'                  => __( 'Keyword', 'textdomain' ),
    	'all_items'                  => __( 'All Keywords', 'textdomain' ),
    	'parent_item'                => __( 'Parent Keyword', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Keyword:', 'textdomain' ),
    	'new_item_name'              => __( 'New Keyword Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Keyword', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Keyword', 'textdomain' ),
    	'update_item'                => __( 'Update Keyword', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Keyword with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Keywords', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Keywords', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Keywords', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'keyword', 'product', $args );
	register_taxonomy_for_object_type( 'keyword', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_keyword' );

function dgc_custom_taxonomy_product_language()  {
	$labels = array(
    	'name'                       => __( 'Languages', 'textdomain' ),
    	'singular_name'              => __( 'Language', 'textdomain' ),
    	'menu_name'                  => __( 'Language', 'textdomain' ),
    	'all_items'                  => __( 'All Languages', 'textdomain' ),
    	'parent_item'                => __( 'Parent Language', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Language:', 'textdomain' ),
    	'new_item_name'              => __( 'New Language Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Language', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Language', 'textdomain' ),
    	'update_item'                => __( 'Update Language', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Language with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Languages', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Languages', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Languages', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'language', 'product', $args );
	register_taxonomy_for_object_type( 'language', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_language' );
/*
function dgc_custom_taxonomy_product_version()  {
	$labels = array(
    	'name'                       => __( 'Versions', 'textdomain' ),
    	'singular_name'              => __( 'Version', 'textdomain' ),
    	'menu_name'                  => __( 'Version', 'textdomain' ),
    	'all_items'                  => __( 'All Versions', 'textdomain' ),
    	'parent_item'                => __( 'Parent Version', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Version:', 'textdomain' ),
    	'new_item_name'              => __( 'New Version Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Version', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Version', 'textdomain' ),
    	'update_item'                => __( 'Update Version', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Version with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Versions', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Versions', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Versions', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'version', 'product', $args );
	register_taxonomy_for_object_type( 'version', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_version' );
*/
function dgc_custom_taxonomy_product_status()  {
	$labels = array(
    	'name'                       => __( 'Statuses', 'textdomain' ),
    	'singular_name'              => __( 'Status', 'textdomain' ),
    	'menu_name'                  => __( 'Status', 'textdomain' ),
    	'all_items'                  => __( 'All Statuses', 'textdomain' ),
    	'parent_item'                => __( 'Parent Status', 'textdomain' ),
    	'parent_item_colon'          => __( 'Parent Status:', 'textdomain' ),
    	'new_item_name'              => __( 'New Status Name', 'textdomain' ),
    	'add_new_item'               => __( 'Add New Status', 'textdomain' ),
    	'edit_item'                  => __( 'Edit Status', 'textdomain' ),
    	'update_item'                => __( 'Update Status', 'textdomain' ),
    	'separate_items_with_commas' => __( 'Separate Status with commas', 'textdomain' ),
    	'search_items'               => __( 'Search Statuses', 'textdomain' ),
    	'add_or_remove_items'        => __( 'Add or remove Statuses', 'textdomain' ),
    	'choose_from_most_used'      => __( 'Choose from the most used Statuses', 'textdomain' ),
	);
	$args = array(
    	'labels'                     => $labels,
    	'hierarchical'               => true,
    	'public'                     => true,
    	'show_ui'                    => true,
    	'show_admin_column'          => true,
    	'show_in_nav_menus'          => true,
    	'show_tagcloud'              => true,
	);
	register_taxonomy( 'status', 'product', $args );
	register_taxonomy_for_object_type( 'status', 'product' );
}
add_action( 'init', 'dgc_custom_taxonomy_product_status' );

/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies() {
	// Add new "Locations" taxonomy to Posts 
	register_taxonomy('location', 'post', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
			'name' => _x( 'Locations', 'taxonomy general name' ),
			'singular_name' => _x( 'Location', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Locations', 'textdomain' ),
			'all_items' => __( 'All Locations', 'textdomain' ),
			'parent_item' => __( 'Parent Location', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Location:', 'textdomain' ),
			'edit_item' => __( 'Edit Location', 'textdomain' ),
			'update_item' => __( 'Update Location', 'textdomain' ),
			'add_new_item' => __( 'Add New Location', 'textdomain' ),
			'new_item_name' => __( 'New Location Name', 'textdomain' ),
			'menu_name' => __( 'Locations', 'textdomain' ),
	  	),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'locations', // This controls the base slug that will display before each term
			'with_front' => false, // Don't display the category base before "/locations/"
			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		),
	));
}
add_action( 'init', 'add_custom_taxonomies', 0 );
/*
function is_login() { 
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')); 
}
*/
/* Polylang */
// 確保複製過去時帶入預設標題
function mxp_editor_title( $title ) {
    // Polylang 會帶入 'from_post' 這組 GET 參數
    if ( isset( $_GET['from_post'] ) ) {
        $my_post = get_post( $_GET['from_post'] );
        if ( $my_post )
            return $my_post->post_title;
    }

    return $title;
}
add_filter( 'default_title', 'mxp_editor_title' );

// 確保複製過去帶入預設內容
function mxp_editor_content( $content ) {
    // Polylang 會帶入 'from_post' 這組 GET 參數
    if ( isset( $_GET['from_post'] ) ) {
        $my_post = get_post( $_GET['from_post'] );
        if ( $my_post )
            return $my_post->post_content;
    }

    return $content;
}
add_filter( 'default_content', 'mxp_editor_content' );

/**
 * @snippet       Edit WooCommerce Product Loop Items Display
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=26658
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.0.4
 */
 
// -------------------------
// 1. Change number of products per row to 1
// Note: this is specific to Storefront theme
// See https://docs.woocommerce.com/document/change-number-of-products-per-row/
 
add_filter('storefront_loop_columns', 'loop_columns');
 
function loop_columns() {
	return 1;
}
 
// -------------------------
// 2. Remove default image, price, rating, add to cart
 
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
 
// -------------------------
// 3. Remove sale flash (Storefront)
 
add_action( 'init', 'bbloomer_hide_storefront_sale_flash' );
 
function bbloomer_hide_storefront_sale_flash() {
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
}
 
// -------------------------
// 4. Add <div> before product title
 
add_action( 'woocommerce_before_shop_loop_item', 'bbloomer_loop_product_div_flex_open', 8 );
function bbloomer_loop_product_div_flex_open() {
	echo '<div class="product_table">';
}
 
// -------------------------
// 5. Wrap product title into a <div> with class "one_third"
 
add_action( 'woocommerce_before_shop_loop_item', 'bbloomer_loop_product_div_wrap_open', 9 );
function bbloomer_loop_product_div_wrap_open() {
	echo '<div class="one_third">';
}
 
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_wrap_close', 6 );
function bbloomer_loop_product_div_wrap_close() {
	echo '</div>';
}
 
// -------------------------
// 6. Re-add and Wrap price into a <div> with class "one_third"
 
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_wrap_open', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 8 );
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_wrap_close', 9 );
 
// -------------------------
// 7. Re-add and Wrap add to cart into a <div> with class "one_third"
 
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_wrap_open', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_wrap_close', 12 );
 
// -------------------------
// 8. Close <div> at the end of product title, price, add to cart divs
 
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_loop_product_div_flex_close', 13 );
function bbloomer_loop_product_div_flex_close() {
	echo '</div>';
}

/* Remove Categories from Single Products */ 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
?>