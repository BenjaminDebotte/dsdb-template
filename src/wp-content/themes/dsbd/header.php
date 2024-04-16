<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">

    <!-- Page Title -->
    <title><?php wp_title(); ?></title>
    <!--/ Page Title -->

    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
    
    <?php wp_body_open(); ?>

    <!-- Header -->
    <header>
        <div class="container d-flex justify-content-between align-items-center">
            <div class="header-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="https://img.freepik.com/vecteurs-libre/lettre-coloree-creation-logo-degrade_474888-2309.jpg?w=1480&t=st=1699457274~exp=1699457874~hmac=cace424f039f551df460c8bce6fc580c5b77979ec70c5a898f137977200f23a9" alt="Logo" width="60">
                </a>
            </div>
            <div class="mobile-menu-toggle">
                <div class="burger-icon">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <div class="close-icon">
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
            <nav class="header-menu desktop-menu">
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'header-menu') ); ?>
            </nav>
            <nav class="header-menu mobile-menu">
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
            </nav>
        </div>
    </header>
    <!-- /Header -->
    