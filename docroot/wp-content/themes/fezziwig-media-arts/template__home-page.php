<?php
/*
Template Name: Home Page Template
*/
?>

<?php get_header(); ?>

  <main id="content" role="main" class="section site-content">
    <div id="content-inner" class="section-inner">
      <section class="layout--home-page">

        <?php
        while ( have_posts() ) :
          the_post();
          
          // Display the featured image if it exists
          if ( has_post_thumbnail() ) {
            echo '<div class="image"><div class="inner">';
            the_post_thumbnail('full');
            echo '</div></div>';
          }
          
          // Display the content
          echo '<div class="page-content">';
          get_template_part( 'template-parts/content', 'page-no-image' );
          echo '</div>';
          
        endwhile;
        ?>

      </section>
    </div>
  </main>

<?php get_footer(); ?>
