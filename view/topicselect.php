<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/topicselect.js" type="text/javascript"></script>


<div class="btn-group" style="width: 100%; margin-top:10px;">
    <button type="button" class="btn btn-info" style="width: 33.3%"
            onclick="window.location = '<?php echo BASE_URL; ?>topicselect'">Your topics
    </button>
    <button type="button" class="btn btn-default" style="width: 33.3%"
            onclick="window.location = '<?php echo BASE_URL; ?>topicsearch'">Find topics
    </button>
</div>
<div class="verticalSpacer" style="height: 10px"></div>


<section class="slideSection slideLevelSelect">
    <header>
        <div class="title">Choose a topic</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>
    <input type="hidden" value="<?php echo $_SESSION["topic"]; ?>" id="currentTopicId">
    <div class="list-group topicSelectListing">
    </div>

    <?php if (isset($_SESSION['grOwnerId']) && ($_SESSION['grOwnerId'] == $_SESSION['ownerId'])) { ?>
        Or add a new topic:
        <input type="text" id="newTopicName" class="form-control" placeholder="topic name" maxlength="30"
               style="width: 50%;max-width: 320px;">
        <div class="verticalSpacer" style="clear: both"></div>

        <button type="button" onclick="addNewTopic()" class="btn btn-primary pull-left"
                style="width: 40%;max-width: 120px;margin-left: 5px;">Add new
        </button>
    <?php } ?>
    <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatRight clearfix">
        Cancel
    </button>


    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>