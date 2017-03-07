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