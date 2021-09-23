<?php get_header() ?>

    <?php 
    $args = array( 'post_type' => 'courses', 'posts_per_page' => 9 );
    $the_query = new WP_Query( $args ); 
    ?>

    <?php if ( $the_query->have_posts() ) : ?>
    
        <div class="container">

            <br><h1 style="color:#D4AF37;text-align:center;">Cours proposés dans nos salles</h1><br>
            <div class="row">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card" style="width:500px;height:540px;">
                        <div class="card-image">
                            <figure class="image is-20by12">
                                <?php the_post_thumbnail(); ?>
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <p class="title is-4"><?php the_title(); ?></p>
                                <p><?php the_content(); ?></p>
                            </div>
                        </div>
                    </div><br>
                </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
                
    <?php else:  ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>

<?php get_footer() ?>