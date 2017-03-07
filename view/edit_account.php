<script src="<?php echo JS_PATH; ?>/jstimezonedetect.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/slides_views_common.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH; ?>/views/editaccount.js" type="text/javascript"></script>

<?php
if ($_REQUEST['closeme']) {
    echo "<script>window.parent.hideContentSlide();</script>";
    return;
}
?>

<?php if (!$_SESSION["firstTimeSignup"]) { ?>
    <div class="btn-group" style="width: 100%">
        <button type="button" class="btn btn-info" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_account'">Account
        </button>
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_profile'">Profile
        </button>
        <button type="button" class="btn btn-default" style="width: 33.3%"
                onclick="window.location = '<?php echo BASE_URL; ?>edit_password'">Password
        </button>
    </div>
<?php } ?>
<div class="verticalSpacer" style="height: 10px"></div>

<section class="slideSection slideEditAccount">
    <header>
        <div class="title" style='color:gray;'>Set your account information</div>
    </header>
    <hr>
    <div class="alert alert-danger alert-dismissable errorMessageBox" onclick="$(this).hide()"
         style="display:  <?= ($edit_profile_message == '') ? 'none' : 'block'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span class="errorMessage">
            <?php
            if ($edit_profile_message != '') {
                echo $edit_profile_message;
            }
            ?>
        </span>
    </div>

    <form role="form" onsubmit="return validateData()" target="_self" name="editUserAccount" id="new_post" method="post"
          enctype="multipart/form-data" action="">

        <!-- Hidden Values -->
        <input type="hidden" name="editUserAccountSubmit" value="1">

        <input type="hidden" name="state" id="state" class="text_box" value="<?php echo($state); ?>">
        <input type="hidden" name="webPg" id="webPg" class="text_box" value="<?php echo($webPg); ?>">
        <input type="hidden" name="bioDesc" id="bioDesc" class="text_box" value="<?php echo($bioDesc); ?>">
        <input type="hidden" name="protect" id="protect" value="<?php echo $protect; ?>">
        <input type="hidden" name="nwUpswd" id="nwUpswd" value="">
        <!-- Hidden Values -->

        <input type="text" class="form-control userFullName" name="fullName" id="fullName" placeholder="your full name"
               value="<?php echo($fullName); ?>" readonly="readonly" required="required">
        <input type="text" class="form-control userName" name="uname" placeholder="a user name to identify you"
               value="<?php echo($username); ?>" readonly="readonly" required="required">
        <input type="text" class="form-control userEmail" name="email" id="email" placeholder="email to reach you"
               value="<?php echo($email); ?>">
        <input type="text" class="form-control userCity" name="city" id="city" placeholder="city"
               value="<?php echo($city); ?>">

        <select name="country" id="country" class="form-control userCountry">
            <option value="" selected="selected">Select Country</option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antarctica">Antarctica</option>
            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
            <option value="Argentina">Argentina</option>
            <option value="Armenia">Armenia</option>
            <option value="Aruba">Aruba</option>
            <option value="Australia">Australia</option>
            <option value="Austria">Austria</option>
            <option value="Azerbaijan">Azerbaijan</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Belarus">Belarus</option>
            <option value="Belgium">Belgium</option>
            <option value="Belize">Belize</option>
            <option value="Benin">Benin</option>
            <option value="Bermuda">Bermuda</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
            <option value="Botswana">Botswana</option>
            <option value="Bouvet Island">Bouvet Island</option>
            <option value="Brazil">Brazil</option>
            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
            <option value="Brunei Darussalam">Brunei Darussalam</option>
            <option value="Bulgaria">Bulgaria</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Burundi">Burundi</option>
            <option value="Cambodia">Cambodia</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Canada">Canada</option>
            <option value="Cape Verde">Cape Verde</option>
            <option value="Cayman Islands">Cayman Islands</option>
            <option value="Central African Republic">Central African Republic</option>
            <option value="Chad">Chad</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Christmas Island">Christmas Island</option>
            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
            <option value="Colombia">Colombia</option>
            <option value="Comoros">Comoros</option>
            <option value="Congo">Congo</option>
            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
            <option value="Cook Islands">Cook Islands</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Cote D'ivoire">Cote D'ivoire</option>
            <option value="Croatia">Croatia</option>
            <option value="Cuba">Cuba</option>
            <option value="Cyprus">Cyprus</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Denmark">Denmark</option>
            <option value="Djibouti">Djibouti</option>
            <option value="Dominica">Dominica</option>
            <option value="Dominican Republic">Dominican Republic</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Egypt">Egypt</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Equatorial Guinea">Equatorial Guinea</option>
            <option value="Eritrea">Eritrea</option>
            <option value="Estonia">Estonia</option>
            <option value="Ethiopia">Ethiopia</option>
            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
            <option value="Faroe Islands">Faroe Islands</option>
            <option value="Fiji">Fiji</option>
            <option value="Finland">Finland</option>
            <option value="France">France</option>
            <option value="French Guiana">French Guiana</option>
            <option value="French Polynesia">French Polynesia</option>
            <option value="French Southern Territories">French Southern Territories</option>
            <option value="Gabon">Gabon</option>
            <option value="Gambia">Gambia</option>
            <option value="Georgia">Georgia</option>
            <option value="Germany">Germany</option>
            <option value="Ghana">Ghana</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Greece">Greece</option>
            <option value="Greenland">Greenland</option>
            <option value="Grenada">Grenada</option>
            <option value="Guadeloupe">Guadeloupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guinea">Guinea</option>
            <option value="Guinea-bissau">Guinea-bissau</option>
            <option value="Guyana">Guyana</option>
            <option value="Haiti">Haiti</option>
            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungary">Hungary</option>
            <option value="Iceland">Iceland</option>
            <option value="India">India</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
            <option value="Iraq">Iraq</option>
            <option value="Ireland">Ireland</option>
            <option value="Israel">Israel</option>
            <option value="Italy">Italy</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japan">Japan</option>
            <option value="Jordan">Jordan</option>
            <option value="Kazakhstan">Kazakhstan</option>
            <option value="Kenya">Kenya</option>
            <option value="Kiribati">Kiribati</option>
            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
            <option value="Korea, Republic of">Korea, Republic of</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Kyrgyzstan">Kyrgyzstan</option>
            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
            <option value="Latvia">Latvia</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Lesotho">Lesotho</option>
            <option value="Liberia">Liberia</option>
            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lithuania">Lithuania</option>
            <option value="Luxembourg">Luxembourg</option>
            <option value="Macao">Macao</option>
            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of
            </option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malawi">Malawi</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Maldives">Maldives</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marshall Islands">Marshall Islands</option>
            <option value="Martinique">Martinique</option>
            <option value="Mauritania">Mauritania</option>
            <option value="Mauritius">Mauritius</option>
            <option value="Mayotte">Mayotte</option>
            <option value="Mexico">Mexico</option>
            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
            <option value="Moldova, Republic of">Moldova, Republic of</option>
            <option value="Monaco">Monaco</option>
            <option value="Mongolia">Mongolia</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Morocco">Morocco</option>
            <option value="Mozambique">Mozambique</option>
            <option value="Myanmar">Myanmar</option>
            <option value="Namibia">Namibia</option>
            <option value="Nauru">Nauru</option>
            <option value="Nepal">Nepal</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Netherlands Antilles">Netherlands Antilles</option>
            <option value="New Caledonia">New Caledonia</option>
            <option value="New Zealand">New Zealand</option>
            <option value="Nicaragua">Nicaragua</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Niue">Niue</option>
            <option value="Norfolk Island">Norfolk Island</option>
            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
            <option value="Norway">Norway</option>
            <option value="Oman">Oman</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Palau">Palau</option>
            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
            <option value="Panama">Panama</option>
            <option value="Papua New Guinea">Papua New Guinea</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Philippines">Philippines</option>
            <option value="Pitcairn">Pitcairn</option>
            <option value="Poland">Poland</option>
            <option value="Portugal">Portugal</option>
            <option value="Puerto Rico">Puerto Rico</option>
            <option value="Qatar">Qatar</option>
            <option value="Reunion">Reunion</option>
            <option value="Romania">Romania</option>
            <option value="Russian Federation">Russian Federation</option>
            <option value="Rwanda">Rwanda</option>
            <option value="Saint Helena">Saint Helena</option>
            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
            <option value="Saint Lucia">Saint Lucia</option>
            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
            <option value="Samoa">Samoa</option>
            <option value="San Marino">San Marino</option>
            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Senegal">Senegal</option>
            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Sierra Leone">Sierra Leone</option>
            <option value="Singapore">Singapore</option>
            <option value="Slovakia">Slovakia</option>
            <option value="Slovenia">Slovenia</option>
            <option value="Solomon Islands">Solomon Islands</option>
            <option value="Somalia">Somalia</option>
            <option value="South Africa">South Africa</option>
            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands
            </option>
            <option value="Spain">Spain</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Sudan">Sudan</option>
            <option value="Suriname">Suriname</option>
            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
            <option value="Swaziland">Swaziland</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
            <option value="Tajikistan">Tajikistan</option>
            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
            <option value="Thailand">Thailand</option>
            <option value="Timor-leste">Timor-leste</option>
            <option value="Togo">Togo</option>
            <option value="Tokelau">Tokelau</option>
            <option value="Tonga">Tonga</option>
            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
            <option value="Tunisia">Tunisia</option>
            <option value="Turkey">Turkey</option>
            <option value="Turkmenistan">Turkmenistan</option>
            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
            <option value="Tuvalu">Tuvalu</option>
            <option value="Uganda">Uganda</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="United States">United States</option>
            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Vanuatu">Vanuatu</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Viet Nam">Viet Nam</option>
            <option value="Virgin Islands, British">Virgin Islands, British</option>
            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
            <option value="Wallis and Futuna">Wallis and Futuna</option>
            <option value="Western Sahara">Western Sahara</option>
            <option value="Yemen">Yemen</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
        </select>

        <select name="timeZone" id="timeZone" class="form-control userTimezone">
            <option value="">Select your Time-Zone</option>
            <option value="-12" data-utc='-12' <?php if ($_SESSION['tz'] == -12) { ?> selected="selected" <?php } ?>>
                (GMT -12:00) Eniwetok, Kwajalein
            </option>
            <option value="-11" data-utc='-11' <?php if ($_SESSION['tz'] == -11) { ?> selected="selected" <?php } ?>>
                (GMT -11:00) Midway Island, Samoa
            </option>
            <option value="-10" data-utc='-10' <?php if ($_SESSION['tz'] == -10) { ?> selected="selected" <?php } ?>>
                (GMT -10:00) Hawaii
            </option>
            <option value="-9" data-utc='-9' <?php if ($_SESSION['tz'] == -9) { ?> selected="selected" <?php } ?>>(GMT
                -9:00) Alaska
            </option>
            <option value="-8" data-utc='-8' <?php if ($_SESSION['tz'] == -8) { ?> selected="selected" <?php } ?>>(GMT
                -8:00) Pacific Time (US &amp; Canada)
            </option>
            <option value="-7" data-utc='-7' <?php if ($_SESSION['tz'] == -7) { ?> selected="selected" <?php } ?>>(GMT
                -7:00) Mountain Time (US &amp; Canada)
            </option>
            <option value="-6" data-utc='-6' <?php if ($_SESSION['tz'] == -6) { ?> selected="selected" <?php } ?>>(GMT
                -6:00) Central Time (US &amp; Canada), Mexico City
            </option>
            <option value="-5" data-utc='-5' <?php if ($_SESSION['tz'] == -5) { ?> selected="selected" <?php } ?>>(GMT
                -5:00) Eastern Time (US &amp; Canada), Bogota, Lima
            </option>
            <option value="-4" data-utc='-4' <?php if ($_SESSION['tz'] == -4) { ?> selected="selected" <?php } ?>>(GMT
                -4:00) Atlantic Time (Canada), Caracas, La Paz
            </option>
            <!--
            <option value="-3.5" data-utc='-3.5' <?php if ($_SESSION['tz'] == -3.5) { ?> selected="selected" <?php } ?>>(GMT -3:30) Newfoundland</option>
            -->
            <option value="-3" data-utc='-3' <?php if ($_SESSION['tz'] == -3) { ?> selected="selected" <?php } ?>>(GMT
                -3:00) Brazil, Buenos Aires, Georgetown
            </option>
            <option value="-2" data-utc='-2' <?php if ($_SESSION['tz'] == -2) { ?> selected="selected" <?php } ?>>(GMT
                -2:00) Mid-Atlantic
            </option>
            <option value="-1" data-utc='-1' <?php if ($_SESSION['tz'] == -1) { ?> selected="selected" <?php } ?>>(GMT
                -1:00 hour) Azores, Cape Verde Islands
            </option>
            <option value="0" data-utc='0' <?php if ($_SESSION['tz'] == 0) { ?> selected="selected" <?php } ?>>(GMT)
                Western Europe Time, London, Lisbon, Casablanca
            </option>
            <option value="1" data-utc='1' <?php if ($_SESSION['tz'] == 1) { ?> selected="selected" <?php } ?>>(GMT
                +1:00 hour) Brussels, Copenhagen, Madrid, Paris
            </option>
            <option value="2" data-utc='2' <?php if ($_SESSION['tz'] == 2) { ?> selected="selected" <?php } ?>>(GMT
                +2:00) Kaliningrad, South Africa
            </option>
            <option value="3" data-utc='3' <?php if ($_SESSION['tz'] == 3) { ?> selected="selected" <?php } ?>>(GMT
                +3:00) Baghdad, Riyadh, Moscow, St. Petersburg
            </option>
            <!--
            <option value="3.5" data-utc='3.5' <?php if ($_SESSION['tz'] == 3.5) { ?> selected="selected" <?php } ?>>(GMT +3:30) Tehran</option>
            -->
            <option value="4" data-utc='4' <?php if ($_SESSION['tz'] == 4) { ?> selected="selected" <?php } ?>>(GMT
                +4:00) Abu Dhabi, Muscat, Baku, Tbilisi
            </option>
            <!--
            <option value="4.5" data-utc='4.5' <?php if ($_SESSION['tz'] == 4.5) { ?> selected="selected" <?php } ?>>(GMT +4:30) Kabul</option>
            -->
            <option value="5" data-utc='5' <?php if ($_SESSION['tz'] == 5) { ?> selected="selected" <?php } ?>>(GMT
                +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent
            </option>
            <!--
            <option value="24" data-utc='5.5' <?php if ($_SESSION['tz'] == 5.5) { ?> selected="selected" <?php } ?>>(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
            <option value="25" data-utc='5.27' <?php if ($_SESSION['tz'] == 5.27) { ?> selected="selected" <?php } ?>>(GMT +5:45) Kathmandu</option>
            -->
            <option value="6" data-utc='6' <?php if ($_SESSION['tz'] == 6) { ?> selected="selected" <?php } ?>>(GMT
                +6:00) Almaty, Dhaka, Colombo
            </option>
            <option value="7" data-utc='7' <?php if ($_SESSION['tz'] == 7) { ?> selected="selected" <?php } ?>>(GMT
                +7:00) Bangkok, Hanoi, Jakarta
            </option>
            <option value="8" data-utc='8' <?php if ($_SESSION['tz'] == 8) { ?> selected="selected" <?php } ?>>(GMT
                +8:00) Beijing, Perth, Singapore, Hong Kong
            </option>
            <option value="9" data-utc='9' <?php if ($_SESSION['tz'] == 9) { ?> selected="selected" <?php } ?>>(GMT
                +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk
            </option>
            <!--
            <option value="9.5" data-utc='9.5' <?php if ($_SESSION['tz'] == 9.5) { ?> selected="selected" <?php } ?>>(GMT +9:30) Adelaide, Darwin</option>
            -->
            <option value="10" data-utc='10' <?php if ($_SESSION['tz'] == 10) { ?> selected="selected" <?php } ?>>(GMT
                +10:00) Eastern Australia, Guam, Vladivostok
            </option>
            <option value="11" data-utc='11' <?php if ($_SESSION['tz'] == 11) { ?> selected="selected" <?php } ?>>(GMT
                +11:00) Magadan, Solomon Islands, New Caledonia
            </option>
            <option value="12" data-utc='12' <?php if ($_SESSION['tz'] == 12) { ?> selected="selected" <?php } ?>>(GMT
                +12:00) Auckland, Wellington, Fiji, Kamchatka
            </option>
        </select>

        <div class="verticalSpacer" style="height: 16px"></div>


        <button type="button" onclick="window.location = '<?php echo BASE_URL . "edit_account?closeme=1"; ?>'"
                class="btn btn-primary floatLeft clearfix">Cancel
        </button>
        <?php if ($_SESSION["firstTimeSignup"]) { ?>
            <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Next</strong>
            </button>
        <?php } else {
            ?>
            <button type="submit" name="submit" class="btn btn-primary floatRight clearfix"><strong>Done</strong>
            </button>
            <?php
        }
        ?>
        <script type="text/javascript">
            $(function () {
                $("#country").val("<?php echo($country); ?>");
            });
        </script>
    </form>
    <footer>
        <div class="verticalSpacer"></div>
    </footer>
</section>