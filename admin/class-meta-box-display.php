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
class Meta_Box_Display {

    /**
     * A reference to the object responsible for retrieving a question to display.
     *
     * @access private
     * @var    Question_Reader $question_reader
     */
    private $question_reader;

    /**
     * Initiializes the class by setting the question reader property.
     *
     * @param Question_Reader $question_reader The object for retrieving a question.
     */
    public function __construct(  ) {
    }

    /**
     * Renders a single string in the context of the meta box to which this
     * Display belongs.
     */
    public function render() {

        $file = dirname( __FILE__ ) . '/data/questions.txt';
        $question = $this->question_reader->get_question_from_file( $file );

        $html = "<p id='tutsplus-author-prompt'>$question</p>";

        echo $this->sanitized_html( $html );
    }

    /**
     * Sanitizes the incoming markup to the user so that
     *
     * @access private
     * @param  string $html The markup to render in the meta box.
     * @return string       Sanitized markup to display to the user.
     */
    private function sanitized_html( $html ) {

        $allowed_html = array(
            'p' => array(
                'id' => array(),
            ),
        );

        return wp_kses( $html, $allowed_html );
    }
}
