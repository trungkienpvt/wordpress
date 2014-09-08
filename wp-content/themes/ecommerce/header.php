<!DOCTYPE html>
<!--[if IE 8]><html lang="en" class="no-js ie ie8"><![endif]-->
<!--[if IE 9]><html lang="en" class="no-js ie ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title><?php wp_title('|') ?> </title>
    <meta name="viewport" content="width=device-width" />
    <link rel="shortcut icon" href="<?php echo THEMEURL; ?>/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo THEMEURL; ?>/css/style.css">
    <script src="<?php echo THEMEURL; ?>/js/ta123.js"></script>
    <script src="<?php echo THEMEURL; ?>/js/modernizr.js"></script>
    <?php wp_head() ?>
</head>
<body>
    <div id="container">
        <header id="header" class="<?php echo (is_front_page()?"header-homepage":"")?>">
            <div class="inner">
                <?php get_search_form(); ?>
              <div class="site-title"><a href="<?php echo get_home_url()?>" >
                <img src="<?php echo THEMEURL;?>/images/logo-1.png" alt="<?php bloginfo( 'name' ) ?>"/>
                </a></div>
                <nav class="navbar">
                    <a target="_blank" class="logo" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" href="http://www.vinacapital.com">
                        <img alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo THEMEURL;?>/images/log-vinacapital.png" />
                    </a>
                    <?php wp_nav_menu( array('theme_location' => 'primary', 'menu_class' => 'nav-menu', 'container' => '') ) ?>
                </nav>
            </div>
            <?php if ( is_front_page() ) { get_template_part('content', 'banner'); } ?>
        </header>
        <main id="main">