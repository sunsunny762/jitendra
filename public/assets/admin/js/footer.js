$(document).on('blur', '[data-validator]', function () {
    new Validator($(this));
})

$(".nav-btn").click(function () {
    $("#main").toggleClass("main-space");
    $("footer").toggleClass("main-space");
});

$(".navbar-nav > li.nav-item .active").focus();
/* End :: Nevgation Menu slide functionality*/

$("form").on('submit', function () {

    $(this).find('[data-validator]').each(function () {
        new Validator($(this));
    });
    if ($('.has-error').length == 0) {
        // submit more than once return false
        $(this).submit(function () {
            return false;
        });
        $(".loader").show();
    } else {
        return false;
    }
});
$("form").find(':input:enabled:visible:first').focus();

$(document).ajaxStart(function () {
    $(".loader").fadeIn("slow");
});

$(document).ajaxStop(function () {
    $(".loader").fadeOut("slow");
});