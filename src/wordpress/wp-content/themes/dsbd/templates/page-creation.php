<?php

/* Template Name: Création de page */ 


defined( 'ABSPATH' ) || exit;


get_header();

// Check value exists.
            if( have_rows('flexible_content') ):

                // Loop through rows.
                while ( have_rows('flexible_content') ) : the_row();

                    // Case: hero layout.
                    if( get_row_layout() == 'hero' ):
                        
                    ?>



                    <?php
                    elseif( get_row_layout() == ''):

                    ?>
                        
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>

<script>
    const swiperHero = new Swiper('.swiper-hero', {
  slidesPerView: 3,
  speed: 400,
  spaceBetween: 20,
  breakpoints: {
      640: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
    },

    // Navigation arrows
    navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

});
</script>

<script>
    const swiperProjects = new Swiper('.swiper-projects', {
  slidesPerView: 1,
  autoplay: true,
  speed: 400,
    // Navigation arrows
    navigation: {
    nextEl: '.swiper-imgs-left-next',
    prevEl: '.swiper-imgs-left-prev',
  },

});
</script>

<script>
  AOS.init();
</script>

<?php get_footer(); ?>



