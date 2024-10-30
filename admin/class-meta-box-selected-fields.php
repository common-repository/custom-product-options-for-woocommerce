<?php
/**
 * Represents a meta box for Available Fields - the list of fields
 * Displayed on the custom post page
 */

namespace JEM_Extra_Product_Options\Admin;

/**
 * Represents a meta box to be displayed within the 'Add New Post' page.
 *
 * The class maintains a reference to a display object responsible for
 * displaying whatever content is rendered within the display.
 */
class Meta_Box_Selected_Fields {

    /**
     * A reference to the Meta Box Display.
     *
     * @access private
     * @var    Meta_Box_Field_Group_Settings_Render
     */
    private $display;

    /**
     * Initializes this class by setting its display property equal to that of
     * the incoming object.
     *
     * @param Meta_Box_Field_Group_Settings_Render $display Displays the contents of this meta box.
     */
    public function __construct( $display ) {
        $this->display = $display;
    }

    /**
     * Registers this meta box with WordPress.
     *

     */
    public function init() {

        add_meta_box(
            'jempa-selected-fields-meta-box',
            __("Selected Fields", JEMPA_DOMAIN),
            array( $this->display, 'render' ),
            'jempa_field_group',
            'advanced',
            'high'
        );
    }
}
