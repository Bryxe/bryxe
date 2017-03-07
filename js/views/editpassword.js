$(document).ready(function () {
    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
});

function validateData() {
    var pass = $(".userNewPassword").val();
    var passconfirm = $(".userNewPasswordConfirm").val();

    var errors = "";
    if (pass.length < 1 || pass != passconfirm) {
        errors += "<li>New password and password confirm must match</li>";
    }

    if (errors != "") {
        errors = "<ul>" + errors + "</ul";
        $(".errorMessageBox .errorMessage").html(errors);
        $(".errorMessageBox").show();
        return false;
    } else {
        window.parent.showProgressOverlay();
        return true;
    }
}
