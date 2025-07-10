<template>
  <div>
    <h1>My Portfolio</h1>
    <p>Loading posts...</p>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      posts: []
    }
  },
  mounted() {
    fetch('https://fezziwigmedia.ddev.site/wp-json/wp/v2/posts')
      .then(response => response.json())
      .then(data => {
        this.posts = data
      })
  }
}
</script>
