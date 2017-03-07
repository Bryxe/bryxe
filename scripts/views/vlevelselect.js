function toggleSelection(clickedObj, levelNum) {
    $(".slideSection form button[type=submit],.slideSection form input[type=submit]").removeAttr("disabled");

    $(clickedObj).toggleClass("active");

    if ($(clickedObj).hasClass("active")) {
        //if it is selected and there is no input yet, then create it
        if (!$(".inputGroup .checkNum" + levelNum).length) {
            var hiddenElem = '<input type="hidden" class="checkGroup checkNum' + levelNum + '" name="level' + levelNum + '" value="' + levelNum + '">';
            $(".inputGroup").append(hiddenElem);
        }
    } else {
        //if it is NOT selected and there is an input then remove it
        if ($(".inputGroup .checkNum" + levelNum).length) {
            $(".inputGroup .checkNum" + levelNum).remove();
        }
    }
    return false;
}

