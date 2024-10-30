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
class Meta_Box_Selected_Fields_Render
{


    /**
     * Initiializes the class
     *
     */
    public function __construct()
    {
    }

    /**
     * Renders the selected fields
     *
     * @param $post The post on this page
     */
    public function render($post)
    {
        wp_nonce_field('jem_cpt_field_meta_second', 'cptexamples_meta_box_nonce');

        echo "<form class='save_jem' action='" . admin_url('admin-post.php') . "' method='post'>";
        echo "<input type='hidden' class='jem-field' name='post_id' value='" . get_the_ID() . "'>";
        echo "<input type='hidden' name='action' value='jem_save_fields'>";
        $textTitle1 = get_post_meta($post->ID, 'cpt_first_meta_field1', true);
        $textClass2 = get_post_meta($post->ID, 'cpt_second_meta_field1', true);
        ?>

        <div>
            <ul id="jem-selected-fields-container">
                <?php $savedFields = get_post_meta($post->ID, 'jem_fields', true);

                //$savedFields = unserialize($savedFields);
                //print_r($getKeys);
                $i = 0;
                if (!empty($savedFields)) {
                    foreach ($savedFields as $field) {
                        $this->addBox($field, $i);       //creates the field accordian - does this by creating an array
                        $i++;
                    }
                }
                ?>
            </ul>

        </div>
        <?php
        echo "</form>";


        //Now render our modal. Alert before deleting field group
        $str = <<< EOT
<!--Modal: modalConfirmDelete-->
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure?</h5>
      </div>
      <div class="modal-body">
        Please confirm you wish to delete this item
      </div>
      <div class="modal-footer">
        <button id="modalCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="modalConfirm" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
<!--Modal: modalConfirmDelete-->
EOT;
        echo $str;

    }

