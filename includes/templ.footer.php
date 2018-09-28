<footer role="contentinfo">
        <p><a href="http://www.Global.com/" target="_blank">Global</a> &copy; <?= date("Y") ?>PETER RABBIT™ &amp; © FW&amp;Co. PETER RABBIT™ Movie © 2018 CPII. All Rights Reserved.</p>
</footer>
</div><!-- end of #frame -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>if (!window.jQuery) {document.write('<script src="scripts/lib/jquery.min.js"><\/script>');}</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php if (isset($security)) {
    echo '<script type="text/javascript">var t_="', $security->getPhpLabel(), '", j_="', $security->getJsLabel(), '";</script>';
} ?>
<script type="text/javascript" src="scripts/scrolloverflow.min.js"></script>
<script type="text/javascript" src="scripts/jquery.fullPage.js"></script>
<script type="text/javascript" src="scripts/js.min.js"></script>

<script>
    $(document).ready(function() {
        var anchors = ['intro', 'movies', 'quiz'];
        var viewport = $(window);
        var windowsize = viewport.width();
        console.log(windowsize);
        if (windowsize > 1000) {

            $('#fullpage').fullpage({
                anchors: anchors,
                scrollOverflow: true,
                navigation: true,
                navigationPosition: 'right',
                scrollBar: false,
                onLeave: function(index, newIndex, direction){
                    $('.' + anchors[index - 1]).removeClass('animation');
                    $('.' + anchors[newIndex - 1]).addClass('animation');

                    if (newIndex == 1){
                        $('header').addClass('animation');
                    } else {
                        $('header').removeClass('animation');
                    }
                    //$('body.fp-viewing-' + anchors[newIndex - 1]).addClass('animation');
                    //$('body.fp-viewing-' + anchors[index - 1]).removeClass('animation');
                }

            });
        }

        if(location.hash) {
            var section = location.hash.replace('#','.');
            $(section).addClass('animation');
            console.log(location.hash);
            if (location.hash == '#intro') {
                $('header').addClass('animation');
            }
        } else {
            $('.intro').addClass('animation');
            $('header').addClass('animation');
        }


        //triggering the overlay
        $('.trigger').on('click', function(e){
            e.preventDefault();
            $('.overlay').addClass('show');
        });

        //closing the overlay
        $('.close').on('click', function(e){
            e.preventDefault();
            $('.overlay').removeClass('show');
        })

        //activating/ de-activating the next button
        $('input[name=answer]').on('click', function(){
            $('#next').removeAttr('disabled');
            $('#next').addClass('active');
        });


        var linkpulseSent = false;

        //destroy full page plugin, hide everything but the form
        $('#next').on('click', function(){
            //$('.competition .text-box').fadeOut("slow", function() {
            //    $('#login-container').css('display', 'block');
            //    $('.questionAndAnswer').css('display', 'none');
            //});

            var newUrl = window.location.origin + window.location.pathname + '#competition';

            if(!linkpulseSent) {
                console.log('New URL: ' + newUrl);

                LP4.logClick({ fromUrl: location.href,  Position:'lp_scroll',  toUrl: newUrl});
                LP4.is.logInScreenData();
            }



            $('#fullpage').hide();
            $('#competition').show();
            if (windowsize > 1000) {
                $.fn.fullpage.destroy("all");
                location.hash = '#competition';
            }

            if(!linkpulseSent) {
                LP4.setUrl(newUrl);
                // LP4.setPageAtr('section','sport | culture | entertaining | etc.');
                LP4.setPageAtr('type','article');

                LP4.logPageview({  url: newUrl,  title: 'Enter competition',  type: 'article'  });

                LP4.is.reInit();

                linkpulseSent = true;
            }

        });

        //back button: rebuild full page plugin, hide the competition, show everything but scroll to quiz
        $('#back').on('click', function(e){
            e.preventDefault();

            $('#fullpage').show();
            $('#competition').hide();
            if (windowsize > 1000) {
                $('#fullpage').fullpage({
                    anchors: anchors,
                    scrollOverflow: true,
                    navigation: true,
                    navigationPosition: 'right',
                    scrollBar: false,
                    onLeave: function(index, newIndex, direction){
                        $('.' + anchors[index - 1]).removeClass('animation');
                        $('.' + anchors[newIndex - 1]).addClass('animation');

                        if (newIndex == 1){
                            $('header').addClass('animation');
                        } else {
                            $('header').removeClass('animation');
                        }
                        //$('body.fp-viewing-' + anchors[newIndex - 1]).addClass('animation');
                        //$('body.fp-viewing-' + anchors[index - 1]).removeClass('animation');
                    }

                });
                setTimeout(function () {
                    location.hash = '#quiz';
                }, 0)
            } else {
                scrollToLink('#quiz');
            }
        })
    });

