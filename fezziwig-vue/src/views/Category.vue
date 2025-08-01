<template>
  <div>
    <h1>{{ categoryTitle }}</h1>
    <div v-if="categoryDescription" v-html="categoryDescription"></div>
    <div class="post-teasers" v-if="posts.length > 0">
      <PostTeaser v-for="post in posts" :key="post.id" :post="post" />
    </div>
    <div v-else>
      <p>Loading posts...</p>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import '@/assets/styles/base/base';

.post-teasers {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3cqi;
  margin: 1.25rem 0;
  list-style: none;
  padding: 0;
  container-type: inline-size;
}
</style>

<script>
import PostTeaser from '../components/PostTeaser.vue'

export default {
  name: 'Category',
  components: {
    PostTeaser,
  },
  data() {
    return {
      posts: [],
      categoryTitle: '',
      categoryDescription: '',
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
        this.categoryDescription = category.description

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
}
</script>
