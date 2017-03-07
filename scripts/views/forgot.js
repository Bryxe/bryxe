function validateData() {
    var uname = $(".userName").val();

    var errors = "";
    if (uname.length < 1 || uname.length > 42) {
        errors += "<li>Enter a valid Username to recover your password</li>";
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