</script>


<script src="//cdn<?= isHttps() ? 's' : '' ?>.gigya.com/js/gigya.js?apiKey=<?= $derrick_API_key ?>"></script>
<script src="/_shared/scripts/derrick.social.v3.js"></script>


<script>
    var env = '<?= $derrick_env ?>';
    var brandUrl;
    var brandId = '<?= $brand ?>';

    switch (env) {
        case 'local':
            brandUrl = 'http://local.thisisglobal.com:8000/';
            break;

        case 'development':
        case 'usertesting':
        case 'training':
        case 'staging':
            brandUrl = 'http://www.<?= $brand ?>.' + env + '.int.thisisglobal.com/';
            break;

        case 'live':
            brandUrl = '<?= $brands[$brand]['brandURL'] ?>';
            derrickURL = '<?= isHttps() ? $brands[$brand]['derrickSecureURL'] : $brands[$brand]['derrickURL'] ?>';
            break;

        default:
            throw new Error('Unknown Environment.');
    }

    /**
     * Function for making the social connect login tabs clickable, called when the stepname is
     *  'UnAuthorised'.
     *  TODO: This should be moved into the core functionality.
     */
    function initialiseConnectTabs() {
        var $connectSelector = $('#connect-selector');
        if ($connectSelector.length) {
            $('#login.connect-section').hide().find('.form__sep').hide();
            $connectSelector.on('click', '.tab a', function (e) {
                e.preventDefault();
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
                target = $(this).attr('href');
                $('.connect-section').not(target).hide();
                $(target).fadeIn(600);
            }).data('initialised', true);
        }
    }

    /**
     * `onAuthenticationChange` callback triggered when the user is logged in or logged out.
     *
     * @param profile object on authenticated or null on un-authenticated.
     */
    function onAuthenticationChange(profile, stepName) {
        if (profile && stepName === 'Authenticated') {
            console.log('Authenticated as: ' + profile.first_name);
            competitionForm.authenticated(profile);
        } else {
            console.log('Not authenticated');
            competitionForm.notAuthenticated();
        }
    }

    /**
     * `onStepChange` callback gets triggered when the user navigates through the component.
     *
     * @param stepName string
     *
     * Possible stepName values:
     *
     * - "Loading"
     * - "UnAuthenticated"
     * - "AlreadyRegistered"
     * - "Authenticated"
     * - "SocialEmailCollect"
     * - "SocialProfileCollect"
     * - "UnhandledException"
     *
     * Example Use Case: useful to hook off of for analytics purposes.
     */
    function onStepChange(stepName) {
        console.log('Changed step: ' + stepName);
        if (stepName === 'UnAuthenticated') {
            competitionForm.notAuthenticated();
            initialiseConnectTabs();
        }
    }

    var options = {
        onAuthenticationChange: onAuthenticationChange,
        onStepChange: onStepChange
    };

    var $competition_form = $('#competition-form');
    if ($competition_form.length) {
        if (typeof derrick === 'object') {
            derrick.SocialAuthComponent(brandId, derrickURL, options);
        }
        window.initForm($competition_form);
    }

</script>

<script type="text/javascript" src="//pp.lp4.io/app/57/96/55/579655e7e45a1d5628d2406a.js" async></script>

<?php include('inc.analytics.php'); ?>
<?php if (isset($kruxCategories)) { include('inc.krux.php');} ?>
<img src="//pixel.quantserve.com/pixel/p-w2ENAMmynuucv.gif?labels=_campaign.branded.Win%20Pages.<?= $client['name'] ?>.<?= $text['metaDescription'] ?>" border="0" height="1" width="1" alt=""/>


<?php
 $pixel_ids = array(
     'lbc' => '503469',
     'capital' => '503462',
     'xtra' => '503455',
     'smooth' => '503420',
     'heart' => '503434',
     'gold' => '503448',
     'radiox' => '503427',
     'classic' => '503441',
 );
?>

<img src="//gb-gmtdmp.mookie1.com/t/v2/activity?tagid=V2_<?=$pixel_ids[$brand]?>&src.rand=<?=time()?>&" style="display:none;"/>

</body>
</html>