
$(document).ready(function () {
    openLoading();
});

$(window).load(function () {
    closeLoading();
});

function openLoading() {
    html = '<div class="se-pre-con"><i class="fa fa-refresh fa-spin"></i></div>';
    $("body").append(html);
}

function closeLoading() {
    $(".se-pre-con").fadeOut("slow");
}
