<?php

defined('_JEXEC') or die;

$googleId = ''; // set your site's ID, something as UA-XXXXX-X
$yandexId = ''; // set your counter's ID from Yandex.Metrika

?>


<?php if ($googleId) : ?>
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','<?php echo $googleId; ?>','auto');ga('send','pageview');
    </script>
<?php endif; ?>


<?php if ($yandexId) : ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter<?php echo $yandexId; ?> = new Ya.Metrika({
                    id                  : <?php echo $yandexId; ?>,
                    webvisor            : true,
                    clickmap            : true,
                    trackLinks          : true,
                    accurateTrackBounce : true,
                    trackHash           : true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div>
        <img src="//mc.yandex.ru/watch/<?php echo $yandexId; ?>" style="position:absolute; left:-9999px;" alt="" />
    </div></noscript>
    <!-- /Yandex.Metrika counter -->
<?php endif; ?>
