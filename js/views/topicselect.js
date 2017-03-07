var WebsiteBase = '';

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
    var currentTopicId = $("#currentTopicId").val();
    $.get(WebsiteBase + "/api/getTopics/", null, function (data) {
        console.log(data);
        // var mainTopicNode = '<a href="'+WebsiteBase+'/showposts?topic=0" class="list-group-item';
        // if (currentTopicId == "" || currentTopicId == undefined || currentTopicId == null || currentTopicId == 0) {
        //     mainTopicNode += " active ";
        // }
        // mainTopicNode += '" target="_parent"> General </a>';
        // $(".topicSelectListing").append(mainTopicNode);
        // console.log(data.response.data);
        for (var i = 0; i < data.response.data.topics.length; i++) {
            var currentTopic = data.response.data.topics[i];
            var topicNode = '<a href="' + WebsiteBase + '/showposts?topic=' + currentTopic.topic_id + '" class="list-group-item';
            if (currentTopic.topic_id == currentTopicId) {
                topicNode += " active ";
            }
            var unreadTopics = '';
            if (parseInt(currentTopic.newposts) > 0) {
                unreadTopics = '<span class="badge badgeRed pull-right">' + currentTopic.newposts + ' unread</span> ';
            }
            var totalTopics = '<span class="badge pull-right">' + currentTopic.oldposts + ' total</span> ';
            topicNode += '" target="_parent">' + currentTopic.topic.capitalizeFirstLetter() + totalTopics + unreadTopics + '</a>';
            $(".topicSelectListing").append(topicNode);
        }
    }, "json");
}
function addNewTopic() {
    var newTopic = $("#newTopicName").val().trim().capitalizeFirstLetter();
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
    $.post(WebsiteBase + "/api/addTopic/", {newtopic: newTopic}, function (data) {
        if (data.response.result == "ok") {
            refreshTopics();
            alert("Topic added!");
            $("#newTopicName").val("");
        } else {
            alert("Error adding topic, please try again later");
        }
    }, "json");
}
