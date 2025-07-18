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
  name: 'Home',
  data() {
    return {
      page: null,
    }
  },
  async mounted() {
    // First, get the site settings
    const settingsResponse = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/`,
    )
    const settings = await settingsResponse.json()

    // Then fetch the actual home page by ID
    const pageResponse = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/pages/${settings.page_on_front}`,
    )
    this.page = await pageResponse.json()
  },
}
</script>
