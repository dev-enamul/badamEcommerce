<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- title -->
    <title><?php echo $meta['meta_title']; ?></title>

    <!-- meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="description" content="<?php echo $meta['meta_description']; ?>" />
    <meta name="keywords" content="<?php echo e($meta['meta_keywords']); ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="<?php echo $meta['meta_title']; ?>">
    <meta name="twitter:description" content="<?php echo $meta['meta_description']; ?>">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="<?php echo e($meta['meta_image']); ?>">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo $meta['meta_title']; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e(url()->full()); ?>" />
    <meta property="og:image" content="<?php echo e($meta['meta_image']); ?>" />
    <meta property="og:description" content="<?php echo $meta['meta_description']; ?>" />
    <meta property="og:site_name" content="<?php echo e(env('APP_NAME')); ?>" />
    <meta property="fb:app_id" content="<?php echo e(env('FACEBOOK_PIXEL_ID')); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(mix('web-assets/css/app.css')); ?>" rel="stylesheet">
    <!-- Scripts -->
    <script src="<?php echo e(mix('web-assets/js/app.js')); ?>" defer></script>

    <style>
        body,
        .v-application {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            font-size: 14px;
        }
        .header-sticky{
            z-index: 8;
        }
        :root {
            --primary: <?php echo e(get_setting('base_color', '#e62d04')); ?>;
            --soft-primary: <?php echo e(hex2rgba(get_setting('base_color', '#e62d04'), 0.15)); ?>;
        }

    </style>

    <?php echo $__env->make('frontend.inc.pwa', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        window.shopSetting = <?php echo json_encode($settings, 15, 512) ?>;
    </script>

    <?php if(get_setting('google_analytics') == 1): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(env('TRACKING_ID')); ?>"></script>

        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo e(env('TRACKING_ID')); ?>');
        </script>
    <?php endif; ?>

    <?php if(get_setting('facebook_pixel') == 1): ?>
        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo e(env('FACEBOOK_PIXEL_ID')); ?>');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=<?php echo e(env('FACEBOOK_PIXEL_ID')); ?>&ev=PageView&noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    <?php endif; ?>

    <?php echo get_setting('web_custom_css'); ?>

    <?php echo get_setting('header_script'); ?>

</head>

<body>
    <noscript>To run this application, JavaScript is required to be enabled.</noscript>
    <div id="app">
        <theShop></theShop>
    </div>

    <?php if(get_setting('facebook_chat') == 1): ?>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v3.3'
                });
            };

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div id="fb-root"></div>
        <!-- Your customer chat code -->
        <div class="fb-customerchat" attribution=setup_tool page_id="<?php echo e(env('FACEBOOK_PAGE_ID')); ?>">
        </div>
    <?php endif; ?>

    <?php echo get_setting('footer_script'); ?>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script> -->
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1271811446764498');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1271811446764498&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


</html>
<?php /**PATH /home/badamico/public_html/resources/views/frontend/app.blade.php ENDPATH**/ ?>