<?php
/**
 * Plugin Name: Custom Product Options for WooCommerce
 * Description: The purpose of this plugin is to allow the user to create extra fields that can be used on WooCommerce products.
 * Version: 1.0
 * Author: JEM Products
 * Author URI: https://jem-products.com/
 */

namespace JEM_Extra_Product_Options;

use JEM_Extra_Product_Options\Admin;
use JEM_Extra_Product_Options\Admin\Util;

defined('ABSPATH') or die('Do not access the file directly');

// If this file is accessed directory, then abort.
if (!defined('WPINC')) {
    die;
}

//Some globals
define("JEMPA_DOMAIN", "JEMPA_DOMAIN");

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(trailingslashit(dirname(__FILE__)) . 'inc/autoloader.php');


class JEM_Product_Options
{

    //Constructor
    function __construct()
    {

        register_deactivation_hook(__FILE__, array($this, 'jem_uninstall'));
        include_once(plugin_dir_path(__FILE__) . 'admin/functions.php');

        add_action('save_post', array($this, 'save_meta_box_data'));
        add_action('admin_menu', array($this, 'register_submenu_page'));

        //Set up the Custom Post
        $cpt = new Admin\Field_Group_Custom_Post();

        add_action('woocommerce_before_add_to_cart_button', array($this, 'woo_before_add_to_cart_button'), 10);                // add fields after add to cart button wordpress
        add_action('admin_post_jem_save_fields', array($this, 'jem_save_fields'));                    // save fields data
        add_filter('woocommerce_add_cart_item_data', array($this, 'jem_add_custom_field_item_data'), 10, 4);        // store fields data in cart
        //add_filter( 'woocommerce_add_to_cart_validation', array($this, 'jem_check_for_empty_values'), 10, 3 ); doesn't need for now
        add_filter('woocommerce_cart_item_name', array($this, 'jem_cart_item_name'), 10, 3);            //show fields data in cart
        add_action('admin_head-post.php', array($this, 'jempa_field_group_xhr'));                    //save field data before publishing post
        add_action('admin_head-post-new.php', array($this, 'jempa_field_group_xhr'));                //ajax action to save fields

        add_action('wp_ajax_jem_save_fields', array($this, 'jem_save_fields'));
        add_action('wp_enqueue_scripts', array($this, 'jem_scripts_styles_frontend'));

        add_action('woocommerce_checkout_create_order_line_item', array($this, 'jem_add_custom_data_to_order'), 10, 4);        //display fields data in checkout and order meta

        //Load the CSS/JS files
        $css_loader = new Util\CSS_Loader();                // load the css loader class
        $css_loader->init();
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));        //show field meta data
        //add ajax action for upload field
        add_action('wp_ajax_jem_upload_file', array($this, 'jem_upload_file'));            // ajax action to upload a file
        add_action('wp_ajax_nopriv_jem_upload_file', array($this, 'jem_upload_file'));

    }

    public function jem_add_custom_data_to_order($item, $cart_item_key, $values, $order)
    {
        //print_r($values);
        //die;
        $get_groups = $this->get_field_groups();        //get existing field groups
        $l = array();
        foreach ($get_groups as $grg) {
            $p = 0;
            if (!empty($grg)) {
                $get_existing = get_post_meta($grg, 'jem_fields', true);        //get saved fields
                //$get_existing = unserialize($get_existing);
                foreach ($get_existing as $gex) {
                    //print_r($gex);
                    $fname = $gex['unique_name'];                //filter values by unique name
                    if (!empty($values[$fname])) {
                        if (is_array($values[$fname])) {
                            $nam = implode(", ", $values[$fname]);        //check if array if passed in cart data and if is passed convert to comma seperated string
                        } else {
                            $nam = $values[$fname];
                            if ($gex['field_type'] == 'upload_field') {
                                $nam = '<a class="change_admin" href="' . $values[$fname] . '">' . basename($values[$fname]) . '</a>';        //show upload file as a link in cart item data
                            }
                            /*
                            elseif($gex['field_type']=='email_field')
                            {
                                $nam = '<a href="mailto:'.$values[$fname].'">'.$values[$fname].'</a>';		//convert email field to link
                            }
                            elseif($gex['field_type']=='color_field')
                            {
                                $nam = '<span class="color-box" style="color:'.$values[$fname].';background:'.$values[$fname].'">'.$values[$fname].'</span>';	//convert color field to color box
                            }
                            */ //no html//
                        }
                        //$l[$p][$fname] = $cart_item[$fname];
                        //	$name .= '<p class="mar-0"><strong>'.$gex['label'].'</strong> : '.$nam.'</p>';			//show each value in p tag
                        $item->add_meta_data(__($gex['label'], 'jem'), $nam);

                    }
                    $p++;
                }
                //print_r($get_existing);

            }
        }
    }

    /**
     * Register the submenu
     */
    public function register_submenu_page()
    {
        // Create Product options  for Wocommerce
        add_submenu_page('woocommerce', 'JEM Product Options', 'JEM Product Options', 'manage_options', 'edit.php?post_type=jempa_field_group', null);

    }


    /**
     * Adds the meta boxes into WordPress
     */
    public function add_meta_boxes()
    {

        //Field Group Settings
        $meta_box_field_group_settings = new Admin\Meta_Box_Field_Group_Settings(
            new Admin\Meta_Box_Field_Group_Settings_Render()
        );

        $meta_box_field_group_settings->init();

        //Available Fields
        $meta_box_available_fields = new Admin\Meta_Box_Available_Fields(
            new Admin\Meta_Box_Available_Fields_Render()
        );

        $meta_box_available_fields->init();

        //Selected Fields
        $meta_box_selected_fields = new Admin\Meta_Box_Selected_Fields(
            new Admin\Meta_Box_Selected_Fields_Render()
        );

        $meta_box_selected_fields->init();

    }

    /**
     * Add our custom fields into the cart
     * @param $cart_item_data
     * @param $product_id
     * @param $variation_id
     * @param $quantity
     * @return mixed
     */
    public function jem_add_custom_field_item_data($cart_item_data, $product_id, $variation_id, $quantity)
    {
        global $woocommerce;

        ///altering fields to find checkbox
        //TODO at some put these inside the array
        foreach ($_POST as $key => $data) {

            //Make sure the key has not been tampered with
            if (sanitize_text_field($key) != $key) {
                //something unexpected so discard this entry
                continue;
            }

            //Do we have a checkbox?
            if (strpos($key, 'check_field') !== false) {

                //Sanitize the data
                $data = $this->sanitize_array($data);

                //
                $cart_item_data[$key] = implode(", ", $data); //add it to the cart
                //print_r($dat);
                //die;
            }
        }
        /*******checbox validation end *******/

        //Now check the rest of the fields
        //TODO - put the checkbox in here at some point
        if (!empty($_POST['jempa_fields'])) {

            // Add the custom fields to the cart
            foreach ($_POST['jempa_fields'] as $key => $data) {

                //Make sure the key has not been tampered with
                if (sanitize_text_field($key) != $key) {
                    //something unexpected so discard this entry
                    continue;
                }

                $cart_item_data[$key] = $this->sanitize_array($data); //store each field in the cart
            }
        }

        return $cart_item_data;

    }


    /* save draggable field data into db */

    public function jem_save_fields()
    {
        //$postFields = $_POST['jem_fields'];
        $return = '';
        $jem_post_id = intval(sanitize_text_field($_POST['post_id']));
        if (isset($_POST['jem_fields'])) {
            $o = 0;
            $fields_data = isset($_POST['jem_fields']) ? (array)$_POST['jem_fields'] : array();
            $fields_data = $this->sanitize_array($fields_data);
            $fd = array();        //create empty array of fields
            //print_r($_POST);
            //die;
            $randomNum = rand(500, 9999);        //generate a random number between 500 and 9999
            foreach ($fields_data as $fdd) {
                //print_r($fdd);
                if (!empty($fdd['unique_name'])) {
                    $fd[$o] = $fdd;
                } else {
                    $fd[$o]['unique_name'] = $jem_post_id . '-' . sanitize_title($fdd['field_type'] . '-' . $randomNum);                //if name is empty generate a random string for name
                    $fdd['unique_name'] = $jem_post_id . '-' . sanitize_title($fdd['field_type'] . '-' . $randomNum);
                    $fd[$o] = $fdd;
                }
                $o++;
            }


            //update_post_meta($jem_post_id, 'jem_fields', maybe_serialize($fd));            //save posted data
            update_post_meta($jem_post_id, 'jem_fields', $fd);            //save posted data
            //$getKeys = get_post_meta($jem_post_id, 'jem_fields', true);                //get saved fields data
            //$mydata = unserialize($getKeys);

            $return = array('success' => true);                                            //send success message to ajax action js
        }

        wp_send_json($return);                                        //send json response to ajax
        wp_die();                                                        //prevent return 0

    }


    public function save_meta_box_data($post_id)
    {
        // Save the information into the database
        // print_r($_POST);
        //die;
        ///////////////save field group settings\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if (isset($_POST['cpt_first_meta_field'])) {

            $text_meta_field = sanitize_text_field($_POST['cpt_first_meta_field']);
            update_post_meta($post_id, 'cpt_first_meta_field', $text_meta_field);
        }

        if (isset($_POST['cpt_class_meta_field'])) {

            $class_meta_field = sanitize_text_field($_POST['cpt_class_meta_field']);
            update_post_meta($post_id, 'cpt_class_meta_field', $class_meta_field);
        }

        if (isset($_POST['cpt_first_meta_field1'])) {

            $text_meta_field_text = sanitize_text_field($_POST['cpt_first_meta_field1']);
            update_post_meta($post_id, 'cpt_first_meta_field1', $text_meta_field_text);
        }

        if (isset($_POST['cpt_second_meta_field1'])) {

            $class_meta_field_text = sanitize_text_field($_POST['cpt_second_meta_field1']);
            update_post_meta($post_id, 'cpt_second_meta_field1', $class_meta_field_text);
        }
        if (isset($_POST['selected_products'])) {

            $selected_products = isset($_POST['selected_products']) ? (array)$_POST['selected_products'] : array();
            $selected_products = $this->sanitize_array($selected_products);
            update_post_meta($post_id, 'selected_products', $selected_products);
        } else {
            update_post_meta($post_id, 'selected_products', '');
        }
        if (isset($_POST['selected_terms'])) {

            $selected_terms = isset($_POST['selected_terms']) ? (array)$_POST['selected_terms'] : array();
            $selected_terms = $this->sanitize_array($selected_terms);
            update_post_meta($post_id, 'selected_terms', $selected_terms);
        } else {
            update_post_meta($post_id, 'selected_terms', '');
        }
        if (isset($_POST['productDisplayRule'])) {
            $productDisplayRule = sanitize_text_field($_POST['productDisplayRule']);
            update_post_meta($post_id, 'productDisplayRule', $productDisplayRule);
        }
        if (isset($_POST['categoryDisplayRule'])) {
            $categoryDisplayRule = sanitize_text_field($_POST['categoryDisplayRule']);
            update_post_meta($post_id, 'categoryDisplayRule', $categoryDisplayRule);
        }

    }

    public function get_field_groups()
    {
        $args = array(
            'post_type' => 'jempa_field_group',
            'posts_per_page' => -1
        );
        $the_query = new \WP_Query($args);                        //get created field groups

        // The Loop
        $data = array();
        if ($the_query->have_posts()) {
            ///	echo '<ul>';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $data[] = get_the_ID();                                    //store an array of field groups ids
            }
            ///	echo '</ul>';
        }
        wp_reset_postdata();
        return $data;
    }

    /*** save_meta_box_data***/
    public function jem_uninstall()
    {
        // Uninstall Method
    }

    public function woo_before_add_to_cart_button()
    {
        global $post;
        $show = false;
        $get_groups = $this->get_field_groups();
        if (!empty($get_groups)) {
            echo '<table class="jem-extra-options jem_tbl" cellspacing="0"><tbody>';
        }
        foreach ($get_groups as $gg) {
            $get_existing = get_post_meta($gg, 'jem_fields', true);
            $product_condition = get_post_meta($gg, 'productDisplayRule', true);
            $terms_condition = get_post_meta($gg, 'categoryDisplayRule', true);
            $selected_products = get_post_meta($gg, 'selected_products', true);
            $selected_terms = get_post_meta($gg, 'selected_terms', true);
            $cats = get_the_terms($post->ID, 'product_cat');
            $tid = $cats[0]->term_id;
            //print_r($cats);
            //die;
            if (!empty($selected_products))            //check selected products in field group
            {
                if ($product_condition == 'incl')                //check if condition is include or exclude and show/hide fields according to that
                {
                    if (in_array($post->ID, $selected_products)) {
                        $show = true;
                    } else {
                        $show = false;
                    }
                } else {
                    if (!in_array($post->ID, $selected_products)) {
                        $show = true;
                    } else {
                        $show = false;
                    }
                }
            } else {
                if (!empty($selected_terms))            //check selected products in field group
                {
                    if ($terms_condition == 'incl')                //check if condition is include or exclude and show/hide fields according to that
                    {
                        if (in_array($tid, $selected_terms)) {
                            $show = true;
                        } else {
                            $show = false;
                        }
                    } else {
                        if (!in_array($tid, $selected_terms)) {
                            $show = true;
                        } else {
                            $show = false;
                        }
                    }
                } else {
                    $show = true;
                }
            }

            if ($show) {
                //$get_existing = unserialize($get_existing);
                //print_r($get_existing);
                foreach ($get_existing as $exist) {
                    //show different type of fields according to type
                    switch ($exist['field_type']) {
                        case 'header_field':
                            $this->addHeading($exist);
                            break;
                        case 'para_field':
                            $this->addParafield($exist);
                            break;
                        case 'draggable_textbox':
                            $this->addTextboxx($exist);
                            break;
                        case 'number_field':
                            $this->addNumberbox($exist);
                            break;
                        case 'pass_field':
                            $this->addPassbox($exist);
                            break;
                        case 'textarea_field':
                            $this->addTextarea($exist);
                            break;
                        case 'email_field':
                            $this->addEmailarea($exist);
                            break;
                        case 'upload_field':
                            $this->addUploadbox($exist);
                            break;
                        case 'check_field':
                            $this->addCheckbox($exist);
                            break;
                        case 'select_field':
                            $this->addSelectbox($exist);
                            break;
                        case 'date_field':
                            $this->addDatepicker($exist);
                            break;
                        case 'radio_field':
                            $this->addRadiofield($exist);
                            break;
                        case 'color_field':
                            $this->addColorfield($exist);
                            break;
                    }
                }
            }

        }
        if (!empty($get_groups)) {
            echo '</tbody></table>';
        }
        //	}

    }

    public function addColorfield($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        $red = 'false';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
            $red = 'true';
        }
        /********create a color picker box ********/
        ?>
        <tr class="">
            <td class="label leftside"><label
                    class="label-tag "><?php echo @$data['label']; ?></label> <?php echo $req; ?></td>
            <td class="value leftside">
                <input id="cpick" <?php echo $reqd; ?> type="text"
                       name="jempa_fields[<?php echo $data['unique_name']; ?>]"
                       class="jscolor {required:<?php echo $red; ?>,hash:true} jem-input-field <?php echo $cl; ?>"
                       placeholder="<?php echo $data['placeholder']; ?>"></td>
        </tr>
        <?php
    }

    public function addParafield($data)
    {
        ?>
        <tr class="">
            <td class="label leftside" colspan="2">
                <div class="jem-field-para <?php echo $data['class']; ?>">
                    <?php echo wpautop($data['value']); ?>
                </div>
            </td>
        </tr>
        <?php
    }

    public function addHeading($data)
    {
        //print_r($data);
        //add heading field for each section
        ?>
        <tr class="">
            <td class="label leftside" colspan="2">
                <div class="jem-field-heading">
                    <<?php echo $data['tag']; ?> class="jem-heading <?php echo $data['class']; ?>
                    "><?php echo $data['value']; ?></<?php echo $data['tag']; ?>>
                </div>
            </td>
        </tr>
        <?php
    }

    public function addRadiofield($data)
    {
        /*********add a new radio field ******* */
        /////custom styled radio box
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <?php
                //$data['value'] = sanitize_title(@$data['value']);
                //echo $data['value'];
                //die;
                $value_list = explode(PHP_EOL, @$data['value']);
                //echo count($value_list);
                //$value_list = trim($value_list);
                //print_r($value_list);							//check what is sent in the frontend, Only for debugging purposes.s
                if (!empty($value_list[0])) {
                    echo "<ul class='check_field_list'>";
                    foreach ($value_list as $vlist) {
                        $labelv = explode(' : ', $vlist);
                        if (count($labelv) > 1) {
                            //	print_r($labelv);
                            ?>
                            <li><label class="container_radio">
                                    <?php echo $labelv[1]; ?>
                                    <input name="jempa_fields[<?php echo $data['unique_name']; ?>]" type="radio"
                                           value="<?php echo $labelv[0]; ?>" class="jem-input-field <?php echo $cl; ?>">
                                    <span class="checkmark"></span>
                                </label></li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <label class="container_radio">
                                    <?php echo $labelv[0]; ?>
                                    <input name="jempa_fields[<?php echo $data['unique_name']; ?>]" type="radio"
                                           value="<?php echo sanitize_title($labelv[0]); ?>"
                                           class="jem-input-field <?php echo $cl; ?>">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <?php
                        }
                    }
                    echo "</ul>";
                }
                ?>
                <?php /*<input <?php echo $reqd; ?> type="email" name="<?php echo $data['unique_name']; ?>" value="<?php echo @$data['value']; ?>" class="jem-input-field <?php echo $cl; ?>"> */ ?>
            </td>
        </tr>
        <?php
    }

    public function addDatepicker($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <input placeholder="<?php echo @$data['placeholder']; ?>" <?php echo $reqd; ?> type="text"
                       name="jempa_fields[<?php echo $data['unique_name']; ?>]" value="<?php echo @$data['value']; ?>"
                       class="jem-date jem-input-field <?php echo $cl; ?>">
            </td>
        </tr>
        <?php
    }

    public function addSelectbox($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <?php
                $data['value'] = sanitize_title(@$data['options']);
                //echo $data['value'];
                //die;
                $value_list = explode(PHP_EOL, @$data['options']);
                //echo count($value_list);
                //$value_list = trim($value_list);
                if (!empty($value_list[0])) {
                    echo "<select name='jempa_fields[" . $data['unique_name'] . "]' " . $reqd . " class='jem-select-field form-control " . $cl . "'>";
                    ?>
                    <option value=""><?php echo $data['placeholder']; ?></option>
                    <?php
                    foreach ($value_list as $vlist) {
                        $labelv = explode(' : ', $vlist);
                        if (count($labelv) > 1) {
                            ?>
                            <option value="<?php echo $labelv[0]; ?>"><?php echo $labelv[1]; ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo sanitize_title($labelv[0]); ?>"><?php echo $labelv[0]; ?></option>
                            <?php
                        }
                        /*
                        <li><label><input name="<?php echo $data['unique_name']; ?>[]" type="checkbox" value="<?php echo $labelv[0]; ?>" class="jem-input-field <?php echo $cl; ?>"><?php echo $labelv[1]; ?></label></li>
                        <?php */
                    }
                    echo "</select>";
                }
                ?>
                <?php /*<input <?php echo $reqd; ?> type="email" name="<?php echo $data['unique_name']; ?>" value="<?php echo @$data['value']; ?>" class="jem-input-field <?php echo $cl; ?>"> */ ?>
            </td>
        </tr>
        <?php
    }

    public function addCheckbox($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <?php
                //$data['value'] = sanitize_title(@$data['value']);
                //echo $data['value'];
                //die;
                $value_list = explode(PHP_EOL, @$data['options']);
                //echo count($value_list);
                //$value_list = trim($value_list);
                //print_r($value_list);
                if (!empty($value_list[0])) {
                    echo "<ul class='check_field_list'>";
                    foreach ($value_list as $vlist) {
                        $vlist = preg_replace('/\s+/', '', $vlist);
                        $labelv = explode(':', $vlist);
                        if (count($labelv) > 1) {
                            /****check if user has input label and value or just the label *****/
                            ?>
                            <li><label class="container_check">    <!-- styled the default checkboes -->
                                    <?php echo $labelv[1]; ?>
                                    <input name="<?php echo $data['unique_name']; ?>[]" type="checkbox"
                                           value="<?php echo $labelv[0]; ?>" class="jem-input-field <?php echo $cl; ?>">
                                    <span class="checkmark"></span>
                                </label></li>
                        <?php } else {
                            ?>
                            <li><label class="container_check">
                                    <?php echo $labelv[0]; ?>
                                    <input name="<?php echo $data['unique_name']; ?>[]" type="checkbox"
                                           value="<?php echo sanitize_title($labelv[0]); ?>"
                                           class="jem-input-field <?php echo $cl; ?>">
                                    <span class="checkmark"></span>
                                </label></li>
                        <?php } ?>
                        <?php
                    }
                    echo "</ul>";
                }
                ?>
            </td>
        </tr>
        <?php
    }

    public function addEmailarea($data)            //add email field
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <input placeholder="<?php echo @$data['placeholder']; ?>" <?php echo $reqd; ?> type="email"
                       name="jempa_fields[<?php echo $data['unique_name']; ?>]" value="<?php echo @$data['value']; ?>"
                       class="jem-input-field <?php echo $cl; ?>">
            </td>
        </tr>
        <?php
    }

    public function addUploadbox($data)                //add upload a file box
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <input <?php echo $reqd; ?> type="file" class="upf jem-input-field <?php echo $cl; ?>">
                <input type="hidden" name="jempa_fields[<?php echo $data['unique_name']; ?>]"/>
                <button class="btn btn-primary upload_a_file">Upload</button>
            </td>
        </tr>
        <?php
    }

    public function addPassbox($data)
    {
        /******** add new password field *********/
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside">
                <label class="label-tag ">
                    <?php echo $data['label']; ?>
                </label>
                <?php echo $req; ?>
            </td>
            <td class="value leftside">
                <input placeholder="<?php echo @$data['placeholder']; ?>" <?php echo $reqd; ?> type="password"
                       name="jempa_fields[<?php echo $data['unique_name']; ?>]" value="<?php echo @$data['value']; ?>"
                       class="jem-input-field <?php echo $cl; ?>">
            </td>
        </tr>
        <?php
    }

    public function addNumberbox($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside"><label
                    class="label-tag "><?php echo @$data['label']; ?></label> <?php echo $req; ?></td>
            <td class="value leftside">
                <input min="<?php echo @$data['min']; ?>" max="<?php echo @$data['max']; ?>" <?php echo $reqd; ?>
                       type="number" name="jempa_fields[<?php echo $data['unique_name']; ?>]"
                       value="<?php echo @$data['value']; ?>" class="jem-input-field <?php echo $cl; ?>"></td>
        </tr>
        <?php
    }

    public function addTextarea($data)
    {
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside"><label
                    class="label-tag "><?php echo @$data['label']; ?></label> <?php echo $req; ?></td>
            <td class="value leftside">
                <textarea <?php echo $reqd; ?> name="jempa_fields[<?php echo $data['unique_name']; ?>]"
                                               class="jem-input-field <?php echo $cl; ?>"
                                               placeholder="<?php echo $data['placeholder']; ?>"></textarea></td>
        </tr>
        <?php
    }

    public function addTextboxx($data)
    {
        //print_r($data);					// debugging purposes
        $req = '';
        $cl = '';
        $reqd = '';
        if (@$data['required'] == 'on') {
            $req = '<abbr class="required" title="Required">*</abbr>';
            $cl = ' validate-required ';
            $reqd = 'required';
        }
        ?>
        <tr class="">
            <td class="label leftside"><label
                    class="label-tag "><?php echo @$data['label']; ?></label> <?php echo $req; ?></td>
            <td class="value leftside">
                <input <?php echo $reqd; ?> type="text" name="jempa_fields[<?php echo $data['unique_name']; ?>]"
                                            value="<?php echo @$data['value']; ?>"
                                            class="jem-input-field <?php echo $cl; ?>"
                                            placeholder="<?php echo $data['placeholder']; ?>"></td>
        </tr>
        <?php
    }

    public function jempa_field_group_xhr()
    {
        global $post;
        if ('jempa_field_group' === $post->post_type) {            //check for post type
            $post_url = admin_url('post.php'); #In case we're on post-new.php
            /////update fields data first and than publish/update post
            echo "
			<script>
				jQuery(document).ready(function($){
					//Click handler - you might have to bind this click event another way
					$('input#publish, input#save-post').click(function(){
						tinyMCE.triggerSave();
							var data2 = $('form.save_jem').serializeArray();
							data2.push({action: 'save_jem_fields'});
							jQuery.post(ajaxurl, data2, function(response) {
								var opt = '<option value=publish>Publish</option>';
								$('#post_status').prepend(opt);
								$('#post_status').val('publish');
								$('form#post').submit();
						});
						return false;
					});
				});
			</script>";
        }
    }

    public function jem_cart_item_name($name, $cart_item, $cart_item_key)
    {
        $get_groups = $this->get_field_groups();        //get existing field groups
        $l = array();
        foreach ($get_groups as $grg) {
            $p = 0;
            if (!empty($grg)) {
                $get_existing = get_post_meta($grg, 'jem_fields', true);        //get saved fields
                //$get_existing = unserialize($get_existing);
                foreach ($get_existing as $gex) {
                    //print_r($gex);
                    $fname = $gex['unique_name'];                //filter values by unique name
                    if (!empty($cart_item[$fname])) {
                        if (is_array($cart_item[$fname])) {
                            $nam = implode(", ", $cart_item[$fname]);        //check if array if passed in cart data and if is passed convert to comma seperated string
                        } else {
                            $nam = $cart_item[$fname];
                            if ($gex['field_type'] == 'upload_field') {
                                $nam = '<a href="' . $cart_item[$fname] . '">' . basename($cart_item[$fname]) . '</a>';        //show upload file as a link in cart item data
                            }
                            /*
                            elseif($gex['field_type']=='email_field')
                            {
                                $nam = '<a href="mailto:'.$cart_item[$fname].'">'.$cart_item[$fname].'</a>';		//convert email field to link
                            }
                            elseif($gex['field_type']=='color_field')
                            {
                                $nam = '<span class="jscolor color-box" style="color:'.$cart_item[$fname].';background:'.$cart_item[$fname].'">'.$cart_item[$fname].'</span>';	//convert color field to color box
                            } *///no html
                        }
                        //$l[$p][$fname] = $cart_item[$fname];
                        $name .= '<p class="mar-0"><strong>' . $gex['label'] . '</strong> : ' . $nam . '</p>';            //show each value in p tag
                    }
                    $p++;
                }
                //print_r($get_existing);

            }
        }

        return $name;
    }

    public function jem_scripts_styles_frontend()
    {
        wp_enqueue_style('jem_woo_style', plugins_url('assets/css/jem-style.css', __FILE__), false, '1.0.0', 'all');            //add a stylesheet to the plugin
        wp_enqueue_script('jquery-ui-datepicker');                            // embed datepicker script
        wp_enqueue_style('e2b-admin-ui-css', plugins_url('assets/css/jquery-ui.css', __FILE__), false, "1.9.0", false);    // add jquery theme
        wp_enqueue_script('jem-color-picker', plugins_url('assets/js/jscolor.js', __FILE__), array('jquery'), null, true);        //required for color field
        wp_enqueue_script('jem-ajax', plugins_url('assets/js/jem-ajax.js', __FILE__), array('jquery'), null, true);                // add custom js in frontend
        wp_localize_script('jem-ajax', 'jem',
            array(
                'ajaxurl' => admin_url('admin-ajax.php')        //send ajax url in script (required in wordpress)
            )
        );

    }

    public function cfwc_add_custom_data_to_order($item, $cart_item_key, $values, $order)
    {        //add data to checkout
        $get_groups = $this->get_field_groups();
        foreach ($item as $cart_item_key => $values) {
            $l = array();
            foreach ($get_groups as $grg) {
                //$p = 0;
                if (!empty($grg)) {
                    $get_existing = get_post_meta($grg, 'jem_fields', true);
                    //$get_existing = unserialize($get_existing);
                    foreach ($get_existing as $gex) {
                        //print_r($gex);
                        $fname = $gex['unique_name'];
                        if (!empty($cart_item[$fname])) {

                            //$l[$p][$fname] = $cart_item[$fname];
                            //	$name .= '<p class="mar-0"><strong>'.$gex['label'].'</strong> : <span>'.$cart_item[$fname].'</span></p>';
                            $item->add_meta_data(__($gex['label'], 'Jem Product Options'), $cart_item[$fname], true);
                        }
                        //$p++;
                    }

                }
            }
        }
    }

    public function jem_upload_file()
    {                    //upload file action
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['file'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
        if ($movefile && !isset($movefile['error'])) {
            wp_send_json(array('success' => true, 'url' => $movefile['url']));
        } else {
            wp_send_json(array('success' => false, 'msg' => $movefile['error']));
        }
        die();
    }

    /**
     * used to sanitize a multidimensional array
     * @param $array
     * @return mixed
     */
    public function sanitize_array(&$array)
    {

        //In the event we don't get an array
        if (!is_array($array)) {
            $array = sanitize_textarea_field($array);
            return $array;
        }

        foreach ($array as &$value) {

            if (!is_array($value))

                // sanitize if value is not an array
                $value = sanitize_textarea_field($value);

            else

                // go inside this function again
                $this->sanitize_array($value);

        }

        return $array;

    }
}


// Instance of JemProductOption.

if (class_exists('JEM_Extra_Product_Options\JEM_Product_Options')) {
    new JEM_Product_Options();
}
