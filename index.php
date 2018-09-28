<?php
require_once('includes/common.constants.php');
include('includes/form.validator.php');
include('includes/templ.header.php');

// Specify the form encoding type if it needs to handle file uploads.
$form_multipart = isset($text['competition']['fileUpload']) && $text['competition']['fileUpload'] ? 'enctype="multipart/form-data" ' : '';

// Determine the competition status based on the timestamp and the 'submitted' session value.
$competition_status =
    ($timestamp >= strtotime($text['competition']['ends']) ? 1 : //ended
        ($timestamp < strtotime($text['competition']['starts']) ? 2 : //coming
            (isset($_SESSION[$campaign][$formID]['submitted']) && $_SESSION[$campaign][$formID]['submitted'] == 1 ? 3 : 4))); // submitted || on

?>

<?php if ($competition_status === 4) { ?>
    <form role="form" action="<?= $siteDetails['baseURL'] ?>#competition" id="competition-form" method="post" class="clearfix"
    <?= $form_multipart ?>  novalidate="novalidate">
<?php } ?>

<div id="fullpage">
    <section class="section intro">
        <div class="wrapper">
            <div class="text-box">
                <h1><?= $text['intro']['title'] ?></h1>
                <?= formatText($text['intro']['text']) ?>
                <?= formatText($text['intro']['link-text'], 'cta', array('href'=>'#quiz')) ?>
            </div>
        </div>
    </section>

    <section class="section movies">
        <div class="wrapper">
            <div class="text-box">
                <h2><?= $text['movies']['title'] ?></h2>
                <?= formatText($text['movies']['text2']) ?>
                <h3>&nbsp;
<!--                    --><?//= $text['movies']['title2'] ?>
                </h3>
                <?= formatText($text['movies']['link-text'], 'cta', array('href'=>$text['movies']['link-url'])) ?>
                <p class="customers"><?= $text['movies']['text'] ?></p>
            </div>
        </div>
    </section>

    <?php if (isset($text['video'])) { ?>
    <section id="video" class="video">
        <div class="wrapper">
            <div class="text-box">
                <h3><?= $text['video']['title'] ?></h3>

                <div class="copy">
                    <?= formatText($text['video']['text']) ?>
                </div>
                <p class="iframe">
                    <iframe src="<?= $text['video']['link'] ?>?api=1" frameborder="0"
                            webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </p>
            </div>
        </div>
    </section>
<?php } ?>

    <?php
    $error_output = isset($error['general']) ? '<p class="error">' . $error['general'] . '</p>' : '';
    ?>
    <section class="section quiz">
        <div class="text-box">
            <h2><?= $text['competition']['title'] ?></h2>
            <?= formatText($text['competition']['text']) ?>
            <?php if (isset($text['overlay']['prize-details']) && !empty($text['overlay']['prize-details'])) { ?>
                <p class="trigger"><button type="button"><?= $text['overlay']['prize-details'] ?></button></p>
            <?php } ?>
        </div>
        <div class="overlay">
            <p class="close"><button type="button"></button></p>
            <?= formatText($text['overlay']['text']) ?>
            <p><a target="_blank" href="<?= $text['competition']['terms'] ?>">Terms and Conditions ></a></p>
        </div>
        <div class="goldFrame">
            <div class="questionAndAnswer">
                <?php
                echo $error_output;
                if (isset($text['competition']['answers']) && is_array($text['competition']['answers'])) { ?>
                    <div class="question-container">
                        <p id="answer">Q: <?= $text['competition']['question'] ?></p>
                    </div>
                    <div class="answers-container">
                        <ul>
                            <?php
                            foreach ($text['competition']['answers'] as $idx => $val) {
                                echo $form->answerElement($idx, $val);
                            } ?>
                        </ul>
                    </div>
                <?php
                } else {
                    if (!isset($text['competition']['question'])) {
                        goto end2;
                    }
                    ?>
                    <p class="full">
                        <label for="answer">Q: <?= $text['competition']['question'] ?></label>
                    </p>
                    <p>
                        <textarea id="answer" name="answer"><?= $form->getValue('answer') ?></textarea>
                    </p>
                    <?php
                    if (!isset($text['competition']['answerLimit'])) { ?>
                        <p>Set the <b>answerLimit</b> variable in the content file.</p>
                        <?php
                        goto end2;
                    }
                    if (!isset($text['competition']['answerLimitType'])) { ?>
                        <p>Set the <b>answerLimitType</b> variable in the content file.</p>
                        <?php
                        goto end2;
                    }
                    ?>
                    <p class="answer-length" id="answerLength" data-target="answer"
                       data-type="<?= $text['competition']['answerLimitType'] ?>">Please limit your answer
                        to <span><?= $text['competition']['answerLimit'] ?></span>
                        <?= $text['competition']['answerLimitType'] ?> or less</p>
                <?php }
                end2: ?>
                <p class="cta"><button type="button" disabled="disabled" id="next" >Next</button></p>
            </div>
        </div>
        <p class="small-print"><?=$text['competition']['small-print-question'] ?></p>
    </section>

</div>
    <section class="section competition fp-auto-height" id="competition">
        <?php if ($competition_status === 4) { ?>
            <?php } ?>
            <div id="form-wrapper" class="form-wrapper <?= $competition_status === 3 ? 'thank-you' : '' ?>">
                <?php
                if ($competition_status === 1) { ?>
                    <div class="wrapper">
                        <div class="column">
                            <p>Sorry! The competition is over already... For more chances to win, check out the <a
                                    href="<?= $brands[$brand]['brandURL'] ?>"><?= $brands[$brand]['name'] ?> website</a>
                        </div>
                    </div>
                    <?php
                    goto exitForm;
                } else if ($competition_status === 2) { ?>
                    <div class="wrapper">
                        <div class="column">
                            <p>Hold your horses! Competition starts
                                at <?= date('G:i \o\n jS F Y', strtotime($text['competition']['starts'])) ?></p>
                        </div>
                    </div>
                    <?php
                    goto exitForm;
                }
                if ($competition_status === 3) {
                    include('includes/templ.success.php');
                } else {
                    include('includes/form.competition.php');
                }
                exitForm:
                ?>
            </div>
            <?php if ($competition_status === 4) { ?>
    <?php } ?>
    </section>


<?php if ($competition_status === 4) { ?>
    </form>
<?php } ?>
<?php

end:
include('includes/templ.footer.php');