var lastScrollTop = 0;
$(function () {

    if ($(".topBarSectionTitle").text() != "") {
        $(".topSectionTitle").text($(".topBarSectionTitle").text());
    }

    $(window).scroll(function (event) {
        var viewportHeight = $(window).height();

        var scrollToTop = $(this).scrollTop();
        if (scrollToTop > lastScrollTop) {
            //scroll down
            if (scrollToTop > 30) {

                collapseMenuNavbar();
                /*
                 if (viewportHeight < 400) {
                 $(".userProfile").hide();
                 $(".addPost").hide();
                 $(".subNav").hide();
                 $(".mainNav").addClass("colapsedMenu");
                 } else {
                 $(".subNav").slideUp("fast");
                 }
                 */

            }


        } else {
            //scroll up

            if (scrollToTop < 150 && $(".mainNav").hasClass("colapsedMenu")) {
                expandMenuNavbar();
            }
            if (scrollToTop > 150 && !$(".mainNav").hasClass("colapsedMenu")) {
                collapseMenuNavbar();
            }
            /*
             if (viewportHeight >= 400 && !$(".mainNav").hasClass("colapsedMenu")) {
             $(".subNav").slideDown("fast");
             }
             */
        }
        lastScrollTop = scrollToTop;
    });

    $(".menu").on("click", function () {
        if ($(".mainNav").hasClass("colapsedMenu")) {
            expandMenuNavbar();
        } else {
            $(".menu .submenu").slideToggle("fast");
        }
    });


});

function collapseMenuNavbar() {
    $(".topTitle").hide();
    $(".addPost").hide();
    $(".subNav").hide();
    $(".mainNav").addClass("colapsedMenu");
    $(".header-container").css({width: "40px", overflow: "hidden"});
    if ($(".menu .submenu").is(':visible')) {
        $(".menu .submenu").slideUp("fast");
    }
}

function expandMenuNavbar() {
    $(".mainNav").removeClass("colapsedMenu");
    $(".topTitle").fadeIn("fast");
    $(".addPost").fadeIn("fast");
    $(".subNav").fadeIn("fast");
    $(".header-container").css({width: "100%", overflow: "visible"});
    if ($(".menu .submenu").is(':visible')) {
        $(".menu .submenu").slideUp("fast");
    }
}

$(function () {
    //drop a banner with the error and hide it on clic
    $(".operationMessages").click(function () {
        $(this).slideToggle("slow");
    });
});

function showContentOnSlide(contentUrl) {
    $('.mainSlidingPanelIframe').attr('src', contentUrl);
    $('.mainSlidingPanel').toggle('slide');
    $('.mainSlidingPanelOverlay').toggle('fade');
}
function hideContentSlide() {

    $('.mainSlidingPanel').toggle('slide');
    $('.mainSlidingPanelOverlay').toggle('fade');

}

function showProgressOverlay() {
    $('.progressBarOverlay').fadeIn('fast');
}
function hideProgressOverlay() {
    $('.progressBarOverlay').fadeOut('fast');
}



