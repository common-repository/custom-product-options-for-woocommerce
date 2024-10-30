<?php
/**
 * Provides a consistent way to enqueue all administrative-related stylsheets.
 */

namespace JEM_Extra_Product_Options\Admin\Util;

/**
 * Provides a consistent way to enqueue all administrative-related stylsheets.
 *
 * Implements the Assets_Interface by defining the init function and the
 * enqueue function.
 *
 * The first is responsible for hooking up the enqueue
 * callback to the proper WordPress hook. The second is responsible for
 * actually registering and enqueueing the file.
 *
 * @implements Assets_Interface
 * @since      0.2.0
 */
class CSS_Loader implements Assets_Interface
{

    /**
     * Registers the 'enqueue' function with the proper WordPress hook for
     * registering stylesheets.
     */
    public function init()
    {

        add_action(
            'admin_enqueue_scripts',
            array($this, 'enqueue')
        );

    }

    /**
     * Defines the functionality responsible for loading the file.
     */
    public function enqueue()
    {


        //Get the current screen!
        $screen= get_current_screen();

        global $post;

        //Only enqueue if we are on our custom post type screen
        //This avoids loading this all over WordPress!!!
        if($screen->post_type=='shop_order')
        {
            wp_enqueue_script('jempa-order-script', plugins_url('assets/js/custom_script.js', dirname(__FILE__)));
        }
        if ('jempa_field_group' === $screen->post_type) {

            //Base CSS For the plugin
            
            wp_enqueue_style( 'jempa-custom-css',  plugins_url('assets/css/jem-custom-style.css', dirname(__FILE__), array()), '1.0.0');

            //TODO - what does this do?
          //  wp_deregister_script('postbox');

            //Bootstrap CSS
            wp_enqueue_style( 'bootstrap-style',  plugins_url('assets/css/bootstrap.min.css', dirname(__FILE__), array()), '1.0.0');

            //Fontawesome CSS
            wp_enqueue_style( 'font-awesome', plugins_url('assets/css/font-awesome.css', dirname(__FILE__)), false, '1.0.0');
            wp_enqueue_style( 'select2_style', plugins_url( 'assets/css/select2.min.css', dirname(__FILE__) ), false, '1.0.0');
            wp_enqueue_editor();
            wp_enqueue_script( 'select2_script', plugins_url( 'assets/js/select2.min.js', dirname(__FILE__) ), false, '1.0.0');

            //Bootstrap & plugin Javascript
            wp_enqueue_script('jempa-boostrap-script', plugins_url('assets/js/bootstrap.min.js', dirname(__FILE__)));
            wp_enqueue_script('jempa-custom-script', plugins_url('assets/js/myscript.js', dirname(__FILE__)));

            wp_enqueue_script( 'jquery-ui-core' );
          //  wp_enqueue_script( 'jquery-ui-autocomplete' );
            //jQueryUI javascript
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script('jquery-ui-droppable');
            wp_enqueue_script('jquery-ui-sortable');
            

        }
    }

}
