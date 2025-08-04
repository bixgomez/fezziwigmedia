<template>
  <router-link :to="`/${post.slug}`" class="post-teaser post-teaser--websites">
    <div class="post-teaser-image">
      <img
        v-if="getFeaturedImageData(post)"
        :src="getFeaturedImageData(post).src"
        :alt="post.title.rendered || 'Image'"
        loading="lazy"
      />
    </div>
    <div class="post-teaser-text">
      <header class="entry-header">
        <h2 class="entry-title" v-html="post.title.rendered" />
      </header>

      <div class="entry-content">
        <div v-html="post.excerpt.rendered" />
      </div>
    </div>
  </router-link>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.post-teaser {
  display: block;
  display: grid;
  gap: 1.5rem;
  grid-template-columns: 8rem auto;
  text-decoration: none;
  color: $color-blue--darker;
  transition: 0.2s linear color;

  &:visited,
  &:active {
    color: $color-blue--darker;
  }

  &:hover {
    color: $color-orange--dark;
  }
  .post-teaser-image img {
    filter: saturate(100%);
    opacity: 0.8;
  }

  &:hover {
    .post-teaser-image img {
      filter: saturate(0%);
      opacity: 1;
    }
  }
}

.teaser--inner {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  overflow: hidden;
  position: relative;
}

.post-teaser-image {
  width: 100%;
  aspect-ratio: 1/1;
  overflow: hidden;
  position: relative;

  img {
    position: absolute;
    object-fit: cover;
    width: 100%;
    height: 100%;
  }
}

.post-teaser--websites {
  display: flex;
  gap: 2cqi;
  width: 100cqi;
  overflow: hidden;
  position: relative;

  .post-teaser-image {
    display: block;
    width: 30cqi;

    img {
      display: block;
      position: relative;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 100;
      object-fit: cover;
      filter: saturate(80%);
      opacity: 0.8;
      transition:
        0.2s linear filter,
        0.2s linear opacity;
    }
  }

  .post-teaser-text {
    position: relative;
    z-index: 200;
    background-color: rgba($color-beige-light, 0.6);
    width: 100%;
    bottom: 0;
    left: 0;
    padding: 2cqi;
    font-size: clamp(12px, 2.25cqi, 18px);
    transition: 0.2s linear background-color;

    .entry-header {
      display: contents;
    }

    .entry-title {
      font-size: 1.25em;

      a {
        text-decoration: none;
        color: $color-blue--darker;
        display: block;
      }
    }

    .entry-content {
      font-size: 1em;
      color: $color-blue--dark;
    }
  }

  &:hover {
    .post-teaser-image {
      img {
        filter: saturate(100%);
        opacity: 1;
      }
    }

    .post-teaser-text {
      background-color: rgba($color-beige-light, 0.9);
    }
  }
}
</style>

<script>
export default {
  name: 'PostTeaser',
  props: {
    post: {
      type: Object,
      required: true,
    },
  },
  methods: {
    getFeaturedImageData(post) {
      if (!post._embedded?.['wp:featuredmedia']?.[0]) {
        return null
      }

      const media = post._embedded['wp:featuredmedia'][0]

      // Check if small size exists
      if (media.media_details?.sizes?.small) {
        return {
          src: media.media_details.sizes.small.source_url,
          width: media.media_details.sizes.small.width,
          height: media.media_details.sizes.small.height,
        }
      }

      // Fall back to full size
      return {
        src: media.source_url,
        width: media.media_details?.width,
        height: media.media_details?.height,
      }
    },
  },
}
</script>
