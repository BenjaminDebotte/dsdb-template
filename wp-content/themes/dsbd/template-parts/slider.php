<?php 

defined( 'ABSPATH' ) || exit;

?>

<!-- Slider main container -->
    <div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <?php 
            $slides = get_sub_field('slides');
            foreach $slides as $slide : 
        ?>
            <div class="swiper-slide">
                <?php $slide['content'];?>
            </div>
        <?php endforeach;?>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

    <!-- If we need scrollbar -->
    <div class="swiper-scrollbar"></div>
    </div>

<script>
    const swiper = new Swiper('.swiper', {
    // Optional parameters
    loop: true,
    autoplay: true,
    slidesPerView: 1,
    spaceBetween: 10,

    // Responsive breakpoints
    breakpoints: {
        // when window width is >= 320px
        320: {
        slidesPerView: 2,
        spaceBetween: 20
        },
        // when window width is >= 480px
        480: {
        slidesPerView: 3,
        spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
        slidesPerView: 4,
        spaceBetween: 40
        }
    }

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
    });
</script>