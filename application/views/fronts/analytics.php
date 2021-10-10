<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $identitas->analytics?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo $identitas->analytics?>');
    </script>
    <meta name="google-site-verification" content="<?php echo $identitas->seo?>" />

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '<?php echo $identitas->pixel?>');
    fbq('track', 'PageView');
    fbq('track', 'Search');
    fbq('track', 'ViewContent');
    </script>
    <noscript>
     <img height="1" width="1"
    src="https://www.facebook.com/tr?id=<?php echo $identitas->pixel?>&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
