$(function () {

    $("input").on("focus", function(){
        $(this).removeClass('error');
        var error = "#" + this.id + "Error";
        $(error).html("");
    });

    $("#registerButton").click(function(){
        $("#registrationContainer").fadeIn();
        $(".bodyContentOverlay").fadeIn();
    });

    $(".logonBtn").click(function(){
        $("#loginContainer").fadeIn();
        $(".bodyContentOverlay").fadeIn();
    });

    $(".closeButton").click(function(){
        $("#registrationContainer").fadeOut();
        $("#loginContainer").fadeOut();
        $(".bodyContentOverlay").fadeOut();
    });

    $("#join").click(function(){
        $("#loginContainer").fadeOut(430, function(){
            $("#registrationContainer").fadeIn();
        });
    });

    $("#login").click(function(){
        $("#registrationContainer").fadeOut(430, function(){
            $("#loginContainer").fadeIn();
        });
    });

    setInterval(function () {
        $('.slides .slide.current').fadeOut("slow", function () {
            $(this).removeClass("current")
        });
        if ($('.slides .slide.current').next().length != 0) {
            $('.slides .slide.current').next().fadeIn("normal", function () {
                $(this).addClass("current")
            });
        } else {//its the latest one
            $('.slides .slide').first().fadeIn("normal", function () {
                $(this).addClass("current")
            });
        }

    }, 8000);

});

function hideProgressOverlay() {
}

//old indian code used in sign up form validation
var ck_name = /^[A-Za-z0-9 ]{4,20}$/;
var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
var ck_username = /^[A-Za-z0-9_]{4,20}$/;
var ck_password = /^[A-Za-z0-9!@#$%^&*()_]{8,18}$/;

function validate(form) {
    var name = form.fullName.value;
    var email = form.email.value;
    var username = form.uname.value;
    var password = form.userPwd.value;
    var conpass = form.cuserPwd.value;


    var errors = [];

    if (!ck_name.test(name)) {
        errors[errors.length] = "Enter a name at least 4 characters long.";
        $("#fullNameError").html("Enter a name at least 4 characters long.");
        $("#fullName").addClass("error");
    }

    if (!ck_email.test(email)) {
        errors[errors.length] = "You must enter a valid email address.";
        $("#emailError").html("You must enter a valid email address.");
        $("#email").addClass("error");
    }
    if (!ck_username.test(username)) {
        errors[errors.length] = "Enter a username without special characters and at least 4 characters long.";
    }

    if (!ck_password.test(password)) {
        errors[errors.length] = "You must enter a valid Password at least 8 characters long.";
        $("#userPwdError").html("You must enter a valid Password at least 8 characters long.");
        $("#userPwd").addClass("error");
    }

    if (!ck_password.test(conpass)) {
        errors[errors.length] = "You must enter a valid Confirm Password at least 8 characters long";
    }
    if (password != conpass) {
        errors[errors.length] = "Your password and pass confirm must match";
    }

    if (!$("#acceptTerms").is(":checked")) {
        errors[errors.length] = "You must read and accept the terms and conditions and our privacy policy to register";
    }


    if (errors.length > 0) {
        return false;
    }

    return true;
}

function reportErrors(errors) {
    var msg = "Please enter valid data...\n";
    for (var i = 0; i < errors.length; i++) {
        var numError = i + 1;
        msg += "\n" + numError + ". " + errors[i];
    }
    alert(msg);
}
