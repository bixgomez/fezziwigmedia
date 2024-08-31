<div class="post-teaser">
  <h3 class="post-teaser-title">
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  </h3>
  <?php if( has_post_thumbnail() ) : ?>
    <div class="post-teaser-image">
      <?php the_post_thumbnail('thumbnail'); ?>
    </div>
  <?php endif; ?>
  <p class="post-teaser-text">
    <?php echo get_the_excerpt(); ?>
  </p>
</div>
