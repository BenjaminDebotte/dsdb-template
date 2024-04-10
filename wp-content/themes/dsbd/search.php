<?php 

defined( 'ABSPATH' ) || exit;

?>

<?php get_header(); ?>

<style>.st-header-five.theme-st-header.sticky-menu{position: relative;}</style>

<div class="page">
    <section class="inner-page header">
        <h2 class="page-title">
            <span><?php _e("Résultats pour","meurdraavocat"); ?> :</span> <?php echo esc_attr(get_search_query()); ?>
        </h2>
        <p><?php echo $wp_query->found_posts; ?> <?php _e("pages trouvées", "meurdraavocat"); ?></p>
    </section>
    <section>
        <div class="pb-150 md-pb-120">
                <div class="container">              
                    <div class="row">
                        <?php



                        if ( have_posts() ):
                            while (have_posts() ) : the_post(); ?>
                            
                            <?php

                            $post_url = get_post_permalink();
                            $post_title = get_the_title();
                            $post_date = get_the_date();

                            ?>

                        <div class="col-lg-4">
                            <div class="blog-post-block-two mb-75 md-mb-60">
                                <div class="img-holder"><img src="<?php the_post_thumbnail_url(); ?>" alt=""></div>
                                <div class="post">
                                    <ul class="post-info">
                                        <li><?php echo $post_date; ?></li>
                                    </ul>
                                    <h4><a href="<?php echo $post_url; ?>"><?php echo $post_title; ?></a></h4>
                                    <p><?php the_excerpt(); ?></p>
                                    <a href="<?php echo$post_url; ?>" class="read-more inline-button-one">Lire plus</a>
                                </div> <!-- /.post -->
                            </div> <!-- /.blog-post-block-two -->
                        </div>
                            <?php endwhile; ?>
                    </div>
                </div>
              <div class="pagination-style-1">
                <?php
                               
                                $big = 999999999; // need an unlikely integer

                                echo paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'prev_text'          => __('<span aria-hidden="true">&laquo;</span>'),
                                    'next_text'          => __('<span aria-hidden="true">&raquo;</span>'),
                                    'type' => 'list'
                                    
                                ) );


                                ?>
              </div>

              <?php else : ?>
					
					<!-- this area shows up if there are no results -->
					
					<article id="post-not-found">
					  
					    	<h3><?php _e("Désolé, aucun résultat ne correspond à votre recherche", "TheTheme"); ?></h3>
					
					    	<p><?php _e("Veuillez effectuer une nouvelle recherche.", "TheTheme"); ?></p>

					    	<?php get_template_part('searchform'); ?>
				
					</article>
					
					<?php endif; ?>
            
        </div>
    </section>


<?php get_footer(); ?>