<?php
/*
Plugin Name: Cappuccino Gallery
Description: Allows you to easily add videos and images to a gallery, and then use a shortcode to display them on a page of your choice. Optionally include description/captions with each item displayed.
Version: 0.6
License: GPLv3
Plugin URI: https://github.com/TurqDevDesign/Cappuccino-Gallery.git
GitHub Plugin URI: https://github.com/TurqDevDesign/Cappuccino-Gallery.git
Author: Austin Fish
Author URI:

==========================================================================

Copyright 2016 Austin Fish

This file is part of Cappuccino Gallery.

    TDMS Gallery is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    TDMS Gallery is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

// Uncomment following 2 lines for debuggine
 error_reporting(E_ALL);
 ini_set('display_errors',1);

//Exit if accessed directly - Preventing non-wordpress systems from running file.
if(!defined('ABSPATH')) {
    exit;
}

function cappu_gallery_registerImagePostType() {

    $singular = 'Image';
    $plural   = 'Images';
	$slug     = 'cappu-gallery-image';

    $labels   = array(
        'name'                => $plural,
        'singular_name'       => $singular,
        'add_name'            => 'Add New',
        'add_new_item'        => 'Add New ' . $singular,
        'edit'                => 'Edit',
        'edit_item'           => 'Edit ' . $singular,
        'new_item'            => 'New ' . $singular,
        'view'                => 'View ' . $singular,
        'view_item'           => 'View ' . $singular,
        'search_term'         => 'Search ' . $plural,
        'parent'              => 'Parent ' . $singular,
        'not_found'           => 'No ' . strtolower($plural) . ' found',
        'not_found_in_trash'  => 'No ' . strtolower($plural) . ' found in trash',
    );

    $args = array(
		'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_in_nav_menus'   => true,
        'show_ui'             => true,
        'show_in_menu'        => false,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-format-image',
        'can_export'          => true,
        'delete_with_user'    => false,
        'hierarchical'        => false,
        'has_archive'         => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        // 'capabilities' => array(),
        'rewrite'             => array(
        	'slug' => $slug,
        	'with_front' => true,
        	'pages' => true,
        	'feeds' => true,
        ),
        'supports'            => array(
        	'title'
        )
	);

    register_post_type($slug,$args);

}

function cappu_gallery_registerVideoPostType() {

    $singular = 'Video';
    $plural   = 'Videos';
    $slug     = 'cappu-gallery-video';

    $labels   = array(
        'name'                => $plural,
        'singular_name'       => $singular,
        'add_name'            => 'Add New',
        'add_new_item'        => 'Add New ' . $singular,
        'edit'                => 'Edit',
        'edit_item'           => 'Edit ' . $singular,
        'new_item'            => 'New ' . $singular,
        'view'                => 'View ' . $singular,
        'view_item'           => 'View ' . $singular,
        'search_term'         => 'Search ' . $plural,
        'parent'              => 'Parent ' . $singular,
        'not_found'           => 'No ' . strtolower($plural) . ' found',
        'not_found_in_trash'  => 'No ' . strtolower($plural) . ' found in trash',
    );

    $args = array(
		'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_in_nav_menus'   => true,
        'show_ui'             => true,
        'show_in_menu'        => false,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-format-video',
        'can_export'          => true,
        'delete_with_user'    => false,
        'hierarchical'        => false,
        'has_archive'         => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        // 'capabilities' => array(),
        'rewrite'             => array(
        	'slug' => $slug,
        	'with_front' => true,
        	'pages' => true,
        	'feeds' => true,
        ),
        'supports'            => array(
        	'title'
        )
	);

    register_post_type($slug,$args);

}

function cappu_gallery_addTopLevelMenuItem() {

    add_menu_page (
        'Manage Gallery',                         // Page title
        'Manage Gallery',                         // Menu title
        'manage_options',                         // Capabilities
        'cappu-gallery',                          // Slug
        'cappu_gallery_settings',                 // Callback
        'dashicons-format-gallery',               // Menu icon
        '8'                                       // Menu position
    );

    add_action('admin_init', 'cappu_gallery_settings_fields');

}

function cappu_gallery_addPostTypeSubmenus() {

    add_submenu_page(
        'cappu-gallery',                          // Parent slug
        'Gallery Settings',                                 // Page title
        'Gallery Settings',                                 // Menu title
        'manage_options',                         // Capabilities
        'cappu-gallery', // Slug
         NULL                                     // Callback
    );

    add_submenu_page(
        'cappu-gallery',                          // Parent slug
        'Images',                                 // Page title
        'Images',                                 // Menu title
        'manage_options',                         // Capabilities
        'edit.php?post_type=cappu-gallery-image', // Slug
         NULL                                     // Callback
    );

    add_submenu_page(
        'cappu-gallery',                              // Parent slug
        'Add new image',                              // Page title
        'Add new image',                              // Menu title
        'manage_options',                             // Capabilities
        'post-new.php?post_type=cappu-gallery-image', // Slug
         NULL                                         // Callback
    );

    add_submenu_page(
        'cappu-gallery',                          // Parent slug
        'Videos',                                 // Page title
        'Videos',                                 // Menu title
        'manage_options',                         // Capabilities
        'edit.php?post_type=cappu-gallery-video', // Slug
         NULL                                     // Callback
    );

    add_submenu_page(
        'cappu-gallery',                              // Parent slug
        'Add new video',                              // Page title
        'Add new video',                              // Menu title
        'manage_options',                             // Capabilities
        'post-new.php?post_type=cappu-gallery-video', // Slug
         NULL                                         // Callback
    );

    add_submenu_page(
        'cappu-gallery',                               // Parent slug
        'Galleries',                                   // Page title
        'Galleries',                                   // Menu title
        'manage_options',                              // Capabilities
        'edit-tags.php?taxonomy=cappu-gallery-groups', // Slug
         NULL                                          // Callback
    );

    add_submenu_page(
        'cappu-gallery',          // Parent slug
        'Help',                   // Page title
        'Help',                   // Menu title
        'manage_options',         // Capabilities
        'cappu_gallery_help',     // Slug
        'cappu_gallery_help_page' // Callback
    );

}

function cappu_gallery_taxonomy() {
	$singular = 'Gallery';
	$plural = 'Galleries';
	$slug = 'cappu-gallery-groups';
	$labels = array(
		'name'                       => $plural,
        'singular_name'              => $singular,
        'search_items'               => 'Search ' . $plural,
        'popular_items'              => 'Popular ' . $plural,
        'all_items'                  => 'All ' . $plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $singular,
        'update_item'                => 'Update ' . $singular,
        'add_new_item'               => 'Add New ' . $singular,
        'new_item_name'              => 'New ' . $singular . ' Name',
        'separate_items_with_commas' => 'Separate ' . $plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $plural,
        'not_found'                  => 'No ' . $plural . ' found.',
        'menu_name'                  => $plural,
	);
	$args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $slug )
        );
	register_taxonomy( $slug, array('cappu-gallery-video','cappu-gallery-image'), $args );

    register_taxonomy_for_object_type('cappu-gallery-groups', array('cappu-gallery-video','cappu-gallery-image'));

}

function cappu_gallery_highlight( $parent_file ) {
   global $current_screen;

   $taxonomy = $current_screen->taxonomy;
   if ( $taxonomy == 'cappu-gallery-groups' ) {
       $parent_file = 'cappu-gallery';
   }

   return $parent_file;
}

// Import shortcodes file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-shortcodes.php' ;

// Import settings file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-settings.php' ;

// Import help page file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-help.php' ;

// Import defaults file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-defaults.php' ;

// Import defaults file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-enqueue.php' ;

// Import post view file
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-post-view.php' ;

//Admin enqueue scripts and styles
add_action('admin_enqueue_scripts', 'cappu_gallery_admin_enqueue_scripts_and_styles');

//Front end enqueue scripts and styles
add_action('wp_enqueue_scripts', 'cappu_gallery_front_end_enqueue_scripts_and_styles');

// Register image post type
add_action('init', 'cappu_gallery_registerImagePostType');

// Register video post type
add_action('init', 'cappu_gallery_registerVideoPostType');

// Add custom top-level menu to house image/video gallery post types
add_action( 'admin_menu', 'cappu_gallery_addTopLevelMenuItem' );

// Add custom post types as submeus to custom top-level menu item
add_action( 'admin_menu', 'cappu_gallery_addPostTypeSubmenus' );

//Make sure custom taxonomy shows proper parent file when clicked
add_filter( 'parent_file', 'cappu_gallery_highlight' );

//Register galleries taxonomy
add_action( 'init', 'cappu_gallery_taxonomy' );

//Loading file to manipulate custom post type screen
require plugin_dir_path( __FILE__ ) . 'cappu-gallery-post-customization.php' ;
