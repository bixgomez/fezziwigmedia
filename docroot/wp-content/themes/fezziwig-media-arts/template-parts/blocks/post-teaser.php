

<!-- post-teaser.php -->

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

  <?php
  $external_link = get_field('external_link', $post->ID);
  if ( $external_link ) :
    $link_url = $external_link['url']; // Get the URL
    $link_text = $external_link['title'] ? $external_link['title'] : $link_url; // Use URL if no title
    $link_target = $external_link['target'] ? $external_link['target'] : '_self'; // Get target, default to _self
    ?>
    <p class="external-link">
      <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" rel="noopener noreferrer">
        <?php echo esc_html($link_text); ?>
      </a>
    </p>
  <?php endif; ?>
</div>
