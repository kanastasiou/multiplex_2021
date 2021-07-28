<?php
/**
 * multiplex functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package multiplex
 */


/*
Load Custom Shortcodes
*/
require get_template_directory() . '/custom_shortcodes.php';

add_action('wp_enqueue_scripts', 'multiplex_extra_scripts',99);


    function multiplex_extra_scripts()
    {
    	wp_enqueue_style( 'fi-theme-style', get_stylesheet_uri() );
         $path=get_template_directory().'/scripts/';
            /*check which dynamic scripts should be loaded*/

            if (file_exists($path))
                {
                $paths=array('js','css');
                foreach ($paths as $kk)
                {
                    $check=glob($path.'*.'.$kk);
                    if (!empty($check))
                    {
                        foreach (glob($path.'*.'.$kk) as $filename) {
                            switch ($kk) {
                                case 'js':
                                    wp_enqueue_script('fi-theme-'.basename($filename), get_template_directory_uri(). '/scripts/'.basename($filename), array(), array(), true);
                                    break;
                                default:
                                    wp_enqueue_style('fi-theme-'.basename($filename),get_template_directory_uri(). '/scripts/'.basename($filename), array(), '', 'all');
                                    break;
                            }
                            }

                    }
                    }

                }
                   wp_enqueue_script( 'plx-gmap-js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBCX2L33Ptp0khSyU0wOJmRLG2GhnYKwTw',array(), array(), true);
    }


