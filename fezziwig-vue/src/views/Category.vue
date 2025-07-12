<template>
  <div v-if="category">
    <h1 v-html="category.name" />
    <p v-html="category.description" />
    
    <div v-if="posts.length > 0">
      <article v-for="post in posts" :key="post.id">
        <router-link :to="`/${post.slug}`">
          <h2 v-html="post.title.rendered" />
        </router-link>
        <div v-html="post.excerpt.rendered" />
        <router-link :to="`/${post.slug}`" class="read-more">
          Read more →
        </router-link>
      </article>
    </div>
    <p v-else>No posts in this category yet.</p>
  </div>
  <div v-else>
    <p>Loading...</p>
  </div>
</template>

<script>
export default {
  name: 'Category',
  data() {
    return {
      category: null,
      posts: []
    }
  },
  async mounted() {
    const slug = this.$route.params.slug
    
    // First, get the category info by slug
    const catResponse = await fetch(`https://fezziwigmedia.ddev.site/wp-json/wp/v2/categories?slug=${slug}`)
    const catData = await catResponse.json()
    this.category = catData[0]
    
    // Then fetch posts in this category
    if (this.category) {
      const postsResponse = await fetch(`https://fezziwigmedia.ddev.site/wp-json/wp/v2/posts?categories=${this.category.id}&per_page=100`)
      this.posts = await postsResponse.json()
    }
  }
}
</script>