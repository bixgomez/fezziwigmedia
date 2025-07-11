<template>
  <div v-if="page">
    <h1 v-html="page.title.rendered" />
    <div v-html="page.content.rendered" />
  </div>
  <div v-else>
    <p>Loading...</p>
  </div>
</template>

<script>
export default {
  name: 'Page',
  data() {
    return {
      page: null
    }
  },
  mounted() {
    console.log('mounted')
    const slug = this.$route.params.slug
    fetch(`https://fezziwigmedia.ddev.site/wp-json/wp/v2/pages?slug=${slug}`)
      .then(res => res.json())
      .then(data => {
        this.page = data[0] || null
      })
  }
}
</script>
