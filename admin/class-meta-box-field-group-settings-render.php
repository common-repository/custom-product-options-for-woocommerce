<?php
/**
 * Defines the functionality required to render the content within the Meta Box
 * to which this display belongs.
 */
namespace JEM_Extra_Product_Options\Admin;

/**
 * Field group settings page
 * Defines the functionality required to render the content within the Meta Box
 * to which this display belongs.
 *
 * When the render method is called, the contents of the string it includes
 * or the file it includes to render within the meta box.
 */
class Meta_Box_Field_Group_Settings_Render {


    /**
     * Initiializes the class
     *
     */
    public function __construct(  ) {
    }

    /**
     * Renders a single string in the context of the meta box to which this
     * Display belongs.
     *
     * @param $post The post on this page
     */
    public function render( $post ) {

        wp_nonce_field( 'jem_cpt_field_meta', 'cptexamples_meta_box_nonce' );
        $textTitle  = get_post_meta( $post->ID, 'cpt_first_meta_field', true );
        $textClass = get_post_meta( $post->ID, 'cpt_class_meta_field', true );
        $selected_products = get_post_meta( $post->ID, 'selected_products', true );
        $selected_terms = get_post_meta( $post->ID, 'selected_terms', true );
        if(empty($selected_products))
        {
            $selected_products = array();
        }
        if(empty($selected_terms))
        {
            $selected_terms = array();
        }
        $productDisplayRule = get_post_meta( $post->ID, 'productDisplayRule', true );
        $categoryDisplayRule = get_post_meta( $post->ID, 'categoryDisplayRule', true );
      //  echo $productDisplayRule;
       // die;
      //  print_r($selected_products);
        ?>
        <nav class="mt-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="group_setting" data-toggle="tab" href="#group_setting_redirect" role="tab" aria-controls="nav-home" aria-selected="true"> <?php _e( 'Group Settings', 'Jem Product Options' ); ?> </a>
                <a class="nav-item nav-link" id="display_setting" data-toggle="tab" href="#display_setting_redirect" role="tab" aria-controls="nav-profile" aria-selected="false"><?php _e( 'Display Settings', 'Jem Product Options' ); ?></a>
            </div>
        </nav>

        <div class="tab-content tab-content-customize" id="nav-tabContent">
            <div class="tab-pane fade show active" id="group_setting_redirect" role="tabpanel" aria-labelledby="group_setting">
                <?php
                echo '<div class="row">';
                echo '<div class="col-sm-6 col-xs-6 form-group">';
                echo '<label for="cpt_first_meta_field">';
                echo _e( 'Title Text', 'Jem Product Options' );
                echo '</label><input class="form-control" type="text" id="cpt_first_meta_field" placeholder="Enter Title Text" name="cpt_first_meta_field" value="' . esc_attr( $textTitle ) . '"   />';
                echo '</div>';
                echo '<div class="col-sm-6 col-xs-6 form-group">';
                echo '<label for="cpt_class_meta_field">';
                echo  _e( 'CSS Class', 'cpt_domain' );
                echo '</label><input class="form-control" type="text" id="cpt_class_meta_field" placeholder="Enter Css Class" name="cpt_class_meta_field" value="' . esc_attr( $textClass ) . '"   />';
                echo '</div>';
                echo '</div>';
                ?>
            </div>
            <div class="tab-pane fade" id="display_setting_redirect" role="tabpanel" aria-labelledby="display_setting">
                <!--?php _e( 'Display settings', 'Jem Product Options' ); ?-->
                <form class="row" action="/action_page.php">
                    <div class="col-sm-6">
                        <div class="productRuleWrapper mb-4">
                            <h5>
                                <?php echo _e( 'Product Display Rules', 'Jem Product Options' ); ?></h5>
                            <div class="form-group">
                                <label for="group1">Show this group of fields if</label>
                                <div class="form-check">
                                    <input <?php if($productDisplayRule=='incl') { ?> checked <?php } ?> class="form-check-input" type="radio" name="productDisplayRule" id="productIsIn" value="incl">
                                    <label class="form-check-label" for="productIsIn">
                                        Product is in
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input <?php if($productDisplayRule=='excl') { ?> checked <?php } ?> class="form-check-input" type="radio" name="productDisplayRule" id="productIsNotIn" value="excl">
                                    <label class="form-check-label" for="productIsNotIn">
                                        Product is not in
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="selectProduct">Select Products</label>
                             <!--   <input type="text" class="form-control" id="selectProduct" aria-describedby="selectProduct" placeholder="Selected Product"> -->
                             <?php
                                $args = array(
                                    'post_type' => 'product',
                                    'post_status' => 'publish',
                                    'posts_per_page'   => -1 // all posts
                                );
                            
                                $posts = get_posts( $args );
                            
                                    if( $posts ) :
                                        foreach( $posts as $k => $post ) {
                                            $source[$k]['ID'] = $post->ID;
                                            $source[$k]['label'] = $post->post_title; // The name of the post
                                            $source[$k]['permalink'] = get_permalink( $post->ID );
                                        }
                                    endif;
                            
                                ?>
                                <select name="selected_products[]" style="width: 100%" multiple class="form-control" id="selected_products" aria-describedby="selectProduct" placeholder="Selected Product">
                                <option value="">Select Products</option>
                                <?php 
                                    foreach ($source as $value) {
                                        ?>
                                        <option <?php if(in_array($value['ID'], $selected_products)) { ?>selected="selected" <?php } ?> value="<?php echo $value['ID']; ?>"><?php echo $value['label']; ?></option>
                                        <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="productRuleWrapper">
                            <h5>Category Display Rules</h5>
                            <div class="form-group">
                                <label for="group2">Show this group of fields if</label>
                                <div class="form-check">
                                    <input <?php if($categoryDisplayRule=='incl') { ?> checked <?php } ?> class="form-check-input" type="radio" name="categoryDisplayRule" id="productIsIn1" value="incl">
                                    <label class="form-check-label" for="productIsIn1">
                                        Product is in
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input <?php if($categoryDisplayRule=='excl') { ?> checked <?php } ?> class="form-check-input" type="radio" name="categoryDisplayRule" id="productIsIn2" value="excl">
                                    <label class="form-check-label" for="productIsIn2">
                                        Product is not in
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="selectProduct">Select Terms</label>
                                <?php
                                $terms = get_terms( 'product_cat', array(
                                    'hide_empty' => false,
                                ) );
                                ?>
                               <!-- <input type="text" class="form-control" id="selectProduct" aria-describedby="selectProduct" placeholder="Selected Product"> -->
                               <select style="width: 100%" multiple name="selected_terms[]" id="selected_terms">
                                    <?php
                                    foreach($terms as $tr)
                                    {
                                            ?>
                                                <option <?php if(in_array($tr->term_id, $selected_terms)) { ?>selected="selected" <?php } ?> value="<?php echo $tr->term_id; ?>"><?php echo $tr->name; ?></option>
                                            <?php
                                    }
                                     ?>
                               </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
<?php 
}
}