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

    $(".postContent").each(function () {
        var hasOverflow = false;
        if ($('.postedTextBody', this)[0] != undefined) {
            hasOverflow = $('.postedTextBody', this).innerWidth() < $('.postedTextBody', this)[0].scrollWidth;
        }
        if (!hasOverflow) {
            $('.postedTextReadMore', this).hide();
        }
    })
});

var startRows = 0;
var countRows = 10;

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 10) {
        //show load more box
    }
});

function loadMoreRows(baseUrl) {
    $('footer .loadMoreData').text("loading more posts...");
    $('footer .loadMoreData').css("text-animation", "blink");
    console.log(startRows);
    console.log(countRows);
    $.ajax({
        type: "POST",
        dataType: "html",
        url: baseUrl + "showposts",
        data: {action: "get", latest_offset: startRows},
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

                if (totalPosts == 0 || $('article.graybox:first', data).data("start") == "0") {
                    $('.main-containerFooter .loadMoreData').hide();
                }
            } else {
                $('.main-containerFooter .loadMoreData').hide();
            }
        },
        complete: function () {
            $('footer .loadMoreData').css("text-animation", "none");
            $('.main-containerFooter .loadMoreData').text("Load more");
            addSwipeBox();
            $(".postContent").each(function () {
                var hasOverflow = false;
                if ($('.postedTextBody', this)[0] != undefined) {
                    hasOverflow = $('.postedTextBody', this).innerWidth() < $('.postedTextBody', this)[0].scrollWidth;
                }
                if (!hasOverflow) {
                    $('.postedTextReadMore', this).hide();
                }
            })
        }
    });
}

