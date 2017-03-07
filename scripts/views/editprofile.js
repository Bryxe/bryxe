$(document).ready(function () {
    $('.counterLimit').maxlength({
        alwaysShow: true,
        threshold: 30,
        warningClass: "label label-info",
        limitReachedClass: "label label-danger",
        separator: ' of ',
        preText: 'You have ',
        postText: ' chars remaining.',
        placement: 'top-right',
        validate: true
    });

    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");
});

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

function validateData() {
    var profileText = $(".profileText").val();
    var profileUrl = $(".profileUrl").val();

    var errors = "";
    if (profileText.length > 170) {
        errors += "<li>Enter a profile text shorter than 170 characters</li>";
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
