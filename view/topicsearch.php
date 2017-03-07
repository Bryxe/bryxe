<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/topicsearch.js" type="text/javascript"></script>


<div class="btn-group" style="width: 100%;margin-top:10px;">
    <button type="button" class="btn btn-default" style="width: 33.3%"
            onclick="window.location = '<?php echo BASE_URL; ?>topicselect'">Your topics
    </button>
    <button type="button" class="btn btn-info" style="width: 33.3%"
            onclick="window.location = '<?php echo BASE_URL; ?>topicsearch'">Find topics
    </button>
</div>
<div class="verticalSpacer" style="height: 10px"></div>


<section class="slideSection slideLevelSelect">
    <header>
        <div class="title">Topic Search</div>
        <input type="text" id="searchTopic" class="form-control pull-left" placeholder="search by topic name"
               maxlength="30" style="width: 50%;max-width: 320px;">
        <button type="button" onclick="refreshTopics()" class="btn btn-primary pull-left"
                style="width: 40%;max-width: 120px;margin-left: 5px;">Search
        </button>
        <div class="clearfix"></div>
        <div style="height: 5px"></div>
    </header>
    <hr>
    <span style="font-size: 14px;">Topics of people you are viewing<br/><span
                style="opacity: 0.7">(select one to join)</span></span>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>
    <div class="list-group topicSelectListing" style="max-height: 210px;overflow-y: scroll;">
    </div>
    <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatRight clearfix">
        Cancel
    </button>

    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>