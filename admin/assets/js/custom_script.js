jQuery(document).ready(function($){
    $(window).bind("load",function(){
        $('.change_admin').each(function(){
            var url = $(this).attr('href');
            $(this).replaceWith('<a href="'+url+'">'+url+'</a>');
        });
    });
});