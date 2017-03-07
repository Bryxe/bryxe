<body class="indexBody">

<?php if ($login_message != '') { ?>
    <span class="operationMessages"><?php echo $login_message; ?></span>
    <script type="text/javascript">

        $(function() {
            $("#loginContainer").show();
            $(".bodyContentOverlay").show();
            setTimeout(function() {
                $(".operationMessages").slideUp();
            }, 4000);
        });

    </script>
<?php } ?>
<?php if ($reg_message != '') { ?>
    <span class="operationMessages"><?php echo $reg_message; ?></span>
    <script type="text/javascript">

        $(function() {
            $("#registerContainer").show();
            $(".bodyContentOverlay").show();
            setTimeout(function() {
                $(".operationMessages").slideUp();
            }, 4000);
        });

    </script>
<?php } ?>

<!-- dialog to display custom messages -->
<div class="msgDialogBox">
    <iframe class="msgBoxIframe" src="<?php echo BASE_URL; ?>forgot"></iframe>
</div>

<script type="text/javascript">
    $(function () {
        $(".msgDialogBox").dialog({
            title: "Recover Password",
            autoOpen: false,
            modal: true,
            resizable: false,
            autoResize: true,
            minWidth: 200,
            maxWidth: 500,
            width: 'auto',
            height: 'auto'
        });

    });
</script>
<!-- END -->

<img src="<?php echo IMAGES_PATH . "/BryxeLogo.png"; ?>" id="logoLogin">
<div id="upperLinks">
<a class="logonBtn">Login</a>
</div>

<div class="wrapperBodyContents">
    <div class="bodyContents">
        <div class="bodyContentOverlay" style="display: none;"></div>

        <div class="toggleLoginBox" style="display: none;">
            <img class="backHomeBtn" src="<?php echo IMAGES_PATH . "/template/back_to_home_btn.png"; ?>" width="177"
                 alt="Back to home" style="display: none;">
        </div>

        <div id="slider" class="welcomeImage slider" style="display: none;">
            <div class="slides">
                <div class="slide current" style="background-image: url(<?php echo IMAGES_PATH . "/bg_login.jpg"; ?>)"></div>
                <div class="slide" style="background-image: url(<?php echo IMAGES_PATH . "/bg_login.jpg"; ?>)"></div>
                <div class="slide" style="background-image: url(<?php echo IMAGES_PATH . "/bg_login.jpg"; ?>)"></div>
            </div>
        </div>

        <div id="registerButton">Join for free</div>

        <!-- Login -->
        <div id="loginContainer">
        <div class="loginForm">
            <div class="internal">
                <div class="formContents">
                    <span class="closeButton">X</span>
                    
                    <form name="login" method="post" enctype="multipart/form-data" action="">

                        <input type="hidden" name="loginSubmit" value="1">
                        
                        <label>Username</label>
                        <input required class="formInput" type="text" placeholder="Username" name="uname" id="uname"
                               value="<?php echo $_COOKIE['remember_me']; ?>">
                        
                        <label>Password</label>
                        <input required class="formInput" type="password" placeholder="Password"
                               name="userPwd" id="userPwd" value="<?php echo $_COOKIE['Key_my_site']; ?>">                        
                        
                        <span class="formLink" onclick="$('.msgDialogBox').dialog('open');">Forgot Password?</span>
                        <input class="formInput" type="checkbox" name="rem" id="rem" value="1" <?php
                        if (isset($_COOKIE['remember_me'])) {
                            echo 'checked="checked"';
                        }
                        ?> />
                        <label class="formCheckboxLabel" for="rem">Remeber Me</label>
                        
                        <input class="formSubmit"
                               onClick="this.form.submit(); this.value='Logging in…'; this.className = 'formSubmit submiting'; this.disabled=true; "
                               type="submit" name="submit" value="Login">

                        <span class="lastLine">Don't have an account? <a id="join">Join for free</a></span>
                    </form>
                </div>
            </div>
        </div> 
        </div>          
    
        <!-- Register -->
        <div id="registrationContainer">
        <div class="registrationForm">
            <div class="internal">
                <div class="formContents">
                    <span class="closeButton">X</span>

                    <form autocomplete="off" enctype="multipart/form-data" method="post" action="" onSubmit="return validate(this);" name="form">

                        <input required class="formInput" type="text" name="fullName" placeholder="Full name" id="fullName">
                        <span class="errors" id="fullNameError"></span>

                        <input required class="formInput" type="text" name="email" placeholder="Email" id="email">
                        <span class="errors" id="emailError"></span>

                        <input required class="formInput" type="text" name="uname" placeholder="Username" id="uname">
                        <span class="errors" id="userNameError"></span>

                        <input required class="formInput" type="password" name="userPwd" placeholder="Password" id="userPwd" value="">
                        <span class="errors" id="userPwdError"></span>

                        <input required class="formInput" type="password" name="cuserPwd"
                               placeholder="Confirm Password" id="cuserPwd" value="">
                        <input class="formInput" type="checkbox" name="acceptTerms" id="acceptTerms" value="1"/>
                        <label class="formCheckboxLabel" style="color: gray;" for="acceptTerms">I've read and accept the
                            <a href="<?php echo BASE_URL; ?>terms"
                               style="color:#357ebd;text-decoration: none;">Terms</a> & <a
                                    href="<?php echo BASE_URL; ?>privacy" style="color:#357ebd;text-decoration: none;">Privacy</a>
                            conditions</label>


                        <input type="hidden" name="regSubmit" value="1">
                        <input type="hidden" name="city" value="">
                        <input type="hidden" name="state" value="">
                        <input type="hidden" name="webPg" value="">
                        <input type="hidden" name="bioDesc" value="">
                        <input type="hidden" name="timeZone" value="">

                        <input class="formSubmit" type="submit" name="submit"
                               value="Sign Up">

                        <span class="lastLine">Already have an account? <a id="login">Login</a></span>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo JS_PATH; ?>/validation.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>/views/index.js"></script>

'</body>