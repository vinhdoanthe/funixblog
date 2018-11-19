<div class="credits">

    <div class="section-inner">

        <a href="#" class="to-the-top" title="<?php _e('To the top', 'rowling'); ?>">
            <div class="fa fw fa-angle-up"></div>
        </a>

        <!--<p class="copyright">&copy; <?php /*echo date('Y'); */ ?> <a href="<?php /*echo esc_url(home_url('/')); */ ?>"
                                                                title="<?php /*echo esc_attr(get_bloginfo('title')); */ ?> &mdash; <?php /*echo esc_attr(get_bloginfo('description')); */ ?>"
                                                                rel="home"><?php /*echo esc_attr(get_bloginfo('title')); */ ?></a>
        </p>

        <p class="attribution"><?php /*printf(__('Theme by %s', 'rowling'), '<a href="http://www.andersnoren.se">Anders Nor&eacute;n</a>'); */ ?></p>-->
        <div class="row">
            <div class="col-md-3"><?php dynamic_sidebar('footerbar1'); ?></div>
            <div class="col-md-6"><?php dynamic_sidebar('footerbar2'); ?></div>
            <div class="col-md-3"><?php dynamic_sidebar('footerbar3'); ?></div>
        </div>

    </div><!-- .section-inner -->

</div><!-- .credits -->

<?php wp_footer(); ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
  (function () {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/5771f0afdef120b32d63a5ca/default';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
  })();
</script>
<!--End of Tawk.to Script-->
<div class="block-call-me-later" style="position: fixed; bottom: 0;">
    <a href="#" class="callmelater fixed-bottom-left pum-trigger" style="cursor: pointer;"><img
                src="https://www.funix.edu.vn/wp-content/uploads/2018/06/call_me.gif" width="100em" alt="callme"
                pagespeed_url_hash="1891507450" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
    </a>
</div>
</body>
</html>