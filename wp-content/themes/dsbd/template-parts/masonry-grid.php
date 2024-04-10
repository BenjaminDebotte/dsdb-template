<?php 

defined( 'ABSPATH' ) || exit;

?>

<div class="grid">
  <!-- width of .grid-sizer used for columnWidth -->
  <div class="grid-sizer"></div>
  <div class="grid-item"></div>
  <div class="grid-item grid-item--width2"></div>
  ...
</div>

<style>
    /* fluid 5 columns */
    .grid-sizer,
    .grid-item { width: 20%; }
    /* 2 columns */
    .grid-item--width2 { width: 40%; }
</style>

// Check that images have been loaded
<script>
    // init Masonry
    var $grid = $('.grid').masonry({
        // set itemSelector so .grid-sizer is not used in layout
        itemSelector: '.grid-item',
        // use element for option
        columnWidth: '.grid-sizer',
        percentPosition: true
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
    });
</script>