$(document).ready(function() {
    $('.panel').on('show.bs.collapse', function () {
        $(this).find('.panel-heading').parent('.panel').addClass('open');
    });
    
    $('.panel').on('hide.bs.collapse', function () {
        $(this).find('.panel-heading').parent('.panel').removeClass('open');
    });
});