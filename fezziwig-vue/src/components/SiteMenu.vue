<template>
  <nav class="main-navigation">
    <ul class="menu">
      <li v-for="item in menuItems" :key="item.id">
        <a :href="getRelativeUrl(item.url)">
          {{ item.title.rendered }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'SiteMenu',
  data() {
    return {
      menuItems: [],
    }
  },
  mounted() {
    fetch(`${import.meta.env.VITE_API_BASE_URL}/wp-json/wp/v2/menu-items`)
      .then((response) => response.json())
      .then((data) => {
        this.menuItems = data.sort((a, b) => a.menu_order - b.menu_order)
      })
  },
  methods: {
    getRelativeUrl(url) {
      // Remove the domain to make it relative
      try {
        // Create a URL object to parse the URL automatically
        const urlObject = new URL(url)
        // Return just the pathname and search parameters
        return urlObject.pathname + urlObject.search
      } catch (error) {
        // If the URL is malformed, return it as-is
        return url
      }
    },
  },
}
</script>
