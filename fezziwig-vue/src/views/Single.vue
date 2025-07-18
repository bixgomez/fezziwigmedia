<template>
  <div v-if="content">
    <h1 v-html="content.title.rendered" />
    <div v-html="content.content.rendered" />
  </div>
  <div v-else>
    <p>Loading...</p>
  </div>
</template>

<script>
export default {
  name: 'Single',
  data() {
    return {
      content: null,
    }
  },
  async mounted() {
    const slug = this.$route.params.slug

    // Try pages first
    const pages = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/pages?slug=${slug}`,
    ).then((r) => r.json())
    if (pages.length) {
      this.content = pages[0]
      return
    }

    // Then try posts
    const posts = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/posts?slug=${slug}`,
    ).then((r) => r.json())
    this.content = posts[0] || null
  },
}
</script>
