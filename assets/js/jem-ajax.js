jQuery(document).on('click', '.upload_a_file', function (e) {
    /****uploading a file using ajaxx*****/
    if(jQuery('.upf').val()!='')
    {
    var file_input = jQuery(this).parent().find('input[type="hidden"]');
    var file_data = jQuery('.upf').prop('files')[0];
    var this_parent = jQuery(this).parent();
    var form_data = new FormData();

    form_data.append('file', file_data);
    form_data.append('action', 'jem_upload_file');

    jQuery.ajax({
        url: jem.ajaxurl,
        type: 'post',
        contentType: false,
        processData: false,
        data: form_data,
        success: function (response) {
            //jQuery('.Success-div').html("Form Submit Successfully")
            if(response.success)
            {
              //  var name = file_input.attr('name');
              //  this_parent.html('<input type="text" name="'+name+'" class="jem-input-field " value="'+response.url+'">');
              file_input.val(response.url);
              this_parent.addClass('valid');
            }
        },  
        error: function (response) {
         //console.log('error');
         //show error if there was an error uploading file
         alert('There was an uploading your file. Please try again later.');
        }

    });
    }
    return false;
});
jQuery(document).ready(function($){
    $('.jem-date').datepicker();                //convert text field to datepicker field
});