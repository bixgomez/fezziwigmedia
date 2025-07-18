<template>
  <div>
    <h1>{{ categoryTitle }}</h1>
    <div v-if="posts.length > 0">
      <div v-for="post in posts" :key="post.id" class="post">
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
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Category',
  data() {
    return {
      posts: [],
      categoryTitle: '',
    }
  },
  mounted() {
    const slug = this.$route.params.slug

    // Getting category by slug to find the ID
    fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/categories?slug=${slug}`,
    )
      .then((res) => res.json())
      .then((data) => {
        if (!data.length) return
        const category = data[0]
        this.categoryTitle = category.name

        // Fetching posts in that category, with embedded featured media
        return fetch(
          `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/posts?categories=${category.id}&_embed`,
        )
      })
      .then((res) => res.json())
      .then((data) => {
        this.posts = data || []
      })
      .catch((err) => {
        console.error('Error fetching category or posts:', err)
      })
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
