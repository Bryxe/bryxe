String.prototype.capitalizeFirstLetter = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

$(function () {
    $(".groupItem").on("click", function () {
        window.parent.showProgressOverlay();
    });

    refreshTopics();

});

function refreshTopics() {
    $(".topicSelectListing").html("");
    var searchTopic = $("#searchTopic").val().trim();
    $.get("/api/topicsSearch/", {search: searchTopic}, function (data) {
        if (data.response.data.length == 0 || data.response.data.topics.length == 0) {
            alert("There are no topics available");
            return;
        }
        for (var i = 0; i < data.response.data.topics.length; i++) {
            var currentTopic = data.response.data.topics[i];
            var usernames = "";
            for (var u = 0; u < currentTopic.usernames.length; u++) {
                usernames += currentTopic.usernames[u] + ", ";
            }
            usernames = "(by <b>" + usernames.trim().replace(/,+$/, "") + "</b>)";
            var topicNode = '<a href="#" onclick="addNewTopic(\'' + currentTopic.topic.trim().capitalizeFirstLetter() + '\');return false;" class="list-group-item';
            topicNode += '" target="_self">' + currentTopic.topic.capitalizeFirstLetter() + " " + usernames + '</a>';
            $(".topicSelectListing").append(topicNode);
        }

    }, "json");
}
function addNewTopic(newTopic) {
    if (newTopic.length < 5) {
        alert("The topic name must be at least 5 character long");
        return;
    }
    if (newTopic.length > 30) {
        alert("The topic name must be at most 30 character long");
        return;
    }
    if (/^[0-9]+$/.test(newTopic)) {
        alert("The topic name cannot be a numerical value");
        return;
    }
    if (/^[0-9A-Za-z\s]+$/.test(newTopic) == false) {
        alert("The topic name must only contain alphanumerical characters");
        return;
    }
    if (!confirm("Do you want to add '" + newTopic + "' to your list?")) {
        return;
    }
    $.post("/api/addTopic/", {newtopic: newTopic}, function (data) {
        if (data.response.result == "ok") {
            alert("Topic added to your list!");
            window.location = "/topicselect";
        } else {
            alert("Error adding topic, please try again later");
        }
    }, "json");
}
