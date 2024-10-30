<?php
/**
 * Defines the functionality required to render the content within the Meta Box
 * to which this display belongs.
 */

namespace JEM_Extra_Product_Options\Admin;

/**
 * Defines the functionality required to render the content within the Meta Box
 * to which this display belongs.
 *
 * When the render method is called, the contents of the string it includes
 * or the file it includes to render within the meta box.
 */
class Meta_Box_Available_Fields_Render
{


    /**
     * Initiializes the class
     *
     */
    public function __construct()
    {
    }

    /**
     * Renders a single string in the context of the meta box to which this
     * Display belongs.
     *
     * @param $post The post on this page
     */
    public function render($post)
    { ?>
        <!-- START OF AVAILABLE FIELDS -->

        <!-- <form method="post"> -->


        <div id="jem-field-draggable-wrapper">
            <ul id="available-fields-ul">

                <!-- START FIELDS THAT CAN BE SELECTED -->
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-text-width" aria-hidden="true"></i>
                                <?php echo _e('Text Field', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1 edit_fields">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="draggable_textbox">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $text_fields_array = $this->get_fields_array_by_type('draggable_textbox');   //get fields array by type textbbox
                            foreach ($text_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-hashtag" aria-hidden="true"></i>
                                <?php echo _e('Number Field', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="number_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $no_fields_array = $this->get_fields_array_by_type('number_field');         //get fields by type number
                            foreach ($no_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <?php echo _e('Password Field', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="pass_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $pass_fields_array = $this->get_fields_array_by_type('pass_field');                 //get fields by type password
                            foreach ($pass_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <?php echo _e('Email Field', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="email_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $email_fields_array = $this->get_fields_array_by_type('email_field');           //get fields by type email
                            foreach ($email_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-terminal" aria-hidden="true"></i>
                                <?php echo _e('Textarea', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="textarea_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $textarea_fields_array = $this->get_fields_array_by_type('textarea_field');                      //get fields by type textarea
                            foreach ($textarea_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-file" aria-hidden="true"></i>
                                <?php echo _e('File Upload', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="upload_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $upload_fields_array = $this->get_fields_array_by_type('upload_field');                  //get fields by type upoad
                            foreach ($upload_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable check_field">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php echo _e('Checkbox', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="check_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $check_fields_array = $this->get_fields_array_by_type('check_field');        //get fields by type checkbox
                            foreach ($check_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                <?php echo _e('Dropdown Field', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="select_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $select_fields_array = $this->get_fields_array_by_type('select_field');              //get fields by type select
                            foreach ($select_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                <?php echo _e('Radio Buttons', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="radio_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $radio_fields_array = $this->get_fields_array_by_type('radio_field');            //get fields by type radio
                            foreach ($radio_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>

                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo _e('Date Picker', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="date_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $date_fields_array = $this->get_fields_array_by_type('date_field');                  //get fields by type date
                            foreach ($date_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>

                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                <?php echo _e('Color', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="color_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $color_fields_array = $this->get_fields_array_by_type('color_field');                    //get fields by type color
                            foreach ($color_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], @$value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>
                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-paragraph" aria-hidden="true"></i>
                                <?php echo _e('Paragraph', JEMPA_DOMAIN); ?>
                                                                                             </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="para_field">
                                <input type="checkbox" class="jem-field form-check-input"
                                       data-jem-field-name="required">
                                <label class="form-check-label" for="exampleCheck1">
                                    <?php _e('Required', 'Jem Product Options'); ?></label>
                            </div>
                            <?php
                            $para_fields_array = $this->get_fields_array_by_type('para_field');  //get fields by typr paragraph
                            foreach ($para_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                </li>

                <li class="jem-field-draggable">
                    <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa fa-header" aria-hidden="true"></i>
                                <?php echo _e('Header', JEMPA_DOMAIN); ?>
                            </span>
                            <span class="jem-field-inside">
                                <a href="" class="text-white btn-link p-1">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-delete-field">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="text-white btn-link p-1 jem-clone-field">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            </span>
                    </div>
                    <div class="jem-field-inside jem-field-textbox">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                                       value="header_field">
                                <?php /*  <input type="checkbox" class="jem-field form-check-input"
                                           data-jem-field-name="required">
                                    <label class="form-check-label" for="exampleCheck1">
                                        <?php _e('Required', 'Jem Product Options'); ?></label> */ ?>
                            </div>
                            <?php
                            $header_fields_array = $this->get_fields_array_by_type('header_field');
                            foreach ($header_fields_array as $key => $value) {
                                $this->generate_field($value['label'], $value['field_name'], $value['type'], $value['classes'], $value['placeholder']);
                            }
                            ?>
                            <div class="hidden_textbox">
                                <input type="hidden" name="jem_field_type[][jem_text_type]" class="form-control">
                            </div>

                        </div>
                        <!-- END TEXT FIELD -->
                </li>

            </ul>
        </div>

        <?php
    }

    public function get_fields_array_by_type($type)
    {
        //get fields by type. get array of fields
        $fields = array();
        switch ($type) {
            case 'draggable_textbox':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //     'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    // 'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                /*
                $fields[4] = array(
                  'label'        => 'Default Value',
                  'field_name'   => 'value',
                  'type'         => 'text',
                  'classes'      => 'col-sm-6 col-xs-12 form-group',
                  'placeholder'  => 'Enter the default Value',
                //  'value'        => $value
                );
                $fields[5] = array(
                  'label'        => 'Max Length',
                  'field_name'   => 'length',
                  'type'         => 'text',
                  'classes'      => 'col-sm-6 col-xs-12 form-group',
                  'placeholder'  => 'Enter the Max number of Characters',
                //  'value'        => $length
                );*/
                break;
            case 'number_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //      'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //   'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //    'value'        => $class
                );
                $fields[3] = array(
                    'label' => 'Default Value',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter the default Value',
                    //  'value'        => $value
                );
                $fields[4] = array(
                    'label' => 'Minimum Value',
                    'field_name' => 'min',
                    'type' => 'number',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Minimum Value',
                    //  'value'        => $min
                );
                $fields[5] = array(
                    'label' => 'Maximum Value',
                    'field_name' => 'max',
                    'type' => 'number',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Maximum Value',
                    //   'value'        => $max
                );
                break;
            case 'pass_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //   'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                break;
            case 'email_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //    'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    // 'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Field Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Placeholder',
                    // 'value'        => $label
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    // 'value'        => $class
                );
                break;
            case 'textarea_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //   'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    // 'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    // 'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                $fields[4] = array(
                    'label' => 'Default Value',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter the default Value',
                    // 'value'        => $value
                );
                $fields[5] = array(
                    'label' => 'Max Length',
                    'field_name' => 'length',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter the Max number of Characters',
                    // 'value'        => $length
                );
                break;
            case 'upload_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //     'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                break;
            case 'check_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name will be automatically generated',
                    //     'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                $fields[3] = array(
                    'label' => 'Options',
                    'field_name' => 'options',
                    'type' => 'textarea',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'value : Label (new option on new line)',
                    //  'value'        => $value
                );
                break;
            case 'select_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //   'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    // 'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                $fields[4] = array(
                    'label' => 'Options',
                    'field_name' => 'options',
                    'type' => 'textarea',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'value : Label (each value in each line)',
                    //  'value'        => $class
                );
                /*
                $fields[4] = array(
                  'label'        => 'Default Value',
                  'field_name'   => 'value',
                  'type'         => 'text',
                  'classes'      => 'col-sm-6 col-xs-12 form-group',
                  'placeholder'  => 'Enter the default Value',
               //   'value'        => $value
                );
                $fields[5] = array(
                  'label'        => 'Max Length',
                  'field_name'   => 'length',
                  'type'         => 'text',
                  'classes'      => 'col-sm-6 col-xs-12 form-group',
                  'placeholder'  => 'Enter the Max number of Characters',
                //  'value'        => $length
                );  */
                break;
            case 'radio_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //   'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    // 'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                $fields[3] = array(
                    'label' => 'List of options',
                    'field_name' => 'value',
                    'type' => 'options_list',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'value : Label (new option seperated by line)',
                    //  'value'        => $value
                );
                break;
            case 'date_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //    'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                break;
            case 'color_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //    'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //   'value'        => $class
                );
                break;
            case 'para_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //     'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Field Label',
                    //  'value'        => $label
                );
                $fields[2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    //  'value'        => $placeholder
                );
                $fields[3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //   'value'        => $class
                );
                $fields[4] = array(
                    'label' => 'Content',
                    'field_name' => 'value',
                    'type' => 'wp_editor',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => '',
                    //  'value'        => $value
                );
                break;
            case 'header_field':
                $fields[0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    //     'value'        => $unique_name
                );
                $fields[1] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    //  'value'        => $class
                );
                $fields[2] = array(
                    'label' => 'Heading Tag',
                    'field_name' => 'tag',
                    'type' => 'header_field',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Select Heading Tag',
                    //  'value'        => $heading
                );
                $fields[3] = array(
                    'label' => 'Heading',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Heading Text',
                    //  'value'        => $placeholder
                );

                break;
        }
        return $fields;
    }

    public function generate_field($label = null, $field_name = null, $field_type = 'text', $field_classes = null, $placeholder = null)
    {
        ?>
        <div class="<?php echo $field_classes; ?>">
            <label><?php _e($label, 'Jem Product Options'); ?></label>
            <?php if ($field_type == 'textarea') { ?>
                <textarea data-jem-field-name="<?php echo $field_name; ?>" class="jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"></textarea>
            <?php } elseif ($field_type == 'wp_editor') {
                $content = '';
                $editor_id = $field_name;
                ?>
                <textarea id="jemwpeditor" data-jem-field-name="<?php echo $field_name; ?>"
                          class="jem-wpeditor jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"></textarea>
                <?php
                //  wp_editor($content, $editor_id);
            } elseif ($field_type == 'options_list') {
                ?>
                <textarea data-jem-field-name="<?php echo $field_name; ?>" class="jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"></textarea>
                <?php /*
                                                todo tried to add new method to add options in check and radio field
                                                
                                                    <div class="row">
                                                        <div class="clone_tobe">
                                                            <div class="col-sm-5">
                                                            <input data-jem-field-name="value][][field_lbl" class="jem-field form-control" type="text" placeholder="Field Label"/>   
                                                            </div>
                                                            <div class="col-sm-5">
                                                            <input data-jem-field-name="value][][field_val" class="jem-field form-control" type="text" placeholder="Value"/>   
                                                            </div>
                                                            <div class="col-sm-1 text-cntr">
                                                                <input data-jem-field-name="value][][chk_bx" type="checkbox" class="jem-field form_control checkbox"/>
                                                            </div>
                                                            <div class="col-sm-1 text-cntr lst">
                                                                <a href="#" class="cloz"><i class="fa fa-close"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="clonned_items">

                                                        </div>
                                                        <div class="col-sm-12">
                                                        <button class="btn btn-primary add_row">Add New Row</button>
                                                        </div>
                                                    </div>
                                                    */ ?>
                <?php
            } elseif ($field_type == 'header_field') {
                $headings = array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6');
                ?>
                <select class="jem-field form-control" data-jem-field-name="<?php echo $field_name; ?>">
                    <option value=""><?php echo $placeholder; ?></option>
                    <?php foreach ($headings as $ar => $heading) {
                        ?>
                        <option value="<?php echo $ar; ?>"><?php echo $heading; ?></option>
                        <?php
                    } ?>
                </select>
                <?php
            } else { ?>
                <input type="<?php echo $field_type; ?>" data-jem-field-name="<?php echo $field_name; ?>"
                       class="jem-field form-control"
                       placeholder="<?php echo $placeholder; ?>">
            <?php } ?>
        </div>
        <?php
    }

}
