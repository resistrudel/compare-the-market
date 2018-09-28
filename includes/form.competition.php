<?php
$error_output = isset($error['general']) ? '<p class="error">' . $error['general'] . '</p>' : '';
?>
	<div id="form-container" class="form-container">

		<input type="hidden" id="formID" name="formID" value="<?= $formID ?>"/>
		<input type="hidden" id="brandID" name="brandID" value="<?= $brand ?>"/>
		<input type="hidden" name="<?= $security->getPhpLabel() ?>" value="<?= $security->getPhpToken(); ?>"/>

		<div class="question" id="question">
			<div class="wrapper question-wrapper">
				<fieldset id="competitionQuestion" class="competition-question column">

                    <div class="goldFrame">
                            <div class="login-container" id="login-container">
                                <div class="social-connect-container">
                                    <div class="wrapper">
                                        <div class="text-box">
                                            <h2>Login to enter the competition</h2>
                                        </div>
                                    </div>
                                    <div id="derrick-social-auth-component">
                                    </div>
                                </div>

                                <p class="cta"><button type="button" id="back" href="#quiz">Back</button></p>
                                <div id="user-details" class="user-details details column">
                                    <div class="wrapper">
                                        <h3 class="title">Please complete the following details to enter the competition:</h3>
                                        <fieldset id="competitionDetails" class="competition-details">
                                            <div class="register-container">
                                                <?php
                                                echo $form->printField('gender', 'div', 'clearfix');
                                                echo $form->printField('firstName', 'div', 'clearfix');
                                                echo $form->printField('surname', 'div', 'clearfix');
                                                echo $form->printField('email', 'div', 'clearfix');
                                                echo $form->printField('dateOfBirth', 'div', 'clearfix');
                                                echo $form->printField('postCode', 'div', 'clearfix');
                                                echo $form->printField('phone', 'div', 'clearfix');
                                                ?>

                                                <noscript>
                                                    <?php if (!isset($userCaptcha)) {
                                                        echoCaptcha();
                                                    } ?>
                                                </noscript>
                                                <?php
                                                if (isset($userCaptcha)) {
                                                    echoCaptcha();
                                                }
                                                // Un-comment the following line to print out the captcha code as plain text.
                                                // echo $security->spillTheBeans();
                                                ?>
                                            </div>
                                        </fieldset>
                                        <fieldset id="competitionOptIns" class="competition-optins column">
                                            <?php
                                            echo $form->printField('clientOptIn', 'p', '', 'If you would like to find out more <a href="' . $client['link'] . '">' . $client['name'] . '</a> , please tick here');
                                            echo $form->printField('stationOptIn', 'p', '', 'Yes! I want to be the first to hear about news, special promotions and offers from <a href="' . $brands[$brand]['brandURL'] . '" target="_blank">' . $brands[$brand]['name'] . '</a>.');
                                            echo $form->printField('termsOptIn', 'p', '', 'I have read and agreed to the <a href="' . $text['competition']['terms'] . '" target="_blank">Terms and Conditions</a> and <a href="' . $brands[$brand]['privacy'] . '" target="_blank">Privacy Policy</a>.');
                                            ?>

                                            <p class="smallprint"><?=$text['competition']['small-print-submit'] ?></p>

                                            <p class="cta clear">
                                                <button type="submit" name="enter">Submit<span></span></button>
                                            </p>
                                            <small><span class="req">*</span> required field</small>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                    </div>
				</fieldset>
			</div>
		</div>



	</div>
<?php // End of file: form.competition.php