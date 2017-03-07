var swipeboxInstance;
function addSwipeBox() {
    swipeboxInstance = $(".swipebox:not(.hasSwipebox)").swipebox({
        hideBarsDelay: 0, // 0 to always show caption and action bar,
        afterOpen: function () {
            $("#swipebox-overlay").on("click", function () {
                swipeboxInstance.closeSlide();

            });
        }

    });
    $(".swipebox").addClass("hasSwipebox");

}

$(function () {
    addSwipeBox();
});

function scrollBox(element) {
    if ($(".mainNav").hasClass("colapsedMenu")) {
        $(element).ScrollTo({offsetTop: 95});
    } else {
        $(element).ScrollTo({offsetTop: 138});
    }
}

var startRows = 0;
var countRows = 10;

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 10) {
        //show load more box
    }
});

function loadMoreRows(next, baseUrl) {
    $('footer .loadMoreData').text("loading more...");
    $('footer .loadMoreData').css("text-animation", "blink");

    $.ajax({
        type: "POST",
        dataType: "html",
        url: baseUrl + "search_users",
        data: {searchUserSubmit: "1", action: "get", latest_offset: next, searchTxt: $("#searchTxt").val()},
        success: function (data) {
            startRows += countRows;
            $('footer .loadMoreData').css("text-animation", "none");
            $('.main-containerFooter .loadMoreData').text("Load more");
            if (data != '') {
                var totalPosts = 0;
                $('article.graybox', data).each(function () {

                    $('.main-containerFooter').before(this);
                    totalPosts++;
                });

                if (totalPosts == 0) {
                    $('.main-containerFooter .loadMoreData').hide();
                }
            }
            else {
                $('.main-containerFooter .loadMoreData').hide();
            }
        },
        complete: function () {
            $('footer .loadMoreData').css("text-animation", "none");
            $('.main-containerFooter .loadMoreData').text("Load more");
            addSwipeBox();
        }
    });
}
