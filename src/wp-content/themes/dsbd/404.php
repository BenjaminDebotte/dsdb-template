<?php 

defined( 'ABSPATH' ) || exit;

?>

<?php get_header(); ?>

<?php $my_post_language_details = apply_filters( 'wpml_post_language_details', NULL, 1 ) ; 
?>

<!--Page-->
<div id="page" class="404-page" data-barba="container">

<!--404 Not Found-->
<div class="not-found">

    <!--404 Not Found Wrapper-->
    <div class="not-found-wrap">

        <div class="not-found-header">
            <h1>404</h1>
            <?php if ( $my_post_language_details['language_code'] == "fr" ) : ?>
                <h1>Page Non Trouvée</h1>
            <?php elseif ( $my_post_language_details['language_code'] == "en" ) : ?>
                <h1>Page Not Found</h1>
            <?php elseif ( $my_post_language_details['language_code'] == "es" ) : ?>
                <h1>Página No Encontrada</h1>
            <?php endif; ?>
        </div>

        <div class="not-found-text">
            <?php if ( $my_post_language_details['language_code'] == "fr" ) : ?>
                <p>La page que vous recherchez n'existe pas.<br/>Elle a pu être déplacée ou supprimée.</p>
            <?php elseif ( $my_post_language_details['language_code'] == "en" ) : ?>
                <p>The page you are looking for does not exist<br/>It may have been moved or deleted.</p>
            <?php elseif ( $my_post_language_details['language_code'] == "es" ) : ?>
                <p>La página que buscas no existe<br/>Puede haber sido movido o eliminado.</p>
            <?php endif; ?>
        </div>

        <div class="not-found-button">

            <div class="a-button style_1 align-center">

                <!--Recent Works Button URL-->
                <?php if ( $my_post_language_details['language_code'] == "fr" ) : ?>
                    <a href="/" target="_blank">Accueil</a>
                <?php elseif ( $my_post_language_details['language_code'] == "en" ) : ?>
                    <a href="/en" target="_blank">Home</a>
                <?php elseif ( $my_post_language_details['language_code'] == "es" ) : ?>
                    <a href="/es" target="_blank">Bienvenida</a>
                <?php endif; ?>
                
                <!--/Recent Works Button URL-->

            </div>

        </div>


    </div>
    <!--/404 Not Found Wrapper-->


</div>
<!--/404 Not Found-->



</div>
<!--/Page-->

<?php get_footer(); ?>