<?php
/**
 * This handle our custom post type: Field Group
 */

namespace JEM_Extra_Product_Options\Admin;

class Field_Group_Custom_Post {


    /**
     * Initializes this class and hooks into WordPress init
     *
     */
    public function __construct(  ) {
        add_action( 'init',  array($this, 'init'));

    }

    /**
     * Registers this custom post with WordPress.
     *

     */
    public function init() {

        //TODO - need to internationalize these
        $labels = array(
            'name'                => 'Field Group',
            'singular_name'       => 'Group type',
            'parent_item_colon'   => 'Parent Slider Directory',
            'all_items'           => 'All New Group',
            'view_item'           => 'View Group',
            'add_new_item'        => 'Add New Group',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit Group',
            'update_item'         => 'Update Group',
            'search_items'        => 'Search Group',
            'not_found'           => 'Not Found',
            'not_found_in_trash'  => 'Not found in Trash'
        );
        $args_slider = array(
            'labels'              => $labels,
            'supports'            => array('title'),
            'rewrite'               =>  array('slug'=>'jempa_field_group'),
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'can_export'          => true,
            'public' => false,
            'publicly_queryable' =>false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'has_archive' => false,
            //'rewrite' => false
        );
        register_post_type( 'jempa_field_group', $args_slider );

    }
}
