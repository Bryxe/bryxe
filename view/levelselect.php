<?php
$groups = get_level($username, $password);
$currentUid = $groups["current_user_id"];
$_SESSION['ownerId'] = $currentUid;
$totalGroups = $groups["count"];
unset($groups["current_user_id"]);
unset($groups["count"]);
unset($groups["result_code"]);
?>

<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/levelselect.js" type="text/javascript"></script>

<section class="slideSection slideLevelSelect">
    <header>
        <div class="title">Choose a new group</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage"></span>
    </div>
    <div class="list-group">
        <?php
        $alreadyActive = false;
        $currentGroupName = "";
        foreach ($groups as $gp) {
            ?>
            <a href="<?php echo BASE_URL; ?>showposts/add/<?php echo $gp["level"]; ?>/<?php echo $gp['owner_id']; ?>"
               class="list-group-item <?= ($_SESSION['level'] == $gp["level"] && $_SESSION['grOwnerId'] == $gp["owner_id"]) ? 'active' : ''; ?>"
               target="_parent">

                <?php echo $gp["level_name"] . " - " . $gp["owner_name"]; ?>
                <span <?php if ($_SESSION['level_post_count'][$gp['owner_id']][$gp["level"]]["levelNw"] == 0) echo 'style="display:none;"'; else echo ""; ?>
                        class="badge badgeRed pull-right">unread topics</span> <span
                        class="badge pull-right"><?php echo isset($_SESSION['level_post_count'][$gp['owner_id']][$gp["level"]]["levelGral"]) ? $_SESSION['level_post_count'][$gp['owner_id']][$gp["level"]]["levelGral"] . " posts" : "0 posts"; ?></span>
            </a>
            <?php
            if (($_SESSION['level'] == $gp["level"] && $currentUid == $gp["owner_id"])) {
                $alreadyActive = true;
            }
        }
        ?>
    </div>

    <?php if ($_SESSION['level'] != 0 && isset($_SESSION['grOwnerId']) && ($_SESSION['grOwnerId'] == $_SESSION['ownerId'])) { ?>
        Delete selected group<br>
        <button type="button" onclick="if(confirm('Confirm group deletion?'))deleteGroup()"
                class="btn btn-primary pull-left" style="width: 40%;max-width: 120px;margin-left: 5px;margin-top: 5px;">
            Delete
        </button>
        <div class="verticalSpacer" style="clear: both"></div>

        Edit current group name:
        <input type="text" id="editGroupName" class="form-control" placeholder="group name" maxlength="30" minlength="5"
               value="<?php echo $_SESSION['level_name']; ?>" style="width: 50%;max-width: 320px;">
        <button type="button" onclick="editGroup()" class="btn btn-primary pull-left"
                style="width: 40%;max-width: 120px;margin-left: 5px;margin-top: 5px;">Edit name
        </button>

        <div class="verticalSpacer" style="clear: both"></div>
        <?php
    }
    ?>
    Add a new group:
    <input type="text" id="newGroupName" class="form-control" placeholder="group name" maxlength="30" minlength="5"
           style="width: 50%;max-width: 320px;">
    <div class="verticalSpacer" style="clear: both"></div>

    <button type="button" onclick="addNewGroup()" class="btn btn-primary pull-left"
            style="width: 40%;max-width: 120px;margin-left: 5px;">Add group
    </button>
    <div></div>

    <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatRight clearfix">
        Cancel
    </button>

    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>