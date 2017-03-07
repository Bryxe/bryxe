$(function () {
    $(".groupItem").on("click", function () {
        window.parent.showProgressOverlay();
    });

    //if there the group has 0 unread messages hide the number
    $(".slideLevelSelect .badgeRed").each(function () {
        var current = $(this).text().replace(" ", "").replace("new", "");

        if (parseInt(current) > 99) {
            $(this).text("+99 new");
        }
        if (current == "" || $(this).text() == "0 new") {
            $(this).hide();
        }
    });

});

function editGroup() {
    var name = $("#editGroupName").val().trim();
    if (name.length > 5 && name.length <= 30) {
        window.parent.location = "/showposts/editgroup/?name=" + name;
        return;
    }
    alert("The group name length must be within 5 and 30 characters long");
}

function addNewGroup() {
    var name = $("#newGroupName").val().trim();
    if (name.length > 5 && name.length <= 30) {
        window.parent.location = "/showposts/newgroup/?name=" + name;
        return;
    }
    alert("The group name length must be within 5 and 30 characters long");
}

function deleteGroup() {
    window.parent.location = "/showposts/deletegroup/";
}

