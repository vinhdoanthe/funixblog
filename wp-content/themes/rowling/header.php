<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager -->
<noscript>
    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-5L7DL2"
            height="0" width="0" style="display:none;visibility:hidden">
    </iframe>
</noscript>
<script>(function (w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
      'gtm.start':
        new Date().getTime(), event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
      '//www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-5L7DL2');</script>
<!-- End Google Tag Manager -->

<?php if (has_nav_menu('secondary') || has_nav_menu('social')) : ?>

    <div class="top-nav">

        <div class="section-inner">

            <ul class="secondary-menu">

                <?php
                if (has_nav_menu('secondary')) {
                    wp_nav_menu(array(
                        'container'      => '',
                        'items_wrap'     => '%3$s',
                        'theme_location' => 'secondary'
                    ));
                }
                ?>

            </ul><!-- .secondary-menu -->

            <ul class="social-menu">

                <?php
                if (has_nav_menu('social')) {
                    wp_nav_menu(array(
                        'theme_location'  => 'social',
                        'container'       => '',
                        'container_class' => 'menu-social',
                        'items_wrap'      => '%3$s',
                        'menu_id'         => 'menu-social-items',
                        'menu_class'      => 'menu-items',
                        'depth'           => 1,
                        'link_before'     => '<span class="screen-reader-text">',
                        'link_after'      => '</span>',
                        'fallback_cb'     => '',
                    ));
                    echo '<li id="menu-item-151" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-151"><a class="search-toggle" href="#"><span class="screen-reader-text">Search</span></a></li>';
                }
                ?>

            </ul><!-- .social-menu -->

            <div class="clear"></div>

        </div><!-- .section-inner -->

    </div><!-- .top-nav -->

<?php endif; ?>

<div class="search-container">

    <div class="section-inner">

        <?php get_search_form(); ?>

    </div><!-- .section-inner -->

</div><!-- .search-container -->

<div class="header-wrapper">

    <div class="header">
        <div class="navigation hidden-850">
            <div class="logo hidden-850">
                <a href="/" class="custom-logo-link" rel="home" itemprop="url">
                    <img width="177" height="108"
                         src="<?php echo get_theme_file_uri('imgs/Webp.net-resizeimage.png') ?>" class="custom-logo"
                         alt="FUNiX Online University" itemprop="logo">
                </a>
            </div>
            <div class="section-inner" style="border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
                <ul class="primary-menu">
                    <?php if (has_nav_menu('primary')) {

                        $nav_args = array(
                            'container'      => '',
                            'items_wrap'     => '%3$s',
                            'theme_location' => 'primary'
                        );

                        wp_nav_menu($nav_args);

                    } else {

                        $list_pages_args = array(
                            'container' => '',
                            'title_li'  => ''
                        );

                        wp_list_pages($list_pages_args);

                    } ?>

                </ul>
                <div class="hidden-850">
                    <?php dynamic_sidebar('topbar'); ?>
                </div>

                <div class="clear"></div>
            </div>
            <div class="section-inner hidden-850">
                <ul class="primary-menu primary-menu-bottom">

                    <?php if (has_nav_menu('primary_bottom')) {

                        $nav_args_bottom = array(
                            'container'      => '',
                            'items_wrap'     => '%3$s',
                            'theme_location' => 'primary_bottom'
                        );

                        wp_nav_menu($nav_args_bottom);

                    } else {

                        $list_pages_args_bottom = array(
                            'container' => '',
                            'title_li'  => ''
                        );

                        wp_list_pages($list_pages_args_bottom);

                    } ?>

                </ul>
                <div class="funix-search-box">
                    <form class="funix-search-form" method="get" role="search" action="https://www.funix.edu.vn/">
                        <input name="search_paths[]" type="hidden" value="">
                        <input type="text" value="" name="s" id="s">
                        <input tabindex="-1" type="submit" name="submit" value="Submit Search">
                    </form>
                </div>
                <div class="slogan">
                    FUNiX WAY: Học khi bạn hứng thú – Hỏi khi bạn gặp khó khăn – Giao lưu khi buồn nản
                </div>
                <div class="clear"></div>

            </div>

        </div><!-- .navigation -->

        <div class="section-inner">
            <div class="nav-toggle">
                <div class="bars">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div><!-- .nav-toggle -->
            <div class="nav-toggle-title">Đại học trực tuyến Funix</div>
            <div class="nav-btn-register">Đăng ký</div>
        </div>
        <!-- .section-inner
        </div><!-- .header -->


        <ul class="mobile-menu">

            <?php
            if (has_nav_menu('primary')) {
                $nav_args['walker'] = new Nghiennet89_Menu_Walker();
                wp_nav_menu($nav_args);
            } else {
                wp_list_pages($list_pages_args);
            }
            ?>

        </ul><!-- .mobile-menu -->

    </div><!-- .header-wrapper -->