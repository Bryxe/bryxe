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
<script src="<?php echo JS_PATH; ?>/views/vlevelselect.js" type="text/javascript"></script>

<section class="slideSection slideLevelSelect">
    <header>
        <div class="title">Choose a new group</div>
    </header>
    <hr>

    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()"
         style="display:  <?= ($create_message == '') ? 'none' : 'block'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage">
            <?php
            if ($create_message != '') {
                echo $create_message;
            }
            ?>
        </span>
    </div>
    <form name="v_lev" action="<?php echo BASE_URL . "v_levelselect/" . trim($viewerid) . "/" . trim($vrUname); ?>"
          method="POST" target="_self">

        <input type="hidden" name="changeLevel" value="1">

        <div class="list-group groupSelects">
            <?php
            $count = 1;
            foreach ($groups as $gp) {
                if ($gp["level"] == 0 || $count > 10) {
                    continue;
                }
                ?>
                <a href="#" onclick="toggleSelection(this, <?php echo $count; ?>);"
                   class="list-group-item <?= ($ge_level[$count]) ? 'active' : ''; ?>"
                   target="_self"><?php echo $gp["level_name"]; ?></a>
                <?php
                $count++;
            }
            ?>

            <div class="inputGroup">
                <?php if ($ge_level['0']) { ?><input type="hidden" class="checkGroup checkNum0" name="level0"
                                                     value="0"><?php } ?>
                <?php if ($ge_level['1']) { ?><input type="hidden" class="checkGroup checkNum1" name="level1"
                                                     value="1"><?php } ?>
                <?php if ($ge_level['2']) { ?><input type="hidden" class="checkGroup checkNum2" name="level2"
                                                     value="2"><?php } ?>
                <?php if ($ge_level['3']) { ?><input type="hidden" class="checkGroup checkNum3" name="level3"
                                                     value="3"><?php } ?>
                <?php if ($ge_level['4']) { ?><input type="hidden" class="checkGroup checkNum4" name="level4"
                                                     value="4"><?php } ?>
                <?php if ($ge_level['5']) { ?><input type="hidden" class="checkGroup checkNum5" name="level5"
                                                     value="5"><?php } ?>
                <?php if ($ge_level['6']) { ?><input type="hidden" class="checkGroup checkNum6" name="level6"
                                                     value="6"><?php } ?>
                <?php if ($ge_level['7']) { ?><input type="hidden" class="checkGroup checkNum7" name="level7"
                                                     value="7"><?php } ?>
                <?php if ($ge_level['8']) { ?><input type="hidden" class="checkGroup checkNum8" name="level8"
                                                     value="8"><?php } ?>
                <?php if ($ge_level['9']) { ?><input type="hidden" class="checkGroup checkNum9" name="level9"
                                                     value="9"><?php } ?>
            </div>

        </div>

        <button type="button" onclick="window.parent.hideContentSlide()" class="btn btn-primary floatLeft clearfix">
            Close
        </button>
        <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Save</strong></button>
    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>