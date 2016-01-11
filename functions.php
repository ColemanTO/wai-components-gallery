<?php
/**
 * WAI Components Gallery functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WAI_Components_Gallery
 */

if ( ! function_exists( 'wai_components_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wai_components_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WAI Components Gallery, use a find and replace
	 * to change 'wai_components' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wai_components', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary Menu', 'wai_components' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wai_components_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	function wai_add_contributer_role() {
 		add_role('wai_custom_post_manager',
            'WAI Contributor',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
            )
        );
   }
   register_activation_hook( __FILE__, 'wai_add_contributer_role' );

    add_action('admin_init','wai_add_role_caps',999);
    function wai_add_role_caps() {

		// Add the roles you'd like to administer the custom post types
		$roles = array('wai_custom_post_manager','editor','administrator');

		// Loop through each role and assign capabilities
		foreach($roles as $the_role) {

		     $role = get_role($the_role);

         $role->add_cap( 'read' );
         $role->add_cap( 'read_wai_custom_post');
         $role->add_cap( 'read_private_wai_custom_posts' );
         $role->add_cap( 'edit_wai_custom_post' );
         $role->add_cap( 'edit_wai_custom_posts' );
         $role->add_cap( 'edit_others_wai_custom_posts' );
         $role->add_cap( 'edit_published_wai_custom_posts' );
         $role->add_cap( 'publish_wai_custom_posts' );
         $role->add_cap( 'delete_others_wai_custom_posts' );
         $role->add_cap( 'delete_private_wai_custom_posts' );
         $role->add_cap( 'delete_published_wai_custom_posts' );

		}
	}

  // Add Post types for the Components Gallery
  /*
  register_post_type( 'wai_vendors',
    array(
      'labels' => array(
        'name' => __( 'Vendors' ),
        'singular_name' => __( 'Vendor' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array(
      	'title', 'thumbnail', 'comments', 'revisions'
      ),
      'rewrite' => array (
      	'slug' => "vendor",
      	'with_front' => "false"
      ),
      'capability_type'     => array('wai_custom_post','wai_custom_posts'),
      'map_meta_cap'        => true,
    )
  );*/

  register_post_type( 'wai_templates',
    array(
      'labels' => array(
        'name' => __( 'Templates' ),
        'singular_name' => __( 'Template' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array(
      	'title', 'thumbnail', 'comments', 'revisions', 'editor'
      ),
      'rewrite' => array (
      	'slug' => "template",
      	'with_front' => "false"
      ),
      'capability_type'     => array('wai_custom_post','wai_custom_posts'),
      'map_meta_cap'        => true,
      'taxonomies'          => array('post_tag'),
    )
  );

  register_post_type( 'wai_widgets',
    array(
      'labels' => array(
        'name' => __( 'Widgets' ),
        'singular_name' => __( 'Widget' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array(
      	'title', 'thumbnail', 'comments', 'revisions', 'editor'
      ),
      'rewrite' => array (
      	'slug' => "widget",
      	'with_front' => "false"
      ),
      'capability_type'     => array('wai_custom_post','wai_custom_posts'),
      'map_meta_cap'        => true,
      'taxonomies'          => array('post_tag'),
    )
  );

  register_post_type( 'wai_frameworks',
    array(
      'labels' => array(
        'name' => __( 'Frameworks' ),
        'singular_name' => __( 'Framework' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array(
      	'title', 'thumbnail', 'comments', 'revisions', 'editor'
      ),
      'rewrite' => array (
      	'slug' => "framework",
      	'with_front' => "false"
      ),
      'capability_type'     => array('wai_custom_post','wai_custom_posts'),
      'map_meta_cap'        => true,
      'taxonomies'          => array('post_tag'),
    )
  );

   // Add a taxonomy like categories
    $labels = array(
      'name'              => 'Vendors',
      'singular_name'     => 'Vendor',
      'search_items'      => 'Search Vendors',
      'all_items'         => 'All Vendors',
      'parent_item'       => 'Parent Vendor',
      'parent_item_colon' => 'Parent Vendor:',
      'edit_item'         => 'Edit Vendor',
      'update_item'       => 'Update Vendor',
      'add_new_item'      => 'Add New Vendor',
      'new_item_name'     => 'New Vendor Name',
      'menu_name'         => 'Vendors',
    );

    $args = array(
      'hierarchical'      => false,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'meta_box_cb'       => false,
      'rewrite'           => array( 'slug' => 'vendor' ),
    );

    register_taxonomy('wai_component_vendor',array('wai_frameworks', 'wai_widgets', 'wai_templates'),$args);

    // Add a taxonomy like tags
  $labels = array(
    'name'                       => 'Tags',
    'singular_name'              => 'Tag',
    'search_items'               => 'Tags',
    'popular_items'              => 'Popular Tags',
    'all_items'                  => 'All Tags',
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => 'Edit Tag',
    'update_item'                => 'Update Tag',
    'add_new_item'               => 'Add New Tag',
    'new_item_name'              => 'New Tag Name',
    'separate_items_with_commas' => 'Separate Tags with commas',
    'add_or_remove_items'        => 'Add or remove Tags',
    'choose_from_most_used'      => 'Choose from most used Tags',
    'not_found'                  => 'No Tags found',
    'menu_name'                  => 'Tags',
  );

  $args = array(
    'hierarchical'          => false,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'tags' ),
  );

  register_taxonomy('wai_tags',array('wai_frameworks', 'wai_widgets', 'wai_templates'),$args);

  add_image_size ( 'small', 200, 100 );

}
endif; // wai_components_setup
add_action( 'after_setup_theme', 'wai_components_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wai_components_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wai_components_content_width', 640 );
}
add_action( 'after_setup_theme', 'wai_components_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wai_components_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wai_components' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wai_components_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wai_components_scripts() {
	wp_enqueue_style( 'wai_components-style', get_stylesheet_uri() );

	wp_enqueue_script( 'wai_components-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'wai_components-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

  wp_enqueue_script( 'wai_components-svg4everybody', get_template_directory_uri() . '/js/svg4everybody.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wai_components_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function wai_icon( $name ) {
  return '<svg class="icon-'.$name.'"><use xlink:href="'.get_template_directory_uri().'/img/icons.svg#icon-'.$name.'"></use></svg>';
}
