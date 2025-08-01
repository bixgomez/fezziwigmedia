<template>
  <div class="post">
    <router-link :to="`/${post.slug}`">
      <h2 v-html="post.title.rendered" />
    </router-link>
    <img
      v-if="getFeaturedImageData(post)"
      :src="getFeaturedImageData(post).src"
      :alt="post.title.rendered || 'Image'"
      loading="lazy"
    />
    <div v-html="post.excerpt.rendered" />
    <router-link :to="`/${post.slug}`" class="read-more">
      Read more →
    </router-link>
  </div>
</template>

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
