$(document).ready(function () {
    var offset = "" + (((new Date()).getTimezoneOffset() / 60) * (-1)) + "";
    if ($("#timeZone").val() == "") {
        $("#timeZone option").each(function () {
            if ($(this).data("utc") == offset) {
                $("#timeZone").val($(this).val());
                $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
            }
        });
    }

    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
});

function validateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
    }
    return (false)
}

function validateData() {
    var fullname = $(".userFullName").val();
    var username = $(".userName").val();
    var email = $(".userEmail").val();

    var errors = "";
    if (fullname.length < 1) {
        errors += "<li>Enter your full name</li>";
    }

    if (username == "" || username.length < 3) {
        errors += "<li>Enter a username to identify you in the system</li>";
    }

    if (email != "" && !validateEmail(email)) {
        errors += "<li>Enter a valid email address</li>";
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
