var $ = jQuery.noConflict();

jQuery(document).ready(function ($) {


    //Set up the click events etc
    initClickHandlers();

    //TODO This all needs refactoring
    //=========== SELECTED FIELDS CONTAINER ===========//
    
    $("#jem-selected-fields-container").sortable({
        placeholder: 'jem-fields-selected-placeholder',
        revert: true,
        helper: 'clone',
        update: function (event, ui) {
            addFieldToSelectedFields(ui);
        }
    });

    //=========== Draggable js===========//
    jQuery("#sortable").disableSelection();
    jQuery(".jem-field-draggable").draggable({
        connectToSortable: "#jem-selected-fields-container",
        //helper: "clone",
        helper: function (event) {
            var li = $(event.target).closest("li");

            return $(li).clone().css({
                width: $(li).width()
            })
        },
        revert: "invalid"
    });
    jQuery('ul#jem-selected-fields-container li').draggable('destroy');

    renameSelectedFields();

    jQuery('#selected_products').select2();
    jQuery('#selected_terms').select2();
    jQuery(document).on('click', '.edit_fields', function(){
        return false;
    });
    jQuery('.detect_input_label').keyup(function(){
        jQuery(this).parent().parent().parent().parent().find('.changing_lbl').text(jQuery(this).val());
       });
    jQuery(document).on('click', '.add_row', function(){
        var tbc = jQuery('.clone_tobe').html();
        jQuery('.clonned_items').prepend('<div class="cloned">'+tbc+'</div>');
        renameRadioOptions();
        return false;
    });
    jQuery(document).on('click', '.cloz', function(){
        var r = confirm("Are you sure?");
        if(r)
        {
           // alert('yes')
           jQuery(this).parent().parent().fadeOut('slow').remove();
        }
        renameRadioOptions();
        return false;
    });
    jQuery('.jem-clone-field').click(function(){
        var li = jQuery(this).parent().parent().parent();
        var $clone = li.clone();
        $clone.find('input[data-jem-field-name="unique_name"]').val('');
        $clone.insertAfter(li);
        renameSelectedFields();
        return false;
    });
}); //END Document Ready


/**
 * Turns on all the click handlers
 * We try and keep them in one place for clarity
 */
function initClickHandlers() {

    //When the header on a selected field is clicked
    $("#jem-selected-fields-container").on("click", ".jem-field-header", function () {
        selectedFieldHeaderClicked(this);
    });

    //When the DELETE FIELD icon is clicked
    $("#jem-selected-fields-container").on("click", ".jem-delete-field", function (e) {
        deleteFieldIconClicked(e, this);
    });

}
/**
 * Handles when a field is dropped on the selected fields...
 * @param ui
 */
function addFieldToSelectedFields(ui) {


    //Add the selected class so it gets displayed correctly!
    $(ui.item).addClass('jem-field-selected');

    //Go through each selected block and renumber the fields
    renameSelectedFields();
   /* jQuery('.clone_tobe').find('.jem-field').each(function(){
       var ty
        console.log(inputname);
    }); */
    console.log(jQuery('.search_field').attr('name'));

}

/**
 * Renames the selected fields
 */
function renameSelectedFields(){
    $('#jem-selected-fields-container .jem-field-draggable').each(function (i) {
        $(this).find('.jem-field').each(function () {
            var jem_field_name = jQuery(this).data('jem-field-name');
            jem_field_name = "jem_fields[" + i + "][" + jem_field_name + "]";
            $(this).attr("name", jem_field_name);
            var edid = jQuery(this).attr('id');
            console.log(edid);
            if(jQuery(this).hasClass('jem-wpeditor'))                   //initialised wp editor using jquery
            {
                $(this).attr("id", edid+'_'+i);
                wp.editor.initialize(
                    edid+'_'+i,
                    { 
                      tinymce: { 
                        wpautop:true, 
                        plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview', 
                        toolbar1: 'formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | spellchecker' 
                      }, 
                      quicktags: true 
                    }
                  );
              //  console.log(edid);
          //      wp.editor.initialize(edid, true);
            }
        })
    });

}
/*
function renameRadioOptions(){
    $('.cloned').each(function (i) {
        $(this).find('.jem-field').each(function () {
            var jem_field_name = jQuery(this).data('jem-field-name');
            jem_field_name = "jem_fields[" + i + "][" + jem_field_name + "]";
            $(this).attr("name", jem_field_name);
        })
    });

}
/**
 *
 * @param header - which header is being clicked
 */
function selectedFieldHeaderClicked(header) {

    //Get the content field and toggle the show/hide
    var inside = $(header).next('.jem-field-inside');

    //$(inside).toggle(500);
   // $(inside).toggleClass("jem-hide");
   $(inside).slideToggle('slow');

}

/**
 * The delete icon on a selected field is clicked
 * @param e event
 * @param icon
 */
function deleteFieldIconClicked(e, icon) {

    //Stop the propagation
    e.stopPropagation();
    e.preventDefault();

    //Pop up a modal confirming we want to delete
    showConfirmModal(
        function () {
            deleteSelectedField(icon);
        },
        function () { /**do nothing **/
        }
    );

}

/**
 * Shows the confirm modal and returns true or false
 * depending on what the user pressed
 *
 * This is pretty slick - I made it so it is reusable amongst projects
 * Pass in 2 callbacks for yes and cancel
 */
function showConfirmModal(callbackYes, callbackCancel){

    //attach the handler
    var mc = $('#modalConfirm');

    $(mc).on('hide.bs.modal', function () {
        var activeElement = $(document.activeElement);

        //Cancel?
        if(activeElement.context.id == "modalCancel") {
            callbackCancel();
        } else {
            //must be a yes
            callbackYes();
        }

        //detach click handler
        $(mc).off('hide.bs.modal');
    });

    //Show it
    $(mc).modal();


}

/**
 * Deletes a selected field & renames fields
 * @param icon
 */
function deleteSelectedField(icon){

    //get the item to delete - the li element
    var li = $(icon).closest('li');

    //and delete it!
    $(li).remove();

    //And rename the fields
    renameSelectedFields();
}