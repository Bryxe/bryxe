$(document).ready(function () {
    $('.counterLimit').maxlength({
        alwaysShow: true,
        threshold: 30,
        warningClass: "label label-info",
        limitReachedClass: "label label-danger",
        separator: ' of ',
        preText: 'You have entered ',
        postText: ' chars remaining.',
        placement: 'top-right',
        validate: true
    });
    $('.counterLimit').on("keypress", function () {
        if ($(this).val().length >= 199 && $(".increaseText").hasClass("firstTime")) {
            $(".increaseText").fadeIn();
            $(".increaseText").addClass("firstTime");
        }
        if ($(this).val().length < 190) {
            $(".increaseText").fadeOut();
        }
    });
    $('.counterLimit').on("change", function () {
        if ($(this).val().length < 190) {
            $(".increaseText").fadeOut();
        }
    });
});

function increaseTextAreaSpace() {
    if (confirm("You have entered 200 characters, want to increase the limit up to 1200 characters?")) {
        $(".increaseText").fadeOut();
        $(".increaseText").removeClass("firstTime")
        $('.counterLimit').attr("maxlength", 1200);
        $('.counterLimit').maxlength({});
        $('.counterLimit').maxlength({
            alwaysShow: true,
            threshold: 30,
            warningClass: "label label-info",
            limitReachedClass: "label label-danger",
            separator: ' of ',
            preText: 'You have entered ',
            postText: ' chars remaining.',
            placement: 'top-right',
            validate: true
        });
    }
}
function processPhoto(inputBox) {

    if (inputBox.files && inputBox.files[0]) {
        var freader = new FileReader();

        if (inputBox.files[0].type.indexOf("mage/") > 0) {
            freader.onload = function (e) {
                if ((inputBox.files[0].size / 1024) > 700) {
                    alert("The image size is " + Math.ceil(inputBox.files[0].size / 1024) + "KB and must be lower than 700KB, please choose a smaller one");
                    $(inputBox).val("");
                    $('#prevImage').hide();
                    $('.photoUploadIcon').show();
                    $(".uploadPhoto .btnTitle").html('upload photo');
                    $(".uploadPhoto .btnSubtitle").html('no photo selected');
                    return;
                }
                $('.photoUploadIcon').hide();
                $('#prevImage').attr('src', e.target.result).width(50);
                $('#prevImage').show();
                $(".uploadPhoto .btnTitle").html('change photo');
                $(".uploadPhoto .btnSubtitle").html('<span class="glyphicon glyphicon-ok"></span>&nbsp;photo selected');

            };
            freader.readAsDataURL(inputBox.files[0]);
        } else {
            alert("You must select an image file");
        }
    } else {
        $('#prevImage').hide();
        $('.photoUploadIcon').show();
        $(".uploadPhoto .btnTitle").html('upload photo');
        $(".uploadPhoto .btnSubtitle").html('no photo selected');
    }
}


function validateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
    }
    return (false)
}

function validateNewPost() {

    var text = $(".postText").val();
    var email = $(".postFriendEmail").val();

    var errors = "";

    if (text == "" || text.length < 1) {
        errors += "<li>Enter a reply at least 1 characters long</li>";
    }

    if (email != "" && !validateEmail(email)) {
        errors += "<li>Enter a valid friend's email address</li>";
    }

    if (text.length > 1200) {
        errors += "<li>Enter a text reply shorter than 200 characters</li>";
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
