<?php
/*
Plugin Name: WCDenver Plugin
Plugin URI: https://wordpress.org/plugins/health-check/
Description: An example plguin
Version: 1.0.0
Author: David Hayes
Author URI: http://davidbhayes.com
*/

add_action( 'init', 'wcdenver_register_testimonials' );
function wcdenver_register_testimonials() {
	$labels = array(
		'name'               => 'Testimonials',
		'singular_name'      => 'Testimonial',
		'menu_name'          => 'Testimonials',
		'name_admin_bar'     => 'Testimonial',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Testimonial',
		'new_item'           => 'New Testimonial',
		'edit_item'          => 'Edit Testimonial',
		'view_item'          => 'View Testimonial',
		'all_items'          => 'All Testimonials',
		'search_items'       => 'Search Testimonials',
		'parent_item_colon'  => 'Parent Testimonials:',
		'not_found'          => 'No testimonials found.',
		'not_found_in_trash' => 'No testimonials found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
    	'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
	);

	register_post_type( 'testimonial', $args );
}


add_action( 'init', 'wcdenver_register_testimonial_taxonomies' );
function wcdenver_register_testimonial_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Skills', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Skill', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Skills', 'textdomain' ),
		'all_items'         => __( 'All Skills', 'textdomain' ),
		'edit_item'         => __( 'Edit Skill', 'textdomain' ),
		'update_item'       => __( 'Update Skill', 'textdomain' ),
		'add_new_item'      => __( 'Add New Skill', 'textdomain' ),
		'new_item_name'     => __( 'New Skill Name', 'textdomain' ),
		'menu_name'         => __( 'Skill', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'skill' ),
	);

	register_taxonomy( 'skill', array( 'testimonial' ), $args );
}

add_shortcode( 'wcdenver_testimonial', 'wcdenver_testimonial_shortcode' );
function wcdenver_testimonial_shortcode( $atts ) {
	return wcdenver_return_markup_for_random_testimonial();
}

add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );
function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style-name', plugin_dir_url(__FILE__).'styles.css' );
    wp_enqueue_script( 'script-name', plugin_dir_url(__FILE__).'carasoul.js', array(), '1.0.0', true );
}


function wcdenver_return_markup_for_random_testimonial() {
	$args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => 10,
		'orderby' => 'rand',
	);
	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) {
		$buffer = '';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$buffer = $buffer.'<p>"' . get_the_content() . '"</p>';
			$buffer = $buffer.'<p>&mdash;' . get_the_title() . '</p>';
		}
		return $buffer;
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		return 'There are no testimonials';
	}
}

class WCDenver_Testimonial extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'wcdenver_testimonial',
			'description' => 'This shows a random testimonial',
		);
		parent::__construct( 'wcdenver_testimonial', 'WCDenver Testimonial', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $args['before_title'] . 'Our Testimonials'. $args['after_title'];
		echo wcdenver_return_markup_for_random_testimonial();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'WCDenver_Testimonial' );
});