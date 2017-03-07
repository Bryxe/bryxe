var changedSomethingInView = false;
$(function () {
    window.parent.hideProgressOverlay();
    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").attr("disabled", "disabled");

    $(".slideSection form input,.slideSection form textarea,.slideSection form select").on("change keypress", function () {
        $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
        changedSomethingInView = true;
    });
    $(".slideSection form input,.slideSection form textarea,.slideSection form select").keyup(function (e) {
        if (e.keyCode == 8 || e.keyCode == 46) {
            $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
            changedSomethingInView = true;
        }
    });

    $(window).bind('beforeunload', function () {
        if (changedSomethingInView) {
            return "There are unsaved changes in the current view, are you sure you want to leave this page?";
        }
    });

    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").on("click", function () {
        changedSomethingInView = false;
    })
});
