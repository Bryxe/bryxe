$(function () {
    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
});


function validateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
    }
    return (false)
}

function validateNewPost() {

    var email = $(".postFriendEmail").val();

    var errors = "";

    if (email != "" && !validateEmail(email)) {
        errors += "<li>Enter a valid friend's email address</li>";
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
