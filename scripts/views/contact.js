$(document).ready(function () {
    $("form").on("submit", null, function () {
        if ($("email").val() != $("emailconfirm").val()) {
            alert("Please make sure that the entered email addresses match");
            return false;
        }
        return true;
    });
});