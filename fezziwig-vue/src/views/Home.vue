<template>
  <div v-if="page">
    <section class="layout--home-page">
      <div class="image">
        <div class="inner">
          <div v-if="featuredImage" class="featured-image">
            <img
              :src="featuredImage.source_url"
              :alt="featuredImage.alt_text"
            />
          </div>
        </div>
      </div>
      <div class="page-content">
        <h1 v-html="page.title.rendered" />
        <div v-html="page.content.rendered" />
      </div>
    </section>
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
  computed: {
    featuredImage() {
      return this.page?._embedded?.['wp:featuredmedia']?.[0]
    },
  },
  async mounted() {
    // First, get the site settings
    const settingsResponse = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/`,
    )
    const settings = await settingsResponse.json()

    // Then fetch the actual home page by ID
    const pageResponse = await fetch(
      `${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/pages/${settings.page_on_front}?_embed`,
    )
    this.page = await pageResponse.json()
  },
}
</script>
