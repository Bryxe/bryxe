<!-- change this to the desired label for the top menu -->
<div class="topBarSectionTitle" style="display: none;">
    Contact
</div>
<!-- end top menu title -->


<!-- Put your section contents inside this "article" tag -->
<article class="graybox clearfix increasedMargin">

    <?php if (!empty($contactResults)) {
        $msgClass = "alert-info";
        if ($validationErrors) {
            $msgClass = "alert-danger";
        }

        ?>
        <div class="contactBoxInfoWarnsAndAlerts alert <?php echo $msgClass; ?> alert-dismissable" style="margin: 10px;"
             onclick="$(this).fadeOut();">
            <span class="message">
                <?php echo $contactResults; ?>
            </span>
        </div>
        <?php
    }
    ?>

    <p class="defaultTextStyle">
        <strong>Please fill in all the fields to send us a message</strong>
    </p>

    <section class="defaultTextStyle">


        <form class="contactForm" role="form" action="contact" method="POST">
            <div style="height: 10px;"></div>
            <select class="form-control" required="required" name="reason">
                <option value="">Why are you contacting us?</option>
                <option value="contact">General enquiry</option>
                <option value="contact">Challenge</option>
                <option value="support">Support request</option>
                <option value="press">Press</option>
                <option value="other">Other</option>
            </select>
            <div style="height: 20px;"></div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"></span>
                </span>
                <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" required="required"
                       title="Please enter your name" placeholder="Please enter your name">
            </div>
            <div style="height: 20px;"></div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-envelope"></span>
                </span>
                <input id="email" type="email" name="email" <?php echo $email; ?> title="Please enter your email"
                       required="required" class="form-control" placeholder="Please enter your email">
            </div>
            <div style="height: 20px;"></div>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-envelope"></span>
                </span>
                <input id="emailconfirm" type="email" name="emailconfirm" <?php echo $emailConf; ?>
                       title="Please confirm your email" required="required" class="form-control"
                       placeholder="Please confirm your email">
            </div>

            <div style="height: 20px;"></div>
            <div class="form-group">
                <textarea rows="6" name="message" class="form-control" <?php echo $message; ?>required="required"
                          title="Please enter your message" placeholder="Please enter your message"></textarea>
            </div>

            <img style="border:1px solid grey;" id="captcha" src="<?php echo BASE_URL; ?>securimage/securimage_show.php"
                 alt="CAPTCHA Image"/>
            <input title="enter code" placeholder="enter code" type="text" name="captcha_code" size="10" maxlength="6"
                   required="required"/>
            <a href="#"
               onclick="document.getElementById('captcha').src = '<?php echo BASE_URL; ?>securimage/securimage_show.php?' + Math.random();
                       return false"> refresh</a>

            <div style="height: 10px;"></div>
            <button id="submitButton" type="submit" class="btn btn-info btn-lg pull-right" style="">Send message
            </button>

            <div class="clearfix"></div>

        </form>

    </section>

    <script src="<?php echo JS_PATH; ?>/views/contact.js" type="text/javascript"></script>

</article>