if ( ! function_exists( 'multiplex_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function multiplex_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on multiplex, use a find and replace
		 * to change 'multiplex' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'multiplex', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'multiplex' ),
            'mobile-menu' => esc_html__('Mobile', 'multiplex')
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'multiplex_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'multiplex_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function multiplex_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'multiplex_content_width', 640 );
}
add_action( 'after_setup_theme', 'multiplex_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function multiplex_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'multiplex' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'multiplex' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Mobile menu widgets', 'multiplex' ),
        'id'            => 'mobile-menu-widget',
        'description'   => esc_html__( 'Add widgets here.', 'multiplex' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'footer-widget', 'multiplex' ),
        'id'            => 'footer-widget',
        'description'   => esc_html__( 'Add widgets here.', 'multiplex' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( '404 Content', 'multiplex' ),
        'id'            => '404-content',
        'description'   => esc_html__( 'Add widgets here.', 'multiplex' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'multiplex_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function multiplex_scripts() {
	wp_enqueue_style( 'multiplex-style', get_stylesheet_uri() );

	wp_enqueue_script( 'multiplex-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'multiplex-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'multiplex_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}





/*motivar code*/



function mtv_get_my_custom_posts($post_type)
    {
    $msg = array();
    $all = array(
        array(
            'post' => 'plx_partners',
            'sn' => __('Partner', 'multiplex') ,
            'pl' => __('Partners', 'multiplex') ,
            'args' => array(
                'title',
                'editor',
                'thumbnail'
            ) ,
            'slug' => get_option('plx_partners_slug') ? : 'plx_partners',
            'chk' => true,
            'mnp' => 2,
            'icn' => '',
            'capp' => array(
                1,
                2,
                3
            ) ,
            'meta_arrays' => array(
              //  'sbp_extra_booking_meta'
            ) ,
            'mtv_enable' => 1,
            'en_slg'=>1,
            'tax_types' => array(
            	/*
                __('OTAs', 'multiplex') ,
                __('OTA', 'multiplex') ,
                'sbp_review_ota'
                */
            ) 
        ) ,
        array(
            'post' => 'plx_marinas',
            'sn' => __('Marina', 'multiplex') ,
            'pl' => __('Marinas', 'multiplex') ,
            'args' => array(
                'title',
                'editor',
                'thumbnail'
            ) ,
             'slug' => get_option('plx_marinas_slug') ? : 'plx_marinas',
            'chk' => true,
            'mnp' => 2,
            'icn' => '',
            'en_slg'=>1,
            'capp' => array(
                1,
                2,
                3
            ) ,
            'meta_arrays' => array(
              //  'sbp_extra_booking_meta'
            ) ,
            'mtv_enable' => 1,
        ) ,
        array(
            'post' => 'plx_services',
            'sn' => __('Service', 'multiplex') ,
            'pl' => __('Services', 'multiplex') ,
             'slug' => get_option('plx_services_slug') ? : 'plx_services',
            'args' => array(
                'title',
                'editor'
            ) ,
            'chk' => false,
            'mnp' => 2,
            'icn' => '',
            'capp' => array(
                1,
                2,
                3
            ) ,
            'meta_arrays' => array(
              //  'sbp_extra_booking_meta'
            ) ,
            'mtv_enable' => 1,
            'tax_types' => array(
                __('Service Categories', 'multiplex') ,
                __('Service Category', 'multiplex') ,
                'plx_service_categories',
                1
            ) 
        ) 

    );
    if ($post_type == 'all')
        {
        $msg = $all;
        }
      else
        {
        foreach($all as $k)
            {
            if ($k['post'] == $post_type)
                {
                $msg = $k;
                }
            }
        }
    return $msg;
    }

add_action('init', 'mtv_register_my_cpts', 10);

function mtv_register_my_cpts()
    {
    $names = mtv_get_my_custom_posts('all');
    foreach($names as $n)
        {
        $enable = isset($n['mtv_enable']) ? $n['mtv_enable'] : 1;
        $relation = isset($n['mtv_relation']) ? $n['mtv_relation'] : 1;
        if ($enable == 1 && $relation == 1)
            {
            $extra_sl = isset($n['extra_slug']) ? '/%' . $n['extra_slug'] . '%' : '';
          
            if (mtv_wpml != 0)
                {
                $extra_sl = '';
                }
		
            $chk = $n['chk'];
            $labels = $args = array();
            $labels = array(
                'name' => $n['pl'],
                'singular_name' => $n['sn'],
                'menu_name' => $n['pl'],
                'add_new' => __('New', 'multiplex') . ' ' . $n['sn'],
                'add_new_item' => __('New', 'multiplex') . ' ' . $n['sn'],
                'edit' => 'Edit',
                'edit_item' => __('Edit', 'multiplex') . ' ' . $n['sn'],
                'new_item' => __('New', 'multiplex') . ' ' . $n['sn'],
                'view' => __('View', 'multiplex') . ' ' . $n['sn'],
                'view_item' => __('View', 'multiplex') . ' ' . $n['sn'],
                'search_items' => __('Search', 'multiplex') . ' ' . $n['sn'],
                'not_found' => __('No', 'multiplex') . ' ' . $n['pl'],
                'not_found_in_trash' => __('No Trashed', 'multiplex') . ' ' . $n['pl'],
                'parent' => 'Parent ' . $n['sn']
            );
            $args = array(
                'labels' => $labels,
                'description' => __('My custom post type for', 'multiplex') . ' ' . $n['pl'],
                'public' => true, //$chk
                'show_ui' => true,
                'has_archive' => true, //$chk
                'show_in_menu' => true,
                'exclude_from_search' => false, //!$chk
                'capability_type' => 'post',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'rewrite' => array(
                    'slug' => $n['post'] . $extra_sl,
                    'with_front' => true,
                    'feeds' => true //$chk
                ) ,
                'query_var' => true,
                'supports' => $n['args'],
                'show_in_rest' => true //$chk
            );
            if (!empty($n['slug']))
                {
                $args['rewrite']['slug'] = $n['slug'] . $extra_sl;
                }

            if (!empty($n['mnp']))
                {
                $args['menu_position'] = $n['mnp'];
                }

            if (!empty($n['icn']))
                {
                $args['menu_icon'] = $n['icn'];
                }

            if ($extra_sl != '')
                {
                $args['rewrite']['has_archive'] = $n['extra_slug'];
                }

            if ((isset($n['sbp_book']) && $n['sbp_book'] == 1) && (isset($n['sbp_main_product']) && $n['sbp_main_product'] == 1) && isset($n['sbp_period_checkout_type']))
                {
                define('sbp_period_checkout_type', $n['sbp_period_checkout_type']);
                }

            /*enable custom capabilities
            if (isset($n['capp']) && $n['capp'] >= 1)
                {
                $capps = create_custom_capabilities($n['post'], 1);
                $k = array_merge($args, $capps);
                $args = $k;
                }
			*/

            register_post_type($n['post'], $args);

            if (isset($n['en_slg']) && $n['en_slg'] == 1 && $chk == true)
                {
                add_action('load-options-permalink.php',
                function ($views) use($n)
                    {
                    if (isset($_POST[$n['post'] . '_slug']))
                        {
                        update_option($n['post'] . '_slug', sanitize_title_with_dashes($_POST[$n['post'] . '_slug']));
                        }

                    add_settings_field($n['post'] . '_slug', __($n['pl'] . ' Slug') ,
                    function ($views) use($n)
                        {
                        $value = get_option($n['post'] . '_slug');
                        echo '<input type="text" value="' . esc_attr($value) . '" name="' . $n['post'] . '_slug' . '" id="' . $n['post'] . '_slug' . '" class="regular-text" placeholder="' . $n['slug'] . '"/>';
                        }

                    , 'permalink', 'optional');
                    });
                }

            if (isset($n['custom_status']) && !empty($n['custom_status']))
                {
                foreach($n['custom_status'] as $k => $v)
                    {
                    register_post_status($k, array(
                        'label' => __($k, $n['post']) ,
                        'public' => true,
                        'exclude_from_search' => false,
                        'show_in_admin_all_list' => true,
                        'show_in_admin_status_list' => true,
                        'label_count' => _n_noop($v . '  <span class="count">(%s)</span>', $v . ' <span class="count">(%s)</span>') ,
                    ));
                    }
                }

            /*end for registering custom types*/
            /*check for taxes*/
            if (isset($n['tax_types']) && !empty($n['tax_types']))
                {
                $i = $n['tax_types'];
                $labels = $args = array();
                $labels = array(
                    'name' => $i[0],
                    'label' => $i[0],
                    'all_items' => __('All', 'multiplex') . ' ' . $i[0],
                    'edit_item' => __('Edit', 'multiplex') . ' ' . $i[1],
                    'update_item' => __('Update', 'multiplex') . ' ' . $i[1],
                    'add_new_item' => __('New', 'multiplex') . ' ' . $i[1],
                    'new_item_name' => __('New', 'multiplex') . ' ' . $i[1],
                    'parent_item' => $i[1] . ' ' . __('Parent', 'multiplex') ,
                    'parent_item_colon' => $i[1] . ' ' . __('Parent :)', 'multiplex') ,
                    'search_items' => __('Search', 'multiplex') . ' ' . $i[0],
                    'popular_items' => __('Popular', 'multiplex') . ' ' . $i[0],
                    'separate_items_with_commas' => __('Split', 'multiplex') . ' ' . $i[0] . ' ' . __('with comma', 'multiplex') ,
                    'add_or_remove_items' => __('Insert / Delete', 'multiplex') . ' ' . $i[1],
                    'choose_from_most_used' => __('Select', 'multiplex') . ' ' . $i[0]
                );
                $args = array(
                    'labels' => $labels,
                    'hierarchical' => true,
                    'label' => $i[2],
                    'show_ui' => true,
                    'query_var' => true,
                    'rewrite' => array(
                        'slug' => get_option($i[2] . '_slug') ? : $i[2],
                        'with_front' => false
                    ) ,
                    'show_admin_column' => false
                );
                register_taxonomy($i[2], array(
                    $n['post']
                ) , $args);
                if (isset($i[3]) && $i[3] == 1)
                    {
                    add_action('load-options-permalink.php',
                    function ($views) use($i)
                        {
                        if (isset($_POST[$i[2] . '_slug']) && !empty($_POST[$i[2] . '_slug']))
                            {
                            update_option($i[2] . '_slug', sanitize_title_with_dashes($_POST[$i[2] . '_slug']));
                            }

                        add_settings_field($i[2] . '_slug', __($i[0] . ' Slug') ,
                        function ($views) use($i)
                            {
                            $value = get_option($i[2] . '_slug');
                            echo '<input type="text" value="' . esc_attr($value) . '" name="' . $i[2] . '_slug' . '" id="' . $i[2] . '_slug' . '" class="regular-text" placeholder="' . $i[2] . '"/>';
                            }

                        , 'permalink', 'optional');
                        });
                    }
                }

            /*end for adding*/
            }
        }


    if (sbp_refact==1)
    {
    /* Filter the single_template with our custom function*/
    add_filter('single_template', 'sbp_custom_templates');
    }


    }

add_action('init','mtv_definitions');
function mtv_definitions()
{
	$wpml=(int)function_exists('icl_object_id');
	define('mtv_wpml',$wpml);
}




function mtv_get_posts_construct($post_type, $exclude = '', $query_attrs = array() , $number = '-1')
    {
    /*
    developer notices:
    $post_type => the post type you want to show
    $exlude => post to exclude, either id or array of ids
    $query_attrs => extra arguments for get_posts define like this : array('arg'=>'value','arg2'=>'valu2')
    $number by default =-1 or yyou put yourself
    */
    if (!empty($post_type))
        {
        $general_args = array(
            'post_type' => $post_type,
            'posts_per_page' => $number,
            'post_status' => 'publish'
        );
        $wpml = (int)function_exists('icl_object_id');
        if ($wpml == 1)
            {
            global $sitepress;
            $sitepress->switch_lang(ICL_LANGUAGE_CODE);
            $general_args['suppress_filters'] = false;
            }

        $meta_array = $return = array();
        if (!is_array($post_type))
            {
            $post_type = array(
                $post_type
            );
            }

        /*fix what you want to show depending on the post_meta*/
        switch ($post_type[0])
            {
        case 'page':
            $meta_array = array(
                '_thumbnail_id',
                'span_icon_class',
                'plx_text_section',
                'plx_small_header',
                'cover_media'
            );
            break;
        case 'plx_partners':
            $meta_array = array(
                '_thumbnail_id',
                'span_icon_class',
                'plx_small_header',
                'plx_small_title',
                'cover_media'
            );
            break;
        case 'plx_marinas':
            $meta_array = array(
                '_thumbnail_id',
                'span_icon_class',
                'plx_small_header'
            );
            break;
        default:
            break;
            }

        if (!empty($exclude))
            {
            if (!is_array($exclude))
                {
                $exclude = array(
                    $exclude
                );
                }

            $general_args['post__not_in'] = $exclude;
            }

        if (!empty($query_attrs))
            {
            foreach($query_attrs as $k => $v)
                {
                $general_args[$k] = $v;
                }
            }

        $posts = get_posts($general_args);
        if (!empty($posts))
            {
            foreach($posts as $p => $k)
                {
                /*general actions for all post types*/
                $return[$k->ID]['main'] = $k;
                $return[$k->ID]['permalink'] = get_permalink($k->ID);
                if (!empty($meta_array))
                    {
                    foreach($meta_array as $meta)
                        {
                        $return[$k->ID]['metas'][$meta] = get_post_meta($k->ID, $meta, true) ? : '';
                        }
                    }
                }
            }
        }

    return $return;
    }

add_filter('mtv_get_some_posts', 'mtv_get_posts_construct', 10, 4);

add_action('init', 'mtv_image_sizes');

function mtv_image_sizes() {
    for ($i=3;$i<=10;$i++)
        {
            $d=$i-1;
        add_image_size('mtv-custom-size-'.$i,$i*100,9999,false);
        }
}

function mtv_image_element($img_id) {
        $image  =  wp_get_attachment_url($img_id);
        $alt_text          = get_post_meta($img_id, '_wp_attachment_image_alt', true);
        $srcset = 'srcset="';
        for ($i=3;$i<=10;$i++)
        {
            if ($i == 10){
                $comma = '';
            }
            else {
                $comma = ', ';
            }
            $img = wp_get_attachment_image_src($img_id, 'sbp-custom-size-'.$i);
            $w = $i*100;

            $srcset .= $img[0].' '.$w.'w'.$comma;
        }
        $srcset .= '"';

            $img = '<img '.$srcset.' class="cover" alt="' . $alt_text . '" src="'.$image.'" sizes="(min-width: 1100px) 33.3vw, (min-width: 767px) 50vw, (min-width: 550px) 90vw"/>';

        return $img;
}