    /**
     * @param array $data
     * @param $index
     */
    public function addBox($data = array(), $index)
    {
        //echo $data['label'];
        //print_r($data);
        $type = $data['field_type'];
        $mname = '';
        $hide_req = false;
        $fields = array();
        //creating array of values to sent into the backend. Array will make it easy to edit the fields in the future.
        switch ($type) {        //filter by type
            case 'number_field':
                $icon = 'fa-hashtag';
                $mname = "Number Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $placeholder = @$data['placeholder'];
                $class = $data['class'];
                $value = $data['value'];
                $max = $data['max'];
                $min = $data['min'];
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][3] = array(
                    'label' => 'Default Value',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter the default Value',
                    'value' => $value
                );
                $fields[$index][4] = array(
                    'label' => 'Minimum Value',
                    'field_name' => 'min',
                    'type' => 'number',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Minimum Value',
                    'value' => $min
                );
                $fields[$index][5] = array(
                    'label' => 'Maximum Value',
                    'field_name' => 'max',
                    'type' => 'number',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Maximum Value',
                    'value' => $max
                );
                break;
            case 'draggable_textbox':
                $icon = 'fa-text-width';
                $mname = "Text Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $unique_name = @$data['unique_name'];
                $label = @$data['label'];
                $placeholder = @$data['placeholder'];
                $class = @$data['class'];
                $value = @$data['value'];
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][4] = array(
                    'label' => 'Default Value',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter the default Value',
                    'value' => $value
                );
                break;
            case 'pass_field':
                $icon='fa-key';
                $mname = "Password Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $placeholder = $data['placeholder'];
                $class = $data['class'];
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'email_field':
                $icon='fa-envelope';
                $mname = "E-Mail Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $placeholder = @$data['placeholder'];
                $class = $data['class'];
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Field Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Placeholder',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'textarea_field':
                $icon='fa-terminal';
                $mname = "Textarea Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                // print_r($data);
                //  die;
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $placeholder = $data['placeholder'];
                $class = $data['class'];
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'upload_field':
                $icon='fa-file';
                $mname = "Upload Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'check_field':
                $icon='fa-check-square';
                $mname = "Checkbox Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }

                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][3] = array(
                    'label' => 'Field Options (Enter new option on new line.)',
                    'field_name' => 'options',
                    'type' => 'textarea',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'value : Label (new option on new line)',
                    'value' => @$data['options']
                );
                break;
            case 'select_field':
                //print_r($data);
                // die;
                $icon='fa-caret-square-o-down';
                $mname = "Dropdown Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                $value = @$data['options'];
                $placeholder = @$data['placeholder'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][4] = array(
                    'label' => 'Options',
                    'field_name' => 'options',
                    'type' => 'textarea',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'option : Label',
                    'value' => $value
                );
                break;
            case 'radio_field':
                $icon='fa-dot-circle-o';
                $mname = "Radio Field : <span class='changing_lbl'>" . $data['label'] . "</span>";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                $value = @$data['value'];
                $placeholder = @$data['placeholder'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][4] = array(
                    'label' => 'List of options',
                    'field_name' => 'value',
                    'type' => 'options_list',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'value : Label (new option seperated by line)',
                    'value' => $value
                );
                break;
            case 'date_field':
                $icon='fa-calendar';
                $mname = "Date Picker";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                $value = @$data['options'];
                $placeholder = @$data['placeholder'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'color_field':
                $icon='fa-paint-brush';
                $mname = "Color Field";
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                $value = @$data['options'];
                $placeholder = @$data['placeholder'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                break;
            case 'para_field':
                $icon='fa-paragraph';
                $mname = "Paragraph Field";
                //print_r($data);
                $unique_name = $data['unique_name'];
                $label = $data['label'];
                $class = $data['class'];
                $req = @$data['required'];
                $value = @$data['value'];
                $placeholder = @$data['placeholder'];
                if ($req == 'on') {
                    $ck = 'checked';
                } else {
                    $ck = '';
                }
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'Field Label',
                    'field_name' => 'label',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group kinput_detect',
                    'placeholder' => 'Enter Field Label',
                    'value' => $label
                );
                $fields[$index][2] = array(
                    'label' => 'Placeholder',
                    'field_name' => 'placeholder',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Placeholder Text',
                    'value' => $placeholder
                );
                $fields[$index][3] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][4] = array(
                    'label' => 'Content',
                    'field_name' => 'value',
                    'type' => 'wp_editor',
                    'classes' => 'col-sm-12 col-xs-12 form-group',
                    'placeholder' => 'Enter the default Value',
                    'value' => $value
                );
                break;
            case 'header_field':
                $icon='fa-header';
                $mname = "Header Field";
                $unique_name = $data['unique_name'];
                $value = $data['value'];
                $class = $data['class'];
                $heading = $data['tag'];
                $hide_req = true;
                $ck = '';
                $fields[$index][0] = array(
                    'label' => 'Field Unique Name',
                    'field_name' => 'unique_name',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Unique Name for field Letters and Underscore ONLY',
                    'value' => $unique_name
                );
                $fields[$index][1] = array(
                    'label' => 'CSS Classes',
                    'field_name' => 'class',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter class seperated by spaces',
                    'value' => $class
                );
                $fields[$index][2] = array(
                    'label' => 'Heading Tag',
                    'field_name' => 'tag',
                    'type' => 'header_field',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Select Heading Tag',
                    'value' => $heading
                );
                $fields[$index][3] = array(
                    'label' => 'Heading',
                    'field_name' => 'value',
                    'type' => 'text',
                    'classes' => 'col-sm-6 col-xs-12 form-group',
                    'placeholder' => 'Enter Heading Text',
                    'value' => $value
                );
                break;
        }
        ?>
        <li class="jem-field-draggable jem-field-selected <?php echo $type; ?>">
            <div class="jem-field-header d-flex justify-content-between">
                            <span>
                                <i class="fa <?= $icon; ?>" aria-hidden="true"></i>
                                <?php echo _e($mname, JEMPA_DOMAIN); ?>
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
            <div class="jem-field-inside jem-field-textbox jem-hide">
                <div class="row">

                    <div class="form-group col-sm-12">
                        <input type="hidden" data-jem-field-name="field_type" class="jem-field"
                               value="<?php echo $type; ?>">
                        <?php if (!$hide_req) { ?>
                            <input <?php echo $ck; ?> type="checkbox" class="jem-field form-check-input"
                                                      data-jem-field-name="required">
                            <label class="form-check-label" for="exampleCheck1">
                                <?php _e('Required', 'Jem Product Options'); ?></label>
                        <?php } ?>
                    </div>
                    <?php foreach ($fields[$index] as $fd) {
                        $this->generate_field($fd['label'], $fd['field_name'], $fd['type'], $fd['classes'], $fd['placeholder'], $fd['value']);    //convert array to fields
                    } ?>
                    <div class="hidden_textbox">
                        <input value="<?php echo $unique_name; ?>" type="hidden" name="jem_field_type[][jem_text_type]"
                               class="form-control">
                    </div>

                </div>
        </li>
        <?php
    }

    /**
     * Generates the HTML for a field
     * @param null $label
     * @param null $field_name
     * @param string $field_type
     * @param null $field_classes
     * @param null $placeholder
     * @param null $value
     */
    public function generate_field($label = null, $field_name = null, $field_type = 'text', $field_classes = null, $placeholder = null, $value = null)
    {
        ?>
        <div class="<?php echo $field_classes; ?>">
            <label><?php _e($label, 'Jem Product Options'); ?></label>
            <?php if ($field_type == "textarea") { ?>
                <textarea data-jem-field-name="<?php echo $field_name; ?>" class="jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea>
            <?php } elseif ($field_type == 'wp_editor') {
                //wp_editor($value, $field_name);
                ?>
                <textarea id="jemwpeditor" data-jem-field-name="<?php echo $field_name; ?>"
                          class="jem-wpeditor jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea>     <!--wp editor field-->
                <?php
            } elseif ($field_type == 'options_list') {
                ?>
                <textarea data-jem-field-name="<?php echo $field_name; ?>" class=" jem-field form-control"
                          placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea>

                <?php
            } elseif ($field_type == 'header_field') {
                $headings = array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6');
                ?>
                <select class="jem-field form-control" data-jem-field-name="<?php echo $field_name; ?>">
                    <option value=""><?php echo $placeholder; ?></option>
                    <?php foreach ($headings as $ar => $heading) {
                        ?>
                        <option <?php if ($value == $ar) { ?>selected="selected" <?php } ?>
                                value="<?php echo $ar; ?>"><?php echo $heading; ?></option>
                        <?php
                    } ?>
                </select>
                <?php
            } else {
                ?>
                <input class="jem-field form-control" value="<?php echo $value; ?>" type="<?php echo $field_type; ?>"
                       data-jem-field-name="<?php echo $field_name; ?>"
                       class="detect_input_label jem-field form-control"
                       placeholder="<?php echo $placeholder; ?>">
            <?php } ?>
        </div>
        <?php
    }




}
